<?php
/**
 * Menu(菜单管理)
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class RemarksController extends AdminbaseController {
    function _initialize() {
        parent::_initialize();
        $this->rem_model = D("Common/remarks");
        $this->remdetail_model =D("Common/remarks_detail");
    }
    public function index()
    {
        if(empty($_REQUEST['rid'])){
            $remarkid=$this->rem_model->find();
            $rid=$remarkid['id'];
        }else{
            $rid=$_REQUEST['rid'];
        }

        if($rid)
        {
            $remarks_detail = $this->remdetail_model->where("rid = $rid")->select();
        }





        $remark = $this->rem_model->select();


        $result = $this->getCate($remark,0);
        $html = '';
        foreach ($result as $val)
        {
             if($val['id']==$rid)
             {
                 $selected = 'selected';
             }else{
                 $selected = '';
             }

            $html  .= "<option value=".$val['id']." $selected>";
            $html  .=str_repeat('&nbsp', $val['count'] * 4).'|--'.$val['name'];
            $html  .= "</option>";
        }

        $this->assign("remark",$html);
        $this->assign('remarks_detail',$remarks_detail);
        $this->assign("remarksid",$rid);
        $this->display();

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

    public function edit()
    {
        import("Tree");
        $tree = new \Tree();
        $rid = intval(I("get.rid"));
        $id = intval(I("get.id"));
        $rs = $this->remdetail_model->where(array("id" => $id))->find();
        $result = $this->rem_model->select();
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $rid ? 'selected' : '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";

//        $detail = $this->remdetail_model-where("")

        $tree->init($array);
        $select_categorys = $tree->get_tree(0, $str);
        $this->assign("data", $rs);
        $this->assign("select_categorys", $select_categorys);
        $this->display();
    }

    public function edit_post()
    {
        $id = I("id");
        $parentid = I("parentid");
        $contents = I("contents");

        if($id)
        {
            $save = $this->remdetail_model->where("id = $id")->save(array("rid"=>$parentid,"contents"=>$contents,"create_time"=>time()));

            if($save)
            {
                $this->success("修改成功",U("index"));
            }
        }else{
            $this->error("修改失败");
        }


    }
    public function delete()
    {
        $id = I("id");

        if($id)
        {
              $delete = $this->remdetail_model->where("id = $id")->delete();
              if($delete)
              {
                  $this->success("删除成功!",U("index"));
              }
        }else{
            $this->error("删除失败");
        }
    }

    public function add()
    {
       $rid = I("rid");
        import("Tree");
        $tree = new \Tree();

        $result = $this->rem_model->select();
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $rid ? 'selected' : '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";

//        $detail = $this->remdetail_model-where("")

        $tree->init($array);
        $select_categorys = $tree->get_tree(0, $str);
        $this->assign("select_categorys", $select_categorys);
       $this->display();

    }

    public function add_post()
    {
        $parentid =  I("parentid");
        $contents = I("contents");
        if(!$contents)
        {
            $this->error("内容不能为空！");
        }

        if($parentid)
        {
             $add = $this->remdetail_model->add(array("rid"=>$parentid,"contents"=>$contents,"create_time"=>time()));
             if($add)
             {
                 $this->success("添加内容成功",U("index"));
             }else{
                 $this->error("添加失败!");
             }
        }

    }

    public function export()
    {
        $allcount=I('allcount');
        $successcount=I('successcount');
        $updatecount=I('updatecount');
        $info=I('info');
        $remark = $this->rem_model->select();
        $result = $this->getCate($remark,0);
        $html = '';
        foreach ($result as $val)
        {


            $html  .= "<option value=".$val['id']." >";
            $html  .=str_repeat('&nbsp', $val['count'] * 4).'|--'.$val['name'];
            $html  .= "</option>";
        }

        $this->assign("remark",$html);
        $this->assign("allcount",$allcount);
        $this->assign("successcount",$successcount);
        $this->assign("updatecount",$updatecount);
        $this->assign("info",$info);
        $this->display();
    }


    public function export_post(){
        $remarkid = intval(I('remark'));



        $allcount=0;
        $successcount=0;
        $updatecount=0;

        if(!$remarkid){
            $this->error("请选择栏目");
        }
        $upload = new \Think\Upload();// 实例化上传类

        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath  =      './'; // 设置附件上传根目录
        $upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
        $upload->autoSub   = 	 false;//不自动生成子文件夹
        // 上传单个文件
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['excel_file']);


        $type = $info['ext'];

        $file_name = $info['name'];

        if(!$info){
            $this->error($upload->getError());
        }else{
            $file_puth = './'.$info['savepath'].$info['savename'];
            //文件上传成功，对文件进行解析
            // vendor('phpexcel_1.phpexcel');//导入类库
            require_once VENDOR_PATH.'PHPExcel/PHPExcel/IOFactory.php';
            require_once VENDOR_PATH.'PHPExcel/PHPExcel.php';
            if($info['ext']=='xlsx'){
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
            }else{
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }

            //use excel2007 for 2007 format
            $objPHPExcel = $objReader->load($file_puth);

            // $objPHPExcel->setActiveSheetIndex(1);
            $sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始)

            $highestRow = $sheet->getHighestRow(); // 取得总行数

            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            //循环读取excel文件,读取一条,插入一条
            // $info='begin::';
            for($j=2;$j<=$highestRow;$j++)
            {
                for($k='A';$k<=$highestColumn;$k++)
                {
                    //读取单元格
                    $ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                    $allcount++;
                }
            }
            $info=$j.'-'.$k.':'.$info.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();
            //var_dump($info);
            // $info=$info.'end';
            $successcount=0;
            $error_info = array();
            $rowNo = 1;



            foreach ($ExamPaper_arr as $key => $value)
            {
                //循环数据检测A=>学生姓名，B=>班级，C=>监护人姓名，D=>家长联系方式，H=>关系, L=>性别，M=>学号，N=>IC卡号，O=>是否住校
                //如果题号或者题干不为空
                if(!empty($value['A'])){
                    $contents=$value['A'];
                    // var_dump($name);


                    $result=$this->importstudent(trim($contents),$remarkid);

                    /**
                     * 导入教师以及关系数据到数据库
                     * return 0 必填字段获取失败
                     * return 1 成功
                     * return 2 老师用户添加失败
                     * return 3 职务绑定失败
                     * return 4 科目绑定失败
                     * return 5 班级绑定失败
                     * return 6 学校信息获取失败
                     * return 7 老师info信息保存失败
                     */
                    if($result ==1){
                        $successcount++;
                    }else if($result ==2){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"内容或栏目缺失！"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==3){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"IC卡号已经存在"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==4){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"家长联系号码已经存在"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==5){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"班级绑定失败"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result == 6){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"学校信息获取失败"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result==7){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"老师info信息保存失败"
                        );
                        array_push($error_info,$error_item);
                    }else if ($result == 0){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"必填字段获取失败"
                        );
                        array_push($error_info,$error_item);
                    }
                }else {
                    $error_item = array(
                        "row"=>$rowNo,
                        "msg"=>"必填数据未填写"
                    );
                    array_push($error_info,$error_item);
                }

                $rowNo++;
            }
        }


        $emptyData = "";
        foreach ($error_info as &$error_item){
            $emptyData = $emptyData."第".($error_item["row"]+1)."行".$error_item["msg"].",";
        }

        $allcount=$highestRow-1;
        $updatecount=$allcount-$ius;




        $info='::其中成功'.$successcount.'人,'.$emptyData;




        $this->success('导入完成','export/successcount/'.$successcount.'/allcount/'.$allcount.'/info/ok::'.$info);
    }
    function importstudent($content,$remarkid){
        // exit();

        $result = 1;
        //0.失败，1新增，2更新
        if($remarkid && $content)
        {
            $data['rid'] = $remarkid;

            $data['contents'] = $content;
            $data['create_time'] = time();
           $remark_detail = $this->remdetail_model->add($data);

        }else{
            $return =  2;
        }




      return $result;
    }

    public function remarks_list()
    {
        $result = $this->rem_model->select();
        import("Tree");
        $tree = new \Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        foreach ($result as $n=> $r) {
            // $result[$n]['level'] = $this->_get_level($r['id'], $newmenus);
            $result[$n]['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . '"' : '';

            $result[$n]['str_manage'] = '<a href="' . U("remarks_add", array("cid"=>$r['cid'],"parentid" => $r['id'], "menuid" => $_GET['menuid'])) . '">添加子菜单</a> | <a target="_blank" href="' . U("remarks_edit", array("id" => $r['id'],"cid"=>$r['cid'], "menuid" => $_GET['menuid'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("remarks_delete", array("id" => $r['id'], "menuid" => I("get.menuid")) ). '">删除</a> ';
            $result[$n]['status'] = $r['status'] ? "显示" : "隐藏";

        }
        $tree->init($result);
        $str = "<tr id='node-\$id' \$parentid_node>
				
					<td>\$id</td>
        		
					<td>\$spacer\$name</td>
				    <td>\$status</td>
					<td>\$str_manage</td>
				</tr>";

        $categorys = $tree->get_tree(0, $str);
        $this->assign("categorys", $categorys);

        $this->display();
    }

    public function remarks_add()
    {
        import("Tree");
        $tree = new \Tree();
        $parentid = intval(I("get.parentid"));
        $result = $this->rem_model->select();
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $parentid ? 'selected' : '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        $select_categorys = $tree->get_tree(0, $str);
        $this->assign("select_categorys", $select_categorys);
        $this->display();
    }
    public function remarks_add_post()
    {
        $parentid  = I("parentid");
        $name = I("name");

        $add_remarks = $this->rem_model->add(array("name"=>$name,"parentid"=>$parentid));
        if($add_remarks)
        {
            $this->success("添加成功!",U("remarks_list"));
        }else{
            $this->error("添加失败!");
        }

    }

    public function remarks_edit()
    {
        import("Tree");
        $tree = new \Tree();
        $id = intval(I("get.id"));
        $rs = $this->rem_model->where(array("id" => $id))->find();
        $result = $this->rem_model->select();
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $rs['parentid'] ? 'selected' : '';
            $array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        $select_categorys = $tree->get_tree(0, $str);
        $this->assign("data", $rs);
        $this->assign("select_categorys", $select_categorys);
        $this->display();
    }

    public function remarks_edit_post()
    {
        $id = I("id");
        $parentid = I("parentid");
        $name = I("name");

        $add = $this->rem_model->where("id = $id")->save(array("name"=>$name,'parentid'=>$parentid,"type"=>1));
        if($add)
        {
            $this->success("修改成功！",U("remarks_list"));
        }else{
            $this->error("修改失败!");
        }
    }
    public function remarks_delete()
    {
        $id = intval(I("get.id"));
        $count = $this->rem_model->where(array("parentid" => $id))->count();
        if ($count > 0) {
            $this->error("该菜单下还有子菜单，无法删除！");
        }
        if ($this->rem_model->delete($id)!==false) {
            $this->remdetail_model->where("rid = $id")->delete();
            $this->success("删除菜单成功！");
        } else {
            $this->error("删除失败！");
        }
    }

}
