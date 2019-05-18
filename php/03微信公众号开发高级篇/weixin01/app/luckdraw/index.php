<?php
include_once "../mysql/conn.php";

$sql = "select * from luckydraws where openid='$_GET[openid]'";

$res = $link->query($sql);

$row = mysqli_fetch_assoc($res);


?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>jQuery老虎机转动抽奖程序</title>
</head>
<style type="text/css">
    body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, button, textarea, blockquote, th, td, p {
        margin: 0;
        padding: 0
    }

    input, button, select, textarea, a:fouse {
        outline: none
    }

    li {
        list-style: none;
    }

    img {
        border: none;
    }

    textarea {
        resize: none;
    }

    body {
        margin: 0;
        font: 12px "微软雅黑";
        background: #feecd4;
        min-width: 680px;
    }

    /* === End CSS Reset ========== */


    a {
        text-decoration: none;
    }

    .clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
    }

    .clearfix {
        *zoom: 1;
    }

    .container {
        width: 670px;
        height: 500px;
        margin: 0 auto;
        overflow: hidden;
        position: relative;
    }

    /* main2 */
    .main2 {
        background: url("images/main2.png") no-repeat center;
        height: 689px;
        width: 100%
    }

    .main3 {
        width: 100%
    }

    .main3-text {
        color: #744b00;
        font-size: 23px;
        font-weight: bold;
        position: absolute;
        left: 74px;
        top: 210px;
    }

    .main3-text2 {
        color: #744b00;
        font-size: 14px;
        position: absolute;
        left: 74px;
        top: 254px;
        line-height: 22px;
        width: 867px;
    }

    .main-text {
        position: absolute;
        left: 360px;
        top: 325px;
        color: #b03b01;
        font-size: 16px;
    }

    .main2-text1 {
        position: absolute;
        left: 79px;
        top: 45px;
        color: #ffffff;
        font-size: 16px;
    }

    .main2-text2 {
        position: absolute;
        left: 69px;
        top: 67px;
        color: #ffffff;
        font-size: 23px;
        font-weight: bold;
    }

    .main2-text2 span {
        color: #ffff00;
    }

    .main2-text3 {
        position: absolute;
        left: 69px;
        top: 97px;
        color: #ffffff;
        font-size: 18px;
    }

    .main2-text4 {
        position: absolute;
        left: 382px;
        top: 34px;
        color: #ffffff;
        font-size: 18px;
    }

    .main2-text4 span {
        color: #ffe700;
        font-weight: bold;
    }

    .main2-text5 {
        position: absolute;
        left: 665px;
        top: 34px;
        color: #ffffff;
        font-size: 18px;
    }

    .main2-text5 span {
        color: #ffe700;
        font-weight: bold;
    }

    .num {
        position: absolute;
        left: 81px;
        top: 171px;
        width: 124px;
        height: 198px;
        overflow: hidden;
    }

    .num-con {
        position: relative;
        top: -430px;
    }

    .num-img {
        background: url("images/num.png") no-repeat;
        width: 124px;
        height: 1298px;
        margin-bottom: 4px;
    }

    .num2 {
        left: 232px;
    }

    .num3 {
        left: 386px;
    }

    .main3-btn {
        width: 307px;
        height: 115px;
        position: absolute;
        left: 146px;
        top: 400px;
        cursor: pointer;
    }

    h2, p {
        text-align: center;
    }
</style>

<body>
<div class="header">
    <h2>抽奖系统</h2>
    <p>剩余抽奖次数<span id="nums" style="color:red"> <?php echo $row['count'] ?> </span>次</p>
    <p>中奖纪录 <?php if($row['prizes']!='')echo $row['prizes'].'元优惠券各一张';else echo '暂无中奖记录' ?></p>
</div>
<div class="main2">

    <div class="container">
        <div class="num num1">
            <div class="num-con num-con1">
                <div class="num-img"></div>
                <div class="num-img"></div>
            </div>
        </div>
        <div class="num num2">
            <div class="num-con num-con2">
                <div class="num-img"></div>
                <div class="num-img"></div>
            </div>
        </div>
        <div class="num num3">
            <div class="num-con num-con3">
                <div class="num-img"></div>
                <div class="num-img"></div>
            </div>
        </div>
        <div class="main3-btn"></div>
    </div>
</div>


</body>
</html>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
    $(".main3-btn").click(function () {
        var nums = $("#nums").html();
        nums = parseInt(nums);
        nums--;


        if (nums < 0) {
            alert('抽奖次数已用完');
            return false;

        } else {
            $.get('./ajax_nums.php', {
                'openid': '<?php echo $row['openid']?>',
                'nums': nums
            }, function (data) {

            });
            $("#nums").html(nums);
            reset();
            letGo();


        }

    });

    var flag = false;
    var index = 0;
    var TextNum1
    var TextNum2
    var TextNum3

    function letGo() {

        TextNum1 = parseInt(Math.random() * 9)//随机数为1，1，1时中奖率为100%
        TextNum2 = parseInt(Math.random() * 9)
        TextNum3 = parseInt(Math.random() * 9)

        // var num1=[-549,-668,-786,-904][TextNum1];//在这里随机
        var num1 = [ -1242, -1377, -1495, -1614, -430, -549, -668, -786, -904][TextNum1];
        var num2 = [ -1242, -1377, -1495, -1614, -430, -549, -668, -786, -904][TextNum2];
        var num3 = [ -1242, -1377, -1495, -1614, -430, -549, -668, -786, -904][TextNum3];
        console.log(num1);
        console.log(num2);
        console.log(num3);
        $(".num-con1").stop().animate({"top": -1140}, 1000, "linear", function () {
            $(this).css("top", 0).animate({"top": num1}, 1000, "linear");
        });
        $(".num-con2").stop().animate({"top": -1140}, 1000, "linear", function () {
            $(this).css("top", 0).animate({"top": num2}, 1800, "linear");
        });
        $(".num-con3").stop().animate({"top": -1140}, 1000, "linear", function () {
            $(this).css("top", 0).animate({"top": num3}, 1300, "linear");
        });
        if (TextNum3 == TextNum2 && TextNum2 == TextNum1) {
            setTimeout(function () {

                $.get('./ajax_zhong.php', {
                    prizes: '<?php echo $row['prizes']?>,'+ TextNum3,
                    openid: '<?php echo $row['openid']?>'
                }, function (data) {

                });
                alert('恭喜抽中'+(9-TextNum3)+'元优惠券');
            }, 3000);
        }
        ;
    }

    function reset() {
        $(".num-con1,.num-con2,.num-con3").css({"top": -430});
    }
</script>
</body>
</html>