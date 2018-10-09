<?php

/**
 * 老师填写
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class TeacherFillController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }

  public function index()
  {    
      
         $gradeid  = I('grade');
         // var_dump($gradeid);

         if($gradeid)
         {
          $where['ag.gradeid'] = $gradeid;
          $this->assign("grade_info",$gradeid);
         }

        	 $schoolid=$_SESSION['schoolid'];
        	 $where['a.schoolid'] = $schoolid;
          $where['g.schoolid'] = $schoolid;




      if($this->level!=1  && $this->level!=2)
      {
//          $map['ay.userid'] = $this->userid;
          $grade_q=Array();
          $class_q=M("teacher_class")
              ->alias('t')
              ->join("wxt_school_class s ON t.classid=s.id")
              ->where("t.teacherid=$this->userid")
              ->field("s.classname,s.id,s.grade")
              ->order("id")->select();

          foreach ($class_q as $item){
              $item_gid= $item['grade'];

//              $grade_item = M("school_grade")->where("gradeid=$item_gid and schoolid = $schoolid")->getF();
              array_push($grade_q,$item_gid);
//              unset($grade_item);
          }

          $teacher_grade = array_unique($grade_q);
          $where['g.gradeid'] = array("in",$teacher_grade);

      }


      $teacher_fill = M('archives_grade')
        	           ->alias("ag")
        	           ->where($where)
        	           ->join("wxt_school_grade g ON g.gradeid=ag.gradeid")
        	           ->join("wxt_archives a ON  ag.archivesid=a.id")
                       ->join("wxt_semester s ON a.semesterid=s.id")
        	           ->field("ag.name,s.semester,g.name as g_name,a.create_time,a.id,ag.gradeid")
        	           ->select();

        foreach ($teacher_fill as &$value){
          $gradeid = $value['gradeid'];  

          $school_class = M('school_class')->where("schoolid = $schoolid and grade = $gradeid ")->field('id')->select();


          $send  = M('archives_student')->where("gradeid = $gradeid and schoolid = $schoolid and send = 2")->count();
          
            $student_sum="";
        
          foreach ($school_class as $val) {
             $classid = $val['id'];
             
            $class = M('class_relationship')->where("classid = $classid and schoolid = $schoolid")->count();
            
            $student_sum = $class+$student_sum;
            //todo还没计算出已经发送的学生
          $value['sum'] =$send.'个已发送'.'/'.'共'.$student_sum.'个学生';

        }
       
      }

      //学期

      // var_dump($teacher_fill);
      $grade = M('school_grade')->where("schoolid = $schoolid")->select();
     // var_dump($grade);
    $this->assign('grade',$grade);
    $this->assign("list",$teacher_fill);
    // var_dump($teacher_fill);
    $this->display();


  }


 public function show()
 {

  $schoolid=$_SESSION['schoolid'];
  // var_dump($schoolid);

 	$archivesid = I('id');


  $gradeid = I('gradeid');


  $studentname = I('studentname');
  // var_dump($studentname);
  // var_dump($gradeid);

  if ($studentname) {
   $where["s.stu_name"]=array("LIKE","%".$studentname."%");
  }

  // var_dump($archivesid);
 	$where['a.archivesid'] = $archivesid;
  $where['a.schoolid'] = $schoolid;
  $where['g.schoolid'] = $schoolid;
  $where['a.gradeid'] = $gradeid;


     if($this->level!=1  && $this->level!=2)
     {
         $where['teacher.schoolid'] = $schoolid;
         $where['teacher.teacherid'] = $this->userid;
         $join_duty = 'wxt_teacher_class teacher ON a.classid=teacher.classid';

     }






 $count = M('archives_student')
       ->alias("a")
       ->where($where)
       ->join("wxt_student_info s ON s.userid = a.studentid")
       ->join("wxt_school_class c ON c.id = a.classid ")
       ->join($join_duty)
       ->join("wxt_school_grade g ON g.gradeid = a.gradeid")
       ->field("a.id,a.archivesid,a.studentid,s.stu_name,g.name as grade_name,s.classname")
       ->count();
$page = $this->page($count, 15);



  // var_dump($where);
 $list = M('archives_student')
       ->alias("a")
       ->where($where)
       ->limit($page->firstRow . ',' . $page->listRows)
       ->order('a.classid')
       ->join($join_duty)
       ->join("wxt_school_class c ON c.id = a.classid ")
       ->join("wxt_student_info s ON s.userid = a.studentid")
       ->join("wxt_school_grade g ON g.gradeid = a.gradeid")
       ->field("a.id,a.archivesid,a.studentid,s.stu_name,g.name as grade_name,c.classname,a.gradeid")
       ->select();

 foreach ($list as $key => &$value){

   $gradeid = $value['gradeid'];
// var_dump($gradeid);
   $studentid = $value['studentid'];

   $archivesid = $value['archivesid'];

   //主号码只会有一条所以这里只查询一条
   $student_info = M('relation_stu_user')->where("studentid=$studentid and type = 1")->field("name,phone")->find();

   $value['parent'] = $student_info['name'];
   $value['phone'] = $student_info['phone'];
   
            $where_tea['studentid'] = $studentid;
            $where_tea['archivesid'] = $archivesid;
            $where_tea['schedule'] = 1;
            $where_tea['writen'] = 1;
            // $where_count['type'] = 1;
             $tea_sum = M('archives_student_page')->where($where_tea)->count();
    
         
            $where_par['studentid'] = $studentid;
            $where_par['archivesid'] = $archivesid;
            $where_par['schedule'] = 1;
            $where_par['writen'] = 2;
            // $where_count['type'] = 1;
             $par_sum = M('archives_student_page')->where($where_par)->count();




   //查出该档案的总页数
   $archives_detail = M('archives_book')->where("archivesid = $archivesid and gradeid = $gradeid")->field("count(1) as sum")->group('writer')->select();

 
   // exit();



            if(!$archives_detail[0]['sum'])
            {
                $archives_detail[0]['sum'] = 0;
            }


            if(!$archives_detail[1]['sum'])                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
            {
                $archives_detail[1]['sum'] = 0;
            }
            $value['tea_sum'] = $tea_sum.'/'.$archives_detail[0]['sum'];
            $value['par_sum'] = $par_sum.'/'.$archives_detail[1]['sum'];

 }
 // var_dump($list);

  $this->assign("gradeid",$gradeid);
  $this->assign("archivesid",$archivesid);
  $this->assign("Page", $page->show('Admin'));
  $this->assign('list',$list);
 	$this->display();
 }



}