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
 * 商品SKU模型
 * Class ItemSku
 * @package app\common\model
 */
class ItemSku extends BaseModel
{
    protected $name = 'item_sku';
    protected $pk = 'item_sku_id';
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
     * 批量添加商品sku记录
     * @param $item_id
     * @param $spec_list
     * @return array|false
     * @throws \Exception
     */
    public function addSkuList($item_id, $spec_list)
    {
		
        $data = [];
        foreach ($spec_list as $item) {
				
            $data[] = array_merge($item['form'], [
                'spec_sku_id' => $item['spec_sku_id'],
                'item_id' => $item_id,
                'app_id' => self::$app_id,
            ]);
        }
      
        return $this->saveAll($data);
    }
    /**
     * 添加商品规格关系记录
     * @param $item_id
     * @param $spec_attr
     * @return array|false
     * @throws \Exception
     */
    public function addSpecRel($item_id, $spec_attr)
    {
		
        $data = [];
        array_map(function ($val) use (&$data, $item_id) {
            array_map(function ($item) use (&$val, &$data, $item_id) {
                $data[] = [
                    'item_id' => $item_id,
                    'spec_id' => $val['group_id'],
                    'spec_value_id' => $item['item_id'],
                    'app_id' => self::$app_id,
                ];
            }, $val['spec_items']);
        }, $spec_attr);
        //print_r($model->saveAll($data,true));die;
	
        $model = new ItemSpecRel();
        return $model->saveAll($data);
    }
    /**
     * 移除指定商品的所有sku
     * @param $item_id
     * @return int
     */
    public function removeAll($item_id)
    {
        $model = new ItemSpecRel;
        $model->where('item_id','=', $item_id)->delete();
        return $this->where('item_id','=', $item_id)->delete();
    }
}