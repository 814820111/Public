<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class FaceRecognitionController extends AdminbaseController{

    function _initialize() {
        parent::_initialize();
        $this->face_application_model = M("face_application");
        $this->face_group = M("face_group");
    }


    //获取识别记录
    public function record_index()
    {
        $Province=role_admin();
        $this->assign("Province",$Province);

        // dump($_GET);
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
            $where["a.schoolid"]=$schoolid;

            $group = M("face_group")->where("schoolid=$schoolid")->select();
            $this->assign("group",$group);

            $this->assign("schoolid",$schoolid);
        }else{
            $where["a.schoolid"]=0;
        }

        $type = I("type"); //类型
        if($type){
            $where["a.type"]=$type;
            $this->assign("type",$type);
        }

        //分组
        $device_group  = I("device_group");
        if($device_group){
            $where["b.tag"]=$device_group;
            $devices = M("face_device")->where("tag=$device_group")->select();
            //dump($devices);
            $this->assign("devices",$devices);
            $this->assign("device_group",$device_group);
        }
        //设备
        $device  = I("device");
        if($device){
            $where["a.deviceKey"]=$device;
            $this->assign("device",$device);
        }
//        $where["type"]=1; //表示注册的人
        $count = M("face_record as a")->join("wxt_face_device as b on a.deviceKey = b.deviceKey")->
        join("wxt_face_application as c on a.appid = c.id")->
        join("wxt_face_school_device as d on d.deviceid = b.id")->
        join("wxt_face_group as e on e.id = b.tag")->
        join("wxt_school as f on f.schoolid = a.schoolid")->
        where($where)->
        field("a.*,b.name as device_name,c.name as application_name,e.name as group_name,f.school_name")->count();
        $page = $this->page($count,20);

        $record = M("face_record as a")->join("wxt_face_device as b on a.deviceKey = b.deviceKey")->
        join("wxt_face_application as c on a.appid = c.id")->
        join("wxt_face_school_device as d on d.deviceid = b.id")->
        join("wxt_face_group as e on e.id = b.tag")->
        join("wxt_school as f on f.schoolid = a.schoolid")->
        where($where)->
        limit($page->firstRow . ',' . $page->listRows)->
        order("a.schoolid,a.showtime desc")->
        field("a.*,b.name as device_name,c.name as application_name,e.name as group_name,f.school_name")->select();

        $this->assign("Page", $page->show('Admin'));
        $this->assign("record",$record);
        $this->display();

    }

    //查询某一个分组下的设备
    public function find__group_device()
    {
        $groupid= I("groupid");
        $res = M("face_device")->where("tag=$groupid")->select();
        // dump($res);
        if($res){
            echo json_encode(array("status"=>true,"data"=>$res));
        }else{
            echo   json_encode(array("status"=>false,"data"=>"该分组下还没有设备"));
        }


    }

    //应用管理
    public function  application_index()
    {
        $application = $this->face_application_model->select();
        $this->assign("application",$application);
        $this->display();
    }

    //添加应用
    public function add_application()
    {
        $this->display();
    }

    //应用提交
    public function add_application_post()
    {
        $data = $this->face_application_model->create();
        if($data){
            $data["create_time"]=date('Y-m-d H:i:s', time());
            $data["create_time_int"]=time();
            $result = $this->face_application_model->add($data); // 写入数据到数据库
            if($result){
                $this->success("添加成功！",U("application_index"));
            }else{
                $this->error("添加失败！");
            }
        }else{
            $this->error("表单验证失败！");
        }
    }

    //人脸识别学校列表
    public function school_face_index()
    {
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
            $where["a.schoolid"]=$schoolid;
            $this->assign("schoolid",$schoolid);
        }

        $result =  M("face_school as a")->
        join("wxt_school as b on a.schoolid=b.schoolid")->
        where($where)->
        field("a.*,b.school_name")->
        select();

//        $result = M("face_school_device a")->
//        join("wxt_face_school e on a.faceschoolid=e.id")->
//        join("wxt_face_device b on a.deviceid=b.id")->
//        join("wxt_face_group c on b.tag=c.id")->
//        join("wxt_school d on e.schoolid=d.schoolid")->
//        where($where)->
//        order("e.schoolid")->
//
//        field("a.*,b.name as device_name,b.devicekey,c.name as group_name,d.school_name")
//            ->select();
        $this->assign("result",$result);
        $this->display();
    }

    //学校人脸识别 禁用 启用
    public function school_face_status()
    {
        $id =I("id");
        $state = I("state");
        if($state==1){
            $result =  M("face_school")->where(array("id"=>$id))->save(array("state"=>2));
        }
        if($state==2){
            $result = M("face_school")->where(array("id"=>$id))->save(array("state"=>1));
        }
        if($result){
            $this->success("修改成功！");
        }else{
            $this->success("修改成功！");
        }
    }

    //学校设备列表
    public function school_device_index()
    {
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
            $where["e.schoolid"]=$schoolid;
            $this->assign("schoolid",$schoolid);
        }

        $tiaojian= I("tiaojian"); //类型
        if($tiaojian){
            $this->assign("tiaojian",$tiaojian);

            $shuzhi= I("shuzhi"); //模糊查找
            if($shuzhi){
                $where["e.schoolid"]=array('gt','0');
                if($tiaojian=="deviceKey"){
                    $where["b.deviceKey"]=$shuzhi;
                }


                if($tiaojian=="name"){
                    $where["b.name"]=$shuzhi;
                }

                if($tiaojian=="group_name"){
                    $where["c.name"]=$shuzhi;
                }


                $this->assign("shuzhi",$shuzhi);
            }


        }

        $count = M("face_school_device a")->
        join("wxt_face_school e on a.faceschoolid=e.id")->
        join("wxt_face_device b on a.deviceid=b.id")->
        join("wxt_face_group c on b.tag=c.id")->
        join("wxt_school d on e.schoolid=d.schoolid")->
        join("wxt_face_application f on b.applicationid=f.id")->
        where($where)->
        order("e.schoolid")->
        field("a.*,b.name as device_name,b.devicekey,c.name as group_name,d.school_name")
            ->count();
        $page = $this->page($count,20);
        $result = M("face_school_device a")->
        join("wxt_face_school e on a.faceschoolid=e.id")->
        join("wxt_face_device b on a.deviceid=b.id")->
        join("wxt_face_group c on b.tag=c.id")->
        join("wxt_school d on e.schoolid=d.schoolid")->
        join("wxt_face_application f on b.applicationid=f.id")->
        where($where)->
        order("e.schoolid")->
        limit($page->firstRow . ',' . $page->listRows)->
        field("a.*,b.name as device_name,b.devicekey,b.applicationid,f.AppId,c.name as group_name,d.school_name,d.schoolid")
            ->select();


        if($schoolid){
            $teacher_num = M("teacher_info")->where(array("schoolid"=>$schoolid))->count();
            $student_num = M("student_info")->where(array("schoollid"=>$schoolid))->count();
            $parent_num = M("student_info a ")->join("wxt_relation_stu_user b on a.userid=b.studentid")->where(array("a.schoollid"=>$schoolid))->count();
            $schoolnum = $teacher_num+$student_num+$parent_num;
        }
        foreach ($result as &$value)
        {
            if($schoolnum){
                $value["num"]=$schoolnum;
            }else{
                $schoolid = $value["schoolid"];
                $teacher_num = M("teacher_info")->where(array("schoolid"=>$schoolid))->count();
                $student_num = M("student_info")->where(array("schoollid"=>$schoolid))->count();
                $parent_num = M("student_info a ")->join("wxt_relation_stu_user b on a.userid=b.studentid")->where(array("a.schoollid"=>$schoolid))->count();
                $num = $teacher_num+$student_num+$parent_num;
                $value["num"]=$num;
            }

            $deviceid = $value["deviceid"];
            $person = M("face_person_device_relation")->where(array("deviceid"=>$deviceid))->select();
            $count = count($person);
            $value["person_num"] = $count; //已授权人数
            $photo_num = 0;
            foreach ($person as $v)
            {

                $face_person = M("face_person")->where(array("Id"=>$v["personid"]))->find();
                $guid = $face_person["guid"];

                $photos = M("face_photo a")->join("wxt_face_photo_device_relation b on a.photoguid = b.photoguid")->
                where(array("a.guid"=>$guid,"b.state"=>3))->count();
                if($photos){
                    $photo_num++;
                    //continue;
                }
            }
            $value["photo_num"] = $photo_num; //图片授权人数
        }

        $this->assign("Page", $page->show('Admin'));
        $this->assign("result",$result);
        $this->display();
    }

    //添加学校设备
    public function add_school_device()
    {
        $Province=role_admin();
        $this->assign("Province",$Province);

//        $arr = M("face_school_device")->field("deviceid")->select();
//        //echo "<pre>";
//       // dump($arr);
//        if($arr){
//
//          $sql = "select * from  wxt_face_device  where id  not in(select deviceid from wxt_face_school_device)";
//          $devices = M()->query($sql);
//          //echo  $devices;
//          $this->assign("devices",$devices);
//        }else{
//            $devices = M("face_device")->select();
//            $this->assign("devices",$devices);
//        }
        $this->display();
    }

    //查找应用下的设备
    public function find_apption_device()
    {
        $arr = M("face_school_device")->field("deviceid")->select();
        //echo "<pre>";
        // dump($arr);
        $applicationid = I("applicationid");
        if($arr){

            $sql = "select * from  wxt_face_device  where id  not in(select deviceid from wxt_face_school_device) and applicationid=$applicationid";
            $devices = M()->query($sql);
        }else{
            $devices = M("face_device")->where(array("applicationid"=>$applicationid))->select();
        }

        if($devices)

            if($devices){
                echo json_encode(array("status"=>true,"data"=>$devices));
            }else{
                echo   json_encode(array("status"=>false,"data"=>"该应用下没有分组"));
            }
    }
    //添加学校设备
    public function add_school_device_post()
    {
        $schoolid = I("schoolid"); //学校ID
        $deviceid = I("deviceid"); //设备ID
        $device_group = I("device_group");//分组ID
        $applicationid = I("application");//应用ID
//        dump($_POST);
//        die();
        if(empty($schoolid) || empty($deviceid) ||empty($device_group) ||empty($applicationid))
        {
            $this->error("参数不足！");
            return;
        }
        //改动
        //查看原来是不是开通过这个学校
        $face_school = M("face_school")->where(array("schoolid"=>$schoolid))->find();
        if(empty($face_school))
        {
            $data["create_time"]=date('Y-m-d H:i:s', time());
            $data["schoolid"]=$schoolid;
            $data["type"]=1;
            $data["applicationid"]=$applicationid;
            $faceschoolid = M("face_school")->add($data); // 写入数据到数据库
        }else{
            $faceschoolid = $face_school["id"];
        }
        foreach($deviceid as $value){
            $data["create_time"]=date('Y-m-d H:i:s', time());
            $data["deviceid"]=$value;
//            $data["schoolid"]=$schoolid;
            $data["faceschoolid"]=$faceschoolid;
            $result = M("face_school_device")->add($data); // 写入数据到数据库
            //修改分组
            $name = "";
            $tag = $device_group;
            //修改设备tag//
            $this->edit_device($value,$name,$tag);
            //修改数据库tag
            M("face_device")->where("id= $value")->save(array("tag"=>$device_group));
        }

        if($result){
            $this->success("添加成功！");
        }else{
            $this->error("添加失败！");
        }

    }

    //修改设备名称
    public function edit_device_post()
    {
        $deviceid = I("deviceid");
        $name = I("name");
        $tag="";
//        echo $deviceid;
//        echo $name;
        //修改设备tag//
        $this->edit_device($deviceid,$name,$tag);
        //修改数据库tag
        M("face_device")->where("id= $deviceid")->save(array("name"=>$name));
        echo json_encode(array("修改成功"));
    }

    //学校设备删除
    public function school_device_delete()
    {
        $sid = I("id");

        $result =  M("face_school_device")->where("id=$sid")->delete();//删除数据库


        $id=I("deviceid");
        $applicationid=I("applicationid");
        $devicekey=I("devicekey");
        $appid=I("appid");
        //获取$token
        $token = $this->getfacetoken($applicationid);
        //调用删除接口
        $devices = $this->delete_device_people($appid,$token,$devicekey);
        if($devices["status"]==true){

            //删除设备挂钩的人员
            M("face_person_device_relation")->where("deviceid=$id")->delete(); //删除数据库人员数据
            $this->success("销权成功!");
            return;
        }

        if($devices["status"]==false){
            $data = "销权失败!".$devices["data"];
            $this->success($data);
            return;
        }


//        if($result){
//            $this->success("删除成功");
//        }else{
//            $this->success("删除失败");
//        }
    }

    //查询某一个学校设备分组
    public function find_school_group()
    {
        $schoolid= I("schoolid");
        $res = M("face_group")->where("schoolid=$schoolid")->select();
        // dump($res);
        $faces = M("face_school")->where(array("schoolid"=>$schoolid))->find();
        if($faces){
            $applicationid = $faces["applicationid"];
            $application = M("face_application")->where("id = $applicationid")->select();
        }else{
            $application = M("face_application")->select();
        }

        if($res){
            echo json_encode(array("status"=>true,"data"=>$res,"application_date"=>$application));
        }else{
            echo   json_encode(array("status"=>false,"data"=>"该学校还没有分组"));
        }


    }


    //添加学校设备分组
    public function school_group_index()
    {
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
            $where["a.schoolid"]=$schoolid;
            $this->assign("schoolid",$schoolid);
        }else{
            $where["a.schoolid"]=0;
        }

        $group = M("face_group a")->
        join("wxt_school b on a.schoolid=b.schoolid")->
        where($where)->
        field("a.*,b.school_name")->
        select();
        $this->assign("group",$group);
        $this->display();
    }

    //添加学校设备分组
    public function add_school_group()
    {
        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->display();
    }

    //添加学校设备分组提交
    public function add_school_group_post()
    {
        $schoolid = I("schoolid");
        $name  = I("name");
        $grouptype  = I("grouptype");
        if($schoolid and $name){
            $data["create_time"]=date('Y-m-d H:i:s', time());
            $data["create_time_int"]=time();
            $data["name"]=$name;
            $data["schoolid"]=$schoolid;
            $data["grouptype"]=$grouptype;
            $result = $this->face_group->add($data); // 写入数据到数据库
            if($result){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            }
        }else{
            $this->error("参数不足！");
        }
    }

    //设备列表
    public function device_index(){

        $server_state= I("server_state"); //类型
        if($server_state)
        {
            $where["a.server_state"]=$server_state;
            $this->assign("server_state",$server_state);
        }
        //dump($where);

        $tiaojian= I("tiaojian"); //类型
        if($tiaojian){
            $this->assign("tiaojian",$tiaojian);

            $shuzhi= I("shuzhi"); //模糊查找
            if($shuzhi){

                if($tiaojian=="deviceKey"){
                    $where["a.deviceKey"]=$shuzhi;
                }

                if($tiaojian=="appid"){
                    $where["b.AppId"]=$shuzhi;
                }
                if($tiaojian=="name"){
                    $where["a.name"]=$shuzhi;
                }



                $this->assign("shuzhi",$shuzhi);
            }
//            else{
//                $where["a.server_state"]=10;
//            }

        }


        $devices = M("face_device a")->
        join("wxt_face_application b on a.applicationid=b.id")->
        where($where)->
        field("a.*,b.name as application_name,b.AppId")->select();
        //dump($devices);
        $this->assign("devices",$devices);
        $this->display();

    }

    //添加设备
    public function add_device()
    {
        $application = $this->face_application_model->select();
        $this->assign("application",$application);
        $this->display();

    }

    //添加设备提交
    public function add_device_post()
    {

        $applicationid = I("applicationid"); //应用ID
        $deviceKey  = I("deviceKey"); //设备序列号
        $name  = I("name");
        if(empty($applicationid) || empty($name) || empty($deviceKey))
        {
            $this->error("参数不足！");
            return;
        }


        $data["create_time"]=date('Y-m-d H:i:s', time());
        $data["create_time_int"]=time();
        $data["name"]=$name;
        $data["deviceKey"]=$deviceKey;
        $data["applicationid"]=$applicationid;
        // 添加设备到数据库
        $query = M("face_device")->add($data);
        if(empty($query))
        {
            $this->error("添加失败！");
            return;
        }


        //通过刚才新增的数据 调用 接口  添加到设备到服务器
        //通过应用ID 获取 AppId  AppKey AppSecret 等 测试
        $application = $this->face_application_model->where(array("id"=>$applicationid))->find();
        $appid = $application["appid"];
        //获取$token
        $token = $this->getfacetoken($applicationid);
        //调用接口加入到服务器
        $devices = $this->insert_device($appid,$token,$deviceKey,$name);
        if($devices["status"]==true){
            M("face_device")->where("id=$query")->save(array("server_state"=>10)); // 修改状态
            M("face_device_config")->add(array("deviceid"=>$query)); //添加一个设备配置
            $this->success("设备添加成功!");
            return;
        }

        if($devices["status"]==false){
            $rst = M("face_device")->where("id=$query")->delete();
            $data = "设备添加失败!".$devices["data"];
            $this->success($data);
            return;
        }

    }

    //设备删除
    public function device_delete()
    {
        $id=I("id");
        $applicationid=I("applicationid");
        $devicekey=I("devicekey");
        $appid=I("appid");
        if(empty($id) || empty($applicationid) || empty($devicekey) || empty($appid))
        {
            $this->error('数据传入失败！');
            return;
        }
        //获取$token
        $token = $this->getfacetoken($applicationid);

        //调用删除接口
        $devices = $this->delete_device($appid,$token,$devicekey);
        if($devices["status"]==true){
            M("face_device")->where("id=$id")->delete(); //删除数据库设备
            M("face_device_config")->where("deviceid=$id")->delete();//删除数据库设备配置
            $this->success("设备删除成功!");
            return;
        }

        if($devices["status"]==false){
            $data = "设备删除失败!".$devices["data"];
            $this->success($data);
            return;
        }


    }


    //设备人员删除
    public function device_people_delete()
    {
        $id=I("id");
        $applicationid=I("applicationid");
        $devicekey=I("devicekey");
        $appid=I("appid");
        if(empty($id) || empty($applicationid) || empty($devicekey) || empty($appid))
        {
            $this->error('数据传入失败！');
            return;
        }
        //获取$token
        $token = $this->getfacetoken($applicationid);

        //调用删除接口
        $devices = $this->delete_device_people($appid,$token,$devicekey);
        if($devices["status"]==true){

            //删除设备挂钩的人员
            M("face_person_device_relation")->where("deviceid=$id")->delete(); //删除数据库人员数据
            $this->success("销权成功!");
            return;
        }

        if($devices["status"]==false){
            $data = "销权失败!".$devices["data"];
            $this->success($data);
            return;
        }


    }

    //设备同步
    public function device_synchronization()
    {
        $id=I("id");
        $applicationid=I("applicationid");
        $devicekey=I("devicekey");
        $appid=I("appid");
        if(empty($id) || empty($applicationid) || empty($devicekey) || empty($appid))
        {
            $this->error('数据传入失败！');
            return;
        }
        //获取$token
        $token = $this->getfacetoken($applicationid);

        //调用同步接口
        $devices = $this->synchronization_device($appid,$token,$devicekey);
        if($devices["status"]==true){
            $this->success("设备同步成功!");
            return;
        }

        if($devices["status"]==false){
            $data = "设备同步失败!".$devices["data"];
            $this->success($data);
            return;
        }


    }

    //设备状态查询
    public function select_device()
    {
        $applicationid=I("applicationid");
        $devicekey=I("devicekey");
        $appid=I("appid");
        if( empty($applicationid) || empty($devicekey) || empty($appid))
        {
            return  array("status"=>false,"data"=>"参数不足");

        }

        //获取$token
        $token = $this->getfacetoken($applicationid);

        //调用设备查询接口
        $devices = $this->query_device($appid,$token,$devicekey);
        if($devices["status"]==false){
            $data = "设备查询失败!".$devices["data"];
            $this->success($data);
            return;
        }
        //修改本地的设备状态
        M("face_device")->where(array("deviceKey"=>$devicekey))->save(array("server_state"=>$devices["data"]["state"]));
        echo json_encode($devices);
    }

    //查询设备配置
    public function device_config()
    {
        $id=I("id"); //设备ID
        $applicationid=I("applicationid"); //应用ID
        $devicekey=I("devicekey"); //设备序列号
        $appid=I("appid"); //应用APPid
        if( empty($applicationid) || empty($devicekey) || empty($appid))
        {
            return  array("status"=>false,"data"=>"参数不足");

        }
        //获取$token
        $token = $this->getfacetoken($applicationid);

        $devices_config = $this->query_device_setting($appid,$token,$devicekey);
        //echo "<pre>";
        //print_r($devices_config);
        if($devices_config["status"]==true){

            //拉取服务器设备配置,更新到本地数据库
            M("face_device_config")->where(array("deviceid"=>$id))->save($devices_config["data"]);
            $config = M("face_device_config")->where(array("deviceid"=>$id))->find();
            $this->assign("configid", $config["id"]);
//            echo "<pre>";
//            print_r($config);
            $this->assign("config", $config);
            $this->display();
        }

        if($devices_config["status"]==false){
//            $data = "设备删除失败!".$devices["data"];
//            $this->success($data);
//            return;
            //echo "查询失败";
            $this->display();
        }
    }

    //设备配置提交
    public function device_config_post()
    {
//        echo "<pre>";
//        print_r($_POST);
        if($_POST["configid"]){
            $id = $_POST["configid"];
        }
        if($_POST["ttsModContent"]){
            $data["ttsModContent"] = $_POST["ttsModContent"];
        }
        if($_POST["ttsModType"]){
            $data["ttsModType"] = $_POST["ttsModType"];
        }
        if($_POST["displayModType"]){
            $data["displayModType"] = $_POST["displayModType"];
        }
        if($_POST["displayModContent"]){
            $data["displayModContent"] = $_POST["displayModContent"];
        }
        if($_POST["comModType"]){
            $data["comModType"] = $_POST["comModType"];
        }
        if($_POST["comModType"]){
            $data["comModContent"] = $_POST["comModContent"];
        }
        if($_POST["recStrangerType"]){
            $data["recStrangerType"] = $_POST["recStrangerType"];
        }
        if($_POST["ttsModStrangerType"]){
            $data["ttsModStrangerType"] = $_POST["ttsModStrangerType"];
        }
        if($_POST["ttsModStrangerContent"]){
            $data["ttsModStrangerContent"] = $_POST["ttsModStrangerContent"];
        }
        if($_POST["recStrangerTimesThreshold"]){
            $data["recStrangerTimesThreshold"] = $_POST["recStrangerTimesThreshold"];
        }
        if(is_numeric($_POST["recDisModType"])){
            $data["recDisModType"] = $_POST["recDisModType"];
        }
        if($_POST["recScore"]){
            $data["recScore"] = $_POST["recScore"];
        }
        if($_POST["recTimeWindow"]){
            $data["recTimeWindow"] = $_POST["recTimeWindow"];
        }
        if($_POST["recTimeWindowInSeconds"]){
            $data["recTimeWindowInSeconds"] = $_POST["recTimeWindowInSeconds"];
        }
        if($_POST["previewModType"]){
            $data["previewModType"] = $_POST["previewModType"];
        }
        if($_POST["orientationType"]){
            $data["orientationType"] = $_POST["orientationType"];
        }
        if($_POST["nameType"]){
            $data["nameType"] = $_POST["nameType"];
        }
        if($_POST["intro"]){
            $data["intro"] = $_POST["intro"];
        }
        if($_POST["slogan"]){
            $data["slogan"] = $_POST["slogan"];
        }
        $result = M("face_device_config")->where("id=$id")->save($data); // 写入数据到数据库

        $devices = $this->edit_device_setting($id);
        if($devices["status"]==true){
            $this->success("修改配置成功!");
            return;
        }

        if($devices["status"]==false){
            $data = "修改配置失败!".$devices["data"];
            $this->success($data);
            return;
        }
    }

    //人员授权 列表
    public function person_list()
    {
        $deviceid  = I("deviceid");//设备ID
        $this->assign("deviceid",$deviceid);
        //echo $deviceid;
        $devicekey= I("devicekey"); //设备key
        $this->assign("devicekey",$devicekey);
        $applicationid = I("applicationid");
        $this->assign("applicationid",$applicationid);
        $appid = I("appid");
        $this->assign("appid",$appid);


        $auth = I('auth');
        $tiaojian = I('tiaojian');
        $keyword = I('keyword');
        if($applicationid)
        {
            $where['fa.id']=$applicationid;
        }
        if($auth)
        {
            $where['fp.authstatus']=$auth;
            $this->assign("auth",$auth);
        }
        if($deviceid)
        {
            $join_device="wxt_face_person_device_relation fpd ON fpd.personid=fp.Id";
            $where['fpd.deviceid']=$deviceid;
        }
        if($tiaojian && $keyword){
            $this->assign("tiaojian",$tiaojian);
            $this->assign("keyword",$keyword);
            if($tiaojian == 'name'){
                $where['fp.name']= array("like","%".$keyword."%");
            }
            if($tiaojian == 'guid'){
                $where['fp.guid']= array("like","%".$keyword."%");
            }
            if($tiaojian == 'cardno'){
                $where['fp.idNo']= array("like","%".$keyword."%");
            }
        }

        $schoolid = I("schoolid");
        $this->assign("schoolid",$schoolid);
        $where['fp.schoolid'] = $schoolid;

//        dump($where);
//        dump($join_device);
        $person1=M("FacePerson")
            ->alias("fp")
            ->join("wxt_face_application fa ON fa.Id=fp.appid")
            ->join($join_device)
            ->where($where)
            ->field('fa.name as appname,fa.Id as appid,fp.name,fp.Id as personid,fp.idNo,fp.authstatus,fp.guid,fp.create_time')
            ->select();

        if($auth==2)
        {
            $where["fp.authstatus"]=0;
        }else{
            $where["fp.authstatus"]=1;
        }

        unset($where["fpd.deviceid"]);
        $person2=M("FacePerson")
            ->alias("fp")
            ->join("wxt_face_application fa ON fa.Id=fp.appid")
            ->where($where)
            ->field('fa.name as appname,fa.Id as appid,fp.name,fp.Id as personid,fp.idNo,fp.authstatus,fp.guid,fp.create_time')
            ->select();

        $person =array_merge($person1,$person2);

        //$count = count($person3);




        $statue['1'] = "已上传";
        $statue['2'] = "注册中";
        $statue['3'] = "注册成功";
        $statue['4'] = "注册失败";
//        foreach ($person as &$value){
//            $photo=M('FacePhoto')->where("guid = '$value[guid]'")->select();
//            $value[photo]= '';
//            if(empty($photo)){
//                $value[photo]= '没有照片';
//            }else{
//                $i=1;
//                foreach ($photo as $kkk){
//                    $value[photo] .="<a href='".$kkk[photo]."' target='_Blank'>图片.".$i++."</a>(".$statue[$kkk[state]].")";
//                    if($i>1){
//                        $value[photo] .="<br>";
//                    }
//                }
//            }
//        }
        foreach ($person as &$valuezz){
            $photo=M('FacePhoto')->where("guid = '$valuezz[guid]'")->select();
            $valuezz[photo]= '';
            if(empty($photo)){
                $valuezz[photo]= '没有照片';
            }else{
                $i=1;
                foreach ($photo as $kkk){
                    $photoarray=M('FacePhotoDeviceRelation')->where("photoguid = '$kkk[photoguid]'")->field("devicename,state")->select();
                    $statuesss = '';
                    if(!empty($photoarray)){
                        foreach ($photoarray as $ooo) {
                            $statuesss .= '('.$ooo[devicename].'-'.$statue[$ooo[state]].')';
                        }
                    }

                    $valuezz[photo] .="<a href='".$kkk[photo]."' target='_Blank'>图片".$i++."</a>".$statuesss;
                    if($i>1){
                        $valuezz[photo] .="<br>";
                    }
                }
            }
        }
        foreach ($person as &$values){
            $device=M('FacePersonDeviceRelation')
                ->alias("fdr")
                ->join('wxt_face_device fd ON fd.Id=fdr.deviceid')
                ->where("fdr.personid = '$values[personid]'")
                ->field("fd.name")
                ->select();
            $value[device]= '';
            if(empty($device)){
                $values[device]= '未授权';
            }else{
                $i=1;
                foreach ($device as $jjj){
                    $values[device] .=$jjj[name]."已授权";$i++;
                    if($i>1){
                        $value[device] .="<br>";
                    }
                }
            }
        }
        //dump($person);
//        $this->assign("Page", $page->show('Admin'));
        $this->assign("person",$person);
        $this->display();
    }

    //设备人员授权人员
    public function device_person_authorize()
    {
        $userid = I('userid');

        $applicationid=I("applicationid"); //应用ID
        $deviceKey=I("devicekey");  //设备key
        $appid=I("appid");  //应用APPID
//        if(empty($deviceid)){
//            $ret=array('status'=>'field',
//                'msg'=>'未选择设备');
//            echo  json_encode($ret);
//            exit;
//        }

        $token = $this->getfacetoken($applicationid);
        $res = M("face_device")->where(array("deviceKey"=>$deviceKey))->find();
        $deviceid = $res["id"];
        $userids = explode(',',$userid);
        $new_array =array();
        foreach ($userids as $value){
            $person = M('FacePerson')->where(array("Id"=>$value))->find();
            $personGuid = $person['guid'];
            array_push($new_array,$personGuid);
        }
        $personGuid = implode(",",$new_array);
//

        $person = $this->devices_person_authorize($appid,$token,$deviceKey,$personGuid);

        if($person[success]){
            foreach ($userids as $value){
                $datas['authstatus'] =2;
                M('FacePerson')->where(array("Id"=>$value))->save($datas);
                $data[personid]=$value;
                $data[deviceid]=$deviceid;
                $restult = M("FacePersonDeviceRelation")->where($data)->find();
                if(empty($restult)){
                    M("FacePersonDeviceRelation")->add($data);
                }
            }

        }

        $ret=array('status'=>'success');
        echo  json_encode($ret);
        exit;

    }




    //获取token
    private function getfacetoken($id)
    {
        // echo $id;
        //   $id = I("id"); //应用自增长ID


        $result = M("face_application")->where(array("id"=>$id))->find(); //令牌刷新时间
        $appid = $result["appid"];

        $appKey = $result["appkey"];

        $appsecret = $result["appsecret"];
        $timestamp = time();
        $sign = md5($appKey.$timestamp.$appsecret);
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/auth";

        $time = $result["token_expire_time_int"]; //令牌有效时间
        //第一次是access_token不存在 就重新获取一个
        if (time()>$time  || empty($time)) {
            $data=array(
                "appId"=>$appid,
                "appKey"=>$appKey,
                "timestamp"=>time(),
                "sign"=>$sign
            );
            $res =$this->http_request_post($url,$data);
            $result = json_decode($res,true);
            if($result["code"]=="GS_SUS100"){
                $token = $result["data"];
                //10个小时
                $data["token_expire_time_int"] = time()+36000;
                $times = time()+36000;
                $data["token_expire_time"] = date('Y-m-d H:i:s', $times);
                $data["token"]     = $token;
                $data["token_refresh_time_int"]     = time();
                $data["token_refresh_time"]     = date('Y-m-d H:i:s', time());
                $res   = M("face_application")->where(array("id"=>$id))->save($data);
            }else{
                echo $result["code"];
            }
            //重新写进 数据库

        } else {
            $arr = M("face_application")->where(array("id"=>$id))->find(); //令牌刷新时间
            $token = $arr["token"];
        }
        return  $token;
    }

    private function http_request_post($url, $data = array())
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
    private function http_request_get($url){
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL,$url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $output = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //print_r($output);
        return $output;
    }
    private function http_request_put($url, $data = array())
    {
        $ch = curl_init(); //初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PUT"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置提交的字符串
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    private function http_request_delete($url,$data){
        $ch = curl_init();
        curl_setopt ($ch,CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    //创建设备
    /*      post
            appId	   应用Id	    String	Y
            token	   调用接口凭证	String	Y
            deviceKey  设备序列号	    String	Y
            name	   设备名称	    String	N
            tag	       设备标签	    String	N
     *      返回结果: code : GS_EXP-321 如果序列号已被占用,就无法添加这个设备,得先删除才能添加
     *      返回结果: code :GS_EXP-342 设备离线则接口调用失败
     *      返回结果: code: GS_SUS300, //设备录入接口调用成功，指设备确认已经录入到云端服务器中
     *      返回结果: code: GS_SUS320, //设备录入接口调用失败，设备离线
     */
    private function insert_device($appid,$token,$deviceKey,$name)
    {
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device";

        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "deviceKey"=>$deviceKey,
            "name"=>$name,
        );
        $res = $this->http_request_post($url,$data);
        $result = json_decode($res,true);
        if($result["code"]=="GS_SUS300"){
            return  array("status"=>true,"data"=>"设备添加成功");
        }else{
            return  array("status"=>false,"data"=>$result["code"]);
        }
    }

    //设备删除
    /*    delete
    *     appId	  应用Id	       String	Y
          token	  调用接口凭证   String	Y
          deviceKey  设备序列号	   String	Y
          返回结果: code : GS_SUS302 //
          设备删除接口调用成功，指设备已经从云端服务器删除，设备与appId解绑；若设备在线，则云端推送删除操作给设备，并清空设备内存储的人员数据信息,数据不能恢复；
          设备离线，则联网后自动进行删除操作
    */
    private function delete_device($appid,$token,$deviceKey)
    {
//        $appid = "9458FA929B0449D58F91D122F162B12C";
//        $token =  "5b46506d2a54e58b7a8d73a67912996127ddac692f499c33e40a76be886689df";
//        $deviceKey = "84E0F42000F100B0";

        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "deviceKey"=>$deviceKey
        );
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device/".$deviceKey;

        $res = $this->http_request_delete($url,$data);
        $result = json_decode($res,true);
        if($result["code"]=="GS_SUS302"){
            return  array("status"=>true,"data"=>"设备删除成功");
        }else{
            return  array("status"=>false,"data"=>$result["code"]);
        }
    }

    //设备查询
    /*     get
     *     appId	  应用Id	       String	Y
           token	  调用接口凭证   String	Y
           deviceKey  设备序列号	   String	Y
           返回结果: code : GS_SUS301 //设备查询接口调用成功
     */
    private function  query_device($appid,$token,$deviceKey)
    {

        $data = "?appId=".$appid."&token=".$token."&deviceKey=".$deviceKey;
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device/".$deviceKey.$data;

        $res = $this->http_request_get($url);
        $result = json_decode($res,true);
        if($result["code"]=="GS_SUS301"){
            return  array("status"=>true,"data"=>$result["data"]);
        }else{
            return  array("status"=>false,"data"=>$result["code"]);
        }

    }


    //设备查询配置
    /*     get
     *     appId	  应用Id	       String	Y
           token	  调用接口凭证   String	Y
           deviceKey  设备序列号	   String	Y
           返回结果: code : GS_SUS334 //查询设备配置接口调用成功
     */
    private function  query_device_setting($appid,$token,$deviceKey)
    {

        $data = "?appId=".$appid."&token=".$token."&deviceKey=".$deviceKey;
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device/".$deviceKey."/setting".$data;


        $res = $this->http_request_get($url);
        $result = json_decode($res,true);
        //return $result;
        if($result["code"]=="GS_SUS334"){
            return  array("status"=>true,"data"=>$result["data"]);
        }else{
            return  array("status"=>false,"data"=>$result["code"]);
        }


    }

    //修改设备配置
    /*     put
     *     appId	  应用Id	       String	Y
           token	  调用接口凭证   String	Y
           deviceKey  设备序列号	   String	Y
           返回结果: code : GS_SUS335 //查询设备配置接口调用成功
     */
    private function  edit_device_setting($id)
    {

        $devices = M("face_device_config a")->join("wxt_face_device b on a.deviceid=b.id")->where("a.id=$id")->field("a.*,b.applicationid")->find();
        $deviceKey = $devices["devicekey"]; //设备序列号
        $applicationid = $devices["applicationid"];
        $token = $this->getfacetoken($applicationid); //token
        $application = M("face_application")->where("id=$applicationid")->find();
        $appid = $application["appid"]; //应用Id

        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "deviceKey"=>$deviceKey
        );

        if($devices["ttsmodcontent"]){
            $data["ttsModContent"] = $devices["ttsmodcontent"];
        }
        if($devices["ttsmodtype"]){
            $data["ttsModType"] = $devices["ttsmodtype"];
        }
        if($devices["displaymodtype"]){
            $data["displayModType"] = $devices["displaymodtype"];
        }
        if($devices["displaymodcontent"]){
            $data["displayModContent"] = $devices["displaymodcontent"];
        }
        if($devices["commodtype"]){
            $data["comModType"] = $devices["commodtype"];
        }
        if($devices["commodcontent"]){
            $data["comModContent"] = $devices["commodcontent"];
        }
        if($devices["recstrangertype"]){
            $data["recStrangerType"] = $devices["recstrangertype"];
        }
        if($devices["ttsmodstrangertype"]){
            $data["ttsModStrangerType"] = $devices["ttsmodstrangertype"];
        }
        if($devices["ttsmodstrangercontent"]){
            $data["ttsModStrangerContent"] = $devices["ttsmodstrangercontent"];
        }
        if($devices["recstrangertimesthreshold"]){
            $data["recStrangerTimesThreshold"] = $devices["recstrangertimesthreshold"];
        }
        if(is_numeric($devices["recdismodtype"])){
            $data["recDisModType"] = $devices["recdismodtype"];
        }
        if($devices["recscore"]){
            $data["recScore"] = $devices["recscore"];
        }
        if($devices["rectimewindow"]){
            $data["recTimeWindow"] = $devices["rectimewindow"];
        }
        if($devices["rectimewindowinseconds"]){
            $data["recTimeWindowInSeconds"] = $devices["rectimewindowinseconds"];
        }
        if($devices["previewmodtype"]){
            $data["previewModType"] = $devices["previewmodtype"];
        }
        if($devices["orientationtype"]){
            $data["orientationType"] = $devices["orientationtype"];
        }
        if($devices["nametype"]){
            $data["nameType"] = $devices["nametype"];
        }
        if($devices["intro"]){
            $data["intro"] = $devices["intro"];
        }
        if($devices["slogan"]){
            $data["slogan"] = $devices["slogan"];
        }
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device/".$deviceKey."/setting";


        $res = $this->http_request_put($url,$data);
        $result = json_decode($res,true);
        //dump($result);
        if($result["code"]=="GS_SUS335"){
            return  array("status"=>true,"data"=>$result["data"]);
        }else{
            return  array("status"=>false,"data"=>$result["code"]);
        }


    }

    //设备更新
    /*    put
    *     appId	  应用Id	       String	Y
          token	  调用接口凭证   String	Y
          deviceKey  设备序列号	   String	Y
          name	     设备名称	String	N
          tag	     设备标签	String	N
          返回结果: code : GS_SUS332 //
          设备更新接口调用成功，指云端存储的设备信息更新。若设备在线，则推送更新信息给设备；若设备离线，则设备联网后自动接收更新信息
    */
    private function edit_device($deviceid,$name,$tag)
    {

//        $appid = "9458FA929B0449D58F91D122F162B12C";
//        $token =  "5b46506d2a54e58b7a8d73a67912996127ddac692f499c33e40a76be886689df";
//        $deviceKey = "84E0F42000F100B0";
//        $name="测试1";
//        $tag = "测试1";
        $devices = M("face_device")->where("id=$deviceid")->find();

        $deviceKey = $devices["devicekey"]; //设备序列号
        $applicationid = $devices["applicationid"];
        $token = $this->getfacetoken($applicationid); //token
        $application = M("face_application")->where("id=$applicationid")->find();
        $appid = $application["appid"]; //应用Id

        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "deviceKey"=>$deviceKey
        );
        if($name){
            $data["name"]=$name;
        }
        if($tag){
            $data["tag"]=$tag;
        }
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device/".$deviceKey;


        $res = $this->http_request_put($url,$data);
        $result = json_decode($res,true);
//        dump($result);
//        if($result["code"]=="GS_SUS332"){
//            echo  "设备更新成功";
//        }else{
//            echo $result["code"];
//        }
    }

    /** 新增结束 */
    /** 新增开始*/
    /**     POST    设备授权人员
     *      appId	应用Id	String	Y
    token	调用接口凭证	String	Y
    deviceKey	    设备序列号	String	Y
    personGuids	员工 GUID列表	String	Y	通过英文逗号拼接而成
    passTime	允许进入的时间段	String	N	范围为[00:00:00,23:59:59]，格式说明见备注
    返回结果: code : GS_SUS204 //人员录入接口调用成功，人员信息存入云端服务器
     */
    public function devices_person_authorize($appid,$token,$deviceKey,$personGuids)
    {
//        $appid = "9458FA929B0449D58F91D122F162B12C";
//        $deviceKey = "84E0F42000F100B0";
//        $token = "4694bad31d1783dc18ceb9e6dd39af268af3409566395fc09d39536f52b90156";
//        $personGuids= "7B0D4F5EC9D647D4BDBD31212D14C36D,";
        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "deviceKey"=>$deviceKey,
            "personGuids"=>$personGuids
        );

//        if($passTime){
//            $data['passTime']=$passTime;
//        }
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device/".$deviceKey."/people";
        $res = $this->http_request_post($url,$data);
        $result = json_decode($res,true);
//        print_r($result);
        //dump($result);
        return $result;
    }


    //设备同步
    /*      post
            appId	   应用Id	    String	Y
            token	   调用接口凭证	String	Y
            deviceKey  设备序列号	    String	Y
     *
     *      返回结果: code: GS_SUS318, //设备录入接口调用成功，指设备确认已经录入到云端服务器中
     *
     */
    private function synchronization_device($appid,$token,$deviceKey)
    {
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device/synchronization";


        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "deviceKey"=>$deviceKey
        );
        $res = $this->http_request_post($url,$data);
        $result = json_decode($res,true);
        if($result["code"]=="GS_SUS318"){
            return  array("status"=>true,"data"=>"设备同步成功");
        }else{
            return  array("status"=>false,"data"=>$result["code"]);
        }
    }

    //设备销权人员接口
    /*    delete
    *     appId	应用Id	String	Y
          token	调用接口凭证	String	Y
          deviceKey	设备序列号	String	Y
          personGuid	员工 GUID	String	N	若为空， 则清空该设备所有的授权记录
          本接口推荐在清空时使用（传入的personGuid为空即可），能够清空设备和云端里的授权人员信息，且数据无法通过同步恢复
          设备不与appId解绑
          "code": "GS_SUS328",//设备销权授权人员接口调用成功，若设备在线，则人员信息从设备删除，销权成功；若设备离线，则联网后自动进行人员信息删除和销权
    */
    private function delete_device_people($appid,$token,$deviceKey)
    {
        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "deviceKey"=>$deviceKey
        );
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/device/".$deviceKey."/people";

        $res = $this->http_request_delete($url,$data);
        $result = json_decode($res,true);
        if($result["code"]=="GS_SUS328"){
            return  array("status"=>true,"data"=>"设备销权人员接口调用成功");
        }else{
            return  array("status"=>false,"data"=>$result["code"]);
        }
    }

    /**    DELETE 人员删除
     *      appId	应用Id	String	Y
    token	调用接口凭证	String	Y
    guid	    需授权的人员	String	Y
    返回结果: "code": "GS_SUS201",//人员删除接口调用成功
     */
    private function person_delete($appid,$token,$guid)
    {
        $data=array(
            "appId"=>$appid,
            "token"=>$token,
            "guid"=>$guid
        );
        $url = "http://gs-api.uface.uni-ubi.com/v1/".$appid."/person/".$guid;

        $res = $this->http_request_delete($url,$data);
        $result = json_decode($res,true);
        return $result;
    }

}