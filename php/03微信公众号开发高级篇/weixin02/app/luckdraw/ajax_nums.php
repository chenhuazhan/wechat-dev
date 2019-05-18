<?php

include_once "../mysql/conn.php";


$sql="update luckydraws set count={$_GET['nums']} where openid='{$_GET['openid']}'";

if ($link->query($sql)) {
	# code...
	echo "1";
}else{
    echo $sql;
	echo "0";
}



 ?>