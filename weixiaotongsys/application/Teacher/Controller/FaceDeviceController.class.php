<?php

/**
 * 给设备分配教室或宿舍楼栋
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class FaceDeviceController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();
        $this->schoolid=$_SESSION['schoolid'];
        if(empty( $this->schoolid)){
            $this->error("未获取到学校，请重新登录");
            exit;
        }
    }
    //分配首页
    public function index(){
        $groupid = I("groupid");
        $devicename = I("devicename");
        $buildname = I("buildname");
        $where['fg.schoolid'] = $this->schoolid;
        if($groupid){
            $where['fg.id'] = $groupid;
            $this->assign("groupid",$groupid);
        }
        if($devicename){
            $where['fd.name'] = array('LIKE',"%".$devicename."%");
            $this->assign("groupid",$groupid);
        }
        if($buildname){
            $where['db.buildname'] = array('LIKE',"%".$buildname."%");
            $this->assign("buildname",$buildname);
        }
        $count = M("FaceDevice")
            ->alias("fd")
            ->join("wxt_face_group fg on fg.id=fd.tag")
            ->join("left outer join wxt_dormitory_facedevice df on df.deviceid=fd.id")
            ->join("left outer join wxt_dormitory_build db on db.id=df.buildid")
            ->where($where)
            ->count();
        $page = $this->page($count, 20);
        $device = M("FaceDevice")
            ->alias("fd")
            ->join("wxt_face_group fg on fg.id=fd.tag")
            ->join("left outer join wxt_dormitory_facedevice df on df.deviceid=fd.id")
            ->join("left outer join wxt_dormitory_build db on db.id=df.buildid")
            ->where($where)
            ->field("fd.name,fg.name as tagname,fd.id,db.buildname,db.id as buildid")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $group = M("FaceGroup")->where("schoolid = '$this->schoolid' ")->select();
        $this->assign("group",$group);
        $this->assign("device",$device);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
    }
    //提交分配
    public function assign_post(){
        $deviceid = I("deviceid");
        $buildid = I("buildid");
        if(empty( $deviceid) || empty($buildid)){
            $ret = $this->format_ret(0,"未获取必要参数，请刷新重试");
            echo json_encode($ret);
            exit;
        }
        $student = M("DormitoryFacedevice")->where("deviceid = '$deviceid'") ->find();
        if(!empty( $student)){
            $ret = $this->format_ret(0,"该设备已分配，请取消绑定后重试");
            echo json_encode($ret);
            exit;
        }
        $data["schoolid"] = $this->schoolid;
        $data["deviceid"] = $deviceid;
        $data["buildid"] = $buildid;
        M("DormitoryFacedevice")->add($data);
        $ret = $this->format_ret(1,'入住成功');
        echo json_encode($ret);
        exit;
    }
    //取消分配
    public function del_device(){
        $deviceid = I("deviceid");
        if(empty( $deviceid)){
            $ret = $this->format_ret(0,"未获取必要参数，请刷新重试");
            echo json_encode($ret);
            exit;
        }
        M("DormitoryFacedevice")->where("deviceid = '$deviceid' and schoolid = '$this->schoolid'") ->delete();
        $ret = $this->format_ret(1,'取消绑定成功');
        echo json_encode($ret);
        exit;
    }
    public function buildlist(){
        $deviceid = I("deviceid");
        if(empty($deviceid)){
           $this->error("未获取到设备，请重试");
           exit;
        }

        $this->assign("deviceid",$deviceid);

        $buildname = I("buildname");
        $where['schoolid'] = $this->schoolid;
        if($buildname){
            $where['buildname'] = array('LIKE',"%".$buildname."%");
            $this->assign("buildname",$buildname);
        }
        $count = M("DormitoryBuild")
            ->where($where)
            ->count();
        $page = $this->page($count, 20);
        $build =M("DormitoryBuild")
            ->where($where)
            ->field("id,buildname")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $this->assign("build",$build);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->display();
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
}