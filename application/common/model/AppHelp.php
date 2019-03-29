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
 * 小程序帮助中心
 * Class appHelp
 * @package app\common\model
 */
class AppHelp extends BaseModel
{
    protected $name = 'app_help';
	/**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'create_time',
        'update_time',
    ];
    /**
     * 获取帮助列表
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->order(['sort' => 'asc'])->select();
    }
    /**
     * 帮助详情
     * @param $help_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($help_id)
    {
		
        return self::get($help_id);
    }
    /**
     * 新增默认帮助
     * @param $app_id
     * @return false|int
     */
    public function insertDefault($app_id)
    {
        return $this->save([
            'title' => '关于小程序',
            'content' => '小程序本身无需下载，无需注册，不占用手机内存，可以跨平台使用，响应迅速，体验接近原生APP。',
            'sort' => 100,
            'app_id'=> $app_id
        ]);
    }
	/**
     * 新增记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['app_id'] = self::$app_id;
        return $this->allowField(true)->save($data);
    }
    /**
     * 更新记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        return $this->allowField(true)->save($data) !== false;
    }
    /**
     * 删除记录
     * @return int
     */
    public function remove() {
        return $this->delete();
    }
}