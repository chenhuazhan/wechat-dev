<?php
mysql_connect('w.rdc.sae.sina.com.cn:3307','4342z15jm2','yh4m22ijxy33kzll0z25iykj003410k004mxykm2');

mysql_set_charset('utf8');

mysql_select_db('app_yzm17');

$sql="select * from user";
$res=mysql_query($sql);

?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>微信头像墙</title>
    <link rel="stylesheet" type="text/css" href="css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <style type="text/css">
        /*Montserrat font*/
		@import url(http://fonts.useso.com/css?family=Montserrat);
		/*basic reset*/
		* {margin: 0; padding: 0;}
		body {text-align: center; }

		.grid {
			 margin: 100px auto 50px auto;
			margin-bottom: 100px;
			perspective: 500px; /*For 3d*/
		}
		.grid img {width: 50px; height: 50px; display: block; float: left; border-radius: 100%; margin: 5px;}

		.animate {
			display: inline-block;
			font: 12px Montserrat; text-transform: uppercase;
			background: rgb(0, 100, 0); color: white;
			padding: 10px 20px; border-radius: 5px;
			cursor: pointer;
		}
		.animate:hover {background: rgb(0, 75, 0);}
    </style>
</head>
<body>
    <article class="htmleaf-container">
        <div class="htmleaf-content bgcolor-8">
            <div class="grid">
            	<?php


            	while ($row=mysql_fetch_assoc($res)) {
            		# code...
            		echo '<img class="grid-image" src="'.$row['headimgurl'].'" />';
            	}


            	?>
            	
            	
            </div>
		<span class="animate">Animate</span>
        </div>
    </article>
    
    <script src="http://libs.useso.com/js/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-2.1.1.min.js"><\/script>')</script>
     <script src="http://libs.useso.com/js/jquery-easing/1.3/jquery.easing.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		// var images = "", count = 50;
		// for(var i = 1; i <= count; i++)
		// 	images += '<img class="grid-image" src="img/'+i+'.jpg" />';
			
		// $(".grid").append(images);

		var d = 0; //delay
		var ry, tz, s; //transform params

		//animation time
		$(".animate").on("click", function(){
			//fading out the thumbnails with style
			$("img.grid-image").each(function(){
				d = Math.random()*1000; //1ms to 1000ms delay
				$(this).delay(d).animate({opacity: 0}, {
					//while the thumbnails are fading out, we will use the step function to apply some transforms. variable n will give the current opacity in the animation.
					step: function(n){
						s = n; //scale - will animate from 0 to 1
						$(this).css("transform", "scale("+s+")");
					}, 
					duration: 1000, 
					easing: 'easeInOutElastic', 
				})
			}).promise().done(function(){
				//after *promising* and *doing* the fadeout animation we will bring the images back
				storm();
			})
		})
		//bringing back the images with style
		function storm()
		{
			$("img.grid-image").each(function(i){
				d = Math.random()*1000;
				$(this).delay(d).animate({opacity: 1}, {
					step: function(n){
						//rotating the images on the Y axis from 360deg to 0deg
						ry = (1-n)*-360;
						//translating the images from 1000px to 0px
						tz = (1-n)*1000;
						//applying the transformation
						$(this).css("transform", "rotateY("+ry+"deg) translateZ("+tz+"px) translateY("+tz+"px)");
					}, 
					duration: 3000, 
					//some easing fun. Comes from the jquery easing plugin.
					easing: 'easeOutQuint', 
				})
			})
		}
	</script>
	<script src="js/prefixfree-1.0.7.js" type="text/javascript"></script>
</body>
</html>