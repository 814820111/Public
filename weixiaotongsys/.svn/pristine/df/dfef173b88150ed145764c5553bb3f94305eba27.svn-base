<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ImportController extends AdminbaseController {
	
	protected $posts_model;
	protected $term_relationships_model;
	protected $terms_model;
	protected $relation_stu_class_model;
	protected $teacher_class_model;
	protected $wxtuser_model;
	
	function _initialize() {
		parent::_initialize();
		$this->school_model = D("Common/School");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->teacher_class_model= D("Common/teacher_class");
        $this->relation_stu_user_model = D("Common/relation_stu_user");
        $this->wxt_agent_model=D("Common/agent");
        $this->department_model=D("Common/department");
        $this->duty_model = D("Common/duty");
        $this->teacherduty_model=D("Common/duty_teacher");
        $this->department_teacher_model=D("Common/department_teacher");
        $this->relation_stu_class_model = D("Common/class_relationship");
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
                    $result=$this->importteacher(trim($name),trim($phone),trim($sex),trim($duty),trim($classname),trim($subject),trim($school_sort_number),trim($ic_number),trim($mainclass),$schoolid);

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
        if(empty($username) || empty($phone) || empty($dutyname)){
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
            var_dump($dutyList);
            $dutyList = array_filter($dutyList);
            var_dump($dutyList);
            //3.获取教师负责科目 以"，"分割，获取科目数组
            $subjectList = explode(",",$subject);
            $subjectList = array_filter($subjectList);
            //3.1 获取教师负责班级信息: 以"，"分割，获取班級数组
            $classList = explode(",",$classname);
            $classList = array_filter($classList);

            //ic卡号不到十位 在前面补位0
            if (strlen($ic_number)<10){
                $lastResult = ""; // 存储返回的结果
                for($i=0;$i<10-strlen($ic_number);$i++){
                    $lastResult = "0" . $lastResult;
                }
                $ic_number = $lastResult.$ic_number;
            }
            if ($ic_number=="0000000000"){
                $ic_number = "";
            }

            //4.在user表中存入老师信息 : 检测用户是否已经存在如果存在并返回ID， 如果不存在，新写入并返回ID
            $userwhere['phone']=$phone;
            $user=$this->wxtuser_model->where($userwhere)->field('id')->find();

            if($user){
            	return 2;
                $userid = $user["id"];
            }else {
                $data = array(
                    'schoolid' => $schoolid,
                    'name' => $username,
                    'phone' => $phone,
                    'sex' => $sex,
                    'password' => md5('123456'),
                    'status' => '1',
                    'user_type' => '0',
                    'create_time' => time()
                );
                $userid = $this->wxtuser_model->add($data);
                var_dump($userid);
                
            }

            //5.user 添加成功 后在teacher_info表中添加老师信息  在student_card存入老师ic卡信息
            if ($userid){
                //5.1teacher_info表中添加老师信息
                $teacher_info_find["schoolid"] = $schoolid;
                $teacher_info_find["teacherid"] = $userid;
                $teacher_info_find_result = M("teacher_info")->where($teacher_info_find)->find();
                if ($teacher_info_find_result){

                }else{
                    $bindingkey=rand(100000,999999);
                    $info_data = array(
                        "schoolid"=>$schoolid,
                        "teacherid"=>$userid,
                        "state"=>1,
                        "email"=>"",
                        "education_card"=>"",
                        "work_card"=>"",
                        "description"=>"",
                        "shool_sort_number"=>$school_sort_number,
                        "ic_number"=>$ic_number,
                        "bindingkey"=>$bindingkey
                    );
                    $user_info = M("teacher_info")->add($info_data);
                    var_dump($user_info);
                }

                //5.2在student_card存入老师ic卡信息  和 卡记录表wxt_student_card_log
                $teacher_ic_find["cardNo"] = $ic_number;
                $teacher_ic_find["personId"] = $userid;
                $teacher_ic_find["cardType"] = 1;
                $teacher_ic_find_result = M("student_card")->where($teacher_ic_find)->find();
                if ($teacher_ic_find_result){

                }else{

                    $ic_number_find["cardNo"] = $ic_number;
                    $ic_number_find["schoolid"] = $ic_number;
                    $ic_number_find_result = M("student_card")->where($ic_number_find)->find();
                    if ($ic_number_find_result){

                    }else{
                        if ($ic_number!=""){

                            $ic_data = array(
                                "cardNo" => $ic_number,
                                "personId" => $userid,
                                "cardType" => 1,
                                "schoolid" => $schoolid,
                                "create_time" => time()
                            );
                            M("student_card")->add($ic_data);

                            $ic_log_data = array(
                                "cardNo" => $ic_number,
                                "personId" => $userid,
                                "cardType" => 1,
                                "handletype"=>1,
                                "schoolid" => $schoolid,
                                "handletime" => date('Y-m-d H:i:s',time()),
                                "handletimeint"=>time()
                            );
                            M("student_card_log")->add($ic_log_data);
                        }


                    }

                }
            }

            if ($user_info==false){
                $result =  7;
            }

            //6.循环插入教师职位关系 查找职务是否存在，并返回职务ID
            foreach ($dutyList as &$duty_item){
            	
                $duty_where['name']=$duty_item;
                
                $duty=M('duty')->where($duty_where)->field('id')->find();
               
                if($duty){
                    $dutyid=$duty['id'];
                    $dudata=array(
                        "schoolid"=>$schoolid,
                        "duty_id"=>$dutyid,
                        "teacher_id"=>$userid
                    );

                    $isduty=$this->teacherduty_model->where($dudata)->find();
                  
                    if($isduty){
                        $result =  3;
                    }else{
                        //写入职务关系表
                        $rt = $this->teacherduty_model->add($dudata);
                        if ($rt==false){
                            $result =  3;
                        }
                    }
                }else{
                    $result =  3;
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
//                if ($mainclass == $class_item){
//                    $isClassMainTeacher = 1;
//                }

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
  
	//excel表导入试题
	public function student(){
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
        ->limit($page->firstRow . ',' . $page->listRows)
        ->select();
        $this->assign("allcount",$allcount);
        $this->assign("successcount",$successcount);
        $this->assign("updatecount",$updatecount);
        $this->assign("info",$info);
        $this->assign("schools",$school);
		$this->display();
	}
	public function student_post(){
		$schoolid = intval(I('school'));
		var_dump($schoolid);

	
		$allcount=0;
		$successcount=0;
		$updatecount=0;

		if(!$schoolid){
			$this->error("请选择学校");
		}
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
			var_dump($highestRow);
			$highestColumn = $sheet->getHighestColumn(); // 取得总列数
			var_dump($highestColumn);
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
			var_dump($info);
			// $info=$info.'end';
		   $successcount=0;
            $error_info = array();
            $rowNo = 1;
            var_dump($ExamPaper_arr);

      
			  foreach ($ExamPaper_arr as $key => $value)
            {
                //循环数据检测A=>学生姓名，B=>班级，C=>监护人姓名，D=>家长联系方式，L=>性别，M=>学号，N=>IC卡号，O=>是否住校
                //如果题号或者题干不为空
                if(!empty($value['A'])||!empty($value['B'])||!empty($value["D"])){
                    $name=$value['A'];
                    var_dump($value['A']);
                    var_dump($value['B']);
                    var_dump($value['D']);
                    $class=$value['B'];
                    $parent = $value['C'];
                    $phone=$value['D'];
                    $sex=$value['L'];
                    $stu_id=$value['M'];
                    $card = $value["N"];
                    $in_residence = $value["O"];
                    
                    $result=$this->importstudent(trim($name),trim($class),trim($parentname),trim($phone),trim($sex),trim($stu_id),trim($card),trim($in_residence),$schoolid);

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
                        var_dump($successcount);
                    }else if($result ==2){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"学生信息添加失败"
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
                    }else if ($result==0){
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
          var_dump($rowNo);
    	var_dump($emptyData);
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
	function importstudent($name,$class,$parentname,$phone,$sex,$stu_id,$card,$in_residence,$schoolid){
		
  //0.失败，1新增，2更新
		 $result = 1;

          //判断学校信息是否存在
        if ($schoolid){
            $isShool = M("School")->where(array("id"=>$schoolid))->find();
            var_dump($isShool);
            if (!$isShool){
                return 6;
            }
        }else{
            return 6;
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
		
		//判断家长名字为空时
		 if($parentname == ""){
		 	$parentnaem=$name."家长";
		 }
	    
		
   
			
		if(empty($name) || empty($class) || empty($phone)){
			
		
			 $result=0;
		}else{				
			//判断用户的性别
			if($sexname=='男'){
				$sex=1;
			}else{
				$sex=0;
			}
			
			//通过传入学校ID和班级名字；查找对应的班级；
			$class_where['schoolid']=$schoolid;
			$class_where['classname']=$class;
			$class=M('school_class')->where($class_where)->field('id')->find();             
			if($class){
				//如果不存在班级就弹出
				$classid=$class['id'];
				// $result=$result.'-d'.$departmentid;
				//查找父母账号是否存在，并返回父母的ID
				$parentwhere['phone']=$phone;			
				$parent=$this->wxtuser_model->where($parentwhere)->field('id')->find();
				//通过号码查如果存在这个号码就不添加学生
				if(!$parent){

                    

					$parentid=$parent['id'];
				
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
						var_dump($userid);
				
						if($userid){
						//写入学生表格				
						 $stu_id = date("Y").$userid;//获取学生的学号
						//导入学生表生成6位的激活
						 $bindingkey=rand(100000,999999);
						$classrelationdataiofo=array(
						"stu_id"=>$stu_id,
						"classid"=>$classid,
						"userid"=>$userid,
						"sex"=>$sex,
						"stu_name"=>$name,
						"bindingkey"=>$bindingkey,
						"schoollid"=>$schoolid,
						"create_time"=>time()
						);
					$Stuiofo=M("student_info")->add($classrelationdataiofo);

                    




					   	//写入班级关系表
						$classrelationdata=array(
							"schoolid"=>$schoolid,
							"classid"=>$classid,
							"userid"=>$userid
						);
					  $classrelationdata['create_time']=time();
					  $crs = $this->relation_stu_class_model->add($classrelationdata);


                      	$datas=array(
							'schoolid'=>$schoolid,
							'name'=>$parentnaem,
							'phone'=>$phone,
							'sex'=>$sex,
							'password'=>md5('123456'),
							'status'=>'1',
							'user_type'=>'1',
							'create_time'=>time()
					);

                        $parentid=M("wxtuser")->add($datas);

					   //写入亲属关系表
						$redata=array(
							"studentid"=>$userid,
							"userid"=>$parentid
						);
						  $redata['name']=$parentname;
						    $redata['phone']=$phone;
							$redata['time']=time();
							$redata['relation_rank']=1;
							$redata['type']=1;
							$redata['preferred']=1;
					$rt = $this->relation_stu_user_model->add($redata);
					     if(!empty($card)){
						//检测是否已经存在卡对应关系表
							$carddata['cardNo']=$ICcardsu;
							$iscard=M('student_card')->where($carddata)->find();
							if($iscard){
								$result=3;
							}else{
								//写入卡表
								$carddata['cardType']=0;
								$carddata['personId']=$userid;
								$carddata['schoolid']=$schoolid;
								$carddata['classid']=$classid;
								//added by pengshuguo 0624begin
								$carddata['classname']=$classname;
								$carddata['name']=$username;
								//added by pengshuguo 0624 end
								$carddata['create_time']=time();
								$carrs=M('student_card')->add($carddata);
<<<<<<< .mine
||||||| .r391
								$result=6;
=======
								$result=6;								
>>>>>>> .r613
							   //插入卡号日志表
							   if($carrs){
							   	  //写入卡表
								    $carddata['cardType']=0;
								    $carddata['personId']=$userid;
								    $carddata['schoolid']=$schoolid;
								    $carddata['classid']=$classid;
								    //added by pengshuguo 0624begin
									$carddata['classname']=$classname;
									$carddata['name']=$username;
									//added by pengshuguo 0624 end
								    $carddata['create_time']=time();
								    $carddata['handletype']=1;
								    $carrs=M('student_card_log')->add($carddata);  
                                 $result = 1;
							   }  
							}
						}
					     
					  }
                  
					}else{
						$result = 4;
					}

                
				}else{
				  
                $result = 5;

		      }

		  }
		return $result;
	}
	public function teacherclass(){
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
        ->limit($page->firstRow . ',' . $page->listRows)
        // ->fetchsql(true)
        ->select();
        $this->assign("allcount",$allcount);
        $this->assign("successcount",$successcount);
        $this->assign("updatecount",$updatecount);
        $this->assign("info",$info);
        $this->assign("schools",$school);
		$this->display();
	}
	public function teacherclass_post(){
		$schoolid = intval(I('school'));
		$allcount=0;
		$successcount=0;
		$updatecount=0;
		if(!$schoolid){
			$this->error("请选择学校");
		}
		$upload = new \Think\Upload();// 实例化上传类
    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
    	$upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
    	$upload->rootPath  =      './'; // 设置附件上传根目录
    	$upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
    	$upload->autoSub   = 	 false;//不自动生成子文件夹
    	// 上传单个文件 
    	$info   =   $upload->uploadOne($_FILES['excel_file']);
    	if(!$info){
    		$this->error($upload->getError());
    	}else{
    		$file_puth = './'.$info['savepath'].$info['savename'];
    		//文件上传成功，对文件进行解析
    		// vendor('phpexcel_1.phpexcel');//导入类库
    		require_once VENDOR_PATH.'PHPExcel_1/PHPExcel/IOFactory.php';
    		require_once VENDOR_PATH.'PHPExcel_1/PHPExcel.php';
    		if($info['ext']=='xlsx'){
				require_once VENDOR_PATH.'PHPExcel_1/PHPExcel/Reader/Excel2007.php';
				$objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
			}else{
				require_once VENDOR_PATH.'PHPExcel_1/PHPExcel/Reader/Excel5.php';
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
			// $info=$info.'end';
			$departmentcount=0;
			$dutycount=0;
			foreach ($ExamPaper_arr as $key => $value) 
			{
				//循环数据检测A=>教师姓名B=>手机号码C=>性别D=>任课科目E=>职务F=>科室
				//如果题号或者题干不为空
				if(!empty($value['B'])||!empty($value['C'])){
					$classname=trim($value['B']);
					// $name=$value['D'];
					// $phone=$value['E'];
					// $sex=empty($value['F'])?0:$value['F'];
					for($k='C';$k<=$highestColumn;$k++)
					{
						if(!empty($value[$k])){
							$username=trim($value[$k]);
							if($k=='C'){
								$type=1;
							}else{
								$type=2;
							}
							$info=$info.':'.$username;
							$result=$this->importteaherclass($classname,$username,$schoolid,$type);
						}
						if($result ==1){
							$successcount++;
						}else if($result ==2){
							$updatecount++;
						}else if($result==3){

							$departmentcount++;
						}else if($result==4){
							$dutycount++;
						}else if($result==5){
							$departmentcount++;
							$dutycount++;
						}
						$info=$info.'-['.$result.'-'.$classname.']';
					}
					
					
				}else{
				}
				
			}
    	}
    	$allcount=$highestRow-1;
    	// $info='::其中,已在班级'.$departmentcount.'人,已在亲属'.$dutycount.'人';

		$this->success('导入完成','student/successcount/'.$successcount.'/updatecount/'.$updatecount.'/allcount/'.$allcount.'/info/ok::'.$info);
	}	
	function importteaherclass($classname='',$username='',$schoolid=0,$type=2){
		$result=0;//0.失败，1新增，2更新
		if(empty($username) ||  empty($classname)){
			return -1;
		}else{
			//逐项检测有效数据
			$classid=0;
			$teacherid=0;
			$class_where['schoolid']=$schoolid;
			$class_where['classname']=$classname;
			$class=M('school_class')->where($class_where)->field('id')->find();

			if($class){

				$classid=$class['id'];
				$uwhere['name']=$username;
				$uwhere['schoolid']=$schoolid;
				$teacher=$this->wxtuser_model->where($uwhere)->field('id')->limit(1)->find();
				if($teacher){
					$teacherid=$teacher['id'];
				}else{
					return 10;
				}
				if($teacherid){
						$data=array(
							'schoolid'=>$schoolid,
							'teacherid'=>$teacherid,
							'classid'=>$classid,
							'type'=>$type
						);
						$isexit=M('teacher_class')->where($data)->select();
						if($isexit){
							$result=2;
						}else{
							$relid=M('teacher_class')->add($data);
						$result=1;
						}
						
					}
				}else{
					$result=-2;
				}
			}
		return $result;
	}
	// public function teacher1_post(){
	// 	$schoolid = I('school');

	// 	if(empty($_POST['school'])){
	// 		$this->error("请选择学校");
	// 	}else{


	// 	$upload = new \Think\Upload();// 实例化上传类
 //    	$upload->maxSize   =     3145728 ;// 设置附件上传大小
 //    	$upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
 //    	$upload->rootPath  =      './'; // 设置附件上传根目录
 //    	$upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
 //    	$upload->autoSub   = 	 false;//不自动生成子文件夹
 //    	// 上传单个文件 
 //    	$info   =   $upload->uploadOne($_FILES['excel_file']);
 //    	if(!$info){
 //    		$this->error($upload->getError());
 //    	}else{
 //    		$file_puth = './'.$info['savepath'].$info['savename'];
 //    		//文件上传成功，对文件进行解析
 //    		// vendor('phpexcel_1.phpexcel');//导入类库
 //    		require_once VENDOR_PATH.'PHPExcel_1/PHPExcel/IOFactory.php';
 //    		require_once VENDOR_PATH.'PHPExcel_1/PHPExcel.php';
    	
 //    		// vendor('phpexcel');
 //    		// vendor('phpexcel.IOFactory');//导入类库
	// 		// $phpexcel = new \phpexcel();//实例化，注意加\
	// 		// dump(VENDOR_PATH.'PHPExcel_1/PHPExcel.php');
	// 		// dump(VENDOR_PATH.'PHPExcel_1/PHPExcel/IOFactory.php');
	// 		/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/ 
	// 		// $PHPReader = new \phpexcel(); 
	// 		// dump($PHPReader->__destruct());
	// 		if($info['ext']=='xlsx'){
	// 			require_once VENDOR_PATH.'PHPExcel_1/PHPExcel/Reader/Excel2007.php';
	// 			$objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
	// 		}else{
	// 			require_once VENDOR_PATH.'PHPExcel_1/PHPExcel/Reader/Excel5.php';
	// 			$objReader = \PHPExcel_IOFactory::createReader('Excel5');
	// 		}
	// 		//use excel2007 for 2007 format
	// 		$objPHPExcel = $objReader->load($file_puth);
	// 		$sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始) 
	// 		$highestRow = $sheet->getHighestRow(); // 取得总行数
	// 		$highestColumn = $sheet->getHighestColumn(); // 取得总列数
	// 		//循环读取excel文件,读取一条,插入一条

	// 		for($j=2;$j<=$highestRow;$j++)
	// 		{
	// 			for($k='A';$k<=$highestColumn;$k++)
	// 			{
	// 				//读取单元格
	// 				$ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
	// 			}
	// 		}
	// 		$question_model=M('question');
	// 		$question_relationships_model = M('question_relationships');
	// 		$answer_model = M('answer');
	// 		static $questionid = 0;
	// 		foreach ($ExamPaper_arr as $key => $value) 
	// 		{
	// 			//循环存储题目主干部分+题目与试卷的默认关联
	// 			//如果题号或者题干不为空
	// 			if(!empty($value['A'])||!empty($value['B'])){
	// 				$title_data['q_id'] = empty($value['A'])?0:$value['A'];
	// 				$title_data['post_title'] = empty($value['B'])?0:$value['B'];
	// 				$title_data['post_description'] = empty($value['D'])?0:$value['D'];
	// 				$title_data['post_difficulty'] = empty($value['E'])?0:$value['E'];
	// 				$title_data['post_date'] = time();
	// 				$questionid=$question_model->add($title_data);

	// 				$relationships['object_id']=$questionid;
	// 				$relationships['term_id']=$paperid;
	// 				$relationships['status']=1;
	// 				$question_relationships_model->add($relationships);

	// 				// $answer_id = 1;//清零选项id，开始新问题
	// 				$answer_right = $value['C'];//获取表中正确答案的字符
	// 			}
	// 			//循环存储题目选项部分+选项与题目的关联
	// 			//每排选项只有第一排的题干有内容，所以题干无内容的选项默认和第一排题干一样
	// 			if(!empty($value['G'])){
	// 				//如果选项有内容，则存储题干id+选项内容
	// 				$answer['questionid']=$questionid; 
	// 				$answer['title']=$value['G'];

	// 				//判断该选项是否是正确选项
	// 				if($value['F']==$answer_right){
	// 					$answer['isanswer']=1;
	// 				}else{
	// 					$answer['isanswer']=0;
	// 				}
	// 				$answerid = $answer_model->add($answer);
	// 			}
	// 		}
	// 		// dump($questionid);
	// 		if($questionid){
	// 			$this->success("导入成功！",U('exam/question/index',array('id'=>$paperid)));
	// 		}else{
	// 			$this->error("导入失败！");
	// 		}
	// 		// $strs = explode("-",$str);
	// 		 // dump($questionid);

	// 		// $excel_file = $phpexcel->load();
	// 		// dump($excel_file);
 //    	}
 //    	}


	// 	// $file = $_FILES['excel_file'];
	// 	// if($file['type']=='application/vnd.ms-excel'||$file['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){

	// 	// }else{
	// 	// 	$this->error('文件类型错误！');
	// 	// }
	// }
	
}