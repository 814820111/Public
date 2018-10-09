<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class ReplaceController extends WeixinbaseController {
	//代接控制器
	//http://localhost/weixiaotong2016/index.php/weixin/Replace/Handle
	//当天待处理的渲染页面
	public function Handle(){
	
		$this->display();
	}
	//已完成的渲染
	public function  Finish(){
		$this->display();
	}
	//未处理的代接信息
	public function Overdue(){
		
		$this->display();
	}
}
?>