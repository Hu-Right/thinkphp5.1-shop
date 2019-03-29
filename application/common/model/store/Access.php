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
use app\common\model\store\User;
use app\common\model\BaseModel;
use app\common\model\store\UserRole;
use app\common\model\store\RoleAccess;
use app\common\model\store\Role as RoleModel;
/**
 * 商家用户权限模型
 * Class Access
 * @package app\common\model\admin
 */
class Access extends BaseModel
{
    protected $name = 'access';
	/** @var User $user 商家用户信息 */
    private $user;
	/** @var array $accessUrls 商家用户权限url */
    private $accessUrls = [];
	/** @var array $allowAllAction 权限验证白名单 */
    protected $allowAllAction = [
        // 权限列表
        'store.role/role',
        // 用户登录
        'login/login',
        // 退出登录
        'login/logout',
        // 修改当前用户信息
        'store.user/renew',
        // 文件库
        'upload.library/*',
        // 图片上传
        'upload/image',
        // 商品选择
        'data.item/lists',
        // 添加商品规格
        'item.spec/*',
        // 订单批量发货模板
        'order.operate/deliverytpl',
        // 物流公司编码表
        'setting.express/company',
        // 帮助信息
        'setting.help/*',
    ];
	
    /**
     * 获取所有权限
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected static function getAll()
    {
        $data = static::useGlobalScope(false)->order(['sort' => 'asc', 'create_time' => 'asc'])->select();
        return $data ? $data->toArray() : [];
    }
	/**
     * 验证指定url是否有访问权限
     * @param string|array $url
     * @param bool $strict 严格模式(必须全部通过才返回true)
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
	public function check($url,$user_id, $strict = true)
    {
        if (!is_array($url)):
            return $this->checkAccess(strtolower($url),$user_id);
        else:
            foreach ($url as $val){
                if ($strict && !$this->checkAccess($val,$user_id)) {
                    return false;
                }
                if (!$strict && $this->checkAccess($val,$user_id)) {
                    return true;
                }
            }
        endif;
        return true;
    }
	/**
     * @param string $url
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function checkAccess($url,$user_id)
    {
        // 超级管理员无需验证
        if ($this->user['is_super']) {
            return true;
        }
        // 验证当前请求是否在白名单
        if (in_array($url, $this->allowAllAction)) {
            return true;
        }
        $roleIds = UserRole::getRoleIds($user_id);
        $list = self::getAll();
        // 根据已分配的权限
        $accessIds = RoleAccess::getAccessIds($list,$roleIds);
        foreach ($list as $k=>$v){
            if($v['url']==$url && in_array($v['id'],$accessIds)){
                return true;
            }
        }
        return false;
    }
    public function getUrls($user_id)
    {
        if (empty($this->accessUrls)) {
            // 获取当前用户的角色集
            $roleIds = UserRole::getRoleIds($user_id);
            $list = (new RoleModel)->getList();
            // 根据已分配的权限
            $accessIds = RoleAccess::getAccessIds($list,$roleIds);
            // 获取当前角色所有权限链接
            $this->accessUrls = Access::getUrls($accessIds);
        }
        return $this->accessUrls;
    }
    /**
     * 权限信息
     * @param $access_id
     * @return array|false|\PDOStatement|string|\think\Model|static
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function detail($access_id)
    {
        return static::useGlobalScope(false)->where(['id' => $access_id])->find();
    }
    /**
     * 获取权限url集
     * @param $accessIds
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAccessUrls($accessIds)
    {
        $urls = [];
        foreach (static::getAll() as $item) {
            in_array($item['id'], $accessIds) && $urls[] = $item['url'];
        }
        return $urls;
    }
	/**
     * 获取权限列表 jstree格式
     * @param int $role_id 当前角色id
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getJsTree($role_id = null)
    {
		$list = $this->getAll();
        $accessIds = is_null($role_id) ? [] : RoleAccess::getAccessIds($list,$role_id);
		$tree = array(); //格式化的树
		$tmpMap = array();  //临时扁平数据
		foreach ($list as $key) {
            $key['checked'] = in_array($key['id'], $accessIds);
			$key['value']=$key['id'];
			$tmpMap[$key['id']] = $key; 
		}
		foreach ($list as $item) {
			if (isset($tmpMap[$item['pid']])) {
				$tmpMap[$item['pid']]['list'][] = &$tmpMap[$item['id']];
			} else {
				$tree[] = &$tmpMap[$item['id']];
			}
		}
        return $tree;
    }
    /**
     * 是否存在子集
     * @param $access_id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function hasChildren($list,$access_id)
    {
        foreach ($list as $item) {
            if ($item['pid'] == $access_id)
                return true;
        }
        return false;
    }
}