<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;

class ColumnManageController extends AdminbaseController {

    protected $school_column_model;

    function _initialize() {
        parent::_initialize();
        $this->school_column_model = M("school_column");
    }

    function getCate($data, $id, $count = 0)
    {
        static $res = array();
        foreach ($data as $val) {
            if ($val['parentid'] == $id) {
                $val['count'] = $count;
                //var_dump($val['pid']);
                //var_dump($val);
                $res[] = $val;
                $this->getCate($data, $val['id'], $count + 1);
            }
        }
        return $res;
    }

    public function index() {
        $Province=role_admin();
        $this->assign("Province",$Province);

        $pro = I("province"); //地区

        if($pro){
            $this->assign("province",$pro);
        }

        $citys = I("citys");
        if($citys){
            $this->assign("new_citys",$citys);
        }

        $message_type = I("message_type");
        if($message_type){
            $this->assign("new_message_type",$message_type);
        }

        $schoolid = I("schoolid"); //学校
        if($schoolid){
            $where["wxt_school_column.schoolid"]=$schoolid;
            $this->assign("schoolid",$schoolid);
        }else{
            $where["wxt_school_column.schoolid"]=0;
        }


        if($pro && $citys)
        {
            //写入缓存
            write_condition($pro,$citys,$message_type,$schoolid,$this->only_code);

        }
        $cache_data = get_condition_cache($this->only_code);
        $this->assign("cache_data",$cache_data);


        $count = $column = $this->school_column_model->
        join("wxt_school on wxt_school_column.schoolid=wxt_school.schoolid")->
        where($where)->field("wxt_school_column.*,wxt_school.school_name")->order("wxt_school_column.schoolid desc,sortid desc")->count();

        $page = $this->page($count,20);
        $column = $this->school_column_model->
        join("wxt_school on wxt_school_column.schoolid=wxt_school.schoolid")->
        limit($page->firstRow . ',' . $page->listRows)->
        where($where)->field("wxt_school_column.*,wxt_school.school_name")->order("wxt_school_column.schoolid desc,sortid desc")->select();

        $this->assign("Page", $page->show('Admin'));

        $result = $this->getCate($column,0);
//        dump($result);
        foreach ($result as &$val)
        {
            $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
        }

//        $this->assign("column",$column);
        $this->assign("column",$result);
        $this->display();
    }


    function add(){
        $Province=role_admin();
        $this->assign("Province",$Province);
        $pro = I("province"); //地区

        if($pro){
            $this->assign("province",$pro);
        }

        $citys = I("citys");
        if($citys){
            $this->assign("new_citys",$citys);
        }

        $message_type = I("message_type");
        if($message_type){
            $this->assign("new_message_type",$message_type);
        }


        $schoolid = I("schoolid"); //学校
        if($schoolid){
            $column = $this->school_column_model->where("schoolid = $schoolid")->order("sortid desc")->select();
            $result = $this->getCate($column,0);
            foreach ($result as &$val)
            {
                $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
            }
            $this->assign("column",$result);
            $this->assign("schoolid",$schoolid);

        }else{
            $where["a.schoolid"]=0;
        }

        if($pro && $citys)
        {
            //写入缓存
            write_condition($pro,$citys,$message_type,$schoolid,$this->only_code);

        }
        $cache_data = get_condition_cache($this->only_code);
        $this->assign("cache_data",$cache_data);
      $this->display();
    }

    //查找学校微网站的分类
    public function find_column()
    {
        $schoolid=I("schoolid");
        $column = $this->school_column_model->where("schoolid = $schoolid")->order("sortid desc")->select();
        $result = $this->getCate($column,0);
        foreach ($result as &$val)
        {
            $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
        }
        if($result)
        {
            echo json_encode(array("status"=>1,"data"=>$result));
        }else{
            echo json_encode(array("status"=>0,"data"=>0));
        }

    }

    
    function add_post(){
        $province = I("province");
        $citys = I('citys');
        $message_type = I('message_type');
        $schoolids = I("schoolid");
        //dump($_POST['smeta']['thumb']);
            $data = $this->school_column_model->create();
            //dump($data);
            //die();
            if($data){
                if($_POST['smeta']['thumb']){
                    $data["icon"] = $_POST['smeta']['thumb'];//图标
                }else{
                    $data["icon"] = "http://ow3hm6y11.bkt.clouddn.com/img03.png";//图标
                }
                //$data["icon"] = $_POST['smeta']['thumb'];//图标
                $result = $this->school_column_model->add($data); // 写入数据到数据库
                if($result){
                    $this->success("新增成功！",U("add",array("province"=>$province,"citys"=>$citys,"message_type"=>$message_type,"schoolid"=>$schoolids)));
                }else{
                    $this->error("新增失败！");
                }
            }else{
                $this->error("表单验证失败！");
            }

    }

    public function edit(){

        $province = I("province");
        $this->assign("province",$province);
        $citys = I('citys');
        $this->assign("citys",$citys);
        $message_type = I('message_type');
        $this->assign("message_type",$message_type);
        $schoolids = I("schoolids");
        $this->assign("schoolids",$schoolids);

        if($province && $citys)
        {
            //写入缓存
            write_condition($province,$citys,$message_type,$schoolids,$this->only_code);

        }
        $cache_data = get_condition_cache($this->only_code);
        $this->assign("cache_data",$cache_data);

        $id=  intval(I("id"));
        $schoolid = I("schoolid");

        $query = $this->school_column_model->where("schoolid = $schoolid")->order("sortid desc")->select();
        $result = $this->getCate($query,0);
        foreach ($result as &$val)
        {
            $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
        }
        $this->assign("result",$result);


        $column_type= I("column_type");
        $this->assign("column_type",$column_type);
        $school =M("school")->where(array("schoolid"=>$schoolid))->field("schoolid,school_name")->find();
        $this->assign("school",$school);
        $column = $this->school_column_model->where(array("id"=>$id))->find();

        $this->assign("parentid",$column["parentid"]);
        $this->assign("column",$column);
        $this->display();
    }
    
    public function edit_post(){
//        dump($_POST['smeta']['thumb']);
//        die();
        $province = I("province");
        $citys = I('citys');
        $message_type = I('message_type');
        $schoolids = I("schoolids");

        $data = $this->school_column_model->create();
        if($data){
            //$data["icon"] = $_POST['smeta']['thumb'];//图标
            if($_POST['smeta']['thumb']){
                $data["icon"] = $_POST['smeta']['thumb'];//图标
            }else{
                $data["icon"] = "http://ow3hm6y11.bkt.clouddn.com/img03.png";//图标
            }
            $result = $this->school_column_model->save($data); // 写入数据到数据库
            if($result){
                $this->success("修改成功！",U("index",array("province"=>$province,"citys"=>$citys,"message_type"=>$message_type,"schoolid"=>$schoolids)));
            }else{
                $this->error("修改失败！");
            }
        }else{
            $this->error("表单验证失败！");
        }

    }
   

    function delete(){
         $id=intval($_GET['id']);
        $count = $this->school_column_model->where("parentid=$id")->select();
        if($count)
        {
            $this->error("这个菜单下还有子类,不能直接删除!请先删除子类!");
        }
        if ($id) {
            $rst = $this->school_column_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }




}