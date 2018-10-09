<?php

/**
 * 代接确认
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class DeliveryController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }


    public function index()
	{



        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
        $map['wxt_wxtuser.schoolid']= $schoolid;
		$student_delivery=M('student_delivery');
		$wxtuser =  M('wxtuser'); 
        $school_class=M('school_class');
        if($level!=1  && $level!=2)
        {

            $school_class_id = get_teacher_class($userid);
            $map['sd.teacherid'] = $userid;


        }else{
            $school_class_id=$school_class->where("schoolid=$schoolid")->field('classname,grade,id')->select();
        }


         //向模板传送本校的年级信息
        $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();


        $grade=I('grade');
        $student_name=I('student_name');//学生姓名
        $status=I('status');// 代接状态
        $start_time=I('start_time');
        $end_time=I('end_time');
        $start_time_unix=strtotime($start_time);//将任何英文文本的日期或时间描述解析为 Unix 时间戳
        $end_time_unix=strtotime($end_time);

  		$classid=I("class");

       
        if($classid){
            $userid_c=M('class_relationship')->field("userid")->where(array("classid"=>$classid))->select();
          
/*
由于$userid_c是一个二维数组，若$userid_c不存在则html界面报错，找不到什么东西。
	因为classid字段是从别的表（即class_relationship表）中获取的，而不是本表（即student_delivery表自己的字段），因此会多一层


注：这里区别于“动态模块”的表结构，“动态”的表（即microblog_main表）本身就有classid字段。
	//	这是动态里判断班级，只有一层
	 if(!empty($class))
        {
            $where['classid']= $class;
        }
    所以，当student_delivery表调用$userid_c为时，会报错。
    因此，加一个 if($userid_c){}判断。
*/ 
            if($userid_c)
            {
            	 $id_arr_c=array();
	            foreach ($userid_c as &$itvo) {
	                foreach ($itvo as &$co) {
	                    array_push($id_arr_c,$co);
	                }
	            }
	            $map["studentid"]=array("in",$id_arr_c);
                
            }
            $this->assign("classinfo",$classid);
           
        }

        if($start_time_unix && $end_time_unix){
            $map["delivery_time"]=array(array('EGT',$start_time_unix),array('ELT',$end_time_unix));
            $this->assign('start_time_unix',date('Y-m-d H:i:s',$start_time_unix));
            $this->assign('end_time_unix',date('Y-m-d H:i:s',$end_time_unix));
        }
        if(!empty($student_name))
        {
            $map['wxt_wxtuser.name']= array('like', "%$student_name%");
            $this->assign("student_name",$student_name);
        }

        if(!empty($status))
        {
        	$map['delivery_status']= $status;
        	$this->assign("status",$status);
        }
        $lists=$student_delivery
        ->alias('sd')
        ->join("wxt_wxtuser ON wxt_wxtuser.id=sd.studentid")
        ->where($map)
        ->count();
        $page = $this->page($lists, 20);
        $lists=$student_delivery
        ->alias('sd')
        ->join("wxt_wxtuser ON wxt_wxtuser.id=sd.studentid")
        ->where($map)
        ->order("delivery_time Desc")
        ->limit($page->firstRow . ',' . $page->listRows)   // 添加分页
        ->select();
        



        foreach ($lists as &$item) {
        	// 获取班级名字 和 学生姓名
            $studentid=$item["studentid"];
            $where_name["id"]=$studentid;
            $student_name=M('student_info')->field("stu_name as name")->where($where_name)->find();
            $item["student_name"]=$student_name["name"];
            $classname=M('school_class')
            ->alias("s")
            ->join("wxt_class_relationship c ON s.id=c.classid")
            ->where("c.userid=$studentid")
            ->field("s.classname")
            ->find();
            $item["classname"]=$classname["classname"];
            // 获取 教师姓名 和 代接人姓名
            $teacherid=$item["teacherid"];
            $where_name_teacher["id"]=$teacherid;
            $teacher_name=M('wxtuser')->field("name")->where($where_name_teacher)->find();
            $item["teacher_name"]=$teacher_name["name"];
            $parentid=$item["parentid"];
            $where_name_parent["id"]=$parentid;
            $parent_name=M('wxtuser')->field("name")->where($where_name_parent)->find();
           // var_dump($parent_name);
            $item["parent_name"]=$parent_name["name"];
        }
//        $this->assign("student_name",$student_name);
		$this->assign("categorys",$school_class_id);
		$this->assign("lists",$lists);
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("Page", $page->show('Admin'));   // 添加分页
		$this->assign("grade",$grade);

		 $this->assign("status",$status);


		$this->display("index");
	}


   public function add()
   {
    //发布者ID
    $userid=$_SESSION['USER_ID'];
    //学校ID
    $schoolid=$_SESSION['schoolid'];

    $level = $_SESSION['level'];
       if($level!=1  && $level!=2)
       {

           $class = get_teacher_class($userid);

       }else{
           $class = M('school_class')->where("schoolid=$schoolid")->select();
       }
    //班级

   
  
    $this->assign("class",$class);
    $this->display();
   }
   


   public function student()
   { 
       
         

        $schoolid=$_SESSION['schoolid'];
        // var_dump($schoolid);

        $class = I('class');

        // var_dump($class);
       

        $class_relationship = M('class_relationship')
                            ->alias("c")
                            ->where("c.schoolid = $schoolid and c.classid = $class")
                            ->join("wxt_student_info s ON c.userid = s.userid")
                            ->field("s.userid,s.stu_name")
                            ->order("s.userid")
                            ->select();

        
   // var_dump($class_relationship);
        

            if($class_relationship){
                $ret = $this->format_ret(1,$class_relationship);
            }else{
                $ret = $this->format_ret(0,"lost params");
            }
            echo json_encode($ret);

   }


   public function  add_post()
   {
         $teacherid=$_SESSION['USER_ID'];

          $schoolid = $_SESSION['schoolid'];

         $student = I('studentid');
       

        
         $relation = M('relation_stu_user')->where("studentid = $student and type = 1")->field("userid")->find();
         // var_dump($relation);

         if(!$relation)
         {
            $this->error("未绑定家长!");
         }


         $content = I('content');
         $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);

         $photo = $_POST['smeta']['thumb'];

        $time = strtotime(I('delivery_time'));
      

      if($student){
        $data = array(
             'teacherid'=>$teacherid,
             'studentid'=>$student,
             'content'=>$content,
             'photo'=>$photo,
             'schoolid'=>$schoolid,
             'delivery_time'=>$time,
             'parentid'=>$relation['userid']

            );

        $add = M("student_delivery")->add($data);

        }else{
            $this->error("学生不能为空");
        }

        if($add)
        {
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
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


}