<?
// +----------------------------------------------------------------------
// | API 
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
namespace weixinpayApp;
use app\common\model\Order as OrderModel;
use app\common\model\App as AppModel;
use app\common\model\Cart as CartModel;
use app\common\model\AppPrepayId as AppPrepayIdModel;
use app\common\library\wechat\WxPay;
require_once '../extend/lib/Alipays.php';
class wxh5{
    //$data 金额和订单号
    public function wxh5Request($data){
        $appid = 'wx1ff41ed2d337fdde';
        $mch_id = '1225065902';//商户号
        $key = '27c3bf6e8a90568d54509d3a9f5ebba1';//商户key
        $notify_url = "https://ccd.iirr5.com/index.php?s=/user/app/setting.html";//回调地址
        $wechatAppPay = new \wechatAppPay($appid, $mch_id, $notify_url, $key);
        $params['body'] = '估价啦';                       //商品描述
        $params['out_trade_no'] = $data['oid'];    //自定义的订单号
        $params['total_fee'] = '1';                       //订单金额 只能为整数 单位为分
        $params['trade_type'] = 'MWEB';                   //交易类型 JSAPI | NATIVE | APP | WAP
        $params['scene_info'] = '{"h5_info": {"type":"Wap","wap_url": "https://ccd.iirr5.com/wap/orders.html","wap_name": "估价啦"}}';
        $result = $wechatAppPay->unifiedOrder( $params );
        $url = $result['mweb_url'].'&redirect_url=https://ccd.iirr5.com/wap/orders-payment.html';//redirect_url 是支付完成后返回的页面
        return $url;
    }
    public function cart($cart_ids, $coupon_id = null, $remark = '')
    {
        // 商品结算信息
        $Card = new CartModel($this->user['user_id']);
        $order = $Card->getList($this->user, $cart_ids);
        if (!$this->request->isPost()){
            return $this->renderSuccess($order);
        }
        // 创建订单
        $model = new OrderModel;
        if ($model->createOrder($this->user['user_id'], $order, $coupon_id, $remark)) {
            // 移出购物车中已下单的商品
            $Card->clearAll($cart_ids);
            // 发起微信支付
            return $this->renderSuccess([
                'payment' => $this->wxh5Request($model),
                'order_id' => $model['order_id']
            ]);
        }
        return $this->renderError($model->getError() ?: '订单创建失败');
    }
    public function wxPayNotify($xml) {
        $notify = new Wxpay_server();
        $notify->saveData($xml);
        //验证签名，并回复微信
        //对后台通知交互时，如果微信收到商户的应答不是成功或者超时，微信认为通知失败
        //微信会通过一定的策略（如30分钟共8次），定期重新发起通知
        if ($notify->checkSign() == false) {
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        } else {
            $notify->checkSign=TRUE;
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        return $notify;
    }
    public function pay_callback() {
        $postData = '';
        if (file_get_contents("php://input")) {
            $postData = file_get_contents("php://input");
        } else {
            return;
        }
        $payInfo = array();
        $notify = $this->wxpay_model->wxPayNotify($postData);
        if ($notify->checkSign == TRUE) {
            if ($notify->data['return_code'] == 'FAIL') {
                $payInfo['status'] = FALSE;
                $payInfo['msg'] = '通信出错';
            } elseif ($notify->data['result_code'] == 'FAIL') {
                $payInfo['status'] = FALSE;
                $payInfo['msg'] = '业务出错';
            } else {
                $payInfo['status'] = TRUE;
                $payInfo['msg'] = '支付成功';
                $payInfo['sn']=substr($notify->data['out_trade_no'],8);
                $payInfo['order_no'] = $notify->data['out_trade_no'];
                $payInfo['platform_no']=$notify->data['transaction_id'];
                $payInfo['attach']=$notify->data['attach'];
                $payInfo['fee']=$notify->data['cash_fee'];
                $payInfo['currency']=$notify->data['fee_type'];
                $payInfo['user_sign']=$notify->data['openid'];
            }
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;
        $this->load->library('RedisCache');
        if($payInfo['status']){
            //这里要记录到日志处理（略）
            $this->model->order->onPaySuccess($payInfo['sn'], $payInfo['order_no'], $payInfo['platform_no'],'', $payInfo['user_sign'], $payInfo);
            $this->redis->RedisCache->set('order:payNo:'.$payInfo['order_no'],'OK',5000);
        }else{
            //这里要记录到日志处理（略）
            $this->model->order->onPayFailure($payInfo['sn'], $payInfo['order_no'], $payInfo['platform_no'],'', $payInfo['user_sign'], $payInfo, '订单支付失败 ['.$payInfo['msg'].']');
        }
    }
}