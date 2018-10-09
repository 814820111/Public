<?php  
    // require_once __DIR__ . '/qiniusdk/autoload.php';  
	require("autoload.php");
    header('Access-Control-Allow-Origin:*');  
    use Qiniu\Auth;  
    use Qiniu\Storage\UploadManager;  
  
   
	$accessKey = '3pdTl4yZ7pw2qQ30S45WKMRqI3AZDwoyOjIbw7xb';  
    $secretKey = '_AhnZVUZs_DK1fzUq2S-Ew9YSq3x2rpZP2RQSBc_'; 
    $auth = new Auth($accessKey, $secretKey);   
	$bucket = 'images'; 	
    $newname = time().'.jpg';  
    $policy = array(  
        'saveKey'=>$newname,  
        'callbackUrl' => 'http://WWW.sinaapp.com/qiniu/callback.php',  
        'callbackBody' => "name=$(fname)&newname=$newname&toid=12"  
        );  
    $token =  $auth->uploadToken($bucket,NULL, 3600, $policy);
	echo $token;	
?>  
