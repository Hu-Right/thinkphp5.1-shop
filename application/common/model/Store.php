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
 * 商城模型
 * Class Store
 * @package app\common\model
 */
class Store extends BaseModel
{
/* @var  $ItemModel */
    private $ItemModel;
    /* @var Order $ItemModel */
    private $OrderModel;
    /* @var User $ItemModel */
    private $UserModel;
    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
        /* 初始化模型 */
        $this->ItemModel = new Item;
        $this->OrderModel = new Order;
        $this->UserModel = new User;
    }
    /**
     * 后台首页数据
     * @return array
     */
        public function getHomeData()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        // 最近七天日期
        $lately7days = $this->getLately7days();
        $data = [
            'widget-card' => [
                // 商品总量
                'item_total' => $this->getitemTotal(),
                // 用户总量
                'user_total' => $this->getUserTotal(),
                // 订单总量
                'order_total' => $this->getOrderTotal(),
                // 评价总量
                'comment_total' => $this->getCommentTotal()
            ],
            'widget-outline' => [
                // 销售额(元)
                'order_total_price' => [
                    'tday' => $this->getOrderTotalPrice($today),
                    'ytd' => $this->getOrderTotalPrice($yesterday)
                ],
                // 支付订单数
                'order_total' => [
                    'tday' => $this->getOrderTotal($today),
                    'ytd' => $this->getOrderTotal($yesterday)
                ],
                // 新增用户数
                'new_user_total' => [
                    'tday' => $this->getUserTotal($today),
                    'ytd' => $this->getUserTotal($yesterday)
                ],
                // 下单用户数
                'order_user_total' => [
                    'tday' => $this->getPayOrderUserTotal($today),
                    'ytd' => $this->getPayOrderUserTotal($yesterday)
                ]
            ],
            'widget-echarts' => [
                // 最近七天日期
                'date' => json_encode($lately7days),
                'order_total' => json_encode($this->getOrderTotalByDate($lately7days)),
                'order_total_price' => json_encode($this->getOrderTotalPriceByDate($lately7days))
            ]
        ];
        return $data;
    }
    /**
     * 最近七天日期
     */
    private function getLately7days()
    {
        // 获取当前周几
        $date = [];
        for ($i = 0; $i < 7; $i++) {
            $date[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        return array_reverse($date);
    }
    /**
     * 获取商品总量
     * @return string
     */
    private function getitemTotal()
    {
        return number_format($this->ItemModel->getitemTotal());
    }
    /**
     * 获取用户总量
     * @param null $day
     * @return string
     */
    private function getUserTotal($day = null)
    {
        return number_format($this->UserModel->getUserTotal($day));
    }
    /**
     * 获取订单总量
     * @param null $day
     * @return string
     */
    private function getOrderTotal($day = null)
    {
        //print_r($this->OrderModel->getPayOrderTotal($day));die;
        return number_format($this->OrderModel->getPayOrderTotal($day));
    }
    /**
     * 获取订单总量 (指定日期)
     * @param $days
     * @return array
     */
    private function getOrderTotalByDate($days)
    {
        $data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotal($day);
        }
        return $data;
    }
    /**
     * 获取评价总量
     * @return string
     */
    private function getCommentTotal()
    {
        $model = new Comment;
		
        return number_format($model->getCommentTotal());
    }
    /**
     * 获取某天的总销售额
     * @param $day
     * @return float|int
     */
    private function getOrderTotalPrice($day)
    {
        return sprintf('%.2f', $this->OrderModel->getOrderTotalPrice($day));
    }
    /**
     * 获取订单总量 (指定日期)
     * @param $days
     * @return array
     */
    private function getOrderTotalPriceByDate($days)
    {
        $data = [];
        foreach ($days as $day) {
            $data[] = $this->getOrderTotalPrice($day);
        }
        return $data;
    }
    /**
     * 获取某天的下单用户数
     * @param $day
     * @return float|int
     */
    private function getPayOrderUserTotal($day)
    {
        return number_format($this->OrderModel->getPayOrderUserTotal($day));
    }
}