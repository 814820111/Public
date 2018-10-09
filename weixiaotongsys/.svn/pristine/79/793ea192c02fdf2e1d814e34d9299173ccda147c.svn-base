<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class BabyFriendController extends WeixinbaseController {

	//宝宝好友渲染控制器
	//http://localhost/weixiaotong2016/index.php/weixin/BabyFriend/index
	//宝宝好友
	public function index(){
		$this->display();
	}
	//班级成员渲染控制器
	public function strudentList(){
		$classid=I("classid");
		//班级ID
		$ids=I("ids");
		$studentid=I("studentid");
		//学生ID
		$this->assign("studentid",$studentid);
		$this->assign("ids",$ids);
		$this->assign("classid",$classid);
		$this->display();
	}
	public function babyGrow(){ 

		$this->display();
	}	
}
?>