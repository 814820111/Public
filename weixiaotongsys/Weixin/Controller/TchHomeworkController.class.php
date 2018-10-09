<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchHomeworkController extends WeixinbaseController {
	//教师端作业
	public function index(){
		$this->display("zuoye");
	}
	public function add(){
		$this->display("Answer_Parent");
	}
	}	

?>