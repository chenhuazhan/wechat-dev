<?php
include "./weChat.class.php";
// TOKEN
define('TOKEN','y17');
$weChat=new Wechat('wxee274aac6d013ab0','c017752c68d16e4fcceeba6d601e4270');


echo $weChat->get_access_token();
