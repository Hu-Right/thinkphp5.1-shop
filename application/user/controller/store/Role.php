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
namespace app\user\controller\store;
use app\user\controller\Controller;
use app\common\model\store\Role as RoleModel;
use app\common\model\store\Access as AccessModel;
/**
 * 商家用户角色控制器
 * Class StoreUser
 * @package app\store\controller
 */
class Role extends Controller
{
	protected $name = 'role';
    protected $pk = 'role_id';
    /**
     * 角色列表
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new RoleModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }
    /**
     * 添加角色
     * @return array|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function add()
    {
        $model = new RoleModel;
        if (!$this->request->isAjax()) {
           // 角色列表
            $roleList = $model->getList();
            return $this->fetch('add', compact('roleList'));
        }
        // 新增记录
        if ($model->add($this->postData('role'))) {
            return $this->renderSuccess('添加成功', url('store.role/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }
	 /**
     * 角色获取
     * @param $role_id
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
	 public function role(){
		$accessList = (new AccessModel)->getJsTree($this->postData('role_id'));
		return $this->renderJson(0, '获取成功','',compact('accessList'));
	 }
    /**
     * 更新角色
     * @param $role_id
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit($role_id)
    {
        // 角色详情
        $model = RoleModel::detail($role_id);
	
        if (!$this->request->isAjax()) {
            // 角色列表
            $roleList = $model->getList();
			
           return $this->fetch('edit',compact('model','roleList'));
        }
        // 更新记录
		
        if ($model->edit($this->postData('role'))) {
            return $this->renderSuccess('更新成功', url('store.role/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }
    /**
     * 删除角色
     * @param $role_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($role_id)
    {
        // 角色详情
        $model = RoleModel::detail($role_id);
        if (!$model->remove()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
}