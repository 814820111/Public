<?php

/**
 * 课件管理
 */

namespace Teacher\Controller;

use Common\Controller\TeacherbaseController;

class MonitorController extends TeacherbaseController
{
    function _initialize() {

        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];
    }

    public function index()
    {
        //var_dump($_SESSION);
        if (IS_POST) {

            $school_id = $_SESSION['schoolid'];
            $class_id = I('class_id');
            if (!empty($class_id)) {
                //获取该学校所有的授权列表
                $monitorInfo = M('monitor')->where("schoolid = $school_id  and classid = $class_id and type=0")->select();
                $this->assign("cid", $class_id);
            } else {
                //获取所有的授权列表
                $monitorInfo = $this->getMonitors();
            }
        } else {
            //获取所有的授权列表
            $monitorInfo = $this->getMonitors();
        }

        //存放班级学习等信息
        $newArr = array();
        //存放账号ID
        $monitorIds = array();
        foreach ($monitorInfo as $k => $v) {
            $schoolAndClass = M('school')->alias("s")->join("wxt_school_class as c on s.schoolid = c.schoolid")->where("c.id = {$v['classid']} and s.schoolid = {$_SESSION['schoolid']}")->find();
            //var_dump($schoolAndClass);exit;
            $newArr[$k]['school_name'] = $schoolAndClass['school_name'];
            $newArr[$k]['class_name'] = $schoolAndClass['classname'];
            $newArr[$k]['time'] = $monitorInfo[$k]['start_time'] . '-' . $monitorInfo[$k]['end_time'];
            $newArr[$k]['day'] = $monitorInfo[$k]['days'];
            $newArr[$k]['usermanage_id'] = $v['usermanage_id'];
            $newArr[$k]['monitor_id'] = $v['id'];
            $newArr[$k]['name'] = $v['name'];
            $monitorIds[$k]['monitor_id'] = $v['id'];
            $newArr[$k]['class_id'] = $schoolAndClass['id'];
        }
        //获取摄像头
        foreach ($monitorIds as $k => $v) {
            $monitorChannel = M('monitor_channel')->where("monitor_id = {$v['monitor_id']} AND is_show = 1")->select();
            //将获得的摄像头拼接成字符串
            $str = '';
            foreach ($monitorChannel as $i => $j) {
                $str .= $j['nname'] . '、';
            }
            $newArr[$k]['monitor_nname'] = trim($str, '、');
        }

        if($this->level!=1  && $this->level!=2)
        {

            $where_class['teacher.schoolid'] = $this -> schoolid;
            $where_class['teacher.teacherid'] = $this -> userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';

        }
           $where_class['c.schoolid'] = $this -> schoolid;

        //获取所有的班级

        $class = M('school_class')->alias("c")->join($join_duty)->where($where_class)->field("c.id, c.classname")->select();
        //var_dump($schools);
        //分配列表
        //var_dump($newArr);exit;
        $this->assign('lists', $newArr);
        $this->assign('class', $class);
        $this->display();
    }

    public function getMonitors()
    {
        $monitorInfo = M('monitor')->alias("m")->join("wxt_monitor_channel_time as t on m.id = t.monitor_id")->where("m.type = 0 and m.schoolid = {$_SESSION['schoolid']}")->select();
        $count = count($monitorInfo);
        $page = $this->page($count, 15);
        $monitorInfo = M('monitor')->alias("m")->join("wxt_monitor_channel_time as t on m.id = t.monitor_id")->where("m.type = 0 and m.schoolid = {$_SESSION['schoolid']}")->limit($page->firstRow . ',' . $page->listRows)->field("m.*, t.start_time, t.end_time, t.days")->select();
        //var_dump($monitorInfo);exit;
        $this->assign('page', $page->show('Admin'));
        return $monitorInfo;
    }

    //获取摄像头列表
    public function getVideoList()
    {
        $monitor_id = I('monitor_id');
        $video = M('monitor_channel')->where("monitor_id = $monitor_id")->select();
        if (!$video) {
            die("error2");
        }
        //var_dump($video);exit;
        $camaro = M('monitor_video')->where("school_id = {$_SESSION['schoolid']}")->select();
        //var_dump($camaro);exit;
        if (empty($camaro)) {
            die("该学校还没有添加摄像头");
        }
        $leCheng = array();
        $yingShi = array();
        $count = 0;
        $num = 0;
        foreach ($camaro as $k => $v) {
            if ($v['type'] == 1) {
                foreach ($video as $ks => $vs) {
                    if ($vs['video_id'] == $v['id']) {
                        $yingShi[$count]['is_checked'] = 1;
                    }
                }
                $yingShi[$count]['id'] = $v['id'];
                $yingShi[$count]['type'] = $v['type'];
                $yingShi[$count]['nname'] = $v['nname'];
                $count++;
            } elseif ($v['type'] == 2) {
                foreach ($video as $ks => $vs) {
                    if ($vs['video_id'] == $v['id']) {
                        $leCheng[$num]['is_checked'] = 1;
                    }
                }
                $leCheng[$num]['id'] = $v['id'];
                $leCheng[$num]['type'] = $v['type'];
                $leCheng[$num]['nname'] = $v['nname'];
                $num++;
            }
        }
        //var_dump($yingShi);exit;
        $html = '';
        if (!empty($leCheng)){
            foreach ($leCheng as $k=> $v){
                $html .= '<div style="width: 25%;float: left;margin: 10px 0  10px 0">';
                $html .='<label style="float: left;margin: 5px 15px 0 0;">';
                $html .= '<input';
                if($v["is_checked"] == 1){
                    $html.= ' checked ';
                }
                $html .= ' style="margin-right:5px" class="video_input" value="'.$v['id'].'" name="id_2[]" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;'.$v['nname'].'&nbsp;&nbsp;&nbsp;&nbsp;</label></div>';
            }
        }
        if (!empty($yingShi)){
            foreach ($yingShi as $k=> $v){
                $html .= '<div style="width: 25%;float: left;margin: 10px 0  10px 0">';
                $html .='<label style="float: left;margin: 5px 15px 0 0;">';
                $html .= '<input';
                if($v["is_checked"] == 1){
                    $html.= ' checked ';
                }
                $html .= ' class="video_input" value="'.$v['id'].'" name="id_1[]" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;'.$v['nname'].'&nbsp;&nbsp;&nbsp;&nbsp;</label></div>';
            }
        }
        echo $html;
    }

    //修改授权
    public function editAuth()
    {
        if (IS_POST){
            $isTypeOne = I('id_1');
            $isTypeTwo = I('id_2');
            $mid = I('mid');

            if (isset($isTypeOne)) {
                //var_dump($_POST);exit;
                //删除type = 1的数据
                $this->deleteMonitorChannel($mid, $isTypeOne, 1);
            }
            if (isset($isTypeTwo)) {
                $this->deleteMonitorChannel($mid, $isTypeTwo, 2);
            }
            $this->success("修改权限成功", U('index'));
            exit;
        }
    }

    //删除
    public function deleteMonitorChannel($mid,$isType, $type)
    {
        //删除type = 1的数据
        M('monitor_channel')->where("monitor_id = $mid and type = $type")->delete();
        //插入新数据
        foreach ($isType as $v) {
            //获取摄像头数据
            $info = M('monitor_video')->where("id = $v")->find();
            $arr = array(
                'channelNo' => $info['channelno'],
                'channelName' => $info['channelname'],
                'monitor_id' => $mid,
                'deviceSerial' => $info['deviceserial'],
                'nname' => $info['nname'],
                'status' => $info['status'],
                'is_show' => $info['is_show'],
                'ability' => $info['ability'],
                'type' => $info['type'],
                'video_id' => $v
            );
            //插入数据
            M('monitor_channel')->add($arr);
        }
    }

    //修改时间
    public function editTime()
    {
        $id = I('monitor_id');
        //获取该权限的时间
        $info = M('monitor_channel_time')->where("monitor_id = $id")->field("days")->find();
        $timeInfo = array();
        $arr = explode('-', $info['days']);
        $html = '';
        for ($i = 1; $i < 8; $i++) {
            if($i == 1){
                $o= '星期一';
            }
            if($i == 2){
                $o= '星期二';
            }
            if($i == 3){
                $o= '星期三';
            }
            if($i == 4){
                $o= '星期四';
            }
            if($i == 5){
                $o= '星期五';
            }
            if($i == 6){
                $o= '星期六';
            }
            if($i == 7 ){
                $o= '星期天';
            }
            $html .= '<div style="width: 25%;float: left;margin: 10px 0  10px 0">';
            $html .= '<label style="float: left;margin: 5px 15px 0 0;">';
            $html .= '<input style="margin-left: 0" type="checkbox" class="isMyChecked"  name="days[]" value="'.$i.'"';
            if (in_array($i, $arr)) {
                $html .= ' checked>'.$o;
            }else {
                $html .= '>'.$o;
            }

            $html .= '</input></label></div>';
        }
        echo $html;
    }

    public function editMonitorTime()
    {
        if (IS_POST){
            //获取参数
            $id = I('mid');
            $days = implode('-', I('days'));
            $start_time = I('start_time');
            $end_time = I('end_time');
            $array = array(
                'start_time' => $start_time,
                'end_time' => $end_time,
                'days' => $days
            );
            $update = M('monitor_channel_time')->where("monitor_id = $id")->save($array);
            if ($update) {
                $this->success('修改开放时间成功', U('index'));
            } else {
                $this->error("修改开放时间失败");
            }
            exit();
        }
    }

}