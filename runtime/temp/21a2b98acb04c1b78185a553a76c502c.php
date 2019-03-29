<?php /*a:2:{s:77:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\item\comment\index.html";i:1543825524;s:65:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layout.html";i:1543209671;}*/ ?>
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
                    <div class="widget-title layer-cf">评价列表</div>
                </div>
                <div class="widget-body layer-fr">
                    <div class="layer-scrollable-horizontal layer-u-sm-12">
                        <table width="100%" class="layer-table layer-table-compact layer-table-striped
                         tpl-table-black layer-text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th class="layer-text-center">用户</th>
                                <th>商品图片</th>
                                <th>商品名称</th>
                                <th>评分</th>
                                <th>评价内容</th>
                                <th>是否有图片</th>
                                <th>显示状态</th>
                                <th>评价排序</th>
                                <th>评价时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php if(!$list->isEmpty()): foreach($list as $item): ?>
                          
                                <tr>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['comment_id']); ?></td>
                                    <td class="layer-text-center">
                                        <p class=""><?php echo htmlentities($item['user']['nickName']); ?></p>
                                        <p class="layer-link-muted">(用户id：<?php echo htmlentities($item['user']['user_id']); ?>)</p>
                                    </td>
                                    <td class="layer-text-middle">
                                        <a href="<?php echo htmlentities($item['order_list']['image']['file_path']); ?>"
                                           title="点击查看大图" target="_blank">
                                            <img src="<?php echo htmlentities($item['order_list']['image']['file_path']); ?>"
                                                 width="50" height="50" alt="商品图片">
                                        </a>
                                    </td>
                                    <td class="layer-text-middle">
                                        <p class="item-title"><?php echo htmlentities($item['order_list']['name']); ?></p>
                                    </td>
                                    <td class="layer-text-middle">
                                        <?php if($item['score'] === 10): ?>
                                            <span class="x-color-green">好评</span>
                                        <?php elseif($item['score'] === 20): ?>
                                            <span class="x-color-yellow">中评</span>
                                        <?php else: ?>
                                            <span class="x-color-red">差评</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle">
                                        <p class="item-title"><?php echo htmlentities($item['content']); ?></p>
                                    </td>
                                    <td class="layer-text-middle">
                                       <?php if($item['is_picture']): ?>
                                            <span class="x-color-green">是</span>
                                        <?php else: ?>
                                            <span class="">否</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle">
                                        <?php if($item['status']): ?>
                                            <span class="x-color-green">显示</span>
                                       <?php else: ?>
                                            <span class="x-color-red">隐藏</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['sort']); ?></td>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['create_time']); ?></td>
                                    <td class="layer-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <a href="<?php echo url('Item.comment/detail', ['comment_id' => $item['comment_id']]); ?>">
                                                <i class="layer-icon-pencil"></i> 详情
                                            </a>
                                            <a href="javascript:void();"
                                               class="item-delete tpl-table-black-operation-del"
                                               data-id="<?php echo htmlentities($item['comment_id']); ?>">
                                                <i class="layer-icon-trash"></i> 删除
                                            </a>
                                        </div>
                                    </td>
                                </tr>
								<?php endforeach; else: ?>
                          
                                <tr>
                                    <td colspan="11" class="layer-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="layer-u-lg-12 layer-cf">
                        <div class="layer-fr"><?php echo $list->render(); ?> </div>
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
        // 删除元素
        var url = "<?php echo url('item.comment/delete'); ?>";
        $('.item-delete').delete('comment_id', url);
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
