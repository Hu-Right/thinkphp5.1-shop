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
 * 规格/属性(值)模型
 * Class SpecValue
 * @package app\common\model
 */
class SpecValue extends BaseModel
{
    protected $name = 'spec_value';
	protected $pk = 'spec_value_id';
    protected $updateTime = false;
    /**
     * 关联规格组表
     * @return $this|\think\model\relation\BelongsTo
     */
    public function spec()
    {
        return $this->belongsTo('Spec');
    }
 /**
     * 根据规格组名称查询规格id
     * @param $spec_id
     * @param $spec_value
     * @return mixed
     */
    public function getSpecValueIdByName($spec_id, $spec_value)
    {
        return self::where(compact('spec_id', 'spec_value'))->value('spec_value_id');
    }
    /**
     * 新增规格值
     * @param $spec_id
     * @param $spec_value
     * @return false|int
     */
    public function add($spec_id, $spec_value)
    {
        $app_id = self::$app_id;
		$create_time = time();
		return self::create(compact('spec_value', 'spec_id', 'app_id','create_time'));
    }
}