<?php /*a:2:{s:69:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\item\index.html";i:1543376833;s:65:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layout.html";i:1543209671;}*/ ?>
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
            <div class="widget layer-cf ">
                <div class="widget-head layer-cf">
                    <div class="widget-title layer-cf">出售中的商品</div>
                </div>
                <div class="widget-body layer-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar layer-margin-bottom-xs layer-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?php echo htmlentities($request->pathinfo()); ?>">
                            <div class="layer-u-sm-12 layer-u-md-3">
                                <div class="layer-form-group">
                                    <div class="layer-btn-group layer-btn-group-xs">
                                        <a class="layer-btn layer-btn-default layer-btn-success"
                                           href="<?php echo url('item/add'); ?>">
                                            <span class="layer-icon-plus"></span> 新增
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="layer-u-sm-12 layer-u-md-9">
                                <div class="layer fr">
                                    <div class="layer-form-group layer-fl">
                                        <span style="display:none;"><?php echo $category_id = $request->get('category_id')?: null; ?></span>
                                        <select name="category_id"
                                                data-layer-selected="{searchBox: 1, btnSize: 'sm',  placeholder: '商品分类', maxHeight: 400}">
                                            <option value=""></option>
                                          <?php if(isset($catgory)): ?>:

											<?php foreach($catgory as $first): ?>
                                                <option value="<?php echo htmlentities($first['category_id']); ?>"
                                                    <?php echo $category_id==$first['category_id'] ? 'selected'  :  ''; ?>>
                                                    <?php echo htmlentities($first['name']); ?></option>
                                                <?php if(isset($first['child'])): foreach($first['child'] as $two): ?>
                                                    <option value="<?php echo htmlentities($two['category_id']); ?>"
                                                        <?php echo $category_id==$two['category_id'] ? 'selected'  :  ''; ?>>
                                                        　　<?php echo htmlentities($two['name']); ?></option>
                                                    <?php if(isset($two['child'])): foreach($two['child'] as $three): ?>
                                                        <option value="<?php echo htmlentities($three['category_id']); ?>"
                                                            <?php echo $category_id==$three['category_id'] ? 'selected'  :  ''; ?>>
                                                            　　　<?php echo htmlentities($three['name']); ?></option>
                                                    <?php endforeach; endif; endforeach; endif; endforeach; endif; ?>
                                        </select>
                                    </div>
                                    <div class="layer-form-group layer-fl">
                                      <span style="display:none;"> <?php echo $status = $request->get('status')?: null; ?></span>
                                        <select name="status"
                                                data-layer-selected="{btnSize: 'sm', placeholder: '商品状态'}">
                                            <option value=""></option>
                                            <option value="10"
                                                <?php echo $status==10 ? 'selected'  :  ''; ?>>上架
                                            </option>
                                            <option value="20"
                                                <?php echo $status==20 ? 'selected'  :  ''; ?>>下架
                                            </option>
                                        </select>
                                    </div>
                                    <div class="layer-form-group layer-fl">
                                        <div class="layer-input-group layer-input-group-sm tpl-form-border-form">
                                            <input type="text" class="layer-form-field" name="name"
                                                   placeholder="请输入商品名称"
                                                   value="<?php echo htmlentities($request->get('name')); ?>">
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

                    <div class="layer-scrollable-horizontal layer-u-sm-12">
                        <table width="100%" class="layer-table layer-table-compact layer-table-striped
                         tpl-table-black layer-text-nowrap">
                            <thead>
                            <tr>
                                <th>商品ID</th>
                                <th>图片</th>
                                <th>名称</th>
                                <th>分类</th>
                                <th>销量</th>
                                <th>排序</th>
                                <th>状态</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!$list->isEmpty()): foreach($list as $item): ?>
                                <tr>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['item_id']); ?></td>
                                    <td class="am-text-middle">
									
                                       <a href="<?php echo htmlentities($item['image'][0]['file_path']); ?>"
                                           title="点击查看大图" target="_blank">
                                            <img src="<?php echo htmlentities($item['image'][0]['file_path']); ?>"
                                                 width="50" height="50" alt="商品图片">
                                        </a> 
                                    </td>
                                    <td class="layer-text-middle">
                                        <p class="item-title"><?php echo htmlentities($item['name']); ?></p>
                                    </td>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['category']['name']); ?></td>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['sales_actual']); ?></td>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['sort']); ?></td>
                                    <td class="layer-text-middle">
                                           <span class="j-state layer-badge x-cur-p layer-badge-<?php echo $item['status']['value']==10 ? 'success'
                                                :  'warning'; ?>" data-id="<?php echo htmlentities($item['item_id']); ?>"
                                                 data-state="<?php echo htmlentities($item['status']['value']); ?>">
                                               <?php if($item['status'] == 10): ?>上架<?php else: ?>下架<?php endif; ?></span>
                                    </td>
                                    <td class="layer-text-middle"><?php echo htmlentities($item['create_time']); ?></td>
                                    <td class="layer-text-middle">
                                        <div class="tpl-table-black-operation">
											<a class="tpl-table-black-operation-primary" href="<?php echo url('item.comment/index',
                                                ['item_id' => $item['item_id']]); ?>">
                                                <i class="layer-icon-pencil"></i> 评价
                                            </a>
                                            <a href="<?php echo url('item/edit',
                                                ['item_id' => $item['item_id']]); ?>">
                                                <i class="layer-icon-pencil"></i> 编辑
                                            </a>
                                            <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                               data-id="<?php echo htmlentities($item['item_id']); ?>">
                                                <i class="layer-icon-trash"></i> 删除
                                            </a>
                                            <a class="tpl-table-black-operation-green" href="<?php echo url('item/copy',
                                                ['item_id' => $item['item_id']]); ?>">
                                                一键复制
                                            </a>
                                        </div>
                                    </td>
                                </tr>
								<?php endforeach; else: ?>

                                <tr>
                                    <td colspan="9" class="layer-text-center">暂无记录</td>
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

        // 商品状态
        $('.j-state').click(function () {
            var data = $(this).data();
            layer.confirm('确定要' + (parseInt(data.state) === 10 ? '下架' : '上架') + '该商品吗？'
                , {title: '友情提示'}
                , function (index) {
                    $.post("<?php echo url('item/state'); ?>"
                        , {
                            item_id: data.id,
                            state: Number(!(parseInt(data.state) === 10))
                        }
                        , function (result) {
                            result.code === 1 ? $.show_success(result.msg, result.url)
                                : $.show_error(result.msg);
                        });
                    layer.close(index);
                });

        });

        // 删除元素
        var url = "<?php echo url('item/delete'); ?>";
        $('.item-delete').delete('item_id', url);

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
