<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author mac
 */
namespace Service\Controller;
use Common\Controller\AppBaseController;
class UserController extends AppBaseController  {
    //put your code here
    public function index() {
//        $mobile = I('mobile');
//        $pass = I('pass');
//        if($mobile == "")
//        {
//            die(json_encode("error:mobile"));
//        }
//        if($pass == "")
//        {
//            die(json_encode("error:pass"));
//        }
        die(json_encode("success:12"));
//        $map['status']  = array('egt',0);
//        $map["mobile"] = array('eq',$mobile);
//        $map["password"] = array('eq',$pass);
//        $user = $this->lists('Consumer', $map);
//        if(is_array($user)){
//            die(json_encode($user));
//        }
//        echo(json_encode($user));
//        if(is_array($user) && $user['status']){
                /* 验证用户密码 */
//        if(think_ucenter_md5($password, UC_AUTH_KEY) === $user['password']){
//                        $this->updateLogin($user['id']); //更新用户登录信息
//        echo(json_encode($user)); //登录成功，返回用户信息
        
    }
}
