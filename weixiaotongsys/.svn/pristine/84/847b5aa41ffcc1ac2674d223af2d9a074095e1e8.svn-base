<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TaskController extends WeixinbaseController {
	//localhost/weixiaotong2016/index.php/weixin/Task/index
	//作业
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display("zuoye");
	}
	public function details(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$title=$_GET["id"];
		$content=$_GET["content"];
		$subject=$_GET["subject"];
		$name=$_GET["name"];
		$create_time=$_GET["create_time"];
		$read_time=$_GET["read_time"];
		$diess=$_GET["diess"];
		$receiverid=$_GET["receiverid"];
		$homework_id=$_GET["homework_id"];
		$subContent = explode ( '1163317574', $diess );
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
	    $this->assign("receiverid",$receiverid);
	    $this->assign("homework_id",$homework_id);
	    $this->assign("title",$title);
	    $this->assign("content",$content);
	    $this->assign("subject",$subject);
	    $this->assign("name",$name);
	    $this->assign("create_time",$create_time);
	    $this->assign("read_time",$read_time);
	    $this->assign("fatherArray",$fatherArray);
	    $this->assign("subC",$subC);
		$this->display("zuoyexiangqing");
	}

    public function update()
    {
	    $result = M("teacher_info as a")->join("wxt_wxtuser as b on a.teacherid=b.id")->field("a.teacherid,b.name")->select();
	   // dump($result);
	    //die();
	    foreach ($result as $value){
	        $teacherid = $value["teacherid"];
	        $name = $value["name"];
	        $a = M("teacher_info")->where(array("teacherid"=>$teacherid))->save(array("name"=>$name));
        }


    }
}
?>