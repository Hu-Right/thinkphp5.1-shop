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
use app\common\model\Category as CategoryModel;
use app\common\model\AppCategory as AppCategoryModel;
/**
 * 商品分类控制器
 * Class Item
 * @package app\api\controller
 */
class Category extends Controller
{
    /**
     * 分类页面
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 分类模板
        $templet = AppCategoryModel::detail();
		
        // 商品分类列表
        $list = array_values(CategoryModel::getCacheTree());
        return $this->renderSuccess(compact('templet', 'list'));
    }
}