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
        <li class="active"><a href="#">设备管理</a></li>

    </ul>
    <form class="well form-search" method="post" action="<?php echo U('MonitorDevice/index');?>">
        <div class="mb10">
            <select  class="zhanghao"  name="name" style="width: 180px">
                <option value="">所有账号</option>
                <?php if(is_array($username)): foreach($username as $key=>$vos): $pro=$userid==$vos['id']?"selected":""; ?>
                    <option value="<?php echo ($vos["id"]); ?>" <?php echo ($pro); ?>><?php echo ($vos["name"]); ?></option><?php endforeach; endif; ?>
            </select>
            <select  class="keyword"  name="keywordtype" style="width: 180px">
                <!-- <option value="1">按账号查询查询</option> -->
                <option value="2">按设备名称查询</option>
                <option value="3">按序列号查询</option>
            </select>
            <input type="text" name="keyword" style="width: 230px;" value="<?php echo ($keyword); ?>" placeholder="请输入关键字...">
            <input type="submit" class="btn btn-primary" value="搜索" />
            <input type="button" class="btn btn-warning" value="重置" onclick="urls('MonitorDevice/index')" />
            <input type="button" class="btn btn-warning updatasj" value="更新账号本地数据"  />
        </div>
    </form>
    <?php $status=array("1"=>"在线","0"=>"不在线"); ?>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>账号</th>
            <th>设备序列号</th>
            <th>原设备名称</th>
            <th>设备别名</th>
             <th>设备状态</th>
            <th>数据生成时间</th>
            <th width="180">管理操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($info)): foreach($info as $key=>$vo): ?><tr>
                <td><?php echo ($vo["username"]); ?></td>
                <td><?php echo ($vo["deviceserial"]); ?></td>
                <td><?php echo ($vo["devicename"]); ?></td>
                <td><?php echo ($vo["alias"]); ?></td>
                <td><?php echo ($status[$vo['status']]); ?></td>
                <td><?php echo ($vo["up_date"]); ?></td>
                <td>
                    <!-- <button type="button" class="btn btn-info" onclick="goTo('Monitor/look',<?php echo $vo['id']?>)">查看</button>
                    <button type="button" class="btn btn-success" onclick="goTo('Monitor/editMonitors',<?php echo $vo['id']?>)">修改</button>
                   <button type="button" class="btn btn-danger" onclick="alertMsg('Monitor/deleteMonitors',<?php echo $vo['id']?>)">删除</button>  -->
                    <a class="" href="<?php echo U('MonitorDevice/edit',array('id'=>$vo['id']));?>">修改</a>
                    <br /> 
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <div class="pagination" style="float: left"><?php echo ($page); ?></div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script>
    function urls(url) {
        location.href="/weixiaotong2016/index.php/Admin/"+url;
    }

    $(".updatasj").click(function(){
        var xuan = $(".zhanghao option:selected").val();
        var isSuccess=1;
        if(xuan == 0) {
                alert("请选择要更新数据的账号");
                return false;
        }
        location.href="/weixiaotong2016/index.php/Admin/MonitorDevice/updata?id="+xuan+"" ;
    })

</script>
</body>
</html>