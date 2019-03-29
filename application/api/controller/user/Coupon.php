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
namespace app\api\controller\user;
use app\api\controller\Controller;
use app\common\model\UserCoupon as UserCouponModel;
/**
 * 用户优惠券
 * Class Coupon
 * @package app\api\controller
 */
class Coupon extends Controller
{
    /* @var UserCouponModel $model */
    private $model;
    /* @var \app\common\model\User $model */
    private $user;
    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function initialize()
    {
        parent::initialize();
        $this->model = new UserCouponModel;
        $this->user = $this->getUser();
    }
    /**
     * 优惠券列表
     * @param string $data_type
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lists($data_type = 'all')
    {
        $is_use = false;
        $is_expire = false;
        switch ($data_type) {
            case 'not_use':
                $is_use = false;
                break;
            case 'is_use':
                $is_use = true;
                break;
            case 'is_expire':
                $is_expire = true;
                break;
        }
        $list = $this->model->getList($this->user['user_id'], $is_use, $is_expire);
        return $this->renderSuccess(compact('list'));
    }
    /**
     * 领取优惠券
     * @param $coupon_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function receive($coupon_id)
    {
        if ($this->model->receive($this->user, $coupon_id)) {
            return $this->renderSuccess([], '领取成功');
        }
        return $this->renderError($this->model->getError() ?: '添加失败');
    }
}