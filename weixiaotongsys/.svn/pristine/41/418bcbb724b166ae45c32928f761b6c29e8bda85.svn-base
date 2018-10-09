<?php

/**
 * 课件管理
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class CoursewareController extends TeacherbaseController {


    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }


	function add()
	{

		$school_class=M('school_class');
		$default_subject=M('default_subject');
		
		$wxtuser=M('wxtuser');
		session_start();
        $userid=$_SESSION["USER_ID"];
        $wxtuser_find=$wxtuser->where(array("id"=>$userid))->field("schoolid")->find();
        $schoolid=$wxtuser_find['schoolid'];
//		$class=$school_class->where(array("schoolid"=>$schoolid))->field("id,classname")->order("id")->select();

		


    $where['schoolid'] = $schoolid;
        
        $where['schoolid'] = 0;

       // $where['gradetype'] =
   
        $school = M('school')->where("schoolid=$schoolid")->find();

        $gradetype = $school['schoolgradetypeid'];
        //var_dump($gradetype);
        $where['gradetype'] =$gradetype;
       
        //var_dump($school);


        $data['gradetype'] = 0;
        $data['schoolid'] = $schoolid;

        $subject_add = M('default_subject')->where($data)->select();
        //var_dump($subject_add);

        $default = M('default_subject')->where($where)->select();
        
       // var_dump($subject);
        //发送到前台的集合
        $subject = array_merge($default,$subject_add);





		// $subject=$default_subject->field("id,subject")->select();
		//var_dump($subject);
       // exit();

        if($this->level!=1  && $this->level!=2)
        {
            $class=M("teacher_class")
                ->alias('t')
                ->join("wxt_school_class s ON t.classid=s.id")
                ->where("t.teacherid=$userid")
                ->field("s.classname,s.id,s.grade")
                ->order("id")->select();



        }else{
            $class=M("school_class")
                ->where("schoolid = $schoolid")->select();

        }


 // var_dump($subject);
		$this->assign("class",$class);
		$this->assign("subject",$subject);
		$this->display("add");
	}


	function add_post()
	{
		// 共享班级
		$class_share_all=I('class_share_all');
		$subject_re=I('subject_re');
		$title=I('title');
		$content=I('content');
		$courseware_time=time();


		$school_class=M('school_class');
		$school_courseware=M('school_courseware');
		$school_courseware_pic=M('school_courseware_pic');
		$wxtuser=M('wxtuser');

		session_start();
        $userid=$_SESSION["USER_ID"];
        $wxtuser_find=$wxtuser->where(array("id"=>$userid))->field("schoolid")->find();
        $schoolid=$wxtuser_find['schoolid'];

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

		$classid_array=explode(",", $class_share_all);
		
		foreach ($classid_array as &$val) {
			$classid=$val;
			$class_find=$school_class->where(array("id"=>$classid))->find();
			if($class_find)
			{
				$data['schoolid']=$schoolid;
				$data['classid']=$classid;
				$data['user_id']=$userid;
				$data['subjectid']=$subject_re;
				$data['courseware_title']=$title;
				$data['courseware_content']=$content;
				$data['courseware_time']=$courseware_time;
				$data['courseware_status']=1;
				$courseware_id=$school_courseware->add($data);
				if($courseware_id)
				{
					$data_p['courseware_id']=$courseware_id;
					$data_p['picture_url']=$photo;
					$school_courseware_pic->add($data_p);
					$this->success("发布成功",'index');
				}
			}
		}



	}


	function index()
	{

        $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];


		$subject = M("subject");
		$school_courseware=M('school_courseware');
		$school_courseware_pic=M('school_courseware_pic');
		$school_class=M('school_class');
//		$class_id=$school_class->field('classname,grade,id')->where("schoolid=$schoolid")->select();
       // var_dump($class_id);
       //exit();
		//获取该学校的科目
		$subject_list=$subject->alias("sb")
            ->join("wxt_default_subject dsb ON sb.subjectid=dsb.id")
            ->where("sb.schoolid=$schoolid")
            ->field("dsb.id,dsb.subject")->select();

// var_dump($subject_list);
		$grade=I('grade');
		$class=I('class');

		$subject_re=I('subject_re');

		$start_time=I('start_time');
        $end_time=I('end_time');
        $start_time_unix=strtotime($start_time);//将任何英文文本的日期或时间描述解析为 Unix 时间戳
        $end_time_unix=strtotime($end_time);

		$map=array();
        if($start_time_unix && $end_time_unix){
            $map["courseware_time"]=array(array('EGT',$start_time_unix),array('ELT',$end_time_unix));
            $this->assign("start_time_unix",$start_time_unix);
            $this->assign("end_time_unix",$end_time_unix);
        }
//        if($class)
//        {
//        	$map["classid"]=$class;
//        }
//        if($grade)
//        {
//        	$map["classid"]=$grade;
//        }
        if($subject_re)
        {
            $map["subjectid"]=$subject_re;
            $this->assign("subjectinfo",$subject_re);
        }
        if($grade) {
            if($class) {
                $map["classid"]=$class;
            }else{
                $cla=array();
                $class_arr=M("school_class")->where("grade=$grade")->field("id")->select();
                foreach ($class_arr as &$classid) {
                    $c=$classid["id"];
                    array_push($cla, $c);
                }
                $map["classid"]=array("in",$cla);
            }
            $this->assign("gradeinfo",$grade);

        }
         
         $map['schoolid'] = $schoolid;
        if($this->level!=1  && $this->level!=2)
        {
            $map['user_id'] = $this -> userid;


        }


        $count=$school_courseware
		->field("courseware_id,classid,subjectid,courseware_title,courseware_content,courseware_time")
		->order("courseware_id desc")
		->where($map)
		->count();
		$page = $this->page($count, 20);


		$lists=$school_courseware
		->field("courseware_id,classid,subjectid,courseware_title,courseware_content,courseware_time")
		->order("courseware_id desc")
		->where($map)
		->limit($page->firstRow . ',' . $page->listRows)   // 添加分页
		->select();
		// var_dump($lists);
		foreach ($lists as &$val) {
			$classid=$val['classid'];
			$school_class_id=$school_class->where(array("id"=>$classid))->field('classname,grade')->find();
			
			$val['classname']=$school_class_id['classname'];

			$subjectid=$val['subjectid'];
			$subject_name=M("default_subject")->where(array("id"=>$subjectid))->field("subject")->find();
			$val['subjectname']=$subject_name['subject'];

			$grade_class_id = $school_class_id["grade"];
			$grade_class_name =  M("school_grade")->where(array("schoolid"=>$schoolid,"gradeid"=>$grade_class_id))->field("name")->find();
			// var_dump($grade_class_name);
			$val["gradename"] = $grade_class_name["name"];
		}

        //zsq_获取班级年级信息

        $grade_q =  M("school_grade")->where(array("schoolid"=>$schoolid))->select();
//        $class_q=M("teacher_class")
//            ->alias('t')
//            ->join("wxt_school_class s ON t.classid=s.id")
//            ->where("t.teacherid=$userid")
//            ->field("s.classname,s.id,s.grade")
//            ->order("id")->select();
        
//        foreach ($class_q as &$item){
//            $item_gid= $item['grade'];
//            $grade_item = M("school_grade")->where(array("schoolid"=>$schoolid,"gradeid"=>$item_gid))->select();
//            array_push($grade_q,$grade_item);
//            unset($grade_item);
//        }

        $this->assign("categorys",$grade_q);
        $this->assign("classinfo",$class);
       // var_dump($grade_q);
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("Page", $page->show('Admin'));   // 添加分页
		$this->assign("subject_list",$subject_list);
		$this->assign("lists",$lists);
		$this->display("index");
	}


// 删除 activity 与 activity_pic 中的数据
	function shanchu()
	{
		$courseware_id=I('courseware_id');
		$school_courseware=M('school_courseware');
		$school_courseware_pic=M('school_courseware_pic');

		$school_courseware->where(array("courseware_id"=>$courseware_id))->delete();
		$school_courseware_pic->where(array("courseware_id"=>$courseware_id))->delete();
		$this->index();
	}


	function edit()
	{
		$courseware_id=I('courseware_id');
		$school_courseware=M('school_courseware');
		$school_courseware_pic=M('school_courseware_pic');
		$default_subject=M('default_subject');
		$school_class=M('school_class');

		$subject=$default_subject->field("id,subject")->select();

		$find_c=$school_courseware
		->where(array("courseware_id"=>$courseware_id))
		->field("courseware_id,classid,subjectid,courseware_title,courseware_content,courseware_time")
		->find();

		$classid=$find_c['classid'];
		$find_c_name=$school_class->where(array("id"=>$classid))->field("classname")->find();
		$find_c['classname']=$find_c_name['classname'];

		$subjectid=$find_c['subjectid'];
		$find_c_subject=$default_subject->where(array("id"=>$subjectid))->field("id,subject")->find();
		$find_c['subjectname']=$find_c_subject['subject'];
		$find_c['subjectid']=$find_c_subject['id'];



		$this->assign("find_c",$find_c);
		$this->assign("subject",$subject);
		$this->display("edit");

	}

	function edit_post()
	{

		$subject_re=I('subject_re');
		$title=I('title');
		$content=I('content');
		$courseware_id=I('courseware_id');
		$courseware_time=time();

		// 图片路径在 data/upload
		$_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
		$photo=$_POST['smeta']['thumb'];

		$school_courseware=M('school_courseware');
		$school_courseware_pic=M('school_courseware_pic');

		
		$data=null;
		$data_p=null;
		$data['subjectid']=$subject_re;
		$data['courseware_title']=$title;
		$data['courseware_content']=$content;
		$data['courseware_time']=$courseware_time;
		$school_courseware_save=$school_courseware->where(array("courseware_id"=>$courseware_id))->save($data);
		if($school_courseware_save)
		{
			if($photo&&$courseware_id)
			{
				$data_p['picture_url']=$photo;
				$school_courseware_pic_save=$school_courseware_pic->where(array("courseware_id"=>$courseware_id))->save($data_p);
			}
		}


		$this->error("修改成功");


		// $this->add();
		// echo $subject_re."___".$title."__".$content."___".$courseware_id."__".$photo;

	}







}