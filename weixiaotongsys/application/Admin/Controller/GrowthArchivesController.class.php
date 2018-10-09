<?php

/**
 * 后台成长档案
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class GrowthArchivesController extends AdminbaseController {

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

        //查询启动的年级
//        $gradelist=M('archives as a')->
//        join('wxt_archives_grade as b on b.archivesid=a.id')->
//        join('wxt_school_grade as c on c.gradeid=b.gradeid')->
//        where("a.schoolid = $schoolid")->
//        field('b.archivesid,b.gradeid,c.name')->
//        select();
//        echo "<pre>";
//        print_r($gradelist);
		$this->assign("Page", $page->show('Admin'));
        $this->assign('schoolid',$schoolid);//学校ID
		$this->assign("archives",$archives);
		$this->display();
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
//       if($result){
//           $this->success("数据添加成功");
//
//       }else{
//           $this->error('数据添加失败');
//       }
        if($result){
            echo json_encode(array('data'=>$result,'message'=>'数据添加成功'));
        }else{
            echo json_encode(array('data'=>'0','message'=>'数据添加失败'));
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

            $rst = M('archives')->where("id=$id")->delete();//删除档案
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }else{
            $this->error("未获取到数据");
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

    //获取书页列表  //待优化 应该以档案年级ID来查询
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
          $where['e.schoolid']=$schoolid;

        $count = M('archives_grade as b')
            ->join('wxt_archives as c on b.archivesid=c.id')
            ->join('wxt_semester as d on c.semesterid=d.id')
            ->join('wxt_school_grade as e on e.gradeid=b.gradeid')
            -> where($where)
            ->field('b.id,b.archivesid,b.gradeid,c.name as archivesname,b.name as bookname,b.sceneid,b.styleid,d.semester,e.name as gradename')
            ->order("b.id desc")
            ->select();
       $num = count($count);
       // echo $count;
        $page = $this->page($num, 3);

        $book = M('archives_grade as b')
            ->join('wxt_archives as c on b.archivesid=c.id')
            ->join('wxt_semester as d on c.semesterid=d.id')
            ->join('wxt_school_grade as e on e.gradeid=b.gradeid')
            -> where($where)
            ->field('b.id,b.archivesid,b.gradeid,c.name as archivesname,b.name as bookname,b.sceneid,b.styleid,d.semester,e.name as gradename')
            ->order("b.id desc")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        // var_dump($book);
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

        $array = M('school_grade')->where("schoolid= $schoolid")->field('gradeid,name')->select();//获取年级列表

        if($result){
            echo json_encode(array('data'=>$result,'gradelist'=>$array,'message'=>'数据获取成功'));
        }else{
            echo json_encode(array('data'=>0,'gradelist'=>$array,'message'=>'数据获取失败'));
        }
    }

    //获得全部的年级的列表
    public function plist()
    {
        $result = M('archives_page')->select();
        if($result){
            echo json_encode(array('data'=>$result,'message'=>'数据获取成功'));
        }else{
            echo json_encode(array('data'=>0,'message'=>'数据获取失败'));
        }
    }

    //书页设置添加提交
    public function bookPost()
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
                                M("archives_student")->data($date)->add();//档案学生列表
                            }
                        }
                    }
                }
            }
        }
        //上述添加完毕之后 开始添加档案书本表
        $archives_grade = M('archives_grade')->where("archivesid= $archivesid")->select();//查找刚添加的档案年级记录
        if(I('pageid')){//书页ID
            $page=array_filter(explode(",",I('pageid')));//处理书页ID
            foreach($archives_grade as $v){
                foreach($page as $k=>$value){
                    $pageid = $value;
                    $data['pageid']= $pageid;
                    $data['gradeid']= $v['gradeid'] ;
                    $data['archivesid']= $archivesid;
                    $data['archivesgradeid']= $v['id'];
                    $data['create_time']= time();
                    //向档案书本表中插入数据
                     M("archives_book")->data($data)->add();
                }
            }

        }

        if($result){
            echo json_encode(array('data'=>$result,'message'=>'数据请求成功'));
        }else{
            echo json_encode(array('data'=>'0','message'=>'数据请求失败'));
        }

    }

    //删除书本
    public function deleteBook(){

        //档案年级ID
        $id =intval(I('id'));
        if($id){
            $rst = M('archives_book')->where("archivesgradeid=$id")->delete();//档案书本表
            $arr = M('archives_grade')->where("id=$id")->delete();//档案年级表
            if($arr){
                $this->success("删除成功");
            }else{
                $this->error("删除失败！");
            }

        }else{
            $this->error("未获取到数据");
        }


    }

    //获取书页列表
    public function showPage()
    {

        if(I('id')){//档案年级ID
            $id =intval(I('id'));
        }
        $query = M('archives_book as a')->join('wxt_archives_page as b on b.id=a.pageid')->where("a.archivesgradeid=$id")->field('b.id,b.name,b.default')->select();
        $pagelist = array();
        if($query){
            $pagelist['selected'] = $query;//已选书页
        }
        if($id){
            $num = M('archives_book')->where("archivesgradeid=$id ")->field('pageid')->count();
            if($num>0){
                $sql = "select id,name from wxt_archives_page where id not in(select pageid from wxt_archives_book where  archivesgradeid='$id')";
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


    public function evaluationList()
    {
        $schoolid=$_SESSION['schoolid'];//学校ID
        if(I('gradeid')){//年级ID
            $gradeid = intval(I('gradeid'));
        }else{
            echo json_encode(array('data'=>0,'message'=>'请选择年级'));
        }
//        $result = M('evaluation as a')->join('wxt_evaluation_content as b on a.id=b.evaluationid')
//            ->where("a.schoolid=0 and a.gradeid=$gradeid and a.state=1")->select();
//        if(count($result)){
//            echo json_encode(array('data'=>$result,'message'=>'数据获取成功'));
//        }else{
//            echo json_encode(array('data'=>0,'message'=>'数据拉取失败'));
//        }
        $result = M('evaluation')->where("schoolid=0 and gradeid=$gradeid and state=1")->select();
        foreach($result as &$v){
            $id = $v['id'];
            $arr = M('evaluation_content')->where("evaluationid = $id")->select();
            $v['num'] = count($arr);
            $v['content'] = $arr;
        }
      // var_dump($result);
    if(count($result)){
            echo json_encode(array('data'=>$result,'message'=>'数据获取成功'));
        }else{
            echo json_encode(array('data'=>0,'message'=>'数据拉取失败'));
        }
    }




    public function checklist()
    {


        // $schoolid=$_SESSION['schoolid'];//学校ID
        // $gradelist = M('school_grade')->where("schoolid= $schoolid")->field('gradeid,name')->select();//拉取年级
        // $this->assign("gradelist",$gradelist);
        $this->display();

    }




 //考评项配置提交
    public function check_add()
    {
        $schoolid = $_SESSION['schoolid'];  //学校ID
        $gradeid=I("gradeid");//系统年级ID
        $type= I('type');//类型
        $state= I('state');//状态
        $evaluationid= I('evaluationid');//档案ID
        $gdid= I('gdid');//年级ID
        $evaluation=array_unique(array_filter(explode(",",$evaluationid)));
        if($state==1){
            //首先判断是否已经模板是否应用过
            $result = M('evaluation')->where("schoolid=$schoolid and gradeid=$gdid")->select();
            if(count($result)){
                //如果存在 那么就先删除原来的数据 在添加
                foreach($result as $v)
                {
                    $id = $v['id'];//考评项ID
                    M('evaluation')->where("id=$id")->delete();
                    M('evaluation_content')->where("evaluationid=$id")->delete();
                }

                //删除后在添加新的数据
                foreach($evaluation as $value)
                {
                    $id = $value;//考评项ID
                    $result = M('evaluation')->where("id=$id and state=1")->find(); //第一次取默认模板
                    $data['name']=$result['name'];
                    $data['schoolid']= $schoolid;
                    $data['gradeid']=$gdid;
                    $data['type']= $type;
                    $data['state']= 2;
                    $data['create_time']=time();
                    $query = M("evaluation")->data($data)->add();
                    if($query){//考评项添加成功后,添加对应的
                        $content = M('evaluation_content')->where("evaluationid=$id")->select(); //第一次取默认模板
                        foreach($content as $v){
                            $date['content'] = $v['content'];
                            $date['standard'] = $v['standard'];
                            $date['evaluationid'] = $query;
                            $list = M("evaluation_content")->data($date)->add();
                        }

                    }
                }

            }else{
                foreach($evaluation as $value)
                {
                    $id = $value;//考评项ID
                    $result = M('evaluation')->where("id=$id and state=1")->find(); //第一次取默认模板
                    $data['name']=$result['name'];
                    $data['schoolid']= $schoolid;
                    $data['gradeid']=$gdid;
                    $data['type']= $type;
                    $data['state']= 2;
                    $data['create_time']=time();
                    $query = M("evaluation")->data($data)->add();
                    if($query){//考评项添加成功后,添加对应的
                        $content = M('evaluation_content')->where("evaluationid=$id")->select(); //第一次取默认模板
                        foreach($content as $v){
                            $date['content'] = $v['content'];
                            $date['standard'] = $v['standard'];
                            $date['evaluationid'] = $query;
                            $list = M("evaluation_content")->data($date)->add();
                        }

                    }
                }

            }

            if($query && $list){
                echo json_encode(array('data'=>$query,'message'=>'数据提交成功'));

            }else{
                echo json_encode(array('data'=> '0','message'=>'数据提交失败'));
            }
        }



    }



     //自定义考评
   
   public function custom()
   {
    $Province=role_admin();
         $this->assign("Province",$Province);



    $this->display();

   }

   //自定义考评列表
   public function custom_list()
   {
      $gradeid = I('gradeid');
      //var_dump($gradeid);

       $schoolid=I('schoolid');//学校ID

       //选项类型
       $type = I('type');



       if(I('gradeid')){//年级ID
           $gradeid = intval(I('gradeid'));
         }else{
         echo json_encode(array('data'=>0,'message'=>'请选择年级'));
         }
            //查询是否有自定义模板
    

        $eva = M('evaluation')->where("schoolid = $schoolid and gradeid = $gradeid and type = $type")->select();
 


      foreach ($eva as $key => $value) {
          $evalid = $value['id'];

          $content = M('evaluation_content')->where("evaluationid = $evalid")->select();

          $num2=array_push($eva[$key],$content); 
        
       
      }
   


    if(count($eva)){
         echo json_encode(array('data'=>$eva,'message'=>'数据获取成功'));
        }else{
                echo json_encode(array('data'=>0,'message'=>'数据拉取失败'));
         }




   }

   //添加考评名称

   public function title_post()
   {
      $schoolid=I('schoolid');
      $name = I('name');

      $gradeid = I('gradeid');
      
      //如果存在是修改 不存在则保存
      $evaid = I('evaid');
      // var_dump($evaid);
   
      if(!$evaid){

      $type = I('type');
   
        $data = array(
           'schoolid'=>$schoolid,
           'gradeid'=>$gradeid,
           'name'=>$name,
           'type'=>$type,
           'state'=>3,
           'create_time'=>time(),

            );
     // var_dump($data);
          $title = M('evaluation')->add($data);
   
  
   
     if ($title) {
           $info['status'] = true;
            $info['msg'] = $title;
            } else {
            $info['status'] = false;
            $info['msg'] = '404';
            }
        echo json_encode($info); 
      }else{
          

          $data = array(
             'name'=>$name,
            );

        $edit = M('evaluation')->where("schoolid = $schoolid and id = $evaid")->save($data);
        // var_dump($edit);

            if ($edit) {
           $info['status'] = true;
            $info['msg'] = $edit;
            $info['name'] = $name;
            } else {
            $info['status'] = false;
            $info['msg'] = '404';
            }

        echo json_encode($info); 


      }

   }

 //删除标题及子类标题


   public function title_del()
   {
      $id = I('id');
    $title = M("evaluation")->where("id = $id")->delete();

    if($title)
    {
     $content = M('evaluation_content')->where("evaluationid = $id")->delete();

        
           $info['status'] = true;
            $info['msg'] = $content;
          
       
    }else{
          $info['status'] = false;
            $info['msg'] = '404';
    }

     echo json_encode($info); 

   }


   //删除子类标题


   public function content_del()
   {
      
      $contentid = I('contentid');

      $content = M("evaluation_content")->where("id = $contentid")->delete();

      if($content){
       
         $info['status'] = true;
            $info['msg'] = $content;

      }else{
        $info['status'] = false;
            $info['msg'] = '404';
      }
      
     echo json_encode($info); 
   }

   //添加考评内容
    public function content_post()
   {
      $schoolid=I('schoolid');
      $evaid = I('evaid');
      $content = I('content');
      $standard = I('standard');

      $contentid = I('contentid');

     if(!$contentid){

   
    $data = array(
       'evaluationid'=>$evaid,
       'content'=>$content,
       'standard'=>$standard,

        );
 // var_dump($data);
      $content = M('evaluation_content')->add($data);
   
  
   
     if ($content) {
           $info['status'] = true;
            $info['msg'] = $content;
            } else {
            $info['status'] = false;
            $info['msg'] = '404';
            }
        echo json_encode($info);
        }else{

             $data = array(
              'content'=>$content,
              'standard'=>$standard,
            );

        $edit = M('evaluation_content')->where("id = $contentid")->save($data);
        // var_dump($edit);

        if ($edit) {
           $info['status'] = true;
            $info['msg'] = $edit;
            } else {
            $info['status'] = false;
            $info['msg'] = '404';
            }

        echo json_encode($info); 

        } 


      

   }   






    //档案进展
    public function  show()
    {



        $schoolid=$_SESSION['schoolid'];
        // var_dump($schoolid);

        $archivesid = I('id');
        // var_dump($archivesid);

        $gradeid = I('gradeid');

        $classid = I('classid');

        // var_dump($gradeid);
        // exit();
        // var_dump($classid);

        if($gradeid)
        {
            $where['a.gradeid'] = $gradeid;
            $this->assign('gradeid',$gradeid);
        }else{

            $one_grade = M('archives_student')->where("schoolid = $schoolid and archivesid = $archivesid")->field("gradeid")->limit(0,1)->find();

            $where['a.gradeid'] = $one_grade['gradeid'];
           
            $this->assign('gradeid',$one_grade['gradeid']);

        }

        if($classid)
        {
            $where['a.classid']  = $classid;
            $this->assign('classid_int',$classid);
        }
        // var_dump($gradeid);

        $studentname = I('studentname');
        // var_dump($studentname);
        // var_dump($gradeid);

        if ($studentname) {
            $where["s.stu_name"]=array("LIKE","%".$studentname."%");
        }

        // var_dump($archivesid);
        $where['a.archivesid'] = $archivesid;
        $where['a.schoolid'] = $schoolid;
        $where['g.schoolid'] = $schoolid;
        // $where['a.gradeid'] = $gradeid;






        $count = M('archives_student')
            ->alias("a")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->join("wxt_student_info s ON s.userid = a.studentid")
            ->join("wxt_school_class c ON c.id = a.classid ")
            ->join("wxt_school_grade g ON g.gradeid = a.gradeid")
            ->field("a.id,a.archivesid,a.studentid,s.stu_name,g.name as grade_name,s.classname")
            ->count();
        $page = $this->page($count, 15);



        // var_dump($where);
        $list = M('archives_student')
            ->alias("a")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order('a.classid')
            ->join("wxt_school_class c ON c.id = a.classid ")
            ->join("wxt_student_info s ON s.userid = a.studentid")
            ->join("wxt_school_grade g ON g.gradeid = a.gradeid")
            ->field("a.id,a.archivesid,a.studentid,s.stu_name,g.name as grade_name,c.classname,a.gradeid")
            ->select();
        // var_dump($list);
        foreach ($list as $key => &$value){

            $gradeid = $value['gradeid'];

            $studentid = $value['studentid'];

            $archivesid = $value['archivesid'];

            //主号码只会有一条所以这里只查询一条
            $student_info = M('relation_stu_user')->where("studentid=$studentid and type = 1")->field("name,phone")->find();

            $value['parent'] = $student_info['name'];
            $value['phone'] = $student_info['phone'];

            $where_tea['studentid'] = $studentid;
            $where_tea['archivesid'] = $archivesid;
            $where_tea['schedule'] = 1;
            $where_tea['writen'] = 1;
            // $where_count['type'] = 1;
             $tea_sum = M('archives_student_page')->where($where_tea)->count();
    
         
            $where_par['studentid'] = $studentid;
            $where_par['archivesid'] = $archivesid;
            $where_par['schedule'] = 1;
            $where_par['writen'] = 2;
            // $where_count['type'] = 1;
             $par_sum = M('archives_student_page')->where($where_par)->count();

   



            //查出该档案的总页数
            $archives_detail = M('archives_book')->where("archivesid = $archivesid and gradeid = $gradeid")->field("count(1) as sum")->group('writer')->select();
           // var_dump($archives_detail);

            // exit();

            //查出该学生下完成进度
       
            if(!$archives_detail[0]['sum'])
            {
                $archives_detail[0]['sum'] = 0;
            }


            if(!$archives_detail[1]['sum'])                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
            {
                $archives_detail[1]['sum'] = 0;
            }
            $value['tea_sum'] = $tea_sum.'/'.$archives_detail[0]['sum'];
            $value['par_sum'] = $par_sum.'/'.$archives_detail[1]['sum'];


         }


        $grade = M('school_grade')->where("schoolid = $schoolid")->select();
       

        $this->assign("categorys",$grade);
        $this->assign("archivesid",$archivesid);
        $this->assign("Page", $page->show('Admin'));
        $this->assign('list',$list);
        $this->display();

    }


    public function Growing()
    {

        $this->display();
    }
  
  //编辑
    public function edit()
    {
        $id = I('id'); //gradeid---年级id
        $archivesid = I('archivesid');  //档案id
        //=============================根据年级id 获取模板信息=================================================
        //显示所有的模板
        $where['b.gradeid'] = $id;
        $info = M('archives_book')
            ->alias('b')
            ->where($where)
            ->join("wxt_archives_page p on b.pageid=p.id")
            ->join("wxt_temple_page tp on tp.id=p.temple_id")
            ->order("sort asc")
            ->select();
        $arr = array();
        foreach ($info as $k => $v) {
            $it = M('temple_imgs_texts')->where("temple_id = {$v['id']}")->select();
            $ia = array();
            $ta = array();
            $count = 0;
            $num = 0;
            foreach ($it as $ks => $vs) {
                if ($vs['type'] == 0) {
                    $ta[$count]['id'] = $vs['id'];
                    $ta[$count]['width'] = $vs['width'];
                    $ta[$count]['height'] = $vs['height'];
                    $ta[$count]['left'] = $vs['left'];
                    $ta[$count]['top'] = $vs['top'];
                    $count++;
                } elseif ($vs['type'] == 1) {
                    $ia[$num]['id'] = $vs['id'];
                    $ia[$num]['width'] = $vs['width'];
                    $ia[$num]['height'] = $vs['height'];
                    $ia[$num]['left'] = $vs['left'];
                    $ia[$num]['top'] = $vs['top'];
                    $num++;
                }
            }
            if (empty($ia)) {
                $ijs = '';
            } else {
                $ijs = json_encode($ia);
            }
            if (empty($ta)) {
                $tjs = '';
            } else {
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
            $arr[$k]['pageid'] = $v['pageid'];
        }
        //dump($arr);
//        foreach ($info as $k=>$v){
//            $it = M('temple_imgs_texts')->where("temple_id = {$v['id']}")->select();
//            $ia = array();
//            $ta = array();
//            $content = array(); //图片内容
//            $text = array(); //文字内容
//            $count = 0;
//            $num = 0;
//            foreach ($it as $ks=>$vs){
//                if ($vs['type'] == 0){
//                    $ta[$count]['id'] = $vs['id'];
//                    $ta[$count]['width'] = $vs['width'];
//                    $ta[$count]['height'] = $vs['height'];
//                    $ta[$count]['left'] = $vs['left'];
//                    $ta[$count]['top'] = $vs['top'];
//                    $text[$count]['id'] = $vs['id'];
//                    $text[$count]['text'] = $vs['content'];
//                    $count++;
//                } elseif ($vs['type'] == 1){
//                    $ia[$num]['id'] = $vs['id'];
//                    $ia[$num]['width'] = $vs['width'];
//                    $ia[$num]['height'] = $vs['height'];
//                    $ia[$num]['left'] = $vs['left'];
//                    $ia[$num]['top'] = $vs['top'];
//                    $content[$num]['position'] = $vs['id'];
//                    $content[$num]['url'] = $vs['content'];
//                    $num++;
//                }
//            }
//            if (empty($ia)){
//                $ijs = '';
//            }else {
//                $ijs = json_encode($ia);
//            }
//            if(empty($ta)){
//                $tjs = '';
//            }else{
//                $tjs = json_encode($ta);
//            }
//            if (!empty($content[0]['url'])){
//                $content = json_encode($content);
//                $arr[$k]['content'] = $content;
//            }
//            if (!empty($text[0]['text'])){
//                $text = json_encode($text);
//                $arr[$k]['text'] = $text;
//            }
//            $arr[$k]['title'] = $v['title'];
//            $arr[$k]['small_img'] = $v['small_img'];
//            $arr[$k]['big_img'] = $v['big_img'];
//            $arr[$k]['img_count'] = $v['img_count'];
//            $arr[$k]['text_count'] = $v['text_count'];
//            $arr[$k]['sort'] = $v['sort'];
//            $arr[$k]['id'] = $v['id'];
//            $arr[$k]['imgPosition'] = $ijs;
//            $arr[$k]['textPosition'] = $tjs;
//        }
        //dump($arr);

        //==============================获取学生信息=================================================
        $studentYes = $this->isSendOrNotSend($id, $archivesid, 2);  //已发送
        $studentNo = $this->isSendOrNotSend($id, $archivesid, 1);   //未发送
        $this->assign('info', $arr);
        //=================================获取寄语===================================================
        $word = M('principal_word')->where("schoolid = {$_SESSION['schoolid']}")->field("content")->select();
        //学生列表
        $this->assign('studentYes', $studentYes);
        $this->assign('studentNo', $studentNo);
        $this->assign('gradeid', $id);
        $this->assign('archivesid', $archivesid);
        $this->assign('words', $word);
        $this->display('add_info_next');
    }

    //学生已发送与未发送---send=1未发送----send=2已发送
    public function isSendOrNotSend($gid, $archivesid, $send)
    {
        //获取总页数
        $a = M()->query("select b.pageid from wxt_archives_book as b where  b.archivesgradeid=(select g.id from wxt_archives_grade as g where g.gradeid=$gid and g.archivesid=$archivesid)");
        //dump($a);
        $all = count($a);
        //获取所有班级下的学生
        $where['a.archivesid'] = $archivesid;
        $where['a.schoolid'] = $_SESSION['schoolid'];
        //$where['g.schoolid'] = $_SESSION['schoolid'];
        $where['a.send'] = $send;
        //var_dump($where);
//        $list = M('archives_student')
//            ->alias("a")
//            ->where($where)
//            ->order('a.classid')
//            ->join("wxt_school_class c ON c.id = a.classid ")
//            ->join("wxt_student_info s ON s.userid = a.studentid")
//            ->join("wxt_school_grade g ON g.gradeid = a.gradeid")
//            //->join("wxt_archives_student_page p on p.studentid=a.studentid")
//            //->field("a.studentid,s.stu_name,g.name as grade_name,c.classname, count(p.id) as count")
//            ->field("a.studentid, a.archivesid, a.gradeid,s.stu_name,g.name as grade_name,c.classname")
//            ->select();
        $student = array();
        $list = M('archives_student')
            ->alias("a")
            ->where("a.archivesid = $archivesid and a.schoolid={$_SESSION['schoolid']} and a.send=$send")
            ->order('a.classid')
            ->join("wxt_school_class c ON c.id = a.classid ")
            ->join("wxt_student_info s ON s.userid = a.studentid")
            ->field("a.studentid, a.archivesid, a.gradeid,s.stu_name")
            ->select();
        //dump($list);
        foreach ($list as $k => $v) {
            if ($v['studentid']) {
                //1.判断该学生是否已经插入页
                $array = M('growth_student_temple')->where("student_id={$v['studentid']} and grade_id=$gid and archives_id = $archivesid")->field("id")->find();
                //dump($list);
                if (empty($array)) {
                    //插入数据库
                    foreach ($a as $vs){
                        $arr = array(
                            'student_id' => $v['studentid'],
                            'grade_id' => $gid,
                            'archives_id' => $archivesid,
                            'page_id' => $vs['pageid']
                        );
                        $id = M('growth_student_temple')->add($arr);
                        if ($id) {
                            //根据页获取当前页的详细信息
                            $imgTexts = M()->query("select tit.id from wxt_temple_imgs_texts as tit where tit.temple_id= (select ap.temple_id from wxt_archives_page as ap where ap.id={$vs['pageid']})");
                            foreach ($imgTexts as $ks => $vss) {
                                $arr = array(
                                    'growth_temple_id' => $id,
                                    'img_text_id' => $vss['id'],
                                    'page_id' => $vs['pageid'],
                                    'grade_id' => $gid,
                                    'archives_id' => $archivesid,
                                    'student_id'=>$v['studentid']
                                );
                                M('growth_temple_imgs_texts')->add($arr);
                            }
                        }
                    }
                }
                //2.保存学生信息
                $student[$k]['studentid'] = $v['studentid'];
                $student[$k]['studentname'] = $v['stu_name'];
                //获取已完成页数
                $asp = M('archives_student_page')->where("archivesid=$archivesid and studentid={$v['studentid']}")->select();
                $student[$k]['nopage'] = count($asp);
                $student[$k]['allpage'] = $all;
            }
        }
        return $student;
    }

    public function tempAjax()
    {
        $id = I('id');
        $type = I('type');
        $where['page_id'] = $id;
        $where['it.type'] = $type;
        $where['grade_id'] = I('gid');
        $where['archives_id'] = I('aid');
        $where['student_id'] = I('sid');
        //dump($where);
        //获取当前页的所有
        $select = M('growth_temple_imgs_texts')
            ->alias('tit')
            ->where($where)
            ->join('wxt_temple_imgs_texts it on it.id=tit.img_text_id')
            ->select();
        //dump($select);
        if ($select) {
            echo json_encode($select);
            exit();
        }
    }

    public function addImgAjax()
    {
        $data = I('data');
        $student_temple = I('studentTemple');
        //dump($student_temple);
        $img_text_id = I('imgTextId');
        //dump($img_text_id);
        //判断是否已经插过数据库
        $sid = $student_temple[0]['sid'];
        $gid = $student_temple[0]['gid'];
        $aid = $student_temple[0]['aid'];
        $array = M('growth_student_temple')->where("student_id=$sid and grade_id=$gid and archives_id = $aid")->field("id")->find();
        //dump($array);
        //exit();
        if (empty($array)) {
            //插入数据库
            foreach ($student_temple as $k => $v) {
                $arr = array(
                    'student_id' => $v['sid'],
                    'grade_id' => $v['gid'],
                    'archives_id' => $v['aid'],
                    'page_id' => $v['pid']
                );
                $id = M('growth_student_temple')->add($arr);
                if ($id) {
                    foreach ($img_text_id as $ks => $vs) {
                        if ($v['pid'] == $vs['pageid']) {
                            echo $id . ', ';
                            $arr = array(
                                'growth_temple_id' => $id,
                                'img_text_id' => $vs['imgTextId'],
                                'page_id' => $vs['pageid'],
                                'grade_id' => $v['gid'],
                                'archives_id' => $v['aid']
                            );
                            M('growth_temple_imgs_texts')->add($arr);
                        }
                    }
                }
            }
        }
        //dump($data);
        //保存数据
        foreach ($data as $k => $v) {
            $where['grade_id'] = $gid;
            $where['archives_id'] = $aid;
            $where['student_id'] = $sid;
            $where['page_id'] = $v['pid'];
            $where['img_text_id'] = $v['id'];
            $arr = array(
                'type' => $v['type'],
                'content' => $v['url'],
            );
            M('growth_temple_imgs_texts')->where($where)->save($arr);
        }
        //添加已完成页
        $is_finish = I('isFinish');
        $count = 0;
        foreach ($is_finish as $k=>$v){
            //dump($v);
            //echo "archivesid={$v['archivesid']} and studentid={$v['studentid']} and pageid={$v['pageid']}";
            //判断是否存在
            $isHas = M('archives_student_page')->where("archivesid={$v['archivesid']} and studentid={$v['studentid']} and pageid={$v['pageid']}")->find();
            if (!$isHas){
                $arr = array(
                    'archivesid'=>$v['archivesid'],
                    'studentid'=>$v['studentid'],
                    'pageid'=>$v['pageid'],
                    'writen'=>1,
                    'schedule'=>1
                );
                M('archives_student_page')->add($arr);
                $count++;
            }
        }
        echo json_encode(array('status' => 200, 'count'=>$count));
    }

    //获取该学生已经填写的页的数据
    public function getStudentPageInfo()
    {
        $sid = I('sid');  //学生id
        $gid = I('gid');   //年纪id
        $aid = I('aid');   //档案id

        //var_dump($sid);
        //1.获取该学生已经填写好的页
        $where['st.student_id'] = $sid;
        $where['st.grade_id'] = $gid;
        $where['st.archives_id'] = $aid;
        $list = M('growth_student_temple')
            ->alias("st")
            ->where($where)
            ->join("wxt_archives_page ap on st.page_id = ap.id")
            ->join("wxt_temple_page tp on tp.id = ap.temple_id")
            //->join("wxt_temple_imgs_texts as tit on tit.temple_id = tp.id")
            ->field("st.id as st_id, st.page_id, tp.*, ap.*")
            ->select();
        //dump($list);
        foreach ($list as $k => $v) {
            $it = M('growth_temple_imgs_texts')
                ->alias("tit")
                ->where("growth_temple_id = {$v['st_id']}")
                ->join("wxt_temple_imgs_texts as it on it.id=tit.img_text_id")
                ->field("tit.*, it.type")
                ->select();
            $content = array(); //图片内容
            $text = array(); //文字内容
            $count = 0;
            $num = 0;
            foreach ($it as $vs) {
                if ($vs['type'] == 0) {
                    if ($vs['content']) {
                        $text[$count]['id'] = $vs['img_text_id'];
                        $text[$count]['text'] = $vs['content'];
                        $count++;
                    }
                } elseif ($vs['type'] == 1) {
                    if ($vs['content']) {
                        $content[$num]['position'] = $vs['img_text_id'];
                        $content[$num]['url'] = $vs['content'];
                        $num++;
                    }
                }
            }
            if (!empty($content)) {
                $arr[$k]['content'] = json_encode($content);
            }else{
                $arr[$k]['content'] = '';
            }
            if (!empty($text)) {
                $arr[$k]['text'] = json_encode($text);
            }else{
                $arr[$k]['text'] = '';
            }
            //判断是否已经填写完整
            if ($v['img_count'] == $num && $v['text_count'] == $count) {
                $flag = true;
            } else {
                $flag = false;
            }
            $arr[$k]['img_count'] = $v['img_count'];
            $arr[$k]['text_count'] = $v['text_count'];
            $arr[$k]['id'] = $v['id'];
            $arr[$k]['is_finish'] = $flag;
        }
        //dump($arr);
        echo json_encode($arr);
    }

    //===================================获取当前学校的所有班级的图片======================================
    public function getClassPic(){
        $gid  = I('gid');
        $aid = I('aid');
        $where['s.schoolid'] = $_SESSION['schoolid'];
        $where['s.gradeid'] = $gid;
        $where['s.archivesid'] = $aid;
        //$where['m.type'] = 2;
        //dump($where);
        //获取该年纪下所有的班级
        $class = M('archives_student')
            ->alias('s')
            ->where($where)
            ->group("s.classid")
            ->join("wxt_school_class as c on c.id=s.classid")
            ->field('s.classid, c.classname')
            ->select();
        echo json_encode($class);
    }

    //获取当前选中的版及对应的图片
    public function getNowClassPic()
    {
        $cid = I('cid');
        $wheres['m.schoolid'] = $_SESSION['schoolid'];
        $wheres['m.classid'] = $cid;
        $wheres['m.type'] = I('type');
        //dump($wheres);
        $list = M('microblog_main')
            ->alias('m')
            ->where($wheres)
            ->join("wxt_microblog_picture_url as u on u.microblogid=m.mid")
            ->field("u.pictureurl, m.classid")
            ->select();
        //dump($list);
        echo json_encode($list);
    }

    public function getNowBabyPic(){
        $sid = I('sid');
        $where['rsu.studentid'] = $sid;
        //$where['m.schoolid'] = $_SESSION['schoolid'];
       // $where['m.type'] = 3;
        $list = M()->query("select pu.pictureurl, pu.microblogid from wxt_microblog_picture_url as pu where pu.microblogid in (select m.mid from wxt_microblog_main as m where m.userid in (select rsu.userid from wxt_relation_stu_user as rsu where rsu.studentid=$sid))");
        echo json_encode($list);
    }
   





}