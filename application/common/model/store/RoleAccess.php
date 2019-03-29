<?
// +----------------------------------------------------------------------
// | Common 
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
namespace app\common\model\store;
use app\common\model\BaseModel;
/**
 * 商家用户角色权限关系模型
 * Class RoleAccess
 * @package app\common\model\admin
 */
class RoleAccess extends BaseModel
{
    protected $name = 'role_access';
    protected $updateTime = false;
	/**
     * 新增关系记录
     * @param $role_id
     * @param array $access
     * @return array|false
     * @throws \Exception
     */
	 
    public function add($role_id, $access)
    {
        $data = [];
        foreach ($access as $access_id) {
            $data[] = [
                'role_id' => $role_id,
                'access_id' => $access_id,
                'app_id' => self::$app_id,
            ];
        }
        return $this->saveAll($data);
    }
    /**
     * 更新关系记录
     * @param $role_id
     * @param array $newAccess 新的权限集
     * @return array|false
     * @throws \Exception
     */
    public function edit($role_id, $newAccess)
    {
        $where['role_id']=$role_id;
		self::deleteAll($where);
        /**
         * 找出添加的权限
         * 假如已有的权限集合是A，界面传递过得权限集合是B
         * 权限集合B当中的某个权限不在权限集合A当中，就应该添加
         * 使用 array_diff() 计算补集
         */
        $data = [];
        foreach ($newAccess as $key) {
            $data[] = [
                'role_id' => $role_id,
                'access_id' => $key,
                'app_id' => self::$app_id,
            ];
        }
        return $this->saveAll($data);
    }
    /**
     * 获取指定角色的所有权限id
     * @param int|array $role_id 角色id (支持数组)
     * @return array
     */
    public static function getAccessIds($list,$role_id)
    {
		
        $roleIds = is_array($role_id) ? $role_id : [(int)$role_id];
        return (new self)->where('role_id', 'in', $roleIds)->column('access_id');
    }
    /**
     * 删除记录
     * @param $where
     * @return int
     */
    public static function deleteAll($data)
    {	
		
      return self::destroy($data);
    }
}