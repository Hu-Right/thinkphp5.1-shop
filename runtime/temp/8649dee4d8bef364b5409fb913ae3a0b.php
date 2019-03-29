<?php /*a:2:{s:74:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\store\role\edit.html";i:1542685762;s:65:"D:\phpStudy\PHPTutorial\WWW\xcx\application\user\view\layout.html";i:1543209671;}*/ ?>
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
        <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>权限树扩展分享</title>
	<link rel="stylesheet" type="text/css" href="/assets/layui/css/layui.css">
	<script type="text/javascript" src="/assets/layui/layui.js"></script>
</head>
<body>
<div class="row-content layer-cf">
	<div class="layui-row widget-bff">
		<div class="">
			<fieldset class="widget-head layer-cf">
					<div class="widget-title layer-fl">角色管理</div>
			</fieldset>
			
		</div>
		<div class="layui-col-md6 ">
			<form id="my-form" class="layer-form tpl-form-line-form layui-form" method="post">
				<div class="layui-form-item">
					<label class="layui-form-label layer-u-sm-3 layer-u-lg-2">角色名称</label>
					<div class="layer-u-sm-9 layer-u-end">
						<input type="text" class="tpl-form-input" name="role[role_name]" value="<?= $model['role_name'] ?>" placeholder="请输入角色名称" required>
					</div>
				</div>
				<div class="layui-form-item">
				<label class="layui-form-label layer-u-sm-3 layer-u-lg-2">角色名称</label>
					<div class="layer-u-sm-9 layer-u-end">
						<select name="role[parent_id]">
							<option value="0"> 顶级角色 </option>
							<?php if (isset($roleList)): foreach ($roleList as $role): ?>
							
								<option value="<?= $role['role_id'] ?>"> <?= $role['role_name_h1'] ?></option>
							<?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label layer-u-sm-3 layer-u-lg-2">排序</label>
					<div class="layer-u-sm-9 layer-u-end">
						<input type="number" min="0" class="layui-input" name="role[sort]" value="<?= $model['sort'] ?>">
					</div>
				</div>
				<div class="layui-form">
				<div class="layui-form-item">
					<div class="layui-form-label layer-u-sm-3 layer-u-lg-2">普通操作</div>
					<div class="layer-u-sm-9 layer-u-end">
						<button type="button" class="layui-btn layui-btn-primary" onclick="checkAll('#LAY-auth-tree-index')">全选</button>
						<button type="button" class="layui-btn layui-btn-primary" onclick="uncheckAll('#LAY-auth-tree-index')">全不选</button>
						<button type="button" class="layui-btn layui-btn-primary" onclick="showAll('#LAY-auth-tree-index')">全部展开</button>
						<button type="button" class="layui-btn layui-btn-primary" onclick="closeAll('#LAY-auth-tree-index')">全部隐藏</button>
					</div>
				</div>
			</div>
				<div class="layui-form-item">
					<label class="layui-form-label layer-u-sm-3 layer-u-lg-2">选择权限</label>
					<div class="layer-u-sm-9 layer-u-end">
						<div id="LAY-auth-tree-index"></div>
					</div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button type="submit" class="j-submit layer-btn layer-btn-secondary">提交
                                    </button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
 $(function () {

	/**
	 * 表单验证提交
	 * @type {*}
	 */
	$('#my-form').superForm();

});
layui.config({
	base: 'assets/extends/',
}).extend({
	authtree: 'authtree',
});
layui.use(['jquery', 'authtree', 'form', 'layer'], function(){
	var $ = layui.jquery;
	var authtree = layui.authtree;
	var form = layui.form;
	var layer = layui.layer;
	var role_id = "<?php echo htmlentities($model['role_id']); ?>";
	
	// 初始化
	$.ajax({
		url: '<?php echo url("store.role/role"); ?>',
		type: 'POST',
		dataType: 'json',
		data:{'role_id':role_id},
		success: function(data){
			// 渲染时传入渲染目标ID，树形结构数据（具体结构看样例，checked表示默认选中），以及input表单的名字
			authtree.render('#LAY-auth-tree-index', data.data.accessList, {
				inputname: 'role[access][]'
				,layfilter: 'lay-check-auth'
				// ,autoclose: false
				// ,autochecked: false
				// ,openchecked: true
				// ,openall: true
				,autowidth: true
			});

			// PS:使用 form.on() 会引起了事件冒泡延迟的BUG，需要 setTimeout()，并且无法监听全选/全不选
			// PS:如果开启双击展开配置，form.on()会记录两次点击事件，authtree.on()不会
			form.on('checkbox(lay-check-auth)', function(data){
				// 注意这里：需要等待事件冒泡完成，不然获取叶子节点不准确。
				setTimeout(function(){
					console.log('监听 form 触发事件数据', data);
					// 获取选中的叶子节点
					var leaf = authtree.getLeaf('#LAY-auth-tree-index');
					console.log('leaf', leaf);
					// 获取最新选中
					var lastChecked = authtree.getLastChecked('#LAY-auth-tree-index');
					console.log('lastChecked', lastChecked);
					// 获取最新取消
					var lastNotChecked = authtree.getLastNotChecked('#LAY-auth-tree-index');
					console.log('lastNotChecked', lastNotChecked);
				}, 100);
			});
			// 使用 authtree.on() 不会有冒泡延迟
			authtree.on('change(lay-check-auth)', function(data) {
				console.log('监听 authtree 触发事件数据', data);
				// 获取所有节点
				var all = authtree.getAll('#LAY-auth-tree-index');
				console.log('all', all);
				// 获取所有已选中节点
				var checked = authtree.getChecked('#LAY-auth-tree-index');
				console.log('checked', checked);
				// 获取所有未选中节点
				var notchecked = authtree.getNotChecked('#LAY-auth-tree-index');
				console.log('notchecked', notchecked);
				// 获取选中的叶子节点
				var leaf = authtree.getLeaf('#LAY-auth-tree-index');
				console.log('leaf', leaf);
				// 获取最新选中
				var lastChecked = authtree.getLastChecked('#LAY-auth-tree-index');
				console.log('lastChecked', lastChecked);
				// 获取最新取消
				var lastNotChecked = authtree.getLastNotChecked('#LAY-auth-tree-index');
				console.log('lastNotChecked', lastNotChecked);
			});
			authtree.on('deptChange(lay-check-auth)', function(data) {
				console.log('监听到显示层数改变',data);
			});
		},
		error: function(xml, errstr, err) {
			layer.alert(errstr+'，获取样例数据失败，请检查是否部署在本地服务器中！');
		}
	});

});
</script>
<script type="text/javascript">
// 获取最大深度样例
function getMaxDept(dst){
	layui.use(['jquery', 'layer', 'authtree'], function(){
		var layer = layui.layer;
		var authtree = layui.authtree;

		layer.alert('树'+dst+'的最大深度为：'+authtree.getMaxDept(dst));
	});
}
// 全选样例
function checkAll(dst){
	layui.use(['jquery', 'layer', 'authtree'], function(){
		var layer = layui.layer;
		var authtree = layui.authtree;

		authtree.checkAll(dst);
	});
}
// 全不选样例
function uncheckAll(dst){
	layui.use(['jquery', 'layer', 'authtree'], function(){
		var layer = layui.layer;
		var authtree = layui.authtree;

		authtree.uncheckAll(dst);
	});
}
// 显示全部
function showAll(dst){
	layui.use(['jquery', 'layer', 'authtree'], function(){
		var layer = layui.layer;
		var authtree = layui.authtree;

		authtree.showAll(dst);
	});
}
// 隐藏全部
function closeAll(dst){
	layui.use(['jquery', 'layer', 'authtree'], function(){
		var layer = layui.layer;
		var authtree = layui.authtree;

		authtree.closeAll(dst);
	});
}

</script>

</html>
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
