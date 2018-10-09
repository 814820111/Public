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
<div class="wrap jj">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('index');?>">学校列表</a></li>
        <li><a href='<?php echo U("classmanage",array("schoolid"=>$schoolid,"schoolname"=>$schoolname));?>'>班级管理</a></li>
        <li class="active"><a href='<?php echo U("addclass",array("schoolid"=>$schoolid,"schoolname"=>$schoolname));?>'>添加班级</a></li>
    </ul>
    <div class="common-form">
        <form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('addclass_post');?>"><!--  -->
            <fieldset>
                <div class="control-group">
                    <label class="control-label">学校:</label>
                    <div class="controls">
                        <input type="text" class="input" name="school_name" value="<?php echo ($schoolname); ?>" readOnly="true">
                        <input type="hidden" name="school_id" value="<?php echo ($school_id); ?>" />
                        <span class="must_red" style="color:red;">*添加班级时,如小一班、小二班.....以此类推</span>
                    </div>
                </div>
              <div class="control-group">
                	<label class="control-label">选择年级段:</label>&nbsp;&nbsp;&nbsp;

                    <select  class="province dian"name="grade_name" >
                    	 <option value="">请选择年级段</option>
                    <?php if(is_array($school_gradename)): foreach($school_gradename as $key=>$vo): ?><option value="<?php echo ($vo["gradeid"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="control-group">
                    <label class="control-label">班级名称:</label>
                    <div class="controls">
                        <input type="text" class="input classname" name="class_name" value="">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所在级部:</label>
                    <div class="controls">
                     <select  class="province"name="grade_type" >
                        <option value="">请选择班级类型</option>
                        <option value="1">正规班级</option>
                        <option value="2">兴趣班</option>
                    </select>
                    </div>
                </div>

            </fieldset>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">添加</button>
                <a class="btn" href='<?php echo U("classmanage",array("schoolid"=>$schoolid,"schoolname"=>$schoolname));?>'>返回</a>
            </div>
        </form>
    </div>
    <input type="hidden" class="shuzhu" value="<?php echo ($schoolid); ?>" />
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script>
//	$(".classname").click(function(){
//		var Province =$(".dian option:selected").text();
//		var classname=Province+"(一班)";
//           $(".classname").val(classname);
//	})
	
</script>
</body>
</html>