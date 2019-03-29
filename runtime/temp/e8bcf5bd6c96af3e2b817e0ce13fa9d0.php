<?php /*a:5:{s:67:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\item\add.html";i:1543373793;s:65:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layout.html";i:1543209671;s:90:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layouts\_template\tpl_file_item.html";i:1541666110;s:89:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layouts\_template\file_library.html";i:1543209671;s:83:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\item\_template\spec_many.html";i:1543318966;}*/ ?>
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
        <link rel="stylesheet" href="/assets/user/css/item.css">
<link rel="stylesheet" href="/assets/user/plugins/umeditor/themes/default/css/umeditor.css">
<div class="row-content layer-cf">
    <div class="row">
        <div class="layer-u-sm-12 layer-u-md-12 layer-u-lg-12">
            <div class="widget layer-cf widget-bff">
                <form id="my-form" class="layer-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                        
						
						<div class="item-list-add-top">
							<ul class="processBar">
								<li class="item-list-add-top-active " id="line0">基础信息</li>
								<li id="line1">规格/库存</li>
								<li id="line2">商品详情</li>
								<li id="line3">其他</li>
							</ul>
						</div>
						<!-- 基础信息 -->
						<div id="basicInfo">
							 <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">商品名称 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="text" class="tpl-form-input" name="item[name]"
                                           value="" required>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">商品分类 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <select style="width:200px; display:inline-block;" name="item[category_id]" required
                                            data-am-selected="{searchBox: 1, btnSize: 'sm',
                                             placeholder:'请选择商品分类', maxHeight: 400}">
                                        <option value=""></option>
										<?php if(isset($catgory)): foreach($catgory as $first): ?>
                                       
                                        <option value="<?php echo htmlentities($first['category_id']); ?>"><?php echo htmlentities($first['name']); ?></option>
										<?php if(isset($first['child'])): foreach($first['child'] as $two): ?>
                                        
                                        <option value="<?php echo htmlentities($two['category_id']); ?>">
                                            　　<?php echo htmlentities($two['name']); ?></option>
										<?php if(isset($two['child'])): foreach($two['child'] as $three): ?>	
                                       
                                        <option value="<?php echo htmlentities($three['category_id']); ?>">
                                            　　　<?php echo htmlentities($three['name']); ?></option>
										<?php endforeach; endif; endforeach; endif; endforeach; endif; ?>
                                        
                                    </select>
                                    <small class="layer-margin-left-xs layer-btn layer-btn-secondary layer-radius">
                                        <a href="<?php echo url('item.category/add'); ?>" style="color:#fff;">去添加</a>
                                    </small>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">商品图片 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <div class="layer-form-file">
                                        <div class="layer-form-file">
                                            <button type="button"
                                                    class="upload-file layer-btn layer-btn-secondary layer-radius">
                                                <i class="layer-icon-cloud-upload"></i> 选择图片
                                            </button>
                                            <div class="uploader-list layer-cf">
                                            </div>
                                        </div>
                                        <div class="help-block layer-margin-top-sm">
                                            <small>尺寸750x750像素以上，大小2M以下 (可拖拽图片调整显示顺序 )</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
						<!-- 规格/库存 -->
						<div id="education">
							 <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">商品规格 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="item[spec_type]" value="10" data-layer-ucheck checked>
                                        单规格
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="item[spec_type]" value="20" data-am-ucheck>
                                        <span class="layer-link-muted">多规格</span>
                                    </label>
                                </div>
                            </div>

                            <div class="item-spec-many layer-form-group">
                                <div class="item-spec-box layer-u-sm-9 layer-u-sm-push-2 layer-u-end">
                                    <!-- 规格属性 -->
                                    <div class="spec-attr"></div>

                                    <!-- 添加规格：按钮 -->
                                    <div class="spec-group-button">
                                        <button type="button" class="btn-addSpecGroup layer-btn">添加规格</button>
                                    </div>

                                    <!-- 添加规格：表单 -->
                                    <div class="spec-group-add">
                                        <div class="spec-group-add-item layer-form-group">
                                            <label class="layer-form-label form-require">规格名 </label>
                                            <input type="text" class="input-specName tpl-form-input"
                                                   placeholder="请输入规格名称">
                                        </div>
                                        <div class="spec-group-add-item layer-form-group">
                                            <label class="layer-form-label form-require">规格值 </label>
                                            <input type="text" class="input-specValue tpl-form-input"
                                                   placeholder="请输入规格值">
                                        </div>
                                        <div class="spec-group-add-item layer-margin-top">
                                            <button type="button" class="btn-addSpecName layer-btn layer-btn-xs
                                            layer-btn-secondary"> 确定
                                            </button>
                                            <button type="button" class="btn-cancleAddSpecName layer-btn layer-btn-xs
                                              layer-btn-default"> 取消
                                            </button>
                                        </div>
                                    </div>
                                    <!-- 商品多规格sku信息 -->
                                    <div class="item-sku layer-scrollable-horizontal">
                                        <!-- 分割线 -->
                                        <div class="item-spec-line layer-margin-top-lg layer-margin-bottom-lg"></div>
                                        <!-- sku 批量设置 -->
                                        <div class="spec-batch layer-form-inline">
                                            <div class="layer-form-group">
                                                <label class="layer-form-label">批量设置</label>
                                            </div>
                                            <div class="layer-form-group">
                                                <input type="text" data-type="item_no" placeholder="商家编码">
                                            </div>
                                            <div class="layer-form-group">
                                                <input type="number" data-type="item_price" placeholder="销售价">
                                            </div>
                                            <div class="layer-form-group">
                                                <input type="number" data-type="line_price" placeholder="划线价">
                                            </div>
                                            <div class="layer-form-group">
                                                <input type="number" data-type="stock_num" placeholder="库存数量">
                                            </div>
                                            <div class="layer-form-group">
                                                <input type="number" data-type="weight" placeholder="重量">
                                            </div>
                                            <div class="layer-form-group">
                                                <button type="button" class="btn-specBatchBtn layer-btn layer-btn-sm layer-btn-secondary
                                                 layer-radius">确定
                                                </button>
                                            </div>
                                        </div>
                                        <!-- sku table -->
                                        <table class="spec-sku-tabel layer-table layer-table-bordered layer-table-centered
                                     layer-margin-bottom-xs layer-text-nowrap"></table>
                                    </div>
                                </div>
                            </div>

                            <div class="item-spec-single">
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">商品编码 </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="text" class="tpl-form-input" name="item[sku][item_no]"
                                               value="">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">商品价格 </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="number" class="tpl-form-input" name="item[sku][item_price]"
                                               required>
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">商品划线价 </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="number" class="tpl-form-input" name="item[sku][line_price]">
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">当前库存数量 </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="number" class="tpl-form-input" name="item[sku][stock_num]"
                                               required>
                                    </div>
                                </div>
                                <div class="layer-form-group">
                                    <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">商品重量(Kg) </label>
                                    <div class="layer-u-sm-9 layer-u-end">
                                        <input type="number" class="tpl-form-input" name="item[sku][weight]"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">库存计算方式 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="item[type]" value="10" data-am-ucheck>
                                        下单减库存
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="item[type]" value="20" data-am-ucheck
                                               checked>
                                        付款减库存
                                    </label>
                                </div>
                            </div>
						</div>
						<!-- 商品详情 -->
						<div id="work">
							<div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">商品详情 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <!-- 加载编辑器的容器 -->
                                    <textarea id="container" name="item[content]" type="text/plain"></textarea>
                                </div>
                            </div>
						</div>
						<!-- 其他 -->
						<div id="social">
							<div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">运费模板 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <select style="width:200px; display:inline-block;" name="item[delivery_id]" required
                                            data-am-selected="{searchBox: 1, btnSize: 'sm',  placeholder:'请选择运费模板'}">
                                        <option value="">请选择运费模板</option>
                                        <?php foreach($delivery as $item): ?>
                                        <option value="<?php echo htmlentities($item['delivery_id']); ?>">
                                            <?php echo htmlentities($item['name']); ?> (<?php echo htmlentities($item['method']['text']); ?>)
                                        </option>
                                        <?php endforeach; ?> 
                                    </select>
                                    <small class="layer-margin-left-xs layer-btn layer-btn-secondary layer-radius">
                                        <a href="<?php echo url('setting.delivery/add'); ?>" style="color:#fff;">去添加</a>
                                    </small>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">商品状态 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="item[status]" value="10" data-am-ucheck
                                               checked>
                                        上架
                                    </label>
                                    <label class="layer-radio-inline">
                                        <input type="radio" name="item[status]" value="20" data-am-ucheck>
                                        下架
                                    </label>
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label">初始销量</label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="number" class="tpl-form-input" name="item[sales_initial]"
                                           value="0">
                                </div>
                            </div>
                            <div class="layer-form-group">
                                <label class="layer-u-sm-3 layer-u-lg-2 layer-form-label form-require">商品排序 </label>
                                <div class="layer-u-sm-9 layer-u-end">
                                    <input type="number" class="tpl-form-input" name="item[sort]"
                                           value="100" required>
                                    <small>数字越小越靠前</small>
                                </div>
                            </div>
							<div class="item-list-add-content-foot ">
								<a class="layer-btn layer-btn-default "  id="previous_step">上一步</a>
								<a class="j-submit layer-btn layer-btn-secondary " id="next_step">下一步 </a>
								 
								<button type="submit" class="j-submit layer-btn layer-btn-secondary " id="tijiao">提交 </button>
							</div>
						</div>
						
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 图片文件列表模板 -->
<script id="tpl-file-item" type="text/template">
    {{ each list }}
	
    <div class="file-item">
        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">
            <img src="{{ $value.file_path }}">
        </a>
        <input type="hidden" name="{{ name }}" value="{{ $value.file_id}}">
        <i class="iconfont icon-shanchu file-item-delete"></i>
    </div>
    {{ /each }}
</script>




<!-- 文件库弹窗 -->
<!-- 文件库模板 -->
<script id="tpl-file-library" type="text/template">
    <div class="row">
        <div class="file-group">
            <ul class="nav-new">
                <li class="ng-scope {{ is_default ? 'active' : '' }}" data-group-id="-1">
                    <a class="group-name layer-text-truncate" href="javascript:void(0);" title="全部">全部</a>
                </li>
                <li class="ng-scope" data-group-id="0">
                    <a class="group-name layer-text-truncate" href="javascript:void(0);" title="未分组">未分组</a>
                </li>
                {{ each group_list }}
                <li class="ng-scope"
                    data-group-id="{{ $value.group_id }}" title="{{ $value.group_name }}">
                    <a class="group-edit" href="javascript:void(0);" title="编辑分组">
                        <i class="iconfont icon-bianji"></i>
                    </a>
                    <a class="group-name layer-text-truncate" href="javascript:void(0);">
                        {{ $value.group_name }}
                    </a>
                    <a class="group-delete" href="javascript:void(0);" title="删除分组">
                        <i class="iconfont icon-shanchu1"></i>
                    </a>
                </li>
                {{ /each }}
            </ul>
            <a class="group-add" href="javascript:void(0);">新增分组</a>
        </div>
        <div class="file-list">
            <div class="v-box-header layer-cf">
                <div class="h-left layer-fl layer-cf">
                    <div class="layer-fl">
                        <div class="group-select layer-dropdown">
                            <button type="button" class="layer-btn layer-btn-sm layer-btn-secondary layer-dropdown-toggle">
                                移动至 <span class="layer-icon-caret-down"></span>
                            </button>
                            <ul class="group-list layer-dropdown-content">
                                <li class="layer-dropdown-header">请选择分组</li>
                                {{ each group_list }}
                                <li>
                                    <a class="move-file-group" data-group-id="{{ $value.group_id }}"
                                       href="javascript:void(0);">{{ $value.group_name }}</a>
                                </li>
                                {{ /each }}
                            </ul>
                        </div>
                    </div>
                    <div class="layer-fl tpl-table-black-operation">
                        <a href="javascript:void(0);" class="file-delete tpl-table-black-operation-del"
                           data-group-id="2">
                            <i class="layer-icon-trash"></i> 删除
                        </a>
                    </div>
                </div>
                <div class="h-rigth layer-fr">
                    <div class="j-upload upload-image">
                        <i class="iconfont icon-add1"></i>
                        上传图片
                    </div>
                </div>
            </div>
            <div id="file-list-body" class="v-box-body">
                {{ include 'tpl-file-list' file_list }}
            </div>
            <div class="v-box-footer layer-cf"></div>
        </div>
    </div>

</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list" type="text/template">
    <ul class="file-list-item">
        {{ include 'tpl-file-list-item' data }}
    </ul>
    {{ if last_page > 1 }}
    <div class="file-page-box layer-fr">
        <ul class="pagination">
            {{ if current_page > 1 }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="上一页" data-page="{{ current_page - 1 }}">«</a>
            </li>
            {{ /if }}
            {{ if current_page < last_page }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="下一页" data-page="{{ current_page + 1 }}">»</a>
            </li>
            {{ /if }}
        </ul>
    </div>
    {{ /if }}
</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list-item" type="text/template">
    {{ each $data }}
    <li class="ng-scope" title="{{ $value.file_name }}" data-file-id="{{ $value.id }}"
        data-file-path="{{ $value.file_path }}">
        <div class="img-cover"
             style="background-image: url('{{ $value.file_path }}')">
        </div>
        <p class="file-name layer-text-center layer-text-truncate">{{ $value.file_name }}</p>
        <div class="select-mask">
            <img src="assets/user/img/chose.png">
        </div>
    </li>
    {{ /each }}
</script>

<!-- 分组元素-->
<script id="tpl-group-item" type="text/template">
    <li class="ng-scope" data-group-id="{{ group_id }}" title="{{ group_name }}">
        <a class="group-edit" href="javascript:void(0);" title="编辑分组">
            <i class="iconfont icon-bianji"></i>
        </a>
        <a class="group-name layer-text-truncate" href="javascript:void(0);">
            {{ group_name }}
        </a>
        <a class="group-delete" href="javascript:void(0);" title="删除分组">
            <i class="iconfont icon-shanchu1"></i>
        </a>
    </li>
</script>


<!-- 商品多规格模板 -->

<!-- 商品规格属性模板 -->
<script id="tpl_spec_attr" type="text/template">
    {{ each spec_attr }}
    <div class="spec-group-item" data-index="{{ $index }}" data-group-id="{{ $value.group_id }}">
        <div class="spec-group-name">
            <span>{{ $value.group_name }}</span>
            <i class="spec-group-delete iconfont icon-shanchu1" title="点击删除"></i>
        </div>
        <div class="spec-list layer-cf">
            {{ each $value.spec_items item key }}
            <div class="spec-item layer-fl" data-item-index="{{ key }}">
                <span>{{ item.spec_value }}</span>
                <i class="spec-item-delete iconfont icon-shanchu1" title="点击删除"></i>
            </div>
            {{ /each }}
            <div class="spec-item-add layer-cf layer-fl">
                <input type="text" class="ipt-specItem layer-fl layer-field-valid">
                <button type="button" class="btn-addSpecItem layer-btn layer-fl">添加</button>
            </div>
        </div>
    </div>
    {{/each }}
</script>

<!-- 商品规格table模板 -->
<script id="tpl_spec_table" type="text/template">
    <tbody>
    <tr>
        {{ each spec_attr }}
        <th>{{ $value.group_name }}</th>
        {{ /each }}
        <th>商家编码</th>
        <th>销售价</th>
        <th>划线价</th>
        <th>库存</th>
        <th>重量(kg)</th>
    </tr>
    {{ each spec_list item }}
    <tr data-index="{{ $index }}" data-sku-id="{{item.spec_sku_id }}">
        {{ each item.rows td itemKey }}
        <td class="td-spec-value layer-text-middle" rowspan="{{ td.rowspan }}">
            {{ td.spec_value }}
        </td>
        {{ /each }}
        <td>
            <input type="text" name="item_no" value="{{item.form.item_no}}" class="ipt-item-no layer-field-valid">
        </td>
        <td>
            <input type="number" name="item_price" value="{{item.form.item_price}}" class="layer-field-valid ipt-w80"
                   required>
        </td>
        <td>
            <input type="number" name="line_price" value="{{item.form.line_price}}" class="layer-field-valid ipt-w80">
        </td>
        <td>
            <input type="number" name="stock_num" value="{{item.form.stock_num}}" class="layer-field-valid ipt-w80"
                   required>
        </td>
        <td>
            <input type="number" name="weight" value="{{item.form.weight}}" class="layer-field-valid ipt-w80"
                   required>
        </td>
    </tr>
    {{ /each }}
    </tbody>
</script>


<script src="/assets/user/js/ddsort.js"></script>
<script src="/assets/user/plugins/umeditor/umeditor.config.js"></script>
<script src="/assets/user/plugins/umeditor/umeditor.min.js"></script>
<script src="/assets/user/js/item.spec.js"></script>
<script>
    $(function () {

        // 富文本编辑器
        UM.getEditor('container', {
            initialFrameWidth: 600,
            initialFrameHeight: 600
        });

        // 选择图片
        $('.upload-file').selectImages({
            name: 'item[images][]'
            , multiple: true
        });

        // 图片列表拖动
        $('.uploader-list').DDSort({
            target: '.file-item',
            delay: 100, // 延时处理，默认为 50 ms，防止手抖点击 A 链接无效
            floatStyle: {
                'border': '1px solid #ccc',
                'background-color': '#fff'
            }
        });

        // 注册商品多规格组件
        var specMany = new itemSpec({
            container: '.item-spec-many'
        });

        // 切换单/多规格
        $('input:radio[name="item[spec_type]"]').change(function (e) {
            var $itemSpecMany = $('.item-spec-many')
                , $itemSpecSingle = $('.item-spec-single');
            if (e.currentTarget.value === '10') {
                $itemSpecMany.hide() && $itemSpecSingle.show();
            } else {
                $itemSpecMany.show() && $itemSpecSingle.hide();
            }
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm({
            // form data
            buildData: function () {
                return {
                    item: {
                        spec_many: specMany.getData()
                    }
                };
            },
            // 自定义验证
            validation: function () {
                var specType = $('input:radio[name="item[spec_type]"]:checked').val();
                if (specType === '20') {
                    var isEmpty = specMany.isEmptySkuList();
                    isEmpty === true && layer.msg('商品规格不能为空');
                    return !isEmpty;
                }
                return true;
            }
        });

    });
	
</script>
<script>

	$(document).ready(function(){
		$("#education").addClass('main-hide');
		$("#work").addClass('main-hide');
		$("#social").addClass('main-hide');
		$('#previous_step').hide();
		$('#tijiao').hide();
		/*上一步*/
		$('#previous_step').bind('click', function () {
			index--;
			ControlContent(index);
		});
		/*下一步*/
		$('#next_step').bind('click', function () {
			index++;
			ControlContent(index);
		});
	});
	var index=0;
	function ControlContent(index) {
		var stepContents = ["basicInfo","education","work","social"];
		var key;//数组中元素的索引值
		for (key in stepContents) {
			var stepContent = stepContents[key];//获得元素的值
			if (key == index) {
				if(stepContent=='basicInfo'){
					$('#previous_step').hide();
					$('#tijiao').hide();
				}else{
					$('#previous_step').show();
				}
				if(stepContent=='education'){
					$('#tijiao').hide();
				}
				if(stepContent=='work'){
					$('#tijiao').hide();
				}			
				if(stepContent=='social'){
					$('#next_step').hide();
					$('#tijiao').show();
				}else{
					$('#next_step').show();
				}
				$('#'+stepContent).removeClass('main-hide');
				$('#line'+key).addClass('item-list-add-top-active');
				$('#line'+key).removeClass('item-list-add-col');
			}else {
				$('#'+stepContent).addClass('main-hide');
				if(key>index){
					$('#line'+key).removeClass('item-list-add-top-active');
				}else if(key<index){
					$('#line'+key).addClass('item-list-add-col');
				}
			}
		}

	}
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
