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
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo U('index');?>">学生微信绑定统计</a></li>
        <!-- <li><a href="<?php echo U('Notice/add');?>">新增班级相册</a></li> -->
        <!-- <li><a href="<?php echo U('schoolcheck');?>">学校审核</a></li> -->
    </ul>
     <div class="common-form">
       <fieldset>
         <div class="search_type cc mb10">
          <div class="mb10">
          <span class="mr20">
              省份选择：
            <select  class="province"  name="province" id="province" style="width: auto;">
              <option value="">&nbsp;&nbsp;
                     
                        省级选择&nbsp;
                        &nbsp;
                       
                        </option>
              <?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?> 
                <option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
            </select>&nbsp;&nbsp;
            <input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>">
            市级:
            <select class="select_1" name="citys" id="citys" style="width: auto;">    
            
                               <option value="0" selected>请先选择省份</option>
                               
            </select> &nbsp;&nbsp;
            <input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>">
            区级:
            <select class="select_3" name="message_type" id="message_type" style="width: auto;">    
               <option value="0">请选择你的区域</option>
            </select> &nbsp;&nbsp;
            学校： 
             <select id="school" style="width: auto;">
                    <option value="0" >请选择学校</option>
                   </select><br>
       
          <span class="mr20" >
              年级选择：
                   <span style="width: 45%; margin-top: 13px; ">
            <select id="gradename" name="gradeid" style="width: auto;">
             
              <option value="0"> &nbsp;&nbsp; 年级选择 &nbsp;&nbsp; </option>
            </select>&nbsp;&nbsp;
            班级:<span style="width: 45%; margin-top: 13px; ">
            <select id="classname" name="classid" style="width: auto;">
             
              <option value="0"> &nbsp;&nbsp; 班级选择 &nbsp;&nbsp; </option>
            </select>
&nbsp;&nbsp;
          <span style="width: 45%; margin-top: 13px; ">
						<select class="tiaojian" id="tiaojian" name="tiaojian" style="width: auto;">

						    <option value="0">&nbsp;&nbsp;

                        查询类型&nbsp;
                        &nbsp;</option>

							<option value="name">学生名字</option>

                            <option value="names">家长名字</option>

                            <option value="phone">家长号码</option>
						</select>
				            <input type="text" placeholder="根据条件进行模糊查询" name="shuzhi" class="zhi"  id="tiaojiancontent" value="<?php echo ($shuzhi); ?>" style="width: 150px;">

						</span>
            
            </span>&nbsp;&nbsp;&nbsp;&nbsp;
            <!-- 时间：
            <input type="text" name="start_time" class="J_date" value="<?php echo ((isset($formget["start_time"]) && ($formget["start_time"] !== ""))?($formget["start_time"]):''); ?>" style="width: 80px;" autocomplete="off">- -->
            <!-- <input type="text" class="J_date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp; -->
            <div style="       display: inline-block;
    margin-top: 8px; ">
                       <button type="button" class="btn btn-primary" id="chaxun" style='margin-top: -10px;'>查询</button>&nbsp;&nbsp;
                        
    
                        
                        
    
            <a class="btn btn-danger" href="<?php echo U('index');?>" style='margin-top: -10px;'>清空</a>
        
            <!-- <a class="btn btn-danger drop" >退学</a> -->
            </div> 
          </span>


          </span>
        </div>
       </div>
      <div style="clear: both"></div>
            </fieldset>
    </div>
            <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; ">
                      <div class="modal-dialog" style="    margin-top: 0;">
                        <div class="modal-content">
                          <div class="modal-header" style="background: white">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: relative;
    left: -12px;"><span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;"><span class="stuname"></span>学生绑定情况</h5>
                            <hr>
                          </div>
                          <div class="modal-body2" style="max-height: 300px; overflow-y: auto;">
                             <div class="table-responsive main">
                             <h3 class="bt" style="text-align: center; color: red;"></h3>
             
                   
                
        
                  </div>
    
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="background: white; color:black; font-weight:bold;">关闭</button>
                           
                          </div>
                       
                        </div>
                      </div>
         </div>   
 <!--重置密码-->


       	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="    display: none;">
										  <div class="modal-dialog">
										    <div class="modal-content">
										      <div class="modal-header" style="background: white">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;">重置密码</h5>
										        <hr>
										      </div>
										      <div class="modal-body2">
					                
    
										        <p class="text-center">
										          <input type="hidden" class="parent_id" ><br>
                                                  <span style="margin-left: 28px;">家长:</span> &nbsp;<input type="text" name="teacher_mname" readonly="true" class="parent_mname"><br>
										           <span style="margin-left: 14px;">新密码:</span> &nbsp;<input type="password" class="rel" name="password"><br>
										          <span>确认密码:</span> &nbsp;<input type="password" class="pwd"></p>
										      </div>
										      <div class="modal-footer">
										      <button class="btn btn-primary pwdtj" style="font-weight:bold;" >提交</button>
										        <button type="button" class="btn btn-danger" data-dismiss="modal" style="">关闭</button>
										    
										      </div>
										   
										    </div>
										  </div>
					</div>
     <!--重置密码end-->


              <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th >班级名称</th>
                <th>学生姓名</th>
                <th>家长</th>
                <th>关系</th>
                <th>账号</th>
                <th>手机号码</th>
                <th>微信绑定码</th>
                <th>微信是否绑定</th>
                <th>APP是否登录</th>
                <th>微信状态</th>
                <th>APP状态状态</th>
                <th>微信绑定时间</th>
                <th>操作</th>


       <!--          <th>发送进度</th>
                <th>操作</th>
                <th>档案进度</th> -->
             
            </tr>
            </thead>
            <tbody>
                <!--<tr><td>1</td><td>1</td><td><img width="30" height="30" src="/weixiaotong2016uploads/avatar/<?php echo ($vo["photo"]); ?>" /></td><td>1</td><td>1</td></tr>-->
            </tbody>
        </table>



           
            <div class="pagination"><?php echo ($Page); ?></div>

       
    </div>
    <script src="/weixiaotong2016/statics/js/common.js"></script>
    <script>
$(document).ready(function () {
    $("#message_type").val(0);
    $("#citys").val(0);
    $("#school").val(0);
    $("#gradename").val(0);
});
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
    $("#school").empty(); 
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
          $("#school").append("<option value='0'>请选择学校</option>");
          $("#school").append(html)
          $("#viewOLanguage").chosen();
          $("#viewOLanguage").trigger("liszt:updated");
        },
        error: function() {
          console.log('系统错误,请稍后重试');
        }
      });
    })

       $("#school").change(function(){
             $("#gradename").empty();
             
            
           $.getJSON("/weixiaotong2016/index.php?g=admin&m=AdminUtils&a=showgrade&schoolid="+$("#school").val(),{},function(data){
                if(data.status=="success"){
                    $("#gradename").append("<option value=''>请选择年级</option>");
                for(var key in data.data){
                    $("#gradename").append("<option value="+data.data[key]["gradeid"]+">"+data.data[key]["name"]+"</option>");
                }
                }
                if(data.status=="error"){
                    $("#gradename").append("<option value='0'>没有年级</option>");
                }
            });



    }) 

          $("#gradename").change(function(){
             $("#classname").empty();
            
           $.getJSON("/weixiaotong2016/index.php?g=admin&m=AdminUtils&a=showclass&schoolid="+$("#school").val()+'&gradeid='+$("#gradename").val(),{},function(data){

                if(data.status=="success"){
                    $("#classname").append("<option value=''>请选择班级</option>");
                for(var key in data.data){
                    $("#classname").append("<option value="+data.data[key]["id"]+">"+data.data[key]["classname"]+"</option>");
                }
                }
                if(data.status=="error"){
                    $("#classname").append("<option value='0'>没有年级</option>");
                }
            });



    })     


$(document).on('click','.frost',function(){

	var name = $(this).parent().parent().find("td:eq(2)").text();
	var parentid =$(this).attr('data-id');
    
    var sql_type = $(this).attr('data-type');
   
    
   var obj_class = $(this).attr("class"); 

    var obj = $(this).parent();




  if (confirm("确定要将家长:"+name+"冻结吗？")) {
     var status = 2;
   
     parent_status(sql_type,parentid,status,obj,obj_class);
  }


})

$(document).on('click','.clear',function(){

	var name = $(this).parent().parent().find("td:eq(2)").text();
	var parentid =$(this).attr('data-id');

	var sql_type = $(this).attr('data-type');

	var obj = $(this).parent();

	var obj_class = $(this).attr("class"); 

  if (confirm("确定要将家长:"+name+"解锁吗？")) {
     var status = 1;

     parent_status(sql_type,parentid,status,obj,obj_class);
  }


})

    function  parent_status(sql_type,parentid,status,obj,obj_class)
    {
               $.ajax({
					type: "get",
					async: false,
					dataType:'json',
					url: "<?php echo U('Admin/Binding/status');?>",
					data: {
						parentid:parentid,
						status:status,
						sql_type:sql_type,
						

					},
					success: function(data) {
					
						if(data.status){


							
                            layer.msg('成功', {
                                icon: 1
                                ,shade: 0.01,
                            });

                             if(obj_class=='frost')
						    {
                               obj.find("span").text("已冻结");
                               obj.find("a").text("解锁");
                               obj.find("a").attr("class",'clear');
						    }else{
						       obj.find("span").text("已启动");
                               obj.find("a").text("冻结");
                               obj.find("a").attr("class",'frost');
						    }

						  	
                            
		                }else{
		                    alert(data.info);
		                }
					},
					//请求失败
					 error:function(){
		               alert('请求失败');
		            }
				});
    } 


$(document).on("click",".reset",function(){

		var parentid = $(this).attr("data-id");
             
        var parent_name = $(this).parent().parent().find("td:eq(2)").text();
       if (confirm("确定要将家长:"+parent_name+"密码重置吗？")) {

         reset_word(parentid)
       }

})


function reset_word(parentid){

  $.ajax({
					type: "get",
					async: false,
					dataType:'json',
					url: "<?php echo U('Admin/Binding/reset_word');?>",
					data: {
						parentid:parentid,

					},
					success: function(data) {
					
						if(data.status){


							
                            layer.msg('重置密码成功,密码为手机号后6位:'+data.msg, {
                                icon: 1
                                ,shade: 0.01,
                            });

                           
						  	
                            
		                }else{
		                    alert(data.info);
		                }
					},
					//请求失败
					 error:function(){
		               alert('请求失败');
		            }
				});

}








    $(document).on("click",".pagination a",function(){
    	layer.load();
    	//return false;
        $.getJSON($(this).attr('href'),function(data){ 
       
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
                       
                        
                           var id = ""
                           var classname = "";
                          var student_name = "";
                          var parent_name = "";
                     
                          var appellation = "";
                          var account = "";
                          var phone = "";
                          var bindingkey = "";
                          var weixin = "";
                          var app_login = "";
                          var parent_id = "";
                           var weixin_status = "";
                          var app_status = "";    
                          var createtime = "";
                           var j = 0
                            // $("table tbody").children().remove();
                            for (var i=0;i<adata.length;i++){
                          
                            	if(i==0)
                            	{
                            		$(".pagination").append(adata[i]);
                            		continue
                            		//return false;
                            	}
                                 
                                id = adata[i]['id']; 
                                classname = adata[i]['classname'];
                                student_name = adata[i]['stu_name'];
                                parent_name = adata[i]['parent_name'];
                                appellation = adata[i]['appellation'];
                                account = adata[i]['phone'];
                                phone = adata[i]['phone'];
                                bindingkey = adata[i]['bindingkey'];
                                weixin = adata[i]['appid'];
                                app_login = adata[i]['last_login_time'];
                                parent_id = adata[i]['parentid'];
                                 weixin_status = adata[i]['status'];
                                app_status = adata[i]['app_status'];
                                createtime = adata[i]['createtime'];
                                // n_lattend = adata[i]['n_lattend'];
                                if(app_status==null)
                                {
                                	app_status = '';
                                }
                        
                                if(weixin_status=='已启动')
                                { 
                                	weixin_type  = '&nbsp;<a style=cursor:pointer; data-type=1 class=frost data-id='+parent_id+'>冻结</a>&nbsp;'
                                 
                                }else if(weixin_status=='已冻结'){
                                    weixin_type  = '&nbsp;<a style=cursor:pointer; data-type=1 class=clear data-id='+parent_id+'>解锁</a>&nbsp;'
                                }else{
                                	weixin_type = '';
                                }
                         
                               if(app_status=='已启动')
                                { 
                                	app_type  = '&nbsp;<a style=cursor:pointer; data-type=2 class=frost data-id='+parent_id+'>冻结</a>&nbsp;'
                                 
                                }else if(app_status=='已冻结'){
                                    app_type  = '&nbsp;<a style=cursor:pointer; data-type=2 class=clear data-id='+parent_id+'>解锁</a>&nbsp;'
                                }else{
                                	app_type = '';
                                }
                                if(createtime == undefined)
                                {
                                    createtime = '';
                                }
                                $("table tbody").append('<tr><td>'+classname+'</td><td>'+student_name+'</td><td>'+parent_name+'</td><td>'+appellation+'</td><td>'+account+'</td><td>'+phone+'</td><td>'+bindingkey+'</td><td>'+weixin+'</td><td>'+app_login+'</td><td><span>'+weixin_status+'</span>'+weixin_type+'</td><td><span>'+app_status+'</span>'+app_type+'</td><td>'+createtime+'</td>><td><a>冻结</a>&nbsp;<a style=cursor:pointer; class=reset  data-id='+parent_id+' >重置密码</a></td></tr>');

                            }
           
                            
           }) 
        return false; 

    })



  



    $("#chaxun").click(function () {
             layer.load();
                    var schoolid = $("#school").val();

                    // console.log(schoolid);
                    // return false;
                   var gradeid = $("#gradename").val();

                   var classid = $("#classname").val();

                    var tiaojian = $("#tiaojian").val();
                    var zui = $("#tiaojiancontent").val();
              
                    // var date = $("#time").val();
                  
                    $.ajax({
                        url:"/weixiaotong2016/index.php/Admin/Binding/WeChat",
                        dataType:"json",
                        type:"get",
                        data:{
                      
                            schoolid:schoolid,
                            gradeid:gradeid,
                            classid:classid,
                            tiaojian:tiaojian,
                            zui:zui,
                        },
                        success:function (res) {
                        	console.log(res);
                            setTimeout(function(){
                      layer.closeAll('loading');
                    });
                            $("table tbody").children().remove();
                            $(".pagination").children().remove();
                    if(res.status=="error"){
                        // console.log('aaa');
                   $("table tbody").append('<tr><td>没有数据!</td>');
                }
                            
                          var adata = res;
                           
                        
                           var id = ""
                           var classname = "";
                          var student_name = "";
                          var parent_name = "";
                     
                          var appellation = "";
                          var account = "";
                          var phone = "";
                          var bindingkey = "";
                          var weixin = "";
                          var app_login = "";
                           var parent_id = "";
                          var weixin_status = "";
                          var app_status = "";    
                           var j = 0
                           var weixin_type = "";
                           var app_type = "";
                           var createtime = "";
                            // $("table tbody").children().remove();
                            for (var i=0;i<adata.length;i++){

                            	if(i==0)
                            	{
                            		$(".pagination").append(adata[i]);
                            		//return false;
                            		continue
                            	}
                                 
                                id = adata[i]['id']; 
                                classname = adata[i]['classname'];
                                student_name = adata[i]['stu_name'];
                                parent_name = adata[i]['parent_name'];
                                appellation = adata[i]['appellation'];
                                account = adata[i]['phone'];
                                phone = adata[i]['phone'];
                                bindingkey = adata[i]['bindingkey'];
                                weixin = adata[i]['appid'];
                                app_login = adata[i]['last_login_time'];
                                parent_id = adata[i]['parentid'];
                                weixin_status = adata[i]['status'];
                                app_status = adata[i]['app_status'];
                                createtime = adata[i]['createtime'];

                                if(app_status==null)
                                {
                                	app_status = '';
                                }
                        
                                if(weixin_status=='已启动')
                                { 
                                	weixin_type  = '&nbsp;<a style=cursor:pointer; data-type=1 class=frost data-id='+parent_id+'>冻结</a>&nbsp;'
                                 
                                }else if(weixin_status=='已冻结'){
                                    weixin_type  = '&nbsp;<a style=cursor:pointer; data-type=1 class=clear data-id='+parent_id+'>解锁</a>&nbsp;'
                                }else{
                                	weixin_type = '';
                                }
                         
                               if(app_status=='已启动')
                                { 
                                	app_type  = '&nbsp;<a style=cursor:pointer; data-type=2 class=frost data-id='+parent_id+'>冻结</a>&nbsp;'
                                 
                                }else if(app_status=='已冻结'){
                                    app_type  = '&nbsp;<a style=cursor:pointer; data-type=2 class=clear data-id='+parent_id+'>解锁</a>&nbsp;'
                                }else{
                                	app_type = '';
                                }
                                if(createtime == undefined)
                                {
                                    createtime = '';
                                }
                         
                                // n_lattend = adata[i]['n_lattend'];
                              
                    

 
                                $("table tbody").append('<tr><td>'+classname+'</td><td>'+student_name+'</td><td>'+parent_name+'</td><td>'+appellation+'</td><td>'+account+'</td><td>'+phone+'</td><td>'+bindingkey+'</td><td>'+weixin+'</td><td>'+app_login+'</td><td><span>'+weixin_status+'</span>'+weixin_type+'</td><td><span>'+app_status+'</span>'+app_type+'</td><td>'+createtime+'</td><td><a>冻结</a>&nbsp;<a style=cursor:pointer; class=reset   data-id='+parent_id+' >重置密码</a></td></tr>');
                            }
                        },
                        error:function (res) {
                            var data = eval(res.data);
//                            alert("失败");
                           
                        }
                    })

             });

  










        function refersh_window() {
            var refersh_time = getCookie('refersh_time');
            if (refersh_time == 1) {
                window.location = "<?php echo U('Notice/index',$formget);?>";
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
                                    id : 'error',
                                    icon : 'error',
                                    content : '您没有勾选信息，无法进行操作！',
                                    cancelVal : '关闭',
                                    cancel : true
                                });
                                return false;
                            }
                            var $this = $(this);
                            art.dialog.open(
                                    "/weixiaotong2016/index.php?g=portal&m=AdminPost&a=move&ids="
                                            + id, {
                                        title : "批量移动",
                                        width : "80%"
                                    });
                        });
            });
        });
    </script>
</body>
</html>