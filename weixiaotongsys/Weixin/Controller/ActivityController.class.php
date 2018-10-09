<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class ActivityController extends WeixinbaseController {
//	localhost/weixiaotong2016/index.php/weixin/Activity/index
	//班级活动控制器
	   public function index(){
	   	$this->display();
	   }
	
	public function details(){
		//活动开始的时间
		$begintime=$_GET["id"];
		//活动结束的时间
		$endtime=$_GET["endtime"];
		//活动报名的时间
		$starttime=$_GET["starttime"];
		//活动结束的时间
		$finishtime=$_GET["finishtime"];
		//活动的标题
		$tiet=$_GET["title"];
		//活动的内容
		$content=$_GET["content"];
		//发起活动的有没有报名的状态
		$diees=$_GET["diees"];
		//发起次活动的时间
		$shijian=$_GET["shijian"];
		//发起活动让的头像照片
		$zhaopian4=$_GET["zhaopian4"];
		// 发起活动的让名字
		$shuzhu4=$_GET["shuzhu4"];
		//发起活动照片数组
		$isapply=$_GET["isapply"];
		//是否报名
		$contactphone=$_GET["contactphone"];
		//发起活动人的号码
		$userid=$_GET['userid'];
		$nuMber=I("rshu"); 
		$receiverid=$_GET["receiverid"];
		      $subContent = explode ( '1163317574', $diees );
	     
           	 if($subContent[1]==""||$subContent[1]=="null"){
           	 	$sub=1;
           	 }else{
           	 	$subContent=$subContent;
           	 	 array_shift($subContent);
           	 	$sub=0;
           	 }
        $this->assign("nuMber",$nuMber);   	  
        $this->assign("sub",$sub);
	 
	    //遍历数组去掉空数组
		$this->assign("title",$tiet);
		$this->assign("content",$content);
		$this->assign("zhaopian4",$zhaopian4);
		$this->assign("shuzhu4",$shuzhu4);
		$this->assign("shijian",$shijian);
		$this->assign("begintime",$begintime);
		$this->assign("endtime",$endtime);
		$this->assign("starttime",$starttime);
		$this->assign("finishtime",$finishtime);
		$this->assign("isapply",$isapply);
		$this->assign("contactphone",$contactphone);
		$this->assign("subContent",$subContent);
	    $this->assign("subC",$subC);
		$this->assign("receiverid",$receiverid);
		$this->assign("userid",$userid);
		$this->display();
	}	
}
?>