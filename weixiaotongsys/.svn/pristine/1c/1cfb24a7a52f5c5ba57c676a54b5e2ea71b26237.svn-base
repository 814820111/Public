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
  select{
    color: black;
  }
       img{
    margin-right: 10px;
        margin-bottom: 5px;
  }
</style>

<body>
      <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
            <li class="active"><a href="<?php echo U('add');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">上传照片</a></li>
            <li ><a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">相册列表</a></li>
      </ul>

<div style="margin-left: 25px;">
<form action="<?php echo U('ClassAlbum/add_post');?>" method="post" class="form-horizontal js-ajax-forms" >
    <div style=" margin-top: 20px;">
        <div style="width: 100px; float: left; text-align: right; margin-right: 10px;">年级：</div>
        <select name='grade' class="form-control" id="school_grade">
            <option value=''>请选择年级</option>
            <?php if(is_array($categorys)): foreach($categorys as $key=>$vo): ?><OPTION value="<?php echo ($vo['gradeid']); ?>"><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>
        </select>
        <div class="clearfix"></div>
    </div>
    <div style=" margin-top: 20px;">
        <div style="width: 100px; float: left; text-align: right; margin-right: 10px;">班级：</div>
        <select name='class' class="form-control" id="school_class">
            <option value=''>请选择班级</option>
            <?php if(is_array($class)): foreach($class as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></option><?php endforeach; endif; ?>
        </select>
        <div class="clearfix"></div>
    </div>

    <div style=" margin-top: 20px;">
        <div style="width: 100px; float: left; text-align: right; margin-right: 10px;">相册描述内容：</div>
        <input type="text" style="width: 500px;height: 200px; color: black;" name="content" value="" placeholder="请输入内容"/>
        <span class="form-required">*</span>
        <div class="clearfix"></div>
    </div>

    <div  class="control-group">
        <!--上传start-->
        <div class="form-group" style=" margin-bottom:10px; margin-top:20px; margin-left:0px;">
            <label class="col-sm-2" style=" margin-top:3px; padding-left:1%;padding-right:0; width:160px">上传附件：</label>
             <div  style=" width: 543px; margin-left: 113px;"><input type='hidden' name='smeta[thumb]' id='thumb2' value=''>
                       <div style=" width: 300px; margin-left: -8px;">
                        <a id="pic" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb2',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=0','');return false;">

                            <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb2_preview' width='80' height='60' style='cursor:hand' />
                            </a>
                        <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                          <input type="button" class="btn" onclick="$('#thumb2_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic').find('img').remove(); $('#pic').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb2_preview width=80 height=60 style=cursor:hand />'); $('#thumb2').val('');return false;" value="取消图片" style=" padding:5px 8px 5px 8px; font-size:14px;">
                         </div>
                       
                    </div>
        </div>



        <div class="form-actions">
            <div class="col-sm-offset-2 col-sm-10">
                 <button type="reset" class="btn btn-default" style="border:none;;color:#111; background-color:#adadad"> &nbsp;清 &nbsp;空&nbsp; </button>
                <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn" style="border:none;;color:#FFF; background-color:#26a69a; margin-left:10%;"> &nbsp;发  &nbsp;送&nbsp; </button>
           
            </div>
        </div>

    </div>



      <!--<div class="row-fluid">-->
        <!--<div class="span9">-->
          <!--<table class="table table-bordered">-->
            <!--<tr>-->
              <!--<th width="80">年级</th>-->
              <!--<td>-->
                  <!--<div class="col-sm-1">-->
                     <!--<select name='grade' class="form-control" >-->
                         <!--<option value='0'></option>-->
                          <!--<?php if(is_array($categorys)): foreach($categorys as $key=>$vo): ?>-->
                          <!--<option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></option>-->
                          <!--<?php endforeach; endif; ?>-->
                    <!--</select>-->
                  <!--</div>-->
              <!--</td>-->
            <!--</tr>-->
            <!--<tr>-->
              <!--<th width="80">班级</th>-->
              <!--<td>-->
                  <!--<div class="col-sm-1">-->
                    <!--<select name='class' class="form-control" >-->
                        <!--<option value='0'></option>-->
                        <!--<?php if(is_array($categorys)): foreach($categorys as $key=>$vo): ?>-->
                        <!--<option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></option>-->
                        <!--<?php endforeach; endif; ?>-->
                    <!--</select>-->
                  <!--</div>-->
              <!--</td>-->
            <!--</tr>-->
            <!--<tr>-->
            <!--<th>相册描述内容</th>-->
              <!--<td>-->
                <!--<input type="text" style="width: 500px;height: 200px;" name="content" value="" placeholder="请输入内容"/>-->
                <!--<span class="form-required">*</span>-->
              <!--</td>-->
            <!--</tr>-->
          <!--</table>-->

          <!--<div  class="control-group">-->
               <!--&lt;!&ndash;上传start&ndash;&gt;-->
              <!--<div class="form-group" style=" margin-bottom:10px; margin-top:20px; margin-left:0px;">-->
                    <!--<label class="col-sm-2" style=" margin-top:3px; padding-left:8%;padding-right:0; width:160px">上传附件：</label>-->
                    <!--<div  style="text-align: center; width: 400px;">-->
                    <!--<input type='hidden' name='smeta[thumb]' id='thumb' value=''>-->
                    <!--<a href='javascript:void(0);' onclick="flashupload('thumb_ima', '附件上传','thumb',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','','');return false;">-->
                    <!--<img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb_preview' width='135' height='113' style='cursor:hand' /></a>-->
                 <!--&lt;!&ndash; <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  &ndash;&gt;-->
                    <!--<input type="button"  class="btn" onclick="$('#thumb_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#thumb').val('');return false;" value="取消图片">-->
                    <!--</div>-->
              <!--</div>-->
                  <!---->
             <!---->

              <!--<div class="form-actions">-->
                <!--<div class="col-sm-offset-2 col-sm-10">-->
                    <!--<button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn" style="border:none;;color:#FFF; background-color:#26a69a; margin-right:10%;"> &nbsp;发  &nbsp;送&nbsp; </button>-->
                    <!--<button type="reset" class="btn btn-default" style="border:none;;color:#111; background-color:#adadad"> &nbsp;重 &nbsp;置&nbsp; </button>-->
                <!--</div>-->
              <!--</div>-->

          <!--</div>-->
          <!---->
       <!---->
      <!--</div>-->
        <!--</div>-->
      
    </form>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop.js"></script>
      <script>
          $(function() {
              $("#school_grade").change(function() {
                  $("#school_class").empty();
                  $.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherUtils&a=get_class&grade="+$("#school_grade").val(),{},function(data){
                      if(data.status=="success"){
                          $("#school_class").append("<option value=0>"+"请选择班级"+"</option>");
                          for(var key in data.data){
                              $("#school_class").append("<option value="+data.data[key]["id"]+">"+data.data[key]["classname"]+"</option>");
                          }
                      }
                      if(data.status=="error"){
                          $("#school_class").append("<option value='0'>没有班级</option>");
                      }
                  });
              });
          });
      </script>
</body>
</html>