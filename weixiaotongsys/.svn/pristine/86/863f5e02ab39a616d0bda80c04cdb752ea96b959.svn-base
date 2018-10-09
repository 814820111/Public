<?php
/* *
 * 系统权限配置，用户角色管理
 */
namespace Apps\Controller;
use Admin\Controller\MailBoxController;
use Common\Controller\WeixinbaseController;
header("Content-type: text/html; charset=utf-8");
class MiniAppsController extends WeixinbaseController {




    public function student_list()
    {

    }
    public  function http_request($url, $data = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public function del_student()
    {
        //查询出塘下中心幼儿园的毕业班年段
//        $gradeid = M("school_grade")->where(array("schoolid"=>13,"gradeid"=>7))->getField("gradeid");
//
//        //查询出该年段的所有班级
//        $school_class = M("school_class")->where(array("schoolid"=>13,"grade"=>$gradeid))->select();
//
//
//        foreach($school_class as $class)
//        {
//            $classid = $class['id'];
//            //查询出学生班级关系表
//            $class_relationship = M("class_relationship")->where(array("schoolid"=>13,"classid"=>$classid))->select();
//
//            foreach($class_relationship as $rel)
//            {
//                //获取学生id
//                $userid = $rel['userid'];
//                //删除家长关系表
//                M("relation_stu_user")->where(array("studentid"=>$userid))->delete();
//                //删除student_card
//                M("student_card")->where(array("personId"=>$userid))->delete();
//                //删除用户表
//                M("wxtuser")->where(array("id"=>$userid))->delete();
//            }
//            M("class_relationship")->where(array("schoolid"=>13,"classid"=>$classid))->delete();
//        }


    }

    public function teacher_id_card()
    {
        ////        //查出所有老老师卡
        $teacher_card = M("student_card")->where("handletype = 1 and cardType = 1")->select();

        foreach($teacher_card as $value)
        {
//            var_dump($value['personid']);

            $personid = $value['personid'];

            $schoolid = $value['schoolid'];
//            dump($schoolid);

            if($personid)
            {

                $teacher_id = M("teacher_info")->where("teacherid = $personid")->getField("id");


                if(!$teacher_id)
                {
                    continue;
                }

//            //将student_card表原来的的记录修改为0
           $result =  M("student_card")->where("handletype = 1 and cardType = 1 and personId = $personid")->save(array("handletype"=>0,"handletime"=>date("Y-m-d",time()),"handletimeint"=>time()));
//
//
//            //修改teacher_attendances表
           $aa =     M("teacher_attendances")->where("userid = $personid and schoolid = $schoolid")->save(array("userid"=>$teacher_id));

             $data['personId'] = $teacher_id;
            $data['cardNo'] = $value['cardno'];
            $data['schoolid'] = $value['schoolid'];
            $data['name'] = $value['name'];
            $data['cardType'] = $value['cardtype'];
            $data['handletime'] = date("Y-m-d H:i:s",time());
            $data['handletimeint'] = time();
            $data['handletype'] = 1;
            $data['create_time'] = time();

            //加入新数据
             $add_card =  M("student_card")->add($data);
            }

        }
        exit();
    }


}