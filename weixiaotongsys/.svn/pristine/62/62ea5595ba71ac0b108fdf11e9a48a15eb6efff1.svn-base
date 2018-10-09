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
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
    <![endif]-->

	<link href="/weixiaotong2016/statics/simpleboot/themes/<?php echo C('SP_TEACHER_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <link href="/weixiaotong2016/tpl_teacher/simpleboot/assets/css/mychangestyle.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/weixiaotong2016/statics/simpleboot/css/index.css"/>
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
//全局变量
var GV = {
    HOST:"<?php echo ($_SERVER['HTTP_HOST']); ?>",
    DIMAUB: "/weixiaotong2016/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};

</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta http-equiv="x-ua-compatible" content="IE=8;IE=9;IE=10">
    <link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
    <script src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<style>
    .center{
        width:700px;
    }
    body{overflow-x: hidden;}
</style>
<body>

    <div class="center">
        <form class="layui-form" action="">
                    <table class="table">
                        <thead>
                        <tr style="background-color:#e2e2e2;">
                            <th style=" width:20px;text-align: center;"> </th>
                            <th style=" max-width:100px;text-align: center;">宿舍号(可分配/总床位)</th>
                            <th style=" text-align: center;max-width:500px;">分配</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        <?php if(is_array($room)): foreach($room as $key=>$vo): ?><tr>
                            <td><?php echo $i++; ?></td>
                            <td style="text-align: center;"><?php echo ($vo["roomname"]); ?>(<?php echo ($vo["nullbed"]); ?>/<?php echo ($vo["bednum"]); ?>)</td>
                            <td>
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <input type="checkbox"  title="全选" lay-filter="checkall">
                                         <?php if(is_array($vo["bed"])): foreach($vo["bed"] as $key=>$vos): ?><input type="checkbox" name="bedid[]" value="<?php echo ($vos["bedid"]); ?>" title="<?php echo ($vos["bedname"]); ?>"><?php endforeach; endif; ?>
                                    </div>
                                 </div>
                            </td>
                        </tr><?php endforeach; endif; ?>
                        </tbody>
                    </table>
            <input type="text" name="classid" value="<?php echo ($classid); ?>"  style="display: none">
            <button id="submited" class="layui-btn" lay-submit="" lay-filter="go" style="display: none"></button>
        </form>
    </div>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>
    <script>
        layui.use(['form', 'layedit', 'laydate'], function() {
                var form = layui.form
                    , layer = layui.layer
                    , layedit = layui.layedit
                    , laydate = layui.laydate;
            form.on('checkbox(checkall)', function(data){
                var room = data.value;
                var child = $(data.elem).parents('tr').find('input[type="checkbox"]');
                child.each(function(index, item){
                    item.checked = data.elem.checked;
                });
                form.render('checkbox');
            });
            form.on('submit(go)', function(data){
                var object = data.field;
                //这是核心的代码。
                $.ajax({
                    url : "<?php echo u('Dormitory/dormitory_add_class_bed');?>",
                    type: "post",
                    dataType : "json",
                    data:{
                        data:object
                    },
                    beforeSend: function () {
                        var index = layer.load(1, {
                            shade: [0.1,'#000'] //0.1透明度的白色背景
                        });
                    },
                    success: function(data) {
                        layer.closeAll('loading');
                        if(data.status == "success"){
                            layer.msg("添加成功",{time:1000},function(){
                                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                                parent.layer.close(index);
                                parent.window.location.reload();
                            });
                        }else if(data.status == "error"){
                            layer.msg(data.data);
                        }
                    },
                    error:function(e){
                        layer.msg(e.message);
                    }
                });
                return false;
            });
        })
        //提交
        function jy(){
            $("#submited").click();
        }
    </script>
</body></html>