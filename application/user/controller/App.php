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
use app\common\model\App as AppModel;
use app\common\model\AppNavbar as AppNavbarModel;
/**
 * 小程序管理
 * Class app
 * @package app\user\controller
 */
class App extends Controller
{
    /**
     * 小程序设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function setting()
    {
		
        $app = AppModel::detail();
        if ($this->request->isAjax()) {
            $data = $this->postData('app');
            if ($app->edit($data)) return $this->renderSuccess('更新成功');
            return $this->renderError('更新失败');
        }
        return $this->fetch('setting', compact('app'));
    }
    /**
     * 导航栏设置
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function tabbar() {
        $model = AppNavbarModel::detail();
        if (!$this->request->isAjax()) {
            return $this->fetch('tabbar', compact('model'));
        }
        $data = $this->postData('tabbar');
        if (!$model->edit($data)) {
            return $this->renderError('更新失败');
        }
        return $this->renderSuccess('更新成功');
    }
}