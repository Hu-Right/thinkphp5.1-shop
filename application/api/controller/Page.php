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
namespace app\api\controller;
use app\common\model\AppPage;
/**
 * 页面控制器
 * Class Index
 * @package app\api\controller
 */
class Page extends Controller
{
    /**
     * 首页diy数据
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function home()
    {
        // 页面元素
        $items = AppPage::getPageItems($this->getUser(false));
        return $this->renderSuccess(compact('items'));
    }
    /**
     * 自定义页数据
     * @param $page_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function custom($page_id)
    {
        // 页面元素
        $items = AppPage::getPageItems($this->getUser(false), $page_id);
        return $this->renderSuccess(compact('items'));
    }
}