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


$url=" https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
$data=' {
     "button":[
     {	
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
               "type":"view",
               "name":"视频",
               "url":"http://v.qq.com/"
            },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';


 // 开启curl
 $ch=curl_init();
 // 设置传输选项
 // 设置传输地址
 curl_setopt($ch, CURLOPT_URL, $url);
 // 以文件流的形式返回
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 // 以post方式
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 // 发送curl
 $arr1=curl_exec($ch);

 $arrs1=json_decode($arr1,TRUE);
var_dump($arrs1);
 // echo $arr;
 // 关闭资源
 curl_close($ch);
 ?>