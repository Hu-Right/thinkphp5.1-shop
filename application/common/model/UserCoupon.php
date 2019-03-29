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
use think\facade\Hook;
use think\Db;
/**
 * 用户优惠券模型
 * Class UserCoupon
 * @package app\common\model
 */
class UserCoupon extends BaseModel
{
    protected $name = 'user_coupon';
    /**
     * 追加字段
     * @var array
     */
    protected $append = ['state'];
    /**
     * 订单模型初始化
     */
    public static function init()
    {
        parent::init();
        // 监听优惠券处理事件
        $static = new static;
        Hook::listen('UserCoupon', $static);
    }
    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
    /**
     * 优惠券状态
     * @param $value
     * @param $data
     * @return array
     */
    public function getStateAttr($value, $data)
    {
        if ($data['is_use']) {
            return ['text' => '已使用', 'value' => 0];
        }
        if ($data['is_expire']) {
            return ['text' => '已过期', 'value' => 0];
        }
        return ['text' => '', 'value' => 1];
    }
    /**
     * 优惠券颜色
     * @param $value
     * @return mixed
     */
    public function getColorAttr($value)
    {
        $status = [10 => 'blue', 20 => 'red', 30 => 'violet', 40 => 'yellow'];
        return ['text' => $status[$value], 'value' => $value];
    }
    /**
     * 优惠券类型
     * @param $value
     * @return mixed
     */
    public function getCouponTypeAttr($value)
    {
        $status = [10 => '满减券', 20 => '折扣券'];
        return ['text' => $status[$value], 'value' => $value];
    }
    /**
     * 折扣率
     * @param $value
     * @return mixed
     */
    public function getDiscountAttr($value)
    {
        return $value / 10;
    }
    /**
     * 有效期-开始时间
     * @param $value
     * @return mixed
     */
    public function getStartTimeAttr($value)
    {
        return ['text' => date('Y/m/d', $value), 'value' => $value];
    }
    /**
     * 有效期-结束时间
     * @param $value
     * @return mixed
     */
    public function getEndTimeAttr($value)
    {
        return ['text' => date('Y/m/d', $value), 'value' => $value];
    }
    /**
     * 优惠券详情
     * @param $coupon_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($coupon_id)
    {
        return self::get($coupon_id);
    }
	 /**
     * 获取优惠券列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->with(['user'])
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
    }
/**
     * 获取用户优惠券列表
     * @param $user_id
     * @param false $is_use
     * @param bool $is_expire
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListapi($user_id, $is_use = false, $is_expire = false)
    {
        return $this->where('user_id', '=', $user_id)
            ->where('is_use', '=', $is_use ? 1 : 0)
            ->where('is_expire', '=', $is_expire ? 1 : 0)
            ->select();
    }
    /**
     * 获取用户优惠券ID集
     * @param $user_id
     * @return array
     */
    public function getUserCouponIds($user_id)
    {
        return $this->where('user_id', '=', $user_id)->column('coupon_id');
    }
    /**
     * 领取优惠券
     * @param $user
     * @param $coupon_id
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public function receive($user, $coupon_id)
    {
        // 获取优惠券信息
        $coupon = Coupon::detail($coupon_id);
        // 验证优惠券是否可领取
        if (!$this->checkReceive($user, $coupon)) {
            return false;
        }
        // 添加领取记录
        return $this->add($user, $coupon);
    }
    /**
     * 添加领取记录
     * @param $user
     * @param Coupon $coupon
     * @return bool
     */
    private function add($user, $coupon)
    {
        // 计算有效期
        if ($coupon['expire_type'] === 10) {
            $start_time = time();
            $end_time = $start_time + ($coupon['expire_day'] * 86400);
        } else {
            $start_time = $coupon['start_time']['value'];
            $end_time = $coupon['end_time']['value'];
        }
        Db::startTrans();
        try {
            // 添加领取记录
            $this->save([
                'coupon_id' => $coupon['coupon_id'],
                'name' => $coupon['name'],
                'color' => $coupon['color']['value'],
                'coupon_type' => $coupon['coupon_type']['value'],
                'reduce_price' => $coupon['reduce_price'],
                'discount' => $coupon->getData('discount'),
                'min_price' => $coupon['min_price'],
                'expire_type' => $coupon['expire_type'],
                'expire_day' => $coupon['expire_day'],
                'start_time' => $start_time,
                'end_time' => $end_time,
                'apply_range' => $coupon['apply_range'],
                'user_id' => $user['user_id'],
                'app_id' => self::$app_id
            ]);
            // 更新优惠券领取数量
            $coupon->setIncReceiveNum();
            Db::commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            Db::rollback();
            return false;
        }
    }
    /**
     * 验证优惠券是否可领取
     * @param $user
     * @param Coupon $coupon
     * @return bool
     */
    private function checkReceive($user, $coupon)
    {
        if (!$coupon) {
            $this->error = '优惠券不存在';
            return false;
        }
        if (!$coupon->checkReceive()) {
            $this->error = $coupon->getError();
            return false;
        }
        // 验证是否已领取
        $userCouponIds = $this->getUserCouponIds($user['user_id']);
        if (in_array($coupon['coupon_id'], $userCouponIds)) {
            $this->error = '该优惠券已领取';
            return false;
        }
        return true;
    }
    /**
     * 订单结算优惠券列表
     * @param $user_id
     * @param $orderPayPrice
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getUserCouponList($user_id, $orderPayPrice)
    {
        $list = (new self)->getListapi($user_id);
        $data = [];
        foreach ($list as $coupon) {
            // 最低消费金额
            if ($orderPayPrice < $coupon['min_price']) continue;
            // 有效期范围内
            if ( $coupon['start_time']['value'] > time()) continue;
            $key = $coupon['user_coupon_id'];
            $data[$key] = [
                'user_coupon_id' => $coupon['user_coupon_id'],
                'name' => $coupon['name'],
                'color' => $coupon['color'],
                'coupon_type' => $coupon['coupon_type'],
                'reduce_price' => $coupon['reduce_price'],
                'discount' => $coupon['discount'],
                'min_price' => $coupon['min_price'],
                'expire_type' => $coupon['expire_type'],
                'start_time' => $coupon['start_time'],
                'end_time' => $coupon['end_time'],
            ];
            // 计算打折金额
            if ($coupon['coupon_type']['value'] === 20) {
                $reduce_price = $orderPayPrice * ($coupon['discount'] / 10);
                $data[$key]['reduced_price'] = bcsub($orderPayPrice, $reduce_price, 2);
            } else
                $data[$key]['reduced_price'] = $coupon['reduce_price'];
        }
        return array_sort($data, 'reduced_price', true);
    }
    /**
     * 设置优惠券为已使用
     * @return false|int
     */
    public function setIsUse()
    {
        return $this->save(['is_use' => 1]);
    }
}