<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class AnswerController extends WeixinbaseController {
	//代接控制器
	//http://localhost/weixiaotong2016/index.php/weixin/Answer/index
	//当天待处理的渲染页面
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("studentid",$_SESSION['studentid']);
        $this->assign("userid",$_SESSION['userid']);
        $this->assign("schoolname",$stu_sch_name);
		$this->display('dai-daichuli');
	}
	//已完成的渲染
	public function  pccept(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("studentid",$_SESSION['studentid']);
        $this->assign("userid",$_SESSION['userid']);
        $this->assign("schoolname",$stu_sch_name);
		$this->display("dai-yiwancheng");
	}
	//未处理的代接信息
	public function Untreateds(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("studentid",$_SESSION['studentid']);
        $this->assign("userid",$_SESSION['userid']);
        $this->assign("schoolname",$stu_sch_name);
		$this->display("Untreated");
	}
}
?>