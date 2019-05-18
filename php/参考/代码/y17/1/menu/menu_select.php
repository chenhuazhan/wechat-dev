<?php 
$appid='wxee274aac6d013ab0';
$appsecret="c017752c68d16e4fcceeba6d601e4270";
$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";

// 开启curl
$ch=curl_init();
// 设置传输选项
// 设置传输地址
curl_setopt($ch, CURLOPT_URL, $url);
// 以文件流的形式返回
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 发送curl
$arr=curl_exec($ch);

$arrs=json_decode($arr,TRUE);
$access_token=$arrs['access_token'];
// echo $arr;
// 关闭资源
curl_close($ch);


$url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$access_token}";

$ch=curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$str=curl_exec($ch);

$menu_Arr=json_decode($str,True);
echo "<pre>";
var_dump($menu_Arr);
curl_close($ch);



 ?>