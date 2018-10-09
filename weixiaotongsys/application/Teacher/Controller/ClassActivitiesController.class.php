<?php

/**
 * 班级活动
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class ClassActivitiesController extends TeacherbaseController {



    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }


	function add()
	{


//		$wxtuser =  M('wxtuser');
//        $school_class=M('school_class');
//        $school_class_id=$school_class->field('classname,grade,id')->select();
        $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $grade=M("school_grade")->where("schoolid=$schoolid")->order("id")->select();
//        $class=M("teacher_class")
//            ->alias('t')
//            ->join("wxt_school_class s ON t.classid=s.id")
//            ->where("t.teacherid=$userid")
//            ->field("s.classname,s.id,s.grade,s.schoolid")
//            ->order("id")->select();
        //var_dump($class);   
//        foreach ($class as &$item){
//            $item_gid= $item['grade'];
//           // var_dump($item_gid);
//            //$item_schoolid = $item['schoolid'];
//           // var_dump($item_schoolid);
//            $grade_item = M("school_grade")->where("gradeid=$item_gid and schoolid = $schoolid")->select();
//           // var_dump($grade_item);
//            array_push($grade,$grade_item);
//            unset($grade_item);
//        }
        $this->assign("categorys",$grade);
        // var_dump($grade);
        //var_dump($grade);
        $this->assign("class",$class);
       	 //var_dump($class);
		$this->display("add");

	}


	function add_post()
	{


        $schoolid = $_SESSION['schoolid']; 
		$grade=I('grade');
		$class=I('class');
		$title=I('title');
		$content=I('content');
		$activity=M('activity');
		$activity_pic=M('activity_pic');
		$wxtuser=M('wxtuser');
		$create_time=time();
        $begintime = I("begintime");
        $endtime = I("endtime");
		if(empty($grade))
        {
             $this->error("请选择年级");
        }
         else if(empty($class))
        {
             $this->error("请选择班级");
        }
        else if(empty($title))
        {
             $this->error("请输入标题");
        }else if (empty($begintime)||empty($endtime)){
            $this->error("请输入活动时间");
        }


// 图片路径在 data/upload

			/*
在 本地  微校通 photo的路径是  /weixiaotong2016uploads/microblog/20170107/5870b86

		只保留	20170107/5870b86  所以截取/weixiaotong2016uploads/microblog/    34

而在  乾哥服务器
uploads/microblog/20170107/5870bc561ebf1.jpg

是18


*/  
	
        $isapply = I("isapply");
        if ($isapply == "1"){
            $starttime = I("starttime");
            $finishtime = I("finishtime");
            $data['starttime']=strtotime($starttime);
            $data['finishtime']=strtotime($finishtime);
        }
		$data['title']=$title;
		$data['content']=$content;
		$data['classid']=$class;
		$data['create_time']=$create_time;
		$data['begintime']=strtotime($begintime);
		$data['endtime']=strtotime($endtime);
		$data["isapply"] = $isapply;

		session_start();
        $userid=$_SESSION["USER_ID"];
		$data['userid']=$userid;

		$find_wu=$wxtuser->where(array("id"=>$userid))->find();

		$data['contactman']=$find_wu['name'];
		$data['contactphone']=$find_wu['phone'];
        $data['schoolid'] = $schoolid;

		$add_id=$activity->add($data);
		if($add_id&&$_POST['smeta']['thumb'])
		{   
          
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];
           
                    $data_ap['activity_id']=$add_id;
                    $data_ap['picture_url']=$value;
                    $activity_pic->add($data_ap);
              }

		}
		if($add_id)
		{
		    //查找班级内所有学生并添加
            $recivers = M("class_relationship")->where("classid=$class")->select();
            foreach ($recivers as &$reciver_item){
                $recive_data["receiverid"]=$reciver_item['userid'];
                $recive_data["activity_id"]=$add_id;
                $recive_data["read_time"]=time();
                $recive_data["message_type"]=0;
                M("activity_receive")->add($recive_data);
            }

			$this->success("添加成功");
		}
		// echo $add_a;
	}


	function index()
	{

		$activity=M('activity');
		$activity_pic=M('activity_pic');
		$activity_receive=M('activity_receive');
		$school_class=M('school_class');
		$class_id=$school_class->field('classname,grade,id')->select();
       
        $schoolid = $_SESSION['schoolid'];


		$grade=I('grade');
		$class=I('class');
		$this->assign("classinfo",$class);
		$keyword=I('keyword');

		$start_time=I('start_time');
        $end_time=I('end_time');
        $start_time_unix=strtotime($start_time);//将任何英文文本的日期或时间描述解析为 Unix 时间戳
        $end_time_unix=strtotime($end_time);



		$map=array();
        if($start_time_unix && $end_time_unix){
            $map["ay.create_time"]=array(array('EGT',$start_time_unix),array('ELT',$end_time_unix));
            $this->assign('start_time_unix',$start_time_unix);
            $this->assign('end_time_unix',$end_time_unix);
        }

        if($grade) {
            if($class) {
            $map["ay.classid"]=$class;
            }else{
//                $map["ay.classid"]=$grade;
                $cla=array();
                $class_arr=M("school_class")->where("grade=$grade")->field("id")->select();
                foreach ($class_arr as &$classid) {
                    $c=$classid["id"];
                    array_push($cla, $c);
                }
                $map["ay.classid"]=array("in",$cla);
            }
            $this->assign("gradeinfo",$grade);

        }
        if($keyword)
        {
            array_push($map, "ay.content like '%$keyword%' ");
            $this->assign("keyword",$keyword);
        }

        if($this->level!=1  && $this->level!=2)
        {
            $map['ay.userid'] = $this->userid;


        }


        $map['schoolid'] = $schoolid;


		$count=$activity
		->alias('ay')
		->field("id,title,classid,content,create_time")
		->where($map)
		->count();
		$page = $this->page($count, 20);



		$lists=$activity
		->alias('ay')
		->field("id,title,classid,content,create_time")
		->order("create_time desc")
		->where($map)
		->limit($page->firstRow . ',' . $page->listRows)   // 添加分页
		->select();
   

		foreach ($lists as &$val) {
			$id_ay=$val['id'];
			$find_ayp=$activity_pic->where(array("activity_id"=>$id_ay))->field("picture_url")->find();
			$val['picture_url']=$find_ayp['picture_url'];
			$count_ayr=$activity_receive->where(array("activity_id"=>$id_ay))->count();
			$val['count']=$count_ayr;
           $classid=$val['classid'];
              $where_class['c.id'] = $classid;
              $where_class['c.schoolid'] = $schoolid;

 
			
			$school_class_id=$school_class
                ->alias("c")
                ->join("wxt_school_grade g ON g.gradeid=c.grade")
                ->where($where_class)
                ->field('c.classname,g.name as gradename')->find();



			$val['classname']=$school_class_id['classname'];
			$val["gradename"]=$school_class_id["gradename"];
		}

		//zsq_获取班级年级信息
        $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $grade_q=Array();
        $class_q=M("teacher_class")
            ->alias('t')
            ->join("wxt_school_class s ON t.classid=s.id")
            ->where("t.teacherid=$userid")
            ->field("s.classname,s.id,s.grade")
            ->order("id")->select();
        foreach ($class_q as &$item){
            $item_gid= $item['grade'];
            $grade_item = M("school_grade")->where("gradeid=$item_gid and schoolid = $schoolid")->select();
            array_push($grade_q,$grade_item);
            unset($grade_item);
        }
        $grade_q = M("school_grade")->where(" schoolid = $schoolid")->select();        
//        $this->assign("class",$class_q);
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("Page", $page->show('Admin'));   // 添加分页
		$this->assign("lists",$lists);
		$this->assign("categorys",$grade_q);
		$this->display("index");

	}


// 删除 activity 与 activity_pic 中的数据
	function shanchu()
	{
		$id=I('id');
		$activity=M('activity');
		$activity_pic=M('activity_pic');

		$activity->where(array("id"=>$id))->delete();
		$activity_pic->where(array("activity_id"=>$id))->delete();
		$this->index();
	}



}