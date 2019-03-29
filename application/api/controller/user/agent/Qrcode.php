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
use app\common\model\agent\Setting;
use app\common\model\agent\User as AgentUserModel;
use app\common\service\qrcode\Poster;
/**
 * 推广二维码
 * Class Order
 * @package app\api\controller\user\agent
 */
class Qrcode extends Controller
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
     * 获取推广二维码
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function poster()
    {
        $Qrcode = new Poster($this->agent);
	
        return $this->renderSuccess([
            // 二维码图片地址
            'qrcode' => $Qrcode->getImage(),
            // 页面文字
            'words' => $this->setting['words']['values'],
        ]);
    }
}