<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class ClassSubjectController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();



    }

	public function index(){
		//用户信息
		$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        //var_dump("schoolid=".$schoolid);
        $classid=I("classid");
        $level= $_SESSION['level'];



        if($level!=1  && $level!=2)
        {
            $where_class['teacher.schoolid'] = $schoolid;
            $where_class['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON s.id=teacher.classid';
        }
        $where_class['s.schoolid'] = $schoolid;
        $class=M('school_class')->alias("s")->join($join_duty)->where($where_class)->field("s.id,s.classname")->order("s.id asc")->select();

        if($classid){
          $this->assign('class_id',$classid);
           //先获取班级所在的年级id
           $gradeid=M('school_class')->field("grade,classname")->where("id=$classid")->find();
           $classname=$gradeid["classname"];
           //然后通过年级查出本年级都有哪些科目
          $school = M("school")->where("schoolid=$schoolid")->find();
            //var_dump($school);
            $schooltype = $school['schoolgradetypeid'];
           //var_dump($schooltype);

             $where['gradetype'] = $schooltype;
       
        

            $data['gradetype'] = 0;

            $data['schoolid'] = $schoolid;

          
             $where_c['gradetype'] = 0;
             $where_c['schoolid'] = 0;
             $where_c['isdefault'] = 0;
       


            $subject_add = M('default_subject')->where($data)->select();
            //var_dump($subject_add);

            $default = M('default_subject')->where($where)->select();

            $currency = M("default_subject")->where($where_c)->select();
              //exit();
             //拼接两数组
            $subject= array_merge($default,$subject_add);

            $subject = array_merge($currency,$subject);
            //var_dump($lesson_name);
             $sub = M('subject')->field('subjectid,schoolid')->select();
        //开始循环 如果相等将生成新数组
            foreach ($sub as $key=>$val){
              foreach ($subject as $ke=>$va){
                      if ($val['subjectid']==$va['id'] && $val['schoolid']==$schoolid){
                          $lesson_name[]=$va;
                      }
              }
          }

           

        }else{
        	//科目首页默认班级
        	$gradeid=M('school_class')->alias("s")->join($join_duty)->field("s.id,s.grade,s.classname")->where($where_class)->limit(1)->find();
          $this->assign('class_id',$gradeid['id']);

        	$classid=$gradeid["id"];
        	$classname=$gradeid["classname"];
        	//然后通过年级查出本年级都有哪些科目
            $school = M("school")->where("schoolid=$schoolid")->find();
            //var_dump($school);
            $schooltype = $school['schoolgradetypeid'];
           // var_dump($schooltype);

             $where['gradetype'] = $schooltype;
       
        

          $data['gradetype'] = 0;

          $data['schoolid'] = $schoolid;


             $where_c['gradetype'] = 0;
             $where_c['schoolid'] = 0;
             $where_c['isdefault'] = 0;

          $subject_add = M('default_subject')->where($data)->select();
          //var_dump($subject_add);

          $default = M('default_subject')->where($where)->select();
            //exit();
        
          //通用科目
         $currency = M("default_subject")->where($where_c)->select();

           $subject= array_merge($default,$subject_add);

           $subject = array_merge($currency,$subject);
          //var_dump($lesson_name);
           $sub = M('subject')->field('subjectid,schoolid')->select();

          foreach ($sub as $key=>$val){
            foreach ($subject as $ke=>$va){
                    if ($val['subjectid']==$va['id'] && $val['schoolid']==$schoolid){
                        $lesson_name[]=$va;
                    }
            }
        }

  
            
        }
           //课程表--第一节课
           $where_one["c.syllabus_no"]=1;
           $where_one["c.classid"]=$classid;
           $monday_one=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.monday=a.id")->where($where_one)->field("a.id,a.subject")->find();
           $this->assign("monday_one",$monday_one);
           $tuesday_one=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.tuesday=a.id")->where($where_one)->field("a.id,a.subject")->find();
           $this->assign("tuesday_one",$tuesday_one);
           $wednesday_one=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.wednesday=a.id")->where($where_one)->field("a.id,a.subject")->find();
           $this->assign("wednesday_one",$wednesday_one);
           $thursday_one=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.thursday=a.id")->where($where_one)->field("a.id,a.subject")->find();
           $this->assign("thursday_one",$thursday_one);
           $friday_one=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.friday=a.id")->where($where_one)->field("a.id,a.subject")->find();
           $this->assign("friday_one",$friday_one);
           $saturday_one=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.saturday=a.id")->where($where_one)->field("a.id,a.subject")->find();
           $this->assign("saturday_one",$saturday_one);
           $sunday_one=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.sunday=a.id")->where($where_one)->field("a.id,a.subject")->find();
           $this->assign("sunday_one",$sunday_one);



           //课程表--第二节课
           $where_two["c.syllabus_no"]=2;
           $where_two["c.classid"]=$classid;
           $monday_two=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.monday=a.id")->where($where_two)->field("a.id,a.subject")->find();
           $this->assign("monday_two",$monday_two);
           $tuesday_two=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.tuesday=a.id")->where($where_two)->field("a.id,a.subject")->find();
           $this->assign("tuesday_two",$tuesday_two);
           $wednesday_two=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.wednesday=a.id")->where($where_two)->field("a.id,a.subject")->find();
           $this->assign("wednesday_two",$wednesday_two);
           $thursday_two=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.thursday=a.id")->where($where_two)->field("a.id,a.subject")->find();
           $this->assign("thursday_two",$thursday_two);
           $friday_two=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.friday=a.id")->where($where_two)->field("a.id,a.subject")->find();
           $this->assign("friday_two",$friday_two);
           $saturday_two=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.saturday=a.id")->where($where_two)->field("a.id,a.subject")->find();
           $this->assign("saturday_two",$saturday_two);
           $sunday_two=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.sunday=a.id")->where($where_two)->field("a.id,a.subject")->find();
           $this->assign("sunday_two",$sunday_two);



          //课程表--第三节课
           $where_three["c.syllabus_no"]=3;
           $where_three["c.classid"]=$classid;
           $monday_three=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.monday=a.id")->where($where_three)->field("a.id,a.subject")->find();
           $this->assign("monday_three",$monday_three);
           $tuesday_three=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.tuesday=a.id")->where($where_three)->field("a.id,a.subject")->find();
           $this->assign("tuesday_three",$tuesday_three);
           $wednesday_three=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.wednesday=a.id")->where($where_three)->field("a.id,a.subject")->find();
           $this->assign("wednesday_three",$wednesday_three);
           $thursday_three=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.thursday=a.id")->where($where_three)->field("a.id,a.subject")->find();
           $this->assign("thursday_three",$thursday_three);
           $friday_three=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.friday=a.id")->where($where_three)->field("a.id,a.subject")->find();
           $this->assign("friday_three",$friday_three);
           $saturday_three=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.saturday=a.id")->where($where_three)->field("a.id,a.subject")->find();
           $this->assign("saturday_three",$saturday_three);
           $sunday_three=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.sunday=a.id")->where($where_three)->field("a.id,a.subject")->find();
           $this->assign("sunday_three",$sunday_three);



          //课程表--第四节课
           $where_four["c.syllabus_no"]=4;
           $where_four["c.classid"]=$classid;
           $monday_four=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.monday=a.id")->where($where_four)->field("a.id,a.subject")->find();
           $this->assign("monday_four",$monday_four);
           $tuesday_four=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.tuesday=a.id")->where($where_four)->field("a.id,a.subject")->find();
           $this->assign("tuesday_four",$tuesday_four);
           $wednesday_four=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.wednesday=a.id")->where($where_four)->field("a.id,a.subject")->find();
           $this->assign("wednesday_four",$wednesday_four);
           $thursday_four=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.thursday=a.id")->where($where_four)->field("a.id,a.subject")->find();
           $this->assign("thursday_four",$thursday_four);
           $friday_four=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.friday=a.id")->where($where_four)->field("a.id,a.subject")->find();
           $this->assign("friday_four",$friday_four);
           $saturday_four=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.saturday=a.id")->where($where_four)->field("a.id,a.subject")->find();
           $this->assign("saturday_four",$saturday_four);
           $sunday_four=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.sunday=a.id")->where($where_four)->field("a.id,a.subject")->find();
           $this->assign("sunday_four",$sunday_four);



           //课程表--第五节课
           $where_five["c.syllabus_no"]=5;
           $where_five["c.classid"]=$classid;
           $monday_five=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.monday=a.id")->where($where_five)->field("a.id,a.subject")->find();
           $this->assign("monday_five",$monday_five);
           $tuesday_five=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.tuesday=a.id")->where($where_five)->field("a.id,a.subject")->find();
           $this->assign("tuesday_five",$tuesday_five);
           $wednesday_five=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.wednesday=a.id")->where($where_five)->field("a.id,a.subject")->find();
           $this->assign("wednesday_five",$wednesday_five);
           $thursday_five=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.thursday=a.id")->where($where_five)->field("a.id,a.subject")->find();
           $this->assign("thursday_five",$thursday_five);
           $friday_five=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.friday=a.id")->where($where_five)->field("a.id,a.subject")->find();
           $this->assign("friday_five",$friday_five);
           $saturday_five=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.saturday=a.id")->where($where_five)->field("a.id,a.subject")->find();
           $this->assign("saturday_five",$saturday_five);
           $sunday_five=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.sunday=a.id")->where($where_five)->field("a.id,a.subject")->find();
           $this->assign("sunday_five",$sunday_five);



           //课程表--第六节课
           $where_six["c.syllabus_no"]=6;
           $where_six["c.classid"]=$classid;
           $monday_six=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.monday=a.id")->where($where_six)->field("a.id,a.subject")->find();
           $this->assign("monday_six",$monday_six);
           $tuesday_six=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.tuesday=a.id")->where($where_six)->field("a.id,a.subject")->find();
           $this->assign("tuesday_six",$tuesday_six);
           $wednesday_six=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.wednesday=a.id")->where($where_six)->field("a.id,a.subject")->find();
           $this->assign("wednesday_six",$wednesday_six);
           $thursday_six=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.thursday=a.id")->where($where_six)->field("a.id,a.subject")->find();
           $this->assign("thursday_six",$thursday_six);
           $friday_six=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.friday=a.id")->where($where_six)->field("a.id,a.subject")->find();
           $this->assign("friday_six",$friday_six);
           $saturday_six=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.saturday=a.id")->where($where_six)->field("a.id,a.subject")->find();
           $this->assign("saturday_six",$saturday_six);
           $sunday_six=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.sunday=a.id")->where($where_six)->field("a.id,a.subject")->find();
           $this->assign("sunday_six",$sunday_six);



           //课程表--第七节课
           $where_seven["c.syllabus_no"]=7;
           $where_seven["c.classid"]=$classid;
           $monday_seven=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.monday=a.id")->where($where_seven)->field("a.id,a.subject")->find();
           $this->assign("monday_seven",$monday_seven);
           $tuesday_seven=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.tuesday=a.id")->where($where_seven)->field("a.id,a.subject")->find();
           $this->assign("tuesday_seven",$tuesday_seven);
           $wednesday_seven=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.wednesday=a.id")->where($where_seven)->field("a.id,a.subject")->find();
           $this->assign("wednesday_seven",$wednesday_seven);
           $thursday_seven=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.thursday=a.id")->where($where_seven)->field("a.id,a.subject")->find();
           $this->assign("thursday_seven",$thursday_seven);
           $friday_seven=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.friday=a.id")->where($where_seven)->field("a.id,a.subject")->find();
           $this->assign("friday_seven",$friday_seven);
           $saturday_seven=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.saturday=a.id")->where($where_seven)->field("a.id,a.subject")->find();
           $this->assign("saturday_seven",$saturday_seven);
           $sunday_seven=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.sunday=a.id")->where($where_seven)->field("a.id,a.subject")->find();
           $this->assign("sunday_seven",$sunday_seven);



           //课程表--第八节课
           $where_eight["c.syllabus_no"]=8;
           $where_eight["c.classid"]=$classid;
           $monday_eight=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.monday=a.id")->where($where_eight)->field("a.id,a.subject")->find();
           $this->assign("monday_eight",$monday_eight);
           $tuesday_eight=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.tuesday=a.id")->where($where_eight)->field("a.id,a.subject")->find();
           $this->assign("tuesday_eight",$tuesday_eight);
           $wednesday_eight=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.wednesday=a.id")->where($where_eight)->field("a.id,a.subject")->find();
           $this->assign("wednesday_eight",$wednesday_eight);
           $thursday_eight=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.thursday=a.id")->where($where_eight)->field("a.id,a.subject")->find();
           $this->assign("thursday_eight",$thursday_eight);
           $friday_eight=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.friday=a.id")->where($where_eight)->field("a.id,a.subject")->find();
           $this->assign("friday_eight",$friday_eight);
           $saturday_eight=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.saturday=a.id")->where($where_eight)->field("a.id,a.subject")->find();
           $this->assign("saturday_eight",$saturday_eight);
           $sunday_eight=M('class_syllabus')->alias("c")->join("wxt_default_subject a ON c.sunday=a.id")->where($where_eight)->field("a.id,a.subject")->find();
           $this->assign("sunday_eight",$sunday_eight);
        //}
		//选择班级
       //    var_dump($classid);
		//$class=M('school_class')->where("schoolid=$schoolid")->order("id asc")->select();
		$this->assign("class",$class);
		$this->assign("class_id",$classid);
		// $this->assign("syllabus_one",$syllabus_one);
		// $this->assign("syllabus_two",$syllabus_two);
		// $this->assign("syllabus_three",$syllabus_three);
		// $this->assign("syllabus_four",$syllabus_four);
		// $this->assign("syllabus_five",$syllabus_five);
		// $this->assign("syllabus_six",$syllabus_six);
		// $this->assign("syllabus_seven",$syllabus_seven);
		// $this->assign("syllabus_eight",$syllabus_eight);
    //var_dump($lesson_name);
		$this->assign("lesson_name",$lesson_name);
		$this->assign("classname",$classname);
		$this->display();
	}

	public function add(){
		
    //echo "dasdas";
    $userid=$_SESSION['USER_ID'];
   $schoolid=$_SESSION['schoolid'];
		$class_id=I("class_id");
		dump($class_id);

		$syllabus_model=M('class_syllabus');
   // var_dump($syllabus_model);

		$sub=$syllabus_model->where("classid=$class_id")->select();
  dump($sub);
//    exit();
		if($sub){
			$where_a["classid"]=$class_id;
			$where_a["syllabus_no"]=1;
			$data_a['classid']=$class_id;
			$data_a['schoolid']=$schoolid;
            $data_a['monday']=$_POST['mon_fir'];
            $data_a['tuesday']=$_POST['tu_fir'];
            $data_a['wednesday']=$_POST['we_fir'];
            $data_a['thursday']=$_POST['th_fir'];
            $data_a['friday']=$_POST['fri_fir'];
            $data_a['saturday']=$_POST['sat_fir'];
            $data_a['sunday']=$_POST['sun_fir'];
            $data_a['syllabus_no']="1";
            //var_dump($data_a);
            //exit();
            $res_a=$syllabus_model->where($where_a)->save($data_a);

            $where_b["classid"]=$class_id;
			$where_b["syllabus_no"]=2;
            $data_b['classid']=$class_id;
            $data_b['schoolid']=$schoolid;
            $data_b['monday']=$_POST['mon_se'];
            $data_b['tuesday']=$_POST['tu_se'];
            $data_b['wednesday']=$_POST['we_se'];
            $data_b['thursday']=$_POST['th_se'];
            $data_b['friday']=$_POST['fri_se'];
            $data_b['saturday']=$_POST['sat_se'];
            $data_b['sunday']=$_POST['sun_se'];
            $data_b['syllabus_no']="2";
            $res_b=$syllabus_model->where($where_b)->save($data_b);

            $where_c["classid"]=$class_id;
			$where_c["syllabus_no"]=3;
            $data_c['classid']=$class_id;
            $data_c['schoolid']=$schoolid;
            $data_c['monday']=$_POST['mon_th'];
            $data_c['tuesday']=$_POST['tu_th'];
            $data_c['wednesday']=$_POST['we_th'];
            $data_c['thursday']=$_POST['th_th'];
            $data_c['friday']=$_POST['fri_th'];
            $data_c['saturday']=$_POST['sat_th'];
            $data_c['sunday']=$_POST['sun_th'];
            $data_c['syllabus_no']="3";
            $res_c=$syllabus_model->where($where_c)->save($data_c);

            $where_d["classid"]=$class_id;
			$where_d["syllabus_no"]=4;
            $data_d['classid']=$class_id;
            $data_d['schoolid']=$schoolid;
            $data_d['monday']=$_POST['mon_fo'];
            $data_d['tuesday']=$_POST['tu_fo'];
            $data_d['wednesday']=$_POST['we_fo'];
            $data_d['thursday']=$_POST['th_fo'];
            $data_d['friday']=$_POST['fri_fo'];
            $data_d['saturday']=$_POST['sat_fo'];
            $data_d['sunday']=$_POST['sun_fo'];
            $data_d['syllabus_no']="4";
            $res_d=$syllabus_model->where($where_d)->save($data_d);

            $where_e["classid"]=$class_id;
			$where_e["syllabus_no"]=5;
            $data_e['classid']=$class_id;
            $data_e['schoolid']=$schoolid;
            $data_e['monday']=$_POST['mon_fi'];
            $data_e['tuesday']=$_POST['tu_fi'];
            $data_e['wednesday']=$_POST['we_fi'];
            $data_e['thursday']=$_POST['th_fi'];
            $data_e['friday']=$_POST['fri_fi'];
            $data_e['saturday']=$_POST['sat_fi'];
            $data_e['sunday']=$_POST['sun_fi'];
            $data_e['syllabus_no']="5";
            $res_e=$syllabus_model->where($where_e)->save($data_e);

            $where_f["classid"]=$class_id;
			$where_f["syllabus_no"]=6;
            $data_f['classid']=$class_id;
            $data_f['schoolid']=$schoolid;
            $data_f['monday']=$_POST['mon_si'];
            $data_f['tuesday']=$_POST['tu_si'];
            $data_f['wednesday']=$_POST['we_si'];
            $data_f['thursday']=$_POST['th_si'];
            $data_f['friday']=$_POST['fri_si'];
            $data_f['saturday']=$_POST['sat_si'];
            $data_f['sunday']=$_POST['sun_si'];
            $data_f['syllabus_no']="6";
            $res_f=$syllabus_model->where($where_f)->save($data_f);

            $where_g["classid"]=$class_id;
			$where_g["syllabus_no"]=7;
            $data_g['classid']=$class_id;
            $data_g['schoolid']=$schoolid;
            $data_g['monday']=$_POST['mon_seve'];
            $data_g['tuesday']=$_POST['tu_seve'];
            $data_g['wednesday']=$_POST['we_seve'];
            $data_g['thursday']=$_POST['th_seve'];
            $data_g['friday']=$_POST['fri_seve'];
            $data_g['saturday']=$_POST['sat_seve'];
            $data_g['sunday']=$_POST['sun_seve'];
            $data_g['syllabus_no']="7";
            $res_g=$syllabus_model->where($where_g)->save($data_g);

            $where_h["classid"]=$class_id;
			$where_h["syllabus_no"]=8;
            $data_h['classid']=$class_id;
            $data_h['schoolid']=$schoolid;
            $data_h['monday']=$_POST['mon_ei'];
            $data_h['tuesday']=$_POST['tu_ei'];
            $data_h['wednesday']=$_POST['we_ei'];
            $data_h['thursday']=$_POST['th_ei'];
            $data_h['friday']=$_POST['fri_ei'];
            $data_h['saturday']=$_POST['sat_ei'];
            $data_h['sunday']=$_POST['sun_ei'];
            $data_h['syllabus_no']="8";
            $res_h=$syllabus_model->where($where_h)->save($data_h);
            // if($res_a){
            // 	$this->success("保存成功");
            // }else{
            // 	$this->error("保存失败");
            // }
           $this->success("课程表保存成功!");
		}else{
			 // echo "Sdasdsad";
    //    exit();

      $data_a['classid']=$class_id;
			$data_a['schoolid']=$schoolid;
            $data_a['monday']=$_POST['mon_fir'];
            $data_a['tuesday']=$_POST['tu_fir'];
            $data_a['wednesday']=$_POST['we_fir'];
            $data_a['thursday']=$_POST['th_fir'];
            $data_a['friday']=$_POST['fri_fir'];
            $data_a['saturday']=$_POST['sat_fir'];
            $data_a['sunday']=$_POST['sun_fir'];
            $data_a['syllabus_no']="1";
            // var_dump($data_a);
            // exit();
            $res_a=$syllabus_model->add($data_a);
            // var_dump($res_a);

            $data_b['classid']=$class_id;
            $data_b['schoolid']=$schoolid;
            $data_b['monday']=$_POST['mon_se'];
            $data_b['tuesday']=$_POST['tu_se'];
            $data_b['wednesday']=$_POST['we_se'];
            $data_b['thursday']=$_POST['th_se'];
            $data_b['friday']=$_POST['fri_se'];
            $data_b['saturday']=$_POST['sat_se'];
            $data_b['sunday']=$_POST['sun_se'];
            $data_b['syllabus_no']="2";
            $res_b=$syllabus_model->add($data_b);

            $data_c['classid']=$class_id;
            $data_c['schoolid']=$schoolid;
            $data_c['monday']=$_POST['mon_th'];
            $data_c['tuesday']=$_POST['tu_th'];
            $data_c['wednesday']=$_POST['we_th'];
            $data_c['thursday']=$_POST['th_th'];
            $data_c['friday']=$_POST['fri_th'];
            $data_c['saturday']=$_POST['sat_th'];
            $data_c['sunday']=$_POST['sun_th'];
            $data_c['syllabus_no']="3";
            $res_c=$syllabus_model->add($data_c);

            $data_d['classid']=$class_id;
            $data_d['schoolid']=$schoolid;
            $data_d['monday']=$_POST['mon_fo'];
            $data_d['tuesday']=$_POST['tu_fo'];
            $data_d['wednesday']=$_POST['we_fo'];
            $data_d['thursday']=$_POST['th_fo'];
            $data_d['friday']=$_POST['fri_fo'];
            $data_d['saturday']=$_POST['sat_fo'];
            $data_d['sunday']=$_POST['sun_fo'];
            $data_d['syllabus_no']="4";
            $res_d=$syllabus_model->add($data_d);

            $data_e['classid']=$class_id;
            $data_e['schoolid']=$schoolid;
            $data_e['monday']=$_POST['mon_fi'];
            $data_e['tuesday']=$_POST['tu_fi'];
            $data_e['wednesday']=$_POST['we_fi'];
            $data_e['thursday']=$_POST['th_fi'];
            $data_e['friday']=$_POST['fri_fi'];
            $data_e['saturday']=$_POST['sat_fi'];
            $data_e['sunday']=$_POST['sun_fi'];
            $data_e['syllabus_no']="5";
            $res_e=$syllabus_model->add($data_e);

            $data_f['classid']=$class_id;
            $data_f['schoolid']=$schoolid;
            $data_f['monday']=$_POST['mon_si'];
            $data_f['tuesday']=$_POST['tu_si'];
            $data_f['wednesday']=$_POST['we_si'];
            $data_f['thursday']=$_POST['th_si'];
            $data_f['friday']=$_POST['fri_si'];
            $data_f['saturday']=$_POST['sat_si'];
            $data_f['sunday']=$_POST['sun_si'];
            $data_f['syllabus_no']="6";
            $res_f=$syllabus_model->add($data_f);

            $data_g['classid']=$class_id;
            $data_g['schoolid']=$schoolid;
            $data_g['monday']=$_POST['mon_seve'];
            $data_g['tuesday']=$_POST['tu_seve'];
            $data_g['wednesday']=$_POST['we_seve'];
            $data_g['thursday']=$_POST['th_seve'];
            $data_g['friday']=$_POST['fri_seve'];
            $data_g['saturday']=$_POST['sat_seve'];
            $data_g['sunday']=$_POST['sun_seve'];
            $data_g['syllabus_no']="7";
            $res_g=$syllabus_model->add($data_g);

            $data_h['classid']=$class_id;
            $data_h['schoolid']=$schoolid;
            $data_h['monday']=$_POST['mon_ei'];
            $data_h['tuesday']=$_POST['tu_ei'];
            $data_h['wednesday']=$_POST['we_ei'];
            $data_h['thursday']=$_POST['th_ei'];
            $data_h['friday']=$_POST['fri_ei'];
            $data_h['saturday']=$_POST['sat_ei'];
            $data_h['sunday']=$_POST['sun_ei'];
            $data_h['syllabus_no']="8";
            $res_h=$syllabus_model->add($data_h);
            $this->success("课程表保存成功!");
		}
	}
}