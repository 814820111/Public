<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class BabyController extends WeixinbaseController {
	//宝宝好友渲染控制器
	//http://localhost/weixiaotong2016/index.php/weixin/Baby/index
	//宝宝好友
	public function index(){
		$this->display("babyhaoyou");
	}
	//班级成员渲染控制器
	public function chenGruan(){
		
		$this->display("banjichengyuan");
	}
	public function haoYou(){
		$this->display("chengzhangriji");
	}	
}
?>