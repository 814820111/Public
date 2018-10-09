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
<style type="text/css">
 label{color: black;} 


</style>
<body class="J_scroll_fixed">
<div class="wrap jj">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('Teacher/index',get_condition_cache($only_code));?>">教师列表</a></li>
        <li class="active"><a href="<?php echo U('Teacher/edit');?>">修改教师</a></li>
    </ul>
    <div class="common-form">
        <form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('edit_post');?>">
            <fieldset>
                <!-- <div class="control-group">
                    <label class="control-label">学校id:</label>
                    <div class="controls">
                        <input type="text" class="input" name="school_id" value="<?php echo ($school['schoolid']); ?>" readOnly="true">
                    </div>
                </div> -->
                <input type="hidden" name="schoolid" value="<?php echo ($schoolid); ?>">
                <div class="control-group">
                    <label class="control-label">姓名:</label>
                    <div class="controls">
                        <input type="text" class="input" name="name" value="<?php echo ($teacher['name']); ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">性别:</label>
                    <div class="controls" >
                        <input type="radio" class="input" name="sex" value="0" checked><span>女</span>
                        <input type="radio" class="input" name="sex" value="1"><span>男</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">卡号:</label>
                    <div class="controls">
                        <input type="hidden" class="input" name="stu_old_card" value="<?php echo ($card); ?>"  readOnly="true">
                        <input type="text" class="input" name="cardNo" value="<?php echo ($card); ?>">
                    </div>
                </div>
                   <div class="control-group">
                    <label class="control-label">邮箱:</label>
                    <div class="controls">
                      
                        <input type="text" class="input" name="email" value="<?php echo ($teacher['email']); ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">手机号码:</label>
                    <div class="controls">
                        <input type="hidden" class="input" name="teacher_id" value="<?php echo ($teacher['id']); ?>"  readOnly="true">
                        <input type="text" class="input" name="phone" value="<?php echo ($teacher['phone']); ?>">
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label">出生日期:</label>
                    <div class="controls">
                        <input type="date" class="input" name="birthday" value="<?php echo ($birthday); ?>">
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
           
               <!--  <div class="control-group">
                    <label class="control-label">科室:</label>
                    <div class="controls">
                        <select class="input" name="department_id">
                           <?php if(is_array($departmentlist)): foreach($departmentlist as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>    
                        </select>
                    </div>
                </div> 
                <div class="control-group">
                    <label class="control-label">职务:</label>
                    <div class="controls">
                        <select class="input"  name="duty_id">
                           <?php if(is_array($dutylist)): foreach($dutylist as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>    
                        </select>
                    </div>
                </div>    -->
                <div style=""><input type='hidden' name='smeta[thumb]' id='thumb' value="<?php echo ((isset($smeta["thumb"]) && ($smeta["thumb"] !== ""))?($smeta["thumb"]):''); ?>">
                    <label class="control-label" >头像:</label>
                    <a href='javascript:void(0);'
                       onclick="flashupload_self('thumb_images', '附件上传','thumb',thumb_images,'1,jpg|jpeg|gif|png|bmp,1,,,1','','','');return false;"
                       style="margin-left: 20px;">

                        <?php $photosrc = empty($teacher['photo'])?"/weixiaotong2016/statics/images/icon/upload-pic.png" : "/weixiaotong2016/uploads/microblog/$teacher[photo]"; ?>
                        <img src='<?php echo ($photosrc); ?>' id='thumb_preview' width='80' height='60' style='cursor:hand' /></a>

                    </a>
                    <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                    <input type="button" class="btn"
                           onclick="$('#thumb_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#thumb').val('');return false;"
                           value="取消图片">
                </div>
                <div class="control-group" style="margin-top: 15px;">
                    <label class="control-label">教师介绍:</label>
                    <div class="controls">
                        <textarea name="description" style=" width: 500px; height: 200px; resize: none;" class="muban2" placeholder="-请输入内容-" ><?php echo ($teacher['description']); ?></textarea>
                    </div>
                </div>
            </fieldset>
            <input type="hidden" value="<?php echo ($info_id); ?>" name="info_id">
            <div class="form-actions">
                <input type="hidden" name="teacherdutyid" value="<?php echo ($teacherduty["id"]); ?>" />
                <input type="hidden" name="teacherdepartmentid" value="<?php echo ($teacherdepartment["id"]); ?>" />
                <!--<button type="submit">更新</button>-->
                <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">更新</button>
                <a class="btn" href="/weixiaotong2016/index.php/Admin/Teacher">返回</a>
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