<?php

/**
 * 体检结果
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class PhySicalController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }
 
   public function index()
   {

    $studentname = I('studentname');

   if ($studentname) {
   $where["stu_name"]=array("LIKE","%".$studentname."%");
  }

    $schoolid=$_SESSION['schoolid'];

       if($this->level!=1  && $this->level!=2)
       {
           $where['teacher.schoolid'] = $schoolid;
           $where['teacher.teacherid'] = $this -> userid;
           $join_duty = 'wxt_teacher_class teacher ON s.classid=teacher.classid';


       }

    $where['schoollid'] = $schoolid;


    $count = M('student_info')
            ->alias("s")  
            ->where($where)
            ->join($join_duty)
            ->field("userid as id,stu_name")
            ->count();

   $page = $this->page($count, 15);

   $student = M('student_info')
            ->alias("s")  
            ->where($where)
            ->join($join_duty)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("userid as id,stu_name")
            ->select();
    // var_dump($student);
  $physical = M('checkup')->where("schoolid = $schoolid")->select();

  foreach ($student as $key => &$value) {

  	foreach ($physical as $key => &$val) {
  		if($value['id']==$val['studentid'])
  		{
  			$value['height'] = $val['height'];
  			$value['weight'] = $val['weight'];
  			$value['seeingleft'] = $val['seeingleft'];
  			$value['seeingright'] = $val['seeingright'];
  			// break;
  		}
  		// if($value['id']!==$val['studentid'])
  		// {
  		// 	$value['status'] = 1;
  		// 	break;
  		// }


  	 }
  }
  // var_dump($student);

    $this->assign('list',$student);
    $this->assign("Page", $page->show('Admin'));
    $this->display();
   }
  


	public function add()
	{  
	  $userid = I('id');


	   $student = M('student_info')->where("userid = $userid")->field("stu_name")->find();
	  
	   $name = $student['stu_name'];

	   $this->assign('name',$name);
	   $this->assign('userid',$userid);
		$this->display();
	}
   
   public function add_post()
   {   

   	   $schoolid=$_SESSION['schoolid'];

       $userid = I('userid');
       $height = I('height');
       $weight = I('weight');
       $seeingleft = I('seeingleft');
       $seeingright = I('seeingright');

       $data = array(
        'schoolid'=>$schoolid,
        'studentid'=>$userid,
        'height'=>$height,
        'weight'=>$weight,
        'seeingleft'=>$seeingleft,
        'seeingright'=>$seeingright

       	);
      
       $physical = M('checkup')->add($data);

       if($physical)
       {
       	$this->success('创建成功','index');
       }else{
       	$this->error('创建失败');
       }




   }
  
  public function edit()
  {   
  	$schoolid=$_SESSION['schoolid'];
      $studentid = I('studentid');


       $height = I('height');

       $weight = I('weight');
 
       $seeingleft = I('seeingleft');
       $seeingright = I('seeingright');
       // exit();
  
  if($studentid)
  {
  	$data = array(
      'height'=>$height,
      'weight'=>$weight,
      'seeingleft'=>$seeingleft,
      'seeingright'=>$seeingright
  		);

  	$save = M('checkup')->where("schoolid=$schoolid and studentid = $studentid")->save($data);
  	if($save)
  	{
  		$this->success('修改成功','index');
  	}
  }else{

  	$this->error('数据不存在');
  }



  }



}