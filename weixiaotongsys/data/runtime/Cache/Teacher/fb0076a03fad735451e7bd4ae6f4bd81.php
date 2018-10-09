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
input{
       margin-bottom: 0px; 
}
div{
  color: black;
}
td{
  color: black;
}
            a{
    color: #00c1dd
  }
</style>

<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="js/fileinput.js" type="text/javascript"></script>
<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>

<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="js/fileinput.js" type="text/javascript"></script>
<script src="js/fileinput_locale_zh.js" type="text/javascript"></script> -->
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<!-- <link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" /> -->
<!-- <script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script> -->
<!-- <script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script> -->
<!-- <script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script> -->
<!-- <script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script> -->
<script src="/weixiaotong2016/statics/js/common.js"></script>

<body>
      <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
            <li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">动态展示</a></li>
            <li><a href="<?php echo U('add');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">新增动态</a></li>
      </ul>
 <div style="margin-left: 25px;margin-right: 20px;">
       <form class="" method="get" action="<?php echo U('Dynamic/index');?>" style="margin: 20px 0px -6px;">
      年级： 
      <select class="select_2" name="grade" style=" width: auto;" id="school_grade">
        <option value=''>请选择年级</option>
        <?php if(is_array($school_grade)): foreach($school_grade as $key=>$vo): $grade_info=$gradeinfo==$vo['gradeid']?"selected":""; ?>
        <option value="<?php echo ($vo["gradeid"]); ?>" <?php echo ($grade_info); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
      </select> &nbsp;&nbsp;
       班级： 
      <select class="select_2" name="class" style=" width: auto;" id="school_class">
        <option value=''>请选择班级</option>
       
      </select> &nbsp;&nbsp;
      <input type="hidden" class="newclass" value="<?php echo ($classinfo); ?>">
      发布人：
      <input type="text" name="issuer" value="<?php echo ($issuer); ?>" style="width: 8%; height: 29px; border-width: 1px; color: black;    vertical-align: -2px;" autocomplete="off"  placeholder="发布人...">&nbsp;&nbsp;
      关键字： 
      <input type="text" name="keyword" value="<?php echo ($keyword); ?>" style="width:8%; height: 29px; border-width: 1px; color: black;    vertical-align: -2px;" value="" placeholder="关键字...">&nbsp;&nbsp;<br>
     
	   创建时间：
	        <input type="text" value="<?php echo ($start_time); ?>" class="sang_Calender" name="start_time" placeholder="-选择时间-" style="width: 150px; height: 29px; border-width: 1px; color: black;    vertical-align: -2px;">  -  <input type="text" value="<?php echo ($end_time); ?>" class="sang_Calender" name="end_time" placeholder="-选择时间-" style="width: 150px; height: 29px; border-width: 1px; color: black;    vertical-align: -2px;"> &nbsp; &nbsp;

      <input type="submit" class="btn btn-primary" style=" background-color: #26a69a; border-color: #26a69a;    padding-top: 4px;padding-bottom: 5px;" value="搜索" />
    </form>

    <form class="js-ajax-form" action="" method="post" action="<?php echo U('Dynamic/index');?>" style="margin: 0px 0px 0px;">
      <table class="table table-hover table-bordered table-list">
        <thead>
          <tr style="background-color: #e2e2e2">
            <th style="  text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">发布人</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">年级</th>
            <th style="  text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">班级</th>
            <th style="  text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;"><?php echo L('TITLE');?></th>
            <th style="  text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">可见范围</th>
            <th style="  text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">发布时间</th>
            <th  style="text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none; border-right: none;">操作</th>
          </tr>
        </thead>
        <?php if(is_array($posts)): foreach($posts as $key=>$vo): ?><tr>
        <!-- TITLE -->
         <td style="  text-align: center;  border-left: none; border-top: none"><?php echo ($vo["name"]); ?></td>
         <!-- 年级 -->
          <td style="  text-align: center;  border-left: none; border-top: none"><?php echo ($vo["gradename"]); ?></td>
          <!-- 班级 -->
          <td style=" text-align: center;  border-left: none; border-top: none"><?php echo ($vo["classname"]); ?></td>
          <!-- 发布人 -->
          <td style=" text-align: center; border-left: none; border-top: none">
          	<?php echo ((isset($vo["content"]) && ($vo["content"] !== ""))?($vo["content"]):'未填写'); ?>        	
          </td>
          <!-- 可见范围 -->
          <td style="  text-align: center;  border-left: none; border-top: none"><?php echo ($vo["status"]); ?>
          </td>
          <!-- 发布时间 -->
          <td style="text-align: center; border-left: none; border-top: none"><?php echo (date("Y-m-d H:i:s",$vo["write_time"])); ?>
          </td>
         <!-- 操作 -->
          <td style=" text-align: center; border-right: none; border-left: none; border-top: none">
        <!--    <a href="<?php echo U('Dynamic/dianzan',array('mid'=>$vo['mid'],'type'=>'0'));?>"><?php echo ($vo["count_like"]); ?> &nbsp; &nbsp;点赞</a> &nbsp; &nbsp;| &nbsp; &nbsp;
 -->


          <?php if($vo['like_status'] == 1): ?><a href="<?php echo U('Dynamic/dianzan',array('mid'=>$vo['mid'],'type'=>'1'));?>" style="color: #00c1dd"><?php echo ($vo["count_like"]); ?> &nbsp; &nbsp;取消</a> &nbsp; &nbsp;| &nbsp; &nbsp;
          <?php elseif($vo['like_status'] == 0): ?>
             <a href="<?php echo U('Dynamic/dianzan',array('mid'=>$vo['mid'],'type'=>'0'));?>" style="color: #00c1dd"><?php echo ($vo["count_like"]); ?> &nbsp; &nbsp;点赞</a> &nbsp; &nbsp;| &nbsp; &nbsp;<?php endif; ?>

          
            <!-- <a href="<?php echo U('Dynamic/pinglun',array('mid'=>$vo['mid']));?>" class="js-ajax-delete"><?php echo ($vo["count_comment"]); ?> &nbsp; &nbsp;评论</a></td> -->

            <a href="javascript:open_iframe_dialog('<?php echo U('Dynamic/pinglun',array('mid'=>$vo['mid']));?>','评论列表')" style="color: #00c1dd"><?php echo ($vo["count_comment"]); ?> &nbsp; &nbsp;评论</a></td>

        </tr><?php endforeach; endif; ?>
      </table>
      <div class="pagination" style="position: relative;bottom: 50px;"><?php echo ($Page); ?></div>
    </form>
  </div>


<script>

if($("#school_grade").val())
{     

  var newclass = $('body').find(".newclass").val();
  // alert(newclass);
    $.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherUtils&a=get_class&grade=" + $("#school_grade").val(), {}, function (data) {
                if (data.status == "success") {
                    $("#school_class").append("<option value=0>" + "请选择班级" + "</option>");
                    for (var key in data.data) {

                      if(newclass==data.data[key]["id"] ){

                        $("#school_class").append("<option value=" + data.data[key]["id"] + " selected>" + data.data[key]["classname"] + "</option>");
                    }else{
                      $("#school_class").append("<option value=" + data.data[key]["id"] + " >" + data.data[key]["classname"] + "</option>");
                    }

                    }
                }
                if (data.status == "error") {
                    $("#school_class").append("<option value='0'>&nbsp;全部班级</option>");
                }
            });
}


    $(function () {
        $("#school_grade").change(function () {
            $("#school_class").empty();
            $.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherUtils&a=get_class&grade=" + $("#school_grade").val(), {}, function (data) {
                if (data.status == "success") {
                    $("#school_class").append("<option value=0>" + "请选择班级" + "</option>");
                    for (var key in data.data) {
                        $("#school_class").append("<option value=" + data.data[key]["id"] + ">" + data.data[key]["classname"] + "</option>");
                    }
                }
                if (data.status == "error") {
                    $("#school_class").append("<option value='0'>没有班级</option>");
                }
            });
        });
    });

   $(function () {
      $('#myTab li:eq(0) a').tab('show');
   });




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
            <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
</body>
</html>