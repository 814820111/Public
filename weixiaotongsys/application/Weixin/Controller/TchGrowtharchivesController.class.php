<?php

namespace Weixin\Controller;

use Common\Controller\WeixinbaseController;

session_start();
header("Content-type:text/html;charset=utf-8");

class TchGrowtharchivesController extends WeixinbaseController
{
    function index()
    {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        //1 根据 老师的班级 找到 年级 通过年级 找到 书本
        $teacherid = $_SESSION['userid'];
        $schoolid = $_SESSION['schoolid'];
        $result = M("teacher_class as a")
            ->join("wxt_school_class as b on a.classid=b.id")
            ->join("wxt_school_grade as c on c.gradeid=b.grade")
            ->join("wxt_archives_grade as d on c.gradeid=d.gradeid")
            ->join("wxt_archives as e on d.archivesid=e.id")
            ->join("wxt_semester as f on e.semesterid=f.id")
            ->where("a.teacherid = $teacherid and a.schoolid = $schoolid and c.schoolid = $schoolid and e.schoolid=$schoolid")
            ->field("d.archivesid,d.gradeid,e.name as aname,c.name as gname,d.name as bookname,f.semester,d.create_time")
            ->order('f.id asc')
            ->select();
        $this->assign("alist", $result);
        $this->display();
    }

    public function details()
    {
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

        $result = array();
        //对重复数据进行处理
        if (count($array) > 0) {
            for ($i = 0; $i < count($array); $i++) {
                $source = $array[$i];
                if (array_search($source, $array) == $i && $source <> "") {
                    $result[] = $source;
                }
            }
        }

        $this->assign("list", $result);
        $this->display();

    }

    public function stuList()
    {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        //找到学生 信息 已经学生完成的页数情况
        $archivesid = I('aid');
        $gradeid = I('gid');
        $classid = I('classid');
        $array = M('archives_student as a')
            ->join("wxt_wxtuser as b on a.studentid = b.id")
            ->join("wxt_student_info as student on student.userid = b.id")
            ->where("a.archivesid = $archivesid and a.gradeid = $gradeid and a.classid = $classid")
            ->field("student.stu_name as name,b.photo,a.gradeid,a.studentid,a.archivesid,a.classid")
            ->select();
//        print_r($array);
        foreach ($array as $key => &$value) {

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
            //$par_sum = M('archives_page')->where($where_par)->count();
            $par_sum = M('archives_student_page')->where($where_par)->count();

            //查出该档案的总页数
            $archives_detail = M('archives_book')->where("archivesid = $archivesid and gradeid = $gradeid")->field("count(1) as sum")->group('writer')->select();
            //查出该学生下完成进度

            if (!$archives_detail[0]['sum']) {
                $archives_detail[0]['sum'] = 0;
            }


            if (!$archives_detail[1]['sum']) {
                $archives_detail[1]['sum'] = 0;
            }
            $value['tea_sum'] = $tea_sum . '/' . $archives_detail[0]['sum'];
            $value['par_sum'] = $par_sum . '/' . $archives_detail[1]['sum'];

        }
//        echo "<pre>";
//        print_r($array);
        $this->assign('aid', $archivesid);
        $this->assign('gid', $gradeid);
        $this->assign("stulist", $array);
        $this->display();
    }

    //班级列表
    public function classList()
    {
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

        $result = array();
        //对重复数据进行处理
        if (count($array) > 0) {
            for ($i = 0; $i < count($array); $i++) {
                $source = $array[$i];
                if (array_search($source, $array) == $i && $source <> "") {
                    $result[] = $source;
                }
            }
        }
        $this->assign("list", $result);
        $this->display();

    }

    //家长进度
    public function parentSchedule()
    {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        //找到学生 信息 已经学生完成的页数情况
        $archivesid = I('aid');
        $gradeid = I('gid');
        $classid = I('classid');
        $array = M('archives_student as a')
            ->join("wxt_wxtuser as b on a.studentid = b.id")
            ->join("wxt_student_info as student on student.userid = b.id")
            ->where("a.archivesid = $archivesid and a.gradeid = $gradeid and a.classid = $classid")
            ->field("student.stu_name as name,b.photo,a.gradeid,a.studentid,a.archivesid")
            ->select();
//        print_r($array);
        foreach ($array as $key => &$value) {

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


            if (!$archives_detail[1]['sum']) {
                $archives_detail[1]['sum'] = 0;
            }
//            $value['tea_sum'] = $tea_sum.'/'.$archives_detail[0]['sum'];
            $value['par_sum'] = $par_sum . '/' . $archives_detail[1]['sum'];

        }
//        print_r($array);
        $this->assign("parentlist", $array);
        $this->display();
    }

    //参数获取(状态，原因)
    function format_ret($status, $data = '')
    {
        if ($status) {
            //成功
            return array('status' => 'success', 'data' => $data);
        } else {
            //验证失败
            return array('status' => 'error', 'data' => $data);
        }
    }

    //成长档案
    function Growtharchives()
    {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname", $stu_sch_name);
        $teacherid = $_SESSION['userid'];
        $this->assign("teacherid", $teacherid);

        $this->display();
    }

    //好友成长日记
    public function GrowthDiary()
    {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname", $stu_sch_name);
        $userid = $_SESSION["userid"];
        $this->assign("userid", $userid);
        $studentid = $_SESSION['studentid'];
        $info = M("wxtuser")->where(array("id" => $userid))->find();//查找自己的信息
        $this->assign("username", $info['name']);//自己的姓名

        //获取学生姓名
        $stu_info = M("wxtuser")->where(array("id" => $studentid))->find();
        $this->assign("name", $stu_info['name']);
        $this->assign("classid", $_SESSION['classid']);
        $this->assign("schoolid", $_SESSION['schoolid']);
        $sid = I('sid');//好友学生id
        $this->assign("studentid", $sid);
        $this->display("Growthdiary");
    }

    //
    public function studentPage()
    {
        $cid = I('cid');
        $sid = I('sid');
        $gid = I('gid');
        $aid = I('aid');

        $img = isset($_GET['img']) ? I('img') : '';
        if ($img) {
            $this->assign('selectImg', $img);
        }
        $id = isset($_GET['id']) ? I('id') : '';
        if ($img) {
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
        $where['ap.writen'] = 1;
        $list = M('growth_student_temple')
            ->alias("st")
            ->where($where)
            ->join("wxt_archives_page ap on st.page_id = ap.id")
            ->join("wxt_temple_page tp on tp.id = ap.temple_id")
            //->join("wxt_temple_imgs_texts as tit on tit.temple_id = tp.id")
            ->field("st.id as st_id, st.page_id, tp.*, ap.*")
           // ->order("ap.writen asc")
            ->select();
        //dump($list);
        $nums = 0;
        foreach ($list as $k => $v) {
//            if ($v['img_count'] == 0 && $v['text_count'] == 0) {
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
                if ($vs['type'] == 0) {
                    $content[$num]['text'] = $vs['content'];
                } else {
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


    public function showstudentPage()
    {
        $cid = I('cid');
        $sid = I('sid');
        $gid = I('gid');
        $aid = I('aid');

        $img = isset($_GET['img']) ? I('img') : '';
        if ($img) {
            $this->assign('selectImg', $img);
        }
        $id = isset($_GET['id']) ? I('id') : '';
        if ($img) {
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
        $this->display('show_student_page');
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
//        $where['ap.writen'] = 1;
        $list = M('growth_student_temple')
            ->alias("st")
            ->where($where)
            ->join("wxt_archives_page ap on st.page_id = ap.id")
            ->join("wxt_temple_page tp on tp.id = ap.temple_id")
            //->join("wxt_temple_imgs_texts as tit on tit.temple_id = tp.id")
            ->field("st.id as st_id, st.page_id, tp.*, ap.*")
            // ->order("ap.writen asc")
            ->select();
        //dump($list);
        $nums = 0;
        foreach ($list as $k => $v) {
//            if ($v['img_count'] == 0 && $v['text_count'] == 0) {
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
                if ($vs['type'] == 0) {
                    $content[$num]['text'] = $vs['content'];
                } else {
                    $content[$num]['img'] = $vs['content'];
                }
                $content[$num]['width'] = $vs['width'];
                $content[$num]['height'] = $vs['height'];
                $content[$num]['top'] = $vs['top'];
                $content[$num]['left'] = $vs['left'];
                $content[$num]['type'] = $vs['type'];
                $num++;
//
            }

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

    //点击图片上传
    public function upload()
    {
        $returns = array();
        //dump($_FILES);
        // 允许上传的图片后缀
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = strtolower(end($temp));     // 获取文件后缀名
        $img_name = time() . '.' . $extension;
        // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
        $result = move_uploaded_file($_FILES["file"]["tmp_name"], "./uploads/growth/" . $img_name);
        if ($result) {
            //R('Apps/index/resizeImage', array("imgSrc" => "./uploads/growth/" . $img_name, "maxwidth" => $_POST['width'], "maxheight" => $_POST['height'], "filetype" => $extension));
            $this->resizeImageAndAuto("./uploads/growth/" . $img_name, $_POST['width'], $_POST['height'], $extension);
            $returns['img'] = $img_name;
        }
        //dump(SR.$img_name);
        //$this->rotate(SR.$img_name);
        //echo "文件存储在: " . "upload/" . $_FILES["file"]["name"];
        echo json_encode($returns);
        exit();
    }

    //图片旋转问题
    public function rotate($source_file){
        $data = imagecreatefromstring(file_get_contents($source_file));
        $exif = exif_read_data($source_file);
        // exif信息头, 包含了照片的基本信息, 包括拍摄时间, 颜色, 宽高, 方向
        if(!empty($exif['Orientation'])) {
            switch($exif['Orientation']){
                case 8:
                    $data = imagerotate($data, 90, 0);
                    break;
                case 3:
                    $data = imagerotate($data, 180, 0);
                    break;
                case 6:
                    $data = imagerotate($data, -90, 0);
                    break;
            }
        }
        imagejpeg($data, $source_file);
    }

    /** 图片等比例压缩+自适应屏幕高宽
     * @param string $imgSrc 原图路径
     * @param int $maxwidth 设置屏幕宽度
     * @param int $maxheight 设置屏幕高度
     * @param string $filetype 图片类型
     */
    function resizeImageAndAuto($imgSrc, $maxwidth, $maxheight, $filetype)
    {
        //初始化图象
        if ($filetype == "jpg" || $filetype == "jpeg") {
            $im = imagecreatefromjpeg($imgSrc);
        }
        if ($filetype == "gif") {
            $im = imagecreatefromgif($imgSrc);
        }
        if ($filetype == "png") {
            $im = imagecreatefrompng($imgSrc);
        }

        //目标图象地址
        $name = end(explode("/", $imgSrc));
        $route = "/data/wwwroot/mp.zhixiaoyuan.net/uploads/growthub/" . $name;//压缩图片的位置
        $windowscale = $maxheight / $maxwidth;//屏幕高宽比

        $pic_width = imagesx($im);
        $pic_height = imagesy($im);
        $originalScale = $pic_height / $pic_width;

        if ($originalScale < $windowscale) {//图片高宽比小于屏幕高宽比
            //图片缩放后的宽为屏幕宽
            $imageWidth = $maxwidth;
            $imageHeight = ($maxwidth * $pic_height) / $pic_width;
        } else {//图片高宽比大于屏幕高宽比
            //图片缩放后的高为屏幕高
            //imageSize.imageHeight = windowHeight;
            //imageSize.imageWidth = (windowHeight * originalWidth) / originalHeight;
            $imageHeight = $maxheight;
            $imageWidth = ($maxheight * $pic_width) / $maxheight;
        }
        $newwidth = $imageWidth;
        $newheight = $imageHeight;
        if (function_exists("imagecopyresampled")) {
            $newim = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);//图像边缘比较平滑.质量较好(但速度比 ImageCopyResized() 慢
        } else {
            $newim = imagecreate($newwidth, $newheight);
            imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);//在所有GD版本中有效,缩放图像的算法比较粗糙
        }
        imagejpeg($newim, $route);
        imagedestroy($newim);
    }

    //图片上传保存
    public function save()
    {
        $img = I('img');
        $text = I('text');
        if ($img) {
            $this->saveList($img);
        }
        if ($text) {
            $this->saveList($text);
        }
        $is_finish = I('isFinish');
        foreach ($is_finish as $k => $v) {
            //dump($v['finish']);
            //判断是否存在
            $isHas = M('archives_student_page')->where("archivesid={$v['archivesid']} and studentid={$v['studentid']} and pageid={$v['pageid']} and writen=1")->find();
            if (!$isHas) {
                if (intval($v['finish'])) {
                    $arr = array(
                        'archivesid' => $v['archivesid'],
                        'studentid' => $v['studentid'],
                        'pageid' => $v['pageid'],
                        'writen' => 1,
                        'schedule' => 1
                    );
                    M('archives_student_page')->add($arr);
                } else {
                    $arr = array(
                        'archivesid' => $v['archivesid'],
                        'studentid' => $v['studentid'],
                        'pageid' => $v['pageid'],
                        'writen' => 1,
                        'schedule' => 0
                    );
                    M('archives_student_page')->add($arr);
                }
            } else {
                $where['archivesid'] = $v['archivesid'];
                $where['studentid'] = $v['studentid'];
                $where['pageid'] = $v['pageid'];
                $where['writen'] = 1;
                //修改
                if (intval($v['finish'])) {
                    M('archives_student_page')->where($where)->save(array('schedule' => 1));
                } else {
                    M('archives_student_page')->where($where)->save(array('schedule' => 0));
                }
            }
        }
        echo json_encode(array('status' => 200));
    }

    private function saveList($data)
    {
        foreach ($data as $k => $v) {
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

        if (!$_SESSION['schoolid']) {
            $list = M('school_class')->where("id=$cid")->field("schoolid")->find();
            $schoolid = $list['schoolid'];
        } else {
            $schoolid = $_SESSION['schoolid'];
        }
        $where['s.schoolid'] = $schoolid;
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
        $newClass = array();
        foreach ($class as $k => $v) {
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
    public function classPhotoList()
    {
        $name = I('classname');
        $sid = I('sid');
        $gid = I('gid');
        $aid = I('aid');
        $cid = I('cid');
        $classid = I('classid');
        if (!$_SESSION['schoolid']) {
            $list = M('school_class')->where("id=$cid")->field("schoolid")->find();
            $schoolid = $list['schoolid'];
        } else {
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
        $sid = I('sid');
        $gid = I('gid');
        $aid = I('aid');
        $cid = I('cid');
        if (!$_SESSION['schoolid']) {
            $list = M('school_class')->where("id=$cid")->field("schoolid")->find();
            $schoolid = $list['schoolid'];
        } else {
            $schoolid = $_SESSION['schoolid'];
        }
        $where['a.archivesid'] = $aid;
        $where['a.schoolid'] = $schoolid;
        $where['a.gradeid'] = $gid;
        $where['a.classid'] = $cid;
        $where['a.send'] = 1;
        $list = M('archives_student')
            ->alias("a")
            ->where($where)
            ->order('a.classid')
            ->join("wxt_school_class c ON c.id = a.classid ")
            ->join("wxt_student_info s ON s.userid = a.studentid")
//            ->join("wxt_relation_stu_user f ON f.studentid = a.studentid")
//            ->field("a.studentid, a.archivesid, a.gradeid,s.stu_name, c.id, a.schoolid,f.userid")
            ->field("a.studentid, a.archivesid, a.gradeid,s.stu_name, c.id, a.schoolid")
            ->select();
        $newList = array();
        foreach ($list as $k => $v) {
            $wheres['m.schoolid'] = $v['schoolid'];
            $wheres['m.classid'] = $v['id'];
//            $wheres['m.userid'] = $v['userid'];
            $wheres['m.userid'] = $v['studentid'];
            $wheres['m.type'] = 3;
            $list = M('microblog_main')
                ->alias('m')
                ->where($wheres)
                //->select();
                ->join("wxt_microblog_picture_url as u on u.microblogid=m.mid")
                ->field("count(u.id) as number")
                ->find();
            //dump($list);
            $newList[$k]['studentid'] = $v['studentid'];
            $newList[$k]['stu_name'] = $v['stu_name'];
            $newList[$k]['count'] = $list['number'];
        }
        //dump($newList);
        $this->assign('students', $newList);
        $this->assign('cid', $cid);
        $this->assign('sid', $sid);
        $this->assign('gid', $gid);
        $this->assign('aid', $aid);
        //获取相册
        $this->display('personal_photo');
    }

    public function getNowBabyPic()
    {
        $sid = I('sid');
        $where['rsu.studentid'] = $sid;
        //dump($_SESSION['schoolid']);
        //dump($sid);
        //$where['m.schoolid'] = $_SESSION['schoolid'];
        // $where['m.type'] = 3;
        //$list = M()->query("select pu.pictureurl from wxt_microblog_picture_url as pu where pu.microblogid in (select m.mid from wxt_microblog_main as m where m.type=3 and m.userid in (select rsu.userid from wxt_relation_stu_user as rsu where rsu.studentid=$sid))");
        $list = M()->query("select pu.pictureurl from wxt_microblog_picture_url as pu where pu.microblogid in (select m.mid from wxt_microblog_main as m where m.type=3 and m.userid=$sid)");
        echo json_encode(array('sid' => $sid, 'img' => $list));
    }
}

