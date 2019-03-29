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
namespace app\user\controller\app;
use app\user\controller\Controller;
use app\common\model\AppHelp as AppHelpModel;
/**
 * 小程序帮助中心
 * Class help
 * @package app\user\controller\app
 */
class Help extends Controller
{
    /**
     * 帮助中心列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new AppHelpModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }
    /**
     * 添加帮助
     * @return array|mixed
     */
    public function add()
    {
        $model = new AppHelpModel;
        if (!$this->request->isAjax()) {
            return $this->fetch('add', compact('list'));
        }
        // 新增记录
        if ($model->add($this->postData('help'))) {
            return $this->renderSuccess('添加成功', url('app.help/index'));
        }
        $error = $model->getError() ?: '添加失败';
        return $this->renderError($error);
    }
    /**
     * 更新帮助
     * @param $help_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($help_id)
    {
        // 帮助详情
        $model = AppHelpModel::detail($help_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 更新记录
        if ($model->edit($this->postData('help'))) {
            return $this->renderSuccess('更新成功', url('app.help/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }
    /**
     * 删除商品分类
     * @param $help_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($help_id)
    {
        // 帮助详情
        $model = AppHelpModel::detail($help_id);
        if (!$model->remove()) {
            $error = $model->getError() ?: '删除失败';
            return $this->renderError($error);
        }
        return $this->renderSuccess('删除成功');
    }
}