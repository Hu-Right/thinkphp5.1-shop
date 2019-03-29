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
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;
use app\common\model\Setting;
use app\common\model\Auth as AuthModel;
/**
 * 后台控制器基类
 * Class BaseController
 * @package app\user\controller
 */
class Controller extends \think\Controller
{
    /* @var array $store 商家登录信息 */
    protected $store;
    /* @var string $route 当前控制器名称 */
    protected $controller = '';
    /* @var string $route 当前方法名称 */
    protected $action = '';
    /* @var string $route 当前路由uri */
    protected $routeUri = '';
    /* @var string $route 当前路由：分组名称 */
    protected $group = '';
    /* @var array $allowAllAction 登录验证白名单 */
    protected $allowAllAction = [
        // 登录页面
        'login/login',
    ];
    /* @var array $notLayoutAction 无需全局layout */
    protected $notLayoutAction = [
        // 登录页面
        'login/login',
    ];
    /**
     * 后台初始化
     */
    public function initialize()
    {
        // 商家登录信息
        $this->store = Session::get('wymall_store');
        // 当前路由信息
        $this->getRouteinfo();
        // 验证登录
        $this->checkLogin();
		//取当前控制器名称
		$this->auth();
        // 全局layout
        $this->layout();
    }
	/*
	*取当前控制器并进行验证
	*/
	public function auth(){
		$request=  \think\facade\Request::instance();
		$url = $request->controller().'/'.$request->action();
        $auth = new AuthModel;
		if($auth->check($url,$this->store['user']['user_id'])===false){
            if (Request::isGet() && Request::isPost()){
               // return $this->renderError('权限不足');
            }
            //$this->error('权限不足');
        }
	}
    /**
     * 全局layout模板输出
     */
    private function layout()
    {
        // 验证当前请求是否在白名单
        if (!in_array($this->routeUri, $this->notLayoutAction)) {
            // 输出到view
            $this->assign([
                'base_url' => base_url(),                      // 当前域名
                'store_url' => url('/store'),              // 后台模块url
                'group' => $this->group,
                'menus' => $this->menus(),                     // 后台菜单
                'store' => $this->store,                       // 商家登录信息
                'setting' => Setting::getAll() ?: null,        // 当前商城设置
                'request' => Request::instance()               // Request对象
            ]);
        }
    }
    /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    protected function getRouteinfo()
    {
        // 控制器名称
        $this->controller = toUnderScore($this->request->controller());
        // 方法名称
        $this->action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        $groupstr = strstr($this->controller, '.', true);
        $this->group = $groupstr !== false ? $groupstr : $this->controller;
        // 当前uri
		//print_r($this->action);die;
        $this->routeUri = $this->controller . '/' . $this->action;
    }
    /**
     * 后台菜单配置
     * @return array
     */
    private function menus()
    {
		$data = left();
        foreach ($data  as $group => $first) {
            $data[$group]['active'] = $group === $this->group;
            // 遍历：二级菜单
            if (isset($first['submenu'])) {
                foreach ($first['submenu'] as $secondKey => $second) {
                    // 二级菜单所有uri
                    $secondUris = [];
                    if (isset($second['submenu'])) {
                        // 遍历：三级菜单
                        foreach ($second['submenu'] as $thirdKey => $third) {
                            $thirdUris = [];
                            if (isset($third['uris'])) {
                                $secondUris = array_merge($secondUris, $third['uris']);
                                $thirdUris = array_merge($thirdUris, $third['uris']);
                            } else {
                                $secondUris[] = $third['index'];
                                $thirdUris[] = $third['index'];
                            }
                            $data[$group]['submenu'][$secondKey]['submenu'][$thirdKey]['active'] = in_array($this->routeUri, $thirdUris);
                        }
                    }else {
                        if (isset($second['uris']))
                            $secondUris = array_merge($secondUris, $second['uris']);
                        else
                            $secondUris[] = $second['index'];
                    }
                    // 二级菜单：active
                    !isset($data[$group]['submenu'][$secondKey]['active'])
                    && $data[$group]['submenu'][$secondKey]['active'] = in_array($this->routeUri, $secondUris);
                }
            }
        }
        return $data;
    }
    /**
     * 验证登录状态
     * @return bool
     */
    private function checkLogin()
    {
        // 验证当前请求是否在白名单
        if (in_array($this->routeUri, $this->allowAllAction)) {
            return true;
        }
        // 验证登录状态
        if (empty($this->store)
            || (int)$this->store['is_login'] !== 1
            || !isset($this->store['app'])
            || empty($this->store['app'])
        ) {
            $this->redirect('Login/login',302);
			//redirect('passport/login')->remember();
            return false;
        }
        return true;
    }
    /**
     * 获取当前app_id
     */
    protected function getAppId()
    {
        return $this->store['app']['id'];
    }
    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }
    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return $this->renderJson(1, $msg, $url, $data);
    }
    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $url = '', $data = [])
    {
        return $this->renderJson(0, $msg, $url, $data);
    }
    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key)
    {
        return $this->request->post($key . '/a');
    }
}