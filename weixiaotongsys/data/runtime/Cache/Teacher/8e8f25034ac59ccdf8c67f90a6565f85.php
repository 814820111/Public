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
<html>
<head>
    <style>
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
    <script src="/weixiaotong2016/statics/js/laydate/laydate.js" type="text/javascript"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
    <script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>

    <style type="text/css">
        .col-auto { overflow: auto; _zoom: 1;_float: left;}
        .col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
        .table th, .table td {vertical-align: middle;}
        .picList li{margin-bottom: 5px;}
        .touchlei{ background-color:#eeeeee;}
        /*.modal{    width: 100px;
             margin-left: 0px;
            }*/
        .modal.fade.in {
            top: 0%;
        }
        div{
            color: black;
        }
        select{
            color: black;
        }
        #sangcalender{
            z-index: 99999999;
        }
    </style>
</head>
<body>
<ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px;">
    <li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">老师不打卡设置</a></li>
    <!--<li><a href="<?php echo U('index_scheudle');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">班次管理</a></li>-->
</ul>
<div style="background-color: rgba(0, 0, 0, 0.7); position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 0; display: none;" class="add_clock_modal">
    <div style=" width:635px;height: 400px;overflow: auto; overflow-x: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;" class="">
        <form id="form3" action="" method="post">
            <div id="" style="width:100%;float:left; margin-top: 20px;">
                <div>
                    <h5>基本设置</h5>
                </div>
                <hr>
                <div>
                    <label style="display: inline-block; font-size: 13px;">活动名称：</label>
                    <span><input name="activity" type="text" style="border-radius: 4px;height: 15px;width: 120px;    margin-right: 8px;    border: 1px solid #dce4ec;"></span>
                    <span>
                        <label style="display: inline-block;font-size: 13px;">活动状态：</label>
                      <input type="checkbox" name="activity_type" style="    vertical-align: -3px;  " value="1">  <i style="font-size: 13px; color: red;font-style: normal;">*选中则为开启状态,否则为停止状态 </i>
                    </span>

                </div>
                <div>
                    <label style="display: inline-block; font-size: 13px;">开始时间：</label>
                    <span><input class="J_date date" name="begintime" type="text" style="border-radius: 4px;height: 15px;width: 120px;    margin-right: 8px;    border: 1px solid #dce4ec;"></span>
                    <span>
                        <label style="display: inline-block;font-size: 13px;">结束时间：</label>
                        <span><input class="J_date date" name="endtime" type="text" style="border-radius: 4px;height: 15px;width: 120px;    margin-right: 8px;    border: 1px solid #dce4ec;"></span>
                    </span>

                </div>
                <div>
                   <div style="float:left;">参加分组：</div>
                    <div style=" border:1px solid #bbbbbb; float: left; overflow-y:scroll; padding:10px; width: 423px; height: 150px;">
                        <?php if(is_array($teacher_group)): foreach($teacher_group as $key=>$vo): ?><div style=" float:left; margin-right:20px; margin-bottom:5px;cursor: pointer;" class="xuanboxs">

                                <div style="width: 100px;height: 5px;position: relative;top: 25px;"></div>
                                <input type="checkbox" value="<?php echo ($vo["id"]); ?>" name="group[]"   class="xuan2" style=" margin-right:5px; margin-top:0px;">
                                <span class="shuzi"><?php echo ($vo["name"]); ?></span>

                            </div><?php endforeach; endif; ?>

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div>
                    <h5>刷卡时间段及短信内容设置</h5>
                </div>
                <hr>
                <div style="width:800px;">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>刷卡开始时间</th>
                            <th>刷卡结束时间</th>
                            <th>短信内容</th>
                            <th>操作</th>

                        </tr>
                        </thead>
                        <tbody class="scheduling_main">
                        <tr>
                            <td><input class="J_date date" name="card_begin[]" type="text" style="border-radius: 4px;height: 8px;width: 100px;margin-right:8px;border: 1px solid #dce4ec;"><input type="time" name="card_begin_timing[]" value="09:00" style=" border-width: 1px;width: 73px; height: 8px;"></td>
                            <td><input class="J_date date" name="card_end[]" type="text" style="border-radius: 4px;height: 8px;width: 100px;margin-right:8px;border: 1px solid #dce4ec;"><input type="time" name="card_end_timing[]" value="09:00" style=" border-width: 1px;width: 73px; height: 8px;"></td>
                            <td><input name="" type="text" style="border-radius: 4px;height: 8px;width: 200px;    margin-right: 8px;    border: 1px solid #dce4ec;"></td>
                            <td style="vertical-align: 1px;" onclick=remove_tr()>×</td>
                        </tr>
                        </tbody>
                    </table>
                </div>





            </div>

             <input type="hidden" class="clockid" name="clockid" >
            <div class="layui-layer-btn layui-layer-btn-" style=" text-align: center;  right:0;bottom:0;"><a class="layui-layer-btn0" onclick="add_tr()" >增加一行</a><a class="layui-layer-btn0" onclick=add_no_clock()>确定</a><a class="layui-layer-btn1 add_clock_modal_guan">关闭</a></div>
            <input type="hidden" name="electiveid" id="electiveid" value="46">

        </form>

        <!--关闭start-->
        <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="add_clock_modal_guan">
        <!--关闭end-->
    </div>
</div>
<!--<div style="background-color: rgba(0, 0, 0, 0.7); position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 0; display: none;" class="edit_clock_modal">-->
    <!--<div style=" width:635px;height: 400px;overflow: auto; overflow-x: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;" class="">-->
        <!--<form id="form3" action="" method="post">-->
            <!--<div id="" style="width:100%;float:left; margin-top: 20px;">-->
                <!--<div>-->
                    <!--<h5>基本设置</h5>-->
                <!--</div>-->
                <!--<hr>-->
                <!--<div>-->
                    <!--<label style="display: inline-block; font-size: 13px;">活动名称：</label>-->
                    <!--<span><input name="activity" type="text" style="border-radius: 4px;height: 15px;width: 120px;    margin-right: 8px;    border: 1px solid #dce4ec;"></span>-->
                    <!--<span>-->
                        <!--<label style="display: inline-block;font-size: 13px;">活动状态：</label>-->
                      <!--<input type="checkbox" name="activity_type" style="    vertical-align: -3px;  " value="1">  <i style="font-size: 13px; color: red;font-style: normal;">*选中则为开启状态,否则为停止状态 </i>-->
                    <!--</span>-->

                <!--</div>-->
                <!--<div>-->
                    <!--<label style="display: inline-block; font-size: 13px;">开始时间：</label>-->
                    <!--<span><input class="J_date date" name="begintime" type="text" style="border-radius: 4px;height: 15px;width: 120px;    margin-right: 8px;    border: 1px solid #dce4ec;"></span>-->
                    <!--<span>-->
                        <!--<label style="display: inline-block;font-size: 13px;">结束时间：</label>-->
                        <!--<span><input class="J_date date" name="endtime" type="text" style="border-radius: 4px;height: 15px;width: 120px;    margin-right: 8px;    border: 1px solid #dce4ec;"></span>-->
                    <!--</span>-->

                <!--</div>-->
                <!--<div>-->
                    <!--<div style="float:left;">参加分组：</div>-->
                    <!--<div style=" border:1px solid #bbbbbb; float: left; overflow-y:scroll; padding:10px; width: 423px; height: 150px;">-->
                        <!--<?php if(is_array($teacher_group)): foreach($teacher_group as $key=>$vo): ?>-->
                            <!--<div style=" float:left; margin-right:20px; margin-bottom:5px;cursor: pointer;" class="xuanboxs">-->

                                <!--<div style="width: 100px;height: 5px;position: relative;top: 25px;"></div>-->
                                <!--<input type="checkbox" value="<?php echo ($vo["id"]); ?>" name="group[]"   class="xuan2" style=" margin-right:5px; margin-top:0px;">-->
                                <!--<span class="shuzi"><?php echo ($vo["name"]); ?></span>-->

                            <!--</div>-->
                        <!--<?php endforeach; endif; ?>-->

                    <!--</div>-->
                    <!--<div class="clearfix"></div>-->
                <!--</div>-->
                <!--<div>-->
                    <!--<h5>刷卡时间段及短信内容设置</h5>-->
                <!--</div>-->
                <!--<hr>-->
                <!--<div style="width:800px;">-->
                    <!--<table class="table">-->
                        <!--<thead>-->
                        <!--<tr>-->
                            <!--<th>刷卡开始时间</th>-->
                            <!--<th>刷卡结束时间</th>-->
                            <!--<th>短信内容</th>-->
                            <!--<th>操作</th>-->

                        <!--</tr>-->
                        <!--</thead>-->
                        <!--<tbody class="scheduling_main">-->
                        <!--<tr>-->
                            <!--<td><input class="J_date date" name="card_begin[]" type="text" style="border-radius: 4px;height: 8px;width: 100px;margin-right:8px;border: 1px solid #dce4ec;"><input type="time" name="card_begin_timing[]" value="09:00" style=" border-width: 1px;width: 73px; height: 8px;"></td>-->
                            <!--<td><input class="J_date date" name="card_end[]" type="text" style="border-radius: 4px;height: 8px;width: 100px;margin-right:8px;border: 1px solid #dce4ec;"><input type="time" name="card_end_timing[]" value="09:00" style=" border-width: 1px;width: 73px; height: 8px;"></td>-->
                            <!--<td><input name="" type="text" style="border-radius: 4px;height: 8px;width: 200px;    margin-right: 8px;    border: 1px solid #dce4ec;"></td>-->
                            <!--<td style="vertical-align: 1px;" onclick=remove_tr()>×</td>-->
                        <!--</tr>-->
                        <!--</tbody>-->
                    <!--</table>-->
                <!--</div>-->





            <!--</div>-->


            <!--<div class="layui-layer-btn layui-layer-btn-" style=" text-align: center;  right:0;bottom:0;"><a class="layui-layer-btn0" onclick="add_tr()" >增加一行</a><a class="layui-layer-btn0" onclick=add_no_clock()>确定</a><a class="layui-layer-btn1 fixation_schedule_guan">关闭</a></div>-->
            <!--<input type="hidden" name="electiveid" id="electiveid" value="46">-->

        <!--</form>-->

        <!--&lt;!&ndash;关闭start&ndash;&gt;-->
        <!--<img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="add_clock_modal_guan">-->
        <!--&lt;!&ndash;关闭end&ndash;&gt;-->
    <!--</div>-->
<!--</div>-->

<div style=" margin-left:30px;margin-right: 30px;">
    <!--<form class="" method="post" action="<?php echo U('TeacherScheduleSelect/index');?>" style="margin: 20px 0px 0px;">-->

    <!--教师姓名：-->
    <!--<input type="text" name="teacher_name" value="<?php echo ($teacher_name); ?>"  autocomplete="off"  placeholder="输入教师姓名" style=" height: 15px; border-width: 1px; width: 100px;" >&nbsp;&nbsp;-->

    <!--教育证号：-->
    <!--<input type="text" name="education_card" value="<?php echo ($education_card); ?>"  autocomplete="off"  placeholder="请输入..." style=" height: 15px; border-width: 1px; width: 100px">&nbsp;&nbsp;-->


    <!--工号：-->
    <!--<input type="text" name="work_card" value="<?php echo ($work_card); ?>"  autocomplete="off"  placeholder="请输入..." style=" height: 15px; border-width: 1px; width: 100px;">&nbsp;&nbsp;-->
    <!---->

    <!--<input type="submit" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;    margin-bottom: 10px;" value="搜索" />-->
    <input  class="add_clock" type="button" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;    margin-bottom: 10px;" value="创建不打卡设置" />
    <input  class="del_clock" type="button" style=" background-color: #FF5722; padding: 5px 10px; border-radius: 3px; border: none; color: white;    margin-bottom: 10px;" value="删除活动" />
    <!--</form>-->

    <form  action="<?php echo U('TeacherScheduleSelect/set_');?>" method="get"  >
        <table class="table table-hover table-bordered table-list">
            <thead>
            <tr>
                <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;"><input id="checkAll" name="checkAll" type="checkbox"></th>
                <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">活动名称</th>
                <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">开始时间</th>
                <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">结束时间</th>
                <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">状态</th>
                <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">详细内容</th>

                <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none; border-right: none;">操作</th>
            </tr>
            </thead>






            <?php if(is_array($posts)): foreach($posts as $key=>$vo): ?><tr>
        <!-- TITLE -->
        <td style="text-align: center;"><input id="sel_all" class="J_check" type="checkbox" value="<?php echo ($vo["id"]); ?>"></td>
        <td style="text-align: center;"><?php echo ($vo["activity_name"]); ?></td>
        <td style=" text-align: center; "><?php echo ($vo["begin_time"]); ?></td>
        <td style=" text-align: center; "><?php echo ($vo["end_time"]); ?></td>
        <td style=" text-align: center; ">
            <?php if($vo['type'] == 1): ?><span style="color:#5FB878">有效</span>
                <?php else: ?>
                <span style="color:#FF5722">无效</span><?php endif; ?>

        </td>
        <td style="    text-align: center;">
            <a style=" cursor: pointer; background-color: #5FB878; padding: 5px 10px; border-radius: 3px; border: none; color: white;    margin-bottom: 10px;" onclick="show_clock(<?php echo ($vo["id"]); ?>,<?php echo ($vo["att_type"]); ?>)">点击查看</a>
        </td>


        <td style=" text-align: center;  border-right: none;">
            <?php if($vo['type'] == 1): ?><a style=" background-color: #c2c2c2; padding: 5px 10px; border-radius: 3px; border: none; color: white;cursor: pointer;margin-bottom: 10px;" >开启</a>
            <a style="background-color: #FF5722; padding: 5px 10px; border-radius: 3px; border: none; color: white; margin-bottom:10px; cursor: pointer;" onclick="edit_type(this,<?php echo ($vo["id"]); ?>,0)" >停止</a>
            <?php else: ?>
                <a style=" background-color: #1E9FFF; padding: 5px 10px; border-radius: 3px; border: none; color: white;cursor: pointer;margin-bottom: 10px;" onclick="edit_type(this,<?php echo ($vo["id"]); ?>,1)">开启</a>
            <a style="background-color: #c2c2c2; padding: 5px 10px; border-radius: 3px; border: none; color: white; margin-bottom:10px; cursor: pointer;">停止</a><?php endif; ?>





        </td>

    </tr><?php endforeach; endif; ?>

</table>
<div class="pagination" style="height: 100%;"><?php echo ($Page); ?></div>

<div>
</div>


<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop_self.js"></script>


<script>

    $(function() {
        $("#checkAll").click(function() {
            $('input[class="J_check"]').prop("checked", $(this).prop("checked"));
        });
        var $J_check = $("input[class='J_check']");
        $J_check.click(function(){
            $("#checkAll").prop("checked",$J_check.length == $("input[class='J_check']:checked").length ? true : false);
        });
    });

    $(".del_clock").click(function(){

        var c_id = "";

        $("input[class='J_check']").each(function(){

            if($(this).attr("checked"))
            {
                c_id+=$(this).val()+",";
            }
        })

        if(!c_id)
        {
            layer.msg('请选择要删除的活动!', {
                icon: 2
                ,shade: 0.01,
            });
            return false;
        }
        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('del_clock');?>",
            data:{
              id:c_id,
            },

            success: function(res) {
                if(res.status)
                {
                    alert(res.msg);
                    $("input[class='J_check']").each(function(){
                        var obj = $(this).parent().parent();
                     if($(this).attr("checked")) {


                         obj.fadeTo("slow", 0.01, function () {
                             obj.slideUp("slow", function () {
                                 obj.remove();
                             });
                         });
                     }

                    })



                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });


    })


    $(".add_clock").click(function(){
        $(".clockid").val("");
        $(".scheduling_main").children().remove();

        $("input[name=activity]").val("");
        $("input[name=begintime]").val("");
        $("input[name=endtime]").val("");
        $("input[name='group[]']").attr("checked",false);
        $("input[name='activity_type']").attr("checked",false);

         var html = "";

        html+="<tr>"
        html+="<td><input id='11' class='J_date date' name=card_begin[] type=text style='border-radius:4px;height:8px;width:100px;margin-right:8px;border:1px solid #dce4ec;'><input type=time  name=card_begin_timing[] value=09:00 style='border-width: 1px;width: 73px; height: 8px;'></td>"
        html+="<td><input id='11' class='J_date date' name=card_end[] type=text style='border-radius:4px;height:8px;width:100px;margin-right:8px;border:1px solid #dce4ec;'><input type=time  name=card_end_timing[] value=09:00 style='border-width: 1px;width: 73px; height: 8px;'></td>"
        html+="<td><input name=content[] type=text style='border-radius: 4px;height: 8px;width: 200px;    margin-right: 8px;    border: 1px solid #dce4ec;'></td>"
        html+="<td  style='vertical-align:1px;' onclick=remove_tr(this)>×</td>"
        html+="</tr>"
        $(".scheduling_main").append(html)

        $(".add_clock_modal").show();
        $(".date").datePicker();


    })

    $(".add_clock_modal_guan").click(function(){

        $(".add_clock_modal").hide();

    })

    function add_tr()
    {
      var html = "";

      html+="<tr>"
        html+="<td><input id='11' class='J_date date' name=card_begin[] type=text style='border-radius:4px;height:8px;width:100px;margin-right:8px;border:1px solid #dce4ec;'><input type=time  name=card_begin_timing[] value=09:00 style='border-width: 1px;width: 73px; height: 8px;'></td>"
        html+="<td><input id='11' class='J_date date' name=card_end[] type=text style='border-radius:4px;height:8px;width:100px;margin-right:8px;border:1px solid #dce4ec;'><input type=time  name=card_end_timing[] value=09:00 style='border-width: 1px;width: 73px; height: 8px;'></td>"
        html+="<td><input type=text  name=content[] style='border-radius: 4px;height: 8px;width: 200px;    margin-right: 8px;    border: 1px solid #dce4ec;'></td>"
        html+="<td  style='vertical-align:1px;' onclick=remove_tr(this)>×</td>"
      html+="</tr>"
        $(".scheduling_main").append(html)

        $(".date").datePicker();

    }

    function add_no_clock()
    {
        if(!verify_form())
        {
            return false;
        }

        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('add_teacher_clock_post');?>",
            data:$("#form3").serialize(),

            success: function(res) {
                if(res.status)
                {
                    alert(res.msg);
                    $(".add_clock_modal").hide();
                    history.go(0);

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }

    function verify_form()
    {
        var is_true = true;

        var activity_name = $("input[name=activity]").val();



        var begin_str = $("input[name=begintime]").val();
        begin_str = begin_str.replace(/-/g,'/');
        var begin = new Date(begin_str);
        var begin_time = begin.getTime()/1000;


        var end_str = $("input[name=endtime]").val();
        end_str = end_str.replace(/-/g,'/');
        var end = new Date(end_str);
        var end_time = end.getTime()/1000;


        if(!activity_name)
        {
            layer.msg('活动名称不能为空!', {
                icon: 2
                ,shade: 0.01,
            });


            return is_true = false;
        }

        if(!begin_time || !end_time)
        {
            layer.msg('活动时间不能为空!', {
                icon: 2
                ,shade: 0.01,
            });
            return is_true = false;
        }

        if(begin_time && end_time)
        {
            if(begin_time > end_time)
            {
                layer.msg('开始时间不能大于结束时间!', {
                    icon: 2
                    ,shade: 0.01,
                });
                return is_true = false;
            }
        }

        var g_id = "";
        $("input[name='group[]']").each(function () {
            if($(this).attr("checked"))
            {
                g_id+=$(this).val()+",";
            }
        });

        if(!g_id)
        {
            layer.msg('请选择班级', {
                icon: 2
                ,shade: 0.01,
            });
            return is_true = false;
        }

        return true

    }

    function show_clock(id,att_type)
    {
        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('show_clock');?>",
            data:{
                id:id,
                att_type:att_type,
            },

            success: function(res) {
                if(res.status)
                {
                    $(".clockid").val(id);
                    var arr = res.data;
                    var name = arr['activity_name'];
                    var begin = arr['begin_time'];
                    var end = arr['end_time'];
                    var type = arr['type'];
                    var group = arr['group'];

                    var card = arr['card'];
                    if(type==1)
                    {

                        $("input[name='activity_type']").attr("checked",true);
                    }else{
                        $("input[name='activity_type']").attr("checked",false);
                    }
                    $("input[name=activity]").val(name);
                    $("input[name=begintime]").val(begin);
                    $("input[name=endtime]").val(end);
                    for (var i =0; i< group.length; i++) {
                        $("input[name='group[]']").each(function () {
                          if($(this).val()==group[i]['g_id'])
                          {
                              $(this).attr("checked",true);
                          }
                        });
                    }
                    $(".scheduling_main").children().remove();
                    var html = "";

                    if(card.length > 0)
                    {

                        for(var j = 0; j <card.length; j++)
                        {
                            var begin = card[j]['card_begin'];
                            var begin_timing = card[j]['card_begin_timing'];
                            var end = card[j]['card_end'];
                            var end_timing = card[j]['card_end_timing'];
                            var content = card[j]['content']

                            html+="<tr>"
                            html+="<td><input id='11' class='J_date date' name=card_begin[] type=text  value="+begin+" style='border-radius:4px;height:8px;width:100px;margin-right:8px;border:1px solid #dce4ec;'><input type=time  name=card_begin_timing[] value="+begin_timing+" style='border-width: 1px;width: 73px; height: 8px;'></td>"
                            html+="<td><input id='11' class='J_date date' name=card_end[] type=text  value="+end+" style='border-radius:4px;height:8px;width:100px;margin-right:8px;border:1px solid #dce4ec;'><input type=time  name=card_end_timing[]  value="+end_timing+" style='border-width: 1px;width: 73px; height: 8px;'></td>"
                            html+="<td><input name=content[] type=text style='border-radius: 4px;height: 8px;width: 200px;    margin-right: 8px;    border: 1px solid #dce4ec;' value="+content+"></td>"
                            html+="<td  style='vertical-align:1px; cursor: pointer;' onclick=remove_tr(this)>×</td>"
                            html+="</tr>"
                        }
                    }else{


                        html+="<tr>"
                        html+="<td><input id='11' class='J_date date' name=card_begin[] type=text style='border-radius:4px;height:8px;width:100px;margin-right:8px;border:1px solid #dce4ec;'><input type=time  name=card_begin_timing[] value=09:00 style='border-width: 1px;width: 73px; height: 8px;'></td>"
                        html+="<td><input id='11' class='J_date date' name=card_end[] type=text style='border-radius:4px;height:8px;width:100px;margin-right:8px;border:1px solid #dce4ec;'><input type=time  name=card_end_timing[] value=09:00 style='border-width: 1px;width: 73px; height: 8px;'></td>"
                        html+="<td><input  name=content[] type=text  style='border-radius: 4px;height: 8px;width: 200px;    margin-right: 8px;    border: 1px solid #dce4ec;'></td>"
                        html+="<td  style='vertical-align:1px; cursor: pointer;s' onclick=remove_tr(this)>×</td>"
                        html+="</tr>"
                    }

                    $(".scheduling_main").append(html)

                    $(".add_clock_modal").show()
                    $(".date").datePicker();

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }

    function remove_tr(obj)
    {
        $(obj).parent().remove();

    }

    function edit_type(obj,id,type)
    {
        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('edit_type');?>",
            data:{
                id:id,
                type:type,
            },

            success: function(res) {
                if(res.status)
                {
                    if(type==1)
                    {
                       $(obj).removeAttr("onclick");
                       $(obj).css("background-color","#c2c2c2");
                      $(obj).next().attr("onclick","edit_type(this,"+id+",0)");
                      $(obj).next().css("background-color","#FF5722");
                      $(obj).parent().prev().prev().find("span").text("有效");
                      $(obj).parent().prev().prev().find("span").css("color","#5FB878");
                    }else{
                        $(obj).removeAttr("onclick");
                        $(obj).css("background-color","#c2c2c2");
                        $(obj).prev().attr("onclick","edit_type(this,"+id+",1)");
                        $(obj).prev().css("background-color","#1E9FFF");
                        $(obj).parent().prev().prev().find("span").text("无效");
                        $(obj).parent().prev().prev().find("span").css("color","#FF5722");
                    }

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });

    }

</script>





</body>
</html>