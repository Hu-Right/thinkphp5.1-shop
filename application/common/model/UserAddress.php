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
use app\common\model\Region;
/**
 * 用户收货地址模型
 * Class UserAddress
 * @package app\common\model
 */
class UserAddress extends BaseModel
{
    protected $name = 'user_address';
	protected $pk = 'address_id';
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
     * 追加字段
     * @var array
     */
    protected $append = ['region'];
    /**
     * 地区名称
     * @param $value
     * @param $data
     * @return array
     */
    public function getRegionAttr($value, $data)
    {
        return [
            'province' => Region::getNameById($data['province_id']),
            'city' => Region::getNameById($data['city_id']),
            'region' => Region::getNameById($data['region_id']),
        ];
    }
	/**
     * @param $user_id
     * @return false|static[]
     * @throws \think\exception\DbException
     */
    public function getList($user_id)
    {
        return self::all(compact('user_id'));
    }
    /**
     * 新增收货地址
     * @param null|static $user
     * @param $data
     * @return false|int
     */
    public function add($user, $data)
    {
		
        // 添加收货地址
        $region = explode(',', $data['region']);
        $province_id = Region::getIdByName($region[0], 1);
        $city_id = Region::getIdByName($region[1], 2, $province_id);
        $region_id = Region::getIdByName($region[2], 3, $city_id);
        $this->allowField(true)->save(array_merge([
            'user_id' => $user['user_id'],
            'app_id' => self::$app_id,
            'province_id' => $province_id,
            'city_id' => $city_id,
            'region_id' => $region_id,
        ], $data));
        // 设为默认收货地址
        !$user['address_id'] && $user->save(['address_id' => $this->getLastInsID()]);
        return true;
    }
    /**
     * 编辑收货地址
     * @param $data
     * @return false|int
     */
    public function edit($data)
    {
        // 添加收货地址
        $region = explode(',', $data['region']);
        $province_id = Region::getIdByName($region[0], 1);
        $city_id = Region::getIdByName($region[1], 2, $province_id);
        $region_id = Region::getIdByName($region[2], 3, $city_id);
        return $this->allowField(true)
            ->save(array_merge(compact('province_id', 'city_id', 'region_id'), $data));
    }
    /**
     * 设为默认收货地址
     * @param null|static $user
     * @return int
     */
    public function setDefault($user)
    {
        // 设为默认地址
        return $user->save(['address_id' => $this['address_id']]);
    }
    /**
     * 删除收货地址
     * @param null|static $user
     * @return int
     */
    public function remove($user)
    {
        // 查询当前是否为默认地址
        $user['address_id'] === $this['address_id'] && $user->save(['address_id' => 0]);
        return $this->delete();
    }
    /**
     * 收货地址详情
     * @param $user_id
     * @param $address_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($user_id, $address_id)
    {
        return self::get(compact('user_id', 'address_id'));
    }
}