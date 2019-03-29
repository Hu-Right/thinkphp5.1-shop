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
namespace app\user\controller\item;
use app\user\controller\Controller;
use app\common\model\Comment as CommentModel;
/**
 * 商品评价管理
 * Class Comment
 * @package app\user\controller\item
 */
class Comment extends Controller
{
    /**
     * 评价列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($item_id = null,$user_id = null)
    {
		
        $model = new CommentModel;
        $list = $model->getList($item_id,$user_id);
        return $this->fetch('index', compact('list'));
    }
    /**
     * 评价详情
     * @param $comment_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function detail($comment_id)
    {
        // 评价详情
        $model = CommentModel::detail($comment_id);
        if (!$this->request->isAjax()) {
		
            return $this->fetch('detail', compact('model'));
        }
        // 更新记录
        if ($model->edit($this->postData('comment'))) {
            return $this->renderSuccess('更新成功', url('item.comment/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }
    /**
     * 删除评价
     * @param $comment_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($comment_id)
    {
        $model = CommentModel::get($comment_id);
        if (!$model->setDelete()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
}