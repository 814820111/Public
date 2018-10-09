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
<title>宿舍入住管理</title>
<style>
    .list_loucen_td tr td{
        text-align: center;
        border-left: none;
        border-top: none;
        max-height:10px;
    }
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }
</style>
<body>
<div>
<ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none;">
    <li class="active"><a href="<?php echo U('Dormitory/dormitory_student');?>" style="color:#1f1f1f;text-decoration: none;">宿舍入住管理</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="home">
        <br/>
        <form class="form-horizontal J_ajaxForm" action="<?php echo u('Dormitory/dormitory_student');?>" method="get" style="margin: 0px 0px 5px;">
            <div class="search_type cc mb10">
                <div class="mb10">
                  <span class="mr20">班级：
                    <input type="text" value="<?php echo ($classname); ?>" class="select_2" name="classname" style="width:8%; height: 15px;border-width:1px;">

                      <button type="submit" class="btn btn-default" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 查 询 </button>

                  </span>
                </div>
            </div>
        </form>




        <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-list">
                    <thead>
                    <tr style="background-color:#e2e2e2;">

                        <th style=" text-align: center;"></th>
                        <th style=" text-align: center;">班级名称</th>
                        <th style=" text-align: center;">班级住宿人数</th>
                        <th style=" text-align: center;">住宿男(人)</th>
                        <th style=" text-align: center;">分配男(床位) </th>
                        <th style=" text-align: center;">入住男(人) </th>
                        <th style=" text-align: center;">未入住男(人) </th>
                        <th style=" text-align: center;">住宿女(人)</th>
                        <th style=" text-align: center;">分配女(床位) </th>
                        <th style=" text-align: center;">入住女(人) </th>
                        <th style=" text-align: center;">未入住女(人) </th>
                        <th style=" text-align: center;">操作 </th>
                    </tr>
                    </thead>
                    <?php $dormitory_statuses=array("1"=>"男","2"=>"女","3"=>"混住");$i=0; ?>
                    <?php if(is_array($class)): foreach($class as $key=>$vo): ?><tr>
                            <td style="text-align: center;"><?php echo $i++; ?></td>
                            <th style=" text-align: center;"><?php echo ($vo["classname"]); ?></th>
                            <th style=" text-align: center;"><?php echo ($vo["studentnum"]); ?></th>
                            <th style=" text-align: center;"><?php echo ($vo["man"]); ?></th>
                            <th style=" text-align: center;"><?php echo ($vo["manbednum"]); ?> </th>
                            <th style=" text-align: center;"><?php echo ($vo["mannum"]); ?></th>
                            <th style=" text-align: center;"><?php echo $vo[man]-$vo[mannum]; ?> </th>
                            <th style=" text-align: center;"><?php echo ($vo["woman"]); ?></th>
                            <th style=" text-align: center;"><?php echo ($vo["womanbednum"]); ?> </th>
                            <th style=" text-align: center;"><?php echo ($vo["womannum"]); ?> </th>
                            <th style=" text-align: center;"><?php echo $vo[woman]-$vo[womannum]; ?>  </th>
                            <td style="text-align: center;">
                                <a style=" color:#00c1dd;" href="<?php echo u('Dormitory/dormitory_student_room');?>?classid=<?php echo ($vo["classid"]); ?>">分配床位</a>|
                                <a style=" color:#00c1dd;" href="<?php echo u('Dormitory/dormitory_student_bed');?>?classid=<?php echo ($vo["classid"]); ?>">学生住宿管理</a>|
                                <a style=" color:#00c1dd;" class="initialization_btn" data-classid="<?php echo ($vo["classid"]); ?>">初始化</a>
                            </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <div class="pagination" style="position: relative;bottom: 35px;"><?php echo ($Page); ?></div>
            </div>
        </form>
    </div>

</div>
</div>

<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
<script src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>

<script>
    layui.use(['layer'], function(){
        var layer = layui.layer;
    });
    //初始化班级
    $('.initialization_btn').click(function () {
        var classid = $(this).attr('data-classid');
                    if (confirm("将删除该班级下所有床位并取消该班级下的所有床位的保留状态，是否确定初始化?")) {
                        $.ajax({
                            url: "<?php echo u('Dormitory/dormitory_class_initialization');?>",
                            type : 'post',
                            dataType : 'json',
                            data : {
                                classid:classid
                            },
                            success : function(data) {
                                if("success" == data.status){
                                    layer.msg("初始化成功" , {
                                        icon: 1
                                        ,shade:  false,
                                    });
                                    window.location.reload();
                                }else{
                                    layer.msg(data.data);
                                }
                            },
                            //请求失败
                            error:function(){
                                layer.msg(e.message , {
                                    icon: 2
                                    ,shade: false,
                                });
                            }
                        });
                    }
    })

</script>
</body>
</html>