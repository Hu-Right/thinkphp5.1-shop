<?
// +----------------------------------------------------------------------
// | Common 
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
namespace app\common\model;
/**
 * 微信小程序分类页模板
 * Class AppCategory
 * @package app\common\model
 */
class AppCategory extends BaseModel
{
    protected $name = 'app_category';
	 /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'app_id',
        'create_time',
        'update_time'
    ];
    /**
     * 分类模板详情
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function detail()
    {
        return self::get([]);
    }
	/**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        return $this->allowField(true)->save($data) !== false;
    }
}