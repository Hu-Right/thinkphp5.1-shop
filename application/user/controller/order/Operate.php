<?
// +----------------------------------------------------------------------
// | User 
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
namespace app\user\controller\order;
use app\user\controller\Controller;
use app\common\model\Order as OrderModel;
use app\common\model\Express as ExpressModel;
/**
 * 订单操作控制器
 * Class Operate
 * @package app\user\controller\order
 */
class Operate extends Controller
{
    /* @var OrderModel $model */
    private $model;
    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
        $this->model = new OrderModel;
    }
    /**
     * 订单导出
     * @param string $dataType
     * @throws \think\exception\DbException
     */
    public function export($dataType)
    {	
        return $this->model->exportList($dataType, $this->request->get());
    }
    /**
     * 批量发货
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function batchDelivery()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch('batchDelivery', [
                'express_list' => ExpressModel::getAll()
            ]);
        }
        if ($this->model->batchDelivery($this->postData('order'))) {
            return $this->renderSuccess('发货成功');
        }
        return $this->renderError($this->model->getError() ?: '发货失败');
    }
    /**
     * 批量发货模板
     */
    public function deliveryTpl()
    {
        return $this->model->deliveryTpl();
    }
}