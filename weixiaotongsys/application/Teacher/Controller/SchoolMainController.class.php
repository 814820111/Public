<?php

/**
 * 学长信息
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class SchoolMainController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();

    }
  public function index()
	{
     $schoolid=$_SESSION['schoolid'];
	$school = M('school')->where("schoolid=$schoolid")->find();

    $school_name = $school['school_name'];
    $photo = $school['photo'];
    // var_dump($photo);
    $introduce = $school['introduce'];
    // var_dump($introduce);
    //var_dump($school_name);
     $this->assign("school",$school_name);	
     $this->assign("photo",$photo);
     $this->assign("content",$introduce);
		 $this->display();
	} 
  

  public function add_post()
  {   

  	 $schoolid=$_SESSION['schoolid'];
       // var_dump($_POST);
       $introduce =$_POST['post']['post_content'];

       // var_dump($_POST['smeta']['thumb']);
       // var_dump($content);

 $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
      

    
      $data = array(
       'introduce'=>$introduce,
       'photo'=>$_POST['smeta']['thumb'],

      	);

    	$school = M('school')->where("schoolid=$schoolid")->save($data);
 

    if($school)
    {
    	$this->success("保存成功!");
    }else{
    	$this->error("保存失败");
    }

  }




}