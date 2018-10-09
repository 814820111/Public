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
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta http-equiv="x-ua-compatible" content="IE=8;IE=9;IE=10">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
    <script src="js/fileinput.js" type="text/javascript"></script>
    <script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
    <link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
    <script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/common.js"></script>
    <title>违纪类型管理页面</title>
    <script>
        $("document").ready(function() {
            // 默认选中第一个
            sel($(".ruleTypeDiv .level_one .levelOne:eq(0)").parent(), "1");
        });

        // 添加样式
        function addStyle (obj) {
            $(obj).siblings().removeClass("sel");
            $(obj).addClass("sel");
        }

        // 查询子分类
        function sel(obj,type) {

            $(obj).siblings().removeClass("sel");
            $(obj).addClass("sel");
            var pId = $(obj).find("input").val();

            $.ajax({
                url :"<?php echo U('Teacher/Illegality/Illegality_subclass');?>",
                type: "post",
                dataType : "json",
                data:{
                    pId : pId,
                },
                success: function(data) {
                    if (data.status == "success") {
                        var childList = data.data;
                        var titleName = "二级分类";
                        var childHtml = "<ul style='padding: 0px;margin: 0px;'>";
                        childHtml += "<li class='title'><img class='add' onclick='addRuleType("+pId+","+type+")' src='/weixiaotong2016/statics/images/add2.png'/>"+titleName+"</li>";

                        var markHtml = "<ul style='padding: 0px;margin: 0px;'><li class='title'>分值</li>";
                        for(var i=0; i<childList.length; i++) {
                            childHtml += "<li onclick='addStyle(this)'><input type='hidden' id='mid' value="+childList[i].mid+"><img class='delImg' onclick='delRuleType(this,"+childList[i].id+")' src='/weixiaotong2016/statics/images/del2.png'/><span>"+childList[i].name+"</span><input type='hidden' value='"+childList[i].id+"'/>";
                            childHtml += "<img class='editImg' onclick='editRuleType(this,"+childList[i].id+")' src='/weixiaotong2016/statics/images/icon_date.png'/></li>";
                            markHtml += "<li> <span>"+childList[i].mark+"</span><input type='hidden' value='"+childList[i].mark+"'/>";
                            markHtml += "<img class='editImg' onclick='editMark(this,"+childList[i].id+")' src='/weixiaotong2016/statics/images/icon_date.png'/></li>";
                        }

                        $(".level_two").html(childHtml);
                        $(".level_three").html(markHtml);
                    } else {
                        alert("服务器繁忙");
                    }
                }
            });
        }

        // 增加分类
        function addRuleType(pId, type) {

            $("._Draghandle_0").show();
            if(type!=0)
            {
               $("#education").css("display","block");
            }else{
                $("#education").css("display","none");
            }

            $(".pid").val(pId);
            $("#is_type").val(type);
            $(".illegality_type").show();
            $(".edit_illegality_type").hide();
//            var belongId = "";
//            if (type == "0") {
//                belongId = pId;
//            } else if (type == "1") {
//                belongId = $(".level_one .sel .levelOne").val();
//            }
//            var url = '/StudyTeach/page/rule/ruleTypeAdd.jsp?pId='+pId+'&depth='+type+'&belongId='+belongId+'&t='+new Date().getTime();
//
//            var OKEvent = function() {
//                diag.close();
//                if (type == "0") {
//                    window.location.reload();
//                } else if (type == "1") {
//                    $(".level_one .sel").click();
//                }
//            };
//            openWin(diag,url,"添加违纪项",400,200,OKEvent,null);
        }




        $(document).on('click', '.dao_close', function() {

            $("._Draghandle_0").hide();
        });
        $(document).on('click', '.mark_close', function() {

            $("._Draghandle_1").hide();
        });

        $(document).on('click', '.illegality_type', function() {
              if(!$("#illegality_name").val())
              {
                  alert("名称不能为空!");
                  return false;
              }
            $.ajax({
                type: "post",
                async: false,
                url: "<?php echo U('Teacher/Illegality/type_add');?>",
                dataType: 'json',
                data: {
                   'pid':$(".pid").val(),
                   'illegality_name':$("#illegality_name").val(),
                    'education':$("#education").val(),
                },
                success: function(data) {
                    if(data.status)
                    {
                        if($("#is_type").val()==1)
                        {
                            $(".level_two").find("ul").append('<li onclick="addStyle(this)"><img class="delImg" onclick="delRuleType(this,'+data.data+')" src="/weixiaotong2016/statics/images/del2.png"><span>'+$("#illegality_name").val()+'</span><input type="hidden" value='+data.data+'><img class="editImg" onclick="editRuleType(this,'+data.data+')" src="/weixiaotong2016/statics/images/icon_date.png"></li>');
                        }else{
                            $(".level_one").find("ul").append('<li onclick="sel(this,'+data.data+')" class="sel"><img class="delImg" onclick="delRuleType(this, '+data.data+')" src="/weixiaotong2016/statics/images/del2.png"> <span>'+$("#illegality_name").val()+'</span> <input type="hidden" class="levelOne" value='+data.data+'> <img class="editImg" onclick="editRuleType(this, '+data.data+')" src="/weixiaotong2016/statics/images/icon_date.png"> </li>');
                        }
                        $("._Draghandle_0").hide();
                        $("#illegality_name").val("");
                    }else{
                        alert(data.msg);
                        return false;
                    }

                }
            });


        })
        // 删除分类
        function delRuleType(obj,id) {
            if (confirm("删除该项的同时也会将子项全部删除，确定要删除?")) {

                $.ajax({
                    type: "post",
                    async: false,
                    url: "<?php echo U('Teacher/Illegality/type_del');?>",
                    dataType: 'json',
                    data: {
                        'id':id

                    },
                    success: function(data) {
                        if(data.status=="success")
                        {
                            $(obj).parent().remove();
                            $(".level_one .sel").click();
                        }else{
                            alert(data.msg);
                            return false;
                        }

                    }
                });



            }
        }

        // 编辑分类
        function editRuleType(obj, id) {

            $("._Draghandle_0").show();
            $("#illegality_name").val($(obj).prev().prev().text());

            var parent = $(obj).parent().parent().parent().attr("class");
            if(parent=="level_one")
            {
                $("#education").css("display","none");
            }else{
                $(".select_2").val($(obj).parent().find("#mid").val())
                $("#education").css("display","block");
            }
           $(".illegality_type").css("display","none");
           $(".edit_illegality_type").show();

           $(".edit_illegality_type").attr("onclick","edit("+id+")");

           edit_obj = obj;

        }

        function edit(id)
        {
            $.ajax({
                type: "post",
                async: false,
                url: "<?php echo U('Teacher/Illegality/type_edit');?>",
                dataType: 'json',
                data: {
                    'id':id,
                    'name':$("#illegality_name").val(),
                    'education':$("#education").val(),
                },
                success: function(data) {
                    if(data.status=="success")
                    {

                        $(edit_obj).prev().prev().text($("#illegality_name").val());
                        $("._Draghandle_0").hide();
                        $("#illegality_name").val("");
                    }else{
                        alert(data.msg);
                        return false;
                    }

                }
            });

        }

        // 编辑分值
        function editMark(obj, id) {
           $("._Draghandle_1").show();

            $(".edit_mark").attr("onclick","edit_mark("+id+")");
            $("#mark_num").val($(obj).prev().prev().text());
            mark_obj = obj;
        }

        function edit_mark(id)
        {
            mark_num = $("#mark_num").val();

            $.ajax({
                type: "post",
                async: false,
                url: "<?php echo U('Teacher/Illegality/mark_edit');?>",
                dataType: 'json',
                data: {
                    'id':id,
                    'mark_num':mark_num
                },
                success: function(data) {
                    if(data.status=="success")
                    {
                        $(mark_obj).prev().prev().text(mark_num);
                        $("._Draghandle_1").hide();
                    }else{
                        alert(data.msg);
                        return false;
                    }

                }
            });
        }

    </script>
    <style>
        html,body{width:100%;padding:0;margin:0;}
        .ruleTypeDiv{margin:10px 20px; font-size:14px;}
        .ruleTypeDiv .level_one{width:15%;height:800px;border-right:1px solid #8A8A84; float:left;}
        .ruleTypeDiv .level_two{width:65%;height:800px;border-right:1px solid #8A8A84; float:left;}
        .ruleTypeDiv .level_three{width:10%;height:800px;float:left;}
        .ruleTypeDiv .delImg{float:left; line-height:40px; margin-top:10px; padding-left:10px;}
        .ruleTypeDiv .editImg{float:right;width:16px;line-height:40px; margin-top:10px;margin-right:10px;}
        .ruleTypeDiv .add{float:left; line-height:40px; margin-top:10px; padding-left:10px;}
        .ruleTypeDiv .level_one ul,.ruleTypeDiv .level_two ul{list-style-type:none;text-align:center;}
        .ruleTypeDiv .level_three ul{list-style-type:none;text-align:center;}
        .ruleTypeDiv .level_three img{margin-left:10px;margin-right:20px;}
        .ruleTypeDiv ul li{line-height:40px;height:40px;border-bottom:1px solid #8A8A84;overflow:auto;}
        .ruleTypeDiv .title{background-color: #95CACA; color:white;}
        .ruleTypeDiv .sel{background-color: #FFF8BF; color: #91AFFF;}
        .ruleTypeDiv .innerli{width:100%;}
        .ruleTypeDiv .add{width:20px;}
    </style>
</head>
<body>
<div style="background-color: rgba(0, 0, 0, 0.7); z-index: 999; width: 100%; height: 100%; position: absolute; display:none;" class="_Draghandle_0">
    <form style=" width:400px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">

        <div>
            <div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">添加违纪项 </div>
            <div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
        </div>

        <form id="form1" >
        <div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">
            <input class="pid" name="pid" type="hidden" >
            <!--<input class="pid" type="hidden" >-->
             <input type="hidden" id="is_type">
            <div>
                <input type="text" id="illegality_name" name="illegality_name" placeholder="名称" style="border: 1px solid rgb(220, 228, 236);"><br>

                    <select class="select_2" name="education" id="education" style="display: none;">
                        <?php if(is_array($education_type)): foreach($education_type as $key=>$so): ?><option value="<?php echo ($so["id"]); ?>"><?php echo ($so["name"]); ?></option><?php endforeach; endif; ?>

                    </select><br>





                <!--     <form  action="/weixiaotong2016/index.php/Teacher/ClassAlbum/ImpUser" method="post" enctype="multipart/form-data"> -->


                <a  class="btn btn-info illegality_type">保存</a>
                <a  class="btn btn-info edit_illegality_type" style="display: none;">保存</a>
                <a class="btn btn-danger dao_close">取消</a>

                <!-- </form> -->
                <p></p>
            </div>
        </div>

        </form>

        <div style=" margin-bottom:10px; margin-left:30px;">
            <span class="Sui"></span>
        </div>
        <!-- <div style=" margin-bottom:10px; margin-left:30px;">
        确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
    </div> -->
        <div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">


        </div>

        <!--关闭start-->
        <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="dao_close">
        <!--关闭end-->
    </div>
</div>

<div style="background-color: rgba(0, 0, 0, 0.7); z-index: 999; width: 100%; height: 100%; position: absolute; display:none;" class="_Draghandle_1">
    <form style=" width:400px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">

        <div>
            <div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">修改分值</div>
            <div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
        </div>

        <form id="form1" >
            <div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">
                <input class="pid" name="pid" type="hidden" >
                <!--<input class="pid" type="hidden" >-->
                <div>
                    <input type="text" id="mark_num" name="mark_num" placeholder="分值" style="border: 1px solid rgb(220, 228, 236);"><br>
                    <!--     <form  action="/weixiaotong2016/index.php/Teacher/ClassAlbum/ImpUser" method="post" enctype="multipart/form-data"> -->


                    <a  class="btn btn-info edit_mark">保存</a>
                    <a class="btn btn-danger mark_close">取消</a>
                    <!-- </form> -->
                    <p></p>
                </div>
            </div>

        </form>

        <div style=" margin-bottom:10px; margin-left:30px;">
            <span class="Sui"></span>
        </div>
        <!-- <div style=" margin-bottom:10px; margin-left:30px;">
        确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
    </div> -->
        <div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">


        </div>

        <!--关闭start-->
        <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="dao_close">
        <!--关闭end-->
</div>
</div>

<!--<div style="background-color: rgba(0, 0, 0, 0.7); z-index: 999; width: 100%; height: 100%; position: absolute; display:none;" class="_Draghandle_1">-->
    <!--<form style=" width:400px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">-->

        <!--<div>-->
            <!--<div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">修改违纪项 </div>-->
            <!--<div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>-->
        <!--</div>-->

        <!--<form id="form1" >-->
            <!--<div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">-->
                <!--<input class="pid" name="pid" type="hidden" >-->
                <!--&lt;!&ndash;<input class="pid" type="hidden" >&ndash;&gt;-->
                <!--<input type="hidden" id="is_type">-->
                <!--<div>-->
                    <!--<input type="text" id="illegality_name" name="illegality_name" placeholder="名称" style="border: 1px solid rgb(220, 228, 236);"><br>-->

                    <!--<select class="select_2" name="education" id="education" style="display: none;">-->
                        <!--<?php if(is_array($education_type)): foreach($education_type as $key=>$so): ?>-->
                            <!--<option value="<?php echo ($so["id"]); ?>"><?php echo ($so["name"]); ?></option>-->
                        <!--<?php endforeach; endif; ?>-->

                    <!--</select><br>-->





                    <!--&lt;!&ndash;     <form  action="/weixiaotong2016/index.php/Teacher/ClassAlbum/ImpUser" method="post" enctype="multipart/form-data"> &ndash;&gt;-->


                    <!--<a  class="btn btn-info illegality_type">保存</a>-->
                    <!--<a class="btn btn-danger dao_close">取消</a>-->

                    <!--&lt;!&ndash; </form> &ndash;&gt;-->
                    <!--<p></p>-->
                <!--</div>-->
            <!--</div>-->

        <!--</form>-->

        <!--<div style=" margin-bottom:10px; margin-left:30px;">-->
            <!--<span class="Sui"></span>-->
        <!--</div>-->
        <!--&lt;!&ndash; <div style=" margin-bottom:10px; margin-left:30px;">-->
        <!--确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">-->
    <!--</div> &ndash;&gt;-->
        <!--<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">-->


        <!--</div>-->

        <!--&lt;!&ndash;关闭start&ndash;&gt;-->
        <!--<img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="dao_close">-->
        <!--&lt;!&ndash;关闭end&ndash;&gt;-->
<!--</div>-->
<!--</div>-->

</div>
<div class="ruleTypeDiv">
    <div class="level_one">
        <ul style="margin:0px;padding: 0px; ">
            <li class="title"><img class="add" onclick="addRuleType('', '0')" src="/weixiaotong2016/statics/images/add2.png">违纪分类</li>
            <?php if(is_array($Illegality_type)): foreach($Illegality_type as $key=>$vo): ?><li onclick="sel(this,<?php echo ($vo["id"]); ?>)" >
                    <img class="delImg" onclick="delRuleType(this, <?php echo ($vo["id"]); ?>)" src="/weixiaotong2016/statics/images/del2.png">
                    <span><?php echo ($vo["name"]); ?></span>
                    <input type="hidden" class="levelOne" value="<?php echo ($vo["id"]); ?>">
                    <img class="editImg" onclick="editRuleType(this, <?php echo ($vo["id"]); ?>)" src="/weixiaotong2016/statics/images/icon_date.png">
                </li><?php endforeach; endif; ?>

            <!--<li onclick="sel(this, '1')">-->
                <!--<img class="delImg" onclick="delRuleType(this, '843')" src="/StudyTeach/images/del2.png">-->
                <!--<span>卫生 </span>-->
                <!--<input type="hidden" class="levelOne" value="843">-->
                <!--<img class="editImg" onclick="editRuleType(this, '843')" src="/StudyTeach/images/icon_date.png">-->
            <!--</li>-->


        </ul>
    </div>
    <div class="level_two"><ul style="padding: 0px; margin: 0px;"  >
        <li class="title"><img class="add" onclick="addRuleType(838,1)" src="/weixiaotong2016/statics/images/add2.png">二级分类</li>
        <?php if(is_array($Subclass)): foreach($Subclass as $key=>$co): ?><li onclick="addStyle(this)">
                <img class="delImg" onclick="delRuleType(this,839)" src="/weixiaotong2016/statics/images/del2.png">
                <span><?php echo ($co["name"]); ?></span>
                <input type="hidden" value="839">
                <img class="editImg" onclick="editRuleType(this,839)" src="/weixiaotong2016/statics/images/icon_date.png">
            </li><?php endforeach; endif; ?>
        <!--<li onclick="addStyle(this)" class="sel">-->
            <!--<img class="delImg" onclick="delRuleType(this,840)" src="/StudyTeach/images/del2.png">-->
            <!--<span>违反进退场纪律</span>-->
            <!--<input type="hidden" value="840">-->
            <!--<img class="editImg" onclick="editRuleType(this,840)" src="/StudyTeach/images/icon_date.png">-->
        <!--</li>-->
        <!--<li onclick="addStyle(this)">-->
            <!--<img class="delImg" onclick="delRuleType(this,841)" src="/StudyTeach/images/del2.png">-->
            <!--<span>违反广播操纪律</span>-->
            <!--<input type="hidden" value="841">-->
            <!--<img class="editImg" onclick="editRuleType(this,841)" src="/StudyTeach/images/icon_date.png">-->
       <!--</li>-->
     </ul>
    </div>
    <div class="level_three"><ul style="padding: 0px; margin: 0px;" >

        <li class="title">分值</li>

        <?php if(is_array($Subclass)): foreach($Subclass as $key=>$co): ?><li>
                <span><?php echo ($co["mark"]); ?></span>
                <input type="hidden" value="2">
                <img class="editImg" onclick="editMark(this,840)" src="/weixiaotong2016/statics/images/icon_date.png">
            </li><?php endforeach; endif; ?>

       </ul>
    </div>
</div>

</body></html>