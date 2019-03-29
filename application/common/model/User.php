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
namespace app\common\model;
use think\facade\Request;
use think\facade\Cache;
use app\common\library\wechat\WxUser;
use app\common\exception\BaseException;
use app\common\model\agent\Referee as RefereeModel;
use app\common\model\agent\Setting as AgentSettingModel;
/**
 * 用户模型类
 * Class User
 * @package app\common\model
 */
class User extends BaseModel
{
	private $token;
    protected $name = 'user';
	protected $pk = 'user_id';
	/**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'app_id',
        'create_time',
        'update_time'
    ];
    // 性别
    private $gender = ['未知', '男', '女'];
    /**
     * 关联收货地址表
     * @return \think\model\relation\HasMany
     */
    public function address()
    {
		
        return $this->hasMany('UserAddress');
    }
    /**
     * 关联收货地址表 (默认地址)
     * @return \think\model\relation\BelongsTo
     */
    public function addressDefault()
    {
		
        return $this->belongsTo('UserAddress', 'address_id');
    }
    /**
     * 显示性别
     * @param $value
     * @return mixed
     */
    public function getGenderAttr($value)
    {
        return $this->gender[$value];
    }
    /**
     * 获取用户信息
     * @param $where
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {	
       $filter = ['is_delete' => 0];
        if (is_array($where)) {
            $filter = array_merge($filter, $where);
        } else {
            $filter = ['user_id','=',(int)$where];
        }
		
        return self::get($filter, ['address', 'addressDefault']);
    }
/**
     * 获取当前用户总数
     * @param $day
     * @return int|string
     */
    public function getUserTotal($day = null)
    {
        if (!is_null($day)) {
            $startTime = strtotime($day);
            $this->where('create_time', '>=', $startTime)
                ->where('create_time', '<', $startTime + 86400);
        }
        return $this->count();
    }
    /**
     * 获取用户列表
     * @param string $nickName
     * @param null $gender
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($nickName = '', $gender = null,$pid = null,$listRows = 15)
    {	
		if(!empty($nickName))
			$where[]=['nickName', 'like', "%$nickName%"];
		if(!empty($pid))
			$where[]=['pid', '=', $pid];
		if($gender > -1&&$gender)
			$where[]=['gender', 'in', (int)$gender];
      //  !empty($nickName) && $this->where('nickName', 'like', "%$nickName%");
       // $gender > -1 && $this->where('gender', (int)$gender);
		$where[]=['is_delete','=','0'];
	
        return $this->where($where)
            ->order('create_time','=','desc')
            ->paginate($listRows, false, [
                 'query' => Request::instance()->request()
            ]);
    }
    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        return $this->save(['is_delete' => 1]);
    }
	/**
     * 获取用户信息
     * @param $token
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function getUser($token)
    {
		
        return self::detail(['open_id' => Cache::get($token)['open_id']]);
		
    }
	/*
	 * 网页用户登录
     * @param array $post
     * @return string
     * @throws BaseException
	*/
	public function app_login($post){
		$user = self::useGlobalScope(false)->where([
            'phone' => $post['phone'],
            'password' => wymall_pass($post['password'])
        ])->find();
		if(!$user){
            //$this->error = '登录失败, 用户名或密码错误';
            return false;
        }else{
			// 生成token (session3rd)
			$this->token = $this->token($user['phone']);
			// 记录缓存, 7天
			Cache::set($this->token, $user, 86400 * 7);
			return $user['user_id'];
		}
	}
    /**
     * 用户登录
     * @param array $post
     * @return string
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login($post)
    {
		
        // 微信登录 获取session_key
        $session = $this->wxlogin($post['code']);
		$session['open_id']=$session['openid'];
        // 自动注册用户
        $referee_id = isset($post['referee_id']) ? $post['referee_id'] : null;
        $userInfo = json_decode(htmlspecialchars_decode($post['user_info']), true);
        $user_id = $this->register($session['open_id'], $userInfo, $referee_id);
        // 生成token (session3rd)
        $this->token = $this->token($session['open_id']);
        // 记录缓存, 7天
        Cache::set($this->token, $session, 86400 * 7);
        return $user_id;
    }
    /**
     * 获取token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }
    /**
     * 微信登录
     * @param $code
     * @return array|mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    private function wxlogin($code)
    {	
        // 获取当前小程序信息
        $wxConfig = App::getAppCache();
        // 微信登录 (获取session_key)
		
        $WxUser = new WxUser($wxConfig['appkey'], $wxConfig['app_secret']);
	
        if (!$session = $WxUser->sessionKey($code))
            throw new BaseException(['msg' => 'session_key 获取失败']);
        return $session;
    }
    /**
     * 生成用户认证的token
     * @param $openid
     * @return string
     */
    private function token($openid)
    {
        return md5($openid . self::$app_id . 'token_salt');
    }
	/*
	*app等注册入口
	* @param $phone
    * @param $data
	*/
	public function reg($data){
		$user = self::useGlobalScope(false)->where([
            'phone' => $data['phone']
        ])->find();
		if($user){
			 return false;
		}
		// 生成token (session3rd)
        $this->token = $this->token($data['phone']);
		return $model->allowField(true)->save($data);
	}
    /**
     * 自动注册用户
     * @param $open_id
     * @param $data
     * @param int $referee_id
     * @return mixed
     * @throws \Exception
     * @throws \think\exception\DbException
     */
    private function register($open_id, $data, $referee_id = null)
    {
        // 查询用户是否已存在
        $user = self::detail(['open_id'=>$open_id]);
		
        $model = $user ?: $this;
        $data['open_id'] = $open_id;
        $data['app_id'] = self::$app_id;
        // 用户昵称
        $data['nickName'] = preg_replace('/[\xf0-\xf7].{3}/', '', $data['nickName']);
        try {
            $this->startTrans();
            // 保存/更新用户记录
            if (!$model->allowField(true)->save($data))
                throw new BaseException(['msg' => '用户注册失败']);
            // 记录推荐人关系
            if (!$user && $referee_id > 0)
                RefereeModel::createRelation($model['user_id'], $referee_id);
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            throw new BaseException(['msg' => $e->getMessage()]);
        }
        return $model['user_id'];
    }
    /**
     * 个人中心菜单列表
     * @return array
     */
    public function getMenus()
    {
        $menus = [
            'address' => [
                'name' => '收货地址',
                'url' => 'pages/address/index',
                'icon' => 'map'
            ],
            'coupon' => [
                'name' => '领券中心',
                'url' => 'pages/coupon/coupon',
                'icon' => 'lingquan'
            ],
            'my_coupon' => [
                'name' => '我的优惠券',
                'url' => 'pages/user/coupon/coupon',
                'icon' => 'youhuiquan'
            ],
            'agent' => [
                'name' => '分销中心',
                'url' => 'pages/agent/index/index',
                'icon' => 'fenxiaozhongxin'
            ],
            'help' => [
                'name' => '我的帮助',
                'url' => 'pages/user/help',
                'icon' => 'help'
            ],
        ];
        // 判断分销功能是否开启
        if (AgentSettingModel::isOpen()) {
            $menus['agent']['name'] = AgentSettingModel::getAgentTitle();
        } else {
            unset($menus['agent']);
        }
        return $menus;
    }
}