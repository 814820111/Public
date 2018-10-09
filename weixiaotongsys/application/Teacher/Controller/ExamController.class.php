<?php

namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
vendor("PHPExcel.PHPExcel");

class ExamController extends TeacherbaseController {
	
	function _initialize() {

		parent::_initialize();
		$this->initMenu();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];
	}

	//成绩管理首页
    public function index(){
        $semesterid = I('semester'); //学期  搜索条件
        if (!empty($semesterid)){
            $where['a.semester'] = $semesterid;
            $this->assign("semesterid", $semesterid);
        }
        $type = I('type'); //类型 搜索条件
        if (!empty($type)){
            $where['a.type'] = $type;
            $this->assign("type", $type);
        }
        $name = I('name'); //类型 搜索条件
        if (!empty($name)){
            $where['a.name'] =  array('like',"%".$name."%");
            $this->assign("name", $name);
        }
        $classid = I('classid'); //类型 搜索条件
        if (!empty($classid)){
            //$where['c.classid'] = array('like',"%".$classid."%");
            $where['c.classid'] = $classid;
            $this->assign("classid", $classid);
        }

        $schoolid = $_SESSION['schoolid'];
        $where["a.schoolid"] = $schoolid;

        $semester = M('semester')->where("schoolid=$schoolid")->field('id,semester')->select();
        $this->assign('semester', $semester);//学期
        //获得班级
//        $class=M('school_class')->where("schoolid=$schoolid")->order("id asc")->select();
//        $this->assign("class",$class);

        $count = M('exam as a')->join("wxt_semester as b on a.semester=b.id")->where($where)
            ->field("a.*,b.semester")->select();

        $count = count($count);
        $page = $this->page($count,20);
        $exam  = M('exam as a')->join("wxt_semester as b on a.semester=b.id")->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("a.*,b.semester")->select();
        $this->assign('Page', $page->show('Admin'));
        $this->assign("exam",$exam);
       	$this->display();
        
    }

    public function subjectinfo(){
        $examid = I("examid");
        $classid = I("classid");
        $subject = M('exam_subject as a')->join("wxt_default_subject as b on a.subjectid=b.id")
            ->field("b.subject")
            ->where("a.examid = $examid and a.classid=$classid")
            ->select();
        //print_r($subject);
        echo  json_encode($subject);
    }

    //成绩管理首页
    public function class_index(){
        $semesterid = I('semester'); //学期  搜索条件
        if (!empty($semesterid)){
            $where['b.semester'] = $semesterid;
            $this->assign("semesterid", $semesterid);
        }
        $type = I('type'); //类型 搜索条件
        if (!empty($type)){
            $where['b.type'] = $type;
            $this->assign("type", $type);
        }

        $classid = I('classid'); //类型 搜索条件
        if (!empty($classid)){
            //$where['c.classid'] = array('like',"%".$classid."%");
            $where['a.classid'] = $classid;
            $this->assign("classid", $classid);
        }
        $name = I('name'); //类型 搜索条件
        if (!empty($name)){
            $where['b.name'] =  array('like',"%".$name."%");
            $this->assign("name", $name);
        }
        $schoolid = $_SESSION['schoolid'];
        $where["b.schoolid"] = $schoolid;

        $semester = M('semester')->where("schoolid=$schoolid")->field('id,semester')->select();
        $this->assign('semester', $semester);//学期
        if($this->level!=1  && $this->level!=2)
        {

            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $this->userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';
            $where_class['teacher.schoolid'] = $schoolid;
            $where_class['teacher.teacherid'] = $this->userid;
            $join_dutys = 'wxt_teacher_class teacher ON d.id=teacher.classid';


        }

          $where_class['c.schoolid'] = $schoolid;

        //获得班级
        $class=M('school_class')->alias("c")->where($where_class)->join($join_duty)->order("c.id asc")->field("c.*")->select();
        $this->assign("class",$class);

        $count = M('exam_class as a')
            ->join("wxt_exam as b on a.examid=b.Id")
            ->join("wxt_semester as c on b.semester=c.id")
            ->join("wxt_school_class as d  on d.id=a.classid")
            ->join($join_dutys)
            ->field("b.name,b.type,b.date,a.*,c.semester,d.classname")
            ->where($where)
            ->select();
        $count = count($count);
        $page = $this->page($count,20);
        $exam =  M('exam_class as a')
           ->join("wxt_exam as b on a.examid=b.Id")
           ->join("wxt_semester as c on b.semester=c.id")
           ->join("wxt_school_class as d  on d.id=a.classid")
           ->join($join_dutys)
            ->limit($page->firstRow . ',' . $page->listRows)
           ->field("b.name,b.type,b.date,a.*,c.semester,d.classname")
           ->where($where)->order("a.examid asc")
           ->select();
//        dump($exam);
        $this->assign('Page', $page->show('Admin'));
        $this->assign("exam",$exam);
        $this->display();

    }
    //添加考试
    public function add()
    {
        $schoolid = $_SESSION['schoolid'];
        //获得学期
        $semester = M('semester')->where("schoolid=$schoolid")->field('id,semester')->select();
        $this->assign('semester', $semester);//学期
        if($this->level!=1  && $this->level!=2)
        {

            $where_class['teacher.schoolid'] = $schoolid;
            $where_class['teacher.teacherid'] = $this->userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';



        }

        $where_class['c.schoolid'] = $schoolid;
        //获得班级
        $class=M('school_class')->alias("c")->join($join_duty)->where($where_class)->order("c.id asc")->field("c.*")->select();

//        dump($class);
        $this->assign("class",$class);

        //获得科目
        $subject = M("subject as a")->
        join("wxt_default_subject as b on a.subjectid = b.id")->
        where("a.schoolid = $schoolid")->
        field('b.id,b.subject')->
        select();
        //dump($subject);
        $this->assign("subject",$subject);
        $this->display();
    }

    //添加提交
    /**
     *
     */
    public function add_post()
    {
        $data["schoolid"]= $_SESSION['schoolid'];
        if(I("date")){
            $data["date"] = I("date");
        }else{
            $this->error("请输入考试时间");
        }

        if(I("semester")){
            $data["semester"] = I("semester");
        }else{
            $this->error("请选择学期");
        }

        if(I("type")){
            $data["type"] = I("type");
        }else{
            $this->error("请选择考试类型");
        }
        if(I("name")){
            $data["name"] = I("name");
        }else{
            $this->error("请输入考试名称");
        }
//        if(I("subject")){
//            $data["subject"] = implode(",",I("subject")).",";
//        }else{
//            $this->error("请选择科目");
//        }
//        if(I("class")){
//            $data["classid"] = implode(",",I("class")).",";
//        }else{
//            $this->error("请选择班级");
     //   }
        $subject = I("subject");
        if(empty($subject)){
            $this->error("请选择科目");
        }
        $class = I("class");
        if(empty($class)){
            $this->error("请选择班级");
        }


        $result=M("exam")->add($data);
        if($result){
            $newsubject = array();
            foreach ($subject as $v){
                foreach ($class as $value){
                    $newsubject[]=array("subjectid"=>$v,"examid"=>$result,"classid"=>$value);
                }

            }
            $res=M("exam_subject")->addAll($newsubject);

            $newclass = array();
            foreach ($class as $v){
                $newclass[]=array("classid"=>$v,"examid"=>$result);
            }
            $arr=M("exam_class")->addAll($newclass);
            $this->success("添加成功",U("index"));
        }else{
            $this->error("添加失败");
        }

    }


    /**
     *  删除
     */
    public function delete(){
        $id = I("get.id",0,"intval");
        //$classid = I("classid");
        $result = M('exam')->where("id=$id")->delete();
        if ($result) {
            M('exam_class')->where("examid=$id")->delete();
            M('exam_subject')->where("examid=$id")->delete();
            M('exam_comment')->where("examid=$id")->delete();
            M('exam_score')->where("examid=$id")->delete();
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    /**
     *  删除
     */
    public function class_delete(){
        $id = I("get.id",0,"intval");
        $examid = I("examid");
        $classid = I("classid");
        //$classid = I("classid");
        $result = M('exam_class')->where("id=$id and classid = $classid and examid= $examid")->delete();
        if ($result) {
            M('exam_subject')->where("examid= $examid and classid = $classid")->delete();
            M('exam_score')->where("examid= $examid and classid = $classid")->delete();
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    //修改页面
    public function edit(){
        $schoolid = $_SESSION['schoolid'];//学校ID
        $id=I("id");//考试ID

        $query = M("exam_score")->where("examid=$id")->select();
        if(count($query)){
            $this->error("成绩已录入,不能进行修改!");
        }
        //获得学期
        $semester = M('semester')->where("schoolid=$schoolid")->field('id,semester')->select();
        $this->assign('semester', $semester);//学期
        //获得班级
        $class=M('school_class')->where("schoolid=$schoolid")->order("id asc")->select();
        $this->assign("class",$class);

        //获得科目
        $subject = M("subject as a")->
        join("wxt_default_subject as b on a.subjectid = b.id")->
        where("a.schoolid = $schoolid")->
        field('b.id,b.subject')->
        select();
        $this->assign("subject",$subject);



        $exam = M('exam')->where("id=$id")->find();//查找考试详情
        $this->assign("exam",$exam);

        $classinfo=M('exam_class')->where("examid=$id")->field("classid")->select();//已选班级
        $newclass = array();
        foreach ($classinfo as $value){
            $newclass[] = $value["classid"];
        }
        $newclass = implode(",",$newclass).",";
        $this->assign("newclass",$newclass);

        $subjectinfo=M('exam_subject')->where("examid=$id")->field("subjectid")->select();//已选科目
        $newsubject = array();
        foreach ($subjectinfo as $value){
            $newsubject[] = $value["subjectid"];
        }
        $newsubject = implode(",",$newsubject).",";
        $this->assign("newsubject",$newsubject);

        $this->display();
    }

    //修改提交
    public function  edit_post(){
        $id=I("id");//考试ID
        if(I("date")){
            $data["date"] = I("date");
        }else{
            $this->error("请输入考试时间");
        }

        if(I("semester")){
            $data["semester"] = I("semester");
        }else{
            $this->error("请选择学期");
        }

        if(I("type")){
            $data["type"] = I("type");
        }else{
            $this->error("请选择考试类型");
        }
        if(I("name")){
            $data["name"] = I("name");
        }else{
            $this->error("请输入考试名称");
        }
//        if(I("subject")){
//            $data["subject"] = implode(",",I("subject")).",";
//        }else{
//            $this->error("请选择科目");
//        }
//        if(I("class")){
//            $data["classid"] = implode(",",I("class")).",";
//        }else{
//            $this->error("请选择班级");
//        }
        $subject = I("subject");
        if(empty($subject)){
            $this->error("请选择科目");
        }
        $class = I("class");
        if(empty($class)){
            $this->error("请选择班级");
        }

        $result=M("exam")->where("Id=$id")->save($data);
        if($result){
            M("exam_subject")->where("examid=$id")->delete(); //先删除 在添加
            $newsubject = array();
            foreach ($subject as $v){
                foreach ($class as $value){
                    $newsubject[]=array("subjectid"=>$v,"examid"=>$id,"classid"=>$value);
                }

            }
            $res=M("exam_subject")->addAll($newsubject);

            M("exam_class")->where("examid=$id")->delete();//先删除 在添加
            $newclass = array();
            foreach ($class as $v){
                $newclass[]=array("classid"=>$v,"examid"=>$id);
            }
            $arr=M("exam_class")->addAll($newclass);

            $this->success("修改成功",U("index"));
        }else{
            $this->error("修改失败");
        }
    }

    //拉取班级考试数据
    public function class_exam(){
        $calssid = I("classid");
        //echo  $calssid;
        $class=M('exam_class as a')->
        join("wxt_exam as b on a.examid=b.id")->
        where("a.classid = $calssid")->select();
        echo  json_encode($class);
    }
    public function ScoreSend()
    {
        $schoolid = $_SESSION['schoolid'];//学校ID
        if($this->level!=1  && $this->level!=2)
        {

            $where_class['teacher.schoolid'] = $schoolid;
            $where_class['teacher.teacherid'] = $this->userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';



        }
        $where_class['c.schoolid'] = $schoolid;
        //获得班级列表
        $class=M('school_class')->alias("c")->join($join_duty)->where($where_class)->order("c.id asc")->field("c.*")->select();
        $this->assign("class",$class);
        //获得考试列表
        $exam = M("exam")->where("schoolid=$schoolid")->select();
        $this->assign("exam",$exam);

        $this->display("scoreadd");
    }

    public function expUser()
    {
        header("Content-type: text/html; charset=utf-8");
       $classid =I("classid");
       //$classid =3;
       $examid = I("examid");
       //$examid = 2;
       $subject = M("exam_subject as a")->join("wxt_default_subject as b on a.subjectid = b.id")
           ->where("a.classid = $classid and a.examid = $examid")->field("subject")->select();
       //dump($subject);
       $arr = array();
        foreach ($subject as $k=>$value){
            $arr[]= array($k,$value["subject"]);
        }
       $array = array( array('name','姓名'));
        $xlsCell = array_merge($array,$arr);
       //dump($newarray);
       //die();
//        $student = M("class_relationship as a")->join("wxt_wxtuser as b on a.userid = b.id")
//            ->where("a.classid = $classid ")->field("b.name")->select();
        $student = M("class_relationship as a")->join("wxt_student_info as b on a.userid = b.userid")
            ->where("a.classid = $classid ")->field("b.stu_name as name")->select();
//        dump( $student);
//        die();
       $xlsName  = "User";

//        );
        //接收保存在SESSION的值
        $xlsData = $student; //学生姓名

        $fileNames =  '学生成绩录入'.date('_YmdHis');


//        dump($student);
//        die();

        $result =     $this->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);






    }
    //导出方法
    public function exportExcel($expTitle,$expCellName,$expTableData,$fileNames){

        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $fileNames;//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);


        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();

        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格

        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);//单元格宽度
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');//设置字体
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);//设置字体大小
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), ' '.$expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        exit;

    }

    //成绩录入提交
    public function score_post(){
        $schoolid = $_SESSION['schoolid'];//学校ID
        $classid = I("class");//班级ID
        $examid = I("exam");//考试ID
        //echo $classid;
        //echo $examid;
        if(empty($classid)){
            $this->error("请选择班级");
        }
        if(empty($examid)){
            $this->error("请选择考试");
        }
        if(empty($_POST["content"])){
            $this->error("请按照流程复制模板,填写成绩");
        }
        $query = M("exam_score")->where("classid=$classid and examid=$examid")->select();
        if(count($query)){
            $this->error("该次考试已经录入过成绩");
        }
        $arr=explode("<br/>",$_POST["content"]); //换行处理数组
        $menu []= explode(" ",$arr[0]);  //第一行菜单 姓名 科目
        $result = array();
        foreach ($arr as $key=>$value){
            if(trim($arr[$key+1])){
                $result[]= explode(" ",trim($arr[$key+1]));
            }
        }
        $res = array_merge($menu,$result);  //处理成新的数组
        //dump($res);

        for ($i=1; $i<=count($res[0])-1; $i++)
        {
            $subject = $res[0][$i];

                $subjectid = M("default_subject")->where(array("subject"=>$subject))->find();
                if($subjectid){
                    $res[0][$i] =$subjectid["id"];
                }else{
                    $this->error("科目填写错误");
                }

        }
        //dump($res);
        $data = array();
        for ($i=1; $i<=count($res)-1; $i++)
        {
            for ($j=1; $j<=count($res[$i])-1; $j++){
            $name = $res[$i][0];
//            $user = M("wxtuser")->where(array("name"=>$name,"schoolid"=>$schoolid))->field("name,id")->find();
            $user = M("student_info as a")->where(array("a.stu_name"=>$name,"a.schoollid"=>$schoolid))->field("a.stu_name as name,a.userid as id")->find();
            $data[] = array(
                //"name"=>$user["name"],
                "studentid"=>$user["id"],
                "subjectid"=>$res[0][$j],
                "score"=>$res[$i][$j],
                "classid"=>$classid,
                "examid"=>$examid,
                "time"=>time()
            );
           }
        }
      //dump($data);
       // die();
      $result = M('exam_score')->addAll($data);
      if($result)  {
          //$this->success("录入成功");
          //echo "!11";
          //echo $examid;
          //echo $classid;
          //die();
          $this->comment($examid,$classid);
      }else{
          $this->error("录入失败");
      }

        //dump($res);
        //dump($data);

    }
    //$examid  考试ID
    //$classid 班级ID
    //第二部添加评论语,然后发送
    public function  comment($examid,$classid){
        //header("Content-type: text/html; charset=utf-8");
        //$examid = 2;
        //$classid = 3;
        //$result = M("class_relationship")->where("classid = $classid")->field("userid")->select();
        $result =   M("exam_score")->where("examid= $examid and classid = $classid")->group("studentid")->field("studentid")->select();
        //dump($result);
        $data = array();
        $id = 0;
        foreach($result as $k=>$value){
            $id++;
            $content="";
            $contents="";
            //$studentid = $value["userid"];//学生ID;
            $studentid = $value["studentid"];//学生ID;
//            $user = M("wxtuser")->where("id = $studentid")->field("name")->find();
            $user = M("student_info")->where("userid = $studentid")->field("stu_name as name")->find();
            $studentname = $user["name"];
            $res = M("exam_score")->where("studentid=$studentid and  examid= $examid and classid = $classid")->select();
            foreach($res as $key=>$v){
                $subjectid = $v["subjectid"];//科目ID
                $score = $v["score"];//分数
                $subject = M("default_subject")->where(array("id"=>$subjectid))->find();
                $subjectname =  $subject["subject"];//科目名称
                $content.=$subjectname.$score." ";
            }
            $contents.=$studentname."的成绩: ".$content;
            $data[] = array("id"=>$id,"studentname"=>$studentname,"content"=>$contents,"examid"=>$examid,"studentid"=>$studentid,"classid"=>$classid);
        }
       // dump($data);
        $this->assign("data",$data);
        $this->assign("examid",$examid);
        $this->assign("classid",$classid);
        $this->display("comment");
    }

    //评论提交
    public function comment_post(){
        $type = I("type");
        $examid = I("examid");//考试ID
        $classid = I("classid");//班级ID
        $ct = I("comment");//点评内容
        $student = I("studentid");
        if($type==1){
            $data = array();
            foreach ($student as $v){
                $data[] = array("studentid"=>$v,"content"=>$ct,"examid"=>$examid,"classid"=>$classid,"time"=>time());
            }

            $result = M('exam_comment')->addAll($data);
            if($result)  {
                $this->success("保存成功",U("ScoreSend"));
            }else{
                $this->error("保存失败");
            }
        }else{
            $data = array();
            foreach ($student as $v){
                $data[] = array("studentid"=>$v,"content"=>$ct,"examid"=>$examid,"classid"=>$classid,"time"=>time());
            }

            $result = M('exam_comment')->addAll($data);//添加评论

            $schoolid = $_SESSION['schoolid'];//学校ID
            $manage=M('wxmanage')->where("schoolid=$schoolid")->field("wx_appid,wx_appsecret")->find();
            $appid =  $manage["wx_appid"];

            $appsecret =  $manage["wx_appsecret"];
            //获得班级
            $class=M('school_class')->where("id=$classid")->find();
            $classname = $class["classname"];//班级名称
            $teacherid = $_SESSION["USER_ID"]; //老师ID
//            $user=M('wxtuser')->where("id=$teacherid")->field("name")->find();
            $user=M('teacher_info')->where("teacherid=$teacherid and schoolid = $schoolid")->field("name")->find();
            $teachername = $user["name"];

            $student = $_POST["studentid"];
            $content = $_POST["content"];
            $comment = I("comment");  //追加的内容
            foreach ($student as  $k=>$value){
                $studentid = $value;//学生ID
                $contents = $content[$k];

                if($comment){
                    $contents=$contents.$comment;
                }

                $url = "http://mp.zhixiaoyuan.net/index.php/Apps/SendTpl/scoreNotice?studentid=".$studentid."&examid=".$examid."&classid=".$classid."&schoolid=".$schoolid."&APPID=".$appid."&APPSECRET=".$appsecret ."&classname=".$classname."&teachername=".$teachername."&content=".$contents;
                //echo $url;
                //echo "<br>";
                // $array = $this->http_request($url);
                $array = file_get_contents($url);

            }
            //die();
            if($array["errcode"] == 0){
                $this->success("发送成功！",U("index"));
            }else{
                $this->error("发送失败！");
            }

        }

    }

    //个人成绩查询
    public function myindex(){

        $classid = I('classid'); //类型 搜索条件
        if (!empty($classid)){
            $where['a.classid'] = $classid;
            $this->assign("classid", $classid);
        }
        $examid = I("examid");
        if (!empty($examid)){
            $where['a.examid'] = $examid;
            $this->assign("examid", $examid);
        }
        $name = I('name'); //类型 搜索条件
        if (!empty($name)){
            $where['e.name'] =  array('like',"%".$name."%");
            $this->assign("name", $name);
        }
        $schoolid = $_SESSION['schoolid'];
        $where["b.schoolid"] = $schoolid;

        //获得考试
        $examlist=M('exam')->where("schoolid=$schoolid")->order("id asc")->select();
        $this->assign("examlist",$examlist);
        if($this->level!=1  && $this->level!=2)
        {

            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $this->userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';
            $where_class['teacher.schoolid'] = $schoolid;
            $where_class['teacher.teacherid'] = $this->userid;
            $join_dutys = 'wxt_teacher_class teacher ON d.id=teacher.classid';


        }

        $where_class['c.schoolid'] = $schoolid;
        //获得班级
        $class=M('school_class')->alias("c")->where($where_class)->join($join_duty)->order("c.id asc")->field("c.*")->select();
        $this->assign("class",$class);

    $count = M('exam_score as a')
        ->join("wxt_exam as b on a.examid=b.id")
        ->join("wxt_school_class as d  on d.id=a.classid")
//        ->join("wxt_wxtuser as e on a.studentid=e.id")
        ->join("wxt_student_info as e on a.studentid=e.userid")
        ->join("wxt_default_subject as c on a.subjectid = c.id")
        ->join($join_dutys)
        ->where($where)
//        ->field("a.*,b.name,b.type,d.classname,e.name as username,c.subject")
        ->field("a.*,b.name,b.type,d.classname,e.stu_name as username,c.subject")
        ->select();
        $count = count($count);
        $page = $this->page($count,20);
        $exam = M('exam_score as a')
            ->join("wxt_exam as b on a.examid=b.id")
            ->join("wxt_school_class as d  on d.id=a.classid")
//            ->join("wxt_wxtuser as e on a.studentid=e.id")
            ->join("wxt_student_info as e on a.studentid=e.userid")
            ->join("wxt_default_subject as c on a.subjectid = c.id")
            ->join($join_dutys)
            ->where($where)
             ->limit($page->firstRow . ',' . $page->listRows)
//            ->field("a.*,b.name,b.type,d.classname,e.name as username,c.subject")
            ->field("a.*,b.name,b.type,d.classname,e.stu_name as username,c.subject")
            ->select();
        $this->assign('Page', $page->show('Admin'));
        $this->assign("exam",$exam);
        $this->display("myindex");
    }


    /**
     *  个人成绩删除
     */
    public function mydelete(){
        $id = I("get.id",0,"intval");
        $classid = I("classid");
        $examid = I("examid");
        $result = M('exam_score')->where("id=$id and classid=$classid and examid=$examid")->delete();
        if ($result) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    public function commentinfo(){
        $examid = I("examid");
        $classid = I("classid");
        $studentid = I("studentid");
        $subject = M('exam_comment')
            ->where("examid = $examid and classid=$classid and studentid=$studentid")
            ->find();
        //print_r($subject);
        echo  json_encode($subject);
    }

    //个人成绩 编辑成绩
    public function score_edit(){
        $score = I("score");
        $id = I("id");
        $data["score"] =  $score;
        $result=M("exam_score")->where("id=$id")->save($data);
        $examid = I("examid"); //考试ID
        $classid = I("classid");//班级ID
        $studentid = I("studentid");//学生ID
        $content = I("content");//学生内容
//        echo  $examid;
//        echo $classid;
//        echo  $studentid;
//        echo $content;
        if($content){
            $arr["content"] = $content;
            $query = M("exam_comment")->where("examid=$examid and classid=$classid and studentid=$studentid")->find();
            if(count($query)){
                $result=M("exam_comment")->where("examid=$examid and classid=$classid and studentid=$studentid")->save($arr);
            }else{
                $arr["examid"]=$examid;
                $arr["classid"]=$classid;
                $arr["studentid"]=$studentid;
                $arr["time"]=time();
                $result=M("exam_comment")->add($arr);
            }

        }
//
        echo  json_encode($result);
    }

    //班级管理 成绩详情
    public function score_details(){
        $examid = I("examid"); //考试ID
        $classid = I("classid");//班级ID

        $subject = M('exam_subject as a')->join("wxt_default_subject as b on a.subjectid=b.id")
            ->where("a.examid = $examid and a.classid=$classid")
            ->field("b.subject,a.subjectid")
            ->select();
        //echo  json_encode($subject);
        $data = array();
        $id = 0;

         $result =   M("exam_score")->where("examid= $examid and classid = $classid")->group("studentid")->field("studentid")->select();
        //dump($result);
        //die();

        foreach ($result as  $k=>$value){
            $id++;
            $studentid = $value["studentid"];//学生ID;
//            $user = M("wxtuser")->where("id = $studentid")->field("name")->find();
            $user = M("student_info")->where("userid = $studentid")->field("stu_name as name")->find();
            $studentname = $user["name"];
            //$data[] = array($studentid,$id,$studentname);
            $data[] = array($id,$studentname);
            foreach($subject as $j=> $v){
                $subjectid = $v["subjectid"];//科目ID
                $res = M("exam_score")->where("studentid=$studentid and  examid= $examid and classid = $classid and subjectid=$subjectid")->find();
                $score = $res["score"];
                //$value['aaa'] = $score;
                //dump($score);
                array_push($data[$k],$score);
            }
            $result = M("exam_comment")->where("studentid=$studentid and  examid= $examid and classid = $classid")->find();
            $res = $result["content"];
            if(empty($res)){
                $res=" ";
            }
            array_push($data[$k],$res);
        }

     $ret =  $this->format_ret($subject,$data);
        //$data["subject"]=$subject;
       // dump($data);
       echo   json_encode($ret);
   }
    function format_ret($status, $data = '')
    {
        if ($status) {
            //成功
            return array('status' => $status, 'data' => $data);
        } else {
            //验证失败
            return array('status' => 'error', 'data' => $data);
        }
    }

//    //班级成绩管理 编辑成绩
//    public  function score_update(){
//        $name = I("name");//考试名称
//        $this->assign("name",$name);
//        $classname = I("classname");//考试对象
//        $this->assign("classname",$classname);
//        $date = I("date");//考试时间
//        $this->assign("date",$date);
//
//
//        $examid = I("examid"); //考试ID
//        $classid = I("classid");//班级ID
//
//        $subject = M('exam_subject as a')->join("wxt_default_subject as b on a.subjectid=b.id")
//            ->where("a.examid = $examid and a.classid=$classid")
//            ->field("b.subject,a.subjectid")
//            ->select();
//        //echo  json_encode($subject);
//        $data = array();
//        $id = 0;
//
//        $result =   M("exam_score")->where("examid= $examid and classid = $classid")->group("studentid")->field("studentid")->select();
//        //dump($result);
//        //die();
//
//        foreach ($result as  $k=>$value){
//            $id++;
//            $studentid = $value["studentid"];//学生ID;
//            $user = M("wxtuser")->where("id = $studentid")->field("name")->find();
//            $studentname = $user["name"];
//            //$data[] = array($studentid,$id,$studentname);
//            $data[] = array($id,$studentname);
//            foreach($subject as $j=> $v){
//                $subjectid = $v["subjectid"];//科目ID
//                $res = M("exam_score")->where("studentid=$studentid and  examid= $examid and classid = $classid and subjectid=$subjectid")->find();
//                $score = $res["score"];
//                //$value['aaa'] = $score;
//                //dump($score);
//                array_push($data[$k],$score);
//            }
//            $result = M("exam_comment")->where("studentid=$studentid and  examid= $examid and classid = $classid")->find();
//            $res = $result["content"];
//            if(empty($res)){
//                $res=" ";
//            }
//            array_push($data[$k],$res);
//        }
//
//        //$ret =  $this->format_ret($subject,$data);
//       // dump($ret);
//        $this->assign("subject",$subject);
//        dump($subject);
//        $this->assign("data",$data);
//        dump($data);
//        $this->display("score_edit");
//    }


    public function  class_comment($examid,$classid){
        //header("Content-type: text/html; charset=utf-8");
        //$examid = 2;
        //$classid = 3;
        $result =   M("exam_score")->where("examid= $examid and classid = $classid")->group("studentid")->field("studentid")->select();
        //$result = M("class_relationship")->where("classid = $classid")->field("userid")->select();
        //dump($result);
        $data = array();
        $id = 0;
        foreach($result as $k=>$value){
            $id++;
            $content="";
            $contents="";
//            $studentid = $value["userid"];//学生ID;
            $studentid = $value["studentid"];//学生ID;
//            $user = M("wxtuser")->where("id = $studentid")->field("name")->find();
            $user = M("student_info")->where("userid = $studentid")->field("stu_name as name")->find();
            $studentname = $user["name"];
            $res = M("exam_score")->where("studentid=$studentid and  examid= $examid and classid = $classid")->select();
            foreach($res as $key=>$v){
                $subjectid = $v["subjectid"];//科目ID
                $score = $v["score"];//分数
                $subject = M("default_subject")->where(array("id"=>$subjectid))->find();
                $subjectname =  $subject["subject"];//科目名称
                $content.=$subjectname.$score." ";
            }
            $contents.=$studentname."的成绩: ".$content;
//            if($content){
                $data[] = array("id"=>$id,"studentname"=>$studentname,"content"=>$contents,"examid"=>$examid,"studentid"=>$studentid,"classid"=>$classid);
//            }

        }
        // dump($data);
        $this->assign("data",$data);
        $this->assign("examid",$examid);
        $this->assign("classid",$classid);
        $this->display("class_comment");
    }

    public function class_comment_post(){
//        dump($_POST);
       // die();
        $examid = I("examid");//考试ID
        $classid = I("classid");//班级ID
        $schoolid = $_SESSION['schoolid'];//学校ID
        $manage=M('wxmanage')->where("schoolid=$schoolid")->field("wx_appid,wx_appsecret")->find();
        $appid =  $manage["wx_appid"];

        $appsecret =  $manage["wx_appsecret"];
        //获得班级
        $class=M('school_class')->where("id=$classid")->find();
        $classname = $class["classname"];//班级名称
        $teacherid = $_SESSION["USER_ID"]; //老师ID
        //$user=M('wxtuser')->where("id=$teacherid")->field("name")->find();
        $user=M('teacher_info')->where("teacherid=$teacherid and schoolid = $schoolid")->field("name")->find();
        $teachername = $user["name"];

        $student = $_POST["studentid"];
        $content = $_POST["content"];
        $comment = I("comment");  //追加的内容
        foreach ($student as  $k=>$value){
                $studentid = $value;//学生ID
                $contents = $content[$k];

                if($comment){
                    $contents=$contents.$comment;
                }

             $url = "http://mp.zhixiaoyuan.net/index.php/Apps/SendTpl/scoreNotice?studentid=".$studentid."&examid=".$examid."&classid=".$classid."&schoolid=".$schoolid."&APPID=".$appid."&APPSECRET=".$appsecret ."&classname=".$classname."&teachername=".$teachername."&content=".$contents;
            //echo $url;
            //echo "<br>";
            // $array = $this->http_request($url);
             $array = file_get_contents($url);

        }
        //die();
        if($array["errcode"] == 0){
             $this->success("发送成功!",U("index"));
        }else{
             $this->error("发送失败！");
        }

    }

//    public  function test(){
//        $url = "http://mp.zhixiaoyuan.net/index.php/Apps/SendTpl/scoreNotice?studentid=2430&examid=8&classid=39&schoolid=7&APPID=wx7325155f62456567&APPSECRET=c379e9768f9faa8865a1db767fc81155&classname=小三班&teachername=徐民峰&content=徐明明的成绩: 体育99 语文66 6566";
//        $arr = file_get_contents($url);
//        dump($arr);
//    }
    function http_request($url, $data = array())
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
}

