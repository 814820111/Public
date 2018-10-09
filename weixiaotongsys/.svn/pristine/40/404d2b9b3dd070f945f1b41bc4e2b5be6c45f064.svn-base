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
<title>楼栋管理</title>
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
<ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none;">
    <li class="active"><a href="<?php echo U('Dormitory/dormitory_buildlist');?>" style="color:#1f1f1f;text-decoration: none;">楼栋管理</a></li>
    <li class=""><a href="<?php echo U('Dormitory/dormitory_buildroom');?>" style="color:#1f1f1f;text-decoration: none;">寝室管理</a></li>
    <li class=""><a href="<?php echo U('Dormitory/dormitory_buildbed');?>" style="color:#1f1f1f;text-decoration: none;">床位管理</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="home">
        <br/>
        <form class="form-horizontal" action="<?php echo u('Dormitory/dormitory_buildlist');?>" method="get" style="margin: 0px 0px 5px;">
            <div class="search_type cc mb10">
                <div class="mb10">
                  <span class="mr20">楼栋号：
                    <input type="text" value="<?php echo ($buildno); ?>" class="select_2" name="buildno" placeholder="-楼栋号-" style="width:8%; height: 15px;border-width:1px;">
                      楼栋名称：
                      <input type="text" value="<?php echo ($buildname); ?>" class="select_2" name="buildname" placeholder="-楼栋名称-" style="width:8%; height: 15px;border-width:1px;">


                      性别：
                      <select  class="select_2" name="sex" style="width: auto;">
                      	<option value="">不选择</option>
                      	<option value="1">男</option>
                      	<option value="0">女</option>
                         <option value="0">混住</option>
                      </select>&nbsp; &nbsp;&nbsp;&nbsp;
                      <button type="submit" class="btn btn-default" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 查 询 </button>
                       <a class="btn btn-default" onclick="addBuild();" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 添加楼栋 </a>
                  </span>
                </div>
            </div>
        </form>

        <!--修改楼栋strat-->

        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:560px">
                <div class="modal-content">
                    <div class="modal-header" style="background: #f3f3f3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <a type="submit" class="btn btn-default add_list"  style="border:none;;color:#FFF; background-color:#26a69a;"> 修改管理员 </a>
                    </div>
                    <div class="modal-body2">
                        <form   class="form-horizontal">
                            <div class="">

                                <div class="control-group">
                                    <label class="control-label" >楼栋名称</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" id="editbulidname" name="editbulidname" placeholder="楼栋名称">
                                    </div>
                                </div>
                                <input type="hidden"  id="editbulidid" name="editbulidid">
                                <div class="control-group">
                                    <label class="control-label" >备注</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" id="editremake" name="editremake" placeholder="备注">
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-success edit_build_tijiao_btn" style="float:right;width:210px;font-weight:bold;margin-right:15px;" >提交</button>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>

    <!--修改楼栋end-->


        <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-list">
                    <thead>
                    <tr style="background-color:#e2e2e2;">

                        <th style=" text-align: center;"></th>
                        <th style=" text-align: center;">楼栋编号</th>
                        <th style=" text-align: center;">楼栋名称</th>
                        <th style=" text-align: center;">学生性别</th>
                        <th style=" text-align: center;">楼层数</th>
                        <th style=" text-align: center;">起始楼层</th>
                        <th style=" text-align: center;">是否有0层</th>
                        <th style=" text-align: center;">管理员</th>
                        <th style=" text-align: center;">联系电话</th>
                        <th style=" text-align: center;">备注</th>
                        <th style=" text-align: center;">操作</th>
                    </tr>
                    </thead>
                    <?php $dormitory_statuses=array("0"=>"男","1"=>"女","2"=>"混住");$i=1;$dormitory_zero=array("1"=>"是","0"=>"否"); ?>
                    <?php if(is_array($build)): foreach($build as $key=>$vo): ?><tr>
                            <td style="text-align: center;"><?php echo $i++; ?></td>
                            <td style="text-align: center;"><?php echo ($vo["buildno"]); ?></td>
                            <td style="text-align: center;"><?php echo ($vo["buildname"]); ?></td>
                            <td style="text-align: center;"><?php echo $dormitory_statuses[$vo[buildsex]]; ?></td>
                            <td style="text-align: center;"><?php echo ($vo["floornum"]); ?></td>
                            <td style="text-align: center;"><?php echo ($vo["startfloor"]); ?></td>
                            <td style="text-align: center;"><?php echo $dormitory_zero[$vo[is_zero]]; ?></td>
                            <td style="text-align: center;"><?php echo ($vo["managername"]); ?></td>
                            <td style="text-align: center;"><?php echo ($vo["managerphone"]); ?></td>
                            <td style="text-align: center;"><?php echo ($vo["remake"]); ?></td>
                            <td style="text-align: center;">
                                <a style=" color:#00c1dd;" class="edit_build_btn" data-toggle="modal" data-id="<?php echo ($vo["id"]); ?>" data-buildname="<?php echo ($vo["buildname"]); ?>" data-remake="<?php echo ($vo["remake"]); ?>">修改</a>
                                |<a style=" color:#00c1dd;"onclick="addManager(<?php echo ($vo["id"]); ?>)">任命管理员</a>|<a class="del_btn" data-id="<?php echo ($vo["id"]); ?>">删除</a>
                            </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <div class="pagination" style=""><?php echo ($Page); ?></div>
            </div>
        </form>
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

    function addBuild() {
        layui.use(['layer'], function() {
            var $ = layui.jquery,
                layer = layui.layer;

            var index = layer.open({
                type: 2,
                id	: 1,
                title: '添加楼栋',
                btn: ['提交', '关闭'],
                area: ['900px', '600px'],
                offset : ['20px', '200px'],
                maxmin: true,
                content: "<?php echo U('Dormitory/dormitory_add_buildlist');?>",
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
            //layer.full(index);
        });
    }
    function addManager(id) {
        layui.use(['layer'], function() {
            var $ = layui.jquery,
                layer = layui.layer;

            var index = layer.open({
                type: 2,
                id	: 1,
                title: '任命管理员',
                btn: ['选择', '关闭'],
                area: ['600px', '600px'],

                content: "<?php echo U('Dormitory/dormitory_manager_add_build');?>?id="+id,
                yes: function(index, layero) {
                    var ibody = layer.getChildFrame('body', index);//获取iframe页面body
                    var iframeWin = window[layero.find('iframe')[0]['name']];//获得iframe页的窗口对象
                    //提交
                    iframeWin.jy();
                    return;
                },
                shade: 0.8,
                shadeClose: true,
                success: function(layero, index){
                }
            });
            //layer.full(index);
        });
    }

    // 删除楼栋
    $('.del_btn').click(function () {
        var id = $(this).attr('data-id');
        $.ajax({
            type: "post",
            dataType:'json',
            url: "<?php echo u('Dormitory/dormitory_del_build');?>",
            data: {
                id:id
            },
            success: function(data) {
                if(data.status == 'success'){
                    if (confirm("你确定要删除?")) {
                        $.ajax({
                            url: "<?php echo u('Dormitory/dormitory_del_post_build');?>",
                            type : 'post',
                            dataType : 'json',
                            data : {
                                id:id
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

                }
                if(data.status == 'error'){
                    layer.msg(data.data , {
                        icon: 2
                        ,shade: false,
                    });
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

    })

    $('.edit_build_btn').click(function() {

        $("#editbulidname").empty();
        $("#editbulidid").empty();
        $("#editremake").empty();
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-buildname');
        var remake =$(this).attr('data-remake');
        $("#editbulidname").val(name);
        $("#editbulidid").val(id);
        $("#editremake").val(remake);
        $("#myModal2").modal("show");
    })
    $('.edit_build_tijiao_btn').click(function () {
        var id = $('#editbulidid').val();
        var name = $('#editbulidname').val();
        var remake = $('#editremake').val();
        if(name == ""){
            layer.msg('楼栋名称不能为空', {
                icon: 2
                ,shade: false,
            });
            return false;
        }

        $.ajax({
            type: "post",
            dataType:'json',
            url: "<?php echo u('Dormitory/dormitory_edit_post_buildlist');?>",
            data: {
                id:id,
                name:name,
                remake:remake
            },
            success: function(data) {

                if(data.status == 'success'){
                    layer.msg("修改成功" , {
                        icon: 1
                        ,shade:  false,
                    });
                    window.location.reload();
                }
                if(data.status == 'error'){
                    layer.msg(data.data , {
                        icon: 2
                        ,shade: false,
                    });
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

    })
</script>
</body>
</html>