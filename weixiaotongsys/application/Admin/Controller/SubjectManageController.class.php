<?php

/**
 * 后台 基础数据管理 学科管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SubjectManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
		
    }

//-----------------------学科管理---------------
    public function subject(){
        $subjects = D("Common/default_subject");
        $grade = I('grade');

        if($grade)
        {
            $where['gradetype'] = $grade;
            $where['schoolid'] = 0;
        
            $this->assign('grade',$grade);
        }else{
           
        $where['gradetype'] = 0;
        $where['schoolid'] = 0;
        $where['isdefault'] = 0;

        }




        $subjectPush = $subjects->where($where)->select();

        $class=M("schoolgradetype")->select();
        $this->assign("subject",$subjectPush);
         $this->assign("class",$class);
        $this->display("subjectManage");
    }

//渲染修改学科页面
    public function changeSubject(){
        $subjects = D("Common/default_subject");
        $subjectid = intval($_GET['id']);
        if ($subjectid) {
            $rst = $subjects->where(array("id"=>$subjectid))->find();
            if ($rst) {
                $this->assign("subject",$rst);
                $this->display("changeSubject");
            } else {
                $this->error('学校数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
//修改学科
    public function changeSubjectPost(){
        if (IS_POST) {
            if(!empty($_POST['subject_id'])){
                $data['id']=$_POST['subject_id'];
                $data['subject'] = $_POST['subject_name'];
                $data['create_time'] = time();
                $subjects = D("Common/default_subject");
                if ($subjects->save($data)){
                    $this->success("保存成功！",U('subject'));
                }else{
                    $this->error("保存失败！");
                }
            }else{
                $this->error("数据传入错误！");
            }
        }else{
            $this->error("数据传入失败！");
        }
    }

//删除学科
    public function delete_Subject(){
        $subjects = D("Common/default_subject");
        $subjectid = intval($_GET['id']);
        if ($subjectid) {
            $rst = $subjects->where("id=$subjectid")->delete();
            if ($rst) {
                $this->success("删除成功！",U('subject'));

            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }

    }

    //新增页面
    public function addsubject(){

         $class=M("schoolgradetype")->select();
        $this->assign("class",$class);
        $this->display("addSubject");
    }

    //新增
    public function add_subject(){
        if(IS_POST){
            $subjects = D("Common/default_subject");
            $grade = I("grade");

            $subject = I('subject');

            $data = array(
                   'subject'=>$subject,
                   'gradetype'=>$grade,
                   'create_time'=>time(),

                );



            $add = $subjects->add($data);
             

            if ($add){
                $this->success("添加成功",U('subject'));
               
            }else {
                $this->error($this->grade_model->getError());
            }

        }
    }
}

