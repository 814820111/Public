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
    <link href="/weixiaotong2016/tpl_teacher/simpleboot/assets/css/mychangestyle.css" rel="stylesheet" />
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
   img{
    margin-left: 23px;
   } 

</style>
<body class="J_scroll_fixed">
<div class="wrap jj" style="margin-bottom: 50px;">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('index');?>">教师信息管理</a></li>
        <li class="active"><a href="<?php echo U('add');?>">添加教师</a></li>
    </ul>

					            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style=" display: none;">
										  <div class="modal-dialog">
										    <div class="modal-content">
										      <div class="modal-header" style="background: white">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;">创建分组</h5>
										        <hr>
										      </div>
										      <div class="modal-body2">
					                
    
										        <p class="text-center">
										          <input type="hidden" class="techar_id" ><br>
                                                  <span style="margin-left: 14px;">分组名称:</span> &nbsp;<input type="text" name="group_name" class="group_name"><br>
										          <span style="margin-left: 14px;">分组序号:</span> &nbsp;<input type="text" class="group_number" name="group_number"><br>
										         </p>
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-default" data-dismiss="modal" style="background: white; color:black; font-weight:bold;">关闭</button>
										        <button class="btn btn-primary grouptj" style="font-weight:bold;" >提交</button>
										      </div>
										   
										    </div>
										  </div>
										</div>  

    <div class="common-form">
        <form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('add_post');?>">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">姓名:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="teacher_name" value="" placeholder="-请输入内容-">&nbsp;<span class="must_red" style="color:red;">*老师姓名是必填项</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">手机号码:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="teacher_phone"  placeholder="-请输入内容-">&nbsp;<span class="must_red" style="color:red;">*老师手机号是必填项</span>
                    </div>
                </div>
                <!--<div class="control-group">-->
                    <!--<label class="control-label">登录密码:</label>-->
                    <!--<div class="controls">-->
                        <!--<input type="password" class="input" id="student_name" name="pass"  placeholder="-请输入内容-">&nbsp;<span class="must_red" style="color:red;">*登录密码必填项</span>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="control-group">-->
                    <!--<label class="control-label">确认密码:</label>-->
                    <!--<div class="controls">-->
                        <!--<input type="password" class="input" id="student_name" name="pass_again" value="" placeholder="-请输入内容-">&nbsp;<span class="must_red" style="color:red;">*确认密码是必填项</span>-->
                    <!--</div>-->
                <!--</div>-->
                  <div class="control-group">
                    <label class="control-label">职位:</label>
                    <div class="controls">
                        <select id="school" name="duty" class="normal_select">
                            <OPTION value="0">请选择</OPTION> 
                            <?php if(is_array($duty_message)): foreach($duty_message as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>  
                        </select>&nbsp;<span class="must_red" style="color:red;">*职位是必填项</span>
                    </div>
                </div>
                <div class="form-group" style=" margin-bottom:10px;">
                    <label class="col-sm-2 control-label" for="inputfile" style=" margin-top:3px;">上传头像：</label>
                      <div  style=""><input type='hidden' name='smeta[thumb]' id='thumb' value=''>
                     
                            <a href='javascript:void(0);' onclick="flashupload_self('thumb_images', '附件上传','thumb',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','','');return false;">
                            
                            <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb_preview' width='80' height='80' style='cursor:hand' /></a>
                           

                            <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                            <input type="button"  class="btn" onclick="$('#thumb_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#thumb').val('');return false;" value="取消图片">
                </div>
                  </div>
                <div class="control-group">
                    <label class="control-label">出生日期:</label>
                    <div class="controls">
                        <input type="text" class="sang_Calender" name="birthday" placeholder="-选择时间-">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">IC卡号:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="ic" value="" placeholder="-请输入内容-">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">在职状态:</label>
                    <div class="controls">
                        <input type="radio" class="input" name="state" value="1" checked><span>在职</span>
                        <input type="radio" class="input" name="state" value="2"><span>离职</span>
                    </div>
                </div>
              
                <div class="control-group">
                    <label class="control-label">邮箱:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="email" value="" placeholder="-请输入内容-">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">教育证号:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="education_card" value="" placeholder="-请输入内容-">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">工号:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="work_card" value="" placeholder="-请输入工号-">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属分组:</label>
                    <div class="controls group">
                    
                    <a class="" style="vertical-align: -3px; cursor:pointer;" data-toggle="modal" data-target="#myModal2" >点击创建</a>
                      
                        <?php if(is_array($department_message)): foreach($department_message as $key=>$to): ?><input type="checkbox" name="department_id[]"  id="check"  value="<?php echo ($to["id"]); ?>" style="    vertical-align: -5px;"><span style="vertical-align: -3px;"><?php echo ($to["name"]); ?></span>&nbsp;<?php endforeach; endif; ?> 
                         
                      
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">教师介绍:</label>
                    <div class="controls">
                        <textarea name="description" style=" width: 500px; height: 200px; resize: none;" class="muban2" placeholder="-请输入内容-"></textarea>
                    </div>
                </div>
            </fieldset>
            <div class="form-actions">
                <!--<input type="hidden" name="id" value="<?php echo ($id); ?>" />-->
                <!--<button type="submit">更新</button>-->
                
                <button class="btn" type="reset">清空</button>
                <button type="submit" class="btn btn-primary btn_submit" style="margin-left: 25px;">提交</button>
                <!--<a class="btn" href="/weixiaotong2016/index.php/Teacher/TeacherInfo/schoollist">清除</a>-->
            </div>
        </form>
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop_self.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<SCRIPT type=text/javascript>
        $(function() {
        $("#school").change(function() {
            $("#class").empty();
            $.getJSON("/weixiaotong2016/index.php?g=apps&m=school&a=getclasslist&schoolid="+$("#school").val(),{},function(data){
                if(data.status=="success"){
                for(var key in data.data){
                    $("#class").append("<option value="+data.data[key]["id"]+">"+data.data[key]["name"]+"</option>");
                }
                }
                if(data.status=="error"){
                    $("#class").append("<option value='0'>没有班级</option>");
                }
            }); 
            });
         $(".grouptj").click(function(){
         	  var group_name = $(".group_name").val();
              
         	  var group_number = $(".group_number").val();
         	  	        $.ajax({
		            type:'get',
		            url: "<?php echo U('Teacher/TeacherInfo/save_de');?>",
		            dataType:'json',
		            data: {
						'group_name': group_name,
						'group_number':group_number,
					},
		            success:function(data){
		                 //console.log(data);
		                if(data.status){

		                  $(".group").append('<input type="checkbox" name="department_id[]"  id="check"  value='+data.msg+' style="    vertical-align: -5px;"><span style="vertical-align: -3px;">'+data.name+'</span>')
		                  $("#myModal2").modal("hide");
		                }else{
		                    alert(data.info);
		                }
		            },
		            //请求失败
		            error:function(){
		               alert('请求失败')
		            }
		        })


         })


        });
</script>
</body>
</html>