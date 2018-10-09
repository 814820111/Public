<?php

/**
 * 后台设备管理---用户管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class UserManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
    }
    //视频用户管理首页
    public function index() {
        if(IS_POST) {
            //获取要查询的关键字
            $keywordtype = I('keywordtype');
            $keyword = I('keyword');
            $map['appKey'] = array('like', $keyword);
            $lists = M('monitor_usermanage')->where($map)->select();
            $this->assign('keyword', $keyword);
            //var_dump($lists);
        } else {
            //分页处理
            //获取所有的账户信息
            $lists = M('monitor_usermanage')->select();
            //获取总条数
            $count = count($lists);
            $page = $this->page($count, 5);
            $lists = M('monitor_usermanage')->limit($page->firstRow . ',' . $page->listRows)->select();
            //分配数据
            $this->assign('page', $page->show('Admin'));
        }
        $this->assign('lists', $lists);
        //载入模板
        $this->display();
    }

    //获取token----萤石
    public function getByYingshiToken($post_data) {

        $this_header = array("Content-Type: application/x-www-form-urlencoded; charset=gbk");
        $url='https://open.ys7.com/api/lapp/token/get';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        $arr=json_decode($result,true);
        $contents = mb_convert_encoding($arr["msg"], 'gbk', 'auto');
        $token=$arr["data"]["accessToken"];

        return $token;
    }
    //获取token-----乐成
    public function getByLeChengToken($info){
        //var_dump($info);exit;
        //微校通设备
        $appId = trim($info['appKey']);
        $appSecret = trim($info['secret']);
        // $phone = "15888708668";//这是登录账号，应该用下面的管理员账号
        $phone = trim($info['mobile']);

        // 青岛设备
        // $appId = 'lc80db01e1cb4142dd';
        // $appSecret = "643ec05b22714e9080e1cd5a5dba36";
        // $phone = "18678959897";

        $length=32;
        // 密码字符集，可任意添加你需要的字符
        $chars = '0123456789';
        $password = '';
        for ( $i = 0; $i < $length; $i++ ) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $String="phone:".$phone.",time:".time().",nonce:".$password.",appSecret:".$appSecret;
        $String = md5($String);
        $system_team["ver"]='1.0';
        $system_team["sign"]=$String;
        $system_team["appId"]=$appId;
        $system_team["time"]=time();
        $system_team["nonce"]=$password;
        $arr["system"]=$system_team;

        $params_arr["phone"]=$phone;
        $arr["params"]=$params_arr;

        $arr["id"]=88;
        //echo json_encode($arr);
        $post_data=json_encode($arr);
        $this_header = array("Content-Type: application/x-www-form-urlencoded; charset=gbk");
        $url='https://openapi.lechange.cn:443/openapi/accessToken';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        $arr_else=json_decode($result,true);
        $contents = mb_convert_encoding($arr_else["msg"], 'gbk', 'auto');

        return $arr_else["result"]["data"]["accessToken"];
    }
    //判断token是否过期
    public function tokenIsOff($id, $type){
        $infos = M('monitor_usermanage')->where("id = $id")->find();
        if (empty($infos['token'])){
            return false;
        }else{
            $nowTime = time()+8*3600;
            if ($type == 1) {
                $offTime = 8*3600;
            }elseif ($type == 2) {
                $offTime = 3*24*3600;
            }
            if ($nowTime - $infos['token_time'] > $offTime) {
                //token失效
                return false;
            } else {
                return true;
            }
        }
    }
    //添加视频用户
    public function add() {

        //添加视频用户
        if (IS_POST) {

           //获取post数据
           $post_data = array(
                'name'=>I('name'),
                'appKey'=>I('appKey'),
                'secret'=>I('appSecret'),
                'username'=>I('username'),
                'password'=>I('password'),
                'type'=>I('type'),
                'mobile'=>I('mobile')
            );

            $result = M('monitor_usermanage')->add($post_data);
            if ($result) {
                //判断token是否过期
                $flag = $this->tokenIsOff($result, I('type'));
                if (!$flag) {
                    //过期了，从新获取token
                    if (I('type') == 1){
                        $post_data='appKey='.I('appKey').'&appSecret='.I('appSecret');
                        $token = $this->getByYingshiToken($post_data);
                    }
                    elseif (I('type') == 2) {
                        $token = $this->getByLeChengToken($post_data);
                    }
                    $update = array(
                        'token'=>$token,
                        'token_time'=>time()+8*3600
                    );
                    $results = M('monitor_usermanage')->where("id = $result")->save($update);
                    if ($results) {
                        $this->success('添加账户成功', U('index'));
                        exit();
                    }else {
                        $this->error("添加账户失败");
                    }
                }
                $this->success('添加账户成功', U('index'));
                exit;
            } else {
                $this->error('添加账户失败');
                exit;
            }

        }

        //载入模板
        $this->display();
    }

    //修改账号信息
    public function change() {

        //修改表单提交
        if (IS_POST) {
            //获取数据
            $id = I('id');
            $obj = M('monitor_usermanage');
            $arr = array(
                'appkey'=>I('appKey'),
                'secret'=>I('appSecret'),
                'name'=>I('name'),
                'username'=>I('username'),
                'password'=>I('password'),
                'type'=>I('type'),
                'mobile'=>I('mobile')
            );
            $result = $obj->where("id=$id")->save($arr);
            if($result) {
                $this->success('修改账号信息成功', U('index'));
                exit;
            }else{
                $this->error("修改账号信息成功",  U('index'));
                exit();
            }
        }

        //获取要修改的id
        $id = I('id');
        //获取账号信息
        $infos = M('monitor_usermanage')->where("id = $id")->find();

        $this->assign('infos', $infos);
        //载入模板
        $this->display();
    }

    //删除账号信息
    public function delete() {
        //获取要删除的id
        $id = I('id');
        $result = M('monitor_usermanage')->where("id=$id")->delete();
        if ($result) {
            $this->success('删除账号信息成功');
            exit;
        } else {
            die('删除账号信息失败');
        }
    }
}

