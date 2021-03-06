<?php /*a:2:{s:76:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\market\coupon\add.html";i:1542612884;s:65:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layout.html";i:1543209671;}*/ ?>
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
            <div class="widget layer-cf  widget-bff">
                <form id="my-form" class="layer-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head layer-cf">
                                <div class="widget-title layer-fl">添加优惠券</div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">优惠券名称 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="tpl-form-input" name="coupon[name]"
                                           value="" placeholder="请输入优惠券名称" required>
                                    <small>例如：满100减10</small>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">优惠券颜色 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="coupon[color]" value="10" checked data-layer-ucheck>
                                        蓝色
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="coupon[color]" value="20" data-layer-ucheck>
                                        红色
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="coupon[color]" value="30" data-layer-ucheck>
                                        紫色
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="coupon[color]" value="40" data-layer-ucheck>
                                        黄色
                                    </label>
                                </div>
                            </div>
                            <div class="layer-form-group" data-x-switch>
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">优惠券类型 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="coupon[coupon_type]" value="10" checked
                                               data-layer-ucheck
                                               data-switch-box="switch-coupon_type"
                                               data-switch-item="coupon_type__10">
                                        满减券
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="coupon[coupon_type]" value="20"
                                               data-layer-ucheck
                                               data-switch-box="switch-coupon_type"
                                               data-switch-item="coupon_type__20">
                                        折扣券
                                    </label>
                                </div>
                            </div>
                            <div class="layer-form-group switch-coupon_type coupon_type__10">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">减免金额 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="number" min="0.01" class="tpl-form-input" name="coupon[reduce_price]"
                                           value="" placeholder="请输入减免金额" required>
                                </div>
                            </div>
                            <div class="layer-form-group switch-coupon_type coupon_type__20 hide">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">折扣率 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="number" min="1" max="100" class="tpl-form-input"
                                           name="coupon[discount]"
                                           value="" placeholder="请输入折扣率" required>
                                    <small>折扣率范围1-100，90代表9折</small>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">最低消费金额 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="number" min="1" class="tpl-form-input" name="coupon[min_price]"
                                           value="" placeholder="请输入最低消费金额" >
                                </div>
                            </div>
                            <div class="layer-form-group" data-x-switch>
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">到期类型 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="coupon[expire_type]" value="10" checked
                                               data-layer-ucheck
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__10">
                                        领取后生效
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="coupon[expire_type]" value="20"
                                               data-layer-ucheck
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__20">
                                        固定时间
                                    </label>
                                </div>
                            </div>
                            <div class="layer-form-group switch-expire_type expire_type__10">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">有效天数 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="number" min="1" class="tpl-form-input" name="coupon[expire_day]"
                                           value="3" placeholder="请输入有效天数" required>
                                </div>
                            </div>
                            <div class="layer-form-group switch-expire_type expire_type__20 hide">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">时间范围 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="j-startTime layer-form-field layer-margin-bottom-sm"
                                           name="coupon[start_time]" placeholder="请选择开始日期" required>
                                    <input type="text" class="j-endTime layer-form-field" name="coupon[end_time]"
                                           placeholder="请选择结束日期" required>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">发放总数量 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="number" min="-1" class="tpl-form-input" name="coupon[total_num]"
                                           value="-1" required>
                                    <small>限制领取的优惠券数量，-1为不限制</small>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">排序 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="number" min="0" class="tpl-form-input" name="coupon[sort]" value="100"
                                           required>
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
    /**
     * 时间选择
     */
    $(function () {
        var nowTemp = new Date();
        var nowDay = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0).valueOf();
        var nowMoth = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), 1, 0, 0, 0, 0).valueOf();
        var nowYear = new Date(nowTemp.getFullYear(), 0, 1, 0, 0, 0, 0).valueOf();
        var $startTime = $('.j-startTime');
        var $endTime = $('.j-endTime');

        var checkin = $startTime.datepicker({
            onRender: function (date, viewMode) {
                // 默认 days 视图，与当前日期比较
                var viewDate = nowDay;
                switch (viewMode) {
                    // moths 视图，与当前月份比较
                    case 1:
                        viewDate = nowMoth;
                        break;
                    // years 视图，与当前年份比较
                    case 2:
                        viewDate = nowYear;
                        break;
                }
                return date.valueOf() < viewDate ? 'layer-disabled' : '';
            }
        }).on('changeDate.datepicker.amui', function (ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.close();
            $endTime[0].focus();
        }).data('amui.datepicker');

        var checkout = $endTime.datepicker({
            onRender: function (date, viewMode) {
                var inTime = checkin.date;
                var inDay = inTime.valueOf();
                var inMoth = new Date(inTime.getFullYear(), inTime.getMonth(), 1, 0, 0, 0, 0).valueOf();
                var inYear = new Date(inTime.getFullYear(), 0, 1, 0, 0, 0, 0).valueOf();
                // 默认 days 视图，与当前日期比较
                var viewDate = inDay;
                switch (viewMode) {
                    // moths 视图，与当前月份比较
                    case 1:
                        viewDate = inMoth;
                        break;
                    // years 视图，与当前年份比较
                    case 2:
                        viewDate = inYear;
                        break;
                }
                return date.valueOf() <= viewDate ? 'layer-disabled' : '';
            }
        }).on('changeDate.datepicker.amui', function (ev) {
            checkout.close();
        }).data('amui.datepicker');
    });
</script>

<script>
    $(function () {

        // swith切换
        var $mySwitch = $('[data-x-switch]');
        $mySwitch.find('[data-switch-item]').click(function () {
            var $mySwitchBox = $('.' + $(this).data('switch-box'));
            $mySwitchBox.hide().filter('.' + $(this).data('switch-item')).show();
        });

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
