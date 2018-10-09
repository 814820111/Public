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
    <![endif]-->
    <link href="/weixiaotong2016/statics/chosen/chosen.css" rel="stylesheet"/>
	<link href="/weixiaotong2016/statics/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <link href="/weixiaotong2016/tpl_admin/simpleboot/assets/css/mychangestyle.css" rel="stylesheet" />
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
var GV = {
    DIMAUB: "/weixiaotong2016/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/validate.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
         label.error{
            display: inline-block;
            margin: 0;
            color: red;
            margin-left: 10px;
        }
	</style><?php endif; ?>

<style>
   
label{color: black;}


</style>
<body class="J_scroll_fixed">
<div class="wrap jj">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('index',get_condition_cache($only_code));?>">学生信息管理</a></li>
        <li class="active"><a href='<?php echo U("Student/edit",array("id"=>$studentid));?>'>修改学生信息</a></li>
        <!--<li><a href="<?php echo U('Student/add',array('school'=>empty($term['schoolid'])?'':$term['schoolid']));?>" target="_self">添加学生</a></li>-->
    </ul>
    <div class="common-form">
        <form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('edit_post');?>">
            <fieldset>
            <input type="hidden" name="schoolid" value="<?php echo ($schoolid); ?>">
                <div class="control-group">
                    <label class="control-label">姓名:</label>
                    <div class="controls">
                        <input type="text" class="input" name="name" value="<?php echo ($student['name']); ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">性别:</label>
                    <div class="controls" >
                        <input type="radio" class="input" name="sex" value="0"  <?php if($student[sex]==0) echo("checked");?> ><span>女</span>
                        <input type="radio" class="input" name="sex" value="1" <?php if($student[sex]==1) echo("checked");?>><span>男</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">住宿情况:</label>
                    <div class="controls" >

                        <input type="radio" class="input" name="in_residence" value="1" <?php if($student[in_residence]==1) echo("checked");?>><span>是</span>
                        <input type="radio" class="input" name="in_residence" value="2" <?php if($student[in_residence]==2) echo("checked");?>><span>否</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">头像:</label>
                    <div class="controls">
                           
                      <div  style="">
                            <?php if($photo == null): ?><input type='hidden' name='smeta[thumb]' id='thumb' value=''>
                            <?php else: ?>
                            <input type='hidden' name='smeta[thumb]' id='thumb' value='/weixiaotong2016/uploads/microblog/<?php echo ($photo); ?>'><?php endif; ?>
                         <?php if($photo == null): ?><a href='javascript:void(0);' onclick="flashupload_self('thumb_images', '附件上传','thumb',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','','');return false;">
                            
                            <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb_preview' width='80' height='80' style='cursor:hand' /></a>
                            <?php else: ?>
                            <a href='javascript:void(0);' onclick="flashupload_self('thumb_images', '附件上传','thumb',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','','');return false;">
                            
                            <img src='/weixiaotong2016/uploads/microblog/<?php echo ($photo); ?>' id='thumb_preview' width='80' height='80' style='cursor:hand' /></a><?php endif; ?>

                            <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                            <input type="button"  class="btn" onclick="$('#thumb_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#thumb').val('');return false;" value="取消图片">
                            </div>
                    </div>
                </div>

                 
                <div class="control-group">
                    <label class="control-label">IC卡号:</label>
                    <div class="controls">
                        <input type="text" class="input" name="newcard" value="<?php echo ($card['cardno']); ?>"><input type="hidden" class="input" name="oldcard" value="<?php echo ($card['cardno']); ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">手机号码:</label>
                    <div class="controls">
                        <input type="text" class="input" name="phone" value="<?php echo ($student['phone']); ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">扣费号码:</label>
                    <div class="controls">
                        <input type="text" class="input" name="charging_phone" value="<?php echo ($student['charging_phone']); ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">入学日期:</label>
                    <div class="controls">
                        <input type="date" class="input" name="initdate" value="<?php echo ($student['initdate']); ?>" id="time">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">出生日期:</label>
                    <div class="controls">
                        <input type="date" class="input" name="birthday" value="<?php echo ($student['birthday']); ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">学号:</label>
                    <div class="controls">
                        <input type="text" class="input" name="stu_id" value="<?php echo ($student['stu_id']); ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">籍贯:</label>
                    <div class="controls">
                        <input type="text" class="input" name="native_place" value="<?php echo ($student['native_place']); ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">家庭住址:</label>
                    <div class="controls">
                        <input type="text" class="input" name="address" value="<?php echo ($student['address']); ?>">
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label">分组:</label>
                    <div class="controls">

                       <?php if(is_array($department)): foreach($department as $key=>$vo): ?><input type="hidden" name="ids[]" value = "<?php echo ($vo["id"]); ?>">
                         <?php if($vo['teacher_status'] != null): ?><input type="checkbox" class="input" name="group[]" value="<?php echo ($vo["id"]); ?>" checked><span class="group_ck" style="    vertical-align: -3px; cursor: pointer;"><?php echo ($vo["name"]); ?></span>
                           <?php else: ?>
                           <input type="checkbox" class="input" name="group[]" value="<?php echo ($vo["id"]); ?>"><span class="group_ck" style="    vertical-align: -3px; cursor: pointer;"><?php echo ($vo["name"]); ?></span><?php endif; endforeach; endif; ?>
                    </div>
                </div>

            </fieldset>
            <div class="form-actions">
                <input type="hidden" class="input" name="student_id" value="<?php echo ($student['id']); ?>"  readOnly="true">
                <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">更新</button>
                <a class="btn" href="<?php echo U('Student/index',$cache_data); ?>">返回</a>
            </div>
        </form>
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop_self.js"></script>
</body>
</html>
<script type="text/javascript">
    




    
        $('.group_ck').click(function(){

         var checked = $(this).prev().attr('checked');

             if(checked){

             $(this).prev().removeAttr("checked");
           }else{
             $(this).prev().attr("checked",true)
           }

        })
</script>