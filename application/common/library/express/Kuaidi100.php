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
namespace app\common\library\express;
use think\facade\Cache;
/**
 * 快递100API模块
 * Class Kuaidi100
 * @package app\common\library\express
 */
class Kuaidi100
{
    /* @var array $config 微信支付配置 */
    private $config;
    /* @var string $error 错误信息 */
    private $error;
    /**
     * 构造方法
     * WxPay constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }
    /**
     * 执行查询
     * @param $express_code
     * @param $express_no
     * @return bool
     */
    public function query($express_code, $express_no)
    {
        // 缓存索引
        $cacheIndex = 'express_' . $express_code . '_' . $express_no;
        if ($data = Cache::get($cacheIndex)) {
            return $data;
        }
        // 参数设置
        $postData = [
            'customer' => $this->config['customer'],
            'param' => json_encode([
                'resultv2' => '1',
                'com' => $express_code,
                'num' => $express_no
            ])
        ];
        $postData['sign'] = strtoupper(md5($postData['param'] . $this->config['key'] . $postData['customer']));
        // 请求快递100 api
        $url = 'http://poll.kuaidi100.com/poll/query.do';
        $result = curlPost($url, http_build_query($postData));
        $express = json_decode($result, true);
        // 记录错误信息
        if (isset($express['returnCode']) || !isset($express['data'])) {
            $this->error = isset($express['message']) ? $express['message'] : '查询失败';
            return false;
        }
        // 记录缓存, 时效5分钟
        Cache::set($cacheIndex, $express['data'], 300);
        return $express['data'];
    }
    /**
     * 返回错误信息
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}