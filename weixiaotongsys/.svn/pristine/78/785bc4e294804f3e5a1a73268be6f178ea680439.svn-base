<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchInformationController extends WeixinbaseController {
	//老师消息渲染控制器
	//localhost/weixiaotong2016/index.php/weixin/TchInformation/index
	public function index(){
		$this->display("Massage");
	}
	//详情控制器
	public function Xiang(){
		$name=I("name");
		//发布人的名字
		$content=I("content");
		//发布的内容
		$time=I("time");
		//发布的时间
		$diees=I("diees");
		//发布的照片的组
		$shuliang=I("shuliang");
		//总人数
		$yidu=I("yidu");
		//已读的人数
		$weidu=$shuliang-$yidu;
		//未读的人数
		$photo=I("photo");
		
			 $subContent = explode ( '1163317574', $diees );
              
           	 if($subContent[1]==""){
           	 	$sub=1;
           	 }else{
           	 	$subContent=$subContent;
           	 	 array_shift($subContent);
           	 	$sub=0;
           	 }
        $this->assign("sub",$sub);
		$this->assign("name",$name);
		$this->assign("content",$content);
		$this->assign("time",$time);
		$this->assign("subContent",$subContent);
		$this->assign("shuliang",$shuliang);
		$this->assign("yidu",$yidu);
		$this->assign("weidu",$weidu);
		$this->display("Message_xiang");
	}
	public function Huoqu(){
		$this->display("Massagehuoquxiaoxi");
	}
	public function details(){
		   	$name=$_GET["id"];
    	$content=$_GET["content"];
    	$message_time=$_GET["message_time"];
    	$message_id=$_GET["message_id"];
    	$message=$_GET["messages"];
    	$receiver_user_id=$_GET["receiver_user_id"];
    	$diees=$_GET["diees"];
    	$photo=$_GET["photo"];
    	$Zong=I("zong");
    	$Yidu=I("yidu");
  	    $Weidu=$Zong-$Yidu;
           
           	 $subContent = explode ( '1163317574', $diees );
              
           	 if($subContent[1]==""){
           	 	$sub=1;
           	 }else{
           	 	$subContent=$subContent;
           	 	 array_shift($subContent);
           	 	$sub=0;
           	 }
        $this->assign("Zong",$Zong);
        $this->assign("Yidu",$Yidu); 
        $this->assign("Weidu",$Weidu);    	 
        $this->assign("photo",$photo);
        $this->assign("sub",$sub);
	    $this->assign("name",$name);
	    $this->assign("content",$content);
	    $this->assign("message_time",$message_time);
	    $this->assign("message_id",$message_id);
	    $this->assign("message",$message);
	    $this->assign("receiver_user_id",$receiver_user_id);
	    $this->assign("subContent",$subContent);
	    $this->assign("subC",$subC);
    	$this->display("xiaoxixiangqing");
    }
    //添加群发信息
    public function Qunfa(){
    
    	$this->display("Answer_publish");
    }
    public function Parentfabu(){
    	$this->display("Answer_Parent");
    }
	
}
?>