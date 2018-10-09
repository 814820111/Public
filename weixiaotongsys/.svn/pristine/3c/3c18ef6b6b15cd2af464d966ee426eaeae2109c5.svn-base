<?php

/**
 * 后台首页  在线客服
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class OnlineServiceController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->service_model=D("Common/service");
        $this->service_school_model=D("Common/service_school");
        $this->complaint_model=D("Common/complaint");
        $this->wxtuser_model=D("Common/wxtuser");
    }
    //在线客服首页
    public function index() {
        echo "在线客服";
    }
    public function servicemanage(){
        //客服管理
        $count=$this->service_model->count();
        $page = $this->page($count, 20);
        $service =$this->service_model
            ->order("id ASC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        foreach($service as $key=>$value){
            //获取客服所在的城市名称
            $cityid=intval($service[$key]['city']);
//            $service[$key]['cityname']=M('city')->where("city_id = $cityid")->getField('city_name');
            $service[$key]['cityname']=M('city')->where("term_id = $cityid")->getField('name');
            //获取客服绑定的学校，并拼接
            $serviceid=intval($service[$key]['id']);
            $schoolid_arr=$this->service_school_model->where("service_id = $serviceid")->select();
            $schoolid_str='';
            foreach($schoolid_arr as $k=>$v){
                $schoolid_str=$schoolid_str.','.$schoolid_arr[$k]['school_id'];
            }
            $service[$key]['schoolid_str']=substr($schoolid_str,1);
        }
        $this->assign("page", $page->show());
        $this->assign("service",$service);
        $this->display("servicemanage");
    }
    public function addservice(){
        $this->display('addservice');
    }
    public function addservice_post(){
        $this->error('该功能未启用！');
    }
    public function changeservice(){
        //修改客服资料
        $id=$_GET['id'];
        if(!empty($id)){
            $service=$this->service_model->where("id = $id")->find();
            $this->assign('service',$service);
            $this->assign('id',$id);
            $this->display('changeservice');
        }else{
            $this->error('传入数据失败！');
        }
    }
    public function deleteservice(){
        //删除客服
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->service_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    function changebind(){
        //修改绑定
        $id=$_GET['id'];
        if(!empty($id)){
            $service_school=$this->service_school_model->where("service_id = $id")->select();
            foreach($service_school as $key=>$value){
//                $serviceid=intval($service_school[$key]['service_id']);
                $schoolid=intval($service_school[$key]['school_id']);
//                $service_school[$key]['servicename']=$this->service_model->where("id=$serviceid")->getField('name');
                $service_school[$key]['schoolname']=M('school')->where("schoolid = $schoolid")->getField('school_name');
            }
//            dump($service_school);
            $this->assign('service_school',$service_school);
            $this->assign('id',$id);
            $this->display('changebind');
        }else{
            $this->error('传入数据失败！');
        }
    }
    function addbind(){
        //添加绑定
        $id=$_GET['id'];
        if(!empty($id)){
            $this->assign('id',$id);
            $this->display('addbind');
        }else{
            $this->error('传入数据失败！');
        }
    }
    function addbind_post(){
        $this->error("该功能暂时未开启！");
    }
    function delete_binding(){
        //删除绑定
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->service_school_model->where("r_id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    function complaint_manage(){
        //投诉管理
        $count = $this->complaint_model->count();
        $page = $this->page($count, 20);
        $complaint =$this->complaint_model
            ->order("complaint_status ASC , complaint_id DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $typename_arr=array(0=>'学生',1=>'教师',2=>'家长');
        $complaint_status_name=array(1=>'待处理',2=>'正在处理',3=>'已处理');
        foreach($complaint as $key=>$value){
            $complaint_user_id=intval($complaint[$key]['complaint_user_id']);
            $complaint[$key]['user_name']=$this->wxtuser_model->where("id = $complaint_user_id")->getField("name");
            $complaint[$key]['phone']=$this->wxtuser_model->where("id = $complaint_user_id")->getField("phone");
           // $complaint[$key]['user_type']=$this->wxtuser_model->where("id = $complaint_user_id")->getField("user_type");
            //$complaint[$key]['user_typename']=$typename_arr[intval($complaint[$key]['user_type'])];
            $complaint[$key]['user_status_name']=$complaint_status_name[intval($complaint[$key]['complaint_status'])];
        }
        $this->assign("complaint",$complaint);
        $this->display("complaint_manage");
    }
    function activecomplaint(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->complaint_model->where("complaint_id = $id")->save(array('complaint_status'=>2));
            if ($rst) {
                $this->success("开始成功！");
            } else {
                $this->error("开始失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    function deletecomplaint(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->complaint_model->where("complaint_id = $id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    function overcomplaint(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->complaint_model->where("complaint_id = $id")->save(array('complaint_status'=>3));
            if ($rst) {
                $this->success("结束成功！");
            } else {
                $this->error("结束失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
}

