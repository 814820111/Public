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
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
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

	table td{
		color: black;
	}		
    
    span {
    	color: black;
    }

    div{
    	color: black;
    }


</style>


<body class="J_scroll_fixed">

	<div class="wrap J_check_wrap">
		<ul class="nav nav-tabs">

			<li  class="active"><a href="<?php echo U('index');?>">绑定码绑定查询</a></li>
			<li><a href="<?php echo U('code_index');?>">手机验证码绑定查询</a></li>
			<!--<li><a href="<?php echo U('service_charge_import');?>">导入费用</a></li>-->


		</ul>

		<form class="well form-search" method="get" action="<?php echo U('index');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
					省份选择：
						<select  class="province"  name="province" id="province" style="width: auto;">
							<option value="">省级选择</option>
							<?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?>
								<option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
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
						  <input type="hidden" class="type_school" value="<?php echo ($schoolid); ?>">
						  <select data-placeholder="输入关键字。。。" name="schoolid" id="viewOLanguage" class="chzn-select"  tabindex="2" >
							<option value=""></option>
						   </select>
						<br><br>
				       <span style="width: 45%; margin-top: 13px right: 15px;">
						<!--绑定类型:-->
						<!--<select class="select_1" name="bindingtype" id="cis1" style="width: auto;">-->
								   <!--<option value="">全部</option>-->
								   <!--<option value="1" <?php if($bindingtype==1) echo("selected");?>>家长</option>-->
							<!--<option value="2" <?php if($bindingtype==2) echo("selected");?>>老师</option>-->
					   <!--</select> &nbsp;&nbsp;-->
						<select class="mohu" name="tiaojian">

						    <option value="0">查询类型</option>

							<option value="stu_name"  <?php if($tiaojian==stu_name) echo("selected");?> >学生名字</option>
							<option value="bindingkey" <?php if($tiaojian==bindingkey) echo("selected");?>>学生绑定码</option>
							<option value="phone" <?php if($tiaojian==phone) echo("selected");?>>家长手机号码</option>
							<option value="tch_phone" <?php if($tiaojian==tch_phone) echo("selected");?>>老师手机号码</option>
							<option value="tch_bindingkey" <?php if($tiaojian==tch_bindingkey) echo("selected");?>>老师绑定码</option>
						</select>
					    <input type="text" placeholder="根据条件进行模糊查询" name="shuzhi" class="zhi" value="<?php echo ($shuzhi); ?>">
						</span>
					绑定状态:
					<select class="select_1" name="status" id="cis1" style="width: auto;">
						       <option value="">全部</option>
                               <option value="1" <?php if($status==1) echo("selected");?>>成功</option>
                               <option value="2" <?php if($status==2) echo("selected");?>>失败</option>

				   </select> &nbsp;&nbsp;



						时间：
						<input type="text" name="start_time" placeholder="请选择" class="J_date" value="<?php echo ((isset($start_time) && ($start_time !== ""))?($start_time):''); ?>" style="width: 80px;" autocomplete="off">
						 <input type="text" class="J_date" placeholder="请选择" name="end_time" value="<?php echo ($end_time); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp;
						<div style="    display: inherit;">
                        <a class="btn btn-danger" href="<?php echo U('index');?>">清空</a>
                        <!--<button class="btn btn-danger" type="reset">清空</button>-->
						<!--<input type="button" class="btn btn-success daochu" value="导出" />-->

						<input type="submit" class="btn btn-primary ss" value="搜索" />

						</div>
					</span>
				</div>
			</div>

		</form>

		<form class="J_ajaxForm" action="" method="post">
			<div class="table-actions">
				<!-- 				<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Student/listorders');?>">排序</button> -->
				<!-- <button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Stuent/check',array('check'=>1));?>" data-subcheck="true">审核</button>
				<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Stuent/check',array('uncheck'=>1));?>" data-subcheck="true">取消审核</button> -->
			</div>
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th align='center'><input type='checkbox' id='checkAll' name="checkAll" style="    vertical-align: -2px;">选择</th>
						<th>学校</th>
						<th>公众号</th>
						<th>类型</th>
						<th>学生姓名</th>
						<th>学生绑定码</th>
						<th>家长姓名</th>
						<th>关系</th>
						<th>家长号码</th>
						<th>老师号码</th>
						<th>老师绑定码</th>
						<th>内容</th>
						<th>状态</th>
						<th>时间</th>
						<!--<th align='center'>操作</th>-->
					</tr>
				</thead>
				<?php if(is_array($result)): foreach($result as $key=>$vo): ?><tr>
						<td class="aaa"><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>" title="ID:"></td>
						<td><?php echo ($vo["school_name"]); ?></td>
						<td><?php echo ($vo["wx_name"]); ?></td>
						<td>
							<?php if($vo['bindingtype'] == 1): ?>家长<?php endif; ?>
							<?php if($vo['bindingtype'] == 2): ?>老师<?php endif; ?>
							</td>
						<td><?php echo ($vo["stu_name"]); ?></td>
						<td><?php echo ($vo["bindingkey"]); ?></td>
						<td><?php echo ($vo["par_name"]); ?></td>
						<td>
							<?php if($vo['relation'] == 1): ?>爸爸<?php endif; ?>
							<?php if($vo['relation'] == 2): ?>妈妈<?php endif; ?>
							<?php if($vo['relation'] == 3): ?>姑姑<?php endif; ?>
							<?php if($vo['relation'] == 4): ?>奶奶<?php endif; ?>
						</td>
						<td><?php echo ($vo["phone"]); ?></td>
						<td><?php echo ($vo["tch_phone"]); ?></td>
						<td><?php echo ($vo["tch_bindingkey"]); ?></td>
						<td><?php echo ($vo["content"]); ?></td>
						<td>
							<?php if($vo['status'] == 1): ?>成功<?php endif; ?>
							<?php if($vo['status'] == 2): ?>失败<?php endif; ?>
							</td>
						<td><?php echo ($vo["bind_datetime"]); ?></td>
						<!--<td class="auditing">-->
							<!--<?php if($vo['auditing_status'] == 1): ?>-->
								<!--待审核-->
							<!--<?php endif; ?>-->
							<!--<?php if($vo['auditing_status'] == 2): ?>-->
								<!--通过-->
							<!--<?php endif; ?>-->
							<!--<?php if($vo['auditing_status'] == 3): ?>-->
								<!--不通过-->
							<!--<?php endif; ?>-->
						<!--</td>-->
						<!--<td>-->
							<!--<?php echo (date("Y-m-d H:i:s",$vo["add_timeint"])); ?>-->
						<!--</td>-->
						<!--<td><?php echo ($vo["decription"]); ?></td>-->
						<!--<td>-->
							<!--<?php if($vo['type'] == 1): ?>-->
								<!--月份-->
							<!--<?php endif; ?>-->
							<!--<?php if($vo['type'] == 2): ?>-->
								<!--学期-->
							<!--<?php endif; ?>-->
							<!--<?php if($vo['type'] == 4): ?>-->
								<!--学年-->
							<!--<?php endif; ?>-->
						<!--</td>-->
						<!--<td><?php echo ($vo["month"]); ?></td>-->
						<!--<td>-->
							<!--<a href="<?php echo U('charge_detail',array('schoolid'=>$vo['schoolid'],'packageid'=>$vo['packageid'],'service_charge_id'=>$vo['id']));?>">查看明细</a>-->
						<!--</td>-->
					</tr><?php endforeach; endif; ?>

			</table>
			<div class="pagination"><?php echo ($Page); ?></div>

		</form>
	</div>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
	<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>
	<script>
        $(".daochu").click(function(){
            var typeschool = $(".chzn-select  option:selected").val();
            if(typeschool == "") {
                alert("请选择学校");
                return;
            }

            location.href="<?php echo U('Lexcel');?>?schoolid="+typeschool ;
		});

 	   $(function() {
            $("#checkAll").click(function() {
                $('input[class="J_check"]').prop("checked", $(this).prop("checked"));
            });
            var $J_check = $("input[class='J_check']");
            $J_check.click(function(){
                $("#checkAll").prop("checked",$J_check.length == $("input[class='J_check']:checked").length ? true : false);
            });
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
                        $("#citys").append("<option value=>"+"请选择市级"+"</option>");
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


                $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                    $("#citys").empty()

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
                // $("#student").empty();

                $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
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
                    $(".chzn-select").html("")
                    var html = "";
                    html += '<option  value="">请选择学校</option> '
                    res = eval(res.data);
                    for(var i = 0; i < res.length; i++) {
                        var school_name = res[i].school_name; //学校的名字
                        var schoolid = res[i].schoolid; //学校的ID
                        html += '<option class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
                    }
                    $(".chzn-select").html(html)
                    $("#viewOLanguage").chosen();
                    $("#viewOLanguage").trigger("liszt:updated");
                },
                error: function() {
                    console.log('系统错误,请稍后重试');
                }
            });
        })
	
		$(function() {
			$("[data-toggle='tooltip']").tooltip();
		});

		function refersh_window() {
			var refersh_time = getCookie('refersh_time');
			if(refersh_time == 1) {
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
							if($(this).attr('checked')) {
								str = 1;
								id += tag + $(this).val();
								tag = ',';
							}
						});
						if(str == 0) {
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


		$("#viewOLanguage").chosen();
		$("#viewOLanguage").trigger("liszt:updated");
		//学校的点击事件


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
        })
		$(".ss").click(function() {

			var xuan = $(".mohu option:selected").val();
			var zhi = $(".zhi").val();
			var type = $(".select_3  option:selected").val();
			var typeschool = $(".chzn-select  option:selected").val();
			var isSuccess = 1;
			if(zhi == "") {
				if(xuan != 0) {
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
				if(typeschool == "") {
					var isSuccess = 0;
					alert("请选择学校");
				}
			}
			if(isSuccess == 0) {
				return false;
			}
		})


    $('.gb').click(function(){
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

    $('.close').click(function(){

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


	</script>
</body>

</html>