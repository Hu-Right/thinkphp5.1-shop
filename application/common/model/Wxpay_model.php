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
/**
 * 手机端微信支付，此处是授权获取到code时的回调地址
 * @param  [type] $orderId 订单编号id
 * @return [type]          [description]
 */
public function confirm($orderId) {
    //先确认用户是否登录
    $this->ensureLogin();
    //通过订单编号获取订单数据
    $order = $this->wxpay_model->get($orderId);
    //验证订单是否是当前用户
    $this->_verifyUser($order);
    //取得支付所需要的订单数据
    $orderData = $this->returnOrderData[$orderId];
    //取得jsApi所需要的数据
    $wxJsApiData = $this->wxpay_model->wxPayJsApi($orderData);
    //将数据分配到模板去，在js里使用
    $this->smartyData['wxJsApiData'] = json_encode($wxJsApiData, JSON_UNESCAPED_UNICODE);
    $this->smartyData['order'] = $orderData;
    $this->displayView('wxpay/confirm.tpl');
}