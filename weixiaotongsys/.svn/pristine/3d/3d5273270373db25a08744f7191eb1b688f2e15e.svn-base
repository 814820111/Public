<?php if (!defined('THINK_PATH')) exit();?>	<!doctype html>
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
    <link href="/weixiaotong2016/tpl_teacher/simpleboot/assets/css/mychangestyle.css" rel="stylesheet" />
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

<style type="text/css">
 
 td{
 	color: black;
 }
	tr .pai {
				background-color: #e2e2e2;
			}	
</style>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>信息1</title>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
<link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
	<title>zz</title>
</head>
<body class="J_scroll_fixed">
	<div class="wrap J_check_wrap">
		<ul class="nav nav-tabs" style=" margin-top: 20px; margin-left: 20px;">
			<li class="active"><a href="<?php echo U('Semester/index');?>">学期信息</a></li>
		</ul>
		<div style="padding: 20px;">
		<form class="" method="post" action=""  style="margin: 5px 0px 0px;">
			<div class="search_type cc mb10">
				<div class="mb10">

				</div>
			</div>
		</form>
		<form class="J_ajaxForm" action="<?php echo U('Semester/index');?>" method="post">
<!-- 			<div class="table-actions">
			</div> -->
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr style="background-color:#CCC;">
						<th class="pai" style=" text-align: center;border-left: none;border-width: none;">学期名称</th>
						<th class="pai" style=" text-align: center;border-left: none;border-width: none;">开学日期</th>
						<th class="pai" style=" text-align: center;border-left: none;border-width: none;">结束日期</th>
						<th class="pai" style=" text-align: center;border-left: none;border-width: none;">状态</th>
						<th class="pai" style=" text-align: center;border-left: none;border-width: none;border-right: none;">创建时间</th>
						<!-- <th>操作</th> -->
					</tr>
				</thead>
				<?php if(is_array($semester)): foreach($semester as $key=>$vo): ?><tr>
					<td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["semester"]); ?></td>
					<td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["semester_start"]); ?></td>
					<td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["semester_end"]); ?></td>
					<td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["statu"]); ?></td>
					<td style=" text-align: center;border-left: none;border-top: none;border-right: none;"><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
					<!-- <td>?</td> -->
				</tr><?php endforeach; endif; ?>
			</table>
		</form>
		</div>
	</div>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
	<script>
	function addsemester(){
		var semestername = $("input[name='semester_name']").val();
		var start_time = $("input[name='start_time']").val();
		var end_time = $("input[name='end_time']").val();
       
         if(semestername == ""){
              
          layer.msg('学期名称不能为空!', {
                                icon: 2
                                ,shade: 0.01,
                            });
	               	return false;


         }

      if(start_time == ""){
              
          layer.msg('时间不能为空!', {
                                icon: 2
                                ,shade: 0.01,
                            });
	               	return false;


         }
         
      if(end_time == ""){
              
          layer.msg('时间不能为空!', {
                                icon: 2
                                ,shade: 0.01,
                            });
	               	return false;


         }



		$.ajax({
	      type:"post",
	      async:false,
	      url:"<?php echo U('Teacher/Semester/add');?>",
	      data:{'semestername': semestername,
	  			'starttime':start_time,
	  			'endtime':end_time
	  		},
	      success: function(msg){
	        history.go(0);
	      }     
    	});
    }
	</script>
</body>
</html>