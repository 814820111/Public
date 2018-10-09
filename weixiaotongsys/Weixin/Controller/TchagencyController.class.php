<?php
	namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchagencyController extends WeixinbaseController {
	//教师端老师代办事宜
	
	public function index(){
		$this->display("daibanshi");
	}
}

?>