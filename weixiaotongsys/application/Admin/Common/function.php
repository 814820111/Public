<?php

function sp_get_url_route(){
	$apps=sp_scan_dir(SPAPP."*",GLOB_ONLYDIR);
	$host=(is_ssl() ? 'https' : 'http')."://".$_SERVER['HTTP_HOST'];
	$routes=array();
	foreach ($apps as $a){
	
		if(is_dir(SPAPP.$a)){
			if(!(strpos($a, ".") === 0)){
				$navfile=SPAPP.$a."/nav.php";
				$app=$a;
				if(file_exists($navfile)){
					$navgeturls=include $navfile;
					foreach ($navgeturls as $url){
						//echo U("$app/$url");
						$nav= file_get_contents($host.U("$app/$url"));
						$nav=json_decode($nav,true);
						if(!empty($nav) && isset($nav['urlrule'])){
							if(!is_array($nav['urlrule']['param'])){
								$params=$nav['urlrule']['param'];
								$params=explode(",", $params);
							}
							sort($params);
							$param="";
							foreach($params as $p){
								$param.=":$p/";
							}
							
							$routes[strtolower($nav['urlrule']['action'])."/".$param]=$nav['urlrule']['action'];
						}
					}
				}
					
			}
		}
	}
	
	return $routes;
}
//传入学校id，获取学校名称
function get_schoolname($schoolid){
	return M('school')->where("schoolid = $schoolid")->getField('school_name');
}
//传入职位id，获取职位名称
function get_dutyname($duty_id){
	return M('duty')->where("id = $duty_id")->getField('name');
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


function admin_role()
{

	$user_id = $_SESSION['ADMIN_ID'];

	$role = M("role_user")->where("user_id = $user_id")->getField("role_id");

	return $role;
}


function role_admin()
{
   $user_id = $_SESSION['ADMIN_ID'];

   $role = M('role_user')->alias("ru")->where("ru.user_id = $user_id")->join("wxt_role r ON r.id=ru.role_id")->field('role_id,r.name,r.pid,r.Province,r.city,r.isonelevelrole')->find();
//   dump($role);

        if($role['role_id']==1 || empty($role))
      {
      
         $Province = M('city')->where(array("parent"=>0))->select();
 
      }else{
           
        //省份
            $Province = M('city')->where(array("term_id"=>$role['province']))->select();

      }
      //暂时先这样写
      if(!$Province && !$role['province'])
      {
          $Province =  M("city")->where(array("parent"=>0))->select();
      }
      
      return $Province;

}

//获取是否为一级账户
function access_level($role)
{

    if($role)
    {

        $isonelevelrole = M("role")->where("id = $role")->getField("isonelevelrole");
    }

    return $isonelevelrole;
}

function gain_category($role)
{
    if($role)
    {
        $categoryid = M("role")->where("id = $role")->getField("categoryid");
    }
    return $categoryid;
}

 //显示该角色的所有学校
function show_school()
{
   // $user_id = $_SESSION['ADMIN_ID'];

   // $role = M('role_user')->alias("ru")->where("ru.user_id = $user_id")->join("wxt_role r ON r.id=ru.role_id")->field('role_id,r.name,r.pid,r.Province,r.city')->find();

   //      if($role['role_id']==1 || empty($role))
   //    {
      
   //       $Province = M('city')->where(array("parent"=>0))->select();
 
   //    }else{
           
   //      //省份
   //      $Province = M('city')->where(array("term_id"=>$role['province']))->select();
    

   //    }
      
   //    return $Province;

}



function getimg($arr)
{

    $img=explode("/", $arr);
         
     $imgs = $img[count($img)-1];

     return $imgs;


}

//查询单个权限
function single_role($type,$str)
{ 

  $roleid =admin_role();
  $access = M("auth_access")->where(array("type"=>$type,"role_id"=>$roleid))->select();
  foreach ($access as $key => $value) {
	       	if(strtolower($value['rule_name'])==$str)
	       	{
	       		return '1';
	       	}
	      }


}

//新的卡号是否已经被使用
function get_showcard($card,$schoolid)
{
    $showcard = M("student_card")->where(array("cardNo"=>$card,"schoolid"=>$schoolid,"handletype"=>1))->find();

    if($showcard)
    {
        $istrue = true;
    }else{
        $istrue = false;
    }
    return $istrue;
}
/*新的卡号是否已经被使用
* 根据卡号、学校、卡类型（学生还是老师）判断是否已经被使用
 *
 */
function get_showcardbak($card,$cardType,$schoolid)
{
    $showcard = M("student_card")->where(array("cardNo"=>$card,"cardType"=>$cardType,"schoolid"=>$schoolid,"handletype"=>1))->find();

    if($showcard)
    {
        $istrue = true;
    }else{
        $istrue = false;
    }
    return $istrue;
}
//更新student_card
//function update_card($type,$userid,$schoolid)
//{
//    if(!$userid)
//    {
//        return false;
//    }
//
//    //判断是什么类型的卡号
//    switch ($type) {
//        case '0':
//            $stu_main = M("student_info")->alias("s")->where("s.userid = $userid and s.schoollid = $schoolid")->join("wxt_school_class class ON s.classid=class.id")->field("s.photo,s.stu_name,class.classname,s.classid")->find();
//            $add_card["classId"] = $stu_main["classid"];
//            $add_card["name"] = $stu_main["stu_name"];
//            $add_card["className"] = $stu_main["classname"];
//            $imgurl = $stu_main["photo"];
//            $arr = explode("/",$imgurl);
//
//            $photo=$arr[count($arr)-1];
//            if(!$photo)
//            {
//                $photo = "weixiaotong.png";
//            }
//            $add_card["imgUrl"] = "http://ow3hm6y11.bkt.clouddn.com/".$photo;
//
//            break;
//        case '1':
//            $teacher_main = M("teacher_info")->where("id = $userid and schoolid = $schoolid")->field("name")->find();
//            $add_card["name"] = $teacher_main['name'];
//            break;
//        case '2':
//            break;
//
//    }
//  //  $save_one["handletime"] = date("Y-m-d H:i:s",time());
//    //$save_one["handletimeint"] = time();
//   // $save_one["handletype"] = 0;
//
//    $add_card["schoolid"] = $schoolid;
//    $add_card["personId"] = $userid;
//    $add_card["cardType"] = $type;
//    $add_card["handletype"] = 1;
//
//
//    //查询出该卡号信息
//    $show_card = M("student_card")->where(array("personId"=>$userid,"schoolid"=>$schoolid,"cardType"=>$type,"handletype"=>1))->find();
//
//
//    //将原有的卡号修改为删除
////    $save_card = M("student_card")->where(array("personId"=>$userid,"schoolid"=>$schoolid,"cardType"=>$type,"handletype"=>1))->save($save_one);
//
//    $add_card["handletime"] = date("Y-m-d H:i:s",time());
//    $add_card["handletimeint"] = time();
//    $add_card["handletype"] = 1;
////    $save_card = M("student_card")->where($where)->save($up_card);
//    //if($save_card && $show_card)
//    //{
//   //     $add_card['cardNo'] = $show_card['cardno'];
//     //   $add_card['create_time'] = time();
//     //   $add_student_card= M("student_card")->add($add_card);
//        //新增
//     //   if($add_student_card){
//    //     M("student_card")->where(array("id"=>$show_card['id']))->delete();
//   //    }
//  //  }
//    $add_card['cardNo'] = $show_card['cardno'];
//    $add_card['create_time'] = time();
//    $save_card = M("student_card")->where(array("personId"=>$userid,"schoolid"=>$schoolid,"cardType"=>$type,"handletype"=>1))->save($add_card);
//
//
//
//}

//更新student_card
function update_card($type,$userid,$schoolid)
{

    //判断是什么类型的卡号
    switch ($type) {
        case '0':
            $stu_main = M("student_info")->alias("s")->where("s.userid = $userid and s.schoollid = $schoolid")->join("wxt_school_class class ON s.classid=class.id")->field("s.photo,s.stu_name,class.classname,s.classid")->find();

            $add_card["classId"] = $stu_main["classid"];

            $add_card["name"] = $stu_main["stu_name"];
            $add_card["className"] = $stu_main["classname"];
            $imgurl = $stu_main["photo"];
            $arr = explode("/",$imgurl);

            $photo=$arr[count($arr)-1];
            if(!$photo)
            {
                $photo = "weixiaotong.png";
            }
            $add_card["imgUrl"] = "http://ow3hm6y11.bkt.clouddn.com/".$photo;

            break;
        case '1':
            $teacher_main = M("teacher_info")->where("id = $userid and schoolid = $schoolid")->field("name")->find();
            $add_card["name"] = $teacher_main['name'];
            break;
        case '2':
            break;

    }
    $save_one["handletime"] = date("Y-m-d H:i:s",time());
    $save_one["handletimeint"] = time();
    $save_one["handletype"] = 0;

    $add_card["schoolid"] = $schoolid;
    $add_card["personId"] = $userid;
    $add_card["cardType"] = $type;
    $add_card["handletype"] = 1;

    //查询出该卡号信息
    $show_card = M("student_card")->where(array("personId"=>$userid,"schoolid"=>$schoolid,"cardType"=>$type,"handletype"=>1))->find();


    //将原有的卡号修改为删除
    $save_card = M("student_card")->where(array("personId"=>$userid,"schoolid"=>$schoolid,"cardType"=>$type,"handletype"=>1))->save($save_one);

    $add_card["handletime"] = date("Y-m-d H:i:s",time());
    $add_card["handletimeint"] = time();
    $add_card["handletype"] = 1;
//    $save_card = M("student_card")->where($where)->save($up_card);
    if($save_card && $show_card)
    {

        $add_card['cardNo'] = $show_card['cardno'];
        $add_card['create_time'] = time();

        $add_student_card= M("student_card")->add($add_card);

    }
}


function is_parent($userid)
{
    if($userid)
    {
        $is_parent = M("relation_stu_user")->where(array("userid"=>$userid))->find();
        if($is_parent)
        {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function is_teacher($userid)
{
    if($userid)
    {
        $is_teacher = M("teacher_info")->where(array("teacherid"=>$userid))->find();
        if($is_teacher)
        {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}



//写入缓存数据  $only_code 标识
function  write_condition($province,$citys,$message_type,$schoolid,$only_code)
{
    //清空数据
    S($only_code,null);
    $cache_data['province'] = $province;
    $cache_data['citys'] = $citys;
    $cache_data['message_type'] = $message_type;
    $cache_data['schoolid'] = $schoolid;
    //存入数据
    S($only_code,$cache_data,3600);
}


//获取查询条件缓存
function get_condition_cache($only_code)
{
    $cache_data = S($only_code);

    if($cache_data)
    {
        array("province"=>$cache_data['province'],"citys"=>$cache_data['citys'],"message_type"=>$cache_data['message_type'],"schoolid"=>$cache_data['schoolid']);
        $arr['province'] = $cache_data['province'];
        $arr['citys'] = $cache_data['citys'];
        $arr['message_type'] = $cache_data['message_type'];
        $arr['schoolid'] = $cache_data['schoolid'];

        return $arr;


    }
}


    //查询学生数据是否有已存在
    function get_student($schoolid,$name,$phone)
    {

        $where['stu_name'] = $name;
        $where['schoollid'] = $schoolid;

        $student = M("student_info")->where($where)->field("userid")->select();
        if($student)
        {
            foreach ($student as $value) {
                $userid = $value['userid'];
                $parent_phone = M("relation_stu_user")->where("studentid = $userid and type = 1")->getField('phone');

                if ($parent_phone == $phone) {
                    return array("status" => false, "error" => "该学生已经存在,请勿重复添加");
                }
            }
            return array("status" => true);

        }else{
            return array("status" => true);

        }


    }
    //获取学校所有科目
    function get_subject($schoolid)
    {
        $where['schoolid'] = $schoolid;

        $where['schoolid'] = 0;

        $school = M('school')->where("schoolid=$schoolid")->find();

        $gradetype = $school['schoolgradetypeid'];
        $where['gradetype'] =$gradetype;

        $data['gradetype'] = 0;
        $data['schoolid'] = $schoolid;
        $data['isdefault'] = 1;

        $where_c['gradetype'] = 0;
        $where_c['schoolid'] = 0;
        $where_c['isdefault'] = 0;

        $where_subject=array($where_c,$data,$where,'_logic'=>'or');

        $subject  = M("default_subject")->where($where_subject)->select();

        return $subject;

    }

/**
 * @param $type 1为老师2为学生
 * @param $phone 修改的手机号
 * @param $userid
 */
    function edit_phone($type,$phone,$userid,$schoolid)
    {

        //为老师
        if($type==1)
        {



        }else{
           $res =  M("relation_stu_user")->where(array("studentid"=>$userid))->find();

           if($res['phone']==13000000000)
           {
                //新增一个号码
               $addData['schoolid'] = $schoolid;
               $addData['name'] = $res['name'];
               $addData['password'] = md5(substr($phone, -6));
               $addData['phone'] = $phone;
               $addData['create_time'] = time();
               $add_user = M("wxtuser")->add($addData);
               if($add_user)
               {
                   M("relation_stu_user")->where(array("studentid"=>$userid))->save(array("phone"=>$phone,"charging_phone"=>$phone,"userid"=>$add_user));
               }

           }else{
               return false;
           }

        }

    }

   //学校管理员默认插入所有班级
  function add_admin_class($userid,$schoolid)
  {
      //查询出这个学校的所有班级
      $school_class = M("school_class")->field("id")->where("schoolid = $schoolid")->select();

      foreach($school_class as $class_item)
      {
          $classid = $class_item['id'];
          $data['teacherid'] = $userid;
          $data['schoolid'] = $schoolid;
          $data['classid'] = $classid;
          $alldata[]=$data;
          unset($data);
      }
      $result = M('teacher_class')->addAll($alldata);

  }

function findNum($str=''){
    $str=trim($str);
    if(empty($str)){return '';}
    $result='';
    for($i=0;$i<strlen($str);$i++){
        if(is_numeric($str[$i])){
            $result.=$str[$i];
        }
    }
    return $result;
}
	//获取token
     function gettoken($id)
    {
    		// echo $id;
      //   $id = I("id"); //应用自增长ID


        $result = M("face_application")->where(array("id"=>$id))->find(); //令牌刷新时间
        $appid = $result["appid"];

        $appKey = $result["appkey"];

        $appsecret = $result["appsecret"];
        $timestamp = time();
        $sign = md5($appKey.$timestamp.$appsecret);
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/auth";

        $time = $result["token_expire_time_int"]; //令牌有效时间
        //第一次是access_token不存在 就重新获取一个
        if (time()>$time  || empty($time)) {
            $data=array(
                "appId"=>$appid,
                "appKey"=>$appKey,
                "timestamp"=>time(),
                "sign"=>$sign
            );
            $res =http_request_post($url,$data);
            $result = json_decode($res,true);
            if($result["code"]=="GS_SUS100"){
                $token = $result["data"];
                //10个小时
                $data["token_expire_time_int"] = time()+36000;
                $times = time()+36000;
                $data["token_expire_time"] = date('Y-m-d H:i:s', $times);
                $data["token"]     = $token;
                $data["token_refresh_time_int"]     = time();
                $data["token_refresh_time"]     = date('Y-m-d H:i:s', time());
                $res   = M("face_application")->where(array("id"=>$id))->save($data);
            }else{
                echo $result["code"];
            }
            //重新写进 数据库

        } else {
            $arr = M("face_application")->where(array("id"=>$id))->find(); //令牌刷新时间
            $token = $arr["token"];
        }
        return  $token;
    }

    function http_request_post($url, $data = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


      function http_request_get($url){
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL,$url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $output = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //print_r($output);
        return $output;
    }
    function http_request_put($url, $data = array())
    {
        $ch = curl_init(); //初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PUT"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置提交的字符串
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

     function http_request_delete($url,$data){
        $ch = curl_init();
        curl_setopt ($ch,CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

       //创建设备
    /*      post
            appId	   应用Id	    String	Y
            token	   调用接口凭证	String	Y
            deviceKey  设备序列号	    String	Y
            name	   设备名称	    String	N
            tag	       设备标签	    String	N
     *      返回结果: code : GS_EXP-321 如果序列号已被占用,就无法添加这个设备,得先删除才能添加
     *      返回结果: code :GS_EXP-342 设备离线则接口调用失败
     *      返回结果: code: GS_SUS300, //设备录入接口调用成功，指设备确认已经录入到云端服务器中
     */
    function insert_device($appid,$token,$deviceKey)
    {
        // $appid = "9458FA929B0449D58F91D122F162B12C";
        // $token =  "5b46506d2a54e58b7a8d73a67912996127ddac692f499c33e40a76be886689df";
        // $deviceKey = "84E0F42000F100B0";
        //$deviceKey = "84E0F4200011ABCD";
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device";

        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "deviceKey"=>$deviceKey,
        );
        $res = http_request_post($url,$data);
        $result = json_decode($res,true);
        if($result["code"]=="GS_SUS300"){
            echo  "设备添加成功";
        }else{
            echo $result["code"];
        }
        dump($result);
    }