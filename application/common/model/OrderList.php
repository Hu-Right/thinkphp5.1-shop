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
 * 订单商品模型
 * Class OrderList
 * @package app\common\model
 */
class OrderList extends BaseModel
{
    protected $name = 'order_list';
	protected $pk = 'list_id';
    protected $updateTime = false;
	/**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'content',
        'app_id',
        'create_time',
    ];
    /**
     * 订单商品列表
     * @return \think\model\relation\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('UploadFile', 'image_id', 'id');
    }
    /**
     * 关联商品表
     * @return \think\model\relation\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo('Item');
    }
    /**
     * 关联商品sku表
     * @return \think\model\relation\BelongsTo
     */
    public function sku()
    {
        return $this->belongsTo('ItemSku', 'spec_sku_id', 'spec_sku_id');
    }
	/**
     * 获取未评价的商品
     * @param $order_id
     * @return OrderList[]|false
     * @throws \think\exception\DbException
     */
    public static function getNotComment($order_id)
    {
        return self::all(['order_id' => $order_id, 'is_comment' => 0], ['orderM', 'image']);
    }
    /**
     * 关联订单主表
     * @return \think\model\relation\BelongsTo
     */
    public function orderM()
    {
        return $this->belongsTo('Order');
    }
}