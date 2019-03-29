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
 * 规格/属性(组)模型
 * Class Spec
 * @package app\common\model
 */
class Spec extends BaseModel
{
    protected $name = 'spec';
    protected $pk = 'spec_id';
    protected $updateTime = false;
	 /**
     * 根据规格组名称查询规格id
     * @param $spec_name
     * @return mixed
     */
    public function getSpecIdByName($spec_name)
    {
        return self::where(compact('spec_name'))->value('spec_id');
    }
    /**
     * 新增规格组
     * @param $spec_name
     * @return false|int
     */
    public function add($spec_name)
    {
       // $user   = new User;
        $app_id = self::$app_id;
        $create_time = time();
        return  self::create(compact('spec_name', 'app_id','create_time'));
    }
}