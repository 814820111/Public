<?php

/**
 * 教职工信息
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class GrowthArchivesController extends TeacherbaseController {

	public function index(){
		$schoolid=$_SESSION['schoolid'];
       //获得档案信息
        $semester = M('semester')->where("schoolid=$schoolid")->field('semester')->select();
        //print_r($semester);
        $this->assign('semester',$semester);//学期

        //搜索条件
        $school_name = I("schoolname");//学校名称
        $filename = I("filename");//档案名称
        $semester = I("semester");//学期
        if($school_name){
            $this->assign("school_name",$school_name);
            $where['b.school_name'] = array("LIKE","%".$school_name."%");
         }
        if($filename){
            $this->assign("filename",$filename);
            $where['a.name'] = array("LIKE","%".$filename."%");
        }
        if($semester){
            $this->assign("semester",$semester);
            $where['c.semester'] = array("LIKE","%".$semester."%");
        }
        $where['a.schoolid']=$schoolid;
        $count=M('archives as a')->
        join('wxt_school as b on b.schoolid=a.schoolid')->
        join('wxt_semester as c on a.semesterid=c.id')->
        where($where)->
        field('b.school_name,a.*,c.semester')->
        order("a.id asc")->count();
		$page = $this->page($count, 3);

        $archives=M('archives as a')->
        join('wxt_school as b on b.schoolid=a.schoolid')->
        join('wxt_semester as c on a.semesterid=c.id')->
        where($where)->
        field('b.school_name,a.*,c.semester')->
        limit($page->firstRow . ',' . $page->listRows) ->
        order("a.id asc")->select();

		$this->assign("Page", $page->show('Admin'));
        $this->assign('schoolid',$schoolid);//学校ID
		$this->assign("archives",$archives);
		$this->display();
	}
	//家长的点击查询
	public function chaxuan(){
		$userid=I("userid");
		if($userid){
		$ICcard=M("student_card")->where("personId=$userid and cardType=2")->field("cardno,personId")->select();	
		echo json_encode(array('data'=>$ICcard,'message'=>'数据请求成功'));	
		}else{
		echo json_encode(array('data'=>'-1','message'=>'数据请求失败'));		
		}	
	}

	//添加页面
	public function add(){

		$schoolid = $_SESSION['schoolid'];
        //获取学校名称
        $school = M('school')->where("schoolid=$schoolid")->field('school_name')->find();
        //获得该校关联学期
        $semester = M('semester')->where("schoolid=$schoolid")->field('id,semester')->select();
        $this->assign('semester',$semester);//学期
        $this->assign('schoolid',$schoolid);//学校ID
        $this->assign('schoolname',$school['school_name']);//学校名字
	    $this->display();
    }
    //添加处理
	public function add_post(){
        //微校通用户信息表添加
        $schoolid = I("schoolid");  //学校ID
        $filename = I("filename");  //档案名称
        $semester=I("semester");//学期ID
        $starttime=I("starttime");//开始时间
        $endtime= I('endtime');//结束时间

        if($filename==""){
            $this->error("请填写档案名称!");
            return;
        }else{
            $data['name']=$filename;
        }

        if($semester==""){
        	   $this->error("请选择学期!");
        	   return;
        }else{
            $data['semesterid']=$semester;
        }
        if($starttime==""){
        	$this->error("请选择学期开始时间！");
            return;
        }else{
            $data['semester_start']=$starttime;
        }
        if($endtime==""){
        	$this->error("请选择学期结束时间！");
            return;
        }else{
            $data['semester_end']=$endtime;
        }
        $data['schoolid']= $schoolid ;
        $data['create_time']= time() ;
        //向表中插入数据
       $result=M("archives")->data($data)->add();
       if($result){
           $this->success("数据添加成功");

       }else{
           $this->error('数据添加失败');
       }
       
    }
    //修改页面
    public function change(){
        $schoolid=$_SESSION['schoolid'];
        $id =intval(I('id'));

        $archives = M('archives')->where("id=$id")->find();
        //print_r($archives);
        $semester = M('semester')->where("schoolid=$schoolid")->field('id,semester')->select();
        //print_r($semester);
        $this->assign('semester',$semester);//学期
        $this->assign("archives",$archives);
        $this->display();
    }

    //提交修还
    public function update(){
        $id =intval(I('id'));//ID
        $semester=I("semester");//学期ID
        $starttime=I("starttime");//开始时间
        $endtime= I('endtime');//结束时间
        $filename= I('filename');//档案名称
        if($filename==""){
            $this->error("请填写档案名称!");
            return;
        }else{
            $data['name']=$filename;
        }

        if($semester==""){
            $this->error("请选择学期!");
            return;
        }else{
            $data['semesterid']=$semester;
        }
        if($starttime==""){
            $this->error("请选择学期开始时间！");
            return;
        }else{
            $data['semester_start']=$starttime;
        }
        if($endtime==""){
            $this->error("请选择学期结束时间！");
            return;
        }else{
            $data['semester_end']=$endtime;
        }
        $result = M('archives')->where("id=$id")->save($data);
        if($result){
            $this->success("数据修改成功");

        }else{
            $this->success('数据修改失败');
        }
    }

    //删除
    public function delete(){
        $id =intval(I('id'));
        if($id){

            $rst = M('archives')->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }else{
            $this->error("未获取到数据");
        }
    }

    //获取班级名称
    public function classList(){
        if(I('archivesid')) {
            $archivesid = intval(I('archivesid'));
        }
        if(I('schoolid')){
            $schoolid =intval(I('schoolid'));
        }else{
            $schoolid=$_SESSION['schoolid'];
        }
        $query = M('school_class as a')->join('wxt_archives_class as b on b.classid=a.id')->where("b.archives_id= $archivesid")->field('a.id,a.classname')->select();
        $classlist = array();
        if($query){
            $classlist['selected'] = $query;//已选班级
        }

        if($archivesid){
            $num = M('archives_class')->where("archives_id= $archivesid")->field('classid')->count();
            if($num>0){
                //查询学校的班级
                $sql = "select id,classname from wxt_school_class where (id not in(select classid from wxt_archives_class where  archives_id='$archivesid')) and schoolid='$schoolid'";
                $model = M();
                $result = $model->query($sql);
            }else{
                $result = M('school_class')->where("schoolid= $schoolid")->field('id,classname')->select();
            }
        }
        if($result){
            $classlist['notselected'] = $result;//未选班级
        }
        if(count($classlist)){
            echo json_encode(array('data'=>$classlist,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>'0','message'=>'数据请求失败'));
        }
    }
    //启动班级
    public function archives_class(){
        if(I('archivesid')){
            $archivesid = I('archivesid');
        }
        //$class=array_filter(explode(",",I('classid')));
        if(I('classid')){
            $class=array_filter(explode(",",I('classid')));
            foreach($class as $k=>$value){
                $classid =  $value;
                $data['classid']= $classid ;
                $data['archives_id']= $archivesid ;
                $data['create_time']= time() ;
                //向表中插入数据
                $result=M("archives_class")->data($data)->add();
            }
        }
        if($result){
            echo json_encode(array('data'=>$result,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>'0','message'=>'数据请求失败'));
        }
    }

    //获取模板列表
    public function template(){
        if(I('id')){
            $archivesid = I('id');
        }
        $query = M('template as a')->join('wxt_template_relation as b on b.templateid=a.id')->where("b.archives_id=$archivesid")->field('a.id,a.name')->select();

        $templatelist = array();
        if($query){
            $templatelist['selected'] = $query;//已选班级
        }
        if($archivesid){
            $num = M('template_relation')->where("archives_id= $archivesid")->field('id')->count();
            if($num>0){
                //查询学校的班级
                $sql = "select id,name from wxt_template where id not in(select templateid from wxt_template_relation where  archives_id='$archivesid')";
                $model = M();
                $result = $model->query($sql);
            }else{
                $result = M('template')->field('id,name')->select();
            }
        }
        if($result){
            $templatelist['notselected'] = $result;//未选班级
        }

        if(count($templatelist)){
            echo json_encode(array('data'=>$templatelist,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>'0','message'=>'数据请求失败'));
        }

    }

    //为档案添加模板
    public function template_relation(){
        if(I('archivesid')){
            $archivesid = I('archivesid');
        }
        if(I('templateid')){
            $template=array_filter(explode(",",I('templateid')));
            foreach($template as $k=>$value){
                $templateid =  $value;
                $data['templateid']= $templateid;
                $data['archives_id']= $archivesid;
                $data['create_time']= time() ;
                //向表中插入数据
                $result=M("template_relation")->data($data)->add();
            }
        }
        if($result){
            echo json_encode(array('data'=>$result,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>'0','message'=>'数据请求失败'));
        }
    }
    //获取年级列表
    public function gradeList(){
        if(I('archivesid')) {
            $archivesid = intval(I('archivesid'));
        }
        if(I('schoolid')){
            $schoolid =intval(I('schoolid'));
        }else{
            $schoolid=$_SESSION['schoolid'];
        }
        $query = M('school_grade as a')->join('wxt_archives_grade as b on b.gradeid=a.gradeid')->where("b.archivesid=$archivesid and a.schoolid=$schoolid")->field('a.gradeid,a.name')->select();
        //echo "<pre>";
        //print_r($query);
        $gradelist = array();
        if($query){
            $gradelist['selected'] = $query;//已选年级
        }

        if($archivesid){
            $num = M('archives_grade')->where("archivesid= $archivesid")->field('gradeid')->count();
            if($num>0){
                //查询学校的班级
                $sql = "select gradeid,name from wxt_school_grade where (gradeid not in(select gradeid from wxt_archives_grade where  archivesid='$archivesid')) and schoolid='$schoolid'";
                $model = M();
                $result = $model->query($sql);
            }else{
                $result = M('school_grade')->where("schoolid= $schoolid")->field('gradeid,name')->select();
            }
        }
        if($result){
            $gradelist['notselected'] = $result;//未选班级
        }
        if(count($gradelist)){
            echo json_encode(array('data'=>$gradelist,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>'0','message'=>'数据请求失败'));
        }

    }

    //启动年级提交处理
    public function archives_grade()
    {
        if(I('archivesid')){//档案ID
            $archivesid = I('archivesid');
            $archives = M('archives')->where("id=$archivesid")->field('name')->find();
            $archivesname= $archives['name'];//档案名称
        }
        if(I('schoolid')){//学校ID
            $schoolid =intval(I('schoolid'));
        }else{
            $schoolid=$_SESSION['schoolid'];
        }
        if(I('gradeid')){//年级ID
            $grade=array_filter(explode(",",I('gradeid')));
            foreach($grade as $k=>$value){
                $gradeid =  $value;
                $array = M('school_grade')->where("schoolid=$schoolid and gradeid=$gradeid")->field('name')->find();
                $gradename=$array['name'];//年级名称
                $name = $archivesname.$gradename;
                $data['gradeid']= $gradeid ;
                $data['name']= $name ;
                $data['archivesid']= $archivesid ;
                $data['create_time']= time();
                //向档案年级表中插入数据
                $result=M("archives_grade")->data($data)->add();
                if($result){//档案年级关联表添加成功后
                    $class = M('school_class')->where("grade= $gradeid and schoolid=$schoolid")->field('id')->select();//查询年级下的班级
                    if($class){
                        foreach($class as $classlist){
                            $classid = $classlist['id'];//班级ID
                            $student = M('class_relationship')->where("classid= $classid")->field('userid')->select();//班级下的学生
                            foreach($student as $studentlist){
                                $date['studentid']= $studentlist['userid'];//学生ID
                                $date['gradeid']= $gradeid;//年级ID
                                $date['archivesid']= $archivesid;//档案ID
                                $date['schoolid']= $schoolid;//学校ID
                                $date['classid']= $classid;//班级ID
                                $date['createtime']= time();//班级ID
                                M("archives_student")->data($date)->add();
                            }
                        }
                    }
                }
            }
        }
        if($result){
            echo json_encode(array('data'=>$result,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>'0','message'=>'数据请求失败'));
        }
    }

    //获取已选班级列表
    public function selectedGrade(){
        if(I('archivesid')) {
            $archivesid = intval(I('archivesid'));
        }
        if(I('schoolid')){
            $schoolid =intval(I('schoolid'));
        }else{
            $schoolid=$_SESSION['schoolid'];
        }
       //$result = M('school_grade as a')->join('wxt_archives_grade as b on b.gradeid=a.gradeid')->where("b.archivesid=$archivesid and a.schoolid=$schoolid")->field('a.gradeid,a.name')->select();
       $result = M('school_grade as a')->join('wxt_archives_grade as b on b.gradeid=a.gradeid')->where("b.archivesid=$archivesid and a.schoolid=$schoolid")->field('a.gradeid,a.name,b.id')->select();

        if(count($result)){
            echo json_encode(array('data'=>$result,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>0,'message'=>'请先启用年级'));
        }

    }

    //获取书页列表
    public function pageList()
    {
        if(I('archivesid')){//档案ID
            $archivesid = intval(I('archivesid'));
        }
        if(I('gradeid')){//年级ID
            $gradeid =intval(I('gradeid'));
        }
        //查看书本表是否有数据 判断是否为第一次添加
        $query = M('archives_book as a')->join('wxt_archives_page as b on b.id=a.pageid')->where("a.archivesid=$archivesid and a.gradeid=$gradeid")->field('b.id,b.name,b.default')->select();
        $pagelist = array();
        if($query){
            $pagelist['selected'] = $query;//已选书页
        }
        if($archivesid &&$gradeid){
            $num = M('archives_book')->where("archivesid= $archivesid and gradeid =$gradeid ")->field('pageid')->count();
            if($num>0){
                $sql = "select id,name from wxt_archives_page where id not in(select pageid from wxt_archives_book where  archivesid='$archivesid' and gradeid ='$gradeid')";
                $model = M();
                $result = $model->query($sql);
            }else{
                $result = M('archives_page')->select();//查询书页表 获取书页数据
            }
        }
        if($result){
            $pagelist['notselected'] = $result;//未选书页
        }
        //$result = M('archives_page')->select();//查询书页表 获取书页数据
        if(count($pagelist)){
            echo json_encode(array('data'=>$pagelist,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>'0','message'=>'数据请求失败'));
        }
    }

    //添加书本
    public function addBook()
    {
        if(I('archivesid')){//档案ID
            $archivesid = intval(I('archivesid'));
        }
        if(I('gradeid')){//年级ID
            $gradeid =intval(I('gradeid'));
        }
        if(I('archivesgradeid')){//档案年级ID
            $archivesgradeid =intval(I('archivesgradeid'));
        }
        if(I('pageid')) {//书页ID
            $page=array_filter(explode(",",I('pageid')));
            foreach($page as $k=>$value){
                $pageid = $value;
                $data['pageid']= $pageid;
                $data['gradeid']= $gradeid ;
                $data['archivesid']= $archivesid;
                $data['archivesgradeid']= $archivesgradeid;
                $data['create_time']= time();
                //向档案书本表中插入数据
                $result=M("archives_book")->data($data)->add();
            }

        }
        if($result){
            echo json_encode(array('data'=>$result,'message'=>'数据添加成功'));
        }else{
            echo json_encode(array('data'=>0,'message'=>'数据添加失败'));
        }
    }

    //书本列表
    public function bookList()
    {
        $schoolid=$_SESSION['schoolid'];//学校ID
        //获得档案信息
        $semester = M('semester')->where("schoolid=$schoolid")->field('semester')->select();
        //print_r($semester);
        $this->assign('semester',$semester);//学期

        //搜索条件
        $filename = I("filename");//档案名称
        $semester = I("semester");//学期
        $bookname = I("bookname");//书本名称
        if($filename){
            $this->assign("filename",$filename);
            $where['c.name'] = array("LIKE","%".$filename."%");
        }
        if($bookname){
            $this->assign("bookname",$bookname);
            $where['b.name'] = array("LIKE","%".$bookname."%");
        }
        if($semester){
            $this->assign("semester",$semester);
            $where['d.semester'] = array("LIKE","%".$semester."%");
        }
        $where['c.schoolid']=$schoolid;

        $count = M('archives_grade as b')
            ->join('wxt_archives as c on b.archivesid=c.id')
            ->join('wxt_semester as d on c.semesterid=d.id')
            ->join('wxt_school_grade as e on e.gradeid=b.gradeid')
            -> where($where)
            ->field('b.id,c.name as archivesname,b.name as bookname,b.sceneid,b.styleid,d.semester,e.name as gradename')
            ->order("b.id asc")
            ->select();
       $num = count($count);
       // echo $count;
        $page = $this->page($num, 3);

        $book = M('archives_grade as b')
            ->join('wxt_archives as c on b.archivesid=c.id')
            ->join('wxt_semester as d on c.semesterid=d.id')
            ->join('wxt_school_grade as e on e.gradeid=b.gradeid')
            -> where($where)
            ->field('b.id,c.name as archivesname,b.name as bookname,b.sceneid,b.styleid,d.semester,e.name as gradename')
            ->order("b.id asc")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $this->assign("Page", $page->show('Admin'));
        $this->assign("book",$book);
        $this->display("booklist");
    }

    //获得档案列表
    public function archivesList()
    {
        $schoolid=$_SESSION['schoolid'];//学校ID
        $sql = "select id,name from wxt_archives where (id not in(select archivesid from wxt_archives_grade )) and schoolid='$schoolid'";
        $model = M();
        $result = $model->query($sql);
        //echo "<pre>";
        //print_r($result);
        if($result){
            echo json_encode(array('data'=>$result,'message'=>'数据获取成功'));
        }else{
            echo json_encode(array('data'=>0,'message'=>'数据获取失败'));
        }
    }

    //编辑
    public function edit()
    {
        $id =
        $info = M('temple_page')->order("sort asc")->select();
        //dump($info);
        $arr = array();
        foreach ($info as $k=>$v){
            $it = M('temple_imgs_texts')->where("temple_id = {$v['id']}")->select();
            $ia = array();
            $ta = array();
            foreach ($it as $ks=>$vs){
                if ($vs['type'] == 0){
                    $ta[$ks]['id'] = $vs['id'];
                    $ta[$ks]['width'] = $vs['width'];
                    $ta[$ks]['height'] = $vs['height'];
                    $ta[$ks]['left'] = $vs['left'];
                    $ta[$ks]['top'] = $vs['top'];
                } elseif ($vs['type'] == 1){
                    $ia[$ks]['id'] = $vs['id'];
                    $ia[$ks]['width'] = $vs['width'];
                    $ia[$ks]['height'] = $vs['height'];
                    $ia[$ks]['left'] = $vs['left'];
                    $ia[$ks]['top'] = $vs['top'];
                }
            }
            if (empty($ia)){
                $ijs = '';
            }else {
                $ijs = json_encode($ia);
            }
            if(empty($ta)){
                $tjs = '';
            }else{
                $tjs = json_encode($ta);
            }
            $arr[$k]['title'] = $v['title'];
            $arr[$k]['small_img'] = $v['small_img'];
            $arr[$k]['big_img'] = $v['big_img'];
            $arr[$k]['img_count'] = $v['img_count'];
            $arr[$k]['text_count'] = $v['text_count'];
            $arr[$k]['sort'] = $v['sort'];
            $arr[$k]['id'] = $v['id'];
            $arr[$k]['imgPosition'] = $ijs;
            $arr[$k]['textPosition'] = $tjs;
        }
        //dump($arr);

        //获取学校
        $school = M('school')->field('schoolid, school_name')->select();
        $this->assign('school', $school);
        $this->assign('info', $arr);

        $this->display('add_info_next');
    }

    public function add_info_post()
    {

        $this->assign('name', I('name'));
        $this->assign('name', I('year'));
        $this->assign('name', I('xueqi'));
        $this->assign('name', I('yue'));
        $this->display();
    }

    public function tempAjax()
    {
        $id = I('id');
        $select = M('temple_imgs_texts')->where("temple_id = $id")->select();
        if ($select){
            echo json_encode($select);
            exit();
        }
    }
    public function classAjax(){

    }
}