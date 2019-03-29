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
namespace app\user\controller\apps\agent;
use app\user\controller\Controller;
use app\common\service\qrcode\Poster;
use app\common\model\agent\User as UserModel;
use app\common\model\agent\Setting as SettingModel;
/**
 * 分销商管理
 * Class User
 * @package app\user\controller\apps\agent
 */
class User extends Controller
{
    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
    }
    /**
     * 分销商用户列表
     * @param string $search
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($search = '')
    {
        $model = new UserModel;
        return $this->fetch('index', [
            'list' => $model->getList($search),
            'basicSetting' => SettingModel::getItem('basic'),
        ]);
    }
    /**
     * 删除分销商
     * @param $agent_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($agent_id)
    {
        $model = UserModel::detail($agent_id);
        if (!$model->setDelete()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
    /**
     * 分销商二维码
     * @param $agent_id
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function qrcode($agent_id)
    {
        $model = UserModel::detail($agent_id);
        $Qrcode = new Poster($model);
        $this->redirect($Qrcode->getImage());
    }
}