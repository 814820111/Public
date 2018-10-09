<?php

/**
 * 考勤卡备卡管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
header("Content-type: text/html; charset=utf-8");      
class SpareCardController extends AdminbaseController {

    function _initialize() {
        parent::_initialize();
    }

    function index() {
        $this -> _lists();
        $this -> display();
    }
    private function _lists() {

        $schoolid = I("school");
        $schoolname=M("school")->where("schoolid = '$schoolid'")->field("school_name")->find();
        $this->assign('schoolid',$schoolid);
        $this->assign('schoolname',$schoolname['school_name']);// 赋值分页输出
        $count = M("SpareCard")->where("schoolid = '$schoolid'")->count();
        $page = $this->page($count,50);
        $show = $page->show('Admin');// 分页显示输出
        $list = M("SpareCard")->where("schoolid = '$schoolid'")->order('id')->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('Page',$show);// 赋值分页输出
        $province = I("province");
        $citys = I('citys');
        $message_type = I('message_type');
        $Province=role_admin();
        $this->assign("Province",$Province);
        if($province)
        {
            $this->assign("province",$province);
        }

        if($citys){
            $this->assign("new_citys",$citys);
        }
        if($message_type)
        {
            $this->assign("new_message_type",$message_type);
        }
        if($province && $citys && $message_type && $schoolid)
        {
            //写入缓存
            write_condition($province,$citys,$message_type,$schoolid,$this->only_code);

        }
    }
    public function addcard_post(){
        $schoolid= intval($_POST['school']);
        $card=$_POST['card'];
        if(!$card){
            $this->error('请输入卡号！');
        }
        if(!is_numeric($card) || strlen($card)!==10){
            $this->error('请输入十位数字卡号');
        }
        if(!$schoolid){
            $this->error('数据丢失，请返回重试');
        }
            $where['schoolid']=$schoolid;
            $where['cardNo']=$card;
            $iscard = M("StudentCard")->where($where)->find();
            if($iscard){
                $this->error('添加失败！该卡号已存在该学校卡号列表中');
            }
            $data['schoolid']=$schoolid;
            $data['cardno']=$card;

            $iscards = M("SpareCard")->where($data)->find();
             if($iscards){
              $this->error('添加失败！该卡号已存在该学校副卡列表中');
              }
        $data['add_date']=time();
        $data['add_datetime']=date('Y-m-d H:i:s', time());
            $classid = M("SpareCard")->add($data);
            if($classid){
                $this->success("保存成功！");
            }else{
                $this->error('数据传入失败！');
            }

        // die('asdfasd');
    }
    function addcard() {
        $Province=role_admin();
        $cache_data = get_condition_cache($this->only_code);
        $this -> assign("cache_data", $cache_data);
        $this->assign("Province",$Province);
        $this -> display();
    }
    public function  del()
    {
        $where[id]=I('delcard');
        $where[status]="0";
        $Result = M("SpareCard")->where($where)->delete();
        if($Result){
            $data['type']="删除成功";
            echo json_encode($data);
            exit();
        }else{
            $data['type']="删除失败";
            echo json_encode($data);
            exit();
        }
    }
    //批量导入学生卡号
    public function card(){
        $allcount=I('allcount');
        $successcount=I('successcount');
        $info=I('info');
        $Province=role_admin();
        $cache_data = get_condition_cache($this->only_code);
        $this -> assign("cache_data", $cache_data);
        $this->assign("Province",$Province);
        $this->assign("allcount",$allcount);
        $this->assign("successcount",$successcount);
        $this->assign("info",$info);
        $this->display();
    }
    public function card_post(){
        $schoolid = intval(I('school'));
        if(!$schoolid){
            $this->error("请选择学校");
        }
        //判断学校信息是否存在
        if ($schoolid){
            $isShool = M("School")->where("schoolid=$schoolid")->find();

            if (!$isShool){
                $this->error("学校信息不存在");
            }
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

        if(!$info){
            $this->error($upload->getError());
        }

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

        $data=array();
        $rowNo = 1;
        $successcount=0;
        $error_info = array();
        //查出该学校下的所有卡号
        $Result = M("student_card")->where("schoolid=$schoolid")->field('cardNo')->select();
        $cardNoarrays = $this->array_column($Result, 'cardno');
        unset($Result);
        //查出该学校下的所有卡号
        $Result = M("SpareCard")->where("schoolid=$schoolid")->field('cardno')->select();
        $cardNoarray = $this->array_column($Result, 'cardno');
        unset($Result);
        $timenow=time();
        $datanow=date('Y-m-d H:i:s', time());
        foreach ($ExamPaper_arr as $key => $value) {
            if (empty($value['A'])) {
                $error_item = array(
                    "row" => $rowNo,
                    "msg" => "卡号未填写"
                );
                array_push($error_info, $error_item);
                $rowNo++;
                continue;
            }
            $Card=trim($value['A']);
            if (in_array("$Card", $cardNoarrays)){
                $error_item = array(
                    "row" => $rowNo,
                    "msg" => "卡号已在学校卡号列表中存在"
                );
                array_push($error_info, $error_item);
                $rowNo++;
                continue;
            }
            if (in_array("$Card", $cardNoarray)){
                $error_item = array(
                    "row" => $rowNo,
                    "msg" => "卡号已在学校备卡列表中存在"
                );
                array_push($error_info, $error_item);
                $rowNo++;
                continue;
            }
            $SCard['cardno']=$Card;
            $SCard['schoolid']=$schoolid;
            $SCard['add_date']=$timenow;
            $SCard['add_datetime']=$datanow;
            $classid = M("SpareCard")->add($SCard);
            if($classid){
                $successcount++;
                $rowNo++;
            }else{
                $error_item = array(
                    "row" => $rowNo,
                    "msg" => "保存失败"
                );
                array_push($error_info, $error_item);
                $rowNo++;
                continue;
            }
        }
        $emptyData = "";
        foreach ($error_info as &$error_item){
            $emptyData = $emptyData."第".($error_item["row"])."行".$error_item["msg"]."。";
        }
        $allcount=$highestRow-1;
        $info='::其中成功'.$successcount.'人,'.$emptyData;
        $this->success('导入完成','card/successcount/'.$successcount.'/allcount/'.$allcount.'/info/ok::'.$info);
    }
    public function  huoqu()
    {
        $where[schoolid]=I('schoolid');
        $where[status]="0";
        $Result = M("SpareCard")->where($where)->field(id,cardno)->select();
        if($Result){
            $data['data']=$Result;
            $data['count']=count($Result);
            $data['status']="1";
            echo json_encode($data);
            exit();
        }else{
            $data['data']="";
            $data['count']="0";
            $data['status']="0";
            echo json_encode($data);
            exit();
        }
    }
    public function  huoquall()
    {
        $where[schoolid]=I('schoolid');
        $Result = M("SpareCard")->where($where)->select();
        if($Result){
            $data['data']=$Result;
            $data['count']=count($Result);
            $data['status']="1";
            echo json_encode($data);
            exit();
        }else{
            $data['data']="";
            $data['count']="0";
            $data['status']="0";
            echo json_encode($data);
            exit();
        }
    }
    /**
     * 低于PHP 5.5版本的array_column()函数
     **/
    function array_column($input, $columnKey, $indexKey = NULL)
    {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
        $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
        $result = array();

        foreach ((array)$input AS $key => $row)
        {
            if ($columnKeyIsNumber)
            {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
            }
            else
            {
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
            }
            if ( ! $indexKeyIsNull)
            {
                if ($indexKeyIsNumber)
                {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
                    $key = is_null($key) ? 0 : $key;
                }
                else
                {
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }

            $result[$key] = $tmp;
        }

        return $result;
    }
}