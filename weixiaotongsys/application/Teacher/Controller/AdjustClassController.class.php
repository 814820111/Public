<?php
/**
 * 学生信息
*/
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class AdjustClassController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();



    }

  public function add(){
    $schoolid = $_SESSION['schoolid'];
        //获取班级
        $class = M('school_class')->where("schoolid=$schoolid")->field('id,classname')->select();
        //获取亲戚关系
        $appellation = M('appellation')->field('id,appellation_name')->select();
        //获取学生组信息       
        $in_group = M('department')->where("schoolid=$schoolid and status = 1")->field('id,name')->select();
        $this->assign('relation',$appellation);
        $this->assign('classname',$class);
        $this->assign('group',$in_group);
      $this->display();
    }

   
    //修改学生资料
public function change(){
  $schoolid=$_SESSION['schoolid'];
  $id =intval(I('id'));
  $student=M('student_info')->where("userid=$id")->select();//查询学生的基础信息
    $where["studentid"]=$id;
    $where["type"]=1;
    $parentid=M("relation_stu_user")->where($where)->select();//查家长的基本信息
    $userid=$parentid["0"]["userid"];
    $phone=$parentid["0"]["phone"];
    $charging_phone=$parentid["0"]["charging_phone"];
    $res2=M("wxtuser")->where("id=$userid")->field("name")->select();//查找家长的名字   
    $classname = M('school_class')->where("schoolid=$schoolid")->field('id,classname')->select();//查找该学校所有的班级 
    $appellation = M('appellation')->field('id,appellation_name')->select(); //获取亲戚关系     
    $group = M('student_group')->where("schoolid=$schoolid")->field('id,group_name')->select();//获取学生组信息
    $this->assign("phone",$phone);
    $this->assign("charging_phone",$charging_phone);
    $this->assign("res2",$res2);
    $this->assign("appellation",$appellation); 
    $this->assign("student",$student); 
    $this->assign("classname",$classname);
    $this->assign("group",$group);
    
  $this->display();
}


   
   public function  edit_class()
   {  
      $schoolid=$_SESSION['schoolid'];
      $studentid = I("ids");
 
     

      $classid = I("classid");

      $old_Class = I('oldclass');
     
 

   

      $id =  implode(",", $studentid); 

      $id_class = implode(",", $old_Class);
      if($studentid && $classid)
      { 
         $where['userid'] = array('in',$id);
         $where['classid'] = array('in',$id_class);


        
        $del = M("class_relationship")->where($where)->delete();


        foreach ($studentid as $key => $value) {

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

                     

                    

                }


            
             

         }
        

      } 
        if ($edit_class ) {
                        $info['status'] = true;
                       
                      }else{

                          $info['status'] = false;
                      }

           echo json_encode($info); 
  


   }
 

  public function student_move()
  { 
    $schoolid = $_SESSION['schoolid'];
    $studentid = I('ids')[0];
  


    $cause = I('cause');

    $classid = I('classid')[0];
 
     

  
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
       
                        $info['status'] = true;
                       
               
           echo json_encode($info); 
     }



  }


   public function abnormal()
   {
       $userid=$_SESSION['USER_ID'];

       $level= $_SESSION['level'];
        $schoolid = $_SESSION['schoolid'];
   
         $search_grade = I("search_grade");
    
        $search_class = I("search_class");

        
     
        $search_student_name = I("student_name");
       $this->assign("gradeinfo",$search_grade);

        if($search_grade && !$search_class){
            // $this->assign("gradeinfo",$search_grade);
            
            $where_class['grade'] = $search_grade;
            $where_class['schoolid'] = $schoolid;
 
          
            
          $query_class = array();

            $school_class = M("school_class")->where($where_class)->field("id")->select();
           if($school_class){

            foreach ($school_class as  $value) {
              array_push($query_class, $value['id']);
            }
            
             $where['s.classid'] =array('in',$query_class);
         }
           // exit();
       
           //  $join_grade = "wxt_school_class cs ON c.classid=cs.id";
         }
   



        if($search_class){
            $this->assign("classinfo",$search_class);
            $where['s.classid'] = $search_class;
            // $join = "wxt_school_class cs ON c.classid=cs.id";
        }
        if($search_student_name){
            $this->assign("studentname",$search_student_name);
            $where['info.stu_name'] = array("LIKE","%".$search_student_name."%");;
           
        }      
        
       

       




     $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
     $class=M('school_class')->where("schoolid=$schoolid and type = 1")->order("id asc")->select();
     $where['s.schoolid'] = $schoolid;

       if($level!=1  && $level!=2)
       {
           $where['teacher.schoolid'] = $schoolid;
           $where['teacher.teacherid'] = $userid;
           $join_duty = 'wxt_teacher_class teacher ON s.classid=teacher.classid';
       }
      
     $move = M("student_move")->alias("s")->where($where)->join($join_duty)->join("wxt_student_info info ON info.userid = s.studentid")->join("wxt_school_class sc ON s.classid=sc.id")->field("s.id,info.stu_name,info.stu_id,s.studentid,sc.classname,s.cause,s.type,s.create_time")->select();
   
     $this->assign("class",$class);
     $this->assign("grade",$grade);
     $this->assign("student",$move);
     $this->display();



   }


   public function rep_study()
   { 
       $schoolid = $_SESSION['schoolid']; 
        
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


    public function qinshu(){
        $data1 = I('qinshu1');
        
        $student = I('studentid');
        
        $schoolid = I('schoolid');
        
     

        if (!empty($data1)&&$data1[0]&&$data1[1]&&$data1[2]) {
              
               $old_phone = $data1[3];

          

              if(!$old_phone){

              $datalist1['name'] = $data1[0];
              $datalist1['password'] = md5('school');
              $datalist1['phone'] = $data1[1];
              $datalist1['schoolid'] = $schoolid;
              $datalist1['create_time'] = time();
              $insert1 = M('wxtuser')->add($datalist1);
              $data_relate1['appellation'] = $data1[2];
              $data_relate1['studentid'] = I('studentid');
              $data_relate1['name'] = $data1[0];
              $data_relate1['phone'] = $data1[1];
              $data_relate1['userid'] = $insert1;
              $data_relate1['time'] = time();
              $relate1 = M('relation_stu_user')->add($data_relate1);
             }else{


              $showold = M('relation_stu_user')->where("phone = $old_phone")->field("phone,id")->find();
                $id = $showold['id'];

                $data1 = array(
                'name'=>$data1[0],
                'phone'=>$data1[1],
                'appellation'=>$data1[2],

                  );

                $save = M('relation_stu_user')->where("id = $id")->save($data1);

             }
        }else{
            $this->error('数据不完整！');
        }       
        
        $data2 = I('qinshu2');
  
    
        if(!empty($data2)&&$data2[0]&&$data2[1]&&$data2[2]) {

               $old_phone2 = $data2[3];

            
            
              
            if(!$old_phone2){
              $datalist2['name'] = $data2[0];
              $datalist2['password'] = md5('school');
              $datalist2['phone'] = $data2[1];
              $datalist2['schoolid'] = $schoolid;
              $datalist2['create_time'] = time();
              $insert2 = M('wxtuser')->add($datalist2);
              $data_relate2['appellation'] = $data2[2];
              $data_relate2['name'] = $data2[0];
              $data_relate2['phone'] = $data2[1];
              $data_relate2['studentid'] = I('studentid');
              $data_relate2['userid'] = $insert2;
              $data_relate2['time'] = time();
              $relate2 = M('relation_stu_user')->add($data_relate2);
            }else{

              $showold = M('relation_stu_user')->where("phone = $old_phone2")->field("phone,id")->find();
                  $id = $showold['id'];

                $data2 = array(
                'name'=>$data2[0],
                'phone'=>$data2[1],
                'appellation'=>$data2[2],

                  );

              $save = M('relation_stu_user')->where("id = $id")->save($data2);

            }


        }else{
            $this->error('数据不完整！');
        }
        
        $data3 = I('qinshu3');
     
      
        if(!empty($data3)&&$data3[0]&&$data3[1]&&$data3[2]){
         
             $old_phone3 = $data3[3];

            
        
             if(!$old_phone3){

              $datalist3['name'] = $data3[0];
              $datalist3['password'] = md5('school');
              $datalist3['phone'] = $data3[1];
              $datalist3['schoolid'] = $schoolid;
              $datalist3['create_time'] = time();
              $insert3 = M('wxtuser')->add($datalist3);
              $data_relate3['appellation'] = $data3[2];
              $data_relate3['name'] = $data3[0];
              $data_relate3['phone'] = $data3[1];
              $data_relate3['studentid'] = I('studentid');
              $data_relate3['userid'] = $insert3;
              $data_relate3['time'] = time();
              $relate3 = M('relation_stu_user')->add($data_relate3);
            }else{

               $showold = M('relation_stu_user')->where("phone = $old_phone3")->field("phone,id")->find();
                //var_dump($showold);

               $id = $showold['id'];

                  $data3 = array(
                  'name'=>$data3[0],
                  'phone'=>$data3[1],
                  'appellation'=>$data3[2],

                    );

                $save = M('relation_stu_user')->where("id = $id")->save($data3);

            }
        }else{
            $this->error('数据不完整！');
        }
         
        if($insert1&&$relate1){
            $this->success("添加成功！");
        }else{
            $this->error("添加失败！");
        }

    }

    public function index(){


        $schoolid=$_SESSION['schoolid'];
        $userid=$_SESSION['USER_ID'];

        $level= $_SESSION['level'];
        //获取亲属关系
        $guanxi = M('appellation')->where("id>2")->select();
    //选择年级
    $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
    //选择班级
    $class=M('school_class')->where("schoolid=$schoolid")->order("id asc")->select();
    //获取学生相关信息
    // $where["c.schoolid"]=$schoolid;
    
        //搜索学生条件
        $search_grade = I("search_grade");
    
        $search_class = I("search_class");
        
     
        $search_student_name = I("student_name");

        $search_student_card = I("student_card");
        
        $search_ICcard = I("iccard");

        $search_phone = I("phone");
      
        $this->assign("gradeinfo",$search_grade);
   
       if($search_grade && !$search_class){
            // $this->assign("gradeinfo",$search_grade);
            
            $where_class['grade'] = $search_grade;
            $where_class['schoolid'] = $schoolid;
 
          
            
          $query_class = array();

            $school_class = M("school_class")->where($where_class)->field("id")->select();
           if($school_class){

            foreach ($school_class as  $value) {
              array_push($query_class, $value['id']);
            }
            
             $where['sc.id'] =array('in',$query_class);
         }
           // exit();
       
           //  $join_grade = "wxt_school_class cs ON c.classid=cs.id";
         }
   



        if($search_class){
            $this->assign("classinfo",$search_class);
            $where['sc.id'] = $search_class;
            // $join = "wxt_school_class cs ON c.classid=cs.id";
        }
        if($search_student_name){
            $this->assign("studentname",$search_student_name);
            $where['st.stu_name'] = array("LIKE","%".$search_student_name."%");;
           
        }
        if ($search_student_card) {
            $this->assign("studentcard",$search_student_card);
            $where['stu_id'] = $search_student_card;
           
        }
        if($search_ICcard){
            $this->assign("searchiccard",$search_ICcard);
            $where['cardNo'] = $search_ICcard;
           
        }
        if($search_phone){
            $this->assign("parent_phone",$search_phone);
            $where['rsu.phone']=array("LIKE","%".$search_phone."%");;
            $where['rsu.type'] = 1;
            $join = "wxt_relation_stu_user rsu ON st.userid=rsu.studentid";
            
        }

 //  var_dump($schoolid);
 // $add = M("student_info")->where("schoollid = $schoolid")->select();
 // var_dump($add);'
  
        $where['st.schoollid'] = $schoolid;
        $where['st.status']=1;
        if($level!=1  && $level!=2)
        {
            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON st.classid=teacher.classid';
        }
       

       $count = M("student_info")
        ->alias("st")
        ->join("wxt_school_class sc ON st.classid = sc.id")
        ->join($join)
        ->join($join_grade)
        ->join($join_duty)
        ->where($where)
        ->count();
  $page = $this->page($count, 20);

       $student = M("student_info")
        ->alias("st")
        ->where($where)
        ->join("wxt_school_class sc ON st.classid = sc.id")
        ->join($join)
        ->join($join_duty)
        ->join($join_grade)
        ->limit($page->firstRow . ',' . $page->listRows) 
        ->field("st.userid,st.stu_name,sc.classname,st.stu_id,st.in_residence,st.classid")
        ->select();

        // exit();


        foreach ($student as &$value) {
           $userid = $value['userid'];

           if($value['in_residence']==1)
           {
            $value['in_residence']= '是';
           }else{
            $value['in_residence'] = '否';
           }

           $parent  = M("relation_stu_user")->where("studentid = $userid and type = 1")->field("name,phone")->find();
         

           $value['parent'] = $parent['name'];
           $value['phone'] = $parent["phone"];
        }

  // exit();

        $school_class = M("school_class")->where("schoolid = $schoolid and type = 1")->field("id,classname")->select();

  

  //       $count=M("class_relationship")
    // ->alias("c")
    // ->join($join)
    // ->join($join_else)
    // ->where($where)
    // ->order("c.create_time DESC")  
    // ->count();
    // $page = $this->page($count, 20);
    // var_dump($page);
          
    // $student=M("class_relationship")
    // ->alias("c")->distinct(true)
    // ->join($join)
    // ->join($join_else)
    // ->where($where)
    // ->field($field)
    // ->limit($page->firstRow . ',' . $page->listRows)     
    //  ->group("userid")
    // ->order("c.classid DESC")  // 添加分页
    // ->select();
    //var_dump($student);


//   $name = array();
//   foreach ($student as $k => $v) {
//    if(!in_array($v['userid'], $name)){
//      $name[] = $v['userid'];
//      // $name[] = $v;
//    }
//   }
//   var_dump($name);

// exit();


    // foreach ($student as &$item) {
    //  //获取学生的所有班级
    //  // $where['k.schoolid'] = $schoolid
    //  // $where['k.userid'] = 
  //  //         $stu = M('class_relationship')->alias('k')->join("wxt_school_class d NO k.classid=d.id")->where()


    //  $s_id=$item["userid"];
      
    //  $classid=$item["classid"];

  //  //       //TOOD自己改造循环一个学生参加了哪几个班
  //         $where_d['k.schoolid'] = $schoolid;
    //  $where_d['k.userid'] = $s_id;
  //          $student_subject=M("class_relationship")
  //        ->alias("k")
  //        ->join("wxt_school_class d ON k.classid=d.id ")
  //        ->where($where_d)
  //        ->field("d.classname,d.id as ids") 
  //        ->select();
  //          //var_dump($student_subject);

        
  //  //       //TOODO循环拼接字段
   //      $student_idsu="";
   //      $student_info="";

          
   //        foreach ($student_subject as $value) {
   //         $info = $value["classname"];
   //         $infos = $value["ids"];
   //         $student_info = $info.",".$student_info;
   //         $student_idsu = $infos.",".$student_idsu;
   //        }
   //        $item["student_classid"]=$student_idsu;
   //        $item['student_subject'] = $student_info;

        
    //  //姓名
    //  $search_student_name=M("wxtuser")->field("name")->where("id=$s_id")->find();
    //  //var_dump($search_student_name);
    //  $item["student_name"]=$search_student_name["name"];
    //  //所在班级
    //  $classname=M("school_class")->where("id=$classid")->find();
  //           // var_dump($classname);
    //  $item["classname"]=$classname["classname"];
    //  //学号
  //           $stu_id = M("student_info")->where("userid=$s_id")->field("stu_id")->find();
  //           $item["stu_id"] = $stu_id['stu_id'];
    //  //IC卡号
    //  $whiu['personId']=$s_id;
    //  $whiu['cardType']=0;
    //  $ICcard=M("student_card")->where($whiu)->find();
    //  $item["cardNo"]=$ICcard["cardno"];      
    //  //家长手机
    //  $where_phone["r.studentid"]=$s_id;
    //  // $where_phone["r.type"]=1;
    //  $phone=M("relation_stu_user")->alias("r")->join("wxt_wxtuser w ON w.id=r.userid")->where($where_phone)->field("w.phone")->find();
    //  $item["phone"]=$phone["phone"];
    //  //是否住校
  //           $in_residence = M("student_info")->where("userid=$s_id")->field("in_residence")->find();
  //           if($in_residence['in_residence'] == 0){
  //               $item['in_residence'] = '是';
  //           }elseif($in_residence['in_residence'] == 1){
  //               $item['in_residence'] = '否';
  //           }else{
  //               $item['in_residence']='不知道';
  //           }
    //  //学生组
  //           $in_group = M('student_info')->alias("s")->join("wxt_student_group w ON s.groupid=w.id")->field("w.group_name")->where("s.userid=$s_id")->find();
  //           $item["in_group"] = $in_group["group_name"];
    //  //服务是否开通
  //           $kaitong = M('student_card')->field('status')->where("personId=$s_id")->find();
  //           if($kaitong['status'] ==0){
  //               $item['kaitong'] = '否';
  //           } elseif ($kaitong['status'] ==1) {
  //               $item['kaitong'] = '是';
  //           }
  //            //获取学生分组
  //        $student_department=M("department_teacher")->alias("d")->join("wxt_department w ON d.department_id=w.id")->where("d.teacher_id=$s_id")->field("w.name,w.id")->select();
           
  //        $item["student_department"]=$student_department; 
    // }
      
        //var_dump($student);
        //将获取到的学生信息保存到seession中
  //       $grop = M('department')->where("schoolid = $schoolid and status = 1")->select();
  //       $_SESSION['student_info']=$student;
     $this->assign("Page", $page->show('Admin'));
    // $this->assign("class",$class);
    $this->assign("grade",$grade);
    // $this->assign("grop",$grop);
    // $this->assign("student",$student);
    // //var_dump($student);
  //       $this->assign("guanxi",$guanxi);
        $this->assign("class",$school_class);
        $this->assign("student",$student);
        $this->display();
    }


      public function studentdrop()
      {

        


      }
 



  

      
       //查看处理结果
       public function showre()
       {
            

          $excelid = I('excelid');
            // var_dump($exelid);                   
          $excel = M('teacher_excel')->where("id=$excelid")->find();
          // var_dump($excel);  

         foreach ($excel as $key => &$value) {
               $excel['time'] = date("Y-m-d H:i:s", $excel['time']);
               // var_dump($value);
         }   

        //  var_dump($excel);
        // exit();

          if ($excel) {
                    $info['status'] = true;
                    $info['msg'] = $excel;
                } else {
                    $info['status'] = false;
                    $info['msg'] = '404';
           }
         echo json_encode($info); 

       }



     
      //批量删除
        public function delpl()
       {
         $er_id = $_POST['fkcheck'];
          // var_dump($er_id);
         // echo "<script type='text/javascript'>alert('测试');</script>";
      

          $id =  implode(",", $er_id);
          // var_dump($id);
          // exit();

          $del = M('teacher_excel')->where("id in ($id)")->delete();

        echo "<script type='text/javascript'>alert('成功删除".$del."条');</script>";
        
        $this->success();

       }


       public function edit_post()
       {     

            $schoolid=$_SESSION['schoolid'];

            $userid = I('student_id');

            $name = I('student_name');

            $address = I("address");

 

            $phone = I('rel');
       
            $sex = I('sex');
     

            $in_residence = I('in_residence');
             
            $card=I("newcardNo");
            
             $old_card = I("oldcardNo"); 

             $newCardNo = I('newcardNo');
            //旧的学生卡
             $oldCardNo = I('oldcardNo');


             
             $depid = I('depid');

             $id =  implode(",", $depid); 
         

            $where_del['teacher_id'] = $userid;

            $where_del['school_id'] = $schoolid; 

            

            if($name)
            {  
               $data_name['name'] = $name; 
              $student_name = M('wxtuser')->where("id = $userid")->save(array("name"=>$name,));

            }

              

            $del = M('department_teacher')->where($where_del)->delete();
            
            // exit();

            foreach ($depid as $key => $val) {
         $data_group['department_id'] = $val;
         $data_group['school_id'] = $schoolid;
         $data_group['teacher_id'] = $userid;

        $alldata[]=$data_group;
        unset($data_group);
      }

      $result = M('department_teacher')->addAll($alldata);
            

           
         if($userid)
         { 
          $data = array(
            'address'=>$address,
              'sex'=>$sex,
               'in_residence'=>$in_residence,
               'stu_name'=>$name,
            );
          $save = M('student_info')->where("userid = $userid")->save($data);
        

          $arr = array(
                 'phone'=>$phone,
            );
           $rel = M('relation_stu_user')->where("studentid = $userid")->save($arr);

               $where['cardno']=$oldCardNo;
           $where['personId']=$userid;
           $where['cardType']=0;
           $where['handletype'] = 1;

             $cha=M("student_card")->where($where)->select(); 
             // var_dump($cha);
          
          if(!$cha){
            $data["personId"]=$userid;
            $data["cardNo"]=$newCardNo;
            $data["schoolid"]=$schoolid;
            $data["create_time"]=time();
            $data['handletime'] = time();
            $data['handletimeint'] = time();
            $data['handletype'] = 1;
            $data["cardType"]=0;
               //echo "dsadsa";
            $card_add=M("student_card")->add($data);
            }else{
              //将原来的表修改并添加替换添加时间并将状态改为删除 ,然后再新增一条card表的记录
                $save_card['handletype'] = 0;  
                  $save_card['handletime'] = date('Y-m-d H:i:s',time());
                $save_card['handletimeint'] = time();

               $card_gai=M("student_card")->where($where)->save($save_card);
               // var_dump($card_gai);

               if($card_gai){
                 
                 $card_addc['personId']=$userid;
                 $card_addc['cardNo'] = $newCardNo;
                 $card_addc['schoolid'] = $schoolid;
                 $card_addc['create_time'] = time();
                 $card_addc['handletime'] = date('Y-m-d H:i:s',time());
                 $card_addc['handletimeint'] = time();
                 $card_addc['handletype'] = 1;
                 $card_addc['cardType'] = 0;
               $creat_card = M('student_card')->add($card_addc); 
              }

              
            }




           if($rel || $save || $del || $result)
           {
            $this->success('修改成功');
           }else{
            $this->error('修改失败');
           } 

         }

       }
    

    //查看亲属

    public function showqinshu()
    {
       $studentid = I('studentid');
       // var_dump($studentid);
       
       if ($studentid) {
         
           $relation = M('relation_stu_user')->where("studentid = $studentid and type = 0")->field("name,phone,appellation")->select();
           // var_dump($relation);
           
                 $info["status"] = true;
                 $info["msg"] = $relation;
            
         echo json_encode($info); 


        } 



     }   




 


}