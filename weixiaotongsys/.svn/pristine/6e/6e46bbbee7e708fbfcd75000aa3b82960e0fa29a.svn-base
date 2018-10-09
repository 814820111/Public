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
<title>家长叮嘱</title>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
.wraps {
		width: 120px;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
	}
  tr .pai {
    background-color: #e2e2e2;}
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
    <ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:30px; margin-left: 0;">
   		<li class="active"><a href="<?php echo U('Entrust/index');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">家长叮嘱</a></li>
   	</ul>
   	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="home">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('Entrust/index');?>" method="get" style="margin: 0px 0px 5px;">
          <div class="search_type cc mb10">
              <div class="mb10">
                  <span class="mr20">班级： 
                      <select class="select_2" name="classid" style="width: auto;">
                         <option value=''>-选择班级-</option>

                         <?php if(is_array($class)): foreach($class as $key=>$vo): $class_info=$classid==$vo['id']?"selected":""; ?>
                         	
                           <OPTION value="<?php echo ($vo["id"]); ?>"<?php echo ($class_info); ?>><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;
                      
                      学生姓名： 
                      <!-- <div class="mr20" style="width: 100px"> -->
                          <input type="text" value="<?php echo ($search); ?>" class="select_2" name="search" placeholder="-请输入姓名-" style="width: 100px; height: 30px; border-width: 1px;">
                      <!-- </div> -->&nbsp; &nbsp;
                      接收时间：
                      <input value="<?php echo ($begintime); ?>" type="text" class="sang_Calender" name="begintime" placeholder="-选择时间-" style="width: 100px; height: 30px;border-width: 1px;">  - 
                      <input value="<?php echo ($endtime); ?>" type="text" class="sang_Calender" name="endtime" placeholder="-选择时间-" style="width: 100px; height: 30px;border-width: 1px;"> &nbsp; &nbsp;
                      叮嘱状态：	
                      <select  class="select_2" name="state" style="width: auto;">
                      	<option value="">请选择状态</option>
                      	<option value="1">启用</option>
                      	<option value="0">禁用</option>
                      </select>&nbsp; &nbsp;
                      <button type="submit" class="btn btn-default" style="border:none;;color:#FFF; background-color:#26a69a;"> 查 询 </button>
                  </span>
              </div>
          </div>
			</form>
      <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                      <table class="table table-hover table-bordered table-list">
                        <thead>
                          <tr style="background-color:#e2e2e2;">
                            <th style=" text-align: center; border-width: 0.5px; border-left: none"><input type="checkbox"> 全选</th>
                            <th style=" text-align: center; border-width: 0.5px; border-left: none">状态</th>
                            <th style=" text-align: center; border-width: 0.5px; border-left: none">学生班级</th>
                            <th style=" text-align: center; border-width: 0.5px; border-left: none">学生姓名</th>
                            <th style=" text-align: center; border-width: 0.5px; border-left: none">信息内容</th>
                            <th style=" text-align: center; border-width: 0.5px; border-left: none">接收时间</th>
                            <th style=" text-align: center; border-width: 0.5px; border-left: none">信息来源</th>
                            <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">操作</th>
                          </tr>
                        </thead>
                        <?php $school_statuses=array("0"=>"禁用","1"=>"启用"); ?>
                        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
                           <td style="text-align: center; border-left: none;border-top: none"><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>"    title="ID:<?php echo ($vo["id"]); ?>"></td>
                           <td class="zhuang" style="text-align: center; border-left: none;border-top: none;cursor: pointer;">
                           	<?php if($vo["status"] == 1): ?><span class="jiyong">启用</span>
                           		<input type="hidden" value="<?php echo ($vo["id"]); ?>" /><?php endif; ?>
                           	<?php if($vo["status"] == 0): ?><span class="jiyong" style="color: brown;">禁用</span>  
                           		<input type="hidden" value="<?php echo ($vo["id"]); ?>" /><?php endif; ?>	
                           	
                           </td>
                           <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["classname"]); ?></td>
                           <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["name"]); ?></td>
                           <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["content"]); ?></td>
                           <td style="text-align: center; border-left: none;border-top: none"><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
                           <td style="text-align: center; border-left: none;border-top: none">微信.app</td>
                           <td style="text-align: center; border-left: none;border-top: none;border-right: none;">
                             <a href="<?php echo U('Teacher/edit',array('id'=>$vo['id']));?>">回复</a>&nbsp; &nbsp;
                           </td>
                        </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pagination" style="position: relative;bottom: 35px;"><?php echo ($Page); ?></div>
                  </div>
                </form>
        </div>
	<div class="tab-pane fade" id="ios">
	</div>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="js/fileinput.js" type="text/javascript"></script>
<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>

<script>
$('#myTab a:first').tab('show');
</script>
<script>
	  $(".zhuang").click(function(){
	  var zhi=$(".jiyong",this).text();
	 var stataid= $(this).children("input:last-child").val();
	    if(zhi=="禁用"){
	    	  $(".jiyong",this).text("启用")
	    	  $(".jiyong",this).css("color","black");
	    	  var state=1; 
	    }else{
	      $(".jiyong",this).text("禁用")
	      $(".jiyong",this).css("color","brown");
	      var state=0;
	    }
	  $.ajax({
	  	type:"post",
	  	url: "<?php echo U('Teacher/Entrust/declareis');?>",
	  	async:true,
	  	data:{
	  		state:state,
	  		stataid:stataid
	  	},
	  	success: function(res) {  		
	  	},
	  	
	  });  
	  })
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
</body>
</html>