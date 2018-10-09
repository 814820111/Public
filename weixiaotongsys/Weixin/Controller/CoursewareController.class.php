<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class CoursewareController extends WeixinbaseController {
	
//	http://localhost/weixiaotong2016/index.php/weixin/Courseware/index
//班级课件渲染控制器
	public function index(){
		$this->display();	
	}
	//课件的展示页面渲染控制器
	public function details(){
		//课件的内容
		$cout=$_GET['cout'];
		$subContent = explode ( '1163317574', $cout );
		array_shift($subContent);
		//课件的标题
		$courseware=$_GET['courseware'];
		$subConten=explode('1163317574',$courseware);
		array_shift($subConten);
		//老师的名字
		$name=$_GET['name'];
		$subConname=explode('1163317574',$name);
		array_shift($subConname);
		//老师的头像照片
		$photoe=$_GET['photoe'];
		$subConphotoe=explode('1163317574',$photoe);
		array_shift($subConphotoe);
		//老师的职务
		$duty=$_GET['duty'];
		$subConduty=explode('1163317574',$duty);
		
		array_shift($subConduty);
		
		 $fatherArray = array();
		 //内容建名
		 $AddendGroup = 'zone_zilei';
		 //标题的建名
	     $fui='zoue_cout';
	     //名字的建名
	     $namei='zone_name'; 
	     //发布人的头像照片
	     $zhaopian='zone_photo';
	     //发布人的职位
	     $zhiwei="zone_duty";
	  foreach($subContent as $key=>$val){
	      $fatherArray[$key][$AddendGroup]=$subContent[$key];
  
      }
       foreach($subConten as $key=>$val){
	      $fatherArray[$key][$fui]=$subConten[$key];
  
      }
         foreach($subConname as $key=>$val){
	      $fatherArray[$key][$namei]=$subConname[$key];
  
      }
       foreach($subConphotoe as $key=>$val){
	      $fatherArray[$key][$zhaopian]=$subConphotoe[$key];
  
      }
       foreach($subConduty as $key=>$val){
	      $fatherArray[$key][$zhiwei]=$subConduty[$key];
  
      }
         
      
    
//	        echo "<pre>";
//            print_r($fatherArray);die(); // or var_dump()
//            echo "</pre><br>";
       
          
        $this->assign("fatherArray",$fatherArray);   
		$this->display();
		
	}
}
?>