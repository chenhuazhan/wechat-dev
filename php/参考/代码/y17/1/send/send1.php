<?php 

include "../weChat.class.php";

$weChat=new weChat('wxc9e5776402018fd9','90b0657dd9b0fdabfeb0173d24ad905f');


echo $weChat->get_access_token();

echo "<br>";
$arr=$weChat->sendImage();

var_dump($arr);


 ?>