<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;

//老师授权
class MonitorStudentWebController extends AdminbaseController{

    function _initialize() {
        parent::_initialize();
    }
//列表页
    function index(){
        if (IS_POST) {
            $keyword = I('keyword');
            $phone = I("phone");
               //dump($keyword);
//                $monitorInfo = M('monitor')
//                    ->alias("m")
//                    ->join("wxt_school as s on s.schoolid = m.schoolid")
//                    ->join("wxt_student_info as si on si.userid = m.classid")
//                    ->join("wxt_relation_stu_user rel ON rel.studentid=m.classid")
//                    ->where("m.type = 2 and si.stu_name like '%{$keyword}%' and m.resource = 2 and rel.type=1 and rel.phone '%{$phone}%'")
//                    ->field("si.userid as teacher_id,si.stu_name as name,s.school_name,s.schoolid,m.id as monitor_id,rel.phone")
//                    ->select();
            if($keyword)
            {
                $where['si.stu_name'] = array('like','%'.$keyword.'%');
            }
            if($phone)
            {
                $where['rel.phone'] = array('like','%'.$phone.'%');

            }
            $where['m.type'] = 2;
            $where['m.resource'] = 2;
            $where['rel.type'] = 1;
            $monitorInfo = M('monitor')
                ->alias("m")
                ->join("wxt_school as s on s.schoolid = m.schoolid")
                ->join("wxt_student_info as si on si.userid = m.classid")
                ->join("wxt_relation_stu_user rel ON rel.studentid=m.classid")
                ->where($where)
                ->field("si.userid as teacher_id,si.stu_name as name,s.school_name,s.schoolid,m.id as monitor_id,rel.phone,m.opening_time,m.opening_time_int")
                ->select();
                //var_dump($monitorInfo);exit;

        } else {

            //获取所有的授权列表
            $monitorInfo = M('monitor')
                ->alias("m")
                ->join("wxt_school as s on s.schoolid = m.schoolid")
                ->join("wxt_student_info as si on si.userid = m.classid")
                ->join("wxt_relation_stu_user rel ON rel.studentid=m.classid")
                ->where("m.type = 2 and m.resource = 2 and rel.type=1")
                ->field("si.name,s.school_name,s.schoolid,m.id as monitor_id,t.days")
                ->count();
            //var_dump($monitorInfo);
            //exit();
            $count = $monitorInfo;
            $page = $this->page($count, 15);
            $monitorInfo = M('monitor')
                ->alias("m")
                ->join("wxt_school as s on s.schoolid = m.schoolid")
//                ->join("wxt_monitor_channel_time as t on t.monitor_id = m.id")
                ->join("wxt_student_info as si on si.userid = m.classid")
                ->join("wxt_relation_stu_user rel ON rel.studentid=m.classid")
                ->where("m.type = 2 and m.resource = 2 and rel.type=1")
                ->limit($page->firstRow . ',' . $page->listRows)
                ->order('m.id desc')
                ->field("si.stu_name as name,s.school_name,s.schoolid,m.id as monitor_id,si.userid,rel.phone,m.opening_time,m.opening_time_int")
                ->select();
//            var_dump($monitorInfo);exit;
            $this->assign('page', $page->show('Admin'));
            //$newArr = $this->getSchoolInfoAndClassInfo($monitorInfo);
        }

        //存放等信息
        $newArr = array();
        //获取摄像头
//        foreach ($monitorInfo as $k => $v) {
//            $monitorChannel = M('monitor_channel')->where("monitor_id = {$v['monitor_id']} AND is_show = 1")->select();
//            //将获得的摄像头拼接成字符串
//            $str = '';
//            foreach ($monitorChannel as $i => $j) {
//                if ($j['type'] == 1){
//                    if ($j['status'] == 1){
//                        $str .= $j['nname'] . '--海康(在线)、';
//                    }else{
//                        $str .= $j['nname'] . '--海康(离线)、';
//                    }
//
//                }elseif ($j['type'] == 2){
//                    if ($j['status'] == 1){
//                        $str .= $j['nname'] . '--大华(在线)、';
//                    }else{
//                        $str .= $j['nname'] . '--大华(离线)、';
//                    }
//                }
//            }
//            if (!empty($v['start_time'])){
//                $monitorInfo[$k]['time'] = $v['start_time'].'-'.$v['end_time'];
//            }
//            $monitorInfo[$k]['day'] = $v['days'];
//            $monitorInfo[$k]['monitor_nname'] = trim($str, '、');
//        }
        //var_dump($monitorInfo);exit;
        $this->assign('lists', $monitorInfo);
        $this->display();
    }

    private function get_time($time,$type,$date_time)
    {
        if($type==1)
        {
            $now = date('Y-m-d H:i:s',$date_time);
        }else{
            $now = date('Y-m-d H:i:s',time());
        }

        switch ($time) {
                //如果为星期一 将该老师为星期一的排班取出 下面以此类推
                case '一个月':
                    //班次ID
                  $open_time = date("Y-m-d H:i:s",strtotime("+1months",strtotime($now)));
                    break;
                case '两个月':
                    $open_time = date("Y-m-d H:i:s",strtotime("+2months",strtotime($now)));
                    break;
                case '三个月':
                    $open_time = date("Y-m-d H:i:s",strtotime("+3months",strtotime($now)));

                    break;
                case '四个月':
                    $open_time = date("Y-m-d H:i:s",strtotime("+4months",strtotime($now)));

                    break;
                case '五个月':
                    $open_time = date("Y-m-d H:i:s",strtotime("+5months",strtotime($now)));

                    break;
                case '半年':
                    $open_time = date("Y-m-d H:i:s",strtotime("+6months",strtotime($now)));

                    break;
                //星期天会时间戳会转换成0
                case '一年':
                    $open_time = date("Y-m-d H:i:s",strtotime("+1years",strtotime($now)));

                    break;

            }

            return $open_time;

    }

    //添加页
    function add(){
        //获取所有的学校
        $school = M('school')->field("schoolid, school_name")->select();

        $this->assign('school', $school);
        $this->display();
    }

    function add_post(){
        if(IS_POST){
            //var_dump($_POST);exit;
//            $isTypeOne = isset($_POST['id_1']) ? I('id_1') : '';
//            $isTypeTwo = isset($_POST['id_2']) ? I('id_2') : '';
//
//            if (empty($isTypeOne) && empty($isTypeTwo)){
//                die("请选择视频摄像头");
//            }
            //$type = I('type');
            $time = $this->get_time($_POST['time']);

            $data['schoolid'] = $_POST['school'];
            $camaro = M('monitor_live')->where("school_id = {$data['schoolid']}")->field("usermanage_id")->find();
            if(!$camaro)
            {
                $this->error("该学校为配置摄像头!");
            }
            $data['usermanage_id'] = $camaro['usermanage_id'];
            $data['type'] = 2;
            $data['resource'] = 2;
            $data['opening_time'] = $time;
            $data['opening_time_int'] = strtotime($time);
            $data['create_time'] = time();

            foreach ($_POST['student'] as $v) {
                $data['classid'] = $v;
                //var_dump($data);exit;
                $existence=M("monitor")->where("classid='$v' and resource=2")->field(id)->find();
                if($existence[id]){
                    $result = $existence[id];
                    $isadd=0;
                }else{
                    $result = M("monitor")->add($data);
                    $biaozhi=1;
                    $isadd=1;
                }

                if (!$result) {
                    die("添加失败");
                }


            }
            if ($result) {
                $this->success("添加成功！", U('index'));
            } else {
                die("添加失败");
            }
        }
    }
    //插入视频数据
    private function insertMonitorChannel($id, $value, $type, $isadd)
    {
        if($isadd){
            //添加摄像头信息
            for ($i = 0; $i < count($value); $i++) {
                $info = M('monitor_live')->where("id = {$value[$i]}")->find();
                $arr = array(
                    'channelNo' => $info['channelno'],
                    'channelName' => $info['channelname'],
                    'deviceSerial' => $info['deviceserial'],
                    'monitor_id' => $id,
                    'nname' => $info['nname'],
                    'status' => $info['status'],
                    'status' => $info['status'],
                    'type' => $type,
                    'ability' => $info['ability'],
                    'video_id' => $info['id'],
                    'usermanage_id'=>$info['usermanage_id'],
                    'img'=>$info['img']
                );
                $insert = M('monitor_channel')->add($arr);
            }
        }else{
            for ($i = 0; $i < count($value); $i++) {
                $info = M('monitor_live')->where("id = {$value[$i]}")->find();
                $isexis=M('monitor_channel')->where("monitor_id = '$id' and video_id='$info[id]' ")->find();
                if(!$isexis) {
                    $arr = array(
                        'channelNo' => $info['channelno'],
                        'channelName' => $info['channelname'],
                        'deviceSerial' => $info['deviceserial'],
                        'monitor_id' => $id,
                        'nname' => $info['nname'],
                        'status' => $info['status'],
                        'type' => $type,
                        'ability' => $info['ability'],
                        'video_id' => $info['id'],
                        'usermanage_id' => $info['usermanage_id'],
                        'img' => $info['img']
                    );
                    $insert = M('monitor_channel')->add($arr);
                }
            }
        }
    }

    //续费
    public function look(){
        $id=I("get.id");
        //获取当前ID的视频数据
        $monitor = M('monitor')->where("id = $id and type=2 and resource = 2")->field('schoolid, id')->find();

        if (!$monitor) {
            $this->error("获取失败");
        }

        //var_dump($yingShi);
        //$this->assign('channelInfo', $channelInfo);
        $this->assign('leCheng', $leCheng);
        $this->assign('yingShi', $yingShi);
        $this->assign('monitor_id', $id);
        $this->display();
    }

    //修改权限post
    function look_post(){
        if (IS_POST) {

            $mid = I('monitor_id');

            $month = I("time");
            $monitorid = M("monitor")->where(array("id"=>$mid))->find();
            if($monitorid) {
                //如果该用户的时间小于当前时间,则直接按当前时间计算
                if (time() > $monitorid['opening_time_int']) {
                    $now = time();
                } else {
                    $now = $monitorid['opening_time_int'];
                }
                $opening_time = $this->get_time($month, 1, $now);


                //如果存在的话，将续费
                M("monitor")->where(array("id" => $monitorid['id']))->save(array("opening_time" => $opening_time, "opening_time_int" => strtotime($opening_time)));
            }

            $this->success("续费成功", U('index'));
            exit;
        }

    }

    //修改时间
    public function editTime()
    {
        $id = I('id');
        //获取该权限的时间
        $info = M('monitor_channel_time')->where("monitor_id = $id")->find();
        $timeInfo = array();
        $timeInfo['start_time'] = $info['start_time'];
        $timeInfo['end_time'] = $info['end_time'];
        $arr = explode('-', $info['days']);
        $days = array();
        for ($i = 1; $i < 8; $i++) {
            if (in_array($i, $arr)) {
                $days[] = $i;
            } else {
                $days[] = 0;
            }
        }
        $timeInfo['days'] = $days;
        $this->assign('timeInfo', $timeInfo);
        $this->assign('monitor_id', $id);
        $this->display('edit_time');
    }
    //修改时间post
    public function editTime_post()
    {
        //获取参数
        $id = I('monitor_id');
        $days = implode('-', I('days'));
        $start_time = I('start_time');
        $end_time = I('end_time');
        $array = array(
            'start_time' => $start_time,
            'end_time' => $end_time,
            'days' => $days
        );
        $update = M('monitor_channel_time')->where("monitor_id = $id")->save($array);
        if ($update) {
            $this->success('修改开放时间成功', U('index'));
        } else {
            $this->error("修改开放时间失败");
        }
        exit();
    }


    /**
     *  删除
     */
    function delete(){
        $id = I('id');
        $deleteResult = M('monitor')->where("id = $id")->delete();
        M('monitor_channel')->where("monitor_id = $id")->delete();
        M('monitor_channel_time')->where("monitor_id = $id")->delete();

        if ($deleteResult) {
            $this->success("删除老师授权成功！");
        } else {
            die("删除老师授权失败！");
        }
    }

    //获取该学校的班级所有学生
    public function getStudent()
    {
        $schoolId = I('schoolid');
        $classid = I("classid");

        $student = M('student_info')
            ->where("schoollid = $schoolId and classid = $classid")
            ->field("userid as id,stu_name as name")
            ->select();
        //$teachers = M()->query("select i.id, i.name from wxt_wxtuser as w where w.id IN (select teacherid from wxt_teacher_info as i where i.schoolid=$schoolId)");
        echo json_encode($student);
    }

    //根据学校ID获取摄像头
    public function getVideoBySchoolId(){
        $schoolId = I('id');
        //根据学校ID获取所有的摄像头
        $camaro = M('monitor_live')->where("school_id = $schoolId")->select();
        $leCheng = array();
        $yingShi = array();
        $count = 0;
        $num = 0;
        foreach ($camaro as $k => $v) {
            if ($v['type'] == 1) {
                $yingShi[$count]['id'] = $v['id'];
                $yingShi[$count]['type'] = $v['type'];
                $yingShi[$count]['nname'] = $v['nname'];
                $count++;
            } else {
                $leCheng[$num]['id'] = $v['id'];
                $leCheng[$num]['type'] = $v['type'];
                $leCheng[$num]['nname'] = $v['nname'];
                $num++;
            }
        }
        $html = '';
        //判断是否为空
        if(!empty($yingShi)){
            $html .= '<div style="width: 100%;text-align: left;float: left">萤石视频</div>';
            foreach($yingShi as $k=>$v){
                $html.='<div class="control-group imgWrapPart"><p>';
                $html .= '<label style="float: left;margin: 5px 15px 0 0;">';
                $html .= '<input type="checkbox" class="isMyChecked" name="id_'.$v['type'].'[]" value="'.$v['id'].'"></input>'.$v['nname'];
                $html .= '</label></p></div>';
            }
        }
        if(!empty($leCheng)){
            $html .= '<div style="width: 100%;text-align: left;float: left">乐橙视频</div>';
            foreach($leCheng as $k=>$v){
                $html.='<div class="control-group imgWrapPart"><p>';
                $html .= '<label style="float: left;margin: 5px 15px 0 0;">';
                $html .= '<input type="checkbox" class="isMyChecked" name="id_'.$v['type'].'[]" value="'.$v['id'].'"></input>'.$v['nname'];
                $html .= '</label></p></div>';
            }
        }
        echo $html;
    }

    public function tolead()
    {
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


    public function monitor_post(){


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

            foreach ($ExamPaper_arr as $key => $value)
            {
                //循环数据检测A=>学校名字，B=>学生姓名，C=>班级，D=>监护人姓名，E=>家长联系方式，I=>关系, M=>性别，N=>学号，O=>IC卡号，P=>是否住校
                //如果题号或者题干不为空
                if($value['A']!=null&&$value['B']!=null&&$value['C']!=null&&$value['D']!=null){
                    $name=$value['B'];
                    // var_dump($name);
                    $classname=$value['C'];
                    $month = $value['D'];
                   

                    $result=$this->importmonitor(trim($schoolid),trim($name),trim($classname),trim($month));

                    /**
                     * 导入教师以及关系数据到数据库
                     * return 0 必填字段获取失败
                     * return 1 成功
                     * return 2 班级不存在
                     * return 3 学生不存在
                     * return 4 该学校没有摄像头
                     * return 5 学生续费成功
                     */
                    if($result ==1){
                        $successcount++;
                    }else if($result ==2){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"班级不存在"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==3){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"学生不存在!"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==4){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"该学校没有摄像头"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==5){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"学生续费成功"
                        );
                        array_push($error_info,$error_item);
                        $successcount++;
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
        $info='::其中成功'.$successcount.'人,'.$emptyData;


        $this->success('导入完成','tolead/successcount/'.$successcount.'/allcount/'.$allcount.'/info/ok::'.$info);
    }
    private function importmonitor($schoolid,$name,$classname,$month)
    {
        $result = 1;
          //先查询出该班级
        $classid = M("school_class")->where(array("schoolid"=>$schoolid,"classname"=>$classname))->getField("id");
        if(!$classid)
        {
            $result = 2;
            return $result;
        }
        //查询出学生是否存在
        $student = M("student_info")->where(array("stu_name"=>$name,"classid"=>$classid))->find();
        if(!$student)
        {
            $result = 3;
            return $result;
        }
        //查询该学校是否有摄像头
        $camaro = M('monitor_live')->where("school_id = $schoolid")->field("usermanage_id")->find();
        if(!$camaro)
        {
            $result = 4;
            return $result;
        }
        //查询该学生是否已经授权
        $monitorid = M("monitor")->where(array("schoolid"=>$schoolid,"classid"=>$student['userid'],"type"=>2,"resource"=>2))->find();
        if($monitorid)
        {
            //如果该用户的时间小于当前时间,则直接按当前时间计算
            if(time() > $monitorid['opening_time_int'])
            {
                $now = time();
            }else{
                $now = $monitorid['opening_time_int'];
            }
            $opening_time = $this->get_time($month,1,$now);


            //如果存在的话，将续费
            M("monitor")->where(array("id"=>$monitorid['id']))->save(array("opening_time"=>$opening_time,"opening_time_int"=>strtotime($opening_time)));
           $result = 5;
        }else{
            //如果不存在的话添加一条记录
            $data['schoolid'] = $schoolid;
            $data['classid'] = $student['userid'];
            $data['usermanage_id'] = $camaro['usermanage_id'];
            $data['type'] = 2;
            $data['resource'] = 2;
            $data['opening_time'] = $this->get_time($month);
            $data['opening_time_int'] = strtotime($this->get_time($month));
            $data['create_time'] = time();

            M("monitor")->add($data);
        }

      return $result;

    }



    private  function FetchRepeatMemberInArray($array) {
        // 获取去掉重复数据的数组
        $unique_arr = array_unique ( $array );
        // 获取重复数据的数组
        $repeat_arr = array_diff_assoc ( $array, $unique_arr );
        return $repeat_arr;
    }


}