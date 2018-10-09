<?php

namespace Apps\Controller;
use Common\Controller\AppBaseController;
/**
 * 首页
 */
class SchoolController extends AppBaseController {
	//首页
	public function index() {
    	die('this is schoolapi');
    }
    public function getCookbookContent(){
        $begindate=I('begindate');
        $endtdate=I('enddate');
        $schoolid=Intval(I('schoolid'));
        if(!empty($begindate) && !empty($schoolid)&& !empty($endtdate)){
            $where="schoolid=$schoolid and date>='$begindate' and date<='$endtdate'";
            $info=M("cookbook") 
            ->field("id,title,content,photo,date,create_time")
            ->where($where)
            ->order("date asc")
            ->select();
            $ret = $this->format_ret(1,$info); 
        }else{
            $ret = $this->format_ret(0,"lost params"); 
        }
        echo json_encode($ret);
        exit;
    }
    //获取学校内老师信息
    public function getteacherinfo(){
        $schoolid = Intval(I('schoolid'));
        if(!empty($schoolid)){
            $where = array('d.schoolid' => $schoolid);
            $appc = M('wxtuser')
            ->alias("w")
            ->join("wxt_duty_teacher d ON w.id=d.teacher_id")
            ->field('w.id,w.photo,w.name,w.phone')
            ->order("id asc")
            ->where($where)
            ->select();   
            $ret = $this->format_ret(1,$appc);      
        }
        else
        {
            $ret = $this->format_ret(0,"lost params");  
        }
        echo json_encode($ret);
        exit;
    } 
    //获取学校内班级列表
    public function getclasslist(){
        $schoolid = Intval(I('schoolid'));
        if(!empty($schoolid)){
            $where = array('schoolid' => $schoolid);
            $appc = M('school_class')->field('id, classname as name')->order("id asc")->where($where)->select();   
            $ret = $this->format_ret(1,$appc);      
        }
        else
        {
            $ret = $this->format_ret(0,"lost params");  
        }
        echo json_encode($ret);
        exit;
    }
    //创建班级
    public function addclass(){
        $schoolid=intval(I('schoolid'));
        $type=intval(I('classtype'));//1=》正常班级，2=>兴趣班级
        $description=I('description');
        $teacherid=intval(I('teacherid'));
        $classname=I('classname');
        if(!empty($schoolid) && !empty($type)){
            $data['schoolid']=$schoolid;
            $data['type']=$type;
            $data['description']=$description;
            $data['classname']=$classname;
            $classid=M('school_class')->add($data);
            if(!empty($teacherid)){
                $relationdata["teacherid"]=$teacherid;
                $relationdata["classid"]=$classid;
                $relationdata["type"]="1";
                $relationdata["schoolid"]=$schoolid;
                $relationid=M('teacher_class')->add($relationdata);
                $ret = $this->format_ret(1,"添加成功");  
            }
            else{
                $ret = $this->format_ret(1,$classid);  
            }
        }else
        {
            $ret = $this->format_ret(0,"lost params");  
        }
        echo json_encode($ret);
        exit;
    }
    // //获取兴趣班级列表-- 可以与获取班级列表整合
    // public function  getInterestClasslistbySchoolid(){
    //     $schoolid=intval(I('schoolid'));
    //     $type=2;
    //     if(!empty($schoolid)){
    //         $where['schoolid']=$schoolid;
    //         $where['type']=$type;
    //         $relation_model=M("teacher_class");
    //         $lists=$relation_model
    //         ->alias("r")
    //         ->join("wxt_school_class as c on c.id=r.classid ")
    //         ->where("r.schoolid=$schoolid and c.type='2'")
    //         ->select();
    //         $ret = $this->format_ret(1,$lists);  
    //     }
    //     else{
    //          $ret = $this->format_ret(0,"lost params");  
    //     }
    //     echo json_encode($ret);
    //     exit;
    // }
    //班级内添加学生
    public function addStudenttoClass(){
        //获取参数
        $studentid=Intval(I('studentid'));
        $classid=Intval(I('classid'));
        $schoolid=Intval(I('schoolid'));
        //参数校验
        if(!empty($studentid) && (!empty($classid))){
            //添加数据
            $class_model=M('class_relationship');
            $data["classid"]=$classid;
            $data["userid"]=$studentid;
            $data["type"]="1";
            $data["schoolid"]=$schoolid;
            $resultid=$class_model->add($data);
            $ret = $this->format_ret(1,$resultid);
        }
        else{
             $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
   //获取班级的学生列表
    public function getStudentlistByClassid(){
        //获取参数
        $classid=Intval(I('classid'));
        if(!empty($classid)){
            $class_model=M('class_relationship');
            $student_model=M('wxtuser');
            $list=$class_model
             ->alias("c")
             ->join("wxt_wxtuser student on c.userid=student.id")
             ->where("c.classid=$classid")
             ->field("student.id as id ,student.name as name,student.sex as sex,student.photo as photo")
             ->select();
            $ret = $this->format_ret(1,$list);
        }else{
            $ret = $this->format_ret(0,"lost params"); 
        }
        echo json_encode($ret);
        exit;       
    }
    //获取班级课表
    // public function ClassSyllabus(){
    //     //获取参数
    //     $school_id = intval(I('schoolid'));
    //     $class_id = intval(I('classid'));
    //     if(!empty($school_id)&&!empty($class_id)){
    //         $class_syllabus_model = M('class_syllabus');
    //         $subject_model=M('default_subject');
    //         //通过获取到的schoolid和classid在class_syllabus查询出对应的七天课程表
    //         $where["schoolid"]=$school_id;
    //         $where["classid"]=$class_id;
    //         $syllabus_data = $class_syllabus_model
    //         ->where($where)
    //         ->order("syllabus_no ASC")
    //         ->field("syllabus_id,schoolid,classid,monday,tuesday,wednesday,thursday,friday,saturday,sunday,syllabus_no")
    //         ->select();
    //         //定义好七天课程的数组,因为需要把每天的八节课放入到一天当中形成一个数组
    //         $lesson_array=array();
    //         $lesson_mon=array();
    //         $lesson_tu=array();
    //         $lesson_we=array();
    //         $lesson_th=array();
    //         $lesson_fri=array();
    //         $lesson_sat=array();
    //         $lesson_sun=array();
    //         //用foreach循环将查询到的每天的八节课放入到对应的周几的数组中
    //         foreach($syllabus_data as $sy){
    //             $lesson_no=$sy['syllabus_no'];
    //             $monday=$subject_model->where(array("id"=>$sy['monday']))->field("subject")->find();
    //             $lesson_mon[]=array($lesson_no=>$monday["subject"]);
    //             $tuesday=$subject_model->where(array("id"=>$sy['tuesday']))->field("subject")->find();
    //             $lesson_tu[]=array($lesson_no=>$tuesday["subject"]);
    //             $wednesday=$subject_model->where(array("id"=>$sy['wednesday']))->field("subject")->find();
    //             $lesson_we[]=array($lesson_no=>$wednesday["subject"]);
    //             $thursday=$subject_model->where(array("id"=>$sy['thursday']))->field("subject")->find();
    //             $lesson_th[]=array($lesson_no=>$thursday["subject"]);
    //             $friday=$subject_model->where(array("id"=>$sy['friday']))->field("subject")->find();
    //             $lesson_fri[]=array($lesson_no=>$friday["subject"]);
    //             $saturday=$subject_model->where(array("id"=>$sy['saturday']))->field("subject")->find();
    //             $lesson_sat[]=array($lesson_no=>$saturday["subject"]);
    //             $sunday=$subject_model->where(array("id"=>$sy['sunday']))->field("subject")->find();
    //             $lesson_sun[]=array($lesson_no=>$sunday["subject"]);
    //         }
    //         //最后将这七个数组放入到一个课程表的数组中完整输出
    //         $lesson_array['mon']=$lesson_mon;
    //         $lesson_array['tu']=$lesson_tu;
    //         $lesson_array['we']=$lesson_we;
    //         $lesson_array['th']=$lesson_th;
    //         $lesson_array['fri']=$lesson_fri;
    //         $lesson_array['sat']=$lesson_sat;
    //         $lesson_array['sun']=$lesson_sun;
    //         $ret = $this->format_ret(1,$lesson_array);
    //     }
    //     echo json_encode($ret);
    //     exit;
    // }
    //获取班级课表
    public function ClassSyllabus(){
        //获取参数
        $school_id = intval(I('schoolid'));
        $class_id = intval(I('classid'));
        if(!empty($school_id)&&!empty($class_id)){
            $class_syllabus_model = M('class_syllabus');
            $subject_model=M('default_subject');
            $subject_data=$subject_model->field("id,subject")->select();
            //通过获取到的schoolid和classid在class_syllabus查询出对应的七天课程表
            $where["schoolid"]=$school_id;
            $where["classid"]=$class_id;
            $syllabus_data = $class_syllabus_model
            ->where($where)
            ->order("syllabus_no ASC")
            ->field("syllabus_id,schoolid,classid,monday,tuesday,wednesday,thursday,friday,saturday,sunday,syllabus_no")
            ->select();
            //定义好七天课程的数组,因为需要把每天的八节课放入到一天当中形成一个数组
            $lesson_array=array();
            $lesson_mon=array();
            $lesson_tu=array();
            $lesson_we=array();
            $lesson_th=array();
            $lesson_fri=array();
            $lesson_sat=array();
            $lesson_sun=array();
            //用foreach循环将查询到的每天的八节课放入到对应的周几的数组中
            foreach($syllabus_data as $sy){
                $lesson_no=$sy['syllabus_no'];
                foreach ($subject_data as &$item) {
                    if($sy['monday']==$item["id"]){
                        $lesson_mon[]=array($lesson_no=>$item["subject"]);
                    }
                    if($sy['tuesday']==$item["id"]){
                        $lesson_tu[]=array($lesson_no=>$item["subject"]);
                    }
                    if($sy['wednesday']==$item["id"]){
                        $lesson_we[]=array($lesson_no=>$item["subject"]);
                    }
                    if($sy['thursday']==$item["id"]){
                        $lesson_th[]=array($lesson_no=>$item["subject"]);
                    }
                    if($sy['friday']==$item["id"]){
                        $lesson_fri[]=array($lesson_no=>$item["subject"]);
                    }
                    if($sy['saturday']==$item["id"]){
                        $lesson_sat[]=array($lesson_no=>$item["subject"]);
                    }
                    if($sy['sunday']==$item["id"]){
                        $lesson_sun[]=array($lesson_no=>$item["subject"]);
                    }
                }
                
            }
            //最后将这七个数组放入到一个课程表的数组中完整输出
            $lesson_array['mon']=$lesson_mon;
            $lesson_array['tu']=$lesson_tu;
            $lesson_array['we']=$lesson_we;
            $lesson_array['th']=$lesson_th;
            $lesson_array['fri']=$lesson_fri;
            $lesson_array['sat']=$lesson_sat;
            $lesson_array['sun']=$lesson_sun;
            $ret = $this->format_ret(1,$lesson_array);
        }
        echo json_encode($ret);
        exit;
    }
    // //try
    // public function addSyllabus(){
    //     //$schoolid = intval(I('schoolid'));
    //     $classid = intval(I('classid'));
    //     $day_lesson=I('monday');
    //     $syllabus_no = I('syllabus_no');
    //     $syllabus_model=M('class_syllabus');
    //     // $lesson=$syllabus_model
    //     // ->field("syllabus_id")
    //     // ->where("classid=$classid AND syllabus_no=$syllabus_no")
    //     // ->find();
    //         $data_add=array(
    //             'classid'=>$classid,
    //             'monday'=>$day_lesson,
    //             'syllabus_no'=>$syllabus_no
    //             );
    //         $lesson_add=$syllabus_model->add($data_add);
    // }
    // //发布班级课表
    // public function addClassSyllabus(){
    //     $schoolid = intval(I('schoolid'));
    //     $classid = intval(I('classid'));
    //     $monday = I('monday');
    //     $tuesday = I('tuesday');
    //     $wednesday = I('wednesday');
    //     $thursday = I('thursday');
    //     $friday = I('friday');
    //     $saturday = I('saturday');
    //     $sunday = I('sunday');
    //     $syllabus_no = I('syllabus_no');
    //     if($classid&&$schoolid){
    //         $dataarray=array(
    //             'schoolid'=>$schoolid,
    //             'classid'=>$classid,
    //             'monday'=>$monday,
    //             'tuesday'=>$tuesday,
    //             'wednesday'=>$wednesday,
    //             'thursday'=>$thursday,
    //             'friday'=>$friday,
    //             'saturday'=>$saturday,
    //             'sunday'=>$sunday,
    //             'syllabus_no'=>$syllabus_no,
    //             );
    //         $syllabus_model=M('class_syllabus');
    //         $syllabuslist = $syllabus_model->add($dataarray);
    //         if($syllabuslist){
    //             $ret = $this->format_ret(1,$syllabuslist);
    //         }else
    //         {
    //             $ret = $this->format_ret(0,"add error");
    //         }
            
    //     }else
    //     {
    //         $ret = $this->format_ret(0,"lost params");
    //     }
    //     echo json_encode($ret);
    //     exit;
    // }
    //获取学校介绍
    public function getschoolinfo(){
        $schoolid = Intval(I('schoolid'));
        if(!empty($schoolid)){
            $where = array('schoolid' => $schoolid);
            $appc = M('school')->field('schoolid, school_name,school_address,school_user,school_phone as phone,introduce as detail,photo')->find();   
            $ret = $this->format_ret(1,$appc);      
        }
        else
        {
            $ret = $this->format_ret(0,"lost params");  
        }
        echo json_encode($ret);
        exit;
    }
    //园区介绍
    public function getWebSchoolInfos(){
        $schoolid=I('schoolid');
        if(!empty($schoolid)){
        $where["schoolid"]=$schoolid;
        $teacherinfo_model=M('schoolinfos');
        $infos=$teacherinfo_model->where($where)->field('id,schoolid,post_title,post_excerpt,post_date,smeta')->select();
        foreach ($infos as  &$val) {
            $smeta=json_decode($val['smeta'],true);
            if(!empty($smeta['thumb'])){
                $val["thumb"]=sp_get_asset_upload_path($smeta['thumb']);
            }else{
                 $val["thumb"]="";
            }
           
        }
        $ret = $this->format_ret(1,$infos);
   }else{
    $ret = $this->format_ret(0,'请输入学校编号');
   }
   echo json_encode($ret);
    exit;

    }
    //校园通知
    public function getSchoolNotices(){
        //获取学校id
        $schoolid=I('schoolid');
        //判断是否获取到schoolid,如果获取到:
        if(!empty($schoolid)){
        $where["schoolid"]=$schoolid;
        //实例化表
        $schoolnotice_model=M('schoolnotice');
        //返回获取到的schoolid所在的信息
        $notice=$schoolnotice_model->where($where)->field('id,schoolid,post_title,post_excerpt,post_date,smeta')->select();
        //遍历数组(每循环一次,notice当前的值就会赋给val)
        foreach ($notice as  &$val) {
        //对smeta进行解码,返回数组
        $smeta=json_decode($val['smeta'],true);
        //如果解码后返回的数组值不为空
        if(!empty($smeta['thumb'])){
            //输出可访问图片的路径
            $val["thumb"]=sp_get_asset_upload_path($smeta['thumb']);
        }else{
            //如果解码后返回的数组值为空,则没有图片
             $val["thumb"]="";
        }

        }
        //数据获取成功
        $ret = $this->format_ret(1,$notice);
        }else{
            //如果未获取到学校id,则失败,并提醒用户
        $ret = $this->format_ret(0,'请输入学校编号');
        }
        //用json的方式返回结果
        echo json_encode($ret);
        exit;    
    }
     //新闻动态
    public function getSchoolNews(){
        $schoolid=I('schoolid');
        if(!empty($schoolid)){
        $where["schoolid"]=$schoolid;
        $schoolnews_model=M('schoolnews');
        $news=$schoolnews_model->where($where)->field('id,schoolid,post_title,post_excerpt,post_date,smeta')->select();
        foreach ($news as  &$val) {
        $smeta=json_decode($val['smeta'],true);
        if(!empty($smeta['thumb'])){
            $val["thumb"]=sp_get_asset_upload_path($smeta['thumb']);
        }else{
             $val["thumb"]="";
        }

        }
        $ret = $this->format_ret(1,$news);
        }else{
        $ret = $this->format_ret(0,'请输入学校编号');
        }
        echo json_encode($ret);
        exit;    
    }
    //育儿知识
    public function getParentsThings(){
        //获取学校id
        $schoolid=I('schoolid');
        //判断是否获取到schoolid,如果获取到:
        if(!empty($schoolid)){
        $where["schoolid"]=$schoolid;
        //实例化表
        $parentsthings_model=M('parentings');
        //返回获取到的schoolid所在的信息
        $parents=$parentsthings_model->where($where)->field('id,schoolid,post_title,post_excerpt,post_date,smeta')->select();
        //遍历数组(每循环一次,notice当前的值就会赋给val)
        foreach ($parents as  &$val) {
        //对smeta进行解码,返回数组
        $smeta=json_decode($val['smeta'],true);
        //如果解码后返回的数组值不为空
        if(!empty($smeta['thumb'])){
            //输出可访问图片的路径
            $val["thumb"]=sp_get_asset_upload_path($smeta['thumb']);
        }else{
            //如果解码后返回的数组值为空,则没有图片
             $val["thumb"]="";
        }

        }
        //数据获取成功
        $ret = $this->format_ret(1,$parents);
        }else{
            //如果未获取到学校id,则失败,并提醒用户
        $ret = $this->format_ret(0,'请输入学校编号');
        }
        //用json的方式返回结果
        echo json_encode($ret);
        exit;    
    }
    //园长信箱
    public function getMailBox(){
        //获取学校id
        $schoolid=I('schoolid');
        //判断是否获取到schoolid,如果获取到:
        if(!empty($schoolid)){
        $where["schoolid"]=$schoolid;
        //实例化表
        $mailbox_model=M('mailbox');
        //返回获取到的schoolid所在的信息
        $mailbox=$mailbox_model->where($where)->field('id,schoolid,userid,message,post_time')->select();
        //数据获取成功
        $ret = $this->format_ret(1,$mailbox);
        }else{
            //如果未获取到学校id,则失败,并提醒用户
        $ret = $this->format_ret(0,'请输入学校编号');
        }
        //用json的方式返回结果
        echo json_encode($ret);
        exit;    
    }
    //创建园长信箱获取的信息
    public function addMailBox(){
        //获取用户传来的信息
        $schoolid=I('schoolid');
        $userid=I('userid');
        $message=I('message');
        $schoolid=I('schoolid');
        $time=I('post_time');
        //如果获取到了schoolid,将获取到的信息添加到表中
        if(!empty($schoolid)){
            $data['schoolid']=$schoolid;
            $data['userid']=$userid;
            $data['message']=$message;
            $data['post_time']=$post_time;
            $mail=M('mailbox')->add($data);
            $ret=$this->format_ret(1,$mail);
            //如果未获取到则失败
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }

    //获取周计划接口
    public function getschoolplan(){
    	$schoolid = Intval(I('schoolid'));
        $classid = Intval(I('classid'));
		if($schoolid&&$classid){
			$where = array('s.schoolid' => $schoolid);
			$appc = M('school_plan')
            ->alias('s')
            ->join("wxt_school_class c ON c.id=s.classid")
            ->field('s.*,c.classname')
            ->where($where)
            ->select(); 
			$ret = $this->format_ret(1,$appc);			
		}
		else
		{
			$ret = $this->format_ret(0,"lost params");	
		}

		echo json_encode($ret);
		exit;
    }
    //发布周计划
    public function publishschoolplan(){
        $schoolid = Intval(I('schoolid'));
        $classid = Intval(I('classid'));
        $userid = Intval(I('userid'));
        $title = I('title');
        $monday = I('monday');
        $tuesday = I('tuesday');
        $wednesday = I('wednesday');
        $thursday = I('thursday');
        $friday = I('friday');
        $saturday = I('saturday');
        $sunday = I('sunday');
        $workpoint = I('workpoint');
        $begintime = I('begintime');
        $endtime = I('endtime');
        if($classid){
            $dataarray=array(
                'schoolid'=>$schoolid,
                'classid'=>$classid,
                'userid'=>$userid,
                'title'=>$title,
                'monday'=>$monday,
                'tuesday'=>$tuesday,
                'wednesday'=>$wednesday,
                'thursday'=>$thursday,
                'friday'=>$friday,
                'saturday'=>$saturday,
                'sunday'=>$sunday,
                'workpoint'=>$workpoint,
                'begintime'=>$begintime,
                'begintime'=>$begintime,
                'create_time'=>time()
                );
            $plan_model=M('school_plan');
            $planlist = $plan_model->add($dataarray);
            if($planlist){
                $ret = $this->format_ret(1,$planlist);
            }else
            {
                $ret = $this->format_ret(0,"publish error");
            }
            
        }else
        {
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;         
    }
    //更新周计划内容
    public function updataschoolplan(){
        $id=Intval(I('id'));
        $userid=Intval(I('userid'));
        $title = I('title');
        $monday = I('monday');
        $tuesday = I('tuesday');
        $wednesday = I('wednesday');
        $thursday = I('thursday');
        $friday = I('friday');
        $saturday = I('saturday');
        $sunday = I('sunday');
        $workpoint = I('workpoint');
        $begintime = I('begintime');
        $endtime = I('endtime');
        $dataarray=array(
                'userid'=>$userid,
                'title'=>$title,
                'monday'=>$monday,
                'tuesday'=>$tuesday,
                'wednesday'=>$wednesday,
                'thursday'=>$thursday,
                'friday'=>$friday,
                'saturday'=>$saturday,
                'sunday'=>$sunday,
                'workpoint'=>$workpoint,
                'begintime'=>$begintime,
                'endtime'=>$endtime,
                );
            $plan_model=M('school_plan');
            $planupdata = $plan_model->where("id=$id")->save($dataarray);
            if($planupdata){
                $ret = $this->format_ret(1,$planupdata);
            }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;   
    }
    //园所情况-班级相册
    public function ClassPicInfo(){
        //获取用户所在学校id
        $schoolid=intval(I("schoolid"));
        if($schoolid){
            $classpic_model=M('microblog_main');
            $class_model=M('school_class');
            $teacher_model=M('teacher_class');
            $where['schoolid']=$schoolid;
            $where['type']=2;
            //在school_class表中查询出本学校都有哪些班
            $class_info=$class_model
            ->field("id,classname")
            ->where("schoolid=$schoolid")
            ->select();
            foreach ($class_info as &$class_num) {
                //通过classid在表中查询出对应班级的信息数量
                $classid=$class_num['id'];
                $where_class['classid']=$class_num['id'];
                $where_class['type']=2;
                $class_count=$classpic_model->where($where_class)->count();
                $class_num['class_count']=$class_count;
                //两表联查查询出每个班的任课老师信息
                $teacher_info=$teacher_model
                ->alias("t")
                ->join("wxt_wxtuser u ON t.teacherid=u.id")
                ->where("t.classid=$classid")
                ->field("id,name,t.classid")
                ->select();
                foreach ($teacher_info as &$teacher) {
                    //通过老师id查询出每个老师发的信息数量
                    $teacherid=$teacher['id'];
                    $where_teacher['userid']=$teacherid;
                    $where_teacher['classid']=$teacher['classid'];
                    $where_teacher['type']=2;
                    $teacher_count=$classpic_model
                    ->where($where_teacher)
                    ->count();
                    $teacher["teacher_count"]=$teacher_count;
                }
                $class_num['teacher_info']=$teacher_info;
                unset($class_num);
            }
            if($class_info){
                $ret = $this->format_ret(1,$class_info);
            }else{
                $ret = $this->format_ret(0,"count error");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //园所情况-班级考勤
    public function StudentAttendanceCount(){
        $schoolid=intval(I("schoolid"));
        $classid=intval(I("classid"));
        $sign_date=I("sign_date");
        if($schoolid){
            $attendance_model=M('attendance');
            $class_model=M('school_class');
            $class_relationship_model=M('class_relationship');
            $leave_model=M('leave');
            //在school_class表中查询出本学校都有哪些班,班里都有哪些学生
            $class_info=$class_model
            ->where("schoolid=$schoolid")
            ->field("id,classname")
            ->select();
            foreach ($class_info as &$class_num) {
                //在class_relationship表中查询出每个班都有多少人
                $classid=$class_num['id'];
                $student_count=$class_relationship_model->where("classid=$classid")->count();
                $class_num['student_count']=$student_count;
                $student_num=settype($student_count,"integer");
                //查询每个学生的姓名和头像
                $student_info=$class_relationship_model
                ->alias("c")
                ->join("wxt_wxtuser w ON c.userid=w.id")
                ->where("c.classid=$classid")
                ->field("w.id,w.name,w.photo")
                ->select();
                foreach ($student_info as &$attendance) {
                    $student_id=$attendance["id"];
                    $where["userid"]=$student_id;
                    $where["sign_date"]=$sign_date;
                    $attendance_info=$attendance_model
                    ->where($where)
                    ->select();
                    $attendance_count=count($attendance_info);
                    $attendance['attendance_count']=$attendance_count;

                    $where_leave["userid"]=$student_id;
                    $where_leave["begintime"]=array("ELT",$sign_date);
                    $where_leave["endtime"]=array("EGT",$sign_date);
                    $where_leave["status"]=1;
                    $leave_info=$leave_model
                    ->where($where_leave)
                    ->count();
                    $attendance['leave_info']=$leave_info;
                }
                $class_num['student_info']=$student_info;
                unset($class_num);
            }
            if($class_info){
                $ret = $this->format_ret(1,$class_info);
            }else{
                $ret = $this->format_ret(0,"count error");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //园所情况-班级活动
    public function ClassActivityCount(){
        //传入schoolid
        $schoolid=intval(I("schoolid"));
        if($schoolid){
            $activity_model=M('activity');
            $department_model=M('department_teacher');
            $teacher_model=M('wxtuser');
            //user表与科室表联查,在科室表中的肯定是老师
            $teacher_info=$teacher_model
            ->alias("w")
            ->join("wxt_department_teacher t ON t.teacher_id=w.id")
            ->distinct(true) //一个老师可能在多个科室,所以取出的id有重复值,用distinct去除重复值
            ->where("t.school_id=$schoolid")
            ->field("w.id,w.name")
            ->select();
            foreach ($teacher_info as &$teacher_num) {
                //在班级活动表中查询出对应老师id所发的信息数量
                $teacherid=$teacher_num['id'];
                $teacher_count=$activity_model
                ->where("userid=$teacherid")
                ->count();
                $teacher_num['teacher_count']=$teacher_count;
                unset($teacher_num);
            }
             if($teacher_info){
                $ret = $this->format_ret(1,$teacher_info);
            }else{
                $ret = $this->format_ret(0,"count error");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //园所情况-老师点评
    public function TeacherCommentCount(){
        //传入schoolid
        $schoolid=intval(I("schoolid"));
        if($schoolid){
            $comment_model=M('teacher_comment');
            $department_model=M('department_teacher');
            $teacher_model=M('wxtuser');
            //user表与科室表联查,在科室表中的肯定是老师
            $teacher_info=$teacher_model
            ->alias("w")
            ->join("wxt_department_teacher t ON t.teacher_id=w.id")
            ->distinct(true) //一个老师可能在多个科室,所以取出的id有重复值,用distinct去除重复值
            ->where("t.school_id=$schoolid")
            ->field("w.id,w.name")
            ->select();
            foreach ($teacher_info as &$teacher_num) {
                //在班级活动表中查询出对应老师id所发的信息数量
                $teacherid=$teacher_num['id'];
                $teacher_count=$comment_model
                ->where("teacher_id=$teacherid")
                ->count();
                $teacher_num['teacher_count']=$teacher_count;
                unset($teacher_num);
            }
             if($teacher_info){
                $ret = $this->format_ret(1,$teacher_info);
            }else{
                $ret = $this->format_ret(0,"count error");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //园所情况-消息群发
    public function SendMessageCount(){
        //传入schoolid
        $schoolid=intval(I("schoolid"));
        if($schoolid){
            $message_model=M('user_message');
            $department_model=M('department_teacher');
            $teacher_model=M('wxtuser');
            //user表与科室表联查,在科室表中的肯定是老师
            $teacher_info=$teacher_model
            ->alias("w")
            ->join("wxt_department_teacher t ON t.teacher_id=w.id")
            ->distinct(true) //一个老师可能在多个科室,所以取出的id有重复值,用distinct去除重复值
            ->where("t.school_id=$schoolid")
            ->field("w.id,w.name")
            ->select();
            foreach ($teacher_info as &$teacher_num) {
                //在班级活动表中查询出对应老师id所发的信息数量
                $teacherid=$teacher_num['id'];
                $teacher_count=$message_model
                ->where("send_user_id=$teacherid")
                ->count();
                $teacher_num['teacher_count']=$teacher_count;
                unset($teacher_num);
            }
             if($teacher_info){
                $ret = $this->format_ret(1,$teacher_info);
            }else{
                $ret = $this->format_ret(0,"count error");
            }
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    /**
    *获取学校招聘信息
    *author:zcq
    *2016-6-3 
    **/
    public function getSchoolJobList(){
        $schoolid = Intval(I('schoolid'));
        if(!empty($schoolid)){
            $where = array('j.schoolid' => $schoolid);
            $lists = M('jobs')
            ->alias('j')
            ->join("wxt_school  s ON j.schoolid=s.schoolid")
            ->field("j.*,s.school_name,s.introduce")
            ->where($where)->select();   
            $ret = $this->format_ret(1,$lists);          
        }
        else
        {
            $ret = $this->format_ret(0,"lost params");  
        }
        echo json_encode($ret);
        exit;
    }
 	   //获取班级内学生的列表
    public function getstudentlist(){
    	$userid = Intval(I('userid'));
        $classid = Intval(I('classid'));
        if($userid && $classid){
            $class_model = M('school_class');
            $student_model = M('wxtuser');
            $relationship = M('class_relationship');
            $lists = $relationship
             ->alias("r")
             ->join("wxt_wxtuser  u ON r.userid=u.id")
             ->where("r.classid = $classid AND r.type=1")
             ->field('u.id,u.name,u.phone')
             ->select();
            $ret = $this->format_ret(1,$lists); 
        }
        else
        {
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;           
    }   
    
    //发布学校公告
    public function publishnotice(){
        //获取发送表中所需的字段值
        $data_send['userid']=I('userid');
        $data_send['title']=I('title');
        $data_send['content']=I('content');
        $data_send['type']=I('type');
        $data_send['create_time']=time();
        $genre=Intval(I('genre'));
        $send_ret=M('notice')->add($data_send);
        //获取接收表中所需字段值,因获取到的是多个receiver_user_id,所以用explode函数拆分开
        $receiverid = I('receiverid');
        $readerid_arr=explode(",",$receiverid);
        //去掉数组中的空格位置
        $receiveid_arr = array_filter($receiveid_arr);
        //将拆分后的id用foreach和settype函数转换为单个int值
        foreach ($readerid_arr as &$receiveid) {
            $receiver_id_info=$receiveid;
            $receiver_id=settype($receiver_id_info,"integer");
            //将接收人id存入表中
            $data_re['noticeid']=$send_ret;
            $data_re['receiverid']=$receiver_id_info;
            $receive_ret=M('notice_receiverid')->add($data_re);
        }
        //图片存入表中
            $pic_model=M('notice_photo');
            $pic=I('photo');
            $pic_arr=explode(",",$pic);
            //去掉数组中的空格位置
            $pic_arr = array_filter($pic_arr);
            for ($i=0; $i < count($pic_arr); $i++) {
                $pic_add=$pic_model->add(array("noticeid"=>$send_ret,"photo"=>$pic_arr[$i]));
            }
        if($send_ret){
            $ret = $this->format_ret(1,'成功');
            if($genre > 1){
                $rs = $this->tjiguang("您收到一条新的通知公告,请注意查收!","notice",$readerid_arr,'',0);
            }else{
                $rs = $this->pjiguang("您收到一条新的通知公告,请注意查收!","notice",$readerid_arr,'',0);
            }
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }  
        echo json_encode($ret);
    exit; 
    }
    //用户读取公告时间
    public function read_notice(){
        $noticeid=I('noticeid');
        $receiverid=I('receiverid');
        $data['create_time']=time();
        $where['noticeid']=$noticeid;
        $where['receiverid']=$receiverid;
        $new_time=M('notice_receiverid')->where($where)->save($data);
        if($new_time){
            $ret = $this->format_ret(1,'成功');
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }  
        echo json_encode($ret);
        exit; 
    }
    //添加公告照片
    public function addnoticephoto(){
        $noticeid = Intval(I('noticeid'));
        $photo = I('photo');
        if($noticeid && (!empty($photo))){
            $noticephoto_model = M('notice_photo');
            $data = array(
                'noticeid'=>$noticeid,
                'photo'=>$photo,
                'create_time'=>time()
                );
            $noticephotoid = $noticephoto_model->add($data);
            if($noticephotoid){
                $ret = $this->format_ret(1,$noticephotoid);
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
    //添加作业照片
    public function addphoto(){
        $refid = Intval(I('id'));
        $photo = I('photo');
        $type=I('type');
        if($refid && (!empty($photo))){
            $noticephoto_model = M('photo');
            $data = array(
                'refid'=>$refid,
                'photo'=>$photo,
                'type'=>$type,
                'create_time'=>time()
                );
            $photoid = $noticephoto_model->add($data);
            if($photoid){
                $ret = $this->format_ret(1,$photoid);
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
    /*写博客上传图片*/
    function WriteMicroblog_upload(){
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
            return "./uploads/microbloghub/$pic_name";
        }else{
            return "";
        }
        return "";
        // echo json_encode($ret);
        // exit;
    }
    //获取自己发布的公告列表
    public function getnoticelist(){
        //获取参数
        $userid = Intval(I('userid'));
        $schoolid = intval(I('schoolid'));
        $classid = intval(I('classid'));
        $type = intval(I('type'));
        if($type=1 && !empty($schoolid)){
            $school_model=M('school');
            $schoolname=$school_model->field("school_name")->where("schoolid=$schoolid")->find();
        }
        if($type=2 && !empty($classid)){
            $class_model=M('school_class'); 
            $classname=$class_model->field("classname")->where("id=$classid")->find();
        }
        if($userid){
            $notice_model = M('notice'); 
            //通过传参的userid获取到对应的公告信息
            $lists = $notice_model
            ->field('id,userid,title,content,type,create_time')
            ->where("userid=$userid")
            ->order('id desc')
            ->select();
            $user_model = M('wxtuser');
            $receive_model=M('notice_receiverid');
            $pic_model = M('notice_photo');
            $like_model =M('likes');
            $comment_model = M('comments');//评论表
            foreach ($lists as &$notice ) {
                $noticeid = $notice["id"];
                $userid = $notice["userid"];
                //通过查询到的userid在user表中查询出对应的姓名头像
                $userinfo = $user_model
                ->field("name,photo")
                ->where("id=$userid")
                ->find();
                if($userinfo){
                    $notice['username']=$userinfo["name"];
                    $notice["avatar"]= $userinfo["photo"];
                }
                else{
                    $notice['username']="";
                    $notice["avatar"]= "default.png";
                }
                //通过查询到的主键id在接收人表中查询出接收人的信息,并通过两表联查获取到接收人的姓名等信息
                $receive_list=$receive_model
                ->alias("r")
                ->join("wxt_wxtuser w ON r.receiverid=w.id")
                ->where("r.noticeid=$noticeid")
                ->field("w.name,w.photo,w.phone,r.id,r.noticeid,r.receiverid,r.receivertype,r.create_time")
                ->select();
                $notice['receive_list']=$receive_list;
                //获取图片
                $pohtolist = $pic_model
                ->field("id,photo as pictureurl,create_time")
                ->where("noticeid=$noticeid")
                ->order("id asc")
                ->select();
                if($pohtolist){
                    $notice['pic']= $pohtolist;
                    for ($j=0; $j < count($pohtolist); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pohtolist[$j]["pictureurl"]);
                    $notice['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $notice['pic'][$j]["pictureheight"]=$imagesize["1"];
                }
                }else
                {
                    $notice['pic']= "";
                }
                //获取点赞和评论
                $like_return = $like_model->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where("wxt_likes.refid = $noticeid and type='3'")
                    ->order('likeid ASC')
                    ->field('userid,photo as avatar,wxt_wxtuser.name')
                    ->select();
                $comment_return = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where("wxt_comments.refid = $noticeid and type='3'")
                    ->order('wxt_comments.id ASC')
                    ->field('userid,wxt_wxtuser.photo as avatar,name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                    ->select();
                $notice['comment']=$comment_return;
                $notice['like']=$like_return;
                unset($notice);
            }

            $ret = $this->format_ret(1,$lists); 
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;               
    }
    //获取接收人接收的公告
    public function get_receive_notice(){
        //获取参数
        $receiverid=Intval(I('receiverid'));
        if($receiverid){
            $notice_model=M('notice');
            $receive_model=M('notice_receiverid');
            $pic_model = M('notice_photo');
            $user_model=M('wxtuser');
            //在接收人表中通过传入的receiverid获取到对应的信息
            $receive_info=$receive_model
            ->alias("r")
            ->join("wxt_wxtuser t ON r.receiverid=t.id")
            ->field("t.name,t.photo,t.phone,r.*")
            ->where("r.receiverid=$receiverid")
            ->order("r.id DESC")
            ->select();
            //foreach循环获取剩余所需信息
            foreach ($receive_info as &$notice) {
                $noticeid=$notice['noticeid'];
                //在公告信息表中通过查询到的对应主键id获取到对应的公告信息,两表联查在user表中查询发布人的姓名等信息
                $notice_info=$notice_model
                ->alias("n")
                ->join("wxt_wxtuser w ON n.userid=w.id")
                ->where("n.id=$noticeid")
                ->field("w.name,w.photo,n.id,n.userid,n.title,n.type,n.content,n.create_time")
                ->select();
                $notice['notice_info']=$notice_info;
                //在接收人表中通过查询到的对应主键id获取到所有收到这条信息的人
                $receiv_list=$receive_model
                ->alias("e")
                ->join("wxt_wxtuser u ON e.receiverid=u.id")
                ->field("u.name,u.photo,u.phone,e.*")
                ->where("e.noticeid=$noticeid")
                ->select();
                $notice['receiv_list']=$receiv_list;
                //获取图片
                $pic=$pic_model->field("photo")->where("noticeid=$noticeid")->select();
                $notice['pic']=$pic;
                for ($j=0; $j < count($pic); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pic[$j]["photo"]);
                    $notice['pic'][$j]["picturewidth"]=$imagesize["0"];
                    $notice['pic'][$j]["pictureheight"]=$imagesize["1"];
                }
                unset($notice);
            }
            $ret = $this->format_ret(1,$receive_info); 
         }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    /***
    *发布待办事宜
    */
    public function addschedule(){
        //定义数据模型
        $schedule_model=M('schedule');
        $recive_model=M('schedule_reception');
        $photo_model=M('schedule_pic');
        //接收参数
        $userid=Intval(I('userid'));
        $schoolid=Intval(I('schoolid'));
        $title=I('title');
        $content=I('content');
        $reciverid=I('reciveid');
        $photolist=I('photolist');
        //判断有效性
        if(!empty($userid)){
            $data["userid"]=$userid;
            $data["title"]=$title;
            $data["content"]=$content;
            $data["schoolid"]=$schoolid;
            $data["create_time"]=time();
            //向待办主表添加数据
            $scheduleid=$schedule_model->add($data);
            if($scheduleid){
                //添加接收记录
                $recivedata["scheduleid"]=$scheduleid;
                $recivedata["receiverid"]=$reciverid;
                $recivedata["create_time"]=time();
                $reciveid=$recive_model->add($recivedata);
                //添加图片记录
                //截取图片字符串
                $picurl_array = explode(',',$photolist);
                //去掉数组中的空格位置
                $picurl_array = array_filter($picurl_array);
                //存入字符串
                for($i=0;$i<count($picurl_array);$i++) {
                    $photo_model->add(array("schedule_id"=>$scheduleid,"picture_url"=>$picurl_array[$i]));
                }
                $ret = $this->format_ret(1,$scheduleid);
                $rs = $this->tjiguang("您收到一条新的待办事宜消息,请注意查收!","schedule",array($reciverid),'',0);
            }else{
                $ret = $this->format_ret(0,"add error");
            }
            // $ret = $this->format_ret(1,"lost params");
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;     
    }
    //转派待办事宜
    public function DoSchedul(){
        //定义数据模型
        $schedule_model=M('schedule');
        $recive_model=M('schedule_reception');
        //接收数据参数
        $previousid=intval(I('id'));
        $scheduleid=intval(I('scheduleid'));
        $userid=intval(I('userid'));
        $feedback=I('feedback');
        $finish=intval(I('finish'));
        $reciveid=I('reciveid');
        if($scheduleid && $userid){
            // //更新我的办理记录
            // $updatewhere["id"]=$previousid;
            // $updatadata["status"]=1
            // $updatadata["finish"]=$finish;
            // $previousid=$recive_model->where($updatewhere)->save($updatadata);
            //添加接收记录
            if($finish==0){
                $updatewhere["id"]=$previousid;
                $updatadata["status"]=2;
                $updatadata["finish"]=$finish;
                $previousid=$recive_model->where($updatewhere)->save($updatadata);
                $recivedata["previousid"]=intval(I('id'));
                $recivedata["scheduleid"]=$scheduleid;
                $recivedata["userid"]=$userid;
                $recivedata["receiverid"]=$reciveid;
                $recivedata["feedback"]=$feedback;
                $recivedata["finish"]=$finish;
                $recivedata["status"]=$status;
                $recivedata["do_time"]=time();
                $recivedata["create_time"]=time();
                $Nextid=$recive_model->add($recivedata);
            }else{
                $updatewhere["id"]=$previousid;
                // $updatadata["status"]=$finish;
                $updatadata["finish"]=intval(I('finish'));
                $previousid=$recive_model->where($updatewhere)->save($updatadata);
            }
            //更新待办事宜的主表
            $schooliddata["status"]=$finish;
            $schedule_model->where("id=$scheduleid")->save($schooliddata);

            $ret = $this->format_ret(1,$scheduleid);
            $rs = $this->tjiguang("您收到一条新的待办事宜消息,请注意查收!","schedule",array($reciveid),'',0);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;   
    }
    /**
    *
    *获取我发布的待办事宜列表
    */
    public function GetMySendSchedulelist(){
        //定义数据模型
        $schedule_model=M('schedule');
        $recive_model=M('schedule_reception');
        $user_model = M('wxtuser');
        $pic_model = M('schedule_pic');
        //接收数据
        $userid = Intval(I('userid'));
        $schoolid = intval(I('schoolid'));
        //判断数据有效性
        if($userid && $schoolid){
            // $iscando="1";
            $lists = $schedule_model
            ->alias('s')
            ->join("".C('DB_PREFIX')."wxtuser as u ON s.userid = u.id")
            ->field('s.id,userid,u.name,u.photo,title,content,s.status,s.create_time')
            ->order('s.id desc')
            ->select();
            //获取办理流程即接收人
            foreach ($lists as &$schedule ) {
                $scheduleid = $schedule["id"];
                //获取图片列表
                $pohtolist = $pic_model
                ->field("id,picture_url")
                ->where("schedule_id=$scheduleid")
                ->order("id asc")
                ->select();
                //获取接收人列表
                $reciver_return = $recive_model
                ->alias("r")
                ->join("".C('DB_PREFIX')."wxtuser as u ON r.userid = u.id")
                ->where("r.scheduleid = $scheduleid ")
                ->order('r.id ASC')
                ->field('r.userid,r.scheduleid,r.previousid,u.name,u.photo,feedback,finish,read_time,r.create_time')
                ->select();
                //获取上一级接收人信息
                foreach ($reciver_return as &$recive) {
                    $prescheduleid=$recive["previousid"];
                    $previous_return=$recive_model
                    ->alias("r")
                    ->join("".C('DB_PREFIX')."wxtuser as u ON r.receiverid = u.id")
                    ->where("r.id = $prescheduleid ")
                    ->order('r.id ASC')
                    ->field('r.receiverid as userid,r.scheduleid,r.previousid,u.name,u.photo,feedback,finish,read_time,r.create_time')
                    ->find();
                    $recive["previous_username"]=$previous_return["name"];
                    $recive["previous_avatar"]=$previous_return["photo"];
                    $recive["previous_feedback"]=$previous_return["feedback"];
                    $recive["previous_readtime"]=$previous_return["read_time"];
                    $recive["previous_createtime"]=$previous_return["create_time"];
                }
                $schedule['piclist']= $pohtolist;
                for ($j=0; $j < count($pohtolist); $j++) { 
                    # code...
                    $imagesize = getimagesize("./uploads/microblog/".$pohtolist[$j]["picture_url"]);
                    $schedule['piclist'][$j]["picturewidth"]=$imagesize["0"];
                    $schedule['piclist'][$j]["pictureheight"]=$imagesize["1"];
                }
                // $schedule['iscando']=$iscando;
                $schedule['reciverlist']=$reciver_return;
                unset($schedule);
            }

            $ret = $this->format_ret(1,$lists); 
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;               
    }
    /**
    *
    *获取我收到的待办事宜列表
    */
     public function GetMyReciveSchedulelist(){
        //定义数据模型
        $schedule_model=M('schedule');
        $recive_model=M('schedule_reception');
        $photo_model=M('photo');
        $user_model = M('wxtuser');
        $pic_model = M('schedule_pic');
        $phototype="7";
        //接收数据
        $userid = Intval(I('userid'));
        $schoolid = intval(I('schoolid'));
        //判断数据有效性
        if($userid && $schoolid){
                $lists = $recive_model
                ->alias("r")
                ->join("".C('DB_PREFIX')."schedule as s ON s.id = r.scheduleid")
                ->join("".C('DB_PREFIX')."wxtuser as u ON s.userid = u.id")
                ->where("r.receiverid = $userid ")
                ->order('r.id DESC')
                ->field('s.id,s.userid,u.name,u.photo,title,content,s.status,s.create_time')
                ->select();
                foreach ($lists as &$schedule ) {
                    $scheduleid = $schedule["id"];

                    //获取图片列表
                    $photowhere["schedule_id"]=$scheduleid;
                    // $photowhere["type"]=$phototype;
                    $pohtolist = $pic_model
                    ->field("id,picture_url")
                    ->where($photowhere)
                    ->order("id asc")
                    ->select();
                    //获取接收人列表
                    $reciverwhere["r.scheduleid"]=$scheduleid;
                    $reciver_return = $recive_model
                    ->alias("r")
                    ->join("".C('DB_PREFIX')."wxtuser as u ON r.userid = u.id")
                    ->where($reciverwhere)
                    ->order('r.id ASC')
                    ->field('r.userid,r.scheduleid,r.previousid,u.name,u.photo,feedback,finish,read_time,r.create_time')
                    ->select();

                    $schedule['piclist']= $pohtolist;
                    for ($j=0; $j < count($pohtolist); $j++) { 
                        # code...
                        $imagesize = getimagesize("./uploads/microblog/".$pohtolist[$j]["picture_url"]);
                        $schedule['piclist'][$j]["picturewidth"]=$imagesize["0"];
                        $schedule['piclist'][$j]["pictureheight"]=$imagesize["1"];
                    }
                    $schedule['reciverlist']=$reciver_return;
                }
            $ret = $this->format_ret(1,$lists); 
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;               
    }

    /**
    *
    *待办事宜列表
    */
     public function getschedulelist(){
        $userid = Intval(I('userid'));
        $schoolid = intval(I('schoolid'));
        if($userid && $schoolid){
            $notice_model = M('schedule');
            $lists = $notice_model
            ->field('id,userid,title,content,create_time')
            ->order('id desc')
            ->select();
            $user_model = M('wxtuser');
            $pic_model = M('photo');
            $like_model =M('likes');
            $comment_model = M('comments');//评论表
            foreach ($lists as &$notice ) {
                $noticeid = $notice["id"];
                $userid = $notice["userid"];
                $userinfo = $user_model
                ->field("name,photo")
                ->where("id=$userid")
                ->find();
                if($userinfo){
                    $notice['username']=$userinfo["name"];
                    $notice["avatar"]= $userinfo["photo"];
                }
                else{
                    $notice['username']="";
                    $notice["avatar"]= "default.png";
                }
                $pohtolist = $pic_model
                ->field("id,photo as pictureurl")
                ->where("refid=$noticeid and type='4'")
                ->order("id asc")
                ->select();
                
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
                $notice['pic']= $pohtolist;
                $notice['comment']=$comment_return;
                $notice['like']=$like_return;
                $notice['readcount']=1;
                $notice['allreader']=9;
                $notice['readtag']=1;
                unset($notice);
            }

            $ret = $this->format_ret(1,$lists); 
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;               
    }

 /* 点赞接口
 * 获取用户id，被点赞的博客id，点赞时间，传入点赞详情表，增加一条记录
 * */
    public function SetLike(){
        $data['userid'] = I('userid');
        $data['refid'] = I('id');
        $data['type'] = I('type');
        $data['add_time'] = time();
        /*
         * 2016/02/25修改点赞时间为后台获取
         * */
        $microblog_like = M('likes');
        if($data['userid']!=''&&$data['refid']!=''){
            $like_return = $microblog_like->add($data);
            if($like_return){
                $ret = $this->format_ret(1,$like_return);
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
        $data['refid'] = I('id');
        //$data['type'] = I('type');
        $microblog_like = M('likes');
        if($data['userid']!=''&&$data['refid']!=''){
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
        $data['userid'] = I('userid');
        $data['refid'] = I('id');
        $data['type'] = I('type');
        $data['content'] = I('content');
        $data['photo']=I('photo');
        $type=I('type');
        /*
         * 2016/02/26修改评论接口为post获取
         * */
        $data['add_time'] = time();
        /*
         * 2016/02/25修改评论时间为后台获取
         * */
        $data['status'] = 1;
        $microblog_comment = M('comments');
        if($data['userid']!=''&&$data['refid']!=''){
            $comment_ret = $microblog_comment->add($data);
            if($comment_ret){
                $ret = $this->format_ret(1,$comment_ret);
                if($type=4){
                    $where["id"]=I('id');
                    $sid=M('entrust')->where($where)->getField("studentid");
                    $rs = $this->pjiguang("您收到一条新的家长叮嘱的回复消息,请注意查收!","trust",array($sid),'',0);
                }
            }else{
                $ret = $this->format_ret(0,"评论失败！");
            }
        }else{
            $ret = $this->format_ret(0,'param lost');
        }
        echo json_encode($ret);
        exit;

    }
    /*获取评论列表*/
    public function GetCommentlist(){
       $userid =I('userid');
       $refid = I('refid');
       $type = I('type'); 
       if(I('type')!=''&&I('refid')!=''){
        $comment_model = M('comments');//评论表
        $lists = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where("wxt_comments.refid = $refid and type=$type")
                    ->order('wxt_comments.id ASC')
                    ->field('userid,wxt_wxtuser.photo as avatar,wxt_wxtuser.name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                    ->select();
            $ret = $this->format_ret(1,$lists);
       // }else{
       //  $ret = $this->format_ret(0,'param lost');
       }else{
        $ret = $this->format_ret(0,'param lost');
       }
       echo json_encode($ret);
        exit;
    }
     /*获取点赞列表*/
    public function GetLikelist(){
       $userid =I('userid');
       $refid = I('refid');
       $type = I('type'); 
       if(I('type')!=''&&I('refid')!=''){
        $like_model=M('likes');//评论表
        $lists = $like_model->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where("wxt_likes.refid = $refid and type=$type")
                    ->order('likeid ASC')
                    ->field('userid,photo as avatar,wxt_wxtuser.name')
                    ->select();
            $ret = $this->format_ret(1,$lists);
       // }else{
       //  $ret = $this->format_ret(0,'param lost');
       }else{
        $ret = $this->format_ret(0,'param lost');
       }
       echo json_encode($ret);
        exit;
    }
/**
*校网模块
*
*/
// //入学报名
//入学报名
    // public function addapply(){
    //     $userid=I('get.userid');
    //     $schoolid=I('get.schoolid');
    //     if(!empty($schoolid)&&!empty($userid)){
    //         $data["userid"]=$userid;
    //         $data["schoolid"]=$schoolid;
    //         $data["classid"]=I('class');
    //         $data["name"]= I('name');
    //         $data["sex"]=I('sex');
    //         $data["birthday"]=I('birthday');
    //         $data["address"]=I('address');
    //         $data["phone"]=I('phone');
    //         $data["qq"]=I('qq');
    //         $data["weixin"]=I('weixin');
    //         $data["education"]=I('education');
    //         $data["school"]=I('school');
    //         $data["create_time"]=date("Y-m-d H:i:s");
    //         $data["post_content"]=I('post_content');
    //         $apply_model=D('apply');
    //         $rst=$apply_model->add($data);
    //         if($rst){
    //            $ret=$this->success('入学成功'); 
    //         }else{
    //             $ret=$this->error('入学失败'); 
    //         }
    //    }else{
    //         $this->error('失败');
    //    }
    //    echo json_encode($ret);
    //    exit;
    // }
public function addapply(){
    $schoolid=I('schoolid');
    if(!empty($schoolid)){
        $data["schoolid"]=$schoolid;
        $data["name"]= I('name');
        $data["sex"]=I('sex');
        $data["address"]=I('address');
        $data["phone"]=I('phone');
        $data["qq"]=I('qq');
        $data["weixin"]=I('weixin');
        $data["photo"]=I('photo');
        $data["create_time"]=time();
        $data["post_content"]=I('post_content');
        $apply_model=M('apply');
        $apply=$apply_model->add($data);
        if($apply){
           $ret = $this->format_ret(1,'报名成功'); 
        }else{
            $ret = $this->format_ret(0,'报名数据不成功');
        }

   }else{
    $ret = $this->format_ret(0,'请输入学校编号');
   }
   echo json_encode($ret);
    exit;

}
//获取教师风采
public function getteacherinfos(){
    $schoolid=I('schoolid');
    if(!empty($schoolid)){
        $where["schoolid"]=$schoolid;
        $teacherinfo_model=M('teacherinfo');
        $infos=$teacherinfo_model->where($where)->field('id,schoolid,post_title,post_excerpt,post_keywords,post_date,smeta')->select();
        foreach ($infos as  &$val) {
            $smeta=json_decode($val['smeta'],true);
            if(!empty($smeta['thumb'])){
                $val["thumb"]=sp_get_asset_upload_path($smeta['thumb']);
            }else{
                 $val["thumb"]="";
            }
           
        }
        $ret = $this->format_ret(1,$infos);
   }else{
    $ret = $this->format_ret(0,'请输入学校编号');
   }
   echo json_encode($ret);
    exit;
}
//获取宝宝秀场
public function getbabyinfos(){
    $schoolid=I('schoolid');
    if(!empty($schoolid)){
        $where["schoolid"]=$schoolid;
        $teacherinfo_model=M('babyinfo');
        $infos=$teacherinfo_model->where($where)->field('id,schoolid,post_title,post_excerpt,post_keywords,post_date,smeta')->select();
        foreach ($infos as  &$val) {
            $smeta=json_decode($val['smeta'],true);
            if(!empty($smeta['thumb'])){
                $val["thumb"]=sp_get_asset_upload_path($smeta['thumb']);
            }else{
                 $val["thumb"]="";
            }
           
        }
        $ret = $this->format_ret(1,$infos);
   }else{
    $ret = $this->format_ret(0,'请输入学校编号');
   }
   echo json_encode($ret);
    exit;
}
//获取教师招聘
public function getjobs(){
    $schoolid=I('schoolid');
    if(!empty($schoolid)){
        $where["schoolid"]=$schoolid;
        $teacherinfo_model=M('jobs');
        $infos=$teacherinfo_model->where($where)->field('id,schoolid,post_title,post_excerpt,post_date,smeta')->select();
        foreach ($infos as &$val) {
            $smeta=json_decode($val['smeta'],true);
            if(!empty($smeta['thumb'])){
                $val["thumb"]=sp_get_asset_upload_path($smeta['thumb']);
            }else{
                 $val["thumb"]="";
            }
           
        }
        $ret = $this->format_ret(1,$infos);
   }else{
    $ret = $this->format_ret(0,'请输入学校编号');
   }
   echo json_encode($ret);
    exit;
}
//获取兴趣班级列表
public function getInterestclass(){
    $schoolid=I('schoolid');
    if(!empty($schoolid)){
        $where["schoolid"]=$schoolid;
        $teacherinfo_model=M('interestclass');
        $infos=$teacherinfo_model->where($where)->field('id,schoolid,post_title,post_excerpt,post_keywords,post_date,smeta')->select();
        foreach ($infos as  &$val) {
            $smeta=json_decode($val['smeta'],true);
            if(!empty($smeta['thumb'])){
                $val["thumb"]=sp_get_asset_upload_path($smeta['thumb']);
            }else{
                 $val["thumb"]="";
            }
           
        }
        $ret = $this->format_ret(1,$infos);
   }else{
    $ret = $this->format_ret(0,'请输入学校编号');
   }
   echo json_encode($ret);
    exit;
}
/**
*校网模块结束
*/


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
            // $ret = $this->format_ret(1,"uploads/microbloghub/$pic_name");
            return array('status'=>1,'pic_source' => "uploads/microbloghub/$pic_name");
        }else{
            return array('status'=>0,'result' => $state);
        }
       return array('status'=>0,'result' => "error");
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
    //以数组的形式返回点赞列表
    function getCommentArrayList($refid,$type){
       if($refid!=''&&$type!=''){
        $comment_model = M('comments');//评论表
        $lists = $comment_model->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where("wxt_comments.refid = $refid and type=$type")
                    ->order('wxt_comments.id ASC')
                    ->field('userid,wxt_wxtuser.photo as avatar,wxt_wxtuser.name,content,wxt_comments.photo,wxt_comments.add_time as comment_time')
                    ->select();
            $ret = array('status'=>'success', 'data'=>$lists);
       }else{
            $ret = array('status'=>'error', 'data'=>"");
       }
       return $ret;
    }



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