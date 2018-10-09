<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class BasicDataController extends AdminbaseController
{
    //学期展示
     public function  semester()
     {
         $semester = M('semester')->field("id,semester,semester_start,semester_end,create_time")->order('semester_start DESC')->select();
         foreach ($semester as &$key) {
             $nowtime = date('Y-m-d');
             $start = $key['semester_start'];
             $end = $key['semester_end'];
             if($nowtime>$start&&$nowtime<$end){
                 $key['statu'] = '已开学';
             }elseif($nowtime>$end){
                 $key['statu'] = '已关闭';
             }else{

                 $key['statu'] = '未开学';
             }
         }

         // var_dump($semester);
//         $this->assign('schoolid',$schoolid);
         $this->assign('semester',$semester);


         $this->display();
     }

     //添加学期
    public function addsemester()
    {
        $this->display();
    }

    public function addsemester_post()
    {

        $semester = I('semester');
        $begin = I('begin');
        $end =  I('end');

        $data = array(
            'semester'=>$semester,
            'semester_start'=>$begin,
            'semester_end'=>$end,
            'create_time'=>time(),
        );

        $add = M("semester")->add($data);

        if($add)
        {

            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }


    }

    //修改时间
    public function semester_edit()
    {
        $id = I('id');



        $semester = M('semester')->where("id = $id")->field("semester,semester_start,semester_end")->find();


        $semester_name = $semester['semester'];
        $semester_start = $semester['semester_start'];
        $semester_end =  $semester['semester_end'];


        $this->assign("semester_start",$semester_start);
        $this->assign("semester_end",$semester_end);
        $this->assign("semester_name",$semester_name);
        $this->assign("id",$id);
        $this->display();


    }

    public function semester_delete()
    {
        $id = I('id');
        if ($id) {
            $rst = M('semester')->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }




    }



}