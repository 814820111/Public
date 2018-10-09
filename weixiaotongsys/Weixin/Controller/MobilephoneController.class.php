<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class MobilephoneController extends WeixinbaseController {
	//通讯录渲染页面
	//	localhost/weixiaotong2016/index.php/weixin/Mobilephone/index
	public function index(){
		$this->display("tongxun-laoshi");
	}
	public function Parent(){
		$this->display("tongxun-jiazhang");
	}
}
?>