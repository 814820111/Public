<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class CurriculumController extends WeixinbaseController {
	//班级课程
//	http://localhost/weixiaotong2016/index.php/weixin/Curriculum/course
	public function index(){
		$this->display("banjiKecheng");
	}
}
?>