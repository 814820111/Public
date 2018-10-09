<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header("Content-type:text/html;charset=utf-8");
class GrowtharchivesController extends WeixinbaseController
{
    function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        //print_r($_SESSION);
        //1 根据 学生的班级 找到  找到 书本
        $studentid = $_SESSION['studentid'];
        $classid = $_SESSION['classid'];
        $schoolid = $_SESSION['schoolid'];
        $array = M("archives_student as a")
            ->join("wxt_archives_grade as b on b.archivesid=a.archivesid and b.gradeid=a.gradeid ")
            ->join("wxt_archives as c on b.archivesid=c.id")
            ->join("wxt_semester as d on c.semesterid=d.id")
            ->join("wxt_school_class as e on a.classid=e.id")
            ->where("a.studentid = $studentid and a.classid = $classid ")
            ->field("a.studentid,a.classid,b.archivesid,b.gradeid,c.name as aname,b.name as bookname,d.semester,e.classname,b.create_time")
            ->order('d.id asc')
            ->select();
        $this->assign("alist", $array);
        $this->display();
    }


    public function stuList(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        //找到学生 信息 已经学生完成的页数情况
        $archivesid = I('aid');
        $gradeid = I('gid');
        $classid = I('classid');
        $studentid = I('studentid');
        $array = M('archives_student as a')
            ->join("wxt_wxtuser as b on a.studentid = b.id")
            ->join("wxt_student_info as student on student.userid = b.id")
            ->where("a.studentid = $studentid and a.archivesid = $archivesid and a.gradeid = $gradeid and a.classid = $classid")
            ->field("student.stu_name as name,b.photo,a.gradeid,a.studentid,a.archivesid, a.classid")
            ->select();
//        print_r($array);
        foreach ($array as $key => &$value){

            $gradeid = $value['gradeid'];

            $studentid = $value['studentid'];

            $archivesid = $value['archivesid'];

//            //主号码只会有一条所以这里只查询一条
//            $student_info = M('relation_stu_user')->where("studentid=$studentid and type = 1")->field("name,phone")->find();
//
//            $value['parent'] = $student_info['name'];
//            $value['phone'] = $student_info['phone'];

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
        $this->assign('cid',$classid);
        $this->assign('sid',$studentid);
        $this->assign('aid',$archivesid);
        $this->assign('gid',$gradeid);
        $this->assign("stulist", $array);
        $this->display();
    }

    //班级列表
    public function classList(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        //1找到这个档案下的班级
        //2找到这个班级下的学生
        //3 处理数据  最最终形成 类似 小一班:学生 小二班学生的 数据
        $archivesid = I('aid');
        $gradeid = I('gid');
        $array = M('archives_student')
            ->join("wxt_school_class on wxt_archives_student.classid = wxt_school_class.id")
            ->where("wxt_archives_student.archivesid = $archivesid and wxt_archives_student.gradeid = $gradeid")
            ->field("classid,classname,archivesid,gradeid")
            ->select();

        $result=array();
        //对重复数据进行处理
        if(count($array)>0){
            for($i=0;$i<count($array);$i++){
                $source=$array[$i];
                if(array_search($source,$array)==$i && $source<>"" ){
                    $result[]=$source;
                }
            }
        }
        $this->assign("list", $result);
        $this->display();

    }

    //家长进度
    public function  parentSchedule(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);

        //找到学生 信息 已经学生完成的页数情况
        $archivesid = I('aid');
        $gradeid = I('gid');
        $classid = I('classid');
        $array = M('archives_student as a')
            ->join("wxt_wxtuser as b on a.studentid = b.id")
            ->where("a.archivesid = $archivesid and a.gradeid = $gradeid and a.classid = $classid")
            ->field("b.name,b.photo,a.gradeid,a.studentid,a.archivesid")
            ->select();
//        print_r($array);
        foreach ($array as $key => &$value){

            $gradeid = $value['gradeid'];

            $studentid = $value['studentid'];

            $archivesid = $value['archivesid'];

//            //主号码只会有一条所以这里只查询一条
            $student_info = M('relation_stu_user')->where("studentid=$studentid and type = 1")->field("name,phone")->find();

            $value['parent'] = $student_info['name'];
            $value['phone'] = $student_info['phone'];

//            $where_tea['studentid'] = $studentid;
//            $where_tea['archivesid'] = $archivesid;
//            $where_tea['schedule'] = 1;
//            $where_tea['writen'] = 1;
//            // $where_count['type'] = 1;
//            $tea_sum = M('archives_student_page')->where($where_tea)->count();


            $where_par['studentid'] = $studentid;
            $where_par['archivesid'] = $archivesid;
            $where_par['schedule'] = 1;
            $where_par['writen'] = 2;
            // $where_count['type'] = 1;
            $par_sum = M('archives_student_page')->where($where_par)->count();

            //查出该档案的总页数
            $archives_detail = M('archives_book')->where("archivesid = $archivesid and gradeid = $gradeid")->field("count(1) as sum")->group('writer')->select();
            //查出该学生下完成进度

//            if(!$archives_detail[0]['sum'])
//            {
//                $archives_detail[0]['sum'] = 0;
//            }


            if(!$archives_detail[1]['sum'])
            {
                $archives_detail[1]['sum'] = 0;
            }
//            $value['tea_sum'] = $tea_sum.'/'.$archives_detail[0]['sum'];
            $value['par_sum'] = $par_sum.'/'.$archives_detail[1]['sum'];

        }
//        print_r($array);
        $this->assign("parentlist", $array);
        $this->display();
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

    //成长档案
    function Growtharchives(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $teacherid = $_SESSION['userid'];
        $this->assign("teacherid", $teacherid);

        $this->display();
    }
    //好友成长日记
    public function GrowthDiary(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION["userid"];
        $this->assign("userid",$userid);
        $studentid = $_SESSION['studentid'];
        $info = M("wxtuser")->where(array("id"=>$userid))->find();//查找自己的信息
        $this->assign("username",$info['name']);//自己的姓名

        //获取学生姓名
        $stu_info = M("wxtuser")->where(array("id"=>$studentid))->find();
        $this->assign("name",$stu_info['name']);
        $this->assign("classid",$_SESSION['classid']);
        $this->assign("schoolid",$_SESSION['schoolid']);
        $sid = I('sid');//好友学生id
        $this->assign("studentid",$sid);
        $this->display("Growthdiary");
    }

    public function studentPage()
{
    $cid = I('cid');
    $sid = I('sid');
    $gid = I('gid');
    $aid = I('aid');

    $img = isset($_GET['img']) ? I('img') : '';
    if ($img){
        $this->assign('selectImg', $img);
    }
    $id = isset($_GET['id']) ? I('id') : '';
    if ($img){
        $this->assign('id', $id);
    }
    //获取学生的信息
    //$stu = M('wxtuser')->where("id = $sid")->field('name')->find();
    $stu = M('student_info')->where("userid = $sid")->field('stu_name')->find();
    $this->assign('cid', $cid);
    $this->assign('sid', $sid);
    $this->assign('gid', $gid);
    $this->assign('aid', $aid);
    $this->assign('student_name', $stu['stu_name']);
    $this->display('student_page');
}

    public function showstudentPage()
    {
        $cid = I('cid');
        $sid = I('sid');
        $gid = I('gid');
        $aid = I('aid');

        $img = isset($_GET['img']) ? I('img') : '';
        if ($img){
            $this->assign('selectImg', $img);
        }
        $id = isset($_GET['id']) ? I('id') : '';
        if ($img){
            $this->assign('id', $id);
        }
        //获取学生的信息
        $stu = M('student_info')->where("userid = $sid")->field('stu_name')->find();
        $this->assign('cid', $cid);
        $this->assign('sid', $sid);
        $this->assign('gid', $gid);
        $this->assign('aid', $aid);
        $this->assign('student_name', $stu['stu_name']);
        $this->display('show_student_page');
    }

    //学生列表页
    public function studentPageList()
    {
        $cid = I('cid');
        $sid = I('sid');
        $gid = I('gid');
        $aid = I('aid');
        //1.获取该学生已经填写好的页
        $where['st.student_id'] = $sid;
        $where['st.grade_id'] = $gid;
        $where['st.archives_id'] = $aid;
        $where['ap.writen'] = 2;
        $list = M('growth_student_temple')
            ->alias("st")
            ->where($where)
            ->join("wxt_archives_page ap on st.page_id = ap.id")
            ->join("wxt_temple_page tp on tp.id = ap.temple_id")
            //->join("wxt_temple_imgs_texts as tit on tit.temple_id = tp.id")
            ->field("st.id as st_id, st.page_id, tp.*, ap.*")
            ->select();
        //dump($list);
        $nums = 0;
        foreach ($list as $k => $v) {
            if ($v['img_count'] == 0 && $v['text_count'] == 0){
                continue;
            }
            $it = M('growth_temple_imgs_texts')
                ->alias("tit")
                ->where("growth_temple_id = {$v['st_id']}")
                ->join("wxt_temple_imgs_texts as it on it.id=tit.img_text_id")
                ->field("tit.*, it.type, it.width, it.height, it.left, it.top")
                ->select();
            $content = array(); //图片内容
            $count = 0;
            $num = 0;
            foreach ($it as $vs) {
                $content[$num]['id'] = $vs['img_text_id'];
                if ($vs['type'] == 0){
                    $content[$num]['text'] = $vs['content'];
                }else{
                    $content[$num]['img'] = $vs['content'];
                }
                $content[$num]['width'] = $vs['width'];
                $content[$num]['height'] = $vs['height'];
                $content[$num]['top'] = $vs['top'];
                $content[$num]['left'] = $vs['left'];
                $content[$num]['type'] = $vs['type'];
                $num++;
//                if ($vs['content']) {
//                    if ($vs['type'] == 0) {
////                        if ($vs['content']) {
////                            $text[$count]['id'] = $vs['img_text_id'];
////                            $text[$count]['text'] = $vs['content'];
////                            $count++;
////                        }
//                        $text[$count]['id'] = $vs['img_text_id'];
//                        $text[$count]['text'] = $vs['content'];
//                        $text[$count]['width'] = $vs['width'];
//                        $text[$count]['height'] = $vs['height'];
//                        $text[$count]['top'] = $vs['top'];
//                        $text[$count]['left'] = $vs['left'];
//                        $text[$count]['type'] = $vs['type'];
//                        $count++;
//                    } elseif ($vs['type'] == 1) {
////                        if ($vs['content']) {
////                            $content[$num]['position'] = $vs['img_text_id'];
////                            $content[$num]['url'] = $vs['content'];
////                            $num++;
////                        }
//                        $content[$num]['id'] = $vs['img_text_id'];
//                        $content[$num]['img'] = $vs['content'];
//                        $content[$num]['width'] = $vs['width'];
//                        $content[$num]['height'] = $vs['height'];
//                        $content[$num]['top'] = $vs['top'];
//                        $content[$num]['left'] = $vs['left'];
//                        $content[$num]['type'] = $vs['type'];
//                        $num++;
//                    }
//                }
            }
//            if (!empty($content)) {
//                $arr[$nums]['content'] = json_encode($content);
//            }else{
//                $arr[$nums]['content'] = '';
//            }
//            if (!empty($text)) {
//                $arr[$nums]['text'] = json_encode($text);
//            }else{
//                $arr[$nums]['text'] = '';
//            }
            //判断是否已经填写完整
//            if ($v['img_count'] == $num && $v['text_count'] == $count) {
//                $flag = true;
//            } else {
//                $flag = false;
//            }
            $arr[$nums]['pid'] = $v['id'];
//            $arr[$nums]['is_finish'] = $flag;
            $arr[$nums]['img'] = $v['big_img'];
            $arr[$nums]['img_count'] = $v['img_count'];
            $arr[$nums]['text_count'] = $v['text_count'];
            $arr[$nums]['content'] = $content;
            $nums++;
        }
        echo json_encode($arr);
        exit;
    }

    //学生列表页
    public function showstudentPageList()
    {
        $cid = I('cid');
        $sid = I('sid');
        $gid = I('gid');
        $aid = I('aid');
        //1.获取该学生已经填写好的页
        $where['st.student_id'] = $sid;
        $where['st.grade_id'] = $gid;
        $where['st.archives_id'] = $aid;
        //$where['ap.writen'] = 2;
        $list = M('growth_student_temple')
            ->alias("st")
            ->where($where)
            ->join("wxt_archives_page ap on st.page_id = ap.id")
            ->join("wxt_temple_page tp on tp.id = ap.temple_id")
            //->join("wxt_temple_imgs_texts as tit on tit.temple_id = tp.id")
            ->field("st.id as st_id, st.page_id, tp.*, ap.*")
            ->select();
        //dump($list);
        $nums = 0;
        foreach ($list as $k => $v) {
//            if ($v['img_count'] == 0 && $v['text_count'] == 0){
//                continue;
//            }
            $it = M('growth_temple_imgs_texts')
                ->alias("tit")
                ->where("growth_temple_id = {$v['st_id']}")
                ->join("wxt_temple_imgs_texts as it on it.id=tit.img_text_id")
                ->field("tit.*, it.type, it.width, it.height, it.left, it.top")
                ->select();
            $content = array(); //图片内容
            $count = 0;
            $num = 0;
            foreach ($it as $vs) {
                $content[$num]['id'] = $vs['img_text_id'];
                if ($vs['type'] == 0){
                    $content[$num]['text'] = $vs['content'];
                }else{
                    $content[$num]['img'] = $vs['content'];
                }
                $content[$num]['width'] = $vs['width'];
                $content[$num]['height'] = $vs['height'];
                $content[$num]['top'] = $vs['top'];
                $content[$num]['left'] = $vs['left'];
                $content[$num]['type'] = $vs['type'];
                $num++;
//                if ($vs['content']) {
//                    if ($vs['type'] == 0) {
////                        if ($vs['content']) {
////                            $text[$count]['id'] = $vs['img_text_id'];
////                            $text[$count]['text'] = $vs['content'];
////                            $count++;
////                        }
//                        $text[$count]['id'] = $vs['img_text_id'];
//                        $text[$count]['text'] = $vs['content'];
//                        $text[$count]['width'] = $vs['width'];
//                        $text[$count]['height'] = $vs['height'];
//                        $text[$count]['top'] = $vs['top'];
//                        $text[$count]['left'] = $vs['left'];
//                        $text[$count]['type'] = $vs['type'];
//                        $count++;
//                    } elseif ($vs['type'] == 1) {
////                        if ($vs['content']) {
////                            $content[$num]['position'] = $vs['img_text_id'];
////                            $content[$num]['url'] = $vs['content'];
////                            $num++;
////                        }
//                        $content[$num]['id'] = $vs['img_text_id'];
//                        $content[$num]['img'] = $vs['content'];
//                        $content[$num]['width'] = $vs['width'];
//                        $content[$num]['height'] = $vs['height'];
//                        $content[$num]['top'] = $vs['top'];
//                        $content[$num]['left'] = $vs['left'];
//                        $content[$num]['type'] = $vs['type'];
//                        $num++;
//                    }
//                }
            }
//            if (!empty($content)) {
//                $arr[$nums]['content'] = json_encode($content);
//            }else{
//                $arr[$nums]['content'] = '';
//            }
//            if (!empty($text)) {
//                $arr[$nums]['text'] = json_encode($text);
//            }else{
//                $arr[$nums]['text'] = '';
//            }
            //判断是否已经填写完整
//            if ($v['img_count'] == $num && $v['text_count'] == $count) {
//                $flag = true;
//            } else {
//                $flag = false;
//            }
            $arr[$nums]['pid'] = $v['id'];
//            $arr[$nums]['is_finish'] = $flag;
            $arr[$nums]['img'] = $v['big_img'];
            $arr[$nums]['img_count'] = $v['img_count'];
            $arr[$nums]['text_count'] = $v['text_count'];
            $arr[$nums]['content'] = $content;
            $nums++;
        }
        echo json_encode($arr);
        exit;
    }
    //图片上传保存
    public function save()
    {
        $img = I('img');
        $text = I('text');
        if ($img){
            $this->saveList($img);
        }
        if ($text){
            $this->saveList($text);
        }
        $is_finish = I('isFinish');
        foreach ($is_finish as $k=>$v){
            //dump($v['finish']);
            //判断是否存在
            $isHas = M('archives_student_page')->where("archivesid={$v['archivesid']} and studentid={$v['studentid']} and pageid={$v['pageid']} and writen=2")->find();
            if (!$isHas){
                if (intval($v['finish'])){
                    $arr = array(
                        'archivesid'=>$v['archivesid'],
                        'studentid'=>$v['studentid'],
                        'pageid'=>$v['pageid'],
                        'writen'=>2,
                        'schedule'=>1
                    );
                    M('archives_student_page')->add($arr);
                }else{
                    $arr = array(
                        'archivesid'=>$v['archivesid'],
                        'studentid'=>$v['studentid'],
                        'pageid'=>$v['pageid'],
                        'writen'=>2,
                        'schedule'=>0
                    );
                    M('archives_student_page')->add($arr);
                }
            }else{
                $where['archivesid'] = $v['archivesid'];
                $where['studentid'] = $v['studentid'];
                $where['pageid'] = $v['pageid'];
                $where['writen'] = 2;
                //修改
                if (intval($v['finish'])){
                    M('archives_student_page')->where($where)->save(array('schedule'=>1));
                }else{
                    M('archives_student_page')->where($where)->save(array('schedule'=>0));
                }
            }
        }
        echo json_encode(array('status'=>200));
    }

    private function saveList($data) {
        foreach ($data as $k=>$v){
            $where['grade_id'] = $v['gid'];
            $where['archives_id'] = $v['aid'];
            $where['student_id'] = $v['sid'];
            $where['page_id'] = $v['pid'];
            $where['img_text_id'] = $v['id'];
            $arr = array(
                'type' => $v['type'],
                'content' => $v['content'],
            );
            $result = M('growth_temple_imgs_texts')->where($where)->save($arr);

        }
    }

    public function classPhoto()
    {
        $sid = I('sid');
        $gid = I('gid');
        $aid = I('aid');
        $cid = I('cid');

        if (!$_SESSION['schoolid']){
            $list = M('school_class')->where("id=$cid")->field("schoolid")->find();
            $schoolid = $list['schoolid'];
        }else{
            $schoolid = $_SESSION['schoolid'];
        }
        $where['s.schoolid'] = $schoolid;
        $where['s.gradeid'] = $gid;
        $where['s.archivesid'] = $aid;
        $where['s.classid'] = $cid;
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
        $newClass = array();
        foreach ($class as $k=>$v){
            $wheres['m.schoolid'] = $schoolid;
            $wheres['m.classid'] = $v['classid'];
            $wheres['m.type'] = 2;
            $list = M('microblog_main')
                ->alias('m')
                ->where($wheres)
                ->join("wxt_microblog_picture_url as u on u.microblogid=m.mid")
                ->field("count(u.id) as number")
                ->find();
            $newClass[$k]['cid'] = $v['classid'];
            $newClass[$k]['name'] = $v['classname'];
            $newClass[$k]['count'] = $list['number'];
        }
        //dump($newClass);
        $this->assign("class", $newClass);
        $this->assign('cid', $cid);
        $this->assign('sid', $sid);
        $this->assign('gid', $gid);
        $this->assign('aid', $aid);
        $this->display('class_photo');
    }

    //某个班级相册列表
    public function classPhotoList(){
        $name = I('classname');
        $sid = I('sid');
        $gid = I('gid');
        $aid = I('aid');
        $cid = I('cid');
        $classid = I('classid');
        if (!$_SESSION['schoolid']){
            $list = M('school_class')->where("id=$cid")->field("schoolid")->find();
            $schoolid = $list['schoolid'];
        }else{
            $schoolid = $_SESSION['schoolid'];
        }
        //获取当前班级的图片相册
        $wheres['m.schoolid'] = $schoolid;
        $wheres['m.classid'] = $classid;
        $wheres['m.type'] = 2;
        $list = M('microblog_main')
            ->alias('m')
            ->where($wheres)
            ->join("wxt_microblog_picture_url as u on u.microblogid=m.mid")
            ->field("pictureurl")
            ->select();


        $this->assign('pics', $list);
        $this->assign('cid', $cid);
        $this->assign('sid', $sid);
        $this->assign('gid', $gid);
        $this->assign('aid', $aid);
        $this->assign('class_name', $name);
        $this->display('class_photo_list');
    }

    public function personalPhoto()
    {
        $gid = I('gid');
        $aid = I('aid');
        $cid = I('cid');
        $sid = I('sid');
        $where['rsu.studentid'] = $sid;
        //dump($_SESSION['schoolid']);
        //dump($sid);
        //$where['m.schoolid'] = $_SESSION['schoolid'];
        // $where['m.type'] = 3;
        //$list = M()->query("select pu.pictureurl from wxt_microblog_picture_url as pu where pu.microblogid in (select m.mid from wxt_microblog_main as m where m.type=3 and m.userid in (select rsu.userid from wxt_relation_stu_user as rsu where rsu.studentid=$sid))");
        $list = M()->query("select pu.pictureurl from wxt_microblog_picture_url as pu where pu.microblogid in (select m.mid from wxt_microblog_main as m where m.type=3 and m.userid=$sid)");

        $this->assign('pics', $list);
        $this->assign('cid', $cid);
        $this->assign('sid', $sid);
        $this->assign('gid', $gid);
        $this->assign('aid', $aid);
        //获取相册
        $this->display('personal_photo');
    }

    public function getNowBabyPic(){
        $sid = I('sid');
        $where['rsu.studentid'] = $sid;
        //dump($_SESSION['schoolid']);
        //dump($sid);
        //$where['m.schoolid'] = $_SESSION['schoolid'];
        // $where['m.type'] = 3;
        //$list = M()->query("select pu.pictureurl from wxt_microblog_picture_url as pu where pu.microblogid in (select m.mid from wxt_microblog_main as m where m.type=3 and m.userid in (select rsu.userid from wxt_relation_stu_user as rsu where rsu.studentid=$sid))");
        $list = M()->query("select pu.pictureurl from wxt_microblog_picture_url as pu where pu.microblogid in (select m.mid from wxt_microblog_main as m where m.type=3 and m.userid=$sid)");
        echo json_encode(array('sid'=>$sid, 'img'=>$list));
    }
}

