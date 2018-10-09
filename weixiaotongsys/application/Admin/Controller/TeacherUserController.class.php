<?php
/* * 
 * 系统权限配置，用户角色管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TeacherUserController extends AdminbaseController {

    function _initialize() {
        parent::_initialize();
        //$this->role_model = D("Common/Role");
    }

    //用户列表
    public function index()
    {
        //获取所有的用户与角色关联
        $user_lists = M('users')
            ->alias('u')
            ->where('r.type = 2')
            ->join('wxt_role_user as ru on ru.user_id = u.id')
            ->join('wxt_role as r on r.id = ru.role_id')
            ->order('u.id desc')
            ->field('u.id as uid, u.user_login, u.user_email, u.user_status, r.name, ru.role_id as rid')
            ->select();
        //dump($user_lists);

        $this->assign('user', $user_lists);
        $this->display();
    }

    //添加后台用户
    public function add()
    {
        //获取所有的角色
        $roles = M('role')->where('type=2')->field('name, id')->select();
        //dump($roles);
        $this->assign('role', $roles);
        $this->display();
    }

    //处理添加用户
    public function add_post(){
        if ($_POST){
            $arr = array(
                'user_login'=>I('username'),
                'user_pass' => sp_password(I('password')),
                'user_nicename'=>I('nname'),
                'user_email'=>I('email'),
                'create_time'=>date('Y-m-d H:i:s', time())
            );
            $role_id = I('role_id');
            $result = M('users')->add($arr);
            if ($result){
                $insert = M('role_user')->add(array('role_id'=>$role_id, 'user_id'=>$result, 'type'=>2));
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
        //$this->success("删除视频成功！");
    }

    //修改用户信息
    public function edit() {
        $uid = I('uid');
        $rid = I('rid');

        //获取用户的信息
        $user = M('users')->where("id = $uid")->field('user_login,user_nicename,user_email, id')->find();
        //获取所有的角色
        $roles = M('role')->where('type=2')->field('name, id')->select();
        //dump($roles);
        $this->assign('role', $roles);
        $this->assign('user', $user);
        $this->assign('rid', $rid);
        $this->display();
    }
    //修改post
    public function edit_post() {
        $uid = I('uid');
        $rid = I('rid');
        $arr = array(
            'user_login'=>I('username'),
            'user_pass' => sp_password(I('password')),
            'user_nicename'=>I('nname'),
            'user_email'=>I('email'),
            'create_time'=>date('Y-m-d H:i:s', time())
        );
        $update = M('role_user')->where('user_id = '. $uid)->save(array('role_id'=>$rid));
        $updates = M('users')->where('id = '.$uid)->save($arr);
        if ($updates && $update){
            $this->success("修改成功！");
        }else{
            $this->success("修改失败！");
        }
    }
}

