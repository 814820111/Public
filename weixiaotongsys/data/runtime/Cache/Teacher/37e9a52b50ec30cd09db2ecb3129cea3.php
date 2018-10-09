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
		<title>信息1</title>
		<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
		<link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
		<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>


		<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
		<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
		<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
		<script src="/weixiaotong2016/statics/js/wind.js"></script>
		<style type="text/css">


			.col-auto {
				overflow: auto;
				_zoom: 1;
				_float: left;
			}
			
			.col-right {
				float: right;
				width: 30%;
				overflow: hidden;
				margin-left: 6px;
			}
			
			.table th,
			.table td {
				vertical-align: middle;
			}
			
			.picList li {
				margin-bottom: 5px;
			}
			
			.touchlei {
				background-color: #eeeeee;
			}
			
			tr .pai,
			tr .pai2 {
				text-align: center;
				color: black;
			}
			
			tr .pai {
				background-color: #e2e2e2;

			}
			
			tr .pai2 {}
			
			.clearfix {
				clear: both;
			}
			
			.name {
				margin-right: 10px;
			}
			
			.qinchu {
				border-radius: 25px;
				background-color: whitesmoke;
				border: ridge;
			}
			select{
				color: black;
			}

			span{
				color: black;
			}
			p{
				color: black;
			}
			    .modal.fade.in {
    	top: 2%;
          }
          i{
          	font-style: normal;
          	color: black;
          }

		</style>

	</head>

	<body>

		<!-- 模态框（Modal） -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background-color: white;height: 10px;">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h5 class="modal-title tites" id="myModalLabel" style=" color:#61c881; font-weight:bold;">设置班主任</h5>
					</div>
					<div class="modal-body" style=    "width: 528px;">
						<!--带班主任弹窗start-->

						<div class="banzhur">
							<div>
								<div style=" margin-top:15px; margin-bottom:15px;">
									<div style=" float:left; "><span style=" font-weight:bold;">年级：</span ><i class="ni">大班</i></div>
                        <div style=" float:left; margin-left:100px; "><span style=" font-weight:bold;">班级：</span><i class="ba">大一班</i></div>
									<div class="clearfix"></div>
								</div>
								<div><span style=" font-weight:bold;">班主任：</span>
									<i class="bzr"></i></div>
						
							</div>
							<form>
								<div class="hides">

									<div style="margin-top: 3px;">
										<span style=" font-weight:bold;">教师姓名：</span>
										<input class="chazhi" type="text" placeholder="-请输入内容-" style="    vertical-align: 1px; height: 15px;"> 
										<a  class="show_teacher" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px; cursor: pointer;">查询</a>

									</div>

									<!--弹出框中的老师列表start-->
									<div style=" border:1px solid #bbbbbb;  overflow-y:scroll; padding:10px; height: 100px">
										<?php if(is_array($teachers)): foreach($teachers as $key=>$to): ?><div style=" float:left; margin-right:20px; margin-bottom:5px;cursor: pointer; width: 100px;" class="xuanbox">
												<input type="radio" value="<?php echo ($to["id"]); ?>" name="teacher_main" class="xuan" style=" margin-right:5px; margin-top:0px;">
												<span class="mingzi"><?php echo ($to["name"]); ?></span>

											</div><?php endforeach; endif; ?>
										<div class="clearfix"></div>
									</div>
									<!--弹出框中的老师列表end-->
									<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">

									</div>
								</div>
						</div>

						<!--班级老师弹窗start-->
						<div class="ruishi">
							<div class="jiaoshi"></div>
							<div style=" margin-top:15px; margin-bottom:15px;">
								<div style=" float:left; "><span style=" font-weight:bold;">年级：</span><i class="ni">大班</i></div>
								<div style=" float:left; margin-left:100px; "><span style=" font-weight:bold;">班级：</span><i class="ba">大一班</i></div>
								<div class="clearfix"></div>
							</div>
							<div><span style=" font-weight:bold;">带班教师：</span>
								<i class="dbzr"></i>

							</div>
							
							<form>
								<div>
									<span style=" font-weight:bold;">教师姓名：</span>
									<input type="text" class="teacher_class_name" placeholder="-请输入内容-" style="  margin-top:10px; border:1px solid #bbbbbb;">
									<input type="button"   class="show_class_teacher" value="查询" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:3px 15px 3px 15px; margin-left:10px;">
								</div>
								<div style=" border:1px solid #bbbbbb;  overflow-y:scroll; padding:10px;  height: 100px">
									<?php if(is_array($teachers)): foreach($teachers as $key=>$to): ?><div style=" float:left; margin-right:20px; margin-bottom:5px;cursor: pointer;" class="xuanboxs">
											<link rel="stylesheet" href="../../../../statics/js/js/ueditor/dialogs/video/video.css" />
											<div style="width: 100px;height: 5px;position: relative;top: 25px;"></div>
											<input type="checkbox" value="<?php echo ($to["id"]); ?>" name="teacher_idarr"   class="xuan2" style=" margin-right:5px; margin-top:0px;">
											<span class="shuzi"><?php echo ($to["name"]); ?></span>

										</div><?php endforeach; endif; ?>
									<div class="clearfix"></div>
								</div>
								<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">

								</div>

						</div>

					</div>
					<div class="modal-footer">
						<input class="btn btn-default laobai" data-dismiss="modal" type="submit" value="保存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" onclick='sub_department()'>
						<input class="btn btn-default laodan" data-dismiss="modal" type="submit" value="保存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" onclick='sub_qrcj()'>
						<button type="button" class="btn btn-default" data-dismiss="modal" style="height: 30px;">关闭</button>	
					</div>
					</form>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal -->
		</div>

    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										  <div class="modal-dialog">
										    <div class="modal-content">
										      <div class="modal-header" style="background: white">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;">编辑班级名称</h5>
										        <hr>
										      </div>
										     
										      <div class="modal-body2">
					                           
    
										         <p class="text-center" style="margin-top: -26px;">
										        <input type="hidden" class="class_id" ><br>
                                                 <span style="margin-left: 27px
                                                 ;">年级段:</span> &nbsp;<select class="teacher_mname"  id="operationGrade"   name="search_class" style="" disabled="disabled">
		                                               <option value='0'>请选择</option>
		                                             <?php if(is_array($grade)): foreach($grade as $key=>$vc): ?><!--   <?php $class_info=$classinfo==$vo['id']?"selected":""; ?> -->
		                                       <OPTION value="<?php echo ($vc["gradeid"]); ?>"><?php echo ($vc["name"]); ?></OPTION><?php endforeach; endif; ?>
		                                         </select> &nbsp;&nbsp;<br>
										           班级名称: &nbsp;<input type="text" class="class_name" name="rel" style="width: 204px; height: 16px; color: black;"><br>
										           班级类型: &nbsp;<select id="operationGrade2">
										           	            <option value="1">正规班</option>
										           	            <option value="2">兴趣班</option>
										                      
										                       </select>
										          
										      </div>

                                           

										      <div class="modal-footer">
										        <button type="button" class="btn btn-default" data-dismiss="modal" style="background: white; color:black; font-weight:bold;">关闭</button>
										        <button class="btn btn-info edit_tj" style="font-weight:bold;" >提交</button>
										      </div>
										   
										    </div>

										    </form>
										  </div>
										</div>
   
		<div class="">
			<ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
				<li class="active">
					<a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">班级管理</a>
				</li>
				<li>
					<a href="<?php echo U('add');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">新增班级</a>
				</li>
			</ul>

			<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
				<div class="tab-pane fade in active" id="home">
					<br/>
					<form class="form-horizontal J_ajaxForm" action="<?php echo u('index');?>" method="post" style="margin: 0px 0px 5px ">
						<div class="search_type cc mb10">
							<div class="mb10">
								<span class="mr20">
                      年级： 
                      <select class="select_2" name="search_grade" style="width: auto;">
                        <option value='0'>--全部--</option>
                        <?php if(is_array($grade)): foreach($grade as $key=>$vo): if($vo["gradeid"] == $search_grade): ?><OPTION value="<?php echo ($vo["gradeid"]); ?>" selected="selected"><?php echo ($vo["name"]); ?></OPTION><?php endif; ?>
                         <?php if($vo["id"] != $search_grade): ?><OPTION value="<?php echo ($vo["gradeid"]); ?>" ><?php echo ($vo["name"]); ?></OPTION><?php endif; endforeach; endif; ?>
                      </select> &nbsp;&nbsp;
                      班级类型： 
                      <select class="select_2" name="search_type" style="width: auto;">
                        <option value=''>--请选择--</option>
                        
                        <option value='1' <?php if($search_type==1) echo("selected");?>>正规班</option>
                        <option value='2' <?php if($search_type==2) echo("selected");?>>兴趣班</option>
                      </select> &nbsp;&nbsp;
                      班级名称： 
                      <input type="text" value="<?php echo ($search_class); ?>" class="select_2" name="search_class" placeholder="-请输入班级名称-" style="width: 150px; height: 16px; border-width: 1px; color: black;">
                      <input type="submit" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;" value="搜索" />
                      
                  </span>
							</div>
						</div>
					</form>
					<form class="J_ajaxForm" action="edit_post" method="get">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-list">
								<thead>
									<tr style="background-color:#CCC;">
										<th class="pai" style=" border-left: none;border-width: 0.5px;">编号</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">年级</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">班级</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">班级类型</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">是否毕业</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">学生人数</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">教师人数</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">班主任</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">带班老师</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;border-right: none">操作</th>
									</tr>
								</thead>
								<?php if(is_array($class_list)): foreach($class_list as $key=>$vo): ?><input type='hidden' id='main_id' name='main_id' value='<?php echo ($vo["id"]); ?>' />
									<?php $type=array("1"=>"正规班","2"=>"兴趣班"); $status=array("1"=>"是","0"=>"否"); $sign=empty($vo['captain'])?'-未设置-':$vo['captain']; $tea=empty($vo['teacher_name'])?'-未设置-':$vo['teacher_name']; ?>
									<tr>
										<td class="pai2" style=""><?php echo ($vo["id"]); ?></td>
										<td class="pai2" style=""><?php echo ($vo["grade"]); ?></td>
										<td class="pai2" style=""><?php echo ($vo["classname"]); ?></td>
										<td class="pai2" style=""><?php echo ($type[$vo['type']]); ?></td>
										<td class="pai2" style=""><?php echo ($status[$vo['status']]); ?></td>
										<td class="pai2" style=""><?php echo ($vo["stu_count"]); ?></td>
										<td class="pai2" style=""><?php echo ($vo["tea_count"]); ?></td>
										<td class="pai2 banzhuren" style=" color:#00c1dd; cursor:pointer;">
											<input type="hidden" id="class_id" value="<?php echo ($vo["id"]); ?>">
											<input type="hidden" id="teacher_main" value="<?php echo ($vo["teacher_main"]); ?>">
											<!-- 按钮触发模态框 -->
											<button class="btn btn-primary btn-lg boi" data-toggle="modal" data-target="#myModal" style="background-color: transparent;color: #00c1dd;font-size: 14px;"> <?php echo ($sign); ?>
                              	            <input type="hidden"  value="<?php echo ($vo["grade"]); ?>" class="nianji"/>
                              	            <input type="hidden"value="<?php echo ($vo["classname"]); ?>" class="banji" />
                                             </button>

										</td>
										<td class="pai2 daibanzhuren" style=" color:#00c1dd; cursor:pointer; " target="_blank" title="<?php echo ($tea); ?>">
					                       <input type="hidden" id="class_idea" value="<?php echo ($vo["id"]); ?>">

											<button class="btn btn-primary btn-lg dai" data-toggle="modal" data-target="#myModal" style="background-color: transparent;color: #00c1dd;  width: 150px;
												overflow: hidden;
												white-space: nowrap;
												text-overflow: ellipsis; font-size: 14px;"><?php echo ($tea); ?>
												<input type="hidden" value="<?php echo ($vo["id"]); ?>" class="ciid" />
                                                <input type="hidden"  value="<?php echo ($vo["grade"]); ?>" class="nianjis"/>
                                                <input type="hidden"value="<?php echo ($vo["classname"]); ?>" class="banjis" />
                                                <input type="hidden"value="<?php echo ($vo["teacher_name"]); ?>" class="banjs" />
                                                <input type="hidden"value="<?php echo ($vo["teacher_id"]); ?>" class="banid" />
                                           </button>
                                     
										</td>
										
                                       

                                   






										<td class="pai2" style="">
											<a href="<?php echo U('delete',array('id'=>$vo['id']));?>" class="J_ajax_del" style=" color:#00c1dd;">
												<?php if($vo['stu_count'] != 0): elseif($vo['stu_count'] == 0): ?> 删除<?php endif; ?>
											</a>
											<a   class="edit"  data-cd="<?php echo ($vo["gradeid"]); ?>" data-toggle="modal" data-id="<?php echo ($vo["id"]); ?>"  data-class="<?php echo ($vo["classname"]); ?>"  data-target="#myModal3" style=" color:#00c1dd; cursor: pointer;">修改</a>
										</td>
									</tr><?php endforeach; endif; ?>
							</table>

							<div class="pagination"><?php echo ($Page); ?></div>
							<div style="height: 50px;"></div>
						</div>
					</form>
				</div>

			</div>
			<div class="tab-pane fade" id="ios">
			</div>
			<!--班级ID赋值的输入框-->
			<input type="hidden" class="classid" />
		</div>
		<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
		<script src="/weixiaotong2016/statics/js/common.js"></script>

		<script>

// $(document).ready(function()         
// {

// var fenbian = screen.width+'*'+screen.height;
// alert(fenbian);

// })
			
  

         $('.edit').click(function(){
         	var classname = $(this).attr("data-class");
         	var gradeid = $(this).attr("data-cd")
         	console.log(gradeid);
         	var cid =   $('#operationGrade option:selected').val();
         	console.log(cid);
         	console.log(classname);
         	$('.class_name').val(classname);
           var classid = $(this).attr("data-id");
           $(".class_id").val(classid)
              var obj = $(" #operationGrade").get(0);
               for(var i = 0; i < obj.options.length; i++){
                   var tmp = obj.options[i].value;
                   console.log(tmp);
                if(tmp == gradeid){
                    obj.options[i].selected = 'selected';
                    break;
                }
            }

          
         });




       $('.edit_tj').click(function(){
	               var classid = $('.class_id').val();
	               console.log(classid);

	             var cid =   $('#operationGrade option:selected').val();
	             console.log(cid);
	             var tid =   $('#operationGrade2 option:selected').val();
	             console.log(tid);
	              // console.log(classid);
	               //var teacher = $('.teacher_mname').val();
	               var rel = $('.class_name').val();
	               
	               console.log(rel);
                   
                   if(rel == '')
                   {
                   	layer.msg('年段名字不能为空', {
                                icon: 2
                                ,shade: 0.01,
                            });
                   	return false;
                   }

                   		editAjax(classid,rel,cid,tid);
	             
             });

   
               //编辑班级函数
              function editAjax(classid,rel,cid,tid)
              {
		        $.ajax({
		            type:'post',
		            url: "<?php echo U('Teacher/ClassManage/edit_post');?>",
		            dataType:'json',
		            async: false,
		            data: {
						'classid': classid,
						'rel':rel,
						'cid':cid,
						'tid':tid
					},
		            success:function(data){
		                 console.log(data);
		                if(data.status){
		                  alert('修改成功')
		                }else{
		                    alert('修改失败');
		                }
		            },
		            //请求失败
		            error:function(){
		               alert('请求失败')
		            }
		        })
              }







      // function myFunction(){

$(".show_teacher").click(function() {
    var names = $(".chazhi").val();

    if(names != "") {
        $.ajax({
            type: "get",
            url: '/weixiaotong2016/index.php/?g=Teacher&m=ClassManage&a=teacher_chasu',
            async: true,
            data: {
                names: names
            },
            dataType: 'json',
            success: function(res) {

                var html = "";
                res = eval(res.code);
                for(var i = 0; i < res.length; i++) {
                    var id = res[i].id;
                    html += id + ",";
                }
                $(".xuanbox input").each(function() {
                    var fuxuan = $(this).val() + ","
                    var pan = html.indexOf(fuxuan)
                    if(pan < 0) {
                        $(this).parent().hide();
                    }
                })
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }else{
        $(".xuanbox").show();
    }
})

$(".show_class_teacher").click(function() {
    var names = $(".teacher_class_name").val();

    if(names != "") {
        $.ajax({
            type: "get",
            url: '/weixiaotong2016/index.php/?g=Teacher&m=ClassManage&a=teacher_chasu',
            async: true,
            data: {
                names: names
            },
            dataType: 'json',
            success: function(res) {
                console.log(res);
                var html = "";
                res = eval(res.code);
                for(var i = 0; i < res.length; i++) {
                    var id = res[i].id;
                    html += id + ",";
                }
                $(".xuanboxs input").each(function() {
                    var fuxuan = $(this).val() + ","
                    var pan = html.indexOf(fuxuan)
                    if(pan < 0) {
                        $(this).parent().hide();
                    }
                })
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }else{
        $(".xuanbox").show();
    }
})

  // }
		 //    $(".xuanboxs .xuan2").click(
			// 	function() {
			// 		happy2 = $(this).val()
			// 		// alert(happy2);
			// 		var fx  = $(this).is(':checked');
			// 		alert(fx);
			// 		if(!fx){
   //                    $(this).prop("checked", true);
                
			// 		}else{
			// 			alert('啊啊');

			// 		}
			// 	}
			// )    
	  $(document).ready(function() {  		

		   $(".xuan2").bind('click', function(event) {  

		   	       var fx = $(this).prop('checked');
                   // alert(fx);
                   var shuzhi = $(this).next().text()+","
                   // alert(shuzhi);
                   var nameis = $(".dbzr").text();
                   // alert(shuzhi);
                     // alert('里面的a点击，但是不想触发外面那个div的事件。');  
                    event.stopPropagation();  

                    if(fx==true)
                    {  

                    	$(this).prop("checked",true);
                    	$(".dbzr").append(shuzhi);
                    }else{
                    	$(".dbzr").append(shuzhi);
                    	var xiazhi = nameis.replace(shuzhi, "");
					    $(".dbzr").text(xiazhi);
                    }
                });  
       

    
			$(".xuanboxs").click(function() {

				var checkboxdanxuan = $("input[type='checkbox']", this).is(':checked');
		
				var shuzhi = $(".shuzi", this).text() + ",";
				// alert(shuzhi);

				var nameis = $(".dbzr").text();
				// alert(nameis);

				if(checkboxdanxuan == false) {

					$("input[type='checkbox']", this).prop("checked", true);
					$(".dbzr").append(shuzhi);
				} else {

					$("input[type='checkbox']", this).prop("checked", false);
					var xiazhi = nameis.replace(shuzhi, "");
					$(".dbzr").text(xiazhi);
				}
			})
        
 });  

			$("#myModal").hide();
			$("#myModal3").hide();

			//点击按钮把班级 班名赋给模态框
			$(".boi").click(function() {
				var nianji = $(".nianji", this).val();
				var banji = $(".banji", this).val();
				$(".ba").text(banji);
				$(".ni").text(nianji);
			});
			$(".dai").click(function() {

				$(".xuanboxs input").each(function() {
					$(this).prop("checked", false);
				})
				//去除上次的点击留下的选中状态
				var nianjis = $(".nianjis", this).val();
				var banjis = $(".banjis", this).val();

				var class_ideas = $(".ciid", this).val();
				$(".classid").val(class_ideas);
				$(".ba").text(banjis);
				$(".ni").text(nianjis);
				var tiite = $(".banjs", this).val();
				$(".dbzr").text(tiite);

				//待班老师的id
				var tid = $(".banid", this).val();
				var strs = tid.split(","); //字符分割    
				for(var i = 0; i < strs.length - 1; i++) {
					var shuzid = strs[i];
					$(".xuanboxs input").each(function() {
						var fuxuan = $(this).val()

						if(shuzid == fuxuan) {
							$(this).prop("checked", true);
						}
					})
				}

			})

			//带班老师的jq事件
			$(".dai").click(function() {
				$(".laodan").hide();
				$(".tites").text("代课老师");
				$(".banzhur").hide();
				$(".ruishi").show();
				$(".laobai").show();

			})
			$(".boi").click(function() {
				$(".laobai").hide();
				$(".tites").text("带班老师");
				$(".ruishi").hide();
				$(".laodan").show();
				$(".banzhur").show();

			})
			//单选框事件
			$(".bantan").hide();
			$(".xuanbox").click(function() {
				$(".xuanbox input").each(function() {
					$(this).prop("checked", true);
				});
				$(".xuan", this).prop("checked", "checked");
				k = $(".mingzi", this).text()
				$(".bzr").text(k)
				happy = $(".xuan", this).val()
			})

			//点击保存换班主任
			function sub_qrcj() {
				var c_id = class_id;
				$.ajax({
					type: "post",
					async: false,
					url: "<?php echo U('Teacher/ClassManage/teacher_add');?>",
					data: {
						'class_id': c_id,
						'teachers': happy
					},
					success: function(msg) {
						window.location.reload(); //刷新当前页面.
					}
				});
			}

			$(".xuanboxs .xuan").click(
				function() {
					happy = $(this).val()
				}
			)
		</script>

		<script>
		
			//点击div 让单选框选中
			$(".banzhuren").click(
				function() {
					class_id = $(this).children("#class_id").val();
					teacher_main = $(this).children("#teacher_main").val();
					$(".bantan").show();
					$(".xuanbox input").each(function() {
						if(teacher_main == $(this).val()) {
							$(this).prop("checked", true);
						}
					});
				}
			)
			$(".banzhuren").click(
				function() {
					w = $(this).text()
					$(".bzr").text(w)
				}
			)
			$(".xuan").click(
				function() {
					k = $(this).parent().text()
					$(".bzr").text(k)
				}
			)
		</script>
		<script type="text/javascript">
			function sub_department() {
				var class_idea = $(".classid").val();
				// var obj = document.getElementsByName("teacher_idarr");
				// console.log(obj)
				check_val = [];
               $("input[name='teacher_idarr']").each(function(){

               	if($(this).is(":checked"))
               	{
               		check_val.push($(this).val());
               	}
					// titles += $(this).val()+",";
					// if(obj[k].checked)
					// 	check_val.push(obj[k].value);
				});
				// check_val = [];
				// for(k in obj) {
				// 	if(obj[k].checked)
				// 		check_val.push(obj[k].value);
				// }

				// console.log(check_val);
                
//            console.log(check_val);
//            return false;

				$.ajax({
					type: "post",
					async: false,
					url: "<?php echo U('Teacher/ClassManage/teachers_add');?>",
					data: {
						'class_id': class_idea,
						'teacher_arr': check_val,
					},
					success: function(msg) {
						history.go(0);
					}
				});
			}
		</script>
	</body>

</html>