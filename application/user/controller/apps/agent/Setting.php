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
use app\common\model\agent\Setting as SettingModel;
/**
 * 分销设置
 * Class Setting
 * @package app\user\controller\apps\agent
 */
class Setting extends Controller
{
    /**
     * 分销设置
     * @return array|mixed
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        if (!$this->request->isAjax()) {
            $data = SettingModel::getAll();
            return $this->fetch('index', compact('data'));
        }
        $model = new SettingModel;
        if ($model->edit($this->postData('setting'))) {
            return $this->renderSuccess('更新成功');
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }
    /**
     * 分销海报
     * @return array|mixed
     * @throws \think\exception\PDOException
     */
    public function qrcode()
    {
        if (!$this->request->isAjax()) {
            $data = SettingModel::getItem('qrcode');
            return $this->fetch('qrcode', [
                'data' => json_encode($data, JSON_UNESCAPED_UNICODE)
            ]);
        }
        $model = new SettingModel;
        if ($model->edit(['qrcode' => $this->postData('qrcode')])) {
            return $this->renderSuccess('更新成功');
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }
}