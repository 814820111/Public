<?php

/**
 * 视频监控管理
 */

namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class MonitorDeviceController extends AdminbaseController
{
    function _initialize()
    {
        parent::_initialize();
    }

    //设备列表
    public function index()
    {
        $userid=I('name');
        if($userid){
            $where = "userid = '$userid'";
        }else{
            $where = 1;
        }
        if (IS_POST) {
            $keyword = I('keyword');
            $keywordtype = I('keywordtype');
            $idarrays = M('monitor_device')->field('max(id)')->group('deviceserial')->select();
            $idarray = $this->array_column($idarrays,'max(id)');
            $map['id']  = array('in',$idarray);
            switch ($keywordtype) {
                case 2:
                    $info = M('monitor_device')->where($map)->where("devicename like '%$keyword%' and $where")->select();
                    break;
                case 3:
                    $info = M('monitor_device')->where($map)->where("deviceserial like '%$keyword%' and $where")->select();
                    break;
                default:
                    ;
            }
            $this->assign('keyword', $keyword);
        } else {
            $idarrays = M('monitor_device')->field('max(id)')->group('deviceserial')->select();
            $idarray = $this->array_column($idarrays,'max(id)');
            $map['id']  = array('in',$idarray);
            $info = M('monitor_device')->where($map)->where("$where")->count();
            $count = $info;
            $page = $this->page($count, 15);
            $info = M('monitor_device')->where($map)->where("$where")->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();
            $this->assign('page', $page->show('Admin'));
        }
        $this->assign('userid', $userid);
        $username=M('MonitorUsermanage')->field('id,name')->select();
        $this->assign('username', $username);
        $this->assign('info', $info);
        $this->display();
    }
    //更新数据库设备
    public function updata()
    {
        $id=I('id');
        switch ($id) {
            case 11:
                $this->updevice();
                break;
            default:
                $this->error('暂只支持海康账号更新数据');
        }
    }
    //修改设备名称
    public function edit()
    {

        $id = I('id');
        //获取名称
        $device = M('monitor_device')->where("id = $id")->find();
        $this->assign('device', $device);
        $this->assign('id', $id);
        $this->display();
    }

    public function edit_post()
    {
        if (!IS_POST) {
            $this->error('请求方式错误');
        }
        $id=trim(I('id'));
        //获取设备名称
       // $devicename=trim(I('devicename'));
       // $olddevicename=I('olddevicename');
        $devicename=1;
        $olddevicename=1;
        //获取本地别名
        $aliass=trim(I('aliass'));
        $oldalias=I('oldalias');
        //$deviceserial=I('deviceserial');
        if($devicename == $olddevicename){
            if($aliass == $oldalias){
                $this->error('没有改动');
            }
            $arr=array('alias'=>$aliass,
                  "up_date" => date('Y-m-d H:i:s', time()),
                  "uptime" => time()
            );
            $results = M('monitor_device')->where("id = $id")->save($arr);
            if($results){
                $this->success('修改设备別名成功','index',3);
                exit;
            }else{
                $this->error('保存别名失败');
            }
        }
        $token=$this->gettokenys();
        if($aliass == $oldalias){
            $results=$this->editDeviceName($token,$deviceserial,$devicename);
            if($results['code'] == 200){
                $arr=array('deviceName'=> $devicename,
                    "up_date" => date('Y-m-d H:i:s', time()),
                    "uptime" => time()
                );
                $resultz = M('monitor_device')->where("id = $id")->save($arr);
                $this->success('修改设备名称成功','index',3);
                exit;
            }else{
                $this->error($results['msg']);
            }
        }

        $results=$this->editDeviceName($token,$deviceserial,$devicename);
            if($results){
                $arr=array('alias'=>$aliass,
                    'deviceName'=>$devicename,
                    "up_date" => date('Y-m-d H:i:s', time()),
                    "uptime" => time()
                );
                $resultz = M('monitor_device')->where("id = $id")->save($arr);
                $this->success('修改成功','index',3);
                exit;
            }else{
                $this->error($results['msg']);
            }
    }


    //更新设备名
    public function editDeviceName($token,$deviceserial,$devicename) {

        $post_data="accessToken=".$token."&deviceSerial=".$deviceserial."&deviceName=".$devicename;
        $this_header = array("application/x-www-form-urlencoded; charset=gbk");
        $url='https://open.ys7.com/api/lapp/device/name/update';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        $arr=json_decode($result,true);
        return $arr;

    }
    //获取萤石的token
    function gettokenys()
    {
        //获取账号信息---appKey
        $id = 11;
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
            return $token;
        }
    }
    //更新本地设备列表的数据库
    function updevice()
    {
        //获取账号信息---appKey
        $id = 11;
        $usermanageinfo = M('monitor_usermanage')->where("id=$id")->find();
        //获取post数据
        $data['type'] = $usermanageinfo['type'];
        $data['schoolid'] = $_REQUEST['school'];
        //$data['classid'] = $_REQUEST['class'];
        $data['name'] = $_REQUEST['name'];
        $data['appsecret'] = trim($usermanageinfo['secret']);
        $data['appkey'] = trim($usermanageinfo['appkey']);
        $data['create_time'] = time();

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
                    if (empty($token)) {
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

            //获取所有设备
            $info = $this->devicelist($token);
            $devicelist = json_decode($info);
            $devicelist = json_decode(json_encode($devicelist), true);
           foreach ($devicelist['data'] as $value){
               $alias =  M('monitor_device')->where("deviceserial = '$value[deviceSerial]'")->field('alias')->order('id desc')->find();
               $dataa = array();
               $dataa["deviceSerial"] = $value["deviceSerial"];
               $dataa["deviceName"] = $value["deviceName"];
               $dataa["deviceType"] = $value["deviceType"];
               $dataa["status"] = $value["status"];
               $dataa ["defence"] = $value["defence"];
               $dataa ["deviceVersion"] = $value["deviceVersion"];
               $dataa ["userid"] = $usermanageinfo['id'];
               $dataa ["username"] = $usermanageinfo['name'];
               $dataa ["alias"] = $alias['alias'];
               $dataa ["up_date"] = date('Y-m-d H:i:s', time());
               $dataa ["uptime"] = time();
               $results = M('monitor_device')->add($dataa);
           }
            $this->success('更新完成','index',3);
            exit;
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
                $info = $this->getDevice($token, $start_page, $page_size);
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
    //获取设备列表
    function devicelist($token)
    {
        $post_data = "&accessToken=" . $token;
        $this_header = array("application/x-www-form-urlencoded; charset=gbk");
        $url = 'https://open.ys7.com/api/lapp/device/list';
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
    //获取摄像头方法
    function getCamaroList($token, $start_page, $page_size)
    {
        $post_data = "&accessToken=" . $token."&pageStart=$start_page&pageSize=$page_size";
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
                    'status' => $jsonVideoList[$k]['status'],
                    'usermanage_id'=>$data['usermanage_id'],
                    'type'=>$type,
                    'img'=>$jsonVideoList[$k]['img']
                );
                $insert = M('monitor_video')->add($channels);
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
                $insert = M('monitor_video')->add($channels);
            }
            $this->success("添加成功！", U('index'));
        }
    }


    /**
     * 低于PHP 5.5版本的array_column()函数
     **/
    function array_column($input, $columnKey, $indexKey = NULL)
    {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
        $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
        $result = array();

        foreach ((array)$input AS $key => $row)
        {
            if ($columnKeyIsNumber)
            {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
            }
            else
            {
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
            }
            if ( ! $indexKeyIsNull)
            {
                if ($indexKeyIsNumber)
                {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
                    $key = is_null($key) ? 0 : $key;
                }
                else
                {
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }

            $result[$key] = $tmp;
        }

        return $result;
    }
}