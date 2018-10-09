<?php
/**
 * 后台首页  教师信息管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TeacherController extends AdminbaseController {
	protected $relation_stu_class_model;
	protected $terms_model;
	protected $teacher_class_model;
	protected $wxtuser_model;

	function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->teacherinfo_model = D("Common/teacher_info");
        $this->relation_stu_class_model = D("Common/class_relationship");
        $this->teacher_class_model = D("Common/teacher_class");
        $this->department_model = D("Common/department");
        $this->duty_model = D("Common/school_duty");
        $this->teacherduty_model=D("Common/duty_teacher");
        $this->department_teacher_model=D("Common/department_teacher");
        $this->city_model=D("Common/city");
        $this->only_code = strtolower(MODULE_NAME).'_'.strtolower(CONTROLLER_NAME);
    }
    function index(){
		$this->_lists();																											
		$this->_getTree();
		$this->display("index");
	}


	//排序
	public function listorders() {
		$status = parent::_listorders($this->term_relationships_model);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		} 
	}
	private  function _lists($status=1){

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
            //写入缓存
            write_condition($province,$citys,$message_type,$schoolid,$this->only_code);

        }elseif(!$get_keywordtype){



            S($this->only_code,null);
            $this->assign("Province",$Province);
            $this -> display('index');
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
            $join_card = "wxt_student_card card ON card.personId = t.id";
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

//        $count=$this->teacherinfo_model
//            ->alias("t")
//            ->join(C('DB_PREFIX')."wxtuser a ON a.id=t.teacherid")
//            ->join("".C('DB_PREFIX')."duty_teacher d on d.teacher_id=t.teacherid")
//            ->join(C('DB_PREFIX')."school s ON d.schoolid=s.schoolid")
//            ->join(C('DB_PREFIX')."city c ON c.term_id=s.city")
//            ->join($join_else)
//            ->where($map)
//            ->count();
		$page = $this->page($count, 20);


		$teachers=$this->teacherinfo_model
		->alias("t")
        ->join(C('DB_PREFIX')."wxtuser a ON a.id=t.teacherid")
            ->join(C('DB_PREFIX')."school s ON t.schoolid=s.schoolid")
            ->join(C('DB_PREFIX')."city c ON c.term_id=s.city")
         ->join($join_else)
         ->join($join_card)
		->field("t.teacherid as id,t.name,a.phone,a.photo,a.sex,a.create_time,t.schoolid AS schoolid,s.school_name AS school_name,c.term_id AS city,t.id as info_id")
		->where($map)
		->limit($page->firstRow . ',' . $page->listRows)
		->order("a.id desc")
		->select();
//        dump($map);
//		exit();

//		//去掉重复数据
//        $len = count ( $teachers );
//        for($i = 0; $i < $len; $i ++) {
//            for($j = $i + 1; $j < $len; $j ++) {
//                if ($teachers [$i]['id'] == $teachers [$j]['id']) {
//                    unset($teachers[$i]);
//                    break;
//                }
//            }
//        }
        foreach ($teachers as &$teacherinfo) {
			 $departmentlist=$this->department_model
			->alias("d")
			->join("wxt_department_teacher t ON d.id=t.department_id")
            ->where(array("t.teacher_id"=>$teacherinfo['id']))
            ->field('name,department_id')
            ->select();
             $departmentlistStr = "";
			 $departmentlistid = "";
			 foreach ($departmentlist as &$depart){
                 $departmentlistStr = $departmentlistStr . $depart['name'] . ';';
                 $departmentlistid = $departmentlistid . $depart['department_id'] . ',';
             }
            $teacherinfo["departmentlist"]=$departmentlistStr;
			$teacherinfo["departmentid"]=rtrim($departmentlistid,",");
			unset($teacherinfo);
		}



        foreach ($teachers as &$value) {
            $userid = $value['id'];

            $info_id = $value['info_id'];

            $schoolid = $value['schoolid'];


            $appid = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();


            if($appid){
                $where_app['userid'] = $userid;
                $where_app['wx_appid'] = $appid['wx_appid'];
//                $teacher_appid = M("xctuserwechat")->where("userid = $userid and appid = $appid'")->field("appid")->find();

                $teacher_appid = M("xctuserwechat")->where($where_app)->field("appid,userid")->find();

	            if($teacher_appid)
	            {
	            	$value['appid'] = $teacher_appid['appid'];
	            }
            }




            $card = M('student_card')->where("personId = $info_id and handletype = 1 and schoolid  = $schoolid")->field("cardNo")->find();

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
			     // $classStr = $classStr . $classitem['classname'] . ',';
        //          $classidstr = $classidstr . $classitem['id'].',';
            }
           
			$teacherclass["teacher_subject"]=rtrim($teacher_inforty, ",");
     
            $teacherclass["teacher_classid"] =$teacher_idsu;
			// unset($teacherclass);
		}
        $city=$this->city_model->order("term_id")->select();
    	$school = $this->school_model->order(array("schoolid = $school_id"))->getField("schoolid,school_name as name",true);
		// $this->assign("users",$users);
        $Province=role_admin();

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
    private  function _lists_teacherid_back($status=1){

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
            //写入缓存
            write_condition($province,$citys,$message_type,$schoolid,$this->only_code);

        }elseif(!$get_keywordtype){



            S($this->only_code,null);
            $this->assign("Province",$Province);
            $this -> display('index');
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

//        $count=$this->teacherinfo_model
//            ->alias("t")
//            ->join(C('DB_PREFIX')."wxtuser a ON a.id=t.teacherid")
//            ->join("".C('DB_PREFIX')."duty_teacher d on d.teacher_id=t.teacherid")
//            ->join(C('DB_PREFIX')."school s ON d.schoolid=s.schoolid")
//            ->join(C('DB_PREFIX')."city c ON c.term_id=s.city")
//            ->join($join_else)
//            ->where($map)
//            ->count();
        $page = $this->page($count, 20);


        $teachers=$this->teacherinfo_model
            ->alias("t")
            ->join(C('DB_PREFIX')."wxtuser a ON a.id=t.teacherid")
            ->join(C('DB_PREFIX')."school s ON t.schoolid=s.schoolid")
            ->join(C('DB_PREFIX')."city c ON c.term_id=s.city")
            ->join($join_else)
            ->join($join_card)
            ->field("t.teacherid as id,t.name,a.phone,a.photo,a.sex,a.create_time,t.schoolid AS schoolid,s.school_name AS school_name,c.term_id AS city,t.id as info_id")
            ->where($map)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("a.id desc")
            ->select();
//        dump($map);
//        dump($teachers);
//		exit();

//		//去掉重复数据
//        $len = count ( $teachers );
//        for($i = 0; $i < $len; $i ++) {
//            for($j = $i + 1; $j < $len; $j ++) {
//                if ($teachers [$i]['id'] == $teachers [$j]['id']) {
//                    unset($teachers[$i]);
//                    break;
//                }
//            }
//        }
        foreach ($teachers as &$teacherinfo) {
            $departmentlist=$this->department_model
                ->alias("d")
                ->join("wxt_department_teacher t ON d.id=t.department_id")
                ->where(array("t.teacher_id"=>$teacherinfo['id']))
                ->field('name,department_id')
                ->select();
            $departmentlistStr = "";
            $departmentlistid = "";
            foreach ($departmentlist as &$depart){
                $departmentlistStr = $departmentlistStr . $depart['name'] . ';';
                $departmentlistid = $departmentlistid . $depart['department_id'] . ',';
            }
            $teacherinfo["departmentlist"]=$departmentlistStr;
            $teacherinfo["departmentid"]=rtrim($departmentlistid,",");
            unset($teacherinfo);
        }

        foreach ($teachers as &$value) {
            $userid = $value['id'];

            $schoolid = $value['schoolid'];


            $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();


            if($appid){
                $teacher_appid = M("xctuserwechat")->where("userid = $userid and appid = '$appid'")->field("appid")->find();

                if($teacher_appid)
                {
                    $value['appid'] = $teacher_appid['appid'];
                }
            }





            $card = M('student_card')->where("personId = $userid and handletype = 1 and schoolid  = $schoolid")->field("cardNo")->find();

            $value['cardno'] = $card['cardno'];
        }

        foreach ($teachers as &$teacherchange) {



            $dutylist=$this->duty_model
                ->alias("d")
                ->join("wxt_duty_teacher t ON d.id=t.duty_id")
                ->where(array("t.teacher_id"=>$teacherchange['info_id'],'t.schoolid'=>$teacherchange['schoolid']))
                ->field('name')
                ->select();
            $dutyStr = "";
            foreach ($dutylist as &$duty){
                $dutyStr = $dutyStr . $duty['name'] . ';';

            }
            $teacherchange["dutylist"]=$dutyStr;
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
                // $classStr = $classStr . $classitem['classname'] . ',';
                //          $classidstr = $classidstr . $classitem['id'].',';
            }

            $teacherclass["teacher_subject"]=rtrim($teacher_inforty, ",");

            $teacherclass["teacher_classid"] =$teacher_idsu;
            // unset($teacherclass);
        }
        $city=$this->city_model->order("term_id")->select();
        $school = $this->school_model->order(array("schoolid = $school_id"))->getField("schoolid,school_name as name",true);
        // $this->assign("users",$users);
        $Province=role_admin();

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
        dump($teachers);



    }
    //地级划分
    public function Provinces(){
        $Province=I("Province");
        $Shisheng=M("City")->where("parent=$Province")->select();
        echo json_encode(array('data'=>$Shisheng,'message'=>'10000'));
    }

    //excel导入老师信息
    public function teacher(){
        $allcount=I('allcount');
        $successcount=I('successcount');
        $updatecount=I('updatecount');
        $info=I('info');
        $school = $this->school_model
            ->alias('s')
            ->join("".C('DB_PREFIX').'agent a ON s.agent_id=a.id')
            ->where("school_status =1 or 0 or 2")
            ->field("s.*,a.name as agent_name")
            ->order("school_status DESC,s.create_time DESC")
            // ->fetchsql(true)
            ->select();
        $this->assign("allcount",$allcount);
        $this->assign("successcount",$successcount);
        $this->assign("updatecount",$updatecount);
        $this->assign("info",$info);
        $this->assign("schools",$school);
        $this->display();
    }
   public function teacher_post(){
         

		$schoolid = intval(I('school'));
		
		$allcount=0;
		$successcount=0;
		$updatecount=0;
		if(!$schoolid){
			$this->error("请选择学校");
		}
       
        if(!$_FILES)
        {
        	echo "Dasdsa";
        	exit();
        }
      

		$upload = new \Think\Upload();// 实例化上传类

    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
    	$upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
    	$upload->rootPath  =      './'; // 设置附件上传根目录
    	$upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
    	$upload->autoSub   = 	 false;//不自动生成子文件夹
    	// 上传单个文件 
    	$info   =   $upload->uploadOne($_FILES['excel_file']);

         $type = $info['ext'];

         $file_name = $info['name'];
        // var_dump($_FILES);
        // exit();
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
            //use excel2007 for 2007 format
            $objPHPExcel = $objReader->load($file_puth);
            // $objPHPExcel->setActiveSheetIndex(1);
            $sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始) 
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
           // var_dump($highestColumn);
            //循环读取excel文件,读取一条,插入一条
            // $info='begin::';
            for($j=7;$j<=$highestRow;$j++)
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
            $rowNo = 6;
            foreach ($ExamPaper_arr as $key => $value)
            {
                //循环数据检测A=>教师姓名，B=>教师角色，C=>电话号码，D=>校园短号，E=>IC卡号，F=>班级，G=>科目，H=>班主任班级
                //如果题号或者题干不为空
                if(!empty($value['A'])||!empty($value['B'])||!empty($value["C"])){
                    $name=$value['A'];
                    $phone=$value['C'];
                    $sex="男";
                    $subject=$value['G'];
                    $duty=$value['B'];
                    $classname=$value['F'];
                    $school_sort_number = $value["D"];
                    $ic_number = $value["E"];
                    $mainclass = $value["H"];

                    $result=$this->importteacher(trim($name),trim($phone),trim($sex),trim($duty),trim($classname),trim($subject),trim($school_sort_number),trim($ic_number,','),trim($mainclass),$schoolid);

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
                    if($result == 1){
                        $successcount++;
                    }else if($result ==2){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"老师用户添加失败"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==3){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"职务绑定失败"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==4){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>" 科目绑定失败"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==5){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"IC卡号已存在"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result==6){
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
        $allcount=$highestRow-6;
        $emptyData = "";
        foreach ($error_info as &$error_item){
            $emptyData = $emptyData."第".($error_item["row"]+1)."行".$error_item["msg"]."、";
        }
   
      if(!empty($emptyData))
      {
            $data_excel =  array(
                       'schoolid'=>$schoolid,
                       'filename'=>$file_name,
                        'type'=>$type,
                        'time'=>time(),
                        'pro'=>rtrim($emptyData, ","),
                        'status'=>1,
                        'state'=>3

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
                        'state'=>3,

                        );
            $teacher_excel = M('teacher_excel')->add($data_excel);


      }

        $info='::其中成功'.$successcount.'人,'.$emptyData;

        $this->success('导入完成','teacher/successcount/'.$successcount.'/allcount/'.$allcount.'/info/ok::'.$info);
    }
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
    function importteacher($username,$phone,$sexname,$dutyname,$classname,$subject,$school_sort_number,$ic_number,$mainclass,$schoolid){
        $result = 1;
        //判断学校信息是否存在
        if ($schoolid){
            $isShool = M("School")->where(array("id"=>$schoolid))->find();
            if (!$isShool){
                return 6;
            }
        }else{
            return 6;
        }
        //判断必填字段
        if(empty($username) || empty($dutyname)){
            return 0;
        }else{
            //逐项检测有效数据
            //1.性别判定
            $sex=0;
            if($sexname=='男'){
                $sex=1;
            }
            //2、职务获取 以"，"分割，获取职位数组
            $dutyList = explode(',',$dutyname);
           
            $dutyList = array_filter($dutyList);
           
            //3.获取教师负责科目 以"，"分割，获取科目数组
            $subjectList = explode(",",$subject);
            $subjectList = array_filter($subjectList);
            //3.1 获取教师负责班级信息: 以"，"分割，获取班級数组
            $classList = explode(",",$classname);
            $classList = array_filter($classList);

            if($ic_number)
            {
                $ic_number = explode(",", $ic_number);
            }


           foreach ($ic_number as &$card) {

               //ic卡号不到十位 在前面补位0
               if (strlen($card) < 10) {

                   $lastResult = ""; // 存储返回的结果
                   for ($i = 0; $i < 10 - strlen($card); $i++) {
                       $lastResult = "0" . $lastResult;
                   }
                   $card = $lastResult . $card;

               }
               if ($card == "0000000000") {
                   $card = "";
               }
           }

            //4.在user表中存入老师信息 : 检测用户是否已经存在如果存在并返回ID， 如果不存在，新写入并返回ID
//            $userwhere['phone']=$phone;
            if(!$phone)
            {
                $phone = 13000000000;
            }
            $userwhere['phone'] = $phone;
            $user=$this->wxtuser_model->where($userwhere)->field('id')->find();

            if($phone==13000000000){

                $pwd = substr($phone, -6);

                $data = array(
                    'schoolid' => $schoolid,
                    'name' => $username,
                    'phone' => $phone,
                    'sex' => $sex,
                    'password' => md5($pwd),
                    'status' => '1',
                    'user_type' => '0',
                    'create_time' => time()
                );
                $userid = $this->wxtuser_model->add($data);
            }elseif ($user){

                $userid = $user["id"];
            }else{

                 $pwd = substr($phone, -6);
                 
                $data = array(
                    'schoolid' => $schoolid,
                    'name' => $username,
                    'phone' => $phone,
                    'sex' => $sex,
                    'password' => md5($pwd),
                    'status' => '1',
                    'user_type' => '0',
                    'create_time' => time()
                );
                $userid = $this->wxtuser_model->add($data);

            }

            //5.user 添加成功 后在teacher_info表中添加老师信息  在student_card存入老师ic卡信息
            if ($userid){
                //5.1teacher_info表中添加老师信息
                $teacher_info_find["schoolid"] = $schoolid;
                $teacher_info_find["teacherid"] = $userid;
                $teacher_info_find["name"] = $username;
                $teacher_info_find_result = M("teacher_info")->where($teacher_info_find)->find();
                if($teacher_info_find_result){
                     $result = 2;                                                                                                                                                                                   
                }else{
                    $bindingkey=rand(100000,999999);
                    $info_data = array(
                        "schoolid"=>$schoolid,
                        "teacherid"=>$userid,
                        "state"=>1,
                        "email"=>"",
                        "education_card"=>"",
                        'name'=>$username,
                        "work_card"=>"",
                        "description"=>"",
                        "shool_sort_number"=>$school_sort_number,
                        "bindingkey"=>$bindingkey
                    );
                    $user_info = M("teacher_info")->add($info_data);
                   
                }

                //5.2在student_card存入老师ic卡信息  和 卡记录表wxt_student_card_log
              foreach ($ic_number as $tea_card) {


                  $teacher_ic_find["cardNo"] = $card;
                  $teacher_ic_find["personId"] = $userid;
                  $teacher_ic_find["cardType"] = 1;
                  $teacher_ic_find_result = M("student_card")->where($teacher_ic_find)->find();


                  if ($teacher_ic_find_result) {
                      $result = 5;
                  } else {

                      $ic_number_find["cardNo"] = $tea_card;
                      $ic_number_find["schoolid"] = $schoolid;
                      $ic_number_find_result = M("student_card")->where($ic_number_find)->find();
                      if ($ic_number_find_result) {
                          $result = 5;
                      } else {
                          if ($ic_number != "") {

                              $ic_data = array(
                                  "cardNo" => $tea_card,
                                  "personId" => $userid,
                                  'name' => $username,
                                  "cardType" => 1,
                                  "handletime" => date('Y-m-d H:i:s', time()),
                                  "handletimeint" => time(),
                                  "schoolid" => $schoolid,
                                  "create_time" => time()
                              );
                              M("student_card")->add($ic_data);
                          }
                      }

                  }
              }
            }

            if ($user_info==false){
                $result =  7;
            }else {


                //6.循环插入教师职位关系 查找职务是否存在，并返回职务ID TO 这里需改造成 school_duty where条件需用上schoolid
                foreach ($dutyList as $key=>&$duty_item) {

                    $duty_where['name'] = $duty_item;
                    $duty_where['schoolid'] = $schoolid;

                    // $duty=M('duty')->where($duty_where)->field('id')->find(); todo 改造每个学校都有自己的权限
                    $duty = M('school_duty')->where($duty_where)->field('id,level')->find();
                    

                    if ($duty) {
                        $dutyid = $duty['id'];
                        $dudata = array(
                            "schoolid" => $schoolid,
                            "duty_id" => $dutyid,
                            "teacher_id" => $userid
                        );

                        $isduty = $this->teacherduty_model->where($dudata)->find();


                        if ($isduty) {
                            $result = 3;
                        } else {
                            //写入职务关系表
                            $rt = $this->teacherduty_model->add($dudata);
                            if (!$rt) {
                                echo "插入不成功!";
                                $result = 3;
                            }
                        }
                    } else {
                        $result = 3;
                    }
                }
            }
            //循环导入科目信息 查找该学校拥有的科目 若没有则插入失败 有则继续插入
            //wxt_subject 学校对应的科目表 ； wxt_default_subject 所有科目表
            foreach ($subjectList as &$subject_item){
                $subject_where["subject"] = $subject_item;
                $subject_find = M("default_subject")->alias("d")
                    ->join("wxt_subject s ON d.id = s.subjectid")
                    ->field("d.id,d.subject,s.id as school_subjectid")
                    ->where($subject_where)
                    ->find();

                if ($subject_find){//存在則存入wxt_teacher_subject 教师科目班级关系表 每个班级都导入任课
                    $subjectid = $subject_find["id"];
                    for ($i=0;$i<count($classList);$i++){
                        $subjectdata=array(
                            "schoolid"=>$schoolid,
                            "classid"=>$classList[$i],
                            "teacherid"=>$userid,
                            "subjectid"=>$subjectid
                        );
                        $isSubject=M("teacher_subject")->where($subjectdata)->find();
                        if($isSubject){
                            $result = 4;
                        }else{
                            //写入科目关系表
                            $st = M("teacher_subject")->add($subjectdata);
                            if ($st==false){
                                $result =  4;
                            }
                        }
                    }

                }
            }







            //循环导入教师班级信息
            foreach ($classList as &$class_item){
//                //3.2 判断是不是班主任
                $isClassMainTeacher = 2;
               if ($mainclass == $class_item){
                   $isClassMainTeacher = 1;
               }

                $class_where['classname']=$class_item;
                $class_where['schoolid']=$schoolid;
                $classid=M('school_class')->where($class_where)->field('id')->find();
               
             
                if($classid){
                    $class_data = array(
                        "teacherid"=>$userid,
                        "schoolid"=>$schoolid,
                        "classid"=>$classid["id"],
                        "type"=>$isClassMainTeacher,
                        "status"=>1
                    );
                    $isClassAdd = M("teacher_class")->where($class_data)->find();
                 
                    if ($isClassAdd==false){
                        $tea_class = M("teacher_class")->add($class_data);
                     
                        $result =  1;
                    }
                }else{
                    $result =  5;
                }

            }

        }
        return $result;
    }
    function importteacherr_teacherid_back($username,$phone,$sexname,$dutyname,$classname,$subject,$school_sort_number,$ic_number,$mainclass,$schoolid){
        $result = 1;
        //判断学校信息是否存在
        if ($schoolid){
            $isShool = M("School")->where(array("id"=>$schoolid))->find();
            if (!$isShool){
                return 6;
            }
        }else{
            return 6;
        }
        //判断必填字段
        if(empty($username) || empty($dutyname)){
            return 0;
        }else{
            //逐项检测有效数据
            //1.性别判定
            $sex=0;
            if($sexname=='男'){
                $sex=1;
            }
            //2、职务获取 以"，"分割，获取职位数组
            $dutyList = explode(',',$dutyname);

            $dutyList = array_filter($dutyList);

            //3.获取教师负责科目 以"，"分割，获取科目数组
            $subjectList = explode(",",$subject);
            $subjectList = array_filter($subjectList);
            //3.1 获取教师负责班级信息: 以"，"分割，获取班級数组
            $classList = explode(",",$classname);
            $classList = array_filter($classList);

            if($ic_number)
            {
                $ic_number = explode(",", $ic_number);
            }


            foreach ($ic_number as &$card) {

                //ic卡号不到十位 在前面补位0
                if (strlen($card) < 10) {

                    $lastResult = ""; // 存储返回的结果
                    for ($i = 0; $i < 10 - strlen($card); $i++) {
                        $lastResult = "0" . $lastResult;
                    }
                    $card = $lastResult . $card;

                }
                if ($card == "0000000000") {
                    $card = "";
                }
            }

            //4.在user表中存入老师信息 : 检测用户是否已经存在如果存在并返回ID， 如果不存在，新写入并返回ID
//            $userwhere['phone']=$phone;
            //这边13000000000只能插入一条
            if(!$phone)
            {
                $phone = 13000000000;
            }
            $userwhere['phone'] = $phone;
            $user=$this->wxtuser_model->where($userwhere)->field('id')->find();

            if($user){

                $userid = $user["id"];
            }else{

                $pwd = substr($phone, -6);

                $data = array(
                    'schoolid' => $schoolid,
                    'name' => $username,
                    'phone' => $phone,
                    'sex' => $sex,
                    'password' => md5($pwd),
                    'status' => '1',
                    'user_type' => '0',
                    'create_time' => time()
                );
                $userid = $this->wxtuser_model->add($data);

            }

            //5.user 添加成功 后在teacher_info表中添加老师信息  在student_card存入老师ic卡信息
            if ($userid){
                //5.1teacher_info表中添加老师信息
                $teacher_info_find["schoolid"] = $schoolid;
                $teacher_info_find["teacherid"] = $userid;
                $teacher_info_find["name"] = $username;
                $teacher_info_find_result = M("teacher_info")->where($teacher_info_find)->find();
                if($teacher_info_find_result){
                    $result = 2;
                }else{
                    $bindingkey=rand(100000,999999);
                    $info_data = array(
                        "schoolid"=>$schoolid,
                        "teacherid"=>$userid,
                        "state"=>1,
                        "email"=>"",
                        "education_card"=>"",
                        'name'=>$username,
                        "work_card"=>"",
                        "description"=>"",
                        "shool_sort_number"=>$school_sort_number,
                        "bindingkey"=>$bindingkey
                    );
                    $user_info = M("teacher_info")->add($info_data);

                }

                //5.2在student_card存入老师ic卡信息  和 卡记录表wxt_student_card_log
                foreach ($ic_number as $tea_card) {


                    $teacher_ic_find["cardNo"] = $card;
                    $teacher_ic_find["personId"] = $user_info;
                    $teacher_ic_find["cardType"] = 1;
                    $teacher_ic_find["handletype"] = 1;


                    $teacher_ic_find_result = M("student_card")->where($teacher_ic_find)->find();


                    if ($teacher_ic_find_result) {
                        $result = 5;
                    } else {

                        $ic_number_find["cardNo"] = $tea_card;
                        $ic_number_find["schoolid"] = $schoolid;
                        $ic_number_find["handletype"] = 1;
                        $ic_number_find_result = M("student_card")->where($ic_number_find)->find();
                        if ($ic_number_find_result) {
                            $result = 5;
                        } else {
                            if ($ic_number != "") {
                             //这里将userid 改为userid
                                $ic_data = array(
                                    "cardNo" => $tea_card,
                                    "personId" => $user_info,
                                    'name' => $username,
                                    "cardType" => 1,
                                    "handletime" => date('Y-m-d H:i:s', time()),
                                    "handletimeint" => time(),
                                    "schoolid" => $schoolid,
                                    "create_time" => time()
                                );
                                M("student_card")->add($ic_data);
                            }
                        }

                    }
                }
            }

            if ($user_info==false){
                $result =  7;
            }else {


                //6.循环插入教师职位关系 查找职务是否存在，并返回职务ID TO 这里需改造成 school_duty where条件需用上schoolid
                foreach ($dutyList as &$duty_item) {

                    $duty_where['name'] = $duty_item;
                    $duty_where['schoolid'] = $schoolid;

                    // $duty=M('duty')->where($duty_where)->field('id')->find(); todo 改造每个学校都有自己的权限
                    $duty = M('school_duty')->where($duty_where)->field('id')->find();

                    if ($duty) {
                        $dutyid = $duty['id'];
                        $dudata = array(
                            "schoolid" => $schoolid,
                            "duty_id" => $dutyid,
                            "teacher_id" => $userid
                        );

                        $isduty = $this->teacherduty_model->where($dudata)->find();


                        if ($isduty) {
                            $result = 3;
                        } else {
                            //写入职务关系表
                            $rt = $this->teacherduty_model->add($dudata);
                            if (!$rt) {
                                echo "插入不成功!";
                                $result = 3;
                            }
                        }
                    } else {
                        $result = 3;
                    }
                }
            }
            //循环导入科目信息 查找该学校拥有的科目 若没有则插入失败 有则继续插入
            //wxt_subject 学校对应的科目表 ； wxt_default_subject 所有科目表
            foreach ($subjectList as &$subject_item){
                $subject_where["subject"] = $subject_item;
                $subject_find = M("default_subject")->alias("d")
                    ->join("wxt_subject s ON d.id = s.subjectid")
                    ->field("d.id,d.subject,s.id as school_subjectid")
                    ->where($subject_where)
                    ->find();

                if ($subject_find){//存在則存入wxt_teacher_subject 教师科目班级关系表 每个班级都导入任课
                    $subjectid = $subject_find["id"];
                    for ($i=0;$i<count($classList);$i++){
                        $subjectdata=array(
                            "schoolid"=>$schoolid,
                            "classid"=>$classList[$i],
                            "teacherid"=>$user_info,
                            "subjectid"=>$subjectid
                        );
                        $isSubject=M("teacher_subject")->where($subjectdata)->find();
                        if($isSubject){
                            $result = 4;
                        }else{
                            //写入科目关系表
                            $st = M("teacher_subject")->add($subjectdata);
                            if ($st==false){
                                $result =  4;
                            }
                        }
                    }

                }
            }

            //循环导入教师班级信息
            foreach ($classList as &$class_item){
//                //3.2 判断是不是班主任
                $isClassMainTeacher = 2;
                if ($mainclass == $class_item){
                    $isClassMainTeacher = 1;
                }

                $class_where['classname']=$class_item;
                $class_where['schoolid']=$schoolid;
                $classid=M('school_class')->where($class_where)->field('id')->find();


                if($classid){
                    $class_data = array(
                        "teacherid"=>$user_info,
                        "schoolid"=>$schoolid,
                        "classid"=>$classid["id"],
                        "type"=>$isClassMainTeacher,
                        "status"=>1
                    );
                    $isClassAdd = M("teacher_class")->where($class_data)->find();

                    if ($isClassAdd==false){
                        $tea_class = M("teacher_class")->add($class_data);

                        $result =  1;
                    }
                }else{
                    $result =  5;
                }

            }

        }
        return $result;
    }

  //导出函数
  public function excel()
  {
  	$schoolid = I("schoold");
	$tiaojian = I("tiaojian");
	$shuzhi = I("shuzhi");
 
   
  if($tiaojian == "name")
  {
  	$where["u.$tiaojian"] = array('like', "%$shuzhi%");
  }

  if($tiaojian=="phone")
  {
    $where["u.phone"] = $shuzhi;
  }



   $where['t.schoolid'] = $schoolid;
    $teachers = M('teacher_info')
                    ->alias("t")
					->join("wxt_wxtuser u ON t.teacherid=u.id")
					->join("wxt_school s ON t.schoolid=s.schoolid")
		            ->where($where)
		            ->field('t.name,u.id,u.phone,s.school_name,u.sex,t.bindingkey')
		            ->select();
  

         foreach ($teachers as &$teacherinfo) {
			 $departmentlist=$this->department_model
			->alias("d")
			->join("wxt_department_teacher t ON d.id=t.department_id")
            ->where(array("t.teacher_id"=>$teacherinfo['id']))
            ->field('name')
            ->select();
			 $departmentlistStr = "";
			 foreach ($departmentlist as &$depart){
                 $departmentlistStr = $departmentlistStr . $depart['name'] . ',';

             }
			$teacherinfo["departmentlist"]=$departmentlistStr;
			unset($teacherinfo);
		}

		foreach ($teachers as &$teacherchange) {
			 $dutylist=$this->duty_model
			->alias("d")
			->join("wxt_duty_teacher t ON d.id=t.duty_id")
            ->where(array("t.teacher_id"=>$teacherchange['id']))
            ->field('name')
            ->select();
            $dutyStr = "";
            foreach ($dutylist as &$duty){
                $dutyStr = $dutyStr . $duty['name'] . ',';

            }
			$teacherchange["dutylist"]=$dutyStr;
			unset($teacherchange);
		}
		//插到最后一个foreach里，判断微信是否绑定
      $appid = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();

		foreach ($teachers as &$teacherclass) {
			 $classlist=$this->class_model
			->alias("c")
			->join("wxt_teacher_class t ON c.id=t.classid")
            ->where(array("t.teacherid"=>$teacherclass['id']))
            ->field('classname')
            ->select();
           
			 $classStr = "";
			 foreach ($classlist as &$classitem){
			     $classStr = $classStr . $classitem['classname'] . ',';
            }
			$teacherclass["classlist"]=$classStr;

            if($appid){
                $where_app['userid'] = $teacherclass['id'];
                $where_app['wx_appid'] = $appid['wx_appid'];
                $teacher_appid = M("xctuserwechat")->where($where_app)->field("appid,userid")->find();

                if($teacher_appid)
                {
                    $teacherclass['is_binding'] = "已绑定";
                }else{
                    $teacherclass['is_binding'] = "未绑定";
                }
            }
       
			unset($teacherclass);
		}


         // var_dump($teachers);
         // exit();
         $xlsName  = "User";

                $xlsCell  = array(

                array('school_name','学校'),

                array('id','编号'),

                array('name','姓名'),

                array('phone','手机'),

                array('bindingkey','微信绑定码'),

                array('departmentlist','科室'),

                array('dutylist','职位'),

                array('classlist','任课班级'),

                array('is_binding','是否绑定微信'),

                );
                //接收保存在SESSION的值
                $xlsData = $teachers;
             //学校名称
             $school_name = M("school")->where("schoolid = $schoolid")->getField("school_name");

                $fileNames =  $school_name.'-'.'老师数据导出';

            
       $this->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);
  }


	public function excel_list()
	{ 
     $begin = strtotime(I('begin'));
     $end = strtotime(I('end'));

     $roleid = admin_role();
      
     if($end && $begin)
     {
     	$where['t.time']  = array('GT',$begin);
		  $where['t.time'] = array('LT',$end); 
     }
      if($roleid!=1)
        {
          $join= "wxt_role_school rs ON rs.schoolid = t.schoolid";
          $where['rs.roleid'] = $roleid;
        } 

         $where['t.state'] = 3;


         $excel = M('teacher_excel')->alias("t")->join($join)->where($where)->order("t.time asc")->select();
      
        $this->assign("only_code",$this->only_code);
        $this->assign('excel',$excel);
		$this->display();
	}



    //通过区域来找对应的学校
    public function lookup(){
        $type=I("type");

        if($type!=""){
            if($type==0){
                $School=M("School")->where()->field("school_name,schoolid,schoolgradetypeid")->select();
            }else{
                $School=M("School")->where("city=$type")->field("school_name,schoolid,schoolgradetypeid")->select();
            }

        }else{
            $ret = $this->format_ret(0,'参数缺失！');
        }

        echo json_encode(array('data'=>$School,'message'=>'10000'));
    }
	function edit(){

          $schoolid = I('schoolid');
          // var_dump($schoolid);
       
		  $teacherid = intval($_GET['id']);
          
       
        if ($teacherid) {



            $rst = $this->wxtuser_model->alias("u")->where("u.id = $teacherid")->join("wxt_teacher_info t ON u.id = t.teacherid")->field("u.name,t.email,u.id,u.phone,u.birthday,u.photo,t.description")->find();


        
           $aa = $rst['birthday'];

             $birthday = date('Y-m-d',$aa);
          

                $department=M("department")->where("schoolid=$schoolid and status = 2")->order("id")->select();
                //暂时先这样改造

            $t_id = M("teacher_info")->where("teacherid = $teacherid and schoolid = $schoolid")->getField("id");

              $card = M('student_card')->where("cardType = 1 and handletype = 1 and personId = $t_id")->field("cardNo")->find();
              

        foreach ($department as &$item) {

            $department_teacher = M('department_teacher')->where("teacher_id = $teacherid")->select();

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
                $this->assign("card",$card['cardno']);
                $this->assign("schoolid",$schoolid);
                $this->assign("teacher",$rst);
                $this->assign("only_code",$this->only_code);
                $this->assign("department",$department);
                $this->assign("birthday",$birthday);
                $this->display("changeTeacher");

            } else {
                $this->error('学校数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }

	}
	function edit_post(){
		if (IS_POST) {
            $schoolid = I('schoolid');
            
            $teacherid = $_POST['teacher_id'];

              
           $ids = I('ids');
        
         
            $where['id']=$_POST['teacher_id'];
            if(!empty($_POST['name'])){
                $data['name']=$_POST['name'];
            }
            if(!empty($_POST['phone'])){
                $data['phone']=$_POST['phone'];
            }
            $newCardNo = I('cardNo');
            $oldCardNo = I('stu_old_card');
           
            $email = I('email');

            $description = I('description');

            if($email || $description || $data['name'])
            {
              $info = array(
               'email'=>$email,
               'description'=>$description,
                  'name'=>$data['name']

                );

              $teacher_info  = M("teacher_info")->where("teacherid = $teacherid")->save($info);

            }

             $str=$_POST['smeta']['thumb'];
             $arr=explode("/", $str);
             $photo=$arr[count($arr)-1];


            $data['photo'] = $photo;

            $data['birthday'] = strtotime($_POST['birthday']);




       
       
            $department = $_POST['group'];
            
            //分组
            $depid = implode(',', $ids);
        

            // $where_del['department_id'] = array('in',$depid);
            $where_del['teacher_id'] = $teacherid;
            $where_del['school_id'] = $schoolid;
       
            $del = M('department_teacher')->where($where_del)->delete();
          

        
            foreach ($department as $val) {
            
                 $dep['department_id'] = $val;
                 $dep['school_id'] = $schoolid;
                 $dep['teacher_id'] = $teacherid;
                $alldata[]=$dep;
                unset($dep);
            
            }

            //在student_card里也保存头像和播报名字

             if($_POST['name'] || $_POST['smeta']['thumb'])
            {
//                      if($_POST['name'])
//                      {
//                        $cardinfo['name'] = $_POST['name'];
//
//                      }

                      if($_POST['smeta']['thumb'])
                      {
                        $cardinfo['imgUrl'] = $_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'];
                      }
                      
                     $card_save = M("student_card")->where("personId = $teacherid and handletype = 1 and cardType = 1")->save($cardinfo); 


             }


            
            $result = M('department_teacher')->addAll($alldata);


            //传过来要有两个卡号一个为老的cardno 一个为新的cardno

            //暂时先这样改造  根据穿过来的userid 去查询teacherid  下次要把teacherid改回来  如果教师是13000000000 这样查找会重复

            $t_id = M("teacher_info")->where("teacherid = $teacherid and schoolid = $schoolid")->getField("id");


               $where_card['cardNo']=$oldCardNo;
               $where_card['personId']=$t_id;
               $where_card['cardType']=1;
               $where_card['handletype'] = 1;



                 $cha=M("student_card")->where($where_card)->select();


          
          if(!$cha){
            $data_c["personId"]=$t_id;
            $data_c["cardNo"]=$newCardNo;
            $data_c["schoolid"]=$schoolid;
            $data_c['name'] = $_POST['name'];
            $data_c['imgUrl'] = $_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'];
            $data_c["create_time"]=time();
            $data_c['handletime'] = date('Y-m-d H:i:s',time());;
            $data_c['handletimeint'] = time();
            $data_c['handletype'] = 1;
            $data_c["cardType"]=1;

            $card_add=M("student_card")->add($data_c);
            }else{
                //将原来的表修改并添加替换添加时间并将状态改为删除 ,然后再新增一条card表的记录
                  $save_card['handletype'] = 0;  
                  $save_card['handletime'] =date('Y-m-d H:i:s',time());;
                  $save_card['handletimeint'] = time();


                 $card_gai=M("student_card")->where($where_card)->save($save_card);
                 // var_dump($card_gai);

                 if($card_gai){
                 
                 $card_addc['personId']=$t_id;
                 $card_addc['cardNo'] = $newCardNo;
                 $card_addc['schoolid'] = $schoolid;
                 
                 if($cha['imgurl']){
                    $card_addc['imgUrl'] = $cha['imgurl'];
                 }

             
                 if($cha['name'])
                 {
                    $card_addc['name'] = $cha['name'];   
                 }

                              
                 $card_addc['create_time'] = time();
                 $card_addc['handletime'] = time();
                 $card_addc['handletimeint'] = time();
                 $card_addc['handletype'] = 1;
                 $card_addc['cardType'] = 1;
                 $creat_card = M('student_card')->add($card_addc); 
                }
            }


            update_card(1,$t_id,$schoolid);

            $user = $this->wxtuser_model->where($where)->save($data);

            $cache_data = get_condition_cache($this->only_code);


                $this->success("保存成功！",U('index',$cache_data));


        }else {
            $this->error("数据传输错误！");
        }

	}


    //修改教师卡号


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
          //默认成功
          $info['status'] = true;
        $ids=I('userid');

      
       $where['cardno']=$oldCardNo;
       $where['personId']=$ids;
       $where['cardType']=1;
       $where['handletype'] = 1;

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
            $data["cardType"]=1;
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
                 $card_addc['handletime'] = date("Y-m-d H:i:s",time());
                 $card_addc['handletimeint'] = time();
                 $card_addc['handletype'] = 1;
                 $card_addc['cardType'] = 1;
                 $creat_card = M('student_card')->add($card_addc); 
                }

              
            }

            update_card(1,$ids,$schoolid);
        }else{
             $this->error("未获取到数据！");
        }
          echo json_encode($info);
    }


   //删除老师卡号

    public function delcard()
    {

      $cardno = I('cardno');
      // var_dump($cardno);
      
      $delete = M('student_card')->where("cardno = $cardno and cardType = 1 and handletype = 1")->save(array("handletype"=>0));
    // var_dump($delete);

       if ($delete) {
                    $info['status'] = true;
                    $info['msg'] = $delete;
                } else {
                    $info['status'] = false;
                    $info['info'] = '修改失败';
                }
          echo json_encode($info);


    }







  //---------------------卡号end-----------------------------


 //----------------------重置密码--------------------------------

// TOODO 修改密码 没加正正则判断
        public function password()
        {
                    $teacherid=I("teacherid");
                     $password = I("password");   
                    $data = [
                        'password'=>$password
                    ];
                     $rel = M('wxtuser')->where("id=$teacherid")->setField('password',md5($password));
                     
                        if ($rel > 0) {
                                $info['status'] = true;
                                $info['msg'] = $teacherid;
                                 $info['info'] = '密码修改成功';
                            } else {
                                $info['status'] = false;
                                $info['info'] = '密码不能与上次相同';
                            echo json_encode($info);exit;
                            }
            //发送短信
            $schoolid=I("passschoolid");
            $name=$this->teacherinfo_model
                ->where("teacherid = '$teacherid' and schoolid = '$schoolid' ")
                ->field('name')
                ->find();
            $phone=M('wxtuser')
                ->where("id=$teacherid")
                ->field('phone')
                ->find();
            $msg =$name[name].'老师您好，您的密码已重置，重置后为'.$password;
            $type='1';
            $sms = new \Common\Controller\SmsController();
            $isphone=$sms->IsPhone($phone[phone],$type);
            if($isphone['status']){
            //发送短信并保存到数据库
            $sms->SendSms($phone[phone],$msg,$type);
            }else{
                $info['status'] = false;
                $info['info'] = $isphone['msg'];
            }
            if(!empty($isphone['imfo'])){
                $num=$isphone['imfo']+1;
                $info['info'] = '重置成功！该号码今日已发送重置密码短信'.$num.'条，同一号码一种类型的短信一天只允许发送5条短信';
            }
            echo json_encode($info);
          }




 //----------------------重置密码end--------------------------------------



  //-----------------------带班带课strat------------------------

public function showclass()
{
  $schoolid = I('schoolid');

  $school_class = M('school_class')->where("schoolid = $schoolid")->field('id,classname')->select();


     if ($school_class) {
            $info['status'] = true;
            $info['msg'] = $school_class;
            }else{
            $info['status'] = false;
            $info['msg'] = '404';
            }
     echo json_encode($info); 
  



}
    public function showzhiwei()
    {
        $schoolid = I('schoolid');

        $school_class = M('school_duty')->where("schoolid = $schoolid")->field("id,name as classname")->select();


        if ($school_class) {
            $info['status'] = true;
            $info['msg'] = $school_class;
        }else{
            $info['status'] = false;
            $info['msg'] = '404';
        }
        echo json_encode($info);




    }
    //通过老师id获取老师的认可情况(班级)
        public function teacher_class(){
            $teacherid=I("teacherid"); 
            $wheres["t.teacherid"]=$teacherid;
            // $wheres["t.type"]=1;      
            $teacher_subject=M("teacher_class")
            ->alias("t")
            ->join("wxt_school_class s ON s.id=t.classid")
            ->where($wheres)
            ->field("t.classid,s.classname")
            ->select();
            foreach ($teacher_subject as &$classid) {
                $c_id=$classid["classid"];
                $subject=M("school_class")
                ->alias("s")
                ->join("wxt_subject w ON w.gradeid=s.grade")
                ->join("wxt_default_subject d ON d.id=w.subjectid")
                ->where("s.id=$c_id")
                ->field("d.id,d.subject")
                ->select();
                $classid["subject"]=$subject;
                $where["t.teacherid"]=$teacherid;
                $where["t.classid"]=$c_id;
                $teacher_su=M("teacher_subject")->alias("t")->join("wxt_default_subject d ON t.subjectid=d.id")->where($where)->field("d.id,d.subject")->select();
                $classid["teacher_su"]=$teacher_su;
            }
            if($teacher_subject){
                $ret = $this->format_ret_else(1,$teacher_subject);
            }else{
                $ret = $this->format_ret_else(0,"lost params");
            }
            echo json_encode($ret);
            exit;
            
        }    

                //参数获取(状态，原因)
        function format_ret_else ($status, $data='') {
            if ($status){   
            //成功
                return array('status'=>'success', 'data'=>$data);
            }else{  
                //验证失败
                return array('status'=>'error', 'data'=>$data);
            }
        }
            


    //带班 科目
    
    public function subject()
    {
        $schoolid = I('schoolid');

        $school = M("school")->where("schoolid=$schoolid")->find();

        $schooltype = $school['schoolgradetypeid'];

        $where_subject['gradetype'] = $schooltype; 

        $where_c['gradetype'] = 0;
        $where_c['schoolid'] = 0;
        $where_c['isdefault'] = 0;
 
         
         $where_b['gradetype'] = $schooltype;
         $where_b['schoolid'] = 0;


         $data['gradetype'] = 0;
         $data['schoolid'] = $schoolid;
         $data['isdefault'] = 1;
        //获取年级
         //自建
        $subject_add=M("default_subject")->where($data)->select(); 
         
         //学校类型科目
        $default = M('default_subject')->where($where_b)->select();
  
        //通用科目
        $currency = M('default_subject')->where($where_c)->select();       
       //將集合发送到前台遍历 只显示自己学校的课程
       $subject = array_merge($subject_add,$default);

       $Wsubject = array_merge($currency,$subject);

      if ($Wsubject) {
                $info['status'] = true;
                $info['msg'] = $Wsubject;
                }else{
                $info['status'] = false;
                $info['msg'] = '404';
                }
         echo json_encode($info); 
     

  }   

        public function teacher_class_subject(){
            $schoolid=I('schoolid');
            $class_banji=I("class_banji");
            var_dump($class_banji);
            $teacherid=I("teacherid");
            var_dump($teacherid);
            $class_subject=I("class_subject");
            var_dump($class_subject);
            //$where['type']=2;
            $where['teacherid']=$teacherid;
            $where['schoolid']=$schoolid;
           // exit();
            $deletel=M("teacher_class")->where($where)->delete();
            $delete=M("teacher_subject")->where(" teacherid=$teacherid and schoolid='$schoolid'")->delete();
            foreach ($class_banji as &$items) {
                if(!empty($items["classid"])) {
                    $datas["schoolid"] = $schoolid;
                    $datas["teacherid"] = $teacherid;
                    $datas["classid"] = $items["classid"];
                    $datas["type"] = 2;
                    $class_add = M("teacher_class")->add($datas);
                }
            }           
            foreach ($class_subject as &$item) {
                $data["schoolid"]=$schoolid;
                $data["teacherid"]=$teacherid;
                $data["classid"]=$item["c_id"];
                $data["subjectid"]=$item["subject"];
                $info_add=M("teacher_subject")->add($data);
            }
        }

    //添加职务
    function teacher_zhiwei_edit(){
        $schoolid=I('schoolid'); var_dump($schoolid);
        $teacher_zhiwei=I("teacher_zhiwei");
        var_dump($teacher_zhiwei);
        $teacherid=I("teacherid");
        var_dump($teacherid);

        $rst = $this->teacherduty_model->where("teacher_id='$teacherid' and schoolid='$schoolid'")->delete();
        foreach ($teacher_zhiwei as &$items) {
            //$this->wxtuser_model->where($where)->save($data);
            //更新职务关系表
            if(!empty($items["zhiweiid"])) {
                $dutydata["teacher_id"] = $teacherid;
                $dutydata["schoolid"] = $schoolid;
                $dutydata["duty_id"] = $items["zhiweiid"];
                //$this->teacherduty_model->where($dutywhere)->save($dutydata);
                $rsts = $this->teacherduty_model->add($dutydata);
            }
        }


    }


  //-----------------------带班带课end------------------------





//删除教师
    function delete(){
        $teacherid = intval($_GET['id']);
        $schoolid= intval($_GET['id']);
        if($teacherid && $schoolid){


            $now=time();
            $nowday=date('Y-m-d H:i:s',$now);
            //查出学校的wxmanage
            $appid=M('Wxmanage')->alias('wm')->join('wxt_wxmanage_school ws on wm.id=ws.manage_id ')->where("ws.schoolid = '$schoolid'")->field("wm.wx_appid")->find();
            //将student_card改为0
            M('student_card')->where(array("personId"=>$teacherid,"handletype"=>1,"schoolid"=>$schoolid))->save(array("handletype"=>0,"handletime"=>$nowday,"handletimeint"=>$now));
            //删除老师带课表
            M("teacher_class")->where(array("teacherid"=>$teacherid,"schoolid"=>$schoolid))->delete();
            //删除老师信息表
            $rstss = M('teacher_info')->where(array("teacherid"=>$teacherid,"schoolid"=>$schoolid))->delete();

            //查询该老师下有没有绑定学生,如果没有则删除
            $jiazhang = M('relation_stu_user') -> where("userid=$teacherid") -> field("userid")->select();
            if(empty($jiazhang)){
                M("xctuserwechat")->where(array("userid"=>$teacherid,"appid"=>$appid['wx_appid']))->delete();
                $rst=$this->wxtuser_model->where("id=$teacherid")->delete();
            }

             if ($rstss) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }else{
                $this->error('数据传入失败！');
        }
} 
	//------------------教师的科室列表展示----------------
  
    //学校的所有分组列表
    public function departmentedit()
    {
      
      $schoolid = I("schoolid"); 

      $depid = I('depid');

      $dempar = M("department")->where("schoolid = $schoolid and status = 2")->select();


      $ids = explode(",", $depid);

        foreach ($dempar as &$value) {
            foreach ($ids as &$val) {
                
                if($value['id']==$val)
                {
                    $value['check'] = 1;
                }
            }
        }

   
        if($dempar){
                $ret = $this->format_ret_else(1,$dempar);
            }else{
                $ret = $this->format_ret_else(0,"lost params");
            }
            echo json_encode($ret);

              exit();
    


    }
  

      public function  departmentpost()
      {

        $groupid = I("group");

        // var_dump($groupid);
        // exit();

        $schoolid = I('schoolid');

        $teacherid = I("teacherid");

                    //分组
         $depid = implode(',', $groupid);
        

            // $where_del['department_id'] = array('in',$groupid);
            $where_del['teacher_id'] = $teacherid;
            $where_del['school_id'] = $schoolid;
       
            $del = M('department_teacher')->where($where_del)->delete();
            
            // var_dump($del);

        
            foreach ($groupid as $val) {
            
                 $dep['department_id'] = $val;
                 $dep['school_id'] = $schoolid;
                 $dep['teacher_id'] = $teacherid;
                $alldata[]=$dep;
                unset($dep);
            
            }
            
            $result = M('department_teacher')->addAll($alldata); 



            
        if($teacherid){
                $ret = $this->format_ret_else(1,$teacherid);
            }else{
                $ret = $this->format_ret_else(0,"lost params");
            }
            echo json_encode($ret);

      }









	public function departmentlist(){
        //科室管理  科室列表
        $teacherid = intval($_GET['id']);	 
        $schoolid = I('schoolid'); 
   
        if ($teacherid) {
              $rst = $this->department_teacher_model
            		->alias("tc")
            		->join("wxt_department u ON tc.department_id=u.id")
            		->field("tc.id,u.name,u.create_time")
            		->where("tc.teacher_id=$teacherid")
            		->select();
            		//var_dump($rst);
            $this->assign("schoolid",$schoolid);
           	$this->assign("teacherid",$teacherid);
            $this->assign("department",$rst);
            $this->display("departmentlist");
            
        } else {
            $this->error('数据传入失败！');
        }
    }
//-------------------教师科室列表展示结束--------------







//--------------------给教师添加科室------------------
   public function adddepartment(){
        //添加科室
        $teacherid = intval($_GET['teacher_id']);
        $schoolid = I('schoolid');
        $department_name = $this->department_model->where("schoolid = $schoolid and status = 1" )->order(array("id"=>"asc"))->select();
        $this->assign("schoolid",$schoolid);
        $this->assign("department_name",$department_name);
        $this->assign("teacherid",$teacherid);
        $this->display("adddepartment");
    }
   public function adddepartment_post(){
     	$d_id=$_POST['department_id'];
     	$t_id=$_POST['teacher_id'];
        $s_id = intval($this->department_model->where("id = $d_id")->getField('schoolid'));
        /*$s_id= $this->department_model
             ->alias("c")
             ->field("c.schoolid")
             ->where("id=$d_id")
            ->select();*/
   		$where_ands=array("department_id=$d_id");
   		array_push($where_ands, "teacher_id=$t_id","school_id=$s_id");
   		$where= join(" and ", $where_ands);
        $count =$this->department_teacher_model
            ->where($where)
            ->count();
        if($_POST){
        	if($count>0){
                $this->error("选择的科室已加入，请重新选择！");
        	}else{
           	    $department_id=$_POST['department_id'];
                $teacher_id=$_POST['teacher_id'];
                $school_id=$s_id;
           	 	$data=array(
                'department_id'=>$department_id,
                'teacher_id'=>$teacher_id,
                'school_id'=>$s_id
                );
           		$rzt = M("department_teacher")->add($data);
           	}
        }
            if($rzt){
               $this->success("添加成功!");
            }else{
                $this->error("添加失败！");
                }
            //}
                 //添加科室post
                 //$this->error('该功能暂时未开启！');
    }      
//--------------------添加科室结束-------------------
//-----------------------删除科室--------------------
    public function department_delete(){
    	$id=intval($_GET['department_id']);
        if ($id) {
            $rst = M("department_teacher")->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error($id ."删除失败！");
            }
        //$this->error('该功能暂时未开通！');
    }else {
                $this->error('数据传入失败！');
        }
}
//----------------------删除科室结束------------------
	// 职务管理
    public function duty_manage(){

    	//获取被查询人id TODO 改造后可以显示教师不同学校的职务
        //id得获取teacherinfo的id不能用
        $teacherid = intval($_GET['id']);
        if ($teacherid) {
            $dutylist = $this->teacherduty_model
                    ->alias("tc")
                    ->join("wxt_school_duty u ON tc.duty_id=u.id")
                    ->field("tc.id,u.name,tc.schoolid")
                    ->where("tc.teacher_id=$teacherid")
                    ->select();
                 $schoolid = '';   
            foreach ($dutylist as &$school_name) {
                 //现在的
                 $schoolid = $school_name['schoolid'];
                 
                  $school=$this->school_model->where("schoolid = $schoolid")->field("school_name,schoolid")->find();

                  $school_name["school"] = $school['school_name'];

            

                   //以前的
                  // $school=$this->school_model
                  //   ->alias("s")
                  //   ->join("wxt_wxtuser u ON s.schoolid=u.schoolid")
                  //   ->field("school_name")
                  //   ->where("u.id=$teacherid")
                  //   ->select();

                  // $school_name["school"]=$school;
               
            }
           
            $this->assign('dutylist',$dutylist);
            $this->assign('teacherid',$teacherid);
            $this->display("duty_manage");
        }else{
            $this->error('数据传入失败！');
        }

}
	//添加职务
	function add_duty(){
		$teacherid = intval($_GET['id']);
            $rst = $this->wxtuser_model->where(array("id"=>$teacherid))->find();
            //获取学校列表
            $schoollist = M('school')->field('schoolid,school_name')->select();
         
            //查询出老师和职务的对应关系
            $teacher_duty=$this->teacherduty_model
            ->where(array("teacher_id"=>$teacherid))
            ->find();
                $this->assign("teacher",$rst);
                $this->assign("teacherid",$teacherid);
                $this->assign("dutylist",$dutylist);
                $this->assign("teacherduty",$teacher_duty);
                $this->assign("schoollist",$schoollist);
                $this->display("addduty");
	}

	function add_duty_post(){
		if (IS_POST) {
            $where['id']=$_POST['teacher_id'];
            //$this->wxtuser_model->where($where)->save($data);
            	//更新职务关系表
            	$dutywhere["id"]=$_POST['teacherdutyid'];
            	$dutydata["teacher_id"]=$_POST['teacher_id'];
            	$dutydata["schoolid"]=$_POST['school_id'];
            	$dutydata["duty_id"]=$_POST['duty_id'];
            	//$this->teacherduty_model->where($dutywhere)->save($dutydata);
            	$this->teacherduty_model->add($dutydata);
                $this->success("保存成功！",U('index'));
        }else {
            $this->error("数据传输错误！");
        }
	}
	//删除职务
	public function duty_delete(){
    	$id=intval($_GET['id']);
        if ($id) {
            $rst = $this->teacherduty_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
        //$this->error('该功能暂时未开通！');
    }
	/*任课班级栏中的编辑*/
    //------------------教师的班级列表展示----------------
    public function classlist(){
        //科室管理  科室列表
        $schoolid = I('schoolid');
       
        $teacherid = intval($_GET['id']);     
        if ($teacherid) {
              $rst = $this->teacher_class_model
                    ->alias("tc")
                    ->join("wxt_school_class u ON tc.classid=u.id")
                    ->field("u.id,u.classname,u.create_time")
                    ->where("tc.teacherid=$teacherid")
                    ->select();
                    //var_dump($rst);
            $this->assign('schoolid',$schoolid);
            $this->assign("teacherid",$teacherid);
            $this->assign("class",$rst);
            $this->display("classlist");
            
        } else {
            $this->error('数据传入失败！');
        }
    }
//-------------------教师班级列表展示结束--------------
//-------------------添加班级--------------
	function addclass(){
		 //添加班级
        $schoolid = I('schoolid');
        $teacherid = intval($_GET['teacherid']);
        $class_name = $this->class_model->order(array("id"=>"asc"))->where("schoolid = $schoolid")->select();
         
        $this->assign("schoolid",$schoolid); 
        $this->assign("class_name",$class_name);
        $this->assign("teacherid",$teacherid);
        $this->display("addclass");
	}
	function addclass_post(){
		$d_id=$_POST['classid'];
        $t_id=$_POST['teacherid'];
        $s_id = intval($this->class_model->where("id = $d_id")->getField('schoolid'));
        $where_ands=array("classid=$d_id");
        array_push($where_ands, "teacherid=$t_id","schoolid=$s_id");
        $where= join(" and ", $where_ands);
        $count =$this->teacher_class_model
            ->where($where)
            ->count();
        if($_POST){
            if($count>0){
                $this->error("选择的班级已加入，请重新选择！");
            }else{
                $classid=$_POST['classid'];
                $teacherid=$_POST['teacherid'];
                $schoolid=$s_id;
                $data=array(
                'classid'=>$classid,
                'teacherid'=>$teacherid,
                'school_id'=>$s_id
                );
                $rzt = M("teacher_class")->add($data);
            }
        }
            if($rzt){
               $this->success("添加成功!");
            }else{
                $this->error("添加失败！");
                }
	}
//-------------------添加班级--------------
//-------------------删除班级--------------
     public function class_delete(){
        $id=intval($_GET['classid']);
        //var_dump($id);
        if ($id) {
            $rst = M("teacher_class")->where("classid=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        //$this->error('该功能暂时未开通！');
    }else {
                $this->error('数据传入失败！');
        }
}
//-------------------添加班级结束--------------
	function add(){

        $province = I("province");

        $citys = I("citys");
        $message_type = I("message_type");
        $schoolid = I("schoolid");


       if($province)
       {
           $this->assign("province",$province);
       }
       if($citys)
       {
           $this->assign("new_citys",$citys);
       }
       if($message_type)
       {
           $this->assign("new_message_type",$message_type);
       }
       if($schoolid)
       {
           $this->assign("schoolid",$schoolid);
        }

//		$schools = $this->school_model->order(array("schoolid"=>"asc"))->select();
//       dump($schools);
		$school_id = intval(I("get.school"));
		$school=$this->school_model->where("schoolid=$school_id")->find();
        $class=$this->class_model->order(array("id"=>"asc"))->select();
        $department=$this->department_model->order(array("id"=>"asc"))->select();

        $duty=M("duty")->order(array("id"=>"asc"))->select();
        //$duty=$this->duty_model->order(array("id"=>"asc"))->select();
        $Province=role_admin();
        $this->assign("Province",$Province);
		$this->assign("school",$school);
		$this->assign("schools",$schools);
        $this->assign("class",$class);
        $this->assign("only_code",$this->only_code);
        // $this->assign("department",$department);
        $this->assign("duty",$duty);
		$this->display();
	}
	
	function add_post(){
		if (IS_POST) {
			$name =I("post.teacher_name");
            $phone =I("post.teacher_phone");
			$schoolid = $_POST['school'];
			$departmentid= $_POST['dep'];
            $dutyid=$_POST['du'];
            $classid=$_POST['cl'];
			$sex=Intval(I("sex"));
             $str=$_POST['smeta']['thumb'];
             $arr=explode("/", $str);
             $avatar=$arr[count($arr)-1];
            
            $birthday = strtotime(I("birthday"));
            $ic = $_POST['ic'];
            $state = $_POST['state'];
            $email = $_POST['email'];
            $education_card = $_POST['education_card'];
            $work_card = $_POST['work_card'];
            $description = $_POST['description'];

            $pass=I("pass");
            // var_dump($pass);
            //$pass_again=I("pass_again");
            
            if(empty($pass))
            {
                //$this->error("密码不能为空!");
                $password=md5(substr($phone,-6));
            }else{
                $password=md5($pass);
            }
            

//            if($pass == $pass_again){
//                $password=md5($pass);
//            }else{
//                $this->error("两次密码输入的不一致");
//            }

            if(empty($phone)){
                $this->error("联系方式不能为空!");
            }

          
			if(empty($_POST['school'])){
				$this->error("请选择学校");
			}
            // if(empty($_POST['cl'])){
            //     $this->error("请选择班级");
            // }
            if(empty($_POST['du'])){
                $this->error("请选择职务");
            }
			if(empty($_POST['teacher_name'])){
				$this->error("请输入姓名");
			}
			if(!$sex){
				$sex=0;
			}

         

          $teacher_user = M('wxtuser')->where("phone = $phone")->field("id")->find();

          if($teacher_user)
          {
            $teacherid = $teacher_user['id'];

            $data=array(
                'photo' => $avatar,
                'birthday' => $birthday,
                'name'=>$name,
                'create_time'=>time()
                );
            $teacher=$this->wxtuser_model->where("id = $teacherid")->save($data);

          }else{

            $data=array(
                'photo' => $avatar,
                'birthday' => $birthday,
                'schoolid'=>$schoolid,
                'name'=>$name,
                'phone'=>$phone,
                'sex'=>$sex,
                'password'=>$password,
                'status'=>'1',
                'user_type'=>'0',
                'create_time'=>time()
                );



            $teacherid=$this->wxtuser_model->add($data);
          }
   




			// $this->success($studentid);
			if($teacherid){
                 //添加卡号 可能需要完善
                if($ic)
                {

//                if($ic!=""){
//                    $lenfth=10-strlen($ic);
//                    $lastResult = ""; // 存储返回的结果
//                    for($i=0;$i<$lenfth;$i++){
//                        $lastResult = "0" . $lastResult;
//                    }
//                    $ICcardsu=$lastResult.$ic; //10位的卡号
//
//                }else{
//                    $ICcardsu="";
//                }
                    $lenfth=10-strlen($ic);
                    $lastResult = ""; // 存储返回的结果
                    for($i=0;$i<$lenfth;$i++){
                        $lastResult = "0" . $lastResult;
                    }
                    $ICcardsu=$lastResult.$ic; //10位的卡号

                    $card_show = M("student_card")->where("handletype = 1 and cardType = 1 and  cardNo =  $ICcardsu")->find();
                    if($card_show){
                        $this->error("该卡号已经存在!");
                    }

                $carddata['cardNo']=$ICcardsu;
                $carddata['imgUrl'] = $_SERVER['SERVER_NAME'].$_POST['smeta']['thumb'];
                $carddata['name'] =$name;
                $carddata['create_time'] = time();
                $carddata['handletime'] = date('Y-m-d H:i:s',time());
                $carddata['handletimeint'] = time();
                $carddata['personId']=$teacherid;
                $carddata['schoolid']=$schoolid;
                $carddata['create_time']=time();
                $carddata['cardType']=1;

                $carrs=M('student_card')->add($carddata);

            }



                //添加科室信息
                $depdata=array(
                    "school_id"=>$schoolid,
                    "department_id"=>$departmentid,
                    "teacher_id"=>$teacherid
                    );
                $rs = $this->department_teacher_model->add($depdata);

                //添加职务信息
                $dudata=array(
                    "schoolid"=>$schoolid,
                    "duty_id"=>$dutyid,
                    "teacher_id"=>$teacherid
                    );
                $rt = $this->teacherduty_model->add($dudata);


                //添加班级信息 TODO 老师不需要所属班级
				// $teacher_class['teacherid'] = $teacherid;
    //             $teacher_class['schoolid'] = $schoolid;
    //             $teacher_class['classid'] = $classid;
    //             $teacher_class['type'] = 2;
    //             $teacher_class['status'] = 1;
    //             $rtc = M("Teacher_class")->add($teacher_class);
                    $bindingkey=rand(100000,999999);
                //添加老师个人信息wxt_teacher_info
                $teacher_info['schoolid'] = $schoolid;
                $teacher_info['teacherid'] = $teacherid;
                $teacher_info['state'] = $state;
                $teacher_info['email'] = $email;
                $teacher_info['name'] = $name;
                $teacher_info['education_card'] = $education_card;
                $teacher_info['work_card'] = $work_card;
                $teacher_info['description'] = $description;
                $teacher_info['bindingkey'] = $bindingkey;
                $rtinfo = M('Teacher_info')->add($teacher_info);


                if($rs&&$rt&&$rtinfo){
                    //获取条件缓存
                    $cache_data = get_condition_cache($this->only_code);
                    $this->success("添加成功！" ,U('index',$cache_data));
                }else{
                    $this->error("教师信息添加失败！");
                }

			}else{
				$this->error("添加失败！");
			}
		}
	}
	private function _getTree(){
		$schoolid=empty($_REQUEST['school'])?0:intval($_REQUEST['school']);
		$result = $this->school_model->field("schoolid ,school_name as name")->order(array("schoolid"=>"asc"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['id']=$r['schoolid'];
			$r['selected']=$schoolid==$r['id']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}

   
   public function department()
   {
     $schoolid = I('schoolid');

     $department = M('department')->where("schoolid = $schoolid and status = 2")->select();

      if($department){
                $ret = $this->format_ret_else(1,$department);
            }else{
                $ret = $this->format_ret_else(0,"lost params");
            }
            echo json_encode($ret);
            exit;


   } 
  public  function bindingkey(){
                         
             $teacherid=I("teacherid");
             $schoolid = I("schoolid");
            //var_dump($teacherid);
              $binkey = M('teacher_info')->where("teacherid=$teacherid and schoolid = $schoolid")->field('bindingkey')->select();
                  
            if($binkey){
                $ret  = $this->format_ret_else(1,$binkey);
                }else{
                   $ret  = $this->format_ret_else(0,"parms lost"); 
                }
            echo  json_encode($ret);

 }


	/*
    * 根据年级查出班级
    */
     public function gra_class() {
         $class = M('school_class');
         $c_list = $class->where('schoolid ='.$_GET['schoolid'])->select();
         //dump($c_list);
         $string = '<option value="">请选择班级</option>';
         for($i = 0; $i < count ( $c_list ); $i ++) {
             $string = $string. "<option value='" . $c_list [$i] ['id'] . "'>" . $c_list [$i] ['classname'] . "</option>";
         }
         echo $string;
     }

         public function exportExcel($expTitle,$expCellName,$expTableData,$fileNames){
            
           $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
            $fileName = $fileNames;//or $xlsTitle 文件名称可根据自己情况设定
            $cellNum = count($expCellName);
            $dataNum = count($expTableData);


            vendor('PHPExcel.PHPExcel');
             $objPHPExcel = new \PHPExcel();
           //var_dump($objPHPExcel);

              $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

           //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格

           // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
                $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);//单元格宽度
                $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');//设置字体
                $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);//设置字体大小
                // $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"名字");
                // $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"时间");
                // $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"照片");
            for($i=0;$i<$cellNum;$i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]); 
            } 
              // Miscellaneous glyphs, UTF-8   
            for($i=0;$i<$dataNum;$i++){
              for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
              }             
            }  
            
            header('pragma:public');
            header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
            header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
            $objWriter = \ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
            $objWriter->save('php://output'); 
            exit;   
             
    }
     
}