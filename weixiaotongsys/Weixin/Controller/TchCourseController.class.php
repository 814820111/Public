<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchCourseController extends WeixinbaseController {
	//班级课程
//	http://localhost/weixiaotong2016/index.php/weixin/TchCourse/course
	public function index(){
		$this->display("banjiKecheng");
	}
}
?>