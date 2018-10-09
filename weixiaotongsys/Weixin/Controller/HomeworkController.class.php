<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class HomeworkController extends WeixinbaseController {
	//	localhost/weixiaotong2016/index.php/weixin/Homework/index
	//作业
	public function index(){
		$this->display();
	}
	public function details(){
		$title=$_GET["id"];
		$content=$_GET["content"];
		$subject=$_GET["subject"];
		$name=$_GET["name"];
		$create_time=$_GET["create_time"];
		$read_time=$_GET["read_time"];
		$diess=$_GET["diess"];
		$receiverid=$_GET["receiverid"];
		$homework_id=$_GET["homework_id"];
		$photo=I("photo");
		$zongshu=I("zongshu");
		$yushu=I("yushu");
		$Wei=$zongshu-$yushu;
		   $subContent = explode ( '1163317574', $diess );
	     
           	 if($subContent[1]==""||$subContent[1]=="null"){
           	 	$sub=1;
           	 }else{
           	 	$subContent=$subContent;
           	 	 array_shift($subContent);
           	 	$sub=0;
           	 }
        $this->assign("zongshu",$zongshu);
        $this->assign("yushu",$yushu);
        $this->assign("Wei",$Wei) ;  	  
        $this->assign("sub",$sub);
	    $this->assign("photo",$photo);
	    $this->assign("receiverid",$receiverid);
	    $this->assign("homework_id",$homework_id);
	    $this->assign("title",$title);
	    $this->assign("content",$content);
	    $this->assign("subject",$subject);
	    $this->assign("name",$name);
	    $this->assign("create_time",$create_time);
	    $this->assign("read_time",$read_time);
	    $this->assign("subContent",$subContent);
	    $this->assign("subC",$subC);
		$this->display();
	} 
}
?>