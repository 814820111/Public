<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
//	localhost/weixiaotong2016/index.php/weixin/Told/index
//家长叮嘱
class ToldController extends WeixinbaseController {
	public function index(){
		
		$this->display("jiazhangdingzhu");
		
	}
	
}
?>