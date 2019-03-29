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
use think\facade\Cache;
/**
 * 系统设置模型
 * Class Setting
 * @package app\common\model
 */
class Setting extends BaseModel
{
    protected $name = 'setting';
	protected $pk = 'id';
    protected $createTime = false;
    /**
     * 获取器: 转义数组格式
     * @param $value
     * @return mixed
     */
    public function getValuesAttr($value)
    {
        return json_decode($value, true);
    }
    /**
     * 修改器: 转义成json格式
     * @param $value
     * @return string
     */
    public function setValuesAttr($value)
    {
        return json_encode($value);
    }
    /**
     * 获取指定项设置
     * @param $key
     * @param $app_id
     * @return array
     */
    public static function getItem($key, $app_id = null)
    {
        $data = self::getAll($app_id);
        return isset($data[$key]) ? $data[$key]['values'] : [];
    }
    /**
     * 获取设置项信息
     * @param $key
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($key)
    {
        return self::get(compact('key'));
    }
    /**
     * 全局缓存: 系统设置
     * @param null $app_id
     * @return array|mixed
     */
    public static function getAll($app_id = null)
    {
        $self = new static;
        is_null($app_id) && $app_id = $self::$app_id;
        if (!$data = Cache::get('setting_' . $app_id)) {
            $data = array_column($self::all()->toArray(), null, 'key');
            Cache::set('setting_' . $app_id, $data);
        }
        return array_merge_multiple($self->defaultData(), $data);
    }
    /**
     * 默认配置
     * @return array
     */
    public function defaultData()
    {
		
        return [
            'store' => [
                'key' => 'store',
                'describe' => '商城设置',
                'values' => [
                    'name' => '小程序商城',
                    'kuaidi100' => [
                        'customer' => '',
                        'key' => '',
                    ]
                ],
            ],
            'trade' => [
                'key' => 'trade',
                'describe' => '交易设置',
                'values' => [
                    'order' => [
                        'close_days' => '0',
                        'receive_days' => '15',
                        'refund_days' => '0'
                    ],
                    'freight_rule' => '10',
                ]
            ],
            'storage' => [
                'key' => 'storage',
                'describe' => '上传设置',
                'values' => [
                    'default' => 'local',
                    'engine' => [
                        'qiniu' => [
                            'bucket' => '',
                            'access_key' => '',
                            'secret_key' => '',
                            'domain' => 'http://'
                        ],
                        'aliyun' => [
                            'bucket' => '',
                            'access_key_id' => '',
                            'access_key_secret' => '',
                            'domain' => 'http://'
                        ],
                        'qcloud' => [
                            'bucket' => '',
                            'region' => '',
                            'secret_id' => '',
                            'secret_key' => '',
                            'domain' => 'http://'
                        ],
                    ]
                ],
            ],
            'sms' => [
                'key' => 'sms',
                'describe' => '短信通知',
                'values' => [
                    'default' => 'aliyun',
                    'engine' => [
                        'aliyun' => [
                            'AccessKeyId' => '',
                            'AccessKeySecret' => '',
                            'sign' => '科技',
                            'order_pay' => [
                                'is_enable' => '0',
                                'template_code' => '',
                                'accept_phone' => '',
                            ],
                        ],
                    ],
                ],
            ],
            'tplMsg' => [
                'key' => 'tplMsg',
                'describe' => '模板消息',
                'values' => [
                    'payment' => [
                        'is_enable' => '0',
                        'template_id' => '',
                    ],
                    'delivery' => [
                        'is_enable' => '0',
                        'template_id' => '',
                    ]
                ],
            ],
        ];
    }
	/**
     * 设置项描述
     * @var array
     */
    private $describe = [
        'store' => '商城设置',
        'trade' => '交易设置',
        'sms' => '短信通知',
        'tplMsg' => '模板消息',
        'storage' => '上传设置',
    ];
    /**
     * 更新系统设置
     * @param $key
     * @param $values
     * @return bool
     * @throws \think\exception\DbException
     */
    public function edit($key, $values)
    {
        $model = self::detail($key) ?: $this;
		
        // 删除系统设置缓存
        Cache::rm('setting_' . self::$app_id);
        return $model->save([
            'key' => $key,
            'describe' => $this->describe[$key],
            'values' => $values,
            'app_id' => self::$app_id,
        ]) !== false ?: false;
    }
}