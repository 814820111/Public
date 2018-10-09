<?php
/**
 * 后台首页 家长信息管理
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class ParentManageController extends TeacherbaseController {

	protected $parentRelationModel;
	protected $wxtuser_model;

	function _initialize() {
        parent::_initialize();

        $this->wxtuser_model = M("Wxtuser");
        $this->parentRelationModel = M("Relation_stu_user");

    }
    function index(){
		$this->_lists();
		$this->display("ParentManage/index");
	}

	private  function _lists(){
		$school_id=0;
		if(!empty(I("school"))){
			$school_id=I("school");
		}

        if (!empty(I('school_id'))){
            $map['s.schoolid'] = I('school_id');
        }else{

            if (!empty(I('province'))){
                $map['s.city'] = I('province');
                $this->assign("province", I('province'));
            }
            if (!empty(I('city'))){
                $map['s.city'] = I('city');
                $this->assign("province", I('city'));
            }
            if (!empty(I('city_next'))){
                $map['s.city'] = I('city_next');
                $this->assign("province", I('city_next'));
            }
        }
        if (!empty(I('keywordtype'))&&!empty(I('keyword'))&&I('keywordtype')=='name'){

            $map['u.name'] = array("like","%".I('keyword')."%");

        }

        if (!empty(I('keywordtype'))&&!empty(I('keyword'))&&I('keywordtype')=='phone'){
            $map['u.phone'] = array("like","%".I('keyword')."%");
        }

        //通过用户表和学生家长关系表获取所有家长
        $count = $this->wxtuser_model
            ->alias("u")
            ->join("wxt_relation_stu_user r ON u.id = r.userid")
            ->join(C('DB_PREFIX')."school s ON u.schoolid=s.schoolid")
            ->where($map)
            ->count();
        $page = $this->page($count, 20);
        $parents = $this->wxtuser_model
            ->alias("u")
            ->join("wxt_relation_stu_user r ON u.id = r.userid")
            ->join(C('DB_PREFIX')."school s ON u.schoolid=s.schoolid")
            ->where($map)
            ->field("u.id,u.name,u.phone,u.create_time,r.appellation,r.studentid,r.type")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("r.studentid asc")
            ->select();


        //通过家长获取对应的孩子信息
        foreach ($parents as &$parent){
            $student = $this->wxtuser_model
                ->where("$parent[studentid] = id")
                ->select();
            $parent['studentname'] = $student[0]["name"];
            unset($parent);
        }
//        echo "<pre>";print_r($parents);echo "</pre><br>";
        $this->assign("parents",$parents);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("province",M("City")->where("parent=0")->select());
	}
    //地级划分
    public function Provinces(){
        $Province=I("Province");
        if (isset($Province)){
            $Shisheng=M("City")->where("parent=$Province")->select();
            echo json_encode(array('data'=>$Shisheng,'message'=>'10000'));
        }
    }

    //通过区域来找对应的学校
    public function lookup(){
        $type=I("type");
        if($type!=""){
            if($type==0){
                $School=M("School")->where()->field("school_name,schoolid,schoolgradetypeid")->select();
            }else{
                $School=M("School")->where("city=$type")->field("school_name,schoolid,schoolgradetypeid")->select();
            }

        }else{
            $ret = $this->format_ret(0,'参数缺失！');
        }

        echo json_encode(array('data'=>$School,'message'=>'10000'));
    }
	function edit(){


	}
	function edit_post(){


	}
    function delete(){

    }
     
}