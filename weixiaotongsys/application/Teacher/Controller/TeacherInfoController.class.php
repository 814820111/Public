<?php

/**
 * 教职工信息
 */
/**
 * 
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class TeacherInfoController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->relation_stu_class_model = D("Common/class_relationship");
        $this->teacher_class_model = D("Common/teacher_class");
        $this->department_model = D("Common/department");
        $this->duty_model = D("Common/duty");
        $this->teacherduty_model=D("Common/duty_teacher");
        $this->department_teacher_model=D("Common/department_teacher");
        $this->city_model=D("Common/city");
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];
    }
	public function index(){



        $city=M("school")
            ->alias("s")
            ->join("wxt_city c ON c.term_id=s.schoolid")
            ->where(array("s.schoolid"=>$this->schoolid))
            ->getField("c.name");




		//用户信息
		$userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
//        dump($level);



        //获取查询班级
        $search_class=I("search_class");
  

        $search_grade = I("search_grade");

        $this->assign("gradeinfo",$search_grade);
        
        if($search_grade && !$search_class)
        {

            // $this->assign("gradeinfo",$search_grade);
            $class_arr = array();
            $school_class =M("school_class")->where("schoolid = $schoolid and grade = $search_grade")->field("id")->select();

            if($school_class){

            foreach ($school_class as $key => $value) {
               array_push($class_arr,$value['id']);
            }
            // var_dump($class_arr);

            $join_else ="wxt_teacher_class class ON class.teacherid = w.id";
            $where_info['class.classid'] = array("in",$class_arr);
           }else{
                $join_else ="wxt_teacher_class class ON class.teacherid = w.id";
                $where_info['class.classid'] = '';
            }
        }

        // exit();
        if($search_class){

             $this->assign("search_class",$search_class);
            $join_else ="wxt_teacher_class class ON class.teacherid = w.id";
            $where_info['class.classid'] = $search_class;

            // var_dump($search_class);

            // var_dump($where_class["class"]);


        }
            $where_class["c.schoolid"]=$schoolid;
        
        
         //获取查询卡号
        $teacher_card=I("search_card");
        // var_dump($teacher_card);
        // exit();
        if($teacher_card){
            $where_info["s.cardNo"]=$teacher_card;
            $join="wxt_student_card s ON s.personId=d.id";
            $this->assign("teacher_card",$teacher_card);
        }
        $teacher_name=I("search_name");
        if($teacher_name){
            $where_info["w.name"]=array("LIKE","%".$teacher_name."%");
        }
       //获取查询手机
        $search_phone=I("search_phone");
           if($search_phone){
                $where_info["w.phone"]=array("LIKE","%".$search_phone."%");
                // var_dump($where_info["w.phone"]);
                $this->assign("teacher_phone",$search_phone);
            }
            // var_dump($search_phone);
        
         // exit();
        $where_info["d.schoolid"]=$schoolid;
        // echo "<hr/>";
        // var_dump($schoolid);
        // echo "<hr/>";
        
        // $school = M("school")->where("schoolid=$schoolid")->find();

        // $schooltype = $school['schoolgradetypeid'];

        // $where_subject['gradetype'] = $schooltype; 

        // $where_c['gradetype'] = 0;
        // $where_c['schoolid'] = 0;
        // $where_c['isdefault'] = 0;
 
         
        //  $where_b['gradetype'] = $schooltype;
        //  $where_b['schoolid'] = 0;


        //  $data['gradetype'] = 0;
        //  $data['schoolid'] = $schoolid;
        //  $data['isdefault'] = 1;
        //获取年级
         //自建
       //  $subject_add=M("default_subject")->where($data)->select(); 
       //  // var_dump($subject_add);
         
       //   //学校类型科目
       //  $default = M('default_subject')->where($where_b)->select();
  
       //  //通用科目
       //  $currency = M('default_subject')->where($where_c)->select();       
       // //將集合发送到前台遍历 只显示自己学校的课程
       // $subject = array_merge($subject_add,$default);

        $Wsubject = M("subject")->alias("s")->join("wxt_default_subject d ON s.subjectid = d.id")->where("s.schoolid = $schoolid")->field("d.id,d.subject")->select();

       // $Wsubject = array_merge($currency,$subject);




        // var_dump($Wsubject);

        //本校班级(年级)
        $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
        // var_dump($grade);
        // echo "<hr>";

        // var_dump($class);
        // exit();
        // //获取教师基本信息
        // echo "<hr>";
          $appid = M("wxmanage")->where("schoolid = $schoolid")->getField("wx_appid");

        if($level!=1  && $level!=2)
        {
            $where_info['d.schoolid'] = $schoolid;
            $where_info['d.teacherid'] = $userid;
            $where_class['teacher.schoolid'] = $schoolid;
            $where_class['teacher.teacherid'] = $this -> userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';

        }
        $class=M('school_class')->alias("c")->join($join_duty)->where($where_class)->order("c.id asc")->select();

        $count=M("teacher_info")
        ->alias("d")
        ->join("wxt_wxtuser w ON d.teacherid=w.id")
        ->join($join)
        ->join($join_else)
        ->distinct(true)
        // ->limit($page->firstRow . ',' . $page->listRows)
        ->where($where_info)
        ->count();



       $page = $this->page($count, 15);
        
        

        $teacher_info=M("teacher_info")
        ->alias("d")
        ->join("wxt_wxtuser w ON d.teacherid=w.id")
        ->join($join)
        ->join($join_else) 
        ->distinct(true)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->where($where_info)
        ->field("w.id,d.name,w.phone,d.schoolid,d.bindingkey,d.state,d.email,d.id as teacherid")
        ->select();



   // var_dump($teacher_info);
        // var_dump($count);
        // echo "<hr>";
      // $page = $this->page($count, 10);

        // var_dump($list);

        $appid = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();

           //$page = $this->page($teacher_info, 20);
        foreach ($teacher_info as &$item) {

            $t_id=$item["id"];

            $teacherid = $item['teacherid'];


        	//获取IC卡号
        	 $card=M("student_card")->field("cardNo")->where("personId=$teacherid and cardType=1 and handletype = 1")->find();
            // var_dump($card);
        	 $item["card"]=$card["cardno"];
        	//获取教师任课情况
        	$where["k.schoolid"]=$schoolid;
        	$where["k.teacherid"]=$t_id;
        	$teacher_subject=M("teacher_class")
        	->alias("k")
        	->join("wxt_school_class d ON k.classid=d.id ")
        	->where($where)
        	->field("d.classname,d.id as ids") 
        	->select();
             //appid



//        	$teacher_appid = M("xctuserwechat")->where("userid = $t_id and appid = $appid")->getField("appid");
        	$teacher_appid = M("xctuserwechat")->where(array("userid"=>$t_id,"appid"=>$appid['wx_appid']))->getField("appid");
             //var_dump($teacher_subject);
        	$item['appid'] = $teacher_appid;
        	$teacher_idsu="";
		    $teacher_inforty="";
        	foreach ($teacher_subject as &$itvo) {
        		  $info=$itvo["classname"];
		          $infos=$itvo["ids"];
		    	$teacher_inforty = $info.",".$teacher_inforty;
			     $teacher_idsu=$infos.",".$teacher_idsu;
        	}       
        	    $item["teacher_classid"]=$teacher_idsu;
              	$item["teacher_subject"]=rtrim($teacher_inforty, ",");
        	//判断是班主任还是带班老师
            // $teacher_set=M("duty_teacher")->field("duty_id")->distinct(true)->where("teacher_id=$t_id")->select();
        	$teacher_set=M("duty_teacher")->alias("t")->join("wxt_school_duty s ON s.id=t.duty_id")->where("t.teacher_id = $t_id and t.schoolid = $schoolid")->field("s.id,s.name")->select();
         $teacher_duty = "";

         foreach ($teacher_set as  $duty) {
         	$info_duty = $duty['name'];
         	$teacher_duty = $info_duty.",".$teacher_duty;
         }


        	$item["teacher_set"]=$teacher_set;
        	$item['teacher_duty'] = $teacher_duty;

        	//获取教师部门
        	$teacher_department=M("department_teacher")->alias("d")->join("wxt_department w ON d.department_id=w.id")->where("d.teacher_id=$teacherid")->field("w.name,w.id")->select();


           
        	$item["teacher_department"]=$teacher_department; 
          
           $department_list = "";
            foreach ($teacher_department as $key => $val) {
                $info_list = $val['name'];
                $department_list = $info_list.",".$department_list;
            }
            $item['department_list'] = $department_list;

        	        	//获取教师任课情况
//      	$teacher_subjec=M("teacher_subject")
//      	->alias("t")
//      	->join("wxt_school_class s ON s.id=t.classid")
//      	->join("wxt_default_subject d ON d.id=t.subjectid")
//      	->where("t.teacherid=$t_id")
//      	->field("t.*,s.classname,d.subject")
//      	->select();
//      	$teacher_ids="";
//		    $teacher_infort="";
//      	$item["teacher_dai"]=$teacher_subjec;
//      	foreach ($teacher_subjec as &$itvos){
//      	    $inf=$itvo["classname"];
//		    $inos=$itvo["subject"]; 
//		    	$teacher_inforty = $inf.",".$inos;  
//       	}
      }



       //   var_dump($teacher_info);
    //      echo "<hr>";

    //      var_dump($grade);
    //      echo "<hr>";
    // var_dump($Wsubject);
    //       echo "<hr>";
    //      var_dump($class);
    //         echo "<hr>";
        // var_dump($teacher_name);
       //TOODO讲数组保存在SESSION中;
//        $_SESSION['Teacher_info']=$teacher_info;

        $grop = M('department')->where("schoolid = $schoolid and status = 2")->select();

        $duty = M('school_duty')->where("schoolid=$schoolid")->select();
        $this->assign("duty",$duty);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("teacher_info",$teacher_info);
     
        $this->assign("grop",$grop);
        $this->assign("grade",$grade);
        $this->assign("Wsubject",$Wsubject);
        $this->assign("class",$class);
        $this->assign("teacher_name",$teacher_name);
		$this->display();
	}
    public function index_teacherid_back(){


        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
//        dump($level);



        //获取查询班级
        $search_class=I("search_class");


        $search_grade = I("search_grade");

        $this->assign("gradeinfo",$search_grade);

        if($search_grade && !$search_class)
        {

            // $this->assign("gradeinfo",$search_grade);
            $class_arr = array();
            $school_class =M("school_class")->where("schoolid = $schoolid and grade = $search_grade")->field("id")->select();

            if($school_class){

                foreach ($school_class as $key => $value) {
                    array_push($class_arr,$value['id']);
                }
                // var_dump($class_arr);

                $join_else ="wxt_teacher_class class ON class.teacherid = w.id";
                $where_info['class.classid'] = array("in",$class_arr);
            }else{
                $join_else ="wxt_teacher_class class ON class.teacherid = w.id";
                $where_info['class.classid'] = '';
            }
        }

        // exit();
        if($search_class){

            $this->assign("search_class",$search_class);
            $join_else ="wxt_teacher_class class ON class.teacherid = w.id";
            $where_info['class.classid'] = $search_class;

            // var_dump($search_class);

            // var_dump($where_class["class"]);


        }
        $where_class["c.schoolid"]=$schoolid;


        //获取查询卡号
        $teacher_card=I("search_card");
        // var_dump($teacher_card);
        // exit();
        if($teacher_card){
            $where_info["s.cardNo"]=$teacher_card;
            $join="wxt_student_card s ON s.personId=d.teacherid";
            $this->assign("teacher_card",$teacher_card);
        }
        $teacher_name=I("search_name");
        if($teacher_name){
            $where_info["w.name"]=array("LIKE","%".$teacher_name."%");
        }
        //获取查询手机
        $search_phone=I("search_phone");
        if($search_phone){
            $where_info["w.phone"]=array("LIKE","%".$search_phone."%");
            // var_dump($where_info["w.phone"]);
            $this->assign("teacher_phone",$search_phone);
        }
        // var_dump($search_phone);

        // exit();
        $where_info["d.schoolid"]=$schoolid;
        // echo "<hr/>";
        // var_dump($schoolid);
        // echo "<hr/>";

        // $school = M("school")->where("schoolid=$schoolid")->find();

        // $schooltype = $school['schoolgradetypeid'];

        // $where_subject['gradetype'] = $schooltype;

        // $where_c['gradetype'] = 0;
        // $where_c['schoolid'] = 0;
        // $where_c['isdefault'] = 0;


        //  $where_b['gradetype'] = $schooltype;
        //  $where_b['schoolid'] = 0;


        //  $data['gradetype'] = 0;
        //  $data['schoolid'] = $schoolid;
        //  $data['isdefault'] = 1;
        //获取年级
        //自建
        //  $subject_add=M("default_subject")->where($data)->select();
        //  // var_dump($subject_add);

        //   //学校类型科目
        //  $default = M('default_subject')->where($where_b)->select();

        //  //通用科目
        //  $currency = M('default_subject')->where($where_c)->select();
        // //將集合发送到前台遍历 只显示自己学校的课程
        // $subject = array_merge($subject_add,$default);

        $Wsubject = M("subject")->alias("s")->join("wxt_default_subject d ON s.subjectid = d.id")->where("s.schoolid = $schoolid")->field("d.id,d.subject")->select();

        // $Wsubject = array_merge($currency,$subject);




        // var_dump($Wsubject);

        //本校班级(年级)
        $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
        // var_dump($grade);
        // echo "<hr>";

        // var_dump($class);
        // exit();
        // //获取教师基本信息
        // echo "<hr>";
        $appid = M("wxmanage")->where("schoolid = $schoolid")->getField("wx_appid");

        if($level!=1  && $level!=2)
        {
            $where_info['d.schoolid'] = $schoolid;
            $where_info['d.teacherid'] = $userid;
            $where_class['teacher.schoolid'] = $schoolid;
            $where_class['teacher.teacherid'] = $this -> userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';

        }
        $class=M('school_class')->alias("c")->join($join_duty)->where($where_class)->order("c.id asc")->select();

        $count=M("teacher_info")
            ->alias("d")
            ->join("wxt_wxtuser w ON d.teacherid=w.id")
            ->join($join)
            ->join($join_else)
            ->distinct(true)
            // ->limit($page->firstRow . ',' . $page->listRows)
            ->where($where_info)
            ->count();



        $page = $this->page($count, 15);



        $teacher_info=M("teacher_info")
            ->alias("d")
            ->join("wxt_wxtuser w ON d.teacherid=w.id")
            ->join($join)
            ->join($join_else)
            ->distinct(true)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->where($where_info)
            ->field("w.id,d.name,w.phone,d.schoolid,d.bindingkey,d.state,d.email,d.id as info_id")
            ->select();



        // var_dump($teacher_info);
        // var_dump($count);
        // echo "<hr>";
        // $page = $this->page($count, 10);

        // var_dump($list);

        $appid = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();




        //$page = $this->page($teacher_info, 20);
        foreach ($teacher_info as &$item) {

            $t_id=$item["id"];
            $info_id = $item['info_id'];

            //获取IC卡号
            $card=M("student_card")->field("cardNo")->where("personId=$t_id and cardType=1 and handletype = 1")->find();
            // var_dump($card);
            $item["card"]=$card["cardno"];
            //获取教师任课情况
            $where["k.schoolid"]=$schoolid;
            $where["k.teacherid"]=$t_id;
            $teacher_subject=M("teacher_class")
                ->alias("k")
                ->join("wxt_school_class d ON k.classid=d.id ")
                ->where($where)
                ->field("d.classname,d.id as ids")
                ->select();
            //appid



//        	$teacher_appid = M("xctuserwechat")->where("userid = $t_id and appid = $appid")->getField("appid");
            $teacher_appid = M("xctuserwechat")->where(array("userid"=>$t_id,"appid"=>$appid['wx_appid']))->getField("appid");
            //var_dump($teacher_subject);
            $item['appid'] = $teacher_appid;
            $teacher_idsu="";
            $teacher_inforty="";
            foreach ($teacher_subject as &$itvo) {
                $info=$itvo["classname"];
                $infos=$itvo["ids"];
                $teacher_inforty = $info.",".$teacher_inforty;
                $teacher_idsu=$infos.",".$teacher_idsu;
            }
            $item["teacher_classid"]=$teacher_idsu;
            $item["teacher_subject"]=rtrim($teacher_inforty, ",");
            //判断是班主任还是带班老师
            // $teacher_set=M("duty_teacher")->field("duty_id")->distinct(true)->where("teacher_id=$t_id")->select();
            $teacher_set=M("duty_teacher")->alias("t")->join("wxt_school_duty s ON s.id=t.duty_id")->where("t.teacher_id = $info_id and t.schoolid = $schoolid")->field("s.id,s.name")->select();
            $teacher_duty = "";

            foreach ($teacher_set as  $duty) {
                $info_duty = $duty['name'];
                $teacher_duty = $info_duty.",".$teacher_duty;
            }


            $item["teacher_set"]=$teacher_set;
            $item['teacher_duty'] = $teacher_duty;

            //获取教师部门
            $teacher_department=M("department_teacher")->alias("d")->join("wxt_department w ON d.department_id=w.id")->where("d.teacher_id=$info_id")->field("w.name,w.id")->select();



            $item["teacher_department"]=$teacher_department;

            $department_list = "";
            foreach ($teacher_department as $key => $val) {
                $info_list = $val['name'];
                $department_list = $info_list.",".$department_list;
            }
            $item['department_list'] = $department_list;

            //获取教师任课情况
//      	$teacher_subjec=M("teacher_subject")
//      	->alias("t")
//      	->join("wxt_school_class s ON s.id=t.classid")
//      	->join("wxt_default_subject d ON d.id=t.subjectid")
//      	->where("t.teacherid=$t_id")
//      	->field("t.*,s.classname,d.subject")
//      	->select();
//      	$teacher_ids="";
//		    $teacher_infort="";
//      	$item["teacher_dai"]=$teacher_subjec;
//      	foreach ($teacher_subjec as &$itvos){
//      	    $inf=$itvo["classname"];
//		    $inos=$itvo["subject"];
//		    	$teacher_inforty = $inf.",".$inos;
//       	}
        }



        //   var_dump($teacher_info);
        //      echo "<hr>";

        //      var_dump($grade);
        //      echo "<hr>";
        // var_dump($Wsubject);
        //       echo "<hr>";
        //      var_dump($class);
        //         echo "<hr>";
        // var_dump($teacher_name);
        //TOODO讲数组保存在SESSION中;
//        $_SESSION['Teacher_info']=$teacher_info;


        $grop = M('department')->where("schoolid = $schoolid and status = 2")->select();

        $duty = M('school_duty')->where("schoolid=$schoolid")->select();
        $this->assign("duty",$duty);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("teacher_info",$teacher_info);

        $this->assign("grop",$grop);
        $this->assign("grade",$grade);
        $this->assign("Wsubject",$Wsubject);
        $this->assign("class",$class);
        $this->assign("teacher_name",$teacher_name);
        $this->display();
    }
    
  public function add(){
            $schoolid=$_SESSION['schoolid'];           
            //var_dump($schoolid);
            //职位信息
            $duty_message=M("school_duty")->where("schoolid = $schoolid")->select();
            //var_dump($duty_message);
            //部门信息
            // TOODO以前写的不显示部分信息$department_message=M("department")->where("schoolid=$schoolid")->select();

            $department_message=M("department")->where("schoolid=$schoolid and status = 2")->select();
            //var_dump($department_message);
            $this->assign("duty_message",$duty_message);
            $this->assign("department_message",$department_message);
            $this->display();
        }
        public function add_post(){
            $schoolid=$_SESSION['schoolid'];
            //用户主表
            $teacher_name=I("teacher_name");
            $teacher_phone=findNum(I("teacher_phone"));

            $data["password"]=md5(substr($teacher_phone,-6))
            ;
            $duty=Intval(I("duty"));
            if(empty($duty)){
                $this->error("请选择职位");
            }
             $str=$_POST['smeta']['thumb'];

             $arr=explode("/", $str);
             
             $department = I("department_id");
             $photo=!$arr[count($arr)-1]?"weixiaotong.png":$arr[count($arr)-1];
             $card = findNum(I('ic'));

            $birthday=strtotime(I("birthday"));

            $teacher_main = M('wxtuser')->where("phone = $teacher_phone")->field("id")->find();

            if($teacher_main)
            {  
              $main_info = $teacher_main['id'];

              $data["name"]=$teacher_name;
              $data["photo"]= $photo;
              $data["create_time"]=time();

               $main_save=M("wxtuser")->where("id = $main_info")->save($data);

            }else{

              $data["name"]=$teacher_name;
               $data["phone"]=$teacher_phone;
                $data["photo"]= $photo;
                $data["birthday"]=$birthday;
                $data["schoolid"]=$schoolid;
                $data["create_time"]=time();

            $main_info=M("wxtuser")->add($data);

            }

            $state=Intval(I("state"));
            if(!$state){
                $state=1;
            }

            $email=I("email");
            $education_card=I("education_card");
            $work_card=I("work_card");
            $description=I("description");
            $data_else["teacherid"]=$main_info;
            $data_else["schoolid"]=$schoolid;
            $data_else["state"]=$state;
            $data_else["email"]=$email;
            $data_else["name"]=$teacher_name;
            $data_else["education_card"]=$education_card;
            $data_else["work_card"]=$work_card;
            $data_else["description"]=$description;
            $bindingkey=rand(100000,999999);
            $data_else["bindingkey"]=$bindingkey;
            $addition_info=M("teacher_info")->add($data_else);


            //根据传过来职责id去查是否是学校管理员
            $duty_name = M("school_duty")->where(array("id"=>$duty,"schoolid"=>$schoolid))->getField("name");
            if($duty_name=="学校管理员")
            {
                add_admin_class($main_info,$schoolid);
            }

            
            //插入老师卡
            if($main_info)
            {
               if($card)
               {

//                 $card_show = M("student_card")->where("personId = $main_info and handletype = 1 and cardType = 1 and  cardNo = $card")->find();
                 $card_show = M("student_card")->where("handletype = 1 and cardType = 1 and  cardNo = $card")->find();
                     if($card_show)
                     {
                          $this->error("该卡号已经存在!");
                     }else{
                       
                        $cardinfo['name'] = $teacher_name;
                        $cardinfo['imgUrl'] = $_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'];
                        $cardinfo['schoolid'] = $schoolid;
                        $cardinfo['personId'] = $addition_info;
                        $cardinfo['cardNo'] = $card;
                        $cardinfo['cardType'] = 1;
                        $cardinfo['create_time'] = time();
                        $cardinfo['handletime'] = date('Y-m-d H:i:s',time());
                        $cardinfo['handletimeint'] = time();
                        $cardinfo['handletype'] = 1;
 
                        M("student_card")->add($cardinfo);

                     }
               }
            }


            //职位添加
            $data_duty["schoolid"]=$schoolid;
            $data_duty["duty_id"]=$duty;
            $data_duty["teacher_id"]=$main_info;
            $duty_info=M("duty_teacher")->add($data_duty);
            //部门添加
            foreach ($department as &$item) {
                $data_department["school_id"]=$schoolid;
                $data_department["department_id"]=$item;
                $data_department["teacher_id"]=$addition_info;
                $department_info=M("department_teacher")->add($data_department);
            }
            if($main_info) {
                $this->success("添加成功");
            }else{
                $this->error("添加失败");
            }
        }

        //通过年级选班级
        public function class_json(){
            $schoolid=$_SESSION['schoolid'];
            $gradeid=I("gradeid");
            $where["c.schoolid"]=$schoolid;
            $where["grade"]=$gradeid;
            if($this->level!=1  && $this->level!=2)
            {

                $where['teacher.schoolid'] = $schoolid;
                $where['teacher.teacherid'] = $this -> userid;
                $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';

            }
            $class=M('school_class')->alias("c")->join($join_duty)->where($where)->order("c.id asc")->select();
            if($class){
                $ret = $this->format_ret(1,$class);
            }else{
                $ret = $this->format_ret(0,"lost params");
            }
            echo json_encode($ret);
            exit;
        }
        //通过老师id获取老师的认可情况(班级)
        public function teacher_class(){
            $teacherid = I("teacherid");
            $wheres["t.teacherid"]=$teacherid;
            // $wheres["t.type"]=1;      
            $teacher_subject=M("teacher_class")
            ->alias("t")
            ->join("wxt_school_class s ON s.id=t.classid")
            ->where($wheres)
            ->field("t.classid,s.classname")
            ->select();
            foreach ($teacher_subject as &$classid) {
                $c_id=$classid["classid"];
                $subject=M("school_class")
                ->alias("s")
                ->join("wxt_subject w ON w.gradeid=s.grade")
                ->join("wxt_default_subject d ON d.id=w.subjectid")
                ->where("s.id=$c_id")
                ->field("d.id,d.subject")
                ->select();
                $classid["subject"]=$subject;
                $where["t.teacherid"]=$teacherid;
                $where["t.classid"]=$c_id;
                $teacher_su=M("teacher_subject")->alias("t")->join("wxt_default_subject d ON t.subjectid=d.id")->where($where)->field("d.id,d.subject")->select();
                $classid["teacher_su"]=$teacher_su;
            }
            if($teacher_subject){
                $ret = $this->format_ret_else(1,$teacher_subject);
            }else{
                $ret = $this->format_ret_else(0,"lost params");
            }
            echo json_encode($ret);
            exit;
            
        } 
                  
        
        //通过classid获取所在年级都有哪些课
        public function class_subject(){
            $classid=I("classid");
            foreach ($classid as &$c_id) {
                $subject=M("school_class")
                ->alias("s")
                ->join("wxt_subject w ON w.gradeid=s.grade")
                ->join("wxt_default_subject d ON d.id=w.subjectid")
                ->where("s.id=$c_id")
                ->field("s.classname,d.id,d.subject")
                ->select();
                $c_id=$subject;
            }
            if($classid){
                $ret = $this->format_ret(1,$classid);
            }else{
                $ret = $this->format_ret(0,"lost params");
            }
            echo json_encode($ret);
            exit;
        }
        public function teacher_class_subject(){
            $schoolid=$_SESSION['schoolid'];
            $class_banji=I("class_banji");

            $teacherid=I("teacherid");

             $class_subject=I("class_subject");

            $where['type']=2;
            $where['teacherid']=$teacherid;

           // exit();
            $deletel=M("teacher_class")->where($where)->delete();
            $delete=M("teacher_subject")->where("teacherid=$teacherid")->delete();
            foreach ($class_banji as &$items) {
            	$datas["schoolid"]=$schoolid;
            	$datas["teacherid"]=$teacherid;
            	$datas["classid"]=$items["classid"];
            	$datas["type"]=2;
            	$class_add=M("teacher_class")->add($datas);
            }           
            foreach ($class_subject as &$item) {
                $data["schoolid"]=$schoolid;
                $data["teacherid"]=$teacherid;
                $data["classid"]=$item["c_id"];
                $data["subjectid"]=$item["subject"];
                $info_add=M("teacher_subject")->add($data);
            }
        }
        //保存IC卡号
        public function card_save(){
        	//传过来要有两个卡号一个为老的cardno 一个为新的cardno
        	$schoolid=$_SESSION['schoolid'];
        	//新的卡号
            $card=I("card");
            //旧的卡号
            $old_card = I("old_card");
            $where['cardno']=$old_card;

            $teacherid=I("teacherid");
            $where['personId']=$teacherid;
            $where['cardType']=1;

            $where['handletype'] =1;
            $showcard = get_showcard($card,$schoolid);


            //查询新的卡号是否已经被使用
            if($showcard)
            {
                $info['status'] = false;
                $info['info'] = '卡号已经被使用!';
                echo json_encode($info);
                die();
            }


            //默认成功
            $info['status'] = true;


            //去查询是否存在该条数据

            $cha=M("student_card")->where($where)->select();
          
            if(!$cha){
            $data["personId"]=$teacherid;
            $data["cardNo"]=$card;
            $data["schoolid"]=$schoolid;
            $data["create_time"]=time();
             $data['handletime'] = date("Y-m-d H:i:s",time());
            $data['handletimeint'] = time();
            $data['handletype'] = 1;
            $data["cardType"]=1;
               //echo "dsadsa";
            $card_add=M("student_card")->add($data);
            }else{
            	//将原来的表修改并添加替换添加时间并将状态改为删除 ,然后再新增一条card表的记录
            	 $save_card['handletype'] = 0;
             
            	 $save_card['handletimeint'] = time();
            	 $card_gai=M("student_card")->where($where)->save($save_card);

            	 if($card_gai){
                 
                 $card_addc['personId']=$teacherid;
                 $card_addc['cardNo'] = $card;
                 $card_addc['schoolid'] = $schoolid;
                 $card_add['create_time'] = time();
                 $card_addc['handletime'] = date("Y-m-d H:i:s",time());
                 $card_addc['handletimeint'] = time();
                 $card_addc['handletype'] = 1;
                 $card_addc['cardType'] = 1;
            	 $creat_card = M('student_card')->add($card_addc); 
            	}

              

            }
            update_card(1,$teacherid,$schoolid);
            echo json_encode($info);
        }
        //保存老师代课班级设置
        public function save_relation(){
            $schoolid=$_SESSION['schoolid'];
            $teacherid=I("teacherid");
            $class_arr=I("class_arr");
            //先把原有班级删除
            $delete=M("teacher_class")->where("teacherid=$teacherid")->delete();
            // if($delete){
                foreach ($class_arr as &$classid) {
                    $data["teacherid"]=$teacherid;
                    $data["schoolid"]=$schoolid;
                    $data["classid"]=$classid;
                    $data["type"]=2;
                    $add=M("teacher_class")->add($data);
                }  
            // }
            if($delete && $class_arr){
                $this->success("保存成功");
            }else{
                $this->error("保存失败");
            }
        }
        //参数获取(状态，原因)
        function format_ret ($status, $data='') {
            if ($status){   
            //成功
                return array('status'=>'success', 'data'=>$data);
            }else{  
                //验证失败
                return array('status'=>'error', 'data'=>$data);
            }
        }

        //参数获取(状态，原因)
        function format_ret_else ($statues, $date='') {
            if ($statues){   
            //成功
                return array('statues'=>'success', 'date'=>$date);
            }else{  
                //验证失败
                return array('statues'=>'error', 'date'=>$date);
            }
        }
    //TODO 还没完善   删除教师info信息  具体该删除哪些数据还需暂定

       public function delete(){

           $schoolid=$_SESSION['schoolid'];
           $teacherid=I("teacherid");
           $info_id = intval($_GET['info_id']);
           if($teacherid && $schoolid) {

               $now = time();
               $nowday = date('Y-m-d H:i:s', $now);

               //先删除带班表
               M("teacher_class")->where(array("schoolid" => $schoolid, "teacherid" => $teacherid))->delete();
               //删除微信绑定表  先查询该userid 是否是家长,如果是家长就不删除

               //删除卡号表
               M('student_card')->where(array("personId" => $info_id, "handletype" => 1, "schoolid" => $schoolid, "cardType" => 1))->save(array("handletype" => 0, "handletime" => $nowday, "handletimeint" => $now));
               //删除职责表
               M("duty_teacher")->where(array("schoolid" => $schoolid, "teacher_id" => $teacherid))->delete();
               //删除teacher_info表
               $rstss = M("teacher_info")->where(array("schoolid" => $schoolid, "teacherid" => $teacherid))->delete();
               //如果该老师不是家长，解除微信关系
               if (!is_parent($teacherid)) {
                   $appid = M('Wxmanage')->alias('wm')->join('wxt_wxmanage_school ws on wm.id=ws.manage_id ')->where("ws.schoolid = '$schoolid'")->field("wm.wx_appid")->find();
                   M("xctuserwechat")->where(array("userid" => $teacherid, "appid" => $appid['wx_appid']))->delete();
                 //如果该老师不在其他学校任课,则删除用户表
                   if (!is_teacher($teacherid)) {
                       M("wxtuser")->where(array("id" => $teacherid))->delete();
                   }
               }
//            $appid=M('Wxmanage')->alias('wm')->join('wxt_wxmanage_school ws on wm.id=ws.manage_id ')->where("ws.schoolid = '$schoolid'")->field("wm.wx_appid")->find();
//            M('student_card')->where(array("personId"=>$teacherid,"handletype"=>1,"schoolid"=>$schoolid))->save(array("handletype"=>0,"handletime"=>$nowday,"handletimeint"=>$now));
//            M("teacher_class")->where(array("teacherid"=>$teacherid,"schoolid"=>$schoolid))->delete();
//            $rstss = M('teacher_info')->where(array("teacherid"=>$teacherid,"schoolid"=>$schoolid))->delete();
//            $jiazhang = M('relation_stu_user') -> where("userid=$teacherid") -> field("userid")->select();

           }

           // var_dump($del);
           // die();
            if ($rstss > 0) {
                    $info['status'] = true;
                    $info['msg'] = $teacherid;
                } else {
                    $info['status'] = false;
                    $info['msg'] = '404';
                }
                echo json_encode($info);
        }

                    //点击查看显示微信绑定
        public  function bindingkey(){
                         
                        $teacherid=I("teacherid");
                
                        $binkey = M('teacher_info')->where("teacherid=$teacherid")->field('bindingkey')->select();
                     
                        if($binkey){
                            $ret  = $this->format_ret(1,$binkey);
                        }else{
                           $ret  = $this->format_ret(0,"parms lost"); 
                        }
                        echo  json_encode($ret);

                }
                 
                 // TOODO 修改密码 没加正正则判断
        public function password()
        {
                    $teacherid=I("teacherid");
                     $password = I("password");   
                    $data = [
                        'password'=>$password
                    ];
                     $rel = M('wxtuser')->where("id=$teacherid")->setField('password',md5($password));
                     
                        if ($rel > 0) {
                                $info['status'] = true;
                                $info['msg'] = $teacherid;
                            } else {
                                $info['status'] = false;
                                $info['msg'] = '404';
                            }
                echo json_encode($info);   
          }
  

       //TOODO编辑教师信息  没完善

        public function edit()
        {
               $teacherid = I('teacherid');

               //获取teacher_info里的id
               $info_id = M("teacher_info")->where(array("teacherid"=>$teacherid,"schoolid"=>$this->schoolid))->getField("id");

               $phone = I('rel');

               $group = I('group');
             
               $name = I('name');

               $email = I('email');
            
               $state = I('state');

               $duty = I('duty');

//               dump($duty);
//               dump($teacherid);
//                exit();
               $schoolid=$_SESSION['schoolid'];
               
            

             if($name){
                $teacherinfo['name'] = $name;
                $up = M('teacher_info')->where("teacherid=$teacherid")->save($teacherinfo);
            }
            if($phone)
            {
                M('wxtuser')->where("id=$teacherid")->save(array("phone"=>$phone));
            }


             if($email || $state)
             {
                $infos = array(
                    'email'=>$email,
                    'state'=>$state,
                    );
                $teacher_info  =M("teacher_info")->where("teacherid = $teacherid")->save($infos);
             }              





              $where_del['teacher_id'] = $info_id;

              $where_del['school_id'] = $schoolid; 

              

              $del = M('department_teacher')->where($where_del)->delete();

            foreach ($group as &$items) {
              
                $datas["school_id"]=$schoolid;
                $datas["teacher_id"]=$info_id;
                $datas["department_id"]=$items['dmpid'];

                $dem_add=M("department_teacher")->add($datas);
            } 
         
         //如果接受到传过来的值则执行
         if ($duty) {
             $where_duty['schoolid'] = $schoolid;
             $where_duty['teacher_id'] = $teacherid;

             $del_duty = M("duty_teacher")->where($where_duty)->delete();




                foreach ($duty as $value) {
                    $data_duty['schoolid'] = $schoolid;
                    $data_duty['duty_id'] = $value['dutyid'];
                    $data_duty['teacher_id'] = $teacherid;

                    $duty_add = M('duty_teacher')->add($data_duty);


             }
         }



        //传过来要有两个卡号一个为老的cardno 一个为新的cardno

            //暂时先这样改造  根据穿过来的userid 去查询teacherid  下次要把teacherid改回来  如果教师是13000000000 这样查找会重复

            $t_id = M("teacher_info")->where("teacherid = $teacherid and schoolid = $schoolid")->getField("id");

            //新的卡号
            $card=I("newcardNo");
            
            //旧的卡号
            $old_card = I("oldcardNo");

            $where['cardno']=$old_card;

            $where['personId']=$t_id;
            $where['cardType']=1;

            $where['handletype'] =1;

            //去查询是否存在该条数据

            $cha=M("student_card")->where($where)->select();
          
            if(!$cha){
            $data["personId"]=$t_id;
            $data["cardNo"]=$card;
            $data["schoolid"]=$schoolid;
            $data["create_time"]=time();
       
            $data['handletimeint'] = time();
            $data['handletype'] = 1;
            $data["cardType"]=1;
               //echo "dsadsa";
            $card_add=M("student_card")->add($data);
            }else{
                //将原来的表修改并添加替换添加时间并将状态改为删除 ,然后再新增一条card表的记录
                 $save_card['handletype'] = 0;
             
                 $save_card['handletimeint'] = time();
                 $card_gai=M("student_card")->where($where)->save($save_card);

                 if($card_gai){
                 
                 $card_addc['personId']=$t_id;
                 $card_addc['cardNo'] = $card;
                 $card_addc['schoolid'] = $schoolid;
                 $card_add['create_time'] = time();
               
                 $card_addc['handletimeint'] = time();
                 $card_addc['handletype'] = 1;
                 $card_addc['cardType'] = 1;
                 $creat_card = M('student_card')->add($card_addc); 
                }

              

            }






            update_card(1,$t_id,$schoolid);



                if ($up || $dem_add || $card || $teacher_info || $duty_add) {
                                $info['status'] = true;
                                $info['msg'] = 'yes';

                            } else {
                                $info['status'] = false;
                                $info['msg'] = '404';
                       }
                     echo json_encode($info);               

         }

        //TOODO  Excel导入导出函数 还没完善

         public function exportExcel($expTitle,$expCellName,$expTableData,$fileNames){
            
           $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
            $fileName = $fileNames;//or $xlsTitle 文件名称可根据自己情况设定
            $cellNum = count($expCellName);
            $dataNum = count($expTableData);


            vendor('PHPExcel.PHPExcel');
             $objPHPExcel = new \PHPExcel();
           //var_dump($objPHPExcel);

              $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

           //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格

           // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
                $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);//单元格宽度
                $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');//设置字体
                $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);//设置字体大小
                // $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"名字");
                // $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"时间");
                // $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"照片");
            for($i=0;$i<$cellNum;$i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]); 
            } 
              // Miscellaneous glyphs, UTF-8   
            for($i=0;$i<$dataNum;$i++){
              for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
              }             
            }  
            
            header('pragma:public');
            header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
            header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
            $objWriter = \ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
            $objWriter->save('php://output'); 
            exit;   
             
    }

      public function expUser(){//导出Excel

          //用户信息
          $userid=$_SESSION['USER_ID'];

          $schoolid=$_SESSION['schoolid'];

          $level= $_SESSION['level'];
          //获取查询班级
          $search_class=I("search_class");

          $search_grade = I("search_grade");
          $this->assign("gradeinfo",$search_grade);

          if($search_grade && !$search_class)
          {
              // $this->assign("gradeinfo",$search_grade);
              $class_arr = array();
              $school_class =M("school_class")->where("schoolid = $schoolid and grade = $search_grade")->field("id")->select();
              if($school_class){

                  foreach ($school_class as $key => $value) {
                      array_push($class_arr,$value['id']);
                  }
                  // var_dump($class_arr);

                  $join_else ="wxt_teacher_class class ON class.teacherid = w.id";
                  $where_info['class.classid'] = array("in",$class_arr);
              }
          }

          // exit();
          if($search_class){

              $this->assign("search_class",$search_class);
              $join_else ="wxt_teacher_class class ON class.teacherid = w.id";
              $where_info['class.classid'] = $search_class;

              // var_dump($search_class);

              // var_dump($where_class["class"]);


          }
          $where_class["schoolid"]=$schoolid;


          //获取查询卡号
          $teacher_card=I("search_card");
          // var_dump($teacher_card);
          // exit();
          if($teacher_card){
              $where_info["s.cardNo"]=$teacher_card;
              $join="wxt_student_card s ON s.personId=d.teacherid";

          }
          $teacher_name=I("search_name");
          if($teacher_name){
              $where_info["w.name"]=array("LIKE","%".$teacher_name."%");
          }
          //获取查询手机
          $search_phone=I("search_phone");
          if($search_phone){
              $where_info["w.phone"]=array("LIKE","%".$search_phone."%");

          }


          //本校班级(年级)
          $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
          // var_dump($grade);
          // echo "<hr>";
          $class=M('school_class')->where($where_class)->order("id asc")->select();

          $appid = M("wxmanage")->where("schoolid = $schoolid")->getField("wx_appid");

          if($level!=1  && $level!=2)
          {
              $where_info['d.schoolid'] = $schoolid;
              $where_info['d.teacherid'] = $userid;

          }



      $where_info['d.schoolid'] = $schoolid;

          $teacher_info=M("teacher_info")
              ->alias("d")
              ->join("wxt_wxtuser w ON d.teacherid=w.id")
              ->join($join)
              ->join($join_else)
              ->distinct(true)
              ->where($where_info)
              ->field("w.id,w.name,w.phone,d.schoolid,d.bindingkey,d.state,d.email,d.id as info_id")
              ->select();



          foreach ($teacher_info as &$item) {

              $t_id=$item["id"];
              $info_id = $item["info_id"];
              //获取IC卡号
              $card=M("student_card")->field("cardNo")->where("personId=$t_id and cardType=1 and handletype = 1")->find();
              // var_dump($card);
              $item["card"]=$card["cardno"];
              //获取教师任课情况
              $where["k.schoolid"]=$schoolid;
              $where["k.teacherid"]=$t_id;
              $teacher_subject=M("teacher_class")
                  ->alias("k")
                  ->join("wxt_school_class d ON k.classid=d.id ")
                  ->where($where)
                  ->field("d.classname,d.id as ids")
                  ->select();
              //appid



//        	$teacher_appid = M("xctuserwechat")->where("userid = $t_id and appid = $appid")->getField("appid");
              $teacher_appid = M("xctuserwechat")->where(array("userid"=>$t_id,"appid"=>$appid))->getField("appid");
              //var_dump($teacher_subject);
              $item['appid'] = $teacher_appid;
              $teacher_idsu="";
              $teacher_inforty="";
              foreach ($teacher_subject as &$itvo) {
                  $info=$itvo["classname"];
                  $infos=$itvo["ids"];
                  $teacher_inforty = $info.",".$teacher_inforty;
                  $teacher_idsu=$infos.",".$teacher_idsu;
              }
              $item["teacher_classid"]=$teacher_idsu;
              $item["teacher_subject"]=rtrim($teacher_inforty, ",");
              //判断是班主任还是带班老师
              // $teacher_set=M("duty_teacher")->field("duty_id")->distinct(true)->where("teacher_id=$t_id")->select();
              $teacher_set=M("duty_teacher")->alias("t")->join("wxt_school_duty s ON s.id=t.duty_id")->where("t.teacher_id = $info_id and t.schoolid = $schoolid")->field("s.id,s.name")->select();
              $teacher_duty = "";

              foreach ($teacher_set as  $duty) {
                  $info_duty = $duty['name'];
                  $teacher_duty = $info_duty.",".$teacher_duty;
              }


              $item["teacher_set"]=$teacher_set;
              $item['teacher_duty'] = $teacher_duty;

              //获取教师部门
              $teacher_department=M("department_teacher")->alias("d")->join("wxt_department w ON d.department_id=w.id")->where("d.teacher_id=$t_id")->field("w.name,w.id")->select();



              $item["teacher_department"]=$teacher_department;

              $department_list = "";
              foreach ($teacher_department as $key => $val) {
                  $info_list = $val['name'];
                  $department_list = $info_list.",".$department_list;
              }
              $item['department_list'] = $department_list;

              //获取教师任课情况
//      	$teacher_subjec=M("teacher_subject")
//      	->alias("t")
//      	->join("wxt_school_class s ON s.id=t.classid")
//      	->join("wxt_default_subject d ON d.id=t.subjectid")
//      	->where("t.teacherid=$t_id")
//      	->field("t.*,s.classname,d.subject")
//      	->select();
//      	$teacher_ids="";
//		    $teacher_infort="";
//      	$item["teacher_dai"]=$teacher_subjec;
//      	foreach ($teacher_subjec as &$itvos){
//      	    $inf=$itvo["classname"];
//		    $inos=$itvo["subject"];
//		    	$teacher_inforty = $inf.",".$inos;
//       	}
          }




                $xlsName  = "User";

                $xlsCell  = array(

                array('id','教师账号'),

                array('name','老师名字'),

                array('phone','手机'),

                array('bindingkey','微信绑定号'),

                array('card','IC卡号'),

                array('teacher_subject','带班/带课'),

                );
                //接收保存在SESSION的值
//                $xlsData = $_SESSION['Teacher_info'];
                $xlsData = $teacher_info;

                //学校名称
                $school_name = get_schoolname($schoolid);

                $fileNames =  get_schoolname($schoolid).'-'.'老师数据导出';
        
                $this->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);
                     
        }


        //加载导入状态页
       public function excel()
       {
            

         $schoolid=$_SESSION['schoolid'];

         $begin_time=strtotime(I("begin"));
         
         //var_dump($begin_time);
         
         $end_time=strtotime(I("end"));
        
         //var_dump($end_time);
         //var_dump($schoolid);
         //exit();

     if($begin_time && $end_time != false)
     {
           $excel_error = M('teacher_excel')->where("time >= $begin_time and time <= $end_time and schoolid = $schoolid and state = 1")->order('time desc')->select();
           $this->assign('excel',$excel_error); 

             $this->display();
             die();
     }



           $excel_error = M('teacher_excel')->where("schoolid = $schoolid and state = 1")->order('time desc')->select();


         // var_dump($excel_error);

         $this->assign('excel',$excel_error); 

         $this->display();

       }


       //查看处理结果
       public function showre()
       {
            $excelid = I('excelid');               
          $excel = M('teacher_excel')->where("id=$excelid")->find();

         
         foreach ($excel as  $key=>&$value) {
           $excel['time']=date("Y-m-d H:i:s", $excel['time']);
         }
       
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
           $er_id = $_POST['ids'];

           $id =  implode(",", $er_id);

           $del = M('teacher_excel')->where("id in ($id)")->delete();

           if ($del) {
               $info['status'] = true;
               $info['msg'] = $del;
           } else {
               $info['status'] = false;
               $info['msg'] = '404';
           }
           echo json_encode($info);
       }
       
   
       //下载教师数据导入模板
       public function ImportExcel()
       {

                $xlsName  = "User";

                $xlsCell  = array(

                array('','姓名'),

                array('','角色'),

                array('','电话号码'),

                array('','IC卡号'),

                array('','出生日期'),

                );
                $fileNames ='教师资料导入';
                $xlsData =" ";
   
        $this->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);

       }
   


     //教师导入
public function impUser(){
         

        $schoolid = $_SESSION['schoolid'];
        
        $allcount=0;
        $successcount=0;
        $updatecount=0;
        if(!$schoolid){
            $this->error("请选择学校");
        }
       
        if(!$_FILES)
        {
            $this->error("请选择上传文件!");
            exit();
        }
      

        $upload = new \Think\Upload();// 实例化上传类

        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath  =      './'; // 设置附件上传根目录
        $upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
        $upload->autoSub   =     false;//不自动生成子文件夹
        // 上传单个文件 
        $info   =   $upload->uploadOne($_FILES['import']);

         $type = $info['ext'];

         $file_name = $info['name'];
        // var_dump($_FILES);
        // exit();
        if(!$info){
            $this->error($upload->getError());
        }else{
            $file_puth = './'.$info['savepath'].$info['savename'];
            //文件上传成功，对文件进行解析
            // vendor('phpexcel_1.phpexcel');//导入类库
            require_once VENDOR_PATH.'PHPExcel/PHPExcel/IOFactory.php';
            require_once VENDOR_PATH.'PHPExcel/PHPExcel.php';
            if($info['ext']=='xlsx'){
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
            }else{
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }
            //use excel2007 for 2007 format
            $objPHPExcel = $objReader->load($file_puth);
            // $objPHPExcel->setActiveSheetIndex(1);
            $sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始) 
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
           // var_dump($highestColumn);
            //循环读取excel文件,读取一条,插入一条
            // $info='begin::';
            for($j=7;$j<=$highestRow;$j++)
            {
                for($k='A';$k<=$highestColumn;$k++)
                {
                    //读取单元格
                    $ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                    $allcount++;

                }
            }
            $info=$j.'-'.$k.':'.$info.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();

            $successcount=0;
            $error_info = array();
            $rowNo = 6;
            foreach ($ExamPaper_arr as $key => $value)
            {
                //循环数据检测A=>教师姓名，B=>教师角色，C=>电话号码，D=>校园短号，E=>IC卡号，F=>班级，G=>科目，H=>班主任班级
                //如果题号或者题干不为空
                if(!empty($value['A'])||!empty($value['B'])||!empty($value["C"])){
                    $name=$value['A'];
                    $phone=$value['C'];
                    $sex="男";
                    $subject=$value['G'];
                    $duty=$value['B'];
                    $classname=$value['F'];
                    $school_sort_number = $value["D"];
                    $ic_number = $value["E"];
                    $mainclass = $value["H"];
                    $result=$this->importteacher(trim($name),trim($phone),trim($sex),trim($duty),trim($classname),trim($subject),trim($school_sort_number),trim($ic_number),trim($mainclass),$schoolid);

                    /**
                     * 导入教师以及关系数据到数据库
                     * return 0 必填字段获取失败
                     * return 1 成功
                     * return 2 老师用户添加失败
                     * return 3 职务绑定失败
                     * return 4 科目绑定失败
                     * return 5 班级绑定失败
                     * return 6 学校信息获取失败
                     * return 7 老师info信息保存失败
                     */
                    if($result == 1){
                        $successcount++;
                    }else if($result ==2){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"老师用户添加失败"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==3){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"职务绑定失败"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==4){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>" 科目绑定失败"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==5){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"IC卡号已存在"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result==6){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"学校信息获取失败"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result==7){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"老师info信息保存失败"
                        );
                        array_push($error_info,$error_item);
                    }
                }else {
                    $error_item = array(
                        "row"=>$rowNo,
                        "msg"=>"必填数据未填写"
                    );
                    array_push($error_info,$error_item);
                }

                $rowNo++;
            }
        }
        $allcount=$highestRow-6;
        $emptyData = "";
        foreach ($error_info as &$error_item){
            $emptyData = $emptyData."第".($error_item["row"]+1)."行".$error_item["msg"]."、";
        }
   
      if(!empty($emptyData))
      {
            $data_excel =  array(
                       'schoolid'=>$schoolid,
                       'filename'=>$file_name,
                        'type'=>$type,
                        'time'=>time(),
                        'pro'=>rtrim($emptyData, ","),
                        'status'=>1,
                        'state'=>3

                        );

          $teacher_excel = M('teacher_excel')->add($data_excel);

         
      }else{
            $data_excel =  array(
                       'schoolid'=>$schoolid,
                       'filename'=>$file_name,
                        'type'=>$type,
                        'time'=>time(),
                        'pro'=>'完美!',
                        'status'=>0,
                        'state'=>3,

                        );
            $teacher_excel = M('teacher_excel')->add($data_excel);


      }

        $info='::其中成功'.$successcount.'人,'.$emptyData;

        $this->success('导入完成');
    }
    /**
     * 导入教师以及关系数据到数据库
     * return 0 必填字段获取失败
     * return 1 成功
     * return 2 老师用户添加失败
     * return 3 职务绑定失败
     * return 4 科目绑定失败
     * return 5 班级绑定失败
     * return 6 学校信息获取失败
     * return 7 老师info信息保存失败
     */
    function importteacher($username,$phone,$sexname,$dutyname,$classname,$subject,$school_sort_number,$ic_number,$mainclass,$schoolid){
        $result = 1;
        //判断学校信息是否存在
        if ($schoolid){
            $isShool = M("School")->where(array("id"=>$schoolid))->find();
            if (!$isShool){
                return 6;
            }
        }else{
            return 6;
        }
        //判断必填字段
        if(empty($username) || empty($dutyname)){
            return 0;
        }else{
            //逐项检测有效数据
            //1.性别判定
            $sex=0;
            if($sexname=='男'){
                $sex=1;
            }
            //2、职务获取 以"，"分割，获取职位数组
            $dutyList = explode(',',$dutyname);

            $dutyList = array_filter($dutyList);

            //3.获取教师负责科目 以"，"分割，获取科目数组
            $subjectList = explode(",",$subject);
            $subjectList = array_filter($subjectList);
            //3.1 获取教师负责班级信息: 以"，"分割，获取班級数组
            $classList = explode(",",$classname);
            $classList = array_filter($classList);

            if($ic_number)
            {
                $ic_number = explode(",", $ic_number);
            }


            foreach ($ic_number as &$card) {

                //ic卡号不到十位 在前面补位0
                if (strlen($card) < 10) {

                    $lastResult = ""; // 存储返回的结果
                    for ($i = 0; $i < 10 - strlen($card); $i++) {
                        $lastResult = "0" . $lastResult;
                    }
                    $card = $lastResult . $card;

                }
                if ($card == "0000000000") {
                    $card = "";
                }
            }

            //4.在user表中存入老师信息 : 检测用户是否已经存在如果存在并返回ID， 如果不存在，新写入并返回ID
//            $userwhere['phone']=$phone;
            if(!$phone)
            {
                $phone = 13000000000;
            }
            $userwhere['phone'] = $phone;
            $user=$this->wxtuser_model->where($userwhere)->field('id')->find();

            if($phone==13000000000){

                $pwd = substr($phone, -6);

                $data = array(
                    'schoolid' => $schoolid,
                    'name' => $username,
                    'phone' => $phone,
                    'sex' => $sex,
                    'password' => md5($pwd),
                    'status' => '1',
                    'user_type' => '0',
                    'create_time' => time()
                );
                $userid = $this->wxtuser_model->add($data);
            }elseif ($user){

                $userid = $user["id"];
            }else{

                $pwd = substr($phone, -6);

                $data = array(
                    'schoolid' => $schoolid,
                    'name' => $username,
                    'phone' => $phone,
                    'sex' => $sex,
                    'password' => md5($pwd),
                    'status' => '1',
                    'user_type' => '0',
                    'create_time' => time()
                );
                $userid = $this->wxtuser_model->add($data);

            }

            //5.user 添加成功 后在teacher_info表中添加老师信息  在student_card存入老师ic卡信息
            if ($userid){
                //5.1teacher_info表中添加老师信息
                $teacher_info_find["schoolid"] = $schoolid;
                $teacher_info_find["teacherid"] = $userid;
                $teacher_info_find["name"] = $username;
                $teacher_info_find_result = M("teacher_info")->where($teacher_info_find)->find();
                if($teacher_info_find_result){
                    $result = 2;
                }else{
                    $bindingkey=rand(100000,999999);
                    $info_data = array(
                        "schoolid"=>$schoolid,
                        "teacherid"=>$userid,
                        "state"=>1,
                        "email"=>"",
                        "education_card"=>"",
                        'name'=>$username,
                        "work_card"=>"",
                        "description"=>"",
                        "shool_sort_number"=>$school_sort_number,
                        "bindingkey"=>$bindingkey
                    );
                    $user_info = M("teacher_info")->add($info_data);

                }

                //5.2在student_card存入老师ic卡信息  和 卡记录表wxt_student_card_log
                foreach ($ic_number as $tea_card) {


                    $teacher_ic_find["cardNo"] = $card;
                    $teacher_ic_find["personId"] = $user_info;
                    $teacher_ic_find["handletype"] = 1;
                    $teacher_ic_find["cardType"] = 1;
                    $teacher_ic_find_result = M("student_card")->where($teacher_ic_find)->find();


                    if ($teacher_ic_find_result) {
                        $result = 5;
                    } else {

                        $ic_number_find["cardNo"] = $tea_card;
                        $ic_number_find["schoolid"] = $schoolid;
                        $ic_number_find_result = M("student_card")->where($ic_number_find)->find();
                        if ($ic_number_find_result) {
                            $result = 5;
                        } else {
                            if ($ic_number != "") {

                                $ic_data = array(
                                    "cardNo" => $tea_card,
                                    "personId" => $user_info,
                                    'name' => $username,
                                    "cardType" => 1,
                                    "handletime" => date('Y-m-d H:i:s', time()),
                                    "handletimeint" => time(),
                                    "schoolid" => $schoolid,
                                    "create_time" => time()
                                );
                                M("student_card")->add($ic_data);
                            }
                        }

                    }
                }
            }

            if ($user_info==false){
                $result =  7;
            }else {


                //6.循环插入教师职位关系 查找职务是否存在，并返回职务ID TO 这里需改造成 school_duty where条件需用上schoolid
                foreach ($dutyList as $key=>&$duty_item) {

                    $duty_where['name'] = $duty_item;
                    $duty_where['schoolid'] = $schoolid;

                    // $duty=M('duty')->where($duty_where)->field('id')->find(); todo 改造每个学校都有自己的权限
                    $duty = M('school_duty')->where($duty_where)->field('id,level')->find();

                    //学校管理员和校长默认带所有班级 以防止重复只取第一个
                    if($duty['level']==1 || $duty['level']==2)
                    {
                        if($key==0)
                        {
                            $is_class = true;

                            add_admin_class($userid,$schoolid);
                        }

                    }

                    if ($duty) {
                        $dutyid = $duty['id'];
                        $dudata = array(
                            "schoolid" => $schoolid,
                            "duty_id" => $dutyid,
                            "teacher_id" => $userid
                        );

                        $isduty = $this->teacherduty_model->where($dudata)->find();


                        if ($isduty) {
                            $result = 3;
                        } else {
                            //写入职务关系表
                            $rt = $this->teacherduty_model->add($dudata);
                            if (!$rt) {
                                echo "插入不成功!";
                                $result = 3;
                            }
                        }
                    } else {
                        $result = 3;
                    }
                }
            }
            //循环导入科目信息 查找该学校拥有的科目 若没有则插入失败 有则继续插入
            //wxt_subject 学校对应的科目表 ； wxt_default_subject 所有科目表
            foreach ($subjectList as &$subject_item){
                $subject_where["subject"] = $subject_item;
                $subject_find = M("default_subject")->alias("d")
                    ->join("wxt_subject s ON d.id = s.subjectid")
                    ->field("d.id,d.subject,s.id as school_subjectid")
                    ->where($subject_where)
                    ->find();

                if ($subject_find){//存在則存入wxt_teacher_subject 教师科目班级关系表 每个班级都导入任课
                    $subjectid = $subject_find["id"];
                    for ($i=0;$i<count($classList);$i++){
                        $subjectdata=array(
                            "schoolid"=>$schoolid,
                            "classid"=>$classList[$i],
                            "teacherid"=>$userid,
                            "subjectid"=>$subjectid
                        );
                        $isSubject=M("teacher_subject")->where($subjectdata)->find();
                        if($isSubject){
                            $result = 4;
                        }else{
                            //写入科目关系表
                            $st = M("teacher_subject")->add($subjectdata);
                            if ($st==false){
                                $result =  4;
                            }
                        }
                    }

                }
            }

            //循环导入教师班级信息

            if(!$is_class) {

                foreach ($classList as &$class_item) {
//                //3.2 判断是不是班主任
                    $isClassMainTeacher = 2;
                    if ($mainclass == $class_item) {
                        $isClassMainTeacher = 1;
                    }

                    $class_where['classname'] = $class_item;
                    $class_where['schoolid'] = $schoolid;
                    $classid = M('school_class')->where($class_where)->field('id')->find();


                    if ($classid) {
                        $class_data = array(
                            "teacherid" => $userid,
                            "schoolid" => $schoolid,
                            "classid" => $classid["id"],
                            "type" => $isClassMainTeacher,
                            "status" => 1
                        );
                        $isClassAdd = M("teacher_class")->where($class_data)->find();

                        if ($isClassAdd == false) {
                            $tea_class = M("teacher_class")->add($class_data);

                            $result = 1;
                        }
                    } else {
                        $result = 5;
                    }

                }
            }

        }
        return $result;
    }
    function importteacher_back($username,$phone,$sexname,$dutyname,$classname,$subject,$school_sort_number,$ic_number,$mainclass,$schoolid){
        $result = 1;
        //判断学校信息是否存在
        if ($schoolid){
            $isShool = M("School")->where(array("id"=>$schoolid))->find();
            if (!$isShool){
                return 6;
            }
        }else{
            return 6;
        }
        //判断必填字段
        if(empty($username) || empty($phone) || empty($dutyname)){
            return 0;
        }else {
            //逐项检测有效数据
            //1.性别判定
            $sex = 0;
            if ($sexname == '男') {
                $sex = 1;
            }
            //2、职务获取 以"，"分割，获取职位数组
            $dutyList = explode(',', $dutyname);

            $dutyList = array_filter($dutyList);

            //3.获取教师负责科目 以"，"分割，获取科目数组
            $subjectList = explode(",", $subject);
            $subjectList = array_filter($subjectList);
            //3.1 获取教师负责班级信息: 以"，"分割，获取班級数组
            $classList = explode(",", $classname);
            $classList = array_filter($classList);

            //ic卡号不到十位 在前面补位0
            if (strlen($ic_number) < 10) {
                $lastResult = ""; // 存储返回的结果
                for ($i = 0; $i < 10 - strlen($ic_number); $i++) {
                    $lastResult = "0" . $lastResult;
                }
                $ic_number = $lastResult . $ic_number;
            }
            if ($ic_number == "0000000000") {
                $ic_number = "";
            }

            //4.在user表中存入老师信息 : 检测用户是否已经存在如果存在并返回ID， 如果不存在，新写入并返回ID
            $userwhere['phone'] = $phone;
//            $userwhere['schoolid'] = $schoolid;
            $user = $this->wxtuser_model->where($userwhere)->field('id')->find();

            if ($user) {
                $userid = $user["id"];
                $edit_name = M('wxtuser')->where("id = $userid")->save(array("name" => $username));
            } else {

                $pwd = substr($phone, -6);

                $data = array(
                    'schoolid' => $schoolid,
                    'name' => $username,
                    'phone' => $phone,
                    'sex' => $sex,
                    'password' => md5($pwd),
                    'status' => '1',
                    'user_type' => '0',
                    'create_time' => time()
                );
                $userid = $this->wxtuser_model->add($data);


            }

            //5.user 添加成功 后在teacher_info表中添加老师信息  在student_card存入老师ic卡信息
            if ($userid) {
                //5.1teacher_info表中添加老师信息
                $teacher_info_find["schoolid"] = $schoolid;
                $teacher_info_find["teacherid"] = $userid;
                $teacher_info_find_result = M("teacher_info")->where($teacher_info_find)->find();
                if ($teacher_info_find_result) {
                    $result = 2;
                } else {
                    $bindingkey = rand(100000, 999999);
                    $info_data = array(
                        "schoolid" => $schoolid,
                        "teacherid" => $userid,
                        "state" => 1,
                        "email" => "",
                        "education_card" => "",
                        "work_card" => "",
                        "description" => "",
                        "shool_sort_number" => $school_sort_number,
                        "ic_number" => $ic_number,
                        "bindingkey" => $bindingkey
                    );
                    $user_info = M("teacher_info")->add($info_data);

                }

                //5.2在student_card存入老师ic卡信息  和 卡记录表wxt_student_card_log
                $teacher_ic_find["cardNo"] = $ic_number;
                $teacher_ic_find["personId"] = $userid;
                $teacher_ic_find["cardType"] = 1;
                $teacher_ic_find_result = M("student_card")->where($teacher_ic_find)->find();
                if ($teacher_ic_find_result) {
                    $result = 5;
                } else {

                    $ic_number_find["cardNo"] = $ic_number;
                    $ic_number_find["schoolid"] = $ic_number;
                    $ic_number_find_result = M("student_card")->where($ic_number_find)->find();
                    if ($ic_number_find_result) {

                    } else {
                        if ($ic_number != "") {

                            $ic_data = array(
                                "cardNo" => $ic_number,
                                "personId" => $userid,
                                'name' => $username,
                                "cardType" => 1,
                                "handletime" => date('Y-m-d H:i:s', time()),
                                "handletimeint" => time(),
                                "schoolid" => $schoolid,
                                "create_time" => time()
                            );
                            M("student_card")->add($ic_data);


                        }


                    }

                }
            }

            if ($user_info == false) {
                $result = 7;
            }

            //6.循环插入教师职位关系 查找职务是否存在，并返回职务ID
            foreach ($dutyList as $key => &$duty_item) {

                $duty_where['name'] = $duty_item;
                $duty_where['schoolid'] = $schoolid;

                $duty = M('school_duty')->where($duty_where)->field('id,level')->find();


                //学校管理员和校长默认带所有班级 以防止重复只取第一个
                if ($duty['level'] == 1 || $duty['level'] == 2) {
                    if ($key == 0) {
                        $is_class = true;

                        add_admin_class($userid, $schoolid);
                    }

                }

                if ($duty) {
                    $dutyid = $duty['id'];
                    $dudata = array(
                        "schoolid" => $schoolid,
                        "duty_id" => $dutyid,
                        "teacher_id" => $userid
                    );

                    $isduty = $this->teacherduty_model->where($dudata)->find();
                    // var_dump($isduty);

                    if ($isduty) {
                        $result = 3;
                    } else {
                        //写入职务关系表
                        $rt = $this->teacherduty_model->add($dudata);
                        if (!$rt) {
                            $result = 3;
                        }
                    }
                } else {
                    $result = 3;
                }
            }

            //循环导入科目信息 查找该学校拥有的科目 若没有则插入失败 有则继续插入
            //wxt_subject 学校对应的科目表 ； wxt_default_subject 所有科目表
            foreach ($subjectList as &$subject_item) {
                $subject_where["subject"] = $subject_item;
                $subject_find = M("default_subject")->alias("d")
                    ->join("wxt_subject s ON d.id = s.subjectid")
                    ->field("d.id,d.subject,s.id as school_subjectid")
                    ->where($subject_where)
                    ->find();

                if ($subject_find) {//存在則存入wxt_teacher_subject 教师科目班级关系表 每个班级都导入任课
                    $subjectid = $subject_find["id"];
                    for ($i = 0; $i < count($classList); $i++) {
                        $subjectdata = array(
                            "schoolid" => $schoolid,
                            "classid" => $classList[$i],
                            "teacherid" => $userid,
                            "subjectid" => $subjectid
                        );
                        $isSubject = M("teacher_subject")->where($subjectdata)->find();
                        if ($isSubject) {
                            $result = 4;
                        } else {
                            //写入科目关系表
                            $st = M("teacher_subject")->add($subjectdata);
                            if ($st == false) {
                                $result = 4;
                            }
                        }
                    }

                }
            }

            //循环导入教师班级信息
            if (!$is_class) {

            foreach ($classList as &$class_item) {
//                //3.2 判断是不是班主任
                $isClassMainTeacher = 2;
                if ($mainclass == $class_item) {
                    $isClassMainTeacher = 1;
                }

                $class_where['classname'] = $class_item;
                $class_where['schoolid'] = $schoolid;
                $classid = M('school_class')->where($class_where)->field('id')->find();


                if ($classid) {
                    $class_data = array(
                        "teacherid" => $userid,
                        "schoolid" => $schoolid,
                        "classid" => $classid["id"],
                        "type" => $isClassMainTeacher,
                        "status" => 1
                    );
                    $isClassAdd = M("teacher_class")->where($class_data)->find();

                    if ($isClassAdd == false) {
                        $tea_class = M("teacher_class")->add($class_data);

                        $result = 1;
                    }
                } else {
                    $result = 5;
                }

            }
         }

        }
        return $result;
    }
        public function save_de(){
    	$data["schoolid"]=$_SESSION['schoolid'];
    	$data["name"]=I("group_name");
    	$data["number"]=I("group_number");
        $data['status'] = 2;
    	$data["create_time"]=time();
    	$add=M("department")->add($data);
    	if($add){
    		 $info['status'] = true;
             $info['msg'] = $add;
             $info['name'] = I("group_name");
    	}else{
             $info['status'] = false;
             $info['info'] = '新增失败';
    	}
    	echo json_encode($info);   
    }
    //删除卡号

    public function delcard()
    {
        $cardno = I("cardno");

        if($cardno)
        {
             $info =  deletecard($cardno,1);

             echo $info;
            
        }else{
            $info['status'] = false;
            $info['info'] = '请传人正确的卡号';

            echo json_encode($info);
        }

    }

  //      public function impUser()
  //      {
  //     $schoolid=$_SESSION['schoolid'];    
     
  //           // $schoolid = intval(I('school'));
  //       $allcount=0;
  //       $successcount=0;
  //       $updatecount=0;
      
  //       $upload = new \Think\Upload();// 实例化上传类
  //       // var_dump($upload);
  //       $upload->maxSize   =     3145728 ;// 设置附件上传大小
  //       $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
  //       $upload->rootPath  =      './'; // 设置附件上传根目录
  //       $upload->savePath  =      'upload/Teacher_info/'; // 设置附件上传（子）目录
  //       $upload->autoSub   =     true;//不自动生成子文件夹
  //       // 上传单个文件 
  //       $info   =   $upload->uploadOne($_FILES['import']);
  //       // var_dump($info);
  //       $type = $info['ext'];

  //       $file_name = $info['name'];

  //       // var_dump($_FILES);
  //       // exit();
  //       if(!$info){
  //           $this->error($upload->getError());
  //       }else{
  //           $file_puth = './'.$info['savepath'].$info['savename'];
  //           //文件上传成功，对文件进行解析
  //           // vendor('phpexcel_1.phpexcel');//导入类库
  //           require_once VENDOR_PATH.'PHPExcel/PHPExcel/IOFactory.php';
  //           require_once VENDOR_PATH.'PHPExcel/PHPExcel.php';
  //           if($info['ext']=='xlsx'){
  //               require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
  //               $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
  //           }else{
  //               require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
  //               $objReader = \PHPExcel_IOFactory::createReader('Excel5');
  //           }
  //           //use excel2007 for 2007 format
  //           $objPHPExcel = $objReader->load($file_puth);
  //           // $objPHPExcel->setActiveSheetIndex(1);
  //           $sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始) 
  //           $highestRow = $sheet->getHighestRow(); // 取得总行数
  //           $highestColumn = $sheet->getHighestColumn(); // 取得总列数
  //           //循环读取excel文件,读取一条,插入一条
  //           // $info='begin::';
  //           for($j=2;$j<=$highestRow;$j++)
  //           {
  //               for($k='A';$k<=$highestColumn;$k++)
  //               {
  //                   //读取单元格
  //                   $ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
  //                   $allcount++;

                    
                    
                    
  //               }
  //           }
  //           $info=$j.'-'.$k.':'.$info.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();
  //            //var_dump($info);
  //           // exit();
  //           // $info=$info.'end';

  //           // $hl = $j.'--'.$k.':'.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();
  //           $successcount = 0;
  //           // $departmentcount=0;
  //           // $dutycount=0;
  //           $rowint = 2;
  //           $error_info = array();
  //           foreach ($ExamPaper_arr as $key => $value) 
  //           {
  //               //循环数据检测A=>教师姓名B=>角色=>电话号码=>IC卡号=>出生日期=>科室
  //               //如果题号或者题干不为空
  //               if(!empty($value['A'])||!empty($value['B'])){
  //                   $name=$value['A'];
  //                   $role=$value['B'];
  //                   $phone=$value['C'];
  //                   $card=$value['D'];
  //                   $date=$value['E'];
  //                   // $department=$value['F'];
  //                   $result=$this->importteacher(trim($name),trim($role),trim($phone),trim($card),trim($date),$type,$file_name,$rowint,$hl);
  //                   if($result ==1){
  //                       $successcount++;
  //                   }else if($result ==2){
  //                       // $updatecount++;
  //                   }else if($result==3){
  //                       $departmentcount++;
  //                   }else if($result==4){
  //                       // $dutycount++;
  //                   }else if($result==5){
  //                       // $departmentcount++;
  //                       // $dutycount++;
  //                   }else if ($result==-1){
  //                       // $emptyData = "有数据为空！";
  //                 $error_item = array(
  //                       "row"=>$rowint,
  //                       "msg"=>"必填数据未填写"
  //                   );
                    
  //                   array_push($error_info,$error_item);
  //                   }else if ($result==0){
  //                      $error_item = array(
  //                           "row"=>$rowint,
  //                           "msg"=>"姓名和电话重复"
  //                       );
  //                      array_push($error_info,$error_item);
  //                       // $row = $rowint-2;
  //                       // $this->error('有数据异常请重新插入,成功插入'.$row.'条数据');
  //                       // return false;
  //                   }
  //               }

  //               $rowint++;
  //              // var_dump($rowint);
                
  //           }
  //       }
      

  //        $emptyData = "";
  //       foreach ($error_info as &$error_item){
  //           $emptyData = $emptyData."第".($error_item["row"])."行".$error_item["msg"]."错误,";
  //       }
  //       var_dump($emptyData);
      

  //       if(!empty($emptyData)){
  //           $data_excel =  array(
  //                      'schoolid'=>$schoolid,
  //                      'filename'=>$file_name,
  //                       'type'=>$type,
  //                       'time'=>time(),
  //                       'pro'=>rtrim($emptyData, ","),
  //                       'status'=>1,
  //                       'state'=>2

  //                       );

  //         $teacher_excel = M('teacher_excel')->add($data_excel);
  //       }else{
  //           $data_excel =  array(
  //                      'schoolid'=>$schoolid,
  //                      'filename'=>$file_name,
  //                       'type'=>$type,
  //                       'time'=>time(),
  //                       'pro'=>'完美!',
  //                       'status'=>0,
  //                       'state'=>1,

  //                       );
  //           $teacher_excel = M('teacher_excel')->add($data_excel);
  //       }
  //       // exit();
      
  //       $info='::其中成功'.$successcount.'人,'.$emptyData;
  //       //var_dump($info);
  //       // exit();
  //     // var_dump($highestRow);
  //     // exit();
  //       // /$info='::其中,已在部门'.$departmentcount.'人,已在职务'.$dutycount.'人'.$emptyData."departmentcount".$departmentcount.trim($schoolid).trim($filename).trim($type).trim($status).trim($oper);
        
        
       

  //       $this->success('导入完成'.'共插入'.$successcount.'条数据');

       
            
          

  //         // $data_excel =  array(
  //         //              'schoolid'=>$schoolid,
  //         //              'filename'=>$file_name,
  //         //               'type'=>$type,
  //         //               'time'=>date("Y-m-d H:i:s"),
  //         //               'pro'=>'完美!',
  //         //               'status'=>0,

  //         //               );

  //         // $teacher_excel = M('teacher_excel')->add($data_excel);

  //      } 


  //      function importteacher($name,$role,$phone,$card,$date,$type,$filenmae,$rowint,$highestRow){
  //       $result=0;//0.失败，1新增，2更新
  //       $schoolid=$_SESSION['schoolid']; 
  //       // $ExamPaper_arr


  //       if(empty($name) || empty($phone)){
            
  //        // $data_excel =  array(
  //        //               'schoolid'=>$schoolid,
  //        //               'filename'=>$filenmae,
  //        //                'type'=>$type,
  //        //                'time'=>date("Y-m-d H:i:s"),
  //        //                'pro'=>'在第'.$rowint.'名字和手机有空缺',
  //        //                'status'=>1,

  //        //                );

  //        //  $teacher_excel = M('teacher_excel')->add($data_excel);


  //           $result = -1;

  //           return $result;

  //       }else{
         
  //           $departmentid=0;
  //           $dutyid=0;
  //           $userid=0;
  
  //            $data["name"]=$name;
  //           //$user=M('wxtuser')->where("name=$name1")->field('id')->find();
  //            $user=M('wxtuser')->where($data)->field('id')->find();
           
  //           $where['name'] = $name;
  //           $where['phone'] = $phone;

  //           $user = M('wxtuser')->where($where)->field('id')->find();
            
  //           if($user){
                
  //             // var_dump($rowint);
  //               // $data_excel =  array(
  //               //    'schoolid'=>$schoolid,
  //               //    'filename'=>$filenmae,
  //               //     'type'=>$type,
  //               //     'time'=>date("Y-m-d H:i:s"),
  //               //     'pro'=>'在第'.$rowint.'行有名字和手机重复',
  //               //     'status'=>1,
  //               //     );
  //               // $teacher_excel = M('teacher_excel')->add($data_excel);

  //               //  $result = 0;
  //               //return $result;
  //               }else{

               
  //                $data_users = array(
  //                     'schoolid'=>$schoolid,
  //                     'name'=>$name,
  //                     'phone'=>$phone,
  //                     'birthday'=>$date,
                     
  //                   );
  //                $rel=M('wxtuser')->add($data_users);
                 
  //                 //var_dump($rel);
                
  //               if($rel){
  //                   $data_info = array(
  //                       'teacherid'=>$rel,
  //                       'schoolid'=>$schoolid,
  //                       );

  //                $teacher_info = M('teacher_info')->add($data_info);

  //               }
  //              //如果卡号不为空
  //               if(!empty($card)&&!empty($rel)){

  //                   $data_card = array(                       
  //                      'personId'=>$rel,
  //                       'schoolid'=>$schoolid,
  //                       'cardNo'=>$card,
  //                       'create_time'=>time(),
  //                       'cardType'=>1,
  //                       'status'=>1,    
  //                   );
  //                   // var_dump($data_card);
  //                   // exit();
  //                   $student_card = M('student_card')->add($data_card);
                   
  //                  }

                     
  //                $result=1;
  //               }

  //       return $result;
    
  //   }
  // }

}