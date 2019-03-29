<?php
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
namespace app\api\controller\user\agent;
use app\api\controller\Controller;
use app\common\model\agent\Setting;
use app\common\model\agent\User as AgentUserModel;
use app\common\model\agent\Withdraw as WithdrawModel;
/**
 * 分销商提现
 * Class Withdraw
 * @package app\api\controller\user\agent
 */
class Withdraw extends Controller
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
     * 提交提现申请
     * @param $data
     * @return array
     * @throws \app\common\exception\BaseException
     */
    public function submit($data)
    {
        $formData = json_decode(htmlspecialchars_decode($data), true);
        $model = new WithdrawModel;
        if ($model->submit($this->agent, $formData)) {
            return $this->renderSuccess([], '申请提现成功');
        }
        return $this->renderError($model->getError() ?: '提交失败');
    }
    /**
     * 分销商提现明细
     * @param int $status
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists($status = -1)
    {
        $model = new WithdrawModel;
        return $this->renderSuccess([
            // 提现明细列表
            'list' => $model->getList($this->user['user_id'], (int)$status),
            // 页面文字
            'words' => $this->setting['words']['values'],
        ]);
    }
}