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
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
    <script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
    <script src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>
    <script src="/weixiaotong2016/statics/js/js/layui/lay/modules/form.js"></script>
    <link rel="stylesheet" href="/weixiaotong2016/statics/js/ztree/bootstrapStyle.css" type="text/css">
    <script type="text/javascript" src="/weixiaotong2016/statics/js/ztree/jquery.ztree.core.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/ztree/jquery.ztree.excheck.js"></script>
    <title>添加违纪</title>
</head>
<style>
    #parentTab>td>a {
        display: inline-block;
        width: 80px;
        text-align: center;
        height: 25px;
        line-height: 25px;
        background: #ccc;
        color: #fff !important;
        margin-left: 5px;
        color: #2b93db;
        text-decoration: none;
    }
    a.delType {
        display: inline-block;
        position: relative;
        top: -5px;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 18px;
        background: #dd5044;
        color: #fff;
        font-size: 16px;
        border: none;
        border-radius: 100%;
        cursor: pointer;
    }
</style>
<body>
<form class="layui-form" id="ruleForm" name="ruleForm" action="trule!save.do?t=1535079404180" style="width:100%;" method="post" enctype="multipart/form-data">
<table class="gridtable-input" style="margin-top:30px;">
    <tbody><tr>
        <td class="title-txt" style="float:right;"><span>姓名</span></td>
        <td align="left" colspan="3">
            <div class="input-text" style="width:660px; border: none;" onclick="addStu(this)">
                <input id="studentIds" name="studentIds" type="hidden" value="">
                <input id="myRuleTypes" name="myRuleTypes" type="hidden" value="">
                <input id="myMarks" name="myMarks" type="hidden" value="">
                <input id="studentNames" class="t_input" style="width:660px;height:30px;border:1px solid #A9A9A9;" name="studentNames" readonly="readonly">
            </div>
            <span style="color: red;">*</span>
        </td>
    </tr>
    <tr class="layui-form-item">
        <td class="title-txt" align="left" style="float:right;"><span>违纪时间</span>
        </td>
        <td align="left">
            <div style="float: left;">
                <input type="text" id="createDate" name="createDate" style="height: 18px; border: 1px solid #CCC;" class="Wdate" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})">
            </div>
            <span style="color: red;">*</span>
            <label class="layui-form-label" style="width:170px;">通知家长</label>
            <div class="layui-input-inline">
                <input type="checkbox" name="noteParentSwitch" checked="" lay-skin="switch" lay-filter="switch" lay-text="ON|OFF"><div class="layui-unselect layui-form-switch layui-form-onswitch" lay-skin="_switch"><em>ON</em><i></i></div>
                <input type="hidden" id="noteParentSwitch" name="noteParent" value="0">
            </div>
        </td>
    </tr>
    <tr>
        <td    class="title-txt" style="float:right;"><span>违纪类别</span></td>
        <td align="left" colspan="3">
            <div id="illegality_type" class="input-text" style="width:660px;height:35px; border: none;" >
                <input id="ruleTypeIds" name="ruleTypeIds" type="hidden" value="">
                <input id="typeNames" class="t_input" style="width:660px;height:30px;border:1px solid #A9A9A9" name="typeNames"  readonly="readonly">

                <div id="typeMenuContent" class="optionDiv" style=" display:none;position: absolute;z-index:4; background-color: white;" tabindex = "1">
                    <ul id="treeDemo" class="ztree" style="max-height:390px;overflow:auto">

                    </ul>
                </div>
                <input id="illegality_type_id" type="hidden" >
            </div>
        </td>
    </tr>
    <tr id="parentTab"><td></td><td style="color:#984242;">自定义违纪类型   ↓<a href="javascript:addTr();">+</a></td></tr>
    <tr>
        <td class="title-txt" style="float:right;"><span>违纪事件</span>
        </td>
        <td colspan="3">
            <textarea style="width:660px;height:100px;line-height:30px;" name="msg" id="msg" placeholder="200个字以内....."></textarea>
            <span style="color: red;">*</span>
        </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            <div>
                <!-- demo开始 -->
                <!--<div id="demo" style="margin-top:20px;">-->
                    <!--<div id="as" class="webuploader-container"><div class="webuploader-pick">+</div><div id="rt_rt_1clkroc7r12jr178h1al21hrlpfj1" style="position: absolute; top: 0px; left: 0px; width: 73px; height: 60px; overflow: hidden; bottom: auto; right: auto;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/jpg,image/jpeg,image/png"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>-->
                <!--</div>-->
                <!-- demo开结束-->
            </div>
        </td>
    </tr>
    <tr>
        <td class="title-txt"></td>
        <td>
            <div id="imgDiv" style="position: relative; cursor:pointer;width:160px; border:1px solid #aaa;display: none;">
                <img id="preview" src="" style="width:100%;height: 100%;" onclick="seeBigImg();">
                <img src="/StudyTeach/images/del2.png" onclick="delImg();" style="position: absolute;top: 1px;left: 143px;">
            </div>
        </td>
    </tr>
    </tbody>
</table>
</form>
</body>
</html>
<script>
    // 增加行
    function addTr(){
        $("#parentTab").after("<tr><td class='title-txt' style='float:right;'></td>\
               <td><span style='display:inline-block;float:left;font-size:14px;color:#adadad;'>违纪类别</span><input type='text' style='width:230px;height:30px;margin-left:15px;display:inline-block;float:left;box-sizing:border-box;' name='myRuleType' />\
				<span style='display:inline-block;float:left;font-size:14px;margin-left:15px;color:#adadad;'>扣分</span><div class='select_style' style='display:inline-block;width:230px;margin-left:15px;'>\
					<input name='myMark' type='number' onkeyup='checkNum(this)' step='1' min='0' max='100' maxlength='5' style='width:230px;height:30px;box-sizing: border-box;' />\
				</div>\
				<a onclick='delTr(this)' class='delType'>x</a>\
			   </td>\
               </tr>");
    }

    var setting = {
        view: {
            selectedMulti: false
        },
        check: {
            enable: true
        },
        data: {
            simpleData: {
                enable: true
            }
        },
        callback:{
            onCheck:onCheck
        }
    };

    var zNodes =[
        <?php if(is_array($illegality_type)): foreach($illegality_type as $key=>$vo): ?>{id:<?php echo ($vo["id"]); ?>, pId:0, name:"<?php echo ($vo["name"]); ?>", open:false},
            <?php if(is_array($vo[subclass])): foreach($vo[subclass] as $key=>$vos): ?>{id:<?php echo ($vos["id"]); ?>, pId:<?php echo ($vos["parent"]); ?>, name:"<?php echo ($vos["name"]); ?>"},<?php endforeach; endif; endforeach; endif; ?>

    ];
   console.log(zNodes);
    $(document).ready(function(){
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    });

    var newCount = 1;
    function addHoverDom(treeId, treeNode) {
        var sObj = $("#" + treeNode.tId + "_span");
        if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;
        var addStr = "<span class='button add' id='addBtn_" + treeNode.tId
            + "' title='add node' onfocus='this.blur();'></span>";
        sObj.after(addStr);
        var btn = $("#addBtn_"+treeNode.tId);
        if (btn) btn.bind("click", function(){
            var zTree = $.fn.zTree.getZTreeObj("treeDemo");
            zTree.addNodes(treeNode, {id:(100 + newCount), pId:treeNode.id, name:"new node" + (newCount++)});
            return false;
        });
    };
    function onCheck(e,treeId,treeNode){

        var treeObj=$.fn.zTree.getZTreeObj("treeDemo"),
            nodes=treeObj.getCheckedNodes(true),
            v="";
        for(var i=0;i<nodes.length;i++){
            v+=nodes[i].name + ",";

            alert(nodes[i].id); //获取选中节点的值
        }
        console.log(nodes);
        console.log(v);
    }







    $("#illegality_type").click(function(){
             $("#typeMenuContent").show()
             $("#typeMenuContent").focus();
    });

//    $("#typeMenuContent").blur(function(){
//        $(this).hide()
//// $(this)
//    });
//
//    function c(e) {
//        if (e && e.preventDefault) {
//            e.preventDefault();
//        } else {
//            window.event.returnValue = false;
//        }
//
//    }

//    document.getElementById('illegality_type').onblur = function(){
//        $("#typeMenuContent").hide();
//    };


//

</script>