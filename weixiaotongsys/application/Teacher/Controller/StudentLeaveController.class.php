<?php

/**
 * 学生请假管理
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class StudentLeaveController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();

    }

    function index_leave()
    {
        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
        // 清除数据缓存
        $cache = new \Think\Cache;
        $cache->getInstance()->clear();
        $wxtuser =  M('wxtuser');
        $school_class=M('school_class');
        $leave =  M('leave');
        $start_time = I("start_time");
        $end_time  = I("end_time");

        if($level!=1  && $level!=2)
        {

            $school_class_id = get_teacher_class($userid);
            $where['le.userid'] = $userid;


        }else{
            $school_class_id=$school_class->where("schoolid=$schoolid")->field('classname,grade,id')->select();
        }



        $start_time_unix=strtotime($start_time);//将任何英文文本的日期或时间描述解析为 Unix 时间戳
        $end_time_unix=strtotime($end_time);
        $classid=I("class");
        $grade=I('grade');
        $student_name=I('student_name');//学生姓名
        $status=I('status');// 状态
        $leavetype=I('leavetype');
        if($classid){
            $userid_c=M('class_relationship')->field("userid")->where(array("classid"=>$classid))->select();
            if($userid_c)
            {
                $id_arr_c=array();
                foreach ($userid_c as &$itvo) {
                    foreach ($itvo as &$co) {
                        array_push($id_arr_c,$co);
                    }
                }
                $where["studentid"]=array("in",$id_arr_c);
            }
            $this->assign("class_c",$classid);

        }
        if($start_time_unix && $end_time_unix){
            $where["le.begintime"]=array(array('EGT',$start_time_unix),array('ELT',$end_time_unix));

            $this->assign("start_time_unix",date('Y-m-d H:i:s',$start_time_unix));
            $this->assign("end_time_unix",date('Y-m-d H:i:s',$end_time_unix));
        }
        if(!empty($student_name))
        {
//            $where['wxt_wxtuser.name']= $student_name;
//            $where['wxt_student_info.stu_name']= $student_name;
            $where['wxt_student_info.stu_name']=array('LIKE',"%".$student_name."%");
            $this->assign("student_name",$student_name);
        }


        if($status!=-1){
            $where['le.status']= $status;
        }





        $this->assign("status",$status);

        if(!empty($leavetype))
        {
            $where['leavetype']= $leavetype;
            $this->assign("leavetype",$leavetype);

        }

        $field="wxt_student_info.stu_name as student_name ,le.id,le.userid,le.studentid,le.leavetype,le.reason,le.create_time,le.begintime,le.endtime,le.status,le.feedback";


//    $where['wxt_wxtuser.schoolid'] = $schoolid;
        $where['le.schoolid'] = $schoolid;

        $count=$leave
            ->alias("le")
            //->join("wxt_wxtuser ON wxt_wxtuser.id=le.studentid")
            ->join("wxt_student_info ON wxt_student_info.userid=le.studentid")
//         ->where($map)
            ->where($where)
            ->order("le.id Desc")
            ->field($field)
            ->count();
        $page = $this->page($count, 20);


        $lists=$leave
            ->alias("le")
            //->join("wxt_wxtuser ON wxt_wxtuser.id=le.studentid")
            ->join("wxt_student_info ON wxt_student_info.userid=le.studentid")
//         ->where($map)
            ->limit($page->firstRow . ',' . $page->listRows)   // 添加分页
            ->where($where)
            ->field($field)
            ->order("le.id Desc")
            ->select();

        foreach ($lists as &$item) {

            // 获取班级名字 和 学生姓名
            $studentid=$item["studentid"];
//            $where_name["id"]=$studentid;
            $where_name["userid"]=$studentid;
//            $student_name=M('wxtuser')->field("name")->where($where_name)->find();
//            $student_name=M('student_info')->field("stu_name as name")->where($where_name)->find();
//            $item["student_name"]=$student_name["name"];
            $classname=M('school_class')
                ->alias("s")
                ->join("wxt_class_relationship c ON s.id=c.classid")
                ->where("c.userid=$studentid")
                ->field("s.classname")
                ->find();
            $item["classname"]=$classname["classname"];

        }
        // var_dump($lists);
        $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("Page", $page->show('Admin'));   // 添加分页
        $this->assign("categorys",$school_class_id);
        $this->assign("lists",$lists);
        $this->display("index_leave");
    }



    //  function agree_not()
    // {
    //     $leave=M('leave');

    //     $id=I('id');
    //     // 为了防止跳转index()函数时status被误以为是参数 所以用 I('status_')
    //     $status_a=I('status_a');
    //     $leave_save=$leave->where(array("id"=>$id))->save(array("status"=>$status_a));

    //     echo "修改成功！".$id."_+++__".$status_a;
    //     //$this->error("修改成功！");



    // }

    function agree_not()
    {
        $leave=M('leave');

        $teacherid=$_SESSION['USER_ID'];

        $id=I('id');
        // 为了防止跳转index()函数时status被误以为是参数 所以用 I('status_a')
        $status_a=I('status_a');

        $feedback = I('content');
        if($status_a)
        {
            $leave_save=$leave->where(array("id"=>$id))->save(array("status"=>$status_a,"feedback"=>$feedback,"deal_time"=>time(),'teacherid'=>$teacherid));
            if($leave_save)
            {
                // $this->index_leave();
                // echo $id."_+++__".$status_a;
                // $this->error("修改成功！");
                // $this->index_leave();
                print_r("成功") ;
            }
            else
            {
                // $this->error("修改失败！");
                // echo $id."___".$status_a;
                print_r("失败") ;
            }
        }
        else
        {
            // $this->error("lost params！");
            print_r("lost params") ;
        }





    }


}
