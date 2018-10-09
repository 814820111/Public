<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class NoticeController extends WeixinbaseController {
	
	
	//http://   localhost/weixiaotong2016/index.php/weixin/Notice/index
	//通知公告渲染控制器
	public function index(){
		
		$this->display();
		
	}
	public function details(){
		$title=$_GET['title'];
		//标题
		$content=$_GET['content'];
		//内容
		$name=$_GET['name'];
		//名字
		$Img=$_GET['cmg'];
		//照片
		$Tmie=$_GET['time'];
		//公告发布的时间
		$photo=$_GET['photo'];
	     //发布公告的图片头像地址
	    $user=$_GET['user'];
//	    //用户的ID
	    $noticeid=$_GET['noticeid'];
	    //公告的ID
	   
	   //判断有没有读的时间
	   $create_time=$_GET['create_time'];
	   $zongshu=I("zongshu");
	  $yushu=I("yushu");
	  $weidu=$zongshu-$yushu;
	      $subContent = explode ( '1163317574', $Img );
	     
           	 if($subContent[1]==""||$subContent[1]=="null"){
           	 	$sub=1;
           	 }else{
           	 	$subContent=$subContent;
           	 	 array_shift($subContent);
           	 	$sub=0;
           	 }
           	  
        $this->assign("sub",$sub);
	     $this->assign("create_time",$create_time);
	     $this->assign("user",$user);
	     $this->assign("photo",$photo);
		$this->assign("nanm",$nanm);
	
		$this->assign("title",$title);
		$this->assign("content",$content);
		$this->assign("subContent",$subContent);
		$this->assign("Tmie",$Tmie);
		$this->assign("noticeid",$noticeid);
		$this->assign("zongshu",$zongshu);
		$this->assign("yushu",$yushu);
		$this->assign("weidu",$weidu);
		$this->display();
	}
}
?>