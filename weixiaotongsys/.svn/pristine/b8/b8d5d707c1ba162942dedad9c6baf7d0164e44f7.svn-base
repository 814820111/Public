<?php

/**
 * 后台首页
 */
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;

header("Content-type:text/html;charset=utf-8");
session_start();
class IndexController extends WeixinbaseController {
    //后台框架首页
    public function index() {
        $weixin = $_SESSION["weixin"];
        if (empty($weixin)) {
            $weixin = 'oImI6w-FUTsUmeDyCGQjk5w1pRwU';
        }
        $map['weixin'] = array('eq', $weixin);
        $wxunserid = M("wxtuser")->where($map)->find();
        $userid = $wxunserid['id'];
        //获取学生姓名
        $stu_info = M("student_info")->where("userid = '$userid'")->find();
        $student_id = $stu_info["stu_id"];
        $_SESSION["studentid"] = $student_id;
        $stu_name = $stu_info['stu_name'];
        $_SESSION["stu_name"] = $stu_name;
        //查询学生id
        $name = M("student_info")->where("userid = '$userid'")->field("schoollid,stu_name,classid,photo")->find();
        $schoollid = $name["schoollid"];
        $classid = $name["classid"];
        $stu_name = $name["stu_name"];
        $photo = $name["photo"];
        $_SESSION['photo'] = $photo;
        //通过学校id查询学校名字
        $school_name = M("school")->field("school_name")->where("schoolid = '$schoollid'")->find();
        $school_name = $school_name["school_name"];
        $_SESSION['school_name'] = $school_name;
        //查询班级名字
        $class_name = M("school_class")->where("schoolid = '$schoollid' AND id = '$classid'")->find();
        $class_name = $class_name["classname"];
        $_SESSION["classname"] = $class_name;
        $this->assign("name", $_SESSION["stu_name"]);
        $this->assign("student_id", $_SESSION["studentid"]);
        $this->assign("photo", $_SESSION['photo']);
        $this->assign("classname", $_SESSION["classname"]);
        $this->assign("school_name", $school_name);
        $this->assign("weixin", $weixin);
        $this->display("index");
    }

    function GetMicroblogById()
    {
        $beginid = I('beginid');
        $schoolid = I('schoolid');
        //学校的ID
        $classid = I('classid');
        //班级的ID
        $type = I('type');
        //空间动态
        $uisd = I("userid");
        //用户的ID
        $mids = I("mids");
        //该信息的ID
        $microblig = M('microblog_main');   //博客主表
        $microblig_pic = M('microblog_picture_url');//博客图片表
        $microblig_like = M('likes');//博客点赞表
        $microblig_comment = M('comments');//博客评论表
        if ($school != "" || $classid != "" || $uisd！="" || $mids != ""){
        $where["wxt_microblog_main.schoolid"] = $schoolid;
        $where["wxt_microblog_main.userid "] = $uisd;
        $where["wxt_microblog_main.classid"] = $classid;
        $where["wxt_microblog_main.mid"] = $mids;
        $where["wxt_microblog_main.status"] = 1;
        if ($type != 1) {
            $where["wxt_microblog_main.type"] = $type;
        }
        $user_return = $microblig->join("wxt_wxtuser ON wxt_microblog_main.userid = wxt_wxtuser.id")
            ->where($where)
            ->field('mid,type,wxt_microblog_main.schoolid,wxt_microblog_main.classid,userid,name,content,write_time,photo')
            ->select();
        //为该条微博匹配存入的图片++++++++匹配点赞情况
        for ($i = 0; $i < count($user_return); $i++) {
            //1.获取该微博对应图片数量，名称等信息      2.对应的点赞人id，点赞时间等信息    3.对应评论人，评论内容，评论时间等信息
            $microblogid = $user_return[$i]['mid'];//主表对应的附表中的microblogid

            $pic_return = $microblig_pic->where("microblogid = $microblogid")
                ->order('id ASC')
                ->field('pictureurl')
                ->select();
            //将图片地址信息附给该条微博
            $user_return[$i]['pic'] = $pic_return;

            $where_like["wxt_likes.refid"] = $microblogid;
            //$where_like["wxt_likes.type"]=$type;
            $like_return = $microblig_like->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                ->where($where_like)
                ->order('likeid ASC')
                ->field('userid,name')
                ->select();
            //将点赞人信息附给该条微博
            $user_return[$i]['like'] = $like_return;

            $where_comment["wxt_comments.refid"] = $microblogid;
            //$where_comment["wxt_comments.type"]=$type;
            $comment_return = $microblig_comment
                ->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                ->where($where_comment)
                ->order('wxt_comments.add_time DESC')
                ->field('userid,name,content,wxt_wxtuser.photo as avatar,add_time as comment_time')
                ->select();
            //将评论人信息及内容附给该条微博
            $user_return[$i]['comment'] = $comment_return;
        }
        $ret = $this->format_ret(1, $user_return);
    }else{
        $ret = $this->format_ret(0, "系统错误请稍后再试！");
    }
            echo json_encode($ret);
        exit;    
            
 }
}