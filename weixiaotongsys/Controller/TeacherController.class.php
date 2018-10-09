<?php

namespace Apps\Controller;
use Common\Controller\AppBaseController;
/**
 * 首页
 */
class TeacherController extends AppBaseController {
	//首页
	public function index() {
    	die('this is teacherapi');
    }
    //教师登录验证
    public function teacher_login(){
        //获取传入的参数phone,password；赋值给$mobile,$pass
        $mobile = I('phone');
        $password = I('password');
        //判断手机号及密码状态
        if($mobile != "" && $password !="")
        {
            //如果都不为空
            //表示实例化Model模型类，并操作 wxt_Wxtuser 表
            $users = M("Wxtuser");
            //判断该手机号在数据库中是否存在，若存在，则以数组的形式返回该手机号对应的数据信息
            $userinfo = $users->where(array("phone"=>$mobile))->field('id,password')->find();
            if (!$userinfo) {
                //若手机号不存在
                    $ret = $this->format_ret(0,'用户不存在');
            } else if (md5($password) != $userinfo['password']) {
                //若密码不匹配
                    $ret = $this->format_ret(0,"密码错误！");
            } else {
                unset($userinfo['password']);
                //用户名及密码正好匹配，则获取用户id，查询学校表
                $teacherid=$userinfo["id"];
                $school_count = M("duty_teacher")->where("teacher_id=$teacherid")->count();
                if(!empty($school_count)){
                    //获取职务信息
                    $duty_info = M("duty_teacher")->where("teacher_id=$teacherid")->group('schoolid')->field('schoolid')->select();
                    //循环查询学校名称
                    foreach ($duty_info as $key => $value) {
                            // $userinfo["schoolid"] = $valommonue['schoolid'].','.$userinfo["schoolid"];
                            $schoolid = intval($value['schoolid']);
                            $duty_info[$key]['schoolname'] = M('school')->where("schoolid = $schoolid")->getField('school_name');
                        }
                    $userinfo["schoolinfo"] = $duty_info;
                        // var_dump($userinfo);
                    $ret = array('status'=>'success','userid'=>$userinfo['id'], 'data'=>$userinfo['schoolinfo']); 
                    $this->format_ret(1,$userinfo);
                    
                }else{
                    $ret = $this->format_ret(0,'用户未激活');
                }
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
    //前台登录验证
    public function teacher_login_pc(){
        //获取传入的参数phone,password；赋值给$mobile,$pass
        $mobile = I('phone');
        $password = I('password');
        $verify=I('verify');
        //判断手机号及密码状态
        if($mobile != "" && $password !="")
        {
            //如果都不为空
            //表示实例化Model模型类，并操作 wxt_Wxtuser 表
            $users = M("Wxtuser");
            //判断该手机号在数据库中是否存在，若存在，则以数组的形式返回该手机号对应的数据信息
            $userinfo = $users->where(array("phone"=>$mobile))->field('id,password')->find();
            if (!$userinfo) {
                //若手机号不存在
                    $ret = $this->format_ret(0,'用户不存在');
            } else if (md5($password) != $userinfo['password']) {
                //若密码不匹配
                    $ret = $this->format_ret(0,"密码错误！");
            } else if(empty($verify)){
                    $ret = $this->format_ret(0,"验证码不能为空！");
            } else if(!sp_check_verify_code()){
                    $ret = $this->format_ret(0,"验证码错误！");
            } else {
                if($userinfo['password']==md5("1234")){
                    $password_change=1;
                }else{
                    $password_change=0;
                }
                unset($userinfo['password']);
                //用户名及密码正好匹配，则获取用户id，查询学校表
                $teacherid=$userinfo["id"];
                $school_count = M("duty_teacher")->where("teacher_id=$teacherid")->count();
                if(!empty($school_count)){
                    //获取职务信息
                    $duty_info = M("duty_teacher")->where("teacher_id=$teacherid")->group('schoolid')->field('schoolid')->select();
                    //循环查询学校名称
                    foreach ($duty_info as $key => $value) {
                            // $userinfo["schoolid"] = $valommonue['schoolid'].','.$userinfo["schoolid"];
                            $schoolid = intval($value['schoolid']);
                            $duty_info[$key]['schoolname'] = M('school')->where("schoolid = $schoolid")->getField('school_name');
                        }
                    $userinfo["schoolinfo"] = $duty_info;
                        // var_dump($userinfo);
                    $ret = array('status'=>'success','userid'=>$userinfo['id'],'password_change'=>$password_change,'data'=>$userinfo['schoolinfo']); 
                    $this->format_ret(1,$userinfo);
                    
                }else{
                    $ret = $this->format_ret(0,'用户未激活');
                }
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
    /*获取用户职位信息及最高权限等级*/
    public function get_user_dutyinfo(){
        $userid = $_POST['userid'];
        $schoolid = $_POST['schoolid'];
        $duty_info = M('duty_teacher')->where(array('schoolid'=>$schoolid,'teacher_id'=>$userid))->field('duty_id')->select();
        if($duty_info){
            $grade_arr = array();
            // //权限信息循环赋值
            foreach ($duty_info as $key => $value) {
                $dutyid = intval($value['duty_id']);
                $duty_info[$key]["duty_name"]= get_duty_name($dutyid);
                $duty_info[$key]['level'] = get_duty_level($dutyid);
                //将权限值存放在数组中，已备接下来判断最高权限
                array_push($grade_arr,$duty_info[$key]['level']);
            }
            // $duty_info[0]['maxleve'] = min($grade_arr);
        $ret = array('status'=>'success','super'=>min($grade_arr), 'data'=>$duty_info); 
        // $this->format_ret(1,$duty_info);

        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }
        
        echo json_encode($ret);
    exit;
    }
    /*获取用户基础资料*/
    public function get_user_baseinfo(){
        $userid = $_POST['userid'];
        //获取除了密码之外的数据
        $userinfo = M('Wxtuser')->where("id = $userid")->field('password',true)->find();
        if($userinfo){
            $ret = $this->format_ret(1,$userinfo);
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }
        echo json_encode($ret);
    exit;
    }
    //获取学生所在班级列表以及班级对应老师的列表
    public function getstudentclasslistandteacherlist(){
        $studentid = Intval(I('studentid'));
        if($studentid){
         $trust_model = M('class_relationship');
         $classlist = $trust_model
         ->alias("a")
         ->join("wxt_school_class c ON c.id=a.classid")
         ->field("a.classid,c.classname")
         ->where("a.userid=$studentid")
         ->order("userid desc")
         ->select();
         foreach ($classlist as &$classitem) {
            $classid= $classitem['classid'];
            $class_model=M('teacher_class');
            $teacherlist=$class_model
             ->alias("c")
             ->join("wxt_wxtuser t on c.teacherid=t.id")
             ->where("c.classid=$classid")
             ->field("t.id as id ,t.name as name,t.sex as sex,t.phone as phone,t.photo as photo")
             ->select();
            $classitem["teacherlist"]=$teacherlist;
            unset($classitem);
         }
         if($classlist){
            $ret = $this->format_ret(1,$classlist);
         }else{
            $ret = $this->format_ret(0,"no data");
         }
        
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;          
    }
    /*传入学校id获取学校信息*/
    public function get_schoolinfo(){
        $schoolid = $_POST['schoolid'];
        //获取除了密码之外的数据
        $schoolinfo = M('school')->where("schoolid = $schoolid")->find();
        if($schoolinfo){
            $ret = $this->format_ret(1,$schoolinfo);
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }
        echo json_encode($ret);
    exit;
    }
    //获取教师任教班级列表以及班级内学生列表
     public function getteacherclasslistandstudentlist(){
        $teacherid = Intval(I('teacherid'));
        if($teacherid){
         $trust_model = M('teacher_class');
         $classlist = $trust_model
         ->alias("a")
         ->join("wxt_school_class c ON c.id=a.classid")
         ->field("a.classid,c.classname")
         ->where("a.teacherid=$teacherid")
         ->order("id desc")
         ->select();
         foreach ($classlist as &$classitem) {
            $classid= $classitem['classid'];
            $class_model=M('class_relationship');
            $student_model=M('wxtuser');
            $studentlist=$class_model
             ->alias("c")
             ->join("wxt_wxtuser student on c.userid=student.id")
             ->where("c.classid=$classid")
             ->field("student.id as id ,student.name as name,student.sex as sex,student.phone as phone,student.photo as photo")
             ->select();
            $classitem["studentlist"]=$studentlist;
            unset($classitem);
         }
         if($classlist){
            $ret = $this->format_ret(1,$classlist);
         }else{
            $ret = $this->format_ret(0,"no data");
         }
        
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;          
    }
    /*获取用户科室信息*/
    public function get_user_department(){
        $userid = $_POST['userid'];
        $schoolid = $_POST['schoolid'];
        $department_info= M('department_teacher')->where(array('school_id'=>$schoolid,'teacher_id'=>$userid))->field('department_id')->select();
        if($department_info){
            //科室名称信息循环赋值
            foreach ($department_info as $key => $value) {
            $departmentid = intval($value['department_id']);
            $department_info[$key]['department_name'] = get_department_name($departmentid);
            }
        $ret = $this->format_ret(1,$department_info);

        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }
        echo json_encode($ret);
    exit;
    }
    /* 提交个人资料 */
	public function saveinfo() {
		$teacherid = I('teacherid');
		$teachername = I('teachername');
		$sex = I('sex');
		$picurl = I('picurl');
		$code = I('code');
		if($teacherid != ""){
			if ($teachername) {
				$data['name'] = $teachername;
			}
			if ($sex) {
				$data['sex'] = $sex;
			}
			if ($picurl) {
				$data['photo'] = $picurl;
			}
			$User = M("Wxtuser");

			$User->where('id='.$teacherid)->save($data);
			$ret = $this->format_ret(1,'success');
		}else{
			//若为空，则返回(0,‘param lost’)
            $ret = $this->format_ret(0,'param lost');
		}
		
		echo json_encode($ret);
		exit;
	}
    
	/* 修改个人手机号码 */
	public function updatemobile(){
		$teacherid = I('teacherid');
		$mobile = I('phone');
		$code = I('code');
		if($teacherid != "" && $mobile != "" && $code != ""){
 			//如果都不为空，先进行code验证
            $noteCode = M("auth_code");
            $noteCodeinfo = $noteCode->where(array("mobile"=>$phone,"code"=>$code,"is_show"=>1))->find();
            if($noteCodeinfo)
            {
                //短信验证码正确
                //验证成功，更改验证码状态
                $noteCode->where(array("mobile"=>$phone,"code"=>$code))->save(array("is_show"=>2,"status"=>4));
                //如果都不为空
                $User = M("Wxtuser");
                $data['phone'] = $mobile;
                $User->where('id='.$teacherid)->save($data);
                $ret = $this->format_ret(1,"success");
            }
            else
            {
                $ret = $this->format_ret(0,"验证码错误");
            }
		}
		else
		{
			$ret = $this->format_ret(0,'lost params');
		}
		echo json_encode($ret);
		exit;
	}
	// //上传教师点评
 //    public function AddTeacherComment(){
 //        $studentid = intval(I('studentid'));
 //        $teacherid = intval(I('teacherid'));
 //        $comment_content = I('content');
 //        if((!empty($studentid)) && (!empty($teacherid))){
 //            $TeacherComment = M('teacher_comment');
 //            $data['teacher_id'] = $teacherid;
 //            $data['studentid'] = $studentid;
 //            $data['comment_content']= $comment_content;
 //            $data['comment_time'] = time();
 //            $resid = $TeacherComment->add($data);
 //            if ($resid) {
 //                $ret = $this->format_ret(1,$resid);
 //            }else{
 //                $ret = $this->format_ret(0,"评论失败");
 //            }
 //        }else{
 //            $ret = $this->format_ret(0,"lost params");
 //        }
 //        echo json_encode($ret);
 //        exit;
 //    }
    //获取学校科目信息
    public function getSubject(){
        $schoolid = intval(I('schoolid'));
        $subject_model=M('subject');
        $subject=$subject_model->alias("s")->join("wxt_default_subject d ON d.id=s.subjectid")->field("d.id,d.subject")->where("s.schoolid=$schoolid")->select();
        if($subject){
            $ret = $this->format_ret(1,$subject);
        }else{
            $ret = $this->format_ret(0,"无法获取数据");
        }
        echo json_encode($ret);
        exit;
    }

    //发布作业信息
    public function addhomework(){
        $teacherid = intval(I('teacherid'));
        $title = I('title');
        $content = I('content');
        $subject = I('subject');
        if($teacherid &&(!empty($title)) && (!empty($content))){
            $homework_model = M('homework');
            $dataarray = array(
                'title'=>$title,
                'userid'=>$teacherid,
                'content'=>$content,
                'subject'=>$subject,
                'create_time'=>time()
                );
            $homeworkid = $homework_model->add($dataarray);
            //获取接收表中所需字段值,因获取到的是多个receiver_user_id,所以用explode函数拆分开
            $receiverid = I('receiverid');
            $receiveid_arr=explode(",",$receiverid);
            //去掉数组中的空格位置
            $receiveid_arr = array_filter($receiveid_arr);
            //将拆分后的id用foreach和settype函数转换为单个int值
            foreach ($receiveid_arr as &$receiver_id) {
                $receiver_id_info=$receiver_id;
                //$receiver_id=settype($receiver_id_info,"integer");
                //将接收人id存入表中
                $data_re['homework_id']=$homeworkid;
                $data_re['receiverid']=$receiver_id_info;
                $receive_ret=M('homework_receive')->add($data_re);
            }
            //图片存入表中
            $pic_model=M('homework_pic');
            $pic=I('picture_url');
            $pic_arr=explode(",",$pic);
            //去掉数组中的空格位置
            $pic_arr = array_filter($pic_arr);
            for ($i=0; $i < count($pic_arr); $i++) {
                $pic_add=$pic_model->add(array("homework_id"=>$homeworkid,"picture_url"=>$pic_arr[$i]));
            }
            if($homeworkid){
                $ret = $this->format_ret(1,$homeworkid);
                $rs = $this->pjiguang("您收到一条新的作业消息,请注意查收!","homework",$receiveid_arr,'',0);
                // foreach ($receiveid_arr as &$item){
                //     $stuid=$item;
                //     $where["studentid"]=$stuid;
                //     $where["type"]=1;
                //     $parent=M('relation_stu_user')->where($where)->getField("userid");
                //     $rs = $this->pjiguang("您收到一条新的作业消息,请注意查收!","homework",array($parent),'',0);
                // }
            }else{
                $ret = $this->format_ret(0,"add error");
            }
        }
        else
        {
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;       
    }
    //获取作业信息列表
    public function gethomeworklist(){
        $userid = intval(I('userid'));
        if($userid){
            $homework_model = M('homework');
            $lists=$homework_model
            ->field('id,userid,title,subject,content,photo,create_time')
            ->where("userid=$userid")
            ->order('id desc')
            ->select();
            $comment_model = M('comments');//评论表
            foreach ($lists as &$homework ) {
                $refid =$homework["id"];
                $homework['username']="潘宁";
                $homework['readcount']=1;
                $homework['allreader']=5;
                $homework['readtag']=1;
                $like_model=M('likes');
                $like_return = $like_model->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where("wxt_likes.refid = $refid and type='2'")
                    ->order('likeid ASC')
                    ->field('userid,photo as avatar,wxt_wxtuser.name')
                    ->select();
                $comment_return = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where("wxt_comments.refid = $refid and type='2'")
                    ->order('wxt_comments.id ASC')
                    ->field('userid,wxt_wxtuser.photo as avatar,wxt_wxtuser.name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                    ->select();
                $homework['comment']=$comment_return;
                $homework['like']=$like_return;
                //接收人列表
                $receive_model=M('homework_receive');
                $receiver=$receive_model->field("id,homework_id,receiverid,read_time")->where("homework_id=$refid")->select();
                foreach ($receiver as &$receiverinfo) {
                    $user_id=$receiverinfo["receiverid"];
                    $receiver_info=M('wxtuser')
                    ->field("name,photo,phone")
                    ->where("id=$user_id")
                    ->select();
                    $receiverinfo['receiver_info']=$receiver_info;
                    unset($receiverinfo);
                }
                $homework['receiverlist']=$receiver;
                //老师信息
                $user_model=M('wxtuser');
                $userinfo=$user_model->field("name,photo")->where("id=$userid")->find();
                $homework['teacher_info']=$userinfo;
                //获取图片
                $pic=M('homework_pic')->field("picture_url")->where(array("homework_id"=>$homework['id']))->select();
                $homework['pic']=$pic;
                for ($j=0; $j < count($pic); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                    $homework['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $homework['pic'][$j]["pictureheight"]=$imagesize["1"];
                }
                unset($homework);
            }
            $ret = $this->format_ret(1,$lists);

        }
        else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;       
    }
    //用户读作业时间
    public function read_homework(){
        $homework_id=I('homework_id');
        $receiverid=I('receiverid');
        $data['read_time']=time();
        $where['homework_id']=$homework_id;
        $where['receiverid']=$receiverid;
        $new_time=M('homework_receive')->where($where)->save($data);
        if($new_time){
            $ret = $this->format_ret(1,'成功');
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }  
        echo json_encode($ret);
        exit; 
    }
    //发布班级活动
    public function addactivity(){
        $teacherid = intval(I('teacherid'));
        $title = I('title');
        $content = I('content');
        $begintime=I('begintime');
        $endtime=I('endtime');
        $starttime=I('starttime');
        $finishtime=I('finishtime');
        $isapply=I('isapply');
        $contactman=I('contactman');
        $contactphone=I('contactphone');
        if($teacherid &&(!empty($title)) && (!empty($content))){
            $homework_model = M('activity');
            $dataarray = array(
                'title'=>$title,
                'userid'=>$teacherid,
                'content'=>$content,
                'begintime'=>$begintime,
                'endtime'=>$endtime,
                'starttime'=>$starttime,
                'finishtime'=>$finishtime,
                'contactman'=>$contactman,
                'contactphone'=>$contactphone,
                'isapply'=>$isapply,
                'create_time'=>time()
                );
            $homeworkid = $homework_model->add($dataarray);
            //获取接收表中所需字段值,因获取到的是多个receiver_user_id,所以用explode函数拆分开
            $receiverid = I('receiverid');
            $receiveid_arr=explode(",",$receiverid);
            //去掉数组中的空格位置
            $receiveid_arr = array_filter($receiveid_arr);
            //将拆分后的id用foreach和settype函数转换为单个int值
            foreach ($receiveid_arr as &$receiver_id) {
                $receiver_id_info=$receiver_id;
                //$receiver_id=settype($receiver_id_info,"integer");
                //将接收人id存入表中
                $data_re['activity_id']=$homeworkid;
                $data_re['receiverid']=$receiver_id_info;
                $receive_ret=M('activity_receive')->add($data_re);
            }
            //图片存入表中
            $pic_model=M('activity_pic');
            $pic=I('picture_url');
            $pic_arr=explode(",",$pic);
            //去掉数组中的空格位置
            $pic_arr = array_filter($pic_arr);
            for ($i=0; $i < count($pic_arr); $i++) {
                $pic_model->add(array("activity_id"=>$homeworkid,"picture_url"=>$pic_arr[$i]));
            }
            if($homeworkid){
                $ret = $this->format_ret(1,$homeworkid);
                $rs = $this->pjiguang("您收到一条新的班级活动消息,请注意查收!","activity",$receiveid_arr,'',0);
                // foreach ($receiveid_arr as &$item){
                //     $stuid=$item;
                //     $where["studentid"]=$stuid;
                //     $where["type"]=1;
                //     $parent=M('relation_stu_user')->field("userid")->where($where)->find();
                //     $rs = $this->pjiguang("您收到一条新的班级活动消息,请注意查收!","activity",$parent,'',0);
                // }
            }else{
                $ret = $this->format_ret(0,"add error");
            }
        }
        else
        {
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;       
    }
     //获取班级活动列表
    public function getactivitylist(){
        $userid = intval(I('userid'));
        if($userid){
            $homework_model = M('activity');
            $lists=$homework_model
            ->field('id,userid,classid,title,content,contactman,contactphone,begintime,endtime,starttime,finishtime,isapply,create_time')
            ->where("userid=$userid")
            ->order('id desc')
            ->select();
            $comment_model = M('comments');//评论表
            foreach ($lists as &$homework ) {
                $refid =$homework["id"];
                $homework['username']="潘宁";
                $homework['readcount']=1;
                $homework['allreader']=5;
                $homework['readtag']=1;
                $like_model=M('likes');
                $like_return = $like_model->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where("wxt_likes.refid = $refid and type='5'")
                    ->order('likeid ASC')
                    ->field('userid,photo as avatar,wxt_wxtuser.name')
                    ->select();
                $comment_return = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where("wxt_comments.refid = $refid and type='5'")
                    ->order('wxt_comments.id ASC')
                    ->field('userid,wxt_wxtuser.photo as avatar,wxt_wxtuser.name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                    ->select();
                $homework['comment']=$comment_return;
                $homework['like']=$like_return;
                //接收人列表
                $receive_model=M('activity_receive');
                $receiver=$receive_model->field("id,activity_id,receiverid,read_time")->where("activity_id=$refid")->select();
                foreach ($receiver as &$receiverinfo) {
                    $user_id=$receiverinfo["receiverid"];
                    $receiver_info=M('wxtuser')
                    ->field("name,photo,phone")
                    ->where("id=$user_id")
                    ->select();
                    $receiverinfo['receiver_info']=$receiver_info;
                    unset($receiverinfo);
                }
                $homework['receiverlist']=$receiver;
                //老师信息
                $user_model=M('wxtuser');
                $userinfo=$user_model->field("name,photo")->where("id=$userid")->find();
                $homework['teacher_info']=$userinfo;
                //获取图片
                $pic=M('activity_pic')->field("picture_url")->where(array("activity_id"=>$homework['id']))->select();
                $homework['pic']=$pic;

                for ($j=0; $j < count($pic); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                    $homework['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $homework['pic'][$j]["pictureheight"]=$imagesize["1"];
                }

                // 报名列表
                $apply_model=M('entryactivity');
                $apply_return = $apply_model->alias("e")->join("".C('DB_PREFIX')."wxtuser as u ON e.userid = u.id")
                    ->where("e.activityid = $refid")
                    ->order('e.id ASC')
                    ->field('userid,photo as avatar,u.name,e.id as applyid,fathername,contactphone,age,e.sex,e.create_time')
                    ->select();
                $homework["applylist"]=$apply_return;
                unset($homework);
            }
            $ret = $this->format_ret(1,$lists);

        }
        else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;       
     
    }
    //报名班级活动
    public function ApplyActivity(){
        $userid=I('userid');
        $activityid=I('activityid');
        $sex=I('sex');
        $age=I('age');
        $fathername=I('fathername');
        $contactphone=I('contactphone');
        if(!empty($userid) && !empty($activityid)){
            $apply_model=M('entryactivity');
            $data["userid"]=$userid;
            $data["activityid"]=$activityid;
            $data["sex"]=$sex;
            $data["age"]=$age;
            $data["fathername"]=$fathername;
            $data["contactphone"]=$contactphone;
            $data["create_time"]=time();
            $applyid=$apply_model->add($data);
            if($applyid){
                $ret = $this->format_ret(1,$applyid);
            }else{
                $ret = $this->format_ret(0,"活动报名失败！");
            }
        }else{
            $ret = $this->format_ret(0,"未获取到用户的id或者活动id！");
        }
        echo json_encode($ret);
        exit;
    }
    //教师获取家长叮嘱列表
    public function getentrustlist(){
        $teacherid = Intval(I('teacherid'));
        if($teacherid){
         $trust_model = M('entrust');
         $user_model = M('wxtuser');
         $pic_model = M('notice_photo');
            $like_model =M('likes');
            $comment_model = M('comments');
         $list = $trust_model
         ->field("id,userid,studentid,teacherid,content,photo,create_time,feedback,feed_time")
         ->where("teacherid=$teacherid")
         ->order("id desc")
         ->select();
        foreach ($list as &$entrust ) {
                $noticeid = $entrust["id"];
                $userid = $entrust["userid"];
                $studentid=$entrust["studentid"];
                $teacherid=$entrust["teacherid"];
                $userinfo = $user_model
                ->field("name,photo")
                ->where("id=$userid")
                ->find();
                $entrust['username']=$userinfo["name"];
                $entrust["useravatar"]= $userinfo["photo"];
                $teacherinfo = $user_model
                ->field("name,photo")
                ->where("id=$teacherid")
                ->find();
                $entrust['teachername']=$teacherinfo["name"];
                $entrust["teacheravatar"]= $teacherinfo["photo"];
                $studentinfo = $user_model
                ->field("name,photo")
                ->where("id=$studentid")
                ->find();
                $entrust['studentname']=$studentinfo["name"];
                $entrust["studentavatar"]= $studentinfo["photo"];
                //获取图片
                $pic=M('trust_pic')->field("picture_url")->where(array("trust_id"=>$entrust['id']))->select();
                if($pic){
                    $entrust['pic']=$pic;
                    for ($j=0; $j < count($pic); $j++) { 
                        # code...
                        $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                        $entrust['pic'][$j]["picturewidth"]=$imagesize["0"];
                        $entrust['pic'][$j]["pictureheight"]=$imagesize["1"];
                    }
                }else
                {
                    $entrust['pic']= "";
                }
                $like_return = $like_model->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where("wxt_likes.refid = $noticeid and type='4'")
                    ->order('likeid ASC')
                    ->field('userid,photo as avatar,wxt_wxtuser.name')
                    ->select();
                $comment_return = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where("wxt_comments.refid = $noticeid and type='4'")
                    ->order('wxt_comments.id ASC')
                    ->field('userid,wxt_wxtuser.photo as avatar,name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                    ->select();
                $entrust['comment']=$comment_return;
                $entrust['like']=$like_return;
                unset($entrust);
            }
        $ret = $this->format_ret(1,$list);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;          
    }
    //教师回复叮嘱
    public function feedbackentrust(){
        $teacherid = Intval(I('teacherid'));
        $id=Intval(I('id'));
        $content = I('content');
        if($teacherid){
            $trust_model = M('entrust');
            $dataarray = array(
                'feedback'=>$content,
                'feed_time'=>time()
                );
         $trust_model->where('id='.$id)->save($dataarray);
         $user_arr=$trust_model->where('id='.$id)->getField('studentid');
         $rs = $this->pjiguang("您收到一条新的家长叮嘱的回复消息,请注意查收!","trust",array($user_arr),'',0);
         $ret = $this->format_ret(1,'success');
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;          
    }
    //获取教师任教班级列表
    public function getteacherclasslist(){
        $teacherid = Intval(I('teacherid'));
        if($teacherid){
         $trust_model = M('teacher_class');
         $list = $trust_model
         ->alias("a")
         ->join("wxt_school_class c ON c.id=a.classid")
         ->field("a.classid,c.classname")
         ->where("a.teacherid=$teacherid")
         ->order("id desc")
         ->select();
         if($list){
            $ret = $this->format_ret(1,$list);
         }else{
            $ret = $this->format_ret(0,"no data");
         }
        
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;          
    }
    //发起待接信息
    public function addtransport(){
        $teacherid = intval(I('teacherid'));
        $studentid =I('studentid');
        $studentid_arr=explode(",",$studentid);
        //去掉数组中的空格位置
        $studentid_arr = array_filter($studentid_arr);
        $content=I('content');
        $photo = I('photo');
        $status = intval(I('status'));
        if($studentid && $teacherid){
            $collect_model = M("student_delivery");
            foreach ($studentid_arr as &$student) {
                $studentid=$student;
                $dataarray = array(
                "teacherid"=>$teacherid,
                "studentid"=>$studentid,
                "content"=>$content,
                "photo"=>$photo,
                "delivery_time"=>time());
            $collect_add=$collect_model->add($dataarray);
            // $studentlist['parent_info']=$parent_info;
        }
            $ret = $this->format_ret(1,"add success");
            $rs = $this->pjiguang("您收到一条新的代接确认消息,请注意查收!","delivery",$studentid_arr,'',0);
        }
        else{
            $ret = $this->format_ret(0,'lost params');
        }
        echo json_encode($ret);
        exit;
    }
    //获取待确认信息
   //获取待确认信息
    public function gettransportconfirmation(){
        //获取老师id
        $userid = Intval(I('teacherid'));
        //如果老师id不为空
        if($userid){
            $collect = M("student_delivery");
            //获取student_delivery表中各字段值
            $lists = $collect
            ->field('delivery_id as id,teacherid,studentid,photo,content,delivery_time,delivery_status,parentid,parenttime')
            ->where("teacherid=$userid")
            ->order("id asc")
            ->select();
            $user_model = M("wxtuser");
            $class_model=M("class_relationship");
            //用foreach获取老师,家长,学生,班级的信息
            foreach ($lists as &$collect ) {
                $teacherid = $collect["teacherid"];
                $studentid=$collect["studentid"];
                $parentid = $collect["parentid"];
                //两表联查,通过学生id获取学生所在的班级的名称
                $student_class=$class_model
                    ->alias("a")
                    ->join("wxt_school_class u ON a.classid=u.id")
                    ->field("classname")
                    ->where("a.userid=$studentid")
                    ->find();
                if($student_class){
                    $collect['classname']=$student_class['classname'];
                }else{
                    $collect['classname']="";
                }
                //通过老师id获取老师的信息
                $teacher = $user_model->field("name,phone,photo")->where("id=$teacherid")->find();
                if($teacher){
                    $collect['teachername']=$teacher["name"];
                    $collect['teacheravatar']=$teacher["photo"];
                    $collect['teacherphone']=$teacher["phone"];
                }else{
                    $collect['teachername']="";
                    $collect['teacheravatar']="default.png";
                    $collect['teacherphone']="";      
                }
                //通过家长id获取家长的信息
                if($parentid){
                    $parent = $user_model->field("name,phone,photo")->where("id=$parentid")->find();
                    if($parent){
                        $collect['parentname']=$parent["name"];
                        $collect['parentavatar']=$parent["photo"];
                        $collect['parentphone']=$parent["phone"];
                    }
                }
                //通过学生id获取学生的信息
                if($studentid){
                    $student = $user_model->field("name,phone,photo")->where("id=$studentid")->find();
                    if($student){
                        $collect['studentname']=$student["name"];
                        $collect['studentavatar']=$student["photo"];
                        $collect['studentphone']=$student["phone"];
                    }else
                    {
                        $collect['studentname']="";
                        $collect['studentavatar']="default.png";
                        $collect['studentphone']="";
                    }
                }
                unset($collect);
            } 
            $ret = $this->format_ret(1,$lists); 
        }else{
            $ret = $this->format_ret(0,"lost params");
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
            ->order("a.create_time DESC")
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
    //判断用户考勤中的请假情况
    public function GetStudentLeave(){
        $userid=Intval(I("userid"));
        $leavedate=I("leavedate");
        $leavedate_arr=explode(",",$leavedate);
        //去掉数组中的空格位置
        $leavedate_arr = array_filter($leavedate_arr);
        foreach ($leavedate_arr as &$leave) {
            $leave_model=M('leave');
            $leave_time=$leave;
            $time=settype($leave_time,"integer");
            $where["studentid"]=$userid;
            $where["begintime"]=array("ELT",$leave_time);
            $where["endtime"]=array("EGT",$leave_time);
            $leava_info=$leave_model
            ->where($where)
            ->order("id")
            ->select();
            var_dump($leava_info);
            if($leava_info){
                $leave["leava_info"]=$leava_info;
            }else{
                $leave["leava_info"]="";
            }
        }
        if($leavedate_arr){
            $ret = $this->format_ret(1,$leavedate_arr);
        }else{
           $ret = $this->format_ret(0,"no data");
        }
        echo json_encode($ret);
        exit;
    }
    //获取班级考勤天数
    public function GetStudentAttendanceDays(){
        $classid=Intval(I("classid"));
        $begintime=I("begintime");
        $endtime=I("endtime");
        if($classid){
            $attendancel_model=M("attendance");
            $class_model=M('class_relationship');
            $studentlist = $class_model
            ->alias("c")
            ->join("wxt_wxtuser w ON c.userid=w.id")
            ->field("w.id,w.photo,w.name")
            ->where("c.classid=$classid")
            ->select();
            foreach ($studentlist as &$attendance) {
                $studentid=$attendance["id"];
                $where["userid"]=$studentid;
                $where["sign_date"]=array("EGT",$begintime);
                $where["sign_date"]=array("ELT",$endtime);
                $attendance_info=$attendancel_model->where($where)->count();
                $attendance["arrive_count"]=$attendance_info;
            }
            if($studentlist){
            $ret = $this->format_ret(1,$studentlist);
            }else{
               $ret = $this->format_ret(0,"no data");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //获取班级内考勤记录
    public function GetStudentAttendanceList(){
        //定义数据模型
        $attendancel_model=M("attendance");
        $class_model=M('class_relationship');
        $leave_model=M('leave');
        //接收数据参数
        $classid=Intval(I("classid"));
        $sign_date=I("sign_date");
        //主结构－－获取班级列表
        if($classid){
         $trust_model = M('teacher_class');
         $classlist = $class_model
         ->field("userid")
         ->where("classid=$classid")
         ->select();
         //子结构获取班级内学生的列表
         foreach ($classlist as &$classitem) {
            $studentid=$classitem["userid"];
            $class_model=M('class_relationship');
            $studentlist=M('wxtuser')
             ->where("id=$studentid")
             ->field("name,phone,photo")
             ->find();
             if($studentlist){
                $classitem["name"]=$studentlist["name"];
                $classitem["phone"]=$studentlist["phone"];
                $classitem["photo"]=$studentlist["photo"];
            }else{
                $classitem["name"]="";
                $classitem["phone"]="";
                $classitem["photo"]="";
            }
            $where["userid"]=$studentid;
            $where["sign_date"]=$sign_date;
            $attendance_info=$attendancel_model->where($where)->find();
            if($attendance_info){
                $classitem["studentid"]=$attendance_info["userid"];
                $classitem["arrivetime"]=$attendance_info["arrivetime"];
                $classitem["leavetime"]=$attendance_info["leavetime"];
                $classitem["type"]=$attendance_info["type"];
                $classitem["arrivepicture"]=$attendance_info["arrivepicture"];
                $classitem["leavepicture"]=$attendance_info["leavepicture"];
                $classitem["arrivevideo"]=$attendance_info["arrivevideo"];
                $classitem["leavevideo"]=$attendance_info["leavevideo"];
                $classitem["sign_date"]=$attendance_info["sign_date"];
                $classitem["create_time"]=$attendance_info["create_time"];
            }else{
                $classitem["studentid"]="";
                $classitem["arrivetime"]="";
                $classitem["leavetime"]="";
                $classitem["type"]="";
                $classitem["arrivepicture"]="";
                $classitem["leavepicture"]="";
                $classitem["arrivevideo"]="";
                $classitem["leavevideo"]="";
                $classitem["sign_date"]="";
                $classitem["create_time"]="";
            }
            $where_leave["studentid"]=$studentid;
            $where_leave["status"]=1;
            $where_leave["endtime"]=array("EGT",$sign_date);
            $where_leave["begintime"]=array("ELT",$sign_date);
            $leave_info=$leave_model->where($where_leave)->find();
            if($leave_info){
                $classitem["status"]=$leave_info["status"];
            }else{
                $classitem["status"]="0";
            }
            unset($classitem);
         }
         if($classlist){
            $ret = $this->format_ret(1,$classlist);
         }else{
            $ret = $this->format_ret(0,"no data");
         }
        
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;  
    }
    // //教师获取任课班级列表
    // public function getteacherclasslist(){
    //     $teacherid = Intval(I('teacherid'));
    //     if($teacherid){
    //         $teacher_class_model = M('teacher_class');
    //         $lists = $teacher_class_model
    //         ->alias("a")
    //         ->join("wxt_school_class c ON c.id=a.classid")
    //         ->field("a.classid,c.classname")
    //         ->where("a.teacherid=$teacherid")
    //         ->select();
    //         $ret = $this->format_ret(1,$lists);
    //     }else
    //     {
    //         $ret = $this->format_ret(0,"lost params");
    //     }
    //     echo json_encode($ret);
    //     exit;            
    // }
    //发布教师点评
    public function AddTeacherComment(){
        //获取传入的参数
        $studentid = I('studentid');
        $teacherid = intval(I('teacherid'));
        $comment_content = I('content');
        $learn=Intval(I('learn'));//学习
        $work=Intval(I('work'));//动手能力
        $sing=Intval(I('sing'));//唱歌
        $labour=Intval(I('labour'));//劳动
        $strain=Intval(I('strain'));//应变能力
        if((!empty($studentid)) && (!empty($teacherid))){
            $TeacherComment = M('teacher_comment');
            $data['teacher_id'] = $teacherid;
            $data['comment_content']= $comment_content;
            $data['learn']=$learn;
            $data['work']=$work;
            $data['sing']=$sing;
            $data['labour']=$labour;
            $data['strain']=$strain;
            $data['comment_time'] = time();
            $student_array = explode(',',$studentid);
            //去掉数组中的空格位置
            $student_array = array_filter($student_array);
                //存入字符串
                for($i=0;$i<count($student_array);$i++) {
                    $data['studentid'] = $student_array[$i];
                    $resid = $TeacherComment->add($data);
                }
            if ($resid) {
                $ret = $this->format_ret(1,$resid);
                $rs = $this->pjiguang("您收到一条新的老师点评,请注意查收!","comment",$student_array,'',0);
            }else{
                $ret = $this->format_ret(0,"评论失败");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //获取老师点评
    public function GetTeacherComment(){
        //接收参数
        $teacherid = intval(I('teacherid'));
        $begintime=I('begintime');
        $endtime=I('endtime');
        if($teacherid){
            $class_model = M('teacher_class');
            //根据接收到的老师id获取班级id.名称
                $classlist = $class_model
                ->alias("a")
                ->join( "".C('DB_PREFIX')."school_class c ON c.id=a.classid")
                ->field("a.classid,c.classname")
                ->where("a.teacherid=$teacherid")
                ->order("id desc")
                ->select();
                //获取每个班级对应的学生信息
                foreach ($classlist as &$classitem) {
                $classid= $classitem['classid'];
                $class_model=M('class_relationship');
                $student_model=M('wxtuser');
                $studentlist=$class_model
                 ->alias("c")
                 ->join("wxt_wxtuser student on c.userid=student.id")
                 ->where("c.classid=$classid")
                 ->field("student.id as id ,student.name as name,student.sex as sex,student.phone as phone,student.photo as photo")
                 ->select();
                 //根据学生获取对应的老师点评
                 foreach ($studentlist as &$conmment) {
                        $studentid=$conmment['id'];
                        $TeacherComment = M('teacher_comment');
                        $conmmentwhere["t.studentid"]=$studentid;
                        if(!empty($begintime)){
                          $conmmentwhere["t.comment_time"]= array(array('EGT',$begintime),array('ELT',$endtime));  
                        }
                        $conmment_info=$TeacherComment
                        ->alias("t")
                        ->join("wxt_wxtuser w ON t.teacher_id=w.id")
                        ->field("t.*,w.name,w.photo")
                        ->where($conmmentwhere)
                        ->select();
                        $conmment["comments"]=$conmment_info;
                        unset($conmment);
                    }
                $classitem["studentlist"]=$studentlist;
                    
                unset($classitem);
                }
                if($classlist){
                   $ret = $this->format_ret(1,$classlist);
                }else{
                   $ret = $this->format_ret(0,"no data");
            }
        }
        else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //教师端获取请假列表
    public function getleavelist(){
        $teacherid = Intval(I("teacherid"));
        if($teacherid){
            $leave_model = M("leave");
            $lists = $leave_model
            ->field('id,studentid,userid as parentid,teacherid,create_time,begintime,endtime,reason,leavetype,status,feedback,deal_time')
            ->where("teacherid=$teacherid")
            ->order("id desc")
            ->select();
            $user_model = M("wxtuser");
            $class_model=M("class_relationship");
            foreach ($lists as &$leave ) {
                $teacherid = $leave["teacherid"];
                $parentid = $leave["parentid"];
                $studentid = $leave["studentid"];
                //两表联查,通过学生id获取学生所在的班级的名称
                $student_class=$class_model
                    ->alias("a")
                    ->join("wxt_school_class u ON a.classid=u.id")
                    ->field("u.classname")
                    ->where("a.userid=$studentid")
                    ->find();
                if($student_class){
                    $leave['classname']=$student_class["classname"];
                }else{
                    $leave['classname']="";
                }
                $teacher = $user_model->field("name,phone,photo")->where("id=$teacherid")->find();
                if($teacher){
                    $leave['teachername']=$teacher["name"];
                    $leave['teacheravatar']=$teacher["photo"];
                    $leave['teacherphone']=$teacher["phone"];
                }else{
                    $leave['teachername']="";
                    $leave['teacheravatar']="default.png";
                    $leave['teacherphone']="";      
                }
                if($parentid){
                    $parent = $user_model->field("name,phone,photo")->where("id=$parentid")->find();
                    if($parent){
                        $leave['parentname']=$parent["name"];
                        $leave['parentavatar']=$parent["photo"];
                        $leave['parentphone']=$parent["phone"];
                    }else{
                        $leave['parentname']="";
                        $leave['parentavatar']="default.png";
                        $leave['parentphone']="";
                    }
                }
                if($studentid){
                    $student = $user_model->field("name,phone,photo")->where("id=$studentid")->find();
                    if($student){
                        $leave['studentname']=$parent["name"];
                        $leave['studentavatar']=$parent["photo"];
                    }else{
                        $leave['studentname']="";
                        $leave['studentavatar']="default.png";
                    }
                }              
                //获取图片
                $pic=M('leave_pic')->field("picture_url")->where(array("leave_id"=>$leave['id']))->select();
                $leave['pic']=$pic;  
                for ($j=0; $j < count($pic); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                    $leave['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $leave['pic'][$j]["pictureheight"]=$imagesize["1"];
                }        
                unset($leave);
            }           
             $ret = $this->format_ret(1,$lists);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit; 
    }
    //教师回复请假信息
    public function replyleave(){
        $collectid = intval(I('leaveid'));
        $teacherid = intval(I('teacherid'));
        $feedback = I('feedback');
        $status = intval(I('status'));
        if($teacherid && $collectid){
            $leave = M("leave");
            $dataarray = array(
                "teacherid"=>$teacherid,
                "status"=>$status,
                "feedback"=>$feedback,
                "deal_time"=>time());
            $leave->where('id='.$collectid)->save($dataarray);
            $ret = $this->format_ret(1,'success');
            $studentid=$leave->where('id='.$collectid)->getField("studentid");
            $rs = $this->pjiguang("您收到一条新的请假回复消息,请注意查收!","leave",array($studentid),'',0);
        }
        else{
            $ret = $this->format_ret(0,'lost params');
        }
        echo json_encode($ret);
        exit;
    }
	//图像上传
	public function imgupload() {
		$uid = $_POST['teacherid'];
	/* echo json_encode(array('result' => $_FILES));die; */
		$saveDir = "./data/user_uploads/$uid/original";
		$saveDir1 = "./data/user_uploads/$uid";
		$arrTmp = pathinfo($_FILES['file']['name']);
		$extension = strtolower($arrTmp['extension']);
		$file_newname = $uid . '_' . date("YmdHis").rand(1000,9999).".".$extension; //重命名新文件， 00表示为上传的为原图
		if(!file_exists($saveDir)){       //判断保存目录是否存在
			mkdir($saveDir,0777,true);    //建立保存目录
		}
		$imageInfo = getimagesize($_FILES['file']['tmp_name']);
		$imageType = strtolower(substr(image_type_to_extension($imageInfo[2]),1));
		$createFun = 'ImageCreateFrom'.($imageType=='jpg'?'jpeg':$imageType);
		$thisim = $createFun($_FILES['file']['tmp_name']);
		$newimg = imagecreatetruecolor(314,234);
		imagecopyresampled($newimg, $thisim, 0, 0, 0, 0, 314, 234, $imageInfo[0], $imageInfo[1]);
		ImageJpeg ($newimg,$saveDir1."/".$file_newname);

		$result = move_uploaded_file($_FILES['file']['tmp_name'],$saveDir."/".$file_newname);
		$ret = $this->format_ret(1,$file_newname);
		// $data['photo'] = $file_newname;
		// $User = M("Xpuser");
		// $User->where('id='.$uid)->save($data);
		echo json_encode($ret);
		exit;
	}


    //教师端推送
    function tjiguang($content = "",$m_type='',$receive=""){
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
            $rs=tjpush($content,$m_type,$receiver,'',0);
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
    // //家长端推送
    // function pjiguang($content = "",$m_type='',$receive=""){
    //     //查找用户对应的registrationid
    //     $recivelist = array();
    //     $ishave=0;
    //     foreach ($receive as &$userid) {
    //         $where['id']=$userid;
    //         $u=M('wxtuser')->where($where)->field('xgtoken')->find();
    //         if(!empty($u['xgtoken'])){
    //            $recivelist[]=$u['xgtoken']; 
    //            $ishave=1;
    //        }
    //    }
    //     if($ishave==1){
    //         $receiver = array('registration_id'=>$recivelist);
    //         $rs=ujpush($content,$m_type,$receiver,'',0);
    //         if($rs){
    //             $ret="success";
    //         }else{
    //             $ret="error";
    //         }
    //     }else{
    //         $ret="error";
    //     }      
    //     return $ret;
    // }
    //家长端推送
    function pjiguang($content = "",$m_type='',$receive="",$m_value="",$isparent = 0){
        $recivelist = array();
        $ishave=0;
        foreach ($receive as &$userid) {
            if($isparent){
                $where['id']=$userid;
                $u=M('wxtuser')->where($where)->field('xgtoken')->find();
                if(!empty($u['xgtoken'])){
                   $recivelist[]=$u['xgtoken']; 
                   $ishave=1;
                }
            }else{
                $plists=$this->GetParentTokenByStudentid($userid);
                if($plists){
                    foreach ($plists as &$parent) {
                        if(!empty($parent['xgtoken'])){
                           $recivelist[]=$parent['xgtoken']; 
                           $ishave=1;
                       }
                    }
                }
            }
            
        }
        if($ishave==1){
            $receiver = array('registration_id'=>$recivelist);
            $rs=ujpush($content,$m_type,$receiver,$m_value,1);
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
    function GetParentTokenByStudentid($studentid)
    {
        if($studentid){
            $parent_model=M('wxtuser');

            $appellation_model=M('relation_stu_user');
            $lists=$appellation_model
            ->alias('a')
            ->join('wxt_wxtuser u on u.id=a.userid')
            ->field("u.xgtoken")
            ->where("a.studentid=$studentid")
            // ->fetchsql(true)
            ->select();
            return $lists;
        }else{
            return "";
        }
        return "";
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
	
	//班级活动详情
	     public function getactivitydetail(){
        $userid = intval(I('userid'));
        $ids=I('id');
        if($userid){
            $homework_model = M('activity');
            $lists=$homework_model
            ->field('id,userid,classid,title,content,contactman,contactphone,begintime,endtime,starttime,finishtime,isapply,create_time')
            ->where("userid=$userid and id=$ids")
            ->order('id desc')
            ->select();
            $comment_model = M('comments');//评论表
            foreach ($lists as &$homework ) {
                $refid =$homework["id"];
                $homework['username']="潘宁";
                $homework['readcount']=1;
                $homework['allreader']=5;
                $homework['readtag']=1;
                $like_model=M('likes');
                $like_return = $like_model->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where("wxt_likes.refid = $refid and type='5'")
                    ->order('likeid ASC')
                    ->field('userid,photo as avatar,wxt_wxtuser.name')
                    ->select();
                $comment_return = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where("wxt_comments.refid = $refid and type='5'")
                    ->order('wxt_comments.id ASC')
                    ->field('userid,wxt_wxtuser.photo as avatar,wxt_wxtuser.name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                    ->select();
                $homework['comment']=$comment_return;
                $homework['like']=$like_return;
                //接收人列表
                $receive_model=M('activity_receive');
                $receiver=$receive_model->field("id,activity_id,receiverid,read_time")->where("activity_id=$refid")->select();
                foreach ($receiver as &$receiverinfo) {
                    $user_id=$receiverinfo["receiverid"];
                    $receiver_info=M('wxtuser')
                    ->field("name,photo,phone")
                    ->where("id=$user_id")
                    ->select();
                    $receiverinfo['receiver_info']=$receiver_info;
                    unset($receiverinfo);
                }
                $homework['receiverlist']=$receiver;
                //老师信息
                $user_model=M('wxtuser');
                $userinfo=$user_model->field("name,photo")->where("id=$userid")->find();
                $homework['teacher_info']=$userinfo;
                //获取图片
                $pic=M('activity_pic')->field("picture_url")->where(array("activity_id"=>$homework['id']))->select();
                $homework['pic']=$pic;

                for ($j=0; $j < count($pic); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                    $homework['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $homework['pic'][$j]["pictureheight"]=$imagesize["1"];
                }

                // 报名列表
                $apply_model=M('entryactivity');
                $apply_return = $apply_model->alias("e")->join("".C('DB_PREFIX')."wxtuser as u ON e.userid = u.id")
                    ->where("e.activityid = $refid")
                    ->order('e.id ASC')
                    ->field('userid,photo as avatar,u.name,e.id as applyid,fathername,contactphone,age,e.sex,e.create_time')
                    ->select();
                $homework["applylist"]=$apply_return;
                unset($homework);
            }
            $ret = $this->format_ret(1,$lists);

        }
        else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;       
     

    }
	
	}