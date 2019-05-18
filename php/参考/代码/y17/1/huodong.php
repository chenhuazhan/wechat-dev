<?php 


$appid="wxc9e5776402018fd9";
$appsecret="90b0657dd9b0fdabfeb0173d24ad905f";
$redirect_uri="http://yzm17.applinzi.com/huodong.php";


$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=123#wechat_redirect";


if (!$_GET) {
	header('location:'.$url);
	exit;
}






$code=$_GET['code'];


$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";


$arr=https_request($url);
var_dump($arr);

	function https_request($url,$data=""){
		 // 开启curl
		 $ch=curl_init();
		 // 设置传输选项
		 // 设置传输地址
		 curl_setopt($ch, CURLOPT_URL, $url);
		 // 以文件流的形式返回
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 if ($data) {
		 	// 以post方式
 			 curl_setopt($ch, CURLOPT_POST, 1);
 			 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 }
		 
		 // 发送curl
		 $request=curl_exec($ch);

		 $tmpArr=json_decode($request,TRUE);
		
		if (is_array($tmpArr)) {
			return $tmpArr;
		}else{
			return $request;
		}
		 // 关闭资源
		 curl_close($ch);
	}

 ?>