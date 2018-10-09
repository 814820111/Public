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
    <!--<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">&ndash;&gt;-->
    <link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
    <!-- <script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script> -->
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/datePicker/datePicker.js" type="text/javascript"></script>
    <!-- <script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script> -->
    <style type="text/css">
        .col-auto { overflow: auto; _zoom: 1;_float: left;}
        .col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
        .table th, .table td {vertical-align: middle;}
        .picList li{margin-bottom: 5px;}
        tr .pai {
            background-color: #e2e2e2;
        }
        a{
            color: #00c1dd
        }
        div{
            color: black;
        }
        table{
            border-left: 1px solid #ddd;
        }
        table td{
            border-top: 1px solid #ddd;
        }
        select{
            color: black;
        }

        .example-image {
            width: 60px;
            height: 56px;
        }
        .mydiv-image {
            width: 230px;
            height: 210px;
        }
    </style>
</head>
<body>
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px;">
   		<li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">老师考勤查询</a></li>
      <li><a href="<?php echo U('index_statistic');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">老师考勤统计</a></li>
   	</ul>


   	<div style=" margin-left:30px;">
	   	 <form class="" method="post" action="<?php echo U('TeacherAttendSelect/index');?>" style="margin: 20px 0px 0px;">

	   	   教师姓名：
	      <input type="text" name="teacher_name"   autocomplete="off"  placeholder="请输入教师姓名..." style=" border-width: 1px; color: black; width: 100px;     vertical-align: 0px;" value="<?php echo ($teacher_name); ?>">&nbsp;&nbsp;

	     <!--   考勤状态： 
	      <select class="select_2" name="attend_status">
	          <option value='0'></option>
	          <option value='1'>正常</option>
	          <option value='2'>迟到</option>
	      </select> &nbsp;&nbsp;
 -->
	      工号：
	      <input type="text" name="work_card"   autocomplete="off"  placeholder="请输入教师账号..." style=" border-width: 1px; color: black; width: 100px;vertical-align: 0px;" value="<?php echo ($work_card); ?>">&nbsp;&nbsp;


	  <!--     教师介绍： 
	      <input type="text" name="description" style="width: 200px;" value="" placeholder="请输入关键字...">
	      -->
		   打卡时间：
		        <input type="text" class="sang_Calender" name="start_time" placeholder="-选择时间-" style="width: 150px; border-width: 1px; color: black;vertical-align: 0px;" value="<?php echo ($start_time_unix); ?>">  -  <input type="text" class="sang_Calender" name="end_time" placeholder="-选择时间-" style="width: 150px;  border-width: 1px; color: black;vertical-align: 0px;" value="<?php echo ($end_time_unix); ?>"> &nbsp; &nbsp;

	      <input type="submit" style=" background-color: #26a69a; padding: 4px 10px; border-radius: 3px; border: none; color: white;" value="搜索" />
             <a class="daochu" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;vertical-align: -2px;cursor: pointer;">导出</a>
	    </form>

	 <form class="js-ajax-form" action=""  method="post" action="<?php echo U('TeacherAttendSelect/index');?>">
      <div>

         <table class="table  table-bordered table-list">
        <thead>
          <tr>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;"><input type='checkbox' id='checkAll' name="checkAll">  全选</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">教师姓名</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">教育证号</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">教师介绍</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">工号</th>
              <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">打卡图片</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">考勤时段</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">考勤时间点</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">打卡时间</th>

            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">考勤状态</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none; border-right: none;">进离校</th>
          </tr>
        </thead>


        <?php if(is_array($posts)): foreach($posts as $key=>$vo): $att_type=array("0"=>"未设置","1"=>"上午上班","2"=>"上午下班","3"=>"下午上班","4"=>"下午下班","5"=>"晚上上班","6"=>"晚上下班","7"=>"无考勤打卡","8"=>"特殊活动打卡"); $status=array("0"=>"异常","1"=>"正常","2"=>"迟到","3"=>"早退","4"=>"病假","5"=>"事假","6"=>"其他","7"=>"其他"); ?>
        <tr>
        <!-- TITLE -->
          <td style=" text-align: center;  "><input type="checkbox" class="J_check" id='sel_all' name="ids[]" value="<?php echo ($vo["phone"]); ?>" title="Phone:<?php echo ($vo["phone"]); ?>"></td>
          <td style=" text-align: center;  "><?php echo ($vo["name"]); ?></td>
          <td style=" text-align: center; "><?php echo ($vo["education_card"]); ?></td>
          <td style=" text-align: center; "><?php echo ($vo["description"]); ?></td>
          <td style=" text-align: center;  "><?php echo ($vo["work_card"]); ?></td>
          <td style=" text-align: center;  ">
              <?php if($vo['leavepicture'] == null): ?>暂无图片
              <?php else: ?>
              <img class="example-image" src="http://ow3hm6y11.bkt.clouddn.com/<?php echo ($vo["leavepicture"]); ?>">
              <!--<img class="example-image" src="http://ow3hm6y11.bkt.clouddn.com/face/7/15288627625714.jpg">--><?php endif; ?>
          </td>
          <td style=" text-align: center;  "><?php echo ($att_type[$vo['attendancetype']]); ?></td>
          <td style=" text-align: center; "><?php echo ($vo["ss_time"]); ?></td>
          <td style=" text-align: center; ">
          <?php if($vo['arrivetime'] == null): else: ?>
          <?php echo (date("Y-m-d
          H:i:s",$vo["arrivetime"])); ?>

          </td><?php endif; ?>
          <td style=" text-align: center;  "><?php echo ($status[$vo['status']]); ?></td>
          <td style=" text-align: center; ">进离校</td>
		</tr><?php endforeach; endif; ?>

      </table>

      <div class="pagination"><?php echo ($Page); ?></div>
    </form>


    <div id="mydiv" style=" position: fixed; width: 230px; height: 210px;background-color: white;  display: none;">
        <img class="mydiv-image" src="">

    </div>
    </div>


<!--
把 attr("checked",this.checked); 换成
prop("checked", $(this).prop("checked")); 
可以解决：全选只能执行一次的问题

注意：prop的第二个参数的写法与attr的不同

 -->
<script >

    $(".daochu").click(function(){
        if (confirm("确定要导出吗？")) {


            location.href="<?php echo U('teacher_export');?>?teacher_name="+$("input[name='teacher_name']").val()+"&work_card="+$("input[name='work_card']").val()+"&start_time="+$("input[name='start_time']").val()+"&end_time="+$("input[name='end_time']").val()+"";


        }
    })

    $(document).on('mouseover', '.example-image', function(e){
        e.stopPropagation();
        var img = $(this).attr("src");

        obj_offset = $(this);
        var offset = $(this).offset();

        //获取滚动轴的高
        var window_height =   $(document).scrollTop();

        //元素位置
        schedule_table_td = $(this).index();

        //元素父级
        parent_schedule_table = $(this).parent();

//        $(".mydiv-top-left").css("border-bottom","1px solid #38adff");
//        $(".mydiv-top-right").css("border-bottom","none");
//        $(".mydiv-bottom-left").show();
//        $(".mydiv-bottom-right").hide();
        $("#mydiv").hide();
//        $("#mydiv).css("background-image","url("+img+")");
        $(".mydiv-image").attr("src",img);
        $("#mydiv").css("position", "abosolute").css("left", offset.left+58+"px").css("top", offset.top-window_height+-210+"px").fadeIn(500);
    })

    $(document).on('mouseout', '.example-image', function(e){
        $("#mydiv").hide();


    })

    $(window).resize(function() {
        var obj_size = obj_offset.offset();
        console.log(obj_size);

        $("#mydiv").css("left", obj_size.left+58+"px").css("top", obj_size.top+-210+"px")
    })

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



    <script src="/weixiaotong2016/statics/js/common.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>

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