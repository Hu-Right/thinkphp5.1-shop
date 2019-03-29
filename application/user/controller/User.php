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
namespace app\user\controller;
use app\common\model\User as UserModel;
/**
 * 用户管理
 * Class User
 * @package app\user\controller
 */
class User extends Controller{
	/**     * 用户列表
	 * @param string $nickName
	 * @param null $gender
	 * @return mixed
	 * @throws \think\exception\DbException
	 */
	public function index($nickName = '', $gender = null,$pid=null)    {
		$nickName=trim($nickName);
		$model = new UserModel;
		$list = $model->getList($nickName, $gender,$pid);
		$page=$list->render();
		return $this->fetch('index', compact('list','page'));
	}
	/**
	 * 删除用户
	 * @param $user_id
	 * @return array
	 * @throws \think\exception\DbException
	 */
	public function delete($user_id)    {
		// 商品详情
		$model = UserModel::detail($user_id);
		if (!$model->setDelete()) {
			return $this->renderError('删除失败');
		}
		return $this->renderSuccess('删除成功');
	}
}