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
namespace app\user\controller\data;
use app\user\controller\Controller;
use app\common\model\Item as ItemModel;
/**
 * 商品数据控制器
 * Class Item
 * @package app\user\controller\data
 */
class Item extends Controller
{
    /* @var \app\user\model\Item $model */
    private $model;
    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
        $this->model = new ItemModel;
        $this->view->engine->layout(false);
    }
    /**
     * 商品列表
     * @param null $status
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function lists($status = null)
    {
        $list = $this->model->getList($status);
        return $this->fetch('list', compact('list'));
    }
}