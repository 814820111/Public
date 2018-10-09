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
    body{overflow-x: hidden;}
    .pagination {
        float: left;
        display: inline-block;
        padding-left: 0;
        margin: 40px 0;
        border-radius: 4px;
    }
    .center {
        overflow-x: hidden;
    }
</style>
</head>
<body>
<div style="width:600px;">
<div align="center">
    <div id="myTabContent" class="tab-content" style="overflow-x: hidden;">
        <div class="tab-pane fade in active" id="home">
            <br/>
            <form class="form-horizontal J_ajaxForm" action="<?php echo u('Dormitory/dormitory_add_student_bed_class');?>" method="get" style="margin: 0px 0px 5px;">
                <div class="search_type cc mb10">
                    <div class="mb10">
                  <span class="mr20" style="float:left;margin-bottom: 10px;">
                       楼栋名称：
                    <input type="text" value="<?php echo ($buildname); ?>" class="select_2" name="buildname" placeholder="-楼栋名称-" style="width:80px; height: 15px;border-width:1px;" >
                      宿舍号：
                    <input type="text" value="<?php echo ($roomname); ?>" class="select_2" name="roomname" placeholder="-宿舍号-" style="width:80px; height: 15px;border-width:1px;" >
                       状态：
                      <select  class="select_2" name="isbed" style="width: auto;">
                          <option value="3">不选择</option>
                      	<option value="1" <?php if($isbed == '1'){echo "selected";} ?>>未入住</option>
                      	<option value="2" <?php if($isbed == '2'){echo "selected";} ?>>已入住</option>
                          </select>
                      <button type="submit" class="btn btn-default" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 搜索 </button>
 <input type="hidden" name="classid" value="<?php echo ($classid); ?>">
                      <input type="hidden" name="studentid" value="<?php echo ($studentid); ?>">
                      <input type="hidden" name="sex" value="<?php echo ($sex); ?>">
                  </span>
                    </div>
                </div>
            </form>




        <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-list">
                    <thead>
                    <tr style="background-color:#e2e2e2;">

                        <th style=" max-width:20px;text-align: center;"></th>
                        <th style=" max-width:20px;text-align: center;"></th>
                        <th style=" max-width:200px;text-align: center;">楼栋名称</th>
                        <th style=" max-width:200px;text-align: center;">宿舍号</th>
                        <th style=" max-width:200px;text-align: center;">床位号</th>
                        <th style=" max-width:200px;text-align: center;">学生姓名</th>
                    </tr>
                    </thead>
                    <?php $i=1 ?>
                    <?php if(is_array($bedlist)): foreach($bedlist as $key=>$vo): ?><tr>
                        <td style="text-align: center;"><?php echo $i++; ?></td>
                        <td style="text-align: center;"><input type="radio" name="bedid"  value="<?php echo ($vo["bedid"]); ?>"  <?php if(empty($vo['stu_name'])){ echo "title='床位".$vo['bedname']."'";}else{ echo "title='床位已分配，无法选择'disabled"; } ?> ></td>
                        <td style="text-align: center;"><?php echo ($vo["buildname"]); ?></td>
                        <td style="text-align: center;"><?php echo ($vo["roomname"]); ?></td>
                        <td style="text-align: center;"><?php echo ($vo["bedname"]); ?></td>
                        <td style="text-align: center;"><?php echo ($vo["stu_name"]); ?></td>
                    </tr><?php endforeach; endif; ?>
                </table>
                <div class="pagination" style="position: relative;bottom: 35px;"><?php echo ($Page); ?></div>
            </div>
        </form>
    </div>
    </div>

</div>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>
<script>
    layui.use(['layer'], function(){
        var layer = layui.layer;
    });
    function jy(){
        var studentid = "<?php echo ($studentid); ?>";
        var bedid = $('[name=bedid]:checked').val();
        if(bedid == "" || bedid === undefined){
            layer.msg("请选择床位");
            return false;
        }
        $.ajax({
            url : "<?php echo U('Dormitory/dormitory_post_add_student_bed');?>",
            type: "post",
            dataType : "json",
            data:{
                bedid:bedid,
                studentid:studentid
            },
            beforeSend: function () {
                var index = layer.load(1, {
                    shade: [0.1,'#000'] //0.1透明度的白色背景
                });
            },
            success: function(data) {
                layer.closeAll('loading');
                if(data.status == "success"){
                    layer.msg("入住成功",{time:1000},function(){
                        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                        parent.layer.close(index);//关闭弹出的子页面窗口
                        parent.location.reload(); // 父页面刷新
                    });
                }else if(data.status == "error"){
                    layer.msg(data.data);
                }
            },
            error:function(e){
                layer.msg(e.message);
            }
        });

    }
</script>
</body></html>