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
use think\Session;
use app\common\model\BaseModel;
/**
 * 商家用户模型
 * Class User
 * @package app\common\model
 */
class User extends BaseModel
{
    protected $name = 'manager';
    protected $pk = 'user_id';
    /**
     * 关联微信小程序表
     * @return \think\model\relation\BelongsTo
     */
    public function app()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\App");
    }
    /**
     * 关联用户角色表表
     * @return \think\model\relation\BelongsToMany
     */
    public function role()
    {
        return $this->belongsToMany('Role','StoreUserRole');
    }
    /**
     * 商家用户详情
     * @param $where
     * @param array $with
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function detail($where, $with = [])
    {	
        !is_array($where) && $where = ['user_id' => (int)$where];
	
        return static::get(array_merge(['is_delete' => 0], $where), $with);
    }
    /**
     * 保存登录状态
     * @param $user
     * @throws \think\Exception
     */
    public function loginState($user)
    {
        /** @var \app\common\model\App $app */
        $app = $user['app'];
        // 保存登录状态
        Session::set('wymall_store', [
            'user' => [
                'user_id' => $user['user_id'],
                'user_name' => $user['user_name'],
            ],
            'app' => $app->toArray(),
            'is_login' => true,
        ]);
    }
	/**
     * 商家用户登录
     * @param $data
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($data)
    {
        // 验证用户名密码是否正确
        if (!$user = $this->getLoginUser($data['user_name'], $data['password'])) {
            $this->error = '登录失败, 用户名或密码错误';
            return false;
        }
        if (empty($user['app'])) {
            $this->error = '登录失败, 未找到小程序信息';
            return false;
        }
        if ($user['app']['is_recycle']) {
            $this->error = '登录失败, 当前小程序商城已删除';
            return false;
        }
        // 保存登录状态
        $this->loginState($user);
        return true;
    }
    /**
     * 获取登录用户信息
     * @param $user_name
     * @param $password
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function getLoginUser($user_name, $password)
    {
        return self::useGlobalScope(false)->with(['app'])->where([
            'user_name' => $user_name,
            'password' => wymall_pass($password),
            'is_delete' => 0
        ])->find();
    }
    /**
     * 获取用户列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->where(['is_delete'=> '0'])
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }
    /**
     * 新增记录
     * @param $data
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public function add($data)
    {
	
        if (!!self::detail(['user_name' => $data['user_name']])) {
            $this->error = '用户名已存在';
            return false;
        }
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        if (empty($data['role_id'])) {
            $this->error = '请选择所属角色';
            return false;
        }
        $this->startTrans();
        try {
            // 新增管理员记录
            $data['password'] = wymall_pass($data['password']);
            $data['app_id'] = self::$app_id;
            $data['is_super'] = 0;
            $this->allowField(true)->save($data);
            // 新增角色关系记录
            (new UserRole)->add($this['user_id'], $data['role_id']);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    /**
     * 更新记录
     * @param array $data
     * @return bool
     * @throws \think\exception\DbException
     */
    public function edit($data)
    {
        if ($this['user_name'] !== $data['user_name']
            && !!self::detail(['user_name' => $data['user_name']])) {
            $this->error = '用户名已存在';
            return false;
        }
        if (!empty($data['password']) && ($data['password'] !== $data['password_confirm'])) {
            $this->error = '确认密码不正确';
            return false;
        }
        if (empty($data['role_id'])) {
            $this->error = '请选择所属角色';
            return false;
        }
        if (!empty($data['password'])) {
            $data['password'] = wymall_pass($data['password']);
        } else {
            unset($data['password']);
        }
        $this->startTrans();
        try {
            // 更新管理员记录
            $this->allowField(true)->save($data);
            // 更新角色关系记录
            (new UserRole)->edit($this['user_id'], $data['role_id']);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        if ($this['is_super']) {
            $this->error = '超级管理员不允许删除';
            return false;
        }
        // 删除对应的角色关系
        UserRole::deleteAll(['user_id' => $this['user_id']]);
        return $this->delete();
    }
    /**
     * 更新当前管理员信息
     * @param $data
     * @return bool
     */
    public function renew($data)
    {
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        // 更新管理员信息
        if ($this->save([
                'user_name' => $data['user_name'],
                'password' => wymall_pass($data['password']),
            ]) === false) {
            return false;
        }
        // 更新session
        Session::set('wymall_store.user', [
            'user_id' => $this['user_id'],
            'user_name' => $data['user_name'],
        ]);
        return true;
    }
}