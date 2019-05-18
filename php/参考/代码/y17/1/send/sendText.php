<?php 

if ($_POST) {
	include "../weChat.class.php";

	$weChat=new weChat('wxc9e5776402018fd9','90b0657dd9b0fdabfeb0173d24ad905f');
	$arr=$weChat->sendText(urlencode($_POST['text']));

	var_dump($arr);
}








 ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="" method="post">
		<p><input type="text" name="text" id=""></p>
		<p><input type="submit" value="群发"></p>
	</form>
</body>
</html>