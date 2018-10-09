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

	.chzn-container-single .chzn-single {
		position: relative;
		top: 12px;
		height: 29px;
	}
</style>
<body class="J_scroll_fixed">
	<div class="wrap jj">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('DeviceManage/index');?>">所有设备</a></li>
			 <li class="active"><a href="<?php echo U('DeviceManage/add');?>">添加设备</a></li>
		</ul>
		<div class="common-form">
			<form method="post" class="form-horizontal J_ajaxForm" action="<?php echo U('DeviceManage/add_post');?>">   <!-- 完成该功能再加入J_ajaxForm-->
				<fieldset>
					<div class="control-group">
						<label class="control-label">省级选择:</label>
						<div class="controls">
							<select  class="province"  name="province" id="province">
								<option value="">省级选择</option>
								<?php if(is_array($Province)): foreach($Province as $key=>$vo): ?><option value="<?php echo ($vo["term_id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">市级选择:</label>
						<div class="controls">
							<select name="city" class="citys"   id="citys" >
								<option value="">市级选择</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">请选择区域:</label>
						<div class="controls">
							<select name="city_next" class="select_3"  id="message_type" >
								<option value="">请选择区域</option>

							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">所属学校:</label>
						<div class="controls">
							<select data-placeholder="输入关键字。。。" id="viewOLanguage" class="chzn-select"  tabindex="2" name="school_id">
								<option value=""></option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">是否为双平台:</label>
						<div class="controls">
							<input type="radio" class="is_twin" name="is_twin" value="2" >是
							<input type="radio" class="is_twin" name="is_twin" value="1"  checked>否
						</div>
					</div>
					<div class="control-group devive_num"  style="display: none;">
						<label class="control-label">设备编号:</label>
						<div class="controls">
							<input type="text" class="input" name="deviceId" value="">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">公话号码:</label>
						<div class="controls">
							<input type="text" class="input" name="phone" value="">
						</div>
					</div>
					<div class="control-group">
	                    <label class="control-label">是否语音话机:</label>
	                    <div class="controls">
							<input type="radio" name="voice" value="1" checked>是
							<input type="radio" name="voice" value="0"  >否
	                    </div>
                	</div>
					<div class="control-group">
						<label class="control-label">SN:</label>
						<div class="controls">
							<input type="text" class="input" name="sn" value="">
							<span class="must_red">*</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">设备类型:</label>
						<div class="controls">
							<input type="radio" name="type" value="3" checked>通道闸
							<input type="radio" name="type" value="4" >人脸加刷卡
							<input type="radio" name="type" value="1" >大屏机
							<input type="radio" name="type" value="2"  >电话
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">开通状态:</label>
						<div class="controls">
							<input type="radio" name="status" value="1" checked>是
							<input type="radio" name="status" value="0"  > 否
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">IMEI:</label>
						<div class="controls">
							<input type="text" class="input" name="IMEI" value="">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">是否纳入监控:</label>
						<div class="controls">
							<input type="radio" name="control" value="1" checked>是
							<input type="radio" name="control" value="0"  > 否
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">协议/供应商:</label>
						<div class="controls">
	                        <select id="agreement" name="agreement" class="normal_select">
	                            <OPTION value="0">请选择协议</OPTION> 
	                            <?php if(is_array($agreements)): $i = 0; $__LIST__ = $agreements;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$agreement): $mod = ($i % 2 );++$i;?><OPTION value="<?php echo ($agreement["id"]); ?>"><?php echo ($agreement["name"]); ?>.<?php echo ($agreement["url"]); ?></OPTION><?php endforeach; endif; else: echo "" ;endif; ?>
	                        </select>
	                    </div>
					</div>
 					<!--<div class="control-group">-->
						<!--<label class="control-label">校讯通协议/供应商:</label>-->
						<!--<div class="controls">-->
	                        <!--<select id="agreement" name="xxt_agreement" class="normal_select">-->
	                            <!--<OPTION value="0">请选择协议</OPTION>-->

	                            <!--<OPTION value="鑫诺协议(IP:211.140.3.31端口:12122)" >鑫诺协议(IP:211.140.3.31 端口:12122)</OPTION>-->
	                            <!--<OPTION value="天波协议(IP:211.140.3.31端口:12121)">天波协议(IP:211.140.3.31 端口:12121)</OPTION> -->
	                            <!--<OPTION value="浙江和教育终端接口协议_标准版(IP:211.140.3.31端口:12124)">浙江和教育终端接口协议_标准版(IP:211.140.3.31 端口:12124)</OPTION> -->
	                          <!---->
	                        <!--</select>-->
	                    <!--</div>-->
					<!--</div>                   -->
                    <!--<div class="control-group">-->
						<!--<label class="control-label">校讯通开通状态:</label>-->
						<!--<div class="controls">-->
							<!--<input type="radio" name="xxt_status" value="1" checked>是-->
							<!--<input type="radio" name="xxt_status" value="0"  > 否-->
						<!--</div>-->
					<!--</div>-->

					<!--<div class="control-group">-->
						<!--<label class="control-label">校讯通SN:</label>-->
						<!--<div class="controls">-->
							<!--<input type="text" class="input" name="xxt_sn" value="">-->
							<!--<span class="must_red">*</span>-->
						<!--</div>-->
					<!--</div>-->

					<!--<div class="control-group">-->
						<!--<label class="control-label">校讯通IMEI:</label>-->
						<!--<div class="controls">-->
							<!--<input type="text" class="input" name="xxt_IMEI" value="">-->
						<!--</div>-->
					<!--</div>-->

					<div class="control-group">
						<label class="control-label">备注:</label>
						<div class="controls">
							<input type="text" class="input" name="remark" value="" style="height: 200px;text-align: match-parent">
						</div>
					</div>
				</fieldset>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary J_ajax_submit_btn">添加</button><!-- btn_submit J_ajax_submit_btn  完成该功能在添加-->
					<a class="btn" href="/weixiaotong2016/index.php/Admin/DeviceManage">返回</a>
				</div>
			</form>
		</div>
	</div>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
	<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>
	<script>

		$(".is_twin").click(function(){
		    var is_val = $(this).val();

		    if(is_val == 2)
			{
              $(".devive_num").show();
			}else{
                $(".devive_num").hide();
			}



		})


        $(function () { $("[data-toggle='tooltip']").tooltip(); });
        //选择市级的下拉的ajax
//        $(".citys").click(function(){
//            $(".jiu").hide();
//            var Province =$(".province option:selected").val();
//            if(Province==""){
//                alert("请选择你要搜索的省")
//            }else{
//                $.ajax({
//                    type:"post",
//                    url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=Provinces',
//                    async:true,
//                    data:{
//                        Province:Province
//                    },
//                    dataType: 'json',
//                    success: function(res) {
//                        var html = "";
//                        res = eval(res.data);
//                        for(var i = 0; i < res.length; i++) {
//                            var name=res[i].name;//地区的名字；
//                            var term_id=res[i].term_id;//地区的ID
//                            html+='<option class="jiu"value="'+term_id+'">'+name+' </option> '
//                        }
//                        $(".citys").append(html);
//                    },
//                    error: function() {
//                        console.log('系统错误,请稍后重试');
//                    }
//                });
//            }
//
//        })
        //选择县级市
//        $(".message_type").click(function(){
//            $(".jius").hide()
//            var zhi= $(".citys option:selected").val();
//            if(zhi==""){
//                alert("请选你要搜索的市")
//            }else{
//                $.ajax({
//                    type:"post",
//                    url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=Provinces',
//                    async:true,
//                    data:{
//                        Province:zhi
//                    },
//                    dataType: 'json',
//                    success: function(res) {
//                        var html = "";
//                        res = eval(res.data);
//                        for(var i = 0; i < res.length; i++) {
//                            var name=res[i].name;//地区的名字；
//                            var term_id=res[i].term_id;//地区的ID
//                            html+='<option class="jius"value="'+term_id+'">'+name+' </option> '
//                        }
//                        $(".message_type").append(html)
//                    },
//                    error: function() {
//                        console.log('系统错误,请稍后重试');
//                    }
//                });
//            }
//
//        })
        $("#viewOLanguage").chosen();
        $("#viewOLanguage").trigger("liszt:updated");

//        $(".message_type").change(function(){
//
//            var type = $(".message_type  option:selected").val();
//            console.log(type);
//            $.ajax({
//                type:"post",
//                url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=lookup',
//                async:true,
//                data:{
//                    type:type
//                },
//                dataType: 'json',
//                success: function(res) {
//                    $(".Sio").text("")
//                    var html = "";
//                    res = eval(res.data);
//                    for(var i = 0; i < res.length; i++) {
//                        var school_name=res[i].school_name;//学校的名字
//                        var schoolid=res[i].schoolid;//学校的ID
//                        html+='<option name="school" class="Sio" value="'+schoolid+'">'+school_name+' </option> '
//                    }
//                    $(".chzn-select").append(html)
//                    $("#viewOLanguage").chosen();
//                    $("#viewOLanguage").trigger("liszt:updated");
//                },
//                error: function() {
//                    console.log('系统错误,请稍后重试');
//                }
//            });
//        })

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

	</script>
</body>
</html>