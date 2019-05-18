<?php 

// 接受参数

// 加密签名
	$signature=$_GET['signature'];
// 时间戳
	$timestamp=$_GET['timestamp'];
// 随机出
	$nonce=$_GET['nonce'];
// 随机字符串
	$echostr=$_GET['echostr'];
// TOKEN
	define('TOKEN','binbin');
// 字典序排序
	$tmpArr=array(TOKEN,$timestamp,$nonce);
	sort($tmpArr,SORT_STRING);
// 拼接字符串 sha1加密
	$tmpStr=join($tmpArr);
	$tmpStr=sha1($tmpStr);
// 加密签名的比较
	if ($tmpStr==$signature) {
		echo $echostr;
	}else{
		echo "error";
		exit;
	}
// 接受xml数据
	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
	if (!$postStr) {
		echo "post data error";
		exit;
	}
	$postObj=simplexml_load_string($postStr,'SimpleXMLElement', LIBXML_NOCDATA );
	$MsgType=$postObj->MsgType;
	switch ($MsgType) {
		case 'text':
		$Content=$postObj->Content;
		switch ($Content) {
			case 'binbin':
				$xml='<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>';
echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),'binbin is girl;');
// echo 
// print_r
// die()
// var_dump();
// printf();
// sprintf();
				break;
			
			default:
							$xml='<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>';
echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$postObj->Content);
				break;
		}
			
			break;
		case 'image':
			$xml='	<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%d</CreateTime>
					<MsgType><![CDATA[image]]></MsgType>
					<Image>
					<MediaId><![CDATA[%s]]></MediaId>
					</Image>
					</xml>';
				echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$postObj->MediaId);
			break;
		default:
			# code...
			break;
	}
 ?>