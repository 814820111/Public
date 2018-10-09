<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
header("Content-type:text/html;charset=utf-8");
class SelectionController extends TeacherbaseController
{
    function _initialize()
    {
        parent::_initialize();
        $this->userid = $_SESSION['USER_ID'];
        $this->schoolid = $_SESSION['schoolid'];
        $this->level = $_SESSION['level'];
        $this->grade = D("Common/school_grade");
        $this->class = D("Common/school_class");
        $this->selection = D("Common/selection");
        $this->selection_course = D("Common/selection_course");
        $this->selection_elective = D("Common/selection_elective");
        $this->selection_elective_node = D("Common/selection_elective_node");
        $this->selection_student_class = D("Common/selection_student_class");
        $this->selection_class_manage = D("Common/selection_class_manage");

    }

    public function index()
    {
        //学校id
        $schoolid = $_SESSION['schoolid'];

        $semesterid = I("semester");

        if($semesterid)
        {
            $where['sele.semesterid'] = $semesterid;
        }

        //查询出学期
        $semester = M("semester")->select();

        $where['sele.schoolid'] = $schoolid;

        $selection = $this->selection
            ->alias("sele")
            ->join("wxt_semester seme ON sele.semesterid = seme.id")
            ->where($where)
            ->field("sele.*,seme.semester")
            ->select();

        $this->assign("selection", $selection);
        $this->assign("semester", $semester);
        $this->assign("semesterid",$semesterid);
//        $this->assign("html", $html);

        $this->display();
//        echo "教务选课";
        exit();
    }


    public function AddSelect()
    {
        //如果学期id为空的话
        if (I("semesterid") == false) {
            $info['status'] = 'false';
            $info['msg'] = '必要参数丢失,请重新提交!';

            echo json_encode($info);
            exit();
        }

        $data['semesterid'] = I("semesterid");
        $data['begintime'] = strtotime(I("begintime"));
        $data['endtime'] = strtotime(I("endtime"));
        $data['days'] = I("workNum");
        $data['enroll_audit'] = I("checkType");
        $data['auditor'] = I("checkTypeTwo");
        $data['days'] = I("workNum");
        $data['morning'] = I("forenoon");
        $data['afternoon'] = I("afternoon");
        $data['evening'] = I("evening");
        $data['schoolid'] = $_SESSION['schoolid'];

        if(I("select_id"))
        {
            $this->selection->where(array("id"=>I("select_id")))->save($data);
            echo json_encode($this->json_info(1,"修改成功！"));
            exit();
        }

        $addselect = $this->selection->add($data);

        if ($addselect) {
            $info['status'] = true;
            $info['msg'] = "添加成功";
        } else {
            $info['status'] = false;
            $info['msg'] = "添加错误!";
        }
        echo json_encode($info);
    }

    //修改
    public function edit()
    {
        $id = I("id");
        if (!$id) {
            $info = $this->json_info(0, "参数丢失,请重新提交!");
            echo json_encode($info);
            exit();
        }

        $ed_result = $this->selection
            ->alias("sele")
            ->join("wxt_semester seme ON sele.semesterid = seme.id")
            ->where("sele.id=$id")
            ->field("sele.*,seme.semester")
            ->find();
        if ($ed_result) {
            $ret = $this->json_info(1, "OK", $ed_result);
            echo json_encode($ret);
            exit();
        }

    }


    public function ShowClass()
    {
        echo "查询该班级是否有相同节次 是的话返回true,否则false,空的话默认返回true";
    }


    public function ClickNodeDel()
    {
        $selection = I("selection");
        $xuankeStr = I("xuankeStr");
        $classid = trim(I("classIds"), ",");

        $where['selection'] = $selection;
        $where['class_position'] = $xuankeStr;
        $where['classid'] = $classid;
        $show_node = $this->selection_elective_node->where($where)->find();
        if($show_node)
        {
            echo json_encode($this->json_info(1,"confilt"));
            exit();
        }else{
            echo json_encode($this->json_info(0,"no"));
            exit();
        }

    }

    //开设选修班
    public function OpenXuan()
    {

    }

    //判断所选班级有无设置选课时间
    public function XuanClass()
    {
        //还需要传总表id

         //总表id
        $selection= I("selection");


        //班级id
        $classid = trim(I("classIds"), ",");

       if(!$classid)
       {
           echo json_encode($this->json_info(1,'kong'));
           exit();
       }

        $array = explode(",",$classid);

        //节次
        $poid = trim(I("xuankeStrs"), ";");



        $position = explode(";", $poid);

          //查询出获取到的班级id
        $result =  $this->getCate($array,$selection);

        echo json_encode($result);



    }


    function getCate($data,$selection)
    {
//    dump(count($data));
        $arr = array();
        $i = 0;
        if (!$data)
        {
            return $info = array("status"=>true,"msg"=>"kong");
        }

        foreach ($data as $key=>$val) {

            $person = $this->selection_course->where(array("classid" => $val,"selection"=>$selection))->field("node_position")->select();

            $res = $this->multi_array_sort($person,'node_position',SORT_ASC,SORT_STRING);

              $i++;
              if($i>1)
              {
                 $end = end($arr);
                 $arr1 = $this->array_reset($end);

                   $arr2 =$this->array_reset($res);

                 if($arr1!=$arr2)
                 {
                     return $info = array("status"=>true,"msg"=>"needRemove");
                 }
              }

               array_push($arr,$res);
        }

        return $info = array("status"=>true,"msg"=>$this->selection_course->where(array("classid" => $data[count($data)-1],"selection"=>$selection))->field("node_position")->select());
    }

   //数组排序
    function multi_array_sort($arr,$shortKey,$short=SORT_DESC,$shortType=SORT_REGULAR)
{
    foreach ($arr as $key => $data){
        $name[$key] = $data[$shortKey];
    }
    array_multisort($name,$shortType,$short,$arr);
    return $arr;
}


    public function array_reset($array)
    {
//        dump($array);
        foreach($array as $k=>$v){
            foreach($v as $key=>$val){
                $arr2[]=$val;
            }
        }
        return $arr2;
    }

//清空原选课
   public function node_empty()
   {
       $selection= I("selection");


       //班级id
       $classid = trim(I("classIds"), ",");

       $map['classid'] = array("in",$classid);
       $map['selection'] = $selection;

       $show_node = $this->selection_elective_node->where($map)->select();
       if($show_node)
       {
           $info['status'] = true;
           $info['msg'] ="confilt";
       }else{
           $del_map['classid'] = array("in",$classid);
           $del_map['selection'] = $selection;
           $del_map['type'] = 1;
           $this->selection_course->where($map)->delete();
       }
       echo json_encode($info);



   }


   //添节次 todo提交时要先删除选中班级的所有节次还没做，记住！
    public function add_node()
    {
        //学校id
        $schoolid = $_SESSION['schoolid'];
        $poid = trim(I("xuankeStrs"), ";");

        $classid = trim(I("classIds"), ",");

        $selection = I("selection");

        if (!$poid || !$classid || !$selection) {
            $info = $this->json_info(0, "参数丢失,请重新提交!");
            echo json_encode($info);
            exit();
        }
        $array = explode(",",$classid);
        $position = explode(";", $poid);
        $map['classid'] = array("in",$classid);
        $map['selection'] = $selection;
        $map['schoolid'] = $schoolid;
        $this->selection_course->where($map)->delete();

        //节次
      foreach($array as $value)
      {
          foreach($position as $val)
          {
              $data['schoolid'] = $schoolid;
              $data['selection'] = $selection;
              $data['classid'] = $value;
              $data['node_position'] = $val;
              $data['type'] = 1;
              $alldata[] = $data;

              unset($data);
          }
      }
        $result = $this->selection_course->addAll($alldata);

      if($result)
      {
          echo json_encode($this->json_info(1, "保存成功"));
      }else{
          echo json_encode($this->json_info(0, "保存失败，请刷新页面"));
      }

    }

    public function set_node()
    {
      //学校id
        $schoolid = $_SESSION['schoolid'];
        //总表id
        $id = I("id");

        //学期id
        $semesterid = I("semesterid");

        $teacher_name = I("teacher_name");

        if($teacher_name)
        {
           $teacher_id = "";
            $where_info["name"]=array("LIKE","%".$teacher_name."%");
            $where_info['schoolid'] = $schoolid;
            $teacher = M("teacher_info")->where($where_info)->field("id")->select();
            if($teacher)
            {
              foreach($teacher as $value)
              {

                  $teacher_id=$value['id'].",".$teacher_id;
              }
                $teacher_id = trim($teacher_id, ",");
            }
            $where['e.teacherid'] = array("in",$teacher_id);
        }


        //课程id
        $subjectid = I("subject");
        if($subjectid)
        {
            $where['e.subjectid'] = $subjectid;
        }

        //查询学期
        $semester = M("semester")->select();

        //获取该学校老师
        $teacher_info = M("teacher_info")->where("schoolid = $schoolid")->select();

        $where['e.schoolid'] = $schoolid;
        $where['e.selection'] = $id;



        //获取选修班 todo 教室还没加和上！
        $elective =  $this->selection_elective
                  ->alias("e")
                  ->join("wxt_semester semest ON semest.id=e.semesterid")
                  ->join("wxt_default_subject subject ON subject.id=e.subjectid")
                  ->join("wxt_teacher_info info ON info.id=e.teacherid")
                  ->field("semest.semester,subject.subject,info.name,e.class_time,e.num,e.id,e.selection")
                  ->where($where)
                  ->select();

        foreach($elective as &$value)
        {

          //获取班级已报人数
            $signup = $this->selection_student_class->where(array("electiveid"=>$value['id'],"type"=>3))->count();

            $value['singup'] = $signup;
            $value['remain'] = $value['num'] - $signup;
            $value['audit'] = $this->selection_student_class->where(array("electiveid"=>$value['id'],"type"=>2))->count();

        }





        //获取课程
        $this->assign("subject",$this->get_subject($schoolid));
        $this->assign("subjectid",$subjectid);
        $this->assign("teacher_name",$teacher_name);
        //这边放着的是id而不是teacherid
        $this->assign("teacher",$teacher_info);
        //上课地点先空着,这边做好在添加
        $this->assign("semesterid",$semesterid);
        $this->assign("elective",$elective);
        $this->assign("selection",$id);
        $this->assign("semester",$semester);
        $this->display();
    }

    //删除节次设置
    public function node_delete()
    {
        $id = I("id");
        if(!$id)
        {
            $this->error("必要参数不存在！");
        }
        //删除选修表
        $elective = $this->selection_elective->where("id = $id and schoolid = $this->schoolid")->delete();
        if($elective)
        {
            //删除选修选课表
            $elective_node = $this->selection_elective_node->where("electiveid = $id")->delete();
            if($elective_node)
            {
                //删除班级学生表
                $student_class = $this->selection_student_class->where("schoolid = $this->schoolid and electiveid = $id")->delete();

                //再删除设置班级人数表
                $this->selection_class_manage->where("electiveid = $id")->delete();
                $this->success("删除成功！");

            }
        }else{
            $this->error("删除失败！");
        }

    }

    public function get_se_node()
    {

        $id = I("id");
        $schoolid = $_SESSION['schoolid'];
        if (!$id) {
            $info = $this->json_info(0, "参数丢失,请重新提交!");
            echo json_encode($info);
            exit();
        }
        //获取班级列表以及节次
        $info = $this->get_node_class($id,$schoolid,2);

        if($info['status']==true)
        {
            echo json_encode($info);
        }else{
            echo json_encode($this->json_info(0,"数据获取失败!"));
        }

    }

//获取课程
    public function get_subject($schoolid)
    {
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
        $data['isdefault'] = 1;


        $where_c['gradetype'] = 0;
        $where_c['schoolid'] = 0;
        $where_c['isdefault'] = 0;

        //自建科目
        $subject_add = M('default_subject')->where($data)->select();

        //var_dump($subject_add);
        //学校类型科目

        $default = M('default_subject')->where($where)->select();
        // var_dump($default);
        //通用科目
        $currency = M("default_subject")->where($where_c)->select();
        // var_dump($currency);
        // var_dump($subject);
        //发送到前台的集合
        $subject = array_merge($default,$subject_add);

        $subject = array_merge($currency,$subject);
        return $subject;
    }

    public function NodeClass()
    {
        $classid = trim(I("classIds"), ",");

        $selection = I("selection");
        $xuankeStrs = I("xuankeStrs");
        if(!$classid)
        {
            echo json_encode($this->json_info(1,'kong'));
            exit();
        }
        $array = explode(",",$classid);

        //节次
        $poid = trim(I("xuankeStrs"), ";");


        //开设选休班与设置节次不同，如果有数据为空则直接返回false;
        foreach($array as $val)
        {
            $class = $this->selection_course->where("classid = $val and selection = $selection")->find();
            if(!$class)
            {
                $info['status'] = true;
                $info['msg'] = "needRemove";
                echo json_encode($info);
                exit();
            }
        }


        $position = explode(";", $poid);

        //查询出获取到的班级id
        $result =  $this->getCate($array,$selection);

        echo json_encode($result);
    }

    public function AddClassNode()
    {

        $classid = trim(I("classIds"), ",");

        $selection = I("selection");
        $xuankeStrs = I("xuankeStrs");
        $elective = I("elective");

        if(!$classid || !$selection)
        {
            echo json_encode($this->json_info(1,'必要参数缺失！'));
            exit();
        }
       $term = I("term");

        $subject = I("subject");
        $classroomid = I("classroomid");
        $teacher = I("teacher");
        $sum =I("sum");

        $poid = trim($xuankeStrs, ";");


        $position = explode(";", $poid);

        $array = explode(",",$classid);

       $class_time = $this->get_class_time($position);

       $data['selection'] = $selection;
       $data['semesterid'] = I("semester");
       $data['subjectid'] = $subject;
       $data['schoolid'] = $_SESSION['schoolid'];
       $data['class_time'] =$class_time;
       $data['teacherid'] = $teacher;
       $data['classroomid'] =$classroomid;
       $data['num'] = $sum;
       $data['courseIntroduce'] = I("courseIntroduce");

       if($elective)
       {
            $this->selection_elective->where("id = $elective")->save($data);
           echo json_encode($this->json_info(1, "修改成功"));
           exit();
       }


       $add_elective = $this->selection_elective->add($data);


       if($add_elective)
       {
         //将学生加入学生选课表
           $this->addStudentClass($array,$add_elective);

          //插入班级人数管理表
           $this->addClassNum($array,$add_elective);
           //先删除原有的
//           $map['classid'] = array("in",$classid);
//           $map['selection'] = $selection;
//           $this->selection_elective_node->where($map)->delete();
//
//           dump($array);
//           dump($position);
           foreach($array as $value)
           {
               foreach($position as $val)
               {
                   $node_data['selection'] = $selection;
                   $node_data['classid'] = $value;
                   $node_data['teacherid'] = $teacher;
                   $node_data['electiveid'] = $add_elective;
                   $node_data['class_position'] = $val;
                   $node_data['type'] = 1;
                   $alldata[] = $node_data;
                   unset($data);
               }
           }
//           dump($alldata);
           $result = $this->selection_elective_node->addAll($alldata);
           if($result)
           {
               echo json_encode($this->json_info(1, "保存成功"));
           }else{
               echo json_encode($this->json_info(0, "保存失败，请刷新页面"));
           }


       }

    }

    public function getConfilt()
    {
        $teacherid = I("teacherid");

        $xuankeStrs = I("xuankeStrs");

        $selection = I("selection");

        if(!$teacherid || !$xuankeStrs || !$selection)
        {
            echo json_encode($this->json_info(0, "必要参数缺失！"));
            exit();
        }

        $teacher_node = $this->teacher_node($selection,$xuankeStrs,$teacherid);


       // $teacher_node = $this->selection_elective_node->where(array("selection"=>$selection,"class_position"=>$xuankeStrs,"teacherid"=>$teacherid))->find();
        if($teacher_node['istrue']==true)
        {
          $info['status'] = true;
          $info['msg'] = 'no';
          $info['data'] = $teacher_node['data'];
        }else{
            $info['status'] = true;
            $info['msg'] = yes;

        }

        echo json_encode($info);


    }

    /**
     * @param $selection 总表id
     * @param $xuankeStrs 选课位置
     * @param $teacherid 老师id
     */

    private function teacher_node($selection,$xuankeStrs,$teacherid)
    {
        $china = array( '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chinas = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $arr = array("a"=>"上午","p"=>"下午","n"=>"晚上");

        $poid = trim($xuankeStrs, ";");

        $position = explode(";", $poid);

        foreach($position as $value)
        {

            $teacher_node = $this->selection_elective_node->where(array("selection"=>$selection,"class_position"=>$value,"teacherid"=>$teacherid))->select();
//            dump($teacher_node);
            if($teacher_node)
            {
                foreach($teacher_node as &$val) {
                    $splice = explode(",", $val['class_position']);


                    $val['china_node'] = "周" . $china[$splice[1]] . $arr[substr($splice[0], 0, 1)] . "第" . $chinas[substr($splice[0], 1, 2)] . "节";
                }
                $info['istrue'] = true;
                $info['msg'] = "no";
                $info['data'] = $teacher_node;
                return $info;
            }
        }

    }

    private function addClassNum($class,$electiveid)
    {
          foreach($class as $value)
          {
              $data['electiveid'] = $electiveid;
              $data['classid'] = $value;
              $alldata[] = $data;
              unset($data);
          }
        $this->selection_class_manage->addAll($alldata);
    }

    public function ClassNum()
    {
        $electiveid = I("electiveid");
        if(!$electiveid)
        {
            echo json_encode($this->json_info(1,'必要参数缺失！'));
            exit();
        }

        $class = $this->selection_class_manage->alias("m")->join("wxt_school_class class ON m.classid=class.id")->field("m.*,class.classname")->where("m.electiveid = $electiveid")->select();

        $info['status'] = 1;
        $info['msg'] = '拉取成功！';
        $info['data'] = $class;
        $info['electiveid'] = $electiveid;

        echo json_encode($info);


    }

    public function editClassNum()
    {
        $electiveid = I("electiveid");


        if(!$electiveid)
        {
            echo json_encode($this->json_info(0,'必要参数缺失！'));
            exit();
        }
        $class_num = I("class_num");
        if($class_num)
        {
            foreach($class_num as $key=>$value)
            {
                $this->selection_class_manage->where(array("electiveid"=>$electiveid,"classid"=>$key))->save(array("num"=>$value));
            }
        }
        echo json_encode($this->json_info(1,'修改成功！'));
        exit();

    }
    private function addStudentClass($class,$electiveid)
    {
        $schoolid = $this->schoolid;
        //查询出这些班级的学生
        $map['classid'] = array("in",$class);
        $map['schoollid'] = $schoolid;
        $student = M("student_info")->where($map)->select();
        foreach($student as $value)
        {
            //学生id
            $studentid = $value['userid'];
            $check =$this->selection_student_class->where("schoolid = $schoolid and studentid = $studentid and electiveid = $electiveid")->find();
            if($check)
            {
                $data['type'] = 3;
            }
            $data['schoolid'] = $schoolid;
            $data['studentid'] = $studentid;
            $data['electiveid'] = $electiveid;
            $data['classid'] = $value['classid'];
            $alldata[] = $data;
            unset($data);
        }
        $this->selection_student_class->addAll($alldata);
    }
    //获取上课时间
    private function get_class_time($position)
    {


        $china = array( '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chinas = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $arr = array("a"=>"上午","p"=>"下午","n"=>"晚上");
        $class_time = "";

        foreach($position as $value)
        {

          $splice = explode(",",$value);

        $class_time = $class_time."周".$china[$splice[1]].$arr[substr($splice[0],0,1)]."第".$chinas[substr($splice[0],1,2)]."节".";";
//          for ()
        }
    return $class_time;
    }

        //修改
    public function XuanEdit()
    {
        //学校id
        $schoolid = $_SESSION['schoolid'];
        //总表id
        $selectionid = I("selectionid");

        //选修班id
        $id = I("id");
       //查询出该记录的选修班
        if (!$id) {
            $info = $this->json_info(0, "参数丢失,请重新提交!");
            echo json_encode($info);
            exit();
        }
        $elective = $this->selection_elective->where("id = $id and schoolid = $schoolid")->find();
        //获取选修班次
        $selective_node = $this->selection_elective_node->where("electiveid = $id")->field("classid,class_position")->select();

        foreach($selective_node as $value)
        {
            $arr[] = $value['classid'];
            $node[] = $value['class_position'];

        }
        //去重
        $classid = array_unique($arr);


        //获取班级列表以及节次
        $info = $this->get_node_class($selectionid,$schoolid,2,1);

        if($info['status']==true)
        {
            $info['check_classid'] =$classid;
            $info['elective_node'] =$node;
            $info['elective'] =$elective;

            echo json_encode($info);
        }else{
            echo json_encode($this->json_info(0,"数据获取失败!"));
        }

    }

    //选修学生管理
    public function XuanAddStu()
    {
//        $type = array("1"=>"自由","2"=>"审核中","3"=>"通过");
        //学校id
        $electiveid = I("electiveid");

        $classid = I("classid");




        $student_name = I("student_name");

        $stu_type = I("stu_type");

        if($classid)
        {
            $where['student_class.classid'] = $classid;
        }
        if($stu_type)
        {
            $where['student_class.type'] = $stu_type;
        }
        if($student_name)
        {
            $student_id = "";
            $where_info["stu_name"]=array("LIKE","%".$student_name."%");
            $where_info['schoollid'] = $this->schoolid;

            $student = M("student_info")->where($where_info)->field("userid")->select();
            if($student)
            {
                foreach($student as $value)
                {

                    $student_id=$value['userid'].",".$student_id;
                }
                $student_id = trim($student_id, ",");
            }
            $where['student_class.studentid'] = array("in",$student_id);
        }



//        dump($electiveid);
        $where['student_class.electiveid'] = $electiveid;
        $count = $this->selection_student_class
            ->alias("student_class")
            ->where($where)
            ->join("wxt_student_info info ON student_class.studentid=info.userid")
            ->join("wxt_school_class class ON info.classid=class.id")
            ->field("student_class.id,student_class.type,info.stu_name,class.classname")
            ->count();

        $page = $this->page($count, 10);
       $student_class = $this->selection_student_class
                      ->alias("student_class")
                      ->where($where)
                      ->join("wxt_student_info info ON student_class.studentid=info.userid")
                      ->join("wxt_school_class class ON info.classid=class.id")
                      ->field("student_class.id,student_class.electiveid,student_class.type,info.stu_name,class.classname,student_class.studentid")
                      -> limit($page -> firstRow . ',' . $page -> listRows)
                      ->select();


        foreach($student_class as &$value)
        {
          $studentid = $value['studentid'];
          $where_stu['schoolid'] = $this->schoolid;
          $where_stu['studentid'] = $studentid;
          $where_stu['type'] = 3;

          $where_stu['electiveid'] = array('not in',$value['electiveid']);

          $stu = $this->selection_student_class->where($where_stu)->find();
          if($stu)
          {
              $value['type'] = 4;
          }
        }
        $Page[] =  $page -> show('Admin');
        $result = array_merge($Page,$student_class);

        //获取该选修的班级
        $class = $this->selection_class_manage
               ->alias("manage")
               ->join("wxt_school_class class ON class.id=manage.classid")
               ->where("manage.electiveid = $electiveid")
               ->field("class.id,class.classname")
               ->select();

//     dump($class);
        if($result)
        {
            $info['status'] = true;
            $info['msg'] = "获取成功";
            $info['data'] = $result;
            $info['class'] =$class;
            echo json_encode($info);
           exit();
        }else{
            echo json_encode($this->json_info(0,"获取失败!"));
            exit();
        }

//        echo  json_encode($this->json_info(1,"获取成功",$this->stu_deal($result)));

    }

    public function select_type()
    {
        $selectid = I("selectid");

        $type = I("type");
        if(!$selectid)
        {
            echo json_encode($this->json_info(1,'必要参数缺失！'));
            exit();
        }
        $edit_type = $this->selection_student_class->where("id = $selectid")->save(array("type"=>$type));

        if($type)
        {
            echo json_encode($this->json_info(1,"操作成功！"));
            exit();
        }else{
            echo json_encode($this->json_info(0,"操作失败！"));
            exit();
        }
    }


    private function stu_deal($array)
    {
           $html = "";
            $html .="<table>";
            $html .= "<tr>";
            $html .= "<th>姓名</th>";
            $html .= "<th>班级</th>";
            $html .= "<th>状态</th>";
            $html .= "<th>操作</th>";
            $html .= "</tr>";
            foreach($array as $key =>$value)
            {
                if($key==0)
                {
                    continue;
                }
             $html .="<tr>";
             $html .="<td>".$value['stu_name']."</td>";
             $html .="<td>".$value['classname']."</td>";
             $html .="<td>".$value['type']."</td>";
             $html .="<td><a>添加</a><a>删除</a></td>";
             $html .="</tr>";
            }
             $html.="</table>";
            $html.="<div class=\"pagination\">$array[0]</div>";

       return $html;
    }


    public function XuanDel()
    {

    }

    //查询该学期是否已经选课   TODO 只有学期  直接根据学期id和schoolid 去判断是否已经设置,现在想法是一个学期只能添加一次选课
    public function getSetting()
    {

        //获取传过来的id
        $semesterid = I("semesterid");
        //学校id
        $schoolid = $_SESSION['schoolid'];
        if (!$semesterid) {
            echo json_encode($this->json_info(0, "必要参数丢失!"));
            exit();
        }

        $ed_result = $this->selection
            ->alias("sele")
            ->join("wxt_semester seme ON sele.semesterid = seme.id")
            ->where("sele.semesterid=$semesterid and sele.schoolid = $schoolid")
            ->field("sele.*,seme.semester")
            ->find();

        if ($ed_result) {
            echo json_encode($this->json_info(1, "当前学年学期已有设置，是否对其进行修改", $ed_result));
            exit();
        }

    }

        public function getXuanKe()
      {
        $id = I("id");
        $schoolid = $_SESSION['schoolid'];
        if (!$id) {
            $info = $this->json_info(0, "参数丢失,请重新提交!");
            echo json_encode($info);
            exit();
        }
        //获取班级列表以及节次
      $info =  $this->get_node_class($id,$schoolid,1);
        if($info['status']==true)
        {
            echo json_encode($info);
        }else{
            echo json_encode($this->json_info(0,"数据获取失败!"));
        }


    }

    protected function get_node_class($id,$schoolid,$type,$check)
    {
        //获取该学校的年级
        $grade = $this->grade->where("schoolid = $schoolid")->field("id,name,gradeid")->select();
        //给年级数组添加parentid,先用系统自带的树状类
        foreach ($grade as $val) {
            $val['parentid'] = 1;
        }
        $arr = array(array("name" => "全校", "parentid" => '0', "grade" => '0', "level" => '0'));

        //获取该学校的班级
        $class = $this->class->where("schoolid = $schoolid")->field("id,grade as parentid,classname as name")->select();
        //查询班级是否已经有设置选课;
        $new_class = $this->new_Clas($class,$id);

        foreach ($grade as &$item) {
            $item['type'] = 1;
        }
        $res = array_merge($arr, $grade);


        //获取学校年级班级列表
        $class_html = $this->deal_arr($res,$new_class,$type,$check);


        //获取选课节时
        $cours_html = $this->getDays($id,$schoolid,$type);

        if($class_html && $cours_html)
        {
            $info['status'] =true;
            $info['class_html'] = $class_html;
            $info['cours_html'] = $cours_html;

            return $info;

        }else{
            $info['status'] =false;
            return false;
        }
    }

    //获取节次天数，及设置节数
    public function getDays($id, $schoolid,$color_type)
    {
        $id = $id;
        $schoolid = $schoolid;
        $china = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        //查询出此次记录的天数
        $selection = $this->selection->where("id = $id and schoolid = $schoolid")->find();
        $html_days = "";
        $html_days .= "<tr>";
        $html_days .= "<th>节次星期</th>";
        //天数
        for ($i = 1; $i <= $selection['days']; $i++) {

            $html_days .= "<th>$china[$i]</th>";

        }
        $html_days .= "</tr>";
        $html_days .= $this->getNode($selection['days'], "上午", $selection['morning'], 0,$color_type);
        $html_days .= $this->getNode($selection['days'], "下午", $selection['afternoon'], 1,$color_type);
        $html_days .= $this->getNode($selection['days'], "晚上", $selection['evening'], 1,$color_type);
        return $html_days;

    }
    public function new_Clas($class,$selection)
    {
        if($class)
        {
          foreach($class as &$value)
          {
             $classid = $value['id'];

             $course = $this->selection_course->where("classid = $classid and selection = $selection")->find();



             if($course)
             {
                 $value['course'] = 1;
             }
          }

          return $class;

        }else{
            echo "参数有误！";
        }
    }


    //上午,还需要加入选课设置表
    public function getNode($days,$str,$num,$type,$color_type)
    {

    $arr = array("上午"=>"a","下午"=>"p","晚上"=>"n");
        $html = "";
        if($type)
        {
            $html.="<tr><th colspan=\"8\"></th></tr>";
        }
        //外层课时,里层天数
        for ($i = 1; $i<=$num; $i++)
        {
          $html .="<tr>";
            $html .="<th>";
                $html.=$str."第".$i."节";
            for ($j = 0; $j<$days; $j++)
            {
                if($color_type!=2)
                {
                    $html.="<td onclick=\"changeColor(this);\">";
                }else{
                    $html.="<td >";
                }
             $html.="<div class='tdText'></div>";
             $html.="<span>$arr[$str]$i,$j</span>";
             $html.="</td>";

            }
            $html .="</th>";
           $html .="</tr>";

        }

      return $html;

    }
    //重组年级班级数组;
    public function deal_arr($arr,$class,$type,$check)
     {
        foreach($arr as $key=>&$val)
        {
            if($val['type']==1)
            {
                $val['count'] = 1;
                $val['level'] = 1;
            }
            $val['tid'] = $key+1;
        }

        foreach($arr as $key=>&$v)
        {
            $count = 0;
            foreach($class as $item)
            {

                if($v['gradeid']==$item['parentid'])
                {
                    $item['count'] = 2;
                    $item['level'] = 2;
                    $arr[$key]['child']['_child'.$count]= $item;
                    $count++;
                }


            }
        }

   return   $this->getArray($arr,$type,$check);

     }

    private function getArray($result,$type,$check)
    {

        $html = '<table  width="100%" cellspacing="0" id="dnd-example">';

        foreach ($result as $val)
        {

            $spacer = str_repeat('&nbsp', $val['count'] * 4);
            $name = $val['name'];
            $id = $val['id'];

            $level = $val['level'];

            $html .= "<tr id='$id' \$parentid_node>
                       <td style=''>$spacer<input type='checkbox' name='menuid[]'   level='$level' \$checked onclick='javascript:checknode(this,$check);'> $name</td>
                    </tr>";

            if(isset($val['child']))
            {
                foreach ($val['child'] as $child)
                {
                    $spacers = str_repeat('&nbsp', $child['count'] * 4);
                    $child_name= $child['name'];
                    $id = $child['id'];
                    $child_level = $child['level'];
                    if($child['course']==1 && $type != 2)
                    {

                        $color = "color:rgb(159, 53, 255)";
                    }else{
                        $color = "";
                    }

                    $html .= "<tr id='$id' \$parentid_node>
                       <td style='$color'>   $spacers<input type='checkbox' name='menuid[]' value=$id level='$child_level' \$checked onclick='javascript:checknode(this,$check);'> $child_name</td>
                    </tr>";
                }
            }

        }
        $html.="</table>";
        return $html;
    }

    //教务-教室
    public function teacher()
    {
        //学校id
        $schoolid = $_SESSION['schoolid'];
        //总表id
        $id = I("id");
        //学期id
//        $semesterid = I("semesterid");

        //查询学期
        $semester = M("semester")->select();

        $teacher_name = I("teacher_name");

        if($teacher_name)
        {
            $teacher_id = "";
            $where_info["name"]=array("LIKE","%".$teacher_name."%");
            $where_info['schoolid'] = $schoolid;
            $teacher = M("teacher_info")->where($where_info)->field("id")->select();
            if($teacher)
            {
                foreach($teacher as $value)
                {

                    $teacher_id=$value['id'].",".$teacher_id;
                }
                $teacher_id = trim($teacher_id, ",");
            }
            $where['e.teacherid'] = array("in",$teacher_id);
        }


        //课程id
        $subjectid = I("subject");
        if($subjectid)
        {
            $where['e.subjectid'] = $subjectid;
        }


        //获取该学校老师
        $teacher_info = M("teacher_info")->where("schoolid = $schoolid")->select();

        $where['e.schoolid'] = $schoolid;

        //获取选修班 todo 教室还没加和上！
        $elective =  $this->selection_elective
            ->alias("e")
            ->join("wxt_semester semest ON semest.id=e.semesterid")
            ->join("wxt_default_subject subject ON subject.id=e.subjectid")
            ->join("wxt_teacher_info info ON info.id=e.teacherid")
            ->field("semest.semester,subject.subject,info.name,e.class_time,e.num,e.id,e.selection")
            ->where($where)
            ->select();

        foreach($elective as &$value)
        {

            //获取班级已报人数
            $signup = $this->selection_student_class->where(array("electiveid"=>$value['id'],"type"=>3))->count();

            $value['singup'] = $signup;
            $value['remain'] = $value['num'] - $signup;
            $value['audit'] = $this->selection_student_class->where(array("electiveid"=>$value['id'],"type"=>2))->count();

        }



        //获取课程
        $this->assign("subject",$this->get_subject($schoolid));
        //这边放着的是id而不是teacherid
        $this->assign("teacher",$teacher_info);
        $this->assign("subjectid",$subjectid);
        $this->assign("teacher_name",$teacher_name);
        //上课地点先空着,这边做好在添加
        $this->assign("semesterid",$semesterid);
        $this->assign("elective",$elective);
        $this->assign("selection",$id);
        $this->assign("semester",$semester);
        $this->display();
    }


    public function arr_merge($arr1,$arr2)
    {
          $arr = array();
          foreach($arr1 as $k=>$r)
          {
              $arr[] = array_merge($r,$arr2[$k]);
          }


          return $arr;
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

    //json 简单返回值
    private function json_info($status,$value,$data='')
    {
        if($status)
        {
            $info['status'] = true;
            $info['msg'] = $value;
            $info['data'] = $data;

        }else{
            $info['status'] = false;
            $info['msg'] = $value;
            $info['data'] = $data;
        }
        return $info;
    }
}