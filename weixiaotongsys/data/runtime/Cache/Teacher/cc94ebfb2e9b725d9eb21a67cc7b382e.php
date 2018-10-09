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
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
.touchlei{ background-color:#eeeeee;}
tr .pai,tr .pai2{ text-align:center;}
tr .pai{ background-color:#e2e2e2;}
tr .pai2{ background-color:#f5f5f5;}
tr .zufu{background-color: white;}
td .pai2{background-color: white;}
.clearfix{ clear:both;}
.name{ margin-right:10px;}
	.content{ color:#00c1dd;cursor: pointer; margin-left: 10px;}
	.con_box{width:100%; height: 100%; background-color: rgba(0,0,0,0.7);position: absolute;}
	.back{background-color: #adadad; color: white; border: none; padding: 4px 15px; border-radius: 3px; margin-left: 50px;}
#Ttab {
    width: 300px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    color: black;
    display: inline-block;
    margin-left: 10px;
}
</style>

</head>

<div class="">
    <ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
   		<li><a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px; border-bottom: none;">每周食谱创建</a></li>
      <li class="active"><a href="<?php echo U('add');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px; font-weight: bold; border-bottom: none;" class="touch">食谱列表</a></li>
   	</ul>

<!--content_start-->
   <form id="form1" method="post">
	<div class="con_box" style="display: none;">
				<div style=" margin-left: auto; margin-right: auto; width: 550px;background-color: white; margin-top: 50px; height: 70%; padding-top: 10px; padding-bottom: 10px; overflow-y: scroll"">
					<div style=" margin-top: 20px; margin-left: 30px;">
					  <div style="width: 100px; margin-right: 10px;color: #61c881;">详情</div>
					</div>
                    <div style=" margin-top: 20px;">
                        <div style=" width:100px; float: left; text-align: right; margin-right: 10px;">范围：</div>
                        <!--<div id="monday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd; margin-left: 110px; overflow-y: scroll"><textarea style="  width:100%; height: 100%; resize: none;" name="monday"></textarea></div>-->
                        <select name="search_grade" class="search_grade"  disabled = 'disabled'>
                            <option value='0'>--请选择--</option>
                            <?php if(is_array($grade)): foreach($grade as $key=>$vo): ?><!--<?php $gradeinfo=$grade_info==$vo['gradeid']?"selected":""; ?>-->
                                <OPTION value="<?php echo ($vo["gradeid"]); ?>" <?php echo ($gradeinfo); ?>><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>
                        </select>
                        <div class="clearfix"></div>
                    </div>
                   <input type="hidden" name="cookbookid" value="">
                    <div style="margin-top: 10px;">
                        <div style=" width:100px; float: left; text-align: right; margin-right: 10px;">标题：</div>
                        <input type="text" value="" name="cook_title" class="cook_title" style=" height: 29px;color: black;">
                        <div class="clearfix"></div>
                    </div>
                    <div style=" ">
                        <div style=" width:100px; float: left; text-align: right; margin-right: 10px;" >菜谱时间：</div>
                        <input type="text" value="" name="cook_time" class="cook_time" style=" height: 29px; color: black;" readonly="true">
                        <div class="clearfix"></div>
                    </div>
                    <div style=" ">
                        <div style=" width:100px; float: left; text-align: right; " >时间范围：</div>
                          <span id="Ttab" style="cursor: pointer">11</span>
                        <div class="clearfix"></div>
                    </div>

					<div style=" margin-top: 10px; height: 10%;">
						<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期一：</div>
						<!--<div id="monday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd; margin-left: 110px; overflow-y: scroll"><textarea style="  width:100%; height: 100%; resize: none;" name="monday"></textarea></div>-->
						<textarea id="monday" class="a_1" name="monday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd;  overflow-y: scroll"></textarea>
                        <div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb1' value=''>
                            <div style=" ">
                                <a id="pic1" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb1',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

                                    <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb1_preview' width='45' height='60' style='cursor:hand;width:45px;height:48px;' />
                                </a>
                                 <!--<input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                                <input type="button" class="btn" onclick="$('#thumb1_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic1').find('img').remove(); $('#pic1').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb1_preview width=45 height=60 style=cursor:hand />'); $('#thumb1').val('');return false;" value="取消" style=" padding:1px 5px 1px 4px; font-size:14px;">
                            </div>

                        </div>
						<div class="clearfix"></div>
					</div>
					<div style=" margin-top: 20px; height: 10%;">
						<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期二：</div>
						<!--<div id="tuesday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd; margin-left: 110px; overflow-y: scroll"></div>-->
                        <textarea id="tuesday"  class="a_2"  name="tuesday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd;  overflow-y: scroll"></textarea>
                        <div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb2' value=''>
                            <div style=" ">
                                <a id="pic2" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb2',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

                                    <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb2_preview' width='45' height='60' style='cursor:hand;width:45px;height:48px;' />
                                </a>
                                <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                                <input type="button" class="btn" onclick="$('#thumb2_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic2').find('img').remove(); $('#pic2').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb2_preview width=45 height=60 style=cursor:hand />'); $('#thumb2').val('');return false;" value="取消" style=" padding:1px 5px 1px 4px; font-size:14px;">
                            </div>

                        </div>
						<div class="clearfix"></div>
					</div>
					<div style=" margin-top: 20px; height: 10%;">
						<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期三：</div>
						<!--<div id="wednesday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd; margin-left: 110px; overflow-y: scroll"></div>-->
                        <textarea id="wednesday" class="a_3" name="wednesday"  style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd;  overflow-y: scroll"></textarea>
                        <div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb3' value=''>
                            <div style=" ">
                                <a id="pic3" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb3',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

                                    <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb3_preview' width='45' height='60' style='cursor:hand;width:45px;height:48px;' />
                                </a>
                                <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                                <input type="button" class="btn" onclick="$('#thumb3_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic3').find('img').remove(); $('#pic3').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb3_preview width=45 height=60 style=cursor:hand />'); $('#thumb3').val('');return false;" value="取消" style=" padding:1px 5px 1px 4px; font-size:14px;">
                            </div>

                        </div>
						<div class="clearfix"></div>
					</div>
					<div style=" margin-top: 20px; height: 10%;">
						<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期四：</div>
						<!--<div id="thursday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd; margin-left: 110px; overflow-y: scroll"></div>-->
                        <textarea id="thursday" class="a_4" name="thursday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd;  overflow-y: scroll"></textarea>
                        <div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb4' value=''>
                            <div style=" ">
                                <a id="pic4" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb4',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

                                    <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb4_preview' width='45' height='60' style='cursor:hand;width:45px;height:48px;' />
                                </a>
                                <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                                <input type="button" class="btn" onclick="$('#thumb4_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic4').find('img').remove(); $('#pic4').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb4_preview width=45 height=60 style=cursor:hand />'); $('#thumb4').val('');return false;" value="取消" style=" padding:1px 5px 1px 4px; font-size:14px;">
                            </div>

                        </div>
						<div class="clearfix"></div>
					</div>
					<div style=" margin-top: 20px; height: 10%;">
						<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期五：</div>
						<!--<div id="friday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd; margin-left: 110px; overflow-y: scroll"></div>-->
                        <textarea id="friday" class="a_5" name="friday"  style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd;  overflow-y: scroll"></textarea>
                        <div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb5' value=''>
                            <div style=" ">
                                <a id="pic5" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb5',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

                                    <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb5_preview' width='45' height='60' style='cursor:hand;width:45px;height:48px;' />
                                </a>
                                <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                                <input type="button" class="btn" onclick="$('#thumb5_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic5').find('img').remove(); $('#pic5').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb5_preview width=45 height=60 style=cursor:hand />'); $('#thumb5').val('');return false;" value="取消" style=" padding:1px 5px 1px 4px; font-size:14px;">
                            </div>

                        </div>
						<div class="clearfix"></div>
					</div>
                    <div style=" margin-top: 20px; height: 10%;">
                        <div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期六：</div>
                        <!--<div id="friday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd; margin-left: 110px; overflow-y: scroll"></div>-->
                        <textarea id="saturday" class="a_6" name="saturday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd;  overflow-y: scroll"></textarea>
                        <div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb6' value=''>
                            <div style=" ">
                                <a id="pic6" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb6',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

                                    <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb6_preview' width='45' height='60' style='cursor:hand;width:45px;height:48px;' />
                                </a>
                                <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                                <input type="button" class="btn" onclick="$('#thumb6_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic6').find('img').remove(); $('#pic6').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb6_preview width=45 height=60 style=cursor:hand />'); $('#thumb6').val('');return false;" value="取消" style=" padding:1px 5px 1px 4px; font-size:14px;">
                            </div>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div style=" margin-top: 20px; height: 10%;">
                        <div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期日：</div>
                        <!--<div id="friday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd; margin-left: 110px; overflow-y: scroll"></div>-->
                        <textarea id="sunday" class="a_7" name="sunday" style="  width:60%; height:100%; resize: none; border: 1px solid #dddddd;  overflow-y: scroll"></textarea>
                        <div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb7' value=''>
                            <div style=" ">
                                <a id="pic7" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb7',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

                                    <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb7_preview' width='45' height='60' style='cursor:hand;width:45px;height:48px;' />
                                </a>
                                <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                                <input type="button" class="btn" onclick="$('#thumb7_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png;');$('#pic7').find('img').remove(); $('#pic7').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb7_preview width=45 height=60 style=cursor:hand />'); $('#thumb7').val('');return false;" value="取消" style=" padding:1px 5px 1px 4px; font-size:14px;">
                            </div>

                        </div>
                        <div class="clearfix"></div>
                    </div>
        <div style="margin-top: 10px;">
            <div style=" width:100px; float: left; text-align: right; margin-right: 10px;" >发送老师：</div>
            <input type="checkbox" name="teachertype" value="1" ><br>
            <div style=" width:100px; float: left; text-align: right; margin-right: 10px; margin-top: 10px;" >是否定时：</div>
            <input type="checkbox" name="optionsRadiosinline" value="1">&nbsp;<input type="time" class = "plantimming" name="timing" value="09:00" style=" border-width: 1px;width: 95px; height: 28px; color: black;" name="time_wf1"  />
            <div class="clearfix"></div>
        </div>
					<div style=" margin-top: 15px; margin-left: 110px;">
						 <input type="button" class="tijiao" value="确定" style=" background-color: #26a69a; color: white; border: none; padding: 4px 15px; border-radius: 3px;">
						<input type="button" value="取消"  class="back">
					</div>
				</div>
			</div>
</form>

<!--content_end-->
   	<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
		<div class="tab-pane fade in active" id="home">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('lists');?>" method="get">
          <div>
				年级：
			  <select class="select_2" name="search_grade">
                <option value='0'>--请选择--</option>
                <?php if(is_array($grade)): foreach($grade as $key=>$vo): $gradeinfo=$grade_info==$vo['gradeid']?"selected":""; ?>
                   <OPTION value="<?php echo ($vo["gradeid"]); ?>" <?php echo ($gradeinfo); ?>><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>
              </select> &nbsp;&nbsp;
         	    <!-- 班级：
         	    <input type="text" placeholder="-请输入内容-" style="height: 30px; border-width: 1px; border-color: #aaaaaa;"> -->
         	    <!-- 时间：
         	    <input type="text" placeholder="-请输入内容-" style="height: 30px; border-width: 1px; border-color: #aaaaaa;"> -->
         	    <input type="submit" value="查询" style=" background-color: #26a69a; color: white; border: none; padding: 4px 10px; border-radius: 3px; margin-left: 50px;">
          </div>
			</form>
      <form class="J_ajaxForm" action="" method="get">
            <div class="table-responsive">
                      <table class="table table-hover table-bordered table-list">
                        <thead>
                          <tr style="background-color:#CCC;">
                            <th class="pai">范围</th>
                            <th class="pai">标题</th>
                            <!--<th class="pai">星期</th>-->
                            <!--<th class="pai">食譜</th>-->
                            <th class="pai">开始时间</th>
                            <th class="pai">结束时间</th>
                            <th class="pai">创建时间</th>
                            <th class="pai">创建人</th>
                            <th class="pai">是否定时</th>
                            <th class="pai">操作</th>
                          </tr>
                        </thead>
                        <?php if(is_array($cook)): foreach($cook as $key=>$vo): $type=array("1"=>"正规班","2"=>"兴趣班"); $status=array("1"=>"是","0"=>"否"); $gradeid=$vo['grade']==0?'':$vo['grade']; ?>
                        <tr class="zufu"  >
                           <input type="hidden" class="chuanzhi" id="c_id" name="c_id" value="<?php echo ($vo["id"]); ?>">
                           <td class="pai2" style="background-color: white;">
                           		<?php if($vo['grade_name'] == '' ): ?>全校	
								<?php else: ?> 
									<?php echo ($vo["grade_name"]); endif; ?>
                         
                           </td>
                           <td class="pai2" style="background-color: white;"><?php echo ($vo["title"]); ?></td>
                           <!--<td class="pai2" style="background-color: white;"><?php echo ($vo["week"]); ?></td>-->
                           <!--<td class="pai2" style="background-color: white;"><?php echo ($vo["content"]); ?></td>-->
                           <td class="pai2" style="background-color: white;"><?php echo ($vo["mondaydate"]); ?></td>
                           <td class="pai2" style="background-color: white;"><?php echo ($vo["sundaydate"]); ?></td>
                           <td class="pai2" style="background-color: white;"><?php echo ($vo["addtime"]); ?></td>
                           <td class="pai2" style="background-color: white;"><?php echo ($vo["user_name"]); ?></td> 
                           <td class="pai2" style="background-color: white;">
                               <?php if($vo['timingtype'] == 1 ): ?>定时
                                   <?php elseif($vo['timingtype'] == 2 ): ?>
                                       定时已发送
                                   <?php else: ?>
                                   不定时<?php endif; ?>

                           </td>
                           <td class="pai2" style="background-color: white;">
                               <a  class="edit" data-id =<?php echo ($vo['id']); ?> data-teachertype = <?php echo ($vo['teachertype']); ?>  data-grade = <?php echo ($vo['grade']); ?> data-cooktime="<?php echo ($vo['selectdate']); ?>" data-ding = "<?php echo ($vo['timingtype']); ?>" style="color:#00c1dd; cursor: pointer;">编辑</a>
                             <a href="<?php echo U('delete',array('id'=>$vo['id'],'timingtype'=>$vo['timingtype']));?>"  class="J_ajax_del" style="color:#00c1dd;">删除</a>
                             <span class="content">
                             	<input type="hidden" id="content_one" value="<?php echo ($vo["monday"]); ?>">
                             	<input type="hidden" id="content_two" value="<?php echo ($vo["tuesday"]); ?>">
                             	<input type="hidden" id="content_three" value="<?php echo ($vo["wednesday"]); ?>">
                             	<input type="hidden" id="content_four" value="<?php echo ($vo["thursday"]); ?>">
                             	<input type="hidden" id="content_five" value="<?php echo ($vo["friday"]); ?>">
                             	<!-- 详情 -->
                             </span>
                           </td>
                        </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pager"><?php echo ($Page); ?></div>
                  </div>
                </form>
        </div>
        </div>
	<div class="tab-pane fade" id="ios">
	</div>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop.js"></script>
<script>
//	$(".con_box").hide()
//	$(".content").click(
//		function(){
//			$(".con_box").show()
//			var monday=$(this).children("#content_one").val();
//			var tuesday=$(this).children("#content_two").val();
//			var wednesday=$(this).children("#content_three").val();
//			var thursday=$(this).children("#content_four").val();
//			var friday=$(this).children("#content_five").val();
//			$("#monday").text(monday);
//			$("#tuesday").text(tuesday);
//			$("#wednesday").text(wednesday);
//			$("#thursday").text(thursday);
//			$("#friday").text(friday);
//		}
//	)
	$(".back").click(
		function(){
			$(".con_box").hide()

            $("#monday").val("");
            $("#tuesday").val("");
            $("#wednesday").val("");
            $("#thursday").val("");
            $("#friday").val("");
            $("#saturday").val("");
            $("#sunday").val("");
            $("input[name=cookbookid]").val("");
		}
	)
$(".tijiao").click(function(){

    $.ajax({
        type: "post",
        async: false,
        url: "<?php echo U('Teacher/CookManage/edit_post');?>",
        data: $('#form1').serialize(),
        success: function(msg) {
            window.location.reload(); //刷新当前页面.
        },
        error: function() {
            alert('系统错误,请稍后重试');
        }
    });



})

    $(".edit").click(function(){

      var cookbookid  =$(this).attr("data-id");

      var gradeid = $(this).attr("data-grade");

      var title = $(this).parent().parent().find("td:eq(1)").text();

      var plantimming = $(this).attr("data-ding");

      var teachertype  = $(this).attr("data-teachertype");

       time = $(this).attr("data-cooktime");




      if(cookbookid)
      {
          $.ajax({
              type: "get",
              url: '/weixiaotong2016/index.php/?g=Teacher&m=CookManage&a=edit',
              async: true,
              data: {
                  cookbookid: cookbookid,
                  plantimming:plantimming,
                  teachertype:teachertype,

              },
              dataType: 'json',
              success: function(data) {
                  console.log(data);
                  if(data.status){
                      if(data.plantimming!="")
                      {
                            $(".plantimming").val(data.plantimming);
                            $("input[name='optionsRadiosinline']").attr("checked",true);

                      }else{
                          $(".plantimming").val('09:00');
                          $("input[name='optionsRadiosinline']").attr("checked",false);
                      }

                      if(data.teachertype!=0)
                      {

                          $("input[name='teachertype']").attr("checked",true);
                      }else{
                          $("input[name='teachertype']").attr("checked",false);
                      }



                      $(".cook_title").val(title);
                      $(".cook_time").val(time);
                      $(".search_grade").find("option:contains(gradeid)").attr("selected",true);
                      if(time)
                      {
                          var d=getMonDate();
                          var arr=[];
                          for(var i=0; i<7; i++)
                          {
                              arr.push(d.getFullYear()+'年'+(d.getMonth()+1)+'月'+d.getDate()+'日 （'+getDayName(d.getDay())+'）');
                              d.setDate(d.getDate()+1);
                          }
                          $("#Ttab").text(arr);
                          $("#Ttab").css("color","red");
                          $("#Ttab").css("font-size","12px");
                          $("#Ttab").attr("title",arr);
                      }else{
                          $("#Ttab").text('');
                      }
                      $(".search_grade option[value='"+gradeid+"']").attr("selected","selected");

                      $("input[name=cookbookid]").val(cookbookid);
                      var res = data.data

                      for(var i = 0; i < res.length; i++) {

                          var week = res[i]['week'];

                          var  content = res[i]['content'];

                          var pic = res[i]['photo'];

                          var j = 'a_'+week;

                          var k = '#thumb'+week;

                          var test = document.getElementsByClassName(j);

                          if(pic!=0)
                          {

                              var k = '#thumb'+week;
                              $("#thumb"+week+"_preview").attr("src",pic);
                              var pic_val = $(k);
                              $(k).val(pic);
                          }

                          $(test).val(content);
                      }
                      $(".con_box").show();

                  }else{
                      alert(data.info);
                  }
              },
              error: function() {
                  console.log('系统错误,请稍后重试');
              }
          });
      }

    });
function getMonDate()
{

    var d=new Date(time),


        day=d.getDay(),

        date=d.getDate();
//          console.log(d);
    if(day==1)
        return d;
    if(day==0)
        d.setDate(date-6);
    else
        d.setDate(date-day+1);
    return d;
}
// 0-6转换成中文名称
function getDayName(day)
{
    var day=parseInt(day);

    if(isNaN(day) || day<0 || day>6)
        return false;
    var weekday=["星期天","星期一","星期二","星期三","星期四","星期五","星期六"];
    return weekday[day];
}
</script>
</body>
</html>