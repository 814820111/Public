<?php

namespace Apps\Controller;
use Common\Controller\AppBaseController;
/**
 * 首页
 */
class StudentController extends AppBaseController {
	//首页
	public function index() {
    	die('this is Studentapi');
    }
    //发布邀请家人
    public function AddInviteFamily(){
        $studentid=Intval(I('studentid'));
        $parentname=I('parentname');
        $appellation=I('appellation');
        $phone=I('phone');
        $photo=I('photo');
        $data['name']=$parentname;
        $data['phone']=$phone;
        $data['photo']=$photo;
        if($studentid){
            $parent_model=M('wxtuser');
            $appellation_model=M('relation_stu_user');
            $apinfo_model=M('appellation');
            $parent_info=$parent_model->where("phone=$phone")->find();
            //如果user表中没有返回的家长,那就把参数add到表中
            //并且家长关系表中肯定没有这个家长,需要把参数加到家长关系表中
            if(!$parent_info){
                $addparent=$parent_model->add($data);
                $data_par['studentid']=$studentid;
                $data_par['userid']=$addparent;
                $data_par['appellation']=$appellation;
                $data_par['time']=time();
                if(($appellation="爸爸")||($appellation="妈妈")){
                    $data_par['relation_rank']=1;
                }
                $addap=$appellation_model->add($data_par);
                if($addap && $addparent){
                    $ret = $this->format_ret(1,$addparent);
                }else{
                    $ret = $this->format_ret(0,"add ap and parent error!");
                }
            //如果user表中已经存在这个家长
            }else{
                //判断在关系表中是否存在
                $apwhere['studentid']=$studentid;
                $apwhere['userid']=$parent_info['id'];
                $appellation_info=$appellation_model->where($apwhere)->find();
                //如果不存在
                if(!$appellation_info){
                    $data_ap['studentid']=$studentid;
                    $data_ap['userid']=$parent_info['id'];
                    $data_ap['appellation']=$appellation;
                    $data_ap['time']=time();
                    if(($appellation="爸爸")||($appellation="妈妈")){
                        $data_ap['relation_rank']=1;
                    }
                    $addappellation=$appellation_model->add($data_ap);
                    if($addappellation){
                    $ret = $this->format_ret(1,$addappellation);
                }else{
                    $ret = $this->format_ret(0,"addappellation error!");
                }
                }else{
                    $ret = $this->format_ret(0,"已经是家人关系了!");
                }
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
     //设置主号家长
    public function SetMainParent(){
        //获取参数
        $studentid=Intval(I('studentid'));
        $userid=Intval(I('userid'));
        if($studentid && $userid){
            $family_model=M('relation_stu_user');
            //查询表中是否有本学生的家长已经设置为主号家长
            $where["studentid"]=$studentid;
            $where["type"]=1;
            $main_parent=$family_model
            ->where($where)
            ->find();
            if(empty($main_parent)){
                //如果没有,设置获取到的userid为主号家长
                $where_data["studentid"]=$studentid;
                $where_data["userid"]=$userid;
                $data["type"]=1;
                $main_data=$family_model->where($where_data)->save($data);
            }else{
                //如果有,现将现有的主号家长type改为0,再将获取到的userid设置为主号家长
                $data_updata["type"]=0;
                $main_update=$family_model->where($where)->save($data_updata);
                $where_a["studentid"]=$studentid;
                $where_a["userid"]=$userid;
                $data_a["type"]=1;
                $main_save=$family_model->where($where_a)->save($data_a);
            }
            $ret = $this->format_ret(1,"设置成功"); 
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //获取学生所在班级内其他学生的主号家长列表
    public function GetParentList(){
        $studentid=Intval(I('studentid'));
        if($studentid){
            $parent_relation_model=M('relation_stu_user');
            $parent_info_model=M('wxtuser');
            $class_model=M('class_relationship');
            $classlist = $class_model
            ->alias("a")
            ->join("wxt_school_class c ON c.id=a.classid")
            ->field("a.classid,c.classname")
            ->where("a.userid=$studentid")
            ->order("userid desc")
            ->select();
            foreach ($classlist as &$studen) {
                $classid=$studen["classid"];
                $where["c.classid"]=$classid;
                // $where["r.type"]=1;
                $stu_par_list=$class_model
                ->alias("c")
                ->join("wxt_wxtuser r ON c.userid=r.id")
                ->where($where)
                ->field("r.id,r.name,r.photo")
                ->select();
                foreach ($stu_par_list as &$parent) {
                    $student_id=$parent["id"];
                    $parent_info=$parent_relation_model
                    ->alias("p")
                    ->join("wxt_wxtuser w ON p.userid=w.id")
                    ->field("w.id,w.name,w.photo,w.phone,p.appellation")
                    ->where("p.studentid=$student_id")
                    ->select();
                    $parent["parent_info"]=$parent_info;
                }
                $studen["stu_par_list"]=$stu_par_list;
            }
            if($classlist){
                $ret = $this->format_ret(1,$classlist); 
            }else{
                $ret = $this->format_ret(0,"获取失败");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //获取家人列表
    public function GetInviteFamily(){
        $studentid=Intval(I('studentid'));
        if($studentid){
            $parent_model=M('wxtuser');
            $appellation_model=M('relation_stu_user');
            $appellation_info=$appellation_model->field("appellation,userid,type")->where("studentid=$studentid")->select();
            foreach ($appellation_info as &$appellationlist) {
                $parent_info=$parent_model
                ->field("name,phone,photo")
                ->where(array("id"=>$appellationlist['userid']))
                ->select();
                $appellationlist["parent_info"]=$parent_info;
                unset($appellationlist);
            }
            $ret = $this->format_ret(1,$appellation_info); 
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;  
    }
    //删除家人
    public function DeleteFamily(){
        $studentid=Intval(I('studentid'));
        $userid=Intval(I('userid'));
        if($studentid && $userid){
            $family_model=M('relation_stu_user');
            $where["studentid"]=$studentid;
            $where["userid"]=$userid;
            $family_delete=$family_model->where($where)->delete();
            if($family_delete){
                $ret = $this->format_ret(1,$family_delete); 
            }else{
                $ret = $this->format_ret(0,"删除失败");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    
    // public function GetBabyInfo(){
    //     $studentid = intval(I('studentid'));
    //     if($studentid){
    //         $baby_model=M('babyupdate');
    //         $user_model=M('wxtuser');
    //         $parent_model=M('relation_stu_user');
    //         $class_model=M('class_relationship');
    //         $babyinfo=$baby_model->where("studentid=$studentid")->select();
    //         $where['studentid']=$studentid;
    //         $where['relation_rank']=1;
    //         $parentinfo=$parent_model->field("userid")->where($where)->select();
    //         foreach ($babyinfo as &$user) {
    //             $userinfo=$user_model
    //             ->field("name, sex,birthday,photo")
    //             ->where(array("id"=>$user['studentid']))
    //             ->select();
    //             $user["babylist"]=$userinfo;               
    //             $class=$class_model
    //             ->alias("c")
    //             ->join("wxt_school_class s ON c.classid=s.id")
    //             ->where("c.userid=$studentid")
    //             ->field("s.classname,s.id")
    //             ->select();
    //             $user["classname"]=$class;
    //             unset($user);
    //         }
    //         foreach ($parentinfo as &$parent) {
    //             $parent_id=$parent['userid'];
    //             $parent_info=$user_model->field("name,photo,phone,sex")->where(array("id"=>$parent_id))->find();
    //             $parent["parentname"]=$parent_info["name"];
    //             $parent["parentphoto"]=$parent_info["photo"];
    //             $parent["parentphone"]=$parent_info["phone"];
    //             $parent["parentsex"]=$parent_info["sex"];
    //         }
    //         // var_dump($parent_info);
    //         $babyinfo["parentlist"]=$parentinfo;
    //         if($babyinfo){
    //             $ret = $this->format_ret(1,$babyinfo);
    //         }else{
    //             $ret = $this->format_ret(0,"param lost");
    //         }
    //     }else{
    //         $ret = $this->format_ret(0,"数据获取失败");
    //     }
    //     echo json_encode($ret);
    //      exit;
    // }
    //家长-获取宝宝资料
    public function GetBabyInfo(){
        $studentid = intval(I('studentid'));
        if($studentid){
            $baby_model=M('babyupdate');
            $user_model=M('wxtuser');
            $parent_model=M('relation_stu_user');
            $class_model=M('class_relationship');
            $babylist=$user_model
            ->field("name, sex,birthday,photo as avatar")
            ->where("id=$studentid")
            ->select();
            foreach ($babylist as &$other) {
                $babyinfo=$baby_model->where("studentid=$studentid")->find();
                if($babyinfo){
                    $other["hobby"]=$babyinfo["hobby"];
                    $other["address"]=$babyinfo["address"];
                    $other["delivery"]=$babyinfo["delivery"];
                    $other["photo"]=$babyinfo["photo"];
                    $other["motherpro"]=$babyinfo["motherpro"];
                    $other["withmother"]=$babyinfo["withmother"];
                    $other["fatherpro"]=$babyinfo["fatherpro"];
                    $other["withfather"]=$babyinfo["withfather"];
                }else{
                    $other["hobby"]="";
                    $other["address"]="";
                    $other["delivery"]="";
                    $other["photo"]="";
                    $other["motherpro"]="";
                    $other["withmother"]="";
                    $other["fatherpro"]="";
                    $other["withfather"]="";
                }
                $class=$class_model
                ->alias("c")
                ->join("wxt_school_class s ON c.classid=s.id")
                ->where("c.userid=$studentid")
                ->field("s.classname,s.id")
                ->find();
                if($class){
                    $other["classid"]=$class["id"];
                    $other["classname"]=$class["classname"];
                }else{
                    $other["classid"]="";
                    $other["classname"]="";
                }
                $where['p.studentid']=$studentid;
                $where['p.relation_rank']=1;
                $parentinfo=$parent_model
                ->alias("p")
                ->join("wxt_wxtuser w ON p.userid=w.id")
                ->where($where)
                ->field("w.id as parentid,w.name as parent_name,w.photo as parent_photo,w.phone as parent_phone,w.sex as parent_sex")
                ->select();
                $other["parentinfo"]=$parentinfo;
            }
            if($babylist){
                $ret = $this->format_ret(1,$babylist);
            }else{
                $ret = $this->format_ret(0,"param lost");
            }
        }else{
                $ret = $this->format_ret(0,"未获取到数据");
        }
        echo json_encode($ret);
        exit;
    }
    /**
    *家长-修改宝宝资料［宝宝.爸爸.妈妈头像］
    **/
    public function UpdateUserAvatar(){
        $userid = intval(I('userid'));
        $avatar = I('avatar');
      if((!empty($userid)) ) {
            if ($avatar) {
                $data['photo'] = $avatar;
            }
            $User = M("wxtuser");
            $User->where("id=$userid")->save($data);
            $ret = $this->format_ret(1,$studenti);
        }
        else
        {
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    /**
    *家长-修改宝宝资料［生日］
    **/
    public function UpdateBirth(){
        $studentid = intval(I('studentid'));
        $birthday = I('birthday');
      if((!empty($studentid)) ) {
            if ($birthday) {
                $data['birthday'] = $birthday;
            }
            $User = M("wxtuser");
            $User->where("id=$studentid")->save($data);
            $ret = $this->format_ret(1,$studentid);
        }
        else
        {
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    /**
    *家长-修改宝宝资料［爱好］
    **/
    public function UpdateHobby(){
        $studentid = intval(I('studentid'));
        $hobby = I('hobby');
      if((!empty($studentid))){
        $User = M("babyupdate");
        $student=$User->where("studentid=$studentid")->find();
        if(!$student){
            if ($hobby) {
                $data['hobby'] = $hobby;
                $data['studentid']=$studentid;
            }
            $User->add($data);
            $ret = $this->format_ret(1,"add success");
        }else{
            if ($hobby) {
                $data['hobby'] = $hobby;
            }
            $User->where('studentid='.$studentid)->save($data);
            $ret = $this->format_ret(1,"save success");
        }
        }
        else{
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    /**
    *家长-修改宝宝资料［家庭住址］
    **/
    public function UpdateAddress(){
        $studentid = intval(I('studentid'));
        $address = I('address');
      if((!empty($studentid))){
        $User = M("babyupdate");
        $student=$User->where("studentid=$studentid")->find();
        if(!$student){
            if ($address) {
                $data['address'] = $address;
                $data['studentid']=$studentid;
            }
            $User->add($data);
            $ret = $this->format_ret(1,"add success");
        }else{
            if ($address) {
                $data['address'] = $address;
            }
            $User->where('studentid='.$studentid)->save($data);
            $ret = $this->format_ret(1,"save success");
        }
        }
        else{
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    /**
    *家长-修改宝宝资料［接送人］
    **/
    public function UpdateDelivery(){
        $studentid = intval(I('studentid'));
        $delivery = I('delivery');
      if((!empty($studentid))){
        $User = M("babyupdate");
        $student=$User->where("studentid=$studentid")->find();
        if(!$student){
            if ($delivery) {
                $data['delivery'] = $delivery;
                $data['studentid']=$studentid;
            }
            $User->add($data);
            $ret = $this->format_ret(1,"add success");
        }else{
            if ($delivery) {
                $data['delivery'] = $delivery;
            }
            $User->where('studentid='.$studentid)->save($data);
            $ret = $this->format_ret(1,"save success");
        }
        }
        else{
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    /**
    *家长-修改宝宝资料［全家福］
    **/
    public function UpdatePhoto(){
        $studentid = intval(I('studentid'));
        $photo = I('photo');
      if((!empty($studentid))){
        $User = M("babyupdate");
        $student=$User->where("studentid=$studentid")->find();
        if(!$student){
            if ($photo) {
                $data['photo'] = $photo;
                $data['studentid']=$studentid;
            }
            $User->add($data);
            $ret = $this->format_ret(1,"add success");
        }else{
            if ($photo) {
                $data['photo'] = $photo;
            }
            $User->where('studentid='.$studentid)->save($data);
            $ret = $this->format_ret(1,"save success");
        }
        }
        else{
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    /**
    *家长-修改宝宝资料［妈妈职业］
    **/
    public function UpdateMoProfession(){
        $studentid = intval(I('studentid'));
        $motherpro = I('motherpro');
      if((!empty($studentid))){
        $User = M("babyupdate");
        $student=$User->where("studentid=$studentid")->find();
        if(!$student){
            if ($motherpro) {
                $data['motherpro'] = $motherpro;
                $data['studentid']=$studentid;
            }
            $User->add($data);
            $ret = $this->format_ret(1,"add success");
        }else{
            if ($motherpro) {
                $data['motherpro'] = $motherpro;
            }
            $User->where('studentid='.$studentid)->save($data);
            $ret = $this->format_ret(1,"save success");
        }
        }
        else{
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    /**
    *家长-修改宝宝资料［喜欢喝妈妈做什么］
    **/
    public function UpdateWithMother(){
        $studentid = intval(I('studentid'));
        $withmother = I('withmother');
      if((!empty($studentid))){
        $User = M("babyupdate");
        $student=$User->where("studentid=$studentid")->find();
        if(!$student){
            if ($withmother) {
                $data['withmother'] = $withmother;
                $data['studentid']=$studentid;
            }
            $User->add($data);
            $ret = $this->format_ret(1,"add success");
        }else{
            if ($withmother) {
                $data['withmother'] = $withmother;
            }
            $User->where('studentid='.$studentid)->save($data);
            $ret = $this->format_ret(1,"save success");
        }
        }
        else{
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    /**
    *家长-修改宝宝资料［爸爸职业］
    **/
    public function UpdateFaProfession(){
        $studentid = intval(I('studentid'));
        $fatherpro = I('fatherpro');
      if((!empty($studentid))){
        $User = M("babyupdate");
        $student=$User->where("studentid=$studentid")->find();
        if(!$student){
            if ($fatherpro) {
                $data['fatherpro'] = $fatherpro;
                $data['studentid']=$studentid;
            }
            $User->add($data);
            $ret = $this->format_ret(1,"add success");
        }else{
            if ($fatherpro) {
                $data['fatherpro'] = $fatherpro;
            }
            $User->where('studentid='.$studentid)->save($data);
            $ret = $this->format_ret(1,"save success");
        }
        }
        else{
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    /**
    *家长-修改宝宝资料［喜欢和爸爸做什么］
    **/
    public function UpdateWithFather(){
        $studentid = intval(I('studentid'));
        $withfather = I('withfather');
      if((!empty($studentid))){
        $User = M("babyupdate");
        $student=$User->where("studentid=$studentid")->find();
        if(!$student){
            if ($withfather) {
                $data['withfather'] = $withfather;
                $data['studentid']=$studentid;
            }
            $User->add($data);
            $ret = $this->format_ret(1,"add success");
        }else{
            if ($withfather) {
                $data['withfather'] = $withfather;
            }
            $User->where('studentid='.$studentid)->save($data);
            $ret = $this->format_ret(1,"save success");
        }
        }
        else{
            $ret = $this->format_ret(0,"param lost");
        }
         echo json_encode($ret);
         exit;      
    }
    //家长端获取老师点评
    public function GetTeacherComment(){
        $studentid = Intval(I('studentid'));
        $begintime = I('begintime');
        $endtime = I('endtime');
        if($studentid){
            $comment_model=M('teacher_comment');
            $where["c.studentid"]=$studentid;
            $where["c.comment_time"]= array(array('EGT',$begintime),array('ELT',$endtime));
            $comments=$comment_model
            ->alias("c")
            ->join("wxt_wxtuser w on c.teacher_id=w.id")
            ->where($where)
            ->field("c.*,w.name as teacher_name,w.photo as teacher_photo")
            ->select();
            if ($comments) {
                $ret = $this->format_ret(1,$comments);
            }else{
                $ret = $this->format_ret(0,"评论失败");
            }
        }else{
            $ret = $this->format_ret(0,"获取评论失败");
            }
        echo json_encode($ret);
        exit;
    }
    //发起好友申请
    public function addfriend(){
        //获取用户id和好友id
        $studentid = Intval(I('studentid'));
        $friendid = Intval(I('friendid'));
        //如果两个id都不为空
        if($studentid && $friendid){
            $friend_model = M('friendship');
            //在好友表中通过获取到的$studentid获取到对应的friendid
            //用于判断表中对应的friendid与$friendid是否相等
            $relation=$friend_model
            ->where("studentid=$studentid")
            ->field('friendid')
            ->find();
            //返回的是数组,无法比较是否相等,用foreach转换为字符串,然后用settype函数将字符串转换为int型
            foreach ($relation as &$reinfo) {
                $relationid = settype($reinfo,"integer");
            }
            //用已经转换为int型的friendid与从前台获取的$friendid相比较
            //如果不相等,则把获取到的两个id和当前系统时间存到表中
            if($reinfo!=$friendid){
                $dataarray = array(
                'studentid'=>$studentid,
                'friendid'=>$friendid,
                'create_time'=>time()
                );
                $ship = $friend_model->add($dataarray);
                if($ship){
                $ret = $this->format_ret(1,$ship);
                }else{
                    $ret = $this->format_ret(0,"add error");
                }
            //如果两id相等,则表示两个人已经是好友关系了
            }else{
                $ret = $this->format_ret(0,"已经是好友了!");
            } 

        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;          
    }
    //获取宝宝好友
    public function getfriendlist(){
    	$studentid = Intval(I('studentid'));
		if($studentid){
			$User = M("Wxtuser");
			$Ship = M("Friendship");
			$userinfo = $User;
			$lists=$User
			 ->field('id,name,photo')
			 // ->join("wxt_Wxtuser a ON f.studentid = a.id")
			 ->where("id in(select friendid from wxt_friendship where studentid = $studentid) ")
			 ->order("id DESC")
			 ->select();
             foreach ($lists as &$blog) {
                $studentid=$blog["id"];
                $where["userid"]=$studentid;
                $where["type"]=7;
                $blog_coutn=M('microblog_main')->where($where)->count();
                $blog["blog_coutn"]=$blog_coutn;
                unset($blog);
             }
			$ret = $this->format_ret(1,$lists);			
		}
		else
		{
			$ret = $this->format_ret(0,"lost params");	
		}

		echo json_encode($ret);
		exit;

    }
    //获取宝宝自己的成长足迹
    public function GetSelfGrow(){
        $studentid=Intval(I('studentid'));
        if($studentid){
            $microblog_model=M('microblog_main');
            $comment_model = M('comments');//评论表
            $like_model=M('likes');
            $where["m.userid"]=$studentid;
            $where["m.type"]=7;
            $microblog_list=$microblog_model
            ->alias("m")
            ->join("wxt_wxtuser w ON m.userid=w.id")
            ->where($where)
            ->order("write_time DESC")
            ->field("m.*,w.name,w.photo")
            ->select();
            foreach ($microblog_list as &$like_com) {
                $refid=$like_com["mid"];
                $like_return = $like_model->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where("wxt_likes.refid = $refid")
                    ->order('likeid ASC')
                    ->field('userid,photo as avatar,wxt_wxtuser.name')
                    ->select();
                $comment_return = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where("wxt_comments.refid = $refid")
                    ->order('wxt_comments.add_time DESC')
                    ->field('userid,wxt_wxtuser.photo as avatar,wxt_wxtuser.name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                    ->select();
                $like_com['comment']=$comment_return;
                $like_com['like']=$like_return;
                //获取图片
                $pic=M('microblog_picture_url')->field("pictureurl")->where(array("microblogid"=>$like_com["mid"]))->select();
                $like_com['pic']=$pic;
                for ($j=0; $j < count($pic); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                    $like_com['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $like_com['pic'][$j]["pictureheight"]=$imagesize["1"];
                }
            }
            if($microblog_list){
                $ret = $this->format_ret(1,$microblog_list); 
            }else{
                $ret = $this->format_ret(0,"未获取到数据");
            }
        }else{
                $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //获取宝宝好友的成长足迹
    public function GetFriendsGrow(){
        $studentid=Intval(I('studentid'));
        if($studentid){
            $firend_model=M('friendship');
            $microblog_model=M('microblog_main');
            $comment_model = M('comments');//评论表
            $like_model=M('likes');
            $friend_list=$firend_model
            ->alias("f")
            ->join("wxt_wxtuser w ON f.friendid=w.id")
            ->field("f.friendid,w.name,w.photo,w.phone")
            ->where("studentid=$studentid")
            ->select();
            foreach ($friend_list as &$microblog) {
                $friendid=$microblog["friendid"];
                $where["userid"]=$friendid;
                $where["type"]=7;
                $microblog_info=$microblog_model->where($where)->order("mid")->select();
                foreach ($microblog_info as &$like_com) {
                    $refid=$like_com["mid"];
                    $like_return = $like_model->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                        ->where("wxt_likes.refid = $refid")
                        ->order('likeid ASC')
                        ->field('userid,photo as avatar,wxt_wxtuser.name')
                        ->select();
                    $comment_return = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                        ->where("wxt_comments.refid = $refid")
                        ->order('wxt_comments.add_time DESC')
                        ->field('userid,wxt_wxtuser.photo as avatar,wxt_wxtuser.name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                        ->select();
                    $like_com['comment']=$comment_return;
                    $like_com['like']=$like_return;
                    //获取图片
                    $pic=M('microblog_picture_url')->field("pictureurl")->where(array("microblogid"=>$like_com["mid"]))->select();
                    $like_com['pic']=$pic;
                    for ($j=0; $j < count($pic); $j++) { 
                        # code...
                        $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                        $like_com['pic'][$j]["picturewidth"]=$imagesize["0"];
                        $like_com['pic'][$j]["pictureheight"]=$imagesize["1"];
                    }
                }
                $microblog["microblog_info"]=$microblog_info;
                unset($microblog);
            }
            if($friend_list){
                $ret = $this->format_ret(1,$friend_list); 
            }else{
                $ret = $this->format_ret(0,"未获取到数据");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //获取待确认信息
    public function gettransportconfirmation(){
        //获取学生id
        $studentid = Intval(I('studentid'));
        //如果学生id不为空
        if($studentid){
            $collect = M("student_delivery");
            //获取student_delivery表中各字段值
            $lists = $collect
            ->field('delivery_id as id,schoolid,teacherid,studentid,content,photo,delivery_time,delivery_status,parenttime')
            ->where("studentid=$studentid")
            ->order("delivery_time desc")
            ->select();
            $user_model = M("wxtuser");
            //用foreach获取老师,家长,学生,学校的信息
            foreach ($lists as &$collect ) {
                $schoolid=$collect["schoolid"];
                $teacherid = $collect["teacherid"];
                $parentid = $collect["parentid"];
                $teacher = $user_model->field("name,phone,photo")->where("id=$teacherid")->find();
                if($schoolid){
                    $school=M('school')->field("school_name")->where("schoolid=$schoolid")->find();
                    $collect['schoolname']=$school['school_name'];
                }else{
                    $collect['schoolname']="";
                }
                if($teacher){
                    $collect['teachername']=$teacher["name"];
                    $collect['teacheravatar']=$teacher["photo"];
                    $collect['teacherphone']=$teacher["phone"];
                }else{
                    $collect['teachername']="";
                    $collect['teacheravatar']="default.png";
                    $collect['teacherphone']="";      
                }
                $teacher_duty=M("duty_teacher")
                ->alias("t")
                ->join("wxt_duty d ON t.duty_id=d.id")
                ->where("t.teacher_id=$teacherid")
                ->field("d.name")
                ->find();
                if($teacher_duty){
                    $collect['teacher_duty']=$teacher_duty["name"];
                }else{
                    $collect['teacher_duty']="";
                }
                if($parentid){
                    $parent = $user_model->field("name,phone,photo")->where("id=$parentid")->find();
                    if($parent){
                        $collect['parentname']=$parent["name"];
                        $collect['parentavatar']=$parent["photo"];
                        $collect['parentphone']=$parent["phone"];
                    }else{
                         $collect['parentname']="";
                        $collect['parentavatar']="default.png";
                        $collect['parentphone']="";
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
    //回复待接信息
    public function confirmtransport(){
        $collectid = intval(I('transportid'));
        $parentid = intval(I('parentid'));
        $status = intval(I('status'));
        if($parentid && $collectid){
            $collect = M("student_delivery");
            $dataarray = array(
                "parentid"=>$parentid,
                "delivery_status"=>$status,
                "parenttime"=>time());
            $collect->where('delivery_id='.$collectid)->save($dataarray);
            $ret = $this->format_ret(1,'success');
            $teacher=$collect->where('delivery_id='.$collectid)->getField("teacherid");
            $rs = $this->tjiguang("您收到一条新的代接确认回复消息,请注意查收!","delivery",array($teacher),'',0);
        }
        else{
            $ret = $this->format_ret(0,'lost params');
        }
        echo json_encode($ret);
        exit;
    }
    //家长端-获取班级活动信息
    public function getactivitylist(){
        //传入接收人id
        $receiverid=Intval(I('receiverid'));
        //获取接收表中对应接收id的信息
        $receive=M('activity_receive')
        ->field("id,activity_id,receiverid,read_time")
        ->where("receiverid=$receiverid")
        ->order("id ASC")
        ->select();
        //通过获取到的activity_id在主表中查询出对应的活动信息
        foreach ($receive as &$activity) {
            $active_id=$activity['activity_id'];
            $active=M('activity')
            ->field("id,userid,classid,title,content,contactman,contactphone,begintime,endtime,starttime,finishtime,isapply,create_time")
            ->where("id=$active_id")
            ->select();
            foreach ($active as &$activeinfo) {
                $user_id=$activeinfo['userid'];
                $active_info=M('wxtuser')->field("name,photo")->where("id=$user_id")->select();
                $activeinfo['user_info']=$active_info;
            }
            $activity['activity_list']=$active;
            //获取图片
            $pic=M('activity_pic')->field("picture_url")->where(array("activity_id"=>$activity['activity_id']))->select();
            $activity['pic']=$pic;
             for ($j=0; $j < count($pic); $j++) { 
                # code...
                $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                $activity['pic'][$j]["picturewidth"]=$imagesize["0"];
                $activity['pic'][$j]["pictureheight"]=$imagesize["1"];
            }
            //报名列表
            $apply_model=M('entryactivity');
            $apply_count = $apply_model->field("userid")->distinct(true)->where("activityid=$active_id")->select();
            $activity["apply_count"]=$apply_count;
            unset($activity);
        }
        if($receive){
            $ret = $this->format_ret(1,$receive);
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }  
        echo json_encode($ret);
        exit; 
    }
   //学生-获取作业信息
    public function gethomeworkmessage(){
        $receiverid = Intval(I('receiverid'));
        $receive=M('homework_receive')
        ->alias("a")
        ->join("wxt_homework b ON a.homework_id=b.id")
        ->order("b.create_time DESC")
        ->distinct(true)
        ->field("a.id,homework_id,receiverid,read_time")
        ->where("receiverid=$receiverid")
        // ->order("id DESC")
        ->select();
        foreach ($receive as &$homework) {
            $send_message=M('homework_receive')
            ->alias("r")
            ->join("wxt_homework u ON r.homework_id=u.id")
            ->field("u.id,u.title,u.userid,u.subject,u.content,u.create_time")
            ->distinct(true)
            ->order("u.create_time ASC")
            ->where(array("u.id"=>$homework['homework_id']))
            ->select();
            foreach ($send_message as &$name) {
                $username=M('wxtuser')->field("name,photo")->where(array("id"=>$name['userid']))->find();
                $name['name']=$username['name'];
                $name['photo']=$username['photo'];
            }
            $homework["homework_info"]=$send_message;
            //获取接收人列表
            $receive_list=M('homework_receive')
            ->alias("h")
            ->join("wxt_wxtuser w ON h.receiverid=w.id")
            ->where(array("h.homework_id"=>$homework['homework_id']))
            ->field("w.name,w.photo,w.phone,h.receiverid,h.read_time")
            ->select();
            $homework["receive_list"]=$receive_list;
            //获取图片
            $pic=M('homework_pic')->field("picture_url")->where(array("homework_id"=>$homework['homework_id']))->select();
            $homework['picture']=$pic;
             for ($j=0; $j < count($pic); $j++) { 
                # code...
                $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                $homework['picture'][$j]["picturewidth"]=$imagesize["0"];
                $homework['picture'][$j]["pictureheight"]=$imagesize["1"];
            }
            unset($homework);
        }
        if($receive){
            $ret = $this->format_ret(1,$receive);
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }  
        echo json_encode($ret);
    exit;   
    }
    //用户读取班级作业时间
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
    //获取班级列表
    public function getclasslist(){
        $studentid = Intval(I('studentid'));
        if($studentid ){
            $class_relationship = M("class_relationship");
            $lists = $class_relationship
            ->join("wxt_school_class ON wxt_class_relationship.classid = wxt_school_class.id")
            ->field("classid,classname,userid,wxt_school_class.create_time")
            ->where("wxt_class_relationship.userid = $studentid and wxt_class_relationship.type=1 ")
            ->select();
            $ret = $this->format_ret(1,$lists); 
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;           
    }
    //获取班级内老师的通讯录
    public function getclassteacherlist(){
        $studentid = Intval(I('studentid'));
        $classid = Intval(I('classid'));
        if($studentid && $classid){
            $teacher_class_model = M('teacher_class');
            $lists = $teacher_class_model
             ->alias("t")
             ->join("wxt_wxtuser u ON t.teacherid=u.id")
             ->where("t.classid = $classid AND t.status=1")
             ->field('u.id,u.name,u.phone')
             ->select();
             $user_model = M("wxtuser");
            foreach ($lists as &$teacher) {
                $teacherid = $teacher["id"];
                $userinfo = $user_model
                ->field("photo")
                ->where("id=$teacherid")
                ->find();
                $teacher["avatar"]=$userinfo["photo"];
                unset($teacher);
            }
            $ret = $this->format_ret(1,$lists); 
        }
        else
        {
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;           
    }
     //发起家长叮嘱
    public function addentrust(){
        $studentid = Intval(I('studentid'));
        $userid = Intval(I('userid'));
        $teacherid = Intval(I('teacherid'));
        $content = I('content');
        $teacherid_arr[]=$teacherid;
        if($studentid && $userid &&(!empty($content))){
            $trust_model = M('entrust');
            $dataarray = array(
                'userid'=>$userid,
                'studentid'=>$studentid,
                'teacherid'=>$teacherid,
                'content'=>$content,
                'create_time'=>time()
                );
            $trustid = $trust_model->add($dataarray);
            //图片存入表中
            $pic_model=M('trust_pic');
            $pic=I('picture_url');
            $pic_arr=explode(",",$pic);
            //去掉数组中的空格位置
            $pic_arr = array_filter($pic_arr);
            for ($i=0; $i < count($pic_arr); $i++) {
                $pic_add=$pic_model->add(array("trust_id"=>$trustid,"picture_url"=>$pic_arr[$i]));
            }
            if($trustid){
                $ret = $this->format_ret(1,$trustid);
                $rs = $this->tjiguang("您收到一条新的家长叮嘱消息,请注意查收!","trust",$teacherid_arr,'',0);
            }
            else
            {
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
    //家长获取家长叮嘱列表
    public function getentrustlist(){
        $userid = Intval(I('userid'));
        $studentid = Intval(I('studentid'));
        if($userid){
         $trust_model = M('entrust');
         $list = $trust_model
         ->field("id,userid,studentid,teacherid,content,create_time,feedback,feed_time")
         ->where("userid=$userid")
         ->order("id desc")
         ->select();
         $user_model=M('wxtuser');
         $comment_model = M('comments');//评论表
            foreach ($list as &$entrust ) {
                $refid =$entrust["id"];
                $entrust['username']="";
                $entrust['studentname']="";
                $entrust['teachername']="";
                $entrust['teacheravatar']="";
                $entrust['studentavatar']="";
                $teacherid=$entrust["userid"];
                $studentid=$entrust["studentid"];
                $teacher = $user_model->field("name,phone,photo")->where("id=$teacherid")->find();
                if($teacher){
                    $entrust['teachername']=$teacher["name"];
                    $entrust['teacheravatar']=$teacher["photo"];
                }
                $student =$user_model->field("name,phone,photo")->where("id=$studentid")->find();
                if($student){
                    $entrust['studentname']=$student["name"];
                    $entrust['studentavatar']=$student["photo"];
                }
                $comment_return = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                ->where("wxt_comments.refid = $refid and type='4'")
                ->order('wxt_comments.id ASC')
                ->field('userid,wxt_wxtuser.photo as avatar,wxt_wxtuser.name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                ->select();
                $entrust['comment']=$comment_return;
                //获取图片
                $pic=M('trust_pic')->field("picture_url")->where(array("trust_id"=>$entrust['id']))->select();
                $entrust['pic']=$pic;
                for ($j=0; $j < count($pic); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["picture_url"]);
                    $entrust['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $entrust['pic'][$j]["pictureheight"]=$imagesize["1"];
                }
                unset($entrust);
            }         
            $ret = $this->format_ret(1,$list);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;           
    }
    //家长发起请假
    public function addleave(){
        $studentid = Intval(I('studentid'));
        $parentid = Intval(I("parentid"));
        $teacherid = Intval(I("teacherid"));
        $begintime = I("begintime");
        $endtime = I("endtime");
        $reason = I("reason");
        $leavetype = I("leavetype");
        if($parentid && $teacherid && $studentid){
            $dataarray = array(
                "studentid"=>$studentid,
                "userid"=>$parentid,
                "teacherid"=>$teacherid,
                "begintime"=>$begintime,
                "endtime"=>$endtime,
                "reason"=>$reason,
                "leavetype"=>$leavetype,
                "create_time"=>time());
            $leave_model = M("leave");
            $leave_id=$leave_model->add($dataarray);
            //图片存入表中
            $pic_model=M('leave_pic');
            $pic=I('picture_url');
            $pic_arr=explode(",",$pic);
            //去掉数组中的空格位置
            $pic_arr = array_filter($pic_arr);
            for ($i=0; $i < count($pic_arr); $i++) {
                $pic_model->add(array("leave_id"=>$leave_id,"picture_url"=>$pic_arr[$i]));
            }
            if($leave_id){
                $ret = $this->format_ret(1,$leave_id);
                $rs = $this->tjiguang("您收到一条新的请假信息,请注意查收!","leave",array($teacherid),'',0);
            }else{
                $ret = $this->format_ret(0,"add error");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;   
    }
    //获取请假列表
    public function getleavelist(){
        $studentid = Intval(I("studentid"));
        if($studentid){
            $leave_model = M("leave");
            $lists = $leave_model
            ->field('id,studentid,userid as parentid,teacherid,create_time,begintime,endtime,reason,leavetype,status,feedback,deal_time')
            ->where("studentid=$studentid")
            ->order("id desc")
            ->select();
            $user_model = M("wxtuser");
            $class_model=M("class_relationship");
            foreach ($lists as &$leave ) {
                $teacherid = $leave["teacherid"];
                $parentid = $leave["parentid"];
                $student_id = $leave["studentid"];
                $student_class=$class_model
                    ->alias("a")
                    ->join("wxt_school_class u ON a.classid=u.id")
                    ->field("u.classname")
                    ->where("a.userid=$studentid")
                    ->find();
                $teacher = $user_model->field("name,phone,photo")->where("id=$teacherid")->find();
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
                    }
                }
                if($studentid){
                    $student = $user_model->field("name,phone,photo")->where("id=$studentid")->find();
                    if($student){
                        $leave['studentname']=$student["name"];
                        $leave['studentavatar']=$student["photo"];
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
    
    //发布宝贝相册
    public function addbabyalbum(){
        $userid = Intval(I('userid'));
    }
    //获取宝宝相册

  //教师端推送
    function tjiguang($content = "",$m_type='',$receive="",$m_value=""){
        // $receiver = array('alias'=>$receive);
        // $rs=tjpush($content,$m_type,$receiver,'',0);
        // if($rs){
        //     $ret="success";
        // }else{
        //     $ret="error";
        // }
        // return $ret;
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
    // //家长端推送
    // function pjiguang($content = "",$m_type='',$receive="",$m_value="",$istostu=""){
    //     // $receiver = array('alias'=>$receive);
    //     // $rs=ujpush($content,$m_type,$receiver,'',0);
    //     // if($rs){
    //     //     $ret="success";
    //     // }else{
    //     //     $ret="error";
    //     // }
    //     // return $ret;
    //      $recivelist = array();
    //     $ishave=0;
    //     foreach ($receive as &$userid) {
    //         $where['id']=$userid;
    //         $u=M('wxtuser')->where($where)->field('xgtoken')->find();
    //         if(!empty($u['xgtoken'])){
    //            $recivelist[]=$u['xgtoken']; 
    //            $ishave=1;
    //        }
    //     }
    //     if($ishave==1){
    //         $receiver = array('registration_id'=>$recivelist);
    //         $rs=ujpush($content,$m_type,$receiver,$m_value,1);
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
}