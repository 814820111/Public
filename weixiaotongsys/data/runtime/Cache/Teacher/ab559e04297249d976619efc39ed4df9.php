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
<style>
*{ font-size:14px;}
.xuan{ float:right; padding:3px 10px 3px 10px; margin-right:20px;}
.xuan input{ margin-top:0px; margin-right:5px;}
.zeng{ float:left; border:1px solid #cfe7f7; padding:0px 20px 0px 20px; margin-right:20px; margin-bottom:10px; width: 80px; color: black;}
.zeng input{ margin-top:0px; margin-right:5px;}
.zlei{ background-color:#ffefef; border-color:#c50000;}
.zlei2{ background-color:#ffefef; border-color:black;}
.clearfix{ clear:both;}
.newz{ background-color:#f2f2f2; float:right; padding:3px 10px 3px 10px; border-radius:5px; cursor:pointer;}
.tanchuang{ width:100%; height:100%; background-color:rgba(0,0,0,0.7); position:absolute;}
.del{ float: right; width: 14px; height: 14px; margin-left: 8px; margin-top: 3px; background-color: red; border-radius: 20px; display: none; cursor:pointer; background-image:url(/weixiaotong2016/statics/images/delete.png); background-size:contain; background-repeat:no-repeat;}
div{
  color: black;
}
</style>
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/wxt_webhome/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<link href="/weixiaotong2016/simpleboot/css/default.css" rel="stylesheet">
<script src="/weixiaotong2016/statics/js/jquery.min.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/artDialog.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
<body>
<script src="/weixiaotong2016/statics/js/jquery.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/wind.js" type="text/javascript"></script>
	<div style=" margin-bottom:100px;">
      <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none;">
            <li class="active"><a href="<?php echo U('homework');?>" style="color:#1f1f1f; text-decoration: none;">科目设置</a></li>
      </ul>
      <!--弹窗start-->
      <div class="tanchuang"  style="display: none; z-index: 999;">
      		<div style=" width:600px; margin-left:auto; margin-right:auto; background-color:white; margin-top:100px; padding:20px;">
            	<form>	
                    <div style=" color:#61c881;">新增科目</div>
                    <div style=" margin-left:80px; margin-top:30px;">
                    	科目名称：
                    	<input type="text" name="subject_name" style=" height:10px; margin-top:7px; border-width:1px; width:320px; color: black;" placeholder="请输入内容">
                    </div>
                    <div style=" margin-left:80px;">
                    	成绩类型：
                    	<select name="status" style="margin-top:7px; width:334px; height:25px; padding:0; color: black;">
                        		<option value="0">-请选择-</option>
                            <option value="1">百分制</option>
                      </select>
                    </div>
                    <div style=" margin-top:50px;">
                    		<input type="button" value="保存" style=" padding:3px 13px; border:none; background-color:#26a69a; color:white; border-radius:3px; margin-left:220px; margin-right:50px;" onclick='sub_qrcj()'>
                            <input type="button" value="取消" style=" padding:3px 13px; border:none; background-color:#adadad; color:white; border-radius:3px;" class="button">
                    </div>
            	</form>
            </div>
      </div>
      <!--弹窗end-->
      <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="home"></div>
            <form class="form-horizontal J_ajaxForm" action="<?php echo u('save_subject');?>" method="get">
            <fieldset>
               <!-- TODO年级先注释 -->
                <div class="control-group" style=" margin-bottom:10px;">
                 <!--  <label class="control-label" for="name">年级:</label> -->
                  <div class="controls">
                    <!-- <select id='grade' class="form-control" > -->
                     <!--  <option>-请选择-</option> -->
                      <?php if(is_array($grade)): $i = 0; $__LIST__ = $grade;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$grade): $mod = ($i % 2 );++$i;?><!--    <OPTION value="<?php echo ($grade["gradeid"]); ?>"><?php echo ($grade["name"]); ?></OPTION>  --><?php endforeach; endif; else: echo "" ;endif; ?>
                      <!-- <?php if(is_array($grade)): foreach($grade as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["grade"]); ?></OPTION><?php endforeach; endif; ?> -->
                    </select>
                  </div>
                  <input type="hidden" name="sub" value="<?php echo ($sub); ?>">
                </div>
                <div class="control-group" style=" margin-bottom:10px;">
                  <label class="control-label" for="name">学科:</label>
                  <div class="controls">
                    <div class="form-control" style="width:50%; border:1px solid #dddddd; min-height:100px; padding:20px;">
                    	<!--默认课程start-->
                      <?php if(is_array($subject)): foreach($subject as $key=>$to): if($to['statu'] == 1 ): ?><div class="zeng"  name="zeng[]"" style="background: pink;cursor: pointer;"   data-id=<?php echo ($to["id"]); ?>>
                             
							            <input type="checkbox" name="subject_id[]" id="check"  class="fx" value="<?php echo ($to["id"]); ?>"  checked ><?php echo ($to["subject"]); ?>
              
                          
                          <!-- <a href="<?php echo U('delete',array('id'=>$to['id']));?>" class="del" style="display: block;  position: relative;"></a> -->
                          <div class="clearfix"></div>     
                        </div>
                        <?php if($to['isdefault'] == 0): else: ?>
                          <a href="<?php echo U('delete',array('id'=>$to['id']));?>" class="del" style="display: block;  position: relative; float: left; z-index: 5; margin-left:-37px;"></a><?php endif; ?>
                        <?php else: ?>
                          <div class="zeng" name="zeng[]" style="cursor: pointer;">
                        
                         <input type="checkbox" name="subject_id[]" class="fx"  id="check" value="<?php echo ($to["id"]); ?>" ><?php echo ($to["subject"]); ?>
                       
                         
                          
                          <!-- <a href="<?php echo U('delete',array('id'=>$to['id']));?>" class="del" style="display: block; float: left;  margin-left:-37px;"></a> -->
                          <div class="clearfix"></div>
                        </div>
                        <?php if($to['isdefault'] == 0): else: ?>
                          <a href="<?php echo U('delete',array('id'=>$to['id']));?>" class="del" style="display: block;  position: relative; float: left; margin-left:-37px;"></a><?php endif; endif; endforeach; endif; ?>  
                        <!--默认课程end-->
						            <div class="clearfix"></div>
                    </div>
                    <div style=" width:53%; margin-top:20px;">
                        <div class="newz" style=" border:1px solid #bbbbbb;">新增科目</div>
                        <div class="xuan">
                          <input name="checkall" type="checkbox" value="checkbox" onclick="change(document.getElementsByName('subject_id[]'), this.checked,document.getElementsByName('zeng[]'))" style=" margin-left:3px; border:1px solid black;" class="all1"/>选中全部科目 
                        </div>
                        <div class="clearfix"></div>
                    </div>
                  </div>
                </div>
  			      </fieldset>
              <div class="form-actions" style=" background-color: white;">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary bc" style="border:none;;color:#FFF; background-color:#26a69a; margin-right:10%;"> 保存修改 </button>
                </div>
              </div>  
            </form>
        </div>
</div>
<script src="/weixiaotong2016/statics/js/common.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/jquery" type="text/javascript"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
<!-- 选择年级实现不跳转、不刷新的情况下选择年级对应的科目(复选框) -->
<SCRIPT type=text/javascript>
 //点击选中取消
$(".zeng").click(function(){
  var id = $(this).attr('data-id');
  var fx = $(this).children("input.fx").attr("checked");

  if(fx){
  //console.log(fx);
  $(this).children("input.fx").removeAttr("checked");
    //取消选中
    $(this).css("background-color","white");
    // calloff(id)

}else{
  $(this).children("input.fx").attr("checked",true);
  $(this).css("background-color","pink");
}


})


$('.fx').click(function(){
    var fx = $(this).attr("checked");
    var aa = $(this).parent();
    console.log(aa);
    if (!fx) {
      $(this).attr("checked",true);
    }else{
       $(this).removeAttr("checked");
    } 

});

//取消

  // function calloff(id)
  //             {
  //           $.ajax({
  //               type:'post',
  //               url: "<?php echo U('Teacher/SubjectManage/calloff');?>",
  //               dataType:'json',
  //               async: false,
  //               data: {
  //           'id': id,
            
  //         },
  //               success:function(data){
  //                    console.log(data);
  //                   if(data.status){
  //                     layer.msg('取消课程成功', {
  //                               icon: 1
  //                               ,shade: 0.01,
  //                           });
  //                   }else{
                        
  //                   }
  //               },
  //               //请求失败
  //               error:function(){
  //                  alert('404')
  //               }
  //           })
  //             }







 $(".bc").click(function(){
  console.log("sdasdas");

 })



</script>
<script>
$(".tanchuang").hide()
$(".newz").click(
			function(){
				$(".tanchuang").show()
				}
)
$(".button").click(
			function(){
				$(".tanchuang").hide()
				}
)
</script>
   <script>
    function sub_qrcj() {
    var status = $("select[name='status']").val();


    var subject_name = $("input[name='subject_name']").val();

    if(!subject_name)
    {
      alert('科目名称不能为空');
      return false;
    }
        if(status==0)
        {
            alert('成绩类型不能为空!');
            return false;
        }
    $.ajax({
      type:"post",
      async:false,
      url:"<?php echo U('Teacher/SubjectManage/subject_add');?>",
      data:{'status': status,'subject_name': subject_name},
      success: function(msg){
        history.go(0);
      }
    });
  }
</script>
<script>
   $(function () {
      $('#myTab li:eq(0) a').tab('show');
   });
</script>
<script>
            $("#file-3").fileinput({
                  showUpload: false,
                  showCaption: false,
                  browseClass: "btn btn-default",
                  fileType: "any",
              previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
            });
          $(document).ready(function() {
              $("#test-upload").fileinput({
                  'showPreview' : false,
                  'allowedFileExtensions' : ['jpg', 'png','gif'],
                  'elErrorContainer': '#errorBlock'
              });

          });
</script>
<script>
var change = function (chkArray, val,zeng) 
{




  
      
 for (var i = 0 ; i < chkArray.length ; i ++) 
//遍历指定组中的所有项

  (function(k){
   
 chkArray[k].checked = val;
    // console.log(val);
     if(val)
     {
      zeng[k].style.backgroundColor="pink"
     }else{
      zeng[k].style.backgroundColor="white";
     }  


  })(i);

     

//设置项为指定的值-是否选中

}
</script>
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
</body>
</html>