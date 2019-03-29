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
namespace app\common\library\wechat;
use app\common\exception\BaseException;
/**
 * 小程序二维码
 * Class Qrcode
 * @package app\common\library\wechat
 */
class Qrcode extends WxBase
{
    /**
     * 获取小程序码
     * @param $scene
     * @param null $page
     * @param int $width
     * @return mixed
     * @throws BaseException
     */
    public function getQrcode($scene, $page = null, $width = 430)
    {
        // 微信接口url
        $access_token = $this->getAccessToken();
		
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$access_token}";
        // 构建请求
        $data = compact('scene', 'width');
        !is_null($page) && $data['page'] = $page;
        // 返回结果
        $result = $this->post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
	
        // 记录日志
        log_write([
            'describe' => '获取小程序码',
            'params' => $data,
            'result' => strpos($result, 'errcode') ? $result : 'image'
        ]);
        if (strpos($result, 'errcode')) {
            $data = json_decode($result, true);
            throw new BaseException(['msg' => '小程序码获取失败 ' . $data['errmsg']]);
        }
        return $result;
    }
}