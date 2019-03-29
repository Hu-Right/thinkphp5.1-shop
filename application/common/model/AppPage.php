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
 * 微信小程序diy页面模型
 * Class AppPage
 * @package app\common\model
 */
class AppPage extends BaseModel
{
    protected $name = 'app_page';
    protected $pk= 'page_id';
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
     * 格式化页面数据
     * @param $json
     * @return array
     */
    public function getPageDataAttr($json)
    {
        $array = json_decode($json, true);
        return compact('array', 'json');
    }
    /**
     * 自动转换data为json格式
     * @param $value
     * @return string
     */
    public function setPageDataAttr($value)
    {
        return json_encode($value ?: ['items' => []]);
    }
    /**
     * diy页面详情
     * @param int $page_id
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function detail($page_id)
    {
        return self::get(['page_id' => $page_id]);
    }
    /**
     * diy页面详情
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function getHomePage()
    {
        return self::get(['page_type' => 10]);
    }
	 /**
     * 获取列表
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->where(['is_delete' => 0])->order(['create_time' => 'desc'])->select();
    }
    /**
     * 新增页面
     * @param $data
     * @return bool
     */
    public function add($data)
    {
        // 删除app缓存
        App::deleteCache();
        return $this->save([
            'page_type' => 20,
            'page_name' => $data['items']['page']['params']['name'],
            'page_data' => $data,
            'app_id' => self::$app_id
        ]);
    }
    /**
     * 更新页面
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        // 删除app缓存
       App::deleteCache();
        // 保存数据
        return $this->save([
                'page_name' => $data['items']['page']['params']['name'],
                'page_data' => $data
            ]) !== false;
    }
    /**
     * 删除记录
     * @return int
     */
    public function setDelete()
    {
        if ($this['page_type'] === 10) {
            $this->error = '默认首页不可以删除';
            return false;
        }
        // 删除app缓存
       App::deleteCache();
        return $this->save(['is_delete' => 1]);
    }
    /**
     * 设为默认首页
     * @return int
     */
    public function setHome()
    {
        // 取消原默认首页
        $this->where(['page_type' => 10])->update(['page_type' => 20]);
        // 删除app缓存
        App::deleteCache();
        return $this->save(['page_type' => 10]);
    }
	/**
     * DIY页面详情
     * @param User $user
     * @param int $page_id
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getPageItems($user, $page_id = null)
    {
		
        $model = new self;
        $detail = $page_id > 0 ? self::detail($page_id) : self::getHomePage();
        $items = $detail['page_data']['array']['items'];
	
        foreach ($items as $key => $item) {
            if ($item['type'] === 'window') {
               $items[$key]['data'] = array_values($item['data']);
            } else if ($item['type'] === 'item') {
				
               $items[$key]['data'] = $model->getItemList($item);
				
            } else if ($item['type'] === 'coupon') {
               $items[$key]['data'] = $model->getCouponList($user, $item);
            }
        }
        return $items;
    }
    /**
     * 商品组件：获取商品列表
     * @param $item
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function getItemList($item)
    {
        // 获取商品数据
        $Item = new Item;
        if ($item['params']['source'] === 'choice') {
			
            // 数据来源：手动
                $itemIds = array_column($item['data'], 'item_id');
				
                $itemsList = $Item->getListByIds($itemIds, 10);
        } else {
			
            // 数据来源：自动
            $itemsList = $Item->getList(10, $item['params']['auto']['category'], '',
                $item['params']['auto']['itemSort'], false, $item['params']['auto']['showNum']);
        }
        // 格式化商品列表
        $data = [];
        foreach ($itemsList as $Item) {
            $data[] = [
            'item_id' => $Item['item_id'],
                'name' => $Item['name'],
                'image' => $Item['image'][0]['file_path'],
                'item_price' => $Item['sku'][0]['item_price'],
            ];
        }
        return $data;
    }
    /**
     * 优惠券组件：获取优惠券列表
     * @param $user
     * @param $item
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function getCouponList($user, $item)
    {
        // 获取优惠券数据
       // print_r($item['params']['limit']);die;
        return (new Coupon)->getListapi($user, $item['params']['limit'], true);
    }
}