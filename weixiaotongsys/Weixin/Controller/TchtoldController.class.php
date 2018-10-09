<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchtoldController extends WeixinbaseController {
	//教师控制器老师叮嘱
	//localhost/weixiaotong2016/index.php/weixin/Tchtold/index
	public function index(){
		$this->display("jiazhangdingzhu");
	}
}
?>