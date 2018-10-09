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
<title>楼栋出入统计</title>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">

<style type="text/css">

.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}

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
   		<li class="active"><a href="<?php echo U('dormitory_count');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">楼栋出入统计</a></li>
        <li><a href="<?php echo U('dormitory_count_room');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">宿舍出入统计</a></li>
        <li><a href="<?php echo U('check_time');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">宿舍考勤时间设置</a></li>
   	</ul>
   	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="home">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('Dormitory/dormitory_count');?>" method="get" style="margin:0px 0px 5px;">
          <div class="search_type cc mb10">
              <div class="mb10">
                  <span class="mr20">
                     <div style="  display: inline-block;" >
                        楼栋名称：
                          <input type="text" class="select_2" name="buildname" value="<?php echo ($buildname); ?>" placeholder="-请输入楼栋-" style="width: 100px; height: 29px; border-width: 1px;color: black;">&nbsp; &nbsp;&nbsp;
                        寝室号：
                          <input type="text" class="select_2" name="roomname" placeholder="-请输入寝室-" value="<?php echo ($roomname); ?>" style="width: 100px; height: 29px; border-width: 1px;color: black;">&nbsp; &nbsp;&nbsp;
                    班级:
                      <input type="text" class="select_2" name="classname" value="<?php echo ($classname); ?>" placeholder="-请输入楼栋-" style="width: 100px; height: 29px; border-width: 1px;color: black;">&nbsp; &nbsp;&nbsp;

                      学生姓名： 

                          <input type="text" class="select_2" name="search" placeholder="-请输入姓名-" value="<?php echo ($stu_name); ?>" style="width: 100px; height: 29px; border-width: 1px;color: black;">&nbsp; &nbsp;&nbsp;

                        <span>
                      查询时间：
                      <input type="text" class="J_date date" name="starttime" value="<?php echo ($starttime); ?>" placeholder="-选择时间-" style=" width: 150px; height: 29px; border-width: 1px;color: black;">  -  <input type="text" class="J_date date" name="endtime" value="<?php echo ($endtime); ?>" placeholder="-选择时间-" style="width: 150px; height: 27px; border-width: 1px; color: black;"><br>

                      状态： 
                      <select class="select_2" name="status" style=" width: auto;     margin-top: 6px;">
                         <option >&nbsp;--请选择--&nbsp;</option>
                         <option value= "1" <?php if($status == '1'){echo "selected";} ?>>正常出入</option>
                          <option value="2" <?php if($status == '2'){echo "selected";} ?>>异常出入</option>
                      </select> &nbsp;&nbsp;

                   
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
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;"> </th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">学生姓名</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">学生班级</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">所住楼栋/宿舍</th>
                              <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">拍照设备/设备所在楼栋</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">打卡时间</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">打卡照片</th>
                          </tr>
                        </thead>
                          <?php $i=1; ?>
                        <?php if(is_array($record)): foreach($record as $key=>$vo): ?><tr <?php if($vo[status]==2){echo "style='color:red;'";} ?>>
                                <td style=" text-align: center;border-left: none;border-top: none;"> <?php echo $i++; ?></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"> <?php echo ($vo["stu_name"]); if(empty($vo[stu_name])){echo "陌生人";} ?></td>
                                <td style=" text-align: center;border-left: none;border-top: none;"> <?php echo ($vo["classname"]); ?></td>
                                <td style=" text-align: center;border-left: none;border-top: none;"> <?php echo ($vo["buildname"]); ?>/<?php echo ($vo["roomname"]); ?></td>
                            <td style=" text-align: center;border-left: none;border-top: none;"> <?php echo ($vo["devicename"]); ?>/<?php echo ($vo["buildnames"]); ?></td>
                                <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["daytime"]); ?>&nbsp;<?php echo ($vo["histime"]); ?> </td>
                                <td style=" text-align: center;border-left: none;border-top: none;"> <a href="<?php echo ($vo["photourl"]); ?>" target="_blank">照片</a></td>

                            </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pagination"><?php echo ($Page); ?></div>
                  </div>
                </form>
        </div>
	<div class="tab-pane fade" id="ios">
	</div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>


</body>
</html>