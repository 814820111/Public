<?php

/**
 * 课件管理
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class ApplyController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }

  public function index()
  {
    $schoolid=$_SESSION['schoolid'];
     
    $issuer = I('issuer');
    if($issuer){
    	$where['d.name'] = array("LIKE","%".$issuer."%"); 
    }

      if($this->level!=1  && $this->level!=2)
      {
          $where['k.teacherid'] = $this->userid;


      }

     $ae = M('school_baomingarticle')->where("schoolid=$schoolid")->select();
     //var_dump($ae);
        $where["k.schoolid"]=$schoolid;
     //    	$where["k.teacherid"]=$t_id;
        	$article=M("school_baomingarticle")
        	->alias("k")
        	->join("wxt_teacher_info d ON k.teacherid=d.teacherid ")
        	->where($where)
        	->field("d.name,d.teacherid as ids,k.createtime,k.title,content,k.id")
        	->select();
        	// var_dump($article);
    
      $this->assign("article",$article);

     $this->display();
  }

  public function add()
  {

  	$schoolid=$_SESSION['schoolid'];

  	$school = M('school')->where("schoolid=$schoolid")->find();

  	$school_name = $school['school_name'];
  	//var_dump($school_name);
     $this->assign("school",$school_name);
  	$this->display();
  }
  
  public function add_post()
  {
    $schoolid=$_SESSION['schoolid'];
    // var_dump($schoolid);
    $teacherid=$_SESSION['USER_ID'];
    // var_dump($userid);
    $title = I('title');
    // var_dump($title);
    $content = I('content');  
    // var_dump($content);
    
	  $data['title'] = $title;
	  $data['content'] = $content;
	  $data['createtime'] =date('Y-m-d H:i:s');
	  $data['teacherid'] = $teacherid;
	  $data['schoolid'] = $schoolid; 


	  $article = M('school_baomingarticle')->add($data);

	  if ($article) {
	  	$this->success('发布成功');
	  }else{
	  	$this->error('发布失败');
	  }

  	// echo "Dasdsad";
  }
 
  public function delete()
  {
  	$id = I('id');
  	// var_dump($id);
  	$del = M('school_baomingarticle')->where("id = $id")->delete();

   if($del > 0){
   	$this->success('删除成功');
   }else{
   	$this->error('删除失败');
    }
  }


  public function edit()
  {
  	$id = I('id');
    

  	$schoolid=$_SESSION['schoolid'];

  	$school = M('school')->where("schoolid=$schoolid")->find();

  	$school_name = $school['school_name'];   

  	$message = M('school_baomingarticle')->where("id=$id")->find();

  	$title = $message['title'];

  	$content = $message['content'];

  	$id = $message['id'];

    $this->assign("id",$id);
    $this->assign("school",$school_name);
    $this->assign("title",$title);
    $this->assign("content",$content);
    $this->display();

  }

  public function edit_post()
  {
  	 $id = I('id');
  	 $title = I('title');
  	 $content = I('content');

  	 $data['title'] = $title;
  	 $data['content'] = $content;

  	 $save = M('school_baomingarticle')->where("id=$id")->save($data);
     // var_dump($save);

   if ($save > 0) {
   	$this->success('修改成功');
   }else{
   	$this->error('修改失败');
   }

  }


  public function list1()
  {
    $schoolid=$_SESSION['schoolid'];
    //var_dump($schoolid);
    $teacherid=$_SESSION['USER_ID'];
   
  
  $student_name = I("name");
  $phone = I('phone');

  if($student_name)
  {
    $where['k.name'] =array("LIKE","%".$student_name."%");
    $this->assign("name",$student_name);
  }
  
  if($phone)
  {
    $where['k.phone'] = array("LIKE","%".$phone."%");
    $this->assign("phone",$phone);
  }

  
   
         $where["d.schoolid"]=$schoolid;
     //    	$where["k.teacherid"]=$t_id;
        	$baoming=M("school_baoming")
        	->alias("k")
        	->join("wxt_school_baomingarticle d ON k.articleid=d.id ")
        	->where($where)
        	->field("k.name,sex,birthday,age,phone,qqnums,adress,result,remak,k.id") 
        	->select();
          $grade = M('school_grade')->where("schoolid = $schoolid")->select();
          
          $this->assign("grade",$grade);
          $this->assign('baoming',$baoming);
        	$this->display();
  }

  public function listdel()
  {
  	$id = I('id');
  	// var_dump($id);
  	$del = M('school_baoming')->where("id = $id")->delete();

   if($del > 0){
   	$this->success('删除成功');
   }else{
   	$this->error('删除失败');
    }
  }


}