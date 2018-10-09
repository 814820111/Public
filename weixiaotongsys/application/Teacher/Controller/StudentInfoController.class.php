<?php

/**
 * 学生信息
 */

namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
header("Content-type: text/html; charset=utf-8");
class StudentInfoController extends TeacherbaseController {
		function _initialize() {
		parent::_initialize();
		$this -> school_model = D("Common/School");
		$this -> class_model = D("Common/school_class");
		$this -> class_relationship_model = D("Common/class_relationship");
		$this -> appellation_model = D("Common/appellation");
		$this -> wxtuser_model = D("Common/wxtuser");
		$this -> relation_stu_user_model = D("Common/relation_stu_user");
		$this -> relation_stu_class_model = D("Common/class_relationship");
            $this -> userid =$_SESSION['USER_ID'];
            $this -> schoolid =$_SESSION['schoolid'];
            $this -> level =$_SESSION['level'];

	}


	// public 
	public function index(){
		$schoolid=$_SESSION['schoolid'];
        $userid=$_SESSION['USER_ID'];

//        $level= $_SESSION['level'];

        //获取亲属关系
        $guanxi = M('appellation')->where("id>2")->select();
		//选择年级
		$grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
		//选择班级
		$class=M('school_class')->where("schoolid=$schoolid")->order("id asc")->select();
		//获取学生相关信息
		$where["c.schoolid"]=$schoolid;
		
       
        $search_grade = I("search_grade");
        $search_class = I("search_class");
        $search_student_name = I("student_name");
        $search_student_card = I("student_card");
        $search_ICcard = I("iccard");
         
        // var_dump($search_grade); 

        $search_phone = I("phone");
        if($search_grade && !$search_class){
            $this->assign("gradeinfo",$search_grade);
            
            $where_class['grade'] = $search_grade;
            $where_class['schoolid'] = $schoolid;

          
            
          $query_class = array();

            $school_class = M("school_class")->where($where_class)->field("id")->select();
           if($school_class)
           {

            foreach ($school_class as  $value) {
            	array_push($query_class, $value['id']);
            }
            
             $where['c.classid'] =array('in',$query_class);


       
            $join_grade = "wxt_school_class cs ON c.classid=cs.id";
           }else{
               $join_grade = "wxt_school_class cs ON c.classid=cs.id";
               $where['c.classid'] = '';
           }

         }
        if($search_class){
            $this->assign("classinfo",$search_class);
            $this->assign("gradeinfo",$search_grade);
            $where['c.classid'] = $search_class;
            $join = "wxt_school_class cs ON c.classid=cs.id";
        }
        if($search_student_name){
        	// var_dump($search_student_name);
            $this->assign("studentname",$search_student_name);
            $join_name = "wxt_wxtuser w ON c.userid=w.id";
            $where['w.name'] = array("LIKE","%".$search_student_name."%");
            // $join_name = "wxt_wxtuser w ON c.userid=w.id";
        }
        if ($search_student_card) {
            $this->assign("studentcard",$search_student_card);
            $where['stu_id'] = $search_student_card;
            $join = "wxt_student_info st ON c.userid=st.userid";
            // $field="c.*";
        }
        if($search_ICcard){
            $this->assign("searchiccard",$search_ICcard);
            $where['sc.cardNo'] = array("LIKE","%".$search_ICcard."%");
            $join_card = "wxt_student_card sc ON c.userid = sc.personId";
            $field="c.*";
            
        }
        if($search_phone){
            $this->assign("parent_phone",$search_phone);
            $where['wu.phone']=array("LIKE","%".$search_phone."%");;
            $join = "wxt_relation_stu_user rsu ON c.userid=rsu.studentid";
            $join_else="wxt_wxtuser wu ON rsu.userid=wu.id";
            $field="c.*";
        }



//         $appid = M("wxmanage")->where("schoolid = $schoolid")->getField("wx_appid");
        if($this -> level!=1  && $this -> level!=2)
        {
            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON c.classid=teacher.classid';

        }


        $count=M("class_relationship")
		->alias("c")
		->join($join)
        ->join($join_duty)
		->join($join_else)
		->join($join_name)
		->join($join_card)
		->where($where)
		->order("c.create_time DESC")  
		->count();

		$page = $this->page($count, 20);

		$student=M("class_relationship")
		->alias("c")->distinct(true)
		->join($join)
        ->join($join_duty)
		->join($join_else)
		->join($join_name)
		->join($join_card)
		->where($where)
		->field($field)
		->limit($page->firstRow . ',' . $page->listRows) 		// ->group("userid")
		->order("c.classid DESC")  // 添加分页
		->select();

//   $name = array();
//   foreach ($student as $k => $v) {
//   	if(!in_array($v['userid'], $name)){
//   		$name[] = $v['userid'];
//   		// $name[] = $v;
//   	}
//   }
//   var_dump($name);

// exit();
            //获取学校公众号的appid
        $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();

		foreach ($student as &$item) {
			//获取学生的所有班级
			// $where['k.schoolid'] = $schoolid
			// $where['k.userid'] = 
   //         $stu = M('class_relationship')->alias('k')->join("wxt_school_class d NO k.classid=d.id")->where()


			$s_id=$item["userid"];
			
			$classid=$item["classid"];

   //       //TOOD自己改造循环一个学生参加了哪几个班
   //        $where_d['k.schoolid'] = $schoolid;
			// $where_d['k.userid'] = $s_id;
   //         $student_subject=M("class_relationship")
   //      	->alias("k")
   //      	->join("wxt_school_class d ON k.classid=d.id ")
   //      	->where($where_d)
   //      	->field("d.classname,d.id as ids") 
   //      	->select();
   //      	//var_dump($student_subject);

	      
   //       //TOODO循环拼接字段
	  //     $student_idsu="";
	  //     $student_info="";
           
	        
	  //       foreach ($student_subject as $value) {
	  //       	$info = $value["classname"];
	  //       	$infos = $value["ids"];
	  //       	$student_info = $info.",".$student_info;
	  //       	$student_idsu = $infos.",".$student_idsu;
	  //       }
	  //       $item["student_classid"]=$student_idsu;
	  //       $item['student_subject'] = $student_info;

        
			//姓名
			$search_student_name=M("student_info")->field("stu_name as name")->where("userid=$s_id")->find();

			$item["student_name"]=$search_student_name["name"];
			//所在班级
			$classname=M("school_class")->where("id=$classid")->find();
      	
			$item["classname"]=$classname["classname"];
			//学号
            $stu_id = M("student_info")->where("userid=$s_id")->field("stu_id,sex,address,native_place,bindingkey")->find();
            $item["stu_id"] = $stu_id['stu_id'];
            $item["sex"] = $stu_id['sex'];
            $item["native_place"] = $stu_id['native_place'];
            $item["bindingkey"] = $stu_id['bindingkey'];

            //家庭住址
            $item["address"] = $stu_id['address'];
			//IC卡号
			$whiu['personId']=$s_id;
			$whiu['cardType']=0;
			$whiu['handletype'] = 1;
			$ICcard=M("student_card")->where($whiu)->find();
			$item["cardNo"]=$ICcard["cardno"];			
			//家长手机
			$where_phone["r.studentid"]=$s_id;
			$where_phone["r.type"] =1;

			$phone=M("relation_stu_user")->alias("r")->join("wxt_wxtuser w ON w.id=r.userid")->where($where_phone)->field("r.phone,r.userid")->find();

			$item["phone"]=$phone["phone"];

            $where_phones["r.studentid"]=$s_id;
            $phones=M("relation_stu_user")->alias("r")->join("wxt_wxtuser w ON w.id=r.userid")->where($where_phones)->field("r.phone,r.userid")->select();

	foreach ($phones as $valuell) {
        $one_parentid = $valuell['userid'];
        if ($one_parentid) {
//			$student_appid = M("xctuserwechat")->where("userid = $one_parentid and appid = $appid")->find();
            $student_appid = M("xctuserwechat")->where(array("userid" => $one_parentid, "appid" => $wxmanage['wx_appid']))->find();
            if($student_appid) {
                $item["appid"] = $student_appid['appid'];
                break;
            }
        }

    }
    //是否住校
            $in_residence = M("student_info")->where("userid=$s_id")->field("in_residence")->find();
            if($in_residence['in_residence'] == 1){
                $item['in_residence'] = '是';
            }elseif($in_residence['in_residence'] == 2){
                $item['in_residence'] = '否';
            }else{
                $item['in_residence']='不知道';
            }
			//学生组
            $in_group = M('student_info')->alias("s")->join("wxt_student_group w ON s.groupid=w.id")->field("w.group_name")->where("s.userid=$s_id")->find();
            $item["in_group"] = $in_group["group_name"];
			//服务是否开通
            $kaitong = M('student_card')->field('status')->where("personId=$s_id")->find();
            if($kaitong['status'] ==0){
                $item['kaitong'] = '否';
            } elseif ($kaitong['status'] ==1) {
                $item['kaitong'] = '是';
            }

            //获取学生分组
        	$student_department=M("department_teacher")->alias("d")->join("wxt_department w ON d.department_id=w.id")->where("d.teacher_id=$s_id")->field("w.name,w.id")->select();
           
        	$item["student_department"]=$student_department; 

           $department_list = "";
            foreach ($student_department as $key => $val) {
                $info_list = $val['name'];
                $department_list = $info_list.",".$department_list;
            }
            $item['department_list'] = $department_list;

            //拿取头像
            $item['photo'] = M("wxtuser")->where("id = $s_id")->getField('photo');
		}




		// $this->assign("Page", $page->show('Admin'));

		$this->assign("Page", $page->show('Admin'));

		$grop = M('department')->where("schoolid = $schoolid and status = 1")->select();

		  // $_SESSION['student_class']=$student;

		$this->assign("Page", $page->show('Admin'));

		$this->assign("class",$class);
		$this->assign("grade",$grade);
		$this->assign("grop",$grop);
		$this->assign("student",$student);
        $this->assign("guanxi",$guanxi);
        $this->assign("stu_qinshu",$student);
        $this->assign("schoolid",$schoolid);
		$this->display();
		//return $stuexp;
	}
	//家长的点击查询
	public function chaxuan(){
		$userid=I("userid");
		if($userid){
		$ICcard=M("student_card")->where("personId=$userid and cardType=2 and handletype = 1")->field("cardno,personId,id")->select();	
		echo json_encode(array('data'=>$ICcard,'message'=>'数据请求成功'));	
		}else{
		echo json_encode(array('data'=>'-1','message'=>'数据请求失败'));		
		}	
	}
	//家长卡的插入
	public function jiaadd(){
		$schoolid=$_SESSION['schoolid'];
		$userid=I("userid");
		//var_dump($userid);
		//获取传过来的卡号
		$class_card=I("class_card");


      
      
     // exit();
		
		// $ICcard=M("student_card")->where("personId=$userid and cardType=2")->delete();
		foreach ($class_card as &$cardNo) {
            $new_card = $cardNo['cardNo'];
            $old_card = $cardNo['old_card'];
            $where['cardNo']=$old_card;
            $where['personId']=$userid;
            $where['cardType']=2;
            $where['handletype'] = 1;
            //此处为删除标识
            if($new_card==1)
            {
                $save_card['handletype'] = 0;
                $save_card['handletime'] = time();
                $save_card['handletimeint'] = time();

                M("student_card")->where($where)->save($save_card);
                continue;
            }
            //如过新的卡号不为空
            if(!empty($new_card)){
            	
                

		        
               $cha = M('student_card')->where($where)->select();
                 //如果不存在则创建一条新的距离
	             if(!$cha )
	             {
		            $data["personId"]=$userid;
		            $data["cardNo"]=$new_card;
		            $data["schoolid"]=$schoolid;
		            $data["create_time"]=time();
		            $data['handletime'] = time();
		            $data['handletimeint'] = time();
		            $data['handletype'] = 1;
		            $data["cardType"]=2;

		             $card_add=M("student_card")->add($data);
		             var_dump($card_add);
	             }else{
	             	//否则将从前的卡号修改
                   $save_card['handletype'] = 0;  
                   $save_card['handletime'] = time();
            	   $save_card['handletimeint'] = time();

            	  $card_gai=M("student_card")->where($where)->save($save_card);
            

	            	if($card_gai)
	            	{
	            	 $card_addc['personId']=$userid;
	                 $card_addc['cardNo'] = $new_card;
	                 $card_addc['schoolid'] = $schoolid;
	                 $card_addc['create_time'] = time();
	                 $card_addc['handletime'] = time();
	                 $card_addc['handletimeint'] = time();
	                 $card_addc['handletype'] = 1;
	                 $card_addc['cardType'] = 2;
	            	 $creat_card = M('student_card')->add($card_addc); 
	            	
	            	 }

	             }  

                
            }
	
		}
		
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

    public function add_post(){
        //微校通用户信息表添加
        $schoolid = $_SESSION['schoolid'];
        $name=I("stu_name");//学生的名字
        $nicheng=I("nicheng");//学生的别名
        $sex= I('sex');//性别
        $nation=I("nation");//名族
        $native_place=I("native_place");//籍贯
        $address=I("address");//家庭住址
        $initdate=I("initdate");//入校时间
        $class=I("in_class");//班级ID 班级ID不能为空
        $in_group=I("in_group");//所属分组
        $in_residence=I("in_residence");//是否住校
        $ICcard=findNum(I("ICcard"));//IC卡号
        $str=$_POST['smeta']['thumb'];
             $arr=explode("/", $str);
             $photo=$arr[count($arr)-1];

        $appellation=I("appellation");//学生的亲属关系
        $parent_name=I("parent_name");//学生家长的名字
        $phone=findNum(I("parent_phone"));//家长的手机号码 家长号码必须填
        $charging_phone=findNum(I("koufei_phone"));//套餐的扣费号码、
          if($ICcard!=""){
           	 $lenfth=10-strlen($ICcard);
           	 $lastResult = ""; // 存储返回的结果
          for($i=0;$i<$lenfth;$i++){
          	$lastResult = "0" . $lastResult;
          }
          $ICcardsu=$lastResult.$ICcard; //10位的卡号
           }else{
           	$ICcardsu="";
           }

        if($name==""){
        	   $this->error("学生的名字不能为空！");
        }
        if($class==""){
        	$this->error("请选择学生的班级！");
        }
        if($phone==""){
        	$this->error("家长的号码不能为空！");
        }

        $where["stu_name"]=$name;
       $info_name=M("student_info")->where($where)->field("userid")->select();

        $show_student = get_student($schoolid,$name,$phone);

        if(!$show_student['status'])
        {

            $this->error($show_student['error']);
            exit();
        }
        if($ICcard) {

            $show_Card = get_showcard($ICcard, $schoolid);

            if ($show_Card) {

                $this->error("卡号已经存在");
                exit();
            }
        }
       	//插入学生
       	 if($photo!=""){
       	 	$data["photo"]=$photo;
       	 }
       	 $data=array(
							'schoolid'=>$schoolid,
							'name'=>$name,
							'sex'=>$sex,
							'photo'=>$photo,
							'password'=>md5('123456'),
							'status'=>'1',
							'user_type'=>'1',
							'create_time'=>time()
					);
			$userid=M("wxtuser")->add($data);
		//插入班级关系
           if($parent_name==""){
               $parent_name=$name."家长"	;
           }
		if($userid){
			$classdata=array(
							"schoolid"=>$schoolid,
							"classid"=>$class,
							"userid"=>$userid,
							"create_time"=>time()
		              );
		        $classiduiid=M("class_relationship")->add($classdata);
		//插入学生wxt_student_info；
		        $bindingkey=rand(100000,999999);//获取随机的登录码
		        $stu_id = date("Y").$userid;//获取学生的学号
		         $student_infodata=array(
		                 "stu_id"=>$stu_id,
		                 "in_residence"=>$in_residence,
		                 "initdate"=>$initdate,
		                 "address"=>$address,
		                 "nation"=>$nation,
		                 "native_place"=>$native_place,
		                 "sex"=>$sex,
		                 "schoollid"=>$schoolid,
						"classid"=>$class,
						"userid"=>$userid,
						"nicheng"=>$nicheng,
						"stu_name"=>$name,
						"ICcard"=>$ICcardsu,
						"bindingkey"=>$bindingkey,
						"groupid"=>$in_group,
						"create_time"=>time()
		         );

		         $student_info=M("student_info")->add($student_infodata);

		        //生成对应的家长信息
		        $wheres["phone"]=$phone;
		        $wheres["type"]=1;
		        $relatives=M("relation_stu_user")->where($wheres)->field("userid")->select(); //通过号码查询对应的家长
		          if(!$relatives){

		          	$datas=array(
							'schoolid'=>$schoolid,
							'name'=>$parent_name,
							'phone'=>$phone,
							'sex'=>$sex,
							'password'=>md5('123456'),
							'status'=>'1',
							'user_type'=>'1',
							'create_time'=>time()
					);
					$parentid=M("wxtuser")->add($datas);
					if($parentid){

						$redata=array(
							"studentid"=>$userid,
							"userid"=>$parentid
						);
						    $redata['charging_phone']=$charging_phone;//扣费号码
					        $redata['time']=time();
							$redata['appellation']=!$appellation?"家长":$appellation;
							$redata['name']=$parent_name;
							$redata['relation_rank']=1;
							$redata['type']=1;
							$redata['preferred']=1;
							$redata['phone']=$phone;
						$rt = M("relation_stu_user")->add($redata);
					}
		          }else{
		          $useridiu=	$relatives["0"]["userid"];
						$redata=array(
							"studentid"=>$userid,
							"userid"=>$useridiu
						);
						$redata['charging_phone']=$charging_phone;//扣费号码
						$redata['appellation']=$appellation;
							$redata['relation_rank']=$parent_name;
							$redata['name']=$parent_name;
							$redata['type']=1;
							$redata['preferred']=1;
							$redata['phone']=$phone;
							$redata['time']=time();
						$rt = M("relation_stu_user")->add($redata);
		          }

		            //写入卡表TODO可能需要完善
		         if($ICcard){



			     		$carddata['cardNo']=$ICcardsu;
					    $iscard=M('student_card')->where($carddata)->find();
					    if(!$iscard){
					            $carddata['imgUrl'] = $_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'];
					            $carddata['name'] =$name;
					            $carddata['create_time'] = time();
					            $carddata['handletime'] = date('Y-m-d H:i:s',time());
					            $carddata['handletimeint'] = time();
								$carddata['personId']=$userid;
								$carddata['schoolid']=$schoolid;
								$carddata['classid']=$class;
								$carddata['create_time']=time();
								$carddata['cardType']=0;
								$carrs=M('student_card')->add($carddata);
					    }
			     }
                  $this->success("数据添加成功");
		      }else{
            $this->eroor("数据添加有误！");
        }




    }

//	public function add_post(){
//        //微校通用户信息表添加
//        $schoolid = $_SESSION['schoolid'];
//        $name=I("stu_name");//学生的名字
//        $nicheng=I("nicheng");//学生的别名
//        $sex= I('sex');//性别
//        $nation=I("nation");//名族
//        $native_place=I("native_place");//籍贯
//        $address=I("address");//家庭住址
//        $initdate=I("initdate");//入校时间
//        $class=I("in_class");//班级ID 班级ID不能为空
//        $in_group=I("in_group");//所属分组
//        $in_residence=I("in_residence");//是否住校
//        $ICcard=I("ICcard");//IC卡号
//        $str=$_POST['smeta']['thumb'];
//             $arr=explode("/", $str);
//             $photo=$arr[count($arr)-1];
//
//        $appellation=I("appellation");//学生的亲属关系
//        $parent_name=I("parent_name");//学生家长的名字
//        $phone=I("parent_phone");//家长的手机号码 家长号码必须填
//        $charging_phone=I("koufei_phone");//套餐的扣费号码、
//          if($ICcard!=""){
//           	 $lenfth=10-strlen($ICcard);
//           	 $lastResult = ""; // 存储返回的结果
//          for($i=0;$i<$lenfth;$i++){
//          	$lastResult = "0" . $lastResult;
//          }
//          $ICcardsu=$lastResult.$ICcard; //10位的卡号
//           }else{
//           	$ICcardsu="";
//           }
//
//        if($name==""){
//        	   $this->error("学生的名字不能为空！");
//        }
//        if($class==""){
//        	$this->error("请选择学生的班级！");
//        }
//        if($phone==""){
//        	$this->error("家长的号码不能为空！");
//        }
//
//        $where["stu_name"]=$name;
//       $info_name=M("student_info")->where($where)->field("userid")->select();
//       if(!$info_name){
//       	//插入学生
//       	 if($photo!=""){
//       	 	$data["photo"]=$photo;
//       	 }
//       	 $data=array(
//							'schoolid'=>$schoolid,
//							'name'=>$name,
//							'sex'=>$sex,
//							'photo'=>$photo,
//							'password'=>md5('123456'),
//							'status'=>'1',
//							'user_type'=>'1',
//							'create_time'=>time()
//					);
//			$userid=M("wxtuser")->add($data);
//		//插入班级关系
//           if($parent_name==""){
//               $parent_name=$name."家长"	;
//           }
//		if($userid){
//			$classdata=array(
//							"schoolid"=>$schoolid,
//							"classid"=>$class,
//							"userid"=>$userid,
//							"create_time"=>time()
//		              );
//		        $classiduiid=M("class_relationship")->add($classdata);
//		//插入学生wxt_student_info；
//		        $bindingkey=rand(100000,999999);//获取随机的登录码
//		        $stu_id = date("Y").$userid;//获取学生的学号
//		         $student_infodata=array(
//		                 "stu_id"=>$stu_id,
//		                 "in_residence"=>$in_residence,
//		                 "initdate"=>$initdate,
//		                 "address"=>$address,
//		                 "nation"=>$nation,
//		                 "native_place"=>$native_place,
//		                 "sex"=>$sex,
//		                 "schoollid"=>$schoolid,
//						"classid"=>$class,
//						"userid"=>$userid,
//						"nicheng"=>$nicheng,
//						"stu_name"=>$name,
//						"ICcard"=>$ICcardsu,
//						"bindingkey"=>$bindingkey,
//						"groupid"=>$in_group,
//						"create_time"=>time()
//		         );
//
//		         $student_info=M("student_info")->add($student_infodata);
//
//		        //生成对应的家长信息
//		        $wheres["phone"]=$phone;
//		        $wheres["type"]=1;
//		        $relatives=M("relation_stu_user")->where($wheres)->field("userid")->select(); //通过号码查询对应的家长
//		          if(!$relatives){
//
//		          	$datas=array(
//							'schoolid'=>$schoolid,
//							'name'=>$parent_name,
//							'phone'=>$phone,
//							'sex'=>$sex,
//							'password'=>md5('123456'),
//							'status'=>'1',
//							'user_type'=>'1',
//							'create_time'=>time()
//					);
//					$parentid=M("wxtuser")->add($datas);
//					if($parentid){
//
//						$redata=array(
//							"studentid"=>$userid,
//							"userid"=>$parentid
//						);
//						    $redata['charging_phone']=$charging_phone;//扣费号码
//					        $redata['time']=time();
//							$redata['appellation']=$appellation;
//							$redata['name']=$parent_name;
//							$redata['relation_rank']=1;
//							$redata['type']=1;
//							$redata['preferred']=1;
//							$redata['phone']=$phone;
//						$rt = M("relation_stu_user")->add($redata);
//					}
//		          }else{
//		          $useridiu=	$relatives["0"]["userid"];
//						$redata=array(
//							"studentid"=>$userid,
//							"userid"=>$useridiu
//						);
//						$redata['charging_phone']=$charging_phone;//扣费号码
//						$redata['appellation']=$appellation;
//							$redata['relation_rank']=$parent_name;
//							$redata['name']=$parent_name;
//							$redata['type']=1;
//							$redata['preferred']=1;
//							$redata['phone']=$phone;
//							$redata['time']=time();
//						$rt = M("relation_stu_user")->add($redata);
//		          }
//
//		            //写入卡表TODO可能需要完善
//		         if($ICcard){
//			     		$carddata['cardNo']=$ICcardsu;
//					    $iscard=M('student_card')->where($carddata)->find();
//					    if(!$iscard){
//					            $carddata['imgUrl'] = $_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'];
//					            $carddata['name'] =$name;
//					            $carddata['create_time'] = time();
//					            $carddata['handletime'] = date('Y-m-d H:i:s',time());
//					            $carddata['handletimeint'] = time();
//								$carddata['personId']=$userid;
//								$carddata['schoolid']=$schoolid;
//								$carddata['classid']=$class;
//								$carddata['create_time']=time();
//								$carddata['cardType']=0;
//								$carrs=M('student_card')->add($carddata);
//					    }else{
//					    	  $ka="该学生已经加入 但是卡号已经存在 请在学生管理列表进行重新设置卡号;";
//					    }
//			     }
//		      }
//       }else{
//       	    $wheres["phone"]=$phone;
//		    $wheres["type"]=1;
//		    $relatives=M("relation_stu_user")->where($wheres)->field("userid")->select(); //通过号码查询对应的家长
//		    if(!$relatives){
//		    	            	 $data=array(
//							'schoolid'=>$schoolid,
//							'name'=>$name,
//							'sex'=>$sex,
//							'photo'=>$photo,
//							'password'=>md5('123456'),
//							'status'=>'1',
//							'user_type'=>'1',
//							'create_time'=>time()
//					);
//			         $userid=M("wxtuser")->add($data);
//
//			    if($parent_name==""){
//		          	 	$parent_name=$name."家长"	;
//		          	 }
//		          	$datas=array(
//							'schoolid'=>$schoolid,
//							'name'=>$parent_name,
//							'sex'=>$sex,
//							'phone'=>$phone,
//							'password'=>md5('123456'),
//							'status'=>'1',
//							'user_type'=>'1',
//							'create_time'=>time()
//					);
//					$parentid=M("wxtuser")->add($datas);
//			if($userid!="" && $parentid!="" ){
//                   $dep = array(
//                        "school_id"=>$schoolid,
//                        "department_id"=>$in_group,
//                        "teacher_id"=>$userid
//                   	);
//
//                 $department = M('department_teacher')->add($dep);
//
//				  $classdata=array(
//							"schoolid"=>$schoolid,
//							"classid"=>$class,
//							"userid"=>$userid,
//							"create_time"=>time()
//		              );
//		        $classiduiid=M("class_relationship")->add($classdata);
//		        //插入学生wxt_student_info；
//		        $bindingkey=rand(100000,999999);//获取随机的登录码
//		        $stu_id = date("Y").$userid;//获取学生的学号
//		         $student_infodata=array(
//		                 "stu_id"=>$stu_id,
//		                 "in_residence"=>$in_residence,
//		                 "initdate"=>$initdate,
//		                 "address"=>$address,
//		                 "nation"=>$nation,
//		                 "native_place"=>$native_place,
//		                 "sex"=>$sex,
//		                 "schoollid"=>$schoolid,
//						"classid"=>$class,
//						"userid"=>$userid,
//						"nicheng"=>$nicheng,
//						"stu_name"=>$name,
//						"ICcard"=>$ICcardsu,
//						"bindingkey"=>$bindingkey,
//						"groupid"=>$in_group,
//						"create_time"=>time()
//		         );
//		          $student_info=M("student_info")->add($student_infodata);
//		           		$redata=array(
//							"studentid"=>$userid,
//							"userid"=>$parentid
//						);
//						$redata['charging_phone']=$charging_phone;//扣费号码
//					        $redata['time']=time();
//							$redata['appellation']=$appellation;
//							$redata['name']=$parent_name;
//							$redata['relation_rank']=1;
//							$redata['type']=1;
//							$redata['preferred']=1;
//							$redata['phone']=$phone;
//						$rt = M("relation_stu_user")->add($redata);
//
//			     if($ICcard){
//			     		$carddata['cardNo']=$ICcardsu;
//					    $iscard=M('student_card')->where($carddata)->find();
//					    if(!$iscard){
//					    	//写入卡表
//					    	    $carddata['imgUrl'] = $_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'];
//					            $carddata['name'] =$name;
//					            $carddata['create_time'] = time();
//					            $carddata['handletime'] = date('Y-m-d H:i:s',time());
//					            $carddata['handletimeint'] = time();
//								$carddata['personId']=$userid;
//								$carddata['schoolid']=$schoolid;
//								$carddata['classid']=$class;
//								$carddata['cardType']=0;
//								$carddata['create_time']=time();
//								$carrs=M('student_card')->add($carddata);
//					    }else{
//					    	   $ka="该学生已经加入 但是卡号已经存在 请在学生管理列表进行重新设置卡号;";
//					    }
//			      }
//			}
//		    }else{
//		    	   $fail="该数据重复添加失败；请根据在根据学生的真实信息进行填写";
//		    }
//       }
//       $panduan=$fail.$ka;
//       if($panduan!=""){
//       	$this->error($fail.$ka);
//       }else{
//       	$this->success("数据添加成功");
//       }
//
//    }
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

    public function delete(){
        $id =intval(I('id'));
        if($id){
            $wheres['studentid']=$id;
            $wheres['type']=1;
            $select=M("relation_stu_user")->where($wheres)->field("userid")->select();
            $where["userid"]=$select["0"]["userid"];
            $count=M("relation_stu_user")->where($where)->count();
            $res1 = M('relation_stu_user')->where("studentid=$id")->delete();
            $wherere['personId']=$id;
            $wherere['cardType']=0;
            $wherere['schoolid'] = $_SESSION['schoolid'];

            $res2 = M('student_card')->where($wherere)->delete();
            $res3 = M('student_info')->where("userid=$id")->delete();
            $res4 = M('class_relationship')->where("userid=$id")->delete();
           if($count==1){
           	$rst1 = M('wxtuser')->where($where)->delete();
           }           
            $rst = M('wxtuser')->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }else{
            $this->error("未获取到数据");
        }
    }
    public function updateICcard(){
       	$schoolid=$_SESSION['schoolid'];
       	//新的卡号
        $newCardNo = I('cardNo');
        //旧的学生卡
        $oldCardNo = I('stu_old_card');
     
        $ids=I('userid');
      
       $where['cardno']=$oldCardNo;
       $where['personId']=$ids;
       $where['cardType']=0;
       $where['handletype'] = 1;

        $showcard = get_showcard($newCardNo,$schoolid);

        //默认成功
        $info['status'] = true;

      //查询新的卡号是否已经被使用
        if($showcard)
        {
            $info['status'] = false;
            $info['info'] = '卡号已经被使用!';
            echo json_encode($info);
            die();
        }

       
        if($ids){


           $cha=M("student_card")->where($where)->select();	
          
          if(!$cha){

//                $showcard = get_showcard($newCardNo,0);
//
//
//
//
//
////              dump($showcard);


                    $data["personId"]=$ids;
                    $data["cardNo"]=$newCardNo;
                    $data["schoolid"]=$schoolid;
                    $data["create_time"]=time();
                    $data['handletime'] = date("Y-m-d H:i:s",time());
                    $data['handletimeint'] = time();
                    $data['handletype'] = 1;
                    $data["cardType"]=0;
                    //echo "dsadsa";
                    $card_add=M("student_card")->add($data);


            }else{
            	//将原来的表修改并添加替换添加时间并将状态改为删除 ,然后再新增一条card表的记录

            	  $save_card['handletype'] = 0;  
                  $save_card['handletime'] = date("Y-m-d H:i:s",time());
            	  $save_card['handletimeint'] = time();

            	 $card_gai=M("student_card")->where($where)->save($save_card);
            	 // var_dump($card_gai);

            	 if($card_gai){
                 
                 $card_addc['personId']=$ids;
                 $card_addc['cardNo'] = $newCardNo;
                 $card_addc['schoolid'] = $schoolid;
                 $card_addc['create_time'] = time();
                 $data['handletime'] = date("Y-m-d H:i:s",time());
                 $card_addc['handletimeint'] = time();
                 $card_addc['handletype'] = 1;
                 $card_addc['cardType'] = 0;
            	 $creat_card = M('student_card')->add($card_addc); 
            	}

              
            }
            update_card(0,$ids,$schoolid);
	   
        }else{
             $this->error("未获取到数据！");
        }
        echo json_encode($info);
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

    public function stumange(){
    
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
		$where["c.schoolid"]=$schoolid;

        //搜索学生条件
        $search_grade = I("search_grade");
        $search_class = I("search_class");
        $search_student_name = I("student_name");
        $search_student_card = I("student_card");
        $search_ICcard = I("iccard");
        $search_phone = I("phone");
        if($search_grade){
            $this->assign("gradeinfo",$search_grade);
            $where['grade'] = $search_grade;
            $join = "wxt_school_class cs ON c.classid=cs.id";
         }
        if($search_class){
            $this->assign("classinfo",$search_class);
            $where['c.classid'] = $search_class;
            $join = "wxt_school_class cs ON c.classid=cs.id";
        }
        if($search_student_name){
            $this->assign("studentname",$search_student_name);
            $where['w.name'] = array("LIKE","%".$search_student_name."%");;
            $join = "wxt_wxtuser w ON c.userid=w.id";
        }
        if ($search_student_card) {
            $this->assign("studentcard",$search_student_card);
            $where['stu_id'] = $search_student_card;
            $join = "wxt_student_info st ON c.userid=st.userid";
        }
        if($search_ICcard){
            $this->assign("searchiccard",$search_ICcard);
            $where['cardNo'] = $search_ICcard;
            $join = "wxt_student_card sc ON c.userid = sc.personId";
        }
        if($search_phone){
            $this->assign("parent_phone",$search_phone);
            $where['wu.phone']=array("LIKE","%".$search_phone."%");;
            $join = "wxt_relation_stu_user rsu ON c.userid=rsu.studentid";
            $join_else="wxt_wxtuser wu ON rsu.userid=wu.id";
            $field="c.*";
        }

        if($level!=1  && $level!=2)
        {
            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON c.classid=teacher.classid';
        }
        $count=M("class_relationship")
		->alias("c")
		->join($join)
        ->join($join_duty)
		->join($join_else)
		->where($where)
		->order("c.create_time DESC")  
		->count();
		$page = $this->page($count, 20);
	   			
		$student=M("class_relationship")
		->alias("c")->distinct(true)
		->join($join)
        ->join($join_duty)
		->join($join_else)
		->where($where)
		->field($field)
		->limit($page->firstRow . ',' . $page->listRows) 		
		 ->group("userid")
		->order("c.classid DESC")  // 添加分页
		->select();
		//var_dump($student);


//   $name = array();
//   foreach ($student as $k => $v) {
//   	if(!in_array($v['userid'], $name)){
//   		$name[] = $v['userid'];
//   		// $name[] = $v;
//   	}
//   }
//   var_dump($name);

// exit();


		foreach ($student as &$item) {
			//获取学生的所有班级
			// $where['k.schoolid'] = $schoolid
			// $where['k.userid'] = 
   //         $stu = M('class_relationship')->alias('k')->join("wxt_school_class d NO k.classid=d.id")->where()


			$s_id=$item["userid"];
			
			$classid=$item["classid"];

   //       //TOOD自己改造循环一个学生参加了哪几个班
          $where_d['k.schoolid'] = $schoolid;
			$where_d['k.userid'] = $s_id;
           $student_subject=M("class_relationship")
        	->alias("k")
        	->join("wxt_school_class d ON k.classid=d.id ")
        	->where($where_d)
        	->field("d.classname,d.id as ids") 
        	->select();
         	//var_dump($student_subject);

	      
   //       //TOODO循环拼接字段
	      $student_idsu="";
	      $student_info="";

	        
	        foreach ($student_subject as $value) {
	        	$info = $value["classname"];
	        	$infos = $value["ids"];
	        	$student_info = $info.",".$student_info;
	        	$student_idsu = $infos.",".$student_idsu;
	        }
	        $item["student_classid"]=$student_idsu;
	        $item['student_subject'] = $student_info;

        
			//姓名
			$search_student_name=M("student_info")->field("stu_name as name")->where("userid=$s_id")->find();
			//var_dump($search_student_name);
			$item["student_name"]=$search_student_name["name"];
			//所在班级
			$classname=M("school_class")->where("id=$classid")->find();
            // var_dump($classname);
			$item["classname"]=$classname["classname"];
			//学号
            $stu_id = M("student_info")->where("userid=$s_id")->field("stu_id")->find();
            $item["stu_id"] = $stu_id['stu_id'];
			//IC卡号
			$whiu['personId']=$s_id;
			$whiu['cardType']=0;
			$ICcard=M("student_card")->where($whiu)->find();
			$item["cardNo"]=$ICcard["cardno"];			
			//家长手机
			$where_phone["r.studentid"]=$s_id;
			// $where_phone["r.type"]=1;
			$phone=M("relation_stu_user")->alias("r")->join("wxt_wxtuser w ON w.id=r.userid")->where($where_phone)->field("w.phone")->find();
			$item["phone"]=$phone["phone"];
			//是否住校
            $in_residence = M("student_info")->where("userid=$s_id")->field("in_residence")->find();
            if($in_residence['in_residence'] == 0){
                $item['in_residence'] = '是';
            }elseif($in_residence['in_residence'] == 1){
                $item['in_residence'] = '否';
            }else{
                $item['in_residence']='不知道';
            }
			//学生组
            $in_group = M('student_info')->alias("s")->join("wxt_student_group w ON s.groupid=w.id")->field("w.group_name")->where("s.userid=$s_id")->find();
            $item["in_group"] = $in_group["group_name"];
			//服务是否开通
            $kaitong = M('student_card')->field('status')->where("personId=$s_id")->find();
            if($kaitong['status'] ==0){
                $item['kaitong'] = '否';
            } elseif ($kaitong['status'] ==1) {
                $item['kaitong'] = '是';
            }
             //获取学生分组
        	$student_department=M("department_teacher")->alias("d")->join("wxt_department w ON d.department_id=w.id")->where("d.teacher_id=$s_id")->field("w.name,w.id")->select();
           
        	$item["student_department"]=$student_department; 
		}
      
        //var_dump($student);
        //将获取到的学生信息保存到seession中
        $grop = M('department')->where("schoolid = $schoolid and status = 1")->select();
        $_SESSION['student_info']=$student;
		 $this->assign("Page", $page->show('Admin'));
		$this->assign("class",$class);
		$this->assign("grade",$grade);
		$this->assign("grop",$grop);
		$this->assign("student",$student);
		//var_dump($student);
        $this->assign("guanxi",$guanxi);
        $this->assign("stu_qinshu",$student);
        $this->display();
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
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), ' '.$expTableData[$i][$expCellName[$j][0]]);
              }             
            }  
            
            header('pragma:public');
            header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
            header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
            $objWriter = \ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
            $objWriter->save('php://output'); 
    
            exit;   
             
    }


  public function expUser()
  {

    	$schoolid=$_SESSION['schoolid'];
    	// var_dump($schoolid);
    	// exit();
        //获取亲属关系
        $guanxi = M('appellation')->where("id>2")->select();
		//选择年级
		$grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
		//选择班级
		$class=M('school_class')->where("schoolid=$schoolid")->order("id asc")->select();
		//获取学生相关信息
		$where["c.schoolid"]=$schoolid;
		
       
        $search_grade = I("search_grade");
  
        $search_class = I("search_class");
  
        $search_student_name = I("student_name");
     
        $search_student_card = I("student_card");
        
     

        $search_phone = I("phone");

        if($search_grade && !$search_class){
            $this->assign("gradeinfo",$search_grade);
            $where['grade'] = $search_grade;
            $join_grade = "wxt_school_class cs ON c.classid=cs.id";
         }
        if($search_class){
            $this->assign("classinfo",$search_class);
            $this->assign("gradeinfo",$search_grade);
            $where['c.classid'] = $search_class;
            $join = "wxt_school_class cs ON c.classid=cs.id";
        }
        if($search_student_name){
        	// var_dump($search_student_name);
            $this->assign("studentname",$search_student_name);
            $join_name = "wxt_wxtuser w ON c.userid=w.id";
            $where['w.name'] = array("LIKE","%".$search_student_name."%");;
            // $join_name = "wxt_wxtuser w ON c.userid=w.id";
        }
        if ($search_student_card) {
            $this->assign("studentcard",$search_student_card);
            $where['stu_id'] = $search_student_card;
            $join = "wxt_student_info st ON c.userid=st.userid";
            // $field="c.*";
        }
        if($search_ICcard){
            $this->assign("searchiccard",$search_ICcard);
            $where['sc.cardNo'] = array("LIKE","%".$search_ICcard."%");
            $join_card = "wxt_student_card sc ON c.userid = sc.personId";
            $field="c.*";
            
        }
        if($search_phone){
            $this->assign("parent_phone",$search_phone);
            $where['wu.phone']=array("LIKE","%".$search_phone."%");;
            $join = "wxt_relation_stu_user rsu ON c.userid=rsu.studentid";
            $join_else="wxt_wxtuser wu ON rsu.userid=wu.id";
            $field="c.*";
        }

      if($this -> level!=1  && $this -> level!=2)
      {
          $where['teacher.schoolid'] = $schoolid;
          $where['teacher.teacherid'] = $this -> userid;
          $join_duty = 'wxt_teacher_class teacher ON c.classid=teacher.classid';

      }
		
	
	   			
		$student=M("class_relationship")
		->alias("c")->distinct(true)
		->join($join)
		->join($join_else)
		->join($join_name)
		->join($join_card)
        ->join($join_duty)
		->where($where)
		->field($field)		// ->group("userid")
		->order("c.classid DESC")  // 添加分页
		->select();
// var_dump($student);



//   $name = array();
//   foreach ($student as $k => $v) {
//   	if(!in_array($v['userid'], $name)){
//   		$name[] = $v['userid'];
//   		// $name[] = $v;
//   	}
//   }
//   var_dump($name);

// exit();


		foreach ($student as &$item) {
			//获取学生的所有班级
			// $where['k.schoolid'] = $schoolid
			// $where['k.userid'] = 
   //         $stu = M('class_relationship')->alias('k')->join("wxt_school_class d NO k.classid=d.id")->where()


			$s_id=$item["userid"];
			
			$classid=$item["classid"];



        
			//姓名
			$search_student_name=M("wxtuser")->field("name")->where("id=$s_id")->find();
			//var_dump($search_student_name);
			$item["student_name"]=$search_student_name["name"];
			//所在班级
			$classname=M("school_class")->where("id=$classid")->find();
      	
			$item["classname"]=$classname["classname"];
			//学号
            $stu_id = M("student_info")->where("userid=$s_id")->field("stu_id,sex,address,native_place,bindingkey")->find();
            $item["stu_id"] = $stu_id['stu_id'];
            $item["sex"] = $stu_id['sex']==0?"女":"男";
            $item["native_place"] = $stu_id['native_place'];
            $item["bindingkey"] = $stu_id['bindingkey'];

            //家庭住址
            $item["address"] = $stu_id['address'];
			//IC卡号
			$whiu['personId']=$s_id;
			$whiu['cardType']=0;
			$whiu['handletype'] = 1;
			$ICcard=M("student_card")->where($whiu)->find();
			$item["cardNo"]=$ICcard["cardno"];			
			//家长手机
			$where_phone["r.studentid"]=$s_id;
			$where_phone["r.type"] =1;
			// $where_phone["r.type"]=1;
			$phone=M("relation_stu_user")->alias("r")->join("wxt_wxtuser w ON w.id=r.userid")->where($where_phone)->field("w.phone")->find();
			$item["phone"]=$phone["phone"];
			//是否住校
            $in_residence = M("student_info")->where("userid=$s_id")->field("in_residence")->find();
            if($in_residence['in_residence'] == 1){
                $item['in_residence'] = '是';
            }elseif($in_residence['in_residence'] == 2){
                $item['in_residence'] = '否';
            }else{
                $item['in_residence']='不知道';
            }
			//学生组
            $in_group = M('student_info')->alias("s")->join("wxt_student_group w ON s.groupid=w.id")->field("w.group_name")->where("s.userid=$s_id")->find();
            $item["in_group"] = $in_group["group_name"];
			//服务是否开通
            $kaitong = M('student_card')->field('status')->where("personId=$s_id")->find();
            if($kaitong['status'] ==0){
                $item['kaitong'] = '否';
            } elseif ($kaitong['status'] ==1) {
                $item['kaitong'] = '是';
            }

		}

		// $this->assign("Page", $page->show('Admin'));

	// var_dump($student);
	// exit();

  $xlsName  = "User";

	$xlsCell  = array(

                array('student_name','学生姓名'),
                
                array('sex','性别'),
                                  

                array('stu_id','学号'),

                array('cardNo','IC卡号'),

                array('phone','家长电话'),

                array('in_residence','是否住校'),

                array('classname','班级'),


                array('bindingkey','微信绑定码'),

                array('kaitong','服务是否开通'),

                );
                //接收保存在SESSION的值
                $xlsData = $student;



                $fileNames =  get_schoolname($schoolid).'-'.'学生数据导出';
                	
       
      
        
            $result =     $this->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);
       



  
          
  }







      // public function expUser(){//导出Excel
                    
      //     $student_info=$_SESSION['student_info'];

       



      //           $xlsName  = "User";

      //           $xlsCell  = array(

      //           array('student_name','学生姓名'),

      //           array('stu_id','学号'),

      //           array('cardNo','IC卡号'),

      //           array('phone','家长电话'),

      //           array('in_residence','是否住校'),

      //           array('student_subject','班级'),

      //           array('kaitong','服务是否开通'),

      //           );
      //           //接收保存在SESSION的值
      //           $xlsData = $student_info;

      //           $fileNames =  '学生信息'.date('_YmdHis');
        
      //           $this->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);
                     
      //   }


         public function stuUser(){//导出Excel
                    
          // $student_class=$_SESSION['student_class'];
          //var_dump($student_class);
        //	  exit();
         $schoolid = $_SESSION['schoolid'];	
         var_dump($schoolid);
          $gradeid = I('gradeid');
       
         var_dump($gradeid);
          $classid = I('classid');
          var_dump($classid);
          exit();
      

          $where['c.schoolid'] = $schoolid;
      

         if($gradeid && !$classid)
         {
         	
         	$where_g['c.grade'] = $gradeid;
         	$where_g['c.schoolid'] = $schoolid;

             $student_name =  M('school_class')->alias('c')->where($where_g)->field("id")->select();

             $g_classid = "";
             
             foreach ($student_name as $key => $value) {
             	// var_dump($value);
             	
             	$cc_classid = $value['id'];
             	 $g_classid = $cc_classid.",".$g_classid;

                $student = M("student_info")->where("classid = $cc_classid")->select();
             	
             	      
             
             }
             rtrim($g_classid,",");
             // exit();
             $where['c.classid'] = array("in",$g_classid);
             $student_name =  M('class_relationship')->alias('c')->where($where)->join('wxt_student_info s ON c.userid=s.userid')->join("wxt_school_class sc ON c.classid = sc.id")->field('c.userid,s.stu_name,s.classid,sc.classname,s.stu_id,s.in_residence')->select();
           

         }
        

         if($classid )
         { 
              
         	$where['c.classid'] = $classid;
         	$student_name =  M('class_relationship')->alias('c')->where($where)->join('wxt_student_info s ON c.userid=s.userid')->join("wxt_school_class sc ON c.classid = sc.id")->field('c.userid,s.stu_name,s.classid,sc.classname,s.stu_id,s.in_residence')->select();
         	 

         }
         // $school_class =  
         $where['c.schoolid'] = $schoolid;

         // $student_name =  M('class_relationship')->alias('c')->where($where)->join('wxt_student_info s ON c.userid=s.userid')->join("wxt_school_class sc ON c.classid = sc.id")->field('c.userid,s.stu_name,s.classid,sc.classname,s.stu_id,s.in_residence')->select();
      

         if(!$student_name)
         {
         	$this->error('数据不存在!');
         }

         foreach ($student_name as $key => &$value) {
         	$userid = $value['userid'];

         	$card = M("student_card")->where("cardType = 0 and handletype = 1 and personId = $userid")->field("cardno,status")->find();

         	$parent = M("relation_stu_user")->where("studentid = $userid and type = 1")->field("phone")->find();
         	// var_dump($parent);

            if($kaitong['status'] ==0){
                $value['kaitong'] = '否';
            } elseif ($kaitong['status'] ==1) {
                $value['kaitong'] = '是';
            }
             if($kaitong['in_residence'] ==1){
                $value['in_residence'] = '是';
            } elseif ($kaitong['in_residence'] ==1) {
                $value['in_residence'] = '否';
            }
               
           $value['cardno'] = $card['cardno'];
           $value['phone'] = $parent['phone'];
          
         }


         // var_dump($student_name);
         // exit();

         // foreach ($student_name as $key => $value) {
         // 	# code...
         // }
         // var_dump($student_name);

        //            $re  = $this->index(stuexp);
        //            var_dump($re); 

        //  	echo "Dasd";
        // exit();

                $xlsName  = "User";

                $xlsCell  = array(

                array('classname','班级'),
                
                array('stu_name','学生姓名'),

                array('stu_id','学号'),

                array('cardNo','IC卡号'),

                array('phone','家长电话'),

                array('in_residence','是否住校'),

               
                array('kaitong','服务是否开通'),

                );
                //接收保存在SESSION的值
                $xlsData =$student_name;
                // var_dump($xlsData);
                // exit();



                $fileNames =  '学生班级'.date('_YmdHis');
        
                $this->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);
                     
        }


    public function impUser(){
		$schoolid = $_SESSION['schoolid'];


	
		$allcount=0;
		$successcount=0;
		$updatecount=0;

		if(!$schoolid){
			$this->error("请选择学校");
		}
	   $upload = new \Think\Upload();// 实例化上传类
    
    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
    	$upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
    	$upload->rootPath  =      './'; // 设置附件上传根目录
    	$upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
    	$upload->autoSub   = 	 false;//不自动生成子文件夹
    	// 上传单个文件 
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
			//循环读取excel文件,读取一条,插入一条
			// $info='begin::';
			for($j=2;$j<=$highestRow;$j++)
			{
				for($k='A';$k<=$highestColumn;$k++)
				{
					//读取单元格
					$ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
					$allcount++;					
				}
			}
			$info=$j.'-'.$k.':'.$info.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();
			//var_dump($info);
			// $info=$info.'end';
		   $successcount=0;
            $error_info = array();
            $rowNo = 1;
     

      
			  foreach ($ExamPaper_arr as $key => $value)
            {
                //循环数据检测A=>学生姓名，B=>班级，C=>监护人姓名，D=>家长联系方式，H=>关系, L=>性别，M=>学号，N=>IC卡号，O=>是否住校
                //如果题号或者题干不为空
                if(!empty($value['A'])||!empty($value['B'])){
                    $name=$value['A'];
                     // var_dump($name);
                    $class=$value['B'];
                    $parentname = $value['C'];
                    $phone=$value['D'];
                    $relation = $value['H'];
                    $sex=$value['L'];
                    $stu_id=$value['M'];
                    $card = $value["N"];
                    $in_residence = $value["O"];
                    
                    $result=$this->importstudent(trim($name),trim($class),trim($parentname),trim($phone),trim($relation),trim($sex),trim($stu_id),trim($card),trim($in_residence),$schoolid);

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
                    if($result ==1){
                        $successcount++;
                    }else if($result ==2){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"学生信息已存在"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==3){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"IC卡号已经存在"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==4){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"家长联系号码已经存在"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==5){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"班级绑定失败"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result == 6){
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
                    }else if ($result == 0){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"必填字段获取失败"
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
        

        $emptyData = "";
        foreach ($error_info as &$error_item){
            $emptyData = $emptyData."第".($error_item["row"]+1)."行".$error_item["msg"].",";
        }

    	$allcount=$highestRow-1;
    	$updatecount=$allcount-$ius;

    	 if(!empty($emptyData))
      {
            $data_excel =  array(
                       'schoolid'=>$schoolid,
                       'filename'=>$file_name,
                        'type'=>$type,
                        'time'=>time(),
                        'pro'=>rtrim($emptyData, ","),
                        'status'=>1,
                        'state'=>2

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
                        'state'=>2,

                        );
            $teacher_excel = M('teacher_excel')->add($data_excel);


      }

      
    	 $info='::其中成功'.$successcount.'人,'.$emptyData;
    	 

		$this->success('导入完成');
	}
	function importstudent($name,$class,$parentname,$phone,$relation,$sex,$stu_id,$card,$in_residence,$schoolid){
		// exit();
		
		$result = 1;
  //0.失败，1新增，2更新

          //判断学校信息是否存在
        if ($schoolid){
            $isShool = M("School")->where("schoolid=$schoolid")->find();
           
            if (!$isShool){
                $result =  6;
            }
        }else{
            $result  = 6;
        }


          if($card!=""){
           	 $lenfth=10-strlen($card); 
           	 $lastResult = ""; // 存储返回的结果
          for($i=0;$i<$lenfth;$i++){
          	$lastResult = "0" . $lastResult;
          }   
          $ICcardsu=$lastResult.$card; //10位的卡号       	 
           }else{
           	$ICcardsu="";
           }  
		
		//判断家长名字为空时
		 if($parentname == ""){
		 	$parentname=$name."家长";
		 }
	      

         	
          //TODO  以后需要改进 多个家长关系
		    // var_dump($relation);
		    // var_dump($phone);

		    //  $phone = explode(",", $phone);
		    //  var_dump($phone);

		    // $relation = explode(",", $relation);
		    // var_dump($relation);
		    // $sum = count($relation);
		    // var_dump($sum);

		    // $arr = array_combine(array_values($phone),$relation);
		    // var_dump($arr);
		    // // exit();
         
      //    foreach($arr as $key=>$value)
      //    {
      //    	var_dump($key);
      //    	var_dump($value); 	
      //    }
        
      //   exit();
      //--------------------end






		
   
			
		if(empty($name) || empty($class)){	

		
			 $result=0;


		}else{				
			//判断用户的性别
			if($sexname=='男'){
				$sex=1;
			}else{
				$sex=0;
			}

           }
	
			
			//通过传入学校ID和班级名字；查找对应的班级；
			$class_where['schoolid']=$schoolid;
			$class_where['classname']=$class;
			$class=M('school_class')->where($class_where)->field('id,classname')->find(); 

			if($class){				
				//如果不存在班级就弹出
				$classid=$class['id'];
				$classname = $class['classname'];
				// 根据班级id 和学生姓名去查找数据
				
				$where['c.classid'] = $classid;
				$where['s.stu_name'] = $name;
				$where['s.schoollid'] = $schoolid;
               $student = M('class_relationship')->alias("c")->join("wxt_student_info s ON s.userid = c.userid")->field("s.userid,s.stu_name,c.classid")->where($where)->find();
              // var_dump($student);
                //如果不存在
		               
		               if(!$student)
		               {     
                               	if(empty($phone))
								{
					               $phone = 13000000000;
								}
								

		                      
		                    	$data=array(
									'schoolid'=>$schoolid,
									'name'=>$name,
									'sex'=>$sex,
									'password'=>md5('123456'),
									'status'=>'1',
									'user_type'=>'1',
									'create_time'=>time()
								);
								$userid=$this->wxtuser_model->add($data);

								if($userid){
								//写入学生表格				
								 $stu_id = date("Y").$userid;//获取学生的学号
								//导入学生表生成6位的激活
								 $bindingkey=rand(100000,999999);
								$classrelationdataiofo=array(
								"stu_id"=>$stu_id,
								"classid"=>$classid,
								"userid"=>$userid,
								"sex"=>$sex,
								"photo"=>'学生.png',
								"stu_name"=>$name,
								"bindingkey"=>$bindingkey,
								"schoollid"=>$schoolid,
								"create_time"=>time()
								);
							$Stuiofo=M("student_info")->add($classrelationdataiofo);

								$classrelationdata=array(
									"schoolid"=>$schoolid,
									"classid"=>$classid,
									"userid"=>$userid
								);
							  $classrelationdata['create_time']=time();
							  $crs = $this->relation_stu_class_model->add($classrelationdata);


		                     	$phone = explode(",", $phone);

							         $i = 0;
							     foreach ($phone as  $phone_num) {
							                $i++;
									    if($i==1)
									     {
							                $type = 1;
									     }else{
									     	$type = 0;
									     }
                                
                               $where['phone'] = $phone_num; 
                               

							   $parent_ex = M("wxtuser")->where("phone = $phone_num")->field("phone,id")->find();		     
                            
                                $pwd = substr($phone_num, -6);
                               
                                if(!$parent_ex || $parent_ex['phone']==13000000000)
                                {
                                 $datas=array(
									'schoolid'=>$schoolid,
									'name'=>$parentname,
									'phone'=>$phone_num,
									'sex'=>$sex,
									'password'=> md5($pwd),
									'status'=>'1',
									'user_type'=>'1',
									'create_time'=>time()
						         	);

		                        $parentid=M("wxtuser")->add($datas);

                                }else{
                                	$parentid = $parent_ex['id'];
                                }

		           

		                     

							   //写入亲属关系表

								$redata=array(
									"studentid"=>$userid,
									"userid"=>$parentid
								);

								   $redata['name']=$parentname;
								    $redata['phone']=$phone_num;
								    $redata['charging_phone']=$phone_num;
									$redata['time']=time();
									$redata['appellation'] = $relation;
									$redata['relation_rank']=1;
									$redata['type']=$type;
									$redata['preferred']=1;

							$rt = $this->relation_stu_user_model->add($redata);
					      }
		                      if(!empty($card)){
								//检测是否已经存在卡对应关系表
									$carddata['cardNo']=$ICcardsu;
									$iscard=M('student_card')->where($carddata)->find();
									if($iscard){
										$result=3;
									}else{
										//写入卡表
										$carddata['cardType']=0;
										$carddata['cardNo']=$ICcardsu;
										$carddata['personId']=$userid;
										$carddata['schoolid']=$schoolid;
										$carddata['className']=$classname;
										$carddata['handletime']=date('Y-m-d H:i:s',time());
										$carddata['handletimeint']=time();
										$carddata['name']=$name;
										$carddata['classId']=$classid;
										$carddata['create_time']=time();
										$carrs=M('student_card')->add($carddata);
										
										//$result = 1;
									   //插入卡号日志表
								
									}
								}
		                    }
		                       

		               }else{
		               	//如果学生信息存在
		               	//用家长关系表去查  判断家长关系表的主号码跟该家长号码是否一样 如果一样的话视为同一个孩子
		               $userid = $student['userid'];
		               // var_dump($userid);

		               $parent = $this->relation_stu_user_model->where("studentid = $userid and type = 1")->field('phone')->find();
		               // var_dump($parent);
		               // exit();
		                       //如果不一样则插入信息
		               //因为可能有两个家长号码,这里只取第一个号码为主号码来比较
			               if($parent['phone']!==strtok($phone, ',') || empty($phone))
			               {  
                                if(empty($phone))
								{
					               $phone = 13000000000;
								}
								
                                

		                       $data=array(
									'schoolid'=>$schoolid,
									'name'=>$name,
									'sex'=>$sex,
									'password'=>md5('123456'),
									'status'=>'1',
									'user_type'=>'1',
									'create_time'=>time()
								);
								$userid=$this->wxtuser_model->add($data);


		                      	if($userid){
								//写入学生表格				
								 $stu_id = date("Y").$userid;//获取学生的学号
								//导入学生表生成6位的激活
								 $bindingkey=rand(100000,999999);
								$classrelationdataiofo=array(
								"stu_id"=>$stu_id,
								"classid"=>$classid,
								"userid"=>$userid,
								"sex"=>$sex,
								"phone"=>'学生.png',
								"stu_name"=>$name,
								"bindingkey"=>$bindingkey,
								"schoollid"=>$schoolid,
								"create_time"=>time()
								);
							$Stuiofo=M("student_info")->add($classrelationdataiofo);

								$classrelationdata=array(
									"schoolid"=>$schoolid,
									"classid"=>$classid,
									"userid"=>$userid
								);
							  $classrelationdata['create_time']=time();
							  $crs = $this->relation_stu_class_model->add($classrelationdata);

                             		$phone = explode(",", $phone);

							         $i = 0;
							     foreach ($phone as  $phone_num) {
							                $i++;
									    if($i==1)
									     {
							                $type = 1;
									     }else{
									     	$type = 0;
									     }
									    // var_dump($type);
							   $parent_ex = M("wxtuser")->where("phone = $phone_num")->field("phone,id")->find();

                                $pwd = substr($phone_num, -6);

                         
                               if(!$parent_ex || $parent_ex['phone']==13000000000)
                                {
                                 $datas=array(
									'schoolid'=>$schoolid,
									'name'=>$parentname,
									'phone'=>$phone_num,
									'sex'=>$sex,
									'password'=> md5($pwd),
									'status'=>'1',
									'user_type'=>'1',
									'create_time'=>time()
						         	);

		                        $parentid=M("wxtuser")->add($datas);

                                }else{
                                	$parentid = $parent_ex['id'];
                                }
                                 

							   //写入亲属关系表

								$redata=array(
									"studentid"=>$userid,
									"userid"=>$parentid
								);

								   $redata['name']=$parentname;
								    $redata['phone']=$phone_num;
								    $redata['charging_phone']=$phone_num;
								    $redata['appellation'] = $relation;
									$redata['time']=time();
									$redata['relation_rank']=1;
									$redata['type']=$type;
									$redata['preferred']=1;

							$rt = $this->relation_stu_user_model->add($redata);
					   }
   
		                      if(!empty($card)){
								//检测是否已经存在卡对应关系表
									$carddata['cardNo']=$ICcardsu;
									$iscard=M('student_card')->where($carddata)->find();
									if($iscard){
										$result=3;
									}else{
										//写入卡表
										$carddata['cardType']=0;
										$carddata['cardNo']=$ICcardsu;
										$carddata['personId']=$userid;
										$carddata['schoolid']=$schoolid;
										$carddata['className']=$classname;
										$carddata['handletime']=date('Y-m-d H:i:s',time());
										$carddata['handletimeint']=time();
										$carddata['name']=$name;
										$carddata['classId']=$classid;
										$carddata['create_time']=time();
										$carrs=M('student_card')->add($carddata);
										
										//$result = 1;
									   //插入卡号日志表
								
									}
								}
		                    }

		                      


			           }else{

			               	$result = 2;
			             }
		               	
		          }


       }else{
           $result = 5;
       }     
                //end 最新到这里过  后面是旧的


    


		  // var_dump($result);说
		return $result;

	
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
           //点击查看显示微信绑定
        function bindingkey(){
             
            $studentid=I("studentid");
            //var_dump($teacherid);
            $binkey = M('student_info')->where("userid=$studentid")->field('bindingkey')->select();
            //var_dump($binkey);

            //  if ($binkey!=null) {
            //     $info['status'] = true;
            //     $info['msg'] = $binkey;

            // } else {
            //     $info['status'] = false;
            //     $info['msg'] = '404';
            // }
            if($binkey){
                $ret  = $this->format_ret(1,$binkey);
            }else{
               $ret  = $this->format_ret(0,"parms lost"); 
            }
            echo  json_encode($ret);

    }     
   



   //      //学生导入数据
   //     public function impUser()
   //     {
   //    $schoolid=$_SESSION['schoolid'];    
     
   //          // $schoolid = intval(I('school'));
   //      $allcount=0;
   //      $successcount=0;
   //      $updatecount=0;
      
   //      $upload = new \Think\Upload();// 实例化上传类
   //      // var_dump($upload);
   //      $upload->maxSize   =     3145728 ;// 设置附件上传大小
   //      $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
   //      $upload->rootPath  =      './'; // 设置附件上传根目录
   //      $upload->savePath  =      'upload/Teacher_info/'; // 设置附件上传（子）目录
   //      $upload->autoSub   =     true;//不自动生成子文件夹
   //      // 上传单个文件 
   //      $info   =   $upload->uploadOne($_FILES['import']);
   //      // var_dump($info);
   //      $type = $info['ext'];

   //      $file_name = $info['name'];

   //      // var_dump($_FILES);
   //      // exit();
   //      if(!$info){
   //          $this->error($upload->getError());
   //      }else{
   //          $file_puth = './'.$info['savepath'].$info['savename'];
   //          //文件上传成功，对文件进行解析
   //          // vendor('phpexcel_1.phpexcel');//导入类库
   //          require_once VENDOR_PATH.'PHPExcel/PHPExcel/IOFactory.php';
   //          require_once VENDOR_PATH.'PHPExcel/PHPExcel.php';
   //          if($info['ext']=='xlsx'){
   //              require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
   //              $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
   //          }else{
   //              require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
   //              $objReader = \PHPExcel_IOFactory::createReader('Excel5');
   //          }
   //          //use excel2007 for 2007 format
   //          $objPHPExcel = $objReader->load($file_puth);
   //          // $objPHPExcel->setActiveSheetIndex(1);
   //          $sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始) 
   //          $highestRow = $sheet->getHighestRow(); // 取得总行数
   //          $highestColumn = $sheet->getHighestColumn(); // 取得总列数
   //         // var_dump($highestColumn);
   //          //循环读取excel文件,读取一条,插入一条
   //          // $info='begin::';
   //          for($j=2;$j<=$highestRow;$j++)
   //          {
   //              for($k='A';$k<=$highestColumn;$k++)
   //              {
   //                  //读取单元格
   //                  $ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
   //                  $allcount++;

                    
                    
                    
   //              }
   //          }
   //          $info=$j.'-'.$k.':'.$info.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();
   //         //  var_dump($info);
   //         // var_dump($ExamPaper_arr);
   //         //   //var_dump($info);
   //         //  exit();
   //          // $info=$info.'end';
   //      var_dump($ExamPaper_arr);
   //          // $hl = $j.'--'.$k.':'.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();
   //          $successcount = 0;
   //          // $departmentcount=0;
   //          // $dutycount=0;
   //          $rowint = 2;
   //          $error_info = array();
   //          foreach ($ExamPaper_arr as $key => $value) 
   //          {
   //              //循环数据检测A=>教师姓名B=>角色=>电话号码=>IC卡号=>出生日期=>科室
   //              //如果题号或者题干不为空
   //              if(!empty($value['A'])||!empty($value['C']) || !empty($value['H'])){
   //                  //姓名
   //                  $name=$value['A'];
   //                  //性别
   //                  $sex=$value['B'];
   //                  //家长手机
   //                  $phone=$value['C'];
   //                  //是否住校
   //                  $in_residence=$value['D'];
   //                  //民族
   //                  $nation=$value['E'];
   //                  //籍贯
   //                  $native_place=$value['F'];
   //                  //家庭住址
   //                  $address=$value['G'];
   //                  //所属班级
   //                  $class=$value['H'];
   //                  // $department=$value['F'];
   //                  $result=$this->importteacher(trim($name),trim($sex),trim($phone),trim($in_residence),trim($nation),trim($native_place),trim($address),trim($class),$type,$file_name,$rowint,$hl);
   //                  if($result ==1){
   //                      $successcount++;
   //                  }else if($result ==2){
   //                     $error_item = array(
   //                      "row"=>$rowint,
   //                      "msg"=>"该班级不存在"
   //                  );
                    
   //                  array_push($error_info,$error_item);
   //                  }else if($result==3){
   //                      $departmentcount++;
   //                  }else if($result==4){
   //                      // $dutycount++;
   //                  }else if($result==5){
   //                      // $departmentcount++;
   //                      // $dutycount++;
   //                  }else if ($result==-1){
   //                      // $emptyData = "有数据为空！";
   //                $error_item = array(
   //                      "row"=>$rowint,
   //                      "msg"=>"必填数据未填写"
   //                  );
                    
   //                  array_push($error_info,$error_item);
   //                  }else if ($result==0){
   //                     $error_item = array(
   //                          "row"=>$rowint,
   //                          "msg"=>"姓名和家长电话重复"
   //                      );
   //                     array_push($error_info,$error_item);
   //                      // $row = $rowint-2;
   //                      // $this->error('有数据异常请重新插入,成功插入'.$row.'条数据');
   //                      // return false;
   //                  }
   //              }

   //              $rowint++;
   //             // var_dump($rowint);
                
   //          }
   //      }
      

   //       $emptyData = "";
   //      foreach ($error_info as &$error_item){
   //          $emptyData = $emptyData."第".($error_item["row"])."行".$error_item["msg"]."错误,";
   //      }
   //    //  var_dump($emptyData);
      

   //      if(!empty($emptyData)){
   //          $data_excel =  array(
   //                     'schoolid'=>$schoolid,
   //                     'filename'=>$file_name,
   //                      'type'=>$type,
   //                      'time'=>time(),
   //                      'pro'=>rtrim($emptyData, ","),
   //                      'status'=>1,
   //                      'state'=>2,

   //                      );

   //        $teacher_excel = M('teacher_excel')->add($data_excel);
   //      }else{
   //          $data_excel =  array(
   //                     'schoolid'=>$schoolid,
   //                     'filename'=>$file_name,
   //                      'type'=>$type,
   //                      'time'=>time(),
   //                      'pro'=>'完美!',
   //                      'status'=>0,
   //                      'state'=>2

   //                      );
   //          $teacher_excel = M('teacher_excel')->add($data_excel);
   //      }
   //      // exit();
      
   //      $info='::其中成功'.$successcount.'人,'.$emptyData;

        
        
       

   //      $this->success('导入完成'.'共插入'.$successcount.'条数据');

       
            
          



   //     } 
   

   // //学生导入调用

   //  function importteacher($name,$sex,$phone,$in_residence,$nation,$native_place,$address,$class,$type,$filenmae,$rowint,$highestRow){
   //      $result=0;//0.失败，1新增，2更新
   //      $schoolid=$_SESSION['schoolid']; 
   //      // $ExamPaper_arr


   //      if(empty($name) || empty($phone) ||empty($class)){
            



   //          $result = -1;

   //          return $result;

   //      }else{

   //          $departmentid=0;
   //          $dutyid=0;
   //          $userid=0;
           



   //          $where_stu['name'] = $name;
   //          $where_par['phone'] = $phone;

   //          $user = M('wxtuser')->where($where_stu)->field('id')->find();

   //          $parent = M('relation_stu_user')->where($where_par)->field('id')->find();
            
   //          if($user && $parent){
                
   //            // var_dump($rowint);
   //              // $data_excel =  array(
   //              //    'schoolid'=>$schoolid,
   //              //    'filename'=>$filenmae,
   //              //     'type'=>$type,
   //              //     'time'=>date("Y-m-d H:i:s"),
   //              //     'pro'=>'在第'.$rowint.'行有名字和手机重复',
   //              //     'status'=>1,
   //              //     );
   //              // $teacher_excel = M('teacher_excel')->add($data_excel);

   //               $result = 0;
   //              return $result;
   //              }else{
   
   //                  //查找班级 如果没有改班级则跳出
   //               $where_class['classname'] = $class;

   //               $classid = M('school_class')->where($where_class)->field('id')->find();

   //               if(!$classid)
   //               {
   //               	$result = 2;	
   //               	return $result;
   //               }





		 //             $data=array(
			// 						'schoolid'=>$schoolid,
			// 						'name'=>$name,
			// 						'sex'=>$sex,
			// 						'password'=>md5('123456'),
			// 						'status'=>'1',
			// 						'user_type'=>'1',
			// 						'create_time'=>time(),
			// 				);
			// 		$userid=M("wxtuser")->add($data);	


			// 		$data_class['schoolid'] = $schoolid;
			// 		$data_class['classid'] = $classid['id'];
			// 		$data_class['userid'] = $userid;
			// 		$data_class['status'] = 1;
			// 		$data_class['create_time'] = time();

			// 		$class_rel = M('class_relationship')->add($data_class);	


		 //                 //插入学生wxt_student_info；        
			// 	        $bindingkey=rand(100000,999999);//获取随机的登录码
			// 	        $stu_id = date("Y").$userid;//获取学生的学号
				        
   //                    if($in_residence=='否')
   //                    {
   //                    	$in_residence = 0;
   //                    }else{
   //                    	$in_residence = 1;
   //                    }

			// 	         $student_infodata=array(
			// 	                 "stu_id"=>$stu_id,
			// 	                 "in_residence"=>$in_residence,
			// 	                 "address"=>$address,
			// 	                 "nation"=>$nation,
			// 	                 "native_place"=>$native_place,
			// 	                 "sex"=>$sex,
			// 	                 "schoolid"=>$schoolid,
			// 					"classid"=>$classid,
			// 					"userid"=>$userid,
			// 					"stu_name"=>$name,
			// 					"bindingkey"=>$bindingkey,
			// 					"create_time"=>time()
			// 	         ); 
				         
			// 	         $student_info=M("student_info")->add($student_infodata);
                 
   //                //var_dump($rel);


			// 	         $datas=array(
			// 				'schoolid'=>$schoolid,
			// 				'name'=>$name."家长",
			// 				'phone'=>$phone,
			// 				'sex'=>$sex,
			// 				'password'=>md5('123456'),
			// 				'status'=>'1',
			// 				'user_type'=>'1',
			// 				'create_time'=>time()
			// 		    );
			// 	         $parentid=M("wxtuser")->add($datas);


   //                if($parentid){

			// 			$redata=array(
			// 				"studentid"=>$userid,
			// 				"userid"=>$parentid							
			// 			); 
						
			// 		        $redata['time']=time();
			// 				$redata['relation_rank']=1;
			// 				$redata['type']=1;
			// 				$redata['preferred']=1;
			// 				$redata['phone']=$phone;
			// 			$rt = M("relation_stu_user")->add($redata);    
			// 		}




   //              }
   //                  //如果卡号不为空
                

                     
   //               $result=1;
   //              }

   //      return $result;
    
   //  }

   //加载学生到入状态页

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
           $excel_error = M('teacher_excel')->where("time >= $begin_time and time <= $end_time and schoolid = $schoolid and state = 2")->order('time desc')->select();
           $this->assign('excel',$excel_error); 

             $this->display();
             die();
     }


         $excel_error = M('teacher_excel')->where("schoolid = $schoolid and state = 2")->order('time desc')->select();

         
         // var_dump($excel_error);
         // exit()?
        // var_dump($excel_error);
         $this->assign('excel',$excel_error); 

         $this->display();

       }

      
       //查看处理结果
       public function showre()
       {
          $excelid = I('excelid');

          $excel = M('teacher_excel')->where("id=$excelid")->find();
          // var_dump($excel);  

         foreach ($excel as $key => &$value) {
               $excel['time'] = date("Y-m-d H:i:s", $excel['time']);
         }
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


       public function edit_post()
       {     

            $schoolid=$_SESSION['schoolid'];

            $userid = I('student_id');

            $name = I('student_name');

            $address = I("address");


            $native_place = I("native_place");


            $stu_id = I("stu_id"); 
 

            $phone = I('rel');
       
            $sex = I('sex');
     

            $in_residence = I('in_residence');
             
            $card=I("newcardNo");
            
             $old_card = I("oldcardNo"); 

             $newCardNo = I('newcardNo');
            //旧的学生卡
             $oldCardNo = I('oldcardNo');
           $str=$_POST['smeta']['thumb'];
           $arr=explode("/", $str);
           $photo=$arr[count($arr)-1];


             
             $depid = I('depid');

             $id =  implode(",", $depid); 
         

            $where_del['teacher_id'] = $userid;

            $where_del['school_id'] = $schoolid;
         if($newCardNo!=$oldCardNo)
         {
           $show_Card = get_showcard($card,$schoolid);

           if($card) {
               if ($show_Card) {

                   $this->error("卡号已经存在");
               }
           }
         }
            

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
            
         if($photo)
         {
             M("wxtuser")->where("id = $userid")->save(array("photo"=>$photo));
         }
           
         if($userid)
         { 
         	$data = array(
         	  'address'=>$address,
              'sex'=>$sex,
               'in_residence'=>$in_residence,
               'stu_name'=>$name,
               'stu_id'=>$stu_id,
               'address'=>$address,
               'native_place'=>$native_place,
         		);


         	$save = M('student_info')->where("userid = $userid")->save($data);


         	$arr = array(
                 'phone'=>$phone,
         		);

         	$relation = M("relation_stu_user")->where("studentid = $userid and type = 1")->find();

           $rel = M('relation_stu_user')->where("studentid = $userid and type = 1")->save($arr);

           //修user表里
             if($relation)
             {
                 M("wxtuser")->where(array("id"=>$relation['userid']))->save(array("phone"=>$phone));
             }else{
                 $this->error("修改密码失败");
             }





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


             update_card(0,$userid,$schoolid);

           if($rel || $save || $del || $result || $cha)
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
     //删除卡号
    public function delcard()
    {
        $cardno = I("cardno");

        if($cardno)
        {
            $info =  deletecard($cardno,0);

            echo $info;

        }else{
            $info['status'] = false;
            $info['info'] = '请传人正确的卡号';

            echo json_encode($info);
        }

    }

    /*--------------------------学生家长列表start---------------------------*/
    public function parentlist() {
        $studentid = $_GET['id'];
        if ($studentid) {
            $schoolid = M("StudentInfo")->where("userid = $studentid")->Field("schoollid as schoolid,stu_name")->find();
            $rst = $this -> wxtuser_model -> alias("user") -> join("wxt_relation_stu_user su ON user.id=su.userid") -> where("su.studentid=$studentid") -> field('su.id as rel_id,user.id as parent_id,su.name as parent_name,user.phone,su.appellation,su.type') -> select();
            $this -> assign("studentid", $studentid);
            $this -> assign("stu_name", $schoolid['stu_name']);
            $this -> assign("userinfo", $rst);
            $this -> assign("schoolid",$schoolid['schoolid']);
            $this -> display("parentlist");
        } else {
            $this -> error('数据传入失败！');
        }
        exit;
    }
    public function updateparent() {
        $studentid = I('studentid');
        if ($studentid) {
            $schoolid = M("StudentInfo")->where("userid = $studentid")->Field("schoollid as schoolid,stu_name")->find();
            $this -> assign("studentid", $studentid);
            $this -> assign("stu_name", $schoolid['stu_name']);
            $this -> assign("schoolid",$schoolid['schoolid']);
        } else {
            $this -> error('数据传入失败！');
        }
        $relationid = $_GET['rid'];
        $where['r.id'] = $relationid;
        $result = $this -> relation_stu_user_model
            -> alias('r')
            -> join("" . C('DB_PREFIX') . 'wxtuser as su on r.studentid = su.id')
            -> join("" . C('DB_PREFIX') . 'wxtuser as pu on r.userid = pu.id')
            -> field("r.id,r.studentid,r.userid as parentid,r.appellation,su.name as studentname,pu.name as parentname,pu.phone as parentphone")
            -> where($where) -> find();
        $relation = $this -> appellation_model -> order(array("id" => "asc")) -> select();
        $this -> assign("relationdata", $result);
        $this -> assign("relation", $relation);
        $this -> display();
        exit;
    }

    public function updateparent_post() {
        if (IS_POST) {
            $phone = $_POST['parentphone'];
            $parentid = $_POST['parentid'];
            $parentname = $_POST['parentname'];
            $relationid = $_POST['relationid'];
            $appe = $_POST['appe'];
            if ($parentid && $relationid && $appe) {
                //如果新存的家长在用户表中已经存在
                $where['phone'] = $phone;
                $where['id'] = array('NEQ', $parentid);
                //注释以下代码 一个学生开挂靠多个家长
                //如果新存的家长在用户表中未存在
                $s_data['name'] = $parentname;
                $s_data['phone'] = $phone;
                $s_where['id'] = $parentid;
                $res = $this -> wxtuser_model -> where($s_where) -> save($s_data);

                $appellationname_where['id'] = $appe;
                $appellation_info = $this -> appellation_model -> where($appellationname_where) -> getField('appellation_name');
                $u_data['appellation'] = $appellation_info;
                // $u_data['studentid']=$studentid;
                $u_data['userid'] = $parentid;
                $u_data['time'] = time();
                $pwhere['id'] = $relationid;
                $rst = $this -> relation_stu_user_model -> where($pwhere) -> save($u_data);
                if ($rst) {
                    $this -> error('保存成功');
                } else {
                    $this -> error("保存失败！");
                }
                $this -> error('lost param!');
            }
        } else {
            $this -> error('error!');
        }

    }
    //-----------------------删除家长与学生的关系--------------------
    public function parent_delete() {
        $id = $_GET['parentid'];
        $relid = $_GET['id'];
        if ($id) {
            //是否存在其他
            $rst = M("relation_stu_user") -> where("id=$relid") -> delete();
            if ($rst) {
                $this -> success("删除成功！");
            } else {
                $this -> error("删除失败！");
            }
        } else {
            $this -> error('数据传入失败！');
        }
        $this -> error('该功能暂时未开通！');
    }
    //------------------添加家长start----------------
    public function addparent() {

        $studentid = $_GET['studentid'];
        $schoolid = $_GET['schoolid'];
        //获取schoolid
        $users = $this -> relation_stu_user_model -> order(array("studentid" => "asc")) -> select();
        $relation = $this -> appellation_model -> order(array("id" => "asc")) -> select();
        $this -> assign("users", $users);
        $this -> assign("relation", $relation);
        $this -> assign("studentid", $studentid);
        $this -> assign("schoolid",$schoolid);
        $this -> display();
        exit;
    }
    public function addparent_post() {
        //$studentid=intval($_GET['student_id']);
        if (IS_POST) {

            $phone = $_POST['phone'];
            $schoolid = $_POST['schoolid'];
            if(!$phone)
            {
                $this->error("手机号码不能为空!");
                exit();
            }

            if(!$_POST['appe'])
            {
                $this->error("请选择关系!");
                exit();
            }
            //如果新存的家长在用户表中已经存在
            $user_id = $this -> wxtuser_model -> where("phone=$phone") -> getField('id');
            if ($user_id) {
                $u_data['studentid'] = $_POST['studentid'];
                $u_data['userid'] = $user_id;
                $u_data['name'] = $_POST['user_name'];
                $u_data['phone'] = $_POST['phone'];
                $u_data['time'] = time();
                $appellationname_where['id'] = $_POST['appe'];
                $appellation_info = $this -> appellation_model -> where($appellationname_where) -> getField('appellation_name');
                $u_data['appellation'] = $appellation_info;
                $rst = $this -> relation_stu_user_model -> add($u_data);
                if ($rst) {
                    $this -> error('保存成功');
                } else {
                    $this -> error("保存失败！");
                }
            } else {
                //如果新存的家长在用户表中未存在
                $s_data['name'] = $_POST['user_name'];
                $s_data['phone'] = $_POST['phone'];
                $s_data['schoolid'] = $schoolid;
                $s_data['password'] = md5(substr($_POST['phone'], -6));
                $s_data['create_time'] = time();
                $res = $this -> wxtuser_model -> add($s_data);

                $new_id = $this -> wxtuser_model -> getLastInsID();
                $d_data['studentid'] = $_POST['studentid'];
                $d_data['userid'] = $new_id;
                $d_data['phone'] = $_POST['phone'];
                $d_data['creattime'] = time();
                $d_data['name'] = $_POST['user_name'];
                $_appellationname = $_POST['appe'];
                $_appellation_info = $this -> appellation_model -> where("$_appellationname=id") -> getField('appellation_name');
                $d_data['appellation'] = $_appellation_info;
                $rus = $this -> relation_stu_user_model -> add($d_data);
                if ($res) {
                    $this -> error('保存成功');
                } else {
                    $this -> error("保存失败！");
                }
            }
        } else {
            $this -> error('error!');
        }

    }

    //考勤卡备卡管理的页面
    public function sparecard(){
        $userid=I("id");
        $card = I("card");
        if($card == 0){
            $card == "";
        }
        $cardlist = M("SpareCard")->where("schoolid = '$_SESSION[schoolid]'  and status = 0")->field("cardno")->select();
        $this->assign("cardlist",$cardlist);
        $this->assign("userid",$userid);
        $this->assign("card",$card);
        $this->display();
        exit;
    }







}