<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class CookManageController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }
	public function index(){
		$schoolid=$_SESSION['schoolid'];
        if($this->level!=1  && $this->level!=2)
        {
//          $map['ay.userid'] = $this->userid;
            $grade_q=Array();
            $class_q=M("teacher_class")
                ->alias('t')
                ->join("wxt_school_class s ON t.classid=s.id")
                ->where("t.teacherid=$this->userid")
                ->field("s.classname,s.id,s.grade")
                ->order("id")->select();

            foreach ($class_q as $item){
                $item_gid= $item['grade'];

//              $grade_item = M("school_grade")->where("gradeid=$item_gid and schoolid = $schoolid")->getF();
                array_push($grade_q,$item_gid);
//              unset($grade_item);
            }

            $teacher_grade = array_unique($grade_q);
            $where['grade'] = array("in",$teacher_grade);
            $where_grade['gradeid'] = array("in",$teacher_grade);
        }
         $where_grade['schoolid'] = $schoolid;

        //选择年级
		$grade=M('school_grade')->where($where_grade)->order("id asc")->select();
		//var_dump($grade);
		$this->assign("grade",$grade);
		$this->display();
	}

    function getdays($day){
        $lastday=date('Y-m-d',strtotime("$day Sunday"));
        $firstday=date('Y-m-d',strtotime("$lastday -6 days"));
        return array($firstday,$lastday);
    }
    public function add_post(){
		$userid=$_SESSION['USER_ID'];
		$schoolid=$_SESSION['schoolid'];
		//年级
		$grade=I("search_grade");
		//标题
		$title=I("title");

		//获取照片集合
        $cookpic = $_POST['cookpic'];

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
                   $this->error($school_grade['name'].'时间段已经存在!');
	              die();
		        }

	       }

     	 
   
     }else{
     	$recipe_time = M('cookbook')->where(array("schoolid"=>$schoolid,"grade"=>$grade,"mondaydate"=>$cook_time[0],"sundaydate"=>$cook_time[1]))->field("grade")->find();

     	if($recipe_time){
            $school_grade = M('school_grade')->where("schoolid = $schoolid and gradeid = $grade")->order("id ASC")->field("name")->find();
            $this->error($school_grade['name'].'时间段已经存在!');
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
		//$data["grade"]=$grade;
//		$data["begin_time"]=$begin_time;
//		$data["end_time"]=$end_time;
		$data["sign"]=$schoolid.time();
		$data["addtime"] = date('Y-m-d H:i:s',time());
		$data["addtimeint"] =time();

        //确认是否是定时发送
        $optionsRadiosinline = I('optionsRadiosinline');
        $teachertype = I('teachertype');

        if($optionsRadiosinline)
        {
            $data['timingtype'] = 1;
        }
       

        $re = I('timing');

        $data['teachertype'] = $teachertype;
         $re_time = explode(':', $re);
 

         $daytime = $re_time['0'] * 3600 + $re_time['1']*60;



		//算出有效期一共几天,然后循环几次
		$days=(strtotime($cook_time[1])-strtotime($cook_time[0]))/86400;





//     exit();



			
			
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
                            $pic =$cookpic[0];
                            break;
                        case '2':
                            $content = $tuesday;
                            $pic =$cookpic[1];
                            break;
                        case '3':
                            $content = $wednesday;
                            $pic =$cookpic[2];
                            break;
                        case '4':
                            $content = $thursday;
                            $pic =$cookpic[3];
                            break;
                        case '5':
                            $content = $friday;
                            $pic =$cookpic[4];
                            break;
                        case '6':
                            $content = $saturday;
                            $pic =$cookpic[5];
                            break;
                        case '7':
                            $content = $sunday;
                            $pic =$cookpic[6];
                            break;

                        default:
                            # code...
                            break;
                    }
                    if($content) {
                        $this->timing_mission($userid, $send_user_name, $schoolid, $send_user_name, $add_cook, $title . ':' . $content, 3, $plantimeint, 3, $plan_status, $schoolid);
                    }
                }


                if ($monday) {
                    if ($week_time == 1) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["content"] = $monday;
                        $data_detail["photo"] = $cookpic[0];

                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                //周二
                if ($tuesday) {
                    if ($week_time == 2) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["content"] = $tuesday;
                        $data_detail["photo"] = $cookpic[1];
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                //周三
                if ($wednesday) {
                    if ($week_time == 3) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = $cookpic[2];
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
                        $data_detail["photo"] = $cookpic[3];
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
                        $data_detail["photo"] = $cookpic[4];
                        $data_detail["content"] = $friday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }

                if ($saturday) {
                    if ($week_time == 6) {

                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = $cookpic[5];
                        $data_detail["content"] = $saturday;
                        $cook = M("cookbook_detail")->add($data_detail);

                    }
                }
                if ($sunday) {
                    if ($week_time == 7) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = $cookpic[6];
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
                        $this->timing_mission($userid, $send_user_name, $schoolid, $send_user_name, $add_cook, $title . ':' . $content, 3, $plantimeint, 3, $plan_status, $schoolid);
                    }
                }

                if ($monday) {
                    if ($week_time == 1) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = $cookpic[0];
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
                        $data_detail["photo"] = $cookpic[1];
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
                        $data_detail["photo"] = $cookpic[2];
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
                        $data_detail["photo"] = $cookpic[3];
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
                        $data_detail["photo"] = $cookpic[4];
                        $data_detail["content"] = $friday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                if ($saturday) {
                    if ($week_time == 6) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = $cookpic[5];
                        $data_detail["content"] = $saturday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
                if ($sunday) {
                    if ($week_time == 7) {
                        $data_detail["cookbookid"] = $add_cook;
                        $data_detail["week"] = $week_time;
                        $data_detail["date"] = $time;
                        $data_detail["photo"] = $cookpic[6];
                        $data_detail["content"] = $sunday;
                        $cook = M("cookbook_detail")->add($data_detail);
                    }
                }
            }
       }




		$this->success("操作成功!");
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


//   public function timing_mission($plantimming,$grade)
//   {
//
//   	// var_dump($grade);
//   	$schoolid = $_SESSION['schoolid'];
//   	 //如果为全校
//      if($grade==0)
//      {
//
//         $school_class = M("school_class")->where("schoolid = $schoolid and type = 1")->field("id")->select();
//
//
//         foreach ($school_class as $key => $value) {
//         	$classid = $value['id'];
//
//         	$relation = M("class_relationship")->alias("c")->where("c.classid = $classid and c.schoolid = $schoolid")->join("wxt_wxtuser u ON u.id = c.userid")->field("u.id,u.name")->select();
//
//           foreach ($relation as $key => $val) {
//
//             $studentname = $val['name'];
//             $studentid = $val['id'];
//
//            $default = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,"receiveuserid"=>$studentid,"receiveusername"=>$studentname,"classid"=>$classid,"type"=>1));
//            var_dump($default);
//
//            }
//
//         }
//
//      }else{
//
//         $school_class = M("school_class")->where("schoolid = $schoolid and type = 1 and grade = $grade")->field("id")->select();
//
//
//             foreach ($school_class as $key => $value) {
//         	$classid = $value['id'];
//
//         	$relation = M("class_relationship")->alias("c")->where("c.classid = $classid and c.schoolid = $schoolid")->join("wxt_wxtuser u ON u.id = c.userid")->field("u.id,u.name")->select();
//
//           foreach ($relation as $key => $val) {
//
//             $studentname = $val['name'];
//             $studentid = $val['id'];
//
//            $default = M("plantimmingdetail")->add(array("plantimmingid"=>$plantimming,"receiveuserid"=>$studentid,"receiveusername"=>$studentname,"classid"=>$classid,"type"=>1));
//            var_dump($default);
//
//            }
//
//         }
//
//      }
//
//
//   }



	public  function  lists(){
		$schoolid=$_SESSION['schoolid'];
		//选择年级

		//var_dump($grade);

		$search_grade=I("search_grade");


		$where["schoolid"]=$schoolid;
        if($this->level!=1  && $this->level!=2)
        {
//          $map['ay.userid'] = $this->userid;
            $grade_q=Array();
            $class_q=M("teacher_class")
                ->alias('t')
                ->join("wxt_school_class s ON t.classid=s.id")
                ->where("t.teacherid=$this->userid")
                ->field("s.classname,s.id,s.grade")
                ->order("id")->select();

            foreach ($class_q as $item){
                $item_gid= $item['grade'];

//              $grade_item = M("school_grade")->where("gradeid=$item_gid and schoolid = $schoolid")->getF();
                array_push($grade_q,$item_gid);
//              unset($grade_item);
            }

            $teacher_grade = array_unique($grade_q);
            $where['grade'] = array("in",$teacher_grade);
            $where_grade['gradeid'] = array("in",$teacher_grade);
        }

        $where_grade['schoolid'] = $schoolid;
//        $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
        $grade=M('school_grade')->where($where_grade)->order("id asc")->select();
        if($search_grade){
            $where["grade"]=$search_grade;
            $this->assign("grade_info",$search_grade);
        }
        $this->assign("grade",$grade);


		$count=M("cookbook")->where($where)->order("addtimeint DESC")->count();

		$page = $this->page($count, 20);

		$cook=M("cookbook")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("addtimeint DESC")->select();



		//exit();
		foreach ($cook as &$item) {
			
              if($item['week']==1){
              	$item['week'] ='星期一';
              }
               if($item['week']==2){
              	$item['week'] ='星期二';
              }
               if($item['week']==3){
              	$item['week'] ='星期三';
              }
               if($item['week']==4){
              	$item['week'] ='星期四';
              }
               if($item['week']==5){
              	$item['week'] ='星期五';
              }
                if($item['week']==6){
              	$item['week'] ='星期六';
              }
               if($item['week']==7){
              	$item['week'] ='星期日';
              }


			// $sign=$item["sign"];
		    //年级
		  if($item["grade"]==0){
		  	$item["grade"]="全校";
		  }else{	
        
			$where['gradeid']=$item["grade"];

			$where['schoolid'] = $schoolid;

			$grade=M("school_grade")->field("name")->where($where)->find();

			$item["grade_name"]=$grade["name"];

          }
			//发布人
			$userid=$item["userid"];
			$user_name=M("teacher_info")->field("name")->where("teacherid=$userid")->find();

			$item["user_name"]=$user_name["name"];
			// //周一食谱
			// $where_mo["sign"]=$sign;
			// $where_mo["week"]=1;
			// $monday=M("cookbook")->where($where_mo)->field("content")->find();
			// var_dump($monday);
			// $item["monday"]=$monday["content"];
			// //周二食谱
			// $where_tu["sign"]=$sign;
			// $where_tu["week"]=2;
			// $tuesday=M("cookbook")->where($where_tu)->field("content")->find();
			// var_dump($tuesday);
			// $item["tuesday"]=$tuesday["content"];
			// //周三食谱
			// $where_we["sign"]=$sign;
			// $where_we["week"]=3;
			// $wednesday=M("cookbook")->where($where_we)->field("content")->find();
			// var_dump($wednesday);

			// $item["wednesday"]=$wednesday["content"];
			// //周四食谱
			// $where_th["sign"]=$sign;
			// $where_th["week"]=4;
			// $thursday=M("cookbook")->where($where_th)->field("content")->find();
			// var_dump($thursday);
			// $item["thursday"]=$thursday["content"];
			// //周五食谱
			// $where_fr["sign"]=$sign;
			// $where_fr["week"]=5;
			// $friday=M("cookbook")->where($where_fr)->field("content")->find();
			// var_dump($friday);
			// $item["friday"]=$friday["content"];
		}
		//var_dump($cook);
		
        $this->assign("Page", $page->show('Admin'));
		$this->assign("cook",$cook);

		$this->display();
	}

	public function edit()
    {
        $cookbookid = I("cookbookid");
        $plantimming = I("plantimming");
        $teachertype = I("teachertype");

         if($plantimming)
         {
             $plantimming = M("plantimming")->where("contentId = $cookbookid")->getField("plantimeint");

             $time = date("H:i:s",$plantimming);


         }else{
             $time = "";
         }

        if($cookbookid)
        {
           $cookbook_detail  = M("cookbook_detail")->where("cookbookid = $cookbookid")->select();


        }
        if($cookbook_detail){

                 $ret  = $this->format_ret_else(1,$cookbook_detail,$time,$teachertype);


        }else{
            $ret  = $this->format_ret_else(0,"parms lost");
        }
        echo  json_encode($ret);


    }
    function format_ret_else ($status, $data='',$plantimming='',$teachertype='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data,'plantimming'=>$plantimming,'teachertype'=>$teachertype);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }
    public function edit_post()
    {

        if (IS_POST){

            $userid=$_SESSION['USER_ID'];
            $schoolid=$_SESSION['schoolid'];
            $send_user_name=M('wxtuser')->where("id=$userid")->getField("name");
           $cookbookid = I("cookbookid");
           $cook_time=$this->getdays(I("cook_time"));

            $cookpic = I("cookpic");

          $optionsRadiosinline = I("optionsRadiosinline");
          $re = I('timing');
          $teachertype =I("teachertype");

          if(!$teachertype)
          {
              $teachertype = 0;
          }


          $cook_title = I("cook_title");
          $monday = I("monday");
          $tuesday = I("tuesday");
          $wednesday = I("wednesday");
          $thursday = I("thursday");
          $friday = I("friday");
          $saturday = I("saturday");
          $sunday = I("sunday");
            //算出有效期一共几天,然后循环几次

            $days=(strtotime($cook_time[1])-strtotime($cook_time[0]))/86400;

//            dump(strtotime($cook_time[0]));

          if($cookbookid)
          {
              $cook_save = M("cookbook")->where("id = $cookbookid")->save(array("timingtype"=>$optionsRadiosinline,"title"=>$cook_title,"teachertype"=>$teachertype));

              M("cookbook_detail")->where("cookbookid = $cookbookid")->delete();
              //清除定时任务
              M("plantimming")->where("contentId = $cookbookid")->delete();
              if($optionsRadiosinline)
              {
                  $re_time = explode(':', $re);
                  $daytime = $re_time['0'] * 3600 + $re_time['1']*60;
//                  dump($daytime);


              }
              for ($i = 0; $i <= $days; $i++) {
//
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
                          $this->timing_mission($userid, $send_user_name,$schoolid,$send_user_name, $cookbookid, $cook_title . ':' . $content, 3, $plantimeint, 3, $plan_status, $schoolid);
                      }
                  }
                  if ($monday) {
                      if ($week_time == 1) {
                         $this->cook_add($cookbookid,$week_time,$monday,$time,$cookpic[0]);
                      }
                  }
                  //周二
                  if ($tuesday) {
                      if ($week_time == 2) {
                          $this->cook_add($cookbookid,$week_time,$tuesday,$time,$cookpic[1]);
                      }
                  }
                  //周三
                  if ($wednesday) {
                      if ($week_time == 3) {
                          $this->cook_add($cookbookid,$week_time,$wednesday,$time,$cookpic[2]);
                      }
                  }
                  //周四
                  if ($thursday) {
                      if ($week_time == 4) {
                          $this->cook_add($cookbookid,$week_time,$thursday,$time,$cookpic[3]);
                      }
                  }
                  //周五
                  if ($friday) {
                      if ($week_time == 5) {
                          $this->cook_add($cookbookid,$week_time,$friday,$time,$cookpic[4]);
                      }
                  }
                  if ($saturday) {
                      if ($week_time == 6) {
                          $this->cook_add($cookbookid,$week_time,$saturday,$time,$cookpic[5]);
                      }
                  }
                  if ($sunday) {
                      if ($week_time == 7) {
                          $this->cook_add($cookbookid,$week_time,$sunday,$time,$cookpic[6]);
                      }
                  }
              }
          }

    }


    }

    public function cook_add($cookbookid,$week,$content,$date,$photo)
    {
        $data_detail["cookbookid"] = $cookbookid;
        $data_detail["week"] = $week;
        $data_detail["date"] = $date;
        $data_detail["photo"] = $photo;
        $data_detail["content"] = $content;
        $data_detail["create_time"] = time();
        $cook = M("cookbook_detail")->add($data_detail);
    }

	public function delete(){


        $cookbookid = $_GET['id'];
        $timingtype = I("timingtype");
        if($timingtype)
        {
            $this->error("请将定时任务关闭后再删除！");
        }
        if($cookbookid){
            $cookbook = M("cookbook")->where("id = $cookbookid")->delete();

            if($cookbook)
            {
                $cookbook_detail = M("cookbook_detail")->where("cookbookid = $cookbookid")->delete();
            }
             if ($cookbook_detail) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            } 
        }else{
                $this->error('数据传入失败！');
        }
    }
}