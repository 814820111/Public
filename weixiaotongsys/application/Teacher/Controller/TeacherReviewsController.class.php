<?php

/**
 * 班级活动
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class TeacherReviewsController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }

	function add()
	{


//		$wxtuser =  M('wxtuser');
//        $school_class=M('school_class');
//        $school_class_id=$school_class->field('classname,grade,id')->select();
        $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $grade=Array();
        $class=M("teacher_class")
            ->alias('t')
            ->join("wxt_school_class s ON t.classid=s.id")
            ->where("t.teacherid=$userid")
            ->field("s.classname,s.id,s.grade")
            ->order("id")->select();
        foreach ($class as &$item){
            $item_gid= $item['grade'];
            $grade_item = M("school_grade")->where("id=$item_gid")->select();
            array_push($grade,$grade_item);
            unset($grade_item);
        }
        $this->assign("categorys",$grade);
        $this->assign("class",$class);
		$this->display("add");

	}


	function add_post()
	{



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
		$_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
		$photo=$_POST['smeta']['thumb'];
			/*
在 本地  微校通 photo的路径是  /weixiaotong2016uploads/microblog/20170107/5870b86

		只保留	20170107/5870b86  所以截取/weixiaotong2016uploads/microblog/    34

而在  乾哥服务器
uploads/microblog/20170107/5870bc561ebf1.jpg

是18


*/  
		$photo=substr($photo, 18);
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

		$add_id=$activity->add($data);
		if($add_id&&$photo)
		{
			$data_ap['activity_id']=$add_id;
			$data_ap['picture_url']=$photo;
			$activity_pic->add($data_ap);
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

	    $show_time = strtotime(I("show_time"));
        $grade=I('grade');
        $class=I('class');

        if (!$show_time){
            $show_time = time();
        }
        //獲取每個月的第一天凌晨和最後一天的午夜十二點的時間戳來作爲查詢點評的條件
        //获取月份天数 当前年、月 计算一号零点零分的时间戳
        $dateNum = date("t",$show_time);
        $dateY =  intval(date("Y",$show_time));
        $dateM = intval(date("m",$show_time));
        $month_start = mktime(0,0,0,$dateM,1,$dateY);
        $month_end = mktime(24,0,0,$dateM,$dateNum,$dateY);
        $where_comment["comment_time"] = array(array('EGT',$month_start),array('ELT',$month_end));

        if($grade) {
            if($class) {
                $map["c.classid"]=$class;
            }else{
                $cla=array();
                $class_arr=M("school_class")->where("grade=$grade")->field("id")->select();
                foreach ($class_arr as &$classid) {
                    $c=$classid["id"];
                    array_push($cla, $c);
                }
                $map["c.classid"]=array("in",$cla);
            }

        }

		//获取班级年级信息
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
            $grade_item = M("school_grade")->where("id=$item_gid")->select();
            array_push($grade_q,$grade_item);
            unset($grade_item);
        }

        //获取老师教的所有学生
        $count = M('wxtuser')
            ->alias("student")
            ->join("wxt_teacher_class a ON a.teacherid=$userid")
            ->join("wxt_school_class s ON s.id=a.classid")
            ->join("wxt_class_relationship c ON c.userid=student.id AND s.id=c.classid")
            ->where($map)
            ->count();
        $page = $this -> page($count, 20);
        $all_students = M('wxtuser')
            ->alias("student")
            ->join("wxt_teacher_class a ON a.teacherid=$userid")
            ->join("wxt_school_class s ON s.id=a.classid")
            ->join("wxt_class_relationship c ON c.userid=student.id AND s.id=c.classid")
            ->where($map)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("student.id,student.name,student.sex,student.phone,student.photo,s.classname as classname")
            ->select();
        foreach ($all_students as &$all_student_item){
            //查询每个学生的点评情况
            $where_comment["studentid"] = $all_student_item["id"];
            $teacher_comment = M("teacher_comment")->alias("comment")
                ->join("wxt_wxtuser user ON user.id=comment.teacher_id")
                ->field("comment.*,user.name as teachername")
                ->where($where_comment)->select();
            $all_student_item["teachercomments"] = $teacher_comment;

            //設置每個元素顯示的月份日期
            $all_student_item["show_time"] = $show_time;
        }

        $this->assign("show_time",$show_time);
        $this->assign("class",$class_q);
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("Page", $page->show('Admin'));   // 添加分页
		$this->assign("lists",$all_students);
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