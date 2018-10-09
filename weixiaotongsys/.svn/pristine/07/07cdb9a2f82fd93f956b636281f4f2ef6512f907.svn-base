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
<link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
<script src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<title>宿舍进出时间设置</title>
<style type="text/css">
	.touchlei{ background-color:#eeeeee;}
	 .span5{    background-color: #f5f5f5; width: 423px;}
</style>
<body>


<ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none;">
	<li><a href="<?php echo U('dormitory_count');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">楼栋出入统计</a></li>
	<li><a href="<?php echo U('dormitory_count_room');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">宿舍出入统计</a></li>
	<li class="active"><a href="<?php echo U('check_time');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">宿舍考勤时间设置</a></li>
</ul>
<form class="layui-form" action="">
	<!-- 上午 -->
	  <div  class="row-fluid" style="margin-top: 20px;">
	       <div class="span5"  style="margin-left: 20px;">
               <b class="dian" style="cursor: pointer;">早上进出正常时间段：<input type="time" value="<?php if($check_time['time_morning1']){echo $check_time['time_morning1'];}else{echo '06:00';} ?>" lay-verify="required|nothundred" style="border-width: 1px;width: 95px;" name="time_morning1" />  &nbsp;&nbsp;至&nbsp;&nbsp;
				   <input type="time" value="<?php if($check_time['time_morning2']){echo $check_time['time_morning2'];}else{echo '08:00';} ?>" lay-verify="required|nothundred" style=" border-width: 1px;width: 95px;" name="time_morning2"  /></b>
	       </div>

	        <div class="span5"  style="margin-left: 20px;">
				<b class="dian" style="cursor: pointer;">中午进出正常时间段：<input type="time" value="<?php if($check_time['time_noon1']){echo $check_time['time_noon1'];}else{echo '11:30';} ?>" lay-verify="required|nothundred" style=" border-width: 1px;width: 95px;" name="time_noon1" />  &nbsp;&nbsp;至&nbsp;&nbsp;
					<input type="time" value="<?php if($check_time['time_noon2']){echo $check_time['time_noon2'];}else{echo '13:30';} ?>" lay-verify="required|nothundred" style=" border-width: 1px;width: 95px;" name="time_noon2"/></b>
	       </div>
    </div>
	  <div  class="row-fluid" style="margin-top: 50px;">
		  <div class="span5"  style="margin-left: 20px;">
			  <b class="dian" style="cursor: pointer;">下午进出正常时间段：<input type="time" value="<?php if($check_time['time_afternoon1']){echo $check_time['time_afternoon1'];}else{echo '16:30';} ?>" lay-verify="required|nothundred" style=" border-width: 1px;width: 95px;" name="time_afternoon1" />  &nbsp;&nbsp;至&nbsp;&nbsp;
				  <input type="time" value="<?php if($check_time['time_afternoon2']){echo $check_time['time_afternoon2'];}else{echo '18:30';} ?>" lay-verify="required|nothundred" style=" border-width: 1px;width: 95px;" name="time_afternoon2" /></b>
		  </div>

		  <div class="span5"  style="margin-left: 20px;">
			  <b class="dian" style="cursor: pointer;">晚上进出正常时间段：<input type="time" value="<?php if($check_time['time_night1']){echo $check_time['time_night1'];}else{echo '20:30';} ?>" lay-verify="required|nothundred" style=" border-width: 1px;width: 95px;" name="time_night1" />  &nbsp;&nbsp;至&nbsp;&nbsp;
				  <input type="time" style=" border-width: 1px;width: 95px;" value="<?php if($check_time['time_night2']){echo $check_time['time_night2'];}else{echo '22:30';} ?>" lay-verify="required|nothundred" name="time_night2"/></b>
		  </div>
    </div>

    

        <div class="form-actions" style="margin-top: 50px;margin-bottom: 50px; background-color: white;">
			<button id="submited" class="layui-btn" lay-submit="" lay-filter="go" style="background-color: #26a69a; border-radius: 3px; border: none; color: white;">保存</button>
		</div>

</form>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>
<script>
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate;
        //校验
        //监听提交
        form.on('submit(go)', function(data){
            var object = data.field;
            //这是核心的代码。
            $.ajax({
                url : "<?php echo u('Dormitory/check_time_post');?>",
                type: "post",
                dataType : "json",
                data:{
                    data:object
                },
                beforeSend: function () {
                    var index = layer.load(1, {
                        shade: [0.1,'#000'] //0.1透明度的白色背景
                    });
                },
                success: function(data) {
                    layer.closeAll('loading');
                    if(data.status == "success"){
                        layer.msg("添加成功",{time:1000},function(){
							window.location.reload();
                        });
                    }else if(data.status == "error"){
                        layer.msg(data.data);
                    }
                },
                error:function(e){
                    layer.msg(e.message);
                }
            });
            return false;
        });

    });

</script>
</body>
</html>