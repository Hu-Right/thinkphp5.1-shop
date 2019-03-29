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
namespace app\user\controller\setting;
use app\user\controller\Controller;
use app\common\model\Express as ExpressModel;
/**
 * 物流公司
 * Class Express
 * @package app\user\controller\setting
 */
class Express extends Controller
{
    /**
     * 物流公司列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new ExpressModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }
    /**
     * 删除物流公司
     * @param $express_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($express_id)
    {
        $model = ExpressModel::detail($express_id);
        if (!$model->remove()) {
            $error = $model->getError() ?: '删除失败';
            return $this->renderError($error);
        }
        return $this->renderSuccess('删除成功');
    }
    /**
     * 添加物流公司
     * @return array|mixed
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        // 新增记录
        $model = new ExpressModel;
        if ($model->add($this->postData('express'))) {
            return $this->renderSuccess('添加成功', url('setting.express/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }
    /**
     * 编辑物流公司
     * @param $express_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($express_id)
    {
        // 模板详情
        $model = ExpressModel::detail($express_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 更新记录
        if ($model->edit($this->postData('express'))) {
            return $this->renderSuccess('更新成功', url('setting.express/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }
    /**
     * 物流公司编码表
     * @return mixed
     */
    public function company()
    {
        return $this->fetch('company');
    }
}