<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchAlbumsController extends WeixinbaseController {

	//localhost/weixiaotong2016/index.php/weixin/TchAlbums/index
	//班级相册的渲染页面
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION['userid'];
        $this->assign("userid",$userid);
        $this->assign("schoolid",$_SESSION['schoolid']);
        $this->assign("classid",$_SESSION['classid']);
		$this->display();
	}
	//班级相册
	public function detail(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);

           //用户ID
       if(I("userid")){
            $userid = I("userid");
       }else{
            $userid=$_SESSION['userid'];
       }
        //该信息的ID
        $mid=I("mid");
        //消息类型
        $types=I("type");
        //班级
        if($_SESSION['classid']){
            $this->assign("classid",$_SESSION['classid']);//班级ID
            $this->assign("schoolid",$_SESSION['schoolid']);//班级ID
        }else{
            $clasid  = M("teacher_class")->where(array("userid"=>$userid))->find();
            $this->assign("classid",$clasid["classid"]);//班级ID
            $this->assign("schoolid",$clasid["schoolid"]);//学校ID
        }

//            //查询头像姓名等等
            $teacher_info = M("wxtuser")->where(array("id"=>$_SESSION['userid']))->field("photo")->find();
//            $this->assign("photo",$stu_info["photo"]);//用户头像
//            $this->assign("name",$stu_info["name"]);//用户姓名

            $id=$_SESSION['userid']; //用户ID
            //获取用户的名字 头像
            $info = M("teacher_info")->where(array("teacherid"=>$_SESSION['userid']))->field("name")->find();
            $this->assign("name",$info["name"]);//用户姓名
            $this->assign("photo",$teacher_info["photo"]);//用户头像
            $this->assign("uid",$id);
            $this->assign("types",$types);
            $this->assign("mid",$mid);
            $this->assign("userid",$userid);
		    $this->display();
	}
	//班级相册
	public function fabu(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        //查询老师的名字
        $teacher_info = M("teacher_info")->where(array("teacherid"=>$_SESSION['userid']))->field("name")->find();
        $this->assign('send_name',$teacher_info["name"]);

        $this->assign('classid',$_SESSION['classid']);
        $this->assign('schoolid',$_SESSION['schoolid']);
        $this->assign('studentid',$_SESSION['studentid']);
        $this->assign('userid',$_SESSION['userid']);
        $type=I("type");
        //权限判断
        $schoolid = $_SESSION['schoolid'];
//        $action = "weixin/TchAlbums/fabu";
//        $teacherid = $_SESSION['userid'];
//        $result = $this->check_role(strtolower($action),$teacherid,$schoolid);
//        $this->assign('check',$result);
		$this->display("fabuxiangce");
	}
	//增加图片
    public function addPhoto()
    {
        if(I("mid")){
            $mid = I("mid");
            $this->assign("mid",$mid);
        }
        $this->assign('userid',$_SESSION['userid']);
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);

        $schoolid = $_SESSION['schoolid'];
        $action = "weixin/TchAlbums/addPhoto";
        $teacherid = $_SESSION['userid'];
        $result = $this->check_role(strtolower($action),$teacherid,$schoolid);
        $this->assign('check',$result);
        $this->display();
    }


}


