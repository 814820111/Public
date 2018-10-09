<?php
/**
 * Created by PhpStorm.
 * User: 消息渲染
 * Date: 2017/2/14
 * Time: 15:21
 */
//  localhost/weixiaotong2016/index.php/weixin/Information/index
//消息
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class InformationController extends WeixinbaseController {
	//消息的渲染页面
    public function index(){
        
       
        $this->display("Massage");
    }
    //消息详情渲染页面
    public function details(){
    	$name=$_GET["id"];
    	$content=$_GET["content"];
    	$message_time=$_GET["message_time"];
    	$message_id=$_GET["message_id"];
    	$message=$_GET["message"];
    	$receiver_user_id=$_GET["receiver_user_id"];
    	$diees=$_GET["diees"];
    	$photo=$_GET["photo"];
//  	echo $name;die();

       		 $subContent = explode ( '1163317574', $diees );
		     $fatherArray = array();
	         $AddendGroup = 'zone_zilei';
	    
	    	  foreach($subContent as $key=>$val){
	           $parentId = $val[$key];
	             if($parentId!=""){
	    	$subContent[$key][$AddendGroup] = array();
	    	    $fatherArray[]=$subContent[$key];
	                }
               }
	    $subC=count($subContent)-1;
	    
	   
	    $this->assign("name",$name);
	    $this->assign("content",$content);
	    $this->assign("message_time",$message_time);
	    $this->assign("message_id",$message_id);
	    $this->assign("message",$message);
	    $this->assign("receiver_user_id",$receiver_user_id);
	    $this->assign("fatherArray",$fatherArray);
	    $this->assign("subC",$subC);
    	$this->display("xiaoxixiangqing");
    }
}