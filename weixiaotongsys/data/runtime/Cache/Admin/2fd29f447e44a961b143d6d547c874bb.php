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
	}
	
	.chzn-container-single .chzn-single {
		position: relative;
		top: 12px;
		height: 29px;
	}
	
	.mohu {
		width: 100px;
		position: relative;
		bottom: 30px;
		left: 30px;
		background-color: whitesmoke;
	}
</style>

<body class="J_scroll_fixed">
	<div class="wrap J_check_wrap">
		<ul class="nav nav-tabs">
			<li >
				<a href="<?php echo U('Student/index',get_condition_cache($only_code));?>">学生信息管理</a>
			</li>

			<li class="active">
				<a href="<?php echo U('Student /excel_list');?>" target="_self">查看导入数据</a>
			</li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('excel_list');?>">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
				         
				          <label class="stu-select-label">日期:</label>
                            <input type="date" name="begin" class="stu-select-inputlist" style="width: 206px;height: 30px;padding: 4px 6px;" id="time" >- <input type="date" name="end" class="stu-select-inputlist" style="width: 206px;height: 30px;padding: 4px 6px;" id="time" >
                            
						<!-- 时间：
						<input type="text" name="start_time" class="J_date" value="<?php echo ((isset($formget["start_time"]) && ($formget["start_time"] !== ""))?($formget["start_time"]):''); ?>" style="width: 80px;" autocomplete="off">- -->
						<!-- <input type="text" class="J_date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp; -->
						<span style="position: relative;left: 40px;">
                        <a class="btn btn-danger" href="<?php echo U('Student/index');?>">清空</a>
						<input type="submit" class="btn btn-primary" value="搜索" />
					
						</span> 
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
						<th align='center'><input    type="checkbox" name="" id="checkall"  onclick="checkfk()" size="10">全选</th>
						<th>文件名称</th>
						<th>上传时间</th>
						<th>导入状态</th>
						<th>查看信息</th>
						<th align='center'>操作</th>
					</tr>
				</thead>
				<?php if(is_array($excel)): foreach($excel as $key=>$vo): ?><tr>
						<td><input type="checkbox" class="J_check" id='sel_all' name="ids[]" value="<?php echo ($vo["id"]); ?>" title="id:<?php echo ($vo["id"]); ?>"></td>
						<td><?php echo ($vo["filename"]); ?></td>
		
						<td><?php echo (date("Y-m-d H:i:s",$vo["time"])); ?></td>
						<!--<td><?php echo ($vo["classname"]); ?></td>-->
						<td>
						 <?php if($vo['status'] == 0): ?>已全部导入
                          <?php elseif($vo['status'] == 1): ?>
                          待处理<?php endif; ?>
						</td>
						<td style="width: 120px; " >
						<div style="width: 120px; 
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;" title="<?php echo ($vo["pro"]); ?>"><?php echo ($vo["pro"]); ?></div>
						</td>

						<td>
							
							<a href="<?php echo U('Student/student_delete',array('term'=>empty($term['term_id'])?'':$term['term_id'],'id'=>$vo['id']));?>" class="J_ajax_del">删除</a>
						</td>
					</tr><?php endforeach; endif; ?>
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

		</form>
	</div>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
	<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>
	<script>
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
		$(".select_3").click(function() {
			$(".jiu").hide();
			$.ajax({
				type: "post",
				url: '/weixiaotong2016/index.php/?g=Admin&m=Student&a=chadi',
				async: true,
				data: {
					type: 3
				},
				dataType: 'json',
				success: function(res) {
					var html = "";
					res = eval(res.data);
					for(var i = 0; i < res.length; i++) {
						var name = res[i].name; //地区的名字；
						var term_id = res[i].term_id; //地区的ID
						html += '<option class="jiu"value="' + term_id + '">' + name + ' </option> '
					}
					$(".select_3").append(html);
				},
				error: function() {
					console.log('系统错误,请稍后重试');
				}
			});
		})

		$("#viewOLanguage").chosen();
		$("#viewOLanguage").trigger("liszt:updated");
		//学校的点击事件

		$(".select_3").change(function() {
			var type = $(".select_3  option:selected").val();
			$.ajax({
				type: "post",
				url: '/weixiaotong2016/index.php/?g=Admin&m=SchoolManage&a=lookup',
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
		$(".btn-primary").click(function() {

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
		
		$(".daochu").click(function(){
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
			if(isSuccess==1){
               location.href="<?php echo U('Student/Lexcel');?>?schoold="+typeschool+"&tiaojian="+xuan+"&shuzhi="+zhi+"" ;
			}
			
		})
	</script>
</body>

</html>