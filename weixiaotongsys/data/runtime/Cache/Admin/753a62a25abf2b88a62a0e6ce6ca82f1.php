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
    .wraps {
        width: 120px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        color: black;
    }
    
    .chzn-container-single .chzn-single {
        position: relative;
        top: 12px;
        height: 29px;
    }
    
    .mohu {
        width: 100px;
        bottom: 30px;
        left: 30px;
        background-color: whitesmoke;
    }
    
    .dbzr {
        background-color: #61c881;
        color: white;
        text-align: center;
        padding: 0px 15px;
        float: left;
        border-radius: 8px;
    }
    
    .sic {
        width: 15px;
        margin-left: 5px;
        margin-top: -15px;
        cursor: pointer;
    }
    
    table td {
        color: black;
    }
    
    span {
        color: black;
    }
    
    div {
        color: black;
    }
    
    img {
        width: 60px;
        height: 55px;
    }
    
    select {
        color: black;
    }
</style>
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>

<body class="J_scroll_fixed" style="">
    <div class="wrap J_check_wrap">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="javascript:;">学生调班</a>
            </li>
            <li>
                <a href="<?php echo U('abnormal');?>" target="_self">异动管理</a>
            </li>

        </ul>
        <form class="well form-search" method="get" action="<?php echo U('index');?>" style="background: #fff;">
            <div class="search_type cc mb10">
                <div class="mb10">
                    <span class="mr20">
					省份选择：
						<select  class="province"  name="province" id="province" style="width: auto;">
							<option value="">&nbsp;&nbsp;
                     
                        省级选择&nbsp;
                        &nbsp;</option>
							<?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?> 
								<option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>&nbsp;&nbsp;
						<input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>">
						市级:
						<select class="select_1" name="citys" id="citys" style="width: auto;">		
						
                               <option value="">请先选择省份</option>
                               
						</select> &nbsp;&nbsp;
						<input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>">
						区级
						<select class="select_3" name="message_type" id="message_type" style="width: auto;">		
							 <option value="0">请选择你的区域</option>
						</select> &nbsp;&nbsp;
						学校： 
				  <select data-placeholder="输入关键字。。。" name="schoold" id="viewOLanguage" class="chzn-select"  tabindex="2" >
                    <option value=""></option>
                  </select>
                   <input type="hidden" class="type_school" value="<?php echo ($schoolid); ?>">
                  <div class="mr20">
                    条件选择：
                   <span class="mr20">

				     
						<select class="tiaojian"/ name="tiaojian" style="width: auto;">
						 
						    <option value="0">&nbsp;&nbsp;
                     
                        查询类型&nbsp;
                        &nbsp;</option>
						  
							<option value="name"  <?php if($tiaojian==name) echo("selected");?> >学生名字</option>
					
							
						
							<option value="names" <?php if($tiaojian==names) echo("selected");?>>家长名字</option>
						
							<option value="phone" <?php if($tiaojian==phone) echo("selected");?>>家长号码</option>
						</select>
						 <input type="text" placeholder="根据条件进行模糊查询" name="shuzhi" class="zhi"/ value="<?php echo ($shuzhi); ?>" style="width: 150px;">
						</span>
                    <!-- 时间：
						<input type="text" name="start_time" class="J_date" value="<?php echo ((isset($formget["start_time"]) && ($formget["start_time"] !== ""))?($formget["start_time"]):''); ?>" style="width: 80px;" autocomplete="off">- -->
                    <!-- <input type="text" class="J_date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp; -->
                    <div style="       display: inline-block;
    margin-top: 8px; margin-left: 200px;">
                        <button type="button" class="btn btn-primary ss" />搜索</button>&nbsp;&nbsp;


                        <!-- 		<input type="button" class="btn btn-success daochu" value="导出" />
						<a class="btn btn-danger" href="<?php echo U('student');?>">导入</a> -->
                        <a class="btn btn-success  change_class" data-toggle="modal">调班</a>&nbsp;&nbsp;
                        <a class="btn btn-danger drop">退学</a>&nbsp;&nbsp;
                        <a class="btn btn-danger" href="<?php echo U('index');?>">清空</a>
                    </div>
                    </span>
                </div>
            </div>
        </form>





        <!--调班级strat-->

        <div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                        <button type="button" class="close dkgb" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <!--存放老师id-->
                        <input type="hidden" class="groupschool" />
                        <!--存放班级改变时候的班级ID-->

                        <div style=" cursor: pointer;">
                            <ul class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
                                <li class="active " id="daibananiu">
                                    <a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">调班管理</a>
                                    &nbsp;<span style="color: red;">*该页面只能调整正规班级</span>
                                </li>

                            </ul>

                        </div>

                    </div>
                    <form  id="edit_class" >
                        <div class="modal-body">
                            <div class="hide" style="display: block;     text-align: center;">


                                <div>
                                    <span style="margin-left: 41px;">学生:&nbsp;&nbsp;</span><input type="text" class="change_name" readonly="true"><br>
                                    <span style="margin-left: 28px;">原班级:&nbsp;&nbsp;</span><input type="text" class="change_class_old" readonly="true"><br>
                                    <input type="hidden" class="changeid" name="changeid">
                                    <input type=hidden class="old_class" name="old_class">
                                    <input type=hidden class="change_school" name="change_school"> 选择班级:&nbsp;&nbsp;

                                    <select name="change_class" id="change_class" style="    vertical-align: 0px; margin-top: 10px;"></select>

                                </div>
                                <input type="hidden" class="teacherid">

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary tjclass" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" \>提交更新</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal -->
        </div>

        <!--调班级end-->

        <!--退学strat-->

        <div class="modal fade" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                        <button type="button" class="close dkgb" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <!--存放老师id-->
                        <input type="hidden" class="groupschool" />
                        <!--存放班级改变时候的班级ID-->

                        <div style=" cursor: pointer;">
                            <ul class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
                                <li class="active " id="daibananiu">
                                    <a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">退学原因</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <form action="<?php echo U('student_move');?>" method="get">
                        <div class="modal-body">
                            <div class="hide" style="display: block;     text-align: center;">


                                <div>
                                    <span style="margin-left: 28px;">学生:</span>&nbsp;&nbsp;<input type="text" class="move_name" readonly="true"><br>
                                    <input type="hidden" class="move_changeid" name="changeid">
                                    <input type=hidden class="move_class" name="old_class">
                                    <input type=hidden class="move_school" name="change_school"> 退学原因:&nbsp;&nbsp;

                                    <textarea class="student_cause" name="student_cause" rows="4" style="margin-top: 10px;"></textarea>

                                </div>
                                <input type="hidden" class="teacherid">

                            </div>

                        </div>

                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary " value="提交更新" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" \>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal -->
        </div>

        <!--退学end-->


        <!--家长IC卡号设置end-->




        <form class="J_ajaxForm" action="" method="post">
            <div class="table-actions">
                <!-- 				<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Student/listorders');?>">排序</button> -->
                <!-- <button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Stuent/check',array('check'=>1));?>" data-subcheck="true">审核</button>
				<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Stuent/check',array('uncheck'=>1));?>" data-subcheck="true">取消审核</button> -->
            </div>
            <table class="table table-hover table-bordered table-list ">
                <thead>
                    <tr>
                        <th align='center'><input type='checkbox' id='checkAll' name="checkAll" style="    vertical-align: -2px;"></th>
                        <th>头像</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>登录手机号</th>
                        <th>班级</th>
                        <th>家长</th>
                        <th>创建时间</th>

                    </tr>
                </thead>
                <tbody class="studentlist">
                </tbody>
                <!-- <tfoot>
					<tr>
						<th width="15"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
						<th width="50">排序</th>
						<th>标题</th>
						<th>栏目</th>
						<th width="50">点击量</th>
						<th width="50">评论量</th>
						<th width="50">关键字</th>
						<th width="50">来源</th>
						<th width="50">摘要</th>
						<th width="50">缩略图</th>
						<th width="80">发布人</th>
						<th width="70">发布时间</th>
						<th width="50">状态</th>
						<th width="60">操作</th>
					</tr>
				</tfoot> -->
            </table>
            <div class="pagination"><?php echo ($Page); ?></div>
            <input class="uisid" type="hidden" />
        </form>
    </div>
    <script src="/weixiaotong2016/statics/js/common.js"></script>
    <script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>
    <script>


        $('.drop').click(function() {

            if (confirm("确定要执行以下操作吗？")) {

                var id = document.getElementsByName('ids');
                var ids = new Array();
                var classid = new Array();
                var name = new Array();

                var schoolid = new Array();
                //将所有选中复选框的默认值写入到id数组中
                for (var i = 0; i < id.length; i++) {
                    if (id[i].checked) {
                        ids.push(id[i].value);
                        classid.push(id[i].getAttribute('data-class'));
                        name.push(id[i].parentNode.nextElementSibling.nextElementSibling.innerText);
                        schoolid.push(id[i].getAttribute('data-school'));
                        // console.log($(this).find('.tt').remove());
                    }
                    // $(this).closest('tr').remove();

                }

                if (ids.length > 1) {
                    alert("请一次只退学一个!!");
                    return false;

                }

                if (ids.length < 1) {
                    alert("请选择学生");
                    return false
                }

                $(".move_changeid").val(ids);
                $(".move_class").val(classid);
                $(".move_school").val(schoolid);
                $(".move_name").val(name);

                $("#myModal6").modal("show");

            }
        })



        $('.change_class').click(function() {

            var id = document.getElementsByName('ids');
            var ids = new Array();
            var name = new Array();
            var userid = new Array();
            var classid = new Array();
            var old_class = new Array();
            //将所有选中复选框的默认值写入到id数组中
            for (var i = 0; i < id.length; i++) {
                if (id[i].checked) {
                    ids.push(id[i].getAttribute('data-school'));
                    userid.push(id[i].value);
                    classid.push(id[i].getAttribute('data-class'));
                    old_class.push(id[i].parentNode.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.innerText);
                    name.push(id[i].parentNode.nextElementSibling.nextElementSibling.innerText)
                        // console.log($(this).find('.tt').remove());
                }
                // $(this).closest('tr').remove();

            }
            if (ids == '') {
                alert("请选择要修改的学生");
                return false;
            }
//            if (ids.length > 1) {
//                alert("一次只能调一个学生");
//                return false;
//            }

            // return false;
          var schoolid =   $("select[name='schoold'] option:selected").val();




            if (confirm("确定要调班吗？")) {
                $("#change_class").empty();
                $(".changeid").val(userid);
                $(".old_class").val(classid);
                $(".change_name").val(name);
                $(".change_class_old").val(old_class);
                $(".change_school").val(schoolid);
                $.getJSON("/weixiaotong2016/index.php?g=admin&m=AdminUtils&a=schoolclass&schoolid=" + schoolid, {}, function(data) {
                    console.log(data);
                    if (data.status == "success") {

                        $("#change_class").append("<option value=0>" + "请选择班级" + "</option>");
                        for (var key in data.data) {
                            $("#change_class").append("<option value=" + data.data[key]["id"] + ">" + data.data[key]["classname"] + "</option>");
                        }
                        $("#myModal5").modal("show");
                    }
                    if (data.status == "error") {
                        $("#change_class").append("<option value='0'>没有班级</option>");
                    }
                });




                // alert(ids);
            }

        })






        $(function() {
            $("#checkAll").click(function() {
                $('input[class="J_check"]').prop("checked", $(this).prop("checked"));
            });
            var $J_check = $("input[class='J_check']");
            $J_check.click(function() {
                $("#checkAll").prop("checked", $J_check.length == $("input[class='J_check']:checked").length ? true : false);
            });
        });








        if ($("#province").val()) {
            var new_citys = $('body').find(".new_citys").val();

            var new_message_type = $('body').find('.new_message_type').val();


            // console.log(type);

            var type_school = $('body').find(".type_school").val();

            if (new_citys) {
                $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province=" + $("#province").val(), {}, function(data) {
                    console.log(data);
                    if (data.status == "success") {
                        $("#citys").empty();
                        $("#citys").append("<option value=>" + "请选择市级" + "</option>");
                        for (var key in data.data) {

                            if (new_citys == data.data[key]["term_id"]) {
                                $("#citys").append("<option value=" + data.data[key]["term_id"] + " selected >" + data.data[key]["name"] + "</option>");

                            } else {
                                $("#citys").append("<option value=" + data.data[key]["term_id"] + ">" + data.data[key]["name"] + "</option>");
                            }
                        }
                        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province=" + $("#citys").val(), {}, function(data) {
                            // console.log(data);
                            if (data.status == "success") {
                                $("#message_type").empty();

                                for (var key in data.data) {
                                    if (new_message_type == data.data[key]["term_id"]) {
                                        $("#message_type").append("<option value=" + data.data[key]["term_id"] + " selected >" + data.data[key]["name"] + "</option>");
                                    } else {
                                        $("#message_type").append("<option value=" + data.data[key]["term_id"] + " >" + data.data[key]["name"] + "</option>");
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

                                        console.log(res);
                                        for (var i = 0; i < res.length; i++) {
                                            var school_name = res[i].school_name; //学校的名字
                                            var schoolid = res[i].schoolid; //学校的ID

                                            // alert('aa');
                                            // alert(type_school);
                                            if (schoolid == type_school) {
                                                // html += '<option class="Sio" value="' + schoolid + ' " selected>' + school_name + ' </option> '
                                                $("#viewOLanguage").append("<option value=" + schoolid + " selected >" + school_name + "</option>");
                                            } else {
                                                $("#viewOLanguage").append("<option value=" + schoolid + " >" + school_name + "</option>");
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
                            if (data.status == "error") {
                                $("#message_type").append("<option value='0'>没有区域</option>");
                            }
                        });



                    }
                    if (data.status == "error") {
                        $("#citys").append("<option value='0'>没有市级</option>");
                    }
                });

            }


        }




        //选择市级的下拉的ajax
        $(function() {
            $("#province").change(function() {
                $("#citys").empty();
                $("#message_type").empty();
                $(".Sio").text("")
                $("#viewOLanguage").chosen();
                $("#viewOLanguage").trigger("liszt:updated");

                $("#message_type").append("<option value=>" + "请选择区域" + "</option>");
                // $("#student").empty();
                $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province=" + $("#province").val(), {}, function(data) {
                    console.log(data);
                    if (data.status == "success") {

                        $("#citys").append("<option value=>" + "请选择市级" + "</option>");
                        for (var key in data.data) {
                            $("#citys").append("<option value=" + data.data[key]["term_id"] + ">" + data.data[key]["name"] + "</option>");
                        }
                    }
                    if (data.status == "error") {
                        $("#citys").append("<option value='0'>没有市级</option>");
                    }
                });
            });
        });

        $(function() {
            $("#citys").change(function() {
                $("#message_type").empty();
                $(".Sio").text("")
                $("#viewOLanguage").chosen();
                $("#viewOLanguage").trigger("liszt:updated");
                $("#message_type").append("<option value=>" + "请选择区域" + "</option>");
                if( $("#citys").val()==0)
                {
                    return false;
                }
                $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province=" + $("#citys").val(), {}, function(data) {
                    console.log(data);
                    if (data.status == "success") {

                        // $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
                        for (var key in data.data) {
                            $("#message_type").append("<option value=" + data.data[key]["term_id"] + ">" + data.data[key]["name"] + "</option>");
                        }
                    }
                    if (data.status == "error") {
                        $("#message_type").append("<option value='0'>没有市级</option>");
                    }
                });
            });
        });





        $(function() {
            $("[data-toggle='tooltip']").tooltip();
        });

        function refersh_window() {
            var refersh_time = getCookie('refersh_time');
            if (refersh_time == 1) {
                window.location = "<?php echo U('AdminPost/index',$formget);?>";
            }
        }
        setInterval(function() {
            refersh_window();
        }, 2000);
        $(function() {
            setCookie("refersh_time", 0);
            Wind.use('ajaxForm', 'artDialog', 'iframeTools', function() {
                //批量移动
                $('.J_articles_move').click(
                    function(e) {
                        var str = 0;
                        var id = tag = '';
                        $("input[name='ids[]']").each(function() {
                            if ($(this).attr('checked')) {
                                str = 1;
                                id += tag + $(this).val();
                                tag = ',';
                            }
                        });
                        if (str == 0) {
                            art.dialog.through({
                                id: 'error',
                                icon: 'error',
                                content: '您没有勾选信息，无法进行操作！',
                                cancelVal: '关闭',
                                cancel: true
                            });
                            return false;
                        }
                        var $this = $(this);
                        art.dialog.open(
                            "/weixiaotong2016/index.php?g=portal&m=AdminPost&a=move&ids=" +
                            id, {
                                title: "批量移动",
                                width: "80%"
                            });
                    });
            });
        });
        // $(".select_3").click(function() {
        // 	$(".jiu").hide();
        // 	$.ajax({
        // 		type: "post",
        // 		url: '/weixiaotong2016/index.php/?g=Admin&m=Student&a=chadi',
        // 		async: true,
        // 		data: {
        // 			type: 3
        // 		},
        // 		dataType: 'json',
        // 		success: function(res) {
        // 			var html = "";
        // 			res = eval(res.data);
        // 			for(var i = 0; i < res.length; i++) {
        // 				var name = res[i].name; //地区的名字；
        // 				var term_id = res[i].term_id; //地区的ID
        // 				html += '<option class="jiu"value="' + term_id + '">' + name + ' </option> '
        // 			}
        // 			$(".select_3").append(html);
        // 		},
        // 		error: function() {
        // 			console.log('系统错误,请稍后重试');
        // 		}
        // 	});
        // })

        $("#viewOLanguage").chosen();
        $("#viewOLanguage").trigger("liszt:updated");
        //学校的点击事件

        $(".select_3").change(function() {
            $("#viewOLanguage").empty();
            $(".Sio").text("")
            $("#viewOLanguage").chosen();
            $("#viewOLanguage").trigger("liszt:updated");
            $("#viewOLanguage").append("<option value=''>请选择学校</option>");
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
                    for (var i = 0; i < res.length; i++) {
                        var school_name = res[i].school_name; //学校的名字
                        var schoolid = res[i].schoolid; //学校的ID
                        html += '<option class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
                    }
                    $(".chzn-select").append(html)

                    $("#viewOLanguage").trigger("liszt:updated");
                },
                error: function() {
                    console.log('系统错误,请稍后重试');
                }
            });
        })


        $(document).on("click",".pagination a",function(){

            layer.load();
            //return false;
            $.getJSON($(this).attr('href'),function(data){
                console.log(data);
                setTimeout(function(){
                    layer.closeAll('loading');
                });
                $("table tbody").children().remove();
                $(".pagination").children().remove();

                if(data.status=="error"){
                    // console.log('aaa');
                    $("table tbody").append('<tr><td>没有数据!</td>');
                }

                var adata = data;


                var classid = "";
                var schoolid = "";
                var id = "";
                var photo = "";
                var name = "";
                var sex = "";
                var phone = "";
                var names = "";
                var classlist = "";
                var create_time = "";
                // $("table tbody").children().remove();
                html = "";
                for (var i = 0; i < adata.length; i++) {
                    if (i == 0) {
                        $(".pagination").append(adata[i]);
                        //return false;
                        continue
                    }
                    classid = adata[i]['classid'];
                    schoolid = adata[i]['schoolid'];
                    name = adata[i]['name'];
                    id = adata[i]['id'];
                    photo = adata[i]['photo'];
                    sex = adata[i]['sex'];
                    phone = adata[i]['phone'];
                    names = adata[i]['names'];
                    classlist = adata[i]['classlist'];
                    create_time = adata[i]['create_time'];



                    // j++

                    if(sex==1)
                    {
                        sex = '女';
                    }else{
                        sex = '男';
                    }

                    if(phone==undefined)
                    {
                        phone = '';
                    }
                    html += '<tr><td><input type="checkbox" class="J_check" id=sel_all name="ids" data-class='+classid+' data-school='+schoolid+' value='+id+' ></td> <td style="width: 60px;"><img src=/weixiaotong2016/uploads/microblog/'+photo+' ></td><td>'+name+'</td><td>'+sex+'</td><td>'+phone+'</td><td>'+classlist+'</td><td style="width: 120px;"><div class="wraps" wraps data-toggle="tooltip" data-placement="right" title="'+names+'"> '+names+'</div></td><td>'+timestampToTime(create_time)+'</td></tr>';
                    // $("table tbody").append('<tr><td><input type="checkbox" class="J_check" id=sel_all name="ids" data-class='+classid+' data-school='+schoolid+' value='+id+' ></td> <td style="width: 60px;"><img src=/weixiaotong2016/uploads/microblog/'+photo+' ></td><td>'+name+'</td><td>'+sex+'</td><td>'+phone+'</td><td>'+classlist+'</td><td style="width: 120px;"><div class="wraps" wraps data-toggle="tooltip" data-placement="right" title='+names+'> '+names+'</div></td><td>'+timestampToTime(create_time)+'</td></tr>');
                }
                $(".studentlist").append(html);


            })
            return false;

        })

        $(".ss").click(function() {

            var xuan = $(".tiaojian option:selected").val();
            console.log(xuan);
            var zhi = $(".zhi").val();
            console.log(zhi);
            var type = $(".select_3  option:selected").val();
            console.log(type);
            var typeschool = $(".chzn-select  option:selected").val();
            console.log(typeschool);
            //			return false;
            var isSuccess = 1;
            if (zhi == "") {
                if (xuan != 0) {
                    var isSuccess = 0;
                    alert("在选好条件在输入框中输入你要找的数据类型");

                }
            }
            if (xuan == 0) {
                if (zhi != "") {
                    var isSuccess = 0;
                    alert("请选择你要搜索的查询类型")
                }
            }
            if (zhi == "" && xuan == 0) {
                if (type == 0) {
                    alert("请选择地区");
                    var isSuccess = 0;
                }
                if (typeschool == "") {
                    var isSuccess = 0;
                    alert("请选择学校");
                }
            }
            if (isSuccess == 0) {
                return false;
            }


               layer.load();


            $.ajax({
                url: "/weixiaotong2016/index.php/Admin/AdjustClass/get_student",
                dataType: "json",
                type: "get",
                data: {
                    schoold: typeschool,
                    tiaojian: xuan,
                    shuzhi: zhi,
                    schoolid: typeschool,
                },
                success: function(res) {
                    setTimeout(function() {
                        layer.closeAll('loading');
                    });
                    var adata = res;


                    var classid = "";
                    var schoolid = "";
                    var id = "";
                    var photo = "";
                    var name = "";
                    var sex = "";
                    var phone = "";
                    var names = "";
                    var classlist = "";
                    var create_time = "";
//                    var time = "";
//                    var content = "";


                    $("table tbody").children().remove();
                    $(".pagination").children().remove();
                    if (res.status == "error") {
                        // console.log('aaa');
                        $("table tbody").append('<tr><td style="width: 100px;">没有数据!</td><tr>');
                    }
                    html = "";
                    for (var i = 0; i < adata.length; i++) {
                        if (i == 0) {
                            $(".pagination").append(adata[i]);
                            //return false;
                            continue
                        }
                        classid = adata[i]['classid'];
                        schoolid = adata[i]['schoolid'];
                        name = adata[i]['name'];
                        id = adata[i]['id'];
                        photo = adata[i]['photo'];
                        sex = adata[i]['sex'];
                        phone = adata[i]['phone'];
                        names = adata[i]['names'];
                        classlist = adata[i]['classlist'];
                        create_time = adata[i]['create_time'];



                        // j++

                    if(sex==1)
                    {
                        sex = '女';
                    }else{
                        sex = '男';
                    }

                    if(phone==undefined)
                    {
                        phone = '';
                    }
                           html += '<tr><td><input type="checkbox" class="J_check" id=sel_all name="ids" data-class='+classid+' data-school='+schoolid+' value='+id+' ></td> <td style="width: 60px;"><img src=/weixiaotong2016/uploads/microblog/'+photo+' ></td><td>'+name+'</td><td>'+sex+'</td><td>'+phone+'</td><td>'+classlist+'</td><td style="width: 120px;"><div class="wraps" wraps data-toggle="tooltip" data-placement="right" title="'+names+'"> '+names+'</div></td><td>'+timestampToTime(create_time)+'</td></tr>';
                       // $("table tbody").append('<tr><td><input type="checkbox" class="J_check" id=sel_all name="ids" data-class='+classid+' data-school='+schoolid+' value='+id+' ></td> <td style="width: 60px;"><img src=/weixiaotong2016/uploads/microblog/'+photo+' ></td><td>'+name+'</td><td>'+sex+'</td><td>'+phone+'</td><td>'+classlist+'</td><td style="width: 120px;"><div class="wraps" wraps data-toggle="tooltip" data-placement="right" title='+names+'> '+names+'</div></td><td>'+timestampToTime(create_time)+'</td></tr>');
                    }


                    $(".studentlist").append(html);
                },
                error: function(res) {
                    var data = eval(res.data);

                }
            })
        })

        $(".tjclass").click(function(){
//            console.log($("#change_class").text())
         var classname =   $("#change_class").find("option:selected").text()

            $.ajax({
                //几个参数需要注意一下
                type: "POST",//方法类型
                dataType: "json",//预期服务器返回的数据类型
                url: "/weixiaotong2016/index.php/Admin/AdjustClass/edit_class" ,//url
                data: $('#edit_class').serialize(),
                success: function (data) {
                   if(data.status=='success')
                   {
                       alert("调班成功!");
//                       $("#myModal5").hide();
                       $("input[name='ids']").each(function () {
                           if ($(this).attr('checked')) {

                               $("#myModal5").modal("hide");
                               $(this).parent().parent().find("td:eq(5)").text(classname);

                           }
                           $(this).attr("checked", false);

                       });

                   }else if(data.status=='error'){
                       alert("调班失败");
                   }else{
                        alert(data.info);
                    }

                },
                error : function() {
                    alert("异常！");
                }
            });



        })

        function timestampToTime(timestamp) {
            var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
            Y = date.getFullYear() + '-';
            M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
            D = date.getDate() + ' ';
            h = date.getHours() + ':';
            m = date.getMinutes() + ':';
            s = date.getSeconds();
            return Y+M+D+h+m+s;
        }




        $(".daochu").click(function() {
            var xuan = $(".mohu option:selected").val();
            var zhi = $(".zhi").val();
            var type = $(".select_3  option:selected").val();
            var typeschool = $(".chzn-select  option:selected").val();
            var isSuccess = 1;
            if (zhi == "") {
                if (xuan != 0) {
                    var isSuccess = 0;
                    alert("在选好条件在输入框中输入你要找的数据类型");

                }
            }
            if (xuan == 0) {
                if (zhi != "") {
                    var isSuccess = 0;
                    alert("请选择你要搜索的查询类型")
                }
            }
            if (zhi == "" && xuan == 0) {
                if (type == 0) {
                    alert("请选择地区");
                    var isSuccess = 0;
                }
                if (typeschool == "") {
                    var isSuccess = 0;
                    alert("请选择学校");
                }
            }
            if (isSuccess == 1) {
                location.href = "<?php echo U('Student/Lexcel');?>?schoold=" + typeschool + "&tiaojian=" + xuan + "&shuzhi=" + zhi + "";
            }

        })

        //修改卡号

        function sub_qrcj() {
            var schoolid = $('body').find('.school').val();

            var userid = w;

            var stu_old_card = $("input[name='stu_old_card']").val();

            var cardNo = $("input[name='newICcard']").val();
            // console.log(cardNo);


            if (cardNo == '') {
                alert('卡号不能为空');
                return false;
            }
            if (cardNo == stu_old_card) {
                alert('卡号不能与上次的相同')
                return false;
            }
            var lengthzhi = cardNo.length;
            if (lengthzhi < 10) {
                var ui = 10 - lengthzhi;
                var us = "";
                for (var i = 0; i < ui; i++) {
                    var j = "0";
                    us += j;
                }
                var cardNo = us + cardNo;
            }
            $.ajax({
                type: "post",
                async: false,
                url: "<?php echo U('Admin/Student/updateICcard');?>",
                data: {
                    'userid': userid,
                    'cardNo': cardNo,
                    'stu_old_card': stu_old_card,
                    'schoolid': schoolid,
                },
                success: function(msg) {
                    history.go(0);
                }
            });
        }


        //亲属关系
        $(".daibanzhuren1").click(
            function(ID) {
                $(".qinshu").show()
            }
        )

        $(".guan1").click(
            function() {
                $(".qinshu").hide()
                $('.qinshuxingming0').val('')
                $('.qinshuxingming1').val('')
                $('.qinshuxingming2').val('')
                $('.qinshuhaoma0').val('')
                $('.oldhaoma0').val('')
                $('.qinshuhaoma1').val('')
                $('.oldhaoma1').val('')
                $('.qinshuhaoma2').val('')
                $('.oldhaoma2').val('')
                $('.qinshuguanxi0').val('')
                $('.qinshuguanxi1').val('')
                $('.qinshuguanxi2').val('')
            }
        )





        $('.gb').click(function() {
            // console.log('dsadsa');
            $('.a0').val('');
            $('.a1').val('');
            $('.a2').val('');
            $('.a3').val('');
            $('.a4').val('');
            $('.a0').removeAttr('data-id')
            $('.a1').removeAttr('data-id')
            $('.a2').removeAttr('data-id')
            $('.a3').removeAttr('data-id')
            $('.a4').removeAttr('data-id')
            $('.a_0').val('');
            $('.a_1').val('');
            $('.a_2').val('');
            $('.a_3').val('');
            $('.a_4').val('');

        })

        $('.close').click(function() {

            $('.a0').val('');
            $('.a1').val('');
            $('.a2').val('');
            $('.a3').val('');
            $('.a4').val('');
            $('.a0').removeAttr('data-id')
            $('.a1').removeAttr('data-id')
            $('.a2').removeAttr('data-id')
            $('.a3').removeAttr('data-id')
            $('.a4').removeAttr('data-id')
            $('.a_0').val('');
            $('.a_1').val('');
            $('.a_2').val('');
            $('.a_3').val('');
            $('.a_4').val('');


        })






        //亲属关系end



        $(".daibanzhuren1").click(
            function() {
                $('.qinshuxingming0').val('')
                $('.qinshuxingming1').val('')
                $('.qinshuxingming2').val('')
                $('.qinshuhaoma0').val('')
                $('.oldhaoma0').val('')
                $('.qinshuhaoma1').val('')
                $('.oldhaoma1').val('')
                $('.qinshuhaoma2').val('')
                $('.oldhaoma2').val('')
                $('.qinshuguanxi0').val('')
                $('.qinshuguanxi1').val('')
                $('.qinshuguanxi2').val('')



                stud = $(this).attr('data-id');
                console.log(stud);
                // $(".chuanzhi").val(stud)
                var stuname = $(this).parent().parent().find("td:eq(2)").text()
                console.log(stuname)
                $(".stuhuan").text(stuname)
                var stuid = $(this).parent().siblings(".stuid").text();
                $(".stuhua").text(stuid);


                $.ajax({
                    type: "get",
                    async: false,
                    dataType: 'json',
                    url: "<?php echo U('Admin/Student/showqinshu');?>",
                    data: {
                        studentid: stud,


                    },
                    success: function(data) {
                        console.log(data);

                        if (data.status) {
                            for (var i = 0; i < data.msg.length; i++) {

                                var name = data.msg[i].name; //姓名；
                                var phone = data.msg[i].phone; //手机
                                var relation = data.msg[i].appellation //关系 
                                    // console.log(relation);


                                var j = "qinshuxingming" + i;

                                var k = "qinshuhaoma" + i;

                                var c = "qinshuguanxi" + i;

                                var d = "oldhaoma" + i;
                                // console.log(c);

                                var test = document.getElementsByClassName(j);
                                var hest = document.getElementsByClassName(k);
                                var old = document.getElementsByClassName(d);
                                var rela = document.getElementsByClassName(c);

                                // console.log(rela);



                                // console.log(test);
                                $(test).val(name);

                                // $(test).attr('data-id',id);

                                $(old).val(phone);

                                $(hest).val(phone);

                                $(rela).val(relation);
                            }




                        } else {
                            alert('查看失败');
                        }
                    },
                    //请求失败
                    error: function() {
                        alert('请求失败');
                    }
                });


            }
        )

        function sub_qinshu() {

            var studentid = stud;

            var schoolid = $('body').find('.daibanzhuren').attr('data-school');




            var arr1 = new Array();
            arr1[0] = $("input[name='qinshuxingming1']").val();
            arr1[1] = $("input[name='qinshuhaoma1']").val();
            arr1[2] = $("input[name='qinshuguanxi1']").val();
            arr1[3] = $("input[name='oldhaoma1']").val();



            var arr2 = new Array();
            arr2[0] = $("input[name='qinshuxingming2']").val();
            arr2[1] = $("input[name='qinshuhaoma2']").val()
            arr2[2] = $("input[name='qinshuguanxi2']").val();
            arr2[3] = $("input[name='oldhaoma2']").val();



            var arr3 = new Array();
            arr3[0] = $("input[name='qinshuxingming3']").val();
            arr3[1] = $("input[name='qinshuhaoma3']").val();
            arr3[2] = $("input[name='qinshuguanxi3']").val();
            arr3[3] = $("input[name='oldhaoma3']").val();



            $.ajax({
                type: "post",
                async: false,
                url: "<?php echo U('Admin/Student/qinshu');?>",
                data: {
                    'qinshu1[]': arr1,
                    'qinshu2[]': arr2,
                    'qinshu3[]': arr3,
                    'studentid': studentid,
                    'schoolid': schoolid
                },
                success: function(msg) {
                    history.go(0);
                }
            });
        }















        //模态








        $(".daibanzhuren").click(
            function() {
                w = $(this).children().val()
                $(".chuanzhi").val(w)
                $(".uisid").val(w);

                var ICname = $(this).prev().prev().prev().text()
                console.log(ICname);
                s = $(this).attr('data-school');
                $('.school').val(s);
                $('.ICname').text(ICname);

            }
        )



        $(".sic").click(
            function() {

                var cardno = $(this).prev().text();
                console.log(cardno);


                var showcard = $('body').find(".shuzi")


                $.ajax({
                    type: "get",
                    async: false,
                    dataType: 'json',
                    url: "<?php echo U('Admin/Student/delcard');?>",
                    data: {
                        cardno: cardno,


                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status) {

                            $(".dbzr").empty();
                            $('.sic').css('display', 'none');
                            $('.xiugai').text('新增卡号');
                            // console.log('点赞成功')
                            for (var i = 0; i < showcard.length; i++) {
                                if (showcard.eq(i).text() == cardno) {
                                    showcard.eq(i).text("设置");
                                }
                            }

                        } else {
                            alert('删除失败');
                        }
                    },
                    //请求失败
                    error: function() {
                        alert('请求失败');
                    }
                });









            }
        )






        $(".daibanzhuren").click(
            function(ID) {
                $(".daitan").show()
                l = $(".shuzi", this).text();

                $(".dbzr").text(l)
                console.log(l);
                $(".stu_old_card").val(l);
            }
        )


        $(".daibanzhuren").click(function() {
            $(".jiaz").hide();
            $(".si").show();
            $(".xuesheng").show();
            $("#huoqu").attr("class", "");
            $("#aniu").attr("class", "active");
            $(".ci").css("display", "none")
            var shuzhi = $(".shuzi", this).text();




            if (shuzhi == "设置") {
                $('.sic').css('display', 'none');
                $(".xiugai").text("新增卡号：");
            } else {
                $('.sic').css('display', 'block');
                $(".xiugai").text("修改卡号：");
            }
        })


        $("#myModal").hide();
        $("#myModal1").hide();
        $("#myModal4").hide();
        var class_card = [];

        $(".ci").click(function() {
            var schoolid = $('body').find('.school').val();
            // console.log(schoolid);


            var userid = $(".uisid").val();

            $(".jiaz input[name='card']").each(function() {

                var k = $(this).next().val();

                var f = $(this).val();


                // console.log(f);

                // console.log(k);

                // var c = $(this).attr('data-id');

                // console.log(f);  
                if (k == f) {
                    var f = '';

                }

                //console.log(f);
                //console.log(arr);

                //console.log(f);
                if (f != "") {
                    var lengthzhi = f.length;
                    if (lengthzhi < 10) {
                        var ui = 10 - lengthzhi;
                        var us = "";
                        for (var i = 0; i < ui; i++) {
                            var j = "0";
                            us += j;
                        }
                        var f = us + f;
                    }
                    class_card.push({
                        cardNo: f,
                        old_card: k,
                    })

                }

            })
            $.ajax({
                type: "get",
                async: false,
                url: "<?php echo U('Admin/Student/jiaadd');?>",
                data: {
                    class_card: class_card,
                    userid: userid,
                    schoolid: schoolid,

                },
                success: function(msg) {
                    history.go(0);
                }
            });
        })
        $("#huoqu").click(function() {
            $(".si").hide();
            $(".jiaz").show();
            $(".xuesheng").hide();
            $("#huoqu").attr("class", "active");
            $("#aniu").attr("class", "");
            $(".ci").css("display", "block")
        })

        $(".jiazhangkahao").click(function() {
            $(".si").hide();
            $(".jiaz").show();
            // $(".xuesheng").hide();

            var userid = $(this).attr("data-id");
            $(".uisid").val(userid);
            $("#huoqu").attr("class", "active");
            $("#aniu").attr("class", "");
            $(".ci").css("display", "block")
        })


        $("#aniu").click(function() {
            $(".jiaz").hide();
            $(".si").show();
            $(".xuesheng").show();
            $("#huoqu").attr("class", "");
            $("#aniu").attr("class", "active");
            $(".ci").css("display", "none")
        })
        $(".daibanzhuren").click(function() {
            $(".jiaz").hide();
            $(".si").show();
            $(".xuesheng").show();
            $("#huoqu").attr("class", "");
            $("#aniu").attr("class", "active");
            $(".ci").css("display", "none")
            var shuzhi = $(".shuzi", this).text();




            if (shuzhi == "设置") {
                $('.sic').css('display', 'none');
                $(".xiugai").text("新增卡号：");
            } else {
                $('.sic').css('display', 'block');
                $(".xiugai").text("修改卡号：");
            }
        })






        $("#huoqu").click(function() {
            var userid = $(".uisid").val();

            // console.log(userid);
            $.ajax({
                type: "post",
                url: "<?php echo U('Admin/Student/chaxuan');?>",
                async: true,
                dataType: 'json',
                data: {
                    userid: userid
                },
                success: function(res) {
                    // console.log(userid);
                    res = eval(res.data);


                    // console.log(res);
                    for (var i = 0; i < res.length; i++) {

                        var cardno = res[i].cardno; //id卡号；
                        var id = res[i].id;

                        var j = "a" + i;

                        var k = "a_" + i;

                        var test = document.getElementsByClassName(j);
                        var hest = document.getElementsByClassName(k);



                        // console.log(test);
                        $(test).val(cardno);

                        $(test).attr('data-id', id);

                        $(hest).val(cardno);
                    }
                },
                error: function() {
                    alert('系统错误,请稍后重试');
                }
            });
        })













        $(".jiazhangkahao").click(function() {
            var userid = $(this).attr("data-id");

            console.log(userid);
            $.ajax({
                type: "post",
                url: "<?php echo U('Admin/Student/chaxuan');?>",
                async: true,
                dataType: 'json',
                data: {
                    userid: userid
                },
                success: function(res) {
                    // console.log(userid);
                    res = eval(res.data);


                    // console.log(res);
                    for (var i = 0; i < res.length; i++) {

                        var cardno = res[i].cardno; //id卡号；
                        var id = res[i].id;

                        var j = "a" + i;

                        var k = "a_" + i;

                        var test = document.getElementsByClassName(j);
                        var hest = document.getElementsByClassName(k);



                        // console.log(test);
                        $(test).val(cardno);

                        $(test).attr('data-id', id);

                        $(hest).val(cardno);
                    }
                },
                error: function() {
                    alert('系统错误,请稍后重试');
                }
            });
        })
    </script>
</body>

</html>