<?php

/**
 * 我的班级
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class MyClassController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();

    }
  public function index()
	{
 
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
       'photo'=>$_POST['smeta']['thumb'] ,

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