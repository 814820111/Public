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
	.wraps{  
width: 250px;  
white-space: nowrap;  
text-overflow: ellipsis;  
overflow: hidden; 

}
    .h-input-box div{
        display: inline-block;
    }
    .h-input-box1 div{
        display: inline-block;
    }
    .h-input-box input{
        margin: 0;
    }
    .h-input-box label{
        display: inline-block;
    }
    .h-input input{
        width: 100px;
    }
    .h-input-box-div{
        margin-bottom: 10px;
    }
</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo U('index');?>">学校列表</a></li>
        <li class="active"><a href='<?php echo U("classmanage",array("schoolid"=>$schoolid,"schoolname"=>$schoolname));?>'>班级管理</a></li>
        <li><a href='<?php echo U("addclass",array("schoolid"=>$schoolid,"schoolname"=>$schoolname));?>'>添加班级</a></li>
        <li ><a href='<?php echo U("interestclass",array("schoolid"=>$schoolid,"schoolname"=>$schoolname));?>'>兴趣班管理</a></li>

    </ul>
    <p>学校：<?php echo ($schoolname); ?></p>
    <form class="J_ajaxForm" action="<?php echo U('SchoolManage/listorders');?>" method="post">
        <div class="table-actions">
            <button class="btn btn_submit btn-primary btn-small J_ajax_submit_btn" type="submit">排序</button>

            <a class="btn btn_submit btn-primary btn-small J_ajax_submit_btn BatchClass" >批量升班</a>
            <a class="btn btn_submit btn-primary btn-small J_ajax_submit_btn GardeBatchClass" >年级段升班</a>
        </div>
        <!--年级升班strat-->

        <div class="modal fade" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                        <button type="button" class="close dkgb" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <!--存放老师id-->
                        <!--存放班级改变时候的班级ID-->

                        <div style=" cursor: pointer;">
                            <ul class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
                                <li class="active " id="daibananiu">
                                    <a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">年级升班管理</a>
                                    &nbsp;<span style="color: red;">*该页面只能调整正规班级</span>
                                </li>

                            </ul>

                        </div>

                    </div>

                        <div class="modal-body">

                            <div class="hide" style="display: block;text-align: center;">
                                <form action=""></form>
                                <form  id="edit_grade" action="111" >
                                    <div class="h-input-box1">
                                        <div class=h-input-box-div1>
                                            <div>将年级名称：</div>
                                            <div class=h-input>
                                                <select style="margin-bottom: 0;width: 140px;" name="gradeid">
                                                    <option>请选择年级段</option>
                                                    <?php if(is_array($school_grade)): foreach($school_grade as $key=>$vo): ?><option value="<?php echo ($vo["gradeid"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                                                </select>
                                           </div>
                                            <div>改为：</div>
                                            <div class=h-input>
                                            <input type=text name=up_grade >
                                        </div>

                                            <div>
                                            <div>

                                        </div>
                                            <div>

                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                    <input name="schoolid" class="schoolid" type="hidden" value="<?php echo ($schoolid); ?>">
                                </form>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary tjgrade" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" \>提交更新</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                        </div>


                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal -->
        </div>

        <!--年级升班end-->

        <!--年级升班strat-->

        <div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                        <button type="button" class="close dkgb" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <!--存放老师id-->
                        <!--存放班级改变时候的班级ID-->

                        <div style=" cursor: pointer;">
                            <ul class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
                                <li class="active " id="daibananiu">
                                    <a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">升班管理</a>
                                    &nbsp;<span style="color: red;">*该页面只能调整正规班级</span>
                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="modal-body">

                        <div class="hide" style="display: block;text-align: center;">
                            <form action=""></form>
                            <form  id="edit_class" action="111" >
                                <div class="h-input-box">

                                </div>
                                <input name="schoolid" class="schoolid" type="hidden" value="<?php echo ($schoolid); ?>">
                            </form>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary tjclass" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" \>提交更新</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
                    </div>


                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal -->
        </div>

        <!--年级升班end-->

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th ><input type='checkbox' id='checkAll' name="checkAll">选择</th>
            <th width="80">排序</th>
            <th width="50">班级ID</th>
            <th>年級段</th>
            <th>班级名称</th>
            <th>班级类型</th>
            <th>班级人数</th>
            <th>班主任</th>
            <th>联系电话</th>
            <th>任课老师</th>
            <th>创建时间</th>
            <th width="120">管理操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($classinfo)): foreach($classinfo as $key=>$vo): ?><tr>
                <td><input id="checkAll" class="J_check"  name="ids" type="checkbox" value="<?php echo ($vo["id"]); ?>"></td>
                <td ><span class="expander"></span><input  style="    margin-bottom: 0px; padding: 3px;width: 40px;" name="listorders[<?php echo ($vo["id"]); ?>]" type="text" size="3" value="<?php echo ($vo["listorder"]); ?>" class="input input-order"></td>
                <td><?php echo ($vo["id"]); ?></td>
                <td><?php echo ($vo["gradename"]); ?></td>
                <td><?php echo ($vo["classname"]); ?></td>
                <td>
                  <?php if($vo["type"] == 1): ?>正规班
                   <?php else: ?>
                   兴趣班<?php endif; ?>
                </td>
                <td><?php echo ($vo["stu_count"]); ?></td>
                <td>
                    <?php if(is_array($vo['admininfo'])): foreach($vo['admininfo'] as $key=>$le): ?><ul>
                        <?php echo ($le["name"]); ?>
                      </ul><?php endforeach; endif; ?>
                </td>
                 <td>
                 	
                    <?php if(is_array($vo['admininfo'])): foreach($vo['admininfo'] as $key=>$le): ?><ul>
                        <?php echo ($le["phone"]); ?>
                      </ul><?php endforeach; endif; ?>
                    
                </td >
                <td >
                	<div class="wraps"  data-toggle="tooltip" data-placement="right" title="<?php echo ($vo["teacherinfo"]); ?>">
                      	 <span class="siu"><?php echo ($vo["teacherinfo"]); ?></span>
                    </div>
                </td>
                <td><?php echo date('Y-m-d',$vo['create_time']); ?></td>
                <td>
                    <a href='<?php echo U("classchange",array("id"=>$vo["id"],"schoolid"=>$schoolid));?>'>修改</a> |
                    <a class="J_ajax_del" href="<?php echo U('class_delect',array('id'=>$vo['id']));?>">删除</a>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    </form>
    <div class="pagination"><?php echo ($page); ?></div>
</div>

 
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script>
    $(function() {
        $("#checkAll").click(function() {
            $('input[class="J_check"]').prop("checked", $(this).prop("checked"));
        });
        var $J_check = $("input[class='J_check']");
        $J_check.click(function(){
            $("#checkAll").prop("checked",$J_check.length == $("input[class='J_check']:checked").length ? true : false);
        });
    });


      $(".GardeBatchClass").click(function(){
          $("#myModal6").modal("show");


      })

		$(function () { $("[data-toggle='tooltip']").tooltip(); });

		$(".BatchClass").click(function(){
            if (confirm("确定要升班吗？")) {

                var id = document.getElementsByName('ids');

                var ids = new Array();
                //将所有选中复选框的默认值写入到id数组中
                for (var i = 0; i < id.length; i++) {
                    if (id[i].checked){
                        ids.push(id[i].value);
                    }
                }
               if(ids=="")
               {
                alert("请选择班级！");
                return false;
               }
                show_class(ids);
//                $("#myModal5").modal("show");

            }
        })

    function show_class(classid)
    {
        $(".h-input-box").find(".h-input-box-div").remove();
        $.ajax({
            type: "get",
            // async: false,
            url: "<?php echo U('show_class');?>",
            dataType:'json',
            data: {
                'classid': classid,
            },
            success: function(res) {
                if(res.status=="success")
                {
                    var class_data = res.data;
                    $("#myModal5").modal("show");
                    html = "";

                    for(var i = 0; i < class_data.length; i++)
                    {
                        html+=" <div class=h-input-box-div> <div>将班级：</div><div class=h-input><input type=text value="+class_data[i]['classname']+" disabled='disabled'  ><input type=hidden name=classid[] value="+class_data[i]['id']+"></div> <div>改为：</div> <div class=h-input><input type=text name=up_class[] ></div><div>是否激活：</div> <div> <div> <input type=radio name=jihuo id=yes><label for=yes >是</label> </div> <div> <input type=radio name=jihuo id=no><label for=no>否</label> </div> </div> </div>";
                    }
                    $(".h-input-box").append(html);
                }else{
                   alert("没有班级");
                   return false;

                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });

    }

    $(".tjclass").click(function(){

        var up_class = true;
        $("input[name='up_class[]']").each(function(){
            if(!$(this).val())
            {
                up_class = false;
                return false;
            }
        })

        if(!up_class)
        {
            alert("请将目标班级填写完整!");
            return false;
        }

        var div_main = $(".h-input-box-div");
        for(var i = 0; i<div_main.length; i++)
        {
          if(div_main.eq(i).find("input").eq(0).val()==div_main.eq(i).find("input").eq(2).val())
          {
             alert("起始班级不能与目标班级相同!");
             return false;
          }
        }

        var schoolid = <?php echo ($schoolid); ?>;

            $.ajax({
                type: "get",
                async: false,
                dataType: 'json',
                url: "<?php echo U('edit_up_class');?>",
                data:$("#edit_class").serialize(),

                success: function(res) {
                    if(res.status=="success")
                    {
                        alert("升班成功!");
                        history.go(0);
                    }else{

                        alert("该"+res.data+"不存在");
                    }
                },
                error: function() {
                    alert('系统错误,请稍后重试');
                }
            });

    })

    $(".tjgrade").click(function(){

        var schoolid = <?php echo ($schoolid); ?>;

        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('edit_up_grade');?>",
            data:$("#edit_grade").serialize(),

            success: function(res) {
                if(res.status=="success")
                {
                    alert("年级升班成功!");
                    history.go(0);
                }else{

                    alert(res.data);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });

    })


</script>
</body>
</html>