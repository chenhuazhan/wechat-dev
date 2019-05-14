<?php
include_once "../mysql/conn.php";


$sql="select users.headimgurl,users.nickname,leave_msgs.content from users,leave_msgs where users.openid = leave_msgs.openid order by created_time desc limit 5";
$res = $link->query($sql);


while ($row=mysqli_fetch_assoc($res)) {
	# code...
	echo '<li>
					<div class="main_li">
						<div class="left">
							<img src="'.$row['headimgurl'].'" width="100%" height="100px" alt="">
						</div>
						<div class="right">
							<h2>'.$row['nickname'].':'.$row['content'].'</h2>
						</div>
					</div>
				</li>';
}

?>

