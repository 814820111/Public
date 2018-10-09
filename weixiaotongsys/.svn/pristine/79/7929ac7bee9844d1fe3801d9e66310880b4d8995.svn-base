<?php

/**
 * 课件管理
 */

namespace Teacher\Controller;

use Common\Controller\TeacherbaseController;

class MonitorVideoController extends TeacherbaseController
{
    function _initialize() {
        parent::_initialize();

    }
    public function index()
    {
        if (IS_POST) {
            $vname = isset($_POST['video_name']) ? I('video_name') : '';
            if (!empty($vname)) {
                //修改摄像头名称
                $id = I('video_id');
                $arr = array(
                    'nname' => $vname
                );
                $res = M('monitor_video')->where("id = $id")->save($arr);
                if ($res) {
                    M('monitor_channel')->where("video_id = $id")->save($arr);
                    $this->success('修改名称成功', U('index'));
                    exit();
                } else {
                    die("修改名称失败");
                }
            }
            //获取要查询的关键字
            $keyword = I('keyword');
            //echo $keyword;
            $info = M('monitor_video')->alias("c")->join("wxt_school as s on c.school_id = s.schoolid")->where("s.schoolid = {$_SESSION['schoolid']} and c.nname like '%$keyword%'")->field("c.id,s.school_name,c.nname,c.deviceSerial")->select();
            $this->assign('keyword', $keyword);
        }else {
            //获取所有的摄像头包含学校名称
            $info = M('monitor_video')->alias("c")->join("wxt_school as s on c.school_id = s.schoolid")->where("s.schoolid = {$_SESSION['schoolid']}")->select();
        }
        //var_dump($info);
        //获取总条数
        $count = count($info);
        $page = $this->page($count, 15);
        $info = M('monitor_video')->alias("c")->join("wxt_school as s on c.school_id = s.schoolid")->where("s.schoolid = {$_SESSION['schoolid']} and c.nname like '%$keyword%'")->limit($page->firstRow . ',' . $page->listRows)->field("c.id,s.school_name,c.nname,c.deviceSerial")->select();
        //var_dump($info);
        //分配数据
        $this->assign('page', $page->show('Admin'));
        $this->assign('info', $info);
        $this->display();
    }

    public function add()
    {

    }

    public function add_post()
    {

    }

    public function delete()
    {
        $id = I('id');
        // var_dump($id);
        $del = M('school_baomingarticle')->where("id = $id")->delete();

        if ($del > 0) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }


    public function edit()
    {


    }
}