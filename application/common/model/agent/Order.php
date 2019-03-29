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
namespace app\common\model\agent;
use app\common\model\BaseModel;
/**
 * 分销商订单模型
 * Class Apply
 * @package app\common\model\agent
 */
class Order extends BaseModel
{
    protected $name = 'agent_order';
	 /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'update_time',
    ];
    /**
     * 订单所属用户
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('app\common\model\User');
    }
    /**
     * 订单详情信息
     * @return \think\model\relation\BelongsTo
     */
    public function orderMaster()
    {
        return $this->belongsTo('app\common\model\Order');
    }
    /**
     * 一级分销商用户
     * @return \think\model\relation\BelongsTo
     */
    public function agentFirst()
    {
        return $this->belongsTo('User', 'first_user_id');
    }
    /**
     * 二级分销商用户
     * @return \think\model\relation\BelongsTo
     */
    public function agentSecond()
    {
        return $this->belongsTo('User', 'second_user_id');
    }
    /**
     * 三级分销商用户
     * @return \think\model\relation\BelongsTo
     */
    public function agentThird()
    {
        return $this->belongsTo('User', 'third_user_id');
    }
    /**
     * 订单详情
     * @param $order_id
     * @return Order|null
     * @throws \think\exception\DbException
     */
    public static function detail($order_id)
    {
        return static::get(['order_id' => $order_id]);
    }
    /**
     * 发放分销订单佣金
     * @param $order_id
     * @return bool|false|int
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function grantMoney($order_id)
    {
        // 分销订单详情
        $model = static::detail($order_id);
        if (!$model || $model['is_settled'] == 1) {
            return false;
        }
        // 发放一级分销商佣金
        $model['first_user_id'] > 0 && User::grantMoney($model['first_user_id'], $model['first_money'], $order_id);
        // 发放二级分销商佣金
        $model['second_user_id'] > 0 && User::grantMoney($model['second_user_id'], $model['second_money'], $order_id);
        // 发放三级分销商佣金
        $model['third_user_id'] > 0 && User::grantMoney($model['third_user_id'], $model['third_money'], $order_id);
        return $model->save(['is_settled' => 1, 'settle_time' => time()]);
    }
	 /**
     * 订单列表
     * @param null $user_id
     * @param int $is_settled
     * @param string $search
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($user_id = null, $is_settled = -1, $search = '')
    {
        // 构建查询规则
        $this->alias('master')->field('master.*')
            ->with([
                'orderMaster' => ['item.image', 'address', 'user'],
                'agent_first.user',
                'agent_second.user',
                'agent_third.user'
            ])
            ->join('order', 'order.order_id = master.order_id')
            ->order(['create_time' => 'desc']);
        // 查询条件
        $user_id > 1 && $this->where('master.first_user_id|master.second_user_id|master.third_user_id', '=', (int)$user_id);
        $is_settled > -1 && $is_settled !== '' && $this->where('master.is_settled', '=', (int)$is_settled);
        !empty($search) && $this->where('order.order_no', 'like', "%$search%");
        // 获取列表数据
        return $this->paginate(10, false, [
            'query' => \request()->request()
        ]);
    }
	/**
     * 获取分销商订单列表
     * @param $user_id
     * @param int $is_settled
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList6($user_id, $is_settled = -1)
    {
        $this->with(['user', 'orderMaster'])
            ->where('first_user_id|second_user_id|third_user_id', '=', $user_id);
        $is_settled > -1 && $this->where('is_settled', '=', !!$is_settled);
        return $this->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }
    /**
     * 创建分销商订单记录
     * @param $order
     * @param $item_list
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public static function createOrder(&$order, &$item_list)
    {
        // 分销订单模型
        $model = new self;
        // 分销商基本设置
        $setting = Setting::getItem('basic');
        // 是否开启分销功能
        if (!$setting['is_open']) return false;
        // 计算分销信息
        $commission = $model->commissions($order['user_id'], $item_list, $setting['level']);
        // 非分销订单
        if (!$commission['first_user_id']) {
            return false;
        }
        // 订单总金额(不含运费)
        $orderPrice = bcsub($order['pay_price'], $order['express_price'], 2);
        // 保存分销订单记录
        return $model->save([
            'user_id' => $order['user_id'],
            'order_id' => $order['order_id'],
            'order_no' => $order['order_no'],
            'order_price' => $orderPrice,
            'first_user_id' => $commission['first_user_id'],
            'second_user_id' => $commission['second_user_id'],
            'third_user_id' => $commission['third_user_id'],
            'first_money' => max($commission['first_money'], 0),
            'second_money' => max($commission['second_money'], 0),
            'third_money' => max($commission['third_money'], 0),
            'is_settled' => 0,
            'app_id' => $model::$app_id
        ]);
    }
    /**
     * 计算分销总佣金
     * @param $user_id
     * @param $item_list
     * @param $level
     * @return array
     * @throws \think\exception\DbException
     */
    private function commissions($user_id, $item_list, $level)
    {
        // 佣金设置
        $setting = Setting::getItem('commission');
        $data = [
            'first_money' => 0.00,  // 一级分销佣金
            'second_money' => 0.00, // 二级分销佣金
            'third_money' => 0.00   // 三级分销佣金
        ];
        // 计算分销佣金
        foreach ($item_list as $Item) {
            $level >= 1 && $data['first_money'] += ($Item['total_pay_price'] * ($setting['first_money'] * 0.01));
            $level >= 2 && $data['second_money'] += ($Item['total_pay_price'] * ($setting['second_money'] * 0.01));
            $level == 3 && $data['third_money'] += ($Item['total_pay_price'] * ($setting['third_money'] * 0.01));
        }
        // 记录分销商用户id
        $data['first_user_id'] = $level >= 1 ? Referee::getRefereeUserId($user_id, 1, true) : 0;
        $data['second_user_id'] = $level >= 2 ? Referee::getRefereeUserId($user_id, 2, true) : 0;
        $data['third_user_id'] = $level == 3 ? Referee::getRefereeUserId($user_id, 3, true) : 0;
        return $data;
    }
}