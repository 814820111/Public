<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->
    <link href="/weixiaotong2016/statics/chosen/chosen.css" rel="stylesheet"/>
	<link href="/weixiaotong2016/statics/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <link href="/weixiaotong2016/tpl_admin/simpleboot/assets/css/mychangestyle.css" rel="stylesheet" />
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/weixiaotong2016/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/validate.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
         label.error{
            display: inline-block;
            margin: 0;
            color: red;
            margin-left: 10px;
        }
	</style><?php endif; ?>
<head />
<body>
	<div class="wrap J_check_wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('TeacherRoles/index');?>">角色管理</a></li>
			<li><a href="<?php echo U('TeacherRoles/roleadd');?>">添加角色</a></li>
		</ul>
		<form name="myform" action="<?php echo U('TeacherRoles/listorders');?>" method="post">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th width="30">ID</th>
						<th align="left">角色名称</th>
						<th align="left">角色描述</th>
						<th width="40" align="left">状态</th>
						<th width="120">管理操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($roles)): foreach($roles as $key=>$vo): ?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php echo ($vo["remark"]); ?></td>
						<td>
							<?php if($vo['status'] == 1): ?><font color="red">√</font>
							<?php else: ?> 
								<font color="red">╳</font><?php endif; ?>
						</td>
						<td>

								<a href="<?php echo U('TeacherRoles/authorize',array('id'=>$vo['id']));?>">权限设置</a>|
								<!-- <a href="javascript:open_iframe_dialog('<?php echo U('rbac/member',array('id'=>$vo['id']));?>','成员管理');">成员管理</a>| -->
								<a href="<?php echo U('TeacherRoles/roleedit',array('id'=>$vo['id']));?>">修改</a>|
								<a class="J_ajax_del" href="<?php echo U('TeacherRoles/roledelete',array('id'=>$vo['id']));?>">删除</a>

						</td>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
		</form>
	</div>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
</body>
</html>