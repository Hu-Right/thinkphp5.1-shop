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
 * 商品规格关系模型
 * Class ItemSpecRel
 * @package app\common\model
 */
class ItemSpecRel extends BaseModel
{
    protected $name = 'item_spec_rel';
    protected $updateTime = false;
    /**
     * 关联规格组
     * @return \think\model\relation\BelongsTo
     */
    public function spec()
    {
        return $this->belongsTo('Spec');
    }
    public function specValue()
    {
        return $this->belongsTo('SpecValue','','spec_value_id');
    }
    public function itemSpec()
    {
        return $this->belongsToMany('Spec','SpecValue','spec_id','spec_id');
    }
    public static function spec_all($item_id){
        $user = self::useGlobalScope(false)->with([
            'itemSpec',
            'Spec',
            'SpecValue'
        ])->where([
            'item_id' => $item_id
        ])->select();
        if (!$user){
            return false;
        }
        return $user;
    }
}