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
<title>信息1</title>

<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
.touchlei{ background-color:#eeeeee;}
    tr .pai {
        background-color: #e2e2e2;
      } 
      a{
  color: #00c1dd
}
div{
  color: black;
}

</style>
</head>
<body>
<div class="" style="margin-left: 20px; margin-right: 20px;">
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none; margin-left: 0;">
   		<li class="active"><a href="<?php echo U('Grow/index');?>" style="color:#1f1f1f;text-decoration:none;">展示</a></li>
      <li><a href="<?php echo U('Grow/grow');?>" style="color:#1f1f1f; text-decoration:none;" class="touch">新增成长轨迹</a></li>
   	</ul>
   	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="home">
        	
			<form class="" action="<?php echo u('Grow/index');?>" method="get" style="margin: 10px 0px 5px;">
          <div class="search_type cc mb10">
              <div class="mb10">
                  <span class="mr20">
                     班级:
                     <select class="select_2" name="class_c" style=" width:auto;">
                         <option value='0'>-选择班级-</option>
                         <?php if(is_array($class)): foreach($class as $key=>$vo): $class_info=$class_c==$vo['id']?"selected":""; ?>
                           <OPTION value="<?php echo ($vo["id"]); ?>"<?php echo ($class_info); ?>><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;
                      学生姓名:
                      <input type="text" value="<?php echo ($studentname); ?>" class="select_2" name="studentname" placeholder="-请输入姓名-" style="width:100px; height: 27px; border-width: 1px; margin-bottom: 0px; "> &nbsp;&nbsp;
                      时间：
                      <input type="text" value="<?php echo ($begintime); ?>" class="sang_Calender" name="begintime" placeholder="-选择时间-" style="width:150px; height: 27px; border-width: 1px;margin-bottom: 0px; ">  
                   -  <input type="text" value="<?php echo ($endtime); ?>" class="sang_Calender" name="endtime" placeholder="-选择时间-" style="width:150px; height: 27px; border-width: 1px;margin-bottom: 0px; "> &nbsp; &nbsp;
                      关键字： 
                      <input type="text" value="<?php echo ($search); ?>" class="select_2" name="search" placeholder="-请输入关键字-" style="width:100px; height: 27px; border-width: 1px;margin-bottom: 0px; ">
                      &nbsp; &nbsp;&nbsp; &nbsp;
                      <input type="submit" class="btn btn-primary" style="border:none;color:#FFF; background-color:#26a69a; padding: 5px 10px;" value="搜索" />
                  </span>
              </div>
          </div>
			</form>
      <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                      <table class="table table-hover table-bordered table-list">
                        <thead>
                          <tr style="background-color:#CCC;">
                            <th class="pai" style=" text-align: center; border-left: none;border-width:0.5px;">发布人</th>
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;">内容</th>
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;">发送时间</th>
                            <th class="pai" style=" text-align: center;border-left: none;border-width:0.5px;border-right:none;">操作</th>
                          </tr>
                        </thead>
                        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
                           <td style=" text-align: center; border-left: none;border-top:none"><?php echo ($vo["username"]); ?></td>
                            <td style=" text-align: center; border-left: none;border-top:none" title="<?php echo ($vo["content"]); ?>"><div style="overflow: hidden; white-space: nowrap; text-overflow: clip;width:300px; display: inline-block;text-overflow: ellipsis;"><?php echo ($vo["content"]); ?></div></td>
                           <td style=" text-align: center; border-left: none;border-top:none"><?php echo (date("Y-m-d H:i:s",$vo["write_time"])); ?></td>
                           <td style=" text-align: center; border-left: none;border-top:none;border-right: none;">
          <?php if($vo['like_status'] == 1): ?><a href="<?php echo U('Grow/dianzan',array('mid'=>$vo['mid'],'type'=>'1'));?>" style=" color: #00c1dd;"><?php echo ($vo["count_like"]); ?> &nbsp; &nbsp;取消</a> &nbsp; &nbsp;| &nbsp; &nbsp;
          <?php elseif($vo['like_status'] == 0): ?>
             <a href="<?php echo U('Grow/dianzan',array('mid'=>$vo['mid'],'type'=>'0'));?>" style=" color: #00c1dd;"><?php echo ($vo["count_like"]); ?> &nbsp; &nbsp;点赞</a> &nbsp; &nbsp;| &nbsp; &nbsp;<?php endif; ?>
            <a href="javascript:open_iframe_dialog('<?php echo U('Grow/pinglun',array('mid'=>$vo['mid']));?>','评论列表')" style=" color: #00c1dd"><?php echo ($vo["count_comment"]); ?> &nbsp; &nbsp;评论</a></td>
                           </td>
                        </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pagination" style="position: relative;bottom: 50px;"><?php echo ($Page); ?></div>
                  </div>
                </form>
        </div>
	<div class="tab-pane fade" id="ios">
	</div>
</div>
<script src="js/fileinput.js" type="text/javascript"></script>
<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
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
$('#myTab a:first').tab('show');
</script>
<script>

if($("#school_grade").val())
{     

  var newclass = $('body').find(".newclass").val();
  // alert(newclass);
    $.getJSON("/weixiaotong2016/index.php?g=teacher&m=Plan&a=class_json&grade=" + $("#school_grade").val(), {}, function (data) {
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
            $.getJSON("/weixiaotong2016/index.php?g=teacher&m=Plan&a=class_json&grade=" + $("#school_grade").val(), {}, function (data) {
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
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>


</html>