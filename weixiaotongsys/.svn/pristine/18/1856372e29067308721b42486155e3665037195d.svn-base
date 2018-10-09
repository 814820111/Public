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
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="js/fileinput.js" type="text/javascript"></script>
<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>

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
<style type="text/css">
    .touchlei {
        background-color: #eeeeee;
    }
  select{
    color: black;
  }
  div{
    color: black;
  }

        tr .pai2 {
        text-align: center;
            color: black;
      }
            a{
            color:#00c1dd;
         }
    .new_ca_type {
        width: 100%;
        height: 100%;
        overflow: scroll;
        overflow-x: hidden;
        padding: 2px;
    }
    .new_ca_type_list_add {
        width: 144px;
        height: 168px;
        background-color: #f0f0f2;
        box-shadow: 0 1px 6px rgba(0,0,0,.15);
        float: left;
        margin: 0px 17px 15px 0;
        text-align: center;
        position: relative;
    }
    .new_ca_type_list {
        padding: 8px 12px 0px 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,.15);
        float: left;
        position: relative;
        margin: 0px 17px 15px 0;
    }
    .new_ca_type_list > img {
        width: 120px;
        height: 120px;
    }
    .new_ca_type_list > .new_ca_type_list_name_sum {
        text-align: center;
        width: 120px;
        height: 40px;
        line-height: 40px;
        color: #8c8c8c;
        font-size: 12px;
        overflow: hidden;
        text-align: left;
    }
    .new_ca_type_list > .new_ca_type_list_name_sum {
        text-align: center;
        width: 120px;
        height: 40px;
        line-height: 40px;
        color: #8c8c8c;
        font-size: 12px;
        overflow: hidden;
        text-align: left;
    }
    .new_ca_type_list > .new_ca_type_list_name_sum span:nth-child(1) {
        width: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<body>
<ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
    <li><a href="<?php echo U('add');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">上传照片</a>
    </li>
    <li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">相册列表</a>
    </li>
</ul>
<div style=" background-color:rgba(0,0,0,0.7);z-index: 999; width:100%; height:100%;position:absolute; display: none" class="show_class"  >
    <div style=" width:400px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">

        <div>
            <div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">新建相册

            </div>
            <div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
        </div>
        <div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">

            <div>
                <select id="album_grade">
                    <option value=''>请选择年级</option>
                    <?php if(is_array($categorys)): foreach($categorys as $key=>$vo): ?><OPTION value="<?php echo ($vo['gradeid']); ?>" ><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>

                </select><br>
                <select class="select_2" name="class" id="album_class" >
                    <option value=''>请选择班级</option>

                </select><br>

                <input type="text" id="album_name" placeholder="请输入相册名称" style="border: 1px solid rgb(220, 228, 236);"><br><br>






                <!--     <form  action="<?php echo U('ImpUser');?>" method="post" enctype="multipart/form-data"> -->


                <input type="submit" value="确定" class="btn btn-info confirm_class">&nbsp;&nbsp;&nbsp;
                <a class="btn btn-danger dao_close">取消</a>

                <!-- </form> -->
                </p>
            </div>

        </div>
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

<div style="margin-left: 25px;margin-right: 20px;">
    <form class="" method="post" action="<?php echo U('ClassAlbum/index');?>" style="margin: 20px 0px 5px;">
        年级：
        <select class="select_2" name="grade" id="school_grade" style="width: auto;">
            <option value=''>请选择年级</option>
            <?php if(is_array($categorys)): foreach($categorys as $key=>$vo): $grade_info=$gradeinfo==$vo['gradeid']?"selected":""; ?>
                <OPTION value="<?php echo ($vo['gradeid']); ?>" <?php echo ($grade_info); ?>><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>
        </select> &nbsp;&nbsp;
        班级：
        <select class="select_2" name="class" id="school_class" style="width: auto;">
            <option value=''>请选择班级</option>
            <input type="hidden" class="newclass" value="<?php echo ($classinfo); ?>">
        </select> &nbsp;&nbsp;

        创建时间：
        <input type="text" class="sang_Calender" name="start_time" placeholder="-选择时间-"
               style="width: 150px; height: 15px;     border: 1px solid #dce4ec; color:black;" value="<?php echo ($start_time_unix); ?>"> - <input type="text" class="sang_Calender" name="end_time"
                                                            placeholder="-选择时间-" style="width: 150px; height: 15px;border: 1px solid #dce4ec; color: black;" value="<?php echo ($end_time_unix); ?>">
        &nbsp; &nbsp;

        <input type="submit"  style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px; margin-bottom: 10px" value="搜索"/>
    </form>


    <div style="background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 1px 20px rgba(0,0,0,.15);
    box-sizing: border-box;">
    <form class="js-ajax-form" action="" method="post" action="<?php echo U('ClassAlbum/index');?>">
        <div class="new_ca_type">
            <div class="new_ca_type_list_add"><div><img src="https://media2.youanbao.com.cn/media/default/albums/images/create.png"></div></div>
            <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><a href="<?php echo U('Album_details',array('mid'=>$vo['mid']));?>" >
                <div class="new_ca_type_list">
                    <img src="/weixiaotong2016/uploads/microblog/<?php echo ($vo["picture"]); ?>">
                    <div class="new_ca_type_list_name_sum"><span><?php echo ($vo["content"]); ?></span><span><?php echo ($vo["picture_count"]); ?>张</span></div>
                </div>
                </a><?php endforeach; endif; ?>
        </div>
        <div class="pagination"><?php echo ($Page); ?></div>
    </form>
    </div>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>

<script>

    $(".new_ca_type_list_add").click(function(){
        $(".show_class").fadeIn(300);
    })


    $(".dao_close").click(
        function() {
            $(".show_class").hide()
        }

    )

    $(".confirm_class").click(function(){
        //下星期来写
         var album_grade = $("#album_grade").val();

         var album_class = $("#album_class").val();

         var album_name = $("#album_name").val();
          if(!album_grade)
          {
              alert("年级不能为空!");
              return false;
          }
          if(!album_class)
          {
              alert("班级不能为空!");
              return false;
          }
          if(!album_name)
          {
              alert("相册名不能为空!");
              return false;
          }

        $.ajax({
            type: "post",
            async: false,
            url: "<?php echo U('Teacher/ClassAlbum/add_album');?>",
            dataType: 'json',
            data: {
                'grade': album_grade,
                'class': album_class,
                'album_name':album_name,
            },
            success: function(data) {
                if(data.status)
                {
                    alert(data.msg)
                    history.go(0);
                }else{
                    alert(data.msg);
                    return false;
                }

            }
        });

    });
    if($("#school_grade").val())
    {

        var newclass = $('body').find(".newclass").val();
        // alert(newclass);
        $("#school_class").empty();
        $.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherUtils&a=get_class&grade=" + $("#school_grade").val(), {}, function (data) {
            if (data.status == "success") {
                $("#school_class").append("<option value=0>" + "请选择班级" + "</option>");
                for (var key in data.data) {

                    if(newclass==data.data[key]["id"] ){

                        $("#school_class").append("<option value=" + data.data[key]["id"] + " selected>" + data.data[key]["classname"] + "</option>");
                    }else{
                        $("#school_class").append("<option value=" + data.data[key]["id"] + " >" + data.data[key]["classname"] + "</option>");
                    }

                }
            }
            if (data.status == "error") {
                $("#school_class").append("<option value='0'>全部班级</option>");
            }
        });
    }


    $(function () {
        $("#school_grade").change(function () {
            $("#school_class").empty();
            $.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherUtils&a=get_class&grade=" + $("#school_grade").val(), {}, function (data) {
                if (data.status == "success") {
                    $("#school_class").append("<option value=0>" + "请选择班级" + "</option>");
                    for (var key in data.data) {
                        $("#school_class").append("<option value=" + data.data[key]["id"] + ">" + data.data[key]["classname"] + "</option>");
                    }
                }
                if (data.status == "error") {
                    $("#school_class").append("<option value='0'>没有班级</option>");
                }
            });
        });
    });

    $(function () {
        $("#album_grade").change(function () {
            $("#album_class").empty();
            $.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherUtils&a=get_class&grade=" + $("#album_grade").val(), {}, function (data) {
                if (data.status == "success") {
                    $("#album_class").append("<option value=0>" + "请选择班级" + "</option>");
                    for (var key in data.data) {
                        $("#album_class").append("<option value=" + data.data[key]["id"] + ">" + data.data[key]["classname"] + "</option>");
                    }
                }
                if (data.status == "error") {
                    $("#album_class").append("<option value='0'>没有班级</option>");
                }
            });
        });
    });

</script>



</body>
</html>