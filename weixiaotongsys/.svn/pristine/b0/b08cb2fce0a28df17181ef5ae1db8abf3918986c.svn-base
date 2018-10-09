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
<html>
<head>
    <style>
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>信息1</title>
    <script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
    <link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .col-auto {
            overflow: auto;
            _zoom: 1;
            _float: left;
        }

        .col-right {
            float: right;
            width: 30%;
            overflow: hidden;
            margin-left: 6px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .picList li {
            margin-bottom: 5px;
        }

        .touchlei {
            background-color: #EEEEEE;
        }
    </style>
</head>
<body>
<div class="" style="margin-left: 20px; margin-right: 20px;">
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none; margin-left: 0;">
        <li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f; font-weight: bold; text-decoration: none;">校内公告列表</a>
        </li>
        <li><a href="<?php echo U('notice');?>" style="color:#1f1f1f; text-decoration: none;" class="touch">新增公告</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="home">
            <br/>
            <form class="form-horizontal J_ajaxForm" action="<?php echo u('SchoolNotice/index');?>" method="post" style="margin: 0px 0px 5px;">
                <div class="search_type cc mb10">
                    <div class="mb10">
                  <span class="mr20">状态:
                    <select class="select_2" name="status" style=" width:auto;">
                         <option value='0'>-请选择-</option>
                        <option value='1'>生效</option>
                        <option value='2'>已失效</option>
                         <!--<?php if(is_array($class)): foreach($class as $key=>$vo): ?>-->
                           <!--<OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></OPTION> -->
                         <!--<?php endforeach; endif; ?>-->
                      </select> &nbsp;&nbsp;
                 
                  公告类型:
                   <select class="select_2" name="type" style=" width:auto;">
                         <option value='0'>-请选择-</option>
                        <option value='1'>普通公告</option>
                        <option value='2'>表扬公告</option>
                         <!--<?php if(is_array($class)): foreach($class as $key=>$vo): ?>-->
                           <!--<OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></OPTION> -->
                         <!--<?php endforeach; endif; ?>-->
                      </select> &nbsp;&nbsp;
                      发布日期: 
                      <input type="text" name="begin" class="J_date" placeholder="-选择时间-"
                             style=" width:150px; color: #a9a9a9; padding-left: 5px; height: 29px; border-width:1px; color: black; " value="<?php echo ($begin); ?>" >&nbsp;至&nbsp;<input
                              type="text" name="end" class="J_date" placeholder="-选择时间-"
                              style=" width:150px; color: #a9a9a9; padding-left: 5px; height: 29px; border-width:1px; color: black;" value="<?php echo ($end); ?>"> &nbsp;&nbsp;

                      <input type="submit" class="btn btn-primary"
                             style="border:none;;color:#FFF; background-color:#26a69a;" value="查询"/>
                      <input type="button" class="btn btn-primary"
                             style="border:none;;color:#FFF; background-color:#26a69a;"  onclick="derive()"  value="导出"/ >
                       <input type="button" class="btn btn-primary"
                              style="border:none;;color:#FFF; background-color:#26a69a;" value="删除" onclick="deletePost()"/>
                       <input type="submit" class="btn btn-primary"
                              style="border:none;;color:#FFF; background-color:#26a69a;" value="恢复生效"/>
                       <input type="submit" class="btn btn-primary"
                              style="border:none;;color:#FFF; background-color:#26a69a;" value="设为无效"/>
                  </span>
                    </div>
                </div>
            </form>
            <form class="J_ajaxForm" action="" method="post">
                <div class="table-responsive">
                    <table  id="tab" class="table table-hover table-bordered table-list">
                        <thead>
                        <tr style="background-color:#e2e2e2;">
                            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">
                                <input type='checkbox' id='checkAll' name="checkAll"> 全选
                            </th>
                            <th style=" text-align: center;border-width: 0.5px;border-left: none;">公告标题</th>
                            <th style=" text-align: center;border-width: 0.5px;border-left: none;">公告类型</th>
                            <th style=" text-align: center;border-width: 0.5px;border-left: none;">发布日期</th>
                            <th style=" text-align: center;border-width: 0.5px;border-left: none;">生效日期</th>
                            <th style=" text-align: center;border-width: 0.5px;border-left: none;">终止日期</th>
                            <th style=" text-align: center;border-width: 0.5px;border-left: none;border-right: none;">
                                当前状态
                            </th>
                        </tr>
                        </thead>
                        <?php if(is_array($notice)): foreach($notice as $key=>$vo): $type=array("1"=>"普通公告","2"=>"表扬公告"); ?>
                            <tr class="tt">
                                <td style=" text-align: center;  border-top:none; border-left: none;">
                                    <input type="checkbox" class="J_check" id='sel_all' name="ids" value="<?php echo ($vo["id"]); ?>"
                                           title="ID:<?php echo ($vo["id"]); ?>"></td>
                                <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["title"]); ?></td>
                                <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($type[$vo['type']]); ?></td>
                                <td style=" text-align: center;border-left: none;border-top: none;">
                                    <?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?>
                                </td>
                                <td style=" text-align: center;border-left: none;border-top: none;">
                                    <?php echo (date("Y-m-d",$vo["begin_time"])); ?>
                                </td>
                                <td style=" text-align: center;border-left: none;border-top: none;">
                                    <?php echo (date("Y-m-d",$vo["end_time"])); ?>
                                </td>
                                <td style=" text-align: center;border-left: none;border-top: none;border-right: none;">
                                    <?php if($time > $vo['end_time']): ?>已失效
                                        <?php elseif($time < $vo['begin_time']): ?>
                                        未生效
                                        <?php else: ?>
                                        生效<?php endif; ?>
                                </td>
                            </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pagination"><?php echo ($Page); ?></div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="ios">
        </div>
    </div>
    <script src="/weixiaotong2016/statics/js/common.js"></script>
    <!--全选start-->
    <script type="text/javascript">
        var change = function (chkArray, val) {
            for (var i = 0; i < chkArray.length; i++)
//遍历指定组中的所有项
                chkArray[i].checked = val;
//设置项为指定的值-是否选中
        }
    </script>
    <!--全选end-->
    <script>

            function deletePost() {
             if (confirm("确定要删除吗？")) {

            var id = document.getElementsByName('ids');
            
           // console.log(obj);
            var ids = new Array();
                //将所有选中复选框的默认值写入到id数组中
                for (var i = 0; i < id.length; i++) {
                    if (id[i].checked){
                        ids.push(id[i].value);
                        console.log($(this).find('.tt').remove());
                    }
                    // $(this).closest('tr').remove();

                }
             console.log(ids);
            //alert("dddd");

           delAjax(ids);
           }
        }


           //删除函数
              function delAjax(ids)
              {
                $.ajax({
                    type:'post',
                    url: "<?php echo U('Teacher/SchoolNotice/delete');?>",
                    dataType:'json',
                    data: {
                        'ids': ids,
                        
                    },
                    success:function(data){
                         //console.log(data);
                        if(data.status){
                           alert('删除成功');
                           location.reload();
                        }else{
                            alert('删除失败');
                            location.reload();
                        }
                    },
                    //请求失败
                    error:function(){
                       alert('请求失败')
                    }
                })
              }
          

          function derive(){
           var id = document.getElementsByName('ids');
             var ids = new Array();
               if (confirm("确定要导出吗？")) {

                //将所有选中复选框的默认值写入到id数组中
                for (var i = 0; i < id.length; i++) {
                    if (id[i].checked){
                        ids.push(id[i].value);
                        //console.log($(this).find('.tt').remove());
                    }
                    // $(this).closest('tr').remove();

                }
                  console.log(ids)
                   if(ids == ''){
                    alert('请选择要导出的文件!')
                    return;
                   }

                location.href="<?php echo U('expUser');?>"+'?id='+ids; 
            

          }

     }


    


        $('#myTab a:first').tab('show');
        $(function() {
            $("#checkAll").click(function() {
                $('input[class="J_check"]').prop("checked", $(this).prop("checked"));
            });
            var $J_check = $("input[class='J_check']");
            $J_check.click(function(){
                $("#checkAll").prop("checked",$J_check.length == $("input[class='J_check']:checked").length ? true : false);
            });
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
        $(document).ready(function () {
            $("#test-upload").fileinput({
                'showPreview': false,
                'allowedFileExtensions': ['jpg', 'png', 'gif'],
                'elErrorContainer': '#errorBlock'
            });

        });
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
        $(document).ready(function () {
            $("#test-upload").fileinput({
                'showPreview': false,
                'allowedFileExtensions': ['jpg', 'png', 'gif'],
                'elErrorContainer': '#errorBlock'
            });

        });
    </script>
    <script>
        $(".touch").mouseenter(
            function () {
                $(this).addClass("touchlei")
            }
        )
        $(".touch").mouseleave(
            function () {
                $(this).removeClass("touchlei")
            }
        )

    </script>
</body>
</html>