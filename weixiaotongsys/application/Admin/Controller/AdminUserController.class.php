<?php
/* * 
 * 系统权限配置，用户角色管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class AdminUserController extends AdminbaseController {

    function _initialize() {
        parent::_initialize();
        //$this->role_model = D("Common/Role");
    }

    //用户列表
    public function index()
    {

        $result = role_admin();

        $this->assign("Province",$result);
        if(I("rid")){//如果有的话,表示显示子用户
            $rid = I("rid");

            $where["r.pid"] = $rid;
            $role = M('users')
                ->alias('u')
                ->join('wxt_role_user as ru on ru.user_id = u.id')
                ->join('wxt_role as r on r.id = ru.role_id')
                ->where($where)
                ->order('r.id asc')
                ->field('u.id as uid, u.user_login, u.user_email, u.user_status,u.last_login_ip,u.last_login_time,r.categoryid, r.name, ru.role_id as rid,r.pid,c.name as city_name')
                ->select();



            $this->assign('user',$role);
            if(count($role)){
                $this->display("index_son");
            }else{
                $this->success("没有子用户！");
            }

            //dump($role);

        }else{ //表示拉取列表
            $userid = $_SESSION["ADMIN_ID"];
            $result=M("role_user as a")->join("wxt_role as b on a.role_id=b.id")->
            where("a.user_id=$userid")->find();
            //dump($result);+
            $_SESSION['pid'] = $result["pid"];
            $_SESSION["role_id"]= $result["role_id"];
            $this->assign('pid', $result["pid"]);//父ID
            $this->assign('result', $result);
            $this->assign('categoryid', $result["categoryid"]);//大类

            //搜索条件
            $get_categoryid = I('categoryid'); //代理商
            if (!empty($get_categoryid)){
                $map['r.categoryid'] = I('categoryid');
                $where['r.categoryid'] = I('categoryid');
                $this->assign("categoryid", I('categoryid'));
            }

            //新增地址搜索
//            $city = I("city");
//            if (!empty($city)){
//                $map['r.city'] = $city;
//                $where['r.city'] = $city;
//                $this->assign("citys",$city);
//            }
//
//            $Province = I("province");
//
//            if ($Province) {
//                //$where_child['Province'] = $Province;
//                $this->assign('pp',$Province);
//            }
            //新增地址搜索


            $get_keywordtype = I('keywordtype');
            $get_keyword = I('keyword');
            if (!empty($get_keywordtype)&&!empty($get_keyword)&&$get_keywordtype=='user_login'){ //用户账号

                $map['u.user_login'] = array("like","%".I('keyword')."%");
                $where['u.user_login'] = array("like","%".I('keyword')."%");
                $this->assign("keyword", I('keyword'));
                $this->assign("keywordtype", 1);

            }



            $pid = $result["pid"];//拉出同角色账号
            $type= $result["categoryid"];//同类
            $role_id = $result["role_id"];//子用户的父ID
            //搜索条件
            $map["r.pid"] = $pid;
            $map["r.id"] = $role_id;
            $map["r.categoryid"] = $type;
            $where["r.pid"] = $role_id;
            $count = M('users')
                ->alias('u')
                ->join('wxt_role_user as ru on ru.user_id = u.id')
                ->join('wxt_role as r on r.id = ru.role_id')
                ->join('wxt_city as c on r.city = c.term_id')
                //->where("r.pid = $pid and r.categoryid=$type")
                ->where($map)
                //->order('u.id asc')
                ->order('r.id asc')
                ->field('u.id as uid, u.user_login, u.user_email, u.user_status,u.last_login_ip,u.last_login_time,r.categoryid, r.name, ru.role_id as rid,r.pid,c.name as city_name')
                ->count();
            $page = $this->page($count, 20);
            $user_lists = M('users')
                ->alias('u')
                ->join('wxt_role_user as ru on ru.user_id = u.id')
                ->join('wxt_role as r on r.id = ru.role_id')
                ->join('wxt_city as c on r.city = c.term_id')
                //->where("r.pid = $pid and r.categoryid=$type")
                ->limit($page->firstRow . ',' . $page->listRows)
                ->where($map)
                //->order('u.id asc')
                ->order('r.id asc')
                ->field('u.id as uid, u.user_login, u.user_email, u.user_status,u.last_login_ip,u.last_login_time,r.categoryid, r.name, ru.role_id as rid,r.pid,c.name as city_name')
                ->select();

             //dump($user_lists);
            //拉出自己的子用户
            $count1 = M('users')
                ->alias('u')
                ->join('wxt_role_user as ru on ru.user_id = u.id')
                ->join('wxt_role as r on r.id = ru.role_id')
                ->join('wxt_city as c on r.city = c.term_id')
                ->where($where)
                // ->where("r.pid = $role_id")
                //->order('u.id asc')
                ->order('r.id asc')
                ->field('u.id as uid, u.user_login, u.user_email, u.user_status,u.last_login_ip,u.last_login_time,r.categoryid, r.name, ru.role_id as rid,r.pid,c.name as city_name')
                ->count();
            $page = $this->page($count1, 20);
            $user = M('users')
                ->alias('u')
                ->join('wxt_role_user as ru on ru.user_id = u.id')
                ->join('wxt_role as r on r.id = ru.role_id')
                ->join('wxt_city as c on r.city = c.term_id')
                ->where($where)
                // ->where("r.pid = $role_id")
                //->order('u.id asc')
                ->limit($page->firstRow . ',' . $page->listRows)
                ->order('r.id asc')
                ->field('u.id as uid, u.user_login, u.user_email, u.user_status,u.last_login_ip,u.last_login_time,r.categoryid, r.name, ru.role_id as rid,r.pid,c.name as city_name')
                ->select();
            // dump($user);
            $this->assign("Page", $page->show('Admin'));
            $rel = array_merge($user_lists,$user );
            // dump($rel);
           // echo (count($rel));
            $this->assign('user', $rel);


            $this->display();
        }

    }
    //添加后台用户
    public function add()
    {
        $userid = $_SESSION["ADMIN_ID"];
        $result=M("role_user as a")->join("wxt_role as b on a.role_id=b.id")->
                where("a.user_id=$userid")->find();
        $this->assign('result', $result);

        //获取所有的角色

        $this->display();
    }
    //角色拉取
    public function role_list(){

        if(I("rid")){
            $id = I("rid"); //传过来的角色ID
            $role = M('role')->where("id = $id")->field('name,id,pid')->find(); //早到它的pid
            //dump($role);
            $pid = $role["pid"];
        }else{
            $pid = $_SESSION["role_id"];//父ID
        }

        $roletype = I("roletype");//角色类型
        $roles = M('role')->where("pid=$pid and roletype=$roletype")->field('name, id')->select();
        echo json_encode($roles);

    }

    //处理添加用户
    public function add_post(){
        $username = I('username');
        $res = M('users')->where(array("user_login"=>$username))->find();
        if(count($res)){
            $this->success('该用户已存在,请换个用户账号');
            die();
        }
        if($_POST){
            $arr = array(
                'user_login'=>I('username'),
                'user_pass' => sp_password(I('password')),
                'user_nicename'=>I('nname'),
                'user_email'=>I('email'),
                'user_status'=>I('user_status'),
                'phone'=>I('phone'),
                'create_time'=>date('Y-m-d H:i:s', time())
            );
            $role_id = I('role_id');
            $result = M('users')->add($arr);
            if ($result){
                $insert = M('role_user')->add(array('role_id'=>$role_id, 'user_id'=>$result));
                if ($insert){
                    $this->success('添加成功', U('index'));
                }
            }
        }
    }

    //删除用户
    public function delete_user(){
        $uid = I('uid');
        $rid = I('rid');
        $deletes = M('role_user')->where('role_id = '.$rid .' and user_id = '. $uid)->delete();
        $delete = M('users')->where('id = '.$uid)->delete();
        if ($delete && $deletes){
            $this->success("删除成功！");
        }
    }

    //修改用户信息
    public function edit() {
        //print_r($_SESSION);
        $uid = I('uid');//用户ID
        $rid = I('rid');//角色ID

            $result=M("role_user as a")->join("wxt_role as b on a.role_id=b.id")->
            where("a.user_id=$uid")->find();
            $this->assign('result', $result);


            $user=M("role_user as a")->join("wxt_role as b on a.role_id=b.id")->
            join("wxt_users as c on c.id=a.user_id")->
            field("c.user_login,c.user_pass,c.user_status,c.phone,c.user_nicename,c.user_email,c.id as uid,b.roletype,b.pid,a.*")->
            where("a.user_id=$uid")->
            find();
            //dump($user);
        $this->assign('user', $user);


        $this->assign('rid', $rid);
        $this->display();
    }
    //修改post
    public function edit_post() {
        $uid = I('uid'); //用户ID
        $rid = I('role_id');//修改的角色ID
        $update = M('role_user')->where("user_id = $uid")->save(array('role_id'=>$rid));//查找角色信息

        if (I('password')){
            $arr = array(
                'user_pass' => sp_password(I('password')),
                'user_nicename'=>I('nname'),
                'user_email'=>I('email'),
                'user_status'=>I('user_status'),
                'phone'=>I('phone'),
                'create_time'=>date('Y-m-d H:i:s', time())
            );
        }else{
            $arr = array(
                'user_nicename'=>I('nname'),
                'user_email'=>I('email'),
                'phone'=>I('phone'),
                'user_status'=>I('user_status'),
                'create_time'=>date('Y-m-d H:i:s', time())
            );

        }

        $updates = M('users')->where('id = '.$uid)->save($arr);
        if ($updates || $update){
            $this->success("修改成功",U('index'));
        }else{
            $this->error("修改失败！");
        }
    }
}

