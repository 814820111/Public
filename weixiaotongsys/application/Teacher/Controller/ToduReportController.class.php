<?php

/**
 *   教学办公-》工作事务-》工作周报
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class ToduReportController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }

    public function index()
    {   
      $schoolid = $_SESSION['schoolid'];
     
     $search_grade = I("school_grade");


    $teacher_name=I("teacher_name");

       $this->assign("gradeinfo",$search_grade);

     $search_class = I("school_class"); 

       $begin_time=strtotime(I("begin_time"));

        $end_time=strtotime(I("end_time"));

       if($begin_time && $end_time)
       {
        $where['w.begintimeint']  = array('GT',$begin_time);
  
        $this->assign("begin_time",date('Y-m-d',$begin_time));
        $where['w.endtimeint'] = array('LT',$end_time); 

        $this->assign("end_time",date('Y-m-d',$end_time));

       } 

         if($search_grade && !$search_class)
        {  
            $this->assign("gradeinfo",$search_grade);
            $class_arr = array();
            $school_class =M("school_class")->where("schoolid = $schoolid and grade = $search_grade")->field("id")->select();
            if($school_class){

            foreach ($school_class as $key => $value) {
               array_push($class_arr,$value['id']);
            }
            // var_dump($class_arr);

       
            $where['w.classid'] = array("in",$class_arr);
           }
        }


        if($search_class){

             $this->assign("search_class",$search_class);
          
            $where['w.classid'] = $search_class;


        }
          if($teacher_name){
            $where["u.name"]=array("LIKE","%".$teacher_name."%");
            $this->assign("teacher_name",$teacher_name);
        }


        if($this->level!=1  && $this->level!=2)
        {
            $where['w.teacherid'] = $this->userid;


        }

          $where['w.schoolid'] = $schoolid;  
		      $weekly = M('school_weekly')
		      ->alias("w")
		      ->where($where)
		      ->join("wxt_wxtuser u ON u.id=w.teacherid")
		      ->field("w.classid,begintime,endtime,contents,u.name,w.id")
		      ->select();

      foreach ($weekly as &$value) {
        $classid = $value['classid'];

        $school_class = M("school_class")
                        ->alias("c")
                        ->where("c.schoolid=$schoolid and g.schoolid=$schoolid and c.id = $classid")
                        ->join("wxt_school_grade g ON g.gradeid = c.grade")
                        ->field("c.classname,g.name")
                        ->select();

                        foreach ($school_class as $key => $val) {
                        	 $value['classname'] = $val['classname'];
                        	 $value['grade'] = $val['name'];
                        }
   
      }
        //var_dump($weekly);
        $grade = M('school_grade')->where("schoolid = $schoolid")->select();
         
 
        $this->assign("grade",$grade);
            
        $this->assign("weekly",$weekly);
    	$this->display();
    }
   



   public function add()
   {
       $schoolid = $_SESSION['schoolid'];

       if($this->level!=1  && $this->level!=2)
       {
           $where['t.teacherid'] = $this->userid;


       }
       $where['t.schoolid'] = $schoolid;

       $grade = M('school_grade')->where("schoolid = $schoolid")->select();

       $teachers = M('teacher_info')->alias("t")->where($where)->join("wxt_wxtuser u ON u.id=t.teacherid ")->field("u.id,t.name")->select();

      // var_dump($grade);
      
      // var_dump($teachers);
      $this->assign("teachers",$teachers);
      $this->assign("categorys",$grade);   
      $this->display();
   }

   public function add_post()
   {   

   	   $schoolid = $_SESSION['schoolid'];
       $class = I('class');
     

       $begintime = I('begintime');
     

       $endtime = I('endtime');



       $teacherid = I('teacher');

 

       $content = I('content');

  
   
       // exit();


      $data = array(
       'schoolid'=>$schoolid,
       'classid'=>$class,
       'teacherid'=>$teacherid,
       'begintime'=>$begintime,
       'begintimeint'=>strtotime($begintime),
       'endtime'=>$endtime,
       'endtimeint'=>strtotime($endtime),
       'contents'=>$content,
       'createtime'=>time(),  

      	);
      // var_dump($data);
      // exit();
   $weekly_add = M('school_weekly')->add($data);
	  
	   if($weekly_add){
	      $this->success("添加成功!");
	     }else{
          $this->error("添加失败");
	     }


   }


   public function delete()
   {
   	$id = I('id');


   	$delete = M('school_weekly')->where("id=$id")->delete();
   }

}