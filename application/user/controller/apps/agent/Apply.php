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
use app\common\model\agent\Apply as ApplyModel;
/**
 * 分销商申请
 * Class Setting
 * @package app\user\controller\apps\agent
 */
class Apply extends Controller
{
    /**
     * 分销商申请列表
     * @param string $search
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($search = '')
    {
        $model = new ApplyModel;
		
        return $this->fetch('index', [
            'list' => $model->getList($search),
        ]);
    }
    /**
     * 分销商审核
     * @param $apply_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function submit($apply_id)
    {
        $model = ApplyModel::detail($apply_id);
		
        if ($model->submit($this->postData('apply'))) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError($model->getError() ?: '操作失败');
    }
}