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
<style type="text/css">
	.touchlei{ background-color:#eeeeee;}
</style>
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
</style>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>

<body>
      <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
            <li class="active"><a href="<?php echo u('InfoTemplateSet/indexWhole');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">整体考勤短信设置</a></li>
            <li><a href="<?php echo u('InfoTemplateSet/index_Boarder');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">住校生考勤短信</a></li>
             <li><a href="<?php echo u('InfoTemplateSet/index_special');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">特殊活动考勤设置</a></li>
      </ul>

</body>
<div style="margin-left: 25px;margin-right: 20px;">
<form action="<?php echo u('InfoTemplateSet/indexWhole_post');?>" method="post">



	<!-- 上午 -->
        <div  class="row-fluid" style="margin-top: 20px; color: black;">
	         <div class="span7" style="margin-left: 25px; width: 40%; ">
	        	 上午上学：
	        	 <div style=" margin-top: 10px; margin-bottom: 10px;">

	        		<textarea name="text_1" style="width:100%;height: 200px; resize: none; border-width: 1px;"><?php echo ($morn_school); ?></textarea>
	             </div>
	              <div>
	              	恢复默认提醒模板：
		              	<input type="radio" name="return_1" style=" margin-top: -2px;" checked="checked" value="1">否
						<input type="radio" name="return_1" style=" margin-top: -2px;" value="2">是
	              </div>

	         </div>

	         <div class="span3" style=" width: 40%; ">
	       		上午放学：
	        	 <div style=" margin-top: 10px; margin-bottom: 10px;">
	        		<textarea name="text_2" style="width:100%;height: 200px; resize: none; border-width: 1px;"><?php echo ($morn_leave); ?></textarea>
	             </div>
	             <div>
	              	恢复默认提醒模板：
		              	<input type="radio" name="return_2" checked="checked" style=" margin-top: -2px;" value="1">否
						<input type="radio" name="return_2" style=" margin-top: -2px;" value="2">是
	             </div>
	         </div>


	        <div class="span7" style="margin-left: 25px;margin-top: 50px; width: 40%; ">
	              下午上学：
	        	 <div style=" margin-top: 10px; margin-bottom: 10px;">
	        		<textarea name="text_3" style="width:100%;height: 200px; resize: none; border-width: 1px;"><?php echo ($after_school); ?></textarea>
	             </div>
	               <div>
	              	恢复默认提醒模板：
		              	<input type="radio" name="return_3" checked="checked" style=" margin-top: -2px;" value="1">否
						<input type="radio" name="return_3" style=" margin-top: -2px;" value="2">是
	               </div>
	        </div>

	        <div  class="span3" style="margin-top: 50px; width: 40%; ">
	              下午放学：
	        	 <div style=" margin-top: 10px; margin-bottom: 10px;">
	        		<textarea name="text_4" style="width:100%;height: 200px; resize: none; border-width: 1px;"><?php echo ($after_leave); ?></textarea>
	             </div>
	               <div>
	              		恢复默认提醒模板：
		              	<input type="radio" name="return_4" checked="checked" style=" margin-top: -2px;" value="1">否
						<input type="radio" name="return_4" style=" margin-top: -2px;" value="2">是
	               </div>
	        </div>

	        <div class="span7" style="margin-left: 25px;margin-top: 50px; width: 40%; ">
	              晚上上学：
	        	 <div style=" margin-top: 10px; margin-bottom: 10px;">
	        		<textarea name="text_5" style="width:100%;height: 200px; resize: none; border-width: 1px;"><?php echo ($night_school); ?></textarea>
	             </div>
	               <div>
	              	恢复默认提醒模板：
		              	<input type="radio" name="return_5" checked="checked" style=" margin-top: -2px;" value="1">否
						<input type="radio" name="return_5" style=" margin-top: -2px;" value="2">是
	               </div>
	        </div>
	         <div  class="span3" style="margin-top: 50px; width: 40%; ">
	              晚上放学：
	        	 <div style=" margin-top: 10px; margin-bottom: 10px;">
	        		<textarea name="text_6" style="width:100%;height: 200px; resize: none; border-width: 1px;"><?php echo ($night_leave); ?></textarea>
	             </div>
	               <div>
	              		恢复默认提醒模板：
		              	<input type="radio" name="return_6" checked="checked" style=" margin-top: -2px;" value="1">否
						<input type="radio" name="return_6" style=" margin-top: -2px;" value="2">是
	               </div>
	        </div>

        </div>

        <div class="form-actions" style="margin-top: 0px;margin-bottom: 0px; background-color: white;">
				<button class="js-ajax-submit" type="submit" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;">保存修改</button>
		</div>

	 <div style="margin-bottom: 50px; margin-left: 20px;">
		 <div style=" width: 15px; height: 15px; background-color: #e84e40; border-radius: 50%; float: left; margin-right: 10px;"></div>
		 <div style=" float: left; margin-top: -2px;">
			1.  您可以选择短信模板中需要替换的内容，如只保留“{学生姓名}”“{时}”“{分}”：{学生姓名}家长，您的小孩{时}点{分}分安全到校刷卡，请您放心！ 
			<br>
			2.  “{}”里的内容是系统用来替换真实内容的，因此修改短信模板时，请不要修改“{}”里的内容，如将“{学生姓名}”修改为“{姓名}
		 </div>
		 <div style="clear: both;"></div>
	</div>


</form>    
</div>
		      <script>
            $(".touch").mouseenter(
					function(){
						$(this).addClass("touchlei")
						}
			)
			 $(".touch").mouseleave(
					function(){
						$(this).removeClass("touchlei")
						}
			)
            </script>
</html>