<?php

/**
 * 宿舍管理
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class DormitoryController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();
        $this->schoolid=$_SESSION['schoolid'];
        if(empty( $this->schoolid)){
            $this->error("未获取到学校，请重新登录");
            exit;
        }
    }

    public function index(){

    }
    //楼栋管理页面
    public function dormitory_buildlist(){

        $where['schoolid'] = $this->schoolid;
        $buildno = I("buildno");
        $buildname = I("buildname");
        $sex = I("sex");
        if($buildno){
            $where['buildno'] = $buildno;
            $this->assign("buildno",$buildno);
        }
        if($buildname){
            $where['buildname'] = $buildname;
            $this->assign("buildname",$buildname);
        }
        if($sex){
            $where['buildsex'] = $sex;
            $this->assign("buildsex",$sex);
        }

        $count = M("DormitoryBuild")->where($where)->count();
        $page = $this->page($count, 20);
        $build = M("DormitoryBuild")->where($where) ->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($build as &$value){
            if($value['managerid']){
                $manager = M("DormitoryManager")->where("id = $value[managerid]")->find();
                $value[managername]=$manager[name];
                $value[managerphone]=$manager[phone];
            }
        }
        $this->assign("build",$build);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //添加楼栋页面
    public function dormitory_add_buildlist(){
        $this->display();
        exit;
    }
    //添加楼栋提交
    public function dormitory_add_post_buildlist()
    {

        $data = I("data");

        $code = $data["code"];
        $buildsex = $data["buildSex"];
        $zeroExist = $data["zeroExist"];
        $buildname = $data["name"];
        $floornum = $data["floorNum"];
        $startfloor = $data["startFloor"];
        $remark = $data["remark"];
        if(empty( $code) || empty( $buildname) || empty( $floornum)){
            $ret = $this->format_ret(0,"获取必要参数失败，请重试");
            echo json_encode($ret);
            exit;
        }
        $selectbuild=M("DormitoryBuild")->where("schoolid='$this->schoolid' and buildname = '$buildname' and buildno='$code'")->find();
        if(!empty($selectbuild)){
            $ret = $this->format_ret(0,"请勿重复提交");
            echo json_encode($ret);
            exit;
        }
        $datas["buildno"]= $code;
        $datas["schoolid"]= $this->schoolid;
        $datas["buildname"]= $buildname;
        $datas["buildsex"]= $buildsex;
        $datas["floornum"]= $floornum;
        $datas["is_zero"]= $zeroExist;
        $datas["startfloor"]= $startfloor;
        $datas["remake"]= $remark;
        $datas["addtime"]= date('Y-m-d H:i:s', time());
        $buildid = M("DormitoryBuild")->add($datas);
        unset($datas);
        if(!$buildid){
            $ret = $this->format_ret(0,"添加到数据库失败");
            echo json_encode($ret);
            exit;
        }
        $i=0;
        for($i=1;$i<=$floornum;$i++) {
            $floor = $startfloor+$i-1;
            if($floor==0 && !$zeroExist){
                $floor = $floor+1;
                $floornum = $floornum+1;
            }

            $roomnum = $data["dormitoryNum".$i];
            $bednum = $data["bedNum".$i];
            $money =$data["charge".$i];
            $sex=$data["sex".$i];
            $datas["buildid"]=$buildid;
            $datas["floor"]=$floor;
            $datas["money"]=$money;
            $datas["sex"]=$sex;
            $datas["bednum"]=$bednum;
            $floorid = M("DormitoryFloor")->add($datas);
            unset($datas);
            $j=0;
            for($j=1;$j<=$roomnum;$j++){
                if($j<10){
                    $roomname='0'.$j;
                }else{
                    $roomname=$j;
                }
                $datas['schoolid'] = $this->schoolid;
                $datas['buildid'] = $buildid;
                $datas['floorid'] = $floorid;
                $datas['bednum'] = $bednum;
                $datas['nowbednum'] = 0;
                $datas['roomno'] = $floor.$roomname;
                $datas['roomname'] = $floor.$roomname;
                $datas['money'] = $money;
                $datas['sex'] = $sex;
                $roomid = M("DormitoryRoom")->add($datas);
                unset($datas);
                $k=0;
                for($k=1;$k<=$bednum;$k++){
                    $datas['schoolid'] = $this->schoolid;
                    $datas['roomid'] = $roomid;
                    $datas['bedname'] = $k;
                    $bedid = M("DormitoryBed")->add($datas);
                    unset($datas);
                }
            }
        }
        if(!empty($buildid)){
            $ret = $this->format_ret(1,'success');
        }else{
            $ret = $this->format_ret(0,"添加楼栋失败");
        }
        echo json_encode($ret);
        exit;
    }
    //修改楼栋页面
    public function dormitory_edit_buildlist()
    {
        $this->display();
        exit;
    }
    //修改楼栋页面提交
    public function dormitory_edit_post_buildlist()
    {

        $name = I("name");
        $remake = I("remake");
        $id = I("id");
        if(empty($name) ||  empty($id)){
            $ret = $this->format_ret(0,"未获取到数据，请重试");
            echo json_encode($ret);
            exit;
        }

        $where['buildname'] = $name;
        $where['remake'] = $remake;
        $build=M("DormitoryBuild")->where("schoolid = '$this->schoolid' and buildname = '$name'")->find();
        if(!empty($build)){
            $ret = $this->format_ret(0,"修改失败，已存在重复名称");
            echo json_encode($ret);
            exit;
        }

        M("DormitoryBuild")->where("schoolid = '$this->schoolid' and id = $id")->save($where);

        $ret = $this->format_ret(1,'修改成功');

        echo json_encode($ret);
        exit;
    }
    //检查楼栋编号是否已存在
    public function dormitory_buildlist_exisno(){
        $code=I("code");
        $excode = M("DormitoryBuild")->where("schoolid = '$this->schoolid' and buildno = '$code'")->find();
        if(empty($excode)){
            $ret = $this->format_ret(1,'success');
        }else{
            $ret = $this->format_ret(0,"楼栋编号已存在");
        }
        echo json_encode($ret);
        exit;
    }
    //检查楼栋名称是否已存在
    public function dormitory_buildlist_exisname(){
        $name=I("name");
        $exname = M("DormitoryBuild")->where("schoolid = '$this->schoolid' and buildname = '$name'")->find();
        if(empty($exname)){
                $ret = $this->format_ret(1,'success');
        }else{
                $ret = $this->format_ret(0,"楼栋名称已存在");
        }
        echo json_encode($ret);
        exit;
    }
    //删除前检查是楼栋中的床位是否还有学生
    public function dormitory_del_build(){
        $id = I("id");
        if(empty($id)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }
        $student=M("DormitoryBuild")
            ->alias("bu")
            ->join("wxt_dormitory_room dr on dr.buildid=bu.id")
            ->join("wxt_dormitory_bed db on db.roomid=dr.id")
            ->where("db.studentid > 0")
            ->field("db.id")
            ->find();
        if(empty($student)){
            $ret = $this->format_ret(1,'允许删除');
        }else{
            $ret = $this->format_ret(0,"楼栋中还有床位分配给学生，请将楼栋中班级初始化或退宿所有学生后再删除楼栋");
        }
        echo json_encode($ret);
        exit;
    }
    //删除楼栋，楼层，宿舍，床位
    public function dormitory_del_post_build(){
        $buildid = I("id");
        if(empty($buildid)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }

       $roomarray=M("DormitoryBuild")
           ->alias("bu")
           ->join("wxt_dormitory_room dr on dr.buildid=bu.id")
           ->field("dr.id")
           ->where("bu.id = '$buildid'")
           ->select();
        $roomids = array();
        foreach ($roomarray as $value){
            $roomids[]=$value[id];
        }
        $where[roomid] =array ('in',$roomids);
        $build= M(DormitoryBuild)->where("id = '$buildid'")->delete();
        M(DormitoryFloor)->where("buildid = '$buildid'")->delete();
        M(DormitoryRoom)->where("buildid = '$buildid'")->delete();
        M(DormitoryBed)->where($where)->delete();

        if(empty($build)){
            $ret = $this->format_ret(0,"删除失败");
        }else{
            $ret = $this->format_ret(1,'删除成功');
        }

        echo json_encode($ret);
        exit;
    }
    //宿舍管理页面
    public function dormitory_buildroom(){

        $where['db.schoolid'] = $this->schoolid;
        $roomno = I("roomno");
        $buildname = I("buildname");
        $sex = I("sex");
        $status = I("status");
        if($roomno){
            $where['dr.roomname'] = $roomno;
            $this->assign("roomno",$roomno);
        }
        if($buildname){
            $where['db.buildname'] = array('LIKE',"%".$buildname."%");
            $this->assign("buildname",$buildname);
        }
        if($sex == '0' || $sex =='1'){
            $where['dr.sex'] = $sex;
            $this->assign("sex",$sex);
        }
        if($status == '1'){
            $where['dr.nowbednum'] = 0;
            $this->assign("status",$status);
        }
        if($status == '2'){
            $where['dr.nowbednum'] =  array('exp','< dr.bednum and dr.nowbednum > 0');
            $this->assign("status",$status);
        }
        if($status == '3'){
            $where['dr.bednum'] = array('exp','= dr.nowbednum');
            $this->assign("status",$status);
        }
        $count = M("DormitoryBuild")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.buildid=db.id")
            ->join("left outer join wxt_student_info si on si.id=dr.roomleader")
            ->where($where)->count();
        $page = $this->page($count, 20);
        $room = M("DormitoryBuild")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.buildid=db.id")
            ->join("left outer join wxt_student_info si on si.id=dr.roomleader")
            ->where($where)
            ->field("dr.id as roomid,db.buildname,dr.roomname,dr.sex,dr.bednum,dr.nowbednum,dr.money,dr.note,si.stu_name")
            ->order("dr.id")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();


        $build = M("DormitoryBuild")->where("schoolid = '$this->schoolid'")->field("id,buildname")->select();

        dump($build);

        $this->assign("build",$build);
        $this->assign("room",$room);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //添加宿舍页面
    public function dormitory_add_buildroom(){
         //查询出所有班级
        $class = M("school_class")->where(array("schoolid"=>$_SESSION['schoolid']))->select();

        $build = M("DormitoryBuild")->where("schoolid = '$this->schoolid'")->field("id,buildname")->select();
        $this->assign("build",$build);
        $this->assign("class",$class);
        $this->display();
        exit;
    }
    //添加宿舍页面查询
    public function dormitory_select_floorinfo(){

        $buildid=I('buildingId');
        $floorid=I('floorId');
        if($buildid == 'qxz'){
            $ret = $this->format_ret(1,$sss);
            echo json_encode($ret);
            exit;
        }
        if(empty($buildid) ||  empty($floorid)){
            $ret = $this->format_ret(0,"未获取到数据，请重试");
            echo json_encode($ret);
            exit;
        }
//        $floor = M("DormitoryFloor")->where("id = '$floorid'")->find();
        $floor = M("DormitoryFloor")->where(array("id"=>$floorid))->find();
        $sss[charge] = $floor['money'];
        $sss[sex] = $floor['sex'];
        $sss[bedNum] = $floor['bednum'];
        $room = M("DormitoryRoom")->where("floorid = '$floorid'")->field("roomname")->order("id desc")->find();
        $sss[maxCode] = $room['roomno'];

        $ret = $this->format_ret(1,$sss);
        echo json_encode($ret);
        exit;
    }
    //添加宿舍页面查询
    public function dormitory_select_buildinfo(){

        $buildid=I('buildingId');
        $build = M("DormitoryBuild")->where("schoolid = '$this->schoolid' and id = '$buildid' ")->find();
        $Buiding[sex]=$build['buildsex'];
        $Buiding[floorNum]=$build['floornum'];
        $Buiding[startFloor]=$build['startfloor'];
        $Buiding[zeroExist]=$build['is_zero'];
        $floorIds = M("DormitoryFloor")->where(" buildid = '$build[id]' ")->select();
        $sss[Buiding]=$Buiding;
        $sss[floorIds]=$floorIds;
        $ret = $this->format_ret(1,$sss);
        echo json_encode($ret);
        exit;
    }
    //添加床位的时候返回寝室号
    public function dormitory_select_code_roomlist(){

        $buildid=I('buildingId');
        $room = M("DormitoryRoom")->where(" buildid = '$buildid' and schoolid = '$this->schoolid' ")->order("id")->field("id as roomid,roomname")->select();

        $ret = $this->format_ret(1,$room);
        echo json_encode($ret);
        exit;
    }
    //添加床位的时候返回床位号
    public function dormitory_select_code_bed(){

        $roomid=I('dormitoryId');
        $bed = M("DormitoryBed")->where(" roomid = '$roomid' and schoolid = '$this->schoolid' ")->order("bedname desc")->field("id as bedid,bedname")->find();
        $bedname = $bed[bedname]+1;
        $ret = $this->format_ret(1,$bedname);
        echo json_encode($ret);
        exit;
    }
    //添加宿舍提交
    public function dormitory_post_add_room()
    {

        $data = I("data");

        $buildid = $data["buildingId"];
        $floorid = $data["floorId"];
        $roomno = $data["dormitoryCode"];
        $roomname = $data["dormitoryCodes"];
        $bednum = $data["bedNum"];
        $money = $data["charge"];
        $note= $data["remark"];
        $classid = $data['classid'];
        if(empty( $buildid) || empty( $floorid) || empty( $roomno) || empty( $roomname)|| empty( $bednum)){
            $ret = $this->format_ret(0,"获取必要参数失败，请重试");
            echo json_encode($ret);
            exit;
        }
        $selectroom=M("DormitoryRoom")->where("schoolid='$this->schoolid' and floorid = '$floorid' and roomname='$roomname'")->find();
        if(!empty($selectroom)){
            $ret = $this->format_ret(0,"请勿重复提交");
            echo json_encode($ret);
            exit;
        }
        $datas["schoolid"]= $this->schoolid;
        $datas["buildid"]= $buildid;
        $datas["floorid"]= $floorid;
        $datas["roomname"]= $roomname;
        $datas["roomno"]= $roomno;
        $datas["bednum"]= $bednum;
        $datas["money"]= $money;
        $datas["note"]= $note;
        $datas["classid"]= $classid;
        $roomid = M("DormitoryRoom")->add($datas);
        unset($datas);
        if(!$roomid){
            $ret = $this->format_ret(0,"添加到数据库失败");
            echo json_encode($ret);
            exit;
        }
        $i=1;
        for($i=1;$i<=$bednum;$i++) {
                    $datas['roomid'] = $roomid;
                    $datas['bedname'] = $i;
                    $bedid = M("DormitoryBed")->add($datas);
                    unset($datas);
        }
        if(!empty($roomid)){
            $ret = $this->format_ret(1,'success');
        }else{
            $ret = $this->format_ret(0,"添加楼栋失败");
        }
        echo json_encode($ret);
        exit;
    }
    //修改宿舍提交
    public function dormitory_edit_post_room()
    {

        $note = I("note");
        $money = I("money");
        $roomid = I("roomid");
        $roomname = I("roomname");
        if(empty($roomid) ||  empty($money) ||  empty($roomname)){
            $ret = $this->format_ret(0,"未获取到数据，请重试");
            echo json_encode($ret);
            exit;
        }

        $where['money'] = $money;
        $where['note'] = $note;
        $where['roomname'] = $roomname;

        M("DormitoryRoom")->where("schoolid = '$this->schoolid' and id = '$roomid'")->save($where);

        $ret = $this->format_ret(1,'修改成功');

        echo json_encode($ret);
        exit;
    }
    //宿舍任命管理员页面
    public function dormitory_add_leader_room(){
        $roomid=I('roomid');
        if(empty( $roomid)){
            $this->error("未获取到房间，系统内部错误");
            exit;
        }

        $student = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_student_info si on si.id=db.studentid ")
            ->where("db.roomid = '$roomid' and db.schoolid = '$this->schoolid'")
            ->field("si.id as studentid,si.stu_name")
            ->select();
        if(empty($student)){
            $this->error("该宿舍没有人员入住");
            exit;
        }

        $this->assign("roomid",$roomid);
        $this->assign("student",$student);
        $this->display();
        exit;
    }
    //宿舍任命管理员提交
    public function dormitory_post_add_leader_bed(){
        $roomid=I('roomid');
        $studentid=I('studentid');
        if(empty($roomid) || empty($studentid)){
            $this->error("未获取到数据，系统内部错误");
            exit;
        }
        $data['roomleader']=$studentid;
        M("DormitoryRoom")->where("schoolid = '$this->schoolid' and id = '$roomid'")->save($data);
        $ret = $this->format_ret(1,'success');
        echo json_encode($ret);
        exit;
    }
    //删除前检查宿舍是否为空
    public function dormitory_del_room(){
        $roomid = I("roomid");
        if(empty($roomid)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }
        $room=M("DormitoryRoom")->where("id = '$roomid'")->field('nowbednum')->find();
        if($room[nowbednum] == 0){
            $ret = $this->format_ret(1,'允许删除');
        }else{
            $ret = $this->format_ret(0,"该宿舍还有人员住宿，请退宿后再进行此操作");
        }
        echo json_encode($ret);
        exit;
    }
    //删除宿舍
    public function dormitory_del_post_room(){

        $roomid = I("roomid");
        if(empty($roomid)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }

        $room=M("DormitoryRoom")->where("id = '$roomid' and schoolid=  '$this->schoolid'")->delete();
        if(empty($room)){
            $ret = $this->format_ret(0,"删除失败");
        }else{
            $ret = $this->format_ret(1,'删除成功');
        }

        echo json_encode($ret);
        exit;
    }
    //床位管理页面
    public function dormitory_buildbed(){

        $where['db.schoolid'] = $this->schoolid;
        $roomno = I("roomno");
        $buildname = I("buildname");
        $sex = I("sex");
        $classname = I("classname");
        $studentname = I("studentname");
        if($roomno){
            $where['dr.roomname'] = $roomno;
            $this->assign("roomno",$roomno);
        }
        if($buildname){
            $where['dbu.buildname'] = array('LIKE',"%".$buildname."%");
            $this->assign("buildname",$buildname);
        }
        if($sex == '0' || $sex =='1'){
            $where['dr.sex'] = $sex;
            $this->assign("sex",$sex);
        }
        if($classname){
            $where['sc.classname'] = array('LIKE',"%".$classname."%");
            $this->assign("classname",$classname);
        }
        if($studentname){
            $where['si.stu_name'] = array('LIKE',"%".$studentname."%");
            $this->assign("studentname",$studentname);
        }


        $count = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id=db.roomid")
            ->join("wxt_dormitory_build dbu on dr.buildid=dbu.id")
            ->join("left outer join wxt_student_info si on si.id=db.studentid")
            ->join("left outer join wxt_school_class sc on sc.id=db.classid")
            ->join("left outer join wxt_school_grade sg on sg.gradeid=sc.grade and sg.schoolid = '$this->schoolid' ")
            ->where($where)->count();
        $page = $this->page($count, 20);
        $bed = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id=db.roomid")
            ->join("wxt_dormitory_build dbu on dr.buildid=dbu.id")
            ->join("left outer join wxt_student_info si on si.id=db.studentid")
            ->join("left outer join wxt_school_class sc on sc.id=db.classid")
            ->join("left outer join wxt_school_grade sg on sg.gradeid=sc.grade and sg.schoolid = '$this->schoolid' ")
            ->where($where)
            ->field("db.id as bedid,dbu.buildname,dr.roomname,dr.sex,db.bedname,db.studentid,db.classid,db.keep,si.stu_name,sc.classname,sg.name as gradename")
            ->order("dr.id")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $build = M("DormitoryBuild")->where("schoolid = '$this->schoolid'")->field("id,buildname")->select();
        $this->assign("build",$build);
        $this->assign("bed",$bed);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //修改床位的保留状态
    public function dormitory_edit_keep_bed(){
        $bedid=I('bedid');
        if(empty($bedid)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }

        $bed=M("DormitoryBed")->where("id = '$bedid' and schoolid=  '$this->schoolid'")->find();
        if(empty($bed)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }
        if($bed[keep] == 1){
            $data[keep]=0;
        }else{
            $data[keep]=1;
        }
        M("DormitoryBed")->where("id = '$bedid' and schoolid=  '$this->schoolid'")->save($data);
        $ret = $this->format_ret(1,'修改成功');

        echo json_encode($ret);
        exit;
    }
    //床位管理添加床位页面
    public function dormitory_add_buildbed(){
        $build = M("DormitoryBuild")->where("schoolid = '$this->schoolid'")->field("id,buildname")->select();
        $this->assign("build",$build);
        $this->display();
        exit;
    }
    //添加床位提交
    public function dormitory_post_add_bed()
    {

        $data = I("data");

        $buildid = $data["buildingId"];
        $roomnid = $data["roomid"];
        $bedname = $data["bedname"];
        $keep = $data["keep"];
        if(empty( $buildid) || empty( $roomnid) || empty( $bedname)){
            $ret = $this->format_ret(0,"获取必要参数失败，请重试");
            echo json_encode($ret);
            exit;
        }
        if(!is_numeric ($bedname)){
            $ret = $this->format_ret(0,"床位号为数字");
            echo json_encode($ret);
            exit;
        }
        $bed=M("DormitoryBed")->where("schoolid='$this->schoolid' and roomid = '$roomnid' and bedname='$bedname'")->find();
        if(!empty($bed)){
            $ret = $this->format_ret(0,"床位已存在");
            echo json_encode($ret);
            exit;
        }
        $datas["schoolid"]= $this->schoolid;
        $datas["roomid"]= $roomnid;
        $datas["bedname"]= $bedname;
        $datas["classid"]= 0;
        $datas["studentid"]= 0;
        $datas["keep"]= $keep;
        $bedadd = M("DormitoryBed")->add($datas);
        unset($datas);
        if(!$bedadd){
            $ret = $this->format_ret(0,"添加到数据库失败");
            echo json_encode($ret);
            exit;
        }
       $bednum = M("DormitoryRoom")->where("schoolid = '$this->schoolid' and id = '$roomid' ")->find();
        $bednumadd[bednum] = $bednum['bednum'] + 1;
        M("DormitoryRoom")->where("schoolid = '$this->schoolid' and id = '$roomid' ")->save($bednumadd);

        $ret = $this->format_ret(1,'success');
        echo json_encode($ret);
        exit;
    }
    //床位管理添加学生页面
    public function dormitory_add_student_bed(){
        $bedid=I('bedid');
        if(empty( $bedid)){
            $this->error("未获取到床位，系统内部错误");
            exit;
        }
        $name = I("name");
        $class = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id=db.roomid")
            ->where("db.id = '$bedid' and db.schoolid = '$this->schoolid' and db.studentid = 0")
            ->field("db.classid,dr.sex")
            ->find();
        if(empty( $class)){
            $this->error("系统内部错误，请刷新重试");
            exit;
        }
        $classname = M("SchoolClass")->where("id = '$class[classid]' and schoolid='$this->schoolid'")->field("classname")->find();

        if($name){
            $where["si.stu_name"]= array('LIKE',"%".$name."%");
        }
        $where["si.classid"] = $class[classid];
        $where["si.schoollid"] = $this->schoolid;
        $where["si.sex"] = $class[sex];
        $where["si.in_residence"] = 1;
        $where["db.id"] = array('exp','is null');

        $count = M("StudentInfo")
            ->alias("si")
            ->join("left outer join wxt_dormitory_bed db on db.studentid=si.id")
           ->where($where)
           ->field("si.id as studentid,si.stu_name")
           ->count();
        $page = $this->page($count, 20);
        $studentlist = M("StudentInfo")
            ->alias("si")
            ->join("left outer join wxt_dormitory_bed db on db.studentid=si.id")
            ->where($where)
            ->field("si.id as studentid,si.stu_name")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $this->assign("bedid",$bedid);
        $this->assign("name",$name);
        $this->assign("classname",$classname[classname]);
        $this->assign("studentlist",$studentlist);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //床位管理添加学生提交
    //床位添加和退宿学生的时候请一并修改房间表的已入住人数 ！
    public function dormitory_post_add_student_bed()
    {
        $bedid = I("bedid");
        $studentid = I("studentid");
        if(empty( $bedid) || empty($studentid)){
            $ret = $this->format_ret(0,"未获取必要参数，请刷新重试");
            echo json_encode($ret);
            exit;
        }
        $student = M("DormitoryBed")->where("id = '$bedid' and schoolid = '$this->schoolid' and studentid > 0") ->find();
        if(!empty( $student)){
            $ret = $this->format_ret(0,"该床位已分配，请刷新重试");
            echo json_encode($ret);
            exit;
        }
        $data["studentid"] = $studentid;
         M("DormitoryBed")->where("id = '$bedid' and schoolid = '$this->schoolid' ") ->save($data);
        //床位添加和删除学生的时候请一并修改房间表的已入住人数 ！
        $nowbed = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id=db.roomid")
            ->where("db.id = '$bedid' and db.schoolid = '$this->schoolid' ")
            ->field("dr.id,dr.nowbednum")
            ->find();
        $nowbednum[nowbednum] = $nowbed[nowbednum]+1;
        M("DormitoryRoom")->where("id = '$nowbed[id]'")->save($nowbednum);

        $ret = $this->format_ret(1,'入住成功');

        echo json_encode($ret);
        exit;
    }
    //床位学生退宿
    //床位添加和退宿学生的时候请一并修改房间表的已入住人数 ！
    public function dormitory_cancel_bed()
    {
        $bedid = I("bedid");

        if(empty( $bedid)){
            $ret = $this->format_ret(0,"未获取必要参数，请刷新重试");
            echo json_encode($ret);
            exit;
        }
        $student=M("DormitoryBed")->where("id = '$bedid' and schoolid = '$this->schoolid' and studentid >0 ") ->find();
        if(!empty($student)) {
            $data["studentid"] = 0;
            M("DormitoryBed")->where("id = '$bedid' and schoolid = '$this->schoolid' ")->save($data);
            //床位添加和删除学生的时候请一并修改房间表的已入住人数 ！
            $nowbed = M("DormitoryBed")
                ->alias("db")
                ->join("wxt_dormitory_room dr on dr.id=db.roomid")
                ->where("db.id = '$bedid' and db.schoolid = '$this->schoolid' ")
                ->field("dr.id,dr.nowbednum")
                ->find();
            $nowbednum[nowbednum] = $nowbed[nowbednum] - 1;
            M("DormitoryRoom")->where("id = '$nowbed[id]'")->save($nowbednum);
        }
        $ret = $this->format_ret(1,'退宿成功');

        echo json_encode($ret);
        exit;
    }
    //床位对调页面
    public function dormitory_exchangebed_student_bed(){
        $bedid=I('bedid');
        $sex = I('sex');
        $studentid = I('studentid');
        if(empty( $bedid) || !isset($sex) || empty($studentid)){
            $this->error("未获取到数据，系统内部错误");
            exit;
        }
        $name = I("name");
        if($name){
            $where["si.stu_name"]= array('LIKE',"%".$name."%");
        }
        $where["dr.sex"] = $sex;
        $where["db.schoolid"] = $this->schoolid;
        $where['db.studentid'] =  array(array('gt',0),array('neq',$studentid));
        $count = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id = db.roomid")
            ->join("wxt_student_info si on si.id = db.studentid")
            ->join("wxt_school_class sc on sc.id = db.classid")
            ->where($where)
            ->field("db.id as bedid,dr.sex,si.id as studentid,si.stu_name,sc.classname")
            ->count();
        $page = $this->page($count, 20);

        $studentlist = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id = db.roomid")
            ->join("wxt_student_info si on si.id = db.studentid")
            ->join("wxt_school_class sc on sc.id = db.classid")
            ->where($where)
            ->field("db.id as bedid,si.id as studentid,si.stu_name,sc.classname")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();


        $this->assign("bedid",$bedid);
        $this->assign("name",$name);
        $this->assign("studentlist",$studentlist);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //床位对调提交
    public function dormitory_post_exchangebed_student_bed()
    {
        $oldbedid = I("oldbedid");
        $studentid = I("studentid");
        if(empty( $oldbedid) || empty($studentid)){
            $ret = $this->format_ret(0,"未获取必要参数，请刷新重试");
            echo json_encode($ret);
            exit;
        }
        $oldstudent = M("DormitoryBed")->where("id = '$oldbedid' and schoolid = '$this->schoolid' ")->find();
        $oldstudentid = $oldstudent[studentid];
        $oldclass = $oldstudent[classid];
        $bed = M("DormitoryBed")->where("studentid = '$studentid' and schoolid = '$this->schoolid' ")->find();
        $class = $bed[classid];
        $bedid = $bed[id];
        if(empty( $oldstudentid) || empty($oldclass) || empty($class) || empty($bedid)){
            $ret = $this->format_ret(0,"内部数据异常，请刷新重试");
            echo json_encode($ret);
            exit;
        }

        $data[classid] = $class;
        $data[studentid] = $studentid;
        M("DormitoryBed")->where("id = '$oldbedid' and schoolid = '$this->schoolid' ")->save($data);
        $olddata[classid] = $oldclass;
        $olddata[studentid] = $oldstudentid;
        M("DormitoryBed")->where("id = '$bedid' and schoolid = '$this->schoolid' ")->save($olddata);

        $ret = $this->format_ret(1,'对调成功');

        echo json_encode($ret);
        exit;
    }
    //删除床位
    public function dormitory_del_bed()
    {
        $bedid = I("bedid");

        if(empty( $bedid)){
            $ret = $this->format_ret(0,"未获取必要参数，请刷新重试");
            echo json_encode($ret);
            exit;
        }
        $student=M("DormitoryBed")->where("id = '$bedid' and schoolid = '$this->schoolid' and studentid >0 ") ->find();
        if(empty($student)) {
            //床位删除时,一并修改房间表的床位数 ！
            $nowbed = M("DormitoryBed")
                ->alias("db")
                ->join("wxt_dormitory_room dr on dr.id=db.roomid")
                ->where("db.id = '$bedid' and db.schoolid = '$this->schoolid' ")
                ->field("dr.id,dr.bednum")
                ->find();
            $bednum[bednum] = $nowbed[bednum] - 1;
            M("DormitoryRoom")->where("id = '$nowbed[id]'")->save($bednum);
            M("DormitoryBed")->where("id = '$bedid' and schoolid = '$this->schoolid'")->delete();
            $ret = $this->format_ret(1,'删除成功');
        }else{
            $ret = $this->format_ret(0,'床位存在学生，删除失败，请刷新重试');
        }

        echo json_encode($ret);
        exit;
    }
    //宿舍管理员页面
    public function dormitory_manager(){

        $where['schoolid'] = $this->schoolid;
        $name = I("name");
        $phone = I("phone");
        if($name){
            $where['name'] = $name;
            $this->assign("name",$name);
        }
        if($phone){
            $where['phone'] = $phone;
            $this->assign("phone",$phone);
        }

        $count = M("DormitoryManager")->where($where)->count();
        $page = $this->page($count, 20);
        $manager = M("DormitoryManager")->where($where) ->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign("manager",$manager);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //宿舍管理员任命页面
    public function dormitory_manager_add_build()
    {

        $id=I('id');
        if(empty( $id)){
            $this->error("未获取到楼栋，系统内部错误");
            exit;
        }
        $where['schoolid'] = $this->schoolid;
        $name = I("name");
        $phone = I("phone");
        if($name){
            $where['name'] = $name;
            $this->assign("name",$name);
        }
        if($phone){
            $where['phone'] = $phone;
            $this->assign("phone",$phone);
        }

        $count = M("DormitoryManager")->where($where)->count();
        $page = $this->page($count, 20);
        $manager = M("DormitoryManager")->where($where) ->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign("id",$id);
        $this->assign("manager",$manager);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //宿舍管理员任命提交
    public function dormitory_manager_add_post_build()
    {
        $buildid = I("buildid");
        $id = I("managerid");
        if(empty( $buildid) || empty($id)){
            $ret = $this->format_ret(0,"未获取必要参数，请刷新重试");
            echo json_encode($ret);
            exit;
        }
        $data["managerid"] = $id;
        $manager = M("DormitoryBuild")->where("id = '$buildid' ") ->save($data);
        if(!empty($manager)){
            $ret = $this->format_ret(1,'任命成功');
        }else{
            $ret = $this->format_ret(0,"任命失败");
        }
        echo json_encode($ret);
        exit;
    }
    //添加管理员提交
    public function dormitory_add_post_manager(){

       $name = I("name");
       $phone = I("phone");
        if(empty($name) || empty($phone)){
            $ret = $this->format_ret(0,"未获取到名称或手机号，请重试");
            echo json_encode($ret);
            exit;
        }
        $where['schoolid'] = $this->schoolid;
        $where['name'] = $name;
        $where['phone'] = $phone;
       $manager=M("DormitoryManager")->where($where)->find();
        if(empty($manager)){
            M("DormitoryManager")->add($where);
            $ret = $this->format_ret(1,'添加成功');
        }else{
            $ret = $this->format_ret(0,"添加失败，已存在相同姓名与电话的管理员");
        }
        echo json_encode($ret);
        exit;
    }
    //修改管理员提交
    public function dormitory_edit_post_manager(){

        $name = I("name");
        $phone = I("phone");
        $id = I("id");
        if(empty($name) || empty($phone) || empty($id)){
            $ret = $this->format_ret(0,"未获取到名称或手机号，请重试");
            echo json_encode($ret);
            exit;
        }

        $where['name'] = $name;
        $where['phone'] = $phone;
        $where['schoolid'] = $this->schoolid;
        $managerss=M("DormitoryManager")->where($where)->find();
        if(!empty($managerss)){
            $ret = $this->format_ret(0,"添加失败，已存在相同姓名与电话的管理员");
            echo json_encode($ret);
            exit;
        }

        $manager=M("DormitoryManager")->where("id = $id")->save($where);

        $ret = $this->format_ret(1,'修改成功');

        echo json_encode($ret);
        exit;
    }
    //删除前检查是否已被任命为楼栋管理员
    public function dormitory_del_manager(){
        $id = I("id");
        if(empty($id)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }
        $managerss=M("DormitoryBuild")->where("managerid = '$id'")->find();
        if(empty($managerss)){
            $ret = $this->format_ret(1,'允许删除');
        }else{
            $ret = $this->format_ret(0,"该人员已被任命为楼栋管理员，请先解除任命再删除");
        }
        echo json_encode($ret);
        exit;
    }
    //删除管理员
    public function dormitory_del_post_manager(){

        $id = I("id");
        if(empty($id)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }

        $manager=M("DormitoryManager")->where("id = '$id' and schoolid = '$this->schoolid'")->delete();
        if(empty($manager)){
            $ret = $this->format_ret(0,"删除失败");
        }else{
            $ret = $this->format_ret(1,'删除成功');
        }

        echo json_encode($ret);
        exit;
    }
    //宿舍入住管理页面
    public function dormitory_student(){

        $classname = I("classname");
        $where['sc.schoolid'] = $this->schoolid;
        $where['si.in_residence'] = 1;
        if($classname){
            $where['sc.classname'] = array('LIKE',"%".$classname."%");
            $this->assign("classname",$classname);
        }
        $class = M("SchoolClass")
            ->alias("sc")
            ->join("wxt_student_info si on si.classid=sc.id")
            ->join("left outer join wxt_dormitory_bed db on db.studentid=si.id")
            ->where( $where)
            ->field("sc.id as classid,sc.classname,si.id as studentid,si.sex,db.roomid,db.roomid")
            ->select();

        //班级住宿人数
        $classdormitory=array();
        foreach ($class as $value){
            $classdormitory[$value[classid]][studentnum] = 0;
            $classdormitory[$value[classid]][classname] = 0;
            $classdormitory[$value[classid]][classid] = 0;
            $classdormitory[$value[classid]][woman] = 0;
            $classdormitory[$value[classid]][womannum] = 0;
            $classdormitory[$value[classid]][man] = 0;
            $classdormitory[$value[classid]][mannum] = 0;
        }
        foreach ($class as $value){
            $classdormitory[$value[classid]][studentnum] = $classdormitory[$value[classid]][studentnum]+1;
            $classdormitory[$value[classid]][classname] = $value[classname];
            $classdormitory[$value[classid]][classid] = $value[classid];
            if($value[sex]==1){
                $classdormitory[$value[classid]][woman] = $classdormitory[$value[classid]][woman]+1;
                if($value[roomid]){
                    $classdormitory[$value[classid]][womannum] = $classdormitory[$value[classid]][womannum]+1;
                }
            }
            if($value[sex]==0){
                $classdormitory[$value[classid]][man] = $classdormitory[$value[classid]][man]+1;
                if($value[roomid]){
                    $classdormitory[$value[classid]][mannum] = $classdormitory[$value[classid]][mannum]+1;
                }
            }
        }
        unset($class);
        foreach ($classdormitory as &$val){
            $val[manbednum] = M("DormitoryBed")
                ->alias("db")
                ->join("wxt_dormitory_room dr on dr.id=db.roomid")
                ->where("dr.sex = 0 and db.classid = '$val[classid]'")
                ->count();
            $val[womanbednum] = M("DormitoryBed")
                ->alias("db")
                ->join("wxt_dormitory_room dr on dr.id=db.roomid")
                ->where("dr.sex = 1 and db.classid = '$val[classid]'")
                ->count();
        }
        $this->assign("class",$classdormitory);
        $this->display();
        exit;
    }
    //初始化班级
    public function dormitory_class_initialization(){


        $classid = I("classid");
        if(empty($classid)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }
        $data['classid']=0;
        $data['studentid']=0;
        $data['keep']=0;
         M("DormitoryBed")->where("schoolid = '$this->schoolid' and classid = '$classid'")->save($data);

            $ret = $this->format_ret(1,'初始化成功');


        echo json_encode($ret);
        exit;
    }
    //给班级分配宿舍页面
    public function dormitory_room_class(){
        $floorid=I('floorid');
        $classid=I('classid');
        if(empty($floorid)){
            $this->error("未获取到楼层，请重试");
            exit;
        }
        $room=M("DormitoryRoom")->where("floorid = '$floorid' and schoolid = '$this->schoolid' ")->field("id as roomid,roomname,bednum,nowbednum")->select();
        foreach ($room as &$value){
            $value['bed']=M("DormitoryBed")->where("roomid = '$value[roomid]' and classid=0 and keep=0")->field("id as bedid,bedname")->order("id")->select();
            $value['nullbed'] = count($value['bed']);
        }
        $this->assign("classid",$classid);
        $this->assign("room",$room);
        $this->display();
        exit;
    }
    //班级宿舍详情页面
    public function dormitory_room_class_bed(){
        $roomid=I('roomid');
        $classid=I('classid');
        if(empty($roomid) || empty($classid)){
            $this->error("未获取到数据，请重试");
            exit;
        }
        $bed=M("DormitoryBed")->where("roomid = '$roomid' and schoolid = '$this->schoolid' ")->field("id as bedid,bedname,studentid")->select();

        $this->assign("bed",$bed);
        $this->display();
        exit;
    }
    //学生床位管理页面
    public function dormitory_student_bed(){
        $classid=I('classid');
        $isbed=I('isbed');
        $stu_name=I('stu_name');
        $sex=I('sex');
        if(empty($classid)){
            $this->error("未获取到班级，请重试");
            exit;
        }
        $this->assign("classid",$classid);
        $classname = M("SchoolClass")->where("id = '$classid' and schoolid = '$this->schoolid' ")->field("classname")->find();
        if(empty($classname)){
            $this->error("未获取到班级，请重试");
            exit;
        }
        $this->assign("classname",$classname[classname]);

        $where['si.schoollid']=$this->schoolid;
        $where['si.classid']=$classid;
        $where['si.in_residence']=1;

        if($isbed ==2){
            $where["db.id"] = array('exp','is null');
            $this->assign("isbed",$isbed);
        }
        if($isbed ==1){
            $where["db.id"] = array('gt',0);
            $this->assign("isbed",$isbed);
        }
        if($stu_name){
            $where["si.stu_name"] = array('LIKE',"%".$stu_name."%");
            $this->assign("stu_name",$stu_name);
        }
        if($sex == 0 or $sex == 1){
            $where["si.sex"] = $sex;
            $this->assign("sex",$sex);
        }

        $count=M("StudentInfo")
            ->alias('si')
            ->join("left outer join wxt_dormitory_bed db on db.studentid=si.id")
            ->join("left outer join wxt_dormitory_room dr on dr.id=db.roomid")
            ->where($where)
            ->count();

        $page = $this->page($count, 20);

        $student=M("StudentInfo")
            ->alias('si')
            ->join("left outer join wxt_dormitory_bed db on db.studentid=si.id")
            ->join("left outer join wxt_dormitory_room dr on dr.id=db.roomid")
            ->where($where)
            ->field("si.stu_name,si.id as studentid,si.sex,dr.roomname,db.bedname,db.id as bedid")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("student",$student);
        $this->display();
        exit;
    }
    //给学生分配床位页面
    public function dormitory_add_student_bed_class(){
        $classid=I('classid');
        $studentid = I("studentid");
        $sex= I("sex");
        if(empty($classid) || empty($studentid) || !isset($sex)){
            $this->error("未获取到数据，请刷新重试");
            exit;
        }
        $this->assign("studentid",$studentid);
        $this->assign("classid",$classid);
        $this->assign("sex",$sex);
        $buildname = I("buildname");
        $roomname = I("roomname");
        $isbed = I("isbed");

        if($buildname){
            $where["dbu.buildname"]= array('LIKE',"%".$buildname."%");
            $this->assign("buildname",$buildname);
        }
        if($roomname){
            $where["dr.roomname"]= array('LIKE',"%".$roomname."%");
            $this->assign("roomname",$roomname);
        }
        if($isbed == 1 ){
            $where["db.studentid"]= 0;
            $this->assign("isbed",$isbed);
        }
        if($isbed == 2 ){
            $where["db.studentid"]= array('gt',0);
            $this->assign("isbed",$isbed);
        }
        $where["db.classid"] = $classid;
        $where["db.schoolid"] = $this->schoolid;
        $where["dr.sex"] =$sex;


        $count = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id=db.roomid")
            ->join("wxt_dormitory_build dbu on dbu.id=dr.buildid")
            ->join("left outer join wxt_student_info si on si.id=db.studentid")
            ->where($where)
            ->field("si.id as studentid,si.stu_name")
            ->count();
        $page = $this->page($count, 20);
        $bedlist = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id=db.roomid")
            ->join("wxt_dormitory_build dbu on dbu.id=dr.buildid")
            ->join("left outer join wxt_student_info si on si.id=db.studentid")
            ->where($where)
            ->field("db.id as bedid,db.bedname,dr.roomname,dbu.buildname,si.stu_name")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $this->assign("bedlist",$bedlist);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //给班级分配宿舍页面
    public function dormitory_student_room(){
        $classid = $_GET[classid];
        if(empty($classid)){
            $this->error("未获取到班级，请重试");
            exit;
        }

        $where['sc.schoolid'] = $this->schoolid;
        $where['si.in_residence'] = 1;
        $where['sc.id'] = $classid;


        $class = M("SchoolClass")
            ->alias("sc")
            ->join("wxt_student_info si on si.classid=sc.id")
            ->join("left outer join wxt_dormitory_bed db on db.studentid=si.id")
            ->where( $where)
            ->field("sc.classname,si.id as studentid,si.sex,db.roomid,db.roomid")
            ->select();

        //班级住宿人数
        $studentnum = 0;
        $classname = $class[0][classname];
        $woman=0;
        $womannum=0;
        $man=0;
        $mannum=0;
        foreach ($class as $value){
            $studentnum = $studentnum+1;
            if($value[sex]==1){
                $woman = $woman+1;
                if($value[roomid]){
                    $womannum = $womannum+1;
                }
            }
            if($value[sex]==0){
                $man = $man+1;
                if($value[roomid]){
                    $mannum =  $mannum+1;
                }
            }
        }
        $room = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id=db.roomid")
            ->where("db.schoolid = '$this->schoolid' and db.classid = '$classid'")
            ->field("db.roomid,dr.roomname,dr.sex,db.bedname,db.studentid")
            ->select();
        $roomdistri = array();
        foreach ($room as $values){
            $roomdistri[$values[roomid]][roomid] = $values[roomid];
            $roomdistri[$values[roomid]][sex] = $values[sex];
            $roomdistri[$values[roomid]][roomname] = $values[roomname];
            $roomdistri[$values[roomid]][bednum] = 0;
            $roomdistri[$values[roomid]][isbed] = 0;
        }
        foreach ($room as $values){
            if($values[studentid]){
                $roomdistri[$values[roomid]][isbed] =  $roomdistri[$values[roomid]][isbed]+1;
            }
            $roomdistri[$values[roomid]][bednum] = $roomdistri[$values[roomid]][bednum]+1;
        }
        $build = M("DormitoryBuild")->where("schoolid = '$this->schoolid'")->field("id,buildname")->select();
        $this->assign("build",$build);
        $this->assign("room",$roomdistri);
        $this->assign("studentnum",$studentnum);
        $this->assign("classname",$classname);
        $this->assign("woman",$woman);
        $this->assign("womannum",$womannum);
        $this->assign("man",$man);
        $this->assign("mannum",$mannum);
        $this->assign("classid",$classid);
        $this->display();
        exit;
    }
    //给班级分配宿舍页面的返回楼层
    public function dormitory_select_buildinfo_student(){

        $buildid=I('buildingId');
        $classid=I('classid');
        $floorIds = M("DormitoryFloor")->where(" buildid = '$buildid' ")->order("id")->select();
        $count=0;
        foreach ($floorIds as &$value){
            $value['roomnum']=M("DormitoryRoom")->where("floorid = '$value[id]' and nowbednum<bednum ")->count();
            $value['nullbed']=M("DormitoryBed")
                ->alias('db')
                ->join('wxt_dormitory_room dr on dr.id=db.roomid')
                ->where("dr.floorid = '$value[id]' and db.classid=0 ")->count();
            $value['classbed']=M("DormitoryBed")
                ->alias('db')
                ->join('wxt_dormitory_room dr on dr.id=db.roomid')
                ->where("dr.floorid = '$value[id]' and db.classid='$classid' ")->count();
            $count = $count+1;
            if($value[sex] == 1){
                $value[sex] = '女';
            }else{
                $value[sex] = '男';
            }
        }
       $sss[floor]=$floorIds;
        $sss[count]=$count;
        $ret = $this->format_ret(1,$sss);
        echo json_encode($ret);
        exit;
    }
    //给班级添加床位
    public function dormitory_add_class_bed(){

        $data=I('data');
        $count=count($data)-1;
        $classid=$data['classid'];
        if(empty($classid)){
            $ret = $this->format_ret(0,"未获取数据，请刷新页面重试");
            echo json_encode($ret);
            exit;
        }

        for($i=0;$i<$count;$i++){
            $bed=array();
            $name = 'bedid['.$i.'';
            $bed['classid']=$classid;
            M("DormitoryBed")->where("id = '$data[$name]' and classid = '0' and schoolid = '$this->schoolid' and keep = 0")->save($bed);
        }

        $ret = $this->format_ret(1,"分配床位成功");
        echo json_encode($ret);
        exit;
    }

    //楼栋出入统计页面
    public function dormitory_count()
    {
        $buildname = I("buildname");
        $roomname = I("roomname");
        $classname = I("classname");
        $stu_name = I("stu_name");
        $starttime = I("starttime");
        $endtime = I("endtime");
        $status = I("status");

//取出正常考勤的时间段设置
        $check_time = M("DormitoryCheckTime")->where("schoolid = '$this->schoolid'")->find();
        if(empty($check_time)){
            $time_morning1="06:00";
            $time_morning2="08:00";
            $time_noon1="11:30";
            $time_noon2="13:30";
            $time_afternoon1="16:30";
            $time_afternoon2="18:30";
            $time_night1="20:30";
            $time_night2="22:30";
        }else{
            $time_morning1=$check_time[time_morning1];
            $time_morning2=$check_time[time_morning2];
            $time_noon1=$check_time[time_noon1];
            $time_noon2=$check_time[time_noon2];
            $time_afternoon1=$check_time[time_afternoon1];
            $time_afternoon2=$check_time[time_afternoon2];
            $time_night1=$check_time[time_night1];
            $time_night2=$check_time[time_night2];
        }
        $where['frd.schoolid'] = $this->schoolid;
        if($buildname){
            $where["dbus.buildname"]= array('LIKE',"%".$buildname."%");
            $this->assign("buildname",$buildname);
        }
        if($roomname){
            $where["dr.roomname"]= array('LIKE',"%".$roomname."%");
            $this->assign("roomname",$roomname);
        }
        if($classname){
            $where["sc.classname"]= array('LIKE',"%".$classname."%");
            $this->assign("classname",$classname);
        }
        if($stu_name){
            $where["si.stu_name"]= array('LIKE',"%".$stu_name."%");
            $this->assign("stu_name",$stu_name);
        }
        if($starttime){
            $this->assign('starttime',$starttime);
        }else{
            $starttime= date('Y-m-d',(time()-604800));
            $this->assign('starttime',$starttime);
        }
        if($endtime){
            $this->assign('endtime',$endtime);
        }else{
            $endtime= date('Y-m-d',time());
            $this->assign('endtime',$endtime);
        }
        $where["frd.daytime"]=array(array('egt',"$startime"),array('elt',"$endtime"));
        if($status == 1){
            $where["frd.histime"]=array(array('between',"$time_morning1,$time_morning2"),
                array('between',"$time_noon1,$time_noon2"),
                array('between',"$time_afternoon1,$time_afternoon2"),
                array('between',"$time_night1,$time_night2"),'OR');
        }
        if($status == 2){
            $where["histime"]=array(array('not between',"$time_morning1,$time_morning2"),
                array('not between',"$time_noon1,$time_noon2"),
                array('not between',"$time_afternoon1,$time_afternoon2"),
                array('not between',"$time_night1,$time_night2"));
        }

        $count = M("FaceRecordDormitory")
            ->alias("frd")
            ->join("wxt_face_device fd on fd.id=frd.deviceid")
            ->join("left outer join wxt_dormitory_facedevice df on df.deviceid=fd.id")
            ->join("left outer join wxt_dormitory_build dbus on dbus.id=df.buildid")
            ->join("left outer join wxt_student_info si on si.userid=frd.userid")
            ->join("left outer join wxt_dormitory_bed db on db.studentid=si.id")
            ->join("left outer join wxt_dormitory_room dr on dr.id=db.roomid")
            ->join("left outer join wxt_dormitory_build dbu on dbu.id=dr.buildid")
            ->join("left outer join wxt_school_class sc on sc.id=si.classid")
            ->where($where)
            ->count();
        $page = $this->page($count, 20);
        $record = M("FaceRecordDormitory")
            ->alias("frd")
            ->join("wxt_face_device fd on fd.id=frd.deviceid")
            ->join("left outer join wxt_dormitory_facedevice df on df.deviceid=fd.id")
            ->join("left outer join wxt_dormitory_build dbus on dbus.id=df.buildid")
            ->join("left outer join wxt_student_info si on si.userid=frd.userid")
            ->join("left outer join wxt_dormitory_bed db on db.studentid=si.id")
            ->join("left outer join wxt_dormitory_room dr on dr.id=db.roomid")
            ->join("left outer join wxt_dormitory_build dbu on dbu.id=dr.buildid")
            ->join("left outer join wxt_school_class sc on sc.id=si.classid")
            ->where($where)
            ->field("si.stu_name,sc.classname,dbu.buildname,dr.roomname,frd.daytime,frd.histime,frd.photourl,fd.name as devicename,dbus.buildname as buildnames")
            ->order("frd.id desc")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        foreach ($record as &$value){
            $histime="";
            $histime=$value[histime];
            if((($time_morning1 < $histime )and ($histime < $time_morning2)) || (($time_noon1 < $histime )and ($histime < $time_noon2)) || (($time_afternoon1 < $histime )and ($histime < $time_afternoon2)) || (($time_night1 < $histime )and ($histime < $time_night2))){
                $value[status]=1;
            }else{
                $value[status]=2;
            }

        }

        $this->assign("record",$record);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //宿舍出入统计页面
    public function dormitory_count_room()
    {
        $buildname = I("buildname");
        $roomname = I("roomname");
        $classname = I("classname");
        $stu_name = I("stu_name");
        $startime = I("startime");
        $endtime = I("endtime");
        $where['db.schoolid'] = $this->schoolid;
        if($stu_name){
            $where['si.stu_name'] = array('LIKE',"%".$stu_name."%");
            $this->assign('stu_name',$stu_name);
        }
        if($classname){
            $where['sc.classname'] = array('LIKE',"%".$classname."%");
            $this->assign('classname',$classname);
        }
        if($roomname){
            $where['dr.roomname'] =array('LIKE',"%".$roomname."%");
            $this->assign('roomname',$roomname);
        }
        if($buildname){
            $where['db.buildname'] = array('LIKE',"%".$buildname."%");
            $this->assign('buildname',$buildname);
        }
        $count = M("DormitoryBuild")
            ->alias('db')
            ->join('wxt_dormitory_room dr on dr.buildid=db.id')
            ->join('wxt_dormitory_bed dbed on dbed.roomid = dr.id ')
            ->join("wxt_student_info si on si.id = dbed.studentid")
            ->join("wxt_school_class sc on sc.id = si.classid")
            ->where($where)
            ->count();
        $page = $this->page($count, 20);
        $record = M("DormitoryBuild")
            ->alias('db')
            ->join('wxt_dormitory_room dr on dr.buildid=db.id')
            ->join('wxt_dormitory_bed dbed on dbed.roomid = dr.id ')
            ->join("wxt_student_info si on si.id = dbed.studentid")
            ->join("wxt_school_class sc on sc.id = si.classid")
            ->where($where)
            ->field("db.buildname,db.id as buildid,dr.roomname,dbed.bedname,dbed.studentid,si.stu_name,sc.classname,si.userid")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        //取出要查询的人员完毕

        //查询挂在宿舍楼下的人脸识别设备
        $device = array();
        foreach($record as $facedevice){
            if(empty($device[$facedevice[buildid]])){
                $device[$facedevice[buildid]]=M("DormitoryFacedevice")->where("schoolid = '$this->schoolid' and buildid = '$facedevice[buildid]' ")->field('deviceid')->select();
                $device[$facedevice[buildid]]=$this->array_column($device[$facedevice[buildid]],deviceid);
            }
        }

        //取出正常考勤的时间段设置
        $check_time = M("DormitoryCheckTime")->where("schoolid = '$this->schoolid'")->find();
        if(empty($check_time)){
            $time_morning1="06:00";
            $time_morning2="08:00";
            $time_noon1="11:30";
            $time_noon2="13:30";
            $time_afternoon1="16:30";
            $time_afternoon2="18:30";
            $time_night1="20:30";
            $time_night2="22:30";
        }else{
            $time_morning1=$check_time[time_morning1];
            $time_morning2=$check_time[time_morning2];
            $time_noon1=$check_time[time_noon1];
            $time_noon2=$check_time[time_noon2];
            $time_afternoon1=$check_time[time_afternoon1];
            $time_afternoon2=$check_time[time_afternoon2];
            $time_night1=$check_time[time_night1];
            $time_night2=$check_time[time_night2];
        }
        if($startime){
            $this->assign('startime',$startime);
        }else{
            $startime= date('Y-m-d',(time()-604800));
            $this->assign('startime',$startime);
        }
        if($endtime){
            $this->assign('endtime',$endtime);
        }else{
            $endtime= date('Y-m-d',time());
            $this->assign('endtime',$endtime);
        }
        $wheres["histime"]=array(array('between',"$time_morning1,$time_morning2"),array('between',"$time_noon1,$time_noon2"),array('between',"$time_afternoon1,$time_afternoon2"),array('between',"$time_night1,$time_night2"),'OR');
        $wheres["schoolid"]=$this->schoolid;
        $wheres["daytime"]=array(array('egt',"$startime"),array('elt',"$endtime"));

        $wherens["histime"]=array(array('not between',"$time_morning1,$time_morning2"),array('not between',"$time_noon1,$time_noon2"),array('not between',"$time_afternoon1,$time_afternoon2"),array('not between',"$time_night1,$time_night2"));
        $wherens["schoolid"]=$this->schoolid;
        $wherens["daytime"]=array(array('egt',"$startime"),array('elt',"$endtime"));
        //获取每日的宿舍进出情况
        foreach ($record as &$value){
            $wheres["userid"]='';
            $wheres["userid"]=$value[userid];
            if(!empty($device[$value[buildid]])){
                $wheres["deviceid"]='';
                $wheres["deviceid"]=array('in',$device[$value[buildid]]);
            }
            $recordperson = M("FaceRecordDormitory")
                ->where($wheres)
                ->field("count(1),week")
                ->group("week")
                ->select();
            $sss = array();
            $sss[1]=0;
            $sss[2]=0;
            $sss[3]=0;
            $sss[4]=0;
            $sss[5]=0;
            $sss[6]=0;
            $sss[7]=0;
            foreach($recordperson as $val){
                $sss[$val[week]]= $val['count(1)'];
            }
            $value["ok1"]=$sss[1];
            $value["ok2"]=$sss[2];
            $value["ok3"]=$sss[3];
            $value["ok4"]=$sss[4];
            $value["ok5"]=$sss[5];
            $value["ok6"]=$sss[6];
            $value["ok7"]=$sss[7];
            $value["ok8"]=$value["ok1"]+$value["ok2"]+$value["ok3"]+$value["ok4"]+$value["ok5"]+$value["ok6"]+$value["ok7"];
            $wherens["userid"]='';
            $wherens["userid"]=$value[userid];
            if(!empty($device[$value[buildid]])){
                $wherens["deviceid"]='';
                $wherens["deviceid"]=array('in',$device[$value[buildid]]);
            }
            $recordpersons = M("FaceRecordDormitory")
                ->where($wherens)
                ->field("count(1),week")
                ->group("week")
                ->select();
            $kkk = array();
            $kkk[1]=0;
            $kkk[2]=0;
            $kkk[3]=0;
            $kkk[4]=0;
            $kkk[5]=0;
            $kkk[6]=0;
            $kkk[7]=0;
            foreach($recordpersons as $vals){
                $kkk[$vals[week]]= $vals['count(1)'];
            }
            $value["nook1"]=$kkk[1];
            $value["nook2"]=$kkk[2];
            $value["nook3"]=$kkk[3];
            $value["nook4"]=$kkk[4];
            $value["nook5"]=$kkk[5];
            $value["nook6"]=$kkk[6];
            $value["nook7"]=$kkk[7];
            $value["nook8"]=$value["nook1"]+$value["nook2"]+$value["nook3"]+$value["nook4"]+$value["nook5"]+$value["nook6"]+$value["nook7"];
        }


        $this->assign("record",$record);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //查看单个床位的学生一段时间内的进出明细
    public function dormitory_see_student_log(){
        $studentid = I("studentid");
        $startime = I("startime");
        $endtime = I("endtime");
        $week = I("week");
        if(empty($studentid) || empty($startime) || empty($endtime) || empty($week)){
            $this->error("未获取必要参数，请刷新重试");
            exit;
        }
        //获取学生楼栋信息
        $build = M("DormitoryBed")
            ->alias("db")
            ->join("wxt_dormitory_room dr on dr.id=db.roomid")
            ->join("wxt_dormitory_build dbu on dbu.id=dr.buildid")
            ->where("db.schoolid = '$this->schoolid' ")
            ->field("db.bedname,dbu.buildname,dr.roomname,dr.buildid")
            ->find();
        if(empty($build)){
            $this->error("获取学生住宿信息失败，请重试");
            exit;
        }
        //获取楼栋的设备
        $device = M("DormitoryFacedevice")->where("schoolid = '$this->schoolid' and buildid = '$build[buildid]'")->field("deviceid")->select();
        if(empty($device)){
            $this->error("该楼栋尚未分配人脸识别设备，请分配后再尝试");
            exit;
        }
        $device=$this->array_column($device,deviceid);
        //取出正常考勤的时间段设置
        $check_time = M("DormitoryCheckTime")->where("schoolid = '$this->schoolid'")->find();
        if(empty($check_time)){
            $time_morning1="06:00";
            $time_morning2="08:00";
            $time_noon1="11:30";
            $time_noon2="13:30";
            $time_afternoon1="16:30";
            $time_afternoon2="18:30";
            $time_night1="20:30";
            $time_night2="22:30";
        }else{
            $time_morning1=$check_time[time_morning1];
            $time_morning2=$check_time[time_morning2];
            $time_noon1=$check_time[time_noon1];
            $time_noon2=$check_time[time_noon2];
            $time_afternoon1=$check_time[time_afternoon1];
            $time_afternoon2=$check_time[time_afternoon2];
            $time_night1=$check_time[time_night1];
            $time_night2=$check_time[time_night2];
        }

        //开始查找记录

        $student = M("StudentInfo")->where("id = '$studentid'and schoollid = '$this->schoolid'")->field("userid,stu_name")->find();
        $wheres["schoolid"]=$this->schoolid;
        $wheres["daytime"]=array(array('egt',"$startime"),array('elt',"$endtime"));
        $wheres["userid"]=$student[userid];
        $wheres["deviceid"]=array('in',$device);
        if($week !== '8'){
            $wheres["week"] = $week;
        }
        $count = M("FaceRecordDormitory")
                ->alias("frd")
                ->join("wxt_face_device fd on fd.id = frd.deviceid")
                ->where($wheres)
                ->field("frd.photourl,frd.week,frd.daytime,frd.histimefd.name as devicename")
                ->count();
        $page = $this->page($count, 20);
        $record = M("FaceRecordDormitory")
            ->alias("frd")
            ->join("wxt_face_device fd on fd.id = frd.deviceid")
            ->where($wheres)
            ->field("frd.photourl,frd.week,frd.daytime,frd.histime,fd.name as devicename")
            ->order("frd.id asc")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        foreach ($record as &$value){
            $histime="";
            $histime=$value[histime];
            if((($time_morning1 < $histime )and ($histime < $time_morning2)) || (($time_noon1 < $histime )and ($histime < $time_noon2)) || (($time_afternoon1 < $histime )and ($histime < $time_afternoon2)) || (($time_night1 < $histime )and ($histime < $time_night2))){
                $value[status]=1;
            }else{
                $value[status]=2;
            }

        }
        $this->assign("record",$record);
        $this->assign("build",$build);
        $this->assign("student",$student);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
        exit;
    }
    //考勤时间设置
    public function check_time(){
        $check =  M("DormitoryCheckTime")->where("schoolid = '$this->schoolid'")->find();
        $this->assign("check_time",$check);
        $this->display();
        exit;
    }
    //考勤时间设置提交
    function check_time_post()
    {
        $data = I("data");

        $time_morning1 = $data["time_morning1"];
        $time_morning2 = $data["time_morning2"];
        $time_noon1 = $data["time_noon1"];
        $time_noon2 = $data["time_noon2"];
        $time_afternoon1 = $data["time_afternoon1"];
        $time_afternoon2 = $data["time_afternoon2"];
        $time_night1 = $data["time_night1"];
        $time_night2 = $data["time_night2"];
        if($time_night2<$time_night1){
            $ret = $this->format_ret(0,"晚上进出正常时间段设置错误，请重新设置");
            echo json_encode($ret);
            exit;
        }
        if($time_afternoon2<$time_afternoon1){
            $ret = $this->format_ret(0,"下午进出正常时间段设置错误，请重新设置");
            echo json_encode($ret);
            exit;
        }
        if($time_noon2<$time_noon1){
            $ret = $this->format_ret(0,"中午进出正常时间段设置错误，请重新设置");
            echo json_encode($ret);
            exit;
        }
        if($time_morning2<$time_morning1){
            $ret = $this->format_ret(0,"早上进出正常时间段设置错误，请重新设置");
            echo json_encode($ret);
            exit;
        }
        if(empty($time_morning1) || empty($time_morning2) || empty($time_noon1) || empty($time_noon2) || empty($time_afternoon1) || empty($time_afternoon2) || empty($time_night1) || empty($time_night2) ){
            $ret = $this->format_ret(0,"未获取必要参数，请填写全部时间");
            echo json_encode($ret);
            exit;
        }
        $isschool= M("DormitoryCheckTime")->where("schoolid = '$this->schoolid'")->find();
        $data['time_morning1']=$time_morning1;
        $data['time_morning2']=$time_morning2;
        $data['time_noon1']=$time_noon1;
        $data['time_noon2']=$time_noon2;
        $data['time_afternoon1']=$time_afternoon1;
        $data['time_afternoon2']=$time_afternoon2;
        $data['time_night1']=$time_night1;
        $data['time_night2']=$time_night2;
        if(empty($isschool)){
            $data['schoolid'] = $this->schoolid;
            M("DormitoryCheckTime")->add($data);
        }else{
            M("DormitoryCheckTime")->where("schoolid = '$this->schoolid' ")->save($data);
        }
        $ret = $this->format_ret(1,'保存成功');


        echo json_encode($ret);
        exit;
    }
    //拼接json字符串
    private function format_ret ($status, $data='') {
        if ($status){
            return array('status'=>'success', 'data'=>$data);
        }else{
            return array('status'=>'error', 'data'=>$data);
        }
    }
    /**
     * 低于PHP 5.5版本的array_column()函数
     **/
    private function array_column($input, $columnKey, $indexKey = NULL)
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
}

