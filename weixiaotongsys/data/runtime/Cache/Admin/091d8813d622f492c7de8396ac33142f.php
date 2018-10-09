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
<style>

    .chzn-container-single .chzn-single {
        position: relative;
        top: 12px;
        height: 29px;
    }

</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo U('DeviceManage/index');?>">所有设备</a></li>
        <li><a href="<?php echo U('DeviceManage/add');?>">添加设备</a></li>
    </ul>
    <div class="common-form">
        <form class="well form-search" method="post" action="<?php echo U('DeviceManage/index');?>" r>
            <div class="search_type cc mb10">
                <div class="mb10">
					<span class="mr20">
							省份：
						<select class="province" name="province" id="province" style="width: 105px;">
							<option value="">省级选择</option>
							<?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?>
								<option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
                        <input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>" >
						市级：
						<select name="city" class="citys" id="citys" style="width: 105px;">
							<option value="0" class="">市级选择</option>
						</select>
                         <input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>">
						县级:&nbsp;
						<select  class="select_3" id="message_type" name = "message_type" style="width: 105px;">
							<option value="" class="">请选择区域</option>

						</select>

						学校:
							<select data-placeholder="输入关键字。。。" id="viewOLanguage" class="chzn-select"  tabindex="2" name="school_id">
								<option value=""></option>
							</select>
						</span>
                    <input type="hidden" class="type_school" value="<?php echo ($schoolid); ?>">
                </div>
            </div>
            <br>
            <div class="mb10">
                <!--<span class="mr20">-->
                <!--公话号码：-->
                <!--<input type="text" name="keyword" id='keyword' style="width: 200px;" value="<?php echo ($keyword); ?>">-->
                <!--</span>-->
                <!--<span class="mr20">-->
                <!--公话编号：-->
                <!--<input type="text" name="keyword" id='keyword' style="width: 200px;" value="<?php echo ($keyword); ?>">-->

                <!--</span>-->
                <!--<span class="mr20">-->
                <!--IMEI：-->
                <!--<input type="text" name="keyword" id='keyword' style="width: 200px;" value="<?php echo ($keyword); ?>">-->
                <!---->
                <!--</span>-->
                查询：
                <select  class="tiaojian" name="keywordtype" style="width: 100px">
                    <?php $keyro=$tiaojian=='phone'?"selected":""; ?>
                    <?php $keyros=$tiaojian=='number'?"selected":""; ?>
                    <option value="0">查询类型</option>
                    <option value="phone" <?php echo ($keyro); ?>>公话号码</option>
                    <option value="number" <?php echo ($keyros); ?>>设备编号</option>
                </select>
                <input type="text" name="keyword" class="zhi" style="width: 200px;" value="<?php echo ($shuzhi); ?>"
                       placeholder="请输入关键字...">
                <input type="submit" class="btn btn-primary ss" value="搜索"/>
                <input type="button" class="btn btn-primary" value="导出"/>
                <a class="btn btn-danger" href="<?php echo U('index');?>">清空</a>

            </div>
        </form>

        <form method="post" class="J_ajaxForm" action="#">
            <?php $status=array("1"=>"显示","0"=>"隐藏"); $types=array("1"=>"大屏机","2"=>"电话","3"=>"通道闸"); $controls=array("1"=>"监控","0"=>"不监控"); $voices=array("1"=>"是","0"=>"否"); $updates=array("-1"=>"正在下发","0"=>"开始下发","1"=>"等待下发"); ?>
            <table width="100%" class="table table-hover table-bordered table-list ">
                <thead>
                <tr>
                    <th width="16"><label><input type="checkbox" class="J_check_all" data-direction="x"
                                                 data-checklist="J_check_x"></label></th>
                    <th style="min-width:50px">ID</th>
                    <th style="min-width:50px">所属SA</th>
                    <th style="min-width:50px">市/镇区</th>
                    <th style="min-width:50px">学校名称</th>
                    <th style="min-width:50px">设备编号</th>
                    <th style="min-width:50px">设备类型</th>
                    <th style="min-width:80px">SN</th>
                    <th style="min-width:50px">创建时间</th>
                    <th>备注</th>
                    <th style="min-width:50px">协议</th>
                    <th style="min-width:50px">开通状态</th>
                    <th style="min-width:50px">是否监控</th>
                    <th style="min-width:50px">是否语音话机</th>
                    <th style="min-width:50px">操作</th>
                    <th style="min-width:50px">下发卡信息</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($ads)): foreach($ads as $key=>$vo): ?><tr>

                        <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x"
                                   name="ids[]" value="<?php echo ($vo["deviceId"]); ?>"></td>
                        <td><?php echo ($vo["id"]); ?></td>
                        <td><?php echo ($vo["agentname"]); ?></td>
                        <td><?php echo ($vo["cityname"]); ?></td>
                        <td><?php echo ($vo["schoolname"]); ?></td>
                        <td><?php echo ($vo["deviceid"]); ?></td>
                        <td><?php echo ($types[$vo['type']]); ?></td>
                        <td><?php echo ($vo["sn"]); ?></td>
                        <td><?php echo (date("Y-m-d",$vo["create_time"])); ?><br/><?php echo (date("H:i:s",$vo["create_time"])); ?></td>
                        <td><?php echo ($vo["remark"]); ?></td>
                        <td><?php echo ($vo["agreements"]); ?></td>
                        <td><?php echo ($controls[$vo['control']]); ?></td>
                        <td><?php echo ($voices[$vo['voice']]); ?></td>
                        <td><?php echo ($status[$vo['status']]); ?></td>

                        <td>
                            <a href="<?php echo U('DeviceManage/close',array('id'=>$vo['deviceid']));?>">关闭短信发送</a>|
                            <a href="<?php echo U('DeviceManage/edit',array('id'=>$vo['id']));?>">修改</a>
                        </td>
                        <td>
                            <?php if($vo['update_state'] == 0): ?><a href="<?php echo U('DeviceManage/update',array('id'=>$vo['id']));?>" class="J_ajax_dialog_btn"
                                   data-msg="确定要下发数据？"><?php echo ($updates[$vo['update_state']]); ?></a>
                                <?php else: ?>
                                <a href="#" class="J_ajax_dialog_btn" data-msg="数据正在下发中,请刷新页面查看！"><?php echo ($updates[$vo['update_state']]); ?></a><?php endif; ?>
                        </td>
                    </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
        </form>

        <!--<div class="search_type cc mb10" align="center">-->
        <!--<div class="mb10">-->
        <!--<span class="mr20">-->
        <!--<a class="btn btn-primary" href="<?php echo U('DeviceManage/add');?>">添加设备</a>&nbsp;&nbsp;-->
        <!--<input type="button" class="btn btn-primary" value="批量导入" />&nbsp;&nbsp;-->
        <!--<input type="button" class="btn btn-primary" value="修改公话" />&nbsp;&nbsp;-->
        <!--<input type="button" class="btn btn-primary" value="修改公话" />&nbsp;&nbsp;-->
        <!--</span>-->
        <!---->
        <!--</div>-->
        <!--</div>-->
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js?"></script>
<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>
<script>

    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });

    if($("#province").val())
    {
        var new_citys = $('body').find(".new_citys").val();

        var new_message_type = $('body').find('.new_message_type').val();


        // console.log(type);

        var type_school = $('body').find(".type_school").val();

        if(new_citys)
        {
            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                console.log(data);
                if(data.status=="success"){
                    $("#citys").empty();
                    $("#citys").append("<option value=0>"+"请选择市级"+"</option>");
                    for(var key in data.data){

                        if(new_citys==data.data[key]["term_id"]){
                            $("#citys").append("<option value="+data.data[key]["term_id"]+ " selected >"+data.data[key]["name"]+"</option>");

                        }else{
                            $("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                        }
                    }
                    $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                        // console.log(data);
                        if(data.status=="success"){
                            $("#message_type").empty();

                            for(var key in data.data){
                                if(new_message_type == data.data[key]["term_id"]){
                                    $("#message_type").append("<option value="+data.data[key]["term_id"]+" selected >"+data.data[key]["name"]+"</option>");
                                }else{
                                    $("#message_type").append("<option value="+data.data[key]["term_id"]+" >"+data.data[key]["name"]+"</option>");
                                }

                            }
                            var type = $(".select_3  option:selected").val();

                            $.ajax({
                                type: "post",
                                url: '/weixiaotong2016/index.php/?g=Admin&m=AdminUtils&a=lookup',
                                async: true,
                                data: {
                                    type: type
                                },
                                dataType: 'json',
                                success: function(res) {
                                    // $(".Sio").text("")
                                    $("#viewOLanguage").empty();
                                    var html = "";
                                    res = eval(res.data);
                                    $("#viewOLanguage").append("<option value='0' >请选择学校</option>");
                                    console.log(res);
                                    for(var i = 0; i < res.length; i++) {
                                        var school_name = res[i].school_name; //学校的名字
                                        var schoolid = res[i].schoolid; //学校的ID

                                        // alert('aa');
                                        // alert(type_school);
                                        if(schoolid == type_school){
                                            // html += '<option class="Sio" value="' + schoolid + ' " selected>' + school_name + ' </option> '
                                            $("#viewOLanguage").append("<option value="+schoolid+" selected >"+school_name+"</option>");
                                        }else{
                                            $("#viewOLanguage").append("<option value="+schoolid+" >"+school_name+"</option>");
                                        }
                                    }
                                    $(".chzn-select").append(html)
                                    $("#viewOLanguage").chosen();
                                    $("#viewOLanguage").trigger("liszt:updated");
                                },
                                error: function() {
                                    console.log('系统错误,请稍后重试');
                                }
                            });



                        }
                        if(data.status=="error"){
                            $("#message_type").append("<option value='0'>没有区域</option>");
                        }
                    });



                }
                if(data.status=="error"){
                    $("#citys").append("<option value='0'>没有市级</option>");
                }
            });

        }


    }



    //选择市级的下拉的ajax
    $(function() {
        $("#province").change(function(){

            $("#citys").empty();
            $("#message_type").empty();
            $(".Sio").text("")

            $("#viewOLanguage").empty();
            $("#viewOLanguage").chosen();
            $("#viewOLanguage").trigger("liszt:updated");

            // $("#student").empty();

            $("#message_type").append("<option value=>"+"选择区域"+"</option>");
            $("#citys").append("<option value=0>"+"选择市级"+"</option>");
            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                $("#citys").empty();

                if(data.status=="success"){

                    $("#citys").append("<option value=0>"+"请选择市级"+"</option>");
                    for(var key in data.data){
                        $("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                    }
                }
                if(data.status=="error"){
                    $("#citys").append("<option value='0'>没有市级</option>");
                }
            });


        })
    });
    $(function() {
        $("#citys").change(function() {
            console.log($("#citys").val())
            $("#message_type").empty();
            $(".Sio").text("")
            $("#viewOLanguage").empty();
            $("#viewOLanguage").chosen();
            $("#viewOLanguage").trigger("liszt:updated");
            $("#message_type").append("<option value=>"+"选择区域"+"</option>");
            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                console.log(data);
                if(data.status=="success"){

                    // $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
                    for(var key in data.data){
                        $("#message_type").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                    }
                }
                if(data.status=="error"){
                    $("#message_type").append("<option value='0'>暂无区域</option>");
                }
            });
        });
    });

    $(".select_3").change(function() {
        var type = $(".select_3  option:selected").val();
        $.ajax({
            type: "post",
            url: '/weixiaotong2016/index.php/?g=Admin&m=AdminUtils&a=lookup',
            async: true,
            data: {
                type: type
            },
            dataType: 'json',
            success: function(res) {
                $(".Sio").text("")
                var html = "";
                res = eval(res.data);
                for(var i = 0; i < res.length; i++) {
                    var school_name = res[i].school_name; //学校的名字
                    var schoolid = res[i].schoolid; //学校的ID
                    html += '<option class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
                }
                $(".chzn-select").append(html)
                $("#viewOLanguage").chosen();
                $("#viewOLanguage").trigger("liszt:updated");
            },
            error: function() {
                console.log('系统错误,请稍后重试');
            }
        });
    });
    $(".ss").click(function() {

        var xuan = $(".tiaojian option:selected").val();
        var zhi = $(".zhi").val();
        var type = $(".select_3  option:selected").val();

        var typeschool = $(".chzn-select  option:selected").val();

        var isSuccess = 1;
        if(zhi == "") {
            if(xuan != 0) {
                alert(xuan);
                var isSuccess = 0;
                alert("在选好条件在输入框中输入你要找的数据类型");

            }
        }
        if(xuan == 0) {
            if(zhi != "") {
                var isSuccess = 0;
                alert("请选择你要搜索的查询类型")
            }
        }
        if(zhi == "" && xuan == 0) {
            if(type == 0) {
                alert("请选择地区");
                var isSuccess = 0;
            }
//            if(typeschool == "") {
//                var isSuccess = 0;
//                alert("请选择学校");
//            }
        }
        if(isSuccess == 0) {
            return false;
        }
    })


    //    function getCitys(Province) {
//        $(".jiu").hide();
////        var Province = $(".province option:selected").val();
//        if (Province == "") {
//            alert("请选择你要搜索的省")
//        } else {
//            $.ajax({
//                type: "post",
//                url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=Provinces',
//                async: true,
//                data: {
//                    Province: Province
//                },
//                dataType: 'json',
//                success: function (res) {
//                    var html = "";
//                    res = eval(res.data);
//                    for (var i = 0; i < res.length; i++) {
//                        var name = res[i].name;//地区的名字；
//                        var term_id = res[i].term_id;//地区的ID
//                        html += '<option class="jiu"value="' + term_id + '">' + name + ' </option> '
//                    }
//                    $(".citys").append(html);
//                },
//                error: function () {
//                    console.log('系统错误,请稍后重试');
//                }
//            });
//        }
//    }
//
//    function getQu(zhi) {
//        $(".jius").hide()
////        var zhi = $(".citys option:selected").val();
//        if (zhi == "") {
//            alert("请选你要搜索的市")
//        } else {
//            $.ajax({
//                type: "post",
//                url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=Provinces',
//                async: true,
//                data: {
//                    Province: zhi
//                },
//                dataType: 'json',
//                success: function (res) {
//                    var html = "";
//                    res = eval(res.data);
//                    for (var i = 0; i < res.length; i++) {
//                        var name = res[i].name;//地区的名字；
//                        var term_id = res[i].term_id;//地区的ID
//                        html += '<option class="jius"value="' + term_id + '">' + name + ' </option> '
//                    }
//                    $(".message_type").append(html)
//                },
//                error: function () {
//                    console.log('系统错误,请稍后重试');
//                }
//            });
//        }
//    }

    //选择市级的下拉的ajax
    //        $(".citys").click(function(){
    //            $(".jiu").hide();
    //            var Province =$(".province option:selected").val();
    //            if(Province==""){
    //                alert("请选择你要搜索的省")
    //            }else{
    //                $.ajax({
    //                    type:"post",
    //                    url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=Provinces',
    //                    async:true,
    //                    data:{
    //                        Province:Province
    //                    },
    //                    dataType: 'json',
    //                    success: function(res) {
    //                        var html = "";
    //                        res = eval(res.data);
    //                        for(var i = 0; i < res.length; i++) {
    //                            var name=res[i].name;//地区的名字；
    //                            var term_id=res[i].term_id;//地区的ID
    //                            html+='<option class="jiu"value="'+term_id+'">'+name+' </option> '
    //                        }
    //                        alert(html);
    //                        $(".citys").append(html);
    //                    },
    //                    error: function() {
    //                        console.log('系统错误,请稍后重试');
    //                    }
    //                });
    //            }
    //
    //        })
    //选择县级市
//    $(".message_type").click(function () {
//        $(".jius").hide()
//        var zhi = $(".citys option:selected").val();
//        if (zhi == "") {
//            alert("请选你要搜索的市")
//        } else {
//            $.ajax({
//                type: "post",
//                url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=Provinces',
//                async: true,
//                data: {
//                    Province: zhi
//                },
//                dataType: 'json',
//                success: function (res) {
//                    var html = "";
//                    res = eval(res.data);
//                    for (var i = 0; i < res.length; i++) {
//                        var name = res[i].name;//地区的名字；
//                        var term_id = res[i].term_id;//地区的ID
//                        html += '<option class="jius"value="' + term_id + '">' + name + ' </option> '
//                    }
//                    $(".message_type").append(html)
//                },
//                error: function () {
//                    console.log('系统错误,请稍后重试');
//                }
//            });
//        }
//
//    })
    $("#viewOLanguage").chosen();
    $("#viewOLanguage").trigger("liszt:updated");
//
//    $(".message_type").change(function () {
//
//        var type = $(".message_type  option:selected").val();
//        $.ajax({
//            type: "post",
//            url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=lookup',
//            async: true,
//            data: {
//                type: type
//            },
//            dataType: 'json',
//            success: function (res) {
//                $(".Sio").text("")
//                var html = "";
//                res = eval(res.data);
//                for (var i = 0; i < res.length; i++) {
//                    var school_name = res[i].school_name;//学校的名字
//                    var schoolid = res[i].schoolid;//学校的ID
//                    html += '<option name="school" class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
//                }
//                $(".chzn-select").append(html)
//                $("#viewOLanguage").chosen();
//                $("#viewOLanguage").trigger("liszt:updated");
//            },
//            error: function () {
//                console.log('系统错误,请稍后重试');
//            }
//        });
//    })

</script>
</body>
</html>