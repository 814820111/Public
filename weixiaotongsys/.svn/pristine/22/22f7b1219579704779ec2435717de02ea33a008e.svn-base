<?php

/**
 * 教师课程表
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class TeacherSubjectController extends TeacherbaseController {


    function _initialize() {
        parent::_initialize();

    }
	public function index(){
        $userid=$_SESSION['USER_ID'];
		$schoolid=$_SESSION['schoolid'];
        $level= $_SESSION['level'];
        if($level!=1  && $level!=2)
        {
            $where_teacher['d.schoolid'] = $schoolid;
            $where_teacher['d.teacher_id'] = $userid;

        }
        $where_teacher['w.schoolid'] = $schoolid;
		//获取本校老师
		$teacher=M("duty_teacher")->alias("d")->join("wxt_teacher_info w ON w.teacherid=d.teacher_id")->distinct(true)->where($where_teacher)->field("w.id,w.teacherid,w.name")->select();

//        $teacher = M("teacher_info")->alias("t")->join("wxt_duty_teacher")
		//获取前台传回的老师id(搜索功能)
		$teacherid=Intval(I("search_teacher"));
		if($teacherid){
			$where["teacherid"]=$teacherid;
			
		   $this->assign('tea_id',$teacherid);
		}else{
			$first_id=M("duty_teacher")->where("schoolid=$schoolid")->field("teacher_id")->find();
			$where["teacherid"]=$first_id["teacher_id"];
		
			$this->assign('tea_id',$first_id["teacher_id"]);
		}
		//先获取八节课,通过这八节课来进行八次循环
		$relation=M("class_syllabus")->field("syllabus_no")->distinct(true)->order("syllabus_no asc")->select();

		foreach ($relation as &$item) {
			$num=$item["syllabus_no"];
			$teacher_subject=M("teacher_subject")->where($where)->select();

			//通过班级来循环对比科目
			foreach ($teacher_subject as &$itvo) {
				$classid=$itvo["classid"];
				//星期一
				$where_monday["c.monday"]=$itvo["subjectid"];
				$where_monday["c.classid"]=$classid;
				$where_monday["c.syllabus_no"]=$num;
				$monday=M("class_syllabus")->alias("c")->join("wxt_default_subject d ON c.monday=d.id")->join("wxt_school_class s ON c.classid=s.id")->where($where_monday)->field("d.subject,s.classname")->find();

				$itvo["monday"]=$monday["subject"];
				$itvo["monday_classname"]=$monday["classname"];
				//星期二
				$where_tuesday["c.tuesday"]=$itvo["subjectid"];
				$where_tuesday["c.classid"]=$classid;
				$where_tuesday["c.syllabus_no"]=$num;
				$tuesday=M("class_syllabus")->alias("c")->join("wxt_default_subject d ON c.tuesday=d.id")->join("wxt_school_class s ON c.classid=s.id")->where($where_tuesday)->field("d.subject,s.classname")->find();
				$itvo["tuesday"]=$tuesday["subject"];
				$itvo["tuesday_classname"]=$tuesday["classname"];
				//星期三
				$where_wednesday["c.wednesday"]=$itvo["subjectid"];
				$where_wednesday["c.classid"]=$classid;
				$where_wednesday["c.    syllabus_no"]=$num;
				$wednesday=M("class_syllabus")->alias("c")->join("wxt_default_subject d ON c.wednesday=d.id")->join("wxt_school_class s ON c.classid=s.id")->where($where_wednesday)->field("d.subject,s.classname")->find();
				$itvo["wednesday"]=$wednesday["subject"];
				$itvo["wednesday_classname"]=$wednesday["classname"];
				//星期四
				$where_thursday["c.thursday"]=$itvo["subjectid"];
				$where_thursday["c.classid"]=$classid;
				$where_thursday["c.syllabus_no"]=$num;
				$thursday=M("class_syllabus")->alias("c")->join("wxt_default_subject d ON c.thursday=d.id")->join("wxt_school_class s ON c.classid=s.id")->where($where_thursday)->field("d.subject,s.classname")->find();
				$itvo["thursday"]=$thursday["subject"];
				$itvo["thursday_classname"]=$thursday["classname"];
				//星期五
				$where_friday["c.friday"]=$itvo["subjectid"];
				$where_friday["c.classid"]=$classid;
				$where_friday["c.syllabus_no"]=$num;
				$friday=M("class_syllabus")->alias("c")->join("wxt_default_subject d ON c.friday=d.id")->join("wxt_school_class s ON c.classid=s.id")->where($where_friday)->field("d.subject,s.classname")->find();
				$itvo["friday"]=$friday["subject"];
				$itvo["friday_classname"]=$friday["classname"];
				//星期六
				$where_saturday["c.saturday"]=$itvo["subjectid"];
				$where_saturday["c.classid"]=$classid;
				$where_saturday["c.syllabus_no"]=$num;
				$saturday=M("class_syllabus")->alias("c")->join("wxt_default_subject d ON c.saturday=d.id")->join("wxt_school_class s ON c.classid=s.id")->where($where_saturday)->field("d.subject,s.classname")->find();
				$itvo["saturday"]=$saturday["subject"];
				$itvo["saturday_classname"]=$saturday["classname"];
				//星期天
				$where_sunday["c.sunday"]=$itvo["subjectid"];
				$where_sunday["c.classid"]=$classid;
				$where_sunday["c.syllabus_no"]=$num;
				$sunday=M("class_syllabus")->alias("c")->join("wxt_default_subject d ON c.sunday=d.id")->join("wxt_school_class s ON c.classid=s.id")->where($where_sunday)->field("d.subject,s.classname")->find();
				$itvo["sunday"]=$sunday["subject"];
				$itvo["sunday_classname"]=$sunday["classname"];
				//获取班级名称
				$classname=M("school_class")->field("classname")->distinct(true)->where("id=$classid")->find();
				$itvo["classname"]=$classname["classname"];
			}
			$item["teacher_subject"]=$teacher_subject;
		}

// var_dump($teacher);
// var_dump($relation);
// exit();


		$this->assign("teacher",$teacher);
		// var_dump($teacher);
		$this->assign("relation",$relation);
		$this->display();
	}
}