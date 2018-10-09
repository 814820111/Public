<?php

/**
 * 后台首页  学校信息管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
header("Content-type: text/html; charset=utf-8");
class AdjustClassController extends AdminbaseController {


        function _initialize() {
        parent::_initialize();
        $this -> school_model = D("Common/School");
        $this -> class_model = D("Common/school_class");
        $this -> class_relationship_model = D("Common/class_relationship");
        $this -> appellation_model = D("Common/appellation");
        $this -> wxtuser_model = D("Common/wxtuser");
        $this -> relation_stu_user_model = D("Common/relation_stu_user");
        $this -> relation_stu_class_model = D("Common/class_relationship");

    }

	   function index()
	   {



        
       $Province=role_admin();
        $this->assign("Province",$Province);

        $this->display();
   }

   //获取学生列表
      public function get_student()
      {
          $schoolid = I("schoold");
          $tiaojian = I("tiaojian");
          $shuzhi = I("shuzhi");
          if ($tiaojian != "0" && $shuzhi != "") {
              $where["s.$tiaojian"] = array('like', "%$shuzhi%");
          }
          if ($schoolid != 0) {
              $where["a.schoolid"] = $schoolid;
          }
          $roleid = admin_role();

          if($roleid!=1)
          {
              $join_else = "wxt_role_school rs ON rs.schoolid = a.schoolid";
              $where['rs.roleid'] = $roleid;
          }
          if ($tiaojian == "name" || $tiaojian == "0" || $tiaojian == "" ) {

              $count = $this -> relation_stu_class_model -> alias("a") -> join("wxt_wxtuser s ON a.userid = s.id") ->join($join_else) -> where($where) -> count();
              $page = $this -> page($count, 20);

              $students = $this -> relation_stu_class_model
                  -> alias("a")
                  -> join("wxt_wxtuser s ON a.userid = s.id")
                  -> join($join_else)
                  -> field("s.id,s.schoolid,s.name,s.photo,s.sex,s.create_time")
                  -> where($where)
                  -> limit($page -> firstRow . ',' . $page -> listRows)
                  -> order("a.id ASC") -> select();

              // exit();

              //exit();
              foreach ($students as &$studentclass) {
                  $classid = $studentclass['id'];
                  $classlist = $this -> class_model -> alias("b") -> join("wxt_class_relationship br ON b.id=br.classid") -> where("br.userid = $classid and b.type = 1") -> field('classname,b.id') -> find();
                  $studentclass["classlist"] = $classlist['classname'];
                  $studentclass["classid"] = $classlist['id'];

                  unset($studentclass);
              }

              foreach ($students as &$student_user) {
                  $userlist = $this -> wxtuser_model -> alias("user") -> join("wxt_relation_stu_user su ON user.id=su.userid") -> where(array("su.studentid" => $student_user['id'])) -> field('su.name,su.appellation,user.phone') -> select();
                  $lastResult = "";
                  $arr = count($userlist);
                  for ($i = 0; $i < $arr; $i++) {
                      $last = $userlist[$i][name];
                      $poeon = $userlist[$i][phone];
                      $Chen = $userlist[$i][appellation];
                      $lastResult = $Chen . " " .$lastResult . $last . "," . $poeon;

                  }
                  $student_user["names"] = $lastResult;
                  unset($student_user);
              }


              //查询登录手机号

              foreach ($students as &$val) {

                  $where_phone['studentid'] = $val['id'];
                  $where_phone['type'] = 1;

                  $rel = M("relation_stu_user")->where($where_phone)->field("phone")->find();

                  if($rel){

                      $val['phone'] = substr_replace($rel['phone'],'****',3,4);
                  }
              }





          } else {


              if ($tiaojian == "names") {
                  $wheres["bi.name"] = array('like', "%$shuzhi%");
              } elseif($tiaojian == "phone") {
                  $wheres["bi.phone"] = array('like', "%$shuzhi%");
              }else{
                  // $wheres['bi.cardno'] = array('like',"%shuzi%");
                  $wheres['cardNo'] = array('like',"%$shuzhi%");
                  $join = "wxt_student_card sc ON si.studentid = sc.personId";


              }
              // var_dump($wheres);

              $count = $this -> wxtuser_model -> alias("bi") -> join("wxt_relation_stu_user si ON bi.id=si.userid ")->distinct(true)->join($join)-> where($wheres) -> count();

              $page = $this -> page($count, 20);

              $students = $this -> wxtuser_model -> alias("bi")->distinct(true) -> join("wxt_relation_stu_user si ON bi.id=si.userid ")->join($join) -> where($wheres) -> limit($page -> firstRow . ',' . $page -> listRows) -> field("bi.name as names, bi.phone ,si.studentid as id") -> select();


              foreach ($students as &$student_user) {
                  $uisname = $this -> wxtuser_model -> where(array("id" => $student_user['id'])) -> select();
                  $lastResultname = "";
                  //学生名字
                  $lastResultcreate_time = "";
                  //创建的时间
                  $lastResultsex = "";
                  //性别
                  $arr = count($uisname);
                  for ($i = 0; $i < $arr; $i++) {
                      $last = $uisname[$i][name];
                      $lio = $uisname[$i][create_time];
                      $lioi = $uisname[$i][sex];

                      $lastResultname = $lastResultname . $last . ",";
                      $lastResultcreate_time = $lastResultcreate_time . $lio;
                      $lastResultsex = $lastResultsex . $lioi;
                  }
                  $student_user['sex'] = $lastResultsex;
                  $student_user["name"] = $lastResultname;
                  $student_user["create_time"] = $lastResultsex;
                  unset($student_user);
              }

              foreach ($students as &$value) {
                  $personId = $value['id'];

                  $card = M('student_card')->where("personId = $personId and handletype = 1")->field("cardNo")->find();



                  $value['cardno'] = $card['cardNo'];
              }

              foreach ($students as &$student_userclass) {
                  $classlist = $this -> class_model -> alias("b") -> join("wxt_class_relationship br ON b.id=br.classid") -> where(array("br.userid" => $student_userclass['id'],"b.type = 1")) -> field('classname,b.id') -> find();
                  $student_userclass["classlist"] = $classlist['classname'];
                  $student_userclass["classid"] = $classlist['id'];
                  unset($student_userclass);
              }
              foreach ($students as &$value) {
                  $personId = $value['id'];



                  $card = M('student_card')->where("personId = $personId and cardType = 0 and handletype = 1")->field("cardno")->find();

                  // var_dump($card);

                  $value['cardno'] = $card['cardno'];
              }
          }

          //todo去除页面重复的值
          $newarr = array();
          foreach($students as $key => $_arr){
              if(!isset($newarr[$_arr['id']])){
                  $newarr[$_arr['id']] = $_arr;
              }
          }

          $students = $newarr;


          $Page[] =  $page -> show('Admin');
          $result = array_merge($Page,$students);
          if (!empty($result)){
              $ret = $this->format_ret(1,$result);

              echo json_encode($result);

          }else{
              $ret = $this->format_ret(0,"parms lost");
              $this -> assign("Page", $page -> show('Admin'));
              echo json_encode($ret);

          }
          exit();

      }
    function format_ret ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }

   
       public function  edit_class()
       {  
          $schoolid=I('change_school');
          $studentid = I("changeid");


          $classid = I("change_class");


          $old_Class = I('old_class');




           $id =  explode(",", $studentid);

           if($studentid && $classid)
           {
               $where['userid'] = array('in',$studentid);
               $where['classid'] = array('in',$old_Class);

               $del = M("class_relationship")->where($where)->delete();

               foreach ($id as $key => $value) {

                   $userid = $value;
                   $s_class = $key;

                   // $del = M("class_relationship")->where("userid =$userid and classid = $key")->delete();

                   $data = array(
                       'schoolid'=>$schoolid,
                       'classid'=>$classid,
                       'userid'=>$value,

                   );

                   $class_rel = M("class_relationship")->add($data);



                   if($class_rel)
                   {

                       $edit_class = M("student_info")->where("userid = $userid")->save(array("classid"=>$classid));

                       update_card(0,$userid,$schoolid);



                   }

               }


           }

           if($class_rel)
           {
               $ret = $this->format_ret(1,$edit_class);
               echo json_encode($ret);
           }else{
               $ret = $this->format_ret(0,$edit_class);
               echo json_encode($ret);
           }


   }

      
          
  public function student_move()
  { 
    $schoolid = I('change_school');
    $studentid = I('changeid');
 
  


    $cause = I('student_cause');

    $classid = I('old_class');
 
     

  
        $data = array(

         'schoolid'=>$schoolid,
         'studentid'=>$studentid,
         'classid'=>$classid,
         'cause'=>$cause,
         'create_time'=>time(),


          );
      $student_move =  M("student_move")->add($data);



        
     if($student_move)
     {  

       $class_rela = M("class_relationship")->where("schoolid = $schoolid and  userid = $studentid")->delete();

        $save = M("student_info")->where("userid=$studentid")->save(array("status"=>2));
        $this->success("退学成功!");
       
   
     }



  }

    public function abnormal()
    {

        $Province=role_admin();

        $this->assign("Province",$Province);
      $this->display();

    }

    public function show_move()
    { 

      $schoolid = I('schoolid'); 
      $class=M('school_class')->where("schoolid=$schoolid and type = 1")->order("id asc")->select();
      $where['s.schoolid'] = $schoolid;

      $move = M("student_move")->alias("s")->where($where)->join("wxt_student_info info ON info.userid = s.studentid")->join("wxt_school_class sc ON s.classid=sc.id")->field("s.id,info.stu_name,info.stu_id,s.studentid,sc.classname,s.cause,s.type,s.create_time")->select();

      foreach ($move as  &$value) {
        $value['create_time'] = date("Y-m-d H:i:s",$value['create_time']);
        if($value['type']==1)
        {
          $value['type'] = '退学';
        }else{
          $value['type'] = '毕业';
        }
      }

        if (!empty($move)){
           $ret = $this->format_ret_else(1,$move);
           echo json_encode($move);
        }else{
            $ret = $this->format_ret_else(0,"parms lost");
            echo json_encode($ret);
        }


    }


     public function rep_study()
   { 
       $schoolid = I("schoolid");
        
      $studentid = I('ids')[0];
  

      $classid = I('classid');
     


      $moveid = I('moveid')[0];


      if($studentid)
      {
        
        $student_info = M("student_info")->where("schoollid = $schoolid and userid = $studentid ")->save(array("status"=>1,"classid"=>$classid));
          
        if($student_info)
        {
          $add_class = array(
               "schoolid"=>$schoolid,
               "classid"=>$classid,
               "userid"=>$studentid,
               "status"=>1,

            );
          $relation = M("class_relationship")->add($add_class);
       

            if($relation)
            {
              $del = M("student_move")->where("id = $moveid")->delete();
                
                $info['status'] = true;                                      
                      
                      echo json_encode($info);  

            }
        }


      }


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