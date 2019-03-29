<?
// +----------------------------------------------------------------------
// | API 
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
namespace app\api\controller;
use app\common\model\Cart as CartModel;
/**
 * 购物车管理
 * Class Cart
 * @package app\api\controller
 */
class Cart extends Controller
{
    /* @var \app\common\model\User $user */
    private $user;
    /* @var \app\common\model\Cart $model */
    private $model;
    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function initialize()
    {
        parent::initialize();
        $this->user = $this->getUser();
        $this->model = new CartModel($this->user['user_id']);
    }
    /**
     * 购物车列表
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        return $this->renderSuccess($this->model->getList($this->user));
    }
    /**
     * 加入购物车
     * @param $item_id
     * @param $item_num
     * @param $item_sku_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function add($item_id, $item_num, $item_sku_id)
    {
		
        if (!$this->model->add($item_id, $item_num, $item_sku_id,$this->user)) {
            return $this->renderError($this->model->getError() ?: '加入购物车失败');
        }
        $total_num = $this->model->getTotalNum();
        return $this->renderSuccess(['cart_total_num' => $total_num], '加入购物车成功');
    }
    /**
     * 减少购物车商品数量
     * @param $item_id
     * @param $item_sku_id
     * @return array
     */
    public function sub($item_id, $item_sku_id)
    {
        $this->model->sub($item_id, $item_sku_id);
        return $this->renderSuccess();
    }
    /**
     * 删除购物车中指定商品
     * @param $item_sku_id (支持字符串ID集)
     * @return array
     */
    public function delete($sku_id)
    {	
        $this->model->delete($sku_id);
        return $this->renderSuccess();
    }
}