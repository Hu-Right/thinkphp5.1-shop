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
namespace app\api\controller\user\agent;
use app\api\controller\Controller;
use app\common\model\agent\Apply as AgentApplyModel;
/**
 * 分销商申请
 * Class Apply
 * @package app\api\controller\user\agent
 */
class Apply extends Controller
{
    /* @var \app\common\model\User $user */
    private $user;
    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function initialize()
    {
        parent::initialize();
        $this->user = $this->getUser();   // 用户信息
    }
    /**
     * 提交分销商申请
     * @param string $name
     * @param string $mobile
     * @return array
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function submit($name = '', $mobile = '')
    {
        $model = new AgentApplyModel;
        if ($model->apply_add($this->user, $name, $mobile)) {
            return $this->renderSuccess();
        }
        return $this->renderError($model->getError() ?: '提交失败');
    }
}