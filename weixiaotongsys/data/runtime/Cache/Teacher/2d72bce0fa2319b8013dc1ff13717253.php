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
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
    <![endif]-->

	<link href="/weixiaotong2016/statics/simpleboot/themes/<?php echo C('SP_TEACHER_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <link href="/weixiaotong2016/tpl_teacher/simpleboot/assets/css/mychangestyle.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/weixiaotong2016/statics/simpleboot/css/index.css"/>
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
//全局变量
var GV = {
    HOST:"<?php echo ($_SERVER['HTTP_HOST']); ?>",
    DIMAUB: "/weixiaotong2016/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};

</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<html>
<head>
<style>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
	.touchlei{ background-color:#eeeeee;}
  div{
    color: black;
  }
</style>
</head>
<body>
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px;">

      <li class="active"><a href="<?php echo U('index_scheudle');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">班次管理</a></li>
   	</ul>


   	<div style=" margin-left:30px; margin-right: 30px; padding-top: 10px;">
	   <!-- <a href= ="<?php echo U('TeacherScheduleSelect/index_scheudle_add');?>"> 新增班次</a> -->
     <a href="<?php echo U('index_scheudle_add');?>" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white; text-decoration: none;">新增班次</a>

	 <form class="js-ajax-form" action="" method="post" action="<?php echo U('TeacherScheduleSelect/index_scheudle');?>">
      <table class="table table-hover table-bordered table-list" style=" margin-top: 10px;">
        <thead>
          <tr>
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px; border-left: none;">班次</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px; border-left: none;">班次名称</th>

            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px; border-left: none;">考勤时间</th>
        
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px; border-left: none;border-right: none;">操作</th>
          </tr>
        </thead>


        <?php if(is_array($posts)): foreach($posts as $key=>$vo): ?><tr>
        <!-- TITLE -->
          <td style=" text-align: center;  border-top: none;border-left: none"><?php echo ($vo["id"]); ?></td>
          <td style=" text-align: center;  border-top: none;border-left: none"><?php echo ($vo["name"]); ?></td>
          <td style=" text-align: center;  border-top: none;border-left: none"><?php echo ($vo["att_time"]); ?></td>
          <td style=" text-align: center; border-top: none;border-left: none;border-right:none">
            <a href="<?php echo U('TeacherScheduleSelect/index_scheudle_edit',array('id'=>$vo['id']));?>">修改</a>&nbsp;&nbsp;||&nbsp;&nbsp;
            <a href="<?php echo U('TeacherScheduleSelect/delete_scheudle',array('id'=>$vo['id']));?>" class="J_ajax_del">删除</a>&nbsp;&nbsp;||&nbsp;&nbsp;
            <a href="<?php echo U('TeacherScheduleSelect/clear_scheudle',array('id'=>$vo['id']));?>">清空
          </td>
		</tr><?php endforeach; endif; ?>

      </table>
      <div class="pagination"><?php echo ($Page); ?></div>
    </form>

   	</div>


  <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
	<script src="js/fileinput.js" type="text/javascript"></script>
	<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
	<script src="/weixiaotong2016/statics/js/common.js"></script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
	<script src="js/fileinput.js" type="text/javascript"></script>
	<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
	<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
	<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
	<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
	<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
	<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
            <script>
            $(".touch").mouseenter(
					function(){
						$(".touch").addClass("touchlei")
						}
			)
			 $(".touch").mouseleave(
					function(){
						$(".touch").removeClass("touchlei")
						}
			)
            </script>

</body>
</html>