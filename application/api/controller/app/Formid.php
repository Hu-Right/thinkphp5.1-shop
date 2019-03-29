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

namespace app\api\controller\app;
use app\api\controller\Controller;
use app\common\model\app\Formid as FormidModel;
/**
 * form_id 管理
 * Class Formid
 * @package app\api\controller\app
 */
class Formid extends Controller
{
    /**
     * 新增form_id
     * @param $formId
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function save($formId)
    {
        if (!$user = $this->getUser(false)) {
            return $this->renderSuccess();
        }
        if (FormidModel::add($user['user_id'], $formId)) {
            return $this->renderSuccess();
        }
        return $this->renderError();
    }
}