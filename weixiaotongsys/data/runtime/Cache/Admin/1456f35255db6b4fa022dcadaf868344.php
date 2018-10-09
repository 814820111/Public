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
  <!-- <link rel="stylesheet" href="/weixiaotong2016/statics/bootstrap/css/bootstrap.css"> -->

  <style type="text/css">
      
 .del{ width: 14px; height: 14px; margin-left: 8px; margin-top: 8px; background-color: red; border-radius: 20px; display: none; cursor:pointer; background-image:url(/weixiaotong2016/statics/images/delete.png); background-size:contain; background-repeat:no-repeat;}

 label{color: black;}

 span{color: black; }

 img{
  width: 80px;
  height: 60px;
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

 table td{
     color: black;
 }

 span {
     color: black;
 }

 div{
     color: black;
 }

 img{
     width: 60px;
     height: 55px;
 }
 .showkey{
     font-size: 10px;
     padding-bottom: 3px;
     padding-top: 3px;
     padding-right: 10px;
     padding-left: 10px;
 }


  </style>
<body class="J_scroll_fixed">
<div class="wrap jj">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('index',get_condition_cache($only_code));?>">学生信息管理</a></li>
        <li class="active"><a href="<?php echo U('add',array('schoolid'=>$schoolid));?>">新增学生</a></li>
    </ul>
    <div class="common-form">
        <form method="post"  class="form-horizontal "  onsubmit="return check()" name="form" id="form" action="<?php echo U('add_post');?>" >
            <fieldset>
                <div class="control-group">
                    <label class="control-label">所属学校:</label>
                    <div class="controls">
                    <span class="mr20">
						<select  class="province"  name="province" id="province" style="width: auto;">
							<option value="">&nbsp;&nbsp;
                        省级选择&nbsp;
                        &nbsp;</option>
							<?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$cache_data['province']==$vo['term_id']?"selected":""; ?>
								<option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>&nbsp;&nbsp;
						市级:
						<select class="select_1" name="citys" id="citys" style="width: auto;">
                               <option value="">请先选择省份</option>
						</select> &nbsp;&nbsp;<input type="hidden" class="new_citys" value="<?php echo ($cache_data["citys"]); ?>">
						区级<input type="hidden" class="new_message_type" value="<?php echo ($cache_data["message_type"]); ?>">
						<select class="select_3" name="message_type" id="message_type" style="width: auto;">
							 <option value="0">请选择你的区域</option>
						</select> &nbsp;&nbsp;
						学校：<input type="hidden" class="type_school" value="<?php echo ($cache_data["schoolid"]); ?>">
				  <select data-placeholder="输入关键字。。。" name="schoolid" id="viewOLanguage" class="chzn-select"  tabindex="2" >
                    <option value=""></option>
                   </select>

  <span class="must_red" style="color:red;">*所属学校是必填项</span>
                    </span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属班级:</label>
                    <div class="controls"> <span style="width: 45%; margin-top: 13px; ">
                        <select class="select_4" name="grade" id="grade" style="width: auto;">
                            <option value="">&nbsp;&nbsp; 年级选择 &nbsp;&nbsp; </option>
                        </select> </span>&nbsp;&nbsp;班级:
                         <span style="width: 45%; margin-top: 13px; ">
                        <input type="hidden" class="new_grade" value="<?php echo ($new_grade); ?>">
                        <select class="select_5" name="classs" id="classs" style="width: auto;">
                            <option value="0">&nbsp; 班级选择 &nbsp; </option>
                        </select></span>
                        <span class="must_red" style="color:red;">*所属班级是必填项</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">姓名:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="student_name" value=""><span class="must_red" style="color:red;">*姓名是必填项</span>
                    </div>
                </div>
                    <div class="control-group">
                    <label class="control-label">联系方式:</label>
                    <div class="controls">
                        <input type="text" class="input" id="phone" name="phone" value=""><span class="must_red" style="color:red;">*联系方式是必填项</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">家长姓名:</label>
                    <div class="controls">
                        <input type="text" class="input" id="student_name" name="parent" value="">
                    </div>
                </div>
             
                <div class="control-group">
                    <label class="control-label">家庭住址:</label>
                    <div class="controls">
                        <input type="text" class="input" id="address" name="address" value="">
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label">IC卡号:</label>
                    <div class="controls">
                        <input type="text" class="input" id="card" name="card" value="">
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label">头像:</label>
                    <div class="controls">

                            <div  style=""><input type='hidden' name='smeta[thumb]' id='thumb' value=''>
                     
                            <a href='javascript:void(0);' onclick="flashupload_self('thumb_images', '附件上传','thumb',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','','');return false;">
                            
                            <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb_preview' width='80' height='80' style='cursor:hand' /></a>
                           

                            <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                            <input type="button"  class="btn" onclick="$('#thumb_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#thumb').val('');return false;" value="取消图片">
                            </div>
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label">籍贯:</label>
                    <div class="controls">
                        <input type="text" class="input" id="native_place" name="native_place" value="">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">性别:</label>
                    <div class="controls">
                        <input type="radio" class="input" name="sex" value="0" checked><span>女生</span>
                        <input type="radio" class="input" name="sex" value="1"><span>男生</span>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">用户类型:</label>
                    <div class="controls">
                        <input type="radio" name="user_type" value="0" checked="checked"><span>学生</span>
                    </div>
                </div>

                 <div class="control-group">
                    <label class="control-label guardian" style="color: #0b7ebf;">监护人信息&nbsp;<span style="color:#0b7ebf;" class="icon-chevron-down"></span></label> <button type="button" class="btn btn-primary tj" style="    margin-left: 780px;">添加监护人</button> <br>
                     <div style="display: none">
                        <div class="controls" style="width: 100%; margin-bottom: 10px;">
                          <span style=" width: 94px;display: inline-block;">监护人姓名:</span><input type="text" class="parent_name" id="parent_name" name="parent_name[]" value="" style="    width: 112px;     margin-right: 15px;"><span style=" width: 94px;display: inline-block; ">与学生关系:</span><input type="text" class="relation" id="card" name="relation[]" value="" style="    width: 112px;     margin-right: 15px;"><span style=" width: 110px;display: inline-block;">监护人手机号:</span><input type="text" class="parent_phone" id="card" name="parent_phone[]" value="" style="    width: 112px;     margin-right: 15px;">
                           <span  class="del" style="display: inline-block;  position: relative; ; "></span>
                        </div>
                          <div class="controls" style="width: 100%; margin-bottom: 10px;">
                          <span style=" width: 94px;display: inline-block;">监护人姓名:</span><input type="text" class="parent_name" id="card" name="parent_name[]" value="" style="    width: 112px;     margin-right: 15px;"><span style=" width: 94px;display: inline-block; ">与学生关系:</span><input type="text" class="relation" id="card" name="relation[]" value="" style="    width: 112px;     margin-right: 15px;"><span style=" width: 110px;display: inline-block;">监护人手机号:</span><input type="text" class="parent_phone" id="card" name="parent_phone[]" value="" style="    width: 112px;     margin-right: 15px;"><span  class="del" style="display: inline-block;  position: relative; ; "></span>
                          
                        </div>
                     </div>
                </div>


            </fieldset>
            <div class="form-actions">
                <!--<input type="hidden" name="id" value="<?php echo ($id); ?>" />-->
                <!--<button type="submit">更新</button>-->
                <button class="btn btn-primary btn_submit">提交</button>
                <button class="btn" type="reset">清空</button>
                <a class="btn" href="/weixiaotong2016/index.php/Admin/Student">返回</a>
                <!--<a class="btn" href="/weixiaotong2016/index.php/Admin/Student/schoollist">清除</a>-->
            </div>
        </form>
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop_self.js"></script>
<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>
<SCRIPT type=text/javascript>

function check(){

    var school = $('body').find('#school').val();

   if(school==0)
   {
    alert('请选择学校');
    return false
   }
    var classid = $('body').find('#classs').val();


    if(classid == 0)
    {
        alert('请选择班级');
        return false
    }

    var student_name = $('body').find('#student_name').val();

    if(student_name == '')
    {
        alert('请输入学生姓名');
        return false
    }

    var phone = $("#phone").val();
    if(!phone)
    {
        alert("联系方式不能为空!");
        return false;
    }

     var parent_name = $('body').find('.parent_name');
     var parent_phone = $('body').find('.parent_phone');

     var relation = $('body').find('.relation');
  
     // console.log(parent_name);
     // console.log(parent_phone);
     // console.log(relation);
    
     for (var i = 0; i < relation.length; i++) {
           
           

                if(parent_name.eq(i).val()!=='' && relation.eq(i).val()=='' )
                {
                   alert('亲属关系未填写!');
                   return false   
                 }
                 if(parent_phone.eq(i).val()!=='' && relation.eq(i).val()=='' )
                {
                   alert('亲属关系未填写!');
                   return false   
                 }
             
             
            
        }   

    return true;


}




  $('.tj').click(function(){
    
     var cout =   $(this).parent().find('.controls');
     var obj = $(this).next().next();
     var sum = cout.length + 1;

 

     obj.append('<div class="controls" style="width: 100%; margin-bottom: 10px;"><span style=" width: 94px;display: inline-block;">监护人姓名:</span><input type="text" class="parent_name" id="card" name="parent_name" value="" style="    width: 112px;     margin-right: 15px;"><span style=" width: 94px;display: inline-block; ">与学生关系:</span><input type="text" class="relation" id="card" name="relation[]" value="" style="    width: 112px;     margin-right: 15px;"><span style=" width: 110px;display: inline-block;">监护人手机号:</span><input type="text" class="parent_phone" id="card" name="parent_phone" value="" style="    width: 112px;     margin-right: 15px;"><a  class="del" style="display: inline-block; position: relative;  "></a></div>');

  })


  $('.guardian').click(function(){
  var aa = $(this).next().next().next();
       
   if(aa.css('display')=='none')
   {
    aa.css('display','block');
    console.log($(this).find('span:eq(0)').attr('class','icon-chevron-up'));
   }else{
    aa.css('display','none');
    $(this).find('span:eq(0)').attr('class','icon-chevron-down')
   }

  })

$(document).on('click','.del',function(){

$(this).parent().remove();

})

//选择市级的下拉的ajax
$(function() {
    $("#province").change(function(){

        $("#citys").empty();
        $("#message_type").empty();
        $("#viewOLanguage").empty();
        $(".Sio").text("")
        $("#viewOLanguage").chosen();
        $("#viewOLanguage").trigger("liszt:updated");
        $("#grade").empty();
        $("#classs").empty();
        $("#viewOLanguage").append("<option value=>"+"请选择学校"+"</option>");
        $("#classs").append("<option value=>"+"请选择年级"+"</option>");
        $("#grade").append("<option value=>"+"请选择学校"+"</option>");

        // $("#student").empty();

        $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
        $("#citys").append("<option value=0>"+"请选择市级"+"</option>");

        if( $("#province").val()==0)
        {
            return false;
        }

        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){


            if(data.status=="success"){


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
        $("#message_type").empty();
        $("#viewOLanguage").empty();
        $(".Sio").text("")
        $("#viewOLanguage").chosen();
        $("#viewOLanguage").trigger("liszt:updated");
        $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
        $("#viewOLanguage").append("<option value=>"+"请选择学校"+"</option>");
        $("#grade").empty();
        $("#classs").empty();
        $("#classs").append("<option value=>"+"请选择年级"+"</option>");
        $("#grade").append("<option value=0>"+"请选择学校"+"</option>");
        if( $("#citys").val()==0)
        {
            return false;
        }

        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
            console.log(data);
            if(data.status=="success"){


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
//选择年级
$(function() {
    $("#viewOLanguage").change(function() {
        $("#grade").empty();
       // $(".Sio").text("")
        $("#classs").empty();
        $("#classs").append("<option value=>"+"请选择年级"+"</option>");
        $("#grade").append("<option value=0>"+"选择年级"+"</option>");
        if( $("#viewOLanguage").val()==0)
        {
            return false;
        }

        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=showgrade&schoolid="+$("#viewOLanguage").val(),{},function(data){
            console.log(data);
            if(data.status=="success"){


                for(var key in data.data){
                    $("#grade").append("<option value="+data.data[key]["gradeid"]+">"+data.data[key]["name"]+"</option>");
                }
            }
            if(data.status=="error"){
                $("#grade").append("<option value='0'>暂无年级</option>");
            }
        });
    });
});
//选择班级
$(function() {
    $("#grade").change(function() {
        $("#classs").empty();
        $("#classs").append("<option value=0>"+"选择班级"+"</option>");
        if( $("#grade").val()==0)
        {
            return false;
        }

        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=showclass&schoolid="+$("#viewOLanguage").val()+"&gradeid="+$("#grade").val(),{},function(data){
            console.log(data);
            if(data.status=="success"){


                for(var key in data.data){
                    $("#classs").append("<option value="+data.data[key]["id"]+">"+data.data[key]["classname"]+"</option>");
                }
            }
            if(data.status=="error"){
                $("#classs").append("<option value='0'>暂无班级</option>");
            }
        });
    });
});
//学校的点击事件

$(".select_3").change(function() {
    $("#viewOLanguage").empty();
    $(".Sio").text("")
    $("#viewOLanguage").chosen();
    $("#viewOLanguage").trigger("liszt:updated");
    $("#viewOLanguage").append("<option value=''>请选择学校</option>");
    $("#grade").empty();
    $("#classs").empty();
    $("#classs").append("<option value=>"+"请选择年级"+"</option>");
    $("#grade").append("<option value=0>"+"请选择学校"+"</option>");
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

            var html = "";
            res = eval(res.data);

            for(var i = 0; i < res.length; i++) {
                var school_name = res[i].school_name; //学校的名字
                var schoolid = res[i].schoolid; //学校的ID
                html += '<option name="school"  class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
            }
            $(".chzn-select").append(html)
            $("#viewOLanguage").chosen();
            $("#viewOLanguage").trigger("liszt:updated");
        },
        error: function() {
            console.log('系统错误,请稍后重试');
        }
    });
})
if($("#province").val())
{
    var new_citys = $('body').find(".new_citys").val();

    var new_message_type = $('body').find('.new_message_type').val();

    // console.log(type);

    var type_school = $('body').find(".type_school").val();



    if(new_citys || $("#province").val())
    {
        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
            console.log(data);
            if(data.status=="success"){
                $("#citys").empty();
                $("#citys").append("<option value=>"+"请选择市级"+"</option>");
                for(var key in data.data){

                    if(new_citys==data.data[key]["term_id"]){
                        $("#citys").append("<option value="+data.data[key]["term_id"]+ " selected >"+data.data[key]["name"]+"</option>");

                    }else{
                        $("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                    }
                }
                $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                    // console.log(data);
                    if(data.status=="success"){
                        $("#message_type").empty();
                        $("#message_type").append("<option value=>"+"请选择区域"+"</option>");

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
                                // $(".Sio").text("")
                                $(".chzn-select").empty();
                                var html = "";
                                res = eval(res.data);


                                for(var i = 0; i < res.length; i++) {
                                    var school_name = res[i].school_name; //学校的名字
                                    var schoolid = res[i].schoolid; //学校的ID

                                    // alert('aa');
                                    // alert(type_school);
                                    if(schoolid == type_school){
                                        // html += '<option class="Sio" value="' + schoolid + ' " selected>' + school_name + ' </option> '
                                        $(".chzn-select").append("<option value="+schoolid+" selected >"+school_name+"</option>");
                                        $("#add_student").attr("data-school",schoolid);

                                    }else{
                                        $(".chzn-select").append("<option value="+schoolid+" >"+school_name+"</option>");
                                    }
                                }
                                $(".chzn-select").append(html)
                                $(".chzn-select").chosen();
                                $(".chzn-select").trigger("liszt:updated");
                            },
                            error: function() {
                                console.log('系统错误,请稍后重试');
                            }
                        });

                        //选择年级
                        if(type_school){
                            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=showgrade&schoolid="+type_school,{},function(data){
                                if(data.status=="success"){
                                    $("#grade").empty();
                                    $("#grade").append("<option value=>"+"请选择年级"+"</option>");

                                    for(var key in data.data){

                                            $("#grade").append("<option value="+data.data[key]["gradeid"]+" >"+data.data[key]["name"]+"</option>");


                                    }
                                }
                                if(data.status=="error"){
                                    $("#grade").append("<option value='0'>暂无年级</option>");
                                }
                            });
                        }
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
$("#viewOLanguage").change(function(){
    var  add_school = $(this).val();
    $("#add_student").attr("data-school",add_school);
})
$("#viewOLanguage").chosen();
$("#viewOLanguage").trigger("liszt:updated");
</script>
</body>
</html>