<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class CoursewareController extends WeixinbaseController {
	
//	http://localhost/weixiaotong2016/index.php/weixin/Courseware/index
//班级课件渲染控制器
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $stuid = $_SESSION['studentid'];
        $this->assign("classid",$_SESSION['classid']);
//查询学校的id
        $school_info= M("class_relationship")->where(array("userid"=>$_SESSION["studentid"],"classid"=>$_SESSION["classid"]))->find();
        $schoolid =$school_info["schoolid"];
        $this->assign("schoolid",$schoolid);
		$this->display();	
	}
	//课件的展示页面渲染控制器
	public function details(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $subjectid=I("id");
        $shuliang=I("shuliang");
        $this->assign("subjectid",$subjectid);
        $this->assign("shuliang",$shuliang);
//        $this->display("kejian");
        $stuid = $_SESSION['studentid'];
        //查询学校的id
        $school_info= M("class_relationship")->where(array("userid"=>$_SESSION["studentid"],"classid"=>$_SESSION["classid"]))->find();
        $schoolid =$school_info["schoolid"];
        $this->assign("schoolid",$schoolid);
        $this->assign("classid",$_SESSION['classid']);
		$this->display("kejian");
		
	}
}
?>