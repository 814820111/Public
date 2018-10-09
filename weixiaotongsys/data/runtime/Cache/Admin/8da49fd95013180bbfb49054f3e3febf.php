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
<div class="wrap jj">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('index');?>">学校列表</a></li>
        <li class="active"><a href="<?php echo U('addschool');?>">新增学校</a></li>
        <li ><a href="<?php echo U('schoolcheck');?>">学校审核</a></li>
        <!-- <li><a href="<?php echo U('schoolcheck');?>">学校审核</a></li> -->
    </ul>
    <div class="common-form">
        <style>
            .update_know{
                height: 30px;
                margin-top: -20px;
                line-height: 30px;
                font-size: 11px;
                color: red;
            }
        </style>
        <p class="update_know">* 图片上传须知：仅支持jpg、jpeg、png的图片格式，图片大小不超过2M</p>
        <form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('SchoolManage/addschool_post');?>">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">学校名称:</label>
                    <div class="controls">
                        <input type="text" class="input" name="school_name" value="">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">学校地址:</label>
                    <div class="controls">
                        <input type="text" class="input" name="school_address" value="">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">联系人:</label>
                    <div class="controls">
                        <input type="text" class="input" name="school_user" value="">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">联系电话:</label>
                    <div class="controls">
                        <input type="text" class="input" name="school_phone" value="">
                    </div>
                </div>
                <div class="control-group">
                		 <label class="control-label">学校的类型:</label>
                		  <div class="controls">
                		  	<select class="input" name="types">
                		  		<option value="">请选择学校的类型</option>
                		  		<?php if(is_array($class)): foreach($class as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                		  	</select>
                		  </div>
                </div>
          
                   <div class="control-group">
                		 <label class="control-label">学校的的区域:</label>
                		  <div class="controls">
                		  	<select class="province" id="province" name="province">
                		  		<option value="">请选择省</option>
                		  		<?php if(is_array($tegion)): foreach($tegion as $key=>$vo): ?><option value="<?php echo ($vo["term_id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                		  	</select>
                		  	&nbsp;市级选择：&nbsp;
                		  	 <select name="citys" class="citys" id="citys" >
                            <option value="">市级选择</option>
                          </select>
                		  	  &nbsp;区级选择：&nbsp;
                            <select name="quyu_id" class="message_type" id="message_type">
                             <option value="">请选择区域</option>
                             </select>
                		  </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">负责代理商:</label>
                    <div class="controls">
                        <select class="input" name="agent_id" >
                        	<option value="">请选择代理商 </option>
                        <?php if(is_array($agentlist)): foreach($agentlist as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                           
                        </select>

                    </div>
                </div>
                
                	
                <div class="control-group">
                    <label class="control-label">合同复印件:</label>
                    <div class="controls">
                        <input type="file" class="input" name="contract_pic" accept="image/png,image/jpeg,image/jpg">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">法人身份证:</label>
                    <div class="controls">
                        <input type="file" class="input" name="corporation_idcard" accept="image/png,image/jpeg,image/jpg">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">办学许可证:</label>
                    <div class="controls">
                        <input type="file" class="input" name="school_licence" accept="image/png,image/jpeg,image/jpg">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">组织机构代码证:</label>
                    <div class="controls">
                        <input type="file" class="input" name="organization_code" accept="image/png,image/jpeg,image/jpg">
                    </div>
                </div>
            </fieldset>
            <div class="form-actions">
                <!--<input type="hidden" name="id" value="<?php echo ($id); ?>" />-->
                <!--<button type="submit">更新</button>-->
                <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn ">提交</button>
                <button class="btn" type="reset">清空</button>
                <!--<a class="btn" href="/weixiaotong2016/index.php/Admin/SchoolManage/schoollist">清除</a>-->
            </div>
        </form>
    </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script>
	function DoOnchange(){
  document.changeForm.submit();
}


      $(function() {
              $("#province").change(function() {
                console.log($("#province").val())
                 $("#citys").empty();
                 $("#message_type").empty();
                 // $("#student").empty();
                  $.getJSON("/weixiaotong2016/index.php?g=Admin&m=Share&a=role_type&Province="+$("#province").val(),{},function(data){
                    console.log(data);
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
              });
          });

             $(function() {
              $("#citys").change(function() {
                  if( $("#citys").val()==0)
                  {
                      return false;
                  }
                 $("#message_type").empty();
                 // $("#student").empty();
                  $.getJSON("/weixiaotong2016/index.php?g=Admin&m=Share&a=Provinces&Province="+$("#citys").val(),{},function(data){
                    console.log(data);
                      if(data.status=="success"){
                      
                          $("#message_type").append("<option value=0>"+"请选择区域"+"</option>");
                          for(var key in data.data){
                              $("#message_type").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                          }
                      }
                      if(data.status=="error"){
                          $("#message_type").append("<option value='0'>没有市级</option>");
                      }
                  });
              });
          });



	 // //选择市级的下拉的ajax
  //   $(".citys").click(function(){
  //       $(".jiu").hide();
  //       var Province =$(".province option:selected").val();
  //       if(Province==""){
  //           alert("请选择你要搜索的省")
  //       }else{
  //           $.ajax({
  //               type:"post",
  //               url: '/weixiaotong2016/index.php/?g=Admin&m=SchoolManage&a=Provinces',
  //               async:true,
  //               data:{
  //                   Province:Province
  //               },
  //               dataType: 'json',
  //               success: function(res) {
  //                   var html = "";
  //                   res = eval(res.data);
  //                   for(var i = 0; i < res.length; i++) {
  //                       var name=res[i].name;//地区的名字；
  //                       var term_id=res[i].term_id;//地区的ID
  //                       html+='<option class="jiu"value="'+term_id+'">'+name+' </option> '
  //                   }
  //                   $(".citys").append(html);
  //               },
  //               error: function() {
  //                   console.log('系统错误,请稍后重试');
  //               }
  //           });
  //       }

  //   })
  //     $(".message_type").click(function(){
  //       $(".jius").hide()
  //       var zhi= $(".citys option:selected").val();
  //       if(zhi==""){
  //           alert("请选你要搜索的市")
  //       }else{
  //           $.ajax({
  //               type:"post",
  //               url: '/weixiaotong2016/index.php/?g=Admin&m=SchoolManage&a=Provinces',
  //               async:true,
  //               data:{
  //                   Province:zhi
  //               },
  //               dataType: 'json',
  //               success: function(res) {
  //                   var html = "";
  //                   res = eval(res.data);
  //                   for(var i = 0; i < res.length; i++) {
  //                       var name=res[i].name;//地区的名字；
  //                       var term_id=res[i].term_id;//地区的ID
  //                       html+='<option class="jius"value="'+term_id+'">'+name+' </option> '
  //                   }
  //                   $(".message_type").append(html)
  //               },
  //               error: function() {
  //                   console.log('系统错误,请稍后重试');
  //               }
  //           });
  //       }

  //   })
	
</script>
</body>
</html>