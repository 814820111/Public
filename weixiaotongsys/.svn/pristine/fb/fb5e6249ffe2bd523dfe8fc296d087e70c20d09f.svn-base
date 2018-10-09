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
.home_info li em {
float: left;
width: 100px;
font-style: normal;
}
li {
list-style: none;
}

</style>
</head>

<body>
<div class="wrap">
  <div id="home_toptip"></div>
  <h4 class="well">接口列表</h4>
  <div class="home_info">
      <p style="color: red;">2016.02.25修改：1、写博客时间；2、点赞时间；3、评论时间；4、写入宝宝日记时间；为后台获取<br/>2016.02.26修改：1.写博客；2.添加评论；3.写入宝宝日记；为post数据传输</p>
    <ul  id="thinkcmf_notices">
    	<!--<li><img src="/weixiaotong2016/tpl_admin/simpleboot/assets/images/loading.gif"  style="vertical-align: middle;"/><span style="display:inline-block;vertical-align: middle;">加载中...</span></li>-->
      <li> <em>用户头像图片文件夹：</em> <span>/uploads/avatar/</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/uploads/avatar/weixiaotong.png</span></li>
      <br>
      <li> <em>动态圈图片文件夹：</em> <span>/uploads/microblog/</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/uploads/microblog/1.jpg</span></li>
      <br>
      <li> <em>轮播图片文件夹：</em> <span>/uploads/Viwepager/</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/uploads/Viwepager/1.png</span></li>
      <br>
      <li> <em>成长日记图片文件夹：</em> <span>/uploads/growCover/</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/uploads/growCover/1.png</span></li>
      <br>
      <li> <em>菜谱图片文件夹：</em> <span>/uploads/recipe/</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/uploads/recipe/yu.jpg</span></li>
      <br>
      <li> <em>班级活动图片文件夹：</em> <span>/uploads/ClassAction/</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/uploads/ClassAction/chunyou.jpg</span></li>
      <br>
      <li> <em>快乐学堂and育儿知识图片文件夹：</em> <span>/uploads/happyschool</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/uploads/happyschool/happy.jpg</span></li>
      <br>
      <li> <em>宝宝资料二维码图片文件夹：</em> <span>/data/QRcode</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/data/QRcode/28QRcode.png</span></li>
      <br>
      <li> <em>接口前缀：</em> <span>http://wxt.xiaocool.net/index.php?g=apps&m=index&</span> </li>
      <br>
      <li> <em>接口名称</em> <span>提交留言</span> </li>
      <li> <em>接口地址：</em> <span>a=LeaveMessage</span> </li>
      <li> <em>入参：</em> <span>userid,message,photo</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=message&a=LeaveMessage&userid=613&message=614&photo=heloo111</span></li> 
      <br>
      <li> <em>接口名称</em> <span>修改群标题</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateGroupTitle</span> </li>
      <li> <em>入参：</em> <span>uid,groupid,title</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=message&a=UpdateGroupTitle&uid=605&groupid=2&title=heloo</span></li>  
      <br>
      <li> <em>接口名称</em> <span>创建聊天群</span> </li>
      <li> <em>接口地址：</em> <span>a=CreateGroupChat</span> </li>
      <li> <em>入参：</em> <span>send_uid,receive_uid,title</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=message&a=CreateGroupChat&send_uid=613&receive_uid=614&title=heloo111</span></li>  
      <br>
      <li> <em>接口名称</em> <span>获取聊天群的联系人</span> </li>
      <li> <em>接口地址：</em> <span>a=xcGetChatLinkManList</span> </li>
      <li> <em>入参：</em> <span>userid,chatid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=message&a=xcGetChatLinkManList&userid=613&chatid</span></li>  
      <br>
      <li> <em>接口名称</em> <span>添加聊天群的联系人</span> </li>
      <li> <em>接口地址：</em> <span>a=xcAddChatLinkMan</span> </li>
      <li> <em>入参：</em> <span>chatid,userid,usertype,inviterid,invitertype</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=message&a=xcGetChatLinkManList&userid=613&chatid</span></li>  
      <br>
      <li> <em>接口名称</em> <span>发送聊天信息</span> </li>
      <li> <em>接口地址：</em> <span>a=SendChatData</span> </li>
      <li> <em>入参：</em> <span>send_uid,receive_uid,content,usertype(接收者的用户类型1:教师，0:家长)</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=message&a=SendChatData&send_uid=613&receive_uid=614&content=heloo111</span></li>  
       <br>
      <li> <em>接口名称</em> <span>获取聊天列表</span> </li>
      <li> <em>接口地址：</em> <span>a=xcGetChatListData</span> </li>
      <li> <em>入参：</em> <span>uid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=xcGetChatListData&uid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取聊天信息（两个人之间的）</span> </li>
      <li> <em>接口地址：</em> <span>a=xcGetChatData</span> </li>
      <li> <em>入参：</em> <span>send_uid,receive_uid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=xcGetChatData&send_uid=1&receive_uid=2&type=1</span></li>  
      <br>
      <li> <em>接口名称</em> <span>获取菜谱内容</span> <>
      <li> <em>接口地址：</em> <span>m=school&a=getCookbookContent</span> <>
      <li> <em>入参：</em> <span>schoolid,begindate,enddate(时间戳)</span> <>
      <li> <em>出参：</em> <span>info</span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getCookbookContent&schoolid=1&begindate=111&enddate=99999999999</span></li>
      <br>
      <li> <em>接口名称</em> <span>添加班级</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=addclass</span> </li>
      <li> <em>入参：</em> <span>schoolid,classtype(1=>班级),classname,description,teacherid(班主任)</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=addclass&schoolid=1&classtype=1&classname=舞蹈版&description=我们学校的特色班级&teaherid=12</span></li> 
      <br>
      <li> <em>接口名称</em> <span>向班级内添加学生</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=addStudenttoClass</span> </li>
      <li> <em>入参：</em> <span>studentid,classid,schoolid</span> </li>
      <li> <em>出参：</em> <span>成功返回班级列表</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=addStudenttoClass&schoolid=1&classid=12&studentid=88</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取班级内的学生列表</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getStudentlistByClassid</span> </li>
      <li> <em>入参：</em> <span>classid</span> </li>
      <li> <em>出参：</em> <span>成功返回班级列表</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getStudentlistByClassid&classid=12</span></li>  
      <br>
      <li> <em>接口名称</em> <span>登录</span> </li>
      <li> <em>接口地址：</em> <span>a=login</span> </li>
      <li> <em>入参：</em> <span>phone,password</span> </li>
      <li> <em>出参：</em> <span>userinfo</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=applogin&phone=18401216028&password=123</span></li>
      <br>
      <li> <em>接口名称</em> <span>发送验证码</span> </li>
      <li> <em>接口地址：</em> <span>a=SendMobileCode</span> </li>
      <li> <em>入参：</em> <span>phone</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=SendMobileCode&phone=18401216028</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长手机号+验证码+未激活 验证</span> </li>
      <li> <em>接口地址：</em> <span>a=UserVerify</span> </li>
      <li> <em>入参：</em> <span>phone,code</span> </li>
      <li> <em>出参：</em> <span>id</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=UserVerify&phone=18865511109&code=111111</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长激活+设置密码</span> </li>
      <li> <em>接口地址：</em> <span>a=UserActivate</span> </li>
      <li> <em>入参：</em> <span>userid,pass</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=UserActivate&userid=28&pass=123</span></li>
      <br>
      <li> <em>接口名称</em> <span>忘记密码-家长手机号+验证码+已激活 验证</span> </li>
      <li> <em>接口地址：</em> <span>a=forgetPass_Verify</span> </li>
      <li> <em>入参：</em> <span>phone,code</span> </li>
      <li> <em>出参：</em> <span>id</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=forgetPass_Verify&phone=18865511109&code=111111</span></li>
      <br>
      <li> <em>接口名称</em> <span>忘记密码-修改密码</span> </li>
      <li> <em>接口地址：</em> <span>a=forgetPass_Activate</span> </li>
      <li> <em>入参：</em> <span>userid,pass</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=forgetPass_Activate&userid=28&pass=123</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取用户资料</span> </li>
      <li> <em>接口地址：</em> <span>a=GetUsers</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>userinfo</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=GetUsers&userid=28</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取服务状态</span> </li>
      <li> <em>接口地址：</em> <span>a=GetSeverStatus</span> </li>
      <li> <em>入参：</em> <span>stuid</span> </li>
      <li> <em>出参：</em> <span>serve_return</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=GetSeverStatus&stuid=1234567890</span></li>
      <br>
      <li> <em>接口名称</em> <span>在线客服</span> </li>
      <li> <em>接口地址：</em> <span>a=service</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>service_return</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=service&userid=597</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取用户关联的学生</span> </li>
      <li> <em>接口地址：</em> <span>a=GetUserRelation</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>relation_stu_return</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=GetUserRelation&userid=597</span></li>
      <br>
      <li> <em>接口名称</em> <span>修改资料</span> </li>
      <li> <em>接口地址：</em> <span>a=SetUser_data</span> </li>
      <li> <em>入参：</em> <span>userid(必须),phone(可选),appellation(可选),photo(未写完)</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=SetUser_data&userid=597&phone=18363866803</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取学生关联的用户</span> </li>
      <li> <em>接口地址：</em> <span>a=GetStuRelation</span> </li>
      <li> <em>入参：</em> <span>stuid</span> </li>
      <li> <em>出参：</em> <span>ret_relation</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=GetStuRelation&stuid=599</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取学生今日记录</span> </li>
      <li> <em>接口地址：</em> <span>a=GetStudentLog</span> </li>
      <li> <em>入参：</em> <span>stuid</span> </li>
      <li> <em>出参：</em> <span>log_info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=GetStudentLog&stuid=599</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取身高数据</span> </li>
      <li> <em>接口地址：</em> <span>a=GetChange_stature</span> </li>
      <li> <em>入参：</em> <span>stuid</span> </li>
      <li> <em>出参：</em> <span>return_array</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=GetChange_stature&stuid=599</span></li>
            <br>
      <li> <em>接口名称</em> <span>获取体重数据</span> </li>
      <li> <em>接口地址：</em> <span>a=GetChange_weight</span> </li>
      <li> <em>入参：</em> <span>stuid</span> </li>
      <li> <em>出参：</em> <span>return_array</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=GetChange_weight&stuid=599</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取动态圈数据</span> </li>
      <li> <em>接口地址：</em> <span>a=GetMicroblog</span> </li>
      <li> <em>入参：</em> <span>beginid,schoolid,classid</span> </li>
      <li> <em>出参：</em> <span>user_return</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=GetMicroblog&schoolid=1&classid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>写博客</span> </li>
      <li> <em>接口地址：</em> <span>a=WriteMicroblog</span> </li>
      <li> <em>入参(post)：</em> <span>userid,schoolid,classid（班级相册时必填）,studentid（宝宝相册时必填）,type(1：个人动态，2，班级相册，3宝宝相册),content,picurl</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=WriteMicroblog</span></li>
      <br>
      <li> <em>接口名称</em> <span>写博客上传图片</span> </li>
      <li> <em>接口地址：</em> <span>a=WriteMicroblog_upload</span> </li>
      <li> <em>入参：</em> <span>无</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=WriteMicroblog_upload</span></li>
      <li><em>图片地址:</em><span>/uploads/microblog</span></li>
      <br>
      <li> <em>接口名称</em> <span>点赞</span> </li>
      <li> <em>接口地址：</em> <span>a=SetLike</span> </li>
      <li> <em>入参：</em> <span>userid,mid,time</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=SetLike&userid=599&mid=38</span></li>
      <br>
      <li> <em>接口名称</em> <span>取消赞</span> </li>
      <li> <em>接口地址：</em> <span>a=ResetLike</span> </li>
      <li> <em>入参：</em> <span>userid,mid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=ResetLike&userid=599&mid=38</span></li>
      <br>
      <li> <em>接口名称</em> <span>添加评论</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=SetComment</span> </li>
      <li> <em>入参(post)：</em> <span>userid,id,type,content,photo</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=SetComment&userid=605&id=42&content=jkjkjk&type=4</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取三张轮播图片</span> </li>
      <li> <em>接口地址：</em> <span>a=Viwepager</span> </li>
      <li> <em>入参：</em> <span>无</span> </li>
      <li> <em>出参：</em> <span>return_url</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=Viwepager</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取成长日记数据</span> </li>
      <li> <em>接口地址：</em> <span>a=BabyGrow</span> </li>
      <li> <em>入参：</em> <span>beginid,babyid</span> </li>
      <li> <em>出参：</em> <span>gorw_id,babyid,userid,cover_photo,title,name,content,write_time</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=BabyGrow&babyid=599&beginid=0</span></li>
      <br>
      <li> <em>接口名称</em> <span>写入成长日记数据</span> </li>
      <li> <em>接口地址：</em> <span>a=WriteBabyGrow</span> </li>
      <li> <em>入参(post)：</em> <span>babyid,userid,cover_photo,title,conten,write_time</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=WriteBabyGrow</span></li>
      <br>
      <li> <em>接口名称</em> <span>上传成长日记封面图片</span> </li>
      <li> <em>接口地址：</em> <span>a=WriteBabyGrow_upload</span> </li>
      <li> <em>入参：</em> <span>无</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&aWriteBabyGrow_upload</span></li>
      <li><em>图片地址:</em><span>/uploads/gorwCover</span></li>
      <br>
      <li> <em>接口名称</em> <span>记录今日体重数据</span> </li>
      <li> <em>接口地址：</em> <span>a=RecordWeight</span> </li>
      <li> <em>入参：</em> <span>stuid,weight</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=RecordWeight&stuid=599&weight=40</span></li>
      <br>
      <li> <em>接口名称</em> <span>记录今日身高数据</span> </li>
      <li> <em>接口地址：</em> <span>a=RecordHeight</span> </li>
      <li> <em>入参：</em> <span>stuid,stature</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=RecordHeight&stuid=599&stature=134</span></li>
      <br>
      <li> <em>接口名称</em> <span>用户发送消息(post传输)</span> </li>
      <li> <em>接口地址：</em> <span>a=SendMessage</span> </li>
      <li> <em>入参：</em> <span>sendid,receiveid,content</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=SendMessage&sendid=599&receiveid=1&content=123</span></li>
      <br>
      <li> <em>接口名称</em> <span>用户发送消息(post传输)</span> </li>
      <li> <em>接口地址：</em> <span>a=send_message</span> </li>
      <li> <em>入参：</em> <span>send_user_id,schoolid,send_user_name,message_content,receiver_user_id,picture_url</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=message&a=send_message&send_user_id=600&schoolid=1&send_user_name=呵呵&message_content=222&receiver_user_id=597,600&picture_url=ajhsdiaho.png</span></li>
      <br>
      <li> <em>接口名称</em> <span>用户已发送的消息</span> </li>
      <li> <em>接口地址：</em> <span>a=SentMessage</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=SentMessage&userid=599</span></li>
      <br>
      <li> <em>接口名称</em> <span>用户收到的消息</span> </li>
      <li> <em>接口地址：</em> <span>a=ReceiveidMessage</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=ReceiveidMessage&userid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>通讯录</span> </li>
      <li> <em>接口地址：</em> <span>a=MessageAddress</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>schoolid,classid,schoolname,classname,teachername,teacherphone,teacherid</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=MessageAddress&userid=597</span></li>
      <br>
      <li> <em>接口名称</em> <span>本周食谱</span> </li>
      <li> <em>接口地址：</em> <span>a=ClassPicInfo</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>recipe_date,recipe_pic,recipe_title,recipe_info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=ClassPicInfo&schoolid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>打卡签到</span> </li>
      <li> <em>接口地址：</em> <span>a=Sign</span> </li>
      <li> <em>入参：</em> <span>stuid</span> </li>
      <li> <em>出参：</em> <span>studentid,arrivetime,log_date</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=Sign&stuid=28</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取代接确认信息</span> </li>
      <li> <em>接口地址：</em> <span>a=DeliveryVerifyinfo</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>delivery_status</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=DeliveryVerifyinfo&userid=28</span></li>
      <br>
      <li> <em>接口名称</em> <span>代接确认</span> </li>
      <li> <em>接口地址：</em> <span>a=DeliveryVerify</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=DeliveryVerify&userid=28</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取当前宝宝对应的老师及id及手机号</span> </li>
      <li> <em>接口地址：</em> <span>a=OnlineLeaveTeacher</span> </li>
      <li> <em>入参：</em> <span>schoolid,classid</span> </li>
      <li> <em>出参：</em> <span>teacherid,teachername,teacherphone</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=OnlineLeaveTeacher&classid=1&schoolid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>在线请假(post传输)</span> </li>
      <li> <em>接口地址：</em> <span>a=OnlineLeave</span> </li>
      <li> <em>入参：</em> <span>userid,teacherid,content</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=OnlineLeave&userid=599&teacherid=1&content=22232</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长叮嘱(post传输)</span> </li>
      <li> <em>接口地址：</em> <span>a=PatriarchEnjoin</span> </li>
      <li> <em>入参：</em> <span>userid,teacherid,content,photo</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=PatriarchEnjoin&userid=599&teacherid=1&content=22232</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取老师点评</span> </li>
      <li> <em>接口地址：</em> <span>a=TeacherComment</span> </li>
      <li> <em>入参：</em> <span>stuid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=TeacherComment&stuid=599</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取校园公告</span> </li>
      <li> <em>接口地址：</em> <span>a=SchoolNotice</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>notice_title,notice_content,releasename,notice_time</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=SchoolNotice&schoolid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取课件列表</span> </li>
      <li> <em>接口地址：</em> <span>a=SchoolCourseware</span> </li>
      <li> <em>入参：</em> <span>schoolid,classid</span> </li>
      <li> <em>出参：</em> <span>courseware_title,courseware_content,releasename,courseware_time</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=SchoolCourseware&schoolid=1&classid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取班级课表</span> </li>
      <li> <em>接口地址：</em> <span>a=ClassSyllabus</span> </li>
      <li> <em>入参：</em> <span>schoolid,classid</span> </li>
      <li> <em>出参：</em> <span>syllabus_id,schoolid,classid,monday,tuesday,wednesday,thursday,friday,saturday,sunday,syllabus_no</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=ClassSyllabus&schoolid=1&classid=2</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-获取宝宝资料</span> </li>
      <li> <em>接口地址：</em> <span>a=GetBabyInfo</span> </li>
      <li> <em>入参：</em> <span>studentid</span> </li>
      <li> <em>出参：</em> <span>babyinfo</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=GetBabyInfo&studentid=661</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［宝宝.爸爸.妈妈头像］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateUserAvatar</span> </li>
      <li> <em>入参：</em> <span>studentid,avatar</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdateUserAvatar&studentid=661&avatar=ajsdojao.png</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［生日］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateHobby</span> </li>
      <li> <em>入参：</em> <span>studentid,birthday</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdateHobby&studentid=661&birthday=1462712324</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［爱好］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateBirth</span> </li>
      <li> <em>入参：</em> <span>studentid,hobby</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdateBirth&studentid=661&hobby=音乐</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［家庭住址］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateAddress</span> </li>
      <li> <em>入参：</em> <span>studentid,address</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdateAddress&studentid=661&address=烟台</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［接送人］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateDelivery</span> </li>
      <li> <em>入参：</em> <span>studentid,delivery</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdateDelivery&studentid=661&delivery=奶奶</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［全家福］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdatePhoto</span> </li>
      <li> <em>入参：</em> <span>studentid,photo</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdatePhoto&studentid=661&photo=asdaw.png</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［妈妈职业］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateMoProfession</span> </li>
      <li> <em>入参：</em> <span>studentid,motherpro</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdateMoProfession&studentid=661&motherpro=教师</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［喜欢和妈妈做什么］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateWithMother</span> </li>
      <li> <em>入参：</em> <span>studentid,withmother</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdateWithMother&studentid=661&withmother=玩耍</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［爸爸职业］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateFaProfession</span> </li>
      <li> <em>入参：</em> <span>studentid,fatherpro</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdateFaProfession&studentid=661&fatherpro=教师</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长-修改宝宝资料［喜欢和爸爸做什么］</span> </li>
      <li> <em>接口地址：</em> <span>a=UpdateWithFather</span> </li>
      <li> <em>入参：</em> <span>studentid,withfather</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=UpdateWithFather&studentid=661&withfather=玩耍</span></li>
      <br>
      <li> <em>接口名称</em> <span>发布邀请家人</span> </li>
      <li> <em>接口地址：</em> <span>a=AddInviteFamily</span> </li>
      <li> <em>入参：</em> <span>studentid,parentname,appellationid,phone</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=AddInviteFamily&studentid=597&parentname=随便&appellationid=5&phone=123123123</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取家人邀请</span> </li>
      <li> <em>接口地址：</em> <span>a=GetInviteFamily</span> </li>
      <li> <em>入参：</em> <span>studentid</span> </li>
      <li> <em>出参：</em> <span>appellation,name,phone,photo</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=GetInviteFamily&studentid=597</span></li>
      <br>
      <li> <em>接口名称</em> <span>发布班级课表</span> </li>
      <li> <em>接口地址：</em> <span>a=addClassSyllabus</span> </li>
      <li> <em>入参：</em> <span>schoolid,classid,monday,tuesday,wednesday,thursday,friday,saturday,sunday,syllabus_no</span> </li>
      <li> <em>出参：</em> <span>syllabuslist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=addClassSyllabus&schoolid=1&classid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取班级活动</span> </li>
      <li> <em>接口地址：</em> <span>a=ClassActivity</span> </li>
      <li> <em>入参：</em> <span>schoolid,classid</span> </li>
      <li> <em>出参：</em> <span>activity_title,activity_content,releasename,activity_pic,activity_time</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=ClassActivity&schoolid=1&classid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取快乐学堂</span> </li>
      <li> <em>接口地址：</em> <span>a=HappySchool</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>happy_title,happy_content,releasename,happy_pic,happy_time</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=HappySchool&schoolid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取育儿知识</span> </li>
      <li> <em>接口地址：</em> <span>a=ParentingKnowledge</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>happy_title,happy_content,releasename,happy_pic,happy_time</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=ParentingKnowledge&schoolid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>生成宝宝资料二维码</span> </li>
      <li> <em>接口地址：</em> <span>a=StuCode</span> </li>
      <li> <em>入参：</em> <span>stuid</span> </li>
      <li> <em>出参：</em> <span>codename</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=StuCode&stuid=28</span></li>
       <br>
      <li> <em>接口名称</em> <span>教师－编辑个人资料</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=saveinfo</span> </li>
      <li> <em>入参：</em> <span>teacherid,teahcername,sex,picurl</span> </li>
      <li> <em>出参：</em> <span>success</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=saveinfo&teacherid=30&teachername=赵丽&sex=0&picurl=up/dd/aa.jpg</span></li>
      <br>
      <li> <em>接口名称</em> <span>教师－编辑个人手机号码</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=updatemobile</span> </li>
      <li> <em>入参：</em> <span>teacherid,mobile,code</span> </li>
      <li> <em>出参：</em> <span>success</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=updatemobile&teacherid=30&mobile=18653503680&sex=0&code＝1234</span></li>
      <br>
      <li> <em>接口名称</em> <span>教师端-获取教师点评</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=GetTeacherComment</span> </li>
      <li> <em>入参：</em> <span>teacherid</span> </li>
      <li> <em>出参：</em> <span>classlist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=GetTeacherComment&teacherid=30</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长端-获取教师点评</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=GetTeacherComment</span> </li>
      <li> <em>入参：</em> <span>studengid</span> </li>
      <li> <em>出参：</em> <span>comments</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=GetTeacherComment&studentid=661&begintime=0&endtime=1469864115</span></li>
      <br>
      <li> <em>接口名称</em> <span>添加教师点评</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=AddTeacherComment</span> </li>
      <li> <em>入参：</em> <span>teacherid,studentid,content,learn,work,sing,labour,strain</span> </li>
      <li> <em>出参：</em> <span>success</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=AddTeacherComment&teacherid=30&studentid=50&content=真不错&learn=1&work=1&sing=1&labour=1 &strain=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>园所情况-班级相册</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=ClassPicInfo</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>class_info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=ClassPicInfo&schoolid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>园所情况-班级活动</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=ClassActivityCount</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>teacher_info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=ClassActivityCount&schoolid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>园所情况-老师点评</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=TeacherCommentCount</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>teacher_info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=TeacherCommentCount&schoolid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取学校周计划</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getschoolplan</span> </li>
      <li> <em>入参：</em> <span>schoolid,type=1</span> </li>
      <li> <em>出参：</em> <span>planinfo</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getschoolplan&schoolid=30&type=1</span></li>   
      <br>
      <li> <em>接口名称</em> <span>发布周计划</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=publishschoolplan</span> </li>
      <li> <em>入参：</em> <span>schoolid,classid,title,content,create_time</span> </li>
      <li> <em>出参：</em> <span>noticeid</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=publishschoolplan&classid=1&t&title=标题&content=内容&</span></li>  
      <br>
      <li> <em>接口名称</em> <span>更新周计划内容</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=updataschoolplan</span> </li>
      <li> <em>入参：</em> <span>id,userid,content</span> </li>
      <li> <em>出参：</em> <span>planupdata</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=updataschoolplan&id=1&t&content=111&userid=597&</span></li> 
      <br>
      <li> <em>接口名称</em> <span>获取宝宝好友列表</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=getfriendlist</span> </li>
      <li> <em>入参：</em> <span>studentid</span> </li>
      <li> <em>出参：</em> <span>friendlist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=getfriendlist&studentid=597</span></li>   
      <br>
      <li> <em>接口名称</em> <span>发起好友申请</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=addfriend</span> </li>
      <li> <em>入参：</em> <span>studentid,friendid</span> </li>
      <li> <em>出参：</em> <span>ship</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=addenfriend&studentid=597&friendid=605</span></li>   
      <br>
      <li> <em>接口名称</em> <span>学生获取作业信息</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=gethomeworkmessage</span> </li>
      <li> <em>入参：</em> <span>receiverid</span> </li>
      <li> <em>出参：</em> <span>receive</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=gethomeworkmessage&receiverid=599</span></li>   
      <br>
      <li> <em>接口名称</em> <span>用户读取班级作业时间</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=read_homework</span> </li>
      <li> <em>入参：</em> <span>receiverid,homework_id</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=read_homework&receiverid=599&homework_id=11</span></li> 
      <br>
      <li> <em>接口名称</em> <span>获取学校院所信息</span> </li>
      <li> <em>接口地址：</em> <span>m=index&a=getschoolinfo</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>schoolinfo</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=getschoolinfo&schoolid=1</span></li>    
      <br>
      <li> <em>接口名称</em> <span>获取学生所在班级教师列表</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=getclassteacherlist</span> </li>
      <li> <em>入参：</em> <span>studentid,classid</span> </li>
      <li> <em>出参：</em> <span>teacherlist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=getclassteacherlist&studentid=597&classid=1</span></li>     
      <br>
      <li> <em>接口名称</em> <span>获取班级内学生列表</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getstudentlist</span> </li>
      <li> <em>入参：</em> <span>studentid,classid</span> </li>
      <li> <em>出参：</em> <span>teacherlist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getstudentlist&userid=597&classid=1</span></li> 
      <br>
      <li> <em>接口名称</em> <span>获取通知公告列表</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getnoticelist</span> </li>
      <li> <em>入参：</em> <span>userid,classid,schoolid</span> </li>
      <li> <em>出参：</em> <span>noticelist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getnoticelist&userid=597&classid=1&schoolid=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取接收人接收的公告</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=get_receive_notice</span> </li>
      <li> <em>入参：</em> <span>receiverid</span> </li>
      <li> <em>出参：</em> <span>noticelist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=get_receive_notice&receiverid=597</span></li>
      <br>
      <li> <em>接口名称</em> <span>发布通知公告</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=publishnotice</span> </li>
      <li> <em>入参：</em> <span>userid,type,title,content,photo,reciveid</span> </li>
      <li> <em>出参：</em> <span>noticeid</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=publishnotice&userid=597&type=1&title=标题&content=内容&photo=11.jpg&reciveid=12</span></li>
      <br>
      <li> <em>接口名称</em> <span>用户读取公告时间</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=read_notice</span> </li>
      <li> <em>入参：</em> <span>noticeid,receiverid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=read_notice&noticeid=10&receiverid=597</span></li>
      <br>
      <li> <em>接口名称</em> <span>发布班级作业</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=addhomework</span> </li>
      <li> <em>入参：</em> <span>teacherid,title,content,subject,receiverid,picture_url</span> </li>
      <li> <em>出参：</em> <span>homeworkid</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=addhomework&teacherid=597&title=周四作业&content=作业内容，快来看&subject=语文&receiverid=597&picture_url=1.png,2.png</span></li>    
      <br>
      <li> <em>接口名称</em> <span>获取班级作业列表</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=gethomeworklist</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>homeworklist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=gethomeworklist&userid=597</span></li>  
      <br>
      <li> <em>接口名称</em> <span>新增家长叮嘱</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=addentrust</span> </li>
      <li> <em>入参：</em> <span>userid,studentid,teacherid,content,picture_url</span> </li>
      <li> <em>出参：</em> <span>entrustid</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=addentrust&teacherid=597&userid=12&studentid=22&content=孩子有点感冒，让中午吃药&picture_url=1.png,2.png</span></li>
      <br>
      <li> <em>接口名称</em> <span>教师获取家长叮嘱列表</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=getentrustlist</span> </li>
      <li> <em>入参：</em> <span>teacherid</span> </li>
      <li> <em>出参：</em> <span>entrustlist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=getentrustlist&teacherid=597</span></li>    
      <br>
      <li> <em>接口名称</em> <span>家长端获取家长叮嘱列表</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=getentrustlist</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>entrustlist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=getentrustlist&userid=12</span></li>  
      <br>
      <li> <em>接口名称</em> <span>新增公告图片</span> </li>
      <li> <em>接口地址：</em> <span>m=schoool&a=addnoticephoto</span> </li>
      <li> <em>入参：</em> <span>noticeid,photo</span> </li>
      <li> <em>出参：</em> <span>entrustlist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=addnoticephoto&noticeid=12</span></li>   
       <br>
      <li> <em>接口名称</em> <span>家长端获取学生所在班级列表</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=getclasslist</span> </li>
      <li> <em>入参：</em> <span>studentid</span> </li>
      <li> <em>出参：</em> <span>list</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=getclasslist&studentid=597</span></li>   
      <br>
      <li> <em>接口名称</em> <span>家长端获取待接列表</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=gettransportconfirmation</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>lists</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=gettransportconfirmation&studentid=597</span></li>    
        <br>
      <li> <em>接口名称</em> <span>家长端确认孩子的待接信息</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=confirmtransport</span> </li>
      <li> <em>入参：</em> <span>transportid,parentid,status</span> </li>
      <li> <em>出参：</em> <span>状态 （delivery_status：0＝待确认，1=已同意，2＝不同意）</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=confirmtransport&transportid=1&parentid=122&status=1</span></li>        
      <br>
      <li> <em>接口名称</em> <span>绑定环信ID</span> </li>
      <li> <em>接口地址：</em> <span>m=Index&a=addhuanxinid</span> </li>
      <li> <em>入参：</em> <span>userid,huanxinid</span> </li>
      <li> <em>出参：</em> <span>状态 </span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=addhuanxinid&userid=28&huanxinid=122</span></li>
      <br>
      <li> <em>接口名称</em> <span>家长端获取请假列表</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=getleavelist</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>collectlist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=getleavelist&studentid=12</span></li>    
      <br>
      <li> <em>接口名称</em> <span>家长端提交孩子请假信息</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=addleave</span> </li>
      <li> <em>入参：</em> <span>studentid,parentid,teacherid,begintime,endtime,reason</span> </li>
      <li> <em>出参：</em> <span>状态 （status：0＝待确认，1=已同意，2＝不同意）</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=addleave&teacherid=1&parentid=122&studentid=12&begintime=2016-05-01&endtime=2016-05-06&reason=生病了</span></li>
      <br>
      <li> <em>接口名称</em> <span>教师端获取请假列表</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=getleavelist</span> </li>
      <li> <em>入参：</em> <span>teacherid</span> </li>
      <li> <em>出参：</em> <span>lists</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=getleavelist&teacherid=599</span></li>
      <br>
      <li> <em>接口名称</em> <span>教师回复请假信息</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=replyleave</span> </li>
      <li> <em>入参：</em> <span>leaveid,teacherid,feedback,status:：0=》等待，1=》同意，－1=》拒绝</span> </li>
      <li> <em>出参：</em> <span>更新信息</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=replyleave&leaveid=46&teacherid=599&feedback=好啊&status=1</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取教师任教班级列表以及班级内学生列表</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=getteacherclasslistandstudentlist</span> </li>
      <li> <em>入参：</em> <span>teacherid</span> </li>
      <li> <em>出参：</em> <span>   
                                 "status":"success",
                                 "data":[{
                                        "classid":"1",
                                        "classname":"\u5c0f\u4e00\u73ed\u554a",
                                        ,"studentlist":[{
                                                        "id":"654",
                                                        "name":"\u5475\u5475\u54c8\u54c8",
                                                        "sex":"1",
                                                        "phone":"22222222",
                                                        "photo":"weixiaotong.png"}]}]}
                           </span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=getteacherclasslistandstudentlist&teacherid=507</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取学生所在班级列表以及班级对应老师的列表</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=getstudentclasslistandteacherlist</span> </li>
      <li> <em>入参：</em> <span>teacherid</span> </li>
      <li> <em>出参：</em> <span>   
                                 "status":"success",
                                 "data":[{
                                        "classid":"1",
                                        "classname":"\u5c0f\u4e00\u73ed\u554a",
                                        "teacherlist":[{
                                                        "id":"654",
                                                        "name":"\u5475\u5475\u54c8\u54c8",
                                                        "sex":"1",
                                                        "phone":"22222222",
                                                        "photo":"weixiaotong.png"}]}]}
                           </span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=getstudentclasslistandteacherlist&teacherid=507</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取教师任课班级列表</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=getclasslist</span> </li>
      <li> <em>入参：</em> <span>teacherid</span> </li>
      <li> <em>出参：</em> <span>list</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=getteacherclasslist&teacherid=507</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取学校老师信息</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getteacherinfo</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>
                                 "status":"success",
                                 "data":
                                 "id":"600",
                                 "photo":"weixiaotong.png",
                                 "name":"\u67312"
                           </span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getteacherinfo&schoolid=1</span></li> 
      <br>
      <li> <em>接口名称</em> <span>获取学校班级列表</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getclasslist</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>list</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getclasslist&schoolid=1</span></li>   
      <br>
      <li> <em>接口名称</em> <span>教师端获取待接列表</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=gettransportconfirmation</span> </li>
      <li> <em>入参：</em> <span>teacherid</span> </li>
      <li> <em>出参：</em> <span>lists</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=gettransportconfirmation&teacherid=597</span></li>            
      <br>
      <li> <em>接口名称</em> <span>教师端发起待接确认</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=addtransport</span> </li>
      <li> <em>入参：</em> <span>teacherid,studentid,parentid,photo</span> </li>
      <li> <em>出参：</em> <span>id</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=addtransport&teacherid=609&parentid=28&studentid=597&photo=122.jpg</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取用户一段时间内的考勤记录</span> </li>
      <li> <em>接口地址：</em> <span>m=index&a=GetAttendance</span> </li>
      <li> <em>入参：</em> <span>userid,begintime,endtime</span> </li>
      <li> <em>出参：</em> <span>lists</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=GetAttendance&userid=609&begintime=1453334170&endtime=597</span></li>  
      <br>
      <li> <em>接口名称</em> <span>用户签到</span> </li>
      <li> <em>接口地址：</em> <span>m=index&a=usersign</span> </li>
      <li> <em>入参：</em> <span>userid,schoolid,arrivetime,arrivepicture,arrivevideo,leavetime,leavepicture,leavevideo</span> </li>
      <li> <em>出参：</em> <span>sign_add或者sign_save</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=usersign&userid=597&schoolid=1&arrivetime=1467603740&type=1&leavetime=1467606000</span></li>
      <br>
      <li> <em>接口名称</em> <span>用户补签</span> </li>
      <li> <em>接口地址：</em> <span>m=index&a=resign</span> </li>
      <li> <em>入参：</em> <span>userid,schoolid</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=index&a=resign&userid=597,605&schoolid=1</span></li>
      <br>                                   <br>
      <li> <em>接口名称</em> <span>［最新］点赞</span> </li>
      <li> <em>接口地址：</em> <span>a=SetLike</span> </li>
      <li> <em>入参：</em> <span>userid,id,type:,1、动态2、作业、3、公告</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=SetLike&userid=599&id=42&type=2</span></li>
      <br>
      <li> <em>接口名称</em> <span>［最新］取消赞</span> </li>
      <li> <em>接口地址：</em> <span>a=ResetLike</span> </li>
      <li> <em>入参：</em> <span>userid,id,type:,1、动态2、作业、3、公告</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=ResetLike&userid=599&id=38</span></li>  
      <br>
      <li> <em>接口名称</em> <span>［最新］添加评论</span> </li>
      <li> <em>接口地址：</em> <span>a=SetComment</span> </li>
      <li> <em>入参(post)：</em> <span>userid,id，content,type:,1、动态2、作业、3、公告,photo</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=SetComment</span></li>
            <br>
      <li> <em>接口名称</em> <span>教师回复家长叮嘱</span> </li>
      <li> <em>接口地址：</em> <span>a=feedbackentrust</span> </li>
      <li> <em>入参(post)：</em> <span>id，teacherid,content</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=feedbackentrust&teacherid=599&content=收到</span></li>    
      <br>
      <li> <em>接口名称</em> <span>获取待办事宜列表</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getschedulelist</span> </li>
      <li> <em>入参：</em> <span>userid,schoolid</span> </li>
      <li> <em>出参：</em> <span>list</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getschedulelist&userid=597&schoolid=1</span></li>  
      <br>
      <li> <em>接口名称</em> <span>发布班级活动</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=addactivity</span> </li>
      <li> <em>入参：</em> <span>teacherid,title,content,photo,classid,begintime,endtime(时间戳),contactman,contactphone,isapply,receiverid,picture_url</span> </li>
      <li> <em>出参：</em> <span>activityid</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=addactivity&teacherid=597&classid=1&title=周四活动&content=活动内容，快来看&photo=11.jpg</span></li> 
      <br>
      <li> <em>接口名称</em> <span>教师端-获取班级活动信息</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=getactivitylist</span> </li>
      <li> <em>入参：</em> <span>userid</span> </li>
      <li> <em>出参：</em> <span>homeworklist</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=getactivitylist&userid=597</span></li> 
      <br>
      <li> <em>接口名称</em> <span>家长端-获取班级活动信息</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=getactivitylist</span> </li>
      <li> <em>入参：</em> <span>receiverid</span> </li>
      <li> <em>出参：</em> <span>receive</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=getactivitylist&receiverid=597</span></li> 
      <br>
      <li> <em>接口名称</em> <span>报名班级活动</span> </li>
      <li> <em>接口地址：</em> <span>m=student&a=ApplyActivity</span> </li>
      <li> <em>入参：</em> <span>userid,activityid,sex,age,fathername,contactphone</span> </li>
      <li> <em>出参：</em> <span>receive</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=student&a=ApplyActivity&userid=597&activityid=3&sex=1&age=5&fathername=大眼&contactphone=111</span></li> 
      <br>
      <li> <em>接口名称</em> <span>用户读取班级活动时间</span> </li>
      <li> <em>接口地址：</em> <span>m=teacher&a=read_activity</span> </li>
      <li> <em>入参：</em> <span>activity_id,receiverid</span> </li>
      <li> <em>出参：</em> <span>list</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=teacher&a=read_activity&activity_id=8&receiverid=597</span></li>     
      <br>
      <li> <em>接口名称</em> <span>获取评论列表</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=GetCommentlist</span> </li>
      <li> <em>入参：</em> <span>userid,refid,type</span> </li>
      <li> <em>出参：</em> <span>list</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=GetCommentlist&userid=597&refid=1&type=5</span></li>     
      <br>
      <li> <em>接口名称</em> <span>获取点赞列表</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=GetLikelist</span> </li>
      <li> <em>入参：</em> <span>userid,refid,type</span> </li>
      <li> <em>出参：</em> <span>list</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=GetLikelist&userid=597&refid=1&type=5</span></li>  
      <br>
      <br>
      <li>  <span>校网相关接口－－－－－－－－－－－－－－－</span> </li>
      <br>
      <li> <em>接口名称</em> <span>获取学校招聘列表</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getSchoolJobList</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>list</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getSchoolJobList&schoolid=1</span></li>  
      <br>
      <li> <em>接口名称</em> <span>获取学校介绍信息</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getschoolinfo</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getschoolinfo&schoolid=1</span></li>  
       <br>
      <li> <em>接口名称</em> <span>获取学校教师风采</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getteacherinfos</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getteacherinfos&schoolid=1</span></li>  
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=teacher&id=16</span></li>  
        <br>
      <li> <em>接口名称</em> <span>获取学校宝宝秀场</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getbabyinfos</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getbabyinfos&schoolid=1</span></li>  
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=baby&id=16</span></li>  
       <br>
      <li> <em>接口名称</em> <span>获取学校招聘信息</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getjobs</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getjobs&schoolid=1</span></li>
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=job&id=16</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取学校兴趣班级</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getInterestclass</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getInterestclass&schoolid=1</span></li>  
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=Interest&id=16</span></li>  
      <br>
      <li> <em>接口名称</em> <span>获取H5园区介绍</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=getWebSchoolInfos</span> </li>
      <li> <em>入参：</em> <span>schoolid</span> </li>
      <li> <em>出参：</em> <span>info</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getWebSchoolInfos&schoolid=1</span></li>  
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=school&id=16</span></li>   
      <br>
      <li> <em>接口名称</em> <span>获取校园通知</span> <>
      <li> <em>接口地址：</em> <span>m=school&a=getSchoolNotices</span> <>
      <li> <em>入参：</em> <span>schoolid</span> <>
      <li> <em>出参：</em> <span>id,schoolid,post_title,smeta,post_excerpt,post_content,post_dateid,schoolid,post_title,smeta,post_excerpt,post_content,post_date</span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getSchoolNotices&schoolid=1</span></li>
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=notice&id=16</span></li> 
      <br>
      <li> <em>接口名称</em> <span>获取新闻动态</span> <>
      <li> <em>接口地址：</em> <span>m=school&a=getSchoolNews</span> <>
      <li> <em>入参：</em> <span>schoolid</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":
                                 "id":"1",
                                 "schoolid":"1",
                                 "post_title":"222",
                                 "post_excerpt":"22",
                                 "post_date":"2016-06-23 14:18:33",
                                 "smeta":"{"thumb":"576b7f3633e43.png"}","thumb":"\/wxt_webhome\/data\/upload\/576b7f3633e43.png"
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getSchoolNews&schoolid=1</span></li>
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=notice&id=16</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取育儿知识</span> <>
      <li> <em>接口地址：</em> <span>m=school&a=getParentsThings</span> <>
      <li> <em>入参：</em> <span>schoolid</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":
                                 "id":"39",
                                 "schoolid":"1",
                                 "post_title":"asd ww",
                                 "post_excerpt":"scxca",
                                 "post_date":"2016-06-23 14:43:39",
                                 "smeta":"{"thumb":"576b851823438.png"}","thumb":"\/wxt_webhome\/data\/upload\/576b851823438.png"
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getParentsThings&schoolid=1</span></li>
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=notice&id=16</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取园长信箱</span> <>
      <li> <em>接口地址：</em> <span>m=school&a=getMailBox</span> <>
      <li> <em>入参：</em> <span>schoolid</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":
                                 "id":"1",
                                 "schoolid":"1",
                                 "userid":"600",
                                 "message":"\u54c8\u54c8\u54c8",
                                 "post_time":"2000-01-01 00:00:00"
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=getMailBox&schoolid=1</span></li>
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=notice&id=16</span></li>
      <br>
      <li> <em>接口名称</em> <span>创建园长信箱</span> <>
      <li> <em>接口地址：</em> <span>m=school&a=addMailBox</span> <>
      <li> <em>入参：</em> <span>schoolid</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":"11"
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=addMailBox&schoolid=2</span></li>
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=notice&id=16</span></li>
      <br>
      <li> <em>接口名称</em> <span>入学报名啊</span> <>
      <li> <em>接口地址：</em> <span>m=school&a=addapply</span> <>
      <li> <em>入参：</em> <span>schoolid</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":"\u62a5\u540d\u6210\u529f"
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=addapply&schoolid=1</span></li>
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=notice&id=16</span></li>
      <br>
      <li> <em>接口名称</em> <span>群发消息审核</span> <>
      <li> <em>接口地址：</em> <span>m=message&a=get_mass_message </span> <>
      <li> <em>入参：</em> <span>start_time,end_time,reception_user_name</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":"\u62a5\u540d\u6210\u529f"
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=Apps&m=Message&a=get_mass_message</span></li>
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=notice&id=16</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取用户发送的信息</span> <>
      <li> <em>接口地址：</em> <span>m=message&a=user_send_message </span> <>
      <li> <em>入参：</em> <span>send_user_id</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":[{
                                 "id":"308",
                                 "schoolid":"1",
                                 "send_user_id":"636",
                                 "send_user_name":"\u8d75\u534e\u4f1f",
                                 "message_content":"\u4f60\u597d\u5417\u4f60",
                                 "message_time":"11111111",
                                 "message_type":"1",
                                 "receiver":[{
                                 "receiver_user_id":"600",
                                 "receiver_user_name":"\u6731",
                                 "read_time":null},
                                 "receiver_num":2,
                                 "picture":[{
                                 "picture_url":"\/uploads\/message\/message_pic.jpg"}
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=Apps&m=Message&a=user_send_message</span></li>
      <li><em>H5拼接地址:</em><span>http://wxt.xiaocool.net/index.php?g=portal&m=article&a=notice&id=16</span></li>
      <br>
      <li> <em>接口名称</em> <span>获取用户已接收的信息</span> <>
      <li> <em>接口地址：</em> <span>m=message&a=user_reception_message </span> <>
      <li> <em>入参：</em> <span>receiver_user_id</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":[{
                                 "id":"1",
                                 "message_id":"300",
                                 "receiver_user_id":"600",
                                 "receiver_user_name":"\u6731",
                                 "message_type":"1",
                                 "read_time":null,
                                 "send_message":[{
                                 "id":"300",
                                 "schoolid":"1",
                                 "send_user_id":"636",
                                 "send_user_name":"\u8d75\u534e\u4f1f",
                                 "message_content":"\u4f60\u597d\u5417\u4f60\u597d\u5417",
                                 "message_time":"1111111111"},
                                 "picture_url":"\/uploads\/message\/message_pic.jpg"}
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=Apps&m=Message&a=user_reception_message</span></li>
      <br>
      <li> <em>接口名称</em> <span>发送群聊</span> <>
      <li> <em>接口地址：</em> <span>m=message&a=send_message </span> <>
      <li> <em>入参：</em> <span>reception_user_id</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":[{
                                 "
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=Apps&m=Message&a=send_message</span></li>
      <br>
      <li> <em>接口名称</em> <span>用户读取消息时间</span> <>
      <li> <em>接口地址：</em> <span>m=message&a=read_message </span> <>
      <li> <em>入参：</em> <span>message_id,receiver_user_id</span> <>
      <li> <em>出参：</em> <span>"status":"success",
                                 "data":[{
                                 "
                           </span> <>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=Apps&m=Message&a=read_message</span></li>
      <br>
      <li> <em>接口名称</em> <span>入学报名</span> </li>
      <li> <em>接口地址：</em> <span>m=school&a=enterschol</span> </li>
      <li> <em>入参：</em> <span>schoolid,username,sex(0,1),birthday(1999-05-21),address,classname(与账号所在班级无关，用户手动填写),phone,qq,weixin(微信名称),education(学历),school(毕业学校),remark,photo(先调用上传图片接口，此处填写文件名)</span> </li>
      <li> <em>出参：</em> <span>success/error</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=school&a=enterschol&schoolid=1&username=朱崇乾
            <br />自行按照参数拼接</span></li>       
      <br>

      <br>
      <li>  <span>校网相关接口－－－－－－－－－－－－－－－end</span> </li>
            <br>
      <li> <em>接口名称</em> <span>推送信息</span> </li>
      <li> <em>接口地址：</em> <span>a=jiguang</span> </li>
      <li> <em>入参：</em> <span>userid,content,sound,key,usertype(接收者的用户类型1:教师，0:家长)</span> </li>
      <li> <em>出参：</em> <span>无</span> </li>
      <li><em>Demo:</em><span>http://wxt.xiaocool.net/index.php?g=apps&m=message&a=SendChatData&send_uid=613&receive_uid=614&content=heloo111</span></li>  
      <br>                        
    </ul>
  </div>
 
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script> 
<script>
//获取官方通知
//$.getJSON("http://www.thinkcmf.com/service/sms_jsonp.php?callback=?",function(data){
//	var tpl='<li><em class="title"></em><span class="content"></span></li>';
//	var $thinkcmf_notices=$("#thinkcmf_notices");
//	$thinkcmf_notices.empty();
//	if(data.length>0){
//		$.each(data,function(i,n){
//			var $tpl=$(tpl);
//			$(".title",$tpl).html(n.title);
//			$(".content",$tpl).html(n.content);
//			$thinkcmf_notices.append($tpl);
//		});
//	}else{
//		$thinkcmf_notices.append("<li>^_^,没有通知~~</li>");
//	}
//	
//});
</script>
</body>
</html>