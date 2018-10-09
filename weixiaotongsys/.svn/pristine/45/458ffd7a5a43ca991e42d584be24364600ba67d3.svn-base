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
    .J_ajaxForm{
        margin:0 auto!important;
        width: 92%;
    }

    .J_ajaxForm:after{
        content: "";
        clear: both;
        display: table;
    }

    .form-horizontal .imgWrapPart{
        float: left;
        margin-left: 20px;
        width: 10%;
    }

    .imgWrapPart img{
        width: 100%;
        height: 140px;
    }

    .imgWrapPart p{
        margin-top: 10px;
    }

    .imgWrapPart input{
        vertical-align: -1px;
    }


</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo U('MonitorTeacher/look', array('id'=> $monitor_id));?>">修改权限</a></li>
        <!--<li><a href="<?php echo U('index');?>">返回视频管理</a></li>-->
    </ul>
    <div class="common-form">
        <form method="post" class="form-horizontal J_ajaxForm " action="<?php echo U('look_post');?>" onsubmit="">
            <fieldset>
                <?php if(!empty($yingShi)){ ?>
                <div style="width: 100%;text-align: left">萤石视频</div>
                <?php foreach($yingShi as $k=>$v){ ?>
                <div class="control-group imgWrapPart">
                    <p>
                        <label style="float: left;margin: 5px 15px 0 0;">
                        <input  <?php if($v['is_checked'] == 1){echo "checked";}?> type="checkbox" class="isMyChecked" name="id_<?php echo $v['type']?>[]" value="<?php echo $v['id'];?>"></input> <?php echo $v['nname']?>
                        </label>
                    </p>
                    <!--<input type="hidden" name="type" value="<?php echo ($vo["type"]); ?>">-->
                </div>
                <?php }?>

                <?php } if(!empty($leCheng)){ ?>
                <div style="width: 100%;text-align: left;float: left;">乐橙视频</div>
                <?php foreach($leCheng as $k=>$v){ ?>
                <div class="control-group imgWrapPart">
                    <p>
                        <label style="float: left;margin: 5px 15px 0 0;">
                        <input <?php if($v['is_checked'] == 1){echo "checked";}?> type="checkbox" class="isMyChecked" name="id_<?php echo $v['type']?>[]" value="<?php echo $v['id'];?>"></input><?php echo $v['nname'];?>
                        </label>
                    </p>
                    <!--<input type="hidden" name="type" value="<?php echo $v['type']?>">-->
                </div>
                <?php }?>
                <?php }?>
                <!--<?php foreach($channelInfo as $k=>$v){?>-->
                <!--<div class="control-group imgWrapPart">-->
                    <!--<p>-->
                        <!--<input type="hidden" name="ids[]" value="<?php echo $v['id'].'-'.$v['is_show']?>">-->
                        <!--<input type="checkbox" class="isMyChecked" <?php if($v['is_show'] == 1){echo "checked";}?> name="auth[]" value="<?php echo $v['id']?>"></input>-->
                        <!--&nbsp;&nbsp;<?php echo $v['nname']?>-->
                    <!--</p>-->
                <!--</div>-->
                <!--<?php }?>-->
            </fieldset>
            <div class="form-actions">
                <input type="hidden" name="monitor_id" value="<?php echo $monitor_id;?>">
                <button type="submit" class="">提交</button>
                <a class="btn" href="/weixiaotong2016/index.php/Admin/MonitorTeacherWeb">返回</a>
            </div>
        </form>
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
</body>
</html>