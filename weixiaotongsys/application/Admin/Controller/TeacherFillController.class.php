<?php

/**
 * 老师填写
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;

class TeacherFillController extends AdminbaseController {


 
 public function index()
 {
      
     $Province=role_admin();
     $this->assign("Province",$Province);

    $this->display();

 }



  public function teafill()
  {    
      
         $gradeid  = I('gradeid');
         // var_dump($gradeid);

         $schoolid = I('schoolid');

         if($gradeid)
         {
           $where['ag.gradeid'] = $gradeid;
         }

        	 $where['a.schoolid'] = $schoolid;
           $where['g.schoolid'] = $schoolid;

        	 $teacher_fill = M('archives_grade')
        	           ->alias("ag")
        	           ->where($where)
        	           ->join("wxt_school_grade g ON g.gradeid=ag.gradeid")
        	           ->join("wxt_archives a ON  ag.archivesid=a.id")
                     ->join("wxt_semester s ON a.semesterid=s.id")
        	           ->field("ag.name,s.semester,g.name as g_name,a.create_time,a.id,ag.gradeid")
        	           ->select();
             // var_dump($teacher_fill);

                 

        foreach ($teacher_fill as &$value){
          $gradeid = $value['gradeid'];  

          $school_class = M('school_class')->where("schoolid = $schoolid and grade = $gradeid ")->field('id')->select();
         
          $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);

          $send  = M('archives_student')->where("gradeid = $gradeid and schoolid = $schoolid and send = 2")->count();
          $value['schoolid'] = $schoolid;
          
            $student_sum="";
        
          foreach ($school_class as $val) {
             $classid = $val['id'];
             
             $class = M('class_relationship')->where("classid = $classid and schoolid = $schoolid")->count();

             $student_sum = $class+$student_sum;
            //todo还没计算出已经发送的学生
          $value['sum'] =$send.'个已发送'.'/'.'共'.$student_sum.'个学生';

          


        }
       
      }
         
     
      $grade = M('school_grade')->where("schoolid = $schoolid")->select();
  if (!empty($teacher_fill)){
           $ret = $this->format_ret_else(1,$teacher_fill);
           echo json_encode($teacher_fill);
        }else{
            $ret = $this->format_ret_else(0,"parms lost");
            echo json_encode($ret);
        }
      

  }


 public function show()
 {

  $schoolid=I('schoolid');
  // var_dump($schoolid);

 	$archivesid = I('id');
  // var_dump($archivesid);

  $gradeid = I('gradeid');
  // var_dump($gradeid);

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





 $count = M('archives_student')
       ->alias("a")
       ->where($where)
       ->limit($page->firstRow . ',' . $page->listRows)
       ->join("wxt_student_info s ON s.userid = a.studentid")
       ->join("wxt_school_class c ON c.id = a.classid ")
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
    
    $this->assign("schoolid",$schoolid);
    $this->assign("gradeid",$gradeid);
    $this->assign("archivesid",$archivesid);
    $this->assign("Page", $page->show('Admin'));
    $this->assign('list',$list);
        $this->display();
    }

    public function showgrade()
    {
        $schoolid = I('schoolid');

        $grade = M("school_grade")->where("schoolid = $schoolid")->field("name,gradeid")->order("gradeid")->select();

          if($grade){
                $ret = $this->format_ret_else(1,$grade);
            }else{
                $ret = $this->format_ret_else(0,"lost params");
            }
            echo json_encode($ret);
            exit;





    }


        function format_ret_else ($status, $data='') {
            if ($status){   
            //成功
                return array('status'=>'success', 'data'=>$data);
            }else{  
                //验证失败
                return array('status'=>'error', 'data'=>$data);
            }
        }


}