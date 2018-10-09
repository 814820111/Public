<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class LeaveMessageController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }
	public function index(){
		$userid=$_SESSION['USER_ID'];
		$message=M("leave_message")->where("userid=$userid")->order("create_time DESC")->select();
		$this->assign("message",$message);
		$this->display();
	}
	public function add(){
		$userid=$_SESSION['USER_ID'];
		$question=I("question");
		$data["userid"]=$userid;
		$data["message"]=$question;
		$data["create_time"]=time();
		$add=M("leave_message")->add($data);
		if($add){
			$this->success("发送成功");
		}else{
			$this->error("发送失败");
		}
	}
}