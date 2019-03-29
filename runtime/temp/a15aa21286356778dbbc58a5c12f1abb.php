<?php /*a:2:{s:74:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\setting\storage.html";i:1542624844;s:65:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layout.html";i:1543209671;}*/ ?>
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
                                <div class="widget-title layer-fl">文件上传设置</div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                    默认上传方式
                                </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="storage[default]" value="local" data-layer-ucheck
                                            <?php echo $values['default']==='local' ? 'checked'  :  ''; ?>> 本地 (不推荐)
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="storage[default]" value="qiniu" data-layer-ucheck
                                            <?php echo $values['default']==='qiniu' ? 'checked'  :  ''; ?>> 七牛云存储
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="storage[default]" value="aliyun" data-layer-ucheck
                                            <?php echo $values['default']==='aliyun' ? 'checked'  :  ''; ?>> 阿里云OSS
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="storage[default]" value="qcloud" data-layer-ucheck
                                            <?php echo $values['default']==='qcloud' ? 'checked'  :  ''; ?>> 腾讯云COS
                                    </label>
                                </div>
                            </div>
                            <div id="qiniu"
                                 class="form-tab-group <?php echo $values['default']==='qiniu' ? 'active'  :  ''; ?>">
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        存储空间名称 <span class="tpl-form-line-small-title">Bucket</span>
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input" name="storage[engine][qiniu][bucket]"
                                               value="<?php echo htmlentities($values['engine']['qiniu']['bucket']); ?>">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        ACCESS_KEY <span class="tpl-form-line-small-title">AK</span>
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input"
                                               name="storage[engine][qiniu][access_key]"
                                               value="<?php echo htmlentities($values['engine']['qiniu']['access_key']); ?>">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        SECRET_KEY <span class="tpl-form-line-small-title">SK</span>
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input"
                                               name="storage[engine][qiniu][secret_key]"
                                               value="<?php echo htmlentities($values['engine']['qiniu']['secret_key']); ?>">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        空间域名 <span class="tpl-form-line-small-title">Domain</span>
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input" name="storage[engine][qiniu][domain]"
                                               value="<?php echo htmlentities($values['engine']['qiniu']['domain']); ?>">
                                        <small>请补全http:// 或 https://，例如：http://static.cloud.com</small>
                                    </div>
                                </div>
                            </div>
                            <div id="aliyun"
                                 class="form-tab-group <?php echo $values['default']==='aliyun' ? 'active'  :  ''; ?>">
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        存储空间名称 <span class="tpl-form-line-small-title">Bucket</span>
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input" name="storage[engine][aliyun][bucket]"
                                               value="<?php echo htmlentities($values['engine']['aliyun']['bucket']); ?>">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label"> AccessKeyId </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input"
                                               name="storage[engine][aliyun][access_key_id]"
                                               value="<?php echo htmlentities($values['engine']['aliyun']['access_key_id']); ?>">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label"> AccessKeySecret </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input"
                                               name="storage[engine][aliyun][access_key_secret]"
                                               value="<?php echo htmlentities($values['engine']['aliyun']['access_key_secret']); ?>">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        空间域名 <span class="tpl-form-line-small-title">Domain</span>
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input"
                                               name="storage[engine][aliyun][domain]"
                                               value="<?php echo htmlentities($values['engine']['aliyun']['domain']); ?>">
                                        <small>请补全http:// 或 https://，例如：http://static.cloud.com</small>
                                    </div>
                                </div>
                            </div>
                            <div id="qcloud"
                                 class="form-tab-group <?php echo $values['default']==='qcloud' ? 'active'  :  ''; ?>">
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        存储空间名称 <span class="tpl-form-line-small-title">Bucket</span>
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input" name="storage[engine][qcloud][bucket]"
                                               value="<?php echo htmlentities($values['engine']['qcloud']['bucket']); ?>">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        所属地域 <span class="tpl-form-line-small-title">Region</span>
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input"
                                               name="storage[engine][qcloud][region]"
                                               value="<?php echo htmlentities($values['engine']['qcloud']['region']); ?>">
                                        <small>请填写地域简称，例如：ap-beijing、ap-hongkong、eu-frankfurt</small>
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        SecretId
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input"
                                               name="storage[engine][qcloud][secret_id]"
                                               value="<?php echo htmlentities($values['engine']['qcloud']['secret_id']); ?>">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        SecretKey
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input"
                                               name="storage[engine][qcloud][secret_key]"
                                               value="<?php echo htmlentities($values['engine']['qcloud']['secret_key']); ?>">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">
                                        空间域名 <span class="tpl-form-line-small-title">Domain</span>
                                    </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input" name="storage[engine][qcloud][domain]"
                                               value="<?php echo htmlentities($values['engine']['qcloud']['domain']); ?>">
                                        <small>请补全http:// 或 https://，例如：http://static.cloud.com</small>
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

        // 切换默认上传方式
        $("input:radio[name='storage[default]']").change(function (e) {
            $('.form-tab-group').removeClass('active');
            switch (e.currentTarget.value) {
                case 'qiniu':
                    $('#qiniu').addClass('active');
                    break;
                case 'qcloud':
                    $('#qcloud').addClass('active');
                    break;
                case 'aliyun':
                    $('#aliyun').addClass('active');
                    break;
                case 'local':
                    break;
            }
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
