<?php

/**
 * 后台首页  学校信息管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class StudentController extends AdminbaseController {
    protected $relation_stu_class_model;
    protected $terms_model;
    function _initialize() {
        parent::_initialize();
        $this -> school_model = D("Common/School");
        $this -> class_model = D("Common/school_class");
        $this -> class_relationship_model = D("Common/class_relationship");
        $this -> appellation_model = D("Common/appellation");
        $this -> wxtuser_model = D("Common/wxtuser");
        $this -> relation_stu_user_model = D("Common/relation_stu_user");
        $this -> student_info_model = D("Common/student_info");
        $this -> relation_stu_class_model = D("Common/class_relationship");
        $this->only_code = strtolower(MODULE_NAME).'_'.strtolower(CONTROLLER_NAME);

    }

    function index() {
        $this -> _lists();
        $this -> _getTree();
        $this -> display();
    }

    /**
     *Autor:郭小康
     *data:2016-6-19
     */
    /*--------------------------学生家长列表start---------------------------*/
    public function parentlist() {
        $studentid = $_GET['id'];
        if ($studentid) {
            $schoolid = M("StudentInfo")->where("userid = $studentid")->Field("schoollid as schoolid,stu_name")->find();
            $rst = $this -> wxtuser_model -> alias("user") -> join("wxt_relation_stu_user su ON user.id=su.userid") -> where("su.studentid=$studentid") -> field('su.id as rel_id,user.id as parent_id,su.name as parent_name,user.phone,su.appellation,su.type') -> select();
            $this -> assign("studentid", $studentid);
            $this -> assign("stu_name", $schoolid['stu_name']);
            $this -> assign("userinfo", $rst);
            $this -> assign("schoolid",$schoolid['schoolid']);
            $this -> display("parentlist");
        } else {
            $this -> error('数据传入失败！');
        }
        exit;
    }

    //------------------学生家长列表end----------------

    //------------------添加家长start----------------
    public function addparent() {
         //获取学生id
        $studentid = $_GET['studentid'];
        $schoolid = $_GET['schoolid'];
        //获取schoolid
        $users = $this -> relation_stu_user_model -> order(array("studentid" => "asc")) -> select();
        $relation = $this -> appellation_model -> order(array("id" => "asc")) -> select();
        $this -> assign("users", $users);
        $this -> assign("relation", $relation);
        $this -> assign("studentid", $studentid);
        $this -> assign("schoolid",$schoolid);
        $this -> display();
        exit;
    }




    public function addparent_post() {
        //$studentid=intval($_GET['student_id']);
        if (IS_POST) {

            $phone = $_POST['phone'];
            $schoolid = $_POST['schoolid'];
            if(!$phone)
            {
                $this->error("手机号码不能为空!");
                exit();
            }

            if(!$_POST['appe'])
            {
                $this->error("请选择关系!");
                exit();
            }
            //如果新存的家长在用户表中已经存在
            $user_id = $this -> wxtuser_model -> where("phone=$phone") -> getField('id');
            if ($user_id) {
                $u_data['studentid'] = $_POST['studentid'];
                $u_data['userid'] = $user_id;
                $u_data['name'] = $_POST['user_name'];
                $u_data['phone'] = $_POST['phone'];
                $u_data['time'] = time();
                $appellationname_where['id'] = $_POST['appe'];
                $appellation_info = $this -> appellation_model -> where($appellationname_where) -> getField('appellation_name');
                $u_data['appellation'] = $appellation_info;
                $rst = $this -> relation_stu_user_model -> add($u_data);
                if ($rst) {
                    $this -> error('保存成功');
                } else {
                    $this -> error("保存失败！");
                }
            } else {
                //如果新存的家长在用户表中未存在
                $s_data['name'] = $_POST['user_name'];
                $s_data['phone'] = $_POST['phone'];
                $s_data['schoolid'] = $schoolid;
                $s_data['password'] = md5(substr($_POST['phone'], -6));
                $s_data['create_time'] = time();
                $res = $this -> wxtuser_model -> add($s_data);

                $new_id = $this -> wxtuser_model -> getLastInsID();
                $d_data['studentid'] = $_POST['studentid'];
                $d_data['userid'] = $new_id;
                $d_data['phone'] = $_POST['phone'];
                $d_data['creattime'] = time();
                $d_data['name'] = $_POST['user_name'];
                $_appellationname = $_POST['appe'];
                $_appellation_info = $this -> appellation_model -> where("$_appellationname=id") -> getField('appellation_name');
                $d_data['appellation'] = $_appellation_info;
                $rus = $this -> relation_stu_user_model -> add($d_data);
                if ($res) {
                    $this -> error('保存成功');
                } else {
                    $this -> error("保存失败！");
                }
            }
        } else {
            $this -> error('error!');
        }

    }

    public function updateparent() {
        $studentid = I('studentid');
        if ($studentid) {
            $schoolid = M("StudentInfo")->where("userid = $studentid")->Field("schoollid as schoolid,stu_name")->find();
            $this -> assign("studentid", $studentid);
            $this -> assign("stu_name", $schoolid['stu_name']);
            $this -> assign("schoolid",$schoolid['schoolid']);
        } else {
            $this -> error('数据传入失败！');
        }
        $relationid = $_GET['rid'];
        $where['r.id'] = $relationid;
        $result = $this -> relation_stu_user_model
            -> alias('r')
            -> join("" . C('DB_PREFIX') . 'wxtuser as su on r.studentid = su.id')
            -> join("" . C('DB_PREFIX') . 'wxtuser as pu on r.userid = pu.id')
            -> field("r.id,r.studentid,r.userid as parentid,r.appellation,su.name as studentname,pu.name as parentname,pu.phone as parentphone")
            -> where($where) -> find();
        $relation = $this -> appellation_model -> order(array("id" => "asc")) -> select();
        $this -> assign("relationdata", $result);
        $this -> assign("relation", $relation);
        $this -> display();
        exit;
    }

    public function updateparent_post() {
        if (IS_POST) {
            $phone = $_POST['parentphone'];
            $parentid = $_POST['parentid'];
            $parentname = $_POST['parentname'];
            $relationid = $_POST['relationid'];
            $appe = $_POST['appe'];
            if ($parentid && $relationid && $appe) {
                //如果新存的家长在用户表中已经存在
                $where['phone'] = $phone;
                $where['id'] = array('NEQ', $parentid);
                //注释以下代码 一个学生开挂靠多个家长
                //如果新存的家长在用户表中未存在
                $s_data['name'] = $parentname;
                $s_data['phone'] = $phone;
                $s_where['id'] = $parentid;
                $res = $this -> wxtuser_model -> where($s_where) -> save($s_data);

                $appellationname_where['id'] = $appe;
                $appellation_info = $this -> appellation_model -> where($appellationname_where) -> getField('appellation_name');
                $u_data['appellation'] = $appellation_info;
                // $u_data['studentid']=$studentid;
                $u_data['userid'] = $parentid;
                $u_data['time'] = time();
                $pwhere['id'] = $relationid;
                $rst = $this -> relation_stu_user_model -> where($pwhere) -> save($u_data);
                if ($rst) {
                    $this -> error('保存成功');
                } else {
                    $this -> error("保存失败！");
                }
                $this -> error('lost param!');
            }
        } else {
            $this -> error('error!');
        }

    }


    //------------------IC卡相关-------------------------------

    //家长的点击查询
    public function chaxuan(){
        $userid=I("userid");
        if($userid){
            $ICcard=M("student_card")->where("personId=$userid and cardType=2 and handletype = 1")->field("cardno,personId,id")->select();

            $card_arr = array();

            $count = count($ICcard);

            $str = "";
            //如果家长卡号大于5的话,将数组拆分
            if($count > 5)
            {

                foreach ($ICcard as $key=>&$value)
                {
                    if($key>4)
                    {
                        $str = $value['cardno'].",".$str;
                        array_push($card_arr,$ICcard[$key]);
                        unset($ICcard[$key]);
                    }
                    if($key==$count-1)
                    {

                        array_push($ICcard,array('cardno'=>rtrim($str,",")));
                    }
                }



            }
            //重新定义key值
            $ICcard =   array_values($ICcard);


            echo json_encode(array('data'=>$ICcard,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>'-1','message'=>'数据请求失败'));
        }
    }

    //修改学生卡号

    public function updateICcard(){
        $schoolid=I('schoolid');
        //新的卡号
        $newCardNo = I('cardNo');
        //旧的学生卡
        $oldCardNo = I('stu_old_card');

        $showcard = get_showcard($newCardNo,$schoolid);
        //查询新的卡号是否已经被使用
        if($showcard)
        {
            $info['status'] = false;
            $info['info'] = '卡号已经被使用!';
            echo json_encode($info);
            die();
        }

        $ids=I('userid');

        //$stu_main = M("student_info")->alias("s")->where("s.userid = $ids and s.schoollid = $schoolid")->join("wxt_school_class class ON s.classid=class.id")->field("s.photo,class.classname,s.classid")->find();

        $where['cardno']=$oldCardNo;
        $where['personId']=$ids;
        $where['cardType']=0;
        $where['handletype'] = 1;
        //默认成功
        $info['status'] = true;

        //查询学生班级

        if($ids){
            $cha=M("student_card")->where($where)->select();

            if(!$cha){
                $data["personId"]=$ids;
                $data["cardNo"]=$newCardNo;
                $data["schoolid"]=$schoolid;
                $data["create_time"]=time();
                $data['handletime'] = date("Y-m-d H:i:s",time());
                $data['handletimeint'] = time();
                $data['handletype'] = 1;
                $data["cardType"]=0;
//            $data["className"] = $stu_main['classname'];
//            $data["classId"] = $stu_main['classid'];
//            $data["imgUrl"] = "http://up.zhixiaoyuan.net/uploads/microblog/".$stu_main["photo"];
                //echo "dsadsa";
                $card_add=M("student_card")->add($data);
            }else{
                //将原来的表修改并添加替换添加时间并将状态改为删除 ,然后再新增一条card表的记录
                $save_card['handletype'] = 0;
                $save_card['handletime'] = date("Y-m-d H:i:s",time());
                $save_card['handletimeint'] = time();

                $card_gai=M("student_card")->where($where)->save($save_card);
                // var_dump($card_gai);

                if($card_gai){

                    $card_addc['personId']=$ids;
                    $card_addc['cardNo'] = $newCardNo;
                    $card_addc['schoolid'] = $schoolid;
                    $card_addc['create_time'] = time();
                    $data['handletime'] = date("Y-m-d H:i:s",time());
                    $card_addc['handletimeint'] = time();
                    $card_addc['handletype'] = 1;
                    $card_addc['cardType'] = 0;
//                 $card_addc["className"] = $stu_main['classname'];
//                 $card_addc["classId"] = $stu_main['classid'];
//                 $card_addc["imgUrl"] = "http://up.zhixiaoyuan.net/uploads/microblog/".$stu_main["photo"];
                    $creat_card = M('student_card')->add($card_addc);
                }


            }

            update_card(0,$ids,$schoolid);
        }else{
            $this->error("未获取到数据！");
        }
        echo json_encode($info);
    }

    //家长卡号
    public function jiaadd(){
        $schoolid = I('schoolid');
        $userid=I("userid");
        //var_dump($userid);
        //获取传过来的卡号
        $class_card=I("class_card");

        //查询出学生信息
        $student_info = M("student_info")->where("userid = $userid")->find();
        $classid = $student_info['classid'];
        //$stu_name = $student_info['stu_name'].'家长';
        $stu_name = $student_info['stu_name'];
        //修改添加班级名称
        $class_info = M("school_class")->where(array("id"=>$classid))->field("classname")->find();
        $className = $class_info["classname"];

        // exit();

        // $ICcard=M("student_card")->where("personId=$userid and cardType=2")->delete();
        foreach ($class_card as &$cardNo) {
            $new_card = $cardNo['cardNo'];
            $old_card = $cardNo['old_card'];
            $where['cardNo']=$old_card;
            $where['personId']=$userid;
            $where['cardType']=2;
            $where['handletype'] = 1;

            //此处为删除标识
            if($new_card==1)
            {
                $save_card['handletype'] = 0;
                $save_card['handletime'] = date('Y-m-d H:i:s',time());
                $save_card['handletimeint'] = time();
                $save_card['classId'] = $classid;
                $save_card['name'] = $stu_name;

                M("student_card")->where($where)->save($save_card);
                continue;
            }
            //如过新的卡号不为空
            if(!empty($new_card)){




                $cha = M('student_card')->where($where)->select();
                //如果不存在则创建一条新的距离
                if(!$cha )
                {
                    $data["personId"]=$userid;
                    $data["cardNo"]=$new_card;
                    $data["schoolid"]=$schoolid;
                    $data["create_time"]=time();
                    $data['handletime'] = date('Y-m-d H:i:s',time());
                    $data['handletimeint'] = time();
                    $data['handletype'] = 1;
                    $data["cardType"]=2;
                    $data["classId"]=$classid;
                    $data["name"]=$stu_name;
                    $data["className"]=$className;//新增

                    $card_add=M("student_card")->add($data);
                    // var_dump($card_add);
                }else{
                    //否则将从前的卡号修改
                    $save_card['handletype'] = 0;
                    $save_card['handletime'] = date('Y-m-d H:i:s',time());
                    $save_card['handletimeint'] = time();
                    $save_card['classId'] = $classid;
                    $save_card['name'] = $stu_name;

                    $card_gai=M("student_card")->where($where)->save($save_card);


                    if($card_gai)
                    {
                        $card_addc['personId']=$userid;
                        $card_addc['cardNo'] = $new_card;
                        $card_addc['schoolid'] = $schoolid;
                        $card_addc['create_time'] = time();
//	                 $card_addc['handletime'] = time();
                        $card_addc['handletime'] = date('Y-m-d H:i:s',time());
                        $card_addc['handletimeint'] = time();
                        $card_addc['handletype'] = 1;
                        $card_addc['cardType'] = 2;
                        $card_addc['classId'] = $classid;
                        $card_addc['name'] = $stu_name;
                        $card_addc["className"]=$className;//新增
                        $creat_card = M('student_card')->add($card_addc);

                    }

                }


            }

        }

    }
    //删除学生卡号

    public function delcard()
    {

        $cardno = I('cardno');
        // var_dump($cardno);

        $delete = M('student_card')->where("cardno = $cardno and cardType = 0 and handletype = 1")->save(array("handletype"=>0,"handletimeint"=>time(),"handletime"=>date("Y-m-d H:i:s",time())));
        // var_dump($delete);

        if ($delete) {
            $info['status'] = true;
            $info['msg'] = $delete;
        } else {
            $info['status'] = false;
            $info['info'] = '404';
        }
        echo json_encode($info);


    }

    //---------------------IC卡相关end-------------------------------------



    //--------------------------家长关系表----------------------------------------------



    //------------------添加家长end----------------
    //-----------------------删除家长与学生的关系--------------------
    public function parent_delete() {
        //var_dump($id);
        $id = $_GET['parentid'];
        $relid = $_GET['id'];
        if ($id) {
            //是否存在其他
            $rst = M("relation_stu_user") -> where("id=$relid") -> delete();
            // $user=$this->wxtuser_model->where("id=$id")->delete();
            if ($rst) {
                $this -> success("删除成功！");
            } else {
                $this -> error("删除失败！");
            }
        } else {
            $this -> error('数据传入失败！');
        }
        $this -> error('该功能暂时未开通！');
    }

    //----------------------删除家长结束------------------
    //---------------------------学生家长列表end----------------------------
    /*
     *家长相关操作end
     **/
    //排序
//	public function listorders() {
//		$status = parent::_listorders($this -> term_relationships_model);
//		if ($status) {
//			$this -> success("排序更新成功！");
//		} else {
//			$this -> error("排序更新失败！");
//		}
//	}
//


    private function _lists() {
        //清空数据

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

        }elseif($province && $citys){
            //写入缓存
            write_condition($province,$citys,$message_type,$schoolid,$this->only_code);
//            exit();
        }elseif(!$tiaojian){
            S($this->only_code,null);
            $this->assign("Province",$Province);
            $this -> display('index');
            exit();
        }

//        if($province && $citys && $message_type && $schoolid)
//        {
//            //写入缓存
//            write_condition($province,$citys,$message_type,$schoolid,$this->only_code);
//
//        }elseif(!$tiaojian){
//            S($this->only_code,null);
//            $this->assign("Province",$Province);
//            $this -> display('index');
//            exit();
////            exit();
//        }


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


            if($citys)
            {
                $wheres['rs.city'] = $citys;
                $where['rs.city'] = $citys;
            }
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

            $count = $this->relation_stu_class_model->alias("a")->join("wxt_wxtuser s ON a.userid = s.id")->join("wxt_school school ON school.schoolid = a.schoolid")->join($join_else) ->join($join_else_grade) ->where($where)->count();
            $page = $this->page($count, 20);


                $students = $this->relation_stu_class_model
                    ->alias("a")
                    ->join("wxt_wxtuser s ON a.userid = s.id")
                    ->join("wxt_school school ON school.schoolid = a.schoolid")
                    ->join($join_else)
                    ->join($join_else_grade)
                    ->field("s.id,s.schoolid,s.name,s.photo,s.sex,s.create_time,school.school_name")
                    ->where($where)
                    ->limit($page->firstRow . ',' . $page->listRows)
                    ->order("a.id ASC")->select();


            //exit();
            foreach ($students as &$studentclass) {
                $classlist = $this -> class_model -> alias("b") -> join("wxt_class_relationship br ON b.id=br.classid") -> where(array("br.userid" => $studentclass['id'])) -> field('classname') -> select();
                $studentclass["classlist"] = $classlist;
                unset($studentclass);
            }

            foreach ($students as &$student_user) {
                $userlist = $this -> wxtuser_model -> alias("user") -> join("wxt_relation_stu_user su ON user.id=su.userid") -> where(array("su.studentid" => $student_user['id'])) -> field('su.name,su.appellation,su.phone') -> select();
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

                // var_dump($card);

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
            $count = $this -> wxtuser_model -> alias("bi")->join("wxt_relation_stu_user si ON bi.id=si.userid ")->join("wxt_school school ON school.schoolid = bi.schoolid")->distinct(true)->join($join_else_info)->join($join)-> where($wheres) -> count();

            $page = $this -> page($count, 20);

            //整改
            $students = $this -> wxtuser_model -> alias("bi")->distinct(true) -> join("wxt_relation_stu_user si ON bi.id=si.userid ")->join("wxt_school school ON school.schoolid = bi.schoolid")->join($join_else_info)->join($join) -> where($wheres) -> limit($page -> firstRow . ',' . $page -> listRows) -> field("si.name as names, bi.phone ,si.studentid as id") -> select();



            if($schoolid)
            {
                $stu_where['schoolid'] = $schoolid;
            }

            foreach ($students as &$student_user) {

                $uisname = $this -> student_info_model ->alias("info")-> where(array("info.userid" => $student_user['id']))->join("wxt_school school ON school.schoolid = info.schoollid") ->field("info.stu_name as name,info.create_time,info.sex,school.school_name,info.schoollid") ->select();

                $lastResultname = "";
                //学生名字
                $lastResultcreate_time = "";
                //创建的时间
                $lastResultsex = "";
                //性别
//                dump($uisname['schoollid']);

                $arr = count($uisname);
                for ($i = 0; $i < $arr; $i++) {
                    $last = $uisname[$i][name];
                    $lio = $uisname[$i][create_time];
                    $lioi = $uisname[$i][sex];



//					$lastResultname = $lastResultname . $last . ",";
                    $lastResultname = $lastResultname . $last;
                    $lastResultcreate_time = $lastResultcreate_time . $lio;
                    $lastResultsex = $lastResultsex . $lioi;
                    $lastResulschool = $uisname[$i][school_name];

                }
                $student_user['sex'] = $lastResultsex;
                $student_user["name"] = $lastResultname;
                $student_user["create_time"] = $lastResultsex;
                $student_user["school_name"] = $lastResulschool;
                $student_user["schoolid"] = $uisname[0]['schoollid'];
                unset($student_user);
            }

            foreach ($students as &$value) {
                $personId = $value['id'];

                $card = M('student_card')->where("personId = $personId and handletype = 1")->field("cardNo")->find();



                $value['cardno'] = $card['cardNo'];
            }

            foreach ($students as &$student_userclass) {
                $classlist = $this -> class_model -> alias("b") -> join("wxt_class_relationship br ON b.id=br.classid") -> where(array("br.userid" => $student_userclass['id'])) -> field('classname') -> select();
                $student_userclass["classlist"] = $classlist;
                unset($student_userclass);
            }
            foreach ($students as &$value) {
                $personId = $value['id'];



                $card = M('student_card')->where("personId = $personId and cardType = 0 and handletype = 1")->field("cardno")->find();

                // var_dump($card);

                $value['cardno'] = $card['cardno'];
            }







//            //加密手机号及拼接家长手机
//            foreach ($students as &$val) {
//                $val['names'] = $val['names'].','.$val['phone'];
//
//                $val['phone'] = substr_replace($val['phone'],'****',3,4);
//            }


        }
        //查询登录手机号

        foreach ($students as &$val) {

            $where_user['studentid'] = $val['id'];
            //改为查询所有卡号的家长中是否有人绑定
            $relss = M("relation_stu_user")->where($where_user)->field("userid")->select();
            $where_phone['studentid'] = $val['id'];
            $where_phone['type'] = 1;
            $rel = M("relation_stu_user")->where($where_phone)->field("phone")->find();

//            if($rel){
//
//                $val['phone'] = substr_replace($rel['phone'],'****',3,4);
//            }
            if($rel){

                $val['phone'] = $rel['phone'];
            }

            $appid = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where(array("a.schoolid"=>$val['schoolid']))->field("b.wx_appid,b.wx_appsecret")->find();


            if($appid){
                foreach ($relss as $values) {
                    $student_appid = M("xctuserwechat")->where(array("userid" => $values['userid'], "appid" => $appid['wx_appid']))->field("appid")->find();

                    if ($student_appid) {
                        $val['appid'] = $student_appid['appid'];
                        break;
                    }
                }
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

    //地区查询
    public function chadi() {
        $type = I("type");
        if ($type) {
            $Region = M("city") -> where("parent=$type") -> select();
            if ($Region) {
                echo json_encode(array('data' => $Region, 'message' => '10000'));
            } else {
                echo json_encode(array('data' => "数据缺失", 'message' => '-1'));
            }
        } else {
            echo json_encode(array('data' => "数据请求失败", 'message' => '-2'));
        }

    }

    //excel数据导出
    public function Lexcel() {
        $schoolid = I("schoolid");
        $tiaojian = I("tiaojian");
        $shuzhi = I("shuzhi");
        $grade=I('grade');
        $classs=I('classs');
        if ($tiaojian != "0" && $shuzhi != "") {
            $where["s.$tiaojian"] = array('like', "%$shuzhi%");
        }
        if ($schoolid != 0) {
            $where["a.schoolid"] = $schoolid;
        }
        if($grade)
        {
            $join_else_grade = "wxt_school_class g ON g.id = a.classid";
            $where['g.grade'] = $grade;
        }
        if($classs && $grade)
        {
            $where['a.classid'] = $classs;
        }

        $where['st.status'] = 1;

        //	    2、如果选择了学生姓名 或者bu'xua
        if ($tiaojian == "name" || $tiaojian == "0" || $tiaojian == "") {

            $students = $this -> relation_stu_class_model -> alias("a")-> join("wxt_school_class class ON a.classid = class.id")->join("wxt_wxtuser s ON a.userid = s.id") ->join("wxt_student_info st ON s.id = st.userid") ->join($join_else_grade)->field("
				s.id,st.schoollid as schoolid,s.name,s.photo,s.sex,s.create_time,st.stu_id,st.in_residence,st.nation,native_place,st.bindingkey,class.classname") -> where($where) -> order("class.listorder ASC,class.create_time desc") -> select();



            foreach ($students as &$studentclass) {
                $classlist = $this -> class_model -> alias("b") -> join("wxt_class_relationship br ON b.id=br.classid") -> where(array("br.userid" => $studentclass['id'])) -> field('classname') -> select();

                $student_info="";


                foreach ($classlist as $value) {
                    $info = $value["classname"];

                    $student_info = $info.",".$student_info;

                }

                $studentclass['student_subject'] = $student_info;
            }



            foreach ($students as &$par) {
                $studentid = $par['id'];

//				$parent_phone = M("relation_stu_user")->where("studentid = $studentid and type = 1")->field("phone")->find();
                $parent_phone = M("relation_stu_user")->where("studentid = $studentid")->order("type asc")->field("phone,name")->select();

                $par_name = "";
                $par_phone = "";
                foreach ($parent_phone as $phone)
                {
                    $par_phone = $phone['phone'].','.$par_phone;
                    $par_name = $phone['name'].','.$par_name;
                }


                $par['parent_phone'] = trim($par_phone,',');
                $par['parent_name'] = trim($par_name,',');
            }





            foreach ($students as &$val) {
                $personId = $val['id'];

                $card = M('student_card')->where("personId = $personId and cardType = 0  and handletype = 1")->field('cardNo')->find();
                $val['card'] = $card['cardno'];
                //查询出所有的家长卡号
                $par_card = M('student_card')->where("personId = $personId and cardType = 2  and handletype = 1")->field('cardNo')->select();


                $parent_card = "";
                foreach ($par_card as $card)
                {
                    $parent_card = $card['cardno'].','.$parent_card;
                }
                $val['parent_card'] = trim($parent_card,",");

            }
//			foreach ($students as &$student_user) {
//				$userlist = $this -> wxtuser_model -> alias("user") -> join("wxt_relation_stu_user su ON user.id=su.userid") -> where(array("su.studentid" => $student_user['id'])) -> field('su.name,su.appellation,su.phone') -> select();
//				$lastResult = "";
//				$arr = count($userlist);
//				for ($i = 0; $i < $arr; $i++) {
//					$last = $userlist[$i][name];
//					$poeon = $userlist[$i][phone];
//					$Chen = $userlist[$i][appellation];
//					$lastResult = $Chen . " " . $lastResult . $last . "," . $poeon;
//
//				}
//				$student_user["names"] = $lastResult;
//				unset($student_user);
//			}
        } else {

            if ($tiaojian == "names") {
                $wheres["bi.name"] = array('like', "%$shuzhi%");
            } else {
                $wheres["bi.phone"] = array('like', "%$shuzhi%");
            }
            $students = $this -> wxtuser_model -> alias("bi") -> join("wxt_relation_stu_user si ON bi.id=si.userid ") -> where($wheres) -> field("bi.name as names, bi.phone ,si.studentid as id") -> select();
            foreach ($students as &$student_user) {
                $uisname = $this -> wxtuser_model -> where(array("id" => $student_user['id'])) -> select();
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

                    $lastResultname = $lastResultname . $last . ",";
                    $lastResultcreate_time = $lastResultcreate_time . $lio;
                    $lastResultsex = $lastResultsex . $lioi;
                }
                $student_user['sex'] = $lastResultsex;
                $student_user["name"] = $lastResultname;
                $student_user["create_time"] = $lastResultsex;
                unset($student_user);
            }
            foreach ($students as &$student_userclass) {
                $classlist = $this -> class_model -> alias("b") -> join("wxt_class_relationship br ON b.id=br.classid") -> where(array("br.userid" => $student_userclass['id'])) -> field('classname') -> select();
                $student_userclass["classlist"] = $classlist;
                unset($student_userclass);
            }

        }

//判断是否绑定微信
        if( $schoolid != 0 ) {

            $appid = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where(array("a.schoolid" => $schoolid))->field("b.wx_appid,b.wx_appsecret")->find();
            if ($appid) {
                foreach ($students as &$student_userappid) {
                    $where_user['studentid'] = $student_userappid['id'];

                    $relss = M("relation_stu_user")->where($where_user)->field("userid")->select();
                    foreach ($relss as $values) {
                        $student_appid = M("xctuserwechat")->where(array("userid" => $values['userid'], "appid" => $appid['wx_appid']))->field("appid")->find();
                        if ($student_appid) {
                            $student_userappid['appid'] = $student_appid['appid'];
                            break;
                        }
                    }
                    unset($student_userappid);
                }
            }
        }



        $newarr = array();
        foreach($students as $key => $_arr){
            if(!isset($newarr[$_arr['id']])){
                $newarr[$_arr['id']] = $_arr;
            }
        }

        $students = $newarr;

        foreach ($students as $key => &$value) {
            if($value['in_residence']==1)
            {
                $value['in_residence'] = '住校';
            }else{
                $value['in_residence'] = '不住校';
            }

            if($value['sex']==0)
            {
                $value['sex'] = '女';
            }else{
                $value['sex'] = '男';
            }

            if($value['appid'])
            {
                $value['is_binding'] = '已绑定';
            }else{
                $value['is_binding'] = '未绑定';
            }
        }




        //$Title = $this -> school_model -> where("schoolid=$schoolid") -> field("school_name") -> select();
        //重组 下标


        $ExceData = array_merge($students);
        // var_dump($ExceData);

        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        //include './statics/PHPExcel/Classes/PHPExcel.php';
        //$objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Da")
            ->setLastModifiedBy("Da")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX,generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet(0)->setTitle("250");//标题
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);//单元格宽度
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');//设置字体
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);//设置字体大小
        $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"姓名");
        $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"性别");
        $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"学生编号");
        $objPHPExcel->getActiveSheet(0)->setCellValue('D1',"IC卡号");
        $objPHPExcel->getActiveSheet(0)->setCellValue('E1',"学号");
        $objPHPExcel->getActiveSheet(0)->setCellValue('F1',"是否住校");
        $objPHPExcel->getActiveSheet(0)->setCellValue('G1',"民族");
        $objPHPExcel->getActiveSheet(0)->setCellValue('H1',"籍贯");
        $objPHPExcel->getActiveSheet(0)->setCellValue('I1',"班级");
        $objPHPExcel->getActiveSheet(0)->setCellValue('J1',"家长姓名");
        $objPHPExcel->getActiveSheet(0)->setCellValue('K1',"家长号码");
        $objPHPExcel->getActiveSheet(0)->setCellValue('L1',"微信绑定码");
        $objPHPExcel->getActiveSheet(0)->setCellValue('M1',"是否绑定微信");
        $objPHPExcel->getActiveSheet(0)->setCellValue('N1',"家长卡号");
        $Val = 2;
        for($i=0 ;$i<count($ExceData) ;$i++){


            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $Val, $ExceData[$i]['name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . $Val, $ExceData[$i]['sex']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . $Val, $ExceData[$i]['stu_id']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . $Val, ' '.$ExceData[$i]['card']);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $Val)->getNumberFormat()->setFormatCode("@");
            $objPHPExcel->getActiveSheet(0)->setCellValue('F' . $Val, $ExceData[$i]['in_residence']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('G' . $Val, $ExceData[$i]['nation']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('H' . $Val, $ExceData[$i]['native_place']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('I' . $Val, $ExceData[$i]['student_subject']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('J' . $Val,$ExceData[$i]['parent_name']);
            $objPHPExcel->getActiveSheet()->getStyle('J' . $Val)->getNumberFormat()->setFormatCode("@");
            $objPHPExcel->getActiveSheet(0)->setCellValue('K' . $Val,$ExceData[$i]['parent_phone']);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $Val)->getNumberFormat()->setFormatCode("@");
            $objPHPExcel->getActiveSheet(0)->setCellValue('L' . $Val, $ExceData[$i]['bindingkey']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('M' . $Val, $ExceData[$i]['is_binding']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('N' . $Val, ' '.$ExceData[$i]['parent_card']);
            $objPHPExcel->getActiveSheet()->getStyle('N' . $Val)->getNumberFormat()->setFormatCode("@");

            $Val++;
        }
        if( $schoolid) {
        $school_name = M('school')->where("schoolid=$schoolid")->getField("school_name");
            $filename = $school_name . '-' . '学生数据导出';
        }else{
            $filename = '学生数据导出';
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename.'.xls');
        header('Cache-Control: max-age=0');

        $objWriter =\ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_clean();//关键
        flush();//关键
        $objWriter->save('php://output');
        exit;
    }


    public function excel_list()
    {

        $begin = strtotime(I('begin'));
        $end = strtotime(I('end'));

        $roleid = admin_role();

        if($roleid!=1)
        {
            $join= "wxt_role_school rs ON rs.schoolid = t.schoolid";
            $where['rs.roleid'] = $roleid;
        }




        if($end && $begin)
        {
            $where['t.time']  = array('GT',$begin);
            $where['t.time'] = array('LT',$end);
        }

        $where['t.state'] = 4;

        $excel = M('teacher_excel')->alias("t")->join($join)->where($where)->order("t.time asc")->select();

        $this->assign('excel',$excel);
        $this->display();

    }

    //导入学生信息
    public function student(){
        $allcount=I('allcount');
        $successcount=I('successcount');
        $updatecount=I('updatecount');
        $info=I('info');

        $this->assign("allcount",$allcount);
        $this->assign("successcount",$successcount);
        $this->assign("updatecount",$updatecount);
        $this->assign("info",$info);

        $this->display();
    }
    //批量导入学生卡号
    public function idupload(){
        $allcount=I('allcount');
        $successcount=I('successcount');
        $info=I('info');

        $this->assign("allcount",$allcount);
        $this->assign("successcount",$successcount);
        $this->assign("info",$info);
        $this->display();
    }

    public function student_post(){


        $allcount=0;
        $successcount=0;
        $updatecount=0;


        $upload = new \Think\Upload();// 实例化上传类

        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath  =      './'; // 设置附件上传根目录
        $upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
        $upload->autoSub   = 	 false;//不自动生成子文件夹
        // 上传单个文件
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['excel_file']);


        $type = $info['ext'];

        $file_name = $info['name'];

        if(!$info){
            $this->error($upload->getError());
        }else{
            $file_puth = './'.$info['savepath'].$info['savename'];
            //文件上传成功，对文件进行解析
            // vendor('phpexcel_1.phpexcel');//导入类库
            require_once VENDOR_PATH.'PHPExcel/PHPExcel/IOFactory.php';
            require_once VENDOR_PATH.'PHPExcel/PHPExcel.php';
            if($info['ext']=='xlsx'){
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
            }else{
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }

//            if($info['ext']=='xlsx'){
//                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
//                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
//            }else{
//                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
//                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
//            }
              if($info['ext']=='xlsx'){
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
            }else{
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }

            //use excel2007 for 2007 format
            $objPHPExcel = $objReader->load($file_puth);


            // $objPHPExcel->setActiveSheetIndex(1);
            $sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始)

            $highestRow = $sheet->getHighestRow(); // 取得总行数

            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            //循环读取excel文件,读取一条,插入一条
            // $info='begin::';
            for($j=2;$j<=$highestRow;$j++)
            {
                for($k='A';$k<=$highestColumn;$k++)
                {
                    //读取单元格
                    $ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                    $allcount++;
                }
            }
            $info=$j.'-'.$k.':'.$info.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();
            //var_dump($info);
            // $info=$info.'end';
            $successcount=0;
            $error_info = array();
            $rowNo = 1;

            $schoolnamearr=array();$namearr=array();$cardarr=array();
            foreach ($ExamPaper_arr as $key => $val)
            {
                $schoolnamearr[]=$val['A'];
                if(!empty($val['B'])){
                    $namearr[]=$val['B'];
                }
                if(is_numeric($val['O'])){
                    $cardarr[]=$val['O'];
                }
            }
            $schoolnum=count(array_count_values($schoolnamearr));
            if($schoolnum !== 1){
                $this->error("请确保导入数据的学校一致");
            }

            $repeat_arr = $this->FetchRepeatMemberInArray ($cardarr);

            if($repeat_arr){

                $this->error("卡号存在重复");
            }
            $schoolcount=M("School")->where("school_name = '$schoolnamearr[0]' ")->count();
            if($schoolcount > 1){
                $this->error("查询出学校存在重复，请检查已添加的学校");
            }
            $schoolid=M("School")->where("school_name = '$schoolnamearr[0]' ")->getField("schoolid");
            if(empty($schoolid)){
                $this->error("查找不到该学校");
            }

            if($schoolnum !== 1){
                $this->error("请确保导入数据的学校一致");
            }
            $repeat_arr = $this->FetchRepeatMemberInArray ($cardarr);
            if($repeat_arr){
                $this->error("卡号存在重复");
            }
            $schoolcount=M("School")->where("school_name = '$schoolnamearr[0]' ")->count();
            if($schoolcount > 1){
                $this->error("查询出学校存在重复，请检查已添加的学校");
            }



            $schoolid=M("School")->where("school_name = '$schoolnamearr[0]' ")->getField("schoolid");

            if(empty($schoolid)){
                $this->error("查找不到该学校");
            }

            foreach ($ExamPaper_arr as $key => $value)
            {
                //循环数据检测A=>学校名字，B=>学生姓名，C=>班级，D=>监护人姓名，E=>家长联系方式，I=>关系, M=>性别，N=>学号，O=>IC卡号，P=>是否住校
                //如果题号或者题干不为空
                if(!empty($value['A'])||!empty($value['B'])||!empty($value['C'])){
                    $name=$value['B'];
                    // var_dump($name);
                    $class=$value['C'];
                    $parentname = $value['D'];
                    $phone=$value['E'];
                    $relation = $value['I'];
                    $sex=$value['N'];
                    $stu_id=$value['M'];
                    $card = $value["O"];
                    $in_residence = $value["P"];
                    $parent_card = $value["Q"];

                    $result=$this->importstudent(trim($name),trim($class),trim($parentname),trim($phone),trim($relation),trim($sex),trim($stu_id),trim($card),trim($in_residence),$schoolid,trim($parent_card,','));

                    /**
                     * 导入教师以及关系数据到数据库
                     * return 0 必填字段获取失败
                     * return 1 成功
                     * return 2 老师用户添加失败
                     * return 3 职务绑定失败
                     * return 4 科目绑定失败
                     * return 5 班级绑定失败
                     * return 6 学校信息获取失败
                     * return 7 老师info信息保存失败
                     */
                    if($result ==1){
                        $successcount++;
                    }else if($result ==2){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"学生信息已存在"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==3){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"IC卡号已经存在"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==4){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"家长联系号码已经存在"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==5){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"班级绑定失败"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result == 6){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"学校信息获取失败"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result==7){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"老师info信息保存失败"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result==8){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"家长卡号已经存在"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result==9){
                        $successcount++;
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"学生调班成功"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result == 0){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"必填字段获取失败"
                        );
                        array_push($error_info,$error_item);
                    }
                }else {
                    $error_item = array(
                        "row"=>$rowNo,
                        "msg"=>"必填数据未填写"
                    );
                    array_push($error_info,$error_item);
                }

                $rowNo++;
            }
        }


        $emptyData = "";
        foreach ($error_info as &$error_item){
            $emptyData = $emptyData."第".($error_item["row"]+1)."行".$error_item["msg"].",";
        }

        $allcount=$highestRow-1;
        $updatecount=$allcount-$ius;

        if(!empty($emptyData))
        {
            $data_excel =  array(
                'schoolid'=>$schoolid,
                'filename'=>$file_name,
                'type'=>$type,
                'time'=>time(),
                'pro'=>rtrim($emptyData, ","),
                'status'=>1,
                'state'=>4

            );

            $teacher_excel = M('teacher_excel')->add($data_excel);


        }else{
            $data_excel =  array(
                'schoolid'=>$schoolid,
                'filename'=>$file_name,
                'type'=>$type,
                'time'=>time(),
                'pro'=>'完美!',
                'status'=>0,
                'state'=>4,

            );
            $teacher_excel = M('teacher_excel')->add($data_excel);


        }


        $info='::其中成功'.$successcount.'人,'.$emptyData;


        $this->success('导入完成','student/successcount/'.$successcount.'/allcount/'.$allcount.'/info/ok::'.$info);
    }

    public function idupload_post(){

        $optionsRadiosinline=I('optionsRadiosinline');


        $upload = new \Think\Upload();// 实例化上传类

        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath  =      './'; // 设置附件上传根目录
        $upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
        $upload->autoSub   = 	 false;//不自动生成子文件夹
        // 上传单个文件
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['excel_file']);


        $type = $info['ext'];

        $file_name = $info['name'];

        if(!$info){
            $this->error($upload->getError());
        }

            $file_puth = './'.$info['savepath'].$info['savename'];
            //文件上传成功，对文件进行解析
            // vendor('phpexcel_1.phpexcel');//导入类库
            require_once VENDOR_PATH.'PHPExcel/PHPExcel/IOFactory.php';
            require_once VENDOR_PATH.'PHPExcel/PHPExcel.php';
            if($info['ext']=='xlsx'){
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
            }else{
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }

            //use excel2007 for 2007 format
            $objPHPExcel = $objReader->load($file_puth);

            // $objPHPExcel->setActiveSheetIndex(1);
            $sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始)

            $highestRow = $sheet->getHighestRow(); // 取得总行数

            $highestColumn = $sheet->getHighestColumn(); // 取得总列数

            //循环读取excel文件,读取一条,插入一条
            // $info='begin::';
            for($j=2;$j<=$highestRow;$j++)
            {
                for($k='A';$k<=$highestColumn;$k++)
                {
                    //读取单元格
                    $ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                    $allcount++;
                }
            }
            $info=$j.'-'.$k.':'.$info.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();
            $successcount=0;
            $error_info = array();
            $rowNo = 1;

        $schoolnamearr=array();$Barr=array();
        foreach ($ExamPaper_arr as $key => $val)
        {
            $schoolnamearr[]=$val['A'];
            if(!empty($val['B'])){
                $Barr[]=$val['B'];
            }
        }
        $schoolnum=count(array_count_values($schoolnamearr));
        if($schoolnum !== 1){
            $this->error("请确保导入数据的学校一致");
        }
        $schoolcount=M("School")->where("school_name = '$schoolnamearr[0]' ")->count();
        if($schoolcount > 1){
            $this->error("查询出学校存在重复，请检查已添加的学校");
        }
        $schoolid=M("School")->where("school_name = '$schoolnamearr[0]' ")->getField("schoolid");
        if(empty($schoolid)){
            $this->error("查找不到该学校");
        }

        if($optionsRadiosinline == "option1") {
            if($highestColumn !== "D"){
                    $this->error("请选择正确模式");
            }
            $repeat_arr = $this->FetchRepeatMemberInArray ($Barr);
            if($repeat_arr){
                $this->error("导入数据中学生编号存在重复");
            }
            //查出该学校下的所有班级
            $Result = M("school_class")->where("schoolid=$schoolid")->field('id as classid,classname')->select();
            $classarray = $this->array_column($Result, 'classname', 'classid');
            unset($Result);
            //查出该学校下的所有学生
            $Result = M("student_info")->where("schoollid=$schoolid")->field('userid,stu_id,student_id,stu_name,classid')->select();
            $studentarray = $this->array_column($Result, '', 'stu_id');
            foreach ($Result as $values) {
                $studentarray[$values['stu_id']] = $values;
            }
            unset($Result);
            unset($values);
            //查出该学校下的所有卡号
            $Result = M("student_card")->where("schoolid=$schoolid")->field('personid as userid,cardNo')->select();
            $cardNoarray = $this->array_column($Result, 'userid');
            $cardNoarrays = $this->array_column($Result, 'cardno');
            unset($Result);

            foreach ($ExamPaper_arr as $key => $value) {
                //循环数据检测A=>学生编号，B=>学生卡号，C=>学生学号
                //如果题号或者题干不为空
                if (empty($value['B'])) {
                    $error_item = array(
                        "row" => $rowNo,
                        "msg" => "学生编号未填写"
                    );
                    array_push($error_info, $error_item);
                    $rowNo++;
                    continue;
                }

                $stu_id = trim($value['B']);
                $card = trim($value['C']);
                $studentid = trim($value['D']);
                if (!$studentarray[$stu_id][stu_id]) {
                    $error_item = array(
                        "row" => $rowNo,
                        "msg" => "学生不存在"
                    );
                    array_push($error_info, $error_item);
                    $rowNo++;
                    continue;
                }
                if (empty($value['C']) && empty($value['D'])) {
                    $rowNo++;
                    continue;
                }
                if (!empty($card)) {

                    $lenfth = 10 - strlen($card);
                    $lastResult = ""; // 存储返回的结果
                    for ($i = 0; $i < $lenfth; $i++) {
                        $lastResult = "0" . $lastResult;
                    }
                    $ICcardsu = $lastResult . $card; //10位的卡号

                    if (in_array("$ICcardsu", $cardNoarrays)) {
                        $error_item = array(
                            "row" => $rowNo,
                            "msg" => "卡号已存在"
                        );
                        array_push($error_info, $error_item);
                        $rowNo++;
                        continue;
                    }
                    //检测学生是否存在卡号,若有则更新原数据状态，在插入
                    $userid = $studentarray[$stu_id][userid];
                    if (in_array($userid, $cardNoarray)) {
                        $carddatas['handletime'] = date('Y-m-d H:i:s', time());
                        $carddatas['handletimeint'] = time();
                        $carddatas['handletype'] = "0";
                        $cardadd = M('student_card')->where("personId=$userid and handletype=1")->save($carddatas);

                        $carddata['cardType'] = 0;
                        $carddata['cardNo'] = $ICcardsu;
                        $carddata['personId'] = $studentarray[$stu_id][userid];
                        $carddata['schoolid'] = $schoolid;
                        $carddata['className'] = $classarray[$studentarray[$stu_id][classid]];
                        $carddata['handletime'] = date('Y-m-d H:i:s', time());
                        $carddata['handletimeint'] = time();
                        $carddata['imgUrl'] = "http://up.zhixiaoyuan.net/uploads/microblog/weixiaotong.png";
                        $carddata['name'] = $studentarray[$stu_id][stu_name];
                        $carddata['classId'] = $studentarray[$stu_id][classid];
                        $carddata['create_time'] = time();
                        $cardaddup = M('student_card')->add($carddata);

                    } else {
                        $carddata['cardType'] = 0;
                        $carddata['cardNo'] = $ICcardsu;
                        $carddata['personId'] = $studentarray[$stu_id][userid];
                        $carddata['schoolid'] = $schoolid;
                        $carddata['className'] = $classarray[$studentarray[$stu_id][classid]];
                        $carddata['handletime'] = date('Y-m-d H:i:s', time());
                        $carddata['handletimeint'] = time();
                        $carddata['imgUrl'] = "http://up.zhixiaoyuan.net/uploads/microblog/weixiaotong.png";
                        $carddata['name'] = $studentarray[$stu_id][stu_name];
                        $carddata['classId'] = $studentarray[$stu_id][classid];
                        $carddata['create_time'] = time();
                        $cardaddup = M('student_card')->add($carddata);
                    }

                }
                /**
                 * if($studentid){
                 * if(in_array("$studentid", $studentidarray)){
                 * $error_item = array(
                 * "row"=>$rowNo,
                 * "msg"=>"学号已存在"
                 * );
                 * array_push($error_info,$error_item);
                 * $rowNo++;
                 * continue;
                 * }
                 * $studentdata['student_id'] = $studentid;
                 * $studentup= M('student_info')-> where("stu_id=$stu_id")->save($studentdata);
                 *
                 * }**/
                $successcount++;
                $rowNo++;
            }
        }else {
            if($highestColumn !== "E"){
                $this->error("请选择正确模式");
            }
            //查出该学校下的所有班级
            $Result = M("school_class")->where("schoolid=$schoolid")->field('id as classid,classname')->select();
            $classarray = $this->array_column($Result, 'classid', 'classname');
            unset($Result);
            //查出该学校下的所有学生
            $Result = M("student_info")->where("schoollid=$schoolid")->field('userid,student_id,stu_name,classid')->select();
            $studentarray = $this->array_column($Result, '', 'stu_name');
            foreach ($Result as $values) {
                $studentarray[$values['stu_name']] = $values;
            }
            unset($Result);
            unset($values);
            //查出该学校下的所有卡号
            $Result = M("student_card")->where("schoolid=$schoolid")->field('personid as userid,cardNo')->select();
            $cardNoarray = $this->array_column($Result, 'userid');
            $cardNoarrays = $this->array_column($Result, 'cardno');
            unset($Result);

            foreach ($ExamPaper_arr as $key => $value) {
                //循环数据检测A=>学生编号，B=>学生卡号，C=>学生学号
                //如果题号或者题干不为空
                if (empty($value['B'])) {
                    $error_item = array(
                        "row" => $rowNo,
                        "msg" => "学生班级未填写"
                    );
                    array_push($error_info, $error_item);
                    $rowNo++;
                    continue;
                }
                if (empty($value['C'])) {
                    $error_item = array(
                        "row" => $rowNo,
                        "msg" => "学生姓名未填写"
                    );
                    array_push($error_info, $error_item);
                    $rowNo++;
                    continue;
                }
                if (empty($value['D'])) {
                    $error_item = array(
                        "row" => $rowNo,
                        "msg" => "学生ic卡号未填写"
                    );
                    array_push($error_info, $error_item);
                    $rowNo++;
                    continue;
                }
                $classname = trim($value['B']);
                $studentname = trim($value['C']);
                $card = trim($value['D']);
                $studentid = trim($value['E']);
                $classid = $classarray[$classname];
                if (empty($classid)) {
                    $error_item = array(
                        "row" => $rowNo,
                        "msg" => "该班级不存在"
                    );
                    array_push($error_info, $error_item);
                    $rowNo++;
                    continue;
                }
                $studentnum = M('student_info')->where("stu_name='$studentname' and classId=$classid")->count();
                if ($studentnum > 1) {
                    $error_item = array(
                        "row" => $rowNo,
                        "msg" => "该班级存在同名学生（请手动修改）"
                    );
                    array_push($error_info, $error_item);
                    $rowNo++;
                    continue;
                }
                if ($studentnum < 1) {
                    $error_item = array(
                        "row" => $rowNo,
                        "msg" => "该学生不存在"
                    );
                    array_push($error_info, $error_item);
                    $rowNo++;
                    continue;
                }
                // if (!empty($card)) {
                $lenfth = 10 - strlen($card);
                $lastResult = ""; // 存储返回的结果
                for ($i = 0; $i < $lenfth; $i++) {
                    $lastResult = "0" . $lastResult;
                }
                $ICcardsu = $lastResult . $card; //10位的卡号

                if (in_array("$ICcardsu", $cardNoarrays)) {
                    $error_item = array(
                        "row" => $rowNo,
                        "msg" => "卡号已存在"
                    );
                    array_push($error_info, $error_item);
                    $rowNo++;
                    continue;
                }
                //检测学生是否存在卡号,若有则更新原数据状态，在插入
                $userid = $studentarray[$studentname][userid];
                if (in_array($userid, $cardNoarray)) {
                    $carddatas['handletime'] = date('Y-m-d H:i:s', time());
                    $carddatas['handletimeint'] = time();
                    $carddatas['handletype'] = "0";
                    $cardadd = M('student_card')->where("personId=$userid and handletype=1")->save($carddatas);

                    $carddata['cardType'] = 0;
                    $carddata['cardNo'] = $ICcardsu;
                    $carddata['personId'] = $studentarray[$studentname][userid];
                    $carddata['schoolid'] = $schoolid;
                    $carddata['className'] = $classname;
                    $carddata['handletime'] = date('Y-m-d H:i:s', time());
                    $carddata['handletimeint'] = time();
                    $carddata['imgUrl'] = "http://up.zhixiaoyuan.net/uploads/microblog/weixiaotong.png";
                    $carddata['name'] = $studentname;
                    $carddata['classId'] = $classarray[$classname];
                    $carddata['create_time'] = time();
                    $cardaddup = M('student_card')->add($carddata);

                } else {
                    $carddata['cardType'] = 0;
                    $carddata['cardNo'] = $ICcardsu;
                    $carddata['personId'] = $studentarray[$studentname][userid];
                    $carddata['schoolid'] = $schoolid;
                    $carddata['className'] = $classname;
                    $carddata['handletime'] = date('Y-m-d H:i:s', time());
                    $carddata['handletimeint'] = time();
                    $carddata['imgUrl'] = "http://up.zhixiaoyuan.net/uploads/microblog/weixiaotong.png";
                    $carddata['name'] = $studentname;
                    $carddata['classId'] = $classarray[$classname];
                    $carddata['create_time'] = time();
                    $cardadd = M('student_card')->add($carddata);
                }

                //}
                /**
                 * if($studentid){
                 * if(in_array("$studentid", $studentidarray)){
                 * $error_item = array(
                 * "row"=>$rowNo,
                 * "msg"=>"学号已存在"
                 * );
                 * array_push($error_info,$error_item);
                 * $rowNo++;
                 * continue;
                 * }
                 * $studentdata['student_id'] = $studentid;
                 * $studentup= M('student_info')-> where("stu_id=$stu_id")->save($studentdata);
                 *
                 * }**/
                $successcount++;
                $rowNo++;
            }
        }
        $emptyData = "";
        foreach ($error_info as &$error_item){
            $rowsss=$error_item["row"]+1;
            $emptyData = $emptyData."第".($rowsss)."行".$error_item["msg"]."。";
        }
        $allcount=$highestRow-1;

        if(!empty($emptyData))
        {
            $data_excel =  array(
                'schoolid'=>$schoolid,
                'filename'=>$file_name,
                'type'=>$type,
                'time'=>time(),
                'pro'=>rtrim($emptyData, ","),
                'status'=>1,
                'state'=>4

            );

            $teacher_excel = M('teacher_excel')->add($data_excel);


        }else{
            $data_excel =  array(
                'schoolid'=>$schoolid,
                'filename'=>$file_name,
                'type'=>$type,
                'time'=>time(),
                'pro'=>'完美!',
                'status'=>0,
                'state'=>4,

            );
            $teacher_excel = M('teacher_excel')->add($data_excel);


        }


        $info='::其中成功'.$successcount.'人,'.$emptyData;


        $this->success('导入完成','idupload/successcount/'.$successcount.'/allcount/'.$allcount.'/info/ok::'.$info);
    }

    function importstudent($name,$class,$parentname,$phone,$relation,$sex,$stu_id,$card,$in_residence,$schoolid,$parent_card){
        // exit();


        $result = 1;
        //0.失败，1新增，2更新

        //判断学校信息是否存在
        if ($schoolid){
            $isShool = M("School")->where("schoolid=$schoolid")->find();

            if (!$isShool){
                $result =  6;
            }
        }else{
            $result  = 6;
        }


        if($card!=""){
            $lenfth=10-strlen($card);
            $lastResult = ""; // 存储返回的结果
            for($i=0;$i<$lenfth;$i++){
                $lastResult = "0" . $lastResult;
            }
            $ICcardsu=$lastResult.$card; //10位的卡号
        }else{
            $ICcardsu="";
        }

        if($parent_card)
        {
            $parent_card = explode(",", $parent_card);
        }


        //判断家长名字为空时
        if($parentname == ""){
            $parentname=$name."家长";
        }
        if(!$relation)
        {
            $relation = '家长';
        }
        //TODO  以后需要改进 多个家长关系

        //--------------------end
        if(empty($name) || empty($class)){
            $result=0;
        }else{
            //判断用户的性别
            if($sexname=='男'){
                $sex=1;
            }else{
                $sex=0;
            }
        }
        //通过传入学校ID和班级名字；查找对应的班级；
        $class_where['schoolid']=$schoolid;
        $class_where['classname']=$class;
        $class=M('school_class')->where($class_where)->field('id,classname')->find();

        if($class){
            //如果不存在班级就弹出
            $classid=$class['id'];
            $classname = $class['classname'];
            // 根据班级id 和学生姓名去查找数据

            $where['s.stu_name'] = $name;
            $where['s.schoollid'] = $schoolid;

            $student = M('class_relationship')->alias("c")->join("wxt_student_info s ON s.userid = c.userid")->field("s.userid,s.stu_name,c.classid")->where($where)->find();


            //如果不存在

            if(!$student)
            {
                if(empty($phone))
                {
                    $phone = 13000000000;
                }



                $data=array(
                    'schoolid'=>$schoolid,
                    'name'=>$name,
                    'sex'=>$sex,
                    'password'=>md5('123456'),
                    'status'=>'1',
                    'user_type'=>'1',
                    'create_time'=>time()
                );
                $userid=$this->wxtuser_model->add($data);

                if($userid){
                    //写入学生表格
                    $lenfths=7-strlen($userid);
                    $lastResults = ""; // 存储返回的结果
                    for($i=0;$i<$lenfths;$i++){
                        $lastResults = "0" . $lastResults;
                    }
                    $userids=$lastResults.$userid; //7位的学号
                    $stu_id = substr(date('Y'),-2).$userids;//获取学生的学号
                    //导入学生表生成6位的激活
                    $bindingkey=rand(100000,999999);
                    $classrelationdataiofo=array(
                        "stu_id"=>$stu_id,
                        "classid"=>$classid,
                        "userid"=>$userid,
                        "sex"=>$sex,
//								"photo"=>'学生.png',
                        "photo"=>'weixiaotong.png',
                        "stu_name"=>$name,
                        "bindingkey"=>$bindingkey,
                        "schoollid"=>$schoolid,
                        "create_time"=>time()
                    );
                    $Stuiofo=M("student_info")->add($classrelationdataiofo);

                    $classrelationdata=array(
                        "schoolid"=>$schoolid,
                        "classid"=>$classid,
                        "userid"=>$userid
                    );
                    $classrelationdata['create_time']=time();
                    $crs = $this->relation_stu_class_model->add($classrelationdata);


                    $phone = explode(",", $phone);

                    $parthon = explode(",", $parentname);
                    $i = 0;$k=0;
                    foreach ($phone as  $phone_num) {
                        $i++;
                        if(empty($parthon["$k"])){
                            $parentnamess=$parentname;
                        }else{
                            $parentnamess=$parthon["$k"];
                        }
                        if($phone_num=='')
                        {
                            continue;
                        }
                        if($i==1)
                        {
                            $type = 1;
                        }else{
                            $type = 0;
                        }

                        $where['phone'] = $phone_num;


//                        $parent_ex = M("wxtuser")->where("phone = $phone_num")->field("phone,id")->find();
                        $parent_ex = M("wxtuser")->where(array("phone"=>$phone_num))->field("phone,id")->find();

                        $pwd = substr($phone_num, -6);

                        //TODO现在判断13000000000只有一条
//                                if(!$parent_ex || $parent_ex['phone']==13000000000)
//                                {
//                                 $datas=array(
//									'schoolid'=>$schoolid,
//									'name'=>$parentname,
//									'phone'=>$phone_num,
//									'sex'=>$sex,
//									'password'=> md5($pwd),
//									'status'=>'1',
//									'user_type'=>'1',
//									'create_time'=>time()
//						         	);
//
//		                        $parentid=M("wxtuser")->add($datas);
//
//                                }else{
//                                	$parentid = $parent_ex['id'];
//                                }
                        if(!$parent_ex )
                        {
                            $datas=array(
                                'schoolid'=>$schoolid,
                                'name'=>$parentnamess,
                                'phone'=>$phone_num,
                                'sex'=>$sex,
                                'password'=> md5($pwd),
                                'status'=>'1',
                                'user_type'=>'1',
                                'create_time'=>time()
                            );

                            $parentid=M("wxtuser")->add($datas);

                        }else{
                            $parentid = $parent_ex['id'];
                        }
                        //写入亲属关系表

                        $redata=array(
                            "studentid"=>$userid,
                            "userid"=>$parentid
                        );

                        $redata['name']=$parentnamess;
                        $redata['phone']=$phone_num;
                        $redata['charging_phone']=$phone_num;
                        $redata['time']=time();
                        $redata['appellation'] = $relation;
                        $redata['relation_rank']=1;
                        $redata['type']=$type;
                        $redata['preferred']=1;

                        $rt = $this->relation_stu_user_model->add($redata);$k++;
                    }
                    if(!empty($card)){
                        //检测是否已经存在卡对应关系表
                        $carddata['cardNo']=$ICcardsu;
                        $carddata['handletype']=1;
                        $iscard=M('student_card')->where($carddata)->find();
                        if($iscard){
                            $result=3;
                        }else{
                            //写入卡表
                            $carddata['cardType']=0;
                            $carddata['cardNo']=$ICcardsu;
                            $carddata['uid']=$ICcardsu;
                            $carddata['personId']=$userid;
                            $carddata['schoolid']=$schoolid;
                            $carddata['className']=$classname;
                            $carddata['handletime']=date('Y-m-d H:i:s',time());
                            $carddata['handletimeint']=time();
                            $carddata['imgUrl']="http://up.zhixiaoyuan.net/uploads/microblog/weixiaotong.png";
                            $carddata['name']=$name;
                            $carddata['classId']=$classid;
                            $carddata['create_time']=time();
                            $carrs=M('student_card')->add($carddata);

                            //$result = 1;
                            //插入卡号日志表

                        }
                    }

                    if($parent_card)
                    {
                        foreach ($parent_card as $card_num)
                        {
                            $parentcard_data['cardNo'] = $card_num;
                            $parentcard_data['schoolid'] = $schoolid;
                            $parentcard_data['handletype'] = 1;
                            $is_parentcard = M('student_card')->where($parentcard_data)->find();
                            if($is_parentcard)
                            {
                                $result = 8;
                            }else{
                                $parentcard_data['cardType']=2;
                                $parentcard_data['cardNo']=$card_num;
                                $parentcard_data['uid']=$card_num;
                                $parentcard_data['personId']=$userid;
                                $parentcard_data['className']=$classname;
                                $parentcard_data['schoolid']=$schoolid;
                                $parentcard_data['handletime']=date('Y-m-d H:i:s',time());
                                $parentcard_data['handletimeint']=time();
                                $parentcard_data['imgUrl']="http://up.zhixiaoyuan.net/uploads/microblog/weixiaotong.png";
                                $parentcard_data['name']=$name;
                                $parentcard_data['classId']=$classid;
                                $parentcard_data['create_time']=time();
                                $parentadd_card=M('student_card')->add($parentcard_data);
                            }

                        }
                    }
                }


            }else{
                //如果学生信息存在

                //用家长关系表去查  判断家长关系表的主号码跟该家长号码是否一样 如果一样的话视为同一个孩子
                $userid = $student['userid'];

                $parent = $this->relation_stu_user_model->where("studentid = $userid and type = 1")->field('phone')->find();

                //如果不一样则插入信息
                //因为可能有两个家长号码,这里只取第一个号码为主号码来比较
                if($parent['phone']!==strtok($phone, ',') || empty($phone))
                {
                    if(empty($phone))
                    {
                        $phone = 13000000000;
                    }



                    $data=array(
                        'schoolid'=>$schoolid,
                        'name'=>$name,
                        'sex'=>$sex,
                        'password'=>md5('123456'),
                        'status'=>'1',
                        'user_type'=>'1',
                        'create_time'=>time()
                    );
                    $userid=$this->wxtuser_model->add($data);


                    if($userid){
                        //写入学生表格
                        $lenfths=7-strlen($userid);
                        $lastResults = ""; // 存储返回的结果
                        for($i=0;$i<$lenfths;$i++){
                            $lastResults = "0" . $lastResults;
                        }
                        $userids=$lastResults.$userid; //7位的学号
                        $stu_id = substr(date('Y'),-2).$userids;//获取学生的学号
                        //导入学生表生成6位的激活
                        $bindingkey=rand(100000,999999);
                        $classrelationdataiofo=array(
                            "stu_id"=>$stu_id,
                            "classid"=>$classid,
                            "userid"=>$userid,
                            "sex"=>$sex,
                            "photo"=>'学生.png',
                            "stu_name"=>$name,
                            "bindingkey"=>$bindingkey,
                            "schoollid"=>$schoolid,
                            "create_time"=>time()
                        );
                        $Stuiofo=M("student_info")->add($classrelationdataiofo);

                        $classrelationdata=array(
                            "schoolid"=>$schoolid,
                            "classid"=>$classid,
                            "userid"=>$userid
                        );
                        $classrelationdata['create_time']=time();
                        $crs = $this->relation_stu_class_model->add($classrelationdata);

                        $phone = explode(",", $phone);

                        $i = 0;
                        foreach ($phone as  $phone_num) {
                            if($phone_num=='')
                            {
                                continue;
                            }
                            $i++;
                            if($i==1)
                            {
                                $type = 1;
                            }else{
                                $type = 0;
                            }
//                            $parent_ex = M("wxtuser")->where("phone = $phone_num")->field("phone,id")->find();
                            $parent_ex = M("wxtuser")->where(array("phone"=>$phone_num))->field("phone,id")->find();


                            $pwd = substr($phone_num, -6);


                            if(!$parent_ex )
                            {
                                $datas=array(
                                    'schoolid'=>$schoolid,
                                    'name'=>$parentname,
                                    'phone'=>$phone_num,
                                    'sex'=>$sex,
                                    'password'=> md5($pwd),
                                    'status'=>'1',
                                    'user_type'=>'1',
                                    'create_time'=>time()
                                );

                                $parentid=M("wxtuser")->add($datas);

                            }else{
                                $parentid = $parent_ex['id'];
                            }


                            //写入亲属关系表

                            $redata=array(
                                "studentid"=>$userid,
                                "userid"=>$parentid
                            );

                            $redata['name']=$parentname;
                            $redata['phone']=$phone_num;
                            $redata['charging_phone']=$phone_num;
                            $redata['appellation'] = $relation;
                            $redata['time']=time();
                            $redata['relation_rank']=1;
                            $redata['type']=$type;
                            $redata['preferred']=1;

                            $rt = $this->relation_stu_user_model->add($redata);
                        }

                        if(!empty($card)){
                            //检测是否已经存在卡对应关系表
                            $carddata['cardNo']=$ICcardsu;
                            $carddata['handletype']=1;
                            $iscard=M('student_card')->where($carddata)->find();
                            if($iscard){
                                $result=3;
                            }else{
                                //写入卡表
                                $carddata['cardType']=0;
                                $carddata['cardNo']=$ICcardsu;
                                $carddata['uid']=$ICcardsu;
                                $carddata['personId']=$userid;
                                $carddata['schoolid']=$schoolid;
                                $carddata['className']=$classname;
                                $carddata['handletime']=date('Y-m-d H:i:s',time());
                                $carddata['handletimeint']=time();
                                $carddata['imgUrl']="http://up.zhixiaoyuan.net/uploads/microblog/weixiaotong.png";
                                $carddata['name']=$name;
                                $carddata['classId']=$classid;
                                $carddata['create_time']=time();
                                $carrs=M('student_card')->add($carddata);
                                //$result = 1;
                                //插入卡号日志表
                            }
                        }
                        //如果存在家长卡
                        if($parent_card)
                        {
                            foreach ($parent_card as $card_num)
                            {
                                $parentcard_data['cardNo'] = $card_num;
                                $parentcard_data['schoolid'] = $schoolid;
                                $parentcard_data['handletype'] = 1;
                                $is_parentcard = M('student_card')->where($parentcard_data)->find();
                                if($is_parentcard)
                                {
                                    $result = 8;
                                }else{
                                    $parentcard_data['cardType']=2;
                                    $parentcard_data['cardNo']=$card_num;
                                    $parentcard_data['uid']=$card_num;
                                    $parentcard_data['personId']=$userid;
                                    $parentcard_data['schoolid']=$schoolid;
                                    $parentcard_data['className']=$classname;
                                    $parentcard_data['handletime']=date('Y-m-d H:i:s',time());
                                    $parentcard_data['handletimeint']=time();
                                    $parentcard_data['imgUrl']="http://up.zhixiaoyuan.net/uploads/microblog/weixiaotong.png";
                                    $parentcard_data['name']=$name;
                                    $parentcard_data['classId']=$classid;
                                    $parentcard_data['create_time']=time();
                                    $parentadd_card=M('student_card')->add($parentcard_data);
                                }

                            }
                        }


                    }




                }else{

                    //这边
                    $class_relationship= $this->class_relationship_model->where("schoolid = $schoolid and userid = $userid")->select();


                     //因为要查询该班级是否是兴趣班，这边调的都是正规班
                    foreach($class_relationship as $value)
                    {
                        $class = $value['classid'];
                        $id = $value['id'];
                        $class_type = M("school_class")->where("id = $classid")->getField("type");

                        if($class_type==1)
                        {
                         $aa = $this->class_relationship_model->where("id = $id")->save(array("classid"=>$classid));
                        }

                    }

                    $this -> student_info_model->where("schoollid = $schoolid and userid = $userid")->save(array("classid"=>$classid));
                    //更新ic卡的班级信息
                    update_card(0,$userid,$schoolid);

                    $result = 9;
                }

            }


        }else{
            $result = 5;
        }
        //end 最新到这里过  后面是旧的
        return $result;


    }

    //-------------------------班级编辑-------------------------------
    //--------------------------学生班级列表start---------------------------
    public function classlist() {
        //班级管理  班级列表
        //var_dump($_GET);
        $studentid = $_GET['id'];
        $schoolid = I('schoolid');
        if ($studentid) {
            $rst = $this -> class_relationship_model -> alias("tc") -> join("wxt_school_class u ON tc.classid=u.id") -> field("u.id,u.classname,u.create_time") -> where("tc.userid=$studentid") -> select();
            //var_dump($rst);
            $this->assign("schoolid",$schoolid);
            $this -> assign("studentid", $studentid);
            $this -> assign("classinfo", $rst);
            $this -> display("classlist");
        } else {
            $this -> error('数据传入失败！');
        }
    }

    //---------------------------学生班级列表end----------------------------
    //---------------------------给学生添加班级-----------------------------
    public function addclass() {
        //var_dump($_GET);
        $studentid = $_GET['studentid'];
        $schoolid = I('schoolid');
        $school = M('school')->where("schoolid = $schoolid")->find();

        $school_name = $school['school_name'];
        //查询出班级的名字和id
        // $classlist = $this -> class_model -> alias("tc") -> join("wxt_wxtuser u ON tc.schoolid=u.schoolid") -> field("tc.id,tc.classname") -> where("u.id=$studentid") -> select();
        $class = $this -> class_model -> order(array("id" => "asc"))->where("schoolid = $schoolid") -> select();
        //分配数据到前台打印
        $this -> assign("schoolid",$schoolid);
        $this -> assign("school_name",$school_name);
        $this -> assign("classlist", $classlist);

        $this -> assign("class", $class);
        $this -> assign("studentid", $studentid);
        $this -> display("addclass");
    }

    public function addclass_post() {
        //var_dump($_POST);
        $s_id = $_POST['student_id'];
        $c_id = $_POST['classid'];
        $school_id = $this -> wxtuser_model -> where("id = $s_id") -> getField("schoolid");
        $where_ands = array("classid=$c_id");
        array_push($where_ands, "userid=$s_id", "schoolid=$school_id");
        $where = join(" and ", $where_ands);
        $count = $this -> class_relationship_model -> where($where) -> count();
        if (IS_POST) {
            if ($count > 0) {

                $this->error("选择的班级已加入,请重新选择");
            } else {

                $data = array('classid' => $c_id, 'schoolid' => $school_id, 'userid' => $s_id, 'type' => "1", 'create_time' => time());
                $rzt = M("class_relationship") -> add($data);
            }
        }
        if ($rzt) {
            $this -> success("添加成功！");
        } else {
            $this -> error("添加失败！");
        }
    }

    //----------------------------添加班级结束------------------------------
    //-----------------------删除班级--------------------------------------
    public function class_delete() {
        //var_dump($id);
        $id = $_GET['id'];
        $userid = $_GET['userid'];
        if ($id && $userid) {
            $rst = M("class_relationship") -> where("classid=$id&&userid=$userid") -> delete();
            if ($rst) {
                $this -> success("删除成功！");
            } else {
                $this -> error("删除失败！");
            }
        } else {
            $this -> error('数据传入失败！');
        }
    }

    //----------------------删除班级结束------------------------------------
    //-----------------------班级编辑结束-----------------------------------

    //-----------------------家长编辑开始----------------------------------
    //---------------------家长列表展示-----------------------------------
    public function parentmanage() {
        //var_dump($_GET);
        $studentid = $_GET['id'];
        $parentsinfo = $this -> relation_stu_user_model -> alias("tc") -> join("wxt_wxtuser u ON tc.userid=u.id") -> join("wxt_appellation d ON tc.appellation_id=d.id") -> field("tc.userid,tc.appellation_id,u.name as name,d.appellation_name") -> where("tc.studentid=$studentid") -> select();
        $this -> assign("parentsinfo", $parentsinfo);
        $this -> assign("studentid", $studentid);
        $this -> display("parentlist");
    }

    /*
     添加家长功能
     */
    public function add_parents() {
        $studentid = $_GET['studentid'];
        //查询出称呼名称
        $appellationlist = $this -> appellation_model -> select();
        $this -> assign("stu_id", $studentid);
        $this -> assign("appellationlist", $appellationlist);
        $this -> display("add_parents");

    }

    public function add_parents_post() {
        $studentid = I("studentid");
        $name = I("name");
        $appellationid = I(intval("appellation_id"));
        $userid = intval($this -> wxtuser_model -> where("name=$name") -> getField('id'));
        //$school_id = intval($this->wxtuser_model->where("id = $s_id")->getField('schoolid'));
        $where_ands = array("studentid=$studentid");
        array_push($where_ands, "userid=$userid", "appellation_id=$appellationid");
        $where = join(" and ", $where_ands);
        $count = $this -> relation_stu_user_model -> where($where) -> count();
        if ($_POST) {
            if ($count > 0) {
                $this -> error("选择的家长类型已加入，请重新选择！");
            } else {
                $data = array('studentid' => $studentid, 'userid' => $userid, 'appellation_id' => $appellationid, 'relation_rank' => "2", 'preferred' => "0", 'create_time' => time());
                $rzt = M("relation_stu_user") -> add($data);
            }
        }
        if ($rzt) {
            $this -> success("添加成功！,U('index')");
        } else {
            $this -> error("添加失败！");
        }
    }

    //---------------------------家长删除功能------------------------------
    public function parents_delete() {
        $userid = $_GET['id'];
        $studentid = $_GET['studentid'];
        if ($userid && $studentid) {
            $rst = $this -> relation_stu_user_model -> where("studentid=$studentid&&userid=$userid") -> delete();
            if ($rst) {
                $this -> success("删除成功！");
            } else {
                $this -> error("删除失败！");
            }
        } else {
            $this -> error('数据传入失败！');
        }
    }

    //---------------------------家长删除结束------------------------------

    //---------------------------家长卡号删除------------------------------

    public function del_parent_card()
    {
        //获取状态
        $type = I("type");
        $schoolid = I("schoolid");
       if($type==1)
       {
          $studentid= I("s_id");

          //删除所选中的卡号
          $where['personId'] = array("in",$studentid);

       }
        $where['schoolid'] = $schoolid;
        $where['cardType'] = 2;
        $where['handletype'] = 1;
        $update_card =  M("student_card")->where($where)->save(array("handletype"=>0,"handletime"=>date("Y-m-d H:i:s",time()),"handletimeint"=>time()));

        if($update_card) {
            $ret = $this->format_ret_else(1, "删除成功!");
        }else{
            $ret = $this->format_ret_else(0, "删除失败!");
        }

        echo  json_encode($ret);

    }


    //---------------------------家长删除结束------------------------------

    //-----------------------家长编辑结束---------------------------------
    function add() {

       /* $schoolid = I("get.schoolid");
        if($schoolid)
        {
            $school_name = $this -> school_model ->where("schoolid = $schoolid")-> order(array("schoolid" => "asc")) ->getField("school_name");
            $class = $this -> class_model ->where("schoolid = $schoolid")->select();
        }else{
            $this->error("学校有误!");
        }
        $this -> assign("school_name", $school_name);
       $this-> assign("class",$class);
        $this -> assign("schoolid", $schoolid);*/
  //----------改为获取缓存，下拉框选择学校
        $Province=role_admin();
        $cache_data = get_condition_cache($this->only_code);
        $this -> assign("cache_data", $cache_data);
        $this->assign("Province",$Province);
//-----------

        $this -> assign("only_code", $this->only_code);
        $this -> display();
    }

    function add_post() {

        if (IS_POST) {
            $name = I("post.student_name");

            $schoolid = $_POST['schoolid'];
            if(!$schoolid || !intval($schoolid))
            {
                $this->error('未获取到学校！');
            }
            $classid = $_POST['classs'];
            if(!$classid || !intval($classid))
            {
                $this->error('未获取到班级！');
            }
            $sex = Intval(I("sex"));
            $address = I('address');
            $phone = findNum(I('phone'));
            $native_place = I('native_place');

            $str=$_POST['smeta']['thumb'];
            $arr=explode("/", $str);
            $photo=$arr[count($arr)-1];

            $parent = I('parent');

            $card = findNum(I('card'));

            $show_Card = get_showcard($card,$schoolid);

            if($card) {
                if ($show_Card) {

                    $this->error("卡号已经存在");
                }
            }


            $show_student = get_student($schoolid,$name,$phone);

            if(!$show_student['status'])
            {

                $this->error($show_student['error']);
            }

            if($parent=='')
            {
                $parent = $name.'家长';
            }

            $parent_phone = I('parent_phone');

            $parent_name = I('parent_name');



            $relation = I('relation');





//            if(empty($photo))
//            {
//                $photo = "weixiaotong.png";
//            }



            if (!$sex) {
                $sex = 0;
            }


            $studentdata = array('name' => $name,  'photo'=>$photo,'schoolid' => $schoolid, 'sex' => $sex, 'password' => md5('school'), 'status' => '1', 'user_type' => '0', 'create_time' => time());
            // $dataarray = array(
            //              'userid'=>$userid,
            //              'studentid'=>$studentid,
            //              'teacherid'=>$teacherid,
            //              'content'=>$content,
            //              'create_time'=>time()
            //              );
            $studentid = $this -> wxtuser_model -> add($studentdata);
            // $this->success($studentid);
            if ($studentid) {
                $classdata = array("schoolid" => $schoolid, "classid" => $classid, "userid" => $studentid);
                $result = $this -> relation_stu_class_model -> add($classdata);

                if ($result) {
                    $lenfthz=7-strlen($studentid);
                    $lastResultz = ""; // 存储返回的结果
                    for($i=0;$i<$lenfthz;$i++){
                        $lastResultz = "0" . $lastResultz;
                    }
                    $studentidz=$lastResultz.$studentid;
                    $bindingkey=rand(100000,999999);
                    $data = array(
                        'schoollid'=>$schoolid,
                        'stu_name'=>$name,
                        'address'=>$address,
                        'sex'=>$sex,
                        'userid'=>$studentid,
                        'classid'=>$classid,
                        'stu_id'=>substr(date('Y'),-2).$studentidz,
                        'create_time'=>time(),
                        'bindingkey'=>$bindingkey,
                        'native_place'=>$native_place,
                        'photo'=>$photo,
                    );
                    $stu_info = M("student_info")->add($data);
                    $show_parent = M("wxtuser")->where("phone = $phone")->find();


                    if($show_parent)
                    {
                        $parentid = $show_parent['id'];
                    }else{
                        $pwd = substr($phone, -6);
                        $datas=array(
                            'schoolid'=>$schoolid,
                            'name'=>$parent,
                            'phone'=>$phone,
                            'sex'=>$sex,
                            'password'=>md5($pwd),
                            'status'=>'1',
                            'user_type'=>'1',
                            'create_time'=>time()
                        );

                        $parentid=M("wxtuser")->add($datas);
                    }



                    //写入亲属关系表

                    $redata=array(
                        "studentid"=>$studentid,
                        "userid"=>$parentid
                    );

                    $redata['name']=$parent;
                    $redata['appellation']="家长";
                    $redata['phone']=$phone;
                    $redata['time']=time();
                    $redata['relation_rank']=1;
                    $redata['type']=1;
                    $redata['preferred']=1;

                    $rt = $this->relation_stu_user_model->add($redata);







                    if($card)
                    {
                        $classname = M("school_class")->where("id = $classid")->field("classname")->find();

                        $carddata  = array(
                            'schoolid'=>$schoolid,
                            'classId'=>$classid,
                            'personId'=>$studentid,
                            'className'=>$classname['classname'],
                            'cardNo'=>$card,
                            'cardType'=>0,
                            'uid'=>$card,
                            'name'=>$name,
//                            'imgUrl'=>$_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'],
                            'imgUrl'=>$photo,
                            'handletime'=>date("Y-m-d H:i:s",time()),
                            'handletimeint'=>time(),
                            'handletype'=>1,
                            'create_time'=>time(),
                        );

                        $card = M('student_card')->add($carddata);


                    }
                    //如果家属关系存在

                    if($relation)
                    {

                        //     exit();
                        $result = array();

                        foreach ($relation as $key => $value) {
                            $result[$key]['relation']=$relation[$key];


                            $result[$key]['parent_name']=$parent_name[$key];


                            $result[$key]['parent_phone']=$parent_phone[$key];
                        }



                        foreach ($result as  $value) {

                            if($value['relation']!= ''){
                                $parentdata = array(
                                    'schoolid'=>$schoolid,
                                    'name'=>$value['parent_name'],
                                    'password' => md5('123456'),
                                    'status'=>1,
                                    'user_type'=>'0',
                                    'create_time'=>time(),


                                );

                                $parentid = $this -> wxtuser_model -> add($parentdata);

                                if($parentid)
                                {
                                    $relationdata = array(
                                        'studentid'=>$studentid,
                                        'userid'=>$parentid,
                                        'name'=>$value['parent_name'],
                                        'phone'=>$value['parent_phone'],
                                        'appellation'=>$value['relation'],
                                        'time'=>time(),

                                    );

                                    $relation_add = M('relation_stu_user')->add($relationdata);
                                }
                            }
                        }



                    }
                    //获取条件缓存
                    $cache_data = get_condition_cache($this->only_code);




                    $this -> success("添加成功",U("Student/index",$cache_data));
                } else {
                    $this -> error("班级信息添加失败！");
                }
            } else {
                $this -> error("添加失败！");
            }
        }
    }

    //-------------------------学生信息修改start-------------------------------
    public function edit() {
        $studentid = intval($_GET['id']);
        $schoolid = intval($_GET['schoolid']);
        $this->assign("schoolid",$schoolid);

        if ($studentid) {

            $where['u.id'] = $studentid;
            $where['relation.type'] = 1;



            $rst = $this -> wxtuser_model
                ->alias("u")
                ->join("wxt_student_info s ON u.id = s.userid")
                ->join("wxt_relation_stu_user relation ON u.id = relation.studentid")
                ->where($where)
                ->field("u.name,u.id,s.in_residence,s.sex,s.native_place,s.birthday,s.address,s.stu_id,s.initdate,u.photo,relation.phone,relation.charging_phone")
                ->find();
            $card = M("student_card")->where("personId = $studentid and cardType = 0 and handletype = 1")->field("cardNo")->find();

            $department=M("department")->where("schoolid=$schoolid and status = 1")->order("id")->select();

            $photo = $rst['photo'];


            foreach ($department as &$item) {

                $department_teacher = M('department_teacher')->where("teacher_id = $studentid")->select();


                foreach ($department_teacher as $value) {
                    if($value['department_id']==$item['id'])
                    {
                        $item['teacher_status']=1;
                    }

                }
                //  $de_id=$item["id"];
                //  $member=M("department_teacher")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacher_id")->where("t.department_id=$de_id")->field("t.w.id,w.name")->select();
                // var_dump($member);

            }


            if ($rst) {


                $this->assign("card",$card);
                $this -> assign("student", $rst);
                $this->assign("photo",$photo);
                $this->assign("department",$department);
                $this->assign("only_code",$this->only_code);
                $this -> assign("studentid", $studentid);
                //获取条件接口
                $cache_data = get_condition_cache($this->only_code);
                $this -> assign("cache_data", $cache_data);
                $this -> display("changestudent");
            } else {
                $this -> error('学校数据获取失败，请重试！');
            }
        } else {
            $this -> error('数据传入失败！');
        }

    }

    public function edit_post() {
        if (IS_POST) {
            $schoolid = $_POST['schoolid'];

            $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);

            // var_dump($_POST['smeta']['thumb']);
            // echo $_SERVER['SERVER_NAME'];
            // exit();

            $str = $_POST['smeta']['thumb'];
            $arr = explode("/", $str);
            $photo = $arr[count($arr) - 1];

            $group = I('group');
            //卡号

            //手机号
            $phone = I("phone");


            //扣费号码
            $charging_phone = I("charging_phone");

            //旧的学生卡
            $oldcard = I('oldcard');

            $where['id'] = $_POST['student_id'];
            $name = $_POST['name'];
            if ($name != "") {
                $name = $_POST['name'];
            }
            $data['sex'] = $_POST['sex'];
            //新的
            $newcard = I('newcard');
            if ($newcard != "") {
                $lenfth = 10 - strlen($newcard);
                $lastResult = ""; // 存储返回的结果
                for ($i = 0; $i < $lenfth; $i++) {
                    $lastResult = "0" . $lastResult;
                }
                $ICcardsu = $lastResult . $newcard; //10位的卡号
            } else {
                $ICcardsu = "";
            }


            $userid = $_POST['student_id'];

            //查询卡号是否被使用
            $show_Card = get_showcard($newcard, $schoolid);

            if ($newcard != $oldcard) {
                if ($newcard) {
                    if ($show_Card) {

                        $this->error("卡号已经存在");
                    }
                }

            }

            //区分是否是13000000000
            $edit_phone = edit_phone(2,$phone,$userid,$schoolid);

            if (!$edit_phone) {

                if ($phone || $charging_phone) {
                    //查询该家长的信息
                    $parentid = M("relation_stu_user")->where("studentid = $userid and type = 1")->getField("userid");

                    $relation_phone = M("relation_stu_user")->where("studentid = $userid and type = 1")->save(array("phone" => $phone, "charging_phone" => $charging_phone));

                    M("wxtuser")->where("id = $parentid")->save(array("phone" => $phone));

                }
           }

            //$stu_main = M("student_info")->alias("s")->where("s.userid = $userid and s.schoollid = $schoolid")->join("wxt_school_class class ON s.classid=class.id")->field("s.photo,class.classname,s.classid")->find();
            //分组处理

            // $where_del['department_id'] = array('in',$depid);
            $where_del['teacher_id'] = $userid;
            $where_del['school_id'] = $schoolid;


            $del = M('department_teacher')->where($where_del)->delete();
            // var_dump($del);
            // exit();
            foreach ($group as $val) {

                $dep['department_id'] = $val;
                $dep['school_id'] = $schoolid;
                $dep['teacher_id'] = $userid;
                $alldata[]=$dep;
                unset($dep);

            }

            $result = M('department_teacher')->addAll($alldata);

            if($newcard!=$oldcard)
            {
                $where_card['cardNo']=$oldcard;
                $where_card['personId']=$userid;
                $where_card['cardType']=0;
                $where_card['handletype'] = 1;

                $cha=M("student_card")->where($where_card)->find();
                // var_dump($cha);
                if(!$cha){
                    $data["personId"]=$userid;
                    $data["cardNo"]=$ICcardsu;
                    $data['schoolid'] =$schoolid;
                    $data["create_time"]=time();
                    $data['name'] = $name;
                    $data['imgUrl'] = $_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'];
                    $data['handletime'] = date('Y-m-d H:i:s',time());
                    $data['handletimeint'] = time();
                    $data['handletype'] = 1;
                    $data["cardType"]=0;
                    //echo "dsadsa";
                    $card_add=M("student_card")->add($data);



                }else{
                    //将原来的表修改并添加替换添加时间并将状态改为删除 ,然后再新增一条card表的记录
                    $save_card['handletype'] = 0;
                    $save_card['handletime'] = date('Y-m-d H:i:s',time());
                    $save_card['handletimeint'] = time();

                    $card_gai=M("student_card")->where($where_card)->save($save_card);


                    if($card_gai){
                        $card_addc['className'] = $cha['classname'];
                        $card_addc['classId'] = $cha['classid'];
                        $card_addc['imgUrl'] = $cha['imgurl'];
                        $card_addc['name'] = $cha['name'];
                        $card_addc['personId']=$userid;
                        $card_addc['cardNo'] = $ICcardsu;
                        $card_addc['schoolid'] = $schoolid;
                        $card_addc['create_time'] = time();
                        $card_addc['handletime'] = date('Y-m-d H:i:s',time());
                        $card_addc['handletimeint'] = time();
                        $card_addc['handletype'] = 1;
                        $card_addc['cardType'] = 0;
                        // var_dump($card_addc);
                        $creat_card = M('student_card')->add($card_addc);

                        // var_dump($arr);

                    }


                }



            }


            //在student_card里也保存头像

            if($name || $_POST['smeta']['thumb'])
            {


                if($_POST['smeta']['thumb'])
                {
                    $cardinfo['imgUrl'] = $_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'];
                }


                $card_save = M("student_card")->where("personId = $userid and handletype = 1 and cardType = 0")->save($cardinfo);


            }

            //更新卡日志


            $sexss=$_POST['sex'];
            $res = $this -> wxtuser_model -> where("id =$userid") -> save(array('photo'=>$photo,'name'=>$name,'sex'=>$sexss));
            if ($userid) {



                $arr = array(
                    'stu_name'=>$name,
                    'sex'=>$_POST['sex'],
                    'in_residence'=>$_POST['in_residence'],
                    'birthday'=>$_POST['birthday'],
                    'initdate'=>$_POST['initdate'],
                    'photo'=> $_POST['smeta']['thumb'],
                    'stu_id'=>$_POST['stu_id'],
                    'address'=>$_POST['address'],
                    'native_place'=>$_POST['native_place'],
                );
                $stu = M('student_info')->where("userid =$userid")->save($arr);

                M("relation_stu_user")->where("studentid = $userid and type = 1")->save(array("name"=>$name.'家长'));

                update_card(0,$userid,$schoolid);

                //获取条件缓存
                $cache_data = get_condition_cache($this->only_code);


                $this -> success('保存成功',U("Student/index",$cache_data));

            } else {
//                $this -> success('保存成功',U("Student/index"));
                $this -> success('保存成功',U("Student/index",$cache_data));
            }
        } else {
            $this -> error("数据传输错误！");
        }

    }

    //-------------------------学生信息修改end-------------------------------
    function student_delete() {

        $userid = intval($_GET['id']);
        $schoolid = intval($_GET['schoolid']);
        if ($userid && $schoolid) {

            $appid=M('Wxmanage')->alias('wm')->join('wxt_wxmanage_school ws on wm.id=ws.manage_id ')->where("ws.schoolid = '$schoolid'")->field("wm.wx_appid")->find();

            $now=time();
            $nowday=date('Y-m-d H:i:s',$now);
            M('student_card')->where(array("personId"=>$userid,"handletype"=>1,"schoolid"=>$schoolid))->save(array("handletype"=>0,"handletime"=>$nowday,"handletimeint"=>$now));
            $rst = $this -> relation_stu_class_model -> where("userid=$userid") -> delete();
            $rstz = $this -> student_info_model -> where("userid=$userid") -> delete();

            $jiazhanglist = $this -> relation_stu_user_model -> where("studentid=$userid") -> field("userid")->select();
            $rest = $this -> relation_stu_user_model -> where("studentid=$userid") -> delete();
            if($jiazhanglist){
                foreach ($jiazhanglist as $value){
                    $jiazhangid=$value[userid];
                    $jiazhang = $this -> relation_stu_user_model -> where("userid=$jiazhangid") -> field("userid")->select();

                    if(empty($jiazhang)){
                       $teacher=M('teacher_info')->where(array("teacherid"=>$jiazhangid))->find();
                        if(empty($teacher)) {
                            //  $user = $this -> wxtuser_model -> where("id=$jiazhangid") -> delete();
                            //  在user表中删除家长
                            //删除绑定关系
                            M("xctuserwechat")->where(array("userid" => $jiazhangid, "appid" => $appid['wx_appid']))->delete();
                        }
                    }
                }
            }

            $user = $this -> wxtuser_model -> where("id=$userid") -> delete();

            if ($rst && $user) {
                $this -> success("删除成功！");
            } else {
                $this -> error("删除失败！");
            }
        } else {
            $this -> error('数据传入失败！');
        }
    }

    private function _getTree() {
        $schoolid = $_REQUEST['school'] ? 0 : intval($_REQUEST['school']);
        $result = $this -> school_model -> field("schoolid ,school_name as name") -> order(array("schoolid" => "asc")) -> select();

        $tree = new \Tree();
        $tree -> icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree -> nbsp = '&nbsp;&nbsp;&nbsp;';
        foreach ($result as $r) {
            // $r['str_manage'] = '<a href="' . U("AdminTerm/add", array("parent" => $r['term_id'])) . '">添加子类</a> | <a href="' . U("AdminTerm/edit", array("id" => $r['term_id'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("AdminTerm/delete", array("id" => $r['term_id'])) . '">删除</a> ';
            // $r['visit'] = "<a href='#'>访问</a>";
            // $r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
            $r['id'] = $r['schoolid'];
            // $r['name']=$r['school_name']
            // $r['parentid']=$r['parent'];
            $r['selected'] = $schoolid == $r['id'] ? "selected" : "";
            $array[] = $r;
        }

        $tree -> init($array);
        $str = "<option value='\$id' \$selected>\$spacer\$name</option>";
        $taxonomys = $tree -> get_tree(0, $str);
        $this -> assign("taxonomys", $taxonomys);
    }

    /*
     * 根据年级查出班级
     */
    public function gra_class() {
        $class = M('school_class');
        $c_list = $class -> where('schoolid =' . $_GET['schoolid']) -> select();
        //dump($c_list);
        $string = '<option value="">请选择班级</option>';
        for ($i = 0; $i < count($c_list); $i++) {
            $string = $string . "<option value='" . $c_list[$i]['id'] . "'>" . $c_list[$i]['classname'] . "</option>";
        }
        echo $string;
    }

    //亲属关系查看
    public function showqinshu()
    {
        $studentid = I('studentid');
        // var_dump($studentid);

        if ($studentid) {

            $relation = M('relation_stu_user')->where("studentid = $studentid and type = 0")->field("name,phone,appellation")->select();
            // var_dump($relation);

            $info["status"] = true;
            $info["msg"] = $relation;

            echo json_encode($info);


        }



    }





    public function qinshu(){
        $data1 = I('qinshu1');



        $student = I('studentid');


        $schoolid = I('schoolid');


        if(!empty($data1))
        {

            if ($data1[0]&&$data1[1]&&$data1[2]) {

                $old_phone = $data1[3];



                if(!$old_phone){

                    $datalist1['name'] = $data1[0];
                    $datalist1['password'] = md5('school');
                    $datalist1['phone'] = $data1[1];
                    $datalist1['schoolid'] = $schoolid;
                    $datalist1['create_time'] = time();
                    $insert1 = M('wxtuser')->add($datalist1);
                    $data_relate1['appellation'] = $data1[2];
                    $data_relate1['studentid'] = I('studentid');
                    $data_relate1['name'] = $data1[0];
                    $data_relate1['phone'] = $data1[1];
                    $data_relate1['userid'] = $insert1;
                    $data_relate1['time'] = time();
                    $relate1 = M('relation_stu_user')->add($data_relate1);
                    $info = '添加成功';
                }else{


                    $showold = M('relation_stu_user')->where("phone = $old_phone")->field("phone,id")->find();
                    $id = $showold['id'];

                    $data1 = array(
                        'name'=>$data1[0],
                        'phone'=>$data1[1],
                        'appellation'=>$data1[2],

                    );

                    $save = M('relation_stu_user')->where("id = $id")->save($data1);
                    $info = '添加成功';

                }
            }else{
                $this->error('数据不完整！');
            }
        }
        $data2 = I('qinshu2');

        if(!empty($data2)){

            if($data2[0]&&$data2[1]&&$data2[2]) {


                $old_phone2 = $data2[3];




                if(!$old_phone2){
                    $datalist2['name'] = $data2[0];
                    $datalist2['password'] = md5('school');
                    $datalist2['phone'] = $data2[1];
                    $datalist2['schoolid'] = $schoolid;
                    $datalist2['create_time'] = time();
                    $insert2 = M('wxtuser')->add($datalist2);
                    $data_relate2['appellation'] = $data2[2];
                    $data_relate2['name'] = $data2[0];
                    $data_relate2['phone'] = $data2[1];
                    $data_relate2['studentid'] = I('studentid');
                    $data_relate2['userid'] = $insert2;
                    $data_relate2['time'] = time();
                    $relate2 = M('relation_stu_user')->add($data_relate2);
                    $info = '添加成功';
                }else{

                    $showold = M('relation_stu_user')->where("phone = $old_phone2")->field("phone,id")->find();
                    $id = $showold['id'];

                    $data2 = array(
                        'name'=>$data2[0],
                        'phone'=>$data2[1],
                        'appellation'=>$data2[2],

                    );

                    $save = M('relation_stu_user')->where("id = $id")->save($data2);
                    $info = '添加成功';

                }


            }else{
                $this->error('数据不完整22!');
            }
        }


        $data3 = I('qinshu3');

        if(!empty($data3)){
            if($data3[0]&&$data3[1]&&$data3[2]){

                $old_phone3 = $data3[3];



                if(!$old_phone3){

                    $datalist3['name'] = $data3[0];
                    $datalist3['password'] = md5('school');
                    $datalist3['phone'] = $data3[1];
                    $datalist3['schoolid'] = $schoolid;
                    $datalist3['create_time'] = time();
                    $insert3 = M('wxtuser')->add($datalist3);
                    $data_relate3['appellation'] = $data3[2];
                    $data_relate3['name'] = $data3[0];
                    $data_relate3['phone'] = $data3[1];
                    $data_relate3['studentid'] = I('studentid');
                    $data_relate3['userid'] = $insert3;
                    $data_relate3['time'] = time();
                    $relate3 = M('relation_stu_user')->add($data_relate3);
                    $info = '添加成功';
                }else{

                    $showold = M('relation_stu_user')->where("phone = $old_phone3")->field("phone,id")->find();
                    //var_dump($showold);

                    $id = $showold['id'];

                    $data3 = array(
                        'name'=>$data3[0],
                        'phone'=>$data3[1],
                        'appellation'=>$data3[2],

                    );

                    $save = M('relation_stu_user')->where("id = $id")->save($data3);
                    $info = '添加成功';

                }
            }else{
                $this->error('数据不完整!');
            }

        }


        $info['status'] = true;
        $info['info'] = $info;


    }
    //批量删除学生 明天写
    public function all_del_student()
    {
       $schoolid = I("schoolid");

       $classid = I("classid");

       if($classid)
       {
           $uid = "";
          //根据学校和班级查询出所有
           $class_relationship =M("class_relationship")->where(array("schoolid"=>$schoolid,"classid"=>$classid))->field("userid")->select();
//           dump($class_relationship);
           foreach($class_relationship as $val)
           {
               $uid = $val['userid'].",".$uid;
           }
           $userid = trim($uid,",");
       }else{
           $userid = trim(I("s_id"),",");
       }

       if(!$userid)
       {
           $res =  $this->format_ret_else(0,"没有删除的学生");
           echo json_encode($res);
           exit();
       }
        $student = M("student_info")->where(array("userid"=>array("in",$userid)))->select();
;
        if ($userid && $schoolid) {

            $appid=M('Wxmanage')->alias('wm')->join('wxt_wxmanage_school ws on wm.id=ws.manage_id ')->where("ws.schoolid = '$schoolid'")->field("wm.wx_appid")->find();

            $now=time();
            $nowday=date('Y-m-d H:i:s',$now);

            M('student_card')->where(array("personId"=>array("in",$userid),"handletype"=>1,"schoolid"=>$schoolid))->save(array("handletype"=>0,"handletime"=>$nowday,"handletimeint"=>$now));
            $rst = $this -> relation_stu_class_model -> where(array("userid"=>array("in",$userid))) -> delete();
            $rstz = $this -> student_info_model -> where(array("userid"=>array("in",$userid))) -> delete();

            $jiazhanglist = $this -> relation_stu_user_model -> where(array("studentid"=>array("in",$userid))) -> field("userid")->select();
            $rest = $this -> relation_stu_user_model -> where(array("studentid"=>array("in",$userid))) -> delete();
            if($jiazhanglist){
                foreach ($jiazhanglist as $value){
                    $jiazhangid=$value[userid];
                    $jiazhang = $this -> relation_stu_user_model -> where("userid=$jiazhangid") -> field("userid")->select();

                    if(empty($jiazhang)){
                        $teacher=M('teacher_info')->where(array("teacherid"=>$jiazhangid))->find();
                        if(empty($teacher)) {


                            //删除绑定关系
                            M("xctuserwechat")->where(array("userid" => $jiazhangid, "appid" => $appid['wx_appid']))->delete();
                            //  在user表中删除家长
                           $this -> wxtuser_model -> where("id=$jiazhangid") -> delete();
                        }
                    }
                }
            }

            $user = $this -> wxtuser_model -> where(array("id"=>array("in",$userid))) -> delete();

        if ($rst && $user) {
              $res =  $this->format_ret_else(1,"删除成功");
            } else {
                $res =  $this->format_ret_else(0,"删除失败");
            }
        } else {
            $res =  $this->format_ret_else(0,"数据传入成功!");
        }

        echo json_encode($res);


    }

    public  function bindingkey(){

        $studentid=I("studentid");
        //var_dump($teacherid);
        $binkey = M('student_info')->where("userid=$studentid")->field('bindingkey')->select();

        if($binkey){
            $ret  = $this->format_ret_else(1,$binkey);
        }else{
            $ret  = $this->format_ret_else(0,"parms lost");
        }
        echo  json_encode($ret);

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
    function format_ret_else ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }

    // 	private function _getSchoolTree($term=array()){
    // 	$result = $this->terms_model->field("schoolid ,school_name as name")->order(array("schoolid"=>"asc"))->select();

    // 	$tree = new \Tree();
    // 	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
    // 	$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
    // 	foreach ($result as $r) {
    // 		// $r['str_manage'] = '<a href="' . U("AdminTerm/add", array("parent" => $r['term_id'])) . '">添加子类</a> | <a href="' . U("AdminTerm/edit", array("id" => $r['term_id'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("AdminTerm/delete", array("id" => $r['term_id'])) . '">删除</a> ';
    // 		// $r['visit'] = "<a href='#'>访问</a>";
    // 		// $r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
    // 		$r['id']=$r['term_id'];
    // 		// $r['parentid']=$r['parent'];
    // 		$r['selected']=in_array($r['term_id'], $term)?"selected":"";
    // 		$r['checked'] =in_array($r['term_id'], $term)?"checked":"";
    // 		$array[] = $r;
    // 	}

    // 	$tree->init($array);
    // 	$str="<option value='\$id' \$selected>\$spacer\$name</option>";
    // 	$taxonomys = $tree->get_tree(0, $str);
    // 	$this->assign("taxonomys", $taxonomys);
    // }
    private  function FetchRepeatMemberInArray($array) {
        // 获取去掉重复数据的数组
        $unique_arr = array_unique ( $array );
        // 获取重复数据的数组
        $repeat_arr = array_diff_assoc ( $array, $unique_arr );
        return $repeat_arr;
    }
}
