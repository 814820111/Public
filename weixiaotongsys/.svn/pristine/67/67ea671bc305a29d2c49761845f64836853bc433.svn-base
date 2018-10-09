<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class ClassalbumController extends WeixinbaseController {

	//localhost/weixiaotong2016/index.php/weixin/Classalbum/index
	//班级相册的渲染页面
	public function index(){
		$this->display("banjixiangce");
	}
	//班级相册
	public function xiangceqing(){
           //发布相册的时间
           $write_time=I("write_time");
           //发布班级相册的让的ID
           $userid=I("userid");
           //该信息的ID
           $mid=I("mid");
          //消息类型
          $types=I("type");
          
          $this->assign("types",$types);
           $this->assign("mid",$mid);
           $this->assign("userid",$userid);
		$this->display("xiangcexiangqing");
	}
	//宝宝相册
	public function baobao(){
		$this->display("baobaoxiangce");
	}
}

?>