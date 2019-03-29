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
 * 小程序prepay_id模型
 * Class appPrepayId
 * @package app\common\model
 */
class AppPrepayId extends BaseModel
{
    protected $pk = 'app_prepay_id';
    /**
     * prepay_id 详情
     * @param $order_id
     * @return array|false|static|string|\think\Model
     */
    public static function detail($order_id)
    {
        return (new static)->where(['order_id' => $order_id])
            ->order(['create_time' => 'desc'])->find();
    }
    /**
     * 记录prepay_id使用次数
     * @return int|true
     * @throws \think\Exception
     */
    public function updateUsedTimes()
    {
        return $this->setInc('used_times', 1);
    }
	/**
     * 新增记录
     * @param $prepay_id
     * @param $order_id
     * @param $user_id
     * @return false|int
     */
    public function add($prepay_id, $order_id, $user_id)
    {
		
        return $this->save([
            'prepay_id' => $prepay_id,
            'order_id' => $order_id,
            'user_id' => $user_id,
            'can_use_times' => 0,
            'used_times' => 0,
            'app_id' => self::$app_id,
            'expiry_time' => time() + (7 * 86400)
        ]);
    }
}