<?php
/* *
 * 系统权限配置，用户角色管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TestController extends AdminbaseController {


    public function del_student()
    {
        //查询出学校id为3的学生;
        $student_info = M("student_info")->where("schoollid = 10")->field("userid")->select();

        foreach($student_info as $info)
        {
            //获取到学生id
            $studentid = $info['userid'];

            //根据学生id去查出学生关系的所有数据删除
            $rela = M("relation_stu_user")->where("studentid = $studentid")->delete();

            //再删除学生信息
            M("student_info")->where("userid = $studentid and schoollid = 10")->delete();
        }

        exit();

    }


}