<?php  
    // require_once __DIR__ . '/qiniusdk/autoload.php'; 
	require("autoload.php");
  
  use Qiniu\Auth;  
  use Qiniu\Storage\UploadManager;  
  
  $accessKey = '3pdTl4yZ7pw2qQ30S45WKMRqI3AZDwoyOjIbw7xb';  
    $secretKey = '_AhnZVUZs_DK1fzUq2S-Ew9YSq3x2rpZP2RQSBc_';  
    $auth = new Auth($accessKey, $secretKey);  
  $bucket = 'images';  
$token = $auth->uploadToken($bucket);  
	 echo $token;
?>  