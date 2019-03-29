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
use app\common\model\UserCoupon as UserCouponModel;
/**
 * 用户优惠券模型
 * Class UserCoupon
 * @package app\task\model
 */
class UserCoupon extends UserCouponModel
{
    /**
     * 获取已过期的优惠券ID集
     * @return array
     */
    public function getExpiredCouponIds()
    {
        $time = time();
        return $this->where('is_expire', '=', 0)
            ->where('is_use', '=', 0)
            ->where(
                "IF ( `expire_type` = 20,
                    (`end_time` + 86400) < {$time},
                    ( `create_time` + (`expire_day` * 864000)) < {$time} )"
            )->column('user_coupon_id');
    }
    /**
     * 设置优惠券过期状态
     * @param $couponIds
     * @return false|int
     */
    public function setIsExpire($couponIds)
    {
        return $this->isUpdate(true)
            ->save(['is_expire' => 1], ['user_coupon_id' => ['in', $couponIds]]);
    }
}