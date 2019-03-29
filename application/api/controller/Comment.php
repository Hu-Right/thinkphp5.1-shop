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
namespace app\api\controller;
use app\common\model\Comment as CommentModel;
/**
 * 商品评价控制器
 * Class Comment
 * @package app\api\controller
 */
class Comment extends Controller
{
    /**
     * 商品评价列表
     * @param $item_id
     * @param int $scoreType
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists($item_id, $scoreType = -1)
    {
        $model = new CommentModel;
        $list = $model->getCommentList($item_id, $scoreType);
        $total = $model->getTotal($item_id);
        return $this->renderSuccess(compact('list', 'total'));
    }
}