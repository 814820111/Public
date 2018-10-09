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
<title>学生床位管理</title>
<style>
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }
</style>
<body>
<ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none;">
    <li><a href="<?php echo U('Dormitory/dormitory_student');?>" style="color:#1f1f1f;text-decoration: none;">宿舍入住管理</a></li>
    <li class="active"><a href="" style="color:#1f1f1f;text-decoration: none;">学生床位管理</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="home">
        <br/>
        <form class="form-horizontal J_ajaxForm" action="<?php echo u('Dormitory/dormitory_student_bed');?>" method="get" style="margin: 0px 0px 5px;">
            <div class="search_type cc mb10">
                <div class="mb10">
                  <span class="mr20">

                    学生姓名：
                    <input type="text" value="<?php echo ($stu_name); ?>" class="select_2" name="stu_name" placeholder="-学生姓名-" style="width:8%; height: 15px;border-width:1px;">
                      性别：
                      <select  class="select_2" name="sex" style="width: auto;">
                      	<option value="3" >不选择</option>
                      	<option value="0" <?php if($sex == '0'){echo "selected";} ?>>男</option>
                          <option value="1" <?php if($sex == '1'){echo "selected";} ?>>女</option>
                          </select>
                         状态：
                      <select  class="select_2" name="isbed" style="width: auto;">
                      	<option value="3" >不选择</option>
                      	<option value="1" <?php if($isbed == '1'){echo "selected";} ?>>已安排床位</option>
                          <option value="2" <?php if($isbed == '2'){echo "selected";} ?>>未安排床位</option>
                          </select>
<input type="hidden" name="classid" value="<?php echo ($classid); ?>">
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

                        <th style=" text-align: center; border-width: 0.5px; border-left: none"></th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">学生姓名</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">班级</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">性别</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">宿舍号</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">床位号</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">操作</th>
                    </tr>
                    </thead>
                    <?php $sex_statuse=array("0"=>"男","1"=>"女");$i=0; ?>
                    <?php if(is_array($student)): foreach($student as $key=>$vo): ?><tr>
                            <td style="text-align: center; border-left: none;border-top: none;"> <?php echo $i++; ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["stu_name"]); ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo ($classname); ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo $sex_statuse[$vo[sex]]; ?></td>
                            <td style="text-align: center; border-left: none;border-top: none">
                                <?php if(empty($vo['roomname'])): ?>未安排
                                    <?php else: ?>
                                    <?php echo ($vo["roomname"]); endif; ?></td>
                            <td style="text-align: center; border-left: none;border-top: none">
                                <?php if(empty($vo['bedname'])): ?>未安排
                                    <?php else: ?>
                                    <?php echo ($vo["bedname"]); endif; ?></td>

                            <td style="text-align: center; border-left: none;border-top: none">

                                <?php if($vo['bedid'] == 0 ): ?><a  style=" color:#00c1dd;" onclick="addStudent(<?php echo ($classid); ?>,<?php echo ($vo["studentid"]); ?>,<?php echo ($vo["sex"]); ?>);" >入住</a>
                                 <?php else: ?>
                                    入住<?php endif; ?>
                                | <?php if($vo['bedid'] == 0 ): ?>退宿
                                <?php else: ?>
                                <a style=" color:#00c1dd;" class="cancel_bed_btn" data-bedid="<?php echo ($vo["bedid"]); ?>">退宿</a><?php endif; ?>
                            </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <div class="pagination" style="position: relative;bottom: 35px;"><?php echo ($Page); ?></div>
            </div>
        </form>
    </div>
    <div class="tab-pane fade" id="ios">
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

    //学生入住
    function addStudent(classid,studentid,sex) {

        layui.use(['layer'], function() {
            var $ = layui.jquery,
                layer = layui.layer;

            var index = layer.open({
                type: 2,
                id	: 1,
                title: '添加床位',
                btn: ['提交', '关闭'],
                area: ['600px', '500px'],
                offset : ['20px', '200px'],
                maxmin: true,
                content: "<?php echo U('Dormitory/dormitory_add_student_bed_class');?>?classid="+classid+"&studentid="+studentid+"&sex="+sex,
                yes: function(index, layero) {
                    var ibody = layer.getChildFrame('body', index);//获取iframe页面body
                    var iframeWin = window[layero.find('iframe')[0]['name']];//获得iframe页的窗口对象
                    //提交
                    iframeWin.jy();
                    return;
                },
                shade: 0.8,
                shadeClose: true,
                maxmin :true,
                success: function(layero, index){
                }
            });
        });
    }

    // 退宿
    $('.cancel_bed_btn').click(function () {
        var bedid = $(this).attr('data-bedid');

        if (confirm("确定要退宿该学生吗?")) {
            $.ajax({
                url: "<?php echo u('Dormitory/dormitory_cancel_bed');?>",
                type : 'post',
                dataType : 'json',
                data : {
                    bedid:bedid
                },
                success : function(data) {
                    if("success" == data.status){
                        layer.msg("退宿成功" , {
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