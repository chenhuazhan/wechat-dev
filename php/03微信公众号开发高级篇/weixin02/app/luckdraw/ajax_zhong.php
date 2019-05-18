<?php

include_once "../mysql/conn.php";


$sql="update luckydraws set prizes='{$_GET['prizes']}' where openid='{$_GET['openid']}'";

if ($link->query($sql)) {
	# code...
	echo "1";
}else{
	echo "0";
}



 ?>