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
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
</style>
</head>
<body>
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px;">

      <li class=""><a href="<?php echo U('index_scheudle');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">班次管理</a></li>
      <li class="active"><a href="<?php echo U('index_scheudle_add');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">新增教师班次</a></li>
   	</ul>
  <div style=" margin-left:30px;margin-right: 30px;">
	 <form class="js-ajax-form"  method="post" action="<?php echo U('TeacherScheduleSelect/index_scheudle_add_post');?>"  onsubmit="return checkForm()">

		<div style="margin-top: 20px; margin-left: 20px;">
			班次名称:
		 		<input type="text" name="schedule_name" value=""  autocomplete="off"  placeholder="请输入班次名称..." style=" height: 30px; border-width: 1px;">
		</div>
		 <div style="margin-left: 20px;  margin-top: 30px;">设置该班次一天内上下班的次数
			 <label style="margin-left:20px;"><span><input type="radio" name="days_num" style=" width: 0px;" value="1" checked></span><span style="border: 1px solid #38adff; padding: 6px;">1天1次上下班</span></label>
			 <label style=""><span><input type="radio" name="days_num" style=" width: 0px;" value="2"></span><span >1天2次上下班</span></label>
			 <label style=""><span><input type="radio" name="days_num" style=" width: 0px;" value="3"></span><span >1天3次上下班</span></label>
		 </div>

		<div  class="div_main" style="margin-left: 20px;margin-top: 50px; float: left; width: 45%;">
			<span style="margin-right: 10px;">第&nbsp;1&nbsp;次</span>
			上班：
			<div style="margin-left: 20px;">
			 考勤时间为：
			 	<input type="time" name="ss_time_start" style="width: 100px;height: 30px; border-width: 1px;" value="07:30" />
			  	
			</div>
			<div style="margin-left: 20px;">
			 考勤记录在设置时间点前：
			 	<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="ss_time_front" id="ss_time_front" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
			  	&nbsp;&nbsp;分钟,后&nbsp;&nbsp;
				<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="ss_time_back" id="ss_time_back" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
				&nbsp;&nbsp;分钟有效
			</div>
		</div>


		<div class="div_main" style="margin-left: 20px;margin-top: 50px; float: left; width: 45%;">
			下班：
			<div style="margin-left: 20px;">
			 考勤时间为：
			 	<input type="time" name="sx_time_start" style="width: 100px;height: 30px; border-width: 1px;" value="17:00" />
			</div>
			<div style="margin-left: 20px;">
			 考勤记录在设置时间点前：
			 	<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="sx_time_front" id="sx_time_front" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
			  	&nbsp;&nbsp;分钟,后&nbsp;&nbsp;
				<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="sx_time_back" id="sx_time_back" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
				&nbsp;&nbsp;分钟有效
			</div>
		</div>
		<div class="div_main" style="margin-left: 20px;margin-top: 50px; float: left; width: 45%; display: none;">
			<span style="margin-right: 10px;">第&nbsp;2&nbsp;次</span>
			上班：
			<div style="margin-left: 20px;">
			 考勤时间为：
			 	<input type="time" name="xs_time_start" style="width: 100px;height: 30px; border-width: 1px;" />  
			</div>
			<div style="margin-left: 20px;">
			 考勤记录在设置时间点前：
			 	<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="xs_time_front" id="xs_time_front" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
			  	&nbsp;&nbsp;分钟,后&nbsp;&nbsp;
				<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="xs_time_back" id="xs_time_back" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
				&nbsp;&nbsp;分钟有效
			</div>
		</div>
		<div class="div_main" style="margin-left: 20px;margin-top: 50px;margin-bottom: 20px; float: left; width: 45%; display: none">
			下班：
			<div style="margin-left: 20px;">
			 考勤时间为：
			 	<input type="time" name="xx_time_start" style="width: 100px;height: 30px; border-width: 1px;" />  
			</div>
			<div style="margin-left: 20px;">
			 考勤记录在设置时间点前：
			 	<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="xx_time_front" id="xx_time_front" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
			  	&nbsp;&nbsp;分钟,后&nbsp;&nbsp;
				<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="xx_time_back" id="xx_time_back" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
				&nbsp;&nbsp;分钟有效
			</div>
		</div>

		<div class="div_main" style="margin-left: 20px;margin-top: 50px; float: left; width: 45%;display: none;">
			<span style="margin-right: 10px;">第&nbsp;3&nbsp;次</span>
			上班：
			<div style="margin-left: 20px;">
			 考勤时间为：
			 	<input type="time" name="ws_time_start" style="width: 100px;height: 30px; border-width: 1px;" />  
			</div>
			<div style="margin-left: 20px;">
			 考勤记录在设置时间点前：
			 	<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="ws_time_front" id="ws_time_front" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
			  	&nbsp;&nbsp;分钟,后&nbsp;&nbsp;
				<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="ws_time_back" id="ws_time_back" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
				&nbsp;&nbsp;分钟有效
			</div>
		</div>
		<div class="div_main" style="margin-left: 20px;margin-top: 50px; float: left; width: 45%;display: none;">
			下班：
			<div style="margin-left: 20px;">
			 考勤时间为：
			 	<input type="time" name="wx_time_start" style="width: 100px;height: 30px; border-width: 1px;" />  
			</div>
			<div style="margin-left: 20px;">
			 考勤记录在设置时间点前：
			 	<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="wx_time_front" id="wx_time_front" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
			  	&nbsp;&nbsp;分钟,后&nbsp;&nbsp;
				<td><input type="text"  onkeyup="if(/\D/.test(this.value)){alert('只能输入数字');this.value='';}" name="wx_time_back" id="wx_time_back" value="90" style="width: 100px;height: 30px; border-width: 1px;" placeholder="请输入:"></td>
				&nbsp;&nbsp;分钟有效
			</div>
		</div>




		 <div  style="clear: both"></div>



		<div class="form-actions" style="margin-bottom: 50px; background-color: white;">
			        <button type="reset" class="btn btn-default" style="border:none;;color:#FFF; background-color:#adadad"> &nbsp;清 &nbsp;空&nbsp; </button>
	 		<button type="submit"   class="btn btn-primary btn_submit J_ajax_submit_btn" style="border:none;;color:#FFF; background-color:#26a69a; margin-left:10%;"> &nbsp;保  &nbsp;存&nbsp; </button>

        </div>
	 
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




        $("input[name='days_num']").click(function(){
          var id  = $(this).val();
         var div_main =$(".div_main");

          var arr = $("input[name='days_num']");

          var time = $("input[type='time']");


          if(id==1)
		  {
             arr.eq(0).parent().next().css("border","1px solid #38adff","padding","5px;")
             arr.eq(1).parent().next().css("border","none");
             arr.eq(2).parent().next().css("border","none");
              time.eq(0).val("07:40");
              time.eq(1).val("16:30");
              div_main.eq(2).hide();
              div_main.eq(3).hide();
              div_main.eq(4).hide();
              div_main.eq(5).hide();
		  }
            if(id==2)
            {
                time.eq(0).val("07:40");
                time.eq(1).val("11:00");
                time.eq(2).val("13:00");
                time.eq(3).val("16:40");
                arr.eq(0).parent().next().css("border","none");
                arr.eq(1).parent().next().css("padding","6px");
                arr.eq(1).parent().next().css("border","1px solid #38adff","padding","5px;")
                arr.eq(2).parent().next().css("border","none");
                div_main.eq(2).show();
                div_main.eq(3).show();
                div_main.eq(4).hide();
                div_main.eq(5).hide();
            }
            if(id==3)
            {
                time.eq(0).val("07:40");
                time.eq(1).val("11:00");
                time.eq(2).val("13:00");
                time.eq(3).val("16:40");
                time.eq(4).val("18:00");
                time.eq(5).val("20:30");
                arr.eq(0).parent().next().css("border","none");
                arr.eq(2).parent().next().css("padding","6px");
                arr.eq(1).parent().next().css("border","none");
                arr.eq(2).parent().next().css("border","1px solid #38adff","padding","5px;")
                div_main.eq(2).show();
                div_main.eq(3).show();
                div_main.eq(4).show();
                div_main.eq(5).show();
            }



		})


		function checkForm()
		{
         var  schedule_name  = $("input[name='schedule_name']").val();

         if(!schedule_name)
		 {
             layer.msg('班次名称不能为空', {
                 icon: 2
                 ,shade: 0.01,
             });
             return false;
		 }
            var is_time = false;
		 $("input[type='time']").each(function(){
		     var time_val = $(this).val();
		     if(time_val)
			 {
			      is_time = true;
			 }
		 })
			if(!is_time)
			{
                layer.msg('考勤时间不能为空', {
                    icon: 2
                    ,shade: 0.01,
                });
                return false;
			}

		 return true;
		}
	</script>

</body>
</html>