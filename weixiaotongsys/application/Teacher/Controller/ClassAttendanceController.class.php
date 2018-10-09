<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
header("Content-type:text/html;charset=utf-8");
class ClassAttendanceController extends TeacherbaseController
{

    function _initialize() {
        parent::_initialize();



    }
    public function index()
    {
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];

        $c_id = I('c_id');


        $this->assign("classinfo",$c_id);

        $isin_residence = I('isin_residence');
        //var_dump($isin_residence);

        $attendance_time = I('attendance_time');

        $begintime = strtotime(I('begintime'));


        $endtime   =  strtotime(I('endtime'));
  
        $this->assign("attendance_time",$attendance_time);

        $search = I('search');

        $school4 = I('school4');
        //var_dump($school4);

       
      if($school4)
      {
         //echo "dsadsa";
        $where_att['status'] = $school4; 
      }  
    

      if($begintime && $endtime)
      { 
      	$cc = date('Y-m-d',$begintime);

      	$dd = date('Y-m-d',$endtime);
        // var_dump($dd);
      	$where_att['arrivedate'] = array(array('EGT',$cc),array('ELT',$dd));
      }else{
      	$where_att['arrivedate'] = date('Y-m-d',time()); 
      }
 
        if ($c_id) {
            $where['c.classid'] = $c_id;
        }
   
       if($isin_residence){

        $where['in_residence'] = $isin_residence;
        // var_dump($where);
        $join = "wxt_student_info st ON c.userid=st.userid";
        // $where['st.in_residence'] = $isin_residence;
       }
     
       if($attendance_time){
        $where_att['attendancetype'] = $attendance_time;
     
       }

       if($search){
           $where['w.name'] = array("LIKE","%".$search."%");
           $where['c.schoolid'] = $schoolid;
            $join = "wxt_wxtuser w ON c.userid=w.id";
       }else{
        $where['c.schoolid'] = $schoolid;
       }


      
       //$map["a.arrivetime"]=array(array('EGT',$start_time_unix),array('ELT',$end_time_unix));

        if($level!=1  && $level!=2)
        {

            $class = get_teacher_class($userid);
            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $userid;

            $join_duty = 'wxt_teacher_class teacher ON c.classid=teacher.classid';



        }else{
            $class = M('school_class')->where("schoolid=$schoolid")->select();
        }
     





        $this->assign("class",$class);
         //重构


        $count=M("class_relationship")
        ->alias("c")
        ->join($join)
        ->join($join_else)
        ->join($join_duty)
        ->where($where)
        ->order("c.create_time DESC")  
        ->count();
        //var_dump($count);
        $page = $this->page($count, 20);
                
        $student=M("class_relationship")
        ->alias("c")->distinct(true)
        ->join($join)
        ->join($join_else)
        ->join($join_duty)
        ->where($where)
        ->field('c.userid,c.classid')
        ->limit($page->firstRow . ',' . $page->listRows)        // ->group("userid")
        ->order("c.classid DESC")  // 添加分页
        ->select();


         //默认时间为当天
  


       //$where_att['arrivedate'] = date('Y-m-d',time()); 

       $where_att['schoolid'] = $schoolid;
      // var_dump($where_att);

       $attendances = M('attendances')->where($where_att)->select();
    

       //如果数据为空的话
       if(!$attendances)
       {
       $this->display();
       return;
       }
    
// var_dump($list);
       // exit();
         //var_dump($attendances);
       //var_dump($student);

       foreach ($student as $key => &$value) {
            
            $classid=$value["classid"];

            $s_id=$value["userid"];

            // var_dump($s_id);

           
           //查出学生的班级
            $classname=M("school_class")->field('classname')->where("id=$classid")->find();
            // var_dump($classname);
          
            $val["classname"]=$classname["classname"];
            
             $value["classname"]=$classname["classname"];
             //姓名
            $search_student_name=M("student_info")->field("stu_name as name")->where("userid=$s_id")->find();

              
            
           $val['student_name'] = $search_student_name['name'];

           $value['student_name'] = $search_student_name['name'];

            $where_in['userid'] = $s_id;

            $student_card = M('student_card')->where("personId = $s_id  and cardType = 0")->field('cardno')->find();
            // var_dump($student_card);

            $value['cardno'] =  $student_card['cardno'];

            // var_dump($value['cardno']);
          
           
           $in_residence = M("student_info")->where($where_in)->field("in_residence")->find();
           // var_dump($in_residence);
            
               if($in_residence['in_residence'] == 0){
                               
                                $value['in_residence'] = '否';
                            }elseif($in_residence['in_residence'] == 1){
                              
                                $value['in_residence'] = '是';
                            }else{
                                
                                $value['in_residence']='不知道';
                            }
           




            foreach ($attendances as $ke=>&$val) {
                  
               

                  if($value['userid']==$val['userid'])
                  {
                    
                    if($val['status'] == 1){
                        $val['statu'] = '正常';
                       }

                       if($val['status'] == 2){
                        $val['statu'] = '迟到';
                       }

                       if($val['status'] == 3){
                        $val['statu'] = '早退';
                       }
                       if($val['status'] == 4){
                        $val['statu'] = '病假';
                       }
                       if($val['status'] == 5){
                        $val['statu'] = '事假';
                       }
                       if($val['status'] == 6){
                        $val['statu'] = '未打卡';
                       }
                       if($val['status'] == 7){
                        $val['statu'] = '其他';
                       }
                       if($val['status']==0)
                       {
                        $val['statu'] = '异常';
                       }
                    
                     
                     

                     if($val['attendancetype'] == 1){
                        $val['attendantype'] = '上午上学';
                       }
                       if($val['attendancetype'] == 2){
                        $val['attendantype'] = '上午放学';
                       }
                       if($val['attendancetype'] == 3){
                        $val['attendantype'] = '下午上学';
                       }
                       if($val['attendancetype'] == 4){
                        $val['attendantype'] = '下午放学';
                       }
                       if($val['attendancetype'] == 5){
                        $val['attendantype'] = '晚上上学';
                       }
                       if($val['attendancetype'] == 6){
                        $val['attendantype'] = '晚上放学';
                       }
                        if($val['attendancetype'] == 0){
                        $val['attendantype'] = '考勤异常';
                       }

                        $val["classname"]=$classname["classname"];
                        $val['student_name'] = $search_student_name['name'];
                        if($in_residence['in_residence'] == 0){
                               
                                $val['in_residence'] = '否';
                            }elseif($in_residence['in_residence'] == 1){
                              
                                $val['in_residence'] = '是';
                            }else{
                                
                                $val['in_residence']='不知道';
                            }

                        $list[] = $val;
                     // array_unshift($value);
                    // unset($key);
                    unset($student[$key]);
                     
                 }
                    
            }

            // var_dump($attendances);
     // var_dump($list);
      // $result=array_diff($val,$value);
           
       $re = array_merge($list,$student);

    
       }
  

       //如果为空的话

if(empty($re)){
      
          $where_atte['schoolid'] = $schoolid;

          $att = M('attendances')->where($where_atte)->select();

          foreach ($att as  $value) {
             $userid = $value['userid'];
         //    var_dump($userid);
            // $where_stu['schoolid'] = $schoolid;
             $list[] = $userid;
                           
            
           // var_dump($stu);
          }  
           // $where['schoolid']= $schoolid;
          $where['userid'] = array('not in',$list);
          // var_dump($where_stu);
          // $stu = M('class_relationship')->where($where_stu)->select();

         $student=M("class_relationship")
        ->alias("c")->distinct(true)
        ->join($join)
        ->join($join_else)
        ->where($where)
        ->join($join_duty)
        ->field("c.userid,c.classid")
        ->limit($page->firstRow . ',' . $page->listRows)        // ->group("userid")
        ->order("c.classid DESC")  // 添加分页
        ->select();


       foreach ($student as  &$val) {

           $where_in['userid'] = $val['userid'];
           
           $where_class['id'] = $val['classid'];

           $where_name['userid'] = $val['userid'];

           $userid = $val['userid'];

           $search_student_name=M("student_info")->field("stu_name as name")->where($where_name)->find();


           $val['student_name']  = $search_student_name['name'];

           $classname = M('school_class')->field('classname')->where($where_class)->find();

            $student_card = M('student_card')->where("personId = $userid  and cardType = 0")->field('cardno')->find();


            $val['cardno'] =  $student_card['cardno'];

            $val['classname'] = $classname['classname']; 

            $in_residence = M("student_info")->where($where_in)->field("in_residence")->find();

            if($in_residence['in_residence'] == 0){
                               
                    $val['in_residence'] = '否';
                }elseif($in_residence['in_residence'] == 1){
                  
                    $val['in_residence'] = '是';
                }else{
                    
                    $val['in_residence']='不知道';
                }
           $re[] = $val;
          // var_dump($re);
          
           
       }
    }
  // var_dump($re);
 
      // var_dump($student);
       //var_dump($ke);
       //var_dump($key);
        //var_dump($list);

    $_SESSION['att_class_info'] = $re;

        $this->assign("Page", $page->show('Teacher'));
        $this->assign("list",$re);
        $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("class",$class);
        $this->assign("teacher",$teacher);
       
        
    // var_dump($re);
//        var_dump($classname);
        $this->display();
    }
    public function count()
    {     //考勤时段
        $attendance_time = I("attendance_time");
        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];


        //开始时间
        $begintime = I("begintime");
        //结束时间
        $endtime = I("endtime");
        //转换成时间戳
        $begin = strtotime($begintime);
        //转换时间戳
        $end = strtotime($endtime);

    




        //便利出来所有的班级

        $classid = I("c_id");


         if ($begintime && $endtime) {
            $where["a.arrivedate"] = array(array('EGT', date('Y-m-d',$begin)), array('ELT', date('Y-m-d',$end)));
        }else{
            $where["a.arrivedate"] = date('Y-m-d',time());
        }

 

        if($classid)
        {
          $where['a.classid'] = $classid;
          $this->assign("classinfo",$classid);
        }


   
       if($attendance_time)
       {
        $where['a.attendancetype'] = $attendance_time;
       }else{
        $where["a.attendancetype"] = array("NEQ",0);
       }
        // $attendances = 
 
       $where['a.schoolid'] = $schoolid;

        if($level!=1  && $level!=2)
        {

            $class = get_teacher_class($userid);
            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON a.classid=teacher.classid';

        }else{
            $class = M('school_class')->field("id,classname")->order("id")->where(array("schoolid" => $schoolid))->select();
        }
       

        $attendances = M('attendances')->alias("a")->join($join_duty)->where($where)->group('a.classid,a.attendancetype,a.arrivedate')->select();

      

       //查询出一个学校的班级共有四个 下面套循环
      //  $class = M('school_class')->field("id,classname")->order("id")->where(array("schoolid" => $schoolid))->select();
       // var_dump($class);

       
      
     foreach ($attendances as  &$value) {
         
         foreach ($class as  &$val) {
          
             if($value['classid']==$val['id'])

             {
                $arrivedate = $value['arrivedate'];
                
                // $where_one['attendancetype'] = $value['attendancetype'];
                // $where_one['arrivedate'] = $arrivedate;
                $where_one['classId'] = $value['classid'];
                
                $where_two['attendancetype'] = $value['attendancetype'];
                $where_two['classid'] = $value['classid'];
                $where_two['status'] = array('in','2,3,4,5');
                 $where_two['arrivedate'] = $arrivedate;
                

                $where_three['attendancetype'] = $value['attendancetype'];
                $where_three['classid'] = $value['classid'];
                $where_three['status'] = array("NEQ",6);
                $where_three['arrivedate'] = $arrivedate;
                 //实际打卡人数 
                $reality = M('attendances')->where($where_three)->count();
                 //var_dump($reality);
                $value['reality'] = $reality;
                //请假
                $leave = M('attendances')->where($where_two)->count();
                //var_dump($leave);

                $value['leave'] = $leave;

                $where_four['attendancetype'] = $value['attendancetype'];
                $where_four['classid'] = $value['classid'];
                $where_four['status']  = 6;
                $where_four['arrivedate'] =$arrivedate;

                //未打卡人数
                $not_clock = M('attendances')->where($where_four)->count();
               

                $value['clock'] = $not_clock;



               
                  
                //应打卡人数
                $att_sum = M('student_card')->where($where_one)->count();
                //班级总人数
                $num = M("class_relationship")->where(array("classid"=>$value['classid']))->count();
                //var_dump($num);
                // var_dump($att_sum);
                $value['sum'] = $num;
                $value['att_sum'] = $att_sum;
               
                $value['classname'] = $val['classname'];
             }

             if($value['attendancetype']==1)
             {
                $value['att_type'] = "上午上学";
             }

             if($value['attendancetype']==2)
             {
                $value['att_type'] = "上午放学";
             }

             if($value['attendancetype']==3)
             {
                $value['att_type'] = "下午上学";
             }

             if($value['attendancetype']==4)
             {
                $value['att_type'] = "下午上学";
             }
             if($value['attendancetype']==5)
             {
                $value['att_type'] = "晚上上学";
             }
             if($value['attendancetype']==6)
             {
                $value['att_type'] = "晚上放学";
     }
     //var_dump($attendances);
 }
}

      //因为一天分 上午上学  上午放学 下午上学  和上午放学 所以这边循环4次写死

      // for ($i=1; $i <=4 ; $i++) { 
      //    foreach ($class as &$value) {
      //       var_dump($i);
      //        if($i==1)
      //         { 
      //           // echo"sasa";
      //           $where_one['attendancetype'] = $i;
      //           $where_one['classid'] = $value['id'];
      //           $attendances = M('attendances')->where($where_one)->count();
      //           var_dump($attendances);
      //           $value['attendancetype'] = '上午上学';
      //           $value['attnum'] = $attendances;
      //         }
      //         if($i==2)
      //         {
      //           $value['attendancetype'] = '上午放学';
      //         }  
      //         if($i==3)
      //         {
      //           $value['attendancetype'] = '下午上学';
      //         }  
      //         if($i==4)
      //         {
      //           $value['attendancetype'] = '下午放学';
      //         } 
      //         $list[] = $value;   
      //    }
      // }
      // var_dump($list);
      // var_dump($class);
      //  //$attendances = 
//        exit();
//         //定义搜索条件名字
//         $search = I('search');
//         //开始时间
//         $begintime = I("begintime");
//         //结束时间
//         $endtime = I("endtime");
//         //转换成时间戳
//         $begin = strtotime($begintime);
//         //转换时间戳
//         $end = strtotime($endtime);
//         //接收到班级id
//         $classid = I("c_id");
//         if ($classid){
//             //如果班级id存在的话那么直接用班级id查询  列出来有多少学生
//             $userid_c = M('class_relationship')->where("classid=$classid")->select();
//             //查出来多少人 然后拼成一维数组
//             for ($i=0;$i<count($userid_c);$i++){
//                 $id_arr_c[$i]  =  $userid_c[$i]["userid"];
//             }
//             //定义一个查询条件
//             $map["userid"] = array("in", $id_arr_c);
//         }
//         //如果开始条件和结束条件存在那么就一并查询
//         if ($begintime && $endtime) {
//             $map["create_time"] = array(array('EGT', $begin), array('ELT', $end));
//         }
//         //查看是否传过来考勤时段如果传过来就加上这个条件
// //        var_dump($attendance_time);
//         $list = M('school_class')->field("id,classname")->where("schoolid=$schoolid")->order("id")->select();
// //        var_dump($list);
//         $count = M('school_class')->where($map)->count();
//         $page = $this->page($count, 20);
//         if ($begintime && $endtime){
//             for ($i=0;$i<count($list);$i++){
//                 //查询各个班级的总人数
//                 $cl_id = $list[$i]['id'];
// //                echo $cl_id;
//                 $num = M("class_relationship")->where(array("classid"=>$cl_id))->count();
//                 $list[$i]['stu_num'] = $num;
//             }
//         }else{
//             for ($i=0;$i<count($list);$i++){
//                 //查询各个班级的总人数
//                 $cl_id = $list[$i]['id'];
// //                echo $cl_id;
//                 $num = M("class_relationship")->where(array("classid"=>$cl_id))->count();
//                 //取出来这个班级的所有人 然后去考勤表校验
//                 $stu_true = M("class_relationship")->where(array("classid"=>$cl_id))->select();
//                 //拿出来班级的所有人的userid
//                 for ($j=0;$j<count($stu_true);$j++){
//                     $stu_list_id[$j] = $stu_true[$j]["userid"];
//                 }
// //                取出来里面的uerid
//                 for ($j=0;$j<count($stu_true);$j++){
//                     $stu[$j] = $stu_true[$j]['userid'];
//                     //获取当前的开始时间和结束时间
//                     $btime = strtotime(date('Ymd'))-28800;
//                     $etime = strtotime(date('Y-m-d',strtotime('+1 day')));
//                     $attendances["arrivetime"] = array(array('EGT', $btime), array('ELT', $etime));//大于等于开始时间 小于等于结束时间
//                     $attendances["userid"] = array("in",$stu_list_id);
//                     $attendance_num = M("attendances")->where($attendances)->count();
//                     $list[$i]["true"] = $attendance_num;
//                 }
//                 $list[$i]['stu_num'] = $num;
//             }
//         }
        // $this->assign("Page", $page->show('Teacher'));
        // $this->assign("current_page", $page->GetCurrentPage());
     // var_dump($class);
     // var_dump($attendances);

     $_SESSION['att_class_count'] = $attendances;
        $this->assign("class", $class);
        $this->assign("list", $attendances);
        
        $this->assign("teacher", $teacher);
        $this->display();
    }


   public function cause()
   {

   	   $schoolid = $_SESSION["schoolid"];

        $id = I('id');

        $val = I('val');
   
        $type  = I('type');

        $classid = I('classid');

        $card = I('card');

	    $data['status'] = $val;

	   $data['schoolid'] = $schoolid;

	   $data['attendancetype'] = $type;

	   $data['userid'] = $id;

	   $data['classid'] = $classid;

	   $data['arrivetime'] = time();

	   $data['cardtype'] = 0;

	   $data['arrivedate'] = date('Y-m-d',time());

	   $data['cardno'] = $card;

	   $save = M('attendances')->add($data);


    if ($save ) {
            $info['status'] = true;
            $info['msg'] = $id;
        }else{
                $info['status'] = false;
                $info['msg'] = '404';
            }
          echo json_encode($info);

   }


   public function show_t()
   {

    $schoolid = $_SESSION["schoolid"];

    $classid = I('classid');


    $type = I('type');


    $time = I('time');
     

     $where['c.schoolid'] = $schoolid;

     $where['c.classid'] = $classid;

    $class = M('class_relationship')->alias("c")->join('wxt_student_info u ON c.userid=u.id')->field("u.stu_name as name,u.id")->where($where)->select();
    
      
   $where_att['classid'] = $classid;

   $where_att['attendancetype'] = $type;

   $where_att['arrivedate'] = $time;
     
     $atten = M('attendances')->field("arrivetime,userid,arrivedate,status")->where($where_att)->select();
     // var_dump($atten);
     

     foreach ($class as  &$value){
          $userid = $value['id'];
         // var_dump($userid);
          
       //   $atten = M('attendances')->field("arrivetime,userid")->where($where_att)->find();
         // var_dump($atten);

          foreach ($atten as &$val){
            if($val['userid']==$userid){
          
             if(!empty($val['arrivetime'])){
              $value['arrivetime']=date("Y-m-d H:i:s", $val['arrivetime']);  
               }
            if($val['status']==6)
            {
              $value['arrivetime'] = '未打卡';
            }     
           }

          }

          $in_residence = M("student_info")->where("userid=$userid")->field("in_residence")->find();

              if($in_residence['in_residence'] == 0){
                             
                      $value['in_residence'] = '否';
                  }elseif($in_residence['in_residence'] == 1){
                    
                      $value['in_residence'] = '是';
                  }else{
                      
                      $value['in_residence']='不知道';
                  }

       
    

        $card = M('student_card')->field('personId,cardNo')->where("personId=$userid and cardType = 0")->find();
           
        $value['card'] = $card['cardno'];
       
      }
    $_SESSION['att_student_info']=$class;
   

      if($class){
            $info['status'] = true;
            $info['msg'] = $class;
        }else{
              $info['status'] = false;
              $info['msg'] = '404';
         }

  echo json_encode($info);


   }


 public function expUser(){//导出Excel
                    
                
                $excel = A('TeacherInfo');

               // echo $excel->exportExcel();

                $xlsName  = "User";

                $xlsCell  = array(

                array('name','学生姓名'),

                array('in_residence','是否住校'),

                array('card','IC卡号'),

                array('arrivetime','刷卡时间'),


                );
                //接收保存在SESSION的值
                $xlsData = $_SESSION['att_student_info'];

                $fileNames =  '学生刷卡信息'.date('_YmdHis');
        
                echo $excel->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);
                     
        }


   public function class_exp(){//导出Excel
                    
                
                $excel = A('TeacherInfo');

               // echo $excel->exportExcel();

                $xlsName  = "User";

                $xlsCell  = array(

                array('classname','班级'),

                array('sum','学生人数'),

                array('att_type','考勤时段'),

                array('arrivedate','考勤时间'),

                array('att_sum','应打卡人数'),

                array('reality','实际打卡人数'),

                array('leave','请假'),

                array('clock','未打卡'),


                );
                //接收保存在SESSION的值
                $xlsData = $_SESSION['att_class_count'];

                $fileNames =  '班级考勤统计'.date('_YmdHis');
        
                echo $excel->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);
                     
        } 





      public function class_info_exp(){//导出Excel
                    
                
                $excel = A('TeacherInfo');

               // echo $excel->exportExcel();

                $xlsName  = "User";

                $xlsCell  = array(

                array('classname','学生班级'),

                array('student_name','学生姓名'),

                array('in_residence','是否住校'),

                array('cardno','IC卡号'),

                array('attendancetype','考勤时段'),

                array('arrivetime','考勤时间'),

                array('status','未打卡原因'),


                );
                //接收保存在SESSION的值
                $xlsData = $_SESSION['att_class_info'];

                foreach ($xlsData as $key => &$value) {
                  if($value['status']==1)
                  {
                    $value['status'] = '卡未发';
                  }
                }

                $fileNames =  '班级考勤查询'.date('_YmdHis');
        
                echo $excel->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);
                     
        }         




}
