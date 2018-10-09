<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class AnswerController extends WeixinbaseController {
	//代接控制器
	//http://localhost/weixiaotong2016/index.php/weixin/Answer/index
	//当天待处理的渲染页面
	public function index(){
	
		$this->display('dai-daichuli');
	}
	//已完成的渲染
	public function  pccept(){
		$this->display("dai-yiwancheng");
	}
	//未处理的代接信息
	public function Untreateds(){
		
		$this->display("Untreated");
	}
}
?>