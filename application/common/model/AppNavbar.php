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
 * 微信小程序导航栏模型
 * Class AppNavbar
 * @package app\common\model
 */
class AppNavbar extends BaseModel
{
    protected $name = 'app_navbar';
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
     * 顶部导航文字颜色
     * @param $value
     * @return array
     */
    public function getTopTextColorAttr($value)
    {
        $color = [10 => '#000000', 20 => '#ffffff'];
        return ['text' => $color[$value], 'value' => $value];
    }
    /**
     * 小程序导航栏详情
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail()
    {
        return self::get([]);
    }
    /**
     * 新增小程序导航栏默认设置
     * @param $app_id
     * @param $app_title
     * @return false|int
     */
    public function insertDefault($app_id, $app_title)
    {
        return $this->save([
            'app_title' => $app_title,
            'top_text_color' => 20,
            'top_background_color' => '#fd4a5f',
            'app_id' => $app_id
        ]);
    }
	 /**
     * 更新页面数据
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        // 删除app缓存
        App::deleteCache();
        return $this->save($data) !== false;
    }
}