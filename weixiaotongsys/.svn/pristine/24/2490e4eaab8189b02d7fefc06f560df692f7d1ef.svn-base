<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchnoticeController extends WeixinbaseController {
	//教师端通知公告
	//localhost/weixiaotong2016/index.php/weixin/Tchnotice/index
	public function index(){
		$this->display("tongzhigonggao");
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
             
           	 if($subContent[1]==""||$subContent[1]=="null"||$subContent[1]==null){
           	 	$sub=1;
           	 }else{
           	 	$subContent=$subContent;
           	 	 array_shift($subContent);
           	 	$sub=0;
           	 }
        $this->assign("sub",$sub);
	    //把多张图片的组合的字符变成照片组
	    
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
		
		$this->display("jiaotongzhixiangqing");
	}
	public function Tong(){
		$this->display("fabutongzhigonggao");
	}
	public function detailsI(){
			$title=I("title");
		//标题
		$content=I("content");
		//内容
		$name=I("username");
		//名字
		$create_time=I("create_time");//发布的时间
		$shuliang=I("shuliang");//总工接收的人数
		$yidu=I("yidu");//已经读的人数；
		$Weidu=$shuliang-$yidu;//未读的人数
		$avatar=I("avatar");
		$diees=I("diees");
		 $subContent = explode ( '1163317574', $diees );
             
           	 if($subContent[1]==""||$subContent[1]=="null"||$subContent[1]==null){
           	 	$sub=1;
           	 }else{
           	 	$subContent=$subContent;
           	 	 array_shift($subContent);
           	 	$sub=0;
           	 }
        $this->assign("subContent",$subContent);
		$this->assign("avatar",$avatar);   	 
        $this->assign("shuliang",$shuliang);
		$this->assign("Weidu",$Weidu);
		$this->assign("yidu",$yidu);   	 
        $this->assign("sub",$sub);
		$this->assign("title",$title);
		$this->assign("content",$content);
		$this->assign("name",$name);
		$this->assign("create_time",$create_time);
		$this->display("Izhigonggao");
	}
	public function addtianjia(){
		$this->display("Answer_Parent");
	}
	public function Answer(){
		$this->display("Answer_publish");
	}
	
}
?>