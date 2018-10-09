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
<body class="J_scroll_fixed">
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
<style type="text/css">
    
img{
    margin-left: 23px;
    height: 60px;
    width: 80px;
}

    .wraps {
        width: 120px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        color: black;
    }

    .chzn-container-single .chzn-single {
        position: relative;
        top: 12px;
        height: 29px;
    }

    .mohu {
        width: 100px;

        bottom: 30px;
        left: 30px;
        background-color: whitesmoke;
    }

    .dbzr {
        background-color: #61c881;
        color: white;
        text-align: center;
        padding: 0px 15px;
        float: left;
        border-radius: 8px;
    }



    .sic {
        width: 15px;
        margin-left: 5px;
        margin-top: -15px;
        cursor: pointer;
    }


</style>
<div class="wrap jj">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('index',get_condition_cache($only_code));?>">教师信息管理</a></li>
        <li class="active"><a href="<?php echo U('add');?>">添加教师</a></li>
    </ul>
    <div class="common-form">
        <form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('add_post');?>">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">省份选择:</label>

                    <select  class="province"  name="province" id="province" style="width: auto;margin-left: 21px;">
                        <option value="">&nbsp;&nbsp;&nbsp;省级选择&nbsp;&nbsp;&nbsp;</option>
                        <?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?>
                            <option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                    </select>&nbsp;&nbsp;
                    市级：
                    <input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>">
                    <select name="citys" class="citys"  id="citys" style="width: auto;">
                        <option value="0">请先选择省份</option>
                    </select>&nbsp;&nbsp;

                    区域:&nbsp;
                    <input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>">
                    <select name="city_next" class="select_3" id="message_type" style="width: auto;">
                        <option value="0">请选择你的区域</option>
                    </select>&nbsp;&nbsp;
                </div>
               <div class="control-group">
                    <label class="control-label">所属学校:</label>
                    <div class="controls">
                        <select id="school" name="school" class="normal_select" data-placeholder="输入关键字。。。"   tabindex="2" >
                            <OPTION value="0">请选择学校</OPTION>
                            <?php if(is_array($schools)): $i = 0; $__LIST__ = $schools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$school): $mod = ($i % 2 );++$i;?><OPTION value="<?php echo ($school["schoolid"]); ?>" ><?php echo ($school["school_name"]); ?></OPTION><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select><span class="must_red" style="color:red;">*所属学校是必填项</span>
                    </div>
                </div>
               
              

                <div class="control-group">
                    <label class="control-label">职务:</label>
                    <div class="controls">
                        <select id='duty' name="du" class="duty">
                            <OPTION value="0">请选择职务</OPTION> 
                           
                        </select><span class="must_red" style="color:red;">*职务是必填项</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">姓名:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="teacher_name" value=""><span class="must_red" style="color:red;">*姓名是必填项</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">手机号码:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="teacher_phone" value=""><span class="must_red" style="color:red;">*手机号码是必填项</span>
                    </div>
                </div>
                     <div class="control-group">
                    <label class="control-label">登录密码:</label>
                    <div class="controls">
                        <input type="password"   name="pass"  placeholder="-请输入密码-"><span class="must_red" style="color:red;">*登录密码位空的话就默认为手机后六位</span>
                    </div>
                </div>
                <!--<div class="control-group">-->
                    <!--<label class="control-label">确认密码:</label>-->
                    <!--<div class="controls">-->
                        <!--<input type="password"   name="pass_again" value="" placeholder="-请确认密码-"><span class="must_red" style="color:red;">*确认密码是必填项</span>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="control-group">
                    <label class="control-label">性别:</label>
                    <div class="controls">
                        <input type="radio" class="input" name="sex" value="0" checked><span>女</span>
                        <input type="radio" class="input" name="sex" value="1"><span>男</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">用户类型:</label>
                    <div class="controls">
                        <input type="radio" name="user_type" value="0" checked="checked"><span>教师</span>
                    </div>
                </div>
                <div class="form-group" style=" margin-bottom:10px;">
                    <label class="col-sm-2 control-label" style=" margin-top:3px;">上传头像：</label>

                   
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
                        <input type="text" class="input J_datetime" name="birthday" placeholder="-选择时间-">
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
                    <label class="control-label">所属分组:</label>
                    <div class="controls">
                        <select  name="dep" id="dep" class="normal_select1">
                            <OPTION value="0">请选择分组</OPTION>
                                <?php if(is_array($department)): foreach($department as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>    
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">工号:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="work_card" value="" placeholder="-请输入内容-">
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
                <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">提交</button>
                <button class="btn" type="reset">清空</button>
                <!--<a class="btn" href="/weixiaotong2016/index.php/Admin/Teacher/schoollist">清除</a>-->
            </div>
        </form>
        <input type = "hidden" value="<?php echo ($schoolid); ?>" id="new_schoolid">
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop_self.js"></script>
<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>
<SCRIPT type=text/javascript>
        $(function() {
        $("#school").change(function() {
        	layer.load();
            $("#dep").empty();
            console.log($("#school").val());
            $.getJSON("/weixiaotong2016/index.php?g=admin&m=Teacher&a=department&schoolid="+$("#school").val(),{},function(data){
                if(data.status=="success"){
                   $("#dep").append("<option value='0'>请选择</option>");
                for(var key in data.data){
                    $("#dep").append("<option value="+data.data[key]["id"]+">"+data.data[key]["name"]+"</option>");
                }
                }
                if(data.status=="error"){
                    $("#dep").append("<option value='0'>没有分组</option>");
                }
            }); 

            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=teacher_duty&schoolid="+$("#school").val(),{},function(data){
            	$("#duty").empty();
            			 setTimeout(function(){
                      layer.closeAll('loading');
                    });
                if(data.status=="success"){
                	
                   $("#duty").append("<option value='0'>请选择</option>");
                for(var key in data.data){
                    $("#duty").append("<option value="+data.data[key]["id"]+">"+data.data[key]["name"]+"</option>");
                }
                }
                if(data.status=="error"){
                    $("#duty").append("<option value='0'>没有职务</option>");
                }
            }); 

           });
        });

        //选择市级的下拉的ajax
        $(function() {
            $("#province").change(function(){
                $("#citys").empty();

                $("#message_type").empty();
                $("#school").empty();
                $(".Sio").text("")
                $("#school").chosen();
                $("#school").trigger("liszt:updated");

                $("#message_type").append("<option value=>"+"请选择区域"+"</option>");


                $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                    $("#citys").empty()

                    if(data.status=="success"){


                        $("#citys").append("<option value>"+"请选择市级"+"</option>");
                        for(var key in data.data){
                            $("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                        }
                    }
                    if(data.status=="error"){
                        $("#citys").append("<option value='0'>没有市级</option>");
                    }
                });


            })
        });

        $(function() {
            $("#citys").change(function() {
                console.log($("#citys").val())
                $("#message_type").empty();
                // $("#student").empty();
                $("#school").empty();
                $(".Sio").text("")
                $("#school").chosen();
                $("#school").trigger("liszt:updated");


                $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
                $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                    console.log(data);
                    if(data.status=="success"){

                        // $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
                        for(var key in data.data){
                            $("#message_type").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                        }
                    }
                    if(data.status=="error"){
                        $("#message_type").append("<option value='0'>暂无区域</option>");
                    }
                });
            });
        });




        $(".select_3").change(function() {
            var type = $(".select_3  option:selected").val();
            $("#school").empty();
            $(".Sio").text("")
            $("#school").chosen();
            $("#school").trigger("liszt:updated");

            $.ajax({
                type: "post",
                url: '/weixiaotong2016/index.php/?g=Admin&m=AdminUtils&a=lookup',
                async: true,
                data: {
                    type: type
                },
                dataType: 'json',
                success: function(res) {
                    $(".Sio").text("")
                    var html = "";
                    res = eval(res.data);
                    for(var i = 0; i < res.length; i++) {
                        var school_name = res[i].school_name; //学校的名字
                        var schoolid = res[i].schoolid; //学校的ID
                        html += '<option class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
                    }
                    $("#school").append("<option value='0'>请选择学校</option>");
                    $("#school").append(html)
                    $("#school").chosen();
                    $("#school").trigger("liszt:updated");
                },
                error: function() {
                    console.log('系统错误,请稍后重试');
                }
            });
        })

        if($("#province").val())
        {

            // console.log($("#province").val());
            var new_citys = $('body').find(".new_citys").val();


            var new_message_type = $('body').find('.new_message_type').val();




            var type_school = $('body').find(".type_school").val();

            var new_schoolid = $("#new_schoolid").val();


            if(new_citys)
            {
                $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                    // console.log(data);
                    if(data.status=="success"){
                        $("#citys").empty();
                        $("#citys").append("<option value=>"+"请选择市级"+"</option>");
                        for(var key in data.data){

                            if(new_citys==data.data[key]["term_id"]){
                                $("#citys").append("<option value="+data.data[key]["term_id"]+ " selected>"+data.data[key]["name"]+"</option>");

                            }else{
                                $("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                            }
                        }
                        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                            // console.log(data);
                            if(data.status=="success"){
                                $("#message_type").empty();

                                for(var key in data.data){
                                    if(new_message_type == data.data[key]["term_id"]){
                                        $("#message_type").append("<option value="+data.data[key]["term_id"]+" selected >"+data.data[key]["name"]+"</option>");
                                    }else{
                                        $("#message_type").append("<option value="+data.data[key]["term_id"]+" >"+data.data[key]["name"]+"</option>");
                                    }

                                }
                                var type = $(".select_3  option:selected").val();

                                $.ajax({
                                    type: "post",
                                    url: '/weixiaotong2016/index.php/?g=Admin&m=AdminUtils&a=lookup',
                                    async: true,
                                    data: {
                                        type: type
                                    },
                                    dataType: 'json',
                                    success: function(res) {

                                        $(".Sio").text("")
                                        var html = "";
                                        res = eval(res.data);
                                        for(var i = 0; i < res.length; i++) {
                                            var school_name = res[i].school_name; //学校的名字
                                            var schoolid = res[i].schoolid; //学校的ID
                                            if(schoolid == new_schoolid){
                                                $(".normal_select").append("<option value="+schoolid+" selected >"+school_name+"</option>");
                                            }else{
                                                $(".normal_select").append("<option value="+schoolid+" >"+school_name+"</option>");
                                            }
                                        }

                                        $(".normal_select").append(html)
                                        $(".normal_select").chosen();
                                        $(".normal_select").trigger("liszt:updated");
                                        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=teacher_duty&schoolid="+$("#school").val(),{},function(data){
                                            $("#duty").empty();
                                            setTimeout(function(){
                                                layer.closeAll('loading');
                                            });
                                            if(data.status=="success"){

                                                $("#duty").append("<option value='0'>请选择</option>");
                                                for(var key in data.data){
                                                    $("#duty").append("<option value="+data.data[key]["id"]+">"+data.data[key]["name"]+"</option>");
                                                }

                                            }
                                            if(data.status=="error"){
                                                $("#duty").append("<option value='0'>没有职务</option>");
                                            }
                                            $("#dep").empty();
                                            console.log($("#school").val());
                                            $.getJSON("/weixiaotong2016/index.php?g=admin&m=Teacher&a=department&schoolid="+$("#school").val(),{},function(data){
                                                if(data.status=="success"){
                                                    $("#dep").append("<option value='0'>请选择</option>");
                                                    for(var key in data.data){
                                                        $("#dep").append("<option value="+data.data[key]["id"]+">"+data.data[key]["name"]+"</option>");
                                                    }
                                                }
                                                if(data.status=="error"){
                                                    $("#dep").append("<option value='0'>没有分组</option>");
                                                }
                                            });

                                        });



                                    },
                                    error: function() {
                                        console.log('系统错误,请稍后重试');
                                    }
                                });



                            }
                            if(data.status=="error"){
                                $("#message_type").append("<option value='0'>没有区域</option>");
                            }
                        });



                    }
                    if(data.status=="error"){
                        $("#citys").append("<option value='0'>没有市级</option>");
                    }
                });

            }


        }
        $("#school").change(function(){
            var  add_school = $(this).val();
            $("#add_student").attr("data-school",add_school);
        })
        $("#school").chosen();
        $("#school").trigger("liszt:updated");
</script>
</body>
</html>