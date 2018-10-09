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
<style>
		.wraps {
		width: 120px;
		white-space: nowrap;
		text-overflow: ellipsis;		
		overflow: hidden;
		position: relative;left: 10%;
	}
  div{
    color: black;
  }
</style>

<script src="/weixiaotong2016/statics/js/common.js"></script>
<script src="/weixiaotong2016/Public/js/common.js"></script>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="js/fileinput.js" type="text/javascript"></script>
<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<body>
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none;">
      <li class="active"><a href="<?php echo U('Delivery/index');?>" style="color:#1f1f1f;text-decoration: none;">代接管理</a></li>
      <li class=""><a href="<?php echo U('Delivery/add');?>" style="color:#1f1f1f;text-decoration: none;">新增代接</a></li>
   	</ul>
<div class="" style="margin-left: 25px; margin-right: 20px;">
  <form class="" method="post" action="<?php echo U('Delivery/index');?>" style="margin: 20px 0px 0px;">
       班级： 
      <select class="select_2" name="class" style=" width: auto;">
        <option value=''>请选择班级</option>
        <?php if(is_array($categorys)): foreach($categorys as $key=>$vo): $class_info=$classinfo==$vo['id']?"selected":""; ?>
        <option value="<?php echo ($vo["id"]); ?>" <?php echo ($class_info); ?>><?php echo ($vo["classname"]); ?></option><?php endforeach; endif; ?>
      </select> &nbsp;&nbsp;
      学生姓名：
      <input type="text" name="student_name"  style="width: 9%;height: 30px; border-width: 1px; color: black;    margin-top: 8px;" autocomplete="off"  placeholder="请输入发布人..." value="<?php echo ($student_name); ?>">&nbsp;&nbsp;
      代接状态： 
       <select class="select_2" name="status" style=" width: auto;">
       <!-- 注：什么都不写(即不写value)则传0，若写成value='0'则什么都不传即为空 -->
         <option >-请选择-</option>
         <option value='0' <?php if($status==0) echo("selected");?>>待确认</option>
         <option value='1' <?php if($status==1) echo("selected");?>>家长已同意</option>
         <option value='2' <?php if($status==2) echo("selected");?>>家长不同意</option>
      </select> &nbsp;&nbsp;
     <div style="    margin-top: -9px;">
	   创建时间：
	        <input type="text" class="sang_Calender" name="start_time" placeholder="-选择时间-" style="width: 150px; height: 29px; border-width: 1px; color: black;    margin-top: 8px;" value="<?php echo ($start_time_unix); ?>">  -  <input type="text" class="sang_Calender" name="end_time" placeholder="-选择时间-" style="width: 150px; height: 29px; border-width: 1px; color: black;    margin-top: 8px;" value="<?php echo ($end_time_unix); ?>"> &nbsp; &nbsp;

      <input  type="submit" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;" value="查询" />
      <input  type="button" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;" value="新增" />
      <input  type="button" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;" value="导出" />
      </div>
    </form>
     <form class="js-ajax-form" action="" method="post" action="<?php echo U('Delivery/index');?>">
      <table class="table table-hover table-bordered table-list">
        <thead>
          <tr>
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px;border-left: none;"><input type='checkbox' id='checkAll' name="checkAll">全选</th>        
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px;border-left: none;">班级</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px;border-left: none;">教师姓名</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px;border-left: none;">学生姓名</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px;border-left: none;">代接时间</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px;border-left: none;">代接内容</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px;border-left: none;">代接状态</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-width: 0.5px;border-left: none; border-right: none;">操作</th>
          </tr>
        </thead>
        <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr>
       <td style=" text-align: center;  border-left: none; border-top: none;"><input type="checkbox" class="J_check" id='sel_all' name="ids[]" value="<?php echo ($vo["phone"]); ?>" title="Phone:<?php echo ($vo["phone"]); ?>"></td>
          <td style=" text-align: center;  border-left: none; border-top: none;"><?php echo ($vo["classname"]); ?></td>
           <td style=" text-align: center;  border-left: none; border-top: none;"><?php echo ($vo["teacher_name"]); ?></td>
            <td style=" text-align: center;  border-left: none; border-top: none;"><?php echo ($vo["student_name"]); ?></td>
             <td style=" text-align: center; border-left: none; border-top: none;"><?php echo (date("Y-m-d H:i:s",$vo["delivery_time"])); ?></td>
              <td style=" text-align: center;  border-left: none; border-top: none; border-right: none;">
              	<div class="wraps" data-toggle="tooltip" data-placement="right"title="<?php echo ($vo["content"]); ?>"
        ><?php echo ($vo["content"]); ?></div>
              </td>
               <td style=" text-align: center;border-top: none; ">
                   <?php if($vo['delivery_status'] == 0): ?>待确认
                      <?php elseif($vo['delivery_status'] == 1): ?> 
                      家长已同意
                      <?php elseif($vo['delivery_status'] == 2): ?> 
                      家长不同意<?php endif; ?>
               </td>
                <td style=" text-align: center;border-left: none; border-top: none; ">提醒</td>
                
        </tr><?php endforeach; endif; ?>
      </table>
      <div class="pagination" style="position: relative;bottom:50px;"><?php echo ($Page); ?></div>
    </form>

</div>
<script >
	$(function () { $("[data-toggle='tooltip']").tooltip(); });

      $(function() {
        $("#checkAll").click(function() {
          $('input[class="J_check"]').prop("checked", $(this).prop("checked")); 
        });
        var $J_check = $("input[class='J_check']");
        $J_check.click(function(){
          $("#checkAll").prop("checked",$J_check.length == $("input[class='J_check']:checked").length ? true : false);
        });
      });
</script>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>


<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>

</body>
</html>