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
        <li class="active"><a href="<?php echo U('index');?>">摄像头管理</a></li>
        <li><a href="<?php echo U('add');?>">新增摄像头</a></li>
    </ul>
    <form class="well form-search" method="post" action="<?php echo U('MonitorChannel/index');?>">
        <div class="mb10">
            <select  class="keyword"  name="keywordtype" style="width: 180px">
                <!-- <option value="0">按名称查询</option> -->
                <option value="1">按学校名称查询</option>
            </select>
            <input type="text" name="keyword" style="width: 230px;" value="<?php echo ($keyword); ?>" placeholder="请输入关键字...">
            <input type="submit" class="btn btn-primary" value="搜索" />
            <input type="button" class="btn btn-warning" value="重置" onclick="urls('MonitorChannel/index')" />
        </div>
    </form>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th><input type="checkbox" id="checkAll" name="" style="vertical-align: -2px">&nbsp;&nbsp;全选</th>
            <th>ID</th>
            <th>设备ID</th>
            <th>摄像头名称</th>
            <th>摄像头别名</th>
            <th>摄像头介绍</th>
           <th>节点</th>
            <th width="180">管理操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($info)): foreach($info as $key=>$vo): ?><tr>
                <td><input type="checkbox" class="checkList" name="delete[]" value="<?php echo ($vo["id"]); ?>"></td>
                <td><?php echo ($vo["id"]); ?></td>
                <td><?php echo ($vo["deviceserial"]); ?></td>
                <td><?php echo ($vo["channelname"]); ?></td>
                <td><?php echo ($vo["nname"]); ?></td>
                <td><?php echo ($vo["content"]); ?></td>
                <td><?php echo ($vo["school_name"]); ?></td>
                <td>
                    <!-- <button type="button" class="btn btn-info" onclick="goTo('Monitor/look',<?php echo $vo['id']?>)">查看</button>
                    <button type="button" class="btn btn-success" onclick="goTo('Monitor/editMonitors',<?php echo $vo['id']?>)">修改</button>
                   <button type="button" class="btn btn-danger" onclick="alertMsg('Monitor/deleteMonitors',<?php echo $vo['id']?>)">删除</button>  -->
                    <a class="" href="<?php echo U('MonitorChannelWeb/edit',array('id'=>$vo['id']));?>">修改</a>
                    <a class="J_ajax_del" href="<?php echo U('MonitorChannelWeb/delete',array('id'=>$vo['id']));?>">删除</a>
                    <br /> 
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <button class="btn btn-warning" id="deleteClick" style="width: 100px;height: 30px;float: left;margin: 20px 20px 20px 0;">删除</button>
    <div class="pagination" style="float: left"><?php echo ($page); ?></div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script>
    function urls(url) {
        location.href="/weixiaotong2016/index.php/Admin/"+url;
    }
    $('#checkAll').click(function () {
        var isChecked = $(this).attr('checked');
        if (isChecked == 'checked'){
            $('.checkList').each(function (k, v) {
                $(this).attr('checked', true);
            });
        }else{
            $('.checkList').each(function (k, v) {
                $(this).attr('checked', false);
            });
        }
    });
    $('#deleteClick').click(function () {
        var ids = [];
        $('.checkList').each(function (k,v) {
            var isChecked = $(this).attr('checked');
            if (isChecked){
                ids.push($(this).val());
            }
        });
        var jsonStr = JSON.stringify(ids);
        //alert(jsonStr);
        if (jsonStr != '[]'){
            $.ajax({
                type: 'post',
                url: '<?php echo U("deleteAll");?>',
                data: {ids: jsonStr},
                dataType: 'json',
                success: function (res) {
                    if (res['status'] == 200){
                        location.href = "<?php echo U('index');?>";
                    }
                },
                error: function () {
                    alert("错误");
                }
            });
        }
    });
</script>
</body>
</html>