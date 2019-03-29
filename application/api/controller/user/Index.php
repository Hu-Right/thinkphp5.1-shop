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
use app\common\model\Order as OrderModel;
/**
 * 个人中心主页
 * Class Index
 * @package app\api\controller\user
 */
class Index extends Controller
{
    /**
     * 获取当前用户信息
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        // 当前用户信息
        $userInfo = $this->getUser();
		
        // 订单总数
        $model = new OrderModel;
		if($userInfo)
			return $this->renderSuccess([
				'userInfo' => $userInfo,
				'orderCount' => [
					'payment' => $model->getCount($userInfo['user_id'], 'payment'),
					'received' => $model->getCount($userInfo['user_id'], 'received'),
					'comment' => $model->getCount($userInfo['user_id'], 'comment'),
				],
				'menus' => $userInfo->getMenus()   // 个人中心菜单列表
			]);
		return $this->renderJson(-1,'没有找到用户信息');
    }
}