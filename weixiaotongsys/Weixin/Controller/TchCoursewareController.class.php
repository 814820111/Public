<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchCoursewareController extends WeixinbaseController {
	//教师端课件
	//localhost/weixiaotong2016/index.php/weixin/TchCourseware/index
	public function index(){
		$this->display();
	}
	public function details(){
		$subjectid=I("id");
		$shuliang=I("shuliang");
		$this->assign("subjectid",$subjectid);
		$this->assign("shuliang",$shuliang);
		$this->display("kejian");
	}
	public function add(){
		$this->display("Answer_publish");
	}
}
?>