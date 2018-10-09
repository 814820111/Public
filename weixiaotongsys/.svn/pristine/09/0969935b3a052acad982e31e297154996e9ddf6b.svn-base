<?php
	namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchActivityController extends WeixinbaseController {
	//教师端班级活动
	public function index(){
		$this->display("banjiHuodong");
	}
	//以报名的人数
	
	//已读未读
	public function details(){
		
		$id=I("id");
	    $type=I("type");
		$this->assign("id",$id);
		$this->assign("type",$type);
		$this->display("yidu");
	}
	public function Qing(){
		$id=I("id");
		$this->assign("id",$id);
		$this->display("huodongxiangqing");
	}
	public function  Addnswer(){
		$this->display("Answer_Parent");
	}
}
?>