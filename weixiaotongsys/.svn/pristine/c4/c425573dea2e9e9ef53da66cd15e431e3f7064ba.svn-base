<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;

//老师授权
class MonitorTeacherController extends AdminbaseController{
	
	function _initialize() {
		parent::_initialize();
	}

	//列表页
	function index(){

        $roleid = admin_role();
        if($roleid!=1)
        {
            $join = "wxt_role_school rs ON rs.schoolid = a.schoolid";
            $where['rs.roleid'] = $roleid;

        }
        $where['m.type'] = 1;
        $where['m.resource'] = 1;
        if (IS_POST) {
            $keyword = I('keyword');
            if (empty($keyword)){
                $monitorInfo = '';
            }else{
                $where['w.name'] = array("LIKE","%".$keyword."%");
                $monitorInfo = M('monitor')->alias("m")->join("wxt_wxtuser as w on m.classid = w.id")->join("wxt_school as s on s.schoolid = m.schoolid")->join($join)->join("wxt_monitor_channel_time as t on t.monitor_id = m.id")->where($where)->field("w.id as teacher_id,w.name,s.school_name,s.schoolid,m.id as monitor_id, t.start_time,t.end_time,t.days,w.phone")->select();
                //var_dump($monitorInfo);exit;
            }
        } else {

            //获取所有的授权列表
            $monitorInfo = M('monitor')->alias("m")->join("wxt_wxtuser as w on m.classid = w.id")->join("wxt_school as s on s.schoolid = m.schoolid")->join("wxt_monitor_channel_time as t on t.monitor_id = m.id")->where("m.type = 1 and m.resource = 1")->field("w.id as teacher_id,w.name,s.school_name,s.schoolid,m.id as monitor_id, t.start_time,t.end_time,t.days")->select();
            //var_dump($monitorInfo);
            //exit();
            $count = count($monitorInfo);
            $page = $this->page($count, 15);
            $monitorInfo = M('monitor')
                ->alias("m")
                ->join("wxt_wxtuser as w on m.classid = w.id")
                ->join("wxt_school as s on s.schoolid = m.schoolid")
                ->join("wxt_monitor_channel_time as t on t.monitor_id = m.id")
                ->join($join)
                ->where($where)
                ->limit($page->firstRow . ',' . $page->listRows)
                ->order('m.id desc')
                ->field("w.id as teacher_id,w.name,s.school_name,s.schoolid,m.id as monitor_id, t.start_time,t.end_time,t.days,w.phone, w.id as userid")
                ->field("w.id as teacher_id,w.name,s.school_name,s.schoolid,m.id as monitor_id, t.start_time,t.end_time,t.days,w.phone, w.id as userid")
                ->select();
            //var_dump($monitorInfo);exit;
            $this->assign('page', $page->show('Admin'));
            //$newArr = $this->getSchoolInfoAndClassInfo($monitorInfo);
        }

        //存放等信息
        $newArr = array();
        //获取摄像头
        foreach ($monitorInfo as $k => $v) {
            $monitorChannel = M('monitor_channel')->where("monitor_id = {$v['monitor_id']} AND is_show = 1")->select();
            //将获得的摄像头拼接成字符串
            $str = '';
            foreach ($monitorChannel as $i => $j) {
                if ($j['type'] == 1){
                    if ($j['status'] == 1){
                        $str .= $j['nname'] . '--海康(在线)、';
                    }else{
                        $str .= $j['nname'] . '--海康(离线)、';
                    }

                }elseif ($j['type'] == 2){
                    if ($j['status'] == 1){
                        $str .= $j['nname'] . '--大华(在线)、';
                    }else{
                        $str .= $j['nname'] . '--大华(离线)、';
                    }
                }
            }
            if (!empty($v['start_time'])){
                $monitorInfo[$k]['time'] = $v['start_time'].'-'.$v['end_time'];
            }
            $monitorInfo[$k]['day'] = $v['days'];
            $monitorInfo[$k]['monitor_nname'] = trim($str, '、');
        }
        //var_dump($monitorInfo);exit;
        $this->assign('lists', $monitorInfo);
		$this->display();
	}

	//添加页
	function add(){
        //获取所有的学校
        $school = M('school')->field("schoolid, school_name")->select();
        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->assign('school', $school);

		$this->display();
	}

	function add_post(){
		if(IS_POST){
			//var_dump($_POST);exit;
            $isTypeOne = isset($_POST['id_1']) ? I('id_1') : '';
            $isTypeTwo = isset($_POST['id_2']) ? I('id_2') : '';

            if (empty($isTypeOne) && empty($isTypeTwo)){
                die("请选择视频摄像头");
            }

            //$type = I('type');
            $data['schoolid'] = $_POST['school'];
            $camaro = M('monitor_video')->where("school_id = {$data['schoolid']}")->field("usermanage_id")->find();
            $data['usermanage_id'] = $camaro['usermanage_id'];
            $data['type'] = 1;
            $data['resource'] = 1;
            $data['create_time'] = time();

            foreach ($_POST['teachers'] as $v) {
                $data['classid'] = $v;
                //var_dump($data);exit;
                $result = M("monitor")->add($data);
                if (!$result) {
                    die("添加失败");
                }
                if (!empty($isTypeOne)) {
                    //获取摄像头信息
                    $this->insertMonitorChannel($result, $isTypeOne, 1);
                }
                if (!empty($isTypeTwo)) {
                    //添加摄像头信息
                    $this->insertMonitorChannel($result, $isTypeTwo, 2);
                }

                //插入时间数据
                $arrTime = array(
                    'start_time' => I('start_time'),
                    'end_time' => I('end_time'),
                    'days' => implode('-', I('days')),
                    'monitor_id' => $result
                );
                $insertTime = M('monitor_channel_time')->add($arrTime);
            }
            if ($insertTime) {
                $this->success("添加成功！", U('index'));
            } else {
                die("添加失败");
            }
		}
	}
	//插入视频数据
    private function insertMonitorChannel($id, $value, $type)
    {
        //添加摄像头信息
        for ($i = 0; $i < count($value); $i++) {
            $info = M('monitor_video')->where("id = {$value[$i]}")->find();
            $arr = array(
                'channelNo' => $info['channelno'],
                'channelName' => $info['channelname'],
                'deviceSerial' => $info['deviceserial'],
                'monitor_id' => $id,
                'nname' => $info['nname'],
                'status' => $info['status'],
                'type' => $type,
                'ability' => $info['ability'],
                'video_id' => $info['id'],
                'usermanage_id'=>$info['usermanage_id'],
                'img'=>$info['img']
            );
            $insert = M('monitor_channel')->add($arr);
        }
    }

    //修改权限
	public function look(){
		$id=I("get.id");
        //获取当前ID的视频数据
        $monitor = M('monitor')->where("id = $id and type=1 and resource = 1")->field('schoolid, id')->find();
        if (!$monitor) {
            $this->error("获取失败");
        }
        $video = M('monitor_channel')->where("monitor_id = {$monitor['id']}")->select();
        if (!$video) {
            die("error2");
        }
        //var_dump($video);exit;
        $camaro = M('monitor_video')->where("school_id = {$monitor['schoolid']}")->select();
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

        //var_dump($yingShi);
        //$this->assign('channelInfo', $channelInfo);
        $this->assign('leCheng', $leCheng);
        $this->assign('yingShi', $yingShi);
        $this->assign('monitor_id', $id);
		$this->display();
	}

	//修改权限post
	function look_post(){
		if (IS_POST) {
            $isTypeOne = I('id_1');
            $isTypeTwo = I('id_2');
            $mid = I('monitor_id');

            if (isset($isTypeOne)) {
                //var_dump($_POST);exit;
                //删除type = 1的数据
                M('monitor_channel')->where("monitor_id = $mid and type = 1")->delete();
                //插入新数据
                foreach ($isTypeOne as $v) {
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
                    $add = M('monitor_channel')->add($arr);
                }
            }

            if (isset($isTypeTwo)) {
                //删除type = 1的数据
                M('monitor_channel')->where("monitor_id = $mid and type = 2")->delete();
                //插入新数据
                foreach ($isTypeTwo as $v) {
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
            $this->success("修改权限成功", U('index'));
            exit;
		}
	}

	//修改时间
    public function editTime()
    {
        $id = I('id');
        //获取该权限的时间
        $info = M('monitor_channel_time')->where("monitor_id = $id")->find();
        $timeInfo = array();
        $timeInfo['start_time'] = $info['start_time'];
        $timeInfo['end_time'] = $info['end_time'];
        $arr = explode('-', $info['days']);
        $days = array();
        for ($i = 1; $i < 8; $i++) {
            if (in_array($i, $arr)) {
                $days[] = $i;
            } else {
                $days[] = 0;
            }
        }
        $timeInfo['days'] = $days;
        $this->assign('timeInfo', $timeInfo);
        $this->assign('monitor_id', $id);
        $this->display('edit_time');
    }
    //修改时间post
    public function editTime_post()
    {
        //获取参数
        $id = I('monitor_id');
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


	/**
	 *  删除
	 */
	function delete(){
        $id = I('id');
        $deleteResult = M('monitor')->where("id = $id")->delete();
        M('monitor_channel')->where("monitor_id = $id")->delete();
        M('monitor_channel_time')->where("monitor_id = $id")->delete();

        if ($deleteResult) {
            $this->success("删除老师授权成功！");
        } else {
            die("删除老师授权失败！");
        }
	}

	//获取该学校的所有老师
    public function getTeacher()
    {
        $schoolId = I('schoolid');
        $teachers = M('teacher_info')
            ->alias("i")
            ->where("i.schoolid = $schoolId")
            ->join("wxt_wxtuser as w on i.teacherid=w.id")
            ->field("w.id, w.name")
            ->select();
        //$teachers = M()->query("select i.id, i.name from wxt_wxtuser as w where w.id IN (select teacherid from wxt_teacher_info as i where i.schoolid=$schoolId)");
        echo json_encode($teachers);
    }

    //根据学校ID获取摄像头
    public function getVideoBySchoolId(){
	    $schoolId = I('id');
        //根据学校ID获取所有的摄像头
        $camaro = M('monitor_video')->where("school_id = $schoolId")->select();
        $leCheng = array();
        $yingShi = array();
        $count = 0;
        $num = 0;
        foreach ($camaro as $k => $v) {
            if ($v['type'] == 1) {
                $yingShi[$count]['id'] = $v['id'];
                $yingShi[$count]['type'] = $v['type'];
                $yingShi[$count]['nname'] = $v['nname'];
                $count++;
            } else {
                $leCheng[$num]['id'] = $v['id'];
                $leCheng[$num]['type'] = $v['type'];
                $leCheng[$num]['nname'] = $v['nname'];
                $num++;
            }
        }
        $html = '';
        //判断是否为空
        if(!empty($yingShi)){
            $html .= '<div style="width: 100%;text-align: left;float: left">萤石视频</div>';
            foreach($yingShi as $k=>$v){
                $html.='<div class="control-group imgWrapPart"><p>';
                $html .= '<label style="float: left;margin: 5px 15px 0 0;">';
                $html .= '<input type="checkbox" class="isMyChecked" name="id_'.$v['type'].'[]" value="'.$v['id'].'"></input>'.$v['nname'];
                $html .= '</label></p></div>';
            }
        }
        if(!empty($leCheng)){
            $html .= '<div style="width: 100%;text-align: left;float: left">乐橙视频</div>';
            foreach($leCheng as $k=>$v){
                $html.='<div class="control-group imgWrapPart"><p>';
                $html .= '<label style="float: left;margin: 5px 15px 0 0;">';
                $html .= '<input type="checkbox" class="isMyChecked" name="id_'.$v['type'].'[]" value="'.$v['id'].'"></input>'.$v['nname'];
                $html .= '</label></p></div>';
            }
        }
        echo $html;
    }
}