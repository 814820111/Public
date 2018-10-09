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
<title>寝室管理</title>
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
    <li class="active"><a href="<?php echo U('Dormitory/dormitory_buildroom');?>" style="color:#1f1f1f;text-decoration: none;">寝室管理</a></li>
    <li class=""><a href="<?php echo U('Dormitory/dormitory_buildbed');?>" style="color:#1f1f1f;text-decoration: none;">床位管理</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="home">
        <br/>
        <form class="form-horizontal J_ajaxForm" action="<?php echo u('Dormitory/dormitory_buildroom');?>" method="get" style="margin: 0px 0px 5px;">
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
                          状态：
                      <select  class="select_2" name="status" style="width: auto;">
                      	<option value="">不选择</option>
                      	<option value="1" <?php if($status == '1'){echo "selected";} ?>>全空</option>
                      	<option value="2" <?php if($status == '2'){echo "selected";} ?>>不满</option>
                        <option value="3" <?php if($status == '3'){echo "selected";} ?>>全满</option>
                      </select>&nbsp; &nbsp;&nbsp;&nbsp;
                      <button type="submit" class="btn btn-default" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 查 询 </button>
                       <a  class="btn btn-default" onclick="addRoom();" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"> 添加寝室</a>
                  </span>
                </div>
            </div>
        </form>

        <!--修改宿舍strat-->

        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:560px">
                <div class="modal-content">
                    <div class="modal-header" style="background: #f3f3f3">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <a type="submit" class="btn btn-default add_list"  style="border:none;;color:#FFF; background-color:#26a69a;"> 修改宿舍 </a>
                    </div>
                    <div class="modal-body2">
                        <form   class="form-horizontal">
                            <div class="">
                                <div class="control-group">
                                    <label class="control-label" >寝室号</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" id="editroomname" name="editroomname" placeholder="寝室号">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" >收费</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" id="editmoney" name="editmoney" placeholder="收费">
                                    </div>
                                </div>
                                <input type="hidden"  id="editroomid" name="editroomid">
                                <div class="control-group">
                                    <label class="control-label" >备注</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" id="editnote" name="editnote" placeholder="备注">
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-success edit_room_tijiao_btn" style="float:right;width:210px;font-weight:bold;margin-right:15px;" >提交</button>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>

    <!--修改宿舍end-->


        <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-list">
                    <thead>
                    <tr style="background-color:#e2e2e2;">

                        <th style=" text-align: center; border-width: 0.5px; border-left: none"></th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">楼栋名称</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">寝室号</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">学生性别</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none">床位数</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">空余床位</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">已入住床位</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">状态</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">寝室长</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">备注</th>
                        <th style=" text-align: center; border-width: 0.5px; border-left: none;border-right: none;">操作</th>
                    </tr>
                    </thead>
                    <?php $room_statuses=array("0"=>"男","1"=>"女");$i=0; ?>
                    <?php if(is_array($room)): foreach($room as $key=>$vo): ?><tr>
                        <td style="text-align: center; border-left: none;border-top: none;"><?php echo $i++; ?></td>
                        <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["buildname"]); ?></td>
                        <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["roomname"]); ?></td>
                        <td style="text-align: center; border-left: none;border-top: none"><?php echo $room_statuses[$vo[sex]]; ?></td>
                        <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["bednum"]); ?></td>
                        <td style="text-align: center; border-left: none;border-top: none"><?php echo $vo[bednum]-$vo[nowbednum]; ?></td>
                        <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["nowbednum"]); ?></td>
                        <td style="text-align: center; border-left: none;border-top: none;"><?php if($vo[nowbednum]==0){echo '全空';}elseif($vo[nowbednum] == $vo[bednum]){echo '全满';}else{echo '不满';} ?></td>
                        <td style="text-align: center; border-left: none;border-top: none">
                            <?php if(empty($vo['stu_name'])): ?>无
                                <?php else: ?>
                                <?php echo ($vo["stu_name"]); endif; ?>
                        </td>
                        <td style="text-align: center; border-left: none;border-top: none"><?php echo ($vo["note"]); ?></td>
                        <td style="text-align: center; border-left: none;border-top: none">
                            <a style=" color:#00c1dd;" class="edit_room_btn" data-toggle="modal" data-roomid="<?php echo ($vo["roomid"]); ?>" data-roommoney="<?php echo ($vo["money"]); ?>" data-roomname="<?php echo ($vo["roomname"]); ?>" data-note="<?php echo ($vo["note"]); ?>">修改</a>
                            |
                            <a  style=" color:#00c1dd;" onclick="addleader(<?php echo ($vo["roomid"]); ?>);" >任命寝室长</a>|<a style=" color:#00c1dd;" class="del_room_btn" data-roomid="<?php echo ($vo["roomid"]); ?>">删除</a>
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
    function addRoom() {
        layui.use(['layer'], function() {
            var $ = layui.jquery,
                layer = layui.layer;

            var index = layer.open({
                type: 2,
                id	: 1,
                title: '添加寝室',
                btn: ['提交', '关闭'],
                area: ['900px', '500px'],
                offset : ['20px', '200px'],
                maxmin: true,
                content:"<?php echo U('Dormitory/dormitory_add_buildroom');?>",
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
    $('.edit_room_btn').click(function() {

        $("#editmoney").empty();
        $("#editroomid").empty();
        $("#editnote").empty();
        var roomid = $(this).attr('data-roomid');
        var roommoney = $(this).attr('data-roommoney');
        var roomname = $(this).attr('data-roomname');
        var note =$(this).attr('data-note');
        $("#editmoney").val(roommoney);
        $("#editroomname").val(roomname);
        $("#editroomid").val(roomid);
        $("#editnote").val(note);
        $("#myModal2").modal("show");
    })
    $('.edit_room_tijiao_btn').click(function () {
        var roomid = $('#editroomid').val();
        var money = $('#editmoney').val();
        var roomname = $('#editroomname').val();
        var note = $('#editnote').val();
        if(money == ""){
            layer.msg('收费不能为空', {
                icon: 2
                ,shade: false,
            });
            return false;
        }
        if(roomname == ""){
            layer.msg('寝室号不能为空', {
                icon: 2
                ,shade: false,
            });
            return false;
        }
        $.ajax({
            type: "post",
            dataType:'json',
            url: "<?php echo u('Dormitory/dormitory_edit_post_room');?>",
            data: {
                roomid:roomid,
                roomname:roomname,
                money:money,
                note:note
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
    // 删除楼栋
    $('.del_room_btn').click(function () {
        var roomid = $(this).attr('data-roomid');
        $.ajax({
            type: "post",
            dataType:'json',
            url: "<?php echo u('Dormitory/dormitory_del_room');?>",
            data: {
                roomid:roomid
            },
            success: function(data) {
                if(data.status == 'success'){
                    if (confirm("你确定要删除?")) {
                        $.ajax({
                            url: "<?php echo u('Dormitory/dormitory_del_post_room');?>",
                            type : 'post',
                            dataType : 'json',
                            data : {
                                roomid:roomid
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
    //学生入住
    function addleader(roomid) {
        layui.use(['layer'], function() {
            var $ = layui.jquery,
                layer = layui.layer;

            var index = layer.open({
                type: 2,
                id	: 1,
                title: '任命寝室长',
                btn: ['提交', '关闭'],
                area: ['600px', '500px'],
                offset : ['20px', '200px'],
                maxmin: true,
                content: "<?php echo U('Dormitory/dormitory_add_leader_room');?>?roomid="+roomid,
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
</script>

</body>
</html>