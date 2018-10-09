<?php

/**
 * 后台首页  日常管理
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class ColumnManageController extends TeacherbaseController {

    protected $school_column_model;

    function _initialize() {
        parent::_initialize();
        $this->school_column_model = M("School_column");
    }

    function getCate($data, $id, $count = 0)
    {
        static $res = array();
        foreach ($data as $val) {
            if ($val['parentid'] == $id) {
                $val['count'] = $count;
                //var_dump($val['pid']);
                //var_dump($val);
                $res[] = $val;
                $this->getCate($data, $val['id'], $count + 1);
            }
        }
        return $res;
    }

    //栏目列表
    public function index() {
        $schoolid=$_SESSION['schoolid'];
        $count = $this->school_column_model->where("schoolid = $schoolid")->order("sortid desc")->count();
        $page = $this->page($count,20);
        $column = $this->school_column_model->where("schoolid = $schoolid") ->limit($page->firstRow . ',' . $page->listRows)->order("sortid desc")->select();
        $this->assign("Page", $page->show('Admin'));

        $result = $this->getCate($column,0);
//        dump($result);
        foreach ($result as &$val)
        {
            $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
        }


//        $this->assign("column",$column);
        $this->assign("column",$result);
        $this->display();
    }


    //栏目添加页面
   public function add(){
       $schoolid=$_SESSION['schoolid'];
        $column = $this->school_column_model->where("schoolid = $schoolid")->order("sortid desc")->select();
       $result = $this->getCate($column,0);
       foreach ($result as &$val)
       {
           $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
       }

       $this->assign("column",$result);
      $this->display();
    }

    //栏目提交页面
    public  function add_post(){
        //dump($_POST['smeta']['thumb']);
            $data = $this->school_column_model->create();
            //dump($data);
            //die();
            if($data){
                $data['schoolid'] = $_SESSION['schoolid'];
                if($_POST['smeta']['thumb']){
                    $data["icon"] = $_POST['smeta']['thumb'];//图标
                }else{
                    $data["icon"] = "http://ow3hm6y11.bkt.clouddn.com/img03.png";//图标
                }

                $result = $this->school_column_model->add($data); // 写入数据到数据库
                if($result){
                    $this->success("新增成功！",U("index"));
                }else{
                    $this->error("新增失败！");
                }
            }else{
                $this->error("表单验证失败！");
            }

    }

    //栏目修改页面
    public function edit(){
        $schoolid=$_SESSION['schoolid'];
        $query = $this->school_column_model->where("schoolid = $schoolid")->order("sortid desc")->select();
        $result = $this->getCate($query,0);
        foreach ($result as &$val)
        {
            $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
        }
        $this->assign("result",$result);


        $id=  intval(I("id"));
        $column_type= I("column_type");
        $this->assign("column_type",$column_type);
        $column = $this->school_column_model->where(array("id"=>$id))->find();

        $this->assign("column",$column);
        $this->assign("parentid",$column["parentid"]);
        $this->display();
    }

    //栏目修改提交页面
    public function edit_post(){
//        dump($_POST['smeta']['thumb']);
//        die();
        $data = $this->school_column_model->create();
//        dump($data);
//        die();
        if($data){
            if($_POST['smeta']['thumb']){
                $data["icon"] = $_POST['smeta']['thumb'];//图标
            }else{
                $data["icon"] = "http://ow3hm6y11.bkt.clouddn.com/img03.png";//图标
            }
            $result = $this->school_column_model->save($data); // 写入数据到数据库
            if($result){
                $this->success("修改成功！",U("index"));
            }else{
                $this->success("修改失败！");
            }
        }else{
            $this->success("表单验证失败！");
        }

    }
   

    //栏目删除页面
    public function delete()
    {

         $id=intval($_GET['id']);
        //var_dump($id);
        $count = $this->school_column_model->where("parentid=$id")->select();
        if($count)
        {
            $this->error("这个菜单下还有子类,不能直接删除!请先删除子类!");
        }
        if ($id) {
            $rst = $this->school_column_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }

    //首页幻灯片设置
    public function SlideSetting()
    {
        $schoolid=$_SESSION['schoolid'];
        if($schoolid)
        {
            $slide = M("school_slide as a")->join("wxt_school as b on a.schoolid=b.schoolid")->field("a.*,b.school_name")->select();
            $this->assign("slide",$slide);
        }

        $this->display();
    }

    //添加幻灯片
    public function add_Slide()
    {
        $slide = M("school_slide as a")->field("a.*")->count();
//        if($slide>=3){
//            $this->success("幻灯片最多为三张,请先进行删除,在进行添加操作",U("SlideSetting"));
//        }else{
            $count = 3 - $slide;
//        }
        $this->assign("count",$count);
        $this->display();
    }

    //幻灯片提交
    public  function add_Slide_post()
    {
        $schoolid=$_SESSION['schoolid'];
        $maxcount = I("maxcount");
        $desc = I("desc");
        $url = I("url");
        if($_POST["smeta"]["thumb"])
        {
            $arr = explode('|', $_POST["smeta"]["thumb"]);
            $count = count($arr);
            if($count>$maxcount)
            {
                $str = "最多还可以添加".$maxcount."张幻灯片";
                $this->error($str,U("add_Slide"));
                return;
            }
            foreach ($arr as $value)
            {
                if($value)
                {
                    $data=array("schoolid"=>$schoolid,"photourl"=>$value,"create_time_int"=>time(),"create_time"=>date('Y-m-d H:i:s', time()),"desc"=>$desc,"url"=>$url);
                    $res = M("school_slide")->add($data);

                }
            }

            if ($res)
            {
                $this->success("添加成功",U("SlideSetting"));
            }else{
                $this->error("添加失败",U("SlideSetting"));
            }


        }else{
            $this->error("请上传图片",U("add_Slide"));
        }

    }

    //修改幻灯片
    public function edit_Slide()
    {
        $id  = I("id");
        $schoolslide = M("school_slide")->where(array("id"=>$id))->find();

        $this->assign("schoolslide",$schoolslide);
        $this->display();
    }

    //修改幻灯片提交
    public function edit_Slide_post()
    {
        $id=I("id");
        $desc = I("desc");
        $url = I("url");
        $photourl = I("photourl");

        if(empty($photourl))
        {
            $this->error("请上传图片");
        }

        $data=array("photourl"=>$photourl,"create_time_int"=>time(),"create_time"=>date('Y-m-d H:i:s', time()),"desc"=>$desc,"url"=>$url);

//        dump($data);
//        die();
        $res = M("school_slide")->where(array("id"=>$id))->save($data);
        if ($res)
        {
            $this->success("修改成功",U("SlideSetting"));
        }else{
            $this->error("修改失败",U("SlideSetting"));
        }
    }


    //幻灯片删除
    function slide_delete(){
        $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = M("school_slide")->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }


  //网站基础设置
    public function school_setting()
    {
        $schoolid = $_SESSION["schoolid"];
        $school = M("school_setting")->where(array("schoolid"=>$schoolid))->find();

//        dump($school);
        if(count($school))
        {
            $this->assign("type",2);
        }else{
            $this->assign("type",1);
        }

        $this->assign("school",$school);

        $this->display();
    }

    //网站基础设置提交
    public function add_school_setting_post()
    {
        $schoolid = $_SESSION["schoolid"];
        $formtype = I("formtype");

        $data = M("school_setting")->create();

        if($schoolid and $data){
            $data["schoolid"] = $schoolid;
            $data['create_time'] = date('Y-m-d h:i:s', time());
            $data['create_time_int'] =  time();
            if($formtype==1)
            {
                $result=M("school_setting")->add($data);
            }else{
                $result=M("school_setting")->where(array("schoolid"=>$schoolid))->save($data);
            }

            if ($result!==false) {
                $this->success("保存成功");
            } else {
                $this->error("保存失败");
            }
        }else{
            $this->error("缺少参数,保存失败");
        }
    }

}