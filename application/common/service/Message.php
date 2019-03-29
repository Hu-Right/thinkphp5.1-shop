<?
// +----------------------------------------------------------------------
// | Common 
// +----------------------------------------------------------------------
// | 版权所有 2015-2020 晓明版权，并保留所有权利。
// +----------------------------------------------------------------------
// | 网站地址: https://huxiaoming.top
// +----------------------------------------------------------------------
// | 这不是一个自由软件！您只能在不用于商业目的的前提下使用本程序
// +----------------------------------------------------------------------
// | 不允许对程序代码以任何形式任何目的的再发布
// +----------------------------------------------------------------------
// | Author: 胡晓明    Date: 2018-12-01
// +----------------------------------------------------------------------
namespace app\common\service;
use app\common\library\wechat\WxTplMsg;
use app\common\library\sms\Driver as SmsDriver;
use app\common\model\User;
use app\common\model\App as AppModel;
use app\common\model\Setting as SettingModel;
use app\common\model\agent\Setting as AgentSettingModel;
use app\common\model\app\Formid;
use app\common\model\AppPrepayId;
/**
 * 消息通知服务
 * Class Message
 * @package app\common\service
 */
class Message
{
    /**
     * 订单支付成功后通知
     * @param $order
     * @return bool
     * @throws \think\Exception
     */
    public function payment($order)
    {
        // 1. 微信模板消息
        $template = SettingModel::getItem('tplMsg', $order['app_id'])['payment'];
        if ($template['is_enable'] && !empty($template['template_id'])) {
            // 获取 prepay_id
            $prepayId = $this->getPrepayId($order['order_id']);
            // 发送模板消息
            $status = $this->sendTemplateMessage($order['app_id'], [
                'touser' => $order['user']['open_id'],
                'template_id' => $template['template_id'],
                'page' => 'pages/order/detail?order_id=' . $order['order_id'],
                'form_id' => $prepayId['prepay_id'],
                'data' => [
                    // 订单编号
                    'keyword1' => $order['order_no'],
                    // 支付时间
                    'keyword2' => date('Y-m-d H:i:s', $order['pay_time']),
                    // 订单金额
                    'keyword3' => $order['pay_price'],
                    // 商品名称
                    'keyword4' => $this->formatName($order['item']),
                ]
            ]);
            // 标记已使用次数
            $status === true && $prepayId->updateUsedTimes();
        }
        // 2. 商家短信通知
        $smsConfig = SettingModel::getItem('sms', $order['app_id']);
        $SmsDriver = new SmsDriver($smsConfig);
        return $SmsDriver->sendSms('order_pay', ['order_no' => $order['order_no']]);
    }
    /**
     * 后台发货通知
     * @param $order
     * @return bool
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function delivery($order)
    {
        // 获取 prepay_id
        $prepayId = $this->getPrepayId($order['order_id']);
        // 微信模板消息
        $template = SettingModel::getItem('tplMsg', $order['app_id'])['delivery'];
        if (!$template['is_enable'] || empty($template['template_id'])) {
            return false;
        }
        // 发送模板消息
        $status = $this->sendTemplateMessage($order['app_id'], [
            'touser' => $order['user']['open_id'],
            'template_id' => $template['template_id'],
            'page' => 'pages/order/detail?order_id=' . $order['order_id'],
            'form_id' => $prepayId['prepay_id'],
            'data' => [
                // 订单编号
                'keyword1' => $order['order_no'],
                // 商品信息
                'keyword2' => $this->formatName($order['item']),
                // 收货人
                'keyword3' => $order['address']['name'],
                // 收货地址
                'keyword4' => implode('', $order['address']['region']) . $order['address']['detail'],
                // 物流公司
                'keyword5' => $order['express']['express_name'],
                // 物流单号
                'keyword6' => $order['express_no'],
            ]
        ]);
        // 标记已使用次数
        $status === true && $prepayId->updateUsedTimes();
        return $status;
    }
    /**
     * 分销商提现审核通知
     * @param $withdraw
     * @return bool
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function withdraw($withdraw)
    {
        // 模板消息id
        $template = AgentSettingModel::getItem('template_msg', $withdraw['app_id']);
        if (empty($template['withdraw_tpl'])) {
            return false;
        }
        // 获取formid
        if (!$formId = Formid::getAvailable($withdraw['user_id'])) {
            return false;
        }
        // 获取用户信息
        $user = User::detail($withdraw['user_id']);
        // 发送模板消息
        $remark = '无';
        if ($withdraw['apply_status'] == 30) {
            $remark = $withdraw['reject_reason'];
        }
        $status = $this->sendTemplateMessage($withdraw['app_id'], [
            'touser' => $user['open_id'],
            'template_id' => $template['withdraw_tpl'],
            'page' => 'pages/agent/withdraw/list/list',
            'form_id' => $formId['form_id'],
            'data' => [
                // 提现时间
                'keyword1' => $withdraw['create_time'],
                // 提现方式
                'keyword2' => $withdraw['pay_type']['text'],
                // 提现金额
                'keyword3' => $withdraw['money'],
                // 提现状态
                'keyword4' => $withdraw->applyStatus[$withdraw['apply_status']],
                // 备注
                'keyword5' => $remark,
            ]
        ]);
        // 标记formid已使用
        $formId->setIsUsed();
        return $status;
    }
    /**
     * 分销商入驻审核通知
     * @param $agent
     * @return bool
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function agent($agent)
    {
        // 模板消息id
        $template = AgentSettingModel::getItem('template_msg', $agent['app_id']);
        if (empty($template['apply_tpl'])) {
            return false;
        }
        // 获取formid
        if (!$formId = Formid::getAvailable($agent['user_id'])) {
            return false;
        }
        // 获取用户信息
        $user = User::detail($agent['user_id']);
        // 发送模板消息
        $remark = '分销商入驻审核通知';
        if ($agent['apply_status'] == 30) {
            $remark .= "\n\n驳回原因：" . $agent['reject_reason'];
        }
        $status = $this->sendTemplateMessage($agent['app_id'], [
            'touser' => $user['open_id'],
            'template_id' => $template['apply_tpl'],
            'page' => 'pages/agent/index/index',
            'form_id' => $formId['form_id'],
            'data' => [
                // 申请时间
                'keyword1' => $agent['apply_time'],
                // 审核状态
                'keyword2' => $agent->applyStatus[$agent['apply_status']],
                // 审核时间
                'keyword3' => $agent['audit_time'],
                // 备注信息
                'keyword4' => $remark,
            ]
        ]);
        // 标记formid已使用
        $formId->setIsUsed();
        return $status;
    }
    /**
     * 发送模板消息
     * @param $app_id
     * @param $params
     * @return bool
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    private function sendTemplateMessage($app_id, $params)
    {
        // 微信模板消息
        $wxConfig = AppModel::getAppCache($app_id);
        $WxTplMsg = new WxTplMsg($wxConfig['appkey'], $wxConfig['app_secret']);
        return $WxTplMsg->sendTemplateMessage($params);
    }
    /**
     * 获取小程序prepay_id记录
     * @param $order_id
     * @return AppPrepayId|array|false|string|\think\Model
     */
    private function getPrepayId($order_id)
    {
        return AppPrepayId::detail($order_id);
    }
    /**
     * 格式化商品名称
     * @param $itemData
     * @return string
     */
    private function formatName($itemData)
    {
        $str = '';
        foreach ($itemData as $Item) $str .= $Item['name'] . ' ';
        return $str;
    }
}