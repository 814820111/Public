<?php
namespace Teacher\Controller;
use Common\Controller\AppframeController;
header("Content-type: text/html; charset=utf-8");
class TeacherUtilsController extends AppframeController{

    function _initialize() {

        parent::_initialize();


    }

    public function get_class()
    {
        $school_class = M("school_class");

        $schoolid = $_SESSION['schoolid'];

        $userid=$_SESSION['USER_ID'];

        $gradeid = I("grade");

        $where['class.schoolid'] = $schoolid;

        $where['class.grade'] = $gradeid;

        $level= $_SESSION['level'];



        //如果权限不足则获取当前老师所带的班级
        if($level!=1  && $level!=2)
        {
             $where['teacher.schoolid'] = $schoolid;
             $where['teacher.teacherid'] = $userid;
             $join = 'wxt_teacher_class teacher ON class.id=teacher.classid';
        }



        $class = $school_class->alias("class")->join($join)->where($where)->field('class.id,class.classname')->select();



        if($class){

            $ret = $this->format_ret(1,$class);

        }else{

            $ret = $this->format_ret(0,"lost params");

        }

        echo json_encode($ret);
        exit;



    }

    public function hx_ass_token()
    {
//
        vendor('Hxcall','','.class.php');
        $Hxcall = new \Hxcall();//实例化，注意加\
         //获取群
//        $user = $Hxcall->chatGroupsDetails("55484525641729");
//        $user = $Hxcall->chatGroupsDetails("55484525641729");
//        $cc = array("123456","a123456789");





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







}