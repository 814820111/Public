<?php

/**
 * 老师不打卡设置
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
header("Content-type: text/html; charset=utf-8");
class NoClockController extends TeacherbaseController {

    function _initialize()
    {
        parent::_initialize();
        $this->userid = $_SESSION['USER_ID'];
        $this->schoolid = $_SESSION['schoolid'];
        $this->level = $_SESSION['level'];
        $this->no_clock = D("Common/no_clock");
        $this->no_clock_card = D("Common/no_clock_card");
        $this->no_clock_detail = D("Common/no_clock_detail");
        $this->teacher_schedule_group = D("Common/teacher_schedule_group");

    }
    public function teacher()
    {

      //获取该学校的分组
        $teacher_group = $this->teacher_schedule_group->where(array("schoolid"=>$this->schoolid))->select();

       //获取该学校老师的活动
        $no_clock = $this->no_clock->where(array("schoolid"=>$this->schoolid,"att_type"=>1))->select();


        $this->assign("posts",$no_clock);
        $this->assign("teacher_group",$teacher_group);
        $this->display();
    }

    public function student()
    {
       //拉出该学校的班级

        if($this -> level!=1  && $this -> level!=2)
        {
            $where['teacher.schoolid'] = $this->schoolid;
            $where['teacher.teacherid'] = $this->userid;
            $join_duty = 'wxt_teacher_class teacher ON class.id=teacher.classid';

        }
       $where['class.schoolid'] = $this->schoolid;
        $class = M("school_class")
               ->alias("class")
               ->join($join_duty)
               ->where($where)
               ->field("class.id,class.classname")
               ->select();
        //获取该学校学生的活动
        $no_clock = $this->no_clock->where(array("schoolid"=>$this->schoolid,"att_type"=>2))->select();

        $this->assign("posts",$no_clock);
        $this->assign("class",$class);
        $this->display();


    }

    public function add_teacher_clock_post()
    {

//        exit();

       //活动名称
        $activity_name = I("activity");
        //活动开始时间
        $begin = I("begintime");
        //活动结束时间
        $end = I("endtime");
        //活动状态
        $activity_type = I("activity_type");
        //获取分组
        $group = I("group");

        //刷卡开始日期
        $card_begin = I("card_begin");
        //刷卡开始时间
        $card_begin_timing = I("card_begin_timing");
        //刷卡结束日期
        $card_end = I("card_end");
        //刷卡结束时间
        $card_end_timing = I("card_end_timing");

        $content = I("content");

        $clockid = I("clockid");


        $data['schoolid'] = $this->schoolid;
        $data['activity_name'] = $activity_name;
        $data['begin'] = strtotime($begin);
        $data['begin_time'] = $begin;
        $data['end'] = strtotime($end);
        $data['end_time'] =$end;
        $data['type'] = $activity_type;
        $data['att_type'] = 1;


        if($clockid)
        {
           $edit =  $this->no_clock->where(array("id"=>$clockid))->save($data);

           //分组详细表
           $this->no_clock_detail->where(array("activity_id"=>$clockid))->delete();

           //删除刷卡信息
            $this->no_clock_card->where(array("clockid"=>$clockid))->delete();

        }else{


            $clockid = $this->no_clock->add($data);

        }

      if($clockid)
      {
          $this->add_teacher_group($clockid,$group);
      }

      if($card_begin && $card_end)
      {
          $this->add_teacher_card($clockid,$card_begin,$card_begin_timing,$card_end,$card_end_timing,$content);
      }

      echo json_encode($this->json_info(1,"提交成功!"));
    }

    public function add_student_clock_post()
    {

//        exit();

        //活动名称
        $activity_name = I("activity");
        //活动开始时间
        $begin = I("begintime");
        //活动结束时间
        $end = I("endtime");
        //活动状态
        $activity_type = I("activity_type");
        //获取分组
        $group = I("group");

        $content = I("content");

        //刷卡开始日期
        $card_begin = I("card_begin");
        //刷卡开始时间
        $card_begin_timing = I("card_begin_timing");
        //刷卡结束日期
        $card_end = I("card_end");
        //刷卡结束时间
        $card_end_timing = I("card_end_timing");

        $clockid = I("clockid");

        $data['schoolid'] = $this->schoolid;
        $data['activity_name'] = $activity_name;
        $data['begin'] = strtotime($begin);
        $data['begin_time'] = $begin;
        $data['end'] = strtotime($end);
        $data['end_time'] =$end;
        $data['type'] = $activity_type;
        $data['att_type'] = 2;

        if($clockid)
        {
            $edit =  $this->no_clock->where(array("id"=>$clockid))->save($data);

            //分组详细表
            $this->no_clock_detail->where(array("activity_id"=>$clockid))->delete();

            //删除刷卡信息
            $this->no_clock_card->where(array("clockid"=>$clockid))->delete();

        }else{


            $clockid = $this->no_clock->add($data);

        }


        if($clockid)
        {
            $this->add_teacher_group($clockid,$group);
        }

        if($card_begin && $card_end)
        {
            $this->add_teacher_card($clockid,$card_begin,$card_begin_timing,$card_end,$card_end_timing,$content);
        }

        echo json_encode($this->json_info(1,"提交成功!"));
    }


    private function add_teacher_group($clockid,$group)
    {
        foreach ($group as $g_id)
        {
            $data['activity_id'] = $clockid;
            $data['g_id'] = $g_id;
            $alldata[]  = $data;
        }
        $this->no_clock_detail->addAll($alldata);
    }

    public function del_clock()
    {
        $id = trim(I("id"), ",");

        if(!$id)
        {
            echo json_encode($this->json_info(0,"参数不存在!"));
        }
        $wher_clock['id'] = array("in",$id);

       //删除总表
        $del_clock = $this->no_clock->where($wher_clock)->delete();

        if($del_clock)
        {
            $where_card['clockid'] = array("in",$id);
            $this->no_clock_card->where($where_card)->delete();

            $where_detail['activity_id'] = array("in",$id);
            $this->no_clock_detail->where($where_detail)->delete();


            echo json_encode($this->json_info("1","删除成功!"));

        }else{
            echo json_encode($this->json_info("0","删除失败!"));
        }


    }

    private function add_teacher_card($clockid,$card_begin,$card_begin_timing,$card_end,$card_end_timing,$content)
    {

        $res = array();

        foreach($card_begin as $key=>$value)
        {
            if(!$card_begin[$key] || !$card_end[$key])
            {
                continue;
            }

            $res[$key]['card_begin'] = $value;
            $res[$key]['card_begin_timing'] =$card_begin_timing[$key];
            $res[$key]['card_end'] = $card_end[$key];
            $res[$key]['card_end_timing'] = $card_end_timing[$key];
            $res[$key]['content'] = $content[$key];
        }

        foreach($res as $val)
        {
            $begin_time = explode(':', $val['card_begin_timing']);
            $end_time = explode(':', $val['card_end_timing']);
            $data['clockid'] = $clockid;
            $data['card_begin'] = $val['card_begin'];
            $data['card_begin_timing'] = $val['card_begin_timing'];
            //获取开始总时间
            $data['card_begin_total'] = strtotime($val['card_begin'])+$begin_time['0'] * 3600 + $begin_time['1']*60;
            $data['card_end'] = $val['card_end'];
            $data['card_end_timing'] = $val['card_end_timing'];
            //获取结束总时间
            $data['card_end_total'] =strtotime($val['card_end'])+$end_time['0'] * 3600 + $end_time['1']*60;
            $data['content'] = $val['content'];
            $alldata[]  = $data;
        }


        $this->no_clock_card->addAll($alldata);
    }

    public function show_clock()
    {
       $id = I("id");
       $att_type = I("att_type");

       //查询出该活动条数
        $no_clock = $this->no_clock->where(array("id"=>$id))->find();

       //如果为老师
        if($att_type==1)
        {
            $no_clock["group"] =  $this->no_clock_detail->alias("d")->join("wxt_teacher_schedule_group g ON g.id=d.g_id")->field("d.g_id,g.name")->where(array("d.activity_id"=>$id))->select();
            $no_clock["card"] = $this->no_clock_card->where("clockid = $id")->select();
        }else{
            $no_clock["group"] =  $this->no_clock_detail->alias("d")->join("wxt_school_class g ON g.id=d.g_id")->field("d.g_id,g.classname as name")->where(array("d.activity_id"=>$id))->select();
            $no_clock["card"] = $this->no_clock_card->where("clockid = $id")->select();
        }

        echo json_encode($this->json_info(1,"拉取成功！",$no_clock));

    }

    public function edit_type()
    {
        //活动id
        $id = I("id");
        //活动状态
        $type = I("type");

        if(!$id)
        {
            echo json_encode($this->json_info(0,"活动不存在！"));
            exit();
        }

        $edit_type = $this->no_clock->where(array("id"=>$id))->save(array("type"=>$type));

        if($edit_type)
        {
            echo json_encode($this->json_info(1,"OK"));
        }else{
            echo json_encode($this->json_info(0,"error"));
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