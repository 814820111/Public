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
<title>宿舍出入统计</title>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">

<style type="text/css">

a{
  color: #00c1dd
}
div{
  color: black;
}
</style>
</head>
<body>
<div class="" style="margin-left: 20px; height: 28px; margin-right: 20px;">
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; list-style:none; margin-left: 0;">
        <li><a href="<?php echo U('dormitory_count');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">楼栋出入统计</a></li>
   		<li class="active"><a href="<?php echo U('dormitory_count_room');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">宿舍出入统计</a></li>
        <li><a href="<?php echo U('check_time');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">宿舍考勤时间设置</a></li>
   	</ul>
   	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="home">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('Dormitory/dormitory_count_room');?>" method="get" style="margin:0px 0px 5px;">
          <div class="search_type cc mb10">
              <div class="mb10">
                  <span class="mr20">
                     <div style="  display: inline-block;" >
                        楼栋名称：
                          <input type="text" class="select_2" name="buildname"  value="<?php echo ($buildname); ?>" placeholder="-请输入楼栋-" style="width: 100px; height: 29px; border-width: 1px;color: black;">&nbsp; &nbsp;&nbsp;
                        寝室号：
                          <input type="text" class="select_2" name="roomname"  value="<?php echo ($roomname); ?>" placeholder="-请输入寝室-" style="width: 100px; height: 29px; border-width: 1px;color: black;">&nbsp; &nbsp;&nbsp;
                    班级:
                      <input type="text" class="select_2" name="classname" value="<?php echo ($classname); ?>" placeholder="-请输入班级-" style="width: 100px; height: 29px; border-width: 1px;color: black;">&nbsp; &nbsp;&nbsp;
                      学生姓名：
                          <input type="text" class="select_2" name="stu_name" value="<?php echo ($stu_name); ?>" placeholder="-请输入姓名-" style="width: 100px; height: 29px; border-width: 1px;color: black;">&nbsp; &nbsp;&nbsp;
                        <span>
                      查询时间：
                      <input type="text" class="J_date date" name="startime" placeholder="-选择时间-" value="<?php echo ($startime); ?>" style=" width: 150px; height: 29px; border-width: 1px;color: black;">  -
                            <input type="text" class="J_date date" name="endtime" value="<?php echo ($endtime); ?>" placeholder="-选择时间-" style="width: 150px; height: 27px; border-width: 1px; color: black;"><br>
					     </span>
                 <button type="submit" class="btn btn-default" style="border:none;;color:#FFF;  background-color:#26a69a; margin-right:3%; margin-top: 5px;"> 查 询 </button>
                      <button type="button" class="btn btn-default daochu" style="border:none;;color:#FFF;  background-color:#26a69a; margin-top: 5px;"> 导 出 </button>
					  </div>
                  </span>
              </div>
          </div>
			</form>
      <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-list">
                    <thead>

                    <tr style="background-color:#CCC;">
                        <th  colspan=6 style=" text-align: center;">查询时间:<?php echo ($startime); ?>至<?php echo ($endtime); ?></th>
                        <th  colspan=8 style=" text-align: center;">每周（正常进出次数/异常进出次数）</th>
                    </tr>
                    <tr style="background-color:#CCC;">
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;"></th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">楼栋</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">宿舍</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">床位</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">学生姓名</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">学生班级</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">1 </th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">2</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">3</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">4</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">5</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">6</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">7</th>
                        <th class="pai"  style=" text-align: center;border-left:none;border-width: 0.5px;">合计</th>
                    </tr>

                    </thead>
                    <?php $i=1; ?>
                    <?php if(is_array($record)): foreach($record as $key=>$vo): ?><tr>
                            <td style=" text-align: center;border-left: none;border-top: none;"><?php echo $i++; ?></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["buildname"]); ?></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["roomname"]); ?></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["bedname"]); ?></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["stu_name"]); ?></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["classname"]); ?></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><a onclick="SeeStudent('<?php echo ($vo["stu_name"]); ?>','<?php echo ($vo["studentid"]); ?>','<?php echo ($startime); ?>','<?php echo ($endtime); ?>','1');"><?php echo ($vo["ok1"]); ?>/<?php echo ($vo["nook1"]); ?></a></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><a onclick="SeeStudent('<?php echo ($vo["stu_name"]); ?>','<?php echo ($vo["studentid"]); ?>','<?php echo ($startime); ?>','<?php echo ($endtime); ?>','2');"><?php echo ($vo["ok2"]); ?>/<?php echo ($vo["nook2"]); ?></a></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><a onclick="SeeStudent('<?php echo ($vo["stu_name"]); ?>','<?php echo ($vo["studentid"]); ?>','<?php echo ($startime); ?>','<?php echo ($endtime); ?>','3');"><?php echo ($vo["ok3"]); ?>/<?php echo ($vo["nook3"]); ?></a></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><a onclick="SeeStudent('<?php echo ($vo["stu_name"]); ?>','<?php echo ($vo["studentid"]); ?>','<?php echo ($startime); ?>','<?php echo ($endtime); ?>','4');"><?php echo ($vo["ok4"]); ?>/<?php echo ($vo["nook4"]); ?></a></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><a onclick="SeeStudent('<?php echo ($vo["stu_name"]); ?>','<?php echo ($vo["studentid"]); ?>','<?php echo ($startime); ?>','<?php echo ($endtime); ?>','5');"><?php echo ($vo["ok5"]); ?>/<?php echo ($vo["nook5"]); ?></a></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><a onclick="SeeStudent('<?php echo ($vo["stu_name"]); ?>','<?php echo ($vo["studentid"]); ?>','<?php echo ($startime); ?>','<?php echo ($endtime); ?>','6');"><?php echo ($vo["ok6"]); ?>/<?php echo ($vo["nook6"]); ?></a></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><a onclick="SeeStudent('<?php echo ($vo["stu_name"]); ?>','<?php echo ($vo["studentid"]); ?>','<?php echo ($startime); ?>','<?php echo ($endtime); ?>','7');"><?php echo ($vo["ok7"]); ?>/<?php echo ($vo["nook7"]); ?></a></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"><a onclick="SeeStudent('<?php echo ($vo["stu_name"]); ?>','<?php echo ($vo["studentid"]); ?>','<?php echo ($startime); ?>','<?php echo ($endtime); ?>','8');"><?php echo ($vo["ok8"]); ?>/<?php echo ($vo["nook8"]); ?></a></td>
                        </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pagination"><?php echo ($Page); ?></div>
                  </div>
                </form>
        </div>

</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>
    <script>
        layui.use(['layer'], function(){
            var layer = layui.layer;
        });
        //查看学生考勤详细
        function SeeStudent(stuname,studentid,startime,endtinme,week) {
            if(week == 8){
                var weeks = "全部"
            }else{
                var weeks = "周"+week
            }
            var title = stuname+" "+startime+"至"+endtinme+" "+weeks+" 进出记录";
            layui.use(['layer'], function() {
                var $ = layui.jquery,
                    layer = layui.layer;

                var index = layer.open({
                    type: 2,
                    id	: 1,
                    title: title,
                    btn: [ '关闭'],
                    area: ['600px', '500px'],
                    offset : ['20px', '200px'],
                    maxmin: true,
                    content: "<?php echo U('Dormitory/dormitory_see_student_log');?>?studentid="+studentid+"&startime="+startime+"&endtime="+endtinme+"&week="+week,
                    shade: 0.8,
                    shadeClose: true,
                    maxmin :true,
                    success: function(layero, index){
                    }
                });
            });
        }
</script>

</body>
</html>