<?php 
include '../weChat.class.php';
define('TOKEN','y17');
$weChat=new Wechat('wxc9e5776402018fd9','90b0657dd9b0fdabfeb0173d24ad905f');

// $weChat=new Wechat('wxee274aac6d013ab0','c017752c68d16e4fcceeba6d601e4270');

$data=' {
     "button":[
      {	
          "type":"click",
          "name":"新闻",
          "key":"NEWS"
      },
      {
           "name":"娱乐",
           "sub_button":[
           {	
               "type":"view",
               "name":"游戏",
               "url":"http://1.yzm17.applinzi.com/game/index.html"
            },
            {
               "type":"click",
               "name":"笑话",
                "key":"XIAOHUA"
            },
            {
               "type":"click",
               "name":"抽奖",
                "key":"CHOU"
            }
            ]
       },
       {  
           "type":"click",
           "name":"赞我们",
           "key":"ZAN"
       }]
 }';

 $arr=$weChat->menu_create($data);
var_dump($arr);
 ?>