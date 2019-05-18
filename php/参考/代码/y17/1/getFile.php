<?php 

include "./weChat.class.php";

$weChat=new weChat('wxc9e5776402018fd9','90b0657dd9b0fdabfeb0173d24ad905f');
$arr=$weChat->getFile('23oga7JXrbkyixcSAH8kmLbgfR34mJmagdjM3OpJdtruuWgGdvjIaqnhv2Vgk7kr');
echo $arr;
 ?>