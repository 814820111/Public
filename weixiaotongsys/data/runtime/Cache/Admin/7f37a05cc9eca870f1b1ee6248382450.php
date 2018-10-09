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
<body class="J_scroll_fixed">
	<div class="wrap J_check_wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('storage/index');?>">文件存储</a></li>
		</ul>
		<div class="common-form">
			<form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('storage/setting_post');?>">
				<?php $support_storages=array("Local"=>"系统默认","Qiniu"=>"七牛云存储"); ?>
				<select name="type">
					<?php if(is_array($support_storages)): foreach($support_storages as $key=>$vo): $type_selected=$type==$key?"selected":""; ?>
					<option value="<?php echo ($key); ?>"<?php echo ($type_selected); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
				</select>
				<div style="margin-top: 10px;">
					<ul class="nav nav-tabs">
						<li class="active"><a>七牛云存储</a></li>
					</ul>

					<fieldset>
						<div class="control-group">
							<label class="control-label">AccessKey</label>
							<div class="controls">
								<input type="text" class="input mr5" name="Qiniu[accessKey]" value="<?php echo ($Qiniu["accessKey"]); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">SecretKey</label>
							<div class="controls">
								<input type="text" class="input mr5" name="Qiniu[secrectKey]" value="<?php echo ($Qiniu["secrectKey"]); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">空间域名</label>
							<div class="controls">
								<input type="text" class="input mr5" name="Qiniu[domain]" value="<?php echo ($Qiniu["domain"]); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">空间名称</label>
							<div class="controls">
								<input type="text" class="input mr5" name="Qiniu[bucket]" value="<?php echo ($Qiniu["bucket"]); ?>">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">获取AccessKey</label>
							<div class="controls">
								<a href="https://portal.qiniu.com/signup?code=3lfihpz361o42" target="_blank">马上获取</a>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">七牛专享优惠码</label>
							<div class="controls">
								<a href="http://www.thinkcmf.com/topic/topic/index/id/103.html" target="_blank">507670e8</a>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">确定</button>
				</div>
			</form>
		</div>
	</div>
	<script src="/weixiaotong2016/statics/js/common.js?"></script>
</body>
</html>