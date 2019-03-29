<?php晓明版权
/**
 * web
 * ============================================================================
 * 版权所有 2015-2020 晓明版权，并保留所有权利。
 * 网站地址: https://huxiaoming.top
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: 晓明
 * Date: 2018-12-01
 */
namespace app\task\model;
use app\common\model\Item as ItemModel;
/**
 * 商品模型
 * Class Item
 * @package app\task\model
 */
class Item extends ItemModel
{
    /**
     * 更新商品库存销量
     * @param $itemsList
     * @throws \Exception
     */
    public function updateStockSales($itemsList)
    {
		
        // 整理批量更新商品销量
        $itemSave = [];
        // 批量更新商品规格：sku销量、库存
        $itemSpecSave = [];
		
        foreach ($itemsList as $Item) {
            $itemSave[] = [
                'item_id' => $Item['item_id'],
                'sales_actual' => ['inc', $Item['total_num']]
            ];
			
            $specData = [
                'item_sku_id' => $Item['item_sku_id'],
                'sales_num' => ['inc', $Item['total_num']]
            ];
            // 付款减库存
            if ($Item['type'] === 20) {
                $specData['stock_num'] = ['dec', $Item['total_num']];
            }
			
            $itemSpecSave[] = $specData;
        }
		
        // 更新商品总销量
        $this->allowField(true)->isUpdate()->saveAll($itemSave);
        // 更新商品规格库存
        (new ItemSku)->isUpdate()->saveAll($itemSpecSave);
    }
}