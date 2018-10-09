<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class MessageInfoController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();
    }

    public function index() {
        //用户信息
        $userid=$_SESSION['USER_ID'];
        $schoolid = $_SESSION['schoolid'];

        $level= $_SESSION['level'];

        $classid=I("cl_else");
       // var_dump($classid);
//        $id=$_SESSION["USER_ID"];
        if($level!=1  && $level!=2)
        {
//            $where['d.schoolid'] = $schoolid;
//            $where['d.teacherid'] = $userid;
            $where_class['teacher.schoolid'] = $schoolid;
            $where_class['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';

        }
        $where_class['c.schoolid'] = $schoolid;

        $class=M('school_class')->alias("c")->join($join_duty)->where($where_class)->field("c.id,c.classname")->order("id")->select();
        if($classid){

            $where['d.schoolid'] = $schoolid;

            $teacher=M('teacher_info')
            ->alias("d")
            ->where($where)
            ->join("wxt_wxtuser w ON d.teacherid=w.id")
            ->field("w.id,d.name")
            ->order("w.id ASC")
            ->select();
        }else{
           
           $where['d.schoolid'] = $schoolid;
          // var_dump($where);
            $teacher=M('teacher_info')
            ->alias("d")
            ->where($where)
            ->join("wxt_wxtuser w ON d.teacherid=w.id")
            ->field("w.id,d.name")
            ->order("w.id ASC")
            ->select();

            $tea_group = M('department')->where("schoolid=$schoolid and status = 2")->select();

            $stu_group = M('department')->where("schoolid=$schoolid and status = 1")->select();
            //var_dump($stu_group);

        }


        $remark = M("remarks")->select();
        $result = $this->getCate($remark,0);



        $html = '';
       foreach ($result as $val)
       {
          $html  .= "<option value=".$val['id'].">";
          $html  .=str_repeat('&nbsp', $val['count'] * 4).'|--'.$val['name'];
          $html  .= "</option>";
       }

        $message = M("SmsSchool")->where("schoolid = $schoolid")->find();//获取要发送的内容
        if (empty($message)){
            $this->assign("sendnull",1);
        }else{
            $month = date('Y-m',time());
            $messages = M("SmsSchool")->where("schoolid = $schoolid and month = '$month'")->find();
            $numzz=$messages['num'];
            $lognumzz=$messages['lognum'];
            if(empty($messages)){
                $messagea = M("SmsSchool")->where("schoolid = $schoolid")->order("id desc")->find();
                $num = M("SchoolProduct")
                    ->alias('sp')
                    ->join("wxt_product p ON p.id=sp.productid")
                    ->where("sp.schoolid = $schoolid and sp.producttype = 1")->order("sp.id desc")->field("p.num")->find();
                if(empty($num[num])){
                    $num[num]=0;
                }
                if($messagea) {
                    if ($messagea[lognum] > $messagea[taocannum]) {
                        $numss = $messagea[num] - $messagea[lognum] + $num[num];
                    } else {
                        $numss = $messagea[num] - $messagea[taocannum] + $num[num];
                    }
                }else{
                    $numss = $num[num];
                }
                $data['schoolid'] = $schoolid;
                $data['num'] = $numss;
                $data['lognum'] = 0;
                $data['taocannum'] = $num[num];
                $data['month'] = $month;
                M("SmsSchool")->add($data);
                $numzz=$numss;
                $lognumzz=0;
            }
            $this->assign("numzz",$numzz);
            $this->assign("lognumzz",$lognumzz);
        }

        $this->assign("tea_group",$tea_group);

         $this->assign("stu_group",$stu_group);
        $this->assign("class",$class);
        $this->assign("remark",$html);
        $this->assign("teacher",$teacher);
       	$this->display("message");  
    }

    function getCate($data, $id, $count = 0)
    {
        static $res = array();
        foreach ($data as $val) {
            if ($val['parentid'] == $id) {
                $val['count'] = $count;
                //var_dump($val['pid']);
                //var_dump($val);
                $res[] = $val;
                $this->getCate($data, $val['id'], $count + 1);
            }
        }
        return $res;
    }

    public function message(){
        $sendid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $content=I('content');

        $classid = I('classid');

        $school_student =I('school_student');
        // var_dump($school_student);

        $school_teacher = I('school_teacher');
        // var_dump($school_teacher);

        $studentid = I('student');

       //全校教师分组
        $teacher_group = I('teacher_group');
        // var_dump($teacher_group);
        // exit();
        //教师分组
        $tea_set = I('tea_set');

        $user=I("teacherid");
        // var_dump($user);
      //  exit();

        $user_arr=$user;
       //  var_dump($user_arr);
        $sned_self=I("sned_self");
        // var_dump($sned_self);
       
        //全校学生分组
        $student_group = I('student_group');
        
        //学生分组 
        $stu_set = I('stu_set');

        $optionsRadiosinline = I('optionsRadiosinline');

        $option_time =  strtotime(I('option_time'));
        // var_dump($option_time);
        // var_dump($optionsRadiosinline);
        
        //如果需要微信推送
        $wechat = I("wechat");
    
        if(!empty($wechat))
        {
//           $wxmanage = M('wxmanage')->where("schoolid = $schoolid")->find();

            $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();
            $appid = $wxmanage['wx_appid'];
            $appsecret = $wxmanage['wx_appsecret'];
        }      
  

        if($optionsRadiosinline)
        {
          $send_type = 2;
        }else{
          $send_type =1;
        }  

        

        if($sned_self){
            array_push($user,$sendid);
        }
        $user_name=I("user_name");
        if($user_name){
            $content=I('content').I('user_names');
        }
        // $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);

       

     
        //下次可以启用 图片是一次性存入数据库还是一条一条的存入  
       // $pic  = explode('|',$_POST['smeta']['thumb']);
      

        
    


        $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
        $data["send_user_id"]=$sendid;
        $data["schoolid"]=$schoolid;
        $data["send_user_name"]=$send_user_name;
        $data["message_content"]=$content;
        $data['send_type'] = $send_type;
        $data["message_time"]=time();
        $message=M('user_message')->add($data);
   

        $addtime=time();
        $addmonth= date('Y-m', time());
        $adddate=date("Y-m-d H:i:s",time());

        if($message){
            $duanxing = I('duanxing');

            if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {

                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
              }
          }

          if($optionsRadiosinline)
          { 
              if(time()<$option_time)
              {
                      $plan_status = 1;
              }else{
                $this->error("发送时间不能小于于当前时间");
              }

             $data_plan = array(
              'senduserId'=>$sendid,
              'sendusername'=>$send_user_name,
              'contentId'=>$message,
              'connent'=>$content,
              'level'=>1,
              'plantime'=>I('option_time'),
              'plantimeint'=>$option_time,
              'type'=>1,
              'addtime'=>date('Y-m-d H:i:s',time()),
              'addtimeint'=>time(),
              'status'=>$plan_status,
               'schoolid'=>$schoolid

            );
             $plantimming = M('plantimming')->add($data_plan);
            

          }
         //如果为全校学生  
         if(!empty($school_student))
         {   
             $where_student['u.schoolid']=$schoolid;

            $student = M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id,u.phone")->select();

               foreach ($student as  &$value) {
                
                $student_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$value['id'],
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$value["name"]));
                   if($duanxing){
                       M('message_sms')
                           ->add(array(
                               "message_id"=>$message,
                               "receiver_user_id"=>$value['id'],
                               "schoolid"=>$schoolid,//新增
                               "receiver_user_name"=>$value["name"],
                               "receiver_user_phone"=>$value["phone"],
                               "isstudent"=>1,
                               "addmonth"=>$addmonth,
                               "adddate"=>$adddate,
                               "addtime"=>$addtime));
                   }
         // var_dump($class_add);

               }
            
         }
        
        //如果为全校教师
         if(!empty($school_teacher))
         {
           

            $where_teacher['u.schoolid'] =$schoolid;
             $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id,u.phone")->select();

            foreach ($teacher as  &$value) {
                
                $teacher_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$value['id'],
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$value["name"]));
              //var_dump($teacher_add);
                 if($optionsRadiosinline)
                     {
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value["name"],'type'=>2));
                     }
                   if($wechat)
                   { 
                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$content,$type);
                   }
                if($duanxing){
                    M('message_sms')
                        ->add(array(
                            "message_id"=>$message,
                            "receiver_user_id"=>$value['id'],
                            "schoolid"=>$schoolid,//新增
                            "receiver_user_name"=>$value["name"],
                            "receiver_user_phone"=>$value["phone"],
                            "isstudent"=>0,
                            "addmonth"=>$addmonth,
                            "adddate"=>$adddate,
                            "addtime"=>$addtime));
                }
               }
         }

     //如果为全校教师分组 

         if(!empty($teacher_group))
         {
            // var_dump($teacher_group);
            $where['status'] = 2;

            $where['schoolid'] = $schoolid;

            $group = M('department')->where($where)->field('id')->select();
           
            foreach ($group as $value) {
               
              $where_d['department_id'] = $value['id'];
              $where_d['school_id'] = $schoolid;
              $department_teacher = M('department_teacher')->where($where_d)->field('teacher_id')->select();
              foreach ($department_teacher as $val) {
                $teacherid = $val['teacher_id'];
                $where_teacher['u.schoolid'] =$schoolid;
                $where_teacher['t.teacherid'] = $val['teacher_id'];
                $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id,u.phone")->select();
                  foreach ($teacher as  &$value) {
                
                $teacher_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$value['id'],
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$value["name"]));

                   if($optionsRadiosinline)
                     {
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value["name"],'type'=>2));
                     }
                  if($wechat)
                   { 
                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$content,$type);
                   }
                      if($duanxing){
                          M('message_sms')
                              ->add(array(
                                  "message_id"=>$message,
                                  "receiver_user_id"=>$value['id'],
                                  "schoolid"=>$schoolid,//新增
                                  "receiver_user_name"=>$value["name"],
                                  "receiver_user_phone"=>$value["phone"],
                                  "isstudent"=>0,
                                  "addmonth"=>$addmonth,
                                  "adddate"=>$adddate,
                                  "addtime"=>$addtime));
                      }
               }
              }
            }
         }
   
      //如果为全校学生分组

       if (!empty($student_group)) {
           $where['status'] = 1;

            $where['schoolid'] = $schoolid;

            $group = M('department')->where($where)->field('id')->select();
           // var_dump($group);
            foreach ($group as $value) {
               
              $where_d['department_id'] = $value['id'];
              $where_d['school_id'] = $schoolid;
              $department_teacher = M('department_teacher')->where($where_d)->field('teacher_id')->select();
              foreach ($department_teacher as $val) {
                $where_student['u.schoolid'] =$schoolid;
                $where_student['s.userid'] = $val['teacher_id'];
                $teacher = M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id,u.phone,s.classid")->select();
                  foreach ($teacher as  &$value) {
                
                $teacher_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$value['id'],
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$value["name"]));
                 if($optionsRadiosinline)
                 {
                  $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value["name"],'classid'=>$value['classid'],'type'=>1));
                 }
                if($wechat)
                 { 
                   $classid = $value['classid'];
                   $type = 1;
                   $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$content,$type,$classid);
                 }
                      if($duanxing){
                          M('message_sms')
                              ->add(array(
                                  "message_id"=>$message,
                                  "receiver_user_id"=>$value['id'],
                                  "schoolid"=>$schoolid,//新增
                                  "receiver_user_name"=>$value["name"],
                                  "receiver_user_phone"=>$value["phone"],
                                  "isstudent"=>1,
                                  "addmonth"=>$addmonth,
                                  "adddate"=>$adddate,
                                  "addtime"=>$addtime));
                      }
               }
              }
            }
         }  


      //老师
        if($user_arr){
              


            foreach ($user_arr as &$t_id) {
               
                
                $tid=$t_id;
                $receive_name=M('wxtuser')->field("name,phone")->where("id=$tid")->find();
                // var_dump($receive_name);

                $teacher_name = $receive_name['name'];
               // var_dump($teacher_name);
                $phone = $receive_name['phone'];
                $receive_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$tid,
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$receive_name["name"]));
                 if($optionsRadiosinline)
                 {
                  $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$tid,'receiveusername'=>$teacher_name,'type'=>2));
                 
                 }

                 if($wechat)
                 { 
                   $type = 2;
                   $this->wechat_push($appid,$appsecret,$message,$schoolid,$tid,$content,$type);
                 }
                if($duanxing){
                    M('message_sms')
                        ->add(array(
                            "message_id"=>$message,
                            "receiver_user_id"=>$tid,
                            "schoolid"=>$schoolid,//新增
                            "receiver_user_name"=>$receive_name["name"],
                            "receiver_user_phone"=>$phone,
                            "isstudent"=>0,
                            "addmonth"=>$addmonth,
                            "adddate"=>$adddate,
                            "addtime"=>$addtime));
                }
                // var_dump($receive_add);
              }
           }
            // var_dump($receive_add);
           
           //如果接收到班级则将该班级的每个学生信息都插入
           if($classid){
             
               $where['classid'] = array('in',$classid);
              // var_dump($classid);
               $student_name =  M('class_relationship')->alias('c')->where($where)->join('wxt_wxtuser u ON c.userid=u.id')->field('c.classid,c.userid,u.name,u.phone')->select();
               // var_dump($student_name);

               foreach ($student_name as  &$value) {
                
                $class_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$value['userid'],
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$value["name"]));

                 if($optionsRadiosinline)
                 {
                  $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['userid'],'receiveusername'=>$value["name"],'classid'=>$value['classid'],'type'=>1));
                 }

                   if($wechat)
                 { 
                   $classid = $value['classid'];
                   $type = 1;
                   $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['userid'],$content,$type,$classid);
                 }
                   if($duanxing){
                       M('message_sms')
                           ->add(array(
                               "message_id"=>$message,
                               "receiver_user_id"=>$value['userid'],
                               "schoolid"=>$schoolid,//新增
                               "receiver_user_name"=>$value["name"],
                               "receiver_user_phone"=>$value["phone"],
                               "isstudent"=>1,
                               "addmonth"=>$addmonth,
                               "adddate"=>$adddate,
                               "addtime"=>$addtime));
                   }
               }
           }

           if($studentid){
            foreach ($studentid as &$t_id) {
                $tid=$t_id;
                $receive_name=M('student_info')->field("stu_name,classid")->where("userid=$tid")->find();
                // var_dump($receive_name);
                $receive_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$tid,
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$receive_name["stu_name"]));
                // var_dump($receive_add);
               if($optionsRadiosinline)
                 {
                  $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$tid,'receiveusername'=>$receive_name["stu_name"],'classid'=>$receive_name['classid'],'type'=>1));
                 }
                  if($wechat)
                 { 
                   $classid = $receive_name['classid'];
                   $type = 1;
                   $this->wechat_push($appid,$appsecret,$message,$schoolid,$tid,$content,$type,$classid);
                 }
                if($duanxing){
                    M('message_sms')
                        ->add(array(
                            "message_id"=>$message,
                            "receiver_user_id"=>$tid,
                            "schoolid"=>$schoolid,//新增
                            "receiver_user_name"=>$receive_name["stu_name"],
                            "receiver_user_phone"=>0,
                            "isstudent"=>1,
                            "addmonth"=>$addmonth,
                            "adddate"=>$adddate,
                            "addtime"=>$addtime));
                }
              }
           }

         if($tea_set)
         {
           foreach ($tea_set as  $value){
              $department_id = $value;
              $tea_set = M('department_teacher')->where("department_id=$department_id")->field('teacher_id')->select();
            foreach ($tea_set as $val) {
                $teacherid = $val['teacher_id'];
                $where_teacher['u.schoolid'] =$schoolid;
                $where_teacher['t.teacherid'] = $val['teacher_id'];
                $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id,u.phone")->select();
                  foreach ($teacher as  &$value) {
                
                $teacher_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$value['id'],
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$value["name"]));
                       if($optionsRadiosinline)
                     {
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value["name"],'type'=>2));
                     }
                    if($wechat)
                   {
                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$content,$type);
                   }
                      if($duanxing){
                          M('message_sms')
                              ->add(array(
                                  "message_id"=>$message,
                                  "receiver_user_id"=>$value['userid'],
                                  "schoolid"=>$schoolid,//新增
                                  "receiver_user_name"=>$value["name"],
                                  "receiver_user_phone"=>$value["phone"],
                                  "isstudent"=>0,
                                  "addmonth"=>$addmonth,
                                  "adddate"=>$adddate,
                                  "addtime"=>$addtime));
                      }
                 }
              }
           }
         }

         if($stu_set)
         {

             foreach ($stu_set as  $value){
              $department_id = $value;
              $stu_set = M('department_teacher')->where("department_id=$department_id")->field('teacher_id')->select();
            foreach ($stu_set as $val) {
                $where_student['u.schoolid'] =$schoolid;
                $where_student['s.userid'] = $val['teacher_id'];
                $teacher = M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id,s.classid,u.phone")->select();
                  foreach ($teacher as  &$value) {
                
                $teacher_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$value['id'],
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$value["name"]));

                 if($optionsRadiosinline)
                 {
                  $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value["name"],'classid'=>$value['classid'],'type'=>1));
                 }

                  if($wechat)
                 { 
                   $classid = $value['classid'];
                   $type = 1;
                   $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$content,$type,$classid);
                 }
                      if($duanxing){
                          M('message_sms')
                              ->add(array(
                                  "message_id"=>$message,
                                  "receiver_user_id"=>$value['userid'],
                                  "schoolid"=>$schoolid,//新增
                                  "receiver_user_name"=>$value["name"],
                                  "receiver_user_phone"=>$value["phone"],
                                  "isstudent"=>1,
                                  "addmonth"=>$addmonth,
                                  "adddate"=>$adddate,
                                  "addtime"=>$addtime));
                      }
               }
              }
            }
         }
            if($duanxing){
                $duanx=$this->sms_push($message);
            }

      }

        if($message){
            $this->success("发送成功");
        }else{
            $this->error("发送失败！");
        }
    }
  





    //保存模板
    public function model_message(){
        $sendid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $change=I("hope");
        $date_mo["schoolid"]=$schoolid;
        $date_mo["userid"]=$sendid;
        $date_mo["content"]=$change;
        $date_mo["type"]=1;
        $date_mo["create_time"]=time();
        $where["type"]=1;
        $where["schoolid"]=$schoolid;
        $model=M('message_model')->where($where)->find();
        if($model){
            $update=M('message_model')->where($where)->save($date_mo);
        }else{
            $update=M('message_model')->add($date_mo);
        }
    }
    //各自发送信息时的处理方法
    public function message_self(){
        $sendid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $content=I('message_content');
         //班级
        $classid = I('classid');
     // var_dump($classid);
        $class_txt = I('class_txt');
     //  var_dump($class_txt);
          
       $class = array_combine($classid,$class_txt);
       //var_dump($class);

       $school_student = I('school_student');

     //  var_dump($school_student);


        $duanxing=I('duanxing');
        $messageidarray=array();
        $addtime=time();
        $addmonth= date('Y-m', time());
        $adddate=date("Y-m-d H:i:s",time());


       $school_teacher = I('school_teacher');
      // var_dump($school_teacher);

      $stuid = I('stu_id');

      $stu_txt = I('stu_txt');

       $stu = array_combine($stuid, $stu_txt); 
       // var_dump($content);
        //个人教师
        $user=I("teacherid");

        $tea_txt = I('tea_txt');

       //var_dump($tea_txt);
      // var_dump($user);
       //将数组组合
       $tea=array_combine($user,$tea_txt);
      // var_dump($tea);

       //全校教师组
       $teacher_group = I('teacher_group');

       $teacher_group_txt = I('teacher_group_txt');
     
       //教师组
       $tea_set = I('tea_set');

       $tea_set_txt = I('tea_set_txt');

       $tea_s = array_combine($tea_set, $tea_set_txt);

       //全校学生组

       $student_group = I('student_group');
       
       $student_group_txt = I('student_group_txt');

      //学生组
      $stu_set = I('stu_set');

      $stu_set_txt = I('stu_set_txt');

       $stu_s = array_combine($stu_set, $stu_set_txt);    
             $optionsRadiosinline = I('optionsRadiosinline');

        $option_time =  strtotime(I('option_time'));
       

        if($optionsRadiosinline)
        {  
            if(time()<$option_time)
         {
                $plan_status = 1;
         }else{
          $this->error("发送时间不能小于于当前时间");
         }
       
     
            $date['send_type']  = 2;      
        }else{
          $date['send_type']  = 1;
        }
          //如果需要微信推送
        $wechat = I("wechat");
    
        if(!empty($wechat))
        {
//           $wxmanage = M('wxmanage')->where("schoolid = $schoolid")->find();
            $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();
            $appid = $wxmanage['wx_appid'];
            $appsecret = $wxmanage['wx_appsecret'];
        }      
  
       
      
  $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
 

            //TODO重构  

            //start 
    
            if(!empty($tea))
            {
                foreach ($tea as $key => $value){
                  $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                 // var_dump($send_user_name);

                       
                                    // exit();
                  $date["send_user_id"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["send_user_name"]=$send_user_name;
                  $date["message_content"]=$value;
            // var_dump($date);
                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('user_message')->add($date);
              //  var_dump($message);
                    $messageidarray[]=$message;

            if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
              }
          }


                    $id = $key;

                    $receive_name=M('wxtuser')->field("name,phone")->where("id=$id")->find();
                    // var_dump($receive_name);
                       if($optionsRadiosinline)
                         {
                               $data_plan = array(
                                'senduserId'=>$sendid,
                                'sendusername'=>$send_user_name,
                                'contentId'=>$message,
                                'connent'=>$value,
                                'level'=>1,
                                'plantime'=>I('option_time'),
                                'plantimeint'=>$option_time,
                                'type'=>1,
                                'addtime'=>date('Y-m-d H:i:s',time()),
                                'addtimeint'=>time(),
                                'status'=>$plan_status,
                                 'schoolid'=>$schoolid


                              );

                               $plantimming = M('plantimming')->add($data_plan);

                               $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$id,'receiveusername'=>$receive_name['name'],'type'=>2));
                              

                        }
                    if($wechat)
                   { 

                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$id,$value,$type);
                   }


   
                $receive_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$id,
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$receive_name["name"]));



                }
                if($duanxing){
                    M('message_sms')
                        ->add(array(
                            "message_id"=>$message,
                            "receiver_user_id"=>$id,
                            "schoolid"=>$schoolid,//新增
                            "receiver_user_name"=>$receive_name["name"],
                            "receiver_user_phone"=>$receive_name["phone"],
                            "isstudent"=>0,
                            "addmonth"=>$addmonth,
                            "adddate"=>$adddate,
                            "addtime"=>$addtime));
                }
            }
             //如果班级不为空的话
            if(!empty($class))
            {
                 foreach ($class as $key => $value) 
                 {  

                $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                 // var_dump($send_user_name);
                  // exit();
                  $date["send_user_id"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["send_user_name"]=$send_user_name;
                  $date["message_content"]=$value;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('user_message')->add($date);
                     $messageidarray[]=$message;
             if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
              }
          }

                   if($optionsRadiosinline)
                         {
                               $data_plan = array(
                                'senduserId'=>$sendid,
                                'sendusername'=>$send_user_name,
                                'contentId'=>$message,
                                'connent'=>$value,
                                'level'=>1,
                                'plantime'=>I('option_time'),
                                'plantimeint'=>$option_time,
                                'type'=>1,
                                'addtime'=>date('Y-m-d H:i:s',time()),
                                'addtimeint'=>time(),
                                'status'=>$plan_status,
                                 'schoolid'=>$schoolid


                              );

                               $plantimming = M('plantimming')->add($data_plan);

                               // $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$id,'receiveusername'=>$receive_name['name'],'type'=>2));
                              

                        }  

                    //var_dump($key);
                    //var_dump($value);
                    $where['c.classid'] = array('in',"$key");
                    // var_dump($where);
                    $student_name =  M('class_relationship')->alias('c')->where($where)->join('wxt_student_info s ON c.userid=s.userid')->field('c.userid,s.stu_name,s.classid')->select();

                     


               
                    foreach ($student_name as &$value) {
                        $class_add=M('user_message_reception')
                        ->add(array(
                            "message_id"=>$message,
                            "receiver_user_id"=>$value['userid'],
                            "schoolid"=>$schoolid,//新增
                         "receiver_user_name"=>$value["stu_name"]));

                        if($duanxing){
                            M('message_sms')
                                ->add(array(
                                    "message_id"=>$message,
                                    "receiver_user_id"=>$value['userid'],
                                    "schoolid"=>$schoolid,//新增
                                    "receiver_user_name"=>$value["stu_name"],
                                    "receiver_user_phone"=>0,
                                    "isstudent"=>1,
                                    "addmonth"=>$addmonth,
                                    "adddate"=>$adddate,
                                    "addtime"=>$addtime));
                        }

                        if($optionsRadiosinline){
                        $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['userid'],'classid'=>$value['classid'],'receiveusername'=>$value['stu_name'],'type'=>1));
                      }
                  if($wechat)
                   { 
                     $classid = $value['classid'];
                     $type = 1;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['userid'],$value,$type,$classid);
                   }


                    }


                 }
                
               
            }



          //如果教师组不为空
         if(!empty($tea_s))
         { 
              foreach ($tea_s as $key => $value) 
              {
                     
                  $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                 // var_dump($send_user_name);
                  // exit();
                  $date["send_user_id"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["send_user_name"]=$send_user_name;
                  $date["message_content"]=$value;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('user_message')->add($date);
                  $messageidarray[]=$message;
                    if($optionsRadiosinline)
                         {
                               $data_plan = array(
                                'senduserId'=>$sendid,
                                'sendusername'=>$send_user_name,
                                'contentId'=>$message,
                                'connent'=>$value,
                                'level'=>1,
                                'plantime'=>I('option_time'),
                                'plantimeint'=>$option_time,
                                'type'=>1,
                                'addtime'=>date('Y-m-d H:i:s',time()),
                                'addtimeint'=>time(),
                                'status'=>$plan_status,
                                 'schoolid'=>$schoolid


                              );

                               $plantimming = M('plantimming')->add($data_plan);

                               // $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$id,'receiveusername'=>$receive_name['name'],'type'=>2));
                              

                        }


              if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
              }
          }
                  
            
              $department_id = $key;

              $tea_set = M('department_teacher')->where("department_id=$department_id")->field('teacher_id')->select();
            foreach ($tea_set as $val) {
                $teacherid = $val['teacher_id'];
                $where_teacher['u.schoolid'] =$schoolid;
                $where_teacher['t.teacherid'] = $val['teacher_id'];
                $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id,u.phone")->select();
                  foreach ($teacher as  &$value) {                
                $teacher_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$value['id'],
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$value["name"]));

                      if($duanxing){
                          M('message_sms')
                              ->add(array(
                                  "message_id"=>$message,
                                  "receiver_user_id"=>$value['id'],
                                  "schoolid"=>$schoolid,//新增
                                  "receiver_user_name"=>$value["name"],
                                  "receiver_user_phone"=>$value["phone"],
                                  "isstudent"=>0,
                                  "addmonth"=>$addmonth,
                                  "adddate"=>$adddate,
                                  "addtime"=>$addtime));
                      }

                if($optionsRadiosinline){ 
                 $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value['name'],'type'=>2));
                 }
                   if($wechat)
                   { 

                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$value,$type);
                   }

               }
              // var_dump($teacher_add);
              }

                    
           }  
           

        }
    

        //如果学生组不为空
         if(!empty($stu_s))
         { 
              foreach ($stu_s as $key => $value) 
              {
                     
                  $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                 // var_dump($send_user_name);
                  // exit();
                  $date["send_user_id"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["send_user_name"]=$send_user_name;
                  $date["message_content"]=$value;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('user_message')->add($date);
                  $messageidarray[]=$message;
                  if($optionsRadiosinline)
                   {
                           $data_plan = array(
                                'senduserId'=>$sendid,
                                'sendusername'=>$send_user_name,
                                'contentId'=>$message,
                                'connent'=>$value,
                                'level'=>1,
                                'plantime'=>I('option_time'),
                                'plantimeint'=>$option_time,
                                'type'=>1,
                                'addtime'=>date('Y-m-d H:i:s',time()),
                                'addtimeint'=>time(),
                                'status'=>$plan_status,
                                 'schoolid'=>$schoolid


                              );

                          $plantimming = M('plantimming')->add($data_plan);

                               // $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$id,'receiveusername'=>$receive_name['name'],'type'=>2));
                              

                        }


               if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
              }
          }
                  
            
              $department_id = $key;

              $tea_set = M('department_teacher')->where("department_id=$department_id")->field('teacher_id')->select();
            foreach ($tea_set as $val) {

                $where_student['u.schoolid'] =$schoolid;
                $where_student['s.userid'] = $val['teacher_id'];
                $student= M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id,s.classid")->select();

                  foreach ($student as  &$value) {                
                $teacher_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$value['id'],
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$value["name"]));

                      if($duanxing){
                          M('message_sms')
                              ->add(array(
                                  "message_id"=>$message,
                                  "receiver_user_id"=>$value['id'],
                                  "schoolid"=>$schoolid,//新增
                                  "receiver_user_name"=>$value["name"],
                                  "receiver_user_phone"=>0,
                                  "isstudent"=>1,
                                  "addmonth"=>$addmonth,
                                  "adddate"=>$adddate,
                                  "addtime"=>$addtime));
                      }

                if($optionsRadiosinline){
                $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'classid'=>$value['classid'],'receiveusername'=>$value['name'],'type'=>1));
                 }

                   if($wechat)
                   { 
                     $classid = $value['classid'];
                     $type = 1;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$value,$type,$classid);
                   }

               }
              // var_dump($teacher_add);
              }

                    
           }  
           

        }







             //如果全校教师组不为空
            if(!empty($teacher_group))
            {
              //var_dump($teacher_group);
               $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                  //var_dump($send_user_name);
                  // exit();
                  $date["send_user_id"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["send_user_name"]=$send_user_name;
                  $date["message_content"]=$teacher_group_txt;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('user_message')->add($date);
                $messageidarray[]=$message;
                
                    if($optionsRadiosinline)
                        {
                               $data_plan = array(
                                'senduserId'=>$sendid,
                                'sendusername'=>$send_user_name,
                                'contentId'=>$message,
                                'connent'=>$teacher_group_txt,
                                'level'=>1,
                                'plantime'=>I('option_time'),
                                'plantimeint'=>$option_time,
                                'type'=>1,
                                'addtime'=>date('Y-m-d H:i:s',time()),
                                'addtimeint'=>time(),
                                'status'=>$plan_status,
                                 'schoolid'=>$schoolid


                              );

                               $plantimming = M('plantimming')->add($data_plan);

                               // $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$id,'receiveusername'=>$receive_name['name'],'type'=>2));
                              

                        }
               


               if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
              }
          }

              $where['schoolid'] = $schoolid;
              $where['status'] = 2;

              $group = M('department')->where($where)->field('id')->select();
             
              foreach ($group as $value) {
                 
                $where_d['department_id'] = $value['id'];
                $where_d['school_id'] = $schoolid;
                $department_teacher = M('department_teacher')->where($where_d)->field('teacher_id')->select();
                foreach ($department_teacher as $val) {
                  $teacherid = $val['teacher_id'];
                  $where_teacher['u.schoolid'] =$schoolid;
                  $where_teacher['t.teacherid'] = $val['teacher_id'];
                  $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id,u.phone")->select();
                    foreach ($teacher as  &$value) {
                  
                  $teacher_add=M('user_message_reception')
                  ->add(array(
                      "message_id"=>$message,
                      "receiver_user_id"=>$value['id'],
                      "schoolid"=>$schoolid,//新增
                      "receiver_user_name"=>$value["name"]));

                        if($duanxing){
                            M('message_sms')
                                ->add(array(
                                    "message_id"=>$message,
                                    "receiver_user_id"=>$value['id'],
                                    "schoolid"=>$schoolid,//新增
                                    "receiver_user_name"=>$value["name"],
                                    "receiver_user_phone"=>$value["phone"],
                                    "isstudent"=>0,
                                    "addmonth"=>$addmonth,
                                    "adddate"=>$adddate,
                                    "addtime"=>$addtime));
                        }

                   if($optionsRadiosinline){ 
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value['name'],'type'=>2));
                    }
             // var_dump($teacher_add);
                  if($wechat)
                   { 

                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$value,$type);
                   }


                }
 
               }
             }

               
         }

         //如果全校学生组不为空

         if(!empty($student_group))
         {
          $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                  //var_dump($send_user_name);
                  // exit();
                  $date["send_user_id"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["send_user_name"]=$send_user_name;
                  $date["message_content"]=$student_group_txt;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('user_message')->add($date);
             $messageidarray[]=$message;
                      if($optionsRadiosinline)
                        {
                               $data_plan = array(
                                'senduserId'=>$sendid,
                                'sendusername'=>$send_user_name,
                                'contentId'=>$message,
                                'connent'=>$student_group_txt,
                                'level'=>1,
                                'plantime'=>I('option_time'),
                                'plantimeint'=>$option_time,
                                'type'=>1,
                                'addtime'=>date('Y-m-d H:i:s',time()),
                                'addtimeint'=>time(),
                                'status'=>$plan_status,
                                 'schoolid'=>$schoolid


                              );

                               $plantimming = M('plantimming')->add($data_plan);

                               // $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$id,'receiveusername'=>$receive_name['name'],'type'=>2));
                              

                        }


                 if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
              }
          }

              $where['schoolid'] = $schoolid;
              $where['status'] = 1;

              $group = M('department')->where($where)->field('id')->select();
            
            foreach ($group as $value) {
                 
                $where_d['department_id'] = $value['id'];
                $where_d['school_id'] = $schoolid;
                $department_teacher = M('department_teacher')->where($where_d)->field('teacher_id')->select();
                foreach ($department_teacher as $val) {
                
                  $where_student['u.schoolid'] =$schoolid;
                  $where_student['s.userid'] = $val['teacher_id'];
                  $teacher = M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id,s.classid")->select();
                    foreach ($teacher as  &$value) {
                  
                  $teacher_add=M('user_message_reception')
                  ->add(array(
                      "message_id"=>$message,
                      "receiver_user_id"=>$value['id'],
                      "schoolid"=>$schoolid,//新增
                      "receiver_user_name"=>$value["name"]));

                        if($duanxing){
                            M('message_sms')
                                ->add(array(
                                    "message_id"=>$message,
                                    "receiver_user_id"=>$value['id'],
                                    "schoolid"=>$schoolid,//新增
                                    "receiver_user_name"=>$value["name"],
                                    "receiver_user_phone"=>0,
                                    "isstudent"=>1,
                                    "addmonth"=>$addmonth,
                                    "adddate"=>$adddate,
                                    "addtime"=>$addtime));
                        }

                if($optionsRadiosinline){
                $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'classid'=>$value['classid'],'receiveusername'=>$value['name'],'type'=>1));
                 }
                  if($wechat)
                   { 
                     $classid = $value['classid'];
                     $type = 1;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$student_group_txt,$type,$classid);
                   }
        

                }
 
               }
             }



         }




            //如果全校学生不为空

            if(!empty($school_student))
            {
                

                $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                  //var_dump($send_user_name);
                  // exit();
                  $date["send_user_id"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["send_user_name"]=$send_user_name;
                  $date["message_content"]=$school_student;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('user_message')->add($date);
                $messageidarray[]=$message;
                 





                 if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
              }
          }

                $where_student['u.schoolid']=$schoolid;

                $student = M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id")->select();

                   foreach ($student as  &$value) {
                    
                    $student_add=M('user_message_reception')
                    ->add(array(
                        "message_id"=>$message,
                        "receiver_user_id"=>$value['id'],
                        "schoolid"=>$schoolid,//新增
                        "receiver_user_name"=>$value["name"]));
             // var_dump($class_add);

                       if($duanxing){
                           M('message_sms')
                               ->add(array(
                                   "message_id"=>$message,
                                   "receiver_user_id"=>$value['id'],
                                   "schoolid"=>$schoolid,//新增
                                   "receiver_user_name"=>$value["name"],
                                   "receiver_user_phone"=>0,
                                   "isstudent"=>1,
                                   "addmonth"=>$addmonth,
                                   "adddate"=>$adddate,
                                   "addtime"=>$addtime));
                       }

               }



            }

            //全校老师不为空的话
            if (!empty($school_teacher)) 
            {

            $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                  //var_dump($send_user_name);
                  // exit();
                  $date["send_user_id"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["send_user_name"]=$send_user_name;
                  $date["message_content"]=$school_teacher;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('user_message')->add($date);
                $messageidarray[]=$message;
                     if($optionsRadiosinline)
                        {
                               $data_plan = array(
                                'senduserId'=>$sendid,
                                'sendusername'=>$send_user_name,
                                'contentId'=>$message,
                                'connent'=>$school_teacher,
                                'level'=>1,
                                'plantime'=>I('option_time'),
                                'plantimeint'=>$option_time,
                                'type'=>1,
                                'addtime'=>date('Y-m-d H:i:s',time()),
                                'addtimeint'=>time(),
                                'status'=>$plan_status,
                                 'schoolid'=>$schoolid


                              );

                               $plantimming = M('plantimming')->add($data_plan);

                               // $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$id,'receiveusername'=>$receive_name['name'],'type'=>2));
                              

                        } 


               if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
              }
          }



                $where_teacher['u.schoolid'] =$schoolid;
               $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id,u.phone")->select();

              foreach ($teacher as  &$value) {
                    
                    $teacher_add=M('user_message_reception')
                    ->add(array(
                        "message_id"=>$message,
                        "receiver_user_id"=>$value['id'],
                        "schoolid"=>$schoolid,//新增
                        "receiver_user_name"=>$value["name"]));

                  if($duanxing){
                      M('message_sms')
                          ->add(array(
                              "message_id"=>$message,
                              "receiver_user_id"=>$value['id'],
                              "schoolid"=>$schoolid,//新增
                              "receiver_user_name"=>$value["name"],
                              "receiver_user_phone"=>$value["phone"],
                              "isstudent"=>0,
                              "addmonth"=>$addmonth,
                              "adddate"=>$adddate,
                              "addtime"=>$addtime));
                  }

               //var_dump($teacher_add);
                      if($optionsRadiosinline){ 
                        $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value['name'],'type'=>2));
                    }
                  if($wechat)
                   { 

                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$school_teacher,$value,$type);
                   }

                 
               }  
                
            }

            //如果学生不为空的话
       if(!empty($stu))
       {
            foreach ($stu as $key => $value){
                  $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                 // var_dump($send_user_name);
                  // exit();
                  $date["send_user_id"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["send_user_name"]=$send_user_name;
                  $date["message_content"]=$value;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('user_message')->add($date);
              //  var_dump($message);
                $messageidarray[]=$message;
                if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("user_message_pic")->add(array("message_id"=>$message,"picture_url"=>$value));
                }
             }
                    $id = $key;

                    $receive_name=M('student_info')->field("stu_name,classid")->where("userid=$id")->find();

                       if($optionsRadiosinline)
                         {
                               $data_plan = array(
                                'senduserId'=>$sendid,
                                'sendusername'=>$send_user_name,
                                'contentId'=>$message,
                                'connent'=>$value,
                                'level'=>1,
                                'plantime'=>I('option_time'),
                                'plantimeint'=>$option_time,
                                'type'=>1,
                                'addtime'=>date('Y-m-d H:i:s',time()),
                                'addtimeint'=>time(),
                                'status'=>$plan_status,
                                 'schoolid'=>$schoolid


                              );

                               $plantimming = M('plantimming')->add($data_plan);

                               $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$id,'classid'=>$receive_name['classid'],'receiveusername'=>$receive_name['stu_name'],'type'=>1));
                              

                        }
                  if($wechat)
                   { 
                     $classid = $receive_name['classid'];
                     $type = 1;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$id,$value,$type,$classid);
                   }

   
                $receive_add=M('user_message_reception')
                ->add(array(
                    "message_id"=>$message,
                    "receiver_user_id"=>$id,
                    "schoolid"=>$schoolid,//新增
                    "receiver_user_name"=>$receive_name["stu_name"]));

                if($duanxing){
                    M('message_sms')
                        ->add(array(
                            "message_id"=>$message,
                            "receiver_user_id"=>$id,
                            "schoolid"=>$schoolid,//新增
                            "receiver_user_name"=>$receive_name["stu_name"],
                            "receiver_user_phone"=>0,
                            "isstudent"=>1,
                            "addmonth"=>$addmonth,
                            "adddate"=>$adddate,
                            "addtime"=>$addtime));
                }

                }




       }

        

     



     // $data_pic['message_id']=$message;
     //        $data_pic['picture_url']=$_POST['smeta']['thumb'];
     //        $pic=M('user_message_pic')->add($data_pic);

        if($duanxing){
            $this->sms_push($messageidarray);
        }
        if($tea!=false || $class!=false || $school_student!=false || $school_teacher!=false || $teacher_group!=false || $tea_s!=false || $stu_s !=false || $stu!=false){
            $this->success("发送成功");
        }else{
            $this->error("发送失败");
        }
    }
 
  //调用模板传值

    public function wechat_push($appid,$appsecret,$message,$schoolid,$tid,$content,$type,$classid)
    {  
        $data['APPID'] = $appid;
        $data['APPSECRET'] = $appsecret;
       //发送人
       $id=$_SESSION["USER_ID"];



       if($type==1)
       {
          $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/classNotice";
           $data['schoolid'] = $schoolid;
           $data['message_id'] = $message;
           $data['userid'] = $id;
           $data['classid'] = $classid;
           $data['uisid'] = $tid;
           $data['content'] = $content;
           $b = $this->http_request($url,$data);
        
       }else{

          $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/t_notice";

           $data['message_id'] = $message;
           $data['schoolid'] = $schoolid;
              $data['content'] = $content;
              $data['userid'] =  $id;
              $data['uisid'] = $tid;
              $data['type'] = 2;
              // var_dump($data);
              $b = $this->http_request($url,$data);

            
       }


    }

    public function sms_push($message_id)
    {
        if(is_array($message_id)){
            $url = "http://up.zhixiaoyuan.net/index.php/Apps/PutSms/SendGXSms";
        }else {
            $url = "http://up.zhixiaoyuan.net/index.php/Apps/PutSms/SendQFSms?message_id=$message_id";
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置是否返回response header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //当需要通过curl_getinfo来获取发出请求的header信息时，该选项需要设置为true
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message_id);
        $response = curl_exec($ch);
        $request_header = curl_getinfo( $ch, CURLINFO_HEADER_OUT);
        //dump($response);dump($request_header);die;
        curl_close($ch);
        return $response;

    }



   public function timing_message()
   {  

       $begin = strtotime(I("begintime"));

       $end = strtotime(I("endtime"));


       if($begin &&  $end)
       {
           $where['plantimeint']  = array('GT',$begin);
           $where['plantimeint'] = array('LT',$end);
       }

       //用户信息
       $userid=$_SESSION['USER_ID'];

       $schoolid=$_SESSION['schoolid'];

       $level= $_SESSION['level'];
   
       $where['schoolid'] = $schoolid;
       $where['type'] = 1;
       $where['status'] = array('NEQ',5);
       if($level!=1  && $level!=2)
       {

           $where['senduserId'] = $userid;

       }




       $plantimming = M("plantimming")->where($where)->select();
   
       foreach ($plantimming as $key => &$value) {
           $planid = $value['id'];
       
           $detail = M("plantimmingdetail")->where("plantimmingid = $planid")->count();
        
           $value['sum'] = $detail;

           if($value['level']==1)
           {
               $value['level'] = '低级';
           }
           if($value['level']==2)
           {
               $value['level'] = '中级';
           }
           if($value['level']==3)
           {
               $value['level'] = '高级';
           }

           if($value['status']==1)
           {
               $value['status']='待发送';
           }
           if($value['status']==2)
           {
               $value['status']='暂停';
           }
           if($value['status']==3)
           {
               $value['status']='取消';
           }
           if($value['status']==4)
           {
               $value['status']='正在发送';
           }
           if($value['status']==5)
           {
               $value['status']='完成';
           }

           if($value['plantimeint'] < time())
           {
               $value['status'] = '已失效';
           }


       }

       // var_dump($plantimming);

       $this->assign("list",$plantimming);
       $this->display();
    

   }

    public function state()
    {
        $type = I('type');
        $id = I('ids');
        // var_dump($id);

     
   
        /**
         * 用type来为标识
         * 1删除
         * 2暂停
         * 3修改
         * 4继续
         *
         */
        switch ($type) {

            case '1':
                $where_one['id'] = array("in",$id);

                $del = M("plantimming")->where($where_one)->delete();
                // var_dump($del);

                if($del)
                {
                    $where_detail['plantimmingid'] = array('in',$id);
                    $detail_del = M("plantimmingdetail")->where($where_detail)->delete();
                }

                break;
            case '2':

                $where_two['id'] = array("in",$id);

                $save = M("plantimming")->where($where_two)->save(array("status"=>$type));
        
                break;
            case '3':
                $where_three['id'] = $id;
                $data_three['plantime'] = I('news');
                $data_three['plantimeint'] = strtotime(I('news'));
                $data_three['connent'] = I('main');
                // var_dump($data_three);
                $save = M("plantimming")->where($where_three)->save($data_three);
                break;
            case '4':
                $where_four['id'] = array("in",$id);

                $save = M("plantimming")->where($where_four)->save(array("status"=>1));
                break;
            default:
                # code...
                break;
        }
    
   
        $info['status'] = true;
        $info['msg'] = $teacherid;
   
        // $info['status'] = false;

        echo json_encode($info);

    }
    


    //分页进行,获取第一页传过来的用户id情况
    public function message_send(){
        $sendid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $content=I("message_content");

        $userid_arr=I("tea");
        $class_arr=I("cla");
        $school_student=I("school_student");
        $school_teacher=I("school_teacher");
        // if(empty($userid_arr)&&empty($class_arr)&&empty($school_student)&&empty($school_teacher)){
        //     $this->error("请选择发送对象");
        // }
        if($userid_arr){
            $userid_a=array();
            $where_a["id"]=array("IN",$userid_arr);
            $stu_a=M("wxtuser")->field("id,name")->distinct(true)->where($where_a)->select();

            // foreach($stu_a as &$item_a){
            //     $id_a=$item_a["id"];
            //     foreach ($id_a as $itvo_a) {
            //         array_push($userid_a, $itvo_a);
            //     }
            // }
        }
        
        if($class_arr){
            $userid_b=array();
            $where_b["c.classid"]=array("IN",$class_arr);
            $stu_b=M("class_relationship")
                ->alias("c")
                ->join("wxt_wxtuser w ON c.userid=w.id")
                ->field("w.id,w.name")
                ->distinct(true)
                ->where($where_b)
                ->select();
            // foreach ($stu_b as &$item_b) {
            //     $id_b=$item_b["id"];
            //     $name_b = $item_b["name"];
            //     foreach ($id_b as &$itvo_b) {
            //         array_push($userid_b,$itvo_b);        
            //     }
            // }
        }        
        if($school_student){
            $userid_c=array();
            $stu_c=M("class_relationship")
                ->alias("c")
                ->join("wxt_wxtuser w ON c.userid=w.id")
                ->field("w.id,w.name")
                ->distinct(true)
                ->where("c.schoolid=$schoolid")
                ->select();
            // foreach ($stu_c as &$item_c) {
            //     $id_c=$item_c["id"];
            //     foreach ($id_c as &$itvo_c) {
            //         array_push($userid_c,$itvo_c);
            //     }
            // }
        }
        
        if($school_teacher){
            $userid_d=array();
            $stu_d=M("duty_teacher")
                ->alias("c")
                ->join("wxt_wxtuser w ON c.teacher_id=w.id")
                ->field("w.id,w.name")
                ->distinct(true)
                ->where("c.schoolid=$schoolid")
                ->select();
            // foreach ($stu_d as &$item_d) {
            //     $id_d=$item_d["id"];
            //     foreach ($id_d as &$itvo_d) {
            //         array_push($userid_d,$itvo_d);
            //     }
            // }
        }
        $stu_name=array();
        foreach ($stu_a as &$sname) {
            $s_name=$sname["name"];
            array_push($stu_name,$s_name);
        }
        foreach ($stu_b as &$sname) {
            $s_name=$sname["name"];
            array_push($stu_name,$s_name);
        }
        foreach ($stu_c as &$sname) {
            $s_name=$sname["name"];
            array_push($stu_name,$s_name);
        }
        foreach ($stu_d as &$sname) {
            $s_name=$sname["name"];
            array_push($stu_name,$s_name);
        }
        $stu_id = array();
        foreach($stu_a as &$sid){
            $s_id = $sid["id"];
            array_push($stu_id,$s_id);
        }
        foreach($stu_b as &$sid){
            $s_id = $sid["id"];
            array_push($stu_id,$s_id);
        }
        foreach($stu_c as &$sid){
            $s_id = $sid["id"];
            array_push($stu_id,$s_id);
        }
        foreach($stu_d as &$sid){
            $s_id = $sid["id"];
            array_push($stu_id,$s_id);
        }
        $stus = array_combine($stu_id, $stu_name);


        $name=implode(",",$stu_name);
        $stu_id=implode(",",$stu_id);
        $where_self["schoolid"]=$schoolid;
        $where_self["type"]=1;
        $note=M('message_model')->where($where_self)->select();

        $this->assign("stu",$stus);
        $this->assign("note",$note);
        $this->assign("name",$name);
        $this->assign("stu_id",$stu_id);
        $this->display();

    }
    public function lists(){
        $userid=$_SESSION['USER_ID'];
        $schoolid = $_SESSION['schoolid'];

        $level= $_SESSION['level'];
        $search=I('search');
        $begintime=I("begintime");
        $endtime=I("endtime");
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        if($search){
            $where["message_content"]=array('LIKE',"%".$search."%");
        }
        if($begintime && $endtime){
            $where["message_time"]=array(array('EGT',$begin),array('ELT',$end));
        }


        if($level!=1  && $level!=2)
        {
            $where['send_user_id'] = $userid;


        }

        $where['schoolid'] = $schoolid;
        $where['send_type'] = 1;


        $count=M('user_message')->where($where)->count();
        $page = $this->page($count, 20);


        $list=M('user_message')->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();





        foreach ($list as &$item) {
            $mid=$item["id"];
            //获取图片
            $pic=M('user_message_pic')->field("picture_url")->where("message_id=$mid")->select();
            $item["picture_url"]=$pic;
            //获取接收人
            $count=M('user_message_reception')->where("message_id=$mid")->count();
            $item["count"]=$count;
        } 


        // var_dump($lists);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("list",$list);
        $this->display('listss');
    }
    public function receive(){
        $id = intval($_GET['id']);
        $receive=M('user_message_reception')
            ->where("message_id=$id")
            ->field("receiver_user_name as name,message_id,receiver_user_id")
            ->select();
        $smsarray = M('message_sms')->where("message_id=$id")->field("receiver_user_id,send_sms_id,phone_status")->select();
        $sms = array();
        if($smsarray) {
            foreach ($smsarray as $vaule) {
                $sms[$vaule[receiver_user_id]]=$vaule;
             }
        }
        if($smsarray) {
            foreach ($receive as &$val) {
                if($sms[$val[receiver_user_id]][send_sms_id] ==1){
                    if($sms[$val[receiver_user_id]][phone_status]){
                        $val[sendtype]=$sms[$val[receiver_user_id]][phone_status];
                    }else{
                        $val[sendtype]='短信未发送';
                    }
                }else{
                    $val[sendtype]='短信发送成功';
                }
            }
        }else{
            foreach ($receive as &$val) {
                $val[sendtype]='该消息未选择发送短信';
            }
        }
        $this->assign("receive",$receive);
        $this->display();
    }
    public function delete(){
        $id = intval($_GET['id']);
        if($id){
            $rst=M('user_message')->where("id=$id")->delete();
            $ret=M('user_message_reception')->where("message_id=$id")->delete();
            $rut=M('user_message_pic')->where("message_id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            } 
        }else{
            $this->error('数据传入失败！');
        }
    }
  

    public function list_info()
    {

        //用户信息
        $userid=$_SESSION['USER_ID'];
        $schoolid = $_SESSION['schoolid'];

        $level= $_SESSION['level'];

        $classid=I("cl_else");
        // var_dump($classid);

        if($level!=1  && $level!=2)
        {
//            $where['d.teacherid'] = $userid;
            $where_class['teacher.schoolid'] = $schoolid;
            $where_class['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';

        }

         $where_class['c.schoolid'] = $schoolid;

        $class=M('school_class')->alias("c")->join($join_duty)->where($where_class)->field("c.id,c.classname")->order("id")->select();

        if($classid){

            $where['d.schoolid'] = $schoolid;

            $teacher=M('teacher_info')
                ->alias("d")
                ->where($where)
                ->join("wxt_wxtuser w ON d.teacherid=w.id")
                ->field("w.id,d.name")
                ->order("w.id ASC")
                ->select();
        }else{
           
            $where['d.schoolid'] = $schoolid;
            // var_dump($where);
            $teacher=M('teacher_info')
                ->alias("d")
                ->where($where)
                ->join("wxt_wxtuser w ON d.teacherid=w.id")
                ->field("w.id,d.name")
                ->order("w.id ASC")
                ->select();

            $tea_group = M('department')->where("schoolid=$schoolid and status = 2")->select();

            $stu_group = M('department')->where("schoolid=$schoolid and status = 1")->select();
        }
        $remark = M("remarks")->select();
        $result = $this->getCate($remark,0);



        $html = '';
        foreach ($result as $val)
        {
            $html  .= "<option value=".$val['id'].">";
            $html  .=str_repeat('&nbsp', $val['count'] * 4).'|--'.$val['name'];
            $html  .= "</option>";
        }
        $this->assign("remark",$html);
        $this->assign("tea_group",$tea_group); 

        $this->assign("stu_group",$stu_group);

        // var_dump()
        $this->assign("class",$class);
        // var_dump($class);
        $this->assign("teacher",$teacher);
        // var_dump($teacher);
        $message = M("SmsSchool")->where("schoolid = $schoolid")->find();//获取要发送的内容
        if (empty($message)){
            $this->assign("sendnull",1);
        }else{
            $month = date('Y-m',time());
            $messages = M("SmsSchool")->where("schoolid = $schoolid and month = '$month'")->find();
            $numzz=$messages['num'];
            $lognumzz=$messages['lognum'];
            if(empty($messages)){
                $messagea = M("SmsSchool")->where("schoolid = $schoolid")->order("id desc")->find();
                $num = M("SchoolProduct")
                    ->alias('sp')
                    ->join("wxt_product p ON p.id=sp.productid")
                    ->where("sp.schoolid = $schoolid and sp.producttype = 1")->order("sp.id desc")->field("p.num")->find();
                if(empty($num[num])){
                    $num[num]=0;
                }
                if($messagea) {
                    if ($messagea[lognum] > $messagea[taocannum]) {
                        $numss = $messagea[num] - $messagea[lognum] + $num[num];
                    } else {
                        $numss = $messagea[num] - $messagea[taocannum] + $num[num];
                    }
                }else{
                    $numss = $num[num];
                }
                $data['schoolid'] = $schoolid;
                $data['num'] = $numss;
                $data['lognum'] = 0;
                $data['taocannum'] = $num[num];
                $data['month'] = $month;
                M("SmsSchool")->add($data);
                $numzz=$numss;
                $lognumzz=0;
            }
            $this->assign("numzz",$numzz);
            $this->assign("lognumzz",$lognumzz);
        }
    
        $this->display();
    }


    public function showstu()
    {   
        $schoolid = $_SESSION['schoolid'];

        $classid = I('classid');
        // var_dump($classid);
   
        $where['c.schoolid'] = $schoolid;

        $where['c.classid'] = $classid;
        $where['r.type'] = 1;



        $student_name =  M('class_relationship')->alias('c')->where($where)->join('wxt_student_info u ON c.userid=u.userid')->join("wxt_relation_stu_user r ON c.userid = r.studentid")->field('c.userid,u.stu_name as name,r.phone')->select();

        foreach ($student_name as $key => &$value) {
            if (!empty($value['phone'])) {
                $value['phone'] = substr_replace($value['phone'],'****',3,4);

            }


        }
    
        // var_dump($student_name);

        if ($student_name){
            $info['status'] = true;
            $info['msg'] = $student_name;
        }else{
            $info['status'] = false;
            $info['msg'] = '404';
        }
        echo json_encode($info);



    }


    public function tea_group()
    {
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];

        $groupid = I('groupid');

        if($level!=1  && $level!=2)
        {

            $where['d.teacher_id'] = $userid;

        }


        $where['d.department_id']=$groupid;
        $where['d.school_id'] = $schoolid;


        $teacher_dep = M('department_teacher')->alias('d')->where($where)->join("wxt_wxtuser u ON d.teacher_id=u.id")->join("wxt_teacher_info t ON t.teacherid=u.id")->field('u.id,t.name,u.phone')->select();

        // var_dump($teacher_dep);
        if ($teacher_dep){
            $info['status'] = true;
            $info['msg'] = $teacher_dep;
        }else{
            $info['status'] = false;
            $info['msg'] = '404';
        }
        echo json_encode($info);


    }

    public function stu_group()
    {
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
        $groupid = I('groupid');
      
   
        $where['d.department_id']=$groupid;
        $where['d.school_id'] = $schoolid;
        if($level!=1  && $level!=2)
        {

            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $userid;
            $join_class = 'wxt_class_relationship relationship ON d.teacher_id=relationship.userid';
            $join_duty = 'wxt_teacher_class teacher ON relationship.classid=teacher.classid';


        }



        $teacher_dep = M('department_teacher')->alias('d')->join($join_class)->join($join_duty)->where($where)->join("wxt_wxtuser u ON d.teacher_id=u.id")->field('u.id,u.name,u.phone')->select();
 
        if ($teacher_dep){
            $info['status'] = true;
            $info['msg'] = $teacher_dep;
        }else{
            $info['status'] = false;
            $info['msg'] = '404';
        }
        echo json_encode($info);


    }
    public function get_remark()
    {
        header("Content-type: text/html; charset=utf-8");
        $schoolid = $_SESSION['schoolid'];
        $remark = I("remarkid");


        if($remark)
        {
            $where['schoolid']  = $schoolid;
            $where['rid'] = $remark;
            $where['isdefault'] = 1;


            $where2['rid'] = $remark;
            $where2['isdefault'] = 0;
//            $where2['_logic']  = 'or';
//
            $where_main['_complex'] = array(
                $where,
                $where2,
                '_logic' => 'or'
            );

            $count = M("remarks_detail")->where($where_main)->count();

            $page = $this -> page($count, 5);
//            dump($page);
            $result1 = M("remarks_detail")-> limit($page -> firstRow . ',' . $page -> listRows)->where($where_main)->select();

            $Page[] =  $page -> show('Teacher');

            $result = array_merge($Page,$result1);



            if($result)
            {
                $ret = $this->format_ret(1,$result);

            }else{
                $ret = $this->format_ret(0,'parms lost');

            }
            echo json_encode($ret);
            exit;
        }else{
            $ret = $this->format_ret(0,'数据有误!');
            echo json_encode($ret);
            exit;
        }

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
      
    //curl  post请求

    public  function http_request($url, $data = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


}

