<?php晓明版权
/**
 * web
 * ============================================================================
 * 版权所有 2015-2020 晓明版权，并保留所有权利。
 * 网站地址: https://huxiaoming.top
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: 晓明
 * Date: 2018-12-01
 */
namespace app\task\behavior;
use think\Db;
use think\facade\Cache;
use app\task\model\Setting;
use app\task\model\Order as OrderModel;
use app\task\model\agent\Order as AgentOrderModel;
/**
 * 订单行为管理
 * Class Order
 * @package app\task\behavior
 */
class Order
{
    /* @var \app\task\model\Order $model */
    private $model;
    /**
     * 执行函数
     * @param $model
     * @return bool
     */
    public function run($model)
    {
        if (!$model instanceof OrderModel) {
            return new OrderModel and false;
        }
        $this->model = $model;
        if (!Cache::has('__task_space__order')) {
            try {
                Db::startTrans();
                $config = Setting::getItem('trade');
                // 未支付订单自动关闭
                $this->close($config['order']['close_days']);
                // 已发货订单自动确认收货
                $this->receive($config['order']['receive_days']);
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                return false;
            }
            Cache::set('__task_space__order', time(), 3600);
        }
        return true;
    }
    /**
     * 未支付订单自动关闭
     * @param $close_days
     * @return $this|bool
     */
    private function close($close_days)
    {
        // 取消n天以前的的未付款订单
        if ($close_days < 1) {
            return false;
        }
        // 截止时间
        $deadlineTime = time() - ((int)$close_days * 86400);
        // 条件
        $filter = [
            'pay_status' => 10,
            'order_status' => 10,
            'create_time' => ['<', $deadlineTime]
        ];
        // 查询截止时间未支付的订单
        $orderIds = $this->model->where($filter)->column('order_id');
        // 记录日志
        $this->dologs('close', [
            'close_days' => (int)$close_days,
            'deadline_time' => $deadlineTime,
            'orderIds' => json_encode($orderIds),
        ]);
        // 直接更新
        if (!empty($orderIds)) {
            return $this->model->isUpdate(true)->save(['order_status' => 20], ['order_id' => ['in', $orderIds]]);
        }
        return false;
    }
    /**
     * 已发货订单自动确认收货
     * @param $receive_days
     * @return bool|false|int
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    private function receive($receive_days)
    {
        if ($receive_days < 1) {
            return false;
        }
        // 截止时间
        $deadlineTime = time() - ((int)$receive_days * 86400);
        // 条件
        $filter = [
            'pay_status' => 20,
            'delivery_status' => 20,
            'receipt_status' => 10,
            'delivery_time' => ['<', $deadlineTime]
        ];
        // 查询截止时间未支付的订单
        $orderIds = $this->model->where($filter)->column('order_id');
        // 记录日志
        $this->dologs('receive', [
            'receive_days' => (int)$receive_days,
            'deadline_time' => $deadlineTime,
            'orderIds' => json_encode($orderIds),
        ]);
        if (!empty($orderIds)) {
            // 发放分销订单佣金
            $this->grantMoney($orderIds);
            // 更新订单收货状态
            return $this->model->isUpdate(true)->save([
                'receipt_status' => 20,
                'receipt_time' => time(),
                'order_status' => 30
            ], ['order_id' => ['in', $orderIds]]);
        }
        return false;
    }
    /**
     * 发放分销订单佣金
     * @param $orderIds
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    private function grantMoney($orderIds)
    {
        foreach ($orderIds as $orderId) {
            AgentOrderModel::grantMoney($orderId);
        }
    }
    /**
     * 记录日志
     * @param $method
     * @param array $params
     * @return bool|int
     */
    private function dologs($method, $params = [])
    {
        $value = 'Order --' . $method;
        foreach ($params as $key => $val)
            $value .= ' --' . $key . ' ' . $val;
        return write_log($value, __DIR__);
    }
}