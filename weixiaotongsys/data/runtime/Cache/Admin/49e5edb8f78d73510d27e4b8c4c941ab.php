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
        <li><a href="<?php echo U('index');?>">学校列表</a></li>
        <li><a href="<?php echo U('addschool');?>">新增学校</a></li>
        <li class="active"><a href="<?php echo U('schoolcheck');?>">学校审核</a></li>
    </ul>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th width="50">学校ID</th>
            <th>学校名称</th>
            <th>负责代理商</th>
            <th>创建时间</th>
            <th>申请人</th>
            <th>状态</th>
            <th width="120">管理操作</th>
        </tr>
        </thead>
        <tbody>
        <?php $school_statuses=array("0"=>"待审核","2"=>"已通过"); ?>
        <?php if(is_array($school)): foreach($school as $key=>$vo): ?><tr>
                <td><?php echo ($vo["schoolid"]); ?></td>
                <td><?php echo ($vo["school_name"]); ?></td>
                <td>代理商1</td>
                <td><?php echo date('Y-m-d h:i:s',$vo['create_time']); ?></td>
                <td>申请人1</td>
                <td><?php echo ($school_statuses[$vo['school_status']]); ?></td>
                <td>
                    <a href='<?php echo U("schoolcheck_details",array("schoolid"=>$vo["schoolid"]));?>'>查看详情</a>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <div class="pagination"><?php echo ($page); ?></div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
</body>
</html>