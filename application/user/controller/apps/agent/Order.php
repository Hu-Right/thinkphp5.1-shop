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
namespace app\user\controller\apps\agent;
use app\user\controller\Controller;
use app\common\model\agent\Order as OrderModel;
/**
 * 分销订单
 * Class Order
 * @package app\user\controller\apps\agent
 */
class Order extends Controller
{
    /**
     * 分销订单列表
     * @param null $user_id
     * @param int $is_settled
     * @param string $search
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($user_id = null, $is_settled = -1, $search = '')
    {
        $model = new OrderModel;
        $list = $model->getList($user_id, $is_settled, $search);
        return $this->fetch('index', compact('list'));
    }
}