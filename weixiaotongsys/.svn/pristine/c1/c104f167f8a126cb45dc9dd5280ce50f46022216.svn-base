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
<link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle; color: black;}
.picList li{margin-bottom: 5px;}
.touchlei{ background-color:#eeeeee;}
tr .pai,tr .pai2{ text-align:center; font-size: 14px;}
tr .pai{ background-color:#e2e2e2;}
tr .pai2{ }
.clearfix{ clear:both;}
.name{ margin-right:10px;}
    select{
        color: black;
    }
</style>

</head>
<body>
<div class="">
    <ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
   		<li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">教师课程表</a></li>
   	</ul>
   	<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
		<div class="tab-pane fade in active" id="home">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('index');?>" method="post" style="margin: 0px 0px 5px;">
          <div class="search_type cc mb10">
              <div class="mb10">
                  <span class="mr20">
                      教师: 
                      <select class="select_2" name="search_teacher">
                        <option value='0'>--请选择--</option>
                        <?php if(is_array($teacher)): foreach($teacher as $key=>$vo): $teacherid=$tea_id==$vo['teacherid']?"selected":""; ?>
                           <OPTION value="<?php echo ($vo["teacherid"]); ?>" <?php echo ($teacherid); ?> ><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;
                      <input type="submit" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;" value="搜索" />
                  </span>
              </div>
          </div>
			</form>
      <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                      <table class="table table-hover table-bordered table-list">
                        <thead>
                          <tr style="background-color:#CCC;">
                            <th class="pai" style="border-left: none;border-width: 0.5px;">节次</th>
                            <th class="pai" style="border-left: none;border-width: 0.5px;">星期一</th>
                            <th class="pai" style="border-left: none;border-width: 0.5px;">星期二</th>
                            <th class="pai" style="border-left: none;border-width: 0.5px;">星期三</th>
                            <th class="pai" style="border-left: none;border-width: 0.5px;">星期四</th>
                            <th class="pai" style="border-left: none;border-width: 0.5px;">星期五</th>
                            <th class="pai" style="border-left: none;border-width: 0.5px;">星期六</th>
                            <th class="pai" style="border-left: none;border-width: 0.5px;border-right: none">星期天</th>
                          </tr>
                        </thead>
                        <?php if(is_array($relation)): foreach($relation as $key=>$vo): $type=array("1"=>"第一节","2"=>"第二节","3"=>"第三节","4"=>"第四节","5"=>"第五节","6"=>"第六节","7"=>"第七节","8"=>"第八节"); ?>
                        <tr>
                           <td class="pai2 cid" style="border-left: none;border-top: none;"><?php echo ($type[$vo['syllabus_no']]); ?></td>
                           <td class="pai2" style="border-left: none;border-top: none;">
                              <?php if(is_array($vo['teacher_subject'])): foreach($vo['teacher_subject'] as $key=>$to): ?><!--                               <?php $mo=empty($to['monday'])?'':$to['monday']; ?>
                              <if condition="$mo eq ''">
                                未安排
                              <else\> -->
                                  <?php echo ($to["monday_classname"]); ?><span style=" color: red"><?php echo ($to["monday"]); ?></span><?php endforeach; endif; ?>
                           </td>
                           <td class="pai2" style="border-left: none;border-top: none;">
                              <?php if(is_array($vo['teacher_subject'])): foreach($vo['teacher_subject'] as $key=>$to): echo ($to["tuesday_classname"]); ?><span style=" color: red"><?php echo ($to["tuesday"]); ?></span><?php endforeach; endif; ?>
                           </td>
                           <td class="pai2" style="border-left: none;border-top: none;">
                              <?php if(is_array($vo['teacher_subject'])): foreach($vo['teacher_subject'] as $key=>$to): echo ($to["wednesday_classname"]); ?><span style=" color: red"><?php echo ($to["wednesday"]); ?></span><?php endforeach; endif; ?>
                           </td>
                           <td class="pai2" style="border-left: none;border-top: none;">
                              <?php if(is_array($vo['teacher_subject'])): foreach($vo['teacher_subject'] as $key=>$to): echo ($to["thursday_classname"]); ?><span style=" color: red"><?php echo ($to["thursday"]); ?></span><?php endforeach; endif; ?>
                           </td>
                           <td class="pai2" style="border-left: none;border-top: none;">
                              <?php if(is_array($vo['teacher_subject'])): foreach($vo['teacher_subject'] as $key=>$to): echo ($to["friday_classname"]); ?><span style=" color: red"><?php echo ($to["friday"]); ?></span><?php endforeach; endif; ?>
                           </td>
                           <td class="pai2" style="border-left: none;border-top: none;">
                              <?php if(is_array($vo['teacher_subject'])): foreach($vo['teacher_subject'] as $key=>$to): echo ($to["saturday_classname"]); ?><span style=" color: red"><?php echo ($to["saturday"]); ?></span><?php endforeach; endif; ?>
                           </td>
                           <td class="pai2" style="border-left: none;border-top: none;border-right: none;">
                              <?php if(is_array($vo['teacher_subject'])): foreach($vo['teacher_subject'] as $key=>$to): echo ($to["sunday_classname"]); ?><span style=" color: red"><?php echo ($to["sunday"]); ?></span><?php endforeach; endif; ?>
                           </td>
                        </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pagination"><?php echo ($Page); ?></div>
                  </div>
                </form>
        </div>
        </div>
	<div class="tab-pane fade" id="ios">
	</div>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>

<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
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
						$(".touch").addClass("touchlei")
						}
			)
			 $(".touch").mouseleave(
					function(){
						$(".touch").removeClass("touchlei")
						}
			)
            </script>
 <script>
 $(".bantan").hide()
  $(".banzhuren").click(
 			function(){
				$(".bantan").show()
				}
 )
 $(".banzhuren").click(
 			function(){
				w=$(this).text()
				$(".bzr").text(w)
				}
 )
$(".xuan").click(
			function(){
				k=$(this).parent().text()
				$(".bzr").text(k)
				}
)
 </script>
 <script>
 $(".guan").click(
 			function(){
				$(".bantan").hide()
				}
 
 )
 </script>
 <script>
 $(".xiala").click(
 			function(){
				$(".shou01").slideToggle()
        $(".xshang").toggle()
        $(".bianzi").toggle()
				}
 
 )
 </script>
 <script>

   $(".daibanzhuren").click(
      function(){
      w=$(this).parent().index()
      $(".chuanzhi").val(w)
      }
    )

    function sub_qrcj() {
    var main_id =w;
    var teachers = $("input[name='teachers']").val();
    // var main_id = $("input[name='main_id']").val();
    $.ajax({
      type:"post",
      async:false,
      url:"<?php echo U('Teacher/ClassManage/teachers');?>",
      data:{'teachers': teachers,'main_id':main_id},
      success: function(msg){
        history.go(0);
      }
    });
  }
  </script>
  <script>
  $(".daitan").hide()
  $(".daibanzhuren").click(
        function(ID){
        $(".daitan").show()
        l=$(this).text()
        $(".dbzr").text(l)
        }
  )
  </script>

   <script>
 $(".guan").click(
      function(){
        $(".daitan").hide()
        }
 
 )
 </script>
 <script>
  
  $(".name").hide()
  $(".xuan2").click(
        function(){
          o=$(this).parent().index()
          $(".name").eq(o).toggle()
          $(".dbzr").hide()
          }
  )
 </script>
 <script type="text/javascript">
   

 </script>
</body>
</html>