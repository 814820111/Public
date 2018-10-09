<?php

//namespace 10\Controller\;
use Common\Controller\AppBaseController;
/**
 * 通道闸－福建鑫诺通讯技术有限公司协议版本
 */
class IndexController extends AppBaseController {
	
    //首页
	public function Index() {
    	die('this is XinnuoController');
    }
    /*
    *终端认证
SendUrl:http://211.140.7.31:12125/10
SendProto:{"deviceId":"776941","devSn":"888880577800001","versionInfo":""}
RecvProto:{"data":"{\"actionCode\":\"\",\"curTime\":\"20160415153249\",\"dataSize\":0,\"error\":1,\"ticket\":\"20237721371226111\"}","error":1}
    *
    */
    public function aa(){
    $json=I('json');
    $realcontent="";
    if(!empty($json)){
        $result["ticket"]="20237721371226111";
        $result["curTime"]=time();
        $ret = $this->format_ret(1,$result);
    }else{
        $ret = $this->format_ret(0,"lost params!");
    }
    echo json_encode($ret);
    exit; 
}
    //参数获取(状态，原因)
    function format_ret ($status, $data='') {
            if ($status){
				//成功
                return array('error'=>'1', 'data'=>$data);
            }else{
				//验证失败
                    return array('error'=>'0', 'data'=>$data);
            }
    }
}

	
