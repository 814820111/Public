<?php

namespace Apps\Controller;
use Common\Controller\AppBaseController;

/**
 * Class BaseController
 *
 */
class UploadBaseImageController extends AppBaseController{

     public function uploadBase64Image($content = "")
 {

     // var_dump($content);
     // 判断是否有多张图片
     if (strpos($content, "787311295") > 0) {
         // 去取多张图片
         $subContent = explode('787311295', $content);
         // var_dump($subContent);

         $imgCount = count($subContent) - 1;
     } else {
         $arr = array();
         // 只有一张
         $subContent = $content;

         $arr[] = $content;
         // var_dump($arr);
         // var_dump($subContent);
         // $imgCount = count($subContent);
         // var_dump($imgCount);
     }

     $lastResult = ""; // 存储返回的结果
     for ($i = 0; $i < count($arr); $i++) {
         $base64Img = $arr[$i]; // 需要使用base64上传的图片

         // var_dump($base64Img);
         if ($base64Img != null) {
             // 上传图片
             $imgSrc = $this->base64_upload_image($base64Img); // 上传图片,返回图片的地址
             //获取 地址;
             // var_dump($imgSrc);
             $str = str_replace(array("./uploads/attendances/"), "", $imgSrc);
            // var_dump($str);
             // SUCCESS
             $imagePath = $str; // 组合新小图每张图片后都加分隔符
             $lastResult = $lastResult . $imagePath;

         } else {
             echo json_encode(array('code' => -10002, 'message' => '系统错误'));
          }
      }
 // var_dump($lastResult);
     return $lastResult;
  }

    //存储图片并返还路径
    public function base64_upload_image($base64, $savepath = "./uploads/attendances/")
    {

        // post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行
        $base64_image = str_replace(' ', '+', $base64);
        var_dump($base64_image);
        // $base64_image = $base64;

        // 读取图片文件，转换成base64编码格式
        // $base64_image = "data:image/png;base64," . $base64_image;
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)) {
            // 匹配成功
            $time_name = date('YmdHis', time()) . rand(100, 999);
            if ($result [2] == 'jpeg') {
                $image_name = $time_name . '.jpg';
                // 纯粹是看jpeg不爽才替换的
            } else {
                $image_name = $time_name . '.' . $result [2];
            }
            $image_file = $savepath . "{$image_name}";
            while (file_exists($image_file))
                ;
            // 服务器文件存储路径
            if (file_put_contents($image_file, base64_decode(str_replace($result [1], '', $base64_image)))) {
                
                return $image_file;
            } else {
            
                return false;
            }
        } else {
            $base64_image = "data:image/png;base64," . $base64;
            var_dump($base64_image);
            return $this->base64_upload_image($base64_image);
            // return false;
        }
    }


}