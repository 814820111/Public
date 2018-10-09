<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class NoticeController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();

    }
    public function index() {
        $userid=$_SESSION['USER_ID'];
        $schoolid = $_SESSION['schoolid'];

        $level= $_SESSION['level'];
        $classid=I("cl_else");
        $id=$_SESSION["USER_ID"];
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
            // var_dump($teacher);

            $stu_group = M('department')->where("schoolid=$schoolid and status = 1")->select();
            //var_dump($stu_group);



        }

        $this->assign("tea_group",$tea_group); 

        $this->assign("stu_group",$stu_group); 

        $this->assign("class",$class);
        $this->assign("teacher",$teacher);
        $this->display("message");  
    }
    public function message(){
        $sendid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $content=I('content');

        $classid = I('classid');

        $school_student =I('school_student');
        // var_dump($school_student);

        $school_teacher = I('school_teacher');
        

        $studentid = I('student');
      

        //全校教师分组
        $teacher_group = I('teacher_group');
       
        // var_dump($teacher_group);
        // exit();
        //教师分组
        $tea_set = I('tea_set');

        //如果需要微信推送
        $wechat = I("wechat"); 
   
        if(!empty($wechat))
        {
            $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();

            $appid = $wxmanage['wx_appid'];
            $appsecret = $wxmanage['wx_appsecret'];
        }  

   
        // $user=I("tea");
        $user=I("teacherid");
    

        $user_arr=$user;
       //  var_dump($user_arr);
       // exit();
        $sned_self=I("sned_self");
        // var_dump($sned_self);
        // exit();
       //全校学生分组
        $student_group = I('student_group');
        
        //学生分组 
        $stu_set = I('stu_set');

        $optionsRadiosinline = I('optionsRadiosinline');

        $option_time =  strtotime(I('option_time'));
    
        //  if(time()<$option_time)
        // {
        //   $plan_status = 1;
        // }else{
        //   $this->error("发送时间不能小于当前时间");
        // }


        if($optionsRadiosinline)
        {
         if(time()<$option_time)
        {
          $plan_status = 1;
        }else{
          $this->error("发送时间不能小于当前时间");
        }

          $send_type = 2;
        }else{
          $send_type =1;
        }  




        if($sned_self){
            array_push($user,$sendid);
        }
        $user_name=I("user_name");
        if($user_name){
            $content=I('content').$user_name;
        }
        $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
        $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
        $data["userid"]=$sendid;
        $data["schoolid"]=$schoolid;
        $data["title"]=I("title");
        $data["send_user_name"]=$send_user_name;
        $data["content"]=$content;
        $data['send_type'] = $send_type;
        $data["create_time"]=time();
        $message=M('notice')->add($data);
        if($message){
           if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
              }
          }


          if($optionsRadiosinline)
          {
             $data_plan = array(
              'senduserId'=>$sendid,
              'sendusername'=>$send_user_name,
              'contentId'=>$message,
              'connent'=>$content,
              'level'=>2,
              'plantime'=>I('option_time'),
              'plantimeint'=>$option_time,
              'type'=>2,
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

            $student = M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id")->select();

               foreach ($student as  &$value) {
                
                $student_add=M('notice_receiverid')
                ->add(array(
                    "noticeid"=>$message,
                    "schoolid"=>$schoolid,//新增
                    "receiverid"=>$value['id']));
         // var_dump($class_add);

               }
            
         }
        
        //如果为全校教师
         if(!empty($school_teacher))
         {
            
            $where_teacher['u.schoolid'] =$schoolid;
           $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id")->select();
 
           foreach ($teacher as  &$value) {                
                $teacher_add=M('notice_receiverid')
                ->add(array(
                    "noticeid"=>$message,
                    "schoolid"=>$schoolid,//新增
                    "receiverid"=>$value['id'],));

                    if($optionsRadiosinline)
                     {
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value["name"],'type'=>2));
                     }
                  if($wechat)
                   { 
                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$content,$type);
                   }
               }
      
         }

         //如果为全校老师分组 
            if(!empty($teacher_group))
           {  
          
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
	                $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id")->select();
	                  foreach ($teacher as  &$value) {
	                
	                $teacher_add=M('notice_receiverid')
	                ->add(array(
	                    "noticeid"=>$message,
                        "schoolid"=>$schoolid,//新增
	                    "receiverid"=>$value['id'],));
                  
		              
                   if($optionsRadiosinline)
                     {
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value["name"],'type'=>2));
                     }   
                    if($wechat)
                   { 
                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$content,$type);
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
	            //var_dump($group);
	            foreach ($group as $value) {
	               
	              $where_d['department_id'] = $value['id'];
	              $where_d['school_id'] = $schoolid;
	              $department_teacher = M('department_teacher')->where($where_d)->field('teacher_id')->select();
	              foreach ($department_teacher as $val) {
	                $where_student['u.schoolid'] =$schoolid;
	                $where_student['s.userid'] = $val['teacher_id'];
	                $teacher = M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id,s.classid")->select();
	                  foreach ($teacher as  &$value) {
	                
	                $teacher_add=M('notice_receiverid')
	                ->add(array(
	                    "noticeid"=>$message,
                        "schoolid"=>$schoolid,//新增
	                    "receiverid"=>$value['id'],));
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

	                  

	               }

	              }
	            }
	        
	         }  







          //如果为老师的话

        if($user_arr){

            foreach ($user_arr as &$t_id) {
                $tid=$t_id;
              
                $receive_name=M('wxtuser')->field("name")->where("id=$tid")->find();
             
                $receive_add=M('notice_receiverid')
                ->add(array(
                    "noticeid"=>$message,
                    "schoolid"=>$schoolid,//新增
                    "receiverid"=>$tid));
                // var_dump($receive_add);
                  if($optionsRadiosinline)
                     {
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$tid,'receiveusername'=>$receive_name["name"],'type'=>2));
                     }
                if($wechat)
                 { 
                   $type = 2;
                   $this->wechat_push($appid,$appsecret,$message,$schoolid,$tid,$content,$type);
                 } 
              }

           }
            // var_dump($receive_add);
           
           //如果接收到班级则将该班级的每个学生信息都插入
           if($classid){
             
               $where['classid'] = array('in',$classid);
               $student_name =  M('class_relationship')->alias('c')->where($where)->join('wxt_wxtuser u ON c.userid=u.id')->field('c.userid,u.name,c.clssid')->select();
               //var_dump($student_name);

               foreach ($student_name as  &$value) {
                
                $class_add=M('notice_receiverid')
                ->add(array(
                    "noticeid"=>$message,
                    "schoolid"=>$schoolid,//新增
                    "receiverid"=>$value['userid']));
                  if($optionsRadiosinline)
                 {
                  $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['userid'],'receiveusername'=>$value["name"],'classid'=>$value['classid'],'type'=>1));
                 }
        // var_dump($class_add);
                if($wechat)
                 { 
                   $classid = $value['classid'];
                   $type = 1;
                   $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['userid'],$content,$type,$classid);
                 }


               }



           }
         //如果为学生
           if($studentid){
            foreach ($studentid as &$t_id) {
              //var_dump($studentid);
                $tid=$t_id;
                $receive_name=M('student_info')->field("stu_name,classid")->where("userid=$tid")->find();
               // var_dump($receive_name);
                $receive_add=M('notice_receiverid')
                ->add(array(
                    "noticeid"=>$message,
                    "schoolid"=>$schoolid,//新增
                    "receiverid"=>$tid));
                // var_dump($receive_add);
               if($optionsRadiosinline)
                {
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$tid,'classid'=>$receive_name['classid'],'receiveusername'=>$receive_name["stu_name"],'type'=>1));
                }
                             if($wechat)
                 { 
                   $classid = $receive_name['classid'];
                   $type = 1;
                   $this->wechat_push($appid,$appsecret,$message,$schoolid,$tid,$content,$type,$classid);
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
                $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id")->select();
          
                  foreach ($teacher as  &$value) {
                
                $teacher_add=M('notice_receiverid')
                ->add(array(
                    "noticeid"=>$message,
                    "receiverid"=>$value['id'],
           ));
                
                               if($optionsRadiosinline)
                     {
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value["name"],'type'=>2));
                     }
                    if($wechat)
                   { 

                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$content,$type);
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
                $teacher = M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id,s.classid")->select();
                  foreach ($teacher as  &$value) {
                
                $teacher_add=M('notice_receiverid')
                ->add(array(
                    "noticeid"=>$message,
                    "schoolid"=>$schoolid,//新增
                    "receiverid"=>$value['id'],
                 ));

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



               }


              }


            }



         }






        }
        // $data_pic['noticeid']=$message;
        // $data_pic['photo']=$_POST['smeta']['thumb'];
        // $data_pic['create_time']=time();
        //  $pic=M('notice_photo')->add($data_pic);
        if($message){
            $this->success("发送成功!");
        }else{
            $this->error("发送失败！");
        }
    } 

    //保存模板信息
    public function model_message(){
        $sendid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $change=I("hope");
        $date_mo["schoolid"]=$schoolid;
        $date_mo["userid"]=$sendid;
        $date_mo["content"]=$change;
        $date_mo["type"]=2;
        $date_mo["create_time"]=time();
        $where["type"]=2;
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

       $school_teacher = I('school_teacher');
      // var_dump($school_teacher);

      $stuid = I('stu_id');

      $stu_txt = I('stu_txt');

       $stu = array_combine($stuid, $stu_txt); 
       // var_dump($content);
        //个人教师
        $user=I("teacherid");
        $tea_txt = I('tea_txt');

       //将数组组合
       $tea=array_combine($user,$tea_txt);

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
  

      
      

  
   
  // $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
 

            //TODO重构  

            //start 
    
            if(!empty($tea))
            {   
         
                foreach ($tea as $key => $value){
                  $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                 // var_dump($send_user_name);
                  // exit();
                  $date["userid"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["title"]=I("title");
                  $date["content"]=$value;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["create_time"]=time();
                // var_dump($date);
                 $message=M('notice')->add($date);
               

           if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
              }
          }



                    $id = $key;

                    $receive_name=M('wxtuser')->field("name")->where("id=$id")->find();

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
                                'type'=>2,
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

   
                $receive_add=M('notice_receiverid')
                ->add(array(
                    "noticeid"=>$message,
                    "schoolid"=>$schoolid,//新增
                    "receiverid"=>$id));



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
                  $date["userid"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["content"]=$value;
                  $date["title"]=I("title");

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["create_time"]=time();
                // var_dump($date);
                 $message=M('notice')->add($date);

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
                                'type'=>2,
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

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
              }
          }
                    

                    //var_dump($key);
                    //var_dump($value);
                    $where['classid'] = array('in',"$key");
                    // var_dump($where);
                    $student_name =  M('class_relationship')->alias('c')->where($where)->join('wxt_student_info s ON c.userid=s.userid')->field('c.userid,s.stu_name,s.classid')->select();
                   // var_dump($student_name);
                  foreach ($student_name as &$value) {
//                        $class_add=M('user_message_reception')
//                        ->add(array(
//                            "message_id"=>$message,
//                            "receiver_user_id"=>$value['userid'],
//                         "receiver_user_name"=>$value["stu_name"]));
                      $class_add=M('notice_receiverid')
                          ->add(array(
                              "noticeid"=>$message,
                              "schoolid"=>$schoolid,//新增
                              "receiverid"=>$value['userid']));

                        //定时保存
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
                 $message=M('notice')->add($date);


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
                                'type'=>2,
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

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
              }
          }
              $department_id = $key;

              $tea_set = M('department_teacher')->where("department_id=$department_id")->field('teacher_id')->select();
            foreach ($tea_set as $val) {
                $teacherid = $val['teacher_id'];
                $where_teacher['u.schoolid'] =$schoolid;
                $where_teacher['t.teacherid'] = $val['teacher_id'];
                $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id")->select();
                  foreach ($teacher as  &$value) {                
//                $teacher_add=M('notice_receiverid')
//                ->add(array(
//                    "message_id"=>$message,
//                    "receiver_user_id"=>$value['id'],));
                      $class_add=M('notice_receiverid')
                          ->add(array(
                              "noticeid"=>$message,
                              "schoolid"=>$schoolid,//新增
                              "receiverid"=>$value['userid']));
                //定时
                if($optionsRadiosinline){ 
                 $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value['name'],'type'=>2));
                 }
                  //微信推送
                  if($wechat)
                   { 

                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$value['id'],$value,$type);
                   }


               }
        
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
                 $message=M('notice')->add($date);

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
                                'type'=>2,
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

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
              }
          }
                  
            
              $department_id = $key;

              $tea_set = M('department_teacher')->where("department_id=$department_id")->field('teacher_id')->select();
            foreach ($tea_set as $val) {

                $where_student['u.schoolid'] =$schoolid;
                $where_student['s.userid'] = $val['teacher_id'];
                $student= M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id,s.classid")->select();

                  foreach ($student as  &$value) {                
//                $teacher_add=M('notice_receiverid')
//                ->add(array(
//                    "message_id"=>$message,
//                    "receiver_user_id"=>$value['id'],));
                      $teacher_add=M('notice_receiverid')
                          ->add(array(
                              "noticeid"=>$message,
                              "schoolid"=>$schoolid,//新增
                              "receiverid"=>$value['id']));

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
           
              }

                    
           }  
           

        }


             //如果全校教师组不为空
            if(!empty($teacher_group))
            {
            
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
                 $message=M('notice')->add($date);
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
                                'type'=>2,
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

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
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
                  $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id")->select();
                    foreach ($teacher as  &$value) {
                  
                  $teacher_add=M('notice_receiverid')
                  ->add(array(
                      "noticeid"=>$message,
                      "schoolid"=>$schoolid,//新增
                      "receiverid"=>$value['id']));
                    if($optionsRadiosinline){ 
                      $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value['name'],'type'=>2));
                    }
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
                  $date["message_content"]=$teacher_group_txt;

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["message_time"]=time();
                // var_dump($date);
                 $message=M('notice')->add($date);


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
                                'type'=>2,
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

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
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
                  
                  $teacher_add=M('notice_receiverid')
                  ->add(array(
                      "noticeid"=>$message,
                      "schoolid"=>$schoolid,//新增
                      "receiverid"=>$value['id'],));

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
                $date["userid"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["content"]=$value;
                  $date["title"]=I("title");

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["create_time"]=time();
                // var_dump($date);
                 $message=M('notice')->add($date);

           if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
              }
          }


                $where_student['u.schoolid']=$schoolid;

                $student = M('student_info')->alias("s")->where($where_student)->join("wxt_wxtuser u ON s.userid=u.id")->field("u.name,u.id")->select();

                   foreach ($student as  &$value) {
                    
                    $student_add=M('notice_receiverid')
                    ->add(array(
                        "noticeid"=>$message,
                        "schoolid"=>$schoolid,//新增
                        "receiverid"=>$value['id']));
             // var_dump($class_add);

               }



            }

            //全校老师不为空的话
            if (!empty($school_teacher)) 
            {

            $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                  //var_dump($send_user_name);
                  // exit();
                  $date["userid"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["content"]=$value;
                  $date["title"]=I("title");

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["create_time"]=time();
                // var_dump($date);
                 $message=M('notice')->add($date);


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
                                'type'=>2,
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

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
              }
          }



                $where_teacher['u.schoolid'] =$schoolid;
               $teacher = M('teacher_info')->alias("t")->where($where_teacher)->join("wxt_wxtuser u ON t.teacherid=u.id")->field("u.name,u.id")->select();

              foreach ($teacher as  &$value) {
                    
                    $teacher_add=M('notice_receiverid')
                    ->add(array(
                        "noticeid"=>$message,
                        "schoolid"=>$schoolid,//新增
                        "receiverid"=>$value['id'],));
                             if($optionsRadiosinline){ 
                            $data_detail = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,'receiveuserid'=>$value['id'],'receiveusername'=>$value['name'],'type'=>2));
                 } 
                   if($wechat)
                   { 

                     $type = 2;
                     $this->wechat_push($appid,$appsecret,$message,$schoolid,$school_teacher,$value,$type);
                   }

               //var_dump($teacher_add);

               }  
                
            }

            //如果学生不为空的话
       if(!empty($stu))
       {

            foreach ($stu as $key => $value){
                  $send_user_name=M('wxtuser')->where("id=$sendid")->getField("name");
                 // var_dump($send_user_name);
                  // exit();
                   $date["userid"]=$sendid;
                  $date["schoolid"]=$schoolid;
                  $date["content"]=$value;
                  $date["title"]=I("title");

                // if(empty($date["message_content"])){
                //     $this->error("请输入要发送的内容");
                // }
                 $date["create_time"]=time();
                // var_dump($date);
                 $message=M('notice')->add($date);
              //  var_dump($message);

           if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];

               $pic_add = M("notice_photo")->add(array("noticeid"=>$message,"photo"=>$value,'create_time'=>time()));
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
                                'type'=>2,
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

   
                $receive_add=M('notice_receiverid')
                ->add(array(
                    "noticeid"=>$message,
                    "schoolid"=>$schoolid,//新增
                    "receiverid"=>$id));



                }




       }

        

     



     // $data_pic['message_id']=$message;
     //        $data_pic['picture_url']=$_POST['smeta']['thumb'];
     //        $pic=M('user_message_pic')->add($data_pic);

 
        
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
              
           $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/school_notice";
          // $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/school_notice";
          // $url = "http://127.0.0.1/wxt20161/index.php/Apps/sendTpl/t_notice";
           // $data['schoolid'] = $schoolid;
           $data['noticeid'] = $message;
           $data['userid'] = $id;
           $data['type'] = 1;
           // $data['classid'] = $classid;
           $data['uisid'] = $tid;
           $data['content'] = $content;
    
      
          $b = $this->http_request($url,$data);
         
      
      
          
        
       }else{

          // $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/t_notice";
          // $url = "http://127.0.0.1/wxt20161/index.php/Apps/sendTpl/t_notice";
        $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/t_notice";

              $data['message_id'] = $message;
              $data['content'] = $content;
              $data['userid'] =  $id;
              $data['uisid'] = $tid;
              $data['type'] = 3;
             
             
            $b = $this->http_request($url,$data);
           
           
           
            

            
       }


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
        if(empty($userid_arr)&&empty($class_arr)&&empty($school_student)&&empty($school_teacher)){
            $this->error("请选择发送的对象");
        }
        if($userid_arr){
            $userid_a=$userid_arr;
            $where_a["id"]=array("IN",$userid_arr);
            $stu_a=M("wxtuser")
            ->field("id,name")
            ->distinct(true)
            ->where($where_a)
            ->select();
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
            // foreach ($stu_b as &$item) {
            //     $id=$item["id"];
            //     foreach ($id as &$itvo) {
            //         array_push($userid_b,$itvo);
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
            // foreach ($stu as &$item) {
            //     $id=$item["id"];
            //     foreach ($id as &$itvo) {
            //         array_push($userid,$itvo);
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
            // foreach ($stu as &$item) {
            //     $id=$item["id"];
            //     foreach ($id as &$itvo) {
            //         array_push($userid,$itvo);
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
        $where_self["type"]=2;
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
            $where["content"]=array('LIKE',"%".$search."%");
        }
        if($begintime && $endtime){
            $where["create_time"]=array(array('EGT',$begin),array('ELT',$end));
        }
        if($level!=1  && $level!=2)
        {
            $where['userid'] = $userid;


        }
        
        $where['schoolid'] = $schoolid;
        $where['send_type'] = 1;

        $count=M('notice')->where($where)->count();
        $page = $this->page($count, 20);

        $list=M('notice')->order("id DESC")->where($where)->select();
        foreach ($list as &$item) {
            $mid=$item["id"];
            $uid=$item["userid"];
            $user_name=M("wxtuser")->field("name")->where("id=$uid")->find();
            $item["user_name"]=$user_name["name"];
            //获取图片
            $pic=M('notice_photo')->field("photo")->where("noticeid=$mid")->select();
            $item["photo"]=$pic;
            //获取接收人
            $count=M('notice_receiverid')->where("noticeid=$mid")->count();
            $item["count"]=$count;
        } 
//        $count=M('homework')->where($where)->count();

        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("list",$list);
        $this->display();
    }
    public function receive(){
        $id = intval($_GET['id']);
        $receive=M('notice_receiverid')
        ->alias("r")
        ->join("wxt_teacher_info w ON r.receiverid=w.teacherid")
        ->where("r.noticeid=$id")
        ->field("w.name")
        ->select();
        $this->assign("receive",$receive);
        $this->display();
    }
    public function delete(){
        $id = intval($_GET['id']);
        if($id){
            $rst=M('notice')->where("id=$id")->delete();
            $ret=M('notice_receiverid')->where("noticeid=$id")->delete();
            $rut=M('notice_photo')->where("noticeid=$id")->delete();
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
//        $id=$_SESSION["USER_ID"];
        if($level!=1  && $level!=2)
        {
            //TODO发送给老师是否开启权限需讨论
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

        $this->assign("tea_group",$tea_group); 

        $this->assign("stu_group",$stu_group);
        // var_dump()
        $this->assign("class",$class);
        // var_dump($class);
        $this->assign("teacher",$teacher);
        // var_dump($teacher);
        $this->display();
    }


    public function showstu()
    {   
      $schoolid = $_SESSION['schoolid'];

      $classid = I('classid');
   
     $where['c.schoolid'] = $schoolid;

     $where['c.classid'] = $classid;

     $student_name =  M('class_relationship')->alias('c')->where($where)->join('wxt_student_info u ON c.userid=u.userid')->field('c.userid,u.stu_name as name')->select();

      if ($student_name){
              $info['status'] = true;
             $info['msg'] = $student_name;
              }else{
                $info['status'] = false;
                 $info['msg'] = '404';
             }
           echo json_encode($info);      



    }

     public function stu_group()
    {
       $schoolid = $_SESSION['schoolid'];
      $groupid = I('groupid');
      
      // var_dump($groupid);
      // exit();

      $where['d.department_id']=$groupid;
      $where['d.school_id'] = $schoolid;
      $teacher_dep = M('department_teacher')->alias('d')->where($where)->join("wxt_wxtuser u ON d.teacher_id=u.id")->field('u.id,u.name,u.phone')->select();
      if ($teacher_dep){
              $info['status'] = true;
             $info['msg'] = $teacher_dep;
              }else{
                $info['status'] = false;
                 $info['msg'] = '404';
             }
               echo json_encode($info);      


    }

    public function timing_notice()
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
        $where['type'] = 2;
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