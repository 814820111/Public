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
<title>床位管理</title>
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
    <li class=""><a href="<?php echo U('Dormitory/dormitory_buildlist');?>" style="color:#1f1f1f;text-decoration: none;">楼栋管理</a></li>
    <li class=""><a href="<?php echo U('Dormitory/dormitory_buildroom');?>" style="color:#1f1f1f;text-decoration: none;">寝室管理</a></li>
    <li class="active"><a href="<?php echo U('Dormitory/dormitory_buildbed');?>" style="color:#1f1f1f;text-decoration: none;">床位管理</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="home">
        <br/>
        <form class="form-horizontal J_ajaxForm" action="<?php echo u('Dormitory/dormitory_buildbed');?>" method="get" style="margin: 0px 0px 5px;">
            <div class="search_type cc mb10">
                <div class="mb10">
                  <span class="mr20">
                     楼栋名称：
                       <select  class="select_2" name="buildname" style="width: auto;">
                      	<option value="" >不选择</option>
                       <?php if(is_array($build)): foreach($build as $key=>$vo): ?><option value="<?php echo ($vo["buildname"]); ?>" <?php if($buildname == $vo[buildname]){echo "selected";} ?>><?php echo ($vo["buildname"]); ?></option><?php endforeach; endif; ?>
                          </select>
                    寝室编号：
                    <input type="text" value="<?php echo ($roomno); ?>" class="select_2" name="roomno" placeholder="-寝室编号-" style="width:8%; height: 15px;border-width:1px;">

                      性别：
                      <select  class="select_2" name="sex" style="width: auto;">
                      	<option value="" >不选择</option>
                      	<option value="0" <?php if($sex == '0'){echo "selected";} ?>>男</option>
                          <option value="1" <?php if($sex == '1'){echo "selected";} ?>>女</option>
                          </select>
                          班级：
                     <input type="text" value="<?php echo ($classname); ?>" class="select_2" name="classname" placeholder="-班级-" style="width:8%; height: 15px;border-width:1px;"> &nbsp;&nbsp;&nbsp;
                      姓名：<input type="text" value="<?php echo ($studentname); ?>" class="select_2" name="studentname" placeholder="-学生姓名-" style="width:8%; height: 15px;border-width:1px;">
                      <button type="submit" class="btn btn-default" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 查 询 </button>
                       <a type="submit" class="btn btn-default" onclick="addBed();" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 添加床位 </a>
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
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">楼栋名称</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">寝室号</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">床位号</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">楼栋性别</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">年级</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">班级</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">姓名</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">床位是否保留</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">操作</th>
                    </tr>
                    </thead>
                    <?php $sex_statuse=array("0"=>"男","1"=>"女");$keep_statuse=array("0"=>"否","1"=>"是");$i=0; ?>
                    <?php if(is_array($bed)): foreach($bed as $key=>$vo): ?><tr>
                            <td style="text-align: center; border-left: none;border-top: none;"> <?php echo $i++; ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["buildname"]); ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["roomname"]); ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["bedname"]); ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo $sex_statuse[$vo[sex]]; ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["gradename"]); ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["classname"]); ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["stu_name"]); ?></td>
                            <td style="text-align: center; border-left: none;border-top: none"><?php echo $keep_statuse[$vo[keep]]; ?></td>
                            <td style="text-align: center; border-left: none;border-top: none">
                                <a style=" color:#00c1dd;" class="edit_keep_btn" data-bedid="<?php echo ($vo["bedid"]); ?>">修改保留状态</a>
                                |
                                <?php if($vo['studentid'] == 0 ): ?><a  style=" color:#00c1dd;" onclick="addStudent(<?php echo ($vo["bedid"]); ?>,<?php echo ($vo["classid"]); ?>);" >入住</a>
                                 <?php else: ?>
                                    入住<?php endif; ?>
                                |
                                <?php if($vo['studentid'] == 0 ): ?>对调
                                    <?php else: ?>
                                    <a  style=" color:#00c1dd;" onclick="ExchangeBed(<?php echo ($vo["bedid"]); ?>,<?php echo ($vo["sex"]); ?>,<?php echo ($vo["studentid"]); ?>);" >对调</a><?php endif; ?>
                                | <?php if($vo['studentid'] == 0 ): ?>退宿
                                <?php else: ?>
                                <a style=" color:#00c1dd;" class="cancel_bed_btn" data-bedid="<?php echo ($vo["bedid"]); ?>">退宿</a><?php endif; ?>|<?php if($vo['studentid'] == 0 ): ?><a style=" color:#00c1dd;" class="del_bed_btn" data-bedid="<?php echo ($vo["bedid"]); ?>">删除</a>
                                <?php else: ?>
                                删除<?php endif; ?>
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
    //添加床位
    function addBed() {
        layui.use(['layer'], function() {
            var $ = layui.jquery,
                layer = layui.layer;

            var index = layer.open({
                type: 2,
                id	: 1,
                title: '添加床位',
                btn: ['提交', '关闭'],
                area: ['900px', '500px'],
                offset : ['20px', '200px'],
                maxmin: true,
                content: "<?php echo U('Dormitory/dormitory_add_buildbed');?>",
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

    //床位对调
    function ExchangeBed(bedid,sex,studentid) {

        layui.use(['layer'], function() {
            var $ = layui.jquery,
                layer = layui.layer;

            var index = layer.open({
                type: 2,
                id	: 1,
                title: '床位对调',
                btn: ['对调', '关闭'],
                area: ['600px', '500px'],
                offset : ['20px', '200px'],
                maxmin: true,
                content: "<?php echo U('Dormitory/dormitory_exchangebed_student_bed');?>?bedid="+bedid+"&sex="+sex+"&studentid="+studentid,
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
    //学生入住
    function addStudent(id,classid) {
        if(!classid){
            layer.msg("请先为床位分配班级", {
                icon: 2
                ,shade: false,
            });
            return false;
        }
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
                content: "<?php echo U('Dormitory/dormitory_add_student_bed');?>?bedid="+id,
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
    // 修改保留状态
    $('.edit_keep_btn').click(function () {
        var bedid = $(this).attr('data-bedid');

                    if (confirm("保留状态会使床位无法进行分配班级与取消分配班级操作，确定要修改吗?")) {
                        $.ajax({
                            url: "<?php echo u('Dormitory/dormitory_edit_keep_bed');?>",
                            type : 'post',
                            dataType : 'json',
                            data : {
                                bedid:bedid
                            },
                            success : function(data) {
                                if("success" == data.status){
                                    layer.msg("修改成功" , {
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
    // 删除床位
    $('.del_bed_btn').click(function () {
        var bedid = $(this).attr('data-bedid');

        if (confirm("确定要删除该床位吗?")) {
            $.ajax({
                url: "<?php echo u('Dormitory/dormitory_del_bed');?>",
                type : 'post',
                dataType : 'json',
                data : {
                    bedid:bedid
                },
                success : function(data) {
                    if("success" == data.status){
                        layer.msg("删除成功" , {
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