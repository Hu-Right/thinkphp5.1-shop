<?
// +----------------------------------------------------------------------
// | API 
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
namespace app\api\controller\user;
use app\api\controller\Controller;
use app\common\model\agent\Setting;
use app\common\model\agent\User as AgentUserModel;
use app\common\model\agent\Apply as AgentApplyModel;
/**
 * 分销中心
 * Class agent
 * @package app\api\controller\user
 */
class Agent extends Controller
{
    /* @var \app\common\model\User $user */
    private $user;
    private $agent;
    private $setting;
    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function initialize()
    {
        parent::initialize();
        // 用户信息
        $this->user = $this->getUser();
        // 分销商用户信息
        $this->agent = AgentUserModel::detail($this->user['user_id']);
        // 分销商设置
        $this->setting = Setting::getAll();
    }
    /**
     * 分销商中心
     * @return array
     */
    public function center()
    {
        return $this->renderSuccess([
            // 当前是否为分销商
            'is_agent' => $this->isAgentUser(),
            // 当前用户信息
            'user' => $this->user,
            // 分销商用户信息
            'agent' => $this->agent,
            // 背景图
            'background' => $this->setting['background']['values']['index'],
            // 页面文字
            'words' => $this->setting['words']['values'],
        ]);
    }
    /**
     * 分销商申请状态
     * @param null $referee_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function apply($referee_id = null)
    {
        // 推荐人昵称
        $referee_name = '平台';
        if ($referee_id > 0 && ($referee = AgentUserModel::detail($referee_id))) {
            $referee_name = $referee['user']['nickName'];
        }
        return $this->renderSuccess([
            // 当前是否为分销商
            'is_agent' => $this->isAgentUser(),
            // 当前是否在申请中
            'is_applying' => AgentApplyModel::isApplying($this->user['user_id']),
            // 推荐人昵称
            'referee_name' => $referee_name,
            // 背景图
            'background' => $this->setting['background']['values']['apply'],
            // 页面文字
            'words' => $this->setting['words']['values'],
            // 申请协议
            'license' => $this->setting['license']['values']['license'],
        ]);
    }
    /**
     * 分销商提现信息
     * @return array
     */
    public function withdraw()
    {
        return $this->renderSuccess([
            // 分销商用户信息
            'agent' => $this->agent,
            // 结算设置
            'settlement' => $this->setting['settlement']['values'],
            // 背景图
            'background' => $this->setting['background']['values']['withdraw_apply'],
            // 页面文字
            'words' => $this->setting['words']['values'],
        ]);
    }
    /**
     * 当前用户是否为分销商
     * @return bool
     */
    private function isAgentUser()
    {
        return !!$this->agent && !$this->agent['is_delete'];
    }
}