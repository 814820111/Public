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
<style type="text/css"> 
	.touchlei{ background-color:#eeeeee;}
	select{
		color: black;
	}
  label{
  	color: black;
  }
    img{
    margin-right: 10px;
        margin-bottom: 5px;
  }

	/** {font-family:Microsoft YaHei,"微软雅黑",宋体,Courier New !important;color:black !important}*/
</style>
<body>
      <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
            <li class="active"><a href="<?php echo U('homework');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">布置作业</a></li>
            <li><a href="<?php echo U('lists');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">作业记录</a></li>
      </ul>
      <div id="myTabContent" class="tab-content" style="margin-left: -63px;">
            <div class="tab-pane fade in active" id="home"></div>
            <form class="form-horizontal J_ajaxForm" action="<?php echo u('Message/homework_post');?>" method="post">
                <input type="hidden" name="button_level" value="1">
            <fieldset>
                <div class="control-group" style=" margin-bottom:10px;">
                  <label class="control-label" for="name">班级:</label>
                  <div class="controls">
                    <select name='cl' class="form-control" >
                      <option value='0'>-选择班级-</option>
                      <?php if(is_array($class)): foreach($class as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>
                    </select>
                  </div>
                </div>
                <div class="control-group" style=" margin-bottom:10px;">
                  <label class="control-label" for="name">学科:</label>
                    <div class="controls">
                      <select name='sub' class="form-control"  >
                        <option value='0' style=" padding:0;">-选择学科-</option>
                        <?php if(is_array($subject)): foreach($subject as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>
                      </select>
                    </div>
                </div>
                <div class="control-group" style=" margin-bottom:10px;">
                        <label class="control-label" for="name">作业标题:</label>
                        <div class="controls">
                              <input type="text" class="form-control" name="title" placeholder="-输入标题-" style=" border-width: 1px; color: black;">
                        </div>
                  </div>
                <div class="control-group" style=" margin-bottom:10px;">
                  <label class="control-label" for="name">作业内容:</label>
                  <div class="controls">
                    <textarea name="content" rows="10" placeholder="请填写内容" class="form-control" style="width:50%; resize:none; border-width: 1px; color: black;"></textarea>
                  </div>
                </div>
                  <div class="control-group" style=" margin-bottom:10px;">
                        <label class="control-label" for="name">完成时间：</label>
                        <div class="controls">
                              <input type="text" class="sang_Calender" name="time" placeholder="-输入完成时间-" style=" border-width: 1px; color: black;">
                        </div>
                  </div>
                  <!--上传start-->
                  <div class="form-group" style=" margin-bottom:10px; margin-top:20px;">
                    <label class="col-sm-2 control-label" style=" margin-top:3px;">上传附件：</label>
                    <div  style=" width: 543px; margin-left: 175px;"><input type='hidden' name='smeta[thumb]' id='thumb2' value=''>
                       <div style=" width: 300px;">
                        <a id="pic" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb2',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=0','');return false;">

                            <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb2_preview' width='80' height='60' style='cursor:hand' />
                            </a>
                        <!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
                          <input type="button" class="btn" onclick="$('#thumb2_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic').find('img').remove(); $('#pic').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb2_preview width=80 height=60 style=cursor:hand />'); $('#thumb2').val('');return false;" value="取消图片" style=" padding:5px 8px 5px 8px; font-size:14px;">
                         </div>
                       
                    </div>
                  </div>
                  
                 <!--上传end-->
                <div class="control-group" style=" margin-top:20px;">
                        <label class="control-label" for="name">发送模式：</label>
                        <div class="controls" style="  margin-left:180px;">
                              <div class="row visible-on" style=" margin-left:0px;">
                                    <label class="checkbox-inline" style=" font-size:13px;">
                                                <input type="radio" name="send" id="optionsRadios1" checked>&nbsp;&nbsp;即时发送&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="send" id="optionsRadios2">&nbsp;&nbsp;定时发送
                                          		<input type="text" class="sang_Calender" placeholder="-输入时间-" style="width:100px; padding:0; border-width: 1px;">
                                         		 
                                    </label>
                                    <!--<label class="checkbox-inline">
                                          <input type="radio" name="send" id="optionsRadios2">&nbsp;&nbsp;定时发送
                                          <input type="text" class="sang_Calender" placeholder="-输入时间-" style="width:140px;">
                                    </label>-->
                                    
                              </div>
                              <div class="form-group">
                                    <label class="checkbox-inline" style=" font-size:13px;">
                                          <input type="checkbox" name="" value="">&nbsp;&nbsp;同时发送给自己
                                          <input type="checkbox" name="" value="" style=" margin-left:15px;">&nbsp;&nbsp;消息前增加家长称呼
                                          <input type="checkbox" name="" value="" style=" margin-left:15px;">&nbsp;&nbsp;消息内容后加老师名
                                          <input type="text" name="teachername" placeholder="-输入姓名-" style="width:74px; padding:0;width:100px; border-width: 1px;">
                                          
                                    </label>
                                    <!--<label class="checkbox-inline">
                                          <input type="radio" name="" value="">&nbsp;&nbsp;消息前增加家长称呼
                                    </label>
                                    <label class="checkbox-inline">
                                                <input type="radio" name="" value="">&nbsp;&nbsp;消息内容后加老师名
                                          <input type="text" name="teachername" placeholder="-输入姓名-" style="width:74px;">
                                    </label>-->
                                    
                              </div>
                              <div class="row visible-on" style=" margin-left:0px; ">
                                    <label class="checkbox-inline" style=" font-size:13px;">
                                    <input type="checkbox" name="" value="">&nbsp;&nbsp;微信推送<a href="https://hao.360.cn/" style="color:#ff9800;"> 如何绑定？ </a>
                                    </label>
                              </div>
                            </div>
                     </div>
                     </fieldset>
                      
                
                  <div class="form-actions" style=" margin-bottom:100px; background-color: white; margin-top:-20px;">
                              <div class="col-sm-offset-2 col-sm-10">
                              <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn" style="border:none;color:#FFF; background-color:#26a69a; margin-right:10%; padding: 5px 10px;" > 发  &nbsp;送 </button>
                              <button type="reset" class="btn btn-default" style="border:none;color:#FFF; background-color:#adadad; padding: 5px 10px;"> 重 &nbsp;置 </button>
                    </div>
                    </div>
                
            </form>
        </div>
      
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop.js"></script>
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
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
          
<script type="text/javascript"> 
$(function () {
	//setInterval(function(){public_lock_renewal();}, 10000);
	$(".J_ajax_close_btn").on('click', function (e) {
	    e.preventDefault();
	    Wind.use("artDialog", function () {
	        art.dialog({
	            id: "question",
	            icon: "question",
	            fixed: true,
	            lock: true,
	            background: "#CCCCCC",
	            opacity: 0,
	            content: "您确定需要关闭当前页面嘛？",
	            ok:function(){
					setCookie("refersh_time",1);
					window.close();
					return true;
				}
	        });
	    });
	});
	/////---------------------
	 Wind.use('validate', 'ajaxForm', 'artDialog', function () {
			//javascript
	        
	            //编辑器
	            editorcontent = new baidu.editor.ui.Editor();
	            editorcontent.render( 'content' );
	            try{editorcontent.sync();}catch(err){};
	            //增加编辑器验证规则
	            jQuery.validator.addMethod('editorcontent',function(){
	                try{editorcontent.sync();}catch(err){};
	                return editorcontent.hasContents();
	            });
	            var form = $('form.J_ajaxForms');
	        //ie处理placeholder提交问题
	        if ($.browser.msie) {
	            form.find('[placeholder]').each(function () {
	                var input = $(this);
	                if (input.val() == input.attr('placeholder')) {
	                    input.val('');
	                }
	            });
	        }
	        //表单验证开始
	        form.validate({
				//是否在获取焦点时验证
				onfocusout:false,
				//是否在敲击键盘时验证
				onkeyup:false,
				//当鼠标掉级时验证
				onclick: false,
	            //验证错误
	            showErrors: function (errorMap, errorArr) {
					//errorMap {'name':'错误信息'}
					//errorArr [{'message':'错误信息',element:({})}]
					try{
						$(errorArr[0].element).focus();
						art.dialog({
							id:'error',
							icon: 'error',
							lock: true,
							fixed: true,
							background:"#CCCCCC",
							opacity:0,
							content: errorArr[0].message,
							cancelVal: '确定',
							cancel: function(){
								$(errorArr[0].element).focus();
							}
						});
					}catch(err){
					}
	            },
	            //验证规则
	            rules: {'post[post_title]':{required:1},'post[post_content]':{editorcontent:true}},
	            //验证未通过提示消息
	            messages: {'post[post_title]':{required:'请输入标题'},'post[post_content]':{editorcontent:'内容不能为空'}},
	            //给未通过验证的元素加效果,闪烁等
	            highlight: false,
	            //是否在获取焦点时验证
	            onfocusout: false,
	            //验证通过，提交表单
	            submitHandler: function (forms) {
	                $(forms).ajaxSubmit({
	                    url: form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
	                    dataType: 'json',
	                    beforeSubmit: function (arr, $form, options) {
	                        
	                    },
	                    success: function (data, statusText, xhr, $form) {
	                        if(data.status){
								setCookie("refersh_time",1);
								//添加成功
								Wind.use("artDialog", function () {
								    art.dialog({
								        id: "succeed",
								        icon: "succeed",
								        fixed: true,
								        lock: true,
								        background: "#CCCCCC",
								        opacity: 0,
								        content: data.info,
										button:[
											{
												name: '继续添加？',
												callback:function(){
													reloadPage(window);
													return true;
												},
												focus: true
											},{
												name: '返回列表页',
												callback:function(){
													location='<?php echo U('JobManage/index');?>';
													return true;
												}
											}
										]
								    });
								});
							}else{
								isalert(data.info);
							}
	                    }
	                });
	            }
	        });
	    });
	////-------------------------
});
</script>
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
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
            <script>
            $(".touch").mouseenter(
					function(){
						$(".touch").addClass("touchlei")
						}
			)
			 $(".touch").mouseleave(
					function(){
						$(".touch").removeClass("touchlei")
						}
			)
            </script>
</body>
</html>