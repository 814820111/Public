<?php
	namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchcommentController extends WeixinbaseController {
	//教师端老师点评
	//localhost/weixiaotong2016/index.php/weixin/Tchcomment/index
	public function Tiaoshu (){
		$name=I("name");
		$id=I("id");//学生id
		$this->assign("id",$id);
		$this->assign("name",$name);
		$this->display("laoshidianping");
	}
	//老师添加渲染页面
	public function xuAnz(){
		$this->display("xuanzexuesheng");
	}
	//老师点评列表页面
	public function LeiBao(){
		$endtime=I("endtime");//结束的时间戳
		$id=I("id");//学生ID;
		$begintime=I("begintime");//开始的时间戳
		$chang=I("chang");//数组的长度
		$this->assign("chang",$chang);
		$this->assign("endtime",$endtime);
		$this->assign("id",$id);
		$this->assign("begintime",$begintime);
		$this->display("laoshidianpingleibao");
		
	}
	//点评的条数
	public function index(){
		$this->display("dianping_child");
	}
}
?>