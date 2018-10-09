<?php

namespace Apps\Controller;
use Common\Controller\AppBaseController;
/**
 * 首页
 */
class IndexController extends AppBaseController {
	
    //首页
	public function index() {
    	die('this is appscontroller');
    }
      public function jiguang(){
        $userid=I('userid');
        $umsg=I('content');
        $sound=I('sound');
        $key=I('key');
        $usertype=intval(I('usertype'));
        $userid_array = explode(',',$userid);
        //去掉数组中的空格位置
        $userid_array = array_filter($userid_array);
        if(!empty($userid)){
            $receive = array();
            foreach ($userid_array as $key => $value) {
                $receive['alias'][$key] = $value;
            }
        }else{
            $receive="";
        }
        if($usertype==1){
            $rs=$this->tjiguang($umsg,'system',$userid_array,0);
        }else{
            $rs=$this->pjiguang($umsg,'system',$userid_array,0);
        }
        
        if($rs){
            $ret="success";
        }else{
            $ret="error";
        }
        // var_dump($userid_array);
        var_dump($ret);
        return $ret;
    }
    //教师端推送
    function tjiguang($content = "",$m_type='',$receive="",$m_value=""){
        //查找用户对应的registrationid
        $recivelist = array();
        $ishave=0;
        foreach ($receive as &$userid) {
            $where['id']=$userid;
            $u=M('wxtuser')->where($where)->field('xgtoken')->find();
            if(!empty($u['xgtoken'])){
               $recivelist[]=$u['xgtoken']; 
               $ishave=1;
           }
        }
        if($ishave==1){
            $receiver = array('registration_id'=>$recivelist);
            $rs=tjpush($content,$m_type,$receiver,$m_value,0);
            if($rs){
                $ret="success";
            }else{
                $ret="error";
            }
        }else{
            $ret="error";
        }
        return $ret;
    }
   
    //家长端推送
    function pjiguang($content = "",$m_type='',$receive="",$m_value="",$istostu=""){
        $recivelist = array();
        $ishave=0;
        foreach ($receive as &$userid) {
            $where['id']=$userid;
            $u=M('wxtuser')->where($where)->field('xgtoken')->find();
            if(!empty($u['xgtoken'])){
               $recivelist[]=$u['xgtoken']; 
               $ishave=1;
           }
        }
        if($ishave==1){
            $receiver = array('registration_id'=>$recivelist);
            $rs=ujpush($content,$m_type,$receiver,$m_value,0);
            if($rs){
                $ret="success";
            }else{
                $ret="error";
            }
        }else{
            $ret="error";
        }
        // $receiver = array('alias'=>$receive);
        // $rs=ujpush($content,$m_type,$receiver,$m_value,0);
        // if($rs){
        //     $ret="success";
        // }else{
        //     $ret="error";
        // }
        return $ret;
    }
	//登陆方法
    public function AppLogin() {
		//获取传入的参数phone,password；赋值给$mobile,$pass
        $mobile = I('phone');
        $password = I('password');
        $jgtoken = I('jgtoken');
        $usertype=intval(I('usertype'));//用户类型0:家长，1:老师
		//判断手机号及密码状态
        if($mobile != "" && $password !="")
        {
			//如果都不为空
			//表示实例化Model模型类，并操作 wxt_Wxtuser 表
            $users = M("Wxtuser");
			//判断该手机号在数据库中是否存在，若存在，则以数组的形式返回该手机号对应的数据信息
            $userinfo = $users->where(array("phone"=>$mobile))->find();
            //判断该手机号是不是老师活家长
            if($userinfo){
                $teacher=M("teacher_info")->where(array("teacherid"=>$userinfo['id']))->find();
                $parent=M("relation_stu_user")->where(array("userid"=>$userinfo['id']))->find();
            }
            if (!$userinfo) {
				//若手机号不存在
                    $ret = $this->format_ret(0,'用户不存在');
            } else if (md5($password) != $userinfo['password']) {
				//若密码不匹配
                    $ret = $this->format_ret(0,"密码错误！");
            } else if (!empty($teacher)&&empty($parent)&&$usertype==0){
                    $ret = $this->format_ret(0,'用户不存在');
            } else if (empty($teacher)&&!empty($parent)&&$usertype==1){
                    $ret = $this->format_ret(0,'用户不存在');
            } else {
				//用户名及密码正好匹配
                //查询本次的极光ID和上次是否一样，如果不一样，则推送下线通知
                if($userinfo['xgtoken'] != $jgtoken){
                    //推送通知
                    $umsg="你的账号已在其他设备登录!";
                    // $userid_array[] = $userinfo['id'];
                    $userid_array = explode(',',$userinfo['id']);
                    //去掉数组中的空格位置
                    $userid_array = array_filter($userid_array);
                    if($usertype==1){
                        $rs=$this->tjiguang($umsg,'loginFromOther',$userid_array,0);
                    }else{
                        $rs=$this->pjiguang($umsg,'loginFromOther',$userid_array,0);
                    }
                    // $rs=$this->tjpush($umsg,'loginFromOther',$receiver,$registrationID,0); 

                }
                $teacherid=$userinfo["id"];
                $save["xgtoken"]=$jgtoken;
                $token=$users->where("id=$teacherid")->save($save);
                $school = M("teacher_class")
                ->alias("t")
                ->join("wxt_school w ON w.schoolid=t.schoolid")
                ->where("t.teacherid=$teacherid")
                ->field("t.*,w.school_name")
                ->find();
                $userinfo["schoolid"]=$school["schoolid"];
                $userinfo["classid"]=$school["classid"];
                $userinfo["school_name"]=$school["school_name"];
                $ret = $this->format_ret(1,$userinfo);
            }
        }
        else
        {
			//若有一个为空，则返回(0,‘param lost’)
            $ret = $this->format_ret(0,'param lost');
        }
        echo json_encode($ret);
	exit;
    }
    //更新绑定的环信ID
    public function addhuanxinid(){
        $userid = Intval(I("userid"));
        $huanxinid = Intval(I("huanxinid"));
        if($userid && $huanxinid){
            $user_model = M("Wxtuser");
            $dataarray = array("huanxinid"=>$huanxinid);
            $user_model->where("id=$userid")->save($dataarray);
            $ret = $this->format_ret(1,"success");
        }
        else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;  
    }
/*账号验证
* 1.验证手机验证码是否正确
* 2.验证输入的账号是否存在于数据库中
 * 3.判断用户激活状态
*/
	public function UserVerify() {
        //获取手机号，验证码
		$mobile = I('phone');
		$code = I('code');
		if( $mobile !="" && $code !="") {
		    //如果都不为空，先进行code验证
            $noteCode =	M("auth_code");
            $noteCodeinfo = $noteCode->where(array("mobile"=>$mobile,"code"=>$code,"is_show"=>1))->find();
            if($noteCodeinfo)
            {
                //短信验证码正确
                //验证成功，更改验证码状态
                $noteCode->where(array("mobile"=>$mobile,"code"=>$code))->save(array("is_show"=>2,"status"=>4));
                //进行手机号码验证
                $users = M("Wxtuser");
                $userinfo = $users->where(array("phone"=>$mobile))->find();
                if($userinfo){
                    //手机号码存在
                    //获取该手机号码状态status
                    $status = $users->where(array("phone"=>$mobile))->getField("status");
                    //判断用户激活状态
                    if($status==0){
                        //返回数据

                        $ret = $this->format_ret(1,$userinfo);
                    }else{
                        $ret = $this->format_ret(0,'已激活！');
                    }

                }else{
                    //手机号码不存在
                    $ret = $this->format_ret(0,'请联系教师注册该手机号！');
                }
            }else{
                //短信验证码错误
                $ret = $this->format_ret(0,'验证码错误！');
            }
		}else{
            //若有一个为空，则返回(0,‘param lost’)
            $ret = $this->format_ret(0,'param lost');
		}
        echo json_encode($ret);
        exit;
	}
/*账号激活
 *1.获取传入的id和密码，将其存入数据库
 *2.激活状态
*/
    public function UserActivate(){
        $id = I('userid');
        $password = I('pass');
        //更新数据，修改状态
        $users = M("Wxtuser");
        $data = array('password'=>md5($password),'time'=>time(),'status'=>1);
        $return = $users->where("id=$id")->save($data);
        if($return){
            $ret = $this->format_ret(1,'激活成功！');
        }else{
            $ret = $this->format_ret(0,'激活失败！');
        }
        echo json_encode($ret);
        exit;
    }

     //发送验证码接口
       //code by xiaocool
        public function SendMobileCode(){
            //用户ID
            $userid= "100000";
            //密码
            $pwd ="111111";

            //获取手机号
            $phone = I('phone');
            //生成随机六位数
            $code = rand(100000,999999);
            //拼接短信内容
            $data ="您好！验证码是：" . $code ;
            // md5加密
            $sign =md5($userid ."|".$pwd."|" .$phone);
            //登录信息
            $post_data = array();
            $post_data['usr'] = iconv('GB2312', 'GB2312',$userid);
            $post_data['extdsrcid'] = iconv('GB2312', 'GB2312',"888888");
            $post_data['mobile'] = $phone;
            $post_data['sms']=mb_convert_encoding("$data",'GBK', 'auto');
            $post_data['sign'] = $sign;
            $url='http://60.190.233.237:6088/wmim/SMSSendYD?'; 
            $o="";
            //生成发送链接
            foreach ($post_data as $k=>$v)
            {
               $o.= "$k=".urlencode($v)."&";
            }
         //去掉最后一个&
            $post_data=substr($o,0,-1);
            $this_header = array("content-type: application/x-www-form-urlencoded; charset=gbk");
        //初始化$ch
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $result = curl_exec($ch);

            // //将验证码发送到数据库
            $noteCode = M("auth_code");
            $noteCode->add(array("mobile"=>$phone,"code"=>$code,"status"=>2,"is_show"=>1,"create_time"=>time()));
            
            // //返回短信发送状态及验证码
            $ret = $this->format_ret(1,array('code'=>$code));
            // echo $post_data;
            echo json_encode($ret);
            exit;
        }
        //获取班级对应的视频列表信息
        public function GetClassVideoList(){
            $classid=I("classid");
            $monitor_list=M("monitor")->where("classid=$classid")->find();
            if($monitor_list){
                $ret = $this->format_ret(1,$monitor_list);
            }else{
                $ret = $this->format_ret(0,'获取失败');
            }
            echo json_encode($ret);
            exit;
        }
        public function yingshiyun(){
            $post_data='appKey=e6a9eb61e34d4b64a6a1d92867914d9c&appSecret=ab272524acaef9ba39e686b33be0d36f';
            $this_header = array("Content-Type: application/x-www-form-urlencoded; charset=gbk");
            $url='https://open.ys7.com/api/lapp/token/get';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $result = curl_exec($ch);
            $arr=json_decode($result,true);
            $contents = mb_convert_encoding($arr["msg"], 'gbk', 'auto');
            echo $result;
        }
        public function lecheng(){
            $length=32;
            // 密码字符集，可任意添加你需要的字符 
            $chars = '0123456789'; 
            $password = ''; 
            for ( $i = 0; $i < $length; $i++ ) { 
                // 这里提供两种字符获取方式 
                // 第一种是使用 substr 截取$chars中的任意一位字符； 
                // 第二种是取字符数组 $chars 的任意元素 
                // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1); 
                $password .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
            } 
            $String="phone:15589611856,time:".time().",nonce:".$password.",appSecret:3451cd2dbdc54d8f8f71bc85a5bab1";
            $String = md5($String);
            var_dump($String);
            $system_team["ver"]='1.0';
            $system_team["sign"]=$String;
            $system_team["appId"]='lc6419aa19c5f74ddb';
            $system_team["time"]=time();
            $system_team["nonce"]=$password;
            $arr["system"]=$system_team;

            $params_arr["phone"]='15589611856';
            $arr["params"]=$params_arr;

            $arr["id"]=88;
            //echo json_encode($arr);
            $post_data=json_encode($arr);
            $this_header = array("Content-Type: application/x-www-form-urlencoded; charset=gbk");
            $url='https://openapi.lechange.cn:443/openapi/accessToken';
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $result = curl_exec($ch);
            $arr_else=json_decode($result,true);
            $contents = mb_convert_encoding($arr_else["msg"], 'gbk', 'auto');
            echo $contents;
        }
/*
 * 忘记密码--手机号+验证码+激活状态 验证
 * 1.验证手机验证码是否正确
 * 2.验证输入的账号是否存在于数据库中
 * 3.判断用户激活状态
*/
    public function forgetPass_Verify(){
        //获取手机号，验证码
        $mobile = I('phone');
        $code = I('code');
        if( $mobile !="" && $code !="") {
            //如果都不为空，先进行code验证
            $noteCode =	M("auth_code");
            $noteCodeinfo = $noteCode->where(array("mobile"=>$mobile,"code"=>$code,"is_show"=>1))->find();
            if($noteCodeinfo)
            {
                //短信验证码正确
                //验证成功，更改验证码状态
                $noteCode->where(array("mobile"=>$mobile,"code"=>$code))->save(array("is_show"=>2,"status"=>4));
                //进行手机号码验证
                $users = M("Wxtuser");
                $userinfo = $users->where(array("phone"=>$mobile))->find();
                if($userinfo){
                    //手机号码存在
                    //获取该手机号码状态status
                    $status = $users->where(array("phone"=>$mobile))->getField("status");
                    //判断用户激活状态
                    if($status==1){
                        //返回数据

                        $ret = $this->format_ret(1,$userinfo);
                    }else{
                        $ret = $this->format_ret(0,'未激活！');
                    }

                }else{
                    //手机号码不存在
                    $ret = $this->format_ret(0,'手机号码错误！');
                }
            }else{
                //短信验证码错误
                $ret = $this->format_ret(0,'验证码错误！');
            }
        }else{
            //若有一个为空，则返回(0,‘param lost’)
            $ret = $this->format_ret(0,'param lost');
        }
        echo json_encode($ret);
        exit;
    }
/*忘记密码——修改密码
 *获取传入的id和密码，将其存入数据库
 *
*/
    public function forgetPass_Activate(){
        $id = I('userid');
        $password = I('pass');
        //更新密码
        $users = M("Wxtuser");
        $data = array('password'=>md5($password),'time'=>time());
        $return = $users->where("id=$id")->save($data);
        if($return){
            $ret = $this->format_ret(1,'密码修改成功！');
        }else{
            $ret = $this->format_ret(0,'密码修改失败！');
        }
        echo json_encode($ret);
        exit;
    }
        public function UpdateUserAvatar(){
        $id = I('userid');
        $avatar = I('avatar');
        //更新密码
        $users = M("Wxtuser");
        $data = array('photo'=>$avatar);
        $return = $users->where("id=$id")->save($data);
        if($return){
            $ret = $this->format_ret(1,'头像修改成功！');
        }else{
            $ret = $this->format_ret(0,'头像修改失败！');
        }
        echo json_encode($ret);
        exit;
    }
    public function UpdateUserSex(){
        $id = I('userid');
        $sex = I('sex');
        //更新密码
        $users = M("Wxtuser");
        $data = array('sex'=>$sex);
        $return = $users->where("id=$id")->save($data);
        if($return){
            $ret = $this->format_ret(1,'性别修改成功！');
        }else{
            $ret = $this->format_ret(0,'性别修改失败！');
        }
        echo json_encode($ret);
        exit;
    }
        public function UpdateUserName(){
        $id = I('userid');
        $name = I('nicename');
        //更新密码
        $users = M("Wxtuser");
        $data = array('name'=>$name);
        $return = $users->where("id=$id")->save($data);
        if($return){
            $ret = $this->format_ret(1,'姓名修改成功！');
        }else{
            $ret = $this->format_ret(0,'姓名修改失败！');
        }
        echo json_encode($ret);
        exit;
    }
    //检测版本号--教师端
    public function CheckVersion(){
        $versionid=intval(I('versionid'));
        $type=I('type');
        $where['versionid']=array('GT',$versionid);
        $where['type']=$type;
        $where['status']=1;
        $version=M('version')->where($where)->order('versionid desc')->limit(1)->find();
        if($version){
           $ret = $this->format_ret(1,$version);
        }else{
           $ret = $this->format_ret(0,"o");    
        }  
        echo json_encode($ret);
        exit;  
    }
    //检测版本号--家长端
    public function CheckVersion_Parent(){
        $versionid=intval(I('versionid'));
        $type=I('type');
        $where['versionid']=array('GT',$versionid);
        $where['type']=$type;
        $where['status']=2;
        $version=M('version')->where($where)->order('versionid desc')->limit(1)->find();
        if($version){
           $ret = $this->format_ret(1,$version);
        }else{
           $ret = $this->format_ret(0,"o");    
        }  
        echo json_encode($ret);
        exit;  
    }
/*
 * 通过id获取用户资料
 */
    public function GetUsers(){
        $uid = I('userid');
        $users = M('wxtuser');
        //通过传入id获取用户资料
        $userinfo = $users->where("id = $uid")->field('id,name,phone,sex,schoolid,birthday,weixin,photo,status,last_login_time')->find();
        //判断获取是否成功
        if($userinfo){
            //如果生日已设置，则生成年龄，否则，年龄为0
            if($userinfo['birthday']){
                $userinfo['age'] = $this->CountAge($userinfo['birthday']);
            }else{
                $userinfo['age'] = 0;
            }
            $ret = $this->format_ret(1,$userinfo);
        }else{
            $ret = $this->format_ret(0,"获取资料失败！");
        }
        echo json_encode($ret);
        exit;
    }
    //根据生日与当前时间，计算年龄的函数
    function CountAge($birthday){
        $today = date('Y.m.d',time());
        //分割字符串
        $str_today = explode(".",$today);
        //去掉数组中的空格位置
        $str_today = array_filter($str_today);
        $str_birth = explode(".",$birthday);
        //去掉数组中的空格位置
        $str_birth = array_filter($str_birth);
        //先比较月份
        if($str_today[1]>$str_birth[1]){
            //如果当前月份大于生日月份，则年份直接进行相减
            $age = $str_today[0]-$str_birth[0];
        }else if($str_today[1] == $str_birth[1]){
            //如果当前月份等于生日月份，则再比较日期
            if($str_today[2] >= $str_birth[2]){
                //如果当前日期大于或等于生日日期，则年份直接进行相减
                $age = $str_today[0] - $str_birth[0];
            }else{
                //如果当前月份小于于生日月份，则结果为年份直接相减+1
                $age = $str_today[0] - $str_birth[0]+1;
            }
        }else{
            //如果当前月份小于于生日月份，则结果为年份直接相减+1
            $age = $str_today[0] - $str_birth[0]+1;
        }
        return $age;
        exit;
    }
/*
 * 获取服务状态
 * 接收学生ID，返回该学生id的服务状态
*/
    public function GetSeverStatus(){
        $stuid = I('stuid');
        $serve = M('serve_status');
        $serve_return = $serve->where("studentid = $stuid")->find();
        if($serve_return){
            $serve_return['begintime']=date("Y.m.d",$serve_return['begintime']);
            $serve_return['endtime']=date("Y.m.d",$serve_return['endtime']);
            $ret = $this->format_ret(1,$serve_return);
        }else{
            $ret = $this->format_ret(0,"调取服务信息失败！");
        }
        echo json_encode($ret);
        exit;
    }
    //在线客服

/*
 * 客服
 */
    public function service(){
        /*
         * 检测不同的学校id信息返回不同的客服电话
         *
         * */
        $uid = I('userid');
        //获取该用户所在学校id
        $users = M('wxtuser');
        $userinfo = $users->where("id = $uid")->getField('schoolid');
        $servicesql = M('service');
        $service_return = $servicesql->where("schoolid = $userinfo")->find();
        $ret = $this->format_ret(1,$service_return);
        echo json_encode($ret);
        exit;
    }
    //客服电话
    public function service_phone(){
        $schoolid = I('schoolid');
        if($schoolid){
            $service_phone=M('agent')
            ->alias("a")
            ->join("wxt_school s ON a.id=s.agent_id")
            ->where("s.schoolid=$schoolid")
            ->field("a.servicephone")
            ->find();
            if($service_phone["servicephone"]){
                $contact["phone"]=$service_phone["servicephone"];
                $ret = $this->format_ret(1,$contact);
            }else{
                $contact_data=M('agent')->field("servicephone")->where(array("id"=>1))->find();
                $contact["phone"]=$contact_data["servicephone"];
                $ret = $this->format_ret(1,$contact);
            }
        }else{
            $ret = $this->format_ret(0,"未获取到数据");
        }
        echo json_encode($ret);
        exit;
    }
    //乐园类目的url
    public function FairylandUrl(){
        $fairy_name = I("name");
        $fairyland_url=M('fairyland_url')->field("url")->where(array("fairyland_name"=>$fairy_name))->find();
        if($fairyland_url){
            $ret = $this->format_ret(1,$fairyland_url);
        }else{
            $ret = $this->format_ret(0,"数据读取失败");
        }
        echo json_encode($ret);
        exit;
    }
    //在线留言
    public function LeaveMessage(){
        $userid = I('userid');
        $message = I('message');
        $photo =I('photo');
        $data["userid"]=$userid;
        $data["message"]=$message;
        $data["photo"]=$photo;
        $data["create_time"]=time();
        if($userid){
            $message_add=M('leave_message')->add($data);
            $ret = $this->format_ret(1,"留言成功");
        }else{
            $ret = $this->format_ret(0,"未获取到数据");
        }
        echo json_encode($ret);
        exit;
    }
    //获取自己发送的在线留言
    public function GetLeaveMessageBySelf(){
        $userid = I('userid');
        $message=M('leave_message')->where("userid= '$userid'")->order("create_time DESC")->select();
        if($message){
            $ret = $this->format_ret(1,$message);
        }else{
            $ret = $this->format_ret(0,"未获取到数据");
        }
        echo json_encode($ret);
        exit;
    }
    //获取系统通知
     public function getSystemMessages(){
        $term_id=I('term_id');
        $where=array();
        $where['a.term_id'] = array('eq',$term_id);
        $join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
        $join2= "".C('DB_PREFIX').'users as c on b.post_author = c.id';
        $join3= "".C('DB_PREFIX').'terms as t on a.term_id = t.term_id';
        $term_relationships_model= M("TermRelationships");
        $field="tid as id,a.term_id,t.name as term_name,post_title,post_excerpt,post_date,post_source,post_like,post_hits,recommended,smeta";
        $lists=$term_relationships_model->alias("a")
        ->join($join)->join($join2)->join($join3)
        ->field($field)
        ->where($where)
        ->order(array("a.object_id"=>"asc"))
        ->select();
        foreach ($lists as  &$val) {
            $smeta=json_decode($val['smeta'],true);
            if(!empty($smeta['thumb'])){
                $val["thumb"]=sp_get_asset_upload_path($smeta['thumb']);
            }else{
                 $val["thumb"]="";
            }  
        }
        if($lists){
            $ret = $this->format_ret(1,$lists);
        }else{
            $ret = $this->format_ret(0,"no data");
        }
          echo json_encode($ret);
         exit;     
    }

/*
 * 根据用户id 获取用户绑定的学生关系
 *
*/
    public function GetUserRelation(){
        $uid = I('userid');
        //查询与这个id相关联的所有学生id信息
        $relation_stu = M('relation_stu_user');
        $relation_stu_return = $relation_stu->where("userid = $uid")->order('preferred DESC')->select();
        if($relation_stu_return){
            $student_model = M('wxtuser');
            $class_model =M('school_class');
            foreach ($relation_stu_return as &$student) {
                $studentid = $student["studentid"];
                $studentinfo = $student_model
                ->alias("m")
                ->join("wxt_school s ON s.schoolid=m.schoolid")
                ->field("m.name,m.photo,m.sex,s.school_name")
                ->where("id=$studentid")
                ->find();
                if($studentinfo){
                    $student["school_name"]= $studentinfo["school_name"];
                    $student["studentname"]= $studentinfo["name"];
                    $student["studentavatar"]= $studentinfo["photo"];
                    $student["sex"]= $studentinfo["sex"];
                }
                else{
                    $student["school_name"]= ""; 
                    $student["studentname"]= "未填写";
                    $student["studentavatar"]= ""; 
                    $student["sex"]= ""; 
                }
                //获取学生对应的班级列表
                 $classlist=$class_model
                 ->alias("b")
                 ->join("wxt_class_relationship br ON b.id=br.classid")
                 ->where(array("br.userid"=>$studentid))
                 ->field('b.id as classid,b.schoolid,classname')
                 ->select();
                 $student["classlist"]=$classlist;
                unset($student);
            }
            $ret = $this->format_ret(1,$relation_stu_return);
        }else{
            $ret = $this->format_ret(0,"调用数据错误");
        }
        echo json_encode($ret);
        exit;
    }
/*
 * 个人信息设置
 * */

    public function SetUser_data(){
        $uid = I('userid');
        $phone = I('phone');
        $photo = I('photo');
        $appellation = I('appellation');
        if($phone != ''){
            //手机号码不为空时    因为只传入单个参数，所以可以单独判断
            $users = M('wxtuser');
            $data = array("phone"=>$phone);
            $userinfo = $users->where("id = $uid")->save($data);
            if($userinfo){
                $ret = $this->format_ret(1,"手机号码修改成功！");
            }else{
                $ret = $this->format_ret(0,"手机号码修改失败！");
            }
        }
        if($photo != ''){
            //头像不为空时
            echo 'photo';
        }
        if($appellation != ''){
            //称谓不为空时
            $relation_user_stu = M('relation_stu_user');
            $return_relation = $relation_user_stu->where("id=$uid")->save("appellation = $appellation");
            if($return_relation){
                $ret = $this->format_ret(1,"称谓修改成功！");
            }else{
                $ret = $this->format_ret(0,"称谓修改失败！");
            }
        }
        echo json_encode($ret);
        exit;

    }


/*
 * 获取动态
 * 每个用户只有一个学校id，一个班级id
 * 将学校id和班级id作为条件   查询状态为正常的   microblog主表内容相关信息，并按时间降序排序
 * 获取每条信息userid对应的用户头像/用户名信息
 * 获取每条信息id对应的信息图片信息
 *
 * */
    public function GetMicroblog(){
        $beginid = I('beginid');
        $schoolid = I('schoolid');
        $classid = I('classid');
        $type = I('type');
        $microblig = M('microblog_main');   //博客主表
        $microblig_pic = M('microblog_picture_url');//博客图片表
        $microblig_like = M('likes');//博客点赞表
        $microblig_comment = M('comments');//博客评论表
        //判断binginid是否为0
        if($schoolid!=''&&$classid!=''){
            if($beginid==0){
                //biginid=0,第一次查询==>从第一条开始查询    最多返回7条
                $where["wxt_microblog_main.schoolid"]=$schoolid;
                $where["wxt_microblog_main.classid"]=$classid;
                $where["wxt_microblog_main.status"]=1;
                if($type!=1){
                    $where["wxt_microblog_main.type"]=$type;
                }
                $user_return = $microblig->join("wxt_wxtuser ON wxt_microblog_main.userid = wxt_wxtuser.id")
                ->order("write_time DESC")
                ->where($where)
                ->limit(7)
                ->field('mid,type,wxt_microblog_main.schoolid,wxt_microblog_main.classid,userid,name,content,write_time,photo')
                ->select();
            }else{
                //biginid!=0,不是第一次查询==>从biginid开始查询   返回五条
                $userwhere["wxt_microblog_main.schoolid"]=$schoolid;
                $userwhere["wxt_microblog_main.classid"]=$classid;
                $userwhere["wxt_microblog_main.status"]=1;
                $userwhere["wxt_microblog_main.mid"]<$beginid;
                if($type!=1){
                   $userwhere["wxt_microblog_main.type"]=$type; 
                }
                $beginid_int=settype($beginid,"integer");
                // $userwhere["wxt_microblog_main.schoolid"]=$schoolid;
                $user_return = $microblig->join("wxt_wxtuser ON wxt_microblog_main.userid = wxt_wxtuser.id")
                    ->order("write_time DESC")
                    // ->where("(wxt_microblog_main.schoolid = $schoolid) & (wxt_microblog_main.classid=$classid) & (wxt_microblog_main.status=1) & (wxt_microblog_main.mid<$beginid)")
                    ->where($userwhere)
                    ->limit($beginid+5)
                    ->field('mid,type,wxt_microblog_main.schoolid,wxt_microblog_main.classid,userid,name,content,write_time,photo')
                    ->select();

            }
            //为该条微博匹配存入的图片++++++++匹配点赞情况
            for($i=0;$i<count($user_return);$i++){
                //1.获取该微博对应图片数量，名称等信息      2.对应的点赞人id，点赞时间等信息    3.对应评论人，评论内容，评论时间等信息
                $microblogid = $user_return[$i]['mid'];//主表对应的附表中的microblogid

                $pic_return = $microblig_pic->where("microblogid = $microblogid")
                    ->order('id ASC')
                    ->field('pictureurl')
                    ->select();
                //将图片地址信息附给该条微博
                $user_return[$i]['pic']=$pic_return;

                for ($j=0; $j < count($pic_return); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic_return[$j]["pictureurl"]);
                    $user_return[$i]['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $user_return[$i]['pic'][$j]["pictureheight"]=$imagesize["1"];
                }

                

                $where_like["wxt_likes.refid"]=$microblogid;
                //$where_like["wxt_likes.type"]=$type;
                $like_return = $microblig_like->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where($where_like)
                    ->order('likeid ASC')
                    ->field('userid,name')
                    ->select();
                //将点赞人信息附给该条微博
                $user_return[$i]['like']=$like_return;
                $where_comment["wxt_comments.refid"]=$microblogid;
                //$where_comment["wxt_comments.type"]=$type;
                $comment_return = $microblig_comment
                    ->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where($where_comment)
                    ->order('wxt_comments.add_time DESC')
                    ->field('userid,name,content,wxt_wxtuser.photo as avatar,add_time as comment_time')
                    ->select();
                //将评论人信息及内容附给该条微博
                $user_return[$i]['comment']=$comment_return;
            }
            $ret = $this->format_ret(1,$user_return);
        }else{
            $ret = $this->format_ret(0,"请输入要获取的学校/班级id！");
        }
        echo json_encode($ret);
        exit;
    }
/*
 * 写博客
 * 收到前台传入的用户id，用户学校/班级信息，博客内容，图片名称字符串,shijian
 * 先存入主表，返回该条微博的id
 * 对图片名称字符串进行截取
 * 将图片链接存入数据库
 *
 * */
    public function WriteMicroblog(){
        /*
         * 2016/02/26修改写博客接口为post获取
         * */
        $type = Intval(I("type"));
        $userid = Intval(I("userid"));
        $classid = Intval(I("classid"));
        $schoolid = Intval(I("schoolid"));
        if($type){
            $data['type'] = $type;
        }else{
           $data['type'] = 0; 
        }
        if($studentid){
            $data['studentid'] = $studentid;
        }
        if($classid){
            $data['classid'] = $classid;
        }
        $data['userid'] = $userid;
        $data['schoolid'] = $schoolid;
        // $data['classid'] = $_POST['classid'];
        $data['write_time'] = time();
        /*
         * 2016/02/25修改写博客时间为后台获取
         * */
        $data['content'] = I('content');
        $data['status'] = 1;
        $picture_url = I('picurl');
        $microblog_main = M('microblog_main');
        $microblog_pic_url = M('microblog_picture_url');
        if($data['userid']!=''&&$data['schoolid']){
            //存主表
            $microblog_main_ret = $microblog_main->add($data);
            if($picture_url!=''){
                //如果有图片，则获取返回该条微博id
                $mid =  $microblog_main->where($data)->getField('mid');
                //截取图片字符串
                $picurl_array = explode(',',$picture_url);
                //去掉数组中的空格位置
                $picurl_array = array_filter($picurl_array);
                //存入字符串
                for($i=0;$i<count($picurl_array);$i++) {
                    $pic_add=$microblog_pic_url->add(array("microblogid"=>$mid,"pictureurl"=>$picurl_array[$i]));
                }
            }
            if($microblog_main_ret){
                $ret = $this->format_ret(1,"存入微博成功！");
            }else{
                $ret = $this->format_ret(0,"存入微博失败！");
            }
        }else{
            $ret = $this->format_ret(0,'param lost');
        }
        echo json_encode($ret);
        exit;
    }
    /*写博客上传图片*/
    function WriteMicroblog_upload(){
        //上传处理类
        $config=array(
        'FILE_UPLOAD_TYPE' => sp_is_sae()?"Sae":'Local',//TODO 其它存储类型暂不考虑
            'rootPath' => './uploads/',
            'savePath' => './microbloghub/',
            'maxSize' => 10240000,//10M
    			'saveName'   =>   '',
    			'exts'       =>    array('jpg', 'png', 'jpeg'),
    			'autoSub'    =>    false,
    	);

        $upload = new \Think\Upload($config);//
    	$info=$upload->upload();

        //开始上传
        if ($info) {
            //上传成功
            $pic_name['pic_name'] = $info['upfile']['savename'];
            $pic_name=$pic_name['pic_name'];
            $this->image_png_size_add("./uploads/microbloghub/$pic_name","./uploads/microblog/$pic_name");
        } else {
            $state = $upload->getError();
        }

        if(!empty($pic_name)){
            $ret = $this->format_ret(1,$pic_name);
        }else{
            $ret = $this->format_ret(0,$state);
        }
        echo json_encode($ret);
        exit;
    }
    /*上传图片*/
    function uploadPic(){
         //上传处理类
        $config=array(
        'FILE_UPLOAD_TYPE' => sp_is_sae()?"Sae":'Local',//TODO 其它存储类型暂不考虑
            'rootPath' => './uploads/',
            'savePath' => './microbloghub/',
            'maxSize' => 2048000,//2M
                'saveName'   =>   '',
                'exts'       =>    array('jpg', 'png', 'jpeg'),
                'autoSub'    =>    false,
        );

        $upload = new \Think\Upload($config);//
        $info=$upload->upload();

        //开始上传
        if ($info) {
            //上传成功
            $pic_name['pic_name'] = $info['upfile']['savename'];
            $pic_name=$pic_name['pic_name'];
            $this->image_png_size_add("./uploads/microbloghub/$pic_name","./uploads/microblog/$pic_name");
        } else {
            $state = $upload->getError();
        }

        if(!empty($pic_name)){
            $ret = $this->format_ret(1,"uploads/microbloghub/$pic_name");
        }else{
            $ret = $this->format_ret(0,$state);
        }
        echo json_encode($ret);
        exit;
    }
    /**/
    function uploadnoticepic(){
        
    }
    /**
     * desription 压缩图片
     * @param sting $imgsrc 图片路径
     * @param string $imgdst 压缩后保存路径
     */
    public function image_png_size_add($imgsrc,$imgdst){
        list($width,$height,$type)=getimagesize($imgsrc);
        $ratio = floatval($height/$width);
        $new_width = ($width>600?600:$width)*0.9;
        $new_height =$new_width*$ratio;
        switch($type){
            case 1:
                $giftype=$this->check_gifcartoon($imgsrc);
                if($giftype){
                    header('Content-Type:image/gif');
                    $image_wp=imagecreatetruecolor($new_width, $new_height);
                    $image = imagecreatefromgif($imgsrc);
                    imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    imagejpeg($image_wp, $imgdst,75);
                    imagedestroy($image_wp);
                }
                break;
            case 2:
                header('Content-Type:image/jpeg');
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefromjpeg($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($image_wp, $imgdst,75);
                imagedestroy($image_wp);
                break;
            case 3:
                header('Content-Type:image/png');
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefrompng($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($image_wp, $imgdst,75);
                imagedestroy($image_wp);
                break;
        }
    }
    /**
     * desription 判断是否gif动画
     * @param sting $image_file图片路径
     * @return boolean t 是 f 否
     */
    function check_gifcartoon($image_file){
        $fp = fopen($image_file,'rb');
        $image_head = fread($fp,1024);
        fclose($fp);
        return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/",$image_head)?false:true;
    }
/*
 * 点赞接口
 * 获取用户id，被点赞的博客id，点赞时间，传入点赞详情表，增加一条记录
 * */
    public function SetLike(){
        $data['userid'] = I('userid');
        $data['microblogid'] = I('mid');
        $data['liketime'] = time();
        /*
         * 2016/02/25修改点赞时间为后台获取
         * */
        $microblog_like = M('microblog_like');
        if($data['userid']!=''&&$data['microblogid']!=''&&$data['liketime']!=''){
            $like_return = $microblog_like->add($data);
            if($like_return){
                $ret = $this->format_ret(1,"点赞成功！");
            }else{
                $ret = $this->format_ret(0,"点赞失败！");
            }
        }else{
            $ret = $this->format_ret(0,'param lost');
        }
        echo json_encode($ret);
        exit;
    }
/*
     * 取消赞接口
     * 获取用户id，被点赞的博客id，点赞时间，传入点赞详情表，增加一条记录
     * */
    public function ResetLike(){
        $data['userid'] = I('userid');
        $data['microblogid'] = I('mid');
        $microblog_like = M('microblog_like');
        if($data['userid']!=''&&$data['microblogid']!=''){
            $like_return = $microblog_like->where($data)->delete();
            if($like_return){
                $ret = $this->format_ret(1,"取消赞成功！");
            }else{
                $ret = $this->format_ret(0,"取消赞失败！");
            }
        }else{
            $ret = $this->format_ret(0,'param lost');
        }
        echo json_encode($ret);
        exit;
    }
/*
 * 评论接口
 * 获取用户id，获取被评论的博客id，评论内容，评论时间，传入评论详情表，增加一条记录
 * */
    public function SetComment(){
        $data['userid'] = $_POST['userid'];
        $data['microblog_c_id'] = $_POST['mid'];
        $data['comment_content'] = $_POST['content'];
        /*
         * 2016/02/26修改评论接口为post获取
         * */
        $data['comment_time'] = time();
        /*
         * 2016/02/25修改评论时间为后台获取
         * */
        $data['status'] = 1;
        $microblog_comment = M('microblog_comment');
        if($data['userid']!=''&&$data['microblog_c_id']!=''&&$data['comment_time']!=''){
            $comment_ret = $microblog_comment->add($data);
            if($comment_ret){
                $ret = $this->format_ret(1,"评论成功！");
            }else{
                $ret = $this->format_ret(0,"评论失败！");
            }
        }else{
            $ret = $this->format_ret(0,'param lost');
        }
        echo json_encode($ret);
        exit;

    }
/*
 * 图片轮播
 * 返回轮播表里的三张图片地址
 * */
    public function Viwepager(){
        $pictureurl_model = M('ad_picture');
        $return_url = $pictureurl_model->order('ap_id ASC')
            ->limit(3)
            ->select();
        if($return_url){
            $ret = $this->format_ret(1,$return_url);
        }else{
            $ret = $this->format_ret(0,"获取失败");
        }
        echo json_encode($ret);
        exit;
    }
/*
 * 宝宝成长
 * 获取当前宝宝的成长状况
 * 传入宝宝id，开始位置，按时间排序，获取对应该宝宝的照片，上传人id->转名字，内容
 * 第一次获取7条，下拉增加5条
 * */
    public function BabyGrow(){
        $babyid = I('babyid');
        $beginid = I('beginid');
        $baby_grow_model = M('baby_grow');
        //判断是否为0
        if($babyid!=''){
            if($beginid==0){
                //biginid=0,第一次查询==>从第一条开始查询    最多返回7条
                $user_return = $baby_grow_model->join("wxt_wxtuser ON wxt_baby_grow.userid = wxt_wxtuser.id")
                    ->order("write_time DESC")
                    ->where("(wxt_baby_grow.babyid = $babyid)& (bg_status=1)")
                    ->limit(7)
                    ->field('grow_id,babyid,userid,cover_photo,name,title,content,write_time')
                    ->select();
            }else{
                //biginid!=0,不是第一次查询==>从biginid开始查询   返回五条
                $user_return = $baby_grow_model->join("wxt_wxtuser ON wxt_baby_grow.userid = wxt_wxtuser.id")
                    ->order("write_time DESC")
                    ->where("(wxt_baby_grow.babyid = $babyid)& (bg_status=1)& (wxt_baby_grow.grow_id<$beginid)")
                    ->limit(5)
                    ->field('grow_id,babyid,userid,cover_photo,name,title,content,write_time')
                    ->select();
            }
            foreach ($user_return as &$grow ) {
                $refid =$grow["grow_id"];
                $comment_model = M('comments');//评论表
                $like_model=M('likes');
                $like_return = $like_model->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where("wxt_likes.refid = $refid and type='7'")
                    ->order('likeid ASC')
                    ->field('userid,photo as avatar,wxt_wxtuser.name')
                    ->select();
                $comment_return = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where("wxt_comments.refid = $refid and type='7'")
                    ->order('wxt_comments.id ASC')
                    ->field('userid,wxt_wxtuser.photo as avatar,wxt_wxtuser.name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                    ->select();
                $grow['comment']=$comment_return;
                $grow['like']=$like_return;
                unset($grow);
            }
            $ret = $this->format_ret(1,$user_return);
        }else{
            $ret = $this->format_ret(0,"请输入正确的参数！");
        }
        echo json_encode($ret);
        exit;
    }
/*
 * 写入宝宝日记
 * */
    public function WriteBabyGrow(){
        //获取数据
        $data['babyid'] = $_POST['babyid'];
        $data['userid'] = $_POST['userid'];
        $data['cover_photo'] = $_POST['cover_photo'];
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        /*
         * 2016/02/26修改写入宝宝日记接口为post获取
         * */
        $data['write_time'] = time();
        /*
         * 2016/02/25修改写入宝宝日记时间为后台获取
         * */
        $data['bg_status'] = 1;

        $baby_grow_model = M('baby_grow');
        if($data['userid']!=''&&$data['babyid']!=''&&$data['write_time']!=''){
            //存入数据
            $baby_grow_ret = $baby_grow_model->add($data);
            //图片存入表中
            $pic_model=M('baby_grow_pic');
            $pic=I('pic');
            $pic_arr=explode(",",$pic);
            //去掉数组中的空格位置
            $pic_arr = array_filter($pic_arr);
            for ($i=0; $i < count($pic_arr); $i++) {
                $pic_model->add(array("baby_grow_id"=>$baby_grow_ret,"pic"=>$pic_arr[$i]));
            }
            if($baby_grow_ret){
                $ret = $this->format_ret(1,"存入成长日记成功！");
            }else{
                $ret = $this->format_ret(0,"存入成长日记失败！");
            }
        }else{
            $ret = $this->format_ret(0,'param lost');
        }
        echo json_encode($ret);
        exit;
    }
    /*写宝宝日记上传图片*/
    function WriteBabyGrow_upload(){
        //上传处理类
        $config=array(
            'FILE_UPLOAD_TYPE' => sp_is_sae()?"Sae":'Local',//TODO 其它存储类型暂不考虑
            'rootPath' => './uploads/',
            'savePath' => './microbloghub/',
            'maxSize' => 2048000,//2M
            'saveName'   =>   '',
            'exts'       =>    array('jpg', 'png', 'jpeg'),
            'autoSub'    =>    false,
        );
        $upload = new \Think\Upload($config);//
        $info=$upload->upload();
        //开始上传
        if ($info) {
            //上传成功
            $pic_name['pic_name'] = $info['upfile']['savename'];
            $pic_name=$pic_name['pic_name'];
            $this->image_png_size_add("./uploads/growCoverhub/$pic_name","./uploads/growCover/$pic_name");

        } else {
            $state = $upload->getError();
        }

        if(!empty($pic_name)){
            $ret = $this->format_ret(1,$pic_name);
        }else{
            $ret = $this->format_ret(0,$state);
        }
        echo json_encode($ret);
    }

    /*
 * 宝宝空间
 * 1.传入学生id，
 * 2.获取关系表中的家人关联状况
 * 3.获取wxtuser表中的  姓名，年龄(计算生成)，学校
 * 4.获取student_log表中的  今日 到校时间，离校时间，到校体温，离校体温，体重，身高
 *
 * 注意：获取4之前，判断一下今日的表是否已建立，如果未建立，则先建立再获取
 * */
    //由学生获取关联用户资料
    public function GetStuRelation(){
        $sid = I('stuid');
//        根据学生id获取关系表中的用户-学生关联状况
        $relation_stu = M('relation_stu_user');
        $ret_relation = $relation_stu->where("studentid = $sid")->select();
        if($ret_relation){
            $ret = $this->format_ret(1,$ret_relation);
            $student_model = M('wxtuser');
            foreach ($ret as &$student) {
                $studentid = $student["id"];
                $studentinfo = $student_model
                ->field("name,photo")
                ->where("id=$studentid")
                ->find();
                if($studentinfo){
                $student["studentname"]= $studentinfo["name"];
                $student["studentavatar"]= $studentinfo["photo"];
                
                }
                else{
                $student["studentname"]= "";
                $student["studentavatar"]= ""; 
                }
                unset($student);
            }
        }else{
            $ret = $this->format_ret(0,"获取关联错误");
        }
        echo json_encode($ret);
        exit;
    }

    /*
     * 获取今日到校情况
     * 如果数据库中不存在今日的日志记录，则输入日期（格式：年.月.日），学生id，新建该记录
     * */
    public function GetStudentLog(){
        $sid = I('stuid');
        $time=I("time");
        //获取格式化今天日期
        $today = date('Y.m.d',time());
        //将数据存入数组内，方便操作
        $data['studentid'] =  $sid;
        $data['log_date'] = $today;
        //连接日志数据库
        $log = M('student_log');
        $log_time=M('attendance');
        $log_info = $log ->field("id,log_date,studentid,stature,weight,create_time")->where($data)->select();
        foreach ($log_info as &$sign) {
            $where["userid"]=$sid;
            $where["sign_date"]=$time;
            $sign_info=$log_time->field("arrivetime,leavetime,arrivepicture,leavepicture")->where($where)->find();
            if($sign_info){
                $sign["arrivetime"]=$sign_info["arrivetime"];
                $sign["leavetime"]=$sign_info["leavetime"];
                $sign["arrivepicture"]=$sign_info["arrivepicture"];
                $sign["leavepicture"]=$sign_info["leavepicture"];
            }else{
                $sign["arrivetime"]="";
                $sign["leavetime"]="";
                $sign["arrivepicture"]="";
                $sign["leavepicture"]="";
            }
        }
        if(!$log_info){
            //如果没有这条数据，则新建一条
            //判断数据是否创建成功
            if($log->add($data)){
                $log_info2 = $log ->field("id,log_date,studentid,stature,weight,create_time")->where($data)->select();
                foreach ($log_info2 as &$sign) {
                    $where["userid"]=$sid;
                    $where["sign_date"]=$time;
                    $sign_info=$log_time->field("arrivetime,leavetime,arrivepicture,leavepicture")->where($where)->find();
                    if($sign_info){
                        $sign["arrivetime"]=$sign_info["arrivetime"];
                        $sign["leavetime"]=$sign_info["leavetime"];
                        $sign["arrivepicture"]=$sign_info["arrivepicture"];
                        $sign["leavepicture"]=$sign_info["leavepicture"];
                    }else{
                        $sign["arrivetime"]="";
                        $sign["leavetime"]="";
                        $sign["arrivepicture"]="";
                        $sign["leavepicture"]="";
                    }
                }
                //判断数据创建完，是否调用成功
                if($log_info2){
                    $ret = $this->format_ret(1,$log_info2);
                }else{
                    $ret = $this->format_ret(0,"数据创建成功，但调用失败！");
                }
            }else{
                $ret = $this->format_ret(0,"创建数据失败！");
            }
        }else{
            //如果存在这条数据，则直接调用
            $ret = $this->format_ret(1,$log_info);
        }
        echo json_encode($ret);
        exit;
    }
    /*
     * 获取用户当月校情况
     * 如果数据库中不存在今日的日志记录，则输入日期（格式：年.月.日），学生id，新建该记录
     * */
    public function GetAttendance(){
        $userid = I('userid');
        $beginday = I('begintime');
        $endday = I('endtime');
        //获取格式化今天日期
        $today = date('Y.m.d',time());
        //将数据存入数组内，方便操作
        $data['studentid'] =  $userid;
        // $data['create_time'] = array(array('gt',$beginday),array('lt',$endday));
        // $data = array(
        //         'studentid'=>$sid,
        //         'log_date'=> array("field"=>"post_date","operator"=>">"),
        // );
        //连接日志数据库
        $log = M('student_log');
        $log_info = $log->where($data)->find();
        if(!$log_info){
            //如果没有这条数据，则新建一条
            //判断数据是否创建成功
            if($log->add($data)){
                $log_info2 = $log->where($data)->find();
                //判断数据创建完，是否调用成功
                if($log_info2){
                    $ret = $this->format_ret(1,$log_info2);
                }else{
                    $ret = $this->format_ret(0,"数据创建成功，但调用失败！");
                }
            }else{
                $ret = $this->format_ret(0,"创建数据失败！");
            }
        }else{
            //如果存在这条数据，则直接调用
            $ret = $this->format_ret(1,$log_info);
        }
        echo json_encode($ret);
        exit;
    }
    /*
     * 获取体重身高变化情况====》获取最近的两次身高/体重数据
     * ！！返回最近两次的数据即可！后台不比对！！！
     * 数据库直接查询按日期排列的，不为空的两条身高数据
     * */
    public function GetChange_stature(){
        $sid = I('stuid');
        $log = M('student_log');
        $log_stature = $log->where("stature<>'' AND studentid = $sid")->order('log_date DESC')->field('log_date,stature')->select();
        // $log_weight = $log->where("weight<>'' AND studentid = $sid")->order('log_date DESC')->getField('weight',2);
        // if($log_stature&&$log_weight){
        //     $return_array['old_stature'] = $log_stature[1];
        //     $return_array['new_stature'] = $log_stature[0];
        //     $return_array['old_weight'] = $log_weight[1];
        //     $return_array['new_weight'] = $log_weight[0];
        //     $ret = $this->format_ret(1,$return_array);
        // }else{
        //     $ret = $this->format_ret(0,"获取失败！");
        // }
        $ret = $this->format_ret(1,$log_stature);
        echo json_encode($ret);
        exit;
    }
        public function GetChange_weight(){
        $sid = I('stuid');
        $log = M('student_log');
        $log_stature = $log->where("weight<>'' AND studentid = $sid")->order('log_date DESC')->field('log_date,weight')->select();
        // $log_weight = $log->where("weight<>'' AND studentid = $sid")->order('log_date DESC')->getField('weight',2);
        // if($log_stature&&$log_weight){
        //     $return_array['old_stature'] = $log_stature[1];
        //     $return_array['new_stature'] = $log_stature[0];
        //     $return_array['old_weight'] = $log_weight[1];
        //     $return_array['new_weight'] = $log_weight[0];
        //     $ret = $this->format_ret(1,$return_array);
        // }else{
        //     $ret = $this->format_ret(0,"获取失败！");
        // }
        $ret = $this->format_ret(1,$log_stature);
        echo json_encode($ret);
        exit;
    }
    //记录体重
    public function RecordWeight(){
        $stu_id = intval(I('stuid'));
        $stu_widght = intval(I('weight'));
        $log_date = date('Y.m.d',time());

        $data['studentid'] =  $stu_id;
        $data['weight'] = $stu_widght;
        //获取格式化今天日期
        $data['log_date'] = $log_date;
        //连接日志数据库
        $student_log_model = M('student_log');
        //判断是否有当天的日志数据

        $log_info = $student_log_model->where("studentid = $stu_id AND log_date = '$log_date'")->select();

        if(!$log_info){
            //如果没有今天的数据，则新建一条
            //判断数据是否创建成功
            if($student_log_model->add($data)){
                $ret = $this->format_ret(1,$data);
            }else{
                $ret = $this->format_ret(0,"创建数据失败！");
            }
        }else{
            //如果存在当天的数据，则直接添加体重数据
            $add_weight = $student_log_model->where("studentid = $stu_id AND log_date = '$log_date'")->save($data);
            if($add_weight){
                $ret = $this->format_ret(1,$data);
            }else{
                $ret = $this->format_ret(0,"创建数据失败！");
            }
        }
        echo json_encode($ret);
        exit;

    }
    //记录身高
    public function RecordHeight(){
        $stu_id = intval(I('stuid'));
        $stu_stature = intval(I('stature'));
        $log_date = date('Y.m.d',time());

        $data['studentid'] =  $stu_id;
        $data['stature'] = $stu_stature;
        //获取格式化今天日期
        $data['log_date'] = $log_date;
        //连接日志数据库
        $student_log_model = M('student_log');
        //判断是否有当天的日志数据

        $log_info = $student_log_model->where("studentid = $stu_id AND log_date = '$log_date'")->select();

        if(!$log_info){
            //如果没有今天的数据，则新建一条
            //判断数据是否创建成功
            if($student_log_model->add($data)){
                $ret = $this->format_ret(1,$data);
            }else{
                $ret = $this->format_ret(0,"创建数据失败1！");
            }
        }else{
            //如果存在当天的数据，则直接添加体重数据
            $add_height = $student_log_model->where("studentid = $stu_id AND log_date = '$log_date'")->save($data);
            //dump($add_height);
            if($add_height){
                $ret = $this->format_ret(1,$data);
            }else{
                $ret = $this->format_ret(0,"创建数据失败2！");
            }
        }
        echo json_encode($ret);
        exit;
    }
    //用户发送消息
    public function SendMessage(){
        $send_user_id = $_POST['sendid'];
        $receive_user_id = $_POST['receiveid'];
        $receive_arr=explode(",",$receive_user_id);
        //去掉数组中的空格位置
        $receive_arr = array_filter($receive_arr);
        $message_content = $_POST['content'];
        $message_time = time();
        $user_message_model = M('user_message');
        foreach ($receive_arr as $recever) {
            $receverid=$recever;
            $data = array('send_user_id'=>$send_user_id,
                    'receive_user_id'=>$receverid,
                    'message_content'=>$message_content,
                    'message_time'=>$message_time,
                    'message_type'=>1);
        $send_ret = $user_message_model->add($data);
        }
        if($send_ret){
            $ret = $this->format_ret(1,$data);
        }else{
            $ret = $this->format_ret(0,"发送失败！");
        }
        echo json_encode($ret);
        exit;
    }
    // //用户已发送的消息
    // public function SentMessage(){
    //     $send_user_id = I('userid');
    //     $user_message_model = M('user_message');
    //     $messgae_arr = $user_message_model
    //         ->join("wxt_wxtuser ON wxt_user_message.send_user_id = wxt_wxtuser.id")
    //         ->order("message_time DESC")
    //         ->where("send_user_id = $send_user_id ")
    //         ->field("name as send_user_name,send_user_id,receive_user_id,message_content,message_time")
    //         ->select();
    //     if($messgae_arr){
    //         $user_reciver_model = M('wxtuser');
    //         foreach ($messgae_arr as &$message ) {
    //             // $ret = $this->format_ret(0,"ddd");
    //             $reciver_user = $user_reciver_model;
    //             $reciverid=$message['receive_user_id'];
    //             $reciverobj=$user_reciver_model
    //             ->field("name")
    //             ->where("id=$reciverid")
    //             ->find();
    //             if($reciverobj){
    //             $message['receive_user_name']=$reciverobj['name'];

    //             }else{
    //                  $message['receive_user_name']='';
    //             }
    //             unset($message);
    //         }
    //         $ret = $this->format_ret(1,$messgae_arr);
    //     }else{
    //         $ret = $this->format_ret(0,"查询失败！");
    //     }
    //     echo json_encode($ret);
    //     exit;
    // }
    // //用户收到的消息
    // public function ReceiveidMessage(){
    //     $receive_user_id = I('userid');
    //     $user_message_model = M('user_message');
    //     $messgae_arr = $user_message_model
    //         ->alias("m")
    //         ->join("wxt_wxtuser u ON m.send_user_id = u.id")
    //         ->order("message_time DESC")
    //         ->where("m.receive_user_id = $receive_user_id ")
    //         ->field("name as send_user_name,send_user_id,receive_user_id,message_content,message_time")
    //         ->select();
    //     if($messgae_arr){
    //         $user_reciver_model = M('wxtuser');
    //         foreach ($messgae_arr as &$message ) {
    //             // $ret = $this->format_ret(0,"ddd");
    //             $reciver_user = $user_reciver_model;
    //             $reciverid=$message['receive_user_id'];
    //             $reciverobj=$user_reciver_model
    //             ->field("name")
    //             ->where("id=$reciverid")
    //             ->find();
    //             if($reciverobj){
    //             $message['receive_user_name']=$reciverobj['name'];

    //             }else{
    //                  $message['receive_user_name']='';
    //             }
    //             unset($message);
    //         }
    //         $ret = $this->format_ret(1,$messgae_arr);
    //     }else{
    //         $ret = $this->format_ret(0,"查询失败！");
    //     }
    //     echo json_encode($ret);
    //     exit;
    // }
    /*用户消息通讯录
     * 先获取对应的孩子id
     * 然后获取孩子所在的班级id
     * 获取学校/班级名称--------平级-------然后获取该班级的老师id
     * 然后获取该班级的老师信息
     * */
    public function MessageAddress(){
        $userid = I('userid');
        //查询与这个id相关联的所有学生id信息
        $relation_stu = M('relation_stu_user');
        $user_model = M('wxtuser');
        $school_class_model= M('school_class');
        $teacher_class_model = M('teacher_class');
        $school_model= M('school');
        $student_class_model = M('class_relationship');

        $relation_stu_return = $relation_stu->where("userid = $userid")->order('preferred DESC')->field('studentid')->select();
        //for语句遍历学生id
        //   获取学生所在的学校id班级id
        $relation_stu_num = count($relation_stu_return);
        for($i=0;$i<$relation_stu_num;$i++){
            $studentid = intval($relation_stu_return[$i]["studentid"]);
            $stu_school_class_transit=$student_class_model->where("userid=$studentid")->field('schoolid,classid')->select();
            $stu_school_class_transit =  $stu_school_class_transit[0];
            $stu_school_class[$i] = $stu_school_class_transit;
//             //获取学校/班级名称
            $schoolid=intval($stu_school_class_transit["schoolid"]);
            var_dump($schoolid);
            $classid=intval($stu_school_class_transit["classid"]);
            var_dump($classid);
            $school_name = $school_model->where("schoolid=$schoolid")->find();
            $class_name = $school_class_model->where("id= $classid")->find();
            $stu_school_class[$i]['schoolname']=$school_name['school_name'];
            $stu_school_class[$i]['classname']=$class_name['classname'];
//             //然后获取该班级的老师id

            $teacher_id_arr = $teacher_class_model->where("schoolid=$schoolid AND classid= $classid AND status=1")->field('teacherid')->select();
            var_dump($teacher_id_arr);
//             //然后根据id遍历该班级的老师的名称   手机号信息
            $teacher_id_num = count($teacher_id_arr);
            for($j=0;$j<$teacher_id_num;$j++){
                $teacher_id=intval($teacher_id_arr[$j]["teacherid"]);
                $teacher_transit=$user_model->where("id=$teacher_id")->field('id,name,phone,photo')->select();
                $stu_school_class[$i]['teacherinfo'][$j] = $teacher_transit[0];
//                $stu_school_class[$i]['teacher'][$j]['teachername'] = $teacher_transit[0]['name'];
//                $stu_school_class[$i]['teacher'][$j]['teachermobile'] = $teacher_transit[0]['phone'];
            }
        }
        if($teacher_id_arr){
            $ret = $this->format_ret(1,$stu_school_class);
        }else{
            $ret = $this->format_ret(0,"111");
        }
        // $ret = $this->format_ret(1,$relation_stu_return);
        echo json_encode($ret);
        exit;
    }
    //获取家长通讯录
    public function ParentContacts(){
        $userid = I('userid');
        $relation_model = M('relation_stu_user');
        $user_model = M('wxtuser');
        $student_model=M('class_relationship');
        $school_class_model= M('school_class');
        $teacher_class_model = M('teacher_class');
        if($userid){
            $classlist=$teacher_class_model
            ->alias("t")
            ->join("wxt_school_class s ON s.id=t.classid")
            ->where("t.teacherid=$userid")
            ->field("t.classid,t.teacherid,s.classname")
            ->select();
            foreach ($classlist as &$student) {
                $classid=$student["classid"];
                $student_list=$student_model
                ->alias("u")
                ->join("wxt_wxtuser w ON u.userid=w.id")
                ->where("u.classid=$classid")
                ->field("w.id,w.name,w.photo")
                ->select();
                foreach ($student_list as &$parent) {
                    $studentid=$parent["id"];
                    $where["e.studentid"]=$studentid;
                    $parent_list=$relation_model
                    ->alias("e")
                    ->join("wxt_wxtuser x on e.userid=x.id")
                    ->where($where)
                    ->field("x.id,x.name,x.photo,x.phone,e.appellation")
                    ->select();
                    $parent["parent_list"]=$parent_list;
                }
                $student["student_list"]=$student_list;
            }
            $ret = $this->format_ret(1,$classlist);
        }else{
            $ret = $this->format_ret(0,"错误");
        }
        echo json_encode($ret);
        exit; 
    }
    //本周食谱
    public function WeekRecipe(){
        $schoolid = I('schoolid');
        if(!empty($schoolid)){
            $recipe_model = M('school_recipe');
            //$recipe_data = $recipe_model->where("schoolid = $schoolid")->SELECT();
            $recipe_data = $recipe_model->where("schoolid = $schoolid AND recipe_status = 1")->field('recipe_date,recipe_pic,recipe_title,recipe_info')->order('recipe_date ASC')->SELECT();
            if($recipe_data){
                $ret = $this->format_ret(1,$recipe_data);
            }else{
                $ret = $this->format_ret(0,"查询失败！");
            }

        }else{
            $ret = $this->format_ret(0,"未获取到学校id！");
        }
        echo json_encode($ret);
        exit;
    }
    //获取考勤记录
    public function GetTeacherAttendanceList(){
        //定义数据模型
        $Attendancel_Model=M("attendance");
        //接收数据参数
        $userid=intval(I("userid"));
        $begintime=I("begintime");
        $endtime=I("endtime");
        if(!empty($userid)){
            $where["userid"]=$userid;
            $where["a.create_time"]= array(array('EGT',$begintime),array('ELT',$endtime));
            $join= "".C('DB_PREFIX').'wxtuser as u on a.userid = u.id';
            $field="a.id,a.userid,u.name,u.photo,a.schoolid,a.arrivetime,a.leavetime,a.arrivepicture,a.leavepicture,a.arrivevideo,a.leavevideo,a.create_time,a.type";
            $lists=$Attendancel_Model
            ->alias("a")
            ->join($join)
            ->field($field)
            ->order("a.create_time asc")
            ->where($where)
            ->select();
            if($lists){
                $ret = $this->format_ret(1,$lists);
            }else{
               $ret = $this->format_ret(0,"no data"); 
            }
            
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //用户签到
    public function usersign(){
        //获取客户端传过来的参数
        $userid=intval(I('userid'));
        $schoolid=intval(I('schoolid'));
        $arrivetime=intval(I('arrivetime'));
        $arrivepicture=I('arrivepicture');
        $arrivevideo=I('arrivevideo');
        $leavetime=intval(I('leavetime'));
        $leavepicture=I('leavepicture');
        $leavevideo=I('leavevideo');
        //当前系统时间,显示为年月日
        $sign_date=date("Y-m-d",time());
        $a=strtotime($sign_date);
        $data['userid']=$userid;
        $data['schoolid']=$schoolid;
        $data['arrivetime']=$arrivetime;
        $data['arrivepicture']=$arrivepicture;
        $data['arrivevideo']=$arrivevideo;
        $data['leavetime']=$leavetime;
        $data['leavepicture']=$leavepicture;
        $data['leavevideo']=$leavevideo;
        $data['type']=1;
        $data['sign_date']=strtotime($sign_date);
        $data['create_time']=time();
        $sign_model=M('attendance');
        //用数组形式完成查询语句
        $where['userid']=$userid;
        $where['sign_date']=$sign_date;
        //通过这两个条件就可以判断出签到用户有没有当天的签到记录
        $sign_info=$sign_model->where($where)->select();
        //如果没有,就将客户端传入的参数add到attendance表中
        if(!$sign_info){
            $sign_add=$sign_model->add($data);
            if($sign_add){
                $ret = $this->format_ret(1,$sign_add);
            }else{
                $ret = $this->format_ret(0,"创建数据失败1！");
            }
        }else{
            //如果有, 就将客户端传入的参数save到attendance表中
            $sign_save=$sign_model->where($where)->save($data);
             if($sign_save){
                $ret = $this->format_ret(1,$sign_save);
            }else{
                $ret = $this->format_ret(0,"创建数据失败2！");
            }
        }
        echo json_encode($ret);
        exit;
    }
    //批量签退
    public function LeaveTime(){
        $schoolid=I('schoolid');
        $userid = I('userid');
        $sign_date=I('sign_date');
        $attendance_model=M('attendance');
        $userid_arr=explode(",",$userid);
        //去掉数组中的空格位置
        $userid_arr = array_filter($userid_arr);
        //将拆分后的id用foreach和settype函数转换为单个int值
        for ($i=0; $i < count($userid_arr); $i++) {
                $data_re['leavetime']=time();
                $where["schoolid"]=$schoolid;
                $where["userid"]=$userid_arr[$i];
                $where["sign_date"]=$sign_date;
                $at_info=$attendance_model->where($where)->select();
                if($at_info){
                    $attendance_save=$attendance_model->where($where)->save($data_re);
                    if($attendance_save){
                        $ret = $this->format_ret(1,"成功");
                    }else{
                        $ret = $this->format_ret(0,"lost params");
                    }
                }else{
                    $data_add['create_time']=time();
                    $data_add['leavetime']=time();
                    $data_add["schoolid"]=$schoolid;
                    $data_add["userid"]=$userid_arr[$i];
                    $data_add["sign_date"]=$sign_date;
                    $attendance_add=$attendance_model->add($data_add);
                    if($attendance_add){
                        $ret = $this->format_ret(1,"成功");
                    }else{
                        $ret = $this->format_ret(0,"lost params");
                    }
                }
            }
        echo json_encode($ret);
        exit;
    }
    //用户补签
    public function resign(){
        $schoolid=I('schoolid');
        $userid = I('userid');
        $userid_arr=explode(",",$userid);
        //去掉数组中的空格位置
        $userid_arr = array_filter($userid_arr);
        //将拆分后的id用foreach和settype函数转换为单个int值
        foreach ($userid_arr as &$user_id) {
            $user_id_info=$user_id;
            $user_id=settype($user_id_info,"integer");
            $sign_date=date("Y-m-d",time());
            //将接收人id存入表中
            $data_re['schoolid']=$schoolid;
            $data_re['userid']=$user_id_info;
            $data_re['type']=0;
            $data_re['arrivetime']=time();
            $data_re['sign_date']=strtotime($sign_date);
            $data_re['create_time']=time();
            $receive_ret=M('attendance')->add($data_re);
        }
        if($userid_arr){
            $ret = $this->format_ret(1,"成功");
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    // //打卡签到
    // //获取学生id，今日日期，生成到校时间，判断是否存在今日状态
    // public function Sign(){
    //     $stu_id = intval(I('stuid'));
    //     $arrivetime=time();
    //     $log_date = date('Y.m.d',time());

    //     $data['studentid'] =  $stu_id;
    //     $data['arrivetime'] = $arrivetime;
    //     //获取格式化今天日期
    //     $data['log_date'] = $log_date;
    //     //连接日志数据库
    //     $student_log_model = M('student_log');
    //     //判断是否有当天的日志数据

    //     $log_info = $student_log_model->where("studentid = $stu_id AND log_date = '$log_date'")->select();

    //     if(!$log_info){
    //         //如果没有今天的数据，则新建一条
    //         //判断数据是否创建成功
    //         if($student_log_model->add($data)){
    //             $ret = $this->format_ret(1,$data);
    //         }else{
    //             $ret = $this->format_ret(0,"创建数据失败1！");
    //         }
    //     }else{
    //         //如果存在当天的数据，则直接添加体重数据
    //         $add_leavetime = $student_log_model->where("studentid = $stu_id AND log_date = '$log_date'")->save($data);
    //         //dump($add_height);
    //         if($add_leavetime){
    //             $ret = $this->format_ret(1,$data);
    //         }else{
    //             $ret = $this->format_ret(0,"创建数据失败2！");
    //         }
    //     }
    //     echo json_encode($ret);
    //     exit;
    // }
    //获取代接确认信息
    //返回最新一次的代接确认状态，如果没有，则返回没有
    public function DeliveryVerifyinfo(){
        $userid = I('userid');
        if(!empty($userid)){
            $student_delivery_model = M('student_delivery');
            $delivery_data = $student_delivery_model->where("userid = $userid")->field('delivery_status')->find();
            if($delivery_data){
                $ret = $this->format_ret(1,$delivery_data);
            }else{
                $ret = $this->format_ret(0,"未获取到代接数据！");
            }
        }else{
            $ret = $this->format_ret(0,"未获取到用户id！");
        }
        echo json_encode($ret);
        exit;
    }
    //确认代接
    public function DeliveryVerify(){
        $userid = I('userid');
        if(!empty($userid)){
            $student_delivery_model = M('student_delivery');
            $data['delivery_status']=1;
            $delivery_ret = $student_delivery_model->where("userid = $userid")->field('delivery_status')->save($data);

            if($delivery_ret){
                $ret = $this->format_ret(1,"确认成功！");
            }else{
                $ret = $this->format_ret(0,"确认失败！");
            }
        }else{
            $ret = $this->format_ret(0,"未获取到用户id！");
        }
        echo json_encode($ret);
        exit;
    }
    //获取当前宝宝对应的老师及id及手机号
    public function OnlineLeaveTeacher(){
        $schoolid = I('schoolid');
        $classid = I('classid');
        $user_model = M('wxtuser');
        $teacher_class_model = M('teacher_class');
        //获取班级对应的老师
        $teacher_id_data = $teacher_class_model->where("schoolid = $schoolid AND classid = $classid AND status=1")->field('teacherid')->select();
        foreach($teacher_id_data as $key=>$value){
            foreach($value as $k2=>$v2){
                $techer_name = $user_model->where("id = $v2")->field("name,phone")->select();
                $teacher_retarr[$key]['teacherid']=$v2;
                $teacher_retarr[$key]['teachername']=$techer_name[0]['name'];
                $teacher_retarr[$key]['teacherphone']=$techer_name[0]['phone'];
            }
        }
        if($teacher_retarr){
            $ret = $this->format_ret(1,$teacher_retarr);
        }else{
            $ret = $this->format_ret(0,"未查询到教师数据！");
        }
        echo json_encode($ret);
        exit;
    }
    //在线请假
    public function OnlineLeave(){
        $send_user_id = I('userid');
        $receive_user_id = I('teacherid');
        $message_content =I('content');
        $message_time = time();
        $user_message_model = M('user_message');    
        $data = array('send_user_id'=>$send_user_id,'receive_user_id'=>$receive_user_id,'message_content'=>$message_content,'message_time'=>$message_time,'message_type'=>2);
        $send_ret = $user_message_model->add($data);
        if($send_ret){
            $ret = $this->format_ret(1,"请假发送成功！");
        }else{
            $ret = $this->format_ret(0,"请假发送失败！");
        }
        echo json_encode($ret);
        exit;
    }
    //家长叮嘱
    public function PatriarchEnjoin(){
         $send_user_id = I('userid');
        $receive_user_id = I('teacherid');
        $message_content =I('content');
        $message_time = time();
        $user_message_model = M('user_message');
        $data = array('send_user_id'=>$send_user_id,'receive_user_id'=>$receive_user_id,'message_content'=>$message_content,'message_time'=>$message_time,'message_type'=>3);
        $send_ret = $user_message_model->add($data);
        if($send_ret){
            $ret = $this->format_ret(1,"叮嘱发送成功！");
        }else{
            $ret = $this->format_ret(0,"叮嘱发送失败！");
        }
        echo json_encode($ret);
        exit;
    }
    //获取老师点评
    public function TeacherComment(){
        $stu_id = intval(I('stuid'));
        if(!empty($stu_id)){
            $teacher_comment_model = M('teacher_comment');
            $comment_data = $teacher_comment_model->where("studentid = $stu_id AND comment_status = 1")
                ->join("wxt_wxtuser ON wxt_wxtuser.id = wxt_teacher_comment.teacher_id")
                ->field("teacher_id,name,comment_content,comment_time")
                ->order("comment_time DESC")->select();
            if($comment_data){
                $ret = $this->format_ret(1,$comment_data);
            }else{
                $ret = $this->format_ret(0,"获取失败！");
            }
        }else{
            $ret = $this->format_ret(0,"未获取到用户id！");
        }
        echo json_encode($ret);
        exit;
    }
    //获取校园公告
    public function SchoolNotice(){
        $school_id = intval(I('schoolid'));
        if(!empty($school_id)){
            $school_notice_model = M('school_notice');
            $notice_data = $school_notice_model->where("wxt_school_notice.schoolid = $school_id AND notice_status = 1")
                ->join("wxt_wxtuser ON wxt_wxtuser.id = wxt_school_notice.user_id")
                ->field("notice_title,notice_content,photo,name as releasename,notice_time")
                ->order("notice_time DESC")
                ->select();
            if($notice_data){
                $ret = $this->format_ret(1,$notice_data);
            }else{
                $ret = $this->format_ret(0,"获取失败！");
            }
        }else{
            $ret = $this->format_ret(0,"未获取到用户的学校id！");
        }
        echo json_encode($ret);
        exit;
    }
    //发布班级课件
    public function AddSchoolCourseware(){
        $schoolid = intval(I('schoolid'));
        $user_id = intval(I('user_id'));
        $class_id = I('classid');
        $subjectid = intval(I('subjectid'));
        $courseware_title = I('courseware_title');
        $courseware_content = I('courseware_content');
        if($schoolid &&(!empty($user_id)) && (!empty($class_id))){
            $courseware_model = M('school_courseware');
            $class_id_arr=explode(",",$class_id);
            //去掉数组中的空格位置
            $class_id_arr = array_filter($class_id_arr);
            foreach ($class_id_arr as &$classid) {
                $class_id_info=$classid;
                $cla_id=settype($class_id_info,"integer");
                $dataarray = array(
                'schoolid'=>$schoolid,
                'classid'=>$class_id_info,
                'user_id'=>$user_id,
                'subjectid'=>$subjectid,
                'courseware_title'=>$courseware_title,
                'courseware_content'=>$courseware_content,
                'courseware_time'=>time()
                );
                $courseware_add=$courseware_model->add($dataarray);
                //图片存入表中
                $pic_model=M('school_courseware_pic');
                $pic=I('picture_url');
                $pic_arr=explode(",",$pic);
                //去掉数组中的空格位置
                $pic_arr = array_filter($pic_arr);
                for ($i=0; $i < count($pic_arr); $i++) {
                    $pic_add=$pic_model->add(array("courseware_id"=>$courseware_add,"picture_url"=>$pic_arr[$i]));
                }
            }
            $ret = $this->format_ret(1,"发布成功");
        }else{
            $ret = $this->format_ret(0,"未获取到数据");
        }
        echo json_encode($ret);
        exit;
    }
    //获取课件列表
    public function SchoolCourseware(){
        $schoolid = intval(I('schoolid'));
        $classid = intval(I('classid'));
        $subject_model=M('subject');
        $subject=$subject_model->alias("s")->join("wxt_default_subject d ON d.id=s.subjectid")->field("d.id,d.subject")->where("s.schoolid=$schoolid")->select();
        foreach ($subject as &$courseware) {
            $subject_id=$courseware["id"];
            $where["classid"]=$classid;
            $where["subjectid"]=$subject_id;
            $courseware_info=M('school_courseware')->where($where)->select();
            foreach ($courseware_info as &$pic_info) {
                $picid=$pic_info["courseware_id"];
                $userid=$pic_info["user_id"];
                $teacher_info=M('wxtuser')->field("name,photo")->where("id=$userid")->find();
                $pic_info["teacher_name"]=$teacher_info["name"];
                $pic_info["teacher_photo"]=$teacher_info["photo"];
                $teacher_duty=M('duty')
                ->alias("d")
                ->join("wxt_duty_teacher t ON d.id=t.duty_id")
                ->where("t.teacher_id=$userid")
                ->field("d.name")
                ->find();
                $pic_info["teacher_duty"]=$teacher_duty["name"];
                $pic=M('school_courseware_pic')->field("picture_url")->where("courseware_id=$picid")->select();
                $pic_info["pic"]=$pic;
                for ($j=0; $j < count($pic); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                    $pic_info['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $pic_info['pic'][$j]["pictureheight"]=$imagesize["1"];
                }
                unset($pic_info);
            }
            $courseware["courseware_info"]=$courseware_info;
            unset($courseware);
        }
        if($subject){
            $ret = $this->format_ret(1,$subject);
        }else{
            $ret = $this->format_ret(0,"获取数据失败");
        }
        echo json_encode($ret);
        exit;
    }
    
    //获取班级活动
    public function ClassActivity(){
        $school_id = intval(I('schoolid'));
        $class_id = intval(I('classid'));
        if(!empty($school_id)&&!empty($class_id)){
            $school_class_activity = M('class_activity');
            $activity_data = $school_class_activity->where("class_activity.activity_schoolid = $school_id AND class_activity.activity_classid = $class_id AND activity_status = 1")
                ->join("wxt_wxtuser ON wxt_wxtuser.id = class_activity.activity_release")
                ->field("activity_title,activity_content,name as releasename,activity_pic,activity_time")
                ->order("activity_time DESC")
                ->select();
            if($activity_data){
                $ret = $this->format_ret(1,$activity_data);
            }else{
                $ret = $this->format_ret(0,"获取失败！");
            }
        }else{
            $ret = $this->format_ret(0,"未获取到用户的学校id或者班级id！");
        }
        echo json_encode($ret);
        exit;
    }
    //获取快乐学堂
    public function HappySchool(){
        $school_id = intval(I('schoolid'));
        if(!empty($school_id)){
            $school_happy_model = M('school_happy');
            $where["wxt_school_happy.happy_schoolid"]=$school_id;
            $where["happy_status"]=1;
            $happy_data = $school_happy_model
                ->join("wxt_wxtuser ON wxt_wxtuser.id = wxt_school_happy.happy_userid")
                ->field("happy_title,happy_content,happy_pic,name as releasename,happy_time")
                ->where($where)
                ->order("happy_time DESC")
                ->select();
            if($happy_data){
                $ret = $this->format_ret(1,$happy_data);
            }else{
                $ret = $this->format_ret(0,"获取失败！");
            }
        }else{
            $ret = $this->format_ret(0,"未获取到用户的学校id！");
        }
        echo json_encode($ret);
        exit;
    }
    //获取育儿知识
    public function ParentingKnowledge(){
        $school_id = intval(I('schoolid'));
        if(!empty($school_id)){
            $school_happy_model = M('school_happy');
            $happy_data = $school_happy_model->where("wxt_school_happy.happy_schoolid = $school_id AND happy_status = 2")
                ->join("wxt_wxtuser ON wxt_wxtuser.id = wxt_school_happy.happy_userid")
                ->field("happy_title,happy_content,happy_pic,name as releasename,happy_time")
                ->order("happy_time DESC")
                ->select();
            if($happy_data){
                $ret = $this->format_ret(1,$happy_data);
            }else{
                $ret = $this->format_ret(0,"获取失败！");
            }
        }else{
            $ret = $this->format_ret(0,"未获取到用户的学校id！");
        }
        echo json_encode($ret);
        exit;
    }
    //生成宝宝二维码
    public function StuCode(){
        $stuid=$_GET['stuid'];
        if(!empty($stuid)){
            vendor("phpqrcode.phpqrcode");
            $url=U("GetUsers",array('userid'=>$stuid),false,true);
            // 纠错级别：L、M、Q、H
            $level = 'L';
            // 点的大小：1到10,用于手机端4就可以了
            $size = 4;
            // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
            $path = "data/QRcode/";
            // 生成的文件名
            $codename = $stuid.'QRcode.png';
            $fileName = $path.$codename;
            $object = new \QRcode();
//        dump($object);
            $object->png($url, $fileName, $level, $size, 2,true);
            $ret = $this->format_ret(1,array('codename'=>$codename));
        }else{
            $ret = $this->format_ret(0,"未获取到学生id！");
        }
        echo json_encode($ret);
        exit;
    }
    //获取学校情况
    public function getschoolinfo(){
        $schoolid = intval(I('schoolid'));
        if($schoolid)
        {
            $School = M('school');
            $info = $School
            ->where("schoolid = $schoolid")
            ->field("school_name,school_address,school_user,school_phone")
            ->find();

        $ret = $this->format_ret(1,$info);
        }
        else
        {
        $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;       
    }
    //更改头像
    public function ChangeHead(){

    }

    //参数获取(状态，原因)
    function format_ret ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }

	
	
	
    public function GetMicroblogById()
    {
        $beginid = I('beginid');

        $schoolid = I('schoolid');
        //学校的ID
        $classid = I('classid');
        //班级的ID
        $type = I('type');
        //空间动态
        $uisd = I("userid");
        //用户的ID
        $mids = I("mids");
        //该信息的ID
        $microblig = M('microblog_main');   //博客主表
        $microblig_pic = M('microblog_picture_url');//博客图片表
        $microblig_like = M('likes');//博客点赞表
        $microblig_comment = M('comments');//博客评论表
        if ($school != "" || $classid != "" || $uisd!="" || $mids != ""){


        $where["wxt_microblog_main.schoolid"] = $schoolid;
        $where["wxt_microblog_main.userid "] = $uisd;
        $where["wxt_microblog_main.classid"] = $classid;
        $where["wxt_microblog_main.mid"] = $mids;
        $where["wxt_microblog_main.status"] = 1;
        if ($type != 1) {
            $where["wxt_microblog_main.type"] = $type;
        }
        $user_return = $microblig->join("wxt_wxtuser ON wxt_microblog_main.userid = wxt_wxtuser.id")
            ->where($where)
            ->field('mid,type,wxt_microblog_main.schoolid,wxt_microblog_main.classid,userid,name,content,write_time,photo')
            ->select();


        //为该条微博匹配存入的图片++++++++匹配点赞情况
        for ($i = 0; $i < count($user_return); $i++) {
            //1.获取该微博对应图片数量，名称等信息      2.对应的点赞人id，点赞时间等信息    3.对应评论人，评论内容，评论时间等信息
            $microblogid = $user_return[$i]['mid'];//主表对应的附表中的microblogid

            $pic_return = $microblig_pic->where("microblogid = $microblogid")
                ->order('id ASC')
                ->field('pictureurl')
                ->select();
            //将图片地址信息附给该条微博
            $user_return[$i]['pic'] = $pic_return;

            $where_like["wxt_likes.refid"] = $microblogid;
            //$where_like["wxt_likes.type"]=$type;
            $like_return = $microblig_like->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                ->where($where_like)
                ->order('likeid ASC')
                ->field('userid,name')
                ->select();
            //将点赞人信息附给该条微博
            $user_return[$i]['like'] = $like_return;

            $where_comment["wxt_comments.refid"] = $microblogid;
            //$where_comment["wxt_comments.type"]=$type;
            $comment_return = $microblig_comment
                ->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                ->where($where_comment)
                ->order('wxt_comments.add_time DESC')
                ->field('userid,name,content,wxt_wxtuser.photo as avatar,add_time as comment_time')
                ->select();
            //将评论人信息及内容附给该条微博
            $user_return[$i]['comment'] = $comment_return;
        }
        $ret = $this->format_ret(1, $user_return);
    }else{
        $ret = $this->format_ret(0, "系统错误请稍后再试！");
    }
           
            echo json_encode($ret);
        exit;    
            
 }


   //获取课件详情列表
    public function SchoolCoursewarelere(){
        $schoolid = intval(I('schoolid'));
        $classid = intval(I('classid'));
        $id=I('subjectid');
        $subject_model=M('subject');
        $subject=$subject_model->alias("s")->join("wxt_default_subject d ON d.id=s.subjectid")->field("d.id,d.subject")->where("s.schoolid=$schoolid and s.subjectid=$id")->select();
        foreach ($subject as &$courseware) {
            $subject_id=$courseware["id"];
            $where["classid"]=$classid;
            $where["subjectid"]=$subject_id;
            $courseware_info=M('school_courseware')->where($where)->select();
            foreach ($courseware_info as &$pic_info) {
                $picid=$pic_info["courseware_id"];
                $userid=$pic_info["user_id"];
                $teacher_info=M('wxtuser')->field("name,photo")->where("id=$userid")->find();
                $pic_info["teacher_name"]=$teacher_info["name"];
                $pic_info["teacher_photo"]=$teacher_info["photo"];
                $teacher_duty=M('duty')
                ->alias("d")
                ->join("wxt_duty_teacher t ON d.id=t.duty_id")
                ->where("t.teacher_id=$userid")
                ->field("d.name")
                ->find();
                $pic_info["teacher_duty"]=$teacher_duty["name"];
                $pic=M('school_courseware_pic')->field("picture_url")->where("courseware_id=$picid")->select();
                $pic_info["pic"]=$pic;
                for ($j=0; $j < count($pic); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                    $pic_info['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $pic_info['pic'][$j]["pictureheight"]=$imagesize["1"];
                }
                unset($pic_info);
            }
            $courseware["courseware_info"]=$courseware_info;
            unset($courseware);
        }
        if($subject){
            $ret = $this->format_ret(1,$subject);
        }else{
            $ret = $this->format_ret(0,"获取数据失败");
        }
        echo json_encode($ret);
        exit;
    }


    //班级相册上传
// 参数 images64=照片.base64+"787311295",
//相册的消息microblogid
//接口  ：姜品丞
    public function PictureProcessing()
    {
        $images64 = I('images64');
        $microblogid = 70;

        if ($images64 && $microblogid) {
            $ImagePath = $this->uploadBase64Image($images64);
            //接收处理的照片
            $ImgUrl = explode('787311295', $ImagePath);
            //将接收的照片切割成数组向数据库插入
            $ImgData = array();
            $Imaglenght = count($ImgUrl);
            for ($i = 0; $i < $Imaglenght - 1; $i++) {

                $ImgDatazifu = $ImgUrl[$i];

                if ($ImgDatazifu != "") {
                    $ImgData['microblogid'] = $microblogid;
                    $ImgData['pictureurl'] = $ImgUrl[$i];

                    $Return = M('microblog_picture_url')->add($ImgData);

                }
            }
            if ($Return) {
                echo json_encode(array('code' => 1, 'message' => "请求成功"));
                exit;
            } else {
                echo json_encode(array('code' => -10005, 'message' => '系统错误,请稍后重试,O(∩_∩)O谢谢'));
                exit;
            }
        }
    }

    //处理照片 并返还路径
    private function uploadBase64Image($content = "")
    {
        // 判断是否有多张图片
        if (strpos($content, "787311295") > 0) {
            // 去取多张图片
            $subContent = explode('787311295', $content);

            $imgCount = count($subContent) - 1;
        } else {
            // 只有一张
            $subContent = $content;
            $imgCount = count($subContent);
        }

        $lastResult = ""; // 存储返回的结果
        for ($i = 0; $i < $imgCount; $i++) {
            $base64Img = $subContent [$i]; // 需要使用base64上传的图片
            if ($base64Img != null) {
                // 上传图片
                $imgSrc = $this->base64_upload_image($base64Img); // 上传图片,返回图片的地址
                //获取 地址;
                $str = str_replace(array("./uploads/microbloghub//"), "", $imgSrc);

                // SUCCESS
                $imagePath = $str . '787311295'; // 组合新小图每张图片后都加分隔符
                $lastResult = $lastResult . $imagePath;

            } else {
                echo json_encode(array('code' => -10002, 'message' => '系统错误'));
            }
        }

        return $lastResult;
    }

    //存储图片并返还路径

    private function base64_upload_image($base64, $savepath = "./uploads/microbloghub/")
    {

        // post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行
        $base64_image = str_replace(' ', '+', $base64);
        // $base64_image = $base64;

        // 读取图片文件，转换成base64编码格式
        // $base64_image = "data:image/png;base64," . $base64_image;
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)) {
            // 匹配成功
            $time_name = date('YmdHis', time()) . rand(100, 999);
            if ($result [2] == 'jpeg') {
                $image_name = $time_name . '.jpg';
                // 纯粹是看jpeg不爽才替换的
            } else {
                $image_name = $time_name . '.' . $result [2];
            }
            $image_file = $savepath . "/{$image_name}";
            while (file_exists($image_file))
                ;
            // 服务器文件存储路径
            if (file_put_contents($image_file, base64_decode(str_replace($result [1], '', $base64_image)))) {

                return $image_file;
            } else {
                return false;
            }
        } else {
            $base64_image = "data:image/png;base64," . $base64;
            return $this->base64_upload_image($base64_image);
            // return false;
        }
    }


    function download()
    {
        $jssdk = new JSSDK("wx7325155f62456567", "c04db6c0a09e1e068879fabf2d000d74");
        $serverId = I("serverId");
        $access_token = $jssdk->getAccessToken();

        //根据微信JS接口上传了图片,会返回上面写的images.serverId（即media_id），填在下面即可
        $str = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=" . $access_token . "&media_id=" . $serverId . "";

        //获取微信“获取临时素材”接口返回来的内容（即刚上传的图片）
        $a = file_get_contents($str);
        //定义文件所在的目录
        //文件命名
        $name = rand(1000, 9999);
        //以读写方式打开一个文件，若没有，则自动创建
        $date = date('Y-m-d H:i:s', time());
        $date = str_replace("-", "", $date);
        $date = str_replace(":", "", $date);
        $date = str_replace(" ", "", $date);
        $array['date'] = $date;
        $array['name'] = $name;
        $jpg = implode($array);
        //echo $load;
        $savepath = "./uploads/microblog/";
        $resource = fopen($savepath . $jpg . ".jpg", 'w+');
        //将图片内容写入上述新建的文件
        fwrite($resource, $a);
        //关闭资源
        fclose($resource);
        echo json_encode($jpg);
    }//download  end

}

class JSSDK {
    private $appId;
    private $appSecret;

    //自动运行的函数
    public function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]";

        $timestamp = time();

        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file("jsapi_ticket.php"));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$accessToken;
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $this->set_php_file("jsapi_ticket.php", json_encode($data));
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file("access_token.php"));
        if ($data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appId."&secret=".$this->appSecret;
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $this->set_php_file("access_token.php", json_encode($data));
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    //定义一个https发送方法
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    private function get_php_file($filename) {
        return trim(substr(file_get_contents($filename), 15));
    }
    private function set_php_file($filename, $content) {
        $fp = fopen($filename, "w+");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }
}

