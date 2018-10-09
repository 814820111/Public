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
<div class="wrap J_check_wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo U('index');?>">授权管理</a></li>
        <li><a href="<?php echo U('add');?>">新增授权</a></li>
    </ul>
    <form class="well form-search" method="post" action="<?php echo U('Monitor/index');?>">
        <div class="mb10">
            <select  class="keyword" onchange="getClassBySchoolId(this.value)"  name="school_id" style="width: 180px">
                <!-- <option value="0">按名称查询</option> -->
                <option value="0">请选择学校</option>
                <?php foreach($schools as $k=>$v){?>
                    <option value="<?php echo $v['schoolid']?>"><?php echo $v['school_name']?></option>
                <?php }?>
            </select>
            <select  class="keyword" id="classId"  name="class_id" style="width: 180px">
                <!-- <option value="0">按名称查询</option> -->
                <option value="0">请选择班级</option>
            </select>
            <input type="submit" class="btn btn-primary" value="搜索" />
            <input type="button" class="btn btn-warning" value="重置" onclick="urls('MonitorWeb/index')" />
        </div>
    </form>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>名称</th>
            <th>学校</th>
            <th>班级</th>
            <th>开放星期</th>
            <th>开放时间</th>
           <th>授权摄像头</th>
            <th width="180">管理操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr>
                <td><?php echo ($vo["monitor_id"]); ?></td>
                <td><?php echo ($vo["name"]); ?></td>
                <td><?php echo ($vo["school_name"]); ?></td>
                <td><?php echo ($vo["class_name"]); ?>(<?php echo ($vo["classid"]); ?>)</td>
                <td><?php echo ($vo["day"]); ?></td>
                <td><?php echo ($vo["time"]); ?></td>
                <td><?php echo ($vo["monitor_nname"]); ?></td>
                <td>
                    <a class="" href="<?php echo U('MonitorWeb/look',array('id'=>$vo['monitor_id']));?>">更改授权</a>
                    <!-- <button type="button" class="btn btn-info" onclick="goTo('Monitor/look',<?php echo $vo['id']?>)">查看</button>
                    <button type="button" class="btn btn-success" onclick="goTo('Monitor/editMonitors',<?php echo $vo['id']?>)">修改</button>
                   <button type="button" class="btn btn-danger" onclick="alertMsg('Monitor/deleteMonitors',<?php echo $vo['id']?>)">删除</button>  -->
                    <a class="" href="<?php echo U('MonitorWeb/editMonitorTime',array('id'=>$vo['monitor_id']));?>">修改开发时间</a>
                    <a class="J_ajax_del" href="<?php echo U('MonitorWeb/deleteMonitors',array('id'=>$vo['monitor_id']));?>">删除</a>
                    <br /> 
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <div class="pagination"><?php echo ($page); ?></div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script>
    function urls(url) {
        location.href="/weixiaotong2016/index.php/Admin/"+url;
    }
    function getClassBySchoolId(id) {
        $.ajax({
            type: 'post',
            data: {id: id},
            dataType: 'json',
            url: "/weixiaotong2016/index.php/Admin/MonitorWeb/getClassBySchoolId",
            success: function(msg) {
                if (msg){
                    $('.class_option').remove();
                    var str = '';
                    for (var i = 0; i < msg.length; i++){
                        str += "<option class='class_option' value='"+msg[i]['id']+"'>"+msg[i]['classname']+"</option>";
                    }
                    //alert(str);
                    $('#classId').append(str);
                }
            },
            error: function() {
                alert('网络出错')
            }
        });
    }
</script>
</body>
</html>