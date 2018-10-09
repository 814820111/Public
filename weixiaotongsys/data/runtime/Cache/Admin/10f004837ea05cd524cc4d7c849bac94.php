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
        width: 50%;
        height: 60px;
    }

    .imgWrapPart p {
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

</style>
<body class="J_scroll_fixed">
<div class="wrap jj">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('index');?>">授权管理</a></li>
        <li class="active"><a href="<?php echo U('add');?>">新增授权</a></li>
    </ul>
    <div class="common-form">
        <form method="post" class="form-horizontal J_ajaxForm add-validate" action="<?php echo U('camarolist');?>">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">所属省份:</label>
                    <div class="controls">
                        <select  class="province"  name="province" id="province" >
                            <option value="">请选择省份</option>
                            <?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?>
                                <option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属市级:</label>
                    <div class="controls">
                        <select class="select_1" name="citys" id="citys" >

                            <option value="">请先选择市级</option>

                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属区域:</label>
                    <div class="controls">
                        <select class="select_3" name="message_type" id="message_type" style="">
                            <option value="0">请选择区域</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">所属学校:</label>
                    <div class="controls">
                        <select id="school" name="school" class="normal_select" >
                            <OPTION value="">请选择学校</OPTION>
                            <!--<?php if(is_array($schools)): $i = 0; $__LIST__ = $schools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$school): $mod = ($i % 2 );++$i;?>-->
                                <!--<OPTION value="<?php echo ($school["schoolid"]); ?>"><?php echo ($school["school_name"]); ?></OPTION>-->
                            <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属班级:</label>
                    <div class="controls">
                        <SELECT id="class" name="class">
                        </SELECT>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">授权名称:</label>
                    <div class="controls">
                        <input type="text" class="input" id="name" name="name" value="">
                    </div>
                </div>

                <!--<div class="control-group">-->
                <!--<label class="control-label">所属账号:</label>-->
                <!--<div class="controls">-->
                <!--<select id="usermanage" name="usermanage_id" class="normal_select">-->
                <!--<OPTION value="0">请选择账号</OPTION>-->
                <!--<?php if(is_array($usermanage)): $i = 0; $__LIST__ = $usermanage;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$usermanage): $mod = ($i % 2 );++$i;?>-->
                <!--<OPTION value="<?php echo ($usermanage["id"]); ?>"><?php echo ($usermanage["name"]); ?>-->
                <!--<?php if($usermanage["type"] == 1): ?>-->
                <!--(海康)-->
                <!--<?php else: ?>-->
                <!--(大华)-->
                <!--<?php endif; ?>-->
                <!--</OPTION>-->
                <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                <!--</select>-->
                <!--</div>-->
                <!--</div>-->
                <div class="control-group">
                    <label class="control-label">开放时间:</label>
                    <!--<div class="controls">-->
                    <!--&lt;!&ndash;<input type="text" class="input" id="name" name="name" value="">&ndash;&gt;-->
                    <!--</div>-->
                    <div class="controls">
                        <div class="control-group imgWrapPart">
                            <input type="time" style="width: 100px" name="start_time"><input style="width: 100px" type="time"name="end_time">
                            <p style="width: 100%">
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input style="margin-left: 0" type="checkbox" class="isMyChecked" name="days[]"
                                       value="1">星期一</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="checkbox" class="isMyChecked" name="days[]" value="2">星期二</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="checkbox" class="isMyChecked" name="days[]" value="3">星期三</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="checkbox" class="isMyChecked" name="days[]" value="4">星期四</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="checkbox" class="isMyChecked" name="days[]" value="5">星期五</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="checkbox" class="isMyChecked" name="days[]" value="6">星期六</input>
                                </label>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input type="checkbox" class="isMyChecked" name="days[]" value="7">星期天</input>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="form-actions">
                <button type="submit" class="">下一步</button>
                <button class="btn" type="reset">清空</button>
                <a class="btn" href="/weixiaotong2016/index.php/Admin/Monitor">返回</a>
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
            name: {
                required: true
            },
            class: {
                required: true
            },
        },
        messages: {
            school: {
                required: '请输入账号名称'
            },
            name: {
                required: '请输入授权名称'
            },
            class: {
                required: '请选择班级'
            },
        }
    });
    //选择市级的下拉的ajax
    $(function() {
        $("#province").change(function(){


            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                $("#citys").empty()

                if(data.status=="success"){

                    $("#citys").append("<option value=0>"+"请选择市级"+"</option>");
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
    $(".select_3").change(function() {
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
                    html += '<option class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
                }
                $(".normal_select") .append(html)

            },
            error: function() {
                console.log('系统错误,请稍后重试');
            }
        });
    })


    $(function() {
        $("#citys").change(function() {
            console.log($("#citys").val())
            $("#message_type").empty();
            // $("#student").empty();

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
    $(function () {
        $("#school").change(function () {
            $("#class").empty();
            $.getJSON("/weixiaotong2016/index.php?g=apps&m=school&a=getclasslist&schoolid=" + $("#school").val(), {}, function (data) {
                if (data.status == "success") {
                    for (var key in data.data) {
                        $("#class").append("<option value=" + data.data[key]["id"] + ">" + data.data[key]["name"] + "</option>");
                    }
                }
                if (data.status == "error") {
                    $("#class").append("<option value=''>没有班级</option>");
                }
            });
        });
    });

    //获取appsecret
    function get_appSecret(id) {
        if (id == '') {
            $('#appsecret').val('');
            return false;
        }
        //发送ajax获取appsecret
        $.ajax({
            type: 'post',
            data: {id: id},
            url: "/weixiaotong2016/index.php/Admin/Monitor/getAppSecret",
            success: function (msg) {
                $('#appsecret').val(msg);
            },
            error: function () {
                alert('网络出错')
            }
        });
    }

    //获取appkey
    function getAppKeys(type) {
        if (type == '') {
            $('#appKey').val('');
            return false;
        }
        $.ajax({
            type: 'post',
            data: {type: type},
            dataType: 'json',
            url: "/weixiaotong2016/index.php/Admin/Monitor/getAppKey",
            success: function (msg) {
                console.log(msg);
                //$('#appKey').val(msg);
                var str = '<option value="">请选择设备appKey</option>';
                for (var i = 0; i < msg.length; i++) {
                    str += "<option value=" + msg[i]['id'] + ">" + msg[i]['appkey'] + "(" + msg[i]['name'] + ")</option>";
                }
                $('#appKey').html(str);
                $('#appsecret').val('');
            },
            error: function () {
                alert('网络出错')
            }
        });
    }
</script>
</body>
</html>