<?php

/**
 * 园长寄语
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;

class PrincipalController extends AdminbaseController {


      public function index()
      { 
        
         $Province=role_admin();
         $this->assign("Province",$Province);
        $this->display();

      }


      public function Pr_list()
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
        
    
       $where['schoolid'] = $schoolid;  

       $list = M('principal_word')->where($where)->select();
      // var_dump($list);
     
         if (!empty($list)){
           $ret = $this->format_ret_else(1,$list);
           echo json_encode($list);
        }else{
            $ret = $this->format_ret_else(0,"parms lost");
            echo json_encode($ret);
        }

  
     }

       public function add()
       {
         $Province=role_admin();
        
             
        //var_dump($school_name);
         $this->assign("Province",$Province);
          $this->display();
        }


       public function add_post()
       {
       $schoolid= I('school');

      
       $content = I('content');
      


        $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);

         $str=$_POST['smeta']['thumb'];

          $arr=explode("/", $str);
          
          $photo=$arr[count($arr)-1];

        //var_dump($_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']));

        $data = array(
            'schoolid'=>$schoolid,
            'content'=>$content,
            'type'=>1,
            'pic'=>$photo, 
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

       public function edit()
       {
        $id = I('id');

        $principal = M('principal_word')->where("id = $id")->find();
        // var_dump($principal);

        $schoolid = $principal['schoolid'];

        $school = M('school')->where("schoolid = $schoolid")->field("school_name")->find();

        $school_name = $school['school_name'];
   
         $photo = $principal['pic'];

         // var_dump($photo);

        $this->assign("conetnt",$principal['content']);
        $this->assign("school_name",$school_name);

        $this->assign("photo",$photo);
        $this->assign("id",$principal['id']);


        $this->display();
       }
          
        //编辑  
       public function edit_post()
       {
         $id = I('pid');
      
         // exit();

         $content = I("content");

          $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);

         $str=$_POST['smeta']['thumb'];
             $arr=explode("/", $str);
             $photo=$arr[count($arr)-1];

             $data = array(
              'content'=>$content,
              'pic' =>$photo,

              );
             // var_dump($data);

          $save = M('principal_word')->where("id = $id")->save($data);

          $this->success("添加成功");




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