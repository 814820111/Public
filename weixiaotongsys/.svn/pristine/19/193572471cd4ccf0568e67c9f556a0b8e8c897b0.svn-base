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
<title>宿舍管理员</title>
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
        <li class="active"><a href="<?php echo U('Dormitory/dormitory_manager');?>" style="color:#1f1f1f;text-decoration: none;">宿舍管理员</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="home">
        <br/>
        <form class="form-horizontal J_ajaxForm" action="<?php echo u('Dormitory/dormitory_manager');?>" method="get" style="margin: 0px 0px 5px;">
            <div class="search_type cc mb10">
                <div class="mb10">
                  <span class="mr20">管理员姓名：
                    <input type="text" value="<?php echo ($name); ?>" class="select_2" name="name" placeholder="-管理员姓名-" style="width:8%; height: 15px;border-width:1px;">
                     管理员电话：
                      <input type="text" value="<?php echo ($phone); ?>" class="select_2" name="phone" placeholder="-管理员电话-" style="width:8%; height: 15px;border-width:1px;">
                     <button type="submit" class="btn btn-default" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 搜索 </button>
                       <a type="submit" class="btn btn-default add_list"  style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 添加 </a>
                  </span>
                </div>
            </div>
        </form>

        <!--添加管理员strat-->

        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:560px">
                <div class="modal-content">
                    <div class="modal-header" style="background: #f3f3f3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <a type="submit" class="btn btn-default add_list"  style="border:none;;color:#FFF; background-color:#26a69a;"> 添加管理员 </a>
                    </div>
                    <div class="modal-body2">
                        <form   class="form-horizontal">
                            <div class="">

                                <div class="control-group">
                                    <label class="control-label" >姓名</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" id="addname" name="addname" placeholder="姓名">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" >电话</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" id="addphone" name="addphone" placeholder="电话">
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-success list_tijiao_btn" style="float:right;width:210px;font-weight:bold;margin-right:15px;" >提交</button>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>

    <!--添加管理员end-->
    <!--修改管理员strat-->

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
                                <label class="control-label" >姓名</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="editname" name="editname" placeholder="姓名">
                                </div>
                            </div>
                            <input type="hidden"  id="editid" name="editid">
                            <div class="control-group">
                                <label class="control-label" >电话</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="editphone" name="editphone" placeholder="电话">
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">

                    <button class="btn btn-success edit_tijiao_btn" style="float:right;width:210px;font-weight:bold;margin-right:15px;" >提交</button>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal -->
</div>

<!--修改管理员end-->

    <form class="J_ajaxForm" action="" method="post">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-list">
                <thead>
                <tr style="background-color:#e2e2e2;">

                    <th style=" text-align: center;"></th>
                    <th style=" text-align: center;">管理员姓名</th>
                    <th style=" text-align: center;">管理员电话</th>
                    <th style=" text-align: center;">操作</th>
                </tr>
                </thead>
                <?php $i=0; ?>
                <?php if(is_array($manager)): foreach($manager as $key=>$vo): ?><tr>
                        <td style="text-align: center;"><?php echo $i++; ?></td>
                        <td style="text-align: center;"><?php echo ($vo["name"]); ?></td>
                        <td style="text-align: center;"><?php echo ($vo["phone"]); ?></td>
                        <td style="text-align: center;">  <a class="edit_btn" data-toggle="modal" data-id="<?php echo ($vo["id"]); ?>" data-name="<?php echo ($vo["name"]); ?>" data-phone="<?php echo ($vo["phone"]); ?>">修改</a>
                            | <a class="del_btn" data-id="<?php echo ($vo["id"]); ?>">删除</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </table>
            <div class="pagination" style="position: relative;bottom: 35px;"><?php echo ($Page); ?></div>
        </div>
    </form>
</div>




<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
<script src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>
<script>
    layui.use(['layer'], function(){
        var layer = layui.layer;
    });
    $('.add_list').click(function() {
        $("#myModal1").modal("show");
    })


    $('.edit_btn').click(function() {

        $("#editname").empty();
        $("#editphone").empty();
        $("#editid").empty();
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        var phone =$(this).attr('data-phone');
        $("#editname").val(name);
        $("#editphone").val(phone);
        $("#editid").val(id);
        $("#myModal2").modal("show");
    })


    $('.list_tijiao_btn').click(function () {
            var name = $('#addname').val();
            var phone = $('#addphone').val();
            if(name == ""){
                layer.msg('姓名不能为空', {
                    icon: 2
                    ,shade: false,
                });
                return false;
            }
        if(phone == ""){
            layer.msg('电话不能为空', {
                icon: 2
                ,shade: false,
            });
            return false;
        }

        $.ajax({
            type: "post",
            dataType:'json',
            url: "<?php echo u('Dormitory/dormitory_add_post_manager');?>",
            data: {
                name:name,
                phone:phone
            },
            success: function(data) {

                if(data.status == 'success'){
                    layer.msg("添加成功" , {
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
    $('.edit_tijiao_btn').click(function () {
        var id = $('#editid').val();
        var name = $('#editname').val();
        var phone = $('#editphone').val();
        if(name == ""){
            layer.msg('姓名不能为空', {
                icon: 2
                ,shade: false,
            });
            return false;
        }
        if(phone == ""){
            layer.msg('电话不能为空', {
                icon: 2
                ,shade: false,
            });
            return false;
        }

        $.ajax({
            type: "post",
            dataType:'json',
            url: "<?php echo u('Dormitory/dormitory_edit_post_manager');?>",
            data: {
                id:id,
                name:name,
                phone:phone
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
    $('.del_btn').click(function () {
        var id = $(this).attr('data-id');
        $.ajax({
            type: "post",
            dataType:'json',
            url: "<?php echo u('Dormitory/dormitory_del_manager');?>",
            data: {
                id:id
            },
            success: function(data) {
                if(data.status == 'success'){
                    if (confirm("你确定要删除?")) {
                        $.ajax({
                            url: "<?php echo u('Dormitory/dormitory_del_post_manager');?>",
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
</script>

</body>
</html>