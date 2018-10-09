<?php

/**
 * 后台首页  违纪管理
 */
namespace Apps\Controller;
use Common\Controller\AppBaseController;
header("Content-type: text/html; charset=utf-8");
class IllegalityController extends AppBaseController {
    function _initialize() {

        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];
        $this->Illegality = D("Common/Illegality");
        $this->illegality_student = D("Common/illegality_student");
        $this->illegality_type_detail = D("Common/illegality_type_detail");
        $this->Illegality_type = D("Common/Illegality_type");
        $this->education_type = D("Common/education_type");
    }
    //违纪首页  传参：page 可传可不传 类别：可穿可不穿
    public function index()
    {
        //分页类别
        $num = I("num");
        if(!$num)
        {
            $num = 10;
        }
       //还需要传一个分类id
        $type = I("type");
        $page = I("page");
        $start_page = $num * ($page-1);//每页第一条记录编号

        $schoolid = I("schoolid");

        //获取类别
        if($type)
        {
          $aid = $this->dis_sub_type($type);
          $where['detail.type_id'] = array("in",$aid);
        }

        $where['schoolid'] = $schoolid;

        //查询出该学校的违纪
        $Illegality = $this->Illegality
                      ->alias("I")
                      ->join("LEFT JOIN wxt_illegality_type_detail detail ON I.id=detail.illegalityid")
                      ->field("I.id,I.userid,I.illegality_event,I.illegality_time,I.create_time")
                      ->limit($start_page. ',' . $num)
                      ->where($where)
                      ->select();
        //先这样写，后期再优化
        foreach($Illegality as &$val)
        {
            $Illegalityid = $val['id'];
            $illegality_student = $this->dis_class(1,$this->illegality_student->where(array("illegalityid"=>$Illegalityid,"schoolid"=>$schoolid))->select(),$schoolid);

            $val['student_name'] =  $illegality_student;
            $val['name'] = M("teacher_info")->where(array("teacherid"=>$val['userid']))->getField("name");
        }
        if($Illegality)
        {
            $res  = $this->format_ret_else(1,$Illegality);
        }else{
            $res  = $this->format_ret_else(0,"no data");
        }
        echo json_encode($res);
    }

    //获取大类中的子类
    private function dis_sub_type($type)
    {
        $schoolid = I("schoolid");
        $where_type['parent'] = array("in",$type);
        $where_type['schoolid'] = $schoolid;
        $Illegality_type = $this->Illegality_type->where($where_type)->select();
        $aid = "";
        foreach($Illegality_type as $val)
        {
            $aid = $val['id'].",".$aid;

        }
        return trim($aid,",");
    }
    //获取违纪首页违纪大类
    public function big_class()
    {
        $schoolid = I("schoolid");
        $type_parent =$this->Illegality_type->where(array("schoolid"=>$schoolid,"parent"=>0))->select();
        if($type_parent)
        {
            $res  = $this->format_ret_else(1,$type_parent);
        }else{
            $res  = $this->format_ret_else(0,"no data");
        }
        echo json_encode($res);
    }
    //违纪提交
    public function add_post()
    {
        //学生id
        $studentid = I("studentid");
        //违纪类别
        $Illegality_type = I("Illegality_type");
        //违纪事件
        $illegality_event = I("illegality_event");
        //违纪时间
        $time = I("time");
        //通知家长
        $notice_parent = I("notice_parent");

        $schoolid = I("schoolid");

        $data['schoolid'] = $schoolid;
        $data['illegality_event'] = $illegality_event;
        $data['userid'] = I("userid");
        $data['notice_parent'] = $notice_parent;
        $data['illegality_time'] = $time;
        $data['create_time'] = time();

        $addData = $this->Illegality ->add($data);
        if($data)
        {
            //添加学生
           $this->add_student_post(0,$addData,$studentid,$schoolid);
           //添加类别
           $this->add_Illegality_type(0,$addData,$Illegality_type);
           $res = $this->format_ret_else(1,$addData);
        }else{
            $res = $this->format_ret_else(0,'no data');
        }
         echo json_encode($res);

    }

    //编辑详情提交
    public function edit_post()
    {
        $Illegalityid = I("id");
        //学生id
        $studentid = I("studentid");
        //违纪类别
        $Illegality_type = I("Illegality_type");
        //违纪事件
        $illegality_event = I("illegality_event");
        //违纪时间
        $time = I("time");
        //通知家长
        $notice_parent = I("notice_parent");
        $schoolid = I("schoolid");
        $data['schoolid'] = $schoolid;
        $data['illegality_event'] = $illegality_event;
        $data['userid'] = I("userid");
        $data['notice_parent'] = $notice_parent;
        $data['illegality_time'] = $time;
        $data['create_time'] = time();

        $edit_post = $this->Illegality->where(array("id"=>$Illegalityid))->save($data);

        //添加学生
        $this->add_student_post(1,$Illegalityid,$studentid,$schoolid);
        //添加类别
        $this->add_Illegality_type(1,$Illegalityid,$Illegality_type);
        $res = $this->format_ret_else(1,$edit_post);

        echo json_encode($res);
    }

    /**
     * @param $type 0为新增 1为修改
     * @param $Illegality 违纪主id
     * @param $studentid 数组集合
     */
   private function add_student_post($type,$Illegality,$studentid,$schoolid)
   {
       if($type==1)
       {
           $this->illegality_student->where(array("illegalityid"=>$Illegality))->delete();
       }

       foreach($studentid as $val)
       {
           $data['schoolid'] = $schoolid;
           $data['illegalityid'] = $Illegality;
           $data['studentid'] = $val;
           $alldata[] = $data;
           unset($data);
       }

       $this->illegality_student->addAll($alldata);
   }

    /**  批量增加违纪类别
     * @param $type 0为新增 1为修改
     * @param $Illegality 违纪主id
     * @param $Illegality_type 数组集合
     */
   private function add_Illegality_type($type,$Illegality,$Illegality_type)
   {
       if($type==1)
       {
           $this->illegality_type_detail->where(array("illegalityid"=>$Illegality))->delete();
       }

       foreach($Illegality_type as $val)
       {
           $data['illegalityid'] = $Illegality;
           $data['type_id'] = $val;
           $alldata[] = $data;
           unset($data);
       }

       $this->illegality_type_detail->addAll($alldata);
   }

    //违纪详情  传参,违纪主id
    public function Illegality_detail()
    {
        //违纪id
        $Illegalityid = I("id");

        $schoolid = I("schoolid");

        $Illegality = $this->Illegality->where(array("id"=>$Illegalityid))->find();



//        $Illegalityid = $Illegality['id'];
        

        $illegality_student = $this->dis_class(1,$this->illegality_student->where(array("illegalityid"=>$Illegalityid,"schoolid"=>$schoolid))->select(),$schoolid);
        $Illegality['student_name'] = $illegality_student;
        $Illegality['illegality_type'] = $this->illegality_type_detail
            ->alias("detail")
            ->join("wxt_Illegality_type type ON detail.type_id = type.id")
            ->field("type.name,type.mark,type.id")
            ->where(array("detail.illegalityid"=>$Illegalityid))
            ->select();


        $Illegality['name'] = M("teacher_info")->where(array("teacherid"=>$Illegality['userid']))->getField("name");

        // dump($Illegality);
        if($Illegality)
        {
            $res  = $this->format_ret_else(1,$Illegality);
        }else{
            $res  = $this->format_ret_else(0,"no data");
        }

        echo json_encode($res);

    }

    // 添加违纪 获取违纪类别选择
    public function Illegality_type()
    {
        $schoolid = I("schoolid");
        $type_parent =$this->Illegality_type->where(array("schoolid"=>$schoolid))->select();

        $result = $this->arr2tree($type_parent);

        if($result)
        {
            $res  = $this->format_ret_else(1,$result);
        }else{
            $res  = $this->format_ret_else(0,"no data");
        }

        echo json_encode($res);

    }

    function arr2tree($tree, $rootId = 0) {
        $return = array();
        foreach($tree as $leaf) {
            if($leaf['parent'] == $rootId) {
                foreach($tree as $subleaf) {
                    if($subleaf['parent'] == $leaf['id']) {
                        $leaf['children'] = $this->arr2tree($tree, $leaf['id']);
                        break;
                    }
                }
                $return[] = $leaf;
            }
        }
        return $return;
    }

    //添加违纪学生
    public function add_student()
    {
        $schoolid = I("schoolid");

        $class = M("school_class")->where(array("schoolid"=>$schoolid))->order("id asc")->select();

        if($class)
        {
            $res  = $this->format_ret_else(1,$class);
        }else{
            $res  = $this->format_ret_else(0,"no data");
        }

        echo json_encode($res);
    }

    //获取学生信息  传参:班级id  classid
    public function get_student_info()
    {
        //班级id
        $classid = I("classid");

        $schoolid = I("schoolid");

        $student_info = M("student_info")->where(array("schoollid"=>$schoolid,"classid"=>$classid))->field("userid,stu_name")->select();

        if($student_info)
        {
            $res  = $this->format_ret_else(1,$student_info);
        }else{
            $res  = $this->format_ret_else(0,"no data");
        }

        echo json_encode($res);
    }

    //处理学生数组 type:1 为h5,0为教师端
    private function dis_class($type,$student,$schoolid)
    {
        $studentid = "";
        foreach($student as $val)
        {
            $studentid =$val['studentid'].",".$studentid;
        }
        $studentid = trim($studentid,",");

        $array = array();

        $where['info.userid'] = array("in",$studentid);
        $where['info.schoollid'] = $schoolid;
        $student_class = M("student_info")
            ->alias("info")
            ->join("wxt_school_class class ON info.classid = class.id")
            ->where($where)
            ->field("info.stu_name,class.classname,info.classid,info.userid")
            ->select();
        if($type!=1)
        {
            $student_name = "";
            $classname = "";
            foreach($student_class as $arr)
            {
                $student_name = $arr['stu_name'].",".$student_name;
                $classname = $arr['classname'].",".$classname;
            }

            $name = trim($student_name,",");
            $class = trim(implode(',',array_unique(explode(',',$classname))),",");
            return array("student_name"=>$name,"classname"=>$class);
        }else{
            return $student_class;
        }


    }

    //处理违纪数据
    private function dis_type($Illegalityid)
    {
        $detail = $this->illegality_type_detail
            ->alias("detail")
            ->join("wxt_Illegality_type type ON detail.type_id = type.id")
            ->field("type.parent")
            ->where(array("detail.illegalityid"=>$Illegalityid))
            ->select();

        $p_id = "";
        foreach($detail as $val)
        {
            $p_id =$val['parent'].",".$p_id;
        }
        $parent = trim(implode(',',array_unique(explode(',',$p_id))),",");

        $where['schoolid'] = $_SESSION['schoolid'];
        $where['id']  = array("in",$parent);

        $arr = $this->Illegality_type->field("name")->where($where)->select();

        $parent_type = "";
        foreach($arr as $v)
        {
            $parent_type = $v['name'].",".$parent_type;
        }

        return trim($parent_type,",");
    }

    public function Illegality_manage()
    {

        $Illegality_type  = $this->Illegality_type->where(array("schoolid"=>$this -> schoolid,"parent"=>0))->select();
        $Subclass = $this->Illegality_type->where(array("schoolid"=>$this -> schoolid,"parent"=>$Illegality_type[0]['id']))->select();
        $education_type = $this->education_type->where(array("schoolid"=>$this->schoolid))->select();


        $arr = array("Illegality_type"=>$Illegality_type,"Subclass"=>$Subclass,"education_type"=>$education_type);

        echo json_encode($arr);

    }

    public function Illegality_subclass()
    {
        $pId= I("pId");

        $Subclass = $this->Illegality_type->where(array("schoolid"=>$this -> schoolid,"parent"=>$pId))->select();

        if($Subclass)
        {
            $res = $this->format_ret_else(1,$Subclass);
        }else{
            $res = $this->format_ret_else(0,"拉取失败");
        }

        echo json_encode($res);
    }

    public function type_add()
    {
        $pid = I("pid");
        $illegality_name = I("illegality_name");
        $education = I("education");

        $data['schoolid'] = $_SESSION['schoolid'];
        $data['name'] = $illegality_name;
        $data['parent'] = $pid;
        $data['mid'] =$education;
        $result =  $this->Illegality_type->add($data);

        if($result)
        {
            $res =  $this->format_ret_else("1",$result);
        }else{
            $res = $this->format_ret_else("0","添加失败");
        }
        echo json_encode($res);
    }

    public function type_edit()
    {
        $id = I("id");
        $name = I("name");
        $education = I("education");

        if($education)
        {
            $data['mid'] = $education;
        }
        $data['name'] = $name;
        $edit =  $this->Illegality_type->where(array("id"=>$id))->save(array("name"=>$name,"education"=>$education));

        if($edit)
        {
            $res =  $this->format_ret_else("1",$edit);
        }else{
            $res =  $this->format_ret_else("0",$edit);
        }

        echo json_encode($res);
    }

    public function mark_edit()
    {
        $id = I("id");
        $mark_num = I("mark_num");


        $edit =  $this->Illegality_type->where(array("id"=>$id))->save(array("mark"=>$mark_num));

        if($edit)
        {
            $res =  $this->format_ret_else("1",$edit);
        }else{
            $res =  $this->format_ret_else("0",$edit);
        }

        echo json_encode($res);
    }

    public function type_del()
    {
        $id = I("id");

        $del =  $this->Illegality_type->where(array("id"=>$id))->delete();
        //删除子类
        $this->Illegality_type->where(array("parent"=>$id))->delete();
        if($del)
        {
            $res = $this->format_ret_else(1,"删除成功");
        }else{
            $res = $this->format_ret_else(0,"删除失败");
        }
        echo json_encode($res);

    }

    public function add_illegality()
    {
        $illegality_type =$this->Illegality_type->where(array("schoolid"=>$_SESSION['schoolid'],"parent"=>0))->select();
//

        foreach($illegality_type as &$value)
        {
            $value['subclass']  = $this->Illegality_type->where(array("schoolid"=>$_SESSION['schoolid'],"parent"=>$value['id']))->select();
        }
        //$this->assign("illegality_type",$illegality_type);
        echo json_encode($illegality_type);
    }

    //参数获取(状态，原因)
    function format_ret_else ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }

}