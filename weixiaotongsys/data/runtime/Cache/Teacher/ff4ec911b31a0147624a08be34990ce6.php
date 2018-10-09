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
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
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
	.changecolor{ background-color: #F5F5F5}
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
<div class="">
    <ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:32px; list-style:none;">
        <li><a href="<?php echo U('index');?>" style="color:#1f1f1f">信息群发</a></li>
        <li><a href="<?php echo U('list_info');?>" style="color:#1f1f1f">个性消息</a></li>
      <li class="active"><a href="<?php echo U('lists');?>" style="color:#1f1f1f; text-decoration:none; padding:13px 15px;">发信箱</a></li>
   	</ul>
   	<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
		<div class="tab-pane fade in active" id="home">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('MessageInfo/lists');?>" method="post" style="margin: 0px 0px 5px;">
          <div class="search_type cc mb10">
              <div class="mb10">
               <span class="mr20"><!-- 发送类型：
                      <select class="select_2" name="school">
                          <option value="0">--请选择--</option>
                          <option value="1">全部发送</option>
                          <option value="2">各自发送</option>
                      </select> &nbsp;&nbsp; -->
                      时间：
                      <input type="text" class="sang_Calender" name="begintime" placeholder="-选择时间-" style="width: 180px; height: 30px; border-width: 1px;">  -  <input type="text" class="sang_Calender" name="endtime" placeholder="-选择时间-" style="width: 180px; height: 30px; border-width: 1px;"> &nbsp; &nbsp;
                      关键字：
                      <input type="text" class="select_2" name="search" placeholder="-请输入内容-" style="width: 180px; height: 30px; border-width: 1px;">
                      <input type="submit" value="搜索" class="btn btn-primary" style="margin-left:10px; border-width: 1px; background-color: #26a69a; border-color: #26a69a;">
                  </span>
              </div>
          </div>
			</form>
      <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                      <table class="table table-hover table-bordered table-list" style=" border: none;">
                        <thead>
                          <tr style="background-color:#CCC;">

                            <th class="pai" style="text-align: center; border-width: 0.5px; border-left: none;">信息内容</th>
                            <!-- <th>列表</th> -->
                            <th class="pai" style="text-align: center; border-width: 0.5px; border-left: none;">发送对象</th>
                            <th class="pai" style="text-align: center; border-width: 0.5px; border-left: none;">图片</th>
                            <!-- <th>发送类型</th>
                            <th>状态</th> -->
                            <th class="pai" style="text-align: center; border-width: 0.5px; border-left: none;">发送时间</th>

                          </tr>
                        </thead>
                        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr class="changcolor">

                           <td style="text-align: center; background:none; border-top: none; border-left: none; cursor: pointer; width: 400px;" title="<?php echo ($vo["message_content"]); ?>"><div style="overflow: hidden; white-space: nowrap; text-overflow: clip;width:300px; display: inline-block;text-overflow: ellipsis;"><?php echo ($vo["message_content"]); ?></div></td>
                           <td style="text-align: center; background:none; border-top: none; border-left: none;"><a href="<?php echo U('receive',array('id'=>$vo['id']));?>" ><?php echo ($vo["count"]); ?>个人</a></td>
                           <td style="text-align: center; background:none; border-top: none; border-left: none;">
                              <?php if(!empty($vo['picture_url'])): ?><a>有图片</a><?php endif; ?>
                            <!--   <ul style=" margin: 0;">
                                <?php if(is_array($vo['picture_url'])): foreach($vo['picture_url'] as $key=>$dl): ?><li>                                                                            
                                    <?php $smeta=$dl['picture_url']; ?>
                                    <?php if(!empty($smeta)): ?><a href="<?php echo sp_get_asset_upload_path($smeta);?>" target='_blank'>查看</a><?php endif; ?>
                                  </li><?php endforeach; endif; ?>
                              </ul> -->
                           </td>
                           <td style="text-align: center; background:none; border-top: none; border-left: none;"><?php echo (date("Y-m-d H:i:s",$vo["message_time"])); ?></td>

                        </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pagination"><?php echo ($Page); ?></div>
                  </div>
                </form>
        </div>


	<div class="tab-pane fade" id="ios">
	</div>
   </div>
</div>

<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="js/fileinput.js" type="text/javascript"></script>
<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>

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


            <!--全选 start-->
            <script>
            var change = function(chkArray,val){
                for(var i=0;i<chkArray.length;i++){
                // 遍历指定组中的所有项
                    chkArray[i].checked = val;
                //设置项为指定的值  是否选中
                }
            }
            </script>
            <!-- 全选 end-->

</body>
</html>