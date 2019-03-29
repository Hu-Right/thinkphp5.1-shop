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
 * 商家用户角色模型
 * Class UserRole
 * @package app\common\model\admin
 */
class UserRole extends BaseModel
{
    protected $name = 'user_role';
    protected $updateTime = false;
/**
     * 新增关系记录
     * @param $user_id
     * @param array $roleIds
     * @return array|false
     * @throws \Exception
     */
    public function add($user_id, $roleIds)
    {
        $data = [];
        foreach ($roleIds as $role_id) {
            $data[] = [
                'user_id' => $user_id,
                'role_id' => $role_id,
                'app_id' => self::$app_id,
            ];
        }
        return $this->saveAll($data);
    }
    /**
     * 更新关系记录
     * @param $user_id
     * @param array $newRole 新的角色集
     * @return array|false
     * @throws \Exception
     */
    public function edit($user_id, $newRole)
    {
        /**
         * 先删除的角色
         */
         self::deleteAll(['user_id' => $user_id]);
        /**
         * 更新角色
         */
        $data = [];
        foreach ($newRole as $role_id) {
            $data[] = [
                'user_id' => $user_id,
                'role_id' => $role_id,
                'app_id' => self::$app_id,
            ];
        }
        return $this->saveAll($data);
    }
    /**
     * 获取指定管理员的所有角色id
     * @param $user_id
     * @return array
     */
    public static function getRoleIds($user_id)
    {
        return (new self)->where('user_id', '=', $user_id)->column('role_id');
    }
    /**
     * 删除记录
     * @param $where
     * @return int
     */
    public static function deleteAll($where)
    {
        return self::destroy($where);
    }
}