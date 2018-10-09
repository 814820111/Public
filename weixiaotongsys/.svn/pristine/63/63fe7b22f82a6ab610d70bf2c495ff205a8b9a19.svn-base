<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchCoursewareController extends WeixinbaseController {
	//教师端课件
	//localhost/weixiaotong2016/index.php/weixin/TchCourseware/index
    //课件列表
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION['userid'];
        if($_SESSION['schoolid']){
            $this->assign('schoolid',$_SESSION['schoolid']);
            $this->assign('classid',$_SESSION['classid']);
        }else{
            $tinfo = M("teacher_class")->where("teacherid = '$userid'")->find();
            $this->assign('schoolid',$tinfo['schoolid']);
            $this->assign('classid',$tinfo['classid']);
        }
		$this->display();
	}
	//课件详情
	public function details(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION['userid'];
        if($_SESSION['schoolid']){
            $this->assign('schoolid',$_SESSION['schoolid']);
            $this->assign('classid',$_SESSION['classid']);
        }else{
            $tinfo = M("teacher_class")->where("teacherid = '$userid'")->find();
            $this->assign('schoolid',$_SESSION['schoolid']);
            $this->assign('classid',$tinfo['classid']);
        }

		$subjectid=I("id");
		$shuliang=I("shuliang");
		$this->assign("subjectid",$subjectid);
		$this->assign("shuliang",$shuliang);
		$this->display("kejian");
	}
	public function add(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);

        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $userid = $_SESSION['userid'];
        if($_SESSION['schoolid']){
            $this->assign('schoolid',$_SESSION['schoolid']);
        }else{
            $schoolid = M("teacher_class")->where("teacherid = '$userid'")->find();
            $this->assign('schoolid',$schoolid['schoolid']);
        }

        $this->assign('userid',$_SESSION['userid']);
		$this->display("Answer_publish");
	}
}

