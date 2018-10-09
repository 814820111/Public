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
        <li class="active"><a href="<?php echo U('index');?>">账号管理</a></li>
        <li><a href="<?php echo U('add');?>">新增账号</a></li>
    </ul>
    <form class="well form-search" method="post" action="<?php echo U('UserManage/index');?>">
                <div class="mb10">
                    <select  class="keyword"  name="keywordtype" style="width: 130px">
                        <!-- <option value="0">按名称查询</option> -->
                        <option value="1">按appkey查询</option>
                    </select>
                    <input type="text" name="keyword" style="width: 230px;" value="<?php echo ($keyword); ?>" placeholder="请输入关键字...">
                    <input type="submit" class="btn btn-primary" value="搜索" />
                    <input type="button" class="btn btn-warning" value="重置" onclick="urls('UserManage/index')" />
                </div>  
    </form>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th width="50">
                <div class="checkbox">
                    <label>
                      <input type="checkbox">
                    </label>
                </div>
            </th>
            <th>ID</th>
            <th>名称</th>
            <th>appKey</th>
            <th>appSecret</th>
            <th>token</th>
            <th>类型</th>
            <th>管理员账号</th>
            <th>用户名</th>
            <th>密码</th>
            <th width="120">管理操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($lists)): foreach($lists as $key=>$v): ?><tr>
                <td>
                    <div class="checkbox">
                    <label>
                      <input type="checkbox" name="checkboxs[]" value="<?php echo ($v["id"]); ?>">
                    </label>
                </div>
                </td>
                <td><?php echo ($v["id"]); ?></td>
                <td><?php echo ($v["name"]); ?></td>
                <td><?php echo ($v["appkey"]); ?></td>
                <td><?php echo ($v["secret"]); ?></td>
                <td><?php echo ($v["token"]); ?></td>
                <td>
                    <?php if($v['type'] == 1): ?>海康威视
                         <?php else: ?>
                         大华<?php endif; ?>
                </td>
                <td><?php echo ($v["mobile"]); ?></td>
                <td><?php echo ($v["username"]); ?></td>
                <td><?php echo ($v["password"]); ?></td>
                <td>
                   <a class="" href="<?php echo U('UserManage/change',array('id'=>$v['id']));?>">修改</a>
                   <!-- <button type="button" class="btn btn-success" onclick="goTo('UserManage/change',<?php echo $v['id']?>)">修改</button>
                   <button type="button" class="btn btn-danger" onclick="alertMsg('UserManage/delete',<?php echo $v['id']?>)">删除</button>  -->
                   <a class="J_ajax_del" href="<?php echo U('UserManage/delete',array('id'=>$v['id']));?>">删除</a>
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
</script>
</body>
</html>