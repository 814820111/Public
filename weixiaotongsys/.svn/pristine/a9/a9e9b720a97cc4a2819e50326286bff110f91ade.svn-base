<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class CourseController extends WeixinbaseController {
	//班级课程
//	http://localhost/weixiaotong2016/index.php/weixin/Course/course
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $this->assign("classid",$_SESSION['classid']);
        //查询学校的id
        $school_info= M("class_relationship")->where(array("userid"=>$_SESSION["studentid"],"classid"=>$_SESSION["classid"]))->find();
        $schoolid =$school_info["schoolid"];
        $this->assign("schoolid",$schoolid);
        $this->display("banjiKecheng");
	}
}
?>