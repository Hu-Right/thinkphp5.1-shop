<?
// +----------------------------------------------------------------------
// | User 
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
namespace app\user\controller;
use app\common\library\sms\Driver as SmsDriver;
use app\common\model\Setting as SettingModel;
/**
 * 系统设置
 * Class Setting
 * @package app\user\controller
 */
class Setting extends Controller
{
    /**
     * 商城设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function store()
    {
		
        return $this->updateEvent('store');
    }
    /**
     * 交易设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function trade()
    {
        return $this->updateEvent('trade');
    }
    /**
     * 短信通知
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function sms()
    {
        return $this->updateEvent('sms');
    }
    /**
     * 模板消息
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function tplMsg()
    {
        return $this->updateEvent('tplMsg');
    }
    /**
     * 发送短信通知测试
     * @param $AccessKeyId
     * @param $AccessKeySecret
     * @param $sign
     * @param $msg_type
     * @param $template_code
     * @param $accept_phone
     * @return array
     * @throws \think\Exception
     */
    public function smsTest($AccessKeyId, $AccessKeySecret, $sign, $msg_type, $template_code, $accept_phone)
    {
        $SmsDriver = new SmsDriver([
            'default' => 'aliyun',
            'engine' => [
                'aliyun' => [
                    'AccessKeyId' => $AccessKeyId,
                    'AccessKeySecret' => $AccessKeySecret,
                    'sign' => $sign,
                    $msg_type => compact('template_code', 'accept_phone'),
                ],
            ],
        ]);
        $templateParams = [];
        if ($msg_type === 'order_pay') {
            $templateParams = ['order_no' => '2018071200000000'];
        }
        if ($SmsDriver->sendSms($msg_type, $templateParams, true)) {
            return $this->renderSuccess('发送成功');
        }
        return $this->renderError('发送失败 ' . $SmsDriver->getError());
    }
    /**
     * 上传设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function storage()
    {
		
        return $this->updateEvent('storage');
    }
    /**
     * 更新商城设置事件
     * @param $key
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    private function updateEvent($key)
    {	
		
        if (!$this->request->isAjax()) {
		
            $values = SettingModel::getItem($key);
            return $this->fetch($key, compact('values'));
        }
        $model = new SettingModel;
        if ($model->edit($key, $this->postData($key))) {
            return $this->renderSuccess('更新成功');
        }
        return $this->renderError('更新失败');
    }
}