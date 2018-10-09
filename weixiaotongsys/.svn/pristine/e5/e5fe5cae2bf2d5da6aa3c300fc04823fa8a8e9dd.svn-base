<?php

/**
 * 敏感词管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
header("Content-type: text/html; charset=utf-8");      
class SensitiveWordController extends AdminbaseController {

    function _initialize() {
        parent::_initialize();

    }

    function index() {

        $this -> _lists();
        $rowNo=I('rowNo');
        $success=I('success');
        $rowNos=I('rowNos');
        $successs=I('successs');
        $this->assign('rowNo',$rowNo);
        $this->assign('success',$success);
        $this->assign('rowNos',$rowNos);
        $this->assign('successs',$successs);
        $this -> display();
    }
    public function  _lists()
    {
        $word=I('word');

            $count = M("FilterWord")->where("word like '%$word%'")->count();
            $page = $this->page($count,100);
            $show = $page -> show('Admin');// 分页显示输出
            $list = M("FilterWord")->where("word like '%$word%'")->order('id')->limit($page->firstRow . ',' . $page->listRows)->select();
            $this->assign('list',$list);// 赋值数据集
            $this->assign('Page',$show);// 赋值分页输出


    }
    public function  add()
    {
        $where[word]=I('addword');
        if(empty($where[word])){
            $data['type']="敏感词为空";
            echo json_encode($data);
            exit();
        }
        $Result = M("FilterWord")->where($where)->field('id')->find();
        if($Result){
            $data['type']="敏感词已存在";
            echo json_encode($data);
            exit();
        }
        $add = M("FilterWord")->add($where);
        if($add){
            $data['type']="插入成功，请更新缓存文件";
            echo json_encode($data);
            exit();
        }
        $data['type']="插入失败";
        echo json_encode($data);
        exit();
    }
    public function  del()
    {
        $where[id]=I('delsword');
        $Result = M("FilterWord")->where($where)->delete();
        if($Result){
            $data['type']="删除成功";
            echo json_encode($data);
            exit();
        }
    }
    public function delword(){

        $upload = new \Think\Upload();// 实例化上传类

        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath  =      './'; // 设置附件上传根目录
        $upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
        $upload->autoSub   = 	 false;//不自动生成子文件夹
        // 上传单个文件
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['excel_file_del']);

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

        $data="";
        $rowNo = 1;
        foreach ($ExamPaper_arr as $key => $value) {
            if (empty($value['A'])) {
                $rowNo++;
                continue;
            }
            $data .= "'".trim($value['A'])."',";
            $rowNo++;
        }
        $data .= "''";
    $insertOkInfo = M("FilterWord")->where("word in ($data)")->delete();



        $this->success('删除敏感词成功','index/rowNos/'.$rowNo.'/successs/'.$insertOkInfo);
    }
    public function addword(){

        $upload = new \Think\Upload();// 实例化上传类

        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath  =      './'; // 设置附件上传根目录
        $upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
        $upload->autoSub   = 	 false;//不自动生成子文件夹
        // 上传单个文件
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['excel_file_add']);

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

            //查出所有敏感词
        $Result = M("FilterWord")->field('id,word')->select();
        $SWordArray = $this->array_column($Result, 'word');
        unset($Result);
            foreach ($ExamPaper_arr as $key => $value) {
                if (empty($value['A'])) {
                    $rowNo++;
                    continue;
                }
                $Word=trim($value['A']);
                    if (in_array("$Word", $SWordArray)){
                        $rowNo++;
                        continue;
                    }
                    $SWord['word']=$Word;
                    array_push($data,$SWord);
                $rowNo++;
            }
        $insertOkInfo = M("FilterWord")->addAll($data);
        $success=count($data);


        $this->success('添加敏感词成功','index/rowNo/'.$rowNo.'/success/'.$success);
    }
    public function updata(){
        //查出所有敏感词
        $Result = M("FilterWord")->field('id,word')->select();
        $SWordArray = $this->array_column($Result, 'word');
        $file=APP_PATH."FilterWord.txt";
        $myfile = fopen($file, "w") or die("Unable to open file!");
        foreach ($SWordArray as $value)
        {
            $txt = $value."\r\n";
            fwrite($myfile, $txt);
        }
        fclose($myfile);
        $data['type']="更新成功";
        echo json_encode($data);
        exit();
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