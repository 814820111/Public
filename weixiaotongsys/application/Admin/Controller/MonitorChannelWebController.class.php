<?php

/**
 * 视频监控管理
 */

namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class MonitorChannelWebController extends AdminbaseController
{
    function _initialize()
    {
        parent::_initialize();
    }

    //涉嫌头列表
    public function index()
    {
        if (IS_POST) {
            //获取要查询的关键字
            $keywordtype = I('keywordtype');
            $keyword = I('keyword');
            $info = M('monitor_live')->alias("c")->join("wxt_school as s on c.school_id = s.schoolid")->where("s.school_name like '$keyword%'")->select();
            $this->assign('keyword', $keyword);
        } else {
            //获取所有的摄像头包含学校名称
            $info = M('monitor_live')->alias("c")->join("wxt_school as s on c.school_id = s.schoolid")->order('c.id desc')->select();
        }
        //var_dump($info);
        //获取总条数
        $count = count($info);
        $page = $this->page($count, 15);
        $info = M('monitor_live')->alias("c")->join("wxt_school as s on c.school_id = s.schoolid")->limit($page->firstRow . ',' . $page->listRows)->order('c.id desc')->field("c.id,s.school_name,c.nname,c.deviceSerial, c.channelName,c.content")->where("s.school_name like '$keyword%'")->select();
        //var_dump($info);
        //分配数据
        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->assign('page', $page->show('Admin'));
        $this->assign('info', $info);
        $this->display();
    }

    //修改摄像头名称
    public function edit()
    {
        if (IS_POST) {
            $id = I('id');
            $arr = array(
                'nname' => I('nname'),
                'content'=>I('content')
            );
            $res = M('monitor_live')->where("id = $id")->save($arr);
            if ($res) {
                M('monitor_channel')->where("video_id = $id")->save($arr);
                $this->success('修改名称成功', U('index'));
                exit();
            } else {
                die("修改名称失败");
            }
        }
        $id = I('id');
        //获取名称
        $monitorChannel = M('monitor_live')->where("id = $id")->field("nname,content")->find();
        $this->assign('monitorChannel', $monitorChannel);
        $this->assign('id', $id);
        $this->display();
    }

    //删除摄像头
    public function delete()
    {
        $id = I('id');
        $res = M('monitor_live')->where("id = $id")->delete();
        if ($res) {
            $this->success('删除名称成功', U('index'));
            exit();
        } else {
            die("删除名称失败");
        }
    }

    //获取所有的摄像头列表
    function camarolist()
    {
        //获取账号信息---appKey
        $id = I('usermanage_id');
        $usermanageinfo = M('monitor_usermanage')->where("id=$id")->find();
        //var_dump($usermanageinfo);
        //获取post数据
        $data['type'] = $usermanageinfo['type'];
        $data['schoolid'] = $_REQUEST['school'];
        //$data['classid'] = $_REQUEST['class'];
        $data['name'] = $_REQUEST['name'];
        $data['appsecret'] = trim($usermanageinfo['secret']);
        $data['appkey'] = trim($usermanageinfo['appkey']);
        $data['create_time'] = time();
        //var_dump($data);
        //获取时间参数
        //$start_time = I('start_time');
        //$end_time = I('end_time');
        //$datys = I('days');
        //$str_days = implode('-', $datys);
        //var_dump($_POST);exit;

        if ($data['type'] == 1) {
            $post_data = 'appKey=' . $data['appkey'] . '&appSecret=' . $data['appsecret'];
            //数据库中存在萤石平台的token
            if ($usermanageinfo['token']) {
                //判断是否过期
                $nowTime = time() + 8 * 3600;
                if ($nowTime - $usermanageinfo['token_time'] > 3500 * 7 * 24) {
                    //token过期---从新获取token
                    //首先获取token
                    $token = $this->getToken($post_data);
                    if (empty($newToken)) {
                        die("获取token失败");
                        //$this->error("获取token失败");
                    }
                    //修改数据库
                    $arr = array(
                        'token' => $token,
                        'token_time' => time() + 8 * 3600
                    );
                    $results = M('monitor_usermanage')->where("id = $id")->save($arr);
                    if (!$results) {
                        //修改数据库失败
                        die('修改token失败');
                    }
                } else {
                    //没有过期
                    //判断appke与secret是否匹配----有问题
                    $token = $usermanageinfo['token'];
                }
            } else {
                //获取token并保存到数据库中
                $token = $this->getToken($post_data);
                if (empty($token)) {
                    $this->error("获取token失败");
                }
                //要修改的数据字段
                $arr = array(
                    'token' => $token,
                    'token_time' => time() + 8 * 3600
                );
                $results = M('monitor_usermanage')->where("id = $id")->save($arr);
                if (!$results) {
                    //修改数据库失败
                    die('添加token失败');
                }
            }
            //echo $token;exit;
            $start_page = isset($_GET['now_page']) ? I('now_page') : 0;
            if ($start_page != 0){
                $start_page =  $start_page - 1;
            }
            $page_size = 16;
            //再获取所有的摄像头
            $info = $this->getCamaroList($token, $start_page, $page_size);
//            $info = $this->getDeviceName($token,$info);

            $camarolist = json_decode($info);


            $camarolist = json_decode(json_encode($camarolist), true);

            //var_dump($camarolist['data']);exit();
//            dump($camarolist);
//            exit;
            $total = $camarolist['page']['total'];
            $this->assign("camarolist", $camarolist["data"]);
            $this->assign('total', $total);
            $this->assign('page', $camarolist['page']['page']);
            $this->assign('size', $camarolist['page']['size']);
            $this->assign('totalPage', ceil($camarolist['page']['total']/$camarolist['page']['size']));
        } else {
            //乐成
            //获取token
            if ($usermanageinfo['token']) {
                //判断是否过期
                $nowTime = time() + 8 * 3600;
                if ($nowTime - $usermanageinfo['token_time'] > 3 * 3500 * 24) {
                    //token过期---从新获取token
                    //首先获取token
                    echo 1;
                    $newToken = $this->getTokenByMobile($usermanageinfo);
                    if (empty($newToken)) {
                        die("获取token失败");
                        //$this->error("获取token失败");
                    }
                    //修改数据库
                    $arr = array(
                        'token' => $newToken,
                        'token_time' => time() + 8 * 3600
                    );
                    $results = M('monitor_usermanage')->where("id = $id")->save($arr);
                    if (!$results) {
                        //修改数据库失败
                        die('修改token失败');
                    }
                }
//                else {
//                    //没有过期
//                    //判断appke与secret是否匹配----有问题
//
//                    $token = $usermanageinfo['token'];
//                }
            } else {
                //获取token并保存到数据库中
                //echo 2;
                $token = $this->getTokenByMobile($usermanageinfo);
                //var_dump($token);exit;
                if (empty($token)) {
                    die("获取token失败");
                }
                //要修改的数据字段
                $arr = array(
                    'token' => $token,
                    'token_time' => time() + 8 * 3600
                );
                $results = M('monitor_usermanage')->where("id = $id")->save($arr);
                if (!$results) {
                    //修改数据库失败
                    die('添加token失败');
                }
            }
            //获取账号信息
            $uInfo = M('monitor_usermanage')->where("id = $id")->find();
            //获取设备列表
            $info = $this->getByLeChengDeviceList($uInfo);
            //var_dump($info);exit;
            $camarolist = json_decode($info);
            $camarolist = json_decode(json_encode($camarolist), true);
            //dump($camarolist);exit();
            $this->assign("camarolist", $camarolist["devices"]);
        }
        //var_dump($camarolist["data"]["0"]["picUrl"]);
        //传入时间参数
//        $this->assign('start_time', $start_time);
//        $this->assign('end_time', $end_time);
//        $this->assign('days', $str_days);

        $this->assign("type", $data['type']);
        $this->assign("schoolid", $_REQUEST['school']);
        //$this->assign("classid", $_REQUEST['class']);
        //$this->assign("name", $_REQUEST['name']);
        $this->assign('usermanage_id', $id);
        $this->assign("deviceSerial", $data['deviceSerial']);
        $this->assign("appsecret", $data['appsecret']);
        $this->assign("appkey", $data['appkey']);
        $this->display();
    }

    public function getYingDeviceName()
    {

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
        if ($arr_else["result"]['code'] == 0){
            return $arr_else["result"]["data"]["accessToken"];
        }
        return null;
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
        if ($arr['code'] == 200){
            return $token;
        }
        return null;
    }


    //TODO获取指定设备的通道信息 后期优化
    function getDeviceName($token,$deviceSerial)
    {


        $camarolist = json_decode($deviceSerial,true);

          $i = 0;
        foreach($camarolist as $key=>$value)
        {
            $i++;
            if($i = 1)
            {
                $res = $value;
                foreach ($res as $k=>&$val)
                {

                    $device = $val['deviceSerial'];

                    $post_data = "&accessToken=" . $token."&deviceSerial=$device";
                    $this_header = array("application/x-www-form-urlencoded; charset=gbk");
                    //        $url = 'https://open.ys7.com/api/lapp/camera/list';
                    $url = 'https://open.ys7.com/api/lapp/device/camera/list';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $data = curl_exec($ch);
                    $result = json_decode($data,true);

                    $arr = $result['data'];

                    if($data)
                    {
                      foreach ($arr as $name)
                      {
                          $channelNo = $name['channelNo'];
                          if($channelNo==$val['channelNo'])
                          {
                              $camarolist[$key][$k]['deviceName'] = $name['deviceName'];
                              $camarolist[$key][$k]['channelName'] = $name['channelName'];
                              break;
                          }
                      }
//
                    }
                }
            }


        }

        return json_encode($camarolist);


    }

    //获取摄像头方法
    function getCamaroList($token, $start_page, $page_size)
    {
        $post_data = "&accessToken=" . $token."&pageStart=$start_page&pageSize=$page_size";
        $this_header = array("application/x-www-form-urlencoded; charset=gbk");
//        $url = 'https://open.ys7.com/api/lapp/camera/list';
        $url = 'https://open.ys7.com/api/lapp/live/video/list';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        if($res)
        {
             $result = $this->getDeviceName($token,$res);
        }
        return $result;
    }

    public function add()
    {
        $schools = M('school')->select();
        //获取账户管理数据
        $usermanage = M('monitor_usermanage')->select();
        $this->assign('usermanage', $usermanage);
        $this->assign('schools', $schools);
        $this->display();
    }

    //添加视频
    function add_post()
    {
        $type = I('type');
        $data['usermanage_id'] = $_POST['usermanage_id'];
        $data['schoolid'] = $_POST['schoolid'];


        if ($type == 1) {
            //将设备信息插入数据库

            $strVideoList = $_POST['videoList'];

            $jsonVideoList = json_decode($strVideoList, true);
            //dump($jsonVideoList);
            foreach ($jsonVideoList as $k=>$v){
                $channels = array(
                    'channelNo' => $jsonVideoList[$k]['channelNo'],
                    'channelName' => $jsonVideoList[$k]['channelName'],
                    'deviceSerial' => $jsonVideoList[$k]['deviceSerial'],
                    'school_id' => $data['schoolid'],
                    'nname' => $jsonVideoList[$k]["channelName"],
                    'liveAddress' => $jsonVideoList[$k]["liveAddress"],
                    'hdAddress' => $jsonVideoList[$k]["hdAddress"],
                    'rtmpAddress' => $jsonVideoList[$k]["rtmpAddress"],
                    'rtmpHdAddress' => $jsonVideoList[$k]["rtmpHdAddress"],
                    'exception' => $jsonVideoList[$k]["exception"],
                    'status' => $jsonVideoList[$k]['status'],
                    'usermanage_id'=>$data['usermanage_id'],
                    'type'=>$type,
                    'img'=>$jsonVideoList[$k]['img']
                );
                $insert = M('monitor_live')->add($channels);
            }
            $this->success("添加成功！", U('index'));
        } elseif ($type == 2) {
            $strVideoList = $_POST['videoList'];
            $jsonVideoList = json_decode($strVideoList, true);
            foreach ($jsonVideoList as $k=>$v){
                $channels = array(
                    'channelNo' => $jsonVideoList[$k]['channelNo'],
                    'channelName' => $jsonVideoList[$k]['channelName'],
                    'deviceSerial' => $jsonVideoList[$k]['deviceSerial'],
                    'school_id' => $data['schoolid'],
                    'nname' => $jsonVideoList[$k]["channelName"],
                    'status' => $jsonVideoList[$k]['status'],
                    'usermanage_id'=>$data['usermanage_id'],
                    'type'=>$type,
                    'img'=>$jsonVideoList[$k]['img']
                );
                $insert = M('monitor_live')->add($channels);
            }
            $this->success("添加成功！", U('index'));
        }
    }

    //删除所有
    public function deleteAll(){
        $ids = json_decode($_POST['ids']);
        foreach ($ids as $v){
            $res = M('monitor_live')->where("id = $v")->delete();
        }
        echo json_encode(array('status'=>200));
        exit;
    }
}