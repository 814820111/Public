<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class BabyFriendController extends WeixinbaseController {

	//宝宝好友渲染控制器
	//http://localhost/weixiaotong2016/index.php/weixin/BabyFriend/index
	//宝宝好友
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
	    $this->assign("studentid",$_SESSION['studentid']);
	    $studentid = $_SESSION['studentid'];
	    $classid = M("student_info")->where("id = '$studentid'")->find();
	    $this->assign('classid',$classid['classid']);
		$this->display();
	}
	//班级成员渲染控制器
	public function strudentList(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$classid=$_SESSION['classid'];
		//班级ID
		$ids=I("ids");
		$studentid=$_SESSION['studentid'];
		//学生ID
		$this->assign("studentid",$studentid);
		$this->assign("ids",$ids);
		$this->assign("classid",$classid);
		$this->display();
	}
	public function babyGrow(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $id=I("id");
        $this->assign("id",$id);
		$this->display();
	}

	//好友日记
	public function friendLog(){
		$stu_sch_name = $_SESSION["school_name"];
		$this->assign("schoolname",$stu_sch_name);
		$userid = $_SESSION["userid"];
		//$userid = $_GET['id'];
		$sid = $_SESSION['studentid'];
		//$studentid = $_SESSION['studentid'];
		$studentid = I('id');//好友ID

		$this->assign("userid",$userid);
		//获取学生姓名
		$stu_info = M("wxtuser")->where(array("id"=>$studentid))->find();
		$this->assign("name",$stu_info['name']);
		$this->assign("classid",$_SESSION['classid']);
		$this->assign("schoolid",$_SESSION['schoolid']);
		$this->assign("studentid",$studentid);

		//$info = M("wxtuser")->where(array("id"=>$userid))->find();//查找自己的信息
		$info = M("relation_stu_user")->where(array("studentid"=>$sid,"userid"=>$userid))->field("name")->find();//查找自己的信息
		$this->assign("username",$info['name']);//自己的姓名
		$this->display();
	}
}
?>