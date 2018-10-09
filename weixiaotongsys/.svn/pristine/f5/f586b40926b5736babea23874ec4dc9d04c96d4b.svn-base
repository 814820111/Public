<?php

/**
 * 后台首页  违纪管理
 */
namespace Apps\Controller;
use Common\Controller\AppBaseController;
header("Content-type: text/html; charset=utf-8");
class DormitoryController extends AppBaseController {



    //寝室管理
    public function index()
    {
       $classid = I("classid");

        $dormitory = M("dormitory_room")
                   ->alias("room")
                   ->join("wxt_school_class class ON class.id=room.classid")
                   ->join("wxt_dormitory_build build ON build.id=room.buildid")
                   ->where(array("room.schoolid"=>$_SESSION['schoolid'],"room.classid"=>$classid))
                   ->field("room.*,build.buildname,build.buildno")
                   ->select();

        $result = $this->get_dormitory_detail($dormitory);

        if($result)
        {
            $res = $this->format_ret_else(1,$result);
        }else{
            $res = $this->format_ret_else(0,"no data");
        }
        echo json_encode($res);

    }

    public function get_class()
    {
        $schoolid = $_SESSION['schoolid'];

        $class = M("school_class")->where(array("schoolid"=>$schoolid))->select();

        if($class)
        {
            $res = $this->format_ret_else(1,$class);
        }else{
            $res = $this->format_ret_else(0,"no class");
        }
        echo json_encode($res);
    }

    //处理学生数据
    private function get_dormitory_detail($dormitory)
    {
        foreach($dormitory as &$val)
        {
            $roomid = $val['id'];
            $where['bed.roomid'] = $roomid;
            $where['bed.studentid'] = array("neq",0);
            $val['title'] = $val['buildname'].$val['buildno'].'栋'.$val['roomname'];
            $val['student'] = M("dormitory_bed")
                ->alias("bed")
                ->join("wxt_student_info info ON info.id=bed.studentid")
                ->field("info.stu_name,info.sex")
                ->where($where)
                ->select();
        }
        return $dormitory;
    }

    //参数获取(状态，原因)
    function format_ret_else ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }

//    private function dis


}