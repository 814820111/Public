<?php
/**
 * Created by PhpStorm.
 * User: 消息渲染
 * Date: 2017/2/14
 * Time: 15:21
 */
//  localhost/weixiaotong2016/index.php/weixin/Message/index
//消息
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class MessageController extends WeixinbaseController {
	//消息的渲染页面
    public function index(){
        
       
        $this->display();
    }
    //消息详情渲染页面
    public function details(){
    	$name=$_GET["id"];
    	$content=$_GET["content"];
    	$message_time=$_GET["message_time"];
    	$message_id=$_GET["message_id"];
    	$message=$_GET["messages"];
    	$receiver_user_id=$_GET["receiver_user_id"];
    	$diees=$_GET["diees"];
    	$photo=$_GET["photo"];
    	$zong=I("zong");
    	$yidu=I("yidu");
    	$Weidu=$zong-$yidu;
//  	echo $name;die();
        
         	 $subContent = explode ( '1163317574', $diees );
              
           	 if($subContent[1]==""){
           	 	$sub=1;
           	 }else{
           	 	$subContent=$subContent;
           	 	 array_shift($subContent);
           	 	$sub=0;
           	 }
        $this->assign("Weidu",$Weidu);   	 
        $this->assign("yidu",$yidu);   	 
        $this->assign("zong",$zong);   	 
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
    	$this->display();
    }
}