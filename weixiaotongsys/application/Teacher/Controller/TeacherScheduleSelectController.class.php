<?php

/**
 * 老师排班
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
header("Content-type: text/html; charset=utf-8");
class TeacherScheduleSelectController extends TeacherbaseController {

    function _initialize()
    {
        parent::_initialize();
        $this->userid = $_SESSION['USER_ID'];
        $this->schoolid = $_SESSION['schoolid'];
        $this->level = $_SESSION['level'];
        $this->teacher_schedule = D("Common/teacher_schedule");
        $this->teacher_schedule_attendance = D("Common/teacher_schedule_attendance");
        $this->teacher_schedule_detail = D("Common/teacher_schedule_detail");
        $this->teacher_schedule_fixation = D("Common/teacher_schedule_fixation");
        $this->teacher_schedule_group = D("Common/teacher_schedule_group");
        $this->teacher_schedule_period = D("Common/teacher_schedule_period");
        $this->teacher_schedule_period_detail = D("Common/teacher_schedule_period_detail");
        $this->teacher_schedule_person = D("Common/teacher_schedule_person");
        $this->teacher_schedule_person_detail = D("Common/teacher_schedule_person_detail");

    }


    public function index()
    {
        $att_group =$this->teacher_schedule_group->where(array("schoolid"=>$this->schoolid))->select();



        foreach ($att_group as &$value)
        {
            $value['num'] = $this->teacher_schedule_person->where(array("groupid"=>$value['id']))->count();
            $value['att_time'] = $this->get_att_time($value['id'],$value['type']);
            $value['type_name'] = $value['type']==1?"固定班制":"排班制";

        }



        $this->assign("posts",$att_group);

        $this->display();
    }

    private function get_att_time($groupid,$type)
    {
        //如果为固定班次
        if($type==1)
        {
            $schedule =$this->teacher_schedule_fixation->where(array("groupid"=>$groupid))->select();
            $result =   [];  //初始化一个数组
            foreach($schedule as $k=>$v){

                $result[$v['scheduleid']][]    =   $v;  //根据initial 进行数组重新赋值

            }
            $week_group = "";

            foreach($result as $key=>&$value)
            {
              $dis =  $this->dis_att_arr($value);
              $value = $dis;
            }

            ksort($result);

        }else{
            $result = $this->teacher_schedule_attendance
                      ->alias("attendance")
                      ->join("wxt_teacher_schedule schedule ON schedule.id=attendance.scheduleid")
                      ->field("attendance.scheduleid,schedule.name")
                      ->where(array("groupid"=>$groupid))
                      ->select();

           foreach($result as &$value)
           {
            $value = $value['name'].$this->get_time($value['scheduleid']);
           }

        }

        return $result;
    }

    //处理固定班次
    private function dis_att_arr($arr)
    {

        $chinas = array('零', '一', '二', '三', '四', '五', '六', '日', '八', '九');

        $week = "";
        foreach ($arr as $key=> &$val)
        {
            $schedule_name = $this->teacher_schedule->where(array("id"=>$arr[0]['scheduleid']))->getField("name");
            $schedule_name = $schedule_name?$schedule_name.$this->get_time($arr[0]['scheduleid']):"休息";
            $week = $week."、".$chinas[$val['week']];
        }

      return   "每周".ltrim($week,"、")." ".$schedule_name;

    }

    public function add_group()
    {




       $this->display();
    }
    public function add_group_post()
    {
        //考勤组名称
        $group_name = I("att_name");


        //考勤组type
        $group_type = I("schedule");

        //参与考勤分组
        $att_group = trim(I("att_group"), ",");

        //参与考勤人员
        $att_userid = trim(I("att_userid"), ",");
//        dump($att_userid);
        //无需考勤人员
        $no_att_userid = trim(I("no_att_userid"), ",");
//        dump($no_att_userid);
         //获取考勤类型

       $schedule = I("schedule");
        //删除原有的分组信息
        if($att_group)
        {

            $this->del_person($att_group);

            $this->del_group($att_group);
            //查询出分组

        }


        //获取固定班次星期

        //获取固定班次

       $person =  $this->dis_group_person($att_group,$att_userid,$no_att_userid);
//       dump($person);


       //
        $data['name'] = $group_name;
        $data['type'] = $group_type;
        $data['schoolid'] = $this->schoolid;
        $att_group  =   $this->teacher_schedule_group->add($data);

        if($schedule==1)
        {
            $week = I("fixation_week");


            $schedule_fixation = I("schedule_fixation");


            $fixation = array_combine($week,$schedule_fixation);

           $this->schedule_fixation($att_group,$fixation);

        }else{
            //排班周期名称
            $period_name = I("period_name");
            //排班周期班次
            $scheduling = trim(I("scheduling"), ",");
            //排班周期天数
            $period_num = I("period_num");
           //排班周每天的班次
            $schedule_period = I("schedule_period");

            $this->schedule_period($att_group,$scheduling,$period_name,$period_num,$schedule_period);
        }

        //添加到考勤人员表
        $this->add_person($att_group,$person);
        $this->success("添加成功！",U('index'));

    }

    public function edit_group()
    {
        $groupid = I("id");
        $group = $this->teacher_schedule_group->where("id = $groupid")->find();

      $this->assign("groupid",$groupid);
      $this->assign("group",$group);
      $this->display();
    }

    public function edit_data()
    {
        $groupid = I("groupid");

        //查出考勤组

        $group = $this->teacher_schedule_group->where("id = $groupid")->find();

        //考勤类型

        $group_type = $group['type'];

        //考勤人员

        $person = $this->teacher_schedule_person->alias("person")->join("wxt_teacher_info info ON info.id=person.personid")->where("person.groupid = $groupid")->field("person.type,person.is_att,info.name,person.personid,person.teacher_groupid")->select();

//dump($person);

        foreach ($person as $key=>$value)
        {
            if($value['type']==2)
            {

               //查询出该分组
                $person[$key] = M("department")->where(array("id"=>$value['teacher_groupid']))->field("id as teacher_groupid,name,type")->find();

            }
        }
        $person = array_values($this->array_unset_tt_person($person,"teacher_groupid"));
//        dump($person);



        //获取班次
        $group_schedule =  $this->get_edit_schedule($groupid,$group_type);




        $info['status'] = true;
        $info['group'] = $group;
        $info['person'] = $person;
        $info['group_schedule'] = $group_schedule;
        if($group_type==2)
        {
            $schedule_period_detail = $this->teacher_schedule_attendance
                ->alias("attendance")
                ->join("wxt_teacher_schedule schedule ON attendance.scheduleid = schedule.id")
                ->where("attendance.groupid = $groupid")
                ->field("attendance.scheduleid,schedule.name")
                ->select();

            foreach($schedule_period_detail as &$value)
            {
                $value['att_time'] = $this->get_time($value['scheduleid']);
            }
            $info['schedule_period_detai'] = $schedule_period_detail;
        }

        echo json_encode($info);

    }

    //删除个人分组人员
    private function del_person($att_group)
    {

        if(in_array(1,explode(',',$att_group)))
        {

             //删除个人考勤人员表
            $this->teacher_schedule_person->where(array("schoolid"=>$this->schoolid,"type"=>1))->delete();

        }else{
            return false;
        }
    }

    //删除其他分组人员
    private function del_group($att_group)
    {
        $arr = "";
        //查询分组;
        if ($att_group) {
            $att_group = explode(",", $att_group);
            foreach ($att_group as $group) {
                if ($group == 1) {
                    continue;
                }
                //查询出分组
                $department_teacher = M("department_teacher")->field("teacher_id as id")->where(array("school_id" => $this->schoolid, "department_id" => $group))->select();

                if($department_teacher)
                {
                    foreach ($department_teacher as &$department) {
                        $arr = $arr.",".$department['id'];
                    }
                }


            }

            $where['personid'] = array("in",$arr);
            $where['schoolid'] = $this->schoolid;
            $where['type'] = 2;
             $this->teacher_schedule_person->where($where)->delete();
        }


        return $arr_group;
    }


    public function edit_post()
    {

      //分组id
      $groupid = I("groupid");

      //考勤类型
      $schedule = I("schedule");
        //参与考勤分组
        $att_group = trim(I("att_group"), ",");
        //参与考勤人员
        $att_userid = trim(I("att_userid"), ",");


        //无需考勤人员
        $no_att_userid = trim(I("no_att_userid"), ",");



       //判断是否需将原有分组人员删除
        if($att_group)
        {

           $this->del_person($att_group);

           $this->del_group($att_group);
            //查询出分组

        }





        //修改考勤分组
        $this->teacher_schedule_group->where(array("id"=>$groupid))->save(array("name"=>$_POST['att_name']));


        //一个老师只能有一个考勤打卡时间，根据schoolid和personid去删除
        //删除参与考勤人员和无需考勤人员
        $total_userid = $att_userid.",".$no_att_userid;


            $where_no_att['schoolid'] =$this->schoolid;
            $where_no_att['groupid'] = $groupid;
            $this->teacher_schedule_person->where($where_no_att)->delete();



        $where_total_user['schoolid'] = $this->schoolid;
        $where_total_user['personid'] = array("in",trim($total_userid,","));

        $this->teacher_schedule_person->where($where_total_user)->delete();


        if($att_group) {
            //删除考勤组
            $where_group['schoolid'] = $this->schoolid;
            $where_group['teacher_groupid'] = array("in", $att_group);

            $this->teacher_schedule_person->where($where_group)->delete();
            //获取固定班次

        }


        $person = $this->dis_group_person($att_group, $att_userid, $no_att_userid);



        if($schedule==1)
        {
            //删除原有节次
            $this->teacher_schedule_fixation->where(array("groupid"=>$groupid))->delete();

            $week = I("fixation_week");


            $schedule_fixation = I("schedule_fixation");


            $fixation = array_combine($week,$schedule_fixation);


            $this->schedule_fixation($groupid,$fixation);
        }else{

            //删除排班周期班次表
            $this->teacher_schedule_attendance->where(array("groupid"=>$groupid))->delete();

            //删除排班周期主表
            $this->teacher_schedule_period->where(array("groupid"=>$groupid))->delete();
            //删除排班周期详细表
            $this->teacher_schedule_period_detail->where(array("groupid"=>$groupid))->delete();

            //排班周期名称
            $period_name = I("period_name");
            //排班周期班次
            $scheduling = trim(I("scheduling"), ",");
            //排班周期天数
            $period_num = I("period_num");
            //排班周每天的班次
            $schedule_period = I("schedule_period");


            $this->schedule_period($groupid,$scheduling,$period_name,$period_num,$schedule_period);
        }
        //添加到考勤人员表
        $this->add_person($groupid,$person);

        $this->success("修改成功!",U('index'));

    }

    //删除分组
    public function group_del()
    {

        //获取分组id
        $groupid =  I("id");
        if(!$groupid)
        {
            $this->error("分组不存在！");
            exit();
        }
        //获取排班类型
        $type = I("type");
        //删除分组总表
       $group_del = $this->teacher_schedule_group->where(array("id"=>$groupid))->delete();
        //如果为固定排班
        if($type==1)
        {
            //删除固定班次表
            $this->teacher_schedule_fixation->where(array("groupid"=>$groupid))->delete();
           //删除人员表
            $this->teacher_schedule_person->where(array("groupid"=>$groupid))->delete();
        }else{
         //如果为排班制

            //删除排班班次表
            $this->teacher_schedule_attendance->where(array("groupid"=>$groupid))->delete();
            //删除排班周期总表
            $this->teacher_schedule_period->where(array("groupid"=>$groupid))->delete();
            //删除排班周期详细表
            $this->teacher_schedule_period_detail->where(array("groupid"=>$groupid))->delete();
            //删除人员表
            $this->teacher_schedule_person->where(array("groupid"=>$groupid))->delete();
            //删除排班人员详细表
            $this->teacher_schedule_person_detail->where(array("groupid"=>$groupid))->delete();
        }

        if($group_del)
        {
            $this->success("删除成功！");
        }else{
            $this->error("删除失败");
        }

    }
    //获取排班周期或固定班次
    private function get_edit_schedule($groupid,$group_type)
    {
         if($group_type==1)
         {
             $group_schedule = $this->teacher_schedule_fixation
                             ->alias("fixation")
                              ->join("LEFT JOIN wxt_teacher_schedule schedule ON schedule.id=fixation.scheduleid")
                              ->where(array("fixation.groupid"=>$groupid))
                              ->order("fixation.week ASC")
                              ->field("fixation.week,fixation.scheduleid,schedule.name")
                              ->select();


             foreach ($group_schedule as &$value)
             {
                 $value['att_time'] = $this->get_time($value['scheduleid']);
             }

         }else{
             //周期总表
             $period = $this->teacher_schedule_period->where(array("groupid"=>$groupid))->select();

             $period_deteil = $this->teacher_schedule_period_detail
                              ->alias("detail")
                              ->join("LEFT JOIN wxt_teacher_schedule schedule ON schedule.id=detail.scheduleid")
                              ->where(array("detail.groupid"=>$groupid))
                               ->order("detail.day ASC")
                              ->field("detail.day,detail.scheduleid,schedule.name")
                              ->select();

             $group_schedule = array_merge($period,$period_deteil);

             foreach($group_schedule as &$value)
             {
                 if($value['scheduleid'])
                 {
                     $value['att_time'] = $this->get_time($value['scheduleid']);
                 }
             }

         }

         return $group_schedule;

    }

    //插入排班周期表
    private function schedule_period($att_group,$scheduling,$period_name,$period_num,$schedule_period)
    {

        $scheduling = explode(",", $scheduling);

        //插入排班考勤班次设置
        foreach($scheduling as $value)
        {
          $scheduling_data['groupid'] = $att_group;
          $scheduling_data['scheduleid'] = $value;
          $s_data[] =   $scheduling_data;
        };
        $this->teacher_schedule_attendance->addAll($s_data);

        //插入排班周期表
        $period_data['groupid'] = $att_group;
        $period_data['name'] = $period_name;
        $period_data['week_num'] = $period_num;
        $this->teacher_schedule_period->add($period_data);

        //插入周期明细表
        foreach($schedule_period as $key=>$schedule)
        {
            $detail_data['groupid'] = $att_group;
            $detail_data['day'] = $key+1;
            $detail_data['scheduleid'] = $schedule;
            $all_detail[] = $detail_data;

        }
        $this->teacher_schedule_period_detail->addAll($all_detail);

    }
    //插入固定排版表
    private function schedule_fixation($groupid,$fixation)
    {
       if($groupid && $fixation)
       {
           foreach ($fixation as  $week=>$scheduleid)
           {
              $data['groupid'] = $groupid;
              $data['week'] = $week;
              $data['scheduleid'] = $scheduleid;
               $alldata[] = $data;
               unset($data);
           }
           $this->teacher_schedule_fixation->addAll($alldata);
       }

    }


     //处理分组和个人以及不考勤人员 汇总成一个集合
    protected function dis_group_person($att_group,$att_userid,$no_att_userid)
    {

//        dump($att_userid);
      if($no_att_userid) {


          $no_att_userid = explode(",", $no_att_userid);

          $no_att_userid = $this->dis_not_att($no_att_userid);
      }
        $arr_group = array();
        //查询分组;
        if($att_group)
        {
            $att_group = explode(",",$att_group);
            foreach ($att_group as $group)
            {
                if($group==1)
                {
                    $teacherid = $this->get_geren();
                    foreach($teacherid as &$value)
                    {
                        //部门状态为2 个人为1;
                        $value['type'] = 1;
                        array_push($arr_group,$value);
                    }
                }
               //查询出分组
                $department_teacher = M("department_teacher")->field("teacher_id as id")->where(array("school_id"=>$this->schoolid,"department_id"=>$group))->select();
                foreach($department_teacher as &$department)
                {
                    $department['type'] = 2;
                    $department['teacher_groupid'] = $group;
                    array_push($arr_group,$department);
                }

            }
            //给分组的id加上type;

        }
       //查询个人
        if($att_userid)
        {
            $where_user['info.id'] = array("in",$att_userid);
            $where_user['info.schoolid'] = $this->schoolid;
            //$where_user['dep.school_id'] = $this->schoolid;

            $teacher_info = M("teacher_info")->alias("info")->join("LEFT JOIN wxt_department_teacher dep ON dep.teacher_id=info.id")->where($where_user)->field("info.id,info.name,dep.department_id")->select();

            foreach ($teacher_info as &$v)
            {
                if(isset($v['department_id']))
                {
                    $v['type'] = 2;
//                    break;
                }else{
                    $v['type'] = 1;

                }


            }

        }

        if($no_att_userid)
        {
            $teacher_info = array_merge($no_att_userid,$teacher_info);
            $teacher_info = $this->array_unset_tt($teacher_info,"id");
        }


       if($arr_group && $teacher_info)
       {
           $arr_total = array_merge($arr_group,$teacher_info);
           return $this->array_unset_tt($arr_total,"id");
       }
       if(empty($teacher_info))
       {
           return $arr_group;
       }
        if(empty($arr_group))
        {

            return $this->array_unset_tt($teacher_info,"id");
        }

    }

    //将不需要考勤的数组处理
    function dis_not_att($not_arr)
    {
        $b = Array();
        foreach ($not_arr as $key => $value) {
            $b[]=Array('id'=>$value,'is_att'=>2,'type'=>1);
         }

        return $b;
    }

//$arr->传入数组   $key->判断的key值
    function array_unset_tt($arr,$key){
        //建立一个目标数组
        $res = array();
        foreach ($arr as $value) {
            //查看有没有重复项

            if(isset($res[$value[$key]])){
                //有：销毁

                unset($value[$key]);

            }
            else{

                $res[$value[$key]] = $value;
            }
        }
        return $res;
    }

    //$arr->传入数组   $key->判断的key值
    function array_unset_tt_person($arr,$key){

        //建立一个目标数组
        $res = array();
        foreach ($arr as $k=>$value) {

            //查看有没有重复项
            if($value['type']==1){
                $res[$value['personid']] = $value;
            }else if (isset($res[$value[$key]])){
                //有：销毁
                unset($value[$key]);
            }else{
                $res[$value[$key]] = $value;
            }

        }


        return $res;
    }
    //插入人

    //插入人员表
    private function add_person($groupid,$person)
    {

        if($person && $groupid)
        {
            foreach ($person as $value)
            {
                 $data['groupid'] = $groupid;
                 $data['personid'] = $value['id'];
                 $data['type'] = $value['type'];
                 $data['schoolid'] = $this->schoolid;
                 $data['teacher_groupid'] = $value['teacher_groupid']?$value['teacher_groupid']:"";
                 $data['is_att'] = $value['is_att']?$value['is_att']:1;
                $alldata[] = $data;
                unset($data);
            }

            $this->teacher_schedule_person->addAll($alldata);

        }

    }
    public function get_group()
    {

        if(!$this->schoolid)
        {
            echo json_encode($this->json_info(0,"数据有误!"));
            exit();
        }
      //先查出该学校的所有老师
//        $teacher_info = M("teacher_info")->where(array("schoolid"=>$this->schoolid))->field("id,name,schoolid")->select();
        //查出该学校的分组
        $department = M("department")->where(array("schoolid"=>$this->schoolid,"status"=>2))->field("id,name,schoolid")->select();


         $info['status'] = true;
         $info['department'] = $department;
//         $info['teacher_info'] = $teacher_info;
         echo json_encode($info);
         exit();
    }

    public function get_person()
    {
        $id = I("id");
        $type = I("type");
        if(!$id)
        {
            echo json_encode($this->json_info(0,"参数不存在！"));
        }

        //如果为分组
        if($type==1)
        {
         $teacher = M("department_teacher")
                  ->alias("d_teacher")
                  ->join("wxt_teacher_info info ON info.id=d_teacher.teacher_id")
                  ->where(array("d_teacher.school_id"=>$this->schoolid,"d_teacher.department_id"=>$id))
                  ->field("info.id,info.name,info.schoolid")
                  ->select();
//         dump($teacher);
        }else{
          $teacher = $this->get_geren();

        }
        echo json_encode($this->json_info(1,"拉取成功",$teacher));

    }

    protected function get_geren()
    {
        //先查出该学校的所有老师
        $teacher = M("teacher_info")->where(array("schoolid"=>$this->schoolid))->field("id,name,schoolid")->select();
        //查出该学校的分组
        $department = M("department")->where(array("schoolid"=>$this->schoolid,"status"=>2))->field("id,name,schoolid")->select();

        $dep = "";
        foreach ($department as $val)
        {
            $dep = $val['id'].",".$dep;
        }
        $depid = rtrim($dep, ",");
        //          查询出该学校有分组的老师人员 todo因为里面没有区分学生和老师，先这样写
        $where_group['school_id'] =  $this->schoolid;
        $where_group['department_id'] = array("in",$depid);
        $teacher_group = M("department_teacher")->where($where_group)->select();

        foreach($teacher_group as $key=>$group)
        {
            foreach($teacher as $k=>$info)
            {
                if($group['teacher_id']==$info['id'])
                {
                    unset($teacher[$k]);
                }
            }
        }

        return $teacher;
    }

    public function get_val()
    {
        $groupid = I("groupid");

        $userid = I("userid");

        if($groupid)
        {
            $where_group['id'] = array("in",$groupid);
            $where_group['schoolid'] = $this->schoolid;
            $group = M("department")->where($where_group)->select();
        }

        if($userid)
        {
            $where_user['id'] = array("in",$userid);
            $where_user['schoolid'] = $this->schoolid;
            $teacher_info = M("teacher_info")->where($where_user)->field("id,name,schoolid")->select();
        }
        $info['status'] = true;
        $info['group']  = $group;
        $info['teacher'] = $teacher_info;
        echo json_encode($info);

    }


    //编辑排班
    public function edit_scheduling()
    {
        $groupid = I("id");

        $this->assign("groupid",$groupid);
        $this->display();

    }

    //获取人员
    public function show_person()
    {
        //分组id
        $groupid = I("groupid");

        //年月标示
        $at_year_month = I("at_year_month");
        if(!$groupid)
        {
            echo json_encode($this->json_info(0,"参数不存在!"));
            exit();
        }
        $person = $this->teacher_schedule_person
                  ->alias("person")
                  ->join("wxt_teacher_info info ON info.id = person.personid")
                  ->where(array("groupid"=>$groupid,"is_att"=>1))
                  ->field("person.groupid,person.personid,info.name")
                  ->select();
        foreach($person as &$value)
        {
            $id = $value['personid'];

            $value['person_detail'] = $this->teacher_schedule_person_detail
                                    ->alias("person_detail")
                                    ->join("LEFT JOIN wxt_teacher_schedule schedule ON person_detail.scheduleid=schedule.id")
                                    ->join("LEFT JOIN wxt_teacher_schedule_attendance attendance ON person_detail.scheduleid=attendance.scheduleid")
                                    ->where("person_detail.year_month = $at_year_month and person_detail.groupid = $groupid and person_detail.period_personid = $id")
                                    ->field("person_detail.time,schedule.name,person_detail.scheduleid,attendance.scheduleid as person_type")
                                    ->select();
        }

        echo json_encode($this->json_info(1,"拉取成功",$person));
    }

    //排版周期
    public function show_scheudle_period()
    {
        $groupid = I("groupid");

        if(!$groupid)
        {
            echo json_encode($this->json_info(0,"参数不存在!"));
            exit();
        }

        $scheudle_period = $this->teacher_schedule_period_detail
            ->alias("period_detail")
            ->join("LEFT JOIN wxt_teacher_schedule schedule ON period_detail.scheduleid = schedule.id")
            ->field("period_detail.scheduleid,schedule.name")
            ->order("period_detail.day ASC")
            ->where(array("period_detail.groupid"=>$groupid))
            ->select();


//        $scheudle_period = $this->teacher_schedule_period_detail
//                        ->alias("period_detail")
//                        ->join("wxt_teacher_schedule schedule ON period_detail.scheduleid = schedule.id")
//                        ->field("period_detail.scheduleid,schedule.name")
//                        ->order("period_detail.day ASC")
//                        ->where(array("period_detail.groupid"=>$groupid))
//                        ->select();

        echo json_encode($this->json_info(1,"拉取成功",$scheudle_period));
    }

    //添加周期

    public function add_period()
    {
      $period = I("period");

      $userid = I("userid");

      $year_month = I("year_month");

      //先删除原有的
      $groupid = I("groupid");

        if(!$groupid)
        {
            echo json_encode($this->json_info(0,"参数不存在!"));
            exit();
        }

        $where_user['groupid'] = $groupid;
        $where_user['period_personid'] = array("in",$userid);
        $where_user['year_month'] = $year_month;
        $this->teacher_schedule_person_detail->where($where_user)->delete();

      if($period){
          foreach($period as $key=>$value)
          {

                      $data['groupid'] = $groupid;
                      $data['period_personid'] = $value['userid'];
                      $data['date_time'] = date("Y-m-d",$value['time']);
                      $data['time'] = $value['time'];
                      $data['scheduleid'] = $value['schedulid'];
                      $data['year_month'] =$year_month;
                      $alldata[] = $data;
                       unset($data);

              }
          $this->teacher_schedule_person_detail->addAll($alldata);

          }

          echo json_encode($this->json_info(1,"保存成功!"));
      }

      public  function get_teacher_name()
      {
          $teacher_name = I("teacher_name");

          $schoolid=$_SESSION['schoolid'];
          $teacher_name=I("teacher_name");
          $where["name"]=array("LIKE","%".$teacher_name."%");
          $where["schoolid"]=$schoolid;
          $teacher_info=M("teacher_info")->where($where)->field("id,name")->distinct(true)->select();
          if($teacher_info){
              $ret = $this->format_ret(1,$teacher_info);
          }else{
              $ret = $this->format_ret(0,"lost params");
          }
          echo json_encode($ret);
          exit;
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





//	function index()
//	{
//			// 清除数据缓存
//		$cache = new \Think\Cache;
//		$cache->getInstance()->clear();
//        //用户信息
//        $userid=$_SESSION['USER_ID'];
//
//        $schoolid=$_SESSION['schoolid'];
//
//        $level= $_SESSION['level'];
//
//		$teacher_name=I('teacher_name');
//		$education_card=I('education_card');
//		$work_card=I('work_card');
//
//
//		$teacher_schedule=M('teacher_schedule');
//		$teacher_schedule_add=M('teacher_schedule_add');
//
//		 if($teacher_name)
//        {
//        	$where['t.name']= $teacher_name;
//        	$this->assign("teacher_name",$teacher_name);
//        }
//        if($work_card)
//        {
//        	$where['t_i.work_card']= $work_card;
//        	$this->assign("work_card",$work_card);
//        }
//		if($education_card)
//		{
//			$where['t_i.education_card']= $education_card;
//			$this->assign("education_card",$education_card);
//		}
//
//    $field="u.id as userid,u.name as name,t_i.education_card,t_i.work_card,ts.id as schedule_id,ts.monday,ts.tuesday,ts.wednesday,ts.thursday,ts.friday,ts.saturday,ts.sunday";
//        if($level!=1  && $level!=2)
//        {
//
//            $where['t.teacherid'] = $userid;
//
//        }
//$where['t.schoolid'] = $schoolid;
//
//		$count=M('teacher_info')
//		->alias('t')
//		->join("wxt_wxtuser u ON u.id=t.teacherid")
//		->where($where)
//		->field("u.id,t.name")
//		->count();
//
//		 $page = $this->page($count, 10);
//
//
//  //改造后的
//
//  $where['t.schoolid'] = $schoolid;
//   // $teacher = M('teacher_info')->alias('t')->join("wxt_wxtuser u NO t.teahcerid=u.id")->where($where)->field("u.id,name")->select();
//   // var_dump($teacher);
//   // exit();
//
//
//
//  //先查出该学的教师的总人数
//		$teacher=M('teacher_info')
//		->alias('t')
//		->join("wxt_wxtuser u ON u.id=t.teacherid")
//		->where($where)
//		->field("u.id,t.name")
//		->limit($page->firstRow . ',' . $page->listRows)
//		->select();
//
//// exit();
//		// var_dump($schoolid);
//
//
//    $teacher_order = M('teacher_schedule_order')->where("schoolid=$schoolid")->select();
//    // var_dump($teacher_order);
//
//
//
//   //去排版设置表去查 如果存在则将数据赋值给总集合
//
//    foreach ($teacher as &$value) {
//    	$where_schedule['teacherid'] = $value['id'];
//    	$teacher_schedule_sel = $teacher_schedule->where($where_schedule)->find();
//    	if($teacher_schedule_sel)
//    	{
//    		$value['monday'] = $teacher_schedule_sel['monday'];
//    		$value['tuesday'] = $teacher_schedule_sel['tuesday'];
//    		$value['wednesday'] = $teacher_schedule_sel['wednesday'];
//    		$value['thursday'] = $teacher_schedule_sel['thursday'];
//    		$value['friday'] = $teacher_schedule_sel['friday'];
//    		$value['saturday'] = $teacher_schedule_sel['saturday'];
//    		$value['sunday'] = $teacher_schedule_sel['sunday'];
//
//    	}
//    }
//  // var_dump($teacher);
//
//$teacher_order = M('teacher_schedule_order')->where("schoolid=$schoolid")->select();
//
////林:TODO改造后的
//    foreach ($teacher as &$value) {
//        foreach ($teacher_order as  &$val) {
//        	if($value['monday']==$val['id'])
//        	{
//        		$value['monday_name'] = $val['name'];
//        	}
//        	if($value['tuesday']==$val['id'])
//        	{
//        		$value['tuesday_name'] = $val['name'];
//        	}
//        	if($value['wednesday']==$val['id'])
//        	{
//        		$value['wednesday_name'] = $val['name'];
//        	}
//        	if($value['thursday']==$val['id'])
//        	{
//        		$value['thursday_name'] = $val['name'];
//        	}
//        	if($value['friday']==$val['id'])
//        	{
//        		$value['friday_name'] = $val['name'];
//        	}
//        	if($value['saturday']==$val['id'])
//        	{
//        		$value['saturday_name'] = $val['name'];
//        	}
//        	if($value['sunday']==$val['id'])
//        	{
//        		$value['sunday_name'] = $val['name'];
//        	}
//        }
//
//    }
//
//
//
//        $this->assign("schedule",$teacher_order);
//		$this->assign("current_page",$page->GetCurrentPage());
//		$this->assign("Page", $page->show('Admin'));   // 添加分页
//		$this->assign("posts",$teacher);
//		//var_dump($teacher);
//		$this->display("index");
//	}

    //设置功能暂时没做
	function set_()
	{    

        $schoolid=$_SESSION['schoolid'];
		//var_dump($_GET);
        $teacherid = I('teacherid');
        $monday = I('monday');
        $tuesday = I('tuesday');
        $friday = I('friday');
        $wednesday = I('wednesday');
        $thursday = I('thursday');
        $sunday = I('sunday');
        $saturday = I('saturday');

        $id = implode(",", $teacherid);
   
    $where['teacherid'] = array('in',"$id");

    $del = M('teacher_schedule')->where($where)->delete();
   
        foreach ($teacherid as $key => $value) {
        	$data['schoolid'] =$schoolid;
        	$data['teacherid'] = $value;
        	$data['monday'] = $monday;
        	$data['tuesday'] = $tuesday;
        	$data['friday'] = $friday;
        	$data['wednesday'] = $wednesday;
        	$data['thursday'] = $thursday;
        	$data['sunday'] = $sunday;
        	$data['saturday'] = $saturday;
        	$alldata[] = $data;
        	unset($data);
        }
    
      $result = M('teacher_schedule')->addAll($alldata); 
      //  var_dump($teacherid);
		    
		 if ($result){
		 	$this->success("保存成功");
		 }else{
		 	$this->error("保存失败");
		    }
        

	}

	function clear_()
	{
		$id=I('id');
		$teacher_schedule=M('teacher_schedule');
		$data['monday']=0;
		$data['tuesday']=0;
		$data['wednesday']=0;
		$data['thursday']=0;
		$data['friday']=0;
		$data['saturday']=0;
		$data['sunday']=0;
		$teacher_schedule_cle=$teacher_schedule->where(array("id"=>$id))->save($data);
		$this->index();
		
	}





  	function index_scheudle()
	{  

	    $schoolid = $_SESSION['schoolid'];

        
       $schedule = M('teacher_schedule')->where("schoolid=$schoolid")->select();




       foreach ($schedule as $key => &$value) {
           //班次id
           $id = $value['id'];
           $att_time = $this->get_time($id);
           $value['att_time'] = $att_time;
       }

       $this->assign("posts",$schedule);
		$this->display("index_scheudle");
	}

   //获取班次
   public function get_scheudle()
   {

       if(!$this->schoolid)
       {
           echo json_encode($this->json_info(0,"数据有误!"));
           exit();
       }

       $schedule = M('teacher_schedule')->where(array("schoolid"=>$this->schoolid))->select();

       foreach ($schedule as $key => &$value) {
           //班次id
           $id = $value['id'];
           $att_time = $this->get_time($id);
           $value['att_time'] = $att_time;
       }

       echo json_encode($this->json_info(1,"拉取成功",$schedule));
   }

   public function get_edit_scheduling()
   {
      $groupid = I("groupid");

      $schedule = $this->teacher_schedule_attendance
                ->alias("attendance")
                ->join("wxt_teacher_schedule schedule ON attendance.scheduleid=schedule.id")
                ->where(array("attendance.groupid"=>$groupid))
                ->field("attendance.scheduleid as id,schedule.name")
                ->select();
       foreach ($schedule as $key => &$value) {
           //班次id
           $id = $value['scheduleid'];
           $att_time = $this->get_time($id);
           $value['att_time'] = $att_time;
       }
       echo json_encode($this->json_info(1,"拉取成功",$schedule));
   }


	public function get_time($schedule)
    {

//      if(!$schedule)
//      {
//          $this->error("班次不存在！");
//      }

      $detail = $this->teacher_schedule_detail->where(array("schoolid"=>$this->schoolid,"orderid"=>$schedule))->select();

        $detail = $this->multi_array_sort($detail,'type',SORT_ASC,SORT_STRING);

//     dump($detail);

     $time_main = "";
     $time_one = "";
     $time_two = "";
     $time_three = "";

     foreach($detail as &$value)
     {
            if($value['num']==1)
            {
                $time_one = $time_one."-".$value['ss_time'];
            }
         if($value['num']==2)
         {
             $time_two = $time_two."-".$value['ss_time'];
         }
         if($value['num']==3)
         {
             $time_three = $time_three."-".$value['ss_time'];
         }


     }

        $time_main  = trim($time_one,"-")." ".trim($time_two,"-")." ".trim("$time_three","-");
//     dump($time_main);

     return $time_main;
    }


	function index_scheudle_add()
	{

		$this->display("index_scheudle_add");
	}

    function index_scheudle_edit()
    {
        $id= I("id");


        //插出班次总表
        $schedule = $this->teacher_schedule->where("id = $id")->find();
//        dump($schedule);
        //查询出该班次下的所有时间段
        $detail = $this->teacher_schedule_detail->where(array("orderid"=>$id,"schoolid"=>$this->schoolid))->select();

        $detail = $this->multi_array_sort($detail,'type',SORT_ASC,SORT_STRING);


        $result= array();
       foreach($detail as $key=>$value)
       {
           $result[$value['num']][] = $value;
       }


        $this->assign("schedule",$schedule);
        $this->assign("result",$result);
        $this->display("index_scheudle_edit");
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


    public function index_scheudle_edit_post()
    {
        $scheudle = I("scheudle");
        $name = I("schedule_name");
        $days_num = I("days_num");
        if(!$scheudle)
        {
            $this->error("数据有误！");
        }

        //修改主表
        $this->teacher_schedule->where(array("id"=>$scheudle))->save(array("name"=>$name,"num"=>$days_num));
        //todo先按照以前这么写，以后再改！ 删除原来该班次的时间段,从新添加
       $del =  $this->teacher_schedule_detail->where(array("schoolid"=>$this->schoolid,"orderid"=>$scheudle))->delete();

           $data['orderid'] = $scheudle;
           $data['schoolid'] = $this->schoolid;


            if(I('ss_time_start') && I('ss_time_front') && I('ss_time_back'))
            {
                $data['type'] = 1;
                $data['num'] = 1;
                $data['ss_time']=I('ss_time_start');

                $data['ss_time_begin'] = I('ss_time_front');
                // $data['ss_time_begintime'] = I('ss_time_front');
                $time_start = strtotime(I('ss_time_start'));

                $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('ss_time_front').'minutes',$time_start));

                $data['ss_time_end'] = I('ss_time_back');

                $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('ss_time_back').'minutes',$time_start));

                $add=$this->teacher_schedule_detail->add($data);


            }
// 上午下班：
            if(I('sx_time_start') && I('sx_time_front') && I('sx_time_back'))
            {
                $data['type'] = 2;
                $data['num'] = 1;
                $data['ss_time']=I('sx_time_start');

                $data['ss_time_begin'] = I('sx_time_front');
                // $data['ss_time_begintime'] = I('ss_time_front');
                $time_start = strtotime(I('sx_time_start'));

                $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('sx_time_front').'minutes',$time_start));

                $data['ss_time_end'] = I('sx_time_back');

                $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('sx_time_back').'minutes',$time_start));

                $add=$this->teacher_schedule_detail->add($data);

            }




            // 下午上班：
            if(I('xs_time_start') && I('xs_time_front') && I('xs_time_back') && $days_num >1 )
            {
                $data['type'] = 3;
                $data['num'] = 2;
                $data['ss_time']=I('xs_time_start');

                $data['ss_time_begin'] = I('xs_time_front');
                // $data['ss_time_begintime'] = I('ss_time_front');
                $time_start = strtotime(I('xs_time_start'));

                $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('xs_time_front').'minutes',$time_start));

                $data['ss_time_end'] = I('xs_time_back');

                $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('xs_time_back').'minutes',$time_start));

                $add=$this->teacher_schedule_detail->add($data);
            }

// 下午下班：
            if(I('xx_time_start') && I('xx_time_front') && I('xx_time_back') && $days_num >1)
            {
                $data['type'] = 4;
                $data['num'] = 2;
                $data['ss_time']=I('xx_time_start');

                $data['ss_time_begin'] = I('xx_time_front');
                // $data['ss_time_begintime'] = I('ss_time_front');
                $time_start = strtotime(I('xx_time_start'));

                $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('xx_time_front').'minutes',$time_start));

                $data['ss_time_end'] = I('xx_time_back');

                $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('xx_time_back').'minutes',$time_start));

                $add=$this->teacher_schedule_detail->add($data);
            }

            //晚上上班
            if(I('ws_time_start') && I('ws_time_front') && I('ws_time_back') && $days_num > 2)
            {
                $data['type'] = 5;
                $data['num'] = 3;
                $data['ss_time']=I('ws_time_start');

                $data['ss_time_begin'] = I('ws_time_front');
                // $data['ss_time_begintime'] = I('ss_time_front');
                $time_start = strtotime(I('ws_time_start'));

                $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('ws_time_front').'minutes',$time_start));

                $data['ss_time_end'] = I('ws_time_back');

                $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('ws_time_back').'minutes',$time_start));

                $add=$this->teacher_schedule_detail->add($data);
            }

            //晚上下班
            if(I('wx_time_start') && I('wx_time_front') && I('wx_time_back') && $days_num > 2 )
            {
                $data['type'] = 6;
                $data['num'] = 3;
                $data['ss_time']=I('wx_time_start');

                $data['ss_time_begin'] = I('wx_time_front');
                // $data['ss_time_begintime'] = I('ss_time_front');
                $time_start = strtotime(I('wx_time_start'));

                $data['ss_time_begintime']  = date('H:i',strtotime(''.I('wx_time_front').'minutes',$time_start));

                $data['ss_time_end'] = I('wx_time_back');

                $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('wx_time_back').'minutes',$time_start));

                $add=$this->teacher_schedule_detail->add($data);
            }

            $this->success("修改成功",U('index_scheudle'));


    }



	function index_scheudle_add_post()
	{   

	    //次数
	    $days_num = I("days_num");
		$schoolid = $_SESSION['schoolid'];
		$teacher_schedule_detail=M('teacher_schedule_detail');
		$schedule_name=I('schedule_name');

		$data['create_time']=time();

		$data['schoolid'] = $schoolid;

		if(I('schedule_name'))
		{
//			$data['name']=I('schedule_name');

			//添加班次

			$order_add = array(
                 'schoolid'=>$schoolid,
                 'name'=>I('schedule_name'),
                 'num'=>$days_num,


				);
			$add = M('teacher_schedule')->add($order_add);
			if($add)
			{
				$data['orderid'] = $add; 	
			}
		}
//		exit();
		// 上午上班：
		if(I('ss_time_start') && I('ss_time_front') && I('ss_time_back'))
		{    
			$data['type'] = 1;
            $data['num'] = 1;
			$data['ss_time']=I('ss_time_start');

			$data['ss_time_begin'] = I('ss_time_front');
			// $data['ss_time_begintime'] = I('ss_time_front'); 
            $time_start = strtotime(I('ss_time_start'));

           $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('ss_time_front').'minutes',$time_start));

           $data['ss_time_end'] = I('ss_time_back');

           $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('ss_time_back').'minutes',$time_start));

          $add=$teacher_schedule_detail->add($data);


		}
// 上午下班：
		if(I('sx_time_start') && I('sx_time_front') && I('sx_time_back'))
		{
			$data['type'] = 2;
            $data['num'] = 1;
			$data['ss_time']=I('sx_time_start');

			$data['ss_time_begin'] = I('sx_time_front');
			// $data['ss_time_begintime'] = I('ss_time_front'); 
            $time_start = strtotime(I('sx_time_start'));

            $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('sx_time_front').'minutes',$time_start));

            $data['ss_time_end'] = I('sx_time_back');

            $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('sx_time_back').'minutes',$time_start));

            $add=$teacher_schedule_detail->add($data);

		}
	
		

		
		// 下午上班：
		if(I('xs_time_start') && I('xs_time_front') && I('xs_time_back'))
		{
			$data['type'] = 3;
            $data['num'] = 2;
			$data['ss_time']=I('xs_time_start');

			$data['ss_time_begin'] = I('xs_time_front');
			// $data['ss_time_begintime'] = I('ss_time_front'); 
            $time_start = strtotime(I('xs_time_start'));

            $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('xs_time_front').'minutes',$time_start));

            $data['ss_time_end'] = I('xs_time_back');

            $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('xs_time_back').'minutes',$time_start));

            $add=$teacher_schedule_detail->add($data);
		}

// 下午下班：
		if(I('xx_time_start') && I('xx_time_front') && I('xx_time_back'))
		{
			$data['type'] = 4;
            $data['num'] = 2;
			$data['ss_time']=I('xx_time_start');

			$data['ss_time_begin'] = I('xx_time_front');
			// $data['ss_time_begintime'] = I('ss_time_front'); 
            $time_start = strtotime(I('xx_time_start'));

            $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('xx_time_front').'minutes',$time_start));

            $data['ss_time_end'] = I('xx_time_back');

            $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('xx_time_back').'minutes',$time_start));

            $add=$teacher_schedule_detail->add($data);
		}

 //晚上上班
   		if(I('ws_time_start') && I('ws_time_front') && I('ws_time_back'))
		{
			$data['type'] = 5;
			$data['num'] = 3;
			$data['ss_time']=I('ws_time_start');

			$data['ss_time_begin'] = I('ws_time_front');
			// $data['ss_time_begintime'] = I('ss_time_front'); 
            $time_start = strtotime(I('ws_time_start'));

            $data['ss_time_begintime']  = date('H:i',strtotime('-'.I('ws_time_front').'minutes',$time_start));

            $data['ss_time_end'] = I('ws_time_back');

            $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('ws_time_back').'minutes',$time_start));

            $add=$teacher_schedule_detail->add($data);
		}  

 //晚上下班	
      if(I('wx_time_start') && I('wx_time_front') && I('wx_time_back'))
		{
			$data['type'] = 6;
            $data['num'] = 3;
			$data['ss_time']=I('wx_time_start');

			$data['ss_time_begin'] = I('wx_time_front');
			// $data['ss_time_begintime'] = I('ss_time_front'); 
            $time_start = strtotime(I('wx_time_start'));

            $data['ss_time_begintime']  = date('H:i',strtotime(''.I('wx_time_front').'minutes',$time_start));

            $data['ss_time_end'] = I('wx_time_back');

            $data['ss_time_endtime'] =  date('H:i',strtotime('+'.I('wx_time_back').'minutes',$time_start));

            $add=$teacher_schedule_detail->add($data);
		}



		$this->success("添加成功",U('index_scheudle'));



	}

	function delete_scheudle()
	{
		$id=I('id');
		$teacher_schedule_add=M('teacher_schedule');

		//查询该班次有没有在人员考勤表里存在

        //固定班次
        $fixation = M("teacher_schedule_fixation")->where(array("scheduleid"=>$id))->find();


        $period  =M("teacher_schedule_person_detail")->where(array("scheduleid"=>$id))->find();


        if($fixation || $period)
        {

            $this->error("班次已被使用,无法删除");
        }else{
            $del=$teacher_schedule_add->where(array("id"=>$id))->delete();

            if($del)
            {
                M("teacher_schedule_detail")->where(array("schoolid"=>$this->schoolid,"orderid"=>$id))->delete();
            }

            $this->success("删除成功");
        }






//		$this->index_scheudle();

	}

	function clear_scheudle()
	{   

		$id=I('id');
		$teacher_schedule_add=M('teacher_schedule_add');
		// 班次名称和时间 暂不清空
		// $data['schedule_name']="";
		// $data['create_time']="";
		$data['ss_time_start']="";
		$data['ss_time_end']="";
		$data['ss_time_front']="";
		$data['ss_time_back']="";
		$data['sx_time_start']="";
		$data['sx_time_end']="";
		$data['sx_time_front']="";
		$data['sx_time_back']="";
		$data['xs_time_start']="";
		$data['xs_time_end']="";
		$data['xs_time_front']="";
		$data['xs_time_back']="";
		$data['xx_time_start']="";
		$data['xx_time_end']="";
		$data['xx_time_front']="";
		$data['xx_time_back']="";
	
		$clear=$teacher_schedule_add->where(array("id"=>$id))->save($data);
		$this->index_scheudle();

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