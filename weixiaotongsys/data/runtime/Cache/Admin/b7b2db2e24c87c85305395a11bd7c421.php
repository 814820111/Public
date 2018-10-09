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

    .form-horizontal .imgWrapPart{
        float: left;
        width: 50%;
        height: 60px;
    }

    .imgWrapPart p{
        margin-top: 10px;
    }

    .imgWrapPart > input{
        vertical-align: -1px;
        margin-right: 20px;
    }
    input.isMyChecked{
        vertical-align: -1px;
    }

</style>
<body class="J_scroll_fixed">
<div class="wrap jj">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('editTime', array('id'=>$monitor_id));?>">修改开放时间</a></li>
        <!--<li class="active"><a href="<?php echo U('add');?>">新增授权</a></li>-->
    </ul>
    <div class="common-form">
        <form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('editTime_post');?>">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">开放时间:</label>
                    <div class="controls">
                        <div class="control-group imgWrapPart">
                            <input type="time" name="start_time" value="<?php echo $timeInfo['start_time']?>" placeholder="开始时间，例如：00:12"><input type="time" value="<?php echo $timeInfo['end_time']?>" name="end_time" placeholder="结束时间,例如：00:42">
                            <p style="width: 100%">
                                <?php $i = 0; foreach($timeInfo['days'] as $v){ ++$i; if($i == 1) $o = '一'; if($i == 2) $o = '二'; if($i == 3) $o = '三'; if($i == 4) $o = '四'; if($i == 5) $o = '五'; if($i == 6) $o = '六'; if($i == 7) $o = '天'; ?>
                                <label style="float: left;margin: 5px 15px 0 0;">
                                <input <?php if($v != 0){echo "checked";}?> style="margin-left: 0" type="checkbox" class="isMyChecked"  name="days[]" value="<?php echo $i?>">星期<?php echo $o;?></input>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                </label>
                                <!--<input type="checkbox" class="isMyChecked"  name="days[]" value="2">星期二</input>-->
                                <!--<input type="checkbox" class="isMyChecked"  name="days[]" value="3">星期三</input>-->
                                <!--<input type="checkbox" class="isMyChecked"  name="days[]" value="4">星期四</input>-->
                                <!--<input type="checkbox" class="isMyChecked"  name="days[]" value="5">星期五</input>-->
                                <!--<input type="checkbox" class="isMyChecked"  name="days[]" value="6">星期六</input>-->
                                <!--<input type="checkbox" class="isMyChecked"  name="days[]" value="7">星期天</input>-->
                                <?php }?>
                            </p>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="form-actions">
                <input type="hidden" name="monitor_id" value="<?php echo $monitor_id;?>">
                <button type="submit" class="">确定</button>
                <!--<button class="btn" type="reset">清空</button>-->
                <a class="btn" href="/weixiaotong2016/index.php/Admin/MonitorTeacherWeb">返回</a>
            </div>
        </form>
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
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
        });

        //获取appsecret
            function get_appSecret(id) {
                if(id == '') {
                    $('#appsecret').val('');
                    return false;
                }
                //发送ajax获取appsecret
                $.ajax({
                    type: 'post',
                    data: {id: id},
                    url: "/weixiaotong2016/index.php/Admin/Monitor/getAppSecret",
                    success: function(msg) {
                        $('#appsecret').val(msg);
                    },
                    error: function() {
                        alert('网络出错')
                    }
                });              
            }

        //获取appkey
        function getAppKeys(type) {
            if(type == '') {
                $('#appKey').val('');
                return false;
            }
            $.ajax({
                    type: 'post',
                    data: {type: type},
                    dataType: 'json',
                    url: "/weixiaotong2016/index.php/Admin/Monitor/getAppKey",
                    success: function(msg) {
                        console.log(msg);
                        //$('#appKey').val(msg);
                        var str = '<option value="">请选择设备appKey</option>';
                        for(var i = 0; i < msg.length; i++) {
                            str += "<option value="+msg[i]['id']+">"+msg[i]['appkey']+"("+msg[i]['name']+")</option>";
                        }
                        $('#appKey').html(str);
                        $('#appsecret').val('');
                    },
                    error: function() {
                        alert('网络出错')
                    }
            });      
        }
</script>
</body>
</html>