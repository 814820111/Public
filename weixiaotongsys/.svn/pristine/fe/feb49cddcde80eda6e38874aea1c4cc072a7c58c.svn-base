<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class WxbindinglogController extends AdminbaseController
{
    protected $menu_model;

    function _initialize()
    {
        parent::_initialize();
        $this->menu_model = D("Common/wechat_menu"); //自定义菜单表
        $this->auto_model = D("Common/wechat_auto_reply");//自动回复表
        $this->material_model = D("Common/wechat_material");//素材表
        $this->Region = D("Common/city");//区域表
        $this->only_code = strtolower(MODULE_NAME).'_'.strtolower(CONTROLLER_NAME);

    }

    public function index()
    {

        $Province=role_admin();//拉取地区
        $this->assign("Province",$Province);

        $pro = I("province"); //地区

        if($pro){
            $this->assign("province",$pro);
        }

        $citys = I("citys");
        if($citys){
            $this->assign("new_citys",$citys);
        }

        $message_type = I("message_type");
        if($message_type){
            $this->assign("new_message_type",$message_type);
        }

        $schoolid = I("schoolid"); //学校
        if($schoolid){
            $where["a.schoolid"]=$schoolid;
            $this->assign("schoolid",$schoolid);
        }
        else{
            $where["a.status"]=null;
        }

//        $bindingtype = I("bindingtype"); //绑定类型
//        if($bindingtype){
//            $where["a.bindingtype"]=$bindingtype;
//            $this->assign("bindingtype",$bindingtype);
//        }
        $status = I("status"); //绑定状态
        if($status){
            $where["a.status"]=$status;
            $this->assign("status",$status);
        }

        $tiaojian= I("tiaojian"); //类型
        if($tiaojian){
            $this->assign("tiaojian",$tiaojian);

            $shuzhi= I("shuzhi"); //模糊查找
            if($shuzhi){
                if ($where["a.status"]==null){
                    $where["a.status"]=array("gt",0);
                }
                if($tiaojian=="stu_name"){
                    $where["a.stu_name"]=array("like","%".trim(I('shuzhi'))."%");
                }

                if($tiaojian=="phone"){
                    $where["a.phone"]=array("like","%".trim(I('shuzhi'))."%");
                }
                if($tiaojian=="bindingkey"){
                    $where["a.bindingkey"]=array("like","%".trim(I('shuzhi'))."%");
                }

                if($tiaojian=="tch_phone"){
                    $where["a.tch_phone"]=array("like","%".trim(I('shuzhi'))."%");
                }
                if($tiaojian=="tch_bindingkey"){
                    $where["a.tch_bindingkey"]=array("like","%".trim(I('shuzhi'))."%");
                }



                $this->assign("shuzhi",$shuzhi);
            }

        }

        $start_time= I("start_time"); //开始时间
        if($start_time){
            $this->assign("start_time",$start_time);

        }
        $end_time= I("end_time"); //开始时间
        if($end_time){
            $this->assign("end_time",$end_time);

        }
        if($end_time && $start_time)
        {

            $where['a.bind_datetime_int']  = array('GT',strtotime($start_time));
            $where['a.bind_datetime_int'] = array('LT',strtotime($end_time));
        }

//        $count= M("service_charge as a")->
//        join("wxt_agent as b  on a.agentid=b.id")->
//        join("wxt_school as c  on a.schoolid=c.schoolid")->
//        join("wxt_package as e  on a.packageid=e.id")->
//        where($where)->
//        order('a.schoolid asc')->
//        field("b.name as agentname,c.school_name,e.name as packagename,a.*")->
//        count();
//
//        $page = $this->page($count,20);
//
//        $result = M("service_charge as a")->
//        join("wxt_agent as b  on a.agentid=b.id")->
//        join("wxt_school as c  on a.schoolid=c.schoolid")->
//        join("wxt_package as e  on a.packageid=e.id")->
//        limit($page->firstRow . ',' . $page->listRows)->
//        where($where)->
//        order('a.schoolid asc')->
//        field("b.name as agentname,c.school_name,e.name as packagename,a.*")->
//        select();
        $count = M("wxbinding_log as a")
            ->join("LEFT JOIN wxt_wxmanage b on a.appid=b.wx_appid")
            ->join("LEFT JOIN wxt_school c on a.schoolid=c.schoolid")
            ->field("a.*,c.school_name,b.wx_name")
            ->where($where)
            ->count();
        $page = $this->page($count,10);
        $result = M("wxbinding_log as a")
            ->join("LEFT JOIN wxt_wxmanage b on a.appid=b.wx_appid")
            ->join("LEFT JOIN wxt_school c on a.schoolid=c.schoolid")
            ->field("a.*,c.school_name,b.wx_name")
            -> limit($page->firstRow . ',' . $page->listRows)
            ->order("bind_datetime_int desc")
            ->where($where)
            ->select();
//        dump($result);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("result",$result);
        $this->display();
    }



    public function code_index()
    {


        $Province=role_admin();//拉取地区
        $this->assign("Province",$Province);

        $pro = I("province"); //地区

        if($pro){
            $this->assign("province",$pro);
        }

        $citys = I("citys");
        if($citys){
            $this->assign("new_citys",$citys);
        }

        $wxmanage = M('wxmanage')->field("wx_appid,id,wx_name")->select();//拉取公众号
        $this->assign('wxmanage',$wxmanage);
        $appid = I('appid'); //公众号ID  搜索条件
        if (!empty($appid)){
            $where['a.appid'] = $appid;
            $this->assign("appid", $appid);
        } else{
            $where["a.status"]=null;
        }

        $message_type = I("message_type");
        if($message_type){
            $this->assign("new_message_type",$message_type);
        }

//        $schoolid = I("schoolid"); //学校
//        if($schoolid){
//            $where["a.schoolid"]=$schoolid;
//            $this->assign("schoolid",$schoolid);
//        }
//        else{
//            $where["a.status"]=null;
//        }

//        $bindingtype = I("bindingtype"); //绑定类型
//        if($bindingtype){
//            $where["a.bindingtype"]=$bindingtype;
//            $this->assign("bindingtype",$bindingtype);
//        }
        $status = I("status"); //绑定状态
        if($status){
            $where["a.status"]=$status;
            $this->assign("status",$status);
        }

        $tiaojian= I("tiaojian"); //类型
        if($tiaojian){
            $this->assign("tiaojian",$tiaojian);

            $shuzhi= I("shuzhi"); //模糊查找
            if($shuzhi){
                if ($where["a.status"]==null){
                    $where["a.status"]=array("gt",0);
                }
                if($tiaojian=="code"){
                    $where["a.code"]=array("like","%".trim(I('shuzhi'))."%");
                }

                if($tiaojian=="phone"){
                    $where["a.phone"]=array("like","%".trim(I('shuzhi'))."%");
                }



                $this->assign("shuzhi",$shuzhi);
            }

        }

        $start_time= I("start_time"); //开始时间
        if($start_time){
            $this->assign("start_time",$start_time);

        }
        $end_time= I("end_time"); //开始时间
        if($end_time){
            $this->assign("end_time",$end_time);

        }
        if($end_time && $start_time)
        {

            $where['a.bind_datetime_int']  = array('GT',strtotime($start_time));
            $where['a.bind_datetime_int'] = array('LT',strtotime($end_time));
        }

        $count = M("wxbinding_sms_log as a")
            ->join("LEFT JOIN wxt_wxmanage b on a.appid=b.wx_appid")
            ->join("LEFT JOIN wxt_school c on a.schoolid=c.schoolid")
            ->field("a.*,c.school_name,b.wx_name")
            ->where($where)
            ->count();
        $page = $this->page($count,10);
        $result = M("wxbinding_sms_log as a")
            ->join("LEFT JOIN wxt_wxmanage b on a.appid=b.wx_appid")
            ->join("LEFT JOIN wxt_school c on a.schoolid=c.schoolid")
            ->field("a.*,c.school_name,b.wx_name")
            -> limit($page->firstRow . ',' . $page->listRows)
            ->order("bind_datetime_int desc")
            ->where($where)
            ->select();
//        dump($result);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("result",$result);
        $this->display();
    }


//    新增
    //学校微信人数绑定统计
    public function weixincount()
    {
//        dump($_GET);
        //拉取地区
        $Province=role_admin();
        $this->assign("Province",$Province);

        $pro = I("province"); //地区

        if($pro){
            $this->assign("province",$pro);
        }

        $citys = I("citys");
        if($citys){
            $cityschool = M("school")->where(array("city"=>$citys))->field("schoolid")->select();

            if($cityschool)
            {
                $arr ="";
                foreach ($cityschool as $value)
                {
                    $arr.=$value['schoolid'].",";
                }
                //echo  $arr;
                $where["schoolid"] = array("in",$arr);
            }

            $this->assign("new_citys",$citys);
        }else{
            $where["schoolid"] = 0;
        }

        $message_type = I("message_type");
        if($message_type){

            $messageschool = M("school")->where(array("area"=>$message_type))->field("schoolid")->select();
//            dump($messageschool);

            if($messageschool)
            {
                $arrs ="";
                foreach ($messageschool as $value)
                {
                    $arrs.=$value['schoolid'].",";
                }
                //echo  $arr;
                $where["schoolid"] = array("in",$arrs);
            }else{
                $where["schoolid"]=0;
            }

            $this->assign("new_message_type",$message_type);
        }

        //学校ID
        $schoolid = I("schoolid");
        if($schoolid)
        {
            $where["schoolid"] = $schoolid;
            $this->assign("schoolid",$schoolid);
        }
//        else{
//            $where["schoolid"] = 0;
//        }

        $school = M("school")->where($where)->field("schoolid,school_name,area")->order("area")->select();
        foreach ($school  as &$value)
        {
            $area = M("city")->where(array("term_id"=>$value["area"]))->find();
            $value["areaname"] = $area["name"];
            $schoolid = $value["schoolid"];
            //查找这学校的老师
            $teacher = M("teacher_info")->where(array("schoolid"=>$schoolid))->select();

            //查询这个学校的学生
            //查找这学校的老师
            $students = M("student_info")->where(array("schoollid"=>$schoolid))->select();
            //插到最后一个foreach里，判断微信是否绑定
            //查找学校所属的appid
            $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();
            $appid = $wxmanage["wx_appid"];//对应公众号的appid
            $teachercount = count($teacher);
            $teacher_weixin_count = 0;
            $studentcount = count($students);
            $student_weixin_count = 0;
            foreach ($teacher as &$teacherlist)
            {
                if($appid){
                    $where_app['userid'] = $teacherlist['teacherid'];
                    $where_app['wx_appid'] = $appid;
                    $teacher_appid = M("xctuserwechat")->where($where_app)->field("appid,userid")->find();

                    if($teacher_appid)
                    {
                        $teacher_weixin_count++;
                    }
                }
                unset($teacherlist);
            }
            $value["tcount"] = $teachercount;
            $value["t_yi_count"] = $teacher_weixin_count;
            $value["t_wei_count"] = $teachercount-$teacher_weixin_count;


            foreach ($students as &$student_userappid)
            {
                $where_user['studentid'] = $student_userappid['userid']; //学生ID

                $relss = M("relation_stu_user")->where($where_user)->field("userid")->select();//查询家属

                foreach ($relss as $values) {
                    $student_appid = M("xctuserwechat")->where(array("userid" => $values['userid'], "appid" =>$appid))->field("appid")->find();
                    if ($student_appid) {
                        $student_weixin_count++;
                        break;
                    }
                }
                unset($student_userappid);
            }
            $value["scount"] = $studentcount;
            $value["s_yi_count"] = $student_weixin_count;
            $value["s_wei_count"] = $studentcount-$student_weixin_count;

        }


        $this->assign("school",$school);
        $this->display();
    }

    //教师微信绑定详情
    public function teacher_count_details()
    {
        $province = I("province");

        $citys = I('citys');

        $message_type = I('message_type');




        $schoolids = I("schoolids");
        if($province && $citys)
        {
            //写入缓存
            write_condition($province,$citys,$message_type,$schoolids,$this->only_code);

        }
        $cache_data = get_condition_cache($this->only_code);
        $this->assign("cache_data",$cache_data);

        $schoolid = I("schoolid");//学校ID
        if($schoolid){
            $this->assign("schoolid",$schoolid);
        }

        $state = I("state");//状态
        if($state){
            $this->assign("state",$state);
        }

        //查找这学校的老师
//        $count = M("teacher_info as a")->join("wxt_wxtuser as b on a.teacherid=b.id")->where(array("a.schoolid"=>$schoolid))->field("a.*,b.phone")->count();
//        $page = $this->page($count, 10);
        $teacher = M("teacher_info as a")->
        join("wxt_wxtuser as b on a.teacherid=b.id")
            ->where(array("a.schoolid"=>$schoolid))
//            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("a.*,b.phone")->select();


        $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret,b.wx_name")->find();
        $appid = $wxmanage["wx_appid"];//对应公众号的appid
        $wx_name= $wxmanage["wx_name"];//对应公众号名称
        if($appid){
            foreach ($teacher as $key=>&$teacherlist)
            {
                //dump($teacherlist);


                $where_app['userid'] = $teacherlist['teacherid'];
                $where_app['wx_appid'] = $appid;
                $teacher_appid = M("xctuserwechat")->where($where_app)->field("appid,userid,createtime")->find();
                if($state==1)
                {
                    if($teacher_appid)
                    {
                        $teacherlist["wx_name"] = $wx_name;
                        $teacherlist["wx_ceate_time"] = date("Y-m-d H:i:s", $teacher_appid["createtime"]);
                        $teacherlist['is_binding'] = "已绑定";
                    }else{
                        unset($teacher[$key]);
                    }
                }
                if($state==2)
                {
                    if($teacher_appid)
                    {
                        unset($teacher[$key]);
                    }else{
                        $teacherlist['is_binding'] = "未绑定";
                        $teacherlist["wx_name"] = "";
                        $teacherlist["wx_ceate_time"] = "";
                    }
                }
//                    if($state==3){
//                        if($teacher_appid)
//                        {
//                            $teacherlist["wx_name"] = $wx_name;
//                            $teacherlist["wx_ceate_time"] = date("Y-m-d H:i:s", $teacher_appid["createtime"]);
//                            $teacherlist['is_binding'] = "已绑定";
//                        }else{
//                            $teacherlist['is_binding'] = "未绑定";
//                            $teacherlist["wx_name"] = "";
//                            $teacherlist["wx_ceate_time"] = "";
//                        }
//                    }

            }
        }
//        $this->assign("Page", $page->show('Admin'));
        $this->assign("teacher",$teacher);
        $this->display();
    }


    // 学生微信绑定统计
    public function student_count()
    {
        $province = I("province");

        $citys = I('citys');

        $message_type = I('message_type');




        $schoolids = I("schoolids");
        if($province && $citys)
        {
            //写入缓存
            write_condition($province,$citys,$message_type,$schoolids,$this->only_code);

        }
        $cache_data = get_condition_cache($this->only_code);
        $this->assign("cache_data",$cache_data);

        $schoolid = I("schoolid");//学校ID
        if($schoolid){
            $grades = M("school_grade")->where("schoolid = $schoolid")->field("name,gradeid")->order("gradeid")->select();
            $where["schoolid"] = $schoolid;
            $this->assign("grade",$grades);
            $this->assign("schoolid",$schoolid);
        }
        $grade = I("grade");
        if($grade)
        {
            $where["grade"] = $grade;
            $this->assign("gradeid",$grade);
        }
        $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret,b.wx_name")->find();
        $appid = $wxmanage["wx_appid"];//对应公众号的appid
        $class = M("school_class")->where($where)->select();

        foreach ($class as &$classlist)
        {
            //班级ID
            $classid = $classlist["id"];
            $classstudents = M("class_relationship")->where(array("classid"=>$classid))->select();
            $classlist["classcount"] = count($classstudents);
            $class_weixin_count = 0;
            foreach ($classstudents as &$student_userappid)
            {
                $where_user['studentid'] = $student_userappid['userid']; //学生ID

                $relss = M("relation_stu_user")->where($where_user)->field("userid")->select();//查询家属

                foreach ($relss as $values) {
                    $student_appid = M("xctuserwechat")->where(array("userid" => $values['userid'], "appid" =>$appid))->field("appid")->find();
                    if ($student_appid) {
                        $class_weixin_count++;
                        break;
                    }
                }
                unset($student_userappid);
            }
            $classlist["weixincount"] = $class_weixin_count;
            $classlist["wei_weixincount"] = count($classstudents)-$class_weixin_count;
        }

        //dump($class);
        $this->assign("class",$class);
        $this->display();
    }

    //学生微信绑定详情
    public function student_count_details()
    {
        $classid = I("classid");
        $schoolid = I("schoolid");
        if ($schoolid) {
            $class = M("school_class")->where(array("schoolid" => $schoolid))->select();
            $this->assign("class", $class);
            $where["a.schoolid"] = $schoolid;
            $this->assign("schoolid", $schoolid);
        }

        if ($classid) {
            $where["a.classid"] = $classid;
            $this->assign("classid", $classid);
        }

        $state = I("state");//状态
        if($state){
            $this->assign("state",$state);
        }

        $classstudents = M("class_relationship as a")->
        join("wxt_student_info as b on a.userid=b.userid")->
        where($where)->field("a.*,b.stu_name")->select();
        //插到最后一个foreach里，判断微信是否绑定
        //查找学校所属的appid
        $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret,b.wx_name")->find();

        $appid = $wxmanage["wx_appid"];//对应公众号的appid
        $wx_name = $wxmanage["wx_name"];//对应公众号名称
        if ($appid) {
            foreach ($classstudents as $key => &$studentlist) {
                //dump($teacherlist);

                $where_user['studentid'] = $studentlist['userid']; //学生ID

                $relss = M("relation_stu_user")->where($where_user)->field("userid,phone,type")->select();//查询家属

                $status = 0;
                foreach ($relss as $values) {
                    if($values["type"]==1){
                        $studentlist["phone"] = $values["phone"];
                    }
                    $student_appid = M("xctuserwechat")->where(array("userid" => $values['userid'], "appid" =>$appid))->field("appid,createtime")->find();
                    if ($student_appid) {
                        $status = 1;
                        break;
                    }


                }
                if( $state ==1)
                {
                    if($status){
                        $studentlist["wx_name"] = $wx_name;
                        $studentlist["wx_ceate_time"] = date("Y-m-d H:i:s", $student_appid ["createtime"]);
                        $studentlist['is_binding'] = "已绑定";
                    }else{
                        unset($classstudents[$key]);
                    }
                }

                if($state ==2)
                {
                    if($status){
                        unset($classstudents[$key]);

                    }else{
                        $studentlist['is_binding'] = "未绑定";
                        $studentlist["wx_name"] = "";
                        $studentlist["wx_ceate_time"] = "";
                    }
                }
            }

//            dump($classstudents);
//        $this->assign("Page", $page->show('Admin'));
            $this->assign("classstudents",$classstudents);

            $this->display();
        }
    }


    //老师微信绑定详情导出
    public function teacher_Lexcel()
    {
        $schoolid = I("schoolid");//学校ID
        // $schoolid = 2;//学校ID


        $state = I("state");//状态
        //$state = 3;//状态


        //查找这学校的老师
        $teacher = M("teacher_info as a")->
        join("wxt_wxtuser as b on a.teacherid=b.id")
            ->where(array("a.schoolid"=>$schoolid))
            ->field("a.*,b.phone")->select();


        $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret,b.wx_name")->find();
        $appid = $wxmanage["wx_appid"];//对应公众号的appid
        $wx_name= $wxmanage["wx_name"];//对应公众号名称
        if($appid){
            foreach ($teacher as $key=>&$teacherlist)
            {
                $where_app['userid'] = $teacherlist['teacherid'];
                $where_app['wx_appid'] = $appid;
                $teacher_appid = M("xctuserwechat")->where($where_app)->field("appid,userid,createtime")->find();
                if($state==1)
                {
                    if($teacher_appid)
                    {
                        $teacherlist["wx_name"] = $wx_name;
                        $teacherlist["wx_ceate_time"] = date("Y-m-d H:i:s", $teacher_appid["createtime"]);
                        $teacherlist['is_binding'] = "已绑定";
                    }else{
                        unset($teacher[$key]);
                    }
                }
                if($state==2)
                {
                    if($teacher_appid)
                    {
                        unset($teacher[$key]);
                    }else{
                        $teacherlist['is_binding'] = "未绑定";
                        $teacherlist["wx_name"] = "";
                        $teacherlist["wx_ceate_time"] = "";
                    }
                }
                if($state==3){
                    if($teacher_appid)
                    {
                        $teacherlist["wx_name"] = $wx_name;
                        $teacherlist["wx_ceate_time"] = date("Y-m-d H:i:s", $teacher_appid["createtime"]);
                        $teacherlist['is_binding'] = "已绑定";
                    }else{
                        $teacherlist['is_binding'] = "未绑定";
                        $teacherlist["wx_name"] = "";
                        $teacherlist["wx_ceate_time"] = "";
                    }
                }

            }
        }


        $ExceData = $teacher;
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
        $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"手机号码");
        $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"绑定状态");
        $objPHPExcel->getActiveSheet(0)->setCellValue('D1',"绑定时间");
        $objPHPExcel->getActiveSheet(0)->setCellValue('E1',"公众号");
        $Val = 2;

        foreach ($ExceData as $value)
        {
            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $Val, $value['name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . $Val, $value['phone']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . $Val, $value['is_binding']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . $Val, $value['wx_ceate_time']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E' . $Val, $value['wx_name']);
            $Val++;
        }
        if($schoolid) {
            $school_name = M('school')->where("schoolid=$schoolid")->getField("school_name");
            $filename = $school_name . '-' . '老师微信绑定数据导出';
        }else{
            $filename = '老师微信绑定数据导出';
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


    //学生微信绑定详情导出
    public function student_Lexcel()
    {
        $classid = I("classid");
        $schoolid = I("schoolid");
        if ($schoolid) {
            $where["a.schoolid"] = $schoolid;

        }

        if ($classid) {
            $where["a.classid"] = $classid;

        }

        $state = I("state");//状态

        $classstudents = M("class_relationship as a")->
        join("wxt_student_info as b on a.userid=b.userid")->
        where($where)->field("a.*,b.stu_name")->select();
        //插到最后一个foreach里，判断微信是否绑定
        //查找学校所属的appid
        $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret,b.wx_name")->find();

        $appid = $wxmanage["wx_appid"];//对应公众号的appid
        $wx_name = $wxmanage["wx_name"];//对应公众号名称
        if ($appid) {
            foreach ($classstudents as $key => &$studentlist) {
                //dump($teacherlist);

                $where_user['studentid'] = $studentlist['userid']; //学生ID

                $relss = M("relation_stu_user")->where($where_user)->field("userid,phone,type")->select();//查询家属

                $status = 0;
                foreach ($relss as $values) {
                    if($values["type"]==1){
                        $studentlist["phone"] = $values["phone"];
                    }
                    $student_appid = M("xctuserwechat")->where(array("userid" => $values['userid'], "appid" => $appid))->field("appid,createtime")->find();
                    if ($student_appid) {
                        $status = 1;
                        break;
                    }


                }
                if ($state == 1) {
                    if ($status) {
                        $studentlist["wx_name"] = $wx_name;
                        $studentlist["wx_ceate_time"] = date("Y-m-d H:i:s", $student_appid ["createtime"]);
                        $studentlist['is_binding'] = "已绑定";
                    } else {
                        unset($classstudents[$key]);
                    }
                }

                if ($state == 2) {
                    if ($status) {
                        unset($classstudents[$key]);

                    } else {
                        $studentlist['is_binding'] = "未绑定";
                        $studentlist["wx_name"] = "";
                        $studentlist["wx_ceate_time"] = "";
                    }
                }
            }
        }

        $ExceData = $classstudents;
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
        $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"手机号码");
        $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"绑定状态");
        $objPHPExcel->getActiveSheet(0)->setCellValue('D1',"绑定时间");
        $objPHPExcel->getActiveSheet(0)->setCellValue('E1',"公众号");
        $Val = 2;

        foreach ($ExceData as $value)
        {
            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $Val, $value['stu_name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . $Val, $value['phone']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . $Val, $value['is_binding']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . $Val, $value['wx_ceate_time']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E' . $Val, $value['wx_name']);
            $Val++;
        }
        if($schoolid) {
            $school_name = M('school')->where("schoolid=$schoolid")->getField("school_name");
            $filename = $school_name . '-' . '学生微信绑定数据导出';
        }else{
            $filename = '学生微信绑定数据导出';
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


    //学校微信人数导出
    public function weixin_excel()
    {
//        dump($_GET);
        //拉取地区

        $citys = I("citys");
        if($citys){
            $cityschool = M("school")->where(array("city"=>$citys))->field("schoolid")->select();

            if($cityschool)
            {
                $arr ="";
                foreach ($cityschool as $cityvalues)
                {
                    $arr.=$cityvalues['schoolid'].",";
                }
                //echo  $arr;
                $where["schoolid"] = array("in",$arr);
            }else{
                $where["schoolid"] = 0;
            }


        }

        $message_type = I("message_type");
        if($message_type){

            $messageschool = M("school")->where(array("area"=>$message_type))->field("schoolid")->select();
//            dump($messageschool);

            if($messageschool)
            {
                $arrs ="";
                foreach ($messageschool as $messagevalue)
                {
                    $arrs.=$messagevalue['schoolid'].",";
                }
                //echo  $arr;
                $where["schoolid"] = array("in",$arrs);
            }else{
                $where["schoolid"]=0;
            }

        }

        //学校ID
        $schoolid = I("schoolid");
        if($schoolid)
        {
            $where["schoolid"] = $schoolid;
            $this->assign("schoolid",$schoolid);
        }

//        dump($where);
        //die();

        $schoollist = M("school")->where($where)->field("schoolid,school_name,area")->order("area")->select();
        foreach ($schoollist  as &$value)
        {
            $area = M("city")->where(array("term_id"=>$value["area"]))->find();
            $value["areaname"] = $area["name"];
            $schoolid = $value["schoolid"];
            //查找这学校的老师
            $teacher = M("teacher_info")->where(array("schoolid"=>$schoolid))->select();

            //查询这个学校的学生
            //查找这学校的老师
            $students = M("student_info")->where(array("schoollid"=>$schoolid))->select();
            //插到最后一个foreach里，判断微信是否绑定
            //查找学校所属的appid
            $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();
            $appid = $wxmanage["wx_appid"];//对应公众号的appid
            $teachercount = count($teacher);
            $teacher_weixin_count = 0;
            $studentcount = count($students);
            $student_weixin_count = 0;
            foreach ($teacher as &$teacherlist)
            {
                if($appid){
                    $where_app['userid'] = $teacherlist['teacherid'];
                    $where_app['wx_appid'] = $appid;
                    $teacher_appid = M("xctuserwechat")->where($where_app)->field("appid,userid")->find();

                    if($teacher_appid)
                    {
                        $teacher_weixin_count++;
                    }
                }
                unset($teacherlist);
            }
            $value["tcount"] = $teachercount;
            $value["t_yi_count"] = $teacher_weixin_count;
            $value["t_wei_count"] = $teachercount-$teacher_weixin_count;


            foreach ($students as &$student_userappid)
            {
                $where_user['studentid'] = $student_userappid['userid']; //学生ID

                $relss = M("relation_stu_user")->where($where_user)->field("userid")->select();//查询家属

                foreach ($relss as $values) {
                    $student_appid = M("xctuserwechat")->where(array("userid" => $values['userid'], "appid" =>$appid))->field("appid")->find();
                    if ($student_appid) {
                        $student_weixin_count++;
                        break;
                    }
                }
                unset($student_userappid);
            }
            $value["scount"] = $studentcount;
            $value["s_yi_count"] = $student_weixin_count;
            $value["s_wei_count"] = $studentcount-$student_weixin_count;

        }

//        dump($schoollist);
//        die();

        $ExceData = $schoollist;
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
        $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"区域");
        $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"学校名称");
        $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"老师总数");
        $objPHPExcel->getActiveSheet(0)->setCellValue('D1',"教师已绑人数");
        $objPHPExcel->getActiveSheet(0)->setCellValue('E1',"教师未绑人数");
        $objPHPExcel->getActiveSheet(0)->setCellValue('F1',"学生总数");
        $objPHPExcel->getActiveSheet(0)->setCellValue('G1',"学生已绑人数");
        $objPHPExcel->getActiveSheet(0)->setCellValue('H1',"学生未绑人数");

        $Val = 2;

        foreach ($ExceData as $Excevalue)
        {
            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $Val, $Excevalue['areaname']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . $Val, $Excevalue['school_name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . $Val, $Excevalue['tcount']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . $Val, $Excevalue['t_yi_count']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E' . $Val, $Excevalue['t_wei_count']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('F' . $Val, $Excevalue['scount']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('G' . $Val, $Excevalue['s_yi_count']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('H' . $Val, $Excevalue['s_wei_count']);

            $Val++;
        }
        $filename = '微信绑定数据导出';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename.'.xls');
        header('Cache-Control: max-age=0');

        $objWriter =\ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_clean();//关键
        flush();//关键
        $objWriter->save('php://output');
        exit;


    }

    //学校进展
    public function wxmanage_count()
    {
        $Province=role_admin();
        $this->assign("Province",$Province);
        $pro = I("province"); //地区
        if($pro){
            $this->assign("province",$pro);
        }
        $citys = I("citys");
        if($citys){
            $cityschool = M("school")->where(array("city"=>$citys))->field("schoolid")->select();

            if($cityschool)
            {
                $arr ="";
                foreach ($cityschool as $value)
                {
                    $arr.=$value['schoolid'].",";
                }
                $where["schoolid"] = array("in",$arr);
            }

            $this->assign("new_citys",$citys);
        }else{
            $where["schoolid"] = 0;
        }

        $message_type = I("message_type");
        if($message_type){
            $messageschool = M("school")->where(array("area"=>$message_type))->field("schoolid")->select();
            if($messageschool)
            {
                $arrs ="";
                foreach ($messageschool as $value)
                {
                    $arrs.=$value['schoolid'].",";
                }
                $where["schoolid"] = array("in",$arrs);
            }else{
                $where["schoolid"]=0;
            }

            $this->assign("new_message_type",$message_type);
        }

        //学校ID
        $schoolid = I("schoolid");
        if($schoolid)
        {
            $where["schoolid"] = $schoolid;
            $this->assign("schoolid",$schoolid);
        }

        //查找学校
        $school = M("school")->where($where)->field("schoolid,school_name,area")->order("area")->select();
        //对数据进行相关的处理
        foreach ($school  as &$schoolvalue)
        {
            $area = M("city")->where(array("term_id"=>$schoolvalue["area"]))->find();
            $schoolvalue["areaname"] = $area["name"];

            $schoolid = $schoolvalue["schoolid"];

            //查询学生数据是否导入
            $student = M("student_info")->where(array("schoollid"=>$schoolid))->find();
            if(count($student)>0)
            {
                $schoolvalue["student_import"] = "已导入";
            }else{
                $schoolvalue["student_import"] = "未导入";
            }

            //查询老师数据是否导入
            $teacher = M("teacher_info")->where(array("schoolid"=>$schoolid))->find();
            if(count($teacher)>0)
            {
                $schoolvalue["teacher_import"] = "已导入";
            }else{
                $schoolvalue["teacher_import"] = "未导入";
            }

            //查询是否挂钩公众号
            $wxmanage_school = M("wxmanage_school")->where(array("schoolid"=>$schoolid))->find();
            if(count($wxmanage_school)>0)
            {
                $wxmanage = M("wxmanage")->where(array("id"=>$wxmanage_school["manage_id"]))->field("wx_name,wx_appid")->find();
                $schoolvalue["wxmanage"] = "已挂钩"."/".$wxmanage["wx_name"];

                $menu = M("wechat_menu")->where(array("manage_id"=>$wxmanage_school["manage_id"]))->field("manage_id")->find();

                if(count($menu)>0)
                {
                    $schoolvalue["is_menu"] = "已配置";
                    $schoolvalue["is_finish"] = "已完成";
                }else{
                    $schoolvalue["is_menu"] = "未配置";
                    $schoolvalue["is_finish"] = "未完成";
                }

                $template = M("template")->where(array("appid"=>$wxmanage["wx_appid"]))->field("schoolid")->find();

                if(count($template)>0)
                {
                    $schoolvalue["is_template"] = "已配置";
                }else{
                    $schoolvalue["is_template"] = "未配置";
                }


            }else{
                $schoolvalue["wxmanage"] = "未挂钩";
                $schoolvalue["wx_name"] = "";
                $schoolvalue["is_menu"] = "";
                $schoolvalue["is_template"] = "";
                $schoolvalue["is_finish"] = "";

            }

            $device = M("device")->where(array("schoolid"=>$schoolid))->field("schoolid,dualplatform")->find();
            if(count($device)>0)
            {
                if($device["dualplatform"]==1)
                {
                    $dualplatform = "单平台";
                }else{
                    $dualplatform = "双平台";
                }
                $schoolvalue["is_device"] = "已配置"."/".$dualplatform;
            }else{
                $schoolvalue["is_device"] = "未配置";
            }

            $face_school = M("face_school as a")->join("wxt_face_school_device as b on a.id=b.faceschoolid")->
            join("wxt_face_device as c on c.id=b.deviceid")->where(array("a.schoolid"=>$schoolid))->field("c.name")->find();
            if($face_school){
                $schoolvalue["is_face"] = "      人脸已配置"."/".$face_school["name"];
            }else{
                $schoolvalue["is_face"] = "";
            }



        }
//        dump($school);
        $this->assign("school",$school);
        $this->display();
    }

    //学校进展导出
    public function school_weixin_excel()
    {
        $citys = I("citys");
        if($citys){
            $cityschool = M("school")->where(array("city"=>$citys))->field("schoolid")->select();

            if($cityschool)
            {
                $arr ="";
                foreach ($cityschool as $value)
                {
                    $arr.=$value['schoolid'].",";
                }
                $where["schoolid"] = array("in",$arr);
            }

        }else{
            $where["schoolid"] = 0;
        }

        $message_type = I("message_type");
        if($message_type){
            $messageschool = M("school")->where(array("area"=>$message_type))->field("schoolid")->select();
            if($messageschool)
            {
                $arrs ="";
                foreach ($messageschool as $value)
                {
                    $arrs.=$value['schoolid'].",";
                }
                $where["schoolid"] = array("in",$arrs);
            }else{
                $where["schoolid"]=0;
            }

        }

        //学校ID
        $schoolid = I("schoolid");
        if($schoolid)
        {
            $where["schoolid"] = $schoolid;
        }

        //查找学校
        $school = M("school")->where($where)->field("schoolid,school_name,area")->order("area")->select();
        //对数据进行相关的处理
        foreach ($school  as &$schoolvalue)
        {
            $area = M("city")->where(array("term_id"=>$schoolvalue["area"]))->find();
            $schoolvalue["areaname"] = $area["name"];

            $schoolid = $schoolvalue["schoolid"];
            //查询学生数据是否导入
            $student = M("student_info")->where(array("schoollid"=>$schoolid))->find();
            if(count($student)>0)
            {
                $schoolvalue["student_import"] = "已导入";
            }else{
                $schoolvalue["student_import"] = "未导入";
            }

            //查询老师数据是否导入
            $teacher = M("teacher_info")->where(array("schoolid"=>$schoolid))->find();
            if(count($teacher)>0)
            {
                $schoolvalue["teacher_import"] = "已导入";
            }else{
                $schoolvalue["teacher_import"] = "未导入";
            }

            //查询是否挂钩公众号
            $wxmanage_school = M("wxmanage_school")->where(array("schoolid"=>$schoolid))->find();
            if(count($wxmanage_school)>0)
            {
                $wxmanage = M("wxmanage")->where(array("id"=>$wxmanage_school["manage_id"]))->field("wx_name,wx_appid")->find();
                $schoolvalue["wxmanage"] = "已挂钩"."/".$wxmanage["wx_name"];

                $menu = M("wechat_menu")->where(array("manage_id"=>$wxmanage_school["manage_id"]))->field("manage_id")->find();


                if(count($menu)>0)
                {
                    $schoolvalue["is_menu"] = "已配置";
                    $schoolvalue["is_finish"] = "已完成";
                }else{
                    $schoolvalue["is_menu"] = "未配置";
                    $schoolvalue["is_finish"] = "未完成";
                }

//                $template = M("template")->where(array("schoolid"=>$schoolid,"appid"=>$wxmanage["wx_appid"]))->field("schoolid")->find();
                $template = M("template")->where(array("appid"=>$wxmanage["wx_appid"]))->field("schoolid")->find();

                if(count($template)>0)
                {
                    $schoolvalue["is_template"] = "已配置";
                }else{
                    $schoolvalue["is_template"] = "未配置";
                }


            }else{
                $schoolvalue["wxmanage"] = "未挂钩";
                $schoolvalue["wx_name"] = "";
                $schoolvalue["is_menu"] = "";
                $schoolvalue["is_template"] = "";
                $schoolvalue["is_finish"] = "";

            }

            $device = M("device")->where(array("schoolid"=>$schoolid))->field("schoolid,dualplatform")->find();
            if(count($device)>0)
            {
                if($device["dualplatform"]==1)
                {
                    $dualplatform = "单平台";
                }else{
                    $dualplatform = "双平台";
                }
                $schoolvalue["is_device"] = "已配置"."/".$dualplatform;
            }else{
                $schoolvalue["is_device"] = "未配置";
            }

            $face_school = M("face_school as a")->join("wxt_face_school_device as b on a.id=b.faceschoolid")->
            join("wxt_face_device as c on c.id=b.deviceid")->where(array("a.schoolid"=>$schoolid))->field("c.name")->find();
            if($face_school){
                $schoolvalue["is_face"] = "      人脸已配置"."/".$face_school["name"];
            }else{
                $schoolvalue["is_face"] = "";
            }



        }

        $ExceData = $school;
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
        $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"区域");
        $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"学校名称");
        $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"老师数据导入");
        $objPHPExcel->getActiveSheet(0)->setCellValue('D1',"学生数据导入");
        $objPHPExcel->getActiveSheet(0)->setCellValue('E1',"挂钩公众号");
        $objPHPExcel->getActiveSheet(0)->setCellValue('F1',"公众号配置");
        $objPHPExcel->getActiveSheet(0)->setCellValue('G1',"模板配置");
        $objPHPExcel->getActiveSheet(0)->setCellValue('H1',"菜单配置");
        $objPHPExcel->getActiveSheet(0)->setCellValue('I1',"设备配置");
        $Val = 2;

        foreach ($ExceData as $Excevalue)
        {
            $device = $Excevalue['is_device'].$Excevalue['is_face'];
            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $Val, $Excevalue['areaname']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . $Val, $Excevalue['school_name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . $Val, $Excevalue['teacher_import']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . $Val, $Excevalue['student_import']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E' . $Val, $Excevalue['wxmanage']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('F' . $Val, $Excevalue['is_finish']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('G' . $Val, $Excevalue['is_template']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('H' . $Val, $Excevalue['is_menu']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('I' . $Val, $device);

            $Val++;
        }
        $filename = '学校进展数据导出';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename.'.xls');
        header('Cache-Control: max-age=0');

        $objWriter =\ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_clean();//关键
        flush();//关键
        $objWriter->save('php://output');
        exit;
    }
}

