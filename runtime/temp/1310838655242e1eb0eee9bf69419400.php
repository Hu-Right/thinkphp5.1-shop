<?php /*a:2:{s:70:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\setting\sms.html";i:1542624660;s:65:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layout.html";i:1543209671;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?php echo htmlentities($setting['store']['values']['name']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="/assets/user/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="<?php echo htmlentities($setting['store']['values']['name']); ?>"/>
    <link rel="stylesheet" href="/assets/layer/theme/default/layer.css"/>
    <link rel="stylesheet" href="/assets/user/css/app.css"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_oo2lzo85b4.css">
    <script src="/assets/user/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_783249_e5yrsf08rap.js"></script>
    <script>
        BASE_URL = '<?php echo htmlentities($base_url); ?>';
        STORE_URL = '/index.php?s=/user';
		
    </script>
</head>

<body data-type="">
<div class="layer-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <div class="layer-fl tpl-header-button switch-button">
                <i class="iconfont icon-menufold"></i>
            </div>
            <!-- 刷新页面 -->
            <div class="layer-fl tpl-header-button refresh-button">
                <i class="iconfont icon-refresh"></i>
            </div>
         
			
            <!-- 其它功能-->
            <div class="layer-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="layer-text-sm tpl-header-navbar-welcome">
                        <a href="<?php echo url("","",true,false);?>">欢迎你，<span><?php echo htmlentities($store['user']['user_name']); ?></span>
                        </a>
                    </li>
                    <!-- 退出 -->
                    <li class="layer-text-sm">
                        <a href="<?php echo url('user/login/logout'); ?>">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 侧边导航栏 -->
    <div class="left-sidebar dis-flex">
        <!-- 一级菜单 <?php echo htmlentities($setting['store']['values']['name']); ?>-->
        <ul class="sidebar-nav">
            <li class="sidebar-nav-heading"><img src="/assets/user/img/logo.png" width="60" /></li>
           
		  <?php foreach($menus as $key=>$item): ?> 
                <li class="sidebar-nav-link">
                    <a href="<?= isset($item['index']) ? url($item['index']) : 'javascript:void(0);' ?>"
                       class="<?php echo !empty($item['active']) ? 'active'  :  ''; ?>">
                        
                            <i class="iconfont sidebar-nav-link-logo <?php echo htmlentities($item['icon']); ?>"></i>
                     
                        <?php echo htmlentities($item['name']); ?>
                    </a>
                </li>
			<?php endforeach; ?>
        </ul>
        <!-- 子级菜单-->
       <?php $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; if(!empty($second)): ?>
            <ul class="left-sidebar-second">
                <li class="sidebar-second-title"><?php echo htmlentities($menus[$group]['name']); ?></li>
                <li class="sidebar-second-item">
                   
					<?php if(is_array($second) || $second instanceof \think\Collection || $second instanceof \think\Paginator): $i = 0; $__LIST__ = $second;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;if(!isset($item['submenu'])): ?>
                            <!-- 二级菜单-->
                            <a href="<?php echo url($item['index']); ?>" class="<?php echo !empty($item['active']) ? 'active'  :  ''; ?>">
                                <?php echo htmlentities($item['name']); ?>
                            </a>
                        <?php else: ?>
                            <!-- 三级菜单-->
                            <div class="sidebar-third-item">
                                <a href="javascript:void(0);"
                                   class="sidebar-nav-sub-title <?php echo !empty($item['active']) ? 'active'  :  ''; ?>">
                                    <i class="iconfont icon-caret"></i>
                                    <?php echo htmlentities($item['name']); ?>
                                </a>
                                <ul class="sidebar-third-nav-sub">
									<?php if(is_array($item['submenu']) || $item['submenu'] instanceof \think\Collection || $item['submenu'] instanceof \think\Paginator): $i = 0; $__LIST__ = $item['submenu'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$third): $mod = ($i % 2 );++$i;?>
                                        <li>
                                            <a class="<?php echo !empty($third['active']) ? 'active'  :  ''; ?>"
                                               href="<?php echo url($third['index']); ?>">
                                                <?php echo htmlentities($third['name']); ?></a>
                                        </li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            </div>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper <?php if($second == null): ?>no-sidebar-second<?php endif; ?>">
        <div class="row-content layer-cf">
    <div class="row">
        <div class="layer-u-sm-12 layer-u-md-12 layer-u-lg-12">
            <div class="widget layer-cf widget-bff">
                <form id="my-form" class="layer-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head layer-cf">
                                <div class="widget-title layer-fl">短信通知（阿里云短信）</div>
                            </div>
                            <input type="hidden" name="sms[default]" value="aliyun">
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require"> AccessKeyId </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="tpl-form-input" name="sms[engine][aliyun][AccessKeyId]"
                                           value="<?php echo htmlentities($values['engine']['aliyun']['AccessKeyId']); ?>" required>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require"> AccessKeySecret </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="tpl-form-input"
                                           name="sms[engine][aliyun][AccessKeySecret]"
                                           value="<?php echo htmlentities($values['engine']['aliyun']['AccessKeySecret']); ?>" required>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require"> 短信签名 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="tpl-form-input" name="sms[engine][aliyun][sign]"
                                           value="<?php echo htmlentities($values['engine']['aliyun']['sign']); ?>" required>
                                </div>
                            </div>
                            <div class="widget-head layer-cf">
                                <div class="widget-title layer-fl">新付款订单提醒</div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">
                                    是否开启短信提醒
                                </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="sms[engine][aliyun][order_pay][is_enable]" value="1"
                                               data-layer-ucheck
                                            <?php echo $values['engine']['aliyun']['order_pay']['is_enable']==='1' ? 'checked'  :  ''; ?>
                                               required>
                                        开启
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="sms[engine][aliyun][order_pay][is_enable]" value="0"
                                               data-layer-ucheck
                                            <?php echo $values['engine']['aliyun']['order_pay']['is_enable']==='0' ? 'checked'  :  ''; ?>>
                                        关闭
                                    </label>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">
                                    模板ID <span class="tpl-form-line-small-title">Template Code</span>
                                </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="tpl-form-input"
                                           name="sms[engine][aliyun][order_pay][template_code]"
                                           value="<?php echo htmlentities($values['engine']['aliyun']['order_pay']['template_code']); ?>">
                                    <small>例如：SMS_139800030</small>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <div class="layer-u-sm-9 layer-u-sm-push-3">
                                    <small>模板内容：您有一条新订单，订单号为：${order_no}，请注意查看。</small>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require"> 接收手机号 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="tpl-form-input"
                                           name="sms[engine][aliyun][order_pay][accept_phone]"
                                           value="<?php echo htmlentities($values['engine']['aliyun']['order_pay']['accept_phone']); ?>">
                                    <div class="help-block">
                                        <small>接收测试： <a class="j-sendTestMsg" data-msg-type="order_pay"
                                                        href="javascript:void(0);">点击发送</a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <div class="layer-u-sm-9 layer-u-sm-push-3 layer-margin-top-lg">
                                    <button type="submit" class="j-submit layer-btn layer-btn-secondary">提交
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

        /**
         * 发送测试短信
         */
        $('.j-sendTestMsg').click(function () {
            var msgType = $(this).data('msg-type')
                , formData = {
                AccessKeyId: $('input[name="sms[engine][aliyun][AccessKeyId]"]').val()
                , AccessKeySecret: $('input[name="sms[engine][aliyun][AccessKeySecret]"]').val()
                , sign: $('input[name="sms[engine][aliyun][sign]"]').val()
                , msg_type: msgType
                , template_code: $('input[name="sms[engine][aliyun][' + msgType + '][template_code]"]').val()
                , accept_phone: $('input[name="sms[engine][aliyun][' + msgType + '][accept_phone]"]').val()
            };
            if (!formData.AccessKeyId.length) {
                layer.msg('请填写 AccessKeyId');
                return false;
            }
            if (!formData.AccessKeySecret.length) {
                layer.msg('请填写 AccessKeySecret');
                return false;
            }
            if (!formData.sign.length) {
                layer.msg('请填写 短信签名');
                return false;
            }
            if (!formData.template_code.length) {
                layer.msg('请填写 模板ID');
                return false;
            }
            if (!formData.accept_phone.length) {
                layer.msg('请填写 接收手机号');
                return false;
            }
            layer.confirm('确定要发送测试短信吗', function (index) {
                var load = layer.load();
                var url = "<?php echo url('setting/smsTest'); ?>";
                $.post(url, formData, function (result) {
                    layer.msg(result.msg);
                    layer.close(load);
                });
                layer.close(index);
            });
        });

    });
</script>

    </div>
    <!-- 内容区域 end -->

</div>
<script src="/assets/layer/layer.js"></script>
<script src="/assets/user/js/jquery.form.min.js"></script>
<script src="/assets/user/js/webuploader.html5only.js"></script>
<script src="/assets/user/js/art-template.js"></script>
<script src="/assets/user/js/app.js"></script>
<script src="/assets/user/js/file.library.js"></script>
<script src="/assets/user/js/amazeui.min.js"></script>
</body>

</html>
