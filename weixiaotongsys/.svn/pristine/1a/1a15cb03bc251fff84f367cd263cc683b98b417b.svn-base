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
			<li><a href="<?php echo U('index');?>">教师信息管理</a></li>
			<li><a href="<?php echo U('Teacher/add',array('school'=>empty($term['schoolid'])?'':$term['schoolid']));?>" target="_self">添加老师</a></li>
			<li class="active"><a href="<?php echo U('Teacher/teacher');?>">批量导入教师</a></li>
			<!--<li><a href="<?php echo U('Import/student');?>">批量导入学生</a></li>-->
			<!--<li><a href="<?php echo U('Import/teacherclass');?>">批量导入任课班级</a></li>-->
    </ul>
<div class="common-form">
        <form method="post" class="form-horizontal" action="<?php echo U('teacher_post');?>"  enctype="multipart/form-data"  onsubmit = "return check()">
            <fieldset>

                <div class="control-group">
							<div class="control-group">
								<label class="control-label">导入文件</label>
								<div class="controls">
									<input type="file" name="excel_file" class="input" value="" accept=".xls">
								</div>
							</div>
							<div class="control-group">
							<label class="control-label">*注意</label>
								<div class="controls">
								仅允许上传后缀名为 .xls 或 .xlsx 的文件. <a href="/weixiaotong2016/statics/excel/teacher_models.xlsx">模板文件下载</a>
								</div>
							</div>
							<?php if(!empty($allcount)): ?><span class="label label-danger">数据导入结果:</span>
							<!-- <label class="label label-danger">数据导入结果：</label> -->
								<div class="controls" style="font-color:red">
								数据总行数:<?php echo ($allcount); ?>,其中[新增数据:<?php echo ($successcount); ?>条,更新数据:<?php echo ($updatecount); ?>]
								</div>
								<div class="controls" style="font-color:red">
								<?php echo ($info); ?>
								</div>
							</div><?php endif; ?>
				</div>
            </fieldset>
            <div class="form-actions">
                <!--<input type="hidden" name="id" value="<?php echo ($id); ?>" />-->
                <!--<button type="submit">更新</button>-->
                <button type="submit" class="btn btn-primary">提交</button>
                <button class="btn" type="reset">清空</button>
                <!--<a class="btn" href="/weixiaotong2016/index.php/Admin/Teacher/schoollist">清除</a>-->
            </div>
        </form>
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<SCRIPT type=text/javascript>


  function check()
  { 


   if(jQuery("input[type='file']").val()==""){
    alert('请选择文件');
    return false;
}

  	return true;
  }


</script>
</body>
</html>