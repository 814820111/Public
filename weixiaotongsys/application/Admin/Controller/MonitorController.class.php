<?php

/**
 * 后台首页  视频监控管理
 */

namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class MonitorController extends AdminbaseController
{
    function _initialize()
    {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->class_model = D("Common/School_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->wxt_agent_model = D("Common/agent");
        $this->monitor_model = D("Common/monitor");
    }

    public function index()
    {
        if (IS_POST) {

            $school_id = I('school_id');
            $class_id = I('class_id');
            //获取该学校所有的授权列表
            $monitorInfo = M('monitor')->where("schoolid = $school_id  and classid = $class_id and type=0 and resource = 1")->select();
        } else {
            //获取所有的授权列表
            $monitorInfo = M('monitor')->alias("m")->join("wxt_monitor_channel_time as t on m.id = t.monitor_id")->where("m.type = 0 and m.resource = 1")->select();
            $count = count($monitorInfo);
            $page = $this->page($count, 15);
            $monitorInfo = M('monitor')->alias("m")->join("wxt_monitor_channel_time as t on m.id = t.monitor_id")->where("m.type = 0 and m.resource = 1")->limit($page->firstRow . ',' . $page->listRows)->order('m.id desc')->field("m.*, t.start_time, t.end_time, t.days")->select();
            //var_dump($monitorInfo);exit;
            $this->assign('page', $page->show('Admin'));
            //$newArr = $this->getSchoolInfoAndClassInfo($monitorInfo);
        }

        //存放班级学习等信息
        $newArr = array();
        //存放账号ID
        $monitorIds = array();
        foreach ($monitorInfo as $k => $v) {
            $schoolAndClass = M('school')->alias("s")->join("wxt_school_class as c on s.schoolid = c.schoolid")->where("s.schoolid = {$v['schoolid']} and c.id = {$v['classid']}")->find();
            //var_dump($schoolAndClass['classname']);
            $newArr[$k]['school_name'] = $schoolAndClass['school_name'];
            $newArr[$k]['class_name'] = $schoolAndClass['classname'];
            $newArr[$k]['classid'] = $schoolAndClass['id'];
            $newArr[$k]['time'] = $monitorInfo[$k]['start_time'] . '-' . $monitorInfo[$k]['end_time'];
            $newArr[$k]['day'] = $monitorInfo[$k]['days'];
            $newArr[$k]['usermanage_id'] = $v['usermanage_id'];
            $newArr[$k]['monitor_id'] = $v['id'];
            $newArr[$k]['name'] = $v['name'];
            $monitorIds[$k]['monitor_id'] = $v['id'];
        }
        //获取摄像头
        foreach ($monitorIds as $k => $v) {
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
            $newArr[$k]['monitor_nname'] = trim($str, '、');
        }

        //获取所有的学校
        $schools = M('school')->field("schoolid, school_name")->select();
        //var_dump($schools);
        //分配列表
        //var_dump($newArr);exit;
        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->assign('lists', $newArr);
        $this->assign('schools', $schools);
        $this->display("");
    }

    //根据学校ID获取班级
    public function getClassBySchoolId()
    {
        $school_id = I('id');
        $class = M('school_class')->where("schoolid = $school_id")->field("classname, id")->select();
        echo json_encode($class);
    }

    private function _lists($status = 1)
    {
        $school_id = 0;
        if (!empty($_REQUEST["school_id"])) {
            $school_id = intval($_REQUEST["school_id"]);
            $this->assign("school_id", $school_id);
            $_GET['school_id'] = $school_id;
        }
        $where_ands = empty($school_id) ? array("") : array("school_id = $school_id");

        // $fields=array(
        //         'start_time'=> array("field"=>"post_date","operator"=>">"),
        //         'end_time'  => array("field"=>"post_date","operator"=>"<"),
        //         'keyword'  => array("field"=>"post_title","operator"=>"like"),
        // );
        // if(IS_POST){
        //     foreach ($fields as $param =>$val){
        //         if (isset($_POST[$param]) && !empty($_POST[$param])) {
        //             $operator=$val['operator'];
        //             $field   =$val['field'];
        //             $get=$_POST[$param];
        //             $_GET[$param]=$get;
        //             if($operator=="like"){
        //                 $get="%$get%";
        //             }
        //             array_push($where_ands, "$field $operator '$get'");
        //         }
        //     }
        // }else{
        //     foreach ($fields as $param =>$val){
        //         if (isset($_GET[$param]) && !empty($_GET[$param])) {
        //             $operator=$val['operator'];
        //             $field   =$val['field'];
        //             $get=$_GET[$param];
        //             if($operator=="like"){
        //                 $get="%$get%";
        //             }
        //             array_push($where_ands, "$field $operator '$get'");
        //         }
        //     }
        // }
        $where = join(" and ", $where_ands);
        // var_dump($where);
        $count = $this->monitor_model
            ->where($where)
            ->count();
        // die($count);
        $page = $this->page($count, 20);
        // var_dump($count);
        $posts = $this->monitor_model
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("create_time DESC")->select();
// var_dump($posts);
        foreach ($posts as &$video) {
            $schoolwhere['schoolid'] = $video['schoolid'];
            $classwhere['id'] = $video['classid'];
            $schoolname = $this->school_model
                ->where($schoolwhere)->find();
            if ($schoolname) {
                $video['schoolname'] = $schoolname['school_name'];
            } else {
                $video['schoolname'] = '缺省';
            }
            $classname = $this->class_model
                ->where($classwhere)->find();
            if ($classname) {
                $video['classname'] = $classname['classname'];
            } else {
                $video['classname'] = '缺省';
            }
            unset($video);
            // //     ->alias("school")
            // //     ->join("wxt_teacherinfo teacher")
            // //     ->where(array("teacher.schoolid"=>$chat['schoolid']))
            // //     ->field('school_name')
            // //     ->find();

            // //     $teacher["schoolname"]=$schoolname["school_name"];
            // //     unset($teacher);
        }

        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page", $page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget", $_GET);
        $this->assign("school_name", $schoolname);
        $this->assign("lists", $posts);
    }

    //解码
    function urlsafe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

//------------------增加校园视频----------------
    function add()
    {
        $schools = $this->school_model->order(array("schoolid" => "asc"))->select();
        $school_id = intval(I("get.school"));
        // $this->_getTree();
        $school = $this->school_model->where("schoolid=$school_id")->find();
        //获取账户管理数据
        //$usermanage = M('monitor_usermanage')->where()->select();
        //$this->assign('usermanage', $usermanage);
        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->assign("school", $school);
        $this->assign("schools", $schools);
        $this->display();
    }

    //获取所有的摄像头列表
    function camarolist()
    {

        //字段验证
        if (empty($_POST['school'])) {
            $this->error("请至少选择一个学校！");
        }
        if (empty($_POST['class'])) {
            $this->error("请选择班级");
        }

        //获取post数据
        $data['schoolid'] = $_POST['school'];
        //根据学校ID获取所有的摄像头
        $camaro = M('monitor_video')->where("school_id = {$data['schoolid']}")->select();
        if (empty($camaro)) {
            die("该学校还没有添加摄像头");
        }
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
        //根据schoolID获取类型等信息

        $data['classid'] = $_POST['class'];
        $data['name'] = $_POST['name'];
        $data['create_time'] = time();
        //获取时间参数
        $start_time = I('start_time');
        $end_time = I('end_time');
        $datys = I('days');
        $str_days = implode('-', $datys);
        //var_dump($_POST);exit;

        $this->assign('start_time', $start_time);
        $this->assign('end_time', $end_time);
        $this->assign('days', $str_days);

        //$this->assign("type", $data['type']);
        $this->assign("schoolid", $data['schoolid']);
        $this->assign("classid", $data['classid']);
        $this->assign("name", $data['name']);
        $this->assign('usermanage_id', $camaro[0]['usermanage_id']);
        $this->assign('leCheng', $leCheng);
        $this->assign('yingShi', $yingShi);
        $this->display();
    }

    public function getByLeChengDeviceList($info)
    {
        $token = $info['token'];
        // 微校通设备
        $appId = $info['appkey'];
        $appSecret = $info['secret'];

        // 青岛设备
        // $appId = 'lc80db01e1cb4142dd';
        // $appSecret = "643ec05b22714e9080e1cd5a5dba36";

        $length = 32;
        // 密码字符集，可任意添加你需要的字符
        $chars = '0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        $data["token"] = $token;
        $data["queryRange"] = "1-99";
        foreach ($data as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $buff = "";
        foreach ($Parameters as $k => $v) {
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . ":" . $v . ",";
        }
        //$String;
        $String = '';
        if (strlen($buff) > 0) {
            $String = substr($buff, 0, strlen($buff) - 1);
        }
        $String = $String . ",time:" . time() . ",nonce:" . $password . ",appSecret:" . $appSecret;
        $String = md5($String);
        $system_team["ver"] = '1.0';
        $system_team["sign"] = $String;
        $system_team["appId"] = $appId;
        $system_team["time"] = time();
        $system_team["nonce"] = $password;
        $arr["system"] = $system_team;

        $arr["params"] = $data;

        $arr["id"] = 88;
        //echo json_encode($arr);
        $post_data = json_encode($arr);
        $this_header = array("Content-Type: application/x-www-form-urlencoded; charset=gbk");
        $url = 'https://openapi.lechange.cn:443/openapi/deviceList';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $arr_else = json_decode($result, true);
        $channels_list = array();
        foreach ($arr_else["result"]["data"]["devices"] as &$item) {
            array_push($channels_list, $item["channels"]);
        }
        return json_encode($arr_else["result"]["data"]);
    }

    //获取token----乐成
    public function getTokenByMobile($info)
    {
        //微校通设备
        $appId = $info['appkey'];
        $appSecret = $info['secret'];
        // $phone = "15888708668";//这是登录账号，应该用下面的管理员账号
        $phone = $info['mobile'];

        // 青岛设备
        // $appId = 'lc80db01e1cb4142dd';
        // $appSecret = "643ec05b22714e9080e1cd5a5dba36";
        // $phone = "18678959897";

        $length = 32;
        // 密码字符集，可任意添加你需要的字符
        $chars = '0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        $String = "phone:" . $phone . ",time:" . time() . ",nonce:" . $password . ",appSecret:" . $appSecret;
        $String = md5($String);
        $system_team["ver"] = '1.0';
        $system_team["sign"] = $String;
        $system_team["appId"] = $appId;
        $system_team["time"] = time();
        $system_team["nonce"] = $password;
        $arr["system"] = $system_team;

        $params_arr["phone"] = $phone;
        $arr["params"] = $params_arr;

        $arr["id"] = 88;


        //echo json_encode($arr);
        $post_data = json_encode($arr);
        //var_dump($post_data);
        $this_header = array("Content-Type: application/x-www-form-urlencoded; charset=gbk");
        $url = 'https://openapi.lechange.cn:443/openapi/accessToken';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $arr_else = json_decode($result, true);
        $contents = mb_convert_encoding($arr_else["msg"], 'gbk', 'auto');

        return $arr_else["result"]["data"]["accessToken"];
    }

    //获取token方法
    public function getToken($post_data)
    {
        $this_header = array("Content-Type: application/x-www-form-urlencoded; charset=gbk");
        $url = 'https://open.ys7.com/api/lapp/token/get';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $arr = json_decode($result, true);
        $contents = mb_convert_encoding($arr["msg"], 'gbk', 'auto');
        $token = $arr["data"]["accessToken"];

        return $token;
    }

    //获取摄像头方法
    function getCamaroList($token)
    {
        $post_data = "&accessToken=" . $token;
        $this_header = array("application/x-www-form-urlencoded; charset=gbk");
        $url = 'https://open.ys7.com/api/lapp/camera/list';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        return $result;
    }

    //添加视频
    function add_post()
    {
        if (strtotime(I('start_time')) > strtotime(I('end_time'))) {
            die("时间错误");
        }
        $isTypeOne = isset($_POST['id_1']) ? I('id_1') : '';
        $isTypeTwo = isset($_POST['id_2']) ? I('id_2') : '';

        if (empty($isTypeOne) && empty($isTypeTwo)){
            die("请选择视频摄像头");
        }

        //$type = I('type');
        $data['schoolid'] = $_POST['schoolid'];
        $data['usermanage_id'] = $_POST['usermanage_id'];
        $data['classid'] = $_POST['classid'];
        $data['name'] = $_POST['name'];
        $data['create_time'] = time();
        $data['resource'] = 1;
        $result = $this->monitor_model->add($data);
        if (!$result) {
            die("添加失败");
        }
        if (!empty($isTypeOne)) {
            //获取摄像头信息
            for ($i = 0; $i < count($isTypeOne); $i++) {
                $info = M('monitor_video')->where("id = {$isTypeOne[$i]}")->find();
                $arr = array(
                    'channelNo' => $info['channelno'],
                    'channelName' => $info['channelname'],
                    'deviceSerial' => $info['deviceserial'],
                    'monitor_id' => $result,
                    'nname' => $info['nname'],
                    'status' => $info['status'],
                    'type' => 1,
                    'video_id' => $info['id'],
                    'usermanage_id'=>$info['usermanage_id'],
                    'img'=>$info['img']
                );
                $insert = M('monitor_channel')->add($arr);
            }
        }
        if (!empty($isTypeTwo)) {
            //添加摄像头信息
            for ($i = 0; $i < count($isTypeTwo); $i++) {
                $info = M('monitor_video')->where("id = {$isTypeTwo[$i]}")->find();
                $arr = array(
                    'channelNo' => $info['channelno'],
                    'channelName' => $info['channelname'],
                    'deviceSerial' => $info['deviceserial'],
                    'monitor_id' => $result,
                    'nname' => $info['nname'],
                    'status' => $info['status'],
                    'type' => 2,
                    'ability' => $info['ability'],
                    'video_id' => $info['id'],
                    'usermanage_id'=>$info['usermanage_id'],
                    'img'=>$info['img']
                );
                $insert = M('monitor_channel')->add($arr);
            }
        }

        //插入时间数据
        $arrTime = array(
            'start_time' => I('start_time'),
            'end_time' => I('end_time'),
            'days' => I('days'),
            'monitor_id' => $result
        );
        $insertTime = M('monitor_channel_time')->add($arrTime);
        if ($insertTime) {
            $this->success("添加成功！", U('index'));
        } else {
            die("添加失败");
        }

    }

    //查看视频信息
    public function look()
    {
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
                        'video_id' => $v,
                        'usermanage_id'=>$info['usermanage_id'],
                        'img'=>$info['img']
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
                        'video_id' => $v,
                        'usermanage_id'=>$info['usermanage_id'],
                        'img'=>$info['img']
                    );
                    //插入数据
                    M('monitor_channel')->add($arr);
                }
            }
            $this->success("修改权限成功", U('index'));
            exit;
        }
        $id = I('id');
        //获取当前ID的视频数据
        $monitor = M('monitor')->where("id = $id and type = 0 and resource = 1")->field('schoolid, id')->find();
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

        //var_dump($channelInfo);
        //$this->assign('channelInfo', $channelInfo);
        $this->assign('leCheng', $leCheng);
        $this->assign('yingShi', $yingShi);
        $this->assign('monitor_id', $id);
        $this->display();
    }

    //修改开发时间
    public function editMonitorTime()
    {
        if (IS_POST) {
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

    //删除视频信息
    public function deleteChannel()
    {
        $id = I('id');
        $deleteResult = M('monitor_channel')->where("id = $id")->delete();
        if ($deleteResult) {
            $this->success("删除视频信息成功！");
        } else {
            die("删除视频信息失败！");
        }
    }

    //删除视频
    public function deleteMonitors()
    {
        $id = I('id');
        $deleteResult = M('monitor')->where("id = $id and type=0 and resource = 1")->delete();

        M('monitor_channel')->where("monitor_id = $id")->delete();
        M('monitor_channel_time')->where("monitor_id = $id")->delete();

        if ($deleteResult) {
            $this->success("删除视频成功！");
        } else {
            die("删除视频失败！");
        }
    }

    //修改视频
    public function editMonitors()
    {
        //视频ID
        $id = I('id');
        echo $id;
        exit;
    }

    //修改视频信息
    public function editChannel()
    {

        if (IS_POST) {
            //获取数据
            $mid = I('monitor_id');
            $nname = I('nname');
            $name = I('name');
            $serial = I('deviceSerial');
            $no = I('no');
            $monitor_channel_id = I('monitor_channel_id'); //视频信息id

//            //获取appkey
//            $appkey = M('monitor')->where("id = $mid")->getField('appkey');
//            //获取token与时间
//            $tokenInfos = M('usermanage')->where("appkey = '{$appkey}'")->find();
//
//            $nowTime = time()+8*3600;
//            if($nowTime - $tokenInfos['token_time'] > 36000) {
//                //token过期---从新获取token
//                //首先获取token
//                $post_data='appKey='.$tokenInfos['appkey'].'&appSecret='.$tokenInfos['secret'];
//                $token = $this->getToken($post_data);
//            } else {
//                $token = $tokenInfos['token'];
//            }

            $datas = array(
                'name' => $name,
                'serial' => $serial,
                'no' => $no,
                'nname' => $nname
            );
            //修改视频信息名称
            $updateName = M('monitor_channel')->where("id = $monitor_channel_id")->save($datas);
            if ($updateName) {
                //修改信息成功
                $this->success('修改视频信息名称成功', U('Monitor/look', array('id' => $mid)));
            } else {
                die("修改视频信息名称失败");
            }
//            $mvInfos = $this->changeMvInfo($datas);
//            if ($mvInfos['code'] == 200) {
//                //修改视频信息数据库
//                $arr = array('channelName'=>$name);
//                $updateName = M('monitor_channel')->where("id = $monitor_channel_id")->save($arr);
//                if($updateName) {
//                    //修改信息成功
//                    $this->success('修改视频信息名称成功', U('Monitor/look', array('id'=>$mid)));
//                } else {
//                    die("修改视频信息名称失败");
//                }
//            }
            exit;
        }
        //视频信息id
        $id = I('id');
        //获取视频信息
        $infos = M('monitor_channel')->where("id = $id")->find();
        $this->assign('monitorChannel', $infos);
        $this->assign('monitor_channel_id', $id);
        $this->display('edit');
    }

    //修改视频信息名称
//    public function changeMvInfo($data) {
//        $post_data="accessToken=".$data['token']."&deviceSerial=".$data['serial']."&deviceName=".$data['name'];
//        $this_header = array("application/x-www-form-urlencoded; charset=gbk");
//        $url='https://open.ys7.com/api/lapp/device/name/update';
//        $ch = curl_init();
//        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_URL,$url);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//        $result = curl_exec($ch);
//        return $arr=json_decode($result,true);
//    }

//------------------增加校园视频结束----------------


//------------------更新校园招聘开始----------------
    public function edit()
    {
        $id = intval(I("id"));
        //var_dump($id);
        $schoolid = intval(I("get.school"));
        $this->_getTree();
        $school_name = $this->school_model->order(array("schoolid" => "asc"))->select();
        $teacher = $this->teacher_model->where(array("id" => $id))->find();
        //$this->_getTermTree($term_relationship);
        //$terms=$this->terms_model->select();
        //$post=$this->posts_model->where("id=$id")->find();
        $this->assign("teacher", $teacher);
        $this->assign("smeta", json_decode($post['smeta'], true));
        $this->assign("school_name", $school_name);
        // $this->assign("term",$term_relationship);
        $this->display();
    }

    public function edit_post()
    {
        if (IS_POST) {
            $where['id'] = intval(I("teacher_id"));
            if (empty($_POST['school'])) {
                $this->error("请至少选择一个分类栏目！");
            }
            //$post_id=intval($_POST['post']['id']);

            //$this->term_relationships_model->where(array("object_id"=>$post_id,"term_id"=>array("not in",implode(",", $_POST['term']))))->delete();
            // foreach ($_POST['term'] as $mterm_id){
            //     $find_term_relationship=$this->term_relationships_model->where(array("object_id"=>$post_id,"term_id"=>$mterm_id))->count();
            //     if(empty($find_term_relationship)){
            //         $this->term_relationships_model->add(array("term_id"=>intval($mterm_id),"object_id"=>$post_id));
            //     }else{
            //         $this->term_relationships_model->where(array("object_id"=>$post_id,"term_id"=>$mterm_id))->save(array("status"=>1));
            //     }
            // }

            if (!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])) {
                foreach ($_POST['photos_url'] as $key => $url) {
                    $photourl = sp_asset_relative_url($url);
                    $_POST['smeta']['photo'][] = array("url" => $photourl, "alt" => $_POST['photos_alt'][$key]);
                }
            }
            $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
            $_POST['post']['post_date'] = date("Y-m-d H:i:s", time());
            //unset($_POST['post']['post_author']);
            $teacher = I("post.post");
            //$job['schoolid']=$_POST['school'];
            $teacher['smeta'] = json_encode($_POST['smeta']);
            $teacher['post_content'] = htmlspecialchars_decode($teacher['post_content']);
            $result = $this->teacher_model->where($where)->save($teacher);
            if ($result !== false) {
                $this->success("保存成功！");
            } else {
                $this->error("保存失败！");
            }
        }
    }

//------------------更新校园招聘结束----------------

//------------------删除信息------------------------
    function delete()
    {
        $id = intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->job_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
        //$this->error('该功能暂时未开通！');
    }

    //排序
    public function listorders()
    {
        $status = parent::_listorders($this->job_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

//-------------------------审核-------------------------
    function check()
    {
        if (isset($_POST['ids']) && $_GET["check"]) {
            $data["post_status"] = 1;

            $tids = join(",", $_POST['ids']);
            $objectids = $this->job_model->field("id")->where("id in ($tids)")->select();
            $ids = array();
            foreach ($objectids as $id) {
                $ids[] = $id["id"];
            }
            $ids = join(",", $ids);
            if ($this->job_model->where("id in ($ids)")->save($data) !== false) {
                $this->success("审核成功！");
            } else {
                $this->error("审核失败！");
            }
        }
        if (isset($_POST['ids']) && $_GET["uncheck"]) {

            $data["post_status"] = 0;
            $tids = join(",", $_POST['ids']);
            $objectids = $this->job_model->field("id")->where("id in ($tids)")->select();
            $ids = array();
            foreach ($objectids as $id) {
                $ids[] = $id["id"];
            }
            $ids = join(",", $ids);
            if ($this->job_model->where("id in ($ids)")->save($data)) {
                $this->success("取消审核成功！");
            } else {
                $this->error("取消审核失败！");
            }
        }
    }

    private function _getTree()
    {
        $schoolid = empty($_REQUEST['school']) ? 0 : intval($_REQUEST['school']);
        $result = $this->school_model->field("schoolid ,school_name as name")->order(array("schoolid" => "asc"))->select();
        $tree = new \Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        foreach ($result as $r) {
            $r['id'] = $r['schoolid'];
            $r['selected'] = $schoolid == $r['id'] ? "selected" : "";
            $array[] = $r;
        }

        $tree->init($array);
        $str = "<option value='\$id' \$selected>\$spacer\$name</option>";
        $taxonomys = $tree->get_tree(0, $str);
        $this->assign("taxonomys", $taxonomys);
    }

    //获取appsecret
    public function getAppSecret()
    {
        //获取数据
        $id = I('id');
        //获取数据
        $appsecret = M('monitor_usermanage')->where("id = $id")->getField('secret');
        echo $appsecret;
    }

    public function getAppKey()
    {
        $type = I('type');
        $lists = M('monitor_usermanage')->where("type=$type")->select();
        echo json_encode($lists);
    }
}