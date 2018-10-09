<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchMicroBlogController extends WeixinbaseController {
	//	localhost/weixiaotong2016/index.php/Weixin/TchMicroBlog/index
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
	    $userid = $_SESSION['userid']; //老师ID
	    $this->assign("userid",$userid);

	    $this->assign("schoolid",$_SESSION["schoolid"]);//学校ID

        $this->assign("classid",$_SESSION["classid"]);//班级ID
	    //$info = M("wxtuser")->where(array("id"=>$userid))->find();
        $info = M("teacher_info")->where(array("teacherid"=>$_SESSION['userid'],"schoolid"=>$_SESSION["schoolid"]))->field("name")->find();
	    $this->assign("name",$info['name']);
		$this->display();
	}
	//动态发布
	public function Fabu(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        //查询老师的名字
        $teacher_info = M("teacher_info")->where(array("teacherid"=>$_SESSION['userid'],"schoolid"=>$_SESSION["schoolid"]))->field("name")->find();
        $this->assign('send_name',$teacher_info["name"]);

        $this->assign('classid',$_SESSION['classid']);
        $this->assign('schoolid',$_SESSION['schoolid']);
        $this->assign('studentid',$_SESSION['studentid']);
        $this->assign('userid',$_SESSION['userid']);
		$this->display("fabudongtai");
	}
}


