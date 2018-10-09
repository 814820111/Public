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
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo U('index');?>">摄像头管理</a></li>
        <li><a href="<?php echo U('add');?>">新增摄像头</a></li>
    </ul>
    <form class="well form-search" method="post" action="<?php echo U('MonitorChannel/index');?>">
        <div class="mb10">
            <span class="mr20">
				     	省份:
						<select  class="province"  name="province" id="province" style="width: 105px;">
							<option value="">

                        省级选择&nbsp;
                        &nbsp;

                        </option>
							<?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?>
								<option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
						市级:<input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>">
						<select class="select_1" name="citys" id="citys" style="width: 105px;">
                               <option value="">选择市级</option>
						</select>
						区级:<input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>">
						<select class="select_3" name="message_type" id="message_type" style="width: 105px;">
							 <option value="0">选择区域</option>
						</select>
						学校：<input type="hidden" class="type_school" value="<?php echo ($schoolid); ?>">
				  <select  name="schoolid" id="viewOLanguage" class="chzn-select"  tabindex="2" >
                    <option value="">选择学校</option>
                   </select>
						</span>
            <input type="text" name="keyword" class="keyword" style="width: 230px;" value="<?php echo ($keyword); ?>" placeholder="请输入学校名称">
            <input type="submit" class="btn btn-primary ss" value="搜索" />
            <input type="button" class="btn btn-warning" value="重置" onclick="urls('MonitorChannel/index')" />
        </div>
    </form>
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th><input type="checkbox" id="checkAll" name="" style="vertical-align: -2px">&nbsp;&nbsp;全选</th>
            <th>ID</th>
            <th>设备ID</th>
            <th>摄像头名称</th>
            <th>摄像头别名</th>
            <th>节点</th>
            <th width="180">管理操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($info)): foreach($info as $key=>$vo): ?><tr>
                <td><input type="checkbox" class="checkList" name="delete[]" value="<?php echo ($vo["id"]); ?>"></td>
                <td><?php echo ($vo["id"]); ?></td>
                <td><?php echo ($vo["deviceserial"]); ?></td>
                <td><?php echo ($vo["channelname"]); ?></td>
                <td><?php echo ($vo["nname"]); ?></td>
                <td><?php echo ($vo["school_name"]); ?></td>
                <td>
                    <!-- <button type="button" class="btn btn-info" onclick="goTo('Monitor/look',<?php echo $vo['id']?>)">查看</button>
                    <button type="button" class="btn btn-success" onclick="goTo('Monitor/editMonitors',<?php echo $vo['id']?>)">修改</button>
                   <button type="button" class="btn btn-danger" onclick="alertMsg('Monitor/deleteMonitors',<?php echo $vo['id']?>)">删除</button>  -->
                    <a class="" href="<?php echo U('MonitorChannel/edit',array('id'=>$vo['id']));?>">修改</a>
                    <a class="J_ajax_del" href="<?php echo U('MonitorChannel/delete',array('id'=>$vo['id']));?>">删除</a>
                    <br /> 
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <button class="btn btn-warning" id="deleteClick" style="width: 100px;height: 30px;float: left;margin: 20px 20px 20px 0;">删除</button>
    <div class="pagination" style="float: left"><?php echo ($page); ?></div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script>
    function urls(url) {
        location.href="/weixiaotong2016/index.php/Admin/"+url;
    }
    $('#checkAll').click(function () {
        var isChecked = $(this).attr('checked');
        if (isChecked == 'checked'){
            $('.checkList').each(function (k, v) {
                $(this).attr('checked', true);
            });
        }else{
            $('.checkList').each(function (k, v) {
                $(this).attr('checked', false);
            });
        }
    });
    $('#deleteClick').click(function () {
        var ids = [];
        $('.checkList').each(function (k,v) {
            var isChecked = $(this).attr('checked');
            if (isChecked){
                ids.push($(this).val());
            }
        });
        var jsonStr = JSON.stringify(ids);
        //alert(jsonStr);
        if (jsonStr != '[]'){
            $.ajax({
                type: 'post',
                url: '<?php echo U("deleteAll");?>',
                data: {ids: jsonStr},
                dataType: 'json',
                success: function (res) {
                    if (res['status'] == 200){
                        location.href = "<?php echo U('index');?>";
                    }
                },
                error: function () {
                    alert("错误");
                }
            });
        }
    });

    //选择市级的下拉的ajax
    $(function() {
        $("#province").change(function(){

            $("#citys").empty();
            $("#message_type").empty();
            $(".Sio").text("")

            $("#viewOLanguage").empty();
            $("#viewOLanguage").append("<option value=''>选择学校</option>");

            // $("#student").empty();

            $("#message_type").append("<option value=>"+"选择区域"+"</option>");
            $("#citys").append("<option value=0>"+"选择市级"+"</option>");

            if( $("#province").val()==0)
            {
                return false;
            }

            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){


                if(data.status=="success"){


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
            $("#message_type").empty();
            $(".Sio").text("")
            $("#viewOLanguage").empty();
            $("#message_type").append("<option value=>"+"选择区域"+"</option>");
            $("#viewOLanguage").append("<option value=''>选择学校</option>");
            if( $("#citys").val()==0)
            {
                return false;
            }

            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                console.log(data);
                if(data.status=="success"){


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
    //学校的点击事件

    $(".select_3").change(function() {
        $("#viewOLanguage").empty();
        $(".Sio").text("")
        $("#viewOLanguage").trigger("liszt:updated");
        $("#viewOLanguage").append("<option value=''>选择学校</option>");
        var type = $(".select_3  option:selected").val();


        $.ajax({
            type: "post",
            url: '/weixiaotong2016/index.php/?g=Admin&m=MonitorSchool&a=lookup',
            async: true,
            data: {
                type: type
            },
            dataType: 'json',
            success: function(res) {

                var html = "";
                res = eval(res.data);

                for(var i = 0; i < res.length; i++) {
                    var school_name = res[i].school_name; //学校的名字
                    var schoolid = res[i].schoolid; //学校的ID
                    html += '<option name="school"  class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
                }
                $(".chzn-select").append(html)
                $("#viewOLanguage").chosen();
                $("#viewOLanguage").trigger("liszt:updated");
            },
            error: function() {
                console.log('系统错误,请稍后重试');
            }
        });
    })

    $(".ss").click(function() {

        var province = $("#province option:selected").val();
        var zhi = $(".keyword").val();
        var type = $(".select_3  option:selected").val();
        var city = $("#citys  option:selected").val();
        var isSuccess = 1;

        if(zhi == "" ) {
            if(!province){
                alert("请选择省份");
                var isSuccess =0;
                return false;
            }
            if(city == 0) {
                alert("请选择城市");
                var isSuccess = 0;
                return false;
            }
            if(type == 0) {
                alert("请选择地区");
                var isSuccess = 0;
                return false;
            }
        }
        if(isSuccess == 0) {
            return false;
        }
    })


    if($("#province").val())
    {
        var new_citys = $('body').find(".new_citys").val();

        var new_message_type = $('body').find('.new_message_type').val();
        // console.log(type);

        var type_school = $('body').find(".type_school").val();



        if(new_citys || $("#province").val())
        {
            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                console.log(data);
                if(data.status=="success"){
                    $("#citys").empty();
                    $("#citys").append("<option value=>"+"选择市级"+"</option>");
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
                            $("#message_type").append("<option value=>"+"选择区域"+"</option>");

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
                                url: '/weixiaotong2016/index.php/?g=Admin&m=MonitorSchool&a=lookup',
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


                                    for(var i = 0; i < res.length; i++) {
                                        var school_name = res[i].school_name; //学校的名字
                                        var schoolid = res[i].schoolid; //学校的ID

                                        // alert('aa');
                                        // alert(type_school);
                                        if(schoolid == type_school){
                                            // html += '<option class="Sio" value="' + schoolid + ' " selected>' + school_name + ' </option> '
                                            $("#viewOLanguage").append("<option value="+schoolid+" selected >"+school_name+"</option>");
                                            $("#add_student").attr("data-school",schoolid);

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


</script>
</body>
</html>