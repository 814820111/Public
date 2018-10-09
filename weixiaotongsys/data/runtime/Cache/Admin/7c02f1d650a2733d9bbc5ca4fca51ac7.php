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

    .form-horizontal .imgWrapPart {
        float: left;
        width: 25%;
        height: 60px;
        box-sizing: border-box;
    }

    .imgWrapPart p {
        width: 200px;
        margin-top: 10px;
    }

    .imgWrapPart > input {
        vertical-align: -1px;
        margin-right: 20px;
    }

    input.isMyChecked {
        margin-left: 20px;
        vertical-align: -1px;
    }
    #video{
        width: 100%;
        padding-left: 100px;
        box-sizing: border-box;
    }
</style>

<script>
    function checkData(){
        //判断输入的时间是否合格
        var startTime = $('#start_time').val();
        var endTime = $('#end_time').val();
        var val=$('input:radio[name="time"]:checked').val();
        var student=$('input:checkbox[name="student[]"]:checked').length;
        console.log(student);
       if(!$("#school").val())
        {
            return false;
        }
        if(!$("#classid").val())
        {
            return false;
        }

        if(student==0)
        {
            alert("请选择学生");
            return false;
        }

        if(val==null){
            alert("请选择开通时长");
            return false;
        }

    }
</script>
<body class="J_scroll_fixed">
<div class="wrap jj">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('index');?>">学生授权管理</a></li>
        <li class="active"><a href="<?php echo U('add');?>">新增学生授权</a></li>
    </ul>
    <div class="common-form">
        <form method="post" class="form-horizontal J_ajaxForm add-validate" action="<?php echo U('add_post');?>" onsubmit="return checkData()">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">所属学校:</label>
                    <div class="controls">
                        <select id="school" name="school" class="normal_select" >
                            <OPTION value="">请选择学校</OPTION>
                            <?php if(is_array($school)): $i = 0; $__LIST__ = $school;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$school): $mod = ($i % 2 );++$i;?><OPTION value="<?php echo ($school["schoolid"]); ?>"><?php echo ($school["school_name"]); ?></OPTION><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属班级:</label>
                    <div class="controls">
                        <select class="normal_select class" id="classid" name="classid" >
                            <option>请选择班级</option>

                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">学生:</label>
                    <div class="controls" id="student">
                        <!--<label style="float: left;margin: 5px 15px 0 0;">-->
                            <!--<input type="checkbox" style="vertical-align: -1px;"> Check me out-->
                        <!--</label>-->
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">开通时长:</label>
                    <div class="controls">
                        <div class="control-group ">
                            <!--<input type="time" id="start_time" style="width: 100px;" name="start_time">&nbsp;&nbsp;&nbsp;&nbsp;<input id="end_time" style="width: 100px;" type="time" name="end_time">-->
                            <p style="width: 100%;margin-top: 20px">
                                <!--<label style="float: left;margin: 5px 15px 0 0;">-->
                                <!--<input type="checkbox" style="vertical-align: -1px;"> Check me out-->
                                <!--</label>-->
                                <label style="float: left;margin: 5px 15px 0 0;">
                                    <input style="margin-left: 0;vertical-align: -1px;" type="radio" class="isMyChecked"  name="time" value="一个月">一个月</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="radio" class="isMyChecked" name="time" value="两个月">两个月</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="radio" class="isMyChecked" name="time" value="三个月">三个月</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="radio" class="isMyChecked" name="time" value="四个月">四个月</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="radio" class="isMyChecked" name="time" value="五个月">五个月</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="radio" class="isMyChecked" name="time" value="半年">半年</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="radio" class="isMyChecked" name="time" value="一年">一年</input>
                                </label>

                            </p>
                        </div>
                    </div>
                </div>
                <div id="video"></div>
            </fieldset>
            <div class="form-actions">
                <button type="submit" class="">确定</button>
                <!--<button class="btn" type="reset">清空</button>-->
                <a class="btn" href="/weixiaotong2016/index.php/Admin/MonitorStudentWeb">返回</a>
            </div>
        </form>
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<SCRIPT type=text/javascript>
    $('.add-validate').validate({
        rules: {
            school: {
                required: true
            },
            student: {
                required: true
            },
            classid: {
                required: true
            },
        },
        messages: {
            school: {
                required: '请输入账号名称'
            },
            student: {
                required: '请选择老师'
            },
            classid: {
                required: '请选择班级'
            },

        }

    });

    $(function () {
        $("#school").change(function () {
            $(".class").empty();
            $("#student").empty();
            $.getJSON("/weixiaotong2016/index.php/Admin/AdminUtils/schoolclass?schoolid=" + $("#school").val(), {}, function (data) {
                if (data.status=="success") {

                    var html = '';
                    $(".class").append("<option value=>请选择班级</option>");
                    for (var key in data.data) {
                        $(".class").append("<option value="+data.data[key]['id']+">"+data.data[key]['classname']+"</option>");
                        //html += "<label style='float: left;margin: 5px 15px 0 0;'><input type='checkbox' value='"+data[key]["id"] +"' name='teachers[]' style='vertical-align: -1px;'>"+data[key]["name"]+"</label>";
                        //$("#class").append("<option value=" + data[key]["id"] + ">" + data[key]["name"] + "</option>");
                    }
                    //alert(html);
                  //  $("#class").html(html);
                }else{
                    $(".class").append("<option value=>没有班级</option>");
                }

            });
        });
    });


    $(function () {
        $(".class").change(function () {
            $("#student").empty();
            $.getJSON("/weixiaotong2016/index.php/Admin/MonitorStudentWeb/getStudent?schoolid=" + $("#school").val()+"&classid="+$(".class").val(),{}, function (data) {
                if (data) {
                    var html = '';
                    for (var key in data) {
                        html += "<label style='float: left;margin: 5px 15px 0 0;'><input type='checkbox' value='"+data[key]["id"] +"' name='student[]' style='vertical-align: -1px;'>"+data[key]["name"]+"</label>";
                        //$("#class").append("<option value=" + data[key]["id"] + ">" + data[key]["name"] + "</option>");
                    }
                    //alert(html);
                    $("#student").html(html);
                }else{
                    $("#student").append("没有学生");
                }
                if (data.status == "error") {
                    $("#student").append("没有学生");
                }
            });
        });
    });
    $(function () {
        $(":checkbox").change(function () {
            $("#student").empty();
            $.getJSON("/weixiaotong2016/index.php/Admin/MonitorStudentWeb/getStudent?schoolid=" + $("#school").val()+"&classid="+$(".class").val(),{}, function (data) {
                if (data) {
                    var html = '';
                    for (var key in data) {
                        html += "<label style='float: left;margin: 5px 15px 0 0;'><input type='checkbox' value='"+data[key]["id"] +"' name='student[]' style='vertical-align: -1px;'>"+data[key]["name"]+"</label>";
                        //$("#class").append("<option value=" + data[key]["id"] + ">" + data[key]["name"] + "</option>");
                    }
                    //alert(html);
                    $("#student").html(html);
                }else{
                    $("#student").append("没有学生");
                }
                if (data.status == "error") {
                    $("#student").append("没有学生");
                }

            });
        });
    });

</script>
</body>
</html>