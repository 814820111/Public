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
    select{
    	width: auto;
    	color: black;
    }

</style>
<body>
	<div class="wrap J_check_wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('AdminRole/index');?>">角色管理</a></li>
			<li><a href="<?php echo U('AdminRole/roleadd');?>" >添加角色</a></li>
		</ul>
		<form name="myform" action="<?php echo U('AdminRole/index');?>" method="get">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
						<span>所属大类：</span>
						<select  class="province"  name="categoryid" >
							<option value="">请选择</option>

								<?php if($role == 1 || empty($role)): ?><option value="1" <?php if($categoryid==1){ echo 'selected';} ?>>内部管理员</option>
									<option value="2" <?php if($categoryid==2){ echo 'selected';} ?>>代理商</option>
									
								<?php else: ?>
									<option value="2" <?php if($categoryid==2){ echo 'selected';} ?>>代理商</option><?php endif; ?>

						</select>
						所属省份：
						      <select  class="province"  name="province" id="province" >
					              <option value="">省级选择</option>
					              <?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$pp==$vo['term_id']?"selected":""; ?> 
					                <option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
					            </select>
					    负责地市:
					       <input  class="citys" type="hidden" value="<?php echo ($citys); ?>">
					          <select id="citys" name="city">
					          	 <option>请选择市级</option>
					          </select>   
						<select  class="role_name"  name="role_name" style="width: 100px">
							<option value="">查询类型</option>
							<option value="role_name" <?php if($rolename==role_name){ echo 'selected';} ?>>角色账号</option>`
							<!--<option value="phone">电话</option>-->
						</select>
						<input type="text" name="keyname" style="width: 200px;" value="<?php echo ($name); ?>" placeholder="请输入关键字...">
						<!--手机号码：-->
						<!--<input type="text" name="phoneNumber" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入手机号...">-->
						<input type="submit" class="btn btn-primary" value="搜索" style="margin-left: 10px; margin-bottom: 10px;" />
						 <a class="btn btn-danger" href="<?php echo U('AdminRole/index');?>" style="margin-bottom: 10px;">清空</a>
					</span>
				</div>
			</div>
		</form>
		<form name="myform" action="<?php echo U('AdminRole/listorders');?>" method="post">

			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th width="30">ID</th>
						<th align="left">角色名称</th>
						<th align="left">角色描述</th>
						<th width="40" align="left">状态</th>
						<th width="120">管理操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($roles)): foreach($roles as $key=>$vo): ?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php echo ($vo["remark"]); ?></td>
						<td>
							<?php if($vo['status'] == 1): ?><font color="red">√</font>
							<?php else: ?> 
								<font color="red">╳</font><?php endif; ?>
						</td>
						<td>
							<?php if($vo['id'] == 1): ?><font color="#cccccc">权限设置</font> | <!-- <a href="javascript:open_iframe_dialog('<?php echo U('rbac/member',array('id'=>$vo['id']));?>','成员管理');">成员管理</a> | -->
								<font color="#cccccc">修改</font> | <font color="#cccccc">删除</font>
							<?php else: ?>
								<a href="<?php echo U('AdminRole/authorize',array('id'=>$vo['id']));?>">权限设置</a>|
								<?php if($role == 1): ?><a href="<?php echo U('AdminRole/roleschool',array('id'=>$vo['id'],'categoryid'=>$vo['categoryid'],'isonelevelrole'=>$vo['isonelevelrole']));?>">查看关联学校</a>|
									<?php else: ?>
									<a href="<?php echo U('AdminRole/roleschool',array('id'=>$vo['id'],'categoryid'=>$vo['categoryid'],'isonelevelrole'=>$vo['isonelevelrole']));?>">设置学校</a>|<?php endif; ?>

								<a href="<?php echo U('AdminRole/roleedit',array('id'=>$vo['id']));?>">修改</a>|
								<a class="J_ajax_del" href="<?php echo U('AdminRole/roledelete',array('id'=>$vo['id']));?>">删除</a><?php endif; ?>
						</td>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
		</form>
	</div>
	<div class="pagination"><?php echo ($Page); ?></div>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
</body>
</html>

<script type="text/javascript">
	
$("#province").change(function(){


                   $.getJSON("/weixiaotong2016/index.php?g=Admin&m=Share&a=role_type&Province="+$("#province").val(),{},function(data){
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

if($("#province").val())
{  

	var city = $("body").find(".citys").val();

	  $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                    $("#citys").empty()
                   
                      if(data.status=="success"){
                      
                          $("#citys").append("<option value=0>"+"请选择市级"+"</option>");
                          for(var key in data.data){
                          	  if(city == data.data[key]["term_id"])
                          	  {
                              $("#citys").append("<option value="+data.data[key]["term_id"]+" selected >"+data.data[key]["name"]+"</option>");
                              }else{
                              	$("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                              }
                          }
                      }
                      if(data.status=="error"){
                          $("#citys").append("<option value='0'>没有市级</option>");
                      }
                  });
}



</script>