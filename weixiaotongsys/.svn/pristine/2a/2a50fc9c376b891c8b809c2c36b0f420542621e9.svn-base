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
<title>考勤信息查询</title>
<!--<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">-->
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<!-- <script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script> -->
<!-- <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script> -->
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<!-- <script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script> -->
<script src="/weixiaotong2016/statics/js/datePicker/datePicker.js" type="text/javascript"></script>
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
      tr .pai {
        background-color: #e2e2e2;
          color: black;
      }
div{
    color: black;
}
select{
    color: black;
}
    
    
</style>
</head>
<body>
<div class="" style="margin-left: 20px; margin-right: 20px;">
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; margin-left: 0;">
   		<li ><a href="<?php echo U('lists');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">考勤信息查询</a></li>
      <li class="active"><a href="<?php echo U('error');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">异常考勤查询</a></li>
   	</ul>
   	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="home">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('error');?>" method="post" style="margin: 0px 0px 0px;">
          <div class="search_type cc mb10">
              <div class="mb10">
                  <span class="mr20">
                     时间选择：
                      <input type="text" class="J_date date" name="begintime" placeholder="-选择时间-" style="width:150px; height: 17px; border-width: 1px;color: black; " value="<?php echo ($begin); ?>">  至  <input type="text" class="J_date date" name="endtime" placeholder="-选择时间-" style="width:150px; height: 17px; border-width: 1px;color: black;" value="<?php echo ($end); ?>"> &nbsp; &nbsp;
                     班级:
                     <select class="select_2" name="class" style=" width: auto;">
                         <option value='0'>-选择班级-</option>
                         <?php if(is_array($class)): foreach($class as $key=>$vo): $class_info=$classinfo==$vo['id']?"selected":""; ?>
                           <OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;
                       学生姓名： 
                      <input type="text" class="select_2" name="stu_name" placeholder="-请输入姓名-" style="width:100px; height: 17px; border-width: 1px; color: black;" value="<?php echo ($stu_name); ?>">
                      &nbsp; &nbsp;
                      家长姓名： 
                      <input type="text" class="select_2" name="par_name" placeholder="-请输入姓名-" style="width:100px; height: 17px; border-width: 1px; color: black;" value="<?php echo ($par_name); ?>"><br>
                     
                      手机号码： 
                      <input type="text" class="select_2" name="phone" placeholder="-请输入手机号-" style="width:150px; height: 17px; border-width: 1px; color: black;    margin-bottom: 2px;" value="<?php echo ($phone); ?>">
                        &nbsp; &nbsp;
                      IC卡号： 
                      <input type="text" class="select_2" name="card" placeholder="-请输入IC卡号-" style="width:130px; height: 17px; border-width: 1px; color: black;    margin-bottom: 2px;" value="<?php echo ($card); ?>">
                      &nbsp; &nbsp;
                    <!--   <input type="radio" class="input" name="time_a" value="0" checked><span>上午上学</span>
                      <input type="radio" class="input" name="time_b" value="0" checked><span>下午放学</span> -->
                      &nbsp; &nbsp;
                      <input type="submit" class="btn btn-primary" style="border:none;color:#FFF; background-color:#26a69a; padding: 5px 10px;     margin-top: 10px;
    vertical-align: -1px;" value="搜索" />
                  </span>
              </div>
          </div>
			</form>
      <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                      <table class="table table-hover table-bordered table-list">
                        <thead>
                          <tr style="background-color:#CCC;">
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;">学生姓名</th>
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;">IC卡号</th>
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;">家长姓名</th>
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;">班级</th>
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;">手机号码</th>
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;">刷卡时间</th>
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;border-right: none">短信内容</th>
                          </tr>
                        </thead>
                        <?php if(is_array($arr)): foreach($arr as $key=>$vo): ?><tr>
                           <td style=" text-align: center;border-width: 0.5px;"><?php echo ($vo["student_name"]); ?></td>
                           <td style=" text-align: center;border-width: 0.5px;"><?php echo ($vo["card"]); ?></td>
                           <td style=" text-align: center;border-width: 0.5px;"><?php echo ($vo["parent_name"]); ?></td>
                           <td style=" text-align: center;border-width: 0.5px;"><?php echo ($vo["classname"]); ?></td>
                           <td style=" text-align: center;border-width: 0.5px;"><?php echo ($vo["parent_phone"]); ?></td>
                           <td style=" text-align: center;border-width: 0.5px;"><?php echo (date("Y-m-d H:i:s",$vo["arrivetime"])); ?></td>
                           <td style=" text-align: center;border-width: 0.5px;border-right: none;">异常考勤</td>
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
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>

<script>
$('#myTab a:first').tab('show');
</script>
<script>
		$("#file-3").fileinput({
			showUpload: false,
			showCaption: false,
			browseClass: "btn btn-default",
			fileType: "any",
	        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
		});
	    $(document).ready(function() {
	        $("#test-upload").fileinput({
	            'showPreview' : false,
	            'allowedFileExtensions' : ['jpg', 'png','gif'],
	            'elErrorContainer': '#errorBlock'
	        });

	    });
		</script>
    <script>
   $(function () {
      $('#myTab li:eq(0) a').tab('show');
   });
</script>
<script>
            $("#file-3").fileinput({
                  showUpload: false,
                  showCaption: false,
                  browseClass: "btn btn-default",
                  fileType: "any",
              previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
            });
          $(document).ready(function() {
              $("#test-upload").fileinput({
                  'showPreview' : false,
                  'allowedFileExtensions' : ['jpg', 'png','gif'],
                  'elErrorContainer': '#errorBlock'
              });

          });
            </script>
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
</body>
</html>