<?php
namespace app\ctrl;
use core\lib\model;

header("Content-type: text/html; charset=utf-8");
class indexCtrl extends \core\project
{
    public function index()
    {
//        p("it is index");
//        $model = new \core\lib\model();
//        $sql = 'SELECT * FROM user ';
//        $res =  $model->query($sql);
//        p($res->fetchAll());
//       $temp =  \core\lib\conf::get('CTRL','route');
//       $temp =  \core\lib\conf::get('ACTION','route');
//       print_r($temp);
//        new \core\lib\model();
//        $data = 'Hello World';
//        $title = '试图文件';
//        $this->assign("data",$data);
//        $this->assign("title",$title);
//        $this->display("index.html");
//       $model =  new model();
//
//       $data = array(
//           'username'=>'林林林',
//           'nickname'=>'晕晕晕',
//
//       );
//
//     $ret = $model->insert('user',$data);

        $model = new \app\model\userModel();

        $data = array(
            'username'=>6666
        );

        $result =  $model->setOne(1,$data);

        dump($result);

    }

}