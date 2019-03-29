<?php /*a:2:{s:73:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\setting\tplMsg.html";i:1542624724;s:65:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layout.html";i:1543209671;}*/ ?>
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
                <form id="my-form" class="layer-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="tips layer-margin-top-sm layer-margin-bottom-sm">
                                <div class="pre">
                                    <p>
                                        模板消息仅用于微信小程序向用户发送服务通知，因微信限制，每笔支付订单可允许向用户在7天内推送最多3条模板消息。
                                        <a href="<?php echo url('store/setting.help/tplMsg'); ?>" target="_blank">如何获取模板消息ID？</a>
                                    </p>
                                </div>
                            </div>
                            <div class="widget-head layer-cf">
                                <div class="widget-title layer-fl">支付成功通知</div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">
                                    是否启用
                                </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="tplMsg[payment][is_enable]" value="1"
                                               data-layer-ucheck
                                            <?php echo $values['payment']['is_enable']==='1' ? 'checked'  :  ''; ?>
                                               required>
                                        开启
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="tplMsg[payment][is_enable]" value="0"
                                               data-layer-ucheck
                                            <?php echo $values['payment']['is_enable']==='0' ? 'checked'  :  ''; ?>>
                                        关闭
                                    </label>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">
                                    模板消息ID
                                    <span class="tpl-form-line-small-title">Template ID</span>
                                </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="tpl-form-input" name="tplMsg[payment][template_id]"
                                           value="<?php echo htmlentities($values['payment']['template_id']); ?>">
                                    <div class="help-block layer-margin-top-xs">
                                        <small>模板编号AT0009，关键词 (订单编号、支付时间、订单金额、商品名称)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-head layer-cf">
                                <div class="widget-title layer-fl">订单发货通知</div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">
                                    是否启用
                                </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="tplMsg[delivery][is_enable]" value="1"
                                               data-layer-ucheck
                                            <?php echo $values['delivery']['is_enable']==='1' ? 'checked'  :  ''; ?>
                                               required>
                                        开启
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="tplMsg[delivery][is_enable]" value="0"
                                               data-layer-ucheck
                                            <?php echo $values['delivery']['is_enable']==='0' ? 'checked'  :  ''; ?>>
                                        关闭
                                    </label>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">
                                    模板消息ID
                                    <span class="tpl-form-line-small-title">Template ID</span>
                                </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="tpl-form-input" name="tplMsg[delivery][template_id]"
                                           value="<?php echo htmlentities($values['delivery']['template_id']); ?>">
                                    <small>模板编号AT0007，关键词 (订单编号、商品信息、收货人、收货地址、物流公司、物流单号)</small>
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
