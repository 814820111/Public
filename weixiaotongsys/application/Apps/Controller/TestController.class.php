<?php

namespace Apps\Controller;

use Common\Controller\AppBaseController;

/**
 * 首页
 */
class TestController extends AppBaseController
{

    //首页
    public function index()
    {
        die('this is appscontroller');
    }

    public function jiguang()
    {
        $userid = I('userid');
        $umsg = I('content');
        $sound = I('sound');
        $key = I('key');
        $usertype = intval(I('usertype'));
        $userid_array = explode(',', $userid);
        //去掉数组中的空格位置
        $userid_array = array_filter($userid_array);
        if (!empty($userid)) {
            $receive = array();
            foreach ($userid_array as $key => $value) {
                $receive['alias'][$key] = $value;
            }
        } else {
            $receive = "";
        }
        if ($usertype == 1) {
            $rs = $this->tjiguang($umsg, 'system', $userid_array, 0);
        } else {
            $rs = $this->pjiguang($umsg, 'system', $userid_array, 0);
        }

        if ($rs) {
            $ret = "success";
        } else {
            $ret = "error";
        }
        // var_dump($userid_array);
        var_dump($ret);
        return $ret;
    }



    //获取班级对应的视频列表信息
    public function GetClassVideoList()
    {
        $classid = I("classid");
        $monitor_list = M("monitor")->where("classid=$classid")->find();
        if ($monitor_list) {
            $ret = $this->format_ret(1, $monitor_list);
        } else {
            $ret = $this->format_ret(0, '获取失败');
        }
        echo json_encode($ret);
        exit;
    }

    //获取班级对应的视频列表信息-----yy
    public function getVideoListByClassId()
    {
        header('content-type: text/html; charset=utf-8');
        $classid = I("id");
        if (empty($classid)) {
            $ret = $this->format_ret(0, '请输入班级id或老师id');
            echo json_encode($ret);
            exit();
        }
        //获取当前班级的信息
        $monitor_list = M('monitor')
            ->alias("m")
            ->join("wxt_monitor_channel as c on m.id = c.monitor_id")
            ->where("m.classid = $classid")
            ->select();
        //dump($monitor_list);exit;
        if ($monitor_list) {
            //获取时间
            $time = M('monitor_channel_time')->where("monitor_id = {$monitor_list[0]['monitor_id']}")->find();
            $arr['start_time'] = $time['start_time'];
            $arr['end_time'] = $time['end_time'];
            $arr['days'] = $time['days'];
            $arr['classid'] = $classid;
            //获取所有的usermanage_id
            $typeAndUids = M('monitor')
                ->alias("m")
                ->join("wxt_monitor_channel as c on m.id = c.monitor_id")
                ->where("m.classid = $classid")
                ->group("c.usermanage_id")
                ->field("c.type,c.usermanage_id")
                ->select();
            //dump($typeAndUids);
            //;exit;
            foreach ($typeAndUids as $k => $v) {
                if ($v['type'] == 1) {
                    //萤石
                    $yingShi = $this->dealWithVideo(1, $v['usermanage_id'], $monitor_list);
                    //dump($yingShi);
                } elseif ($v['type'] == 2){
                    //乐成
                    $leCheng = $this->dealWithVideo(2, $v['usermanage_id'], $monitor_list);
                   //dump($leCheng);
                }
            }
            if (empty($leCheng) && !empty($yingShi)){
                $arr['device'] = $yingShi;
            }
            if (!empty($leCheng) && empty($yingShi)){
                $arr['device'] = $leCheng;
            }
            if (!empty($leCheng) && !empty($yingShi)){
                $arrs = array_merge($yingShi, $leCheng);
                $arr['device'] = $arrs;
            }
            if (empty($leCheng) && empty($yingShi)){
                $arr['device'] = null;
            }
        } else {
            $ret = $this->format_ret(0, '没有视频可以观看！');
            echo json_encode($ret);
            exit;
        }
       
        $ret = $this->format_ret(1, $arr);
        echo json_encode($ret);
        exit;
    }

    /*根据班级id或老师idh5页面获取直播列表
    * 入参 post id 班级id或老师id
    * 作者 ：彭书国
    */
    public function getVideoListWebByClassId()
    { 
        
        header('content-type: text/html; charset=utf-8');
        $schoolid = I("schoolid");
        //获取id
        $classid = I("id");
      
        //获取标识是老师还是班级
        $is_type = I("type");

        if($is_type==0)
        {
            $studentid = I("studentid");
            if (empty($studentid)) {
                $ret = $this->format_ret(0, '学生不能为空');
                echo json_encode($ret);
                exit();
            }
            $parentid = I("parentid");
            if (empty($parentid)) {
                $ret = $this->format_ret(0, '家长不能为空');
                echo json_encode($ret);
                exit();
            }

            $role_parent = $this->role_parent($studentid,$parentid,$schoolid);

           if(!$role_parent['status']){
              $ret = $this->format_ret(0, $role_parent['data']);
              echo json_encode($ret);
              exit();
           }
        }

        if (empty($classid)) {
            $ret = $this->format_ret(0, '请输入班级id或老师id');
            echo json_encode($ret);
            exit();
        }
        
        if ($is_type==="") {
            $ret = $this->format_ret(0, '无法识别!');
            echo json_encode($ret);
            exit();
        }

        //获取当前班级的信息
        $monitor_list = M('monitor')
            ->alias("m")
            ->join("wxt_monitor_channel as c on m.id = c.monitor_id")
            ->join("wxt_monitor_live as live on c.video_id = live.id")
            ->where("m.classid = $classid and m.type = $is_type and m.resource = 2 and live.school_id=$schoolid")
            //->where("m.classid = $classid and m.type = $is_type and m.resource = 2")
            ->select();
            
        //dump($monitor_list);exit;
        if ($monitor_list) {
            //获取时间
            $time = M('monitor_channel_time')->where("monitor_id = {$monitor_list[0]['monitor_id']}")->find();
            $arr['start_time'] = $time['start_time'];
            $arr['end_time'] = $time['end_time'];
            $arr['days'] = $time['days'];
            $arr['classid'] = $classid;
            //获取所有的usermanage_id
            $typeAndUids = M('monitor')
                ->alias("m")
                ->join("wxt_monitor_channel as c on m.id = c.monitor_id")
                ->where("m.classid = $classid and m.type = $is_type and m.resource = 2")
                ->group("c.usermanage_id")
                ->field("c.type,c.usermanage_id")
                ->select();
           
            //;exit;
            foreach ($typeAndUids as $k => $v) {
                if ($v['type'] == 1) {
                    //萤石
                    $yingShi = $this->dealWithVideoLive(1, $v['usermanage_id'], $monitor_list);
                    //dump($yingShi);
                } elseif ($v['type'] == 2){
                    //乐成
                    $leCheng = $this->dealWithVideoLive(2, $v['usermanage_id'], $monitor_list);
                   //dump($leCheng);
                }
            }
      
     
            if (empty($leCheng) && !empty($yingShi)){
                $arr['device'] = $yingShi;
            }
            if (!empty($leCheng) && empty($yingShi)){
                $arr['device'] = $leCheng;
            }
            if (!empty($leCheng) && !empty($yingShi)){
                $arrs = array_merge($yingShi, $leCheng);
                $arr['device'] = $arrs;
            }
            if (empty($leCheng) && empty($yingShi)){
                $arr['device'] = null;
            }
        } else {
            $ret = $this->format_ret(0, '没有视频可以观看！');
            echo json_encode($ret);
            exit;
        }
       
        $ret = $this->format_ret(1, $arr);
        echo json_encode($ret);
        exit;
    }

    /**  检查学生是否开通摄像头服务
     * @param $student 学生
     * @param $parent  家长
     */
    private function role_parent($studentid,$parentid,$schoolid)
    {

        $monitor = M("monitor")->where(array("schoolid"=>$schoolid,"classid"=>$studentid))->find();
        if(!$monitor)
        {
            return array("status"=>false,"data"=>"该学生没有开通视频服务");
        }
        //判断收费是否过期
        if(time() > $monitor['opening_time_int'])
        {
            return array("status"=>false,"data"=>"视频服务已过期,请续费");
        }

       //只查询主号码
       $is_parentid = M("relation_stu_user")->where(array("studentid"=>$studentid,"type"=>1))->getField("userid");
       if($is_parentid==$parentid)
       {
           return array("status"=>true);
       }else{
           return array("status"=>false,"data"=>"该家长没有开通视频服务");
       }

    }

        //直播数据处理
    private function dealWithVideoLive($type, $mid, $monitor_list)
    {
        $token = M('monitor_usermanage')->where("id = $mid")->find();
        $appKey = $token['appkey'];
        $appSecret = $token['secret'];
        //var_dump($token);

        //判断token是否有效
        $tokenFlag = $this->tokenIsOk($type, $token);  //  false过期
        //没有token或token已经失效
        if (!$tokenFlag) {
            //获取token
            if ($type == 1){
                $tokenFlag = $this->getTokenByYingShiYun($token);
            } elseif ($type == 2){
                $tokenFlag = $this->getTokenByLeChengYun($token);
            }
            if ($tokenFlag){
                //修改数据库
                $arr = array(
                    'token' => $tokenFlag,
                    'token_time' => time() + 8 * 3600
                );
                //dump($tokenFlag);
                //exit;
                $res = M('monitor_usermanage')->where("id = $mid")->save($arr);
                if (!$res) {
                    $ret = $this->format_ret(0, '修改数据库token失败');
                }
            }else{
                $ret = $this->format_ret(0, '获取token失败');
                exit;
            }
        }
        //列表部分
        foreach ($monitor_list as $ks => $vs) {
            if ($vs['type'] == $type){
                $arr[$ks]['accessToken'] = $tokenFlag;
                $arr[$ks]['appKey'] = $appKey;
                $arr[$ks]['appSecret'] = $appSecret;
                $arr[$ks]['type'] = $type;
                $arr[$ks]['deviceserial'] = $vs['deviceserial']; //设备序列号
                $arr[$ks]['liveaddress'] = $vs['liveaddress']; //直播地址
                $arr[$ks]['status'] = $vs['status']; //设备状态
                $arr[$ks]['channelno'] = $vs['channelno']; //设备通道号
                $arr[$ks]['channelname'] = $vs['nname']; //设备名称
                $arr[$ks]['ability'] = $vs['ability'];
                $arr[$ks]['img'] = $vs['img']; //设备图片
            }
        }
        //$arr = $this->getPic($arr);
        return $arr;
    }


    //视频数据处理
    private function dealWithVideo($type, $mid, $monitor_list)
    {
        $token = M('monitor_usermanage')->where("id = $mid")->find();
        $appKey = $token['appkey'];
        $appSecret = $token['secret'];
        //var_dump($token);

        //判断token是否有效
        $tokenFlag = $this->tokenIsOk($type, $token);  //  false过期
        //没有token或token已经失效
        if (!$tokenFlag) {
            //获取token
            if ($type == 1){
                $tokenFlag = $this->getTokenByYingShiYun($token);
            } elseif ($type == 2){
                $tokenFlag = $this->getTokenByLeChengYun($token);
            }
            if ($tokenFlag){
                //修改数据库
                $arr = array(
                    'token' => $tokenFlag,
                    'token_time' => time() + 8 * 3600
                );
                //dump($tokenFlag);
                //exit;
                $res = M('monitor_usermanage')->where("id = $mid")->save($arr);
                if (!$res) {
                    $ret = $this->format_ret(0, '修改数据库token失败');
                }
            }else{
                $ret = $this->format_ret(0, '获取token失败');
                exit;
            }
        }
        //列表部分
        foreach ($monitor_list as $ks => $vs) {
            if ($vs['type'] == $type){
                $arr[$ks]['accessToken'] = $tokenFlag;
                $arr[$ks]['appKey'] = $appKey;
                $arr[$ks]['appSecret'] = $appSecret;
                $arr[$ks]['type'] = $type;
                $arr[$ks]['deviceserial'] = $vs['deviceserial']; //设备序列号
                $arr[$ks]['status'] = $vs['status']; //设备状态
                $arr[$ks]['channelno'] = $vs['channelno']; //设备通道号
                $arr[$ks]['channelname'] = $vs['nname']; //设备名称
                $arr[$ks]['ability'] = $vs['ability'];
                $arr[$ks]['img'] = $vs['img']; //设备图片
            }
        }
        //$arr = $this->getPic($arr);
        return $arr;
    }

    //获取视频截图
    private function getPic($arr)
    {
        foreach ($arr as $k=>$v){
            if ($v['type'] == 1){
                //萤石
                $post_data = 'accessToken=' .$v['accessToken'].'&deviceSerial='.$v['deviceserial'].'&channelNo='.$v['channelno'];
                $this_header = array("Content-Type: application/x-www-form-urlencoded; charset=gbk");
                $url = 'https://open.ys7.com/api/lapp/device/capture';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                $arr = json_decode($result, true);
                var_dump($arr);exit;
                return $result;
            } elseif ($v['type'] == 2){

            }
        }
    }

    //获取乐成的token
    public function getTokenByLeChengYun($info)
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
        //dump($arr_else);
        if ($arr_else["result"]['code'] == 0){
            return $arr_else["result"]["data"]["accessToken"];
        }
        return null;
    }

    /*
     * 传入参数为账号ID,//获取token
     *根据指定的appkey跟appsecret获取萤石云token
     */
    public function getTokenByYingShiYun($app)
    {

        //$app = M('monitor_usermanage')->where("id = $usermanage_id")->find();
        //需要获取appKey和appSecret
        $post_data = 'appKey=' . $app['appkey'] . '&appSecret=' . $app['secret'];
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
        //dump($arr);
        if ($arr['code'] == 200){
            return $arr['data']['accessToken'];
        }
        return null;
    }
    /*
     * 传入参数为账号ID,//获取token
     *调用接口，根据传入的appkey跟appsecret获取萤石云token
     */
    public function getTokenYingShiYun()
    {
        $appkey=I('appkey');
        $appsecret=I('secret');
        //$app = M('monitor_usermanage')->where("id = $usermanage_id")->find();
        //需要获取appKey和appSecret
        $post_data = 'appKey=' . $appkey . '&appSecret=' . $appsecret;
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
        dump($arr);

    }
    //判断当前平台的token是否有效
    /*
     * flag = 1   萤石
     * flag = 2   乐成
     */
    public function tokenIsOk($flag, $token = '')
    {
        $nowTime = time() + 8 * 3600;
        //判断当前平台
        if ($flag == 1) {
            //萤石---//判断数据库中是否存在token
            if (empty($token['token'])) {
                return null;
            }
            //判断是否失效
            if ($nowTime - $token['token_time'] > 3500 * 7 * 24) {
                //过期----返回false
                return false;
            } else {
                //调用数据库的token
                return $token['token'];
            }
        } elseif ($flag == 2) {
            //乐成
            //$token = M('lecheng_token')->find();
            if (empty($token)) {
                return null;
            }
            //判断是否失效
            if ($nowTime - $token['token_time'] > 3500 * 3 * 24) {
                //过期----返回false
                return false;
            } else {
                //调用数据库的token
                return $token['token'];
            }
        }
    }
    //根据指定的appkey跟appsecret获取萤石云token
    public function yingshiyun()
    {
        //$post_data='appKey=e6a9eb61e34d4b64a6a1d92867914d9c&appSecret=ab272524acaef9ba39e686b33be0d36f';
        $post_data = 'appKey=3891cce2b8f441f7ba2977e555904f01&appSecret=39b7f44eb865ea81b90ff59bbb037c2a';
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
        // $info=$this->getCamaroList($token);
        // var_dump($token);
        // $a=json_decode($info,true);
        // $b = mb_convert_encoding($a["msg"], 'gbk', 'auto');
        echo($token);
        exit;
    }

    public function getCamaroList()
    {
        $token = I('token');
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

        echo($result);
        exit;
    }

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

    /**
    *获取指定有效期的直播地址
    *
    */
    function LiveVideoList()
    {
        $token='at.4pt6i96t63kc7dc0dua1uzuxb1yynbbw-9671903qdw-0pczoh8-ofk5vmypr';
        $post_data = "&accessToken=" . $token ;
        $this_header = array("application/x-www-form-urlencoded; charset=gbk");
        $url = 'https://open.ys7.com/api/lapp/live/video/list';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        echo $result;
    }

    /**
    *获取指定有效期的直播地址
    *
    */
    function LiveVideolimited()
    {
        $token='at.4pt6i96t63kc7dc0dua1uzuxb1yynbbw-9671903qdw-0pczoh8-ofk5vmypr';
        $deviceSerial='747669153';
        $channelNo=1;
        $post_data = "&accessToken=" . $token."&deviceSerial=$deviceSerial&channelNo=$channelNo";
        $this_header = array("application/x-www-form-urlencoded; charset=gbk");
        $url = 'https://open.ys7.com/api/lapp/live/address/limited';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        echo $result;
    }
       /**
    *获取直播地址
    *
    */
    function LiveVideoget()
    {
        $token='at.4pt6i96t63kc7dc0dua1uzuxb1yynbbw-9671903qdw-0pczoh8-ofk5vmypr';
        $deviceSerial='747669153';
        $channelNo=1;
        $source='747669153:3';
        $post_data = "&accessToken=" . $token."&source=$source&channelNo=$channelNo";
        $this_header = array("application/x-www-form-urlencoded; charset=gbk");
        $url = 'https://open.ys7.com/api/lapp/live/address/get';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        echo $result;
    }
    public function lecheng()
    {

        //微校通设备
        $appId = 'lc46aca9dfa13f405b';
        $appSecret = "482b6e7b6edf45b38ec5265ba94248";
        // $phone = "15888708668";//这是登录账号，应该用下面的管理员账号
        $phone = "6b10a4ce84f740c1";

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

        echo $arr_else["result"]["data"]["accessToken"];
        exit;
    }

    public function lechengDeviceList()
    {
        $token = I("token");

        // 微校通设备
        $appId = 'lc46aca9dfa13f405b';
        $appSecret = "482b6e7b6edf45b38ec5265ba94248";

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
        $data["queryRange"] = "1-30";
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
        echo json_encode($arr_else["result"]["data"]);
    }

    function getSign($data)
    {
        foreach ($data as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $buff = "";
        foreach ($Parameters as $k => $v) {
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $String;
        if (strlen($buff) > 0) {
            $String = substr($buff, 0, strlen($buff) - 1);
        }
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . "dc97f063b53bf6af160b51c50623b310"; // 商户后台设置的key
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
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




