<?php

/**
 * 后台首页  违纪管理
 */
namespace Teacher\Controller;

use Common\Controller\TeacherbaseController;

class IllegalityController extends TeacherbaseController {
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


     public function index()
     {
            //查询出该学校的违纪
           $Illegality = $this->Illegality->field("id,userid")->where(array("schoolid"=>$_SESSION['schoolid']))->select();

           //$Illegalityid = "";
            //先这样写，后期再优化
           foreach($Illegality as &$val)
           {
               $Illegalityid = $val['id'];
               $illegality_student = $this->dis_class($this->illegality_student->where(array("illegalityid"=>$Illegalityid,"schoolid"=>$_SESSION['schoolid']))->select());
               $illegality_type = $this->dis_type($Illegalityid);
               $val['typename'] =  $illegality_type;
               $val['class'] =  $illegality_student['classname'];
               $val['student_name'] =  $illegality_student['student_name'];

               $val['name'] = M("teacher_info")->where(array("teacherid"=>$val['userid']))->getField("name");
           }
           dump($Illegality);
          $this->display();
     }
     //处理学生数组
     private function dis_class($student)
     {
         $studentid = "";
         foreach($student as $val)
         {
             $studentid =$val['studentid'].",".$studentid;
         }
         $studentid = trim($studentid,",");

         $array = array();

         $where['info.userid'] = array("in",$studentid);
         $where['info.schoollid'] = $_SESSION['schoolid'];
         $student_class = M("student_info")
                        ->alias("info")
                        ->join("wxt_school_class class ON info.classid = class.id")
                        ->where($where)
                        ->field("info.stu_name,class.classname,info.classid")
                        ->select();
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


        $this->assign("education_type",$education_type);
        $this->assign("Subclass",$Subclass);
        $this->assign("Illegality_type",$Illegality_type);
        $this->display();
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
//
        $this->assign("illegality_type",$illegality_type);
        $this->display();
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