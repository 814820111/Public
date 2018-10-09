<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchCourseController extends WeixinbaseController {
	//班级课程
//	http://localhost/weixiaotong2016/index.php/weixin/TchCourse/course
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
	    $userid = $_SESSION['userid'];
	    $tinfo = M("teacher_class")->where("teacherid = '$userid'")->find();
	    $this->assign('schoolid',$tinfo['schoolid']);
	    $this->assign('classid',$tinfo['classid']);
		$this->display("banjiKecheng");
	}
}
?>