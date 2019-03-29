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
/**
 * 微信模板消息
 * Class WxTplMsg
 * @package app\common\library\wechat
 */
class WxTplMsg extends WxBase
{
    /**
     * 发送模板消息
     * @param $params
     * @return bool
     */
    public function sendTemplateMessage($params)
    {
		
        // 微信接口url
        $access_token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
        // 构建请求
		
        $data = [
            'touser' => $params['touser'],
            'template_id' => $params['template_id'],
            'page' => $params['page'],
            'form_id' => $params['form_id'],
            'data' => $this->createData($params['data'])
        ];
	
        $result = $this->post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
        // 记录日志
        log_write([
            'params' => $data,
            'result' => $result
        ]);
        // 返回结果
        $response = json_decode($result, true);
		
        if (!isset($response['errcode'])) {
            $this->error = 'not found errcode';
            return false;
        }
        if ($response['errcode'] != 0) {
            $this->error = $response['errmsg'];
            return false;
        }
        return true;
    }
    /**
     * 生成关键字数据
     * @param $data
     * @return array
     */
    private function createData($data)
    {
        $params = [];
        foreach ($data as $key => $value) {
            $params[$key] = [
                'value' => $value,
                'color' => '#333333'
            ];
        }
        return $params;
    }
}