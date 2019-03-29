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
namespace app\common\model\app;
use app\common\model\BaseModel;
/**
 * form_id 模型
 * Class Apply
 * @package app\common\model\agent
 */
class Formid extends BaseModel
{
    protected $name = 'app_formid';
    /**
     * 获取一个可用的formid
     * @param $user_id
     * @return array|false|\PDOStatement|string|\think\Model|static
     */
    public static function getAvailable($user_id)
    {
        return (new static)->where([
            'user_id' => $user_id,
            'is_used' => 0,
            'expiry_time' => ['>=', time()]
        ])->order(['create_time' => 'asc'])->find();
    }
	/**
     * 新增form_id
     * @param $user_id
     * @param $form_id
     * @return false|int
     */
    public static function add($user_id, $form_id)
    {
        $model = new self;
        return $model->save([
            'user_id' => $user_id,
            'form_id' => $form_id,
            'expiry_time' => time() + (7 * 86400) - 10,
            'app_id' => self::$app_id
        ]);
    }
    /**
     * 设置为已使用
     * @return false|int
     */
    public function setIsUsed()
    {
        return $this->save(['is_used' => 1]);
    }
}