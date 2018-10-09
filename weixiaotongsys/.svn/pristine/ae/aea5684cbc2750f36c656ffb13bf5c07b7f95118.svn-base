<?php

/**
 * 园长寄语
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class PrincipalController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }
      public function index()
      {


       $begin =   strtotime(I('begin'));
       // var_dump($begin);

       $end = strtotime(I('end'));

       // var_dump($end);

       // $where_att['arrivedate'] = array(array('EGT',$cc),array('ELT',$dd));
      
      if($begin && $end)
      {
        $where['createint_time'] =  array(array('EGT',$begin),array('ELT',$end));
      }


       $schoolid=I('schoolid');
        
    
       $where['schoolid'] = $_SESSION['schoolid']; 

       $list = M('principal_word')->where($where)->select();
      // var_dump($list);
     
         $this->assign("list",$list);
         $this->display();

  
     }

          public function add()
       {
     $schoolid=$_SESSION['schoolid'];

    $school = M('school')->where("schoolid=$schoolid")->find();

    $school_name = $school['school_name'];
    //var_dump($school_name);
     $this->assign("school",$school_name);
          	$this->display();
        }


       public function add_post()
       {
       $schoolid=$_SESSION['schoolid'];
      
       $content = I('content');

        $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);

        //var_dump($_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']));

        $data = array(
            'schoolid'=>$schoolid,
            'content'=>$content,
            'type'=>1,
            'pic'=>$_POST['smeta']['thumb'], 
            'create_time'=>date('Y-m-d'),
            'createint_time'=>time(),


          );

        $principal_word = M('principal_word')->add($data);
        if($principal_word )
        {
            $this->success('添加寄语成功!');
        }else{
          $this->error('添加失败!');
        }
        // exit();

       }

          //删除
    public function delete(){
        $id =intval(I('id'));
        if($id){

            $rst = M('principal_word')->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }else{
            $this->error("未获取到数据");
        }
    }

     


}