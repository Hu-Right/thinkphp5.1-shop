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
use app\common\model\AppPrepayId as AppPrepayIdModel;
/**
 * 小程序prepay_id模型
 * Class AppPrepayId
 * @package app\task\model
 */
class AppPrepayId extends AppPrepayIdModel
{
    /**
     * 更新prepay_id已付款状态
     * @return false|int
     */
    public function updatePayStatus()
    {
        return $this->save([
            'can_use_times' => 3,
            'pay_status' => 1
        ]);
    }
}