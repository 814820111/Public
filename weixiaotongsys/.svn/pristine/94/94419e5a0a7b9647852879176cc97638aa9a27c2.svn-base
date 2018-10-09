<?php
  namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchCookbookController extends WeixinbaseController {
	//http://localhost/weixiaotong2016/index.php/weixin/TchCookbook/index
	//教师端本周食谱
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
	    $userid = $_SESSION['userid'];
        $this->assign('userid',$userid);
        if($_SESSION['schoolid']){
            $this->assign('schoolid',$_SESSION['schoolid']);
        }else{
            $tinfo = M("teacher_class")->where("teacherid = '$userid'")->find();
            $this->assign('schoolid',$tinfo['schoolid']);
        }
        //查找年级
        if($_SESSION['classid']){
            $classid = $_SESSION['classid'];
            $result = M("school_class")->where("id = '$classid'")->find();
            $this->assign('grade',$result['grade']);
        }
		$this->display();
	}

	//添加食谱
    public function addcook(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION['userid'];
        $this->assign('userid',$userid);
        $schoolid=$_SESSION['schoolid'];
        $this->assign('schoolid',$schoolid);
        //选择年级
//        $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
//        $this->assign("grade",$grade);

        $grade_q=Array();
        $class_q=M("teacher_class")
            ->alias('t')
            ->join("wxt_school_class s ON t.classid=s.id")
            ->where("t.teacherid=$userid")
            ->field("s.classname,s.id,s.grade")
            ->order("id")->select();

        foreach($class_q as $item){
            $item_gid= $item['grade'];
            array_push($grade_q,$item_gid);
        }
        $teacher_grade = array_unique($grade_q);
        $where_grade['gradeid'] = array("in",$teacher_grade);
        $where_grade['schoolid'] = $schoolid;
        $grade=M('school_grade')->where($where_grade)->order("id asc")->select(); //拉取这个老师的年级段
        $this->assign("grade",$grade);
	    $this->display();
    }

    function getdays($day){
        $lastday=date('Y-m-d',strtotime("$day Sunday"));
        $firstday=date('Y-m-d',strtotime("$lastday -6 days"));
        return array($firstday,$lastday);
    }
    public function add_post(){
        $userid=$_SESSION['userid'];
        $schoolid=$_SESSION['schoolid'];
        //年级
        $grade=I("search_grade");
        //$grade=3;
        //标题
        $title=I("title");
        //食谱有效期
        $selectdate = I("cook_time");

        $cook_time=$this->getdays(I("cook_time"));

        $send_user_name=M('wxtuser')->where("id=$userid")->getField("name");

        //查询发送人
        if($grade == 0){
            $school_grade = M('school_grade')->where("schoolid = $schoolid")->order("id ASC")->select();
            foreach ($school_grade as $key => $val) {

                $gradelist =  $val['gradeid'];

                $recipe_time = M('cookbook')->where(array("schoolid"=>$schoolid,"grade"=>$gradelist,"mondaydate"=>$cook_time[0],"sundaydate"=>$cook_time[1]))->field("grade")->find();

                if($recipe_time)
                {
                    $gradeid = $recipe_time['grade'];

                    $school_grade = M('school_grade')->where("schoolid = $schoolid and gradeid = $gradeid")->field("name")->find();
                    $error = $school_grade['name'].'该时间段食谱已经存在!';
                    echo json_encode(array('data'=>'0','type'=>2,'message'=>$error));
                    die();
                }

            }



        }else{
            $recipe_time = M('cookbook')->where(array("schoolid"=>$schoolid,"grade"=>$grade,"mondaydate"=>$cook_time[0],"sundaydate"=>$cook_time[1]))->field("grade")->find();

            if($recipe_time){
                $school_grade = M('school_grade')->where("schoolid = $schoolid and gradeid = $grade")->order("id ASC")->field("name")->find();
                $error = $school_grade['name'].'该时间段食谱已经存在!';
                echo json_encode(array('data'=>'0','type'=>2,'message'=>$error));
                die();
            }
        }



        //周一至周日的食谱
        $monday=I("monday");


        $tuesday=I("tuesday");
        //var_dump($tuesday);
        $wednesday=I("wednesday");
        //var_dump($wednesday);
        $thursday=I("thursday");
        //var_dump($thursday);
        $friday=I("friday");
        //	var_dump($friday);
        $saturday = I('saturday');

        $sunday = I('sunday');
        //数据
        $data["userid"]=$userid;
        $data["title"]=$title;
        $data["schoolid"]=$schoolid;
        $data["selectdate"]=$selectdate;
        $data["mondaydate"]=$cook_time[0];
        $data["sundaydate"]=$cook_time[1];
        $data["sign"]=$schoolid.time();
        $data["addtime"] = date('Y-m-d H:i:s',time());
        $data["addtimeint"] =time();

        //确认是否是定时发送
        $optionsRadiosinline = I('optionsRadiosinline');

        if($optionsRadiosinline)
        {
            $data['timingtype'] = 1;
        }

        $re = I('timing');

        $re_time = explode(':', $re);

        $daytime = $re_time['0'] * 3600 + $re_time['1']*60;


        //算出有效期一共几天,然后循环几次
        $days=(strtotime($cook_time[1])-strtotime($cook_time[0]))/86400;


        //如果为全校 则循环添加每一个年级
        if($grade == 0){
            $school_grade = M('school_grade')->where("schoolid = $schoolid")->order("id ASC")->select();


            foreach ($school_grade as $key =>  $value) {
                $gradeid = $value['gradeid'];

                $data['grade'] = $gradeid;

                $add_cook = M("cookbook")->add($data);

                if($add_cook) {
                    //循环数组
                    for ($i = 0; $i <= $days; $i++) {

                        //得到每天0点的时间戳
                        $time = strtotime($cook_time[0]) + ($i) * 86400;

                        //查出每天都是星期几
                        $week_time = date('N', $time);

                        //合并后的定时时间戳
                        $plantimeint =$time+$daytime;

                        if(time()<$plantimeint)
                        {
                            $plan_status = 1;
                        }else{
                            $plan_status = 3;
                        }
                        if($optionsRadiosinline)
                        {
                            switch ($week_time) {
                                case '1':
                                    $content = $monday;
                                    break;
                                case '2':
                                    $content = $tuesday;
                                    break;
                                case '3':
                                    $content = $wednesday;
                                    break;
                                case '4':
                                    $content = $thursday;
                                    break;
                                case '5':
                                    $content = $friday;
                                    break;
                                case '6':
                                    $content = $saturday;
                                    break;
                                case '7':
                                    $content = $sunday;
                                    break;

                                default:
                                    # code...
                                    break;
                            }
                            if($content) {
                                $timingres = $this->timing_mission($userid, $send_user_name, $schoolid, $send_user_name, $add_cook, $title . ':' . $content, 3, $plantimeint, 3, $plan_status, $schoolid);
                            }
                        }

                        if ($monday) {
                            if ($week_time == 1) {
                                $data_detail["cookbookid"] = $add_cook;
                                $data_detail["week"] = $week_time;
                                $data_detail["date"] = $time;
                                $data_detail["photo"] = 'weixiaotong.png';
                                $data_detail["content"] = $monday;
                                $cook = M("cookbook_detail")->add($data_detail);
                            }
                        }
                        //周二
                        if ($tuesday) {
                            if ($week_time == 2) {
                                $data_detail["cookbookid"] = $add_cook;
                                $data_detail["week"] = $week_time;
                                $data_detail["date"] = $time;
                                $data_detail["photo"] = 'weixiaotong.png';
                                $data_detail["content"] = $tuesday;
                                $cook = M("cookbook_detail")->add($data_detail);
                            }
                        }
                        //周三
                        if ($wednesday) {
                            if ($week_time == 3) {
                                $data_detail["cookbookid"] = $add_cook;
                                $data_detail["week"] = $week_time;
                                $data_detail["date"] = $time;
                                $data_detail["photo"] = 'weixiaotong.png';
                                $data_detail["content"] = $wednesday;
                                $cook = M("cookbook_detail")->add($data_detail);
                            }
                        }
                        //周四
                        if ($thursday) {
                            if ($week_time == 4) {
                                $data_detail["cookbookid"] = $add_cook;
                                $data_detail["week"] = $week_time;
                                $data_detail["date"] = $time;
                                $data_detail["photo"] = 'weixiaotong.png';
                                $data_detail["content"] = $thursday;
                                $cook = M("cookbook_detail")->add($data_detail);
                            }
                        }
                        //周五
                        if ($friday) {
                            if ($week_time == 5) {
                                $data_detail["cookbookid"] = $add_cook;
                                $data_detail["week"] = $week_time;
                                $data_detail["date"] = $time;
                                $data_detail["photo"] = 'weixiaotong.png';
                                $data_detail["content"] = $friday;
                                $cook = M("cookbook_detail")->add($data_detail);
                            }
                        }

                        if ($saturday) {
                            if ($week_time == 6) {
                                $data_detail["cookbookid"] = $add_cook;
                                $data_detail["week"] = $week_time;
                                $data_detail["date"] = $time;
                                $data_detail["photo"] = 'weixiaotong.png';
                                $data_detail["content"] = $saturday;
                                $cook = M("cookbook_detail")->add($data_detail);

                            }
                        }
                        if ($sunday) {
                            if ($week_time == 7) {
                                $data_detail["cookbookid"] = $add_cook;
                                $data_detail["week"] = $week_time;
                                $data_detail["date"] = $time;
                                $data_detail["photo"] = 'weixiaotong.png';
                                $data_detail["content"] = $sunday;
                                $cook = M("cookbook_detail")->add($data_detail);
                            }
                        }

                    }
                }

            }




        }else{
            $data["grade"]=$grade;

            $add_cook = M("cookbook")->add($data);
            for ($i = 0; $i <= $days; $i++) {

                //得到每天0点的时间戳
                $time = strtotime($cook_time[0]) + ($i) * 86400;

                //查出每天都是星期几
                $week_time = date('N', $time);
                $plantimeint =$time+$daytime;

                if(time()<$plantimeint)
                {
                    $plan_status = 1;
                }else{
                    $plan_status = 3;
                }

                if($optionsRadiosinline)
                {
                    switch ($week_time) {
                        case '1':
                            $content = $monday;
                            break;
                        case '2':
                            $content = $tuesday;
                            break;
                        case '3':
                            $content = $wednesday;
                            break;
                        case '4':
                            $content = $thursday;
                            break;
                        case '5':
                            $content = $friday;
                            break;
                        case '6':
                            $content = $saturday;
                            break;
                        case '7':
                            $content = $sunday;
                            break;

                        default:
                            # code...
                            break;
                    }
                    if($content) {
                        $timingres = $this->timing_mission($userid, $send_user_name, $schoolid, $send_user_name, $add_cook, $title . ':' . $content, 3, $plantimeint, 3, $plan_status, $schoolid);
                    }
                }


                if ($monday) {
                    if ($week_time == 1) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = 'weixiaotong.png';
                        $data_detail["content"] = $monday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                //周二
                if ($tuesday) {
                    if ($week_time == 2) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = 'weixiaotong.png';
                        $data_detail["content"] = $tuesday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                //周三
                if ($wednesday) {
                    if ($week_time == 3) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = 'weixiaotong.png';
                        $data_detail["content"] = $wednesday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                //周四
                if ($thursday) {
                    if ($week_time == 4) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = 'weixiaotong.png';
                        $data_detail["content"] = $thursday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                //周五
                if ($friday) {
                    if ($week_time == 5) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = 'weixiaotong.png';
                        $data_detail["content"] = $friday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                if ($saturday) {
                    if ($week_time == 6) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = 'weixiaotong.png';
                        $data_detail["content"] = $saturday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                if ($sunday) {
                    if ($week_time == 7) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = 'weixiaotong.png';
                        $data_detail["content"] = $sunday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
            }
        }


        if($optionsRadiosinline){ //定时
           echo json_encode(array('data'=>10,'type'=>1,'message'=>'定时任务添加成功'));
           die();
        }else{ //不定时
            if($cook){
                echo json_encode(array('data'=>$cook,'type'=>2,'message'=>'发送请求成功'));
                die();
            }else{
                echo json_encode(array('data'=>'0','type'=>2,'message'=>'发送添加失败'));
                die();
            }
        }


    }

    //增加定时任务
    public function  timing_mission($userid,$send_user_name,$schoolid,$send_user_name,$contentId,$content,$level,$plantimeint,$type,$plan_status,$schoolid)
    {
        $data_plan = array(
            'senduserId'=>$userid,
            'sendusername'=>$send_user_name,
            'contentId'=>$contentId,
            'connent'=>$content,
            'level'=>$level,
            'plantime'=>date('Y-m-d H:i:s',$plantimeint),
            'plantimeint'=>$plantimeint,
            'type'=>$type,
            'addtime'=>date('Y-m-d H:i:s',time()),
            'addtimeint'=>time(),
            'status'=>$plan_status,
            'schoolid'=>$schoolid
        );
        $plantimming = M('plantimming')->add($data_plan);
    }

    /*$schoolid 学校id  $grade 年级ID $date 当前日期 2018-1-29
     * 获取食谱列表
     */

    public function getCookbookContent()
    {
        $schoolid = I("schoolid");//学校ID
        $grade = I("grade");//年级ID
        $date = I("date");//日期
        if(empty($schoolid) || empty($grade) || empty($grade)){
            $ret = array("state"=>"error","date"=>"参数不足,获取失败");
            echo json_encode($ret);
            exit;
        }
        $cook_time=$this->getdays($date);//获得星期一和星期日的世界
        $mondaydate = $cook_time[0];
        $sundaydate = $cook_time[1];
        $where = array(
            "schoolid"=>$schoolid,
            "grade"=>$grade,
            "mondaydate"=>$mondaydate,
            "sundaydate"=>$sundaydate,
            "timingtype"=>array('neq',1)
        );

       // $result = M('cookbook')->where(array("schoolid"=>$schoolid,"grade"=>$grade,"mondaydate"=>$cook_time[0],"sundaydate"=>$cook_time[1]))->find();
        $result = M('cookbook')->where($where)->find();
        if(empty($result)){
            $ret = array("state"=>"error","data"=>"本周没有食谱");
            echo json_encode($ret);
            exit;
        }
        $cookbookid= $result["id"];//食谱ID
        $cooklist = M('cookbook_detail')->where(array("cookbookid"=>$cookbookid))->order('week asc')->select();
        if(empty($cooklist)){
            $ret = array("state"=>"error","data"=>"未获取到数据");
            echo json_encode($ret);
            exit;
        }else{
            foreach ($cooklist as &$value){
                $value["title"] = $result["title"];
            }
            $ret = array("state"=>"success","data"=>$cooklist);
            echo json_encode($ret);
            exit;
        }
    }

    public function getCookbooks()
    {
        $cookbookid= I("cookbookid");//食谱ID
        $result = M('cookbook')->where(array("id"=>$cookbookid))->find();
        $cooklist = M('cookbook_detail')->where(array("cookbookid"=>$cookbookid))->order('week asc')->select();
        if(empty($cooklist)){
            $ret = array("state"=>"error","data"=>"未获取到数据");
            echo json_encode($ret);
            exit;
        }else{
            foreach ($cooklist as &$value){
                $value["title"] = $result["title"];
            }
            $ret = array("state"=>"success","data"=>$cooklist);
            echo json_encode($ret);
            exit;
        }
    }


    public function getCookbook()
    {
        $schoolid = I("schoolid");//学校ID
        $grade = I("grade");//年级ID
        $where = array(
            "schoolid"=>$schoolid,
            "grade"=>$grade,
            "timingtype"=>array('neq',1)
        );

        // $result = M('cookbook')->where(array("schoolid"=>$schoolid,"grade"=>$grade,"mondaydate"=>$cook_time[0],"sundaydate"=>$cook_time[1]))->find();
        $result = M('cookbook')->where($where)->order("id asc")->field("id,title")->select();
       // $result = M('cookbook')->where(array("schoolid"=>$schoolid,"grade"=>$grade))->order("id asc")->field("id,title")->select();
        $newarray=array();
        foreach ($result as $value){
            $id = $value["id"];
            $title = $value["title"];
            $newarray[]=array("id"=>$id,"value"=>$title);

        }
        //$cc = json_encode($newarray);
//        dump($cc);
        if(empty($result)){
            $ret = array("state"=>"error","data"=>"未获取到数据");
            echo json_encode($ret);
            exit;
        }else{
            $ret = array("state"=>"success","data"=>$newarray);
            echo json_encode($ret);
            //echo $cc;
            exit;
        }
    }
}
?>