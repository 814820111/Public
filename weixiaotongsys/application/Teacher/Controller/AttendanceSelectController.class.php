<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
header("Conten-type:text/html;charset=utf-8");
class AttendanceSelectController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();



    }

    public function lists() {

        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];

        if($level!=1  && $level!=2)
        {

            $class = get_teacher_class($userid);
            $map['teacher.schoolid'] = $schoolid;
            $map['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON a.classid=teacher.classid';

        }else{
            $class=M('school_class')->field("id,classname")->order("id")->where(array("schoolid"=>$schoolid))->select();//查询班级列表
        }

      // var_dump($class);
        //      var_dump($class);
        $stu_name=I('stu_name');//获取学生名字
        $par_name=I('par_name');
        // var_dump($par_name);
        $begintime=I("begintime");//开始时间
        $endtime=I("endtime");//结束时间
        $begin=strtotime($begintime);
     
        $end=strtotime($endtime);
        //var_dump($end);
        $classid=I("class");
        $phone = I("phone");
        $time_a = I("time_a");
      //  var_dump($classid);
        
       if($time_a){
          
          $map['a.attendancetype'] = $time_a;


       }





        if($classid){//如果班级id存在就把所有的班级id入栈
             
           $where['a.classid'] = $classid;
            $this->assign("classinfo",$classid);
         }
        if($stu_name){
            $where_name["name"]=array('LIKE',"%".$stu_name."%");




             $userid_n=M('wxtuser')->field("id")->where($where_name)->select();
             // var_dump($userid_n);
            // //将select查询出的多条id的二维数组通过两次foreach循环配合array_push方法加入到一个一维数组中
            if(empty($userid_n)){
                $this->display();
                return;
            }

            $id_arr_n=array();
            foreach ($userid_n as &$item) {
                foreach ($item as &$vo) {
                    array_push($id_arr_n,$vo);
                }
            }
            $map["a.userid"]=array("in",$id_arr_n);
            $this->assign("stu_name",$stu_name);
        }
        if($par_name){
            $where_name["name"]=array('LIKE',"%".$par_name."%");

            $userid_n=M('wxtuser')->field("id")->where($where_name)->select();
            
            
            //将select查询出的多条id的二维数组通过两次foreach循环配合array_push方法加入到一个一维数组中
            $id_arr_n=array();
            foreach ($userid_n as &$item) {
                foreach ($item as &$vo) {
                    array_push($id_arr_n,$vo);
                }
            }

            $map["a.userid"]=array("in",$id_arr_n);
            $this->assign("par_name",$par_name);
        }
        if($begintime && $endtime){

         $cc = date('Y-m-d',$begin);
    
         $dd = date('Y-m-d',$end);

            $this->assign("begin",date('Y-m-d',$begin));
            $this->assign("end",date('Y-m-d',$end));


      	 $map['a.arrivedate'] = array(array('EGT',$cc),array('ELT',$dd));

            
        }else{
        	$map['arrivedate'] = date('Y-m-d',time());
        }

        if($phone){
            //var_dump($phone);
             $where_u['phone'] = $phone;
             $where_u['schoolid'] = $schoolid;      
            $userid_n=M('wxtuser')->field('id')->where($where_u)->find();

            $stuid = $userid_n['id'];
           // var_dump($stuid);

            $stu = M("relation_stu_user")->field('studentid')->where("userid = $stuid")->find();
            //var_dump($stu);
            $studentid = $stu['studentid'];
            //var_dump($studentid);

            $map['a.userid'] = $studentid;

            $this->assign("phone",$phone);
           //var_dump($userid_n);

        }
           $_GET = array_merge($_GET,$_POST);//分页带条件

         $map['a.schoolid'] = $schoolid;

       
       $count=M('attendances')->alias("a")->join($join_duty)->where($map)->count();




       
        $page = $this->page($count, 5);
        
        $list=M('attendances')->alias("a")->limit($page->firstRow . ',' . $page->listRows)->where($map)->join($join_duty)->distinct(true)->order("a.id DESC")->select();
        $sum = array();

         //TODO现在改进可以查出多个班级
        foreach ($list as &$item) {
            $studentid=$item["userid"];

            $leavepicture = $item['leavepicture'];
           
            $where_name["userid"]=$studentid;
           
            $student_name=M('student_info')->field("stu_name as name")->where($where_name)->find();
           
            $item["student_name"]=$student_name["name"];
            
             $where['c.userid'] = $studentid;

            $classname=M('school_class')
            ->alias("s")
            ->join("wxt_class_relationship c ON s.id=c.classid")
            ->where($where)
            ->field("s.classname,c.userid")      
            ->select();
            $where_p["r.studentid"]=$studentid;
            $where_p["r.type"]=1;
            $parent_info=M('relation_stu_user')
            ->alias("r")
            ->join("wxt_wxtuser w ON w.id=r.userid")
            ->where($where_p)
            ->field("w.name,w.phone")
            ->find();
            $parent_info["name"];
            $parent_info["phone"];

             foreach ($classname as $key => &$value) {
               if($item['attendancetype']==1){
                $value['attendancetype'] = '上午上学';
               }
               if($item['attendancetype']==2){
                $value['attendancetype'] = '上午放学';
               }
               if($item['attendancetype']==3){
                $value['attendancetype'] = '下午上学';
               }
               if($item['attendancetype']==4){
                $value['attendancetype'] = '下午放学';
               }
               if($item['attendancetype']==5){
                $value['attendancetype'] = '晚上上学';
               }
               if($item['attendancetype']==6){
                $value['attendancetype'] = '晚上放学';
               }
                 if($item['attendancetype']==7){
                     $value['attendancetype'] = '特殊考勤';
                 }
                 if($item['attendancetype']==0){
                     $value['attendancetype'] = '考勤异常';
                 }



              
              $value['arrivetime'] = $item['arrivetime'];
              $value['student_name'] = $student_name['name'];
              $value['parent_name'] =  $parent_info["name"];
              $value['parent_phone'] = $parent_info["phone"];
              $value['leavepicture'] = $leavepicture;
              $arr[] = $value;

         }


        }


        $this->assign("time_a",$time_a);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("begintime",$begintime);
        $this->assign("endtime",$endtime);
        // $this->assign("current_page",$page->GetCurrentPage());
        // var_dump($list);
        $this->assign("list",$list);
        $this->assign("class",$class);
        $this->assign("arr",$arr);
        $this->assign("teacher",$teacher);
       	$this->display();
    }
    function error()
    {
        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];

        $stu_name=I('stu_name');//获取学生名字
        $par_name=I('par_name');
       // var_dump($par_name);
        $begintime=I("begintime");//开始时间
        $endtime=I("endtime");//结束时间
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        $classid=I("class");
        $phone = I("phone");
        $card = I('card');
      //  var_dump($card);
            






    if($classid){//如果班级id存在就把所有的班级id入栈
             
           $where['classid'] = $classid;
           $this->assign("classinfo",$classid);
           // var_dump($classid);

         }
        if($stu_name){
            $where_name["name"]=array('LIKE',"%".$stu_name."%");


             $userid_n=M('wxtuser')->field("id")->where($where_name)->select();
             // var_dump($userid_n);
            // //将select查询出的多条id的二维数组通过两次foreach循环配合array_push方法加入到一个一维数组中
            if(empty($userid_n)){
                $this->display();
                return;
            }

            $id_arr_n=array();
            foreach ($userid_n as &$item) {
                foreach ($item as &$vo) {
                    array_push($id_arr_n,$vo);
                }
            }
            $map["a.userid"]=array("in",$id_arr_n);
            $this->assign("stu_name",$stu_name);
            // var_dump($id_arr_n);
        }
        if($par_name){
            $where_name["name"]=array('LIKE',"%".$par_name."%");

            $userid_n=M('wxtuser')->field("id")->where($where_name)->select();
            
            
            //将select查询出的多条id的二维数组通过两次foreach循环配合array_push方法加入到一个一维数组中
            $id_arr_n=array();
            foreach ($userid_n as &$item) {
                foreach ($item as &$vo) {
                    array_push($id_arr_n,$vo);
                }
            }
          // var_dump($id_arr_n);

            $map["a.userid"]=array("in",$id_arr_n);
            $this->assign("par_name",$par_name);
        }
        if($begintime && $endtime){
    
            $begin = date('Y-m-d',$begin);
            $end = date('Y-m-d',$end);
            $map["a.arrivedate"]=array(array('EGT',$begin),array('ELT',$end));
            $this->assign("begin",$begin);
            $this->assign("end",$end);
        }else{
            $map['a.arrivedate'] = date("Y-m-d",time());
        }

        if($phone){
            //var_dump($phone);
             $where_u['phone'] = $phone;
             $where_u['schoolid'] = $schoolid;      
            $userid_n=M('wxtuser')->field('id')->where($where_u)->find();
           // if($user_id)

            $stuid = $userid_n['id'];
            // var_dump($stuid);
             
             $where_stu['userid'] = $userid_n['id'];


            $stu = M("relation_stu_user")->field('studentid')->where($vfvfdvwhere_stu)->find();
            // var_dump($stu);
            $studentid = $stu['studentid'];
            // var_dump($studentid);

            $map['a.userid'] = $studentid;
            $this->assign("phone",$phone);
           // var_dump($userid_n);

        }

        if($card){
           $map['cardno']=$card;
           $this->assign("card",$card);
        }
      // var_dump($where_card);

        if($level!=1  && $level!=2)
        {

            $class = get_teacher_class($userid);
            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON a.classid=teacher.classid';

        }else{
            $class=M('school_class')->field("id,classname")->order("id")->where(array("schoolid"=>$schoolid))->select();//查询班级列表
        }



        $map['a.schoolid'] = $schoolid;
        $map['a.attendancetype'] = 0;
      
       $count=M('attendances')->alias("a")->join($join_duty)->where($map)->count();
       
        $page = $this->page($count, 20);
        
        $list=M('attendances')->alias("a")->join($join_duty)->where($map)->order("a.id DESC")->select();
        // var_dump($list);

       foreach ($list as &$item) {
            $studentid=$item["userid"];
            $where_name["id"]=$studentid;
            $student_name=M('wxtuser')->field("name")->where($where_name)->find();
            // var_dump($student_name);
            $item["student_name"]=$student_name["name"];
            // var_dump($studentid);
            
            $where_card['personid'] = $studentid;

            // $card = M('student_card')->where($where_card)->find();
            // var_dump($card);
         

             $where['c.userid'] = $studentid;

            $classname=M('school_class')
            ->alias("s")
            ->join("wxt_class_relationship c ON s.id=c.classid")
            ->where($where)
            ->field("s.classname,c.userid")      
            ->select();
            // var_dump($classname);
        //  var_dump($classname);
          // $arr = array();
         //  foreach ($classname as $key => &$value) {
                
         //     $value['student_name'] = $student_name['name'];
         //      $value['name'] =  $parent_info["name"];
         //      $value['phone'] = $parent_info["phone"];
         //      $arr[] = $value;
         // }
           // $class_inforty="";

         // foreach ($classname as $key => &$value) {
                
         //     $value['student_name'] = $student_name['name'];
         //     //     $infos=$itvo["ids"];
         //     //    $class_inforty = $info.",".$class_inforty             //$teacher_idsu=$infos.",".$teacher_idsu;
         //     // $sum  = $value;
         // }
      //   var_dump($sum);
          // $item["classname"] =  $class_inforty;
          //  var_dump($classname);
            //$item["classname"]=$classname["classname"];
            $where_p["r.studentid"]=$studentid;
            $where_p["r.type"]=1;
            $parent_info=M('relation_stu_user')
            ->alias("r")
            ->join("wxt_wxtuser w ON w.id=r.userid")
            ->where($where_p)
            ->field("w.name,w.phone")
            ->find();
            $parent_info["name"];
            $parent_info["phone"];

             foreach ($classname as $key => &$value) {
              
              $value['arrivetime'] = $item['arrivetime'];
              $value['card'] = $item['cardno'];
              $value['student_name'] = $student_name['name'];
              $value['parent_name'] =  $parent_info["name"];
              $value['parent_phone'] = $parent_info["phone"];
              $arr[] = $value;
         }
        
       
    }
       $this->assign("Page", $page->show('Teacher'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("class",$class);
        $this->assign("arr",$arr);
        $this->assign("teacher",$teacher);
        $this->display();
  }
}