<?php /*a:2:{s:70:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\order\index.html";i:1543376126;s:65:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layout.html";i:1543209671;}*/ ?>
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
            <div class="widget layer-cf">
                <div class="widget-head layer-cf">
                    <div class="widget-title layer-cf"><?php echo htmlentities($title); ?></div>
                </div>
                <div class="widget-body layer-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar layer-margin-bottom-xs layer-cf">
                        <form id="form-search" class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?php echo htmlentities($request->pathinfo()); ?>">
                            <input type="hidden" name="dataType" value="<?php echo htmlentities($dataType); ?>">
                            <div class="layer-u-sm-12 layer-u-md-6">
                                <div class="layer-form-group">
                                    <div class="layer-btn-toolbar">
                                        <div class="layer-btn-group layer-btn-group-xs">
                                            <a class="j-export layer-btn layer-btn-success layer-radius"
                                               href="javascript:void(0);">
                                                <i class="iconfont icon-daochu layer-margin-right-xs"></i>订单导出
                                            </a>
                                            <?php if($dataType === 'delivery'): ?>
                                                <a class="j-export layer-btn layer-btn-secondary layer-radius"
                                                   href="<?php echo url('order.operate/batchDelivery'); ?>">
                                                    <i class="iconfont icon-daoru layer-margin-right-xs"></i>批量发货
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="layer-u-sm-12 layer-u-md-6">
                                <div class="layer fr">
                                    <div class="layer-form-group layer-fl">
                                        <div class="layer-input-group layer-input-group-sm tpl-form-border-form">
                                            <input type="text" class="layer-form-field" name="order_no"
                                                   placeholder="请输入订单号"
                                                   value="<?php echo htmlentities($request->get('order_no')); ?>">
                                            <div class="layer-input-group-btn">
                                                <button class="layer-btn layer-btn-default layer-icon-search"
                                                        type="submit"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="order-list layer-scrollable-horizontal layer-u-sm-12 layer-margin-top-xs">
                        <table width="100%" class="layer-table layer-table-centered
                        layer-text-nowrap layer-margin-bottom-xs">
                            <thead>
                            <tr>
                                <th width="30%" class="item-detail">商品信息</th>
                                <th width="10%">单价/数量</th>
                                <th width="15%">实付款</th>
                                <th>买家</th>
                                <th>交易状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if((!$list->isEmpty())): foreach($list as $order): ?>
                                <tr> 
                                    <td class="layer-text-middle layer-text-left" colspan="6" style="border-bottom:none;">
                                        <span class="layer-margin-right-lg"> <?php echo htmlentities($order['create_time']); ?></span>
                                        <span class="layer-margin-right-lg">订单号：<?php echo htmlentities($order['order_no']); ?></span>
                                    </td>
                               </tr>
                              
                                <?php foreach($order['item'] as $i=>$item): ?>
                                    <tr>
                                        <td class="item-detail layer-text-middle">
                                            <div class="item-image">
                                                <img src="<?php echo htmlentities($item['image']['file_path']); ?>" alt="">
                                            </div>
                                            <div class="item-info">
                                                <p class="item-title"><?php echo htmlentities($item['name']); ?></p>
                                                <p class="item-spec layer-link-muted">
                                                    <?php echo htmlentities($item['goods_attr']); ?>
                                                </p>
                                            </div>
                                        </td>
                                        <td class="layer-text-middle">
                                            <p>￥<?php echo htmlentities($item['item_price']); ?></p>
                                            <p>×<?php echo htmlentities($item['total_num']); ?></p>
                                        </td>
                                        <?php if($itemCount = count($order['item'])): ?>
                                            <td class="layer-text-middle" rowspan="<?php echo htmlentities($itemCount); ?>">
                                                <p>￥<?php echo htmlentities($order['pay_price']); ?></p>
                                                <p class="layer-link-muted">(含运费：￥<?php echo htmlentities($order['express_price']); ?>)</p>
                                            </td>
                                            <td class="layer-text-middle" rowspan="<?php echo htmlentities($itemCount); ?>">
                                                <p><?php echo htmlentities($order['user']['nickName']); ?></p>
                                                <p class="layer-link-muted">(用户id：<?php echo htmlentities($order['user']['user_id']); ?>)</p>
                                            </td>
                                            <td class="layer-text-middle" rowspan="<?php echo htmlentities($itemCount); ?>">
                                                <p>付款状态：
                                                    <span class="layer-badge
                                                <?php echo $order['pay_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
                                                        <?php echo htmlentities($order['pay_status']['text']); ?></span>
                                                </p>
                                                <p>发货状态：
                                                    <span class="layer-badge
                                                <?php echo $order['delivery_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
                                                        <?php echo htmlentities($order['delivery_status']['text']); ?></span>
                                                </p>
                                                <p>收货状态：
                                                    <span class="layer-badge
                                                <?php echo $order['receipt_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
                                                        <?php echo htmlentities($order['receipt_status']['text']); ?></span>
                                                </p>
                                            </td>
                                            <td class="layer-text-middle" rowspan="<?php echo htmlentities($itemCount); ?>">
                                                <div class="tpl-table-black-operation">
                                                    <a class="tpl-table-black-operation-green"
                                                       href="<?php echo url('order/detail', ['order_id' => $order['order_id']]); ?>">
                                                        订单详情</a>
                                                    <?php if(($order['pay_status']['value'] === 20
                                                        && $order['delivery_status']['value'] === 10)): ?>
                                                        <a class="tpl-table-black-operation"
                                                           href="<?php echo url('order/detail#delivery',
                                                               ['order_id' => $order['order_id']]); ?>">
                                                            去发货</a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; endforeach; else: ?>
                                <tr>
                                    <td colspan="6" class="layer-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="layer-u-lg-12 layer-cf">
                        <div class="layer-fr"><?php echo $list; ?> </div>
                        <div class="layer-fr pagination-total layer-margin-right">
                            <div class="layer-vertical-align-middle">总记录：<?php echo htmlentities($list->total()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(function () {

        /**
         * 订单导出
         */
        $('.j-export').click(function () {
	
            var data = {};
            var formData = $('#form-search').serializeArray();
            $.each(formData, function () {
                this.name !== 's' && (data[this.name] = this.value);
            });
            window.location = "<?php echo url('order.operate/export'); ?>" + '&' + $.urlEncode(data);
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
