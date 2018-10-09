<?php
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class MainController extends TeacherbaseController {
	
	function _initialize() {
        parent::_initialize();
        $this->wxtuser_model = D("Common/wxtuser");
        $this->schedule_model = D("Common/schedule");
        $this->entrust_model = D("Common/entrust");
        $this->notice_model = D("Common/notice");
        $this->user_message_model = D("Common/user_message");
        $this->activity = D("Common/activity");
        $this->microblog_main = D("Common/microblog_main");
        $this->courseware = D("Common/school_courseware");
	}
    public function index(){
        

        $userid = $_SESSION['USER_ID'];

        $schoolid = $_SESSION['schoolid'];
       
        $name = $this->wxtuser_model->where("id = $userid")->getField("name");
  
    	
    	$mysql= mysql_get_server_info();
    	$mysql=empty($mysql)?"未知":$mysql;
    	//服务器信息
    	$info = array(
    			'操作系统' => PHP_OS,
    			'运行环境' => $_SERVER["SERVER_SOFTWARE"],
    			'PHP运行方式' => php_sapi_name(),
    			'MYSQL版本' =>$mysql,
    			'程序版本' => SIMPLEWIND_CMF_VERSION . "&nbsp;&nbsp;&nbsp; [<a href='http://www.thinkcmf.com' target='_blank'>访问官网</a>]",
    			'上传附件限制' => ini_get('upload_max_filesize'),
    			'执行时间限制' => ini_get('max_execution_time') . "秒",
    			'剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
    	);
        //本周
        $thisweek_start= strtotime(date('Y-m-d', strtotime('this week')));
        $thisweek_end=mktime(23,59,59,date('m'),date('d')-date('w')+7,date('Y'));



        //本月
        $thismonth_start=mktime(0,0,0,date('m'),1,date('Y'));

        $thismonth_end=mktime(23,59,59,date('m'),date('t'),date('Y'));

        $endLastweek=mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
        $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));

        $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;


//        $map['message_time']  = array('between','$endLastweek,$beginThismonth');
//        $nowweek=$this->user_message_model->where($map)->count();
//
//        dump($nowweek);

//       dump()


        //今日
        $today_info = $this->user_message_model->where("message_time >= $beginToday and message_time<=$endToday")->count();
        //本星期条数
        $week_info = $this->user_message_model->where("message_time >= $thisweek_start and message_time<=$thisweek_end")->count();
        //本月条数
        $month_info = $this->user_message_model->where("message_time >= $thismonth_start and message_time<=$thismonth_end")->count();

        //班级相册
        $microblog_info = $this->microblog_main->where("schoolid = $schoolid and userid = $userid and type = 2")->count();

        //班级活动
        $activity_info = $this->activity->where("schoolid = $schoolid and userid = $userid")->count();

       //班级课件
        $courseware_info = $this->courseware->where("schoolid = $schoolid and user_id = $userid")->count();

        //待办事宜
        $schedule = $this->schedule_model->where("userid = $userid and schoolid = $schoolid")->order("id desc")->limit("0,2")->select();
       
       //家长叮嘱
       $entrust = $this->entrust_model->alias("e")->join("wxt_wxtuser u ON u.id = e.userid")->where("e.teacherid = $userid")->limit("0,2")->field("u.name,e.content,e.create_time")->select();
       
      //校内公告
       $notice = $this->notice_model->where("userid = $userid and schoolid = $schoolid")->order("id desc")->limit("0,2")->select();
       
       //信息群发统计
       $message_sum  = $this->user_message_model->where("send_user_id = $userid and send_type = 1 and schoolid = $schoolid")->count();

       //动态
        $Dynamic_info = $this->microblog_main->where("schoolid = $schoolid and userid = $userid and type = 1")->count();

        //系统信息
        $where = array();
        $where['a.term_id'] = 3;
        $where['a.status'] = 1;
        $join = "" . C('DB_PREFIX') . 'posts as b on a.object_id =b.id';
        $join2 = "" . C('DB_PREFIX') . 'users as c on b.post_author = c.id';
        $join3 = "" . C('DB_PREFIX') . 'terms as t on a.term_id = t.term_id';
        $term_relationships_model = M("TermRelationships");
        $field = "tid as id,a.term_id,t.name as term_name,post_title,post_excerpt,post_date,post_source,post_like,post_hits,recommended,smeta";
        $Xitong = $term_relationships_model->alias("a")
            ->join($join)->join($join2)->join($join3)
            ->field($field)
            ->where($where)
            ->order(array("a.object_id" => "desc"))
            ->limit(0,2)
            ->select();
        $this->assign("Xitong",$Xitong);
        $this->assign("microblog_info",$microblog_info);
        $this->assign("activity_info",$activity_info);
        $this->assign("courseware_info",$courseware_info);
        $this->assign("today_info",$today_info);
        $this->assign("week_info",$week_info);
        $this->assign("month_info",$month_info);
        $this->assign("message_sum",$message_sum);
        $this->assign("Dynamic_info",$Dynamic_info);
        $this->assign("notice",$notice);
        $this->assign("entrust",$entrust);
        $this->assign("schedule",$schedule);
        $this->assign("name",$name);
    	$this->assign('server_info', $info);
    	$this->display();
    }
    function SystermMessage(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $this->display();
    }
    function SystermMessages(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $this->display();
    }
    //系统消息
   function System() {
        $id=intval($_GET['id']);
        $article=M("posts")->where("id=$id")->find();

        $article_id=$article['id'];

        $should_change_post_hits=sp_check_user_action("posts$article_id",1,true);
        if($should_change_post_hits){
            $posts_model=M("posts");
            $posts_model->save(array("id"=>$article_id,"post_hits"=>array("exp","post_hits+1")));
        }


        $smeta=json_decode($article['smeta'],true);
        $this->assign($article);
        $this->assign("post_content",$article["post_content"]);
        $this->assign("post_title",$article["post_title"]);

        $this->display();
    }
}