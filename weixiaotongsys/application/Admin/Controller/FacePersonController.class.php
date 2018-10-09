<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class FacePersonController extends AdminbaseController{
	
	function _initialize() {
		parent::_initialize();
        $this->face_application_model = M("face_application");
        $this->face_group = M("face_group");
        $this->only_code = strtolower(MODULE_NAME).'_'.strtolower(CONTROLLER_NAME);
	}

    public function index()
    {

           $ss= M("FaceApplication")
               ->alias("fa")
               ->join( "wxt_face_device fd ON fd.applicationid = fa.Id")
               ->join( "wxt_face_device_config fdc ON fdc.deviceKey = fd.deviceKey")
               ->join( "wxt_face_school_device fsd ON fsd.deviceid = fd.Id")
               ->join( "wxt_face_school fs ON fs.schoolid = fsd.faceschoolid")
               ->join( "wxt_face_group fg ON fg.schoolid = fs.schoolid")
               ->join( "wxt_face_person fp ON fp.appid = fa.Id")
               ->join( "wxt_face_person_device_relation fpd ON fpd.personid = fp.Id")
               ->join( "wxt_face_photo fpo ON fpo.guid = fp.guid")
               ->join( "wxt_face_photo_device_relation fpod ON fpod.photoguid = fpo.photoguid")
               ->join( "wxt_face_record fr ON fr.guid = fp.guid")
               ->select(false);
dump($ss);

    }

    private function _lists_school_person()
    {
        $this -> class_model = D("Common/school_class");
        $this -> wxtuser_model = D("Common/wxtuser");
        $this -> student_info_model = D("Common/student_info");
        $this -> relation_stu_class_model = D("Common/class_relationship");
        //1、获取参数
        $schoolid = I("schoolid");

        $tiaojian = I("tiaojian");
        $shuzhi = I("shuzhi");
        $province = I("province");

        $citys = I('citys');

        $message_type = I('message_type');

        $Province=role_admin();
        $grade=I('grade');
        $classs=I('classs');
        if($province && $citys && $message_type && $schoolid)
        {
            //写入缓存
            write_condition($province,$citys,$message_type,$schoolid,$this->only_code);
        }elseif(!$tiaojian){
            S($this->only_code,null);
            $this->assign("Province",$Province);
            $this -> display('add_school_person');
            exit();
        }

        $this -> assign("tiaojian",$tiaojian);

        if($schoolid)
        {
            $this->assign("schoolid",$schoolid);
        }

        if($province)
        {
            $where['school.province'] = $province;
            $wheres['school.province'] = $province;
            $this->assign("province",$province);
        }

        if($citys){
            $where['school.city'] = $citys;
            $wheres['school.city'] = $citys;
            $this->assign("new_citys",$citys);
        }
        if($message_type)
        {
            $where['school.area'] = $message_type;
            $wheres['school.area'] = $message_type;
            $this->assign("new_message_type",$message_type);
        }

        if ($tiaojian != "0" && $shuzhi != "") {
            $where["s.$tiaojian"] = array('like', "%$shuzhi%");
        }
        if ($schoolid != 0) {
            $where["a.schoolid"] = $schoolid;
        }

        $roleid = admin_role();

        if($roleid!=1)
        {
            $join_else = "wxt_role_school rs ON rs.schoolid = a.schoolid";
            $where['rs.roleid'] = $roleid;
            $join_else_info = "wxt_role_school rs ON rs.schoolid = bi.schoolid";
            $wheres['rs.roleid'] = $roleid;
        }
        if($grade)
        {
            $join_else_grade = "wxt_school_class g ON g.id = a.classid";
            $where['g.grade'] = $grade;
            $this->assign("new_grade",$grade);
        }
        if($classs && $grade)
        {
            $where['a.classid'] = $classs;
            $this->assign("new_classs",$classs);
        }

        //地区
        $Region = M("city") -> where("parent=2") -> select();

        //TODO现在拉取数据主表用的是class_relation,需要改为student_info,以后再修改!
        //	    2、如果选择了学生姓名 或者bu'xua
        if ($tiaojian == "name" || $tiaojian == "0" || $tiaojian == "" ) {

            $count = $this->relation_stu_class_model
                ->alias("a")
                ->join("wxt_wxtuser s ON a.userid = s.id")
                ->join("wxt_school school ON school.schoolid = a.schoolid")
                ->join($join_else)
                ->join($join_else_grade)
                ->where($where)
                ->count();
            $page = $this->page($count, 20);


            $students = $this->relation_stu_class_model
                ->alias("a")
                ->join("wxt_wxtuser s ON a.userid = s.id")
                ->join("wxt_school school ON school.schoolid = a.schoolid")
                ->join($join_else)
                ->join($join_else_grade)
                ->field("s.id,s.schoolid,s.name,s.phone,s.create_time,school.school_name")
                ->where($where)
                ->limit($page->firstRow . ',' . $page->listRows)
                ->order("a.id ASC")->select();


            //exit();
            foreach ($students as &$studentclass) {
                $classlist = $this -> class_model
                    -> alias("b")
                    -> join("wxt_class_relationship br ON b.id=br.classid")
                    -> where(array("br.userid" => $studentclass['id']))
                    -> field('classname')
                    -> select();
                $studentclass["classlist"] = $classlist;
                unset($studentclass);
            }

            foreach ($students as &$student_user) {
                $userlist = $this -> wxtuser_model
                    -> alias("user")
                    -> join("wxt_relation_stu_user su ON user.id=su.userid")
                    -> where(array("su.studentid" => $student_user['id']))
                    -> field('su.name,su.appellation,su.phone')
                    -> select();
                $lastResult = "";
                $arr = count($userlist);
                for ($i = 0; $i < $arr; $i++) {
                    $last = $userlist[$i][name];
                    $poeon = $userlist[$i][phone];
                    $Chen = $userlist[$i][appellation];
                    $lastResult = $Chen . " " . $lastResult . $last . "," . $poeon;

                }
                $student_user["names"] = $lastResult;
                unset($student_user);
            }
            foreach ($students as &$value) {
                $personId = $value['id'];
                $card = M('student_card')->where("personId = $personId and cardType = 0 and handletype = 1")->field("cardno")->find();
                $value['cardno'] = $card['cardno'];
            }

        } else {

            if ($tiaojian == "names") {
                $wheres["bi.name"] = array('like', "%$shuzhi%");
            } elseif($tiaojian == "phone") {
                $wheres["bi.phone"] = array('like', "%$shuzhi%");
            }else{
                // $wheres['bi.cardno'] = array('like',"%shuzi%");
                $wheres['cardNo'] = array('like',"%$shuzhi%");
                $wheres['handletype'] = 1;
                $join = "wxt_student_card sc ON si.studentid = sc.personId";

            }



            //整改
            $count = $this -> wxtuser_model
                -> alias("bi")
                ->join("wxt_relation_stu_user si ON bi.id=si.userid ")
                ->join("wxt_school school ON school.schoolid = bi.schoolid")
                ->distinct(true)
                ->join($join_else_info)
                ->join($join)
                -> where($wheres)
                -> count();

            $page = $this -> page($count, 20);

            //整改
            $students = $this -> wxtuser_model
                -> alias("bi")
                ->distinct(true)
                -> join("wxt_relation_stu_user si ON bi.id=si.userid ")
                ->join("wxt_school school ON school.schoolid = bi.schoolid")
                ->join($join_else_info)
                ->join($join)
                -> where($wheres)
                -> limit($page -> firstRow . ',' . $page -> listRows)
                -> field("si.name as names, bi.phone,bi.phone ,si.studentid as id,bi.schoolid")
                -> select();

            if($schoolid)
            {
                $stu_where['schoolid'] = $schoolid;
            }

            foreach ($students as &$student_user) {



                $uisname = $this -> student_info_model
                    ->alias("info")
                    -> where(array("info.userid" => $student_user['id']))
                    ->join("wxt_school school ON school.schoolid = info.schoollid")
                    ->field("info.stu_name as name,info.create_time,info.sex,school.school_name")
                    ->select();

                $lastResultname = "";
                //学生名字
                $lastResultcreate_time = "";
                //创建的时间
                $lastResultsex = "";
                //性别

                $arr = count($uisname);
                for ($i = 0; $i < $arr; $i++) {
                    $last = $uisname[$i][name];
                    $lio = $uisname[$i][create_time];
                    $lioi = $uisname[$i][sex];

                    $lastResultname = $lastResultname . $last;
                    $lastResultcreate_time = $lastResultcreate_time . $lio;
                    $lastResultsex = $lastResultsex . $lioi;
                    $lastResulschool = $uisname[$i][school_name];

                }
                $student_user['sex'] = $lastResultsex;
                $student_user["name"] = $lastResultname;
                $student_user["create_time"] = $lastResultsex;
                $student_user["school_name"] = $lastResulschool;
                unset($student_user);
            }

            foreach ($students as &$student_userclass) {
                $classlist = $this -> class_model
                    -> alias("b")
                    -> join("wxt_class_relationship br ON b.id=br.classid")
                    -> where(array("br.userid" => $student_userclass['id']))
                    -> field('classname')
                    -> select();
                $student_userclass["classlist"] = $classlist;
                unset($student_userclass);
            }
            foreach ($students as &$value) {
                $personId = $value['id'];
                $card = M('student_card')->where("personId = $personId and handletype = 1")->field("cardNo")->find();
                $value['cardno'] = $card['cardNo'];
            }

        }

        //查询登录手机号

        foreach ($students as &$val) {

            $where_user['studentid'] = $val['id'];
            //改为查询所有卡号的家长中是否有人绑定
            $relss = M("relation_stu_user")->where($where_user)->field("userid")->select();
            $where_phone['studentid'] = $val['id'];
            $where_phone['type'] = 1;
            $rel = M("relation_stu_user")->where($where_phone)->field("phone")->find();
            if($rel){
                $val['phone'] = $rel['phone'];
                $val['phones'] = substr_replace($rel['phone'],'****',3,4);
            }
        }
        //todo去除页面重复的值
        $newarr = array();
        foreach($students as $key => $_arr){
            if(!isset($newarr[$_arr['id']])){
                $newarr[$_arr['id']] = $_arr;
            }
        }
        $students = $newarr;

        $statue['1'] = "已上传";
        $statue['2'] = "注册中";
        $statue['3'] = "注册成功";
        $statue['4'] = "注册失败";
        foreach ($students as &$person){
            $personss = M("FacePerson")->where("userid = $person[id]")->field("Id as personid,guid,appid,create_time")->find();
            $person['personid'] = $personss[personid];
            $person['appid'] = $personss[appid];
            $person['guid'] = $personss[guid];
            $person['create_time'] = $personss[create_time];
        }
        foreach ($students as &$valuezz){
            $photo=M('FacePhoto')->where("guid = '$valuezz[guid]'")->select();
            $valuezz[photo]= '';
            if(empty($photo)){
                $valuezz[photo]= '没有照片';
            }else{
                $i=1;
                foreach ($photo as $kkk){
                    $photoarray=M('FacePhotoDeviceRelation')->where("photoguid = '$kkk[photoguid]'")->field("devicename,state")->select();
                    $statuesss = '';
                    if(!empty($photoarray)){
                        foreach ($photoarray as $ooo) {
                            $statuesss .= '('.$ooo[devicename].'-'.$statue[$ooo[state]].')';
                        }
                    }

                    $valuezz[photo] .="<a href='".$kkk[photo]."' target='_Blank'>图片".$i++."</a>".$statuesss;
                    if($i>1){
                        $valuezz[photo] .="<br>";
                    }
                }
            }
        }
        foreach ($students as &$valuesz){
            $device=M('FacePersonDeviceRelation')
                ->alias("fdr")
                ->join('wxt_face_device fd ON fd.Id=fdr.deviceid')
                ->where("fdr.personid = '$valuesz[personid]'")
                ->field("fd.name")
                ->select();
            $valuez[device]= '';
            if(empty($device)){
                $valuesz[device]= '未授权';
            }else{
                $i=1;
                foreach ($device as $jjj){
                    $valuesz[device] .=$jjj[name]."已授权";$i++;
                    if($i>1){
                        $valuesz[device] .="<br>";
                    }
                }
            }
        }

        $Province=role_admin();
        $this->assign("Province",$Province);
        $this -> assign("Region", $Region);
        $this -> assign("tiaojian",$tiaojian);
        $this-> assign("shuzhi",$shuzhi);
        $this -> assign("Page", $page -> show('Admin'));
        $this -> assign("current_page", $page -> GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this -> assign("formget", $_GET);
        $this -> assign("students", $students);
    }
    public function shiliguifan()
    {
        $this->display();
    }
    private function _lists_school_teacher_person()
    {
        $this->school_model = D("Common/School");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->teacherinfo_model = D("Common/teacher_info");
        $this->relation_stu_class_model = D("Common/class_relationship");
        $this->department_model = D("Common/department");
        $this->duty_model = D("Common/school_duty");
        $this->city_model=D("Common/city");
        $school_id=0;
        $get_school = I("school");


        $schoolid = I("schoolid");

        $province = I("province");

        $citys = I('citys');


        $message_type = I('message_type');

        $get_keywordtype = I('keywordtype');

        $Province=role_admin();


        if($province && $citys && $message_type && $schoolid)
        {
            write_condition($province,$citys,$message_type,$schoolid,$this->only_code);
        }elseif(!$get_keywordtype){
            S($this->only_code,null);
            $this->assign("Province",$Province);
            $this -> display('add_school_teacher_person');
            exit();
        }

        if($schoolid)
        {
            $this->assign("schoolid",$schoolid);
        }


        if($province)
        {
            $this->assign("province",$province);
        }

        if($citys){

            $this->assign("new_citys",$citys);
        }
        if($message_type)
        {
            $this->assign("new_message_type",$message_type);
        }


        if(!empty($get_school)){
            $school_id=I("school");
        }

        $get_school_id = I('schoolid');
        if (!empty($get_school_id)){
            $map['t.schoolid'] = I('schoolid');
        }else{
            $get_province = I('province');
            if (!empty($get_province)){
                $map['province'] = $province;
            }


            $get_city = I('citys');
            if (!empty($get_city)){
                $map['city'] = $citys;
            }
            $get_city_next = I('message_type');
            if (!empty($get_city_next)){
                $map['area'] = $message_type;
            }
        }

        $get_keyword = I('keyword');
        if (!empty($get_keywordtype)&&!empty($get_keyword)&&$get_keywordtype=='name'){

            $map['a.name'] = array("like","%".$get_keyword."%");

        }

        if (!empty($get_keywordtype)&&!empty($get_keyword)&&$get_keywordtype=='phone'){
            $map['a.phone'] = array("like","%".$get_keyword."%");
        }

        if (!empty($get_keywordtype)&&!empty($get_keyword)&&$get_keywordtype=='cardno'){
            $map['card.cardNo'] = array("like","%".$get_keyword."%");
            $map['card.handletype'] = 1;
            $map['card.cardType'] = 1;
            $join_card = "wxt_student_card card ON card.personId = t.teacherid";
        }

        $where_ands=empty($school_id)?array(""):array("a.schoolid = $school_id");
        //获取当前角色id
        $roleid = admin_role();
        if($roleid!=1)
        {
            $join_else = "wxt_role_school rs ON rs.schoolid = a.schoolid";
            $map['rs.roleid'] = $roleid;
        }
        $where= join("", $where_ands);

        $count=$this->teacherinfo_model
            ->alias("t")
            ->join(C('DB_PREFIX')."wxtuser a ON a.id=t.teacherid")
            ->join(C('DB_PREFIX')."school s ON t.schoolid=s.schoolid")
            ->join(C('DB_PREFIX')."city c ON c.term_id=s.city")
            ->join($join_else)
            ->join($join_card)
            ->where($map)
            ->count();

        $page = $this->page($count, 50);


        $teachers=$this->teacherinfo_model
            ->alias("t")
            ->join(C('DB_PREFIX')."wxtuser a ON a.id=t.teacherid")
            ->join(C('DB_PREFIX')."school s ON t.schoolid=s.schoolid")
            ->join(C('DB_PREFIX')."city c ON c.term_id=s.city")
            ->join($join_else)
            ->join($join_card)
            ->field("t.teacherid as id,t.name,a.phone,a.create_time,t.schoolid AS schoolid,s.school_name AS school_name,c.term_id AS city,t.id as info_id")
            ->where($map)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("a.id desc")
            ->select();


        foreach ($teachers as &$value) {
            $userid = $value['id'];
            $card = M('student_card')->where("personId = $userid and handletype = 1 and schoolid  = $schoolid")->field("cardNo")->find();
            $value['cardno'] = $card['cardno'];
        }

        foreach ($teachers as &$teacherchange) {
            $dutylist=$this->duty_model
                ->alias("d")
                ->join("wxt_duty_teacher t ON d.id=t.duty_id")
                ->where(array("t.teacher_id"=>$teacherchange['id'],'t.schoolid'=>$teacherchange['schoolid']))
                ->field('t.duty_id,name')
                ->select();
            $dutyStr = "";
            $dutylid = "";
            foreach ($dutylist as &$duty){
                $dutyStr = $dutyStr . $duty['name'] . ';';
                $dutylid = $dutylid . $duty['duty_id'] . ',';
            }
            $teacherchange["dutylist"]=$dutyStr;
            $teacherchange["teacher_dutylid"]=$dutylid;
            unset($teacherchange);
        }
        foreach ($teachers as &$teacherclass) {
            $classlist=$this->class_model
                ->alias("c")
                ->join("wxt_teacher_class t ON c.id=t.classid")
                ->where(array("t.teacherid"=>$teacherclass['id'],"t.schoolid"=>$teacherclass['schoolid']))
                ->field('classname,c.id')
                ->select();

            $teacher_inforty = "";
            $teacher_idsu = "";
            foreach ($classlist as &$classitem){
                $info = $classitem["classname"];
                $infos = $classitem["id"];

                $teacher_inforty = $info.",".$teacher_inforty;
                $teacher_idsu=$infos.",".$teacher_idsu;
            }

            $teacherclass["teacher_subject"]=rtrim($teacher_inforty, ",");

            $teacherclass["teacher_classid"] =$teacher_idsu;
        }
        $city=$this->city_model->order("term_id")->select();
        $school = $this->school_model->order(array("schoolid = $school_id"))->getField("schoolid,school_name as name",true);
        $Province=role_admin();

        $statue['1'] = "已上传";
        $statue['2'] = "注册中";
        $statue['3'] = "注册成功";
        $statue['4'] = "注册失败";
        foreach ($teachers as &$person){
            $personss = M("FacePerson")->where("userid = $person[id]")->field("Id as personid,guid,appid,create_time")->find();
            $person['personid'] = $personss[personid];
            $person['appid'] = $personss[appid];
            $person['guid'] = $personss[guid];
            $person['create_time'] = $personss[create_time];
        }
        foreach ($teachers as &$valuezz){
            $photo=M('FacePhoto')->where("guid = '$valuezz[guid]'")->select();
            $valuezz[photo]= '';
            if(empty($photo)){
                $valuezz[photo]= '没有照片';
            }else{
                $i=1;
                foreach ($photo as $kkk){
                    $photoarray=M('FacePhotoDeviceRelation')->where("photoguid = '$kkk[photoguid]'")->field("devicename,state")->select();
                    $statuesss = '';
                    if(!empty($photoarray)){
                        foreach ($photoarray as $ooo) {
                            $statuesss .= '('.$ooo[devicename].'-'.$statue[$ooo[state]].')';
                        }
                    }

                    $valuezz[photo] .="<a href='".$kkk[photo]."' target='_Blank'>图片".$i++."</a>".$statuesss;
                    if($i>1){
                        $valuezz[photo] .="<br>";
                    }
                }
            }
        }
        foreach ($teachers as &$valuesz){
            $device=M('FacePersonDeviceRelation')
                ->alias("fdr")
                ->join('wxt_face_device fd ON fd.Id=fdr.deviceid')
                ->where("fdr.personid = '$valuesz[personid]'")
                ->field("fd.name")
                ->select();
            $valuez[device]= '';
            if(empty($device)){
                $valuesz[device]= '未授权';
            }else{
                $i=1;
                foreach ($device as $jjj){
                    $valuesz[device] .=$jjj[name]."已授权";$i++;
                    if($i>1){
                        $valuesz[device] .="<br>";
                    }
                }
            }
        }

        $this->assign("Province",$Province);
        $this->assign("city",$city);
        $this -> assign("tiaojian",$get_keywordtype);
        $this->assign("keyword",$get_keyword);
        $this->assign("schools",$school);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
        $this->assign("teachers",$teachers);
    }

    private function _lists_school_parent_person()
    {


        $schoolid = I("schoolid");

        $tiaojian = I("tiaojian");
        $shuzhi = I("shuzhi");
        $province = I("province");

        $citys = I('citys');

        $message_type = I('message_type');

        $Province=role_admin();
        $this->assign("Province",$Province);
        $gradeid=I('grade');
        $classid=I('classs');
        if($province && $citys && $message_type && $schoolid)
        {
            write_condition($province,$citys,$message_type,$schoolid,$this->only_code);
        }elseif(!$tiaojian){
            S($this->only_code,null);
            $this->assign("Province",$Province);
            $this -> display('add_school_parent_person');
            exit();
        }

        $this -> assign("tiaojian",$tiaojian);
        $this -> assign("shuzhi",$shuzhi);
        if($schoolid)
        {
            $this->assign("schoolid",$schoolid);
        }

        if($province)
        {
            $this->assign("province",$province);
        }

        if($citys){
            $this->assign("new_citys",$citys);
        }
        if($message_type)
        {
            $this->assign("new_message_type",$message_type);
        }

        if($gradeid)
        {
            $this->assign("new_grade",$gradeid);
        }
        if($classid && $gradeid)
        {
            $this->assign("new_classs",$classid);
        }
        $Page = '';
        $binding='';
        if($schoolid || ($tiaojian && $zui))
        {
            if($schoolid)
            {
                $where["c.schoolid"] = $schoolid;
            }
            if($gradeid)
            {
                $where['sc.grade'] = $gradeid;
            }
            if($classid)
            {
                $where['sc.id'] =$classid;
            }
            if($shuzhi) {
                switch ($tiaojian)  // 通过function_num_args()函数计算传入参数的个数，根据个数来判断接下来的操作
                {
                    case name:
                        $where['info.stu_name'] = array('like', "%$shuzhi%");
                        break;
                    case names:
                        $where['u.NAME'] = array('like', "%$shuzhi%");
                        break;
                    case phone:
                        $where['u.phone'] = array('like', "%$shuzhi%");
                        break;
                    default:
                        ;
                }
            }

            $count = M("class_relationship")
                ->alias("c")
                ->join("wxt_school_class sc ON sc.id=c.classid")
                ->join("wxt_student_info info ON c.userid = info.userid")
                ->join("wxt_relation_stu_user rel ON info.userid=rel.studentid")
                ->join("LEFT JOIN wxt_wxtuser u ON rel.userid = u.id")
                ->field("info.userid,c.schoolid,c.classid,c.schoolid,info.stu_name,u.phone,sc.classname,u.name as parent_name,rel.appellation,rel.userid as parentid,rel.userid as parentid")
                ->where($where)
                ->count();
            $page = $this -> page($count, 50);


            $binding = M("class_relationship")
                ->alias("c")
                ->join("wxt_school_class sc ON sc.id=c.classid")
                ->join("wxt_student_info info ON c.userid = info.userid")
                ->join("wxt_relation_stu_user rel ON info.userid=rel.studentid")
                ->join("LEFT JOIN wxt_wxtuser u ON rel.userid = u.id")
                ->field("info.userid,c.schoolid,c.classid,c.schoolid,info.stu_name,u.phone,sc.classname,u.name as parent_name,rel.appellation,rel.userid as parentid,rel.userid as parentid")
                ->where($where)
                -> limit($page -> firstRow . ',' . $page -> listRows)
                ->select();

            $Page =  $page -> show('Admin');
        }
        foreach ($binding as &$value) {
            $userid = $value['parentid'];
            $card = M('student_card')->where("personId = $userid and handletype = 1 and schoolid  = $schoolid")->field("cardNo")->find();
            $value['cardno'] = $card['cardno'];
        }
        foreach ($binding as &$schoolname) {
            $schoolnames = M('School')->where("schoolid = $schoolname[schoolid]")->field("school_name")->find();
            $schoolname['school_name'] = $schoolnames['school_name'];
        }

        $statue['1'] = "已上传";
        $statue['2'] = "注册中";
        $statue['3'] = "注册成功";
        $statue['4'] = "注册失败";
        foreach ($binding as &$person){
            $person['id'] = $person['parentid'];
            $personss = M("FacePerson")->where("userid = $person[id]")->field("Id as personid,guid,appid,create_time")->find();
            $person['personid'] = $personss[personid];
            $person['appid'] = $personss[appid];
            $person['guid'] = $personss[guid];
            $person['create_time'] = $personss[create_time];
        }
        foreach ($binding as &$valuezz){
            $photo=M('FacePhoto')->where("guid = '$valuezz[guid]'")->select();
            $valuezz[photo]= '';
            if(empty($photo)){
                $valuezz[photo]= '没有照片';
            }else{
                $i=1;
                foreach ($photo as $kkk){
                    $photoarray=M('FacePhotoDeviceRelation')->where("photoguid = '$kkk[photoguid]'")->field("devicename,state")->select();
                    $statuesss = '';
                    if(!empty($photoarray)){
                        foreach ($photoarray as $ooo) {
                            $statuesss .= '('.$ooo[devicename].'-'.$statue[$ooo[state]].')';
                        }
                    }

                    $valuezz[photo] .="<a href='".$kkk[photo]."' target='_Blank'>图片".$i++."</a>".$statuesss;
                    if($i>1){
                        $valuezz[photo] .="<br>";
                    }
                }
            }
        }
        foreach ($binding as &$valuesz){
            $device=M('FacePersonDeviceRelation')
                ->alias("fdr")
                ->join('wxt_face_device fd ON fd.Id=fdr.deviceid')
                ->where("fdr.personid = '$valuesz[personid]'")
                ->field("fd.name")
                ->select();
            $valuez[device]= '';
            if(empty($device)){
                $valuesz[device]= '未授权';
            }else{
                $i=1;
                foreach ($device as $jjj){
                    $valuesz[device] .=$jjj[name]."已授权";$i++;
                    if($i>1){
                        $valuesz[device] .="<br>";
                    }
                }
            }
        }

        $this->assign("Page", $Page);
        $this->assign("parent",$binding);
    }

    //批量添加学生人员页面
    public function add_school_person()
    {
        $this->_lists_school_person();
        $this->display();
    }
    //批量添加教师人员页面
    public function add_school_teacher_person()
    {
        $this->_lists_school_teacher_person();
        $this->display();
    }
    //批量添加家长人员页面
    public function add_school_parent_person()
    {
        $this->_lists_school_parent_person();
        $this->display();
    }
    //添加人员提交,学生家长老师通用
    public function add_school_person_post()
    {
        $userid  = I("userid");
        $name  = I("name");
        $phone  = I("phone");
        $cardno  = I("cardno");
        $schoolid  = I("school");
        if(empty($userid) || empty($schoolid))
        {
            $this->error("参数不足！");
            return;
        }
        $application = M("FaceSchoolDevice")
            ->alias(fsd)
            ->join("wxt_face_school fs ON fs.Id=fsd.faceschoolid")
            ->join("wxt_face_device fd ON fd.id=fsd.deviceid")
            ->join("wxt_face_application fa ON fa.id=fd.applicationid")
            ->where("fs.schoolid = '$schoolid' and fs.state=1")
            ->field("fa.id,fa.appid")
            ->find();

        if(empty($application))
        {
            $this->error("该学校未挂靠人脸识别设备");
            return;
        }

        //导入的时候批量授权
       // $device = M("FaceSchoolDevice")->alias(fsd)->join("wxt_face_device fd ON fd.id=fsd.deviceid")->where("fsd.schoolid = '$schoolid'")->field("fd.devicekey,fsd.deviceid")->select();

        $id=$application[id];
        $appid=$application[appid];
        $token = $this->getfacetoken($id);
        $datass["authstatus"]=1;
        $count=count($userid);
        for($i=0;$i<$count;$i++){

            $isperson = M("face_person")->where("userid = '$userid[$i]'")->find();
            if(empty($isperson)) {
                $data["userid"] = $userid[$i];
                $data["schoolid"] = $schoolid;
                $data["name"] = $name[$i];
                $data["phone"] = $phone[$i];
                $data["idNo"] = $cardno[$i];
                $data["type"] = 0;
                $data["create_time"] = date('Y-m-d H:i:s', time());
                $data["create_time_int"] = time();
                $data["appid"] = $id;
                $data["authstatus"] = 1;  //授权状态，1未授权，2已授权
                $query = M("face_person")->add($data);

                $person = $this->insert_person($appid, $token, $name[$i], $cardno[$i], $phone[$i], '');
                if ($person[success]) {
                    $datas[guid] = $person[data][guid];
                    M("face_person")->where("id = '$query'")->save($datas);
                    //  foreach ($device as $value){
                    //导入的时候批量授权
                    //  $devicesuth = $this->person_devices_authorize($appid,$token,$value[devicekey],$person[data][guid]);
                    //     if($person[success]){
                    //         $datas[personid]=  $query;
                    //         $datas[deviceid]=  $value[deviceid];
                    //         M("FacePersonDevice")->add($datas);
                    //        M(face_person)->where("authstatus = 1 and id = '$query' ")->save($datass);
                    //    }
                    // }
                }
            }
        }
        $this->success("注册成功！");
        exit;

    }
    //根据学校，年级，班级来添加人员注册,学生用
    public function add_school_person_post_s()
    {
        $schoolid = I('schoolidss');
        $classid = I('classsss');
        $gradeid = I('gradess');
        if(empty($schoolid))
        {
            $this->error("未获取到选择学校");
            return;
        }

        $applicationid=M("FaceSchool")
            ->alias("fs")
            ->join("wxt_face_school_device fsd on fsd.faceschoolid = fs.Id")
            ->join("wxt_face_device fd on fd.Id=fsd.deviceid")
            ->where("fs.schoolid = $schoolid")
            ->field("fd.applicationid")
            ->find();
        if(empty($applicationid)){
            $this->error("该学校尚未添加设备，无法获取所属应用");
            return;
        }
        $aid=$applicationid['applicationid'];
        $application = $this->face_application_model->where(array("id"=>$aid))->find();
        $appid = $application["appid"];
        $token = $this->getfacetoken($aid);


        $where['schoolid']=$schoolid;
        if($classid){
            $where['sc.id']=$classid;
        }
        if($gradeid){
            $where['sc.grade']=$gradeid;
        }
        $user = M("StudentInfo")
            ->alias("si")
            ->join("wxt_school_class sc on sc.id=si.classid")
            ->where($where)
            ->distinct(true)
            ->field('si.userid,si.stu_name')
            ->select();
        foreach ($user as &$phonearray){
            $result= M("RelationStuUser")->where("studentid = '$phonearray[userid]' and type = 1 ")->field("phone")->find();
            $phonearray['phone']=$result['phone'];
        }
        foreach ($user as &$cardarray){
            $result= M("StudentCard")->where("schoolid = '$schoolid' and personId = '$cardarray[userid]' and handletype = 1 ")->field("cardNo")->find();
            $cardarray['cardno']=$result['cardno'];
        }


        foreach ($user as $value){

            $isperson = M("face_person")->where("userid = '$value[userid]'")->find();
            if(empty($isperson)) {
                $data["userid"] = $value['userid'];
                $data["schoolid"] = $schoolid;
                $data["name"] = $value['stu_name'];
                $data["phone"] = $value['phone'];
                $data["idNo"] = $value['cardno'];
                $data["type"] = 0;
                $data["create_time"] = date('Y-m-d H:i:s', time());
                $data["create_time_int"] = time();
                $data["appid"] = $aid;
                $data["authstatus"] = 1;  //授权状态，1未授权，2已授权
                $query = M("face_person")->add($data);

                $person = $this->insert_person($appid, $token, $value['stu_name'], $value['cardno'], $value['phone'], '');
                if ($person[success]) {
                    $datas[guid] = $person[data][guid];
                    M("face_person")->where("id = '$query'")->save($datas);

                }else{
                    dump($person);
                }
            }
        }
        $this->success("注册成功！");
        exit;

    }
    //修改人员提交
    public function edit_person_post()
    {

        $appid = I("appid"); //应用ID
        $guid  = I("guid");//人员名称
        $idno  = I("idno");//卡号
        $phone = I("phone");//电话
        $type  = I("type");//类型
        $name  = I("name");//类型
        $person = M("FacePerson")->where("guid = '$guid'")->find();
        if(($idno == $person[idno]) && ($phone == $person[phone]) && ($type == $person[type]) && ($name == $person[name])){
            $this->success("修改成功！未做任何改变");
            exit;
        }
        $application = $this->face_application_model->where(array("AppId"=>$appid))->find();
        $id = $application["id"];
        //获取$token
        $token = $this->getfacetoken($id);
        $upperson = $this->updata_person($appid,$token,$guid,$name,$idno,$phone,'',$type);
        if($upperson[success]){
            $datas['idno']=$idno;
            $datas['phone']=$phone;
            $datas['type']=$type;
            $datas['name']=$name;
            M("FacePerson")->where("guid = '$guid'")->save($datas);
            $this->success("人员资料更新成功！");
            exit;
        }else{
            $this->error("人员更新至服务器失败！");
            exit;
        }
    }
    //编辑人员
    public function edit_person()
    {
        $statue['1'] = "已上传";
        $statue['2'] = "注册中";
        $statue['3'] = "注册成功";
        $statue['4'] = "注册失败";
        $personid = I("personid");
        $person = M("FacePerson")
            ->alias("fp")
            ->join("wxt_face_application fa ON fa.Id=fp.appid")
            ->where("fp.id = $personid")
            ->field("fa.name as appname,fp.name as personname,fp.idNo,fp.phone,fp.guid,fp.type,fa.AppId,fa.Id as applicationid")
            ->find();
        $guid=$person[guid];
        $photo = M("FacePhoto")->where("guid = '$guid'")->select();
        $html ='';
        $token = $this->getfacetoken($person[applicationid]);
        foreach ($photo as $value){
            $photosss = '';
            $resalute = $this->query_faces_status($person[appid],$token,'',$value[guid],$value[photoguid]);
            if($resalute[success]){
                $photostatus = $resalute[data];
                M('FacePhotoDeviceRelation')->where("photoguid = '$value[photoguid]'")->delete();
                foreach ($photostatus as $values){
                    $photodevice = M('FacePhotoDeviceRelation')->where("devicekey = '$values[deviceKey]' and photoguid = '$values[faceGuid]'")->find();

                    if($photodevice[state] == $values[state]){
                        $photosss .="(".$photodevice[devicename].$statue[$values[state]].")<br>";
                    }else{
                        if(empty($photodevice)){
                            $devicename = M("FaceDevice")->where("deviceKey = '$values[deviceKey]'")->field("name")->find();
                            $data['photoguid'] = $values[faceGuid];
                            $data['deviceKey'] = $values[deviceKey];
                            $data['devicename'] =$devicename[name] ;
                            $data['state'] =$values[state] ;
                            M("FacePhotoDeviceRelation")->add($data);
                            $photosss .="(".$devicename[name].$statue[$values[state]].")<br>";
                        }else{
                            $datas['state'] =$values[state] ;
                            M("FacePhotoDeviceRelation")->where("deviceKey = '$values[deviceKey]'")->save($datas);
                            $photosss .="(".$photodevice[devicename].$statue[$values[state]].")<br>";
                        }
                    }
                }
            }

            $html .="<div class='photodiv'><img src='".$value["photo"]."'/><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$photosss."&nbsp&nbsp&nbsp&nbsp<button class='btn btn-danger delphoto' data-guid='".$value["photoguid"]."' data-personguid='".$value["guid"]."'>删除</button></div>";
        }
        $Province=role_admin();
        $cache_data = get_condition_cache($this->only_code);
        $this -> assign("cache_data", $cache_data);
        $this->assign("Province",$Province);
        $this->assign("photohtml",$html);
        $this->assign("person",$person);
        $this->display();

    }
    //更新照片状态
    public function photo_up_status()
    {
        $userid = I("userid");
        foreach ($userid as $value){
            $personid = $value;
            if($personid) {
            $person = M("FacePerson")
                ->alias("fp")
                ->join("wxt_face_application fa ON fa.Id=fp.appid")
                ->where("fp.id = $personid")
                ->field("fa.name as appname,fp.name as personname,fp.idNo,fp.phone,fp.guid,fp.type,fa.AppId,fa.Id as applicationid")
                ->find();
                $guid = $person[guid];
                $photo = M("FacePhoto")->where("guid = '$guid'")->select();
                $token = $this->getfacetoken($person[applicationid]);
                foreach ($photo as $value) {
                    $resalute = $this->query_faces_status($person[appid], $token, '', $value[guid], $value[photoguid]);
                    if ($resalute[success]) {
                        $photostatus = $resalute[data];
                        M('FacePhotoDeviceRelation')->where("photoguid = '$value[photoguid]'")->delete();
                        foreach ($photostatus as $values) {
                            $photodevice = M('FacePhotoDeviceRelation')->where("devicekey = '$values[deviceKey]' and photoguid = '$values[faceGuid]'")->find();
                            if ($photodevice[state] !== $values[state]) {
                                if (empty($photodevice)) {
                                    $devicename = M("FaceDevice")->where("deviceKey = '$values[deviceKey]'")->field("name")->find();
                                    $data['photoguid'] = $values[faceGuid];
                                    $data['deviceKey'] = $values[deviceKey];
                                    $data['devicename'] = $devicename[name];
                                    $data['state'] = $values[state];
                                    M("FacePhotoDeviceRelation")->add($data);
                                } else {
                                    $datas['state'] = $values[state];
                                    M("FacePhotoDeviceRelation")->where("deviceKey = '$values[deviceKey]'")->save($datas);
                                }
                            }
                        }
                    }
                }
            }
        }
        $ret=array('status'=>'success');
        echo  json_encode($ret);
        exit;
    }
    //删除照片
    public function delete_photo()
    {
        $guid = $_GET["guid"];
        $personguid = $_GET["personguid"];

        $application = M("FacePerson")
            ->alias("fp")
            ->join("wxt_face_application fa ON fa.Id=fp.appid")
            ->where("fp.guid = '$personguid'")
            ->field("fa.id,fa.AppId")
            ->find();
        $appid = $application["appid"];
        $id = $application["id"];
        $token = $this->getfacetoken($id);
        $delphoto = $this->delete_face($appid,$token,$guid,$personguid);
        if($delphoto[success]){
            M("FacePhoto")->where("photoguid = '$guid'")->delete();
            $ret=array('status'=>'success');

        }else{
            $ret=array('status'=>'field',
                'msg'=>'从服务器删除失败');
        }
        echo  json_encode($ret);
        exit;

    }
    //上传图片
    public function upload_image()
    {
        $typeArr = array("jpg", "png");

        $path = "uploads/";

        if (isset($_POST)) {
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $name_tmp = $_FILES['file']['tmp_name'];
            if (empty($name)) {
                echo json_encode(array("error" => "您还未选择图片"));
                exit ;
            }
            $type = strtolower(substr(strrchr($name, '.'), 1));
            //获取文件类型

            if (!in_array($type, $typeArr)) {
                echo json_encode(array("error" => "清上传jpg或png类型的图片！"));
                exit ;
            }
            if ($size > (400 * 1024)) {

                echo json_encode(array("error" => "图片大小已超过400KB！"));
                exit ;
            }
            $appid = $_GET["appid"];
            $application = $this->face_application_model->where(array("AppId"=>$appid))->find();
            $id = $application["id"];
            $guid= $_GET["guid"];
            $base64_img = $this->base64EncodeImage($name_tmp);
            $token = $this->getfacetoken($id);
            $upphoto = $this->add_face($appid,$token,$guid,$base64_img);
            if($upphoto[success]){
                $photo=$this->query_faces($appid,$token,$guid);
                if($photo[success]) {
                    $data = $photo[data];
                    M('FacePhoto')->where("guid ='$guid'")->delete();
                    foreach ($data as $value){
                        $photoguid = $value['guid'];
                        $resault = M('FacePhoto')->where("photoguid ='$photoguid'")->find();
                        if(empty($resault)){
                            $datas['guid']=$guid;
                            $datas['photo']=$value['faceUrl'];
                            $datas['photoguid']=$value['guid'];
                            $datas['state']=1;
                            $datas['create_time']=date('Y-m-d H:i:s', time());
                            $datas['create_time_int']=time();
                            M('FacePhoto')->add($datas);
                        }
                    }
                    $photolast = M('FacePhoto')->where("guid = '$guid'")->select();

                    echo json_encode(array("error" => "0", "data" => $photolast));
                }else{
                    echo json_encode(array("error" => "上传成功！但从服务器获取图片地址失败"));
                }
            }else{
                echo json_encode(array("error" => "上传至服务器失败"));
            }
        }
exit;
    }
    //删除人员
    public function delete_person()
    {
        $guid = I("guid");
        $applicationid = I("appid");
        $application = $this->face_application_model->where(array("id"=>$applicationid))->find();
        $appid = $application["appid"];
        $token = $this->getfacetoken($applicationid);
        $person = $this->person_delete($appid,$token,$guid);

        if($person[success]){
            $persondel=M('FacePerson')->where("guid = '$guid'")->find();
            M('FacePersonDeviceRelation')->where("personid = $persondel[id]")->delete();
            $phootodel=M('FacePhoto')->where("guid = '$guid'")->select();
            if($phootodel){
            foreach ($phootodel as $value){
                $photoguid = $value[photoguid];
                M('FacePhotoDeviceRelation')->where("photoguid = '$photoguid'")->delete();
            }
            }
            M('FacePhoto')->where("guid = '$guid'")->delete();
            M('FacePerson')->where("guid = '$guid'")->delete();
            $ret=array('status'=>'success');
        }else{
            $ret=array('status'=>'field',
                'msg'=>'删除失败');
        }
        echo  json_encode($ret);
        exit;
    }
    //设备授权人员
    public function device_person_auth()
    {
        $userid = I('userid');
        $applicationid = I('appids');
        $deviceid = I('group');

        if(empty($deviceid)){
            $ret=array('status'=>'field',
                'msg'=>'未选择设备');
            echo  json_encode($ret);
            exit;
        }

        $application = $this->face_application_model->where(array("id"=>$applicationid))->find();
        $appid = $application["appid"];
        $token = $this->getfacetoken($applicationid);
        $userids = explode(',',$userid);

        foreach ($deviceid as $valdel) {
            $device = M('FaceDevice')->where(array("Id" => $valdel))->find();
            $deviceKey = $device["devicekey"];

            foreach ($userids as $value) {
                $person = M('FacePerson')->where(array("Id" => $value))->find();
                $personGuid = $person['guid'];
                $person = $this->person_devices_authorize($appid, $token, $deviceKey, $personGuid);
                if ($person[success]) {
                    $datas['authstatus'] = 2;
                    M('FacePerson')->where(array("Id" => $value))->save($datas);
                    $data[personid] = $value;
                    $data[deviceid] = $valdel;
                    $restult = M("FacePersonDeviceRelation")->where($data)->find();
                    if (empty($restult)) {
                        M("FacePersonDeviceRelation")->add($data);
                    }
                }
            }
        }
        $ret=array('status'=>'success');
    echo  json_encode($ret);
    exit;

    }

    //学校批量设备授权人员
    public function device_school_person_auth()
    {
        $schoolid = I('schoolidssz');
        $classid = I('classsssz');
        $gradeid = I('gradessz');
        $deviceid = I('group');

        if(empty($deviceid)){
            $ret=array('status'=>'field',
                'msg'=>'未选择设备');
            echo  json_encode($ret);
            exit;
        }
        if(empty($schoolid)){
            $ret=array('status'=>'field',
                'msg'=>'未选择学校');
            echo  json_encode($ret);
            exit;
        }
        $where['schoolid']=$schoolid;
        if($classid){
            $where['sc.id']=$classid;
        }
        if($gradeid){
            $where['sc.grade']=$gradeid;
        }

        $user = M("StudentInfo")
            ->alias("si")
            ->join("wxt_school_class sc on sc.id=si.classid")
            ->join("wxt_face_person fp on fp.userid=si.userid")
            ->where($where)
            ->distinct(true)
            ->field('fp.Id')
            ->select();
        $applicationid=M("FaceSchool")
            ->alias("fs")
            ->join("wxt_face_school_device fsd on fsd.faceschoolid = fs.Id")
            ->join("wxt_face_device fd on fd.Id=fsd.deviceid")
            ->where("fs.schoolid = $schoolid")
            ->field("fd.applicationid")
            ->find();
        $application = $this->face_application_model->where(array("id"=>$applicationid['applicationid']))->find();
        $appid = $application["appid"];
        $token = $this->getfacetoken($applicationid['applicationid']);


        foreach ($deviceid as $valdel) {
            $device = M('FaceDevice')->where(array("Id" => $valdel))->find();
            $deviceKey = $device["devicekey"];

            foreach ($user as $value) {
                $person = M('FacePerson')->where(array("Id" => $value[id]))->find();
                $personGuid = $person['guid'];
                $data[personid] = $value[id];
                $data[deviceid] = $valdel;
                $restult = M("FacePersonDeviceRelation")->where($data)->find();
                if(empty($restult)) {
                    $person = $this->person_devices_authorize($appid, $token, $deviceKey, $personGuid);
                    if ($person[success]) {
                        $datas['authstatus'] = 2;
                        M('FacePerson')->where(array("Id" => $value[id]))->save($datas);
                        M("FacePersonDeviceRelation")->add($data);
                    }
                }
            }
        }
        $ret=array('status'=>'success');
        echo  json_encode($ret);
        exit;

    }

    //获取设备列表
    public function showdevice()
    {
        $applicationid = I("applicationid");
        $device = M("FaceDevice")->where("applicationid = '$applicationid'")->field("id,name")->select();
        if($device){
            $ret=array('status'=>'success',
                'data'=>$device);
        }else{
            $ret=array('status'=>'field',
                'data'=>'查询失败');
        }
        echo  json_encode($ret);
        exit;
    }

    //获取学校设备列表
    public function showschooldevice()
    {
        $schoolid= I("schoolid");
        $device = M("FaceSchoolDevice")
            ->alias(fsd)
            ->join("wxt_face_school fs ON fs.Id=fsd.faceschoolid")
            ->join("wxt_face_device fd ON fd.id=fsd.deviceid")
            ->where("fs.schoolid = '$schoolid' and fs.state=1")
            ->field("fd.id,fd.name")
            ->select();
        if($device){
            $ret=array('status'=>'success',
                'data'=>$device);
        }else{
            $ret=array('status'=>'field',
                'data'=>'查询失败');
        }
        echo  json_encode($ret);
        exit;
    }
    //批量添加照片
    public function upload_photo_s()
    {
        $schoolid = I("schoolid");
        $province = I("province");
        $citys = I('citys');
        $message_type = I('message_type');

        if($province && $citys && $message_type && $schoolid) {
            write_condition($province, $citys, $message_type, $schoolid, $this->only_code);
        }
            $Province=role_admin();
        $cache_data = get_condition_cache($this->only_code);
        $this -> assign("cache_data", $cache_data);
        $this->assign("Province",$Province);


        if($cache_data){
            $schoolids = $cache_data[schoolid];
            $schoolname = M("School")->where("schoolid = '$schoolids'")->field('school_name')->find();
        }
        $this->assign("schoolname",$schoolname[school_name]);
        $this->display();
    }
    //批量添加照片提交
    public function upload_photo_s_post()
    {
        $schoolid = $_GET["schoolid"];
        if(empty($schoolid)){
            echo json_encode(array('success'=>2,"date"=>"未获取到学校，请刷新页面重试"));
            exit ;
        }
        if ($_FILES){
            $typeArr = array("jpg", "png","jpeg","bmp");



                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $name_tmp = $_FILES['file']['tmp_name'];
                if (empty($name)) {
                    echo json_encode(array("error" => "您还未选择图片"));
                    exit ;
                }
                $type = strtolower(substr(strrchr($name, '.'), 1));
                //获取文件类型
            $photoarray = explode('-',$name);
            $count=count($photoarray);
            if($count !== 3){
                echo json_encode(array('success'=>2,"date"=>$name."不符合命名规范，请重命名后上传。小一班-张三-1.jpg"));
                exit ;
            }
            if (!in_array($type, $typeArr)) {
                echo json_encode(array('success'=>2,"date"=>$name."清上传jpg或png类型的图片！"));
                exit ;
            }
            if ($size > (400 * 1024)) {
                $sizes = $size/1024;
                echo json_encode(array('success'=>2,"date"=>$name."压缩失败，图片大小已超过400KB！".$sizes."kb"));
                exit ;
            }
            $classname = $photoarray[0];
            $personname = $photoarray[1];

            $person = M("SchoolClass")
                ->alias("sc")
                ->join("wxt_class_relationship cr on cr.classid = sc.id")
                ->join("wxt_face_person fp on fp.userid =cr.userid")
                ->where("sc.schoolid = '$schoolid' and sc.classname = '$classname' and fp.name='$personname'")
                ->field("fp.appid,fp.guid")
                ->select();
            if(empty($person)){
                echo json_encode(array('success'=>2,"date"=>$name."未找到该学生，请先发布至云端后再添加照片"));
                exit ;
            }
            $counts = count($person);
            if($counts>1){
                echo json_encode(array('success'=>2,"date"=>$name."该班已发布的该学生存在同名同姓，请手动添加图片"));
                exit ;
            }
                $id = $person[0][appid];
                $guid= $person[0][guid];
                $application = $this->face_application_model->where(array("Id"=>$id))->find();
                $appid = $application["appid"];
                $base64_img = $this->base64EncodeImage($name_tmp);
                $token = $this->getfacetoken($id);
                $upphoto = $this->add_face($appid,$token,$guid,$base64_img);
                if($upphoto[success]){
                    $photo=$this->query_faces($appid,$token,$guid);
                    if($photo[success]) {
                        $data = $photo[data];
                         M('FacePhoto')->where("guid ='$guid'")->delete();
                        foreach ($data as $value){
                            $photoguid = $value['guid'];
                            $resault = M('FacePhoto')->where("photoguid ='$photoguid'")->find();
                            if(empty($resault)){
                                $datas['guid']=$guid;
                                $datas['photo']=$value['faceUrl'];
                                $datas['photoguid']=$value['guid'];
                                $datas['state']=1;
                                $datas['create_time']=date('Y-m-d H:i:s', time());
                                $datas['create_time_int']=time();
                                M('FacePhoto')->add($datas);
                            }
                        }
                        $photolast = M('FacePhoto')->where("guid = '$guid'")->select();

                        echo json_encode(array('success'=>1,"date"=>$name."上传成功"));
                        exit;
                    }else{
                        echo json_encode(array('success'=>2,"date"=>$name."上传成功！但从服务器获取图片回调地址失败"));
                        exit;
                    }
                }else{
                    echo json_encode(array('success'=>2,"date"=>$name."上传至服务器失败！".$upphoto[msg]));
                    exit;
                }

        }
        else{
            echo json_encode(array('success'=>2,"date"=>"未获取到图片"));
            exit;
        }

    }

    //把图片转换成bate64
    private function base64EncodeImage ($image_file) {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = chunk_split(base64_encode($image_data));
        return $base64_image;
    }
    /**    delete 人员照片删除
    *     appId	  应用Id	       String	Y
          token	  调用接口凭证   String	Y
          guid	  照片的 id	String	Y
          personGuid	照片所属人员 id	String	Y
          返回结果: code : GS_SUS601 //
          //人员照片删除接口调用成功，云端存储的照片删除，若设备在线，则从设备上删除照片；若设备离线，则联网后自动进行照片删除
    */
    private function delete_face($appid,$token,$guid,$personGuid)
    {
        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "guid"=>$guid,
            "personGuid"=>$personGuid
        );
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/person/".$personGuid."/face/".$guid;

        $res = $this->http_request_delete($url,$data);
        $result = json_decode($res,true);
        return $result;
    }
    /**    put 人员更新接口
     *     appId 	应用Id 	String 	Y
           token 	调用接口凭证 	String 	Y
           guid 	人员编号 	String 	Y
           name 	人员姓名 	String 	N
           idNo 	卡号（IC卡／身份证） 	String 	N
           phone 	人员手机号 	String 	N
           tag 	人员标签 	String 	N
           type 	人员类型 	Int 	N 	可自行定义，支持正整数，0没有意义
    返回结果: code : GS_SUS601 //
    //人员照片删除接口调用成功，云端存储的照片删除，若设备在线，则从设备上删除照片；若设备离线，则联网后自动进行照片删除
     */
    private function updata_person($appid,$token,$guid,$name,$idno,$phone,$tag = null,$type)
    {
        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "guid"=>$guid,
            "name"=>$name,
            "idno"=>$idno,
            "phone"=>$phone,
            "tag"=>$tag,
            "type"=>$type
        );
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/person/".$guid;

        $res = $this->http_request_put($url,$data);
        $result = json_decode($res,true);
        return $result;
    }
    /**     get      人员照片查询
     *     appId	  应用Id	       String	Y
           token	  调用接口凭证   String	Y
           guid       照片所属人员的id	String	Y
           返回结果: code : GS_SUS207 //人员照片查询接口调用成功
     */
    private function  query_faces($appid,$token,$guid)
    {
        $data = "?appId=".$appid."&token=".$token."&guid=".$guid;
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/person/".$guid."/faces.$data";

        $res = $this->http_request_get($url);
        $result = json_decode($res,true);
       return $result;
    }
    /**     get      人员照片查询
     *     appId	  应用Id	       String	Y
    token	  调用接口凭证   String	Y
    guid       照片所属人员的id	String	Y
    返回结果: code : GS_SUS207 //人员照片查询接口调用成功
     */
    private function  query_faces_status($appid,$token,$deviceKey,$personGuid,$guid)
    {
        $data = "?appId=".$appid."&token=".$token."&deviceKey=".$deviceKey."&personGuid=".$personGuid."&guid=".$guid;
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/person/".$personGuid."/face/".$guid."/state.$data";

        $res = $this->http_request_get($url);
        $result = json_decode($res,true);
        return $result;
    }
    /**    POST 人员照片注册接口
    *     appId	应用Id	String	Y
          token	调用接口凭证	String	Y
          guid	照片所属人的 id	String	Y
          img	照片数据（ base64编码）	String	Y	图片编码为 base64 字符串 不加头部，如：data:image/jpg;base64
          type	照片类型	Byte	N	1：普通 RGB 照片，默认；
                                    2：红外照片， 特定设备型号使用；
                                       若传入type字段，则内容不可为空
          useUFaceCloud	服务器端照片检测	Boolean	N	传入false为不检测注册照片，传入true检测注册照片是否符合；若不传入useUFaceCloud字段，则默认为不检测照片
           返回结果: code : GS_SUS600 //人员照片注册接口调用成功，照片成功录入云端服务器，人员-照片关系绑定
           返回结果: code : GS_EXP-212 //人员不存在
           照片要求  1.图片尺寸为640*480左右
                    2.图片中只有一个人脸
                    3.图片中人脸端正
                    4.图片中人脸占图片30%以上
                    5.图片大小不超过400K
           注册成功后会返回服务器分配的照片编号guid（简称照片id），照片所属人员id（personGuid）等
           当图片超过三张 返回 GS_EXP-606
    */
    private function add_face($appid,$token,$guid,$img)
    {
        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "guid"=>$guid,
            "img"=>$img
        );
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/person/".$guid."/face";
        $res = $this->http_request_post($url,$data);
        $result = json_decode($res,true);
        return $result;
    }
    /**    DELETE 人员删除
     *      appId	应用Id	String	Y
    token	调用接口凭证	String	Y
    guid	    需授权的人员	String	Y
    返回结果: "code": "GS_SUS201",//人员删除接口调用成功
     */
    private function person_delete($appid,$token,$guid)
    {
        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "guid"=>$guid
        );
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/person/".$guid;

        $res = $this->http_request_delete($url,$data);
        $result = json_decode($res,true);
        return $result;
    }
    /**    POST 人员设备授权
    *      appId	应用Id	String	Y
           token	调用接口凭证	String	Y
           guid	    需授权的人员	String	Y
           deviceKeys	所有需授权的设备	String	Y	deviceKey 通过英文逗号拼接而成
           passTime	允许进入的时间段	String	N	范围为[00:00:00,23:59:59]，格式说明见备注
           返回结果: code : GS_SUS204 //人员录入接口调用成功，人员信息存入云端服务器
    */
    private function person_devices_authorize($appid,$token,$deviceKeys,$guid,$passTime = null)
    {
        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "guid"=>$guid,
            "deviceKeys"=>$deviceKeys
        );
        if($passTime){
            $data[passTime]=$passTime;
        }
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/person/".$guid."/devices";

        $res = $this->http_request_post($url,$data);
        $result = json_decode($res,true);
        return $result;
    }
    /**    POST      人员录入
    *      appId	应用Id	    String	Y
           token	调用接口凭证	String	Y
           name	    人员姓名  	String	Y
           idNo	    IC卡/身份证卡号	String	N
           phone	人员手机号	String	N
           tag	    人员标签	    String	N	可自行定义
           type	    人员类型	    Int	    N	可自行定义 ,支持正整数，0没有意义
           人员姓名格式：name 限制32个字符，只允许数字、英文、中文、中英文符号；名字过长可能会导致屏幕显示不下
           返回结果: code : GS_SUS200 //人员录入接口调用成功，人员信息存入云端服务器
           返回    guid  人员ID等
    */
    private function insert_person($appid,$token,$name,$idno,$phone,$type)
    {
        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "name"=>$name
        );
        if($idno){
            $data[idNo]=$idno;
        }
      if($phone){
          $data[phone]=$phone;
      }
        if($type){
            $data[type]=$type;
        }
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/person";

        $res = $this->http_request_post($url,$data);
        $result = json_decode($res,true);
        return $result;
    }
    //获取token
    private function getfacetoken($id)
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
            $res =$this->http_request_post($url,$data);
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
    private function http_request_post($url, $data = array())
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
    private function http_request_get($url){
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
    private function http_request_put($url, $data = array())
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
    private function http_request_delete($url,$data){
        $ch = curl_init();
        curl_setopt ($ch,CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}