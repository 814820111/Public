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
.chzn-container-single .chzn-single {
  position: relative;
  top: 12px;
  height: 29px; 
}

table td{
  color: black;
}
</style>
<body class="J_scroll_fixed">

<div class="wrap J_check_wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo U('index');?>">学校列表</a></li>
        <li><a href="<?php echo U('transfer_log');?>">划拨日志</a></li>
        
    </ul>
    <div class="well form-search">
        省份选择：

        <select  class="province" id="province" style="width: auto;">
           
            <option value="">省级选择</option>
            <?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?> 
                <option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
        </select>
        市级选择：
       <input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>">
        <select name="" class="citys"  id="citys" style="width: auto;">

            <option value="">市级选择</option>
        </select>

        县级选择:&nbsp;
        <input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>" >
        <select name="city_next" class="select_3" id="message_type"  style="width: auto;">
            <option value="">请选择区域</option>

        </select>
        学校名称：
        <select data-placeholder="输入关键字。。。" id="viewOLanguage" class="chzn-select"  tabindex="2" name="school_id">
            <option value=""></option>
        </select>
        <input type="hidden" class="type_school" value="<?php echo ($schoolid); ?>">
        <div style="position: relative;top: 10px;left: 8px;" >

            年级段：&nbsp;
            <select class="classname" style="width: auto;">
                <option value="">选择年级段</option>
                <?php if(is_array($class)): foreach($class as $key=>$vo): $grade=$grade_type==$vo['id']?"selected":""; ?> 
                    <option value="<?php echo ($vo["id"]); ?>" <?php echo ($grade); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
            </select>

            使用状态：
            <select name="" class="school_status" style="width: auto;">
                <option value='' >学校使用状态</option>
                <option value="0" >停用</option>
                <option value="1" >试用期</option>
                <option value="2" >收费期</option>
            </select>
  <!--              <select name="" class="school_status" >
                <option value='' <?php if($status=='') echo("selected");?>>学校使用状态</option>
                <option value="0" <?php if($status==0) echo("selected");?>>停用</option>
                <option value="1" <?php if($status==1) echo("selected");?>>试用期</option>
                <option value="2" <?php if($status==2) echo("selected");?>>收费期</option>
            </select> -->
           <span style="    margin-left: 210px;">
            <input type="submit" class="btn btn-primary ss" value="搜索" />&nbsp;&nbsp;
            <input type="submit" class="btn btn-primary" value="导出" />&nbsp;&nbsp;
            <a class="btn btn-danger" href="<?php echo U('SchoolTransfer/index');?>">清空</a>
            </span>
        </div>
    </div>



</div>
</div>
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
									</li>
		
								</ul>
							</div>
						</div>
					<form action="" method="get" id="myform" >	
						<div class="modal-body">
							<div class="hide" style="display: block;     text-align: center;">


								<div>
								        <span style="margin-left: 43px;">学校:&nbsp;&nbsp;</span><input type="text"  class="school_name" readonly="true"><br>
								                                                
								                                                 <input type = hidden class ="ag_schoolid" name="ag_schoolid">
								                                                 <input type = hidden class ="old_agentid" name="old_agentid">
                                                                                 <input type = hidden name="agent_newname" class="agent_newname">
                                                                                 <input type = hidden name="agent_oldname" class="agent_oldname">
								                                                
									选择代理商:&nbsp;&nbsp;<select name="new_agentid" id="agent" style="    vertical-align: 0px; "> 
									   <?php if(is_array($agent)): foreach($agent as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
									</select>
									
								</div>
								<input type="hidden" class="teacherid">
							
							</div>
				
						</div>
					
						<div class="modal-footer">
							<button  type="button" class="btn btn-primary agtj"  value="提交更新" style=" border:none; color:white; border-radius:3px; padding:5px 15px 5px 15px;" >提交更新</button >
							<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
						</div>
						</form>	
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal -->
			</div>

   <!--调班级end-->

<table class="table table-hover table-bordered">
    <thead>
    <tr>
        <th width="50">学校ID</th>
        <th>学校名称</th>
        <th>学校的类型</th>
        <th>学校地址</th>
        <th>学校的区域</th>
        <th>联系人</th>
        <th>联系电话</th>
        <th>负责代理商</th>
        <th>代理商电话</th>
        <th>创建时间</th>
        <th>状态</th>
        <th width="120">管理操作</th>
    </tr>
    </thead>
    <tbody>
    <?php $school_statuses=array("0"=>"停用","1"=>"试用期","2"=>"收费期"); ?>
    <?php if(is_array($school)): foreach($school as $key=>$vo): ?><tr>
            <td><?php echo ($vo["schoolid"]); ?></td>

            <td><?php echo ($vo["school_name"]); ?></td>
            <td><?php echo ($vo["class_name"]); ?></td>
            <td><?php echo ($vo["school_address"]); ?></td>
            <td><?php echo ($vo["agent_name"]); ?></td>
            <td><?php echo ($vo["school_user"]); ?></td>
            <td><?php echo ($vo["school_phone"]); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><?php echo ($vo["ag_phone"]); ?></td>
            <td><?php echo date('Y-m-d h:i:s',$vo['create_time']); ?></td>
            <td><?php echo ($school_statuses[$vo['school_status']]); ?></td>
            <td>
            
             
                
                   <a class="transfer" style='cursor:pointer;' data-ag = <?php echo ($vo["agent_id"]); ?>>学校划拨</a>
            

            </td>
        </tr><?php endforeach; endif; ?>
    </tbody>
</table>

<div class="pagination"><?php echo ($page); ?></div>
</div>

<script src="/weixiaotong2016/statics/js/common.js"></script>
<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>


<script>    

$("#agent").change(function(){

$(".agent_newname").val($("#agent").find("option:selected").text());

})
$(".agtj").click(function(){

   var  agent_name = $("#agent").find("option:selected").text();

   var new_agentid = $("#agent").val();
   var old_agentid = $(".old_agentid").val();

	  if(new_agentid==old_agentid)
	  {
	  	alert("请勿选择同样的代理商!");
	  	return false;
	  }

                 $.ajax({
		               type: "get",
		                            url: '/weixiaotong2016/index.php/?g=Admin&m=SchoolTransfer&a=transfer',
		                            async: true,
		                            data: $('#myform').serialize(),                          
		                            dataType: 'json',
		                            success: function(data) {
		                              
		                            if(data.status){
		                          layer.msg('划拨成功', {
                                     icon: 1
                                        ,shade: 0.01,
                                       });
                                    agent_obj.text(data.name);
                                    apentid_obj.attr("data-ag",data.agent_id);
			                         $("#myModal5").modal("hide");
			                    }else{
			                          alert(data.info);
			                      }
			                              
		                            },
		                            error: function() {
		                              console.log('系统错误,请稍后重试');
		                            }
		                          });


  return false;

})


$(".transfer").click(function(){

	  agent_obj = $(this).parent().parent().find("td:eq(7)");
	  apentid_obj = $(this);
	  var school = $(this).parent().parent().find("td:eq(1)").text();
	  $(".school_name").val(school);
	  var schoolid = $(this).parent().parent().find("td:eq(0)").text();
	  $(".ag_schoolid").val(schoolid);
      var agent = $(this).attr("data-ag");
      $(".old_agentid").val(agent);

      var oldname = $(this).parent().parent().find("td:eq(7)").text();
      $(".agent_oldname").val(oldname);
	  $("#agent").find("option[value = '"+agent+"']").attr("selected","selected");
	  $("#myModal5").modal("show");
})

    $(".ss").click(function(){
        var type = $(".select_3  option:selected").val();
        var schooiid=$(".chzn-select  option:selected").val();
        var classname=$(".classname option:selected").val();
        var school_status=$(".school_status option:selected").val();


        location.href="<?php echo U('SchoolTransfer/index');?>?type="+type+"&schooiid="+schooiid+"&classname="+classname+"&school_status="+school_status+"&province="+$("#province option:selected").val()+"&citys="+$("#citys option:selected").val()+"&school_id="+$('body').find("select[name='school_id']").val()+"";     	

    })




if($("#province").val())
{

  // console.log($("#province").val());

 var new_citys = $('body').find(".new_citys").val();


 var new_message_type = $('body').find('.new_message_type').val();

 


 var type_school = $('body').find(".type_school").val();


    if(new_citys)
    {
        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                      // console.log(data);
                        if(data.status=="success"){
                        $("#citys").empty();  
                            $("#citys").append("<option value=>"+"请选择市级"+"</option>");
                            for(var key in data.data){
                              
                                 if(new_citys==data.data[key]["term_id"]){
                                $("#citys").append("<option value="+data.data[key]["term_id"]+ " selected>"+data.data[key]["name"]+"</option>");

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
		                              $(".Sio").text("")
		                              var html = "";
		                              res = eval(res.data);
		                              for(var i = 0; i < res.length; i++) {
		                                var school_name = res[i].school_name; //学校的名字
		                                var schoolid = res[i].schoolid; //学校的ID
		                                if(schoolid== type_school){
		                                $("#viewOLanguage").append("<option value="+schoolid+" selected>"+school_name+"</option>");
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











          $(function() {
              $("#province").change(function() {
              
                 $("#citys").empty();
                 $("#message_type").empty();
                 // $("#student").empty();
                  $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                  
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
            
                 $("#message_type").empty();
                 // $("#student").empty();
                  $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                    // console.log(data);
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

          //      $(function() {
          //     $("#message_type").change(function() {
               
          //        // $("#student").empty();
          //         $.getJSON("/weixiaotong2016/index.php?g=Admin&m=SchoolManage&a=lookup&type="+$("#message_type").val(),{},function(data){
          //           console.log(data);
          //             if(data.status=="success"){
                      
          //                 $("#message_type").append("<option value=0>"+"请选择区域"+"</option>");
          //                 for(var key in data.data){
          //                     $("#message_type").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
          //                 }
          //             }
          //             if(data.status=="error"){
          //                 $("#message_type").append("<option value='0'>没有市级</option>");
          //             }
          //         });
          //     });
          // });
  




    //选择市级的下拉的ajax

    // $(".citys").click(function(){
    //     $(".jiu").hide();
    //     var Province =$(".province option:selected").val();
    //     console.log(Province);
    //     if(Province==""){
    //         alert("请选择你要搜索的省")
    //     }else{
    //         $.ajax({
    //             type:"post",
    //             url: '/weixiaotong2016/index.php/?g=Admin&m=SchoolManage&a=Provinces',
    //             async:true,
    //             data:{
    //                 Province:Province
    //             },
    //             dataType: 'json',
    //             success: function(res) {
    //                 var html = "";
    //                 res = eval(res.data);
    //                 for(var i = 0; i < res.length; i++) {
    //                     var name=res[i].name;//地区的名字；
    //                     var term_id=res[i].term_id;//地区的ID
    //                     html+='<option class="jiu"value="'+term_id+'">'+name+' </option> '
    //                 }
    //                 $(".citys").append(html);
    //             },
    //             error: function() {
    //                 console.log('系统错误,请稍后重试');
    //             }
    //         });
    //     }


    
    //选择市级的下拉的ajax
//    $(".citys").click(function(){
//        $(".jiu").hide();
//        var Province =$(".province option:selected").val();
//        if(Province==""){
//            alert("请选择你要搜索的省")
//        }else{
//            $.ajax({
//                type:"post",
//                url: '/weixiaotong2016/index.php/?g=Admin&m=SchoolManage&a=Provinces',
//                async:true,
//                data:{
//                    Province:Province
//                },
//                dataType: 'json',
//                success: function(res) {
//                    var html = "";
//                    res = eval(res.data);
//                    for(var i = 0; i < res.length; i++) {
//                        var name=res[i].name;//地区的名字；
//                        var term_id=res[i].term_id;//地区的ID
//                        html+='<option class="jiu"value="'+term_id+'">'+name+' </option> '
//                    }
//                    $(".citys").append(html);
//                },
//                error: function() {
//                    console.log('系统错误,请稍后重试');
//                }
//            });
//        }
//
//    })



    $("#viewOLanguage").chosen();
    $("#viewOLanguage").trigger("liszt:updated");

    $(".select_3").change(function(){
        var type = $(".select_3  option:selected").val();
        $.ajax({
            type:"post",
            url: '/weixiaotong2016/index.php/?g=Admin&m=AdminUtils&a=lookup',
            async:true,
            data:{
                type:type
            },
            dataType: 'json',
            success: function(res) {
                $(".Sio").text("")
                var html = "";
                res = eval(res.data);
                for(var i = 0; i < res.length; i++) {
                    var school_name=res[i].school_name;//学校的名字
                    var schoolid=res[i].schoolid;//学校的ID
                    html+='<option class="Sio" value="'+schoolid+'">'+school_name+' </option> '
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
</script>
</body>
</html>