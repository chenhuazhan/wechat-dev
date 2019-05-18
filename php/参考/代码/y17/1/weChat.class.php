<?php 

class weChat{
	public $appid;
	public $appsecret;

	public function __construct($appid,$appsecret){
		$this->appid=$appid;
		$this->appsecret=$appsecret;
		mysql_connect('w.rdc.sae.sina.com.cn:3307','4342z15jm2','yh4m22ijxy33kzll0z25iykj003410k004mxykm2');

		mysql_set_charset('utf8');

		mysql_select_db('app_yzm17');
	}
	// 验证消息

	public function valid(){
		// 随机字符串
		$echostr=$_GET['echostr'];
		if ($this->checkSignature()) {
			echo "$echostr";
		}else{
			echo "error";
			exit;
		}
	}
	// 检验签名

	public function checkSignature(){
		// 加密签名
			$signature=$_GET['signature'];
		// 时间戳
			$timestamp=$_GET['timestamp'];
		// 随机出
			$nonce=$_GET['nonce'];
		
		
		// 字典序排序
			$tmpArr=array(TOKEN,$timestamp,$nonce);
			sort($tmpArr,SORT_STRING);
		// 拼接字符串 sha1加密
			$tmpStr=join($tmpArr);
			$tmpStr=sha1($tmpStr);
		// 加密签名的比较
			if ($tmpStr==$signature) {
				return true;
			}else{
				return false;
			}
	}

	// 处理用户请求消息

	public function responseMsg(){
		// 接受原生的xml字符串
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!$postStr) {
			echo "post data error";
			exit;
		}
		// 把原生字符串转化成对象
		$postObj=simplexml_load_string($postStr,'SimpleXMLElement', LIBXML_NOCDATA );
		// 接受消息的类型
		$MsgType=$postObj->MsgType;
		// 处理消息
		$this->checkMsgType($postObj,$MsgType);
	}

	// 处理消息类型

	public function checkMsgType($postObj,$MsgType){
		switch ($MsgType) {
			case 'text':
				// 处理文本消息
				$this->receiveText($postObj);
				break;
			case 'image':
				# code...
				// 处理图片消息
				$this->receiveImage($postObj);

				break;
			case 'event':
				$Event=$postObj->Event;
				// 处理事件
					$this->checkEvent($postObj,$Event);
				break;
			case 'voice':
				$this->receiveVoice($postObj);
				break;
			case 'location':
				# code...
				$Location_X=$postObj->Location_X;
				$Location_Y=$postObj->Location_Y;
				$sql="select * from position where openid='$postObj->FromUserName'";
				$res=mysql_query($sql);
				$position=mysql_fetch_assoc($res);
				if ($position['openid']) {
					$sql="update position set Latitude='$Location_X',Longitude='$Location_Y' where  openid='$postObj->FromUserName'";
				}else{
					$sql="insert into position values(null,'$postObj->FromUserName','$Latitude','$Longitude')";
				}
				mysql_query($sql);
				break;
			
			default:
				# code...
				break;
		}
	}

	// 处理事件的方法
	public function checkEvent($postObj,$Event){
		switch ($Event) {
			case 'subscribe':
				$data=array(
					array(
						'Title'=>'欢迎来到云知梦',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/1.jpg',
						'Url'=>'http://www.baidu.com',
						),
					array(
						'Title'=>'3001万的故事',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/2.jpg',
						'Url'=>'http://www.baidu.com',
						),
					array(
						'Title'=>'3002万的故事',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/3.jpg',
						'Url'=>'http://www.baidu.com',
						),
					);
				$url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->get_access_token()."&openid=".$postObj->FromUserName."&lang=zh_CN";
				$userInfo=$this->https_request($url);
				$sql="insert into user values(null,'$userInfo[openid]','$userInfo[nickname]','$userInfo[sex]','$userInfo[city]','$userInfo[country]','$userInfo[province]','$userInfo[headimgurl]','$userInfo[subscribe_time]')";
				mysql_query($sql);

				$sql="select * from chou where openid='$postObj->openid'";
				$res1=mysql_query($sql);
				$arr2=mysql_fetch_assoc($res1);
				if (!$arr2['openid']) {
					$sql="insert into chou values(null,'$postObj->FromUserName','3','')";
					mysql_query($sql);

				}
				$this->replyNews($postObj,$data);
				break;
			case 'unsubscribe':
				$sql="delete from user where openid='$postObj->FromUserName'";
				mysql_query($sql);
				break;
			case 'CLICK':
				# code...
				$this->checkClick($postObj,$postObj->EventKey);
				break;
			case 'LOCATION':
				$sql="insert into position values(null,'$postObj->FromUserName','$postObj->Latitude','$postObj->Longitude')";
				mysql_query($sql);
				# code...
				break;
			default:
				# code...
				break;
		}
	}
	// 处理click

	public function checkClick($postObj,$EventKey){
		switch ($EventKey) {
			case 'NEWS':
				$data=array(
					array(
						'Title'=>'新闻001',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/1.jpg',
						'Url'=>'http://yzm17.applinzi.com/jssdk/jssdk.php',
						),
					array(
						'Title'=>'3001万的故事',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/2.jpg',
						'Url'=>'http://yzm17.applinzi.com/jssdk/jssdk_oop.php',
						),
					array(
						'Title'=>'3002万的故事',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/3.jpg',
						'Url'=>'http://www.baidu.com',
						),
					);
				$this->replyNews($postObj,$data);
				break;
			case 'ZAN':
				$this->replyText($postObj,'谢谢·。。。。。。');
				break;
			case 'XIAOHUA':
				$url="http://api.1-blog.com/biz/bizserver/xiaohua/list.do?page=".rand(0,10000)."&size=1";
				$xiaoArr=$this->https_request($url);
				$xiaoHua=$xiaoArr['detail'][0];
				$this->replyText($postObj,$xiaoHua['content']);
				break;
			case 'CHOU':
				$data=array(
					array(
						'Title'=>'抽奖送大礼（3000wan）',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/5.jpg',
						'Url'=>'http://1.yzm17.applinzi.com/chou/index.php?openid='.$postObj->FromUserName,
						),
					);
				$this->replyNews($postObj,$data);
				break;
			default:
				# code...
				break;
		}
	}

	// 获取access_token

	public function get_access_token(){
		if($access_token=$this->memcahce_gets('access_token')){
			return $access_token;
		}else{
			$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
			$request=$this->https_request($url);
			$access_token=$request['access_token'];
			$this->memcache_sets('access_token',$access_token,'7000');
			return $access_token;
		}
		
	}

	// 模拟gei请求·和post请求

	public function https_request($url,$data=""){
		 // 开启curl
		 $ch=curl_init();
		 // 设置传输选项
		 // 设置传输地址
		 curl_setopt($ch, CURLOPT_URL, $url);
		 // 以文件流的形式返回
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 if ($data) {
		 	// 以post方式
 			 curl_setopt($ch, CURLOPT_POST, 1);
 			 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 }
		 
		 // 发送curl
		 $request=curl_exec($ch);

		 $tmpArr=json_decode($request,TRUE);
		
		if (is_array($tmpArr)) {
			return $tmpArr;
		}else{
			return $request;
		}
		 // 关闭资源
		 curl_close($ch);
	}
	// 处理文本消息

	public function receiveText($postObj){
		$Content=$postObj->Content;

		switch ($Content) {
			case '点歌':
				$str="欢迎来到云知梦点歌系统\n";
				$files=scandir('music');
				$i=1;
				foreach ($files as $key => $value) {
					# code...
					if ($value !='.' && $value !='..') {
						# code...
						$str.= $i.' '.$value."\n";
						$i++;

					}
				}
				$str.="请输入对应的编号试听歌曲\n";
				$this->replyText($postObj,$str);
				break;
			case '美女':
				$this->replyImage($postObj,'CgG5YjFf79cDFfy2RwsvNkjuFhPpXkdPsgXw0r-ehoanL3c9_fNhQUuwnNomW5yA');
				break;
			case '新闻':
				$data=array(
					array(
						'Title'=>'3000万的故事',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/1.jpg',
						'Url'=>'http://yzm17.applinzi.com/jssdk.php',
						),
					array(
						'Title'=>'3001万的故事',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/2.jpg',
						'Url'=>'http://www.baidu.com',
						),
					array(
						'Title'=>'3002万的故事',
						'Description'=>'3000万的颠沛流离',
						'PicUrl'=>'http://1.yzm17.applinzi.com/img/3.jpg',
						'Url'=>'http://www.baidu.com',
						),
					);
				$this->replyNews($postObj,$data);
				break;
			
			default:
				preg_match('/^sq([\x{4e00}-\x{9fa5}]+)/ui', $Content,$arr);
				if ($arr[0]) {
					$sql="insert into text values(null,'$postObj->FromUserName','$arr[1]',".time().")";
					// $this->replyText($postObj,$sql);
					mysql_query($sql);
					
				}

				preg_match('/^ss([\x{4e00}-\x{9fa5}]+)/ui', $Content,$arr1);
				if ($arr1[0]) {
					$sql="select * from position where openid='$postObj->FromUserName'";
					$res=mysql_query($sql);
					$position=mysql_fetch_assoc($res);
					if ($position['openid']) {
						$url="http://yzm17.applinzi.com/baidu/index.php?search=$arr1[1]&j=$position[Longitude]&w=$position[Latitude]";
						$data1=array(
							array(
								'Title'=>'周边的'.$arr1[1].'信息',
								'Description'=>'周边的'.$arr1[1].'信息',
								'PicUrl'=>'http://1.yzm17.applinzi.com/img/6.jpg',
								'Url'=>$url,
								),
							);
						$this->replyNews($postObj,$data1);
					}else{
						$this->replyText($postObj,'请您提交您的地理位置信息');
					}
					
				}
				if (preg_match('/^\d{1,2}$/', $Content)) {
					$files=scandir('music');
					$i=1;
					foreach ($files as $key => $value) {
						# code...
						if ($value !='.' && $value !='..') {
							# code...
							if ($Content==$i) {
								$data=array(
									'Title'=>$value,
									'Description'=>$value,
									'MusicUrl'=>'http://1.yzm17.applinzi.com/music/'.$value,
									'HQMusicUrl'=>'http://1.yzm17.applinzi.com/music/'.$value,
									);
								$this->replyMusic($postObj,$data);
							}
							
							$i++;

						}
					}
				}
				break;
		}
	}

	// 处理语音消息

	public function receiveVoice($postObj){
		$Recognition=$postObj->Recognition;
		$url="http://www.tuling123.com/openapi/api?key=c11311dda971ef36a39d2d2f57b86a98&info=".$Recognition;
		// $arr=array(
		// 	"key"=>'c11311dda971ef36a39d2d2f57b86a98',
		// 	"info"=>$Recognition,
		// 	);
		// $json=json_encode($arr);
		$tuArr=$this->https_request($url);
		switch ($tuArr['code']) {
			case '100000':
				$this->replyText($postObj,$tuArr['text']);
				break;
			case '200000':
				$this->replyText($postObj,"<a href='".$tuArr[url]."'>".$tuArr['text'].'</a>');
				break;
			
			default:
				# code...
				break;
		}
	}

	// 处理图片消息
	public function receiveImage($postObj){
		$MediaId=$postObj->MediaId;
		$this->replyImage($postObj,$MediaId);
	}
	// 回复文本消息
	public function replyText($postObj,$Content){
		$xml='<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%d</CreateTime>
			<MsgType><![CDATA[text]]></MsgType>
			<Content><![CDATA[%s]]></Content>
			</xml>';
		echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$Content);
	}

	// 回复图片
	public function replyImage($postObj,$MediaId){
		$xml='	<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%d</CreateTime>
				<MsgType><![CDATA[image]]></MsgType>
				<Image>
				<MediaId><![CDATA[%s]]></MediaId>
				</Image>
				</xml>';
		echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$MediaId);
	}

	// 回复音乐消息
	public function replyMusic($postObj,$data){
		$xml="<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%d</CreateTime>
				<MsgType><![CDATA[music]]></MsgType>
				<Music>
				<Title><![CDATA[%s]]></Title>
				<Description><![CDATA[%s]]></Description>
				<MusicUrl><![CDATA[%s]]></MusicUrl>
				<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
				</Music>
				</xml>";
		echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time(),$data['Title'],$data['Description'],$data['MusicUrl'],$data['HQMusicUrl']);


	}

	//回复图文消息
	public function replyNews($postObj,$data){
		foreach ($data as $key => $value) {
			$str.="<item>
				<Title><![CDATA[".$value[Title]."]]></Title> 
				<Description><![CDATA[".$value[Description]."]]></Description>
				<PicUrl><![CDATA[".$value[PicUrl]."]]></PicUrl>
				<Url><![CDATA[".$value[Url]."]]></Url>
				</item>";
		}
		$xml='	<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%d</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>'.count($data).'</ArticleCount>
				<Articles>
				'.$str.'
				</Articles>
				</xml> ';
		echo sprintf($xml,$postObj->FromUserName,$postObj->ToUserName,time());
	}


	// 创建菜单
	public function menu_create($data){
		$url=" https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$this->get_access_token()}";
		return $request=$this->https_request($url,$data);

	}
	// 查询菜单
	public function menu_select(){
		$url="https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$this->get_access_token()}";
		return $this->https_request($url);
	}

	// 删除菜单
	public function menu_del(){
		$url="https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$this->get_access_token()}";
		return $this->https_request($url);
	}


	// 设置memcache
	public function memcache_sets($key,$value,$time){
		$mmc=memcache_init();

		memcache_set($mmc,$key,$value,0,$time);
	}
	// 获取memcache
	public function memcahce_gets($key){
		$mmc=memcache_init();

		return memcache_get($mmc,$key);
	}


	// 群发文本消息
	public function sendText($text){
		// 1、准备url地址
		$url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$this->get_access_token();

		// 2、准备数据
		$sql="select openid from user";
		$res=mysql_query($sql);
		while ($row=mysql_fetch_assoc($res)) {
			$arr1[]=$row['openid'];
		}
		$arr=array(
			"touser"=>$arr1,
			"msgtype"=>"text",
			"text"=>array("content"=>urldecode($text)),
			);

		// 3、封装成json
		$json=json_encode($arr);
		// 4、发送请求

		return $result=$this->https_request($url,$json);

	}

	// 0IQlHQSO57gEGHco0qr0_QnlDudszs9AxiCXYcDMNycrQ2m09yhsoPkwmHghSK3H
	// 群发图片

	public function sendImage(){
		// 1、准备url地址
		$url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$this->get_access_token();

		// 2、准备数据
		$sql="select openid from user";
		$res=mysql_query($sql);
		while ($row=mysql_fetch_assoc($res)) {
			$arr1[]=$row['openid'];
		}
		$arr=array(
			"touser"=>$arr1,
			"image"=>array("media_id"=>'tCs-dMObQzt8g1Zpj8UkzkyxmXU9-SMqJQUy9eKJXg5rIN-0kiBvmiJJ6F1fpOAd'),
			"msgtype"=>"image"
			);

		// 3、封装成json
		 $json=json_encode($arr);
		// 4、发送请求

		return $result=$this->https_request($url,$json);
	}


	// 发送模板消息

	public function sendTmp($user,$tmp,$arr){
		// url
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->get_access_token();
		// 组装数组

		$arr=array(
			"touser"=>$user,
			"template_id"=>$tmp,
			"url"=>"http://www.baidu.com",
			"data"=>array(
				"name"=>array("value"=>$arr[name],"color"=>'#f00'),
				"goods"=>array("value"=>$arr[goods],"color"=>'#f00'),
				"time"=>array("value"=>" ".date('Y-m-d H:i:s')." ","color"=>'#f00'),
				),

			);
		// json
		$json=json_encode($arr);
		return $this->https_request($url,$json);
	}

	// 上传临时素材
	public function uploads(){
		$url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$this->get_access_token()."&type=image";
		$filepath = dirname(__FILE__)."/img/b.jpg";
		$filedata = array("file"  => "@".$filepath);

		return $this->https_request($url,$filedata);
	}

	// 获取临时文件

	public function getFile($media_id){
		$url="https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$this->get_access_token()."&media_id=".$media_id;
		return $this->https_request($url);
	}


	// 获取ticket
	public function getTicket(){
		$url="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$this->get_access_token()}&type=jsapi";


		$ticketArr=$this->https_request($url);


		return $ticket=$ticketArr['ticket'];
	}

	// 获取随机数

	public function getNonceStr($length='10'){
		$str="1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFTGYHJUKLZXCVBNM";
		$newStr='';
		for ($i=0; $i < $length; $i++) { 
			$newStr.=$str[rand(0,strlen($str)-1)];
		}
		return $newStr;
	}
	// 生成jssdk的签名

	public function getSignature(){
		$ticket=$this->getTicket();
		$noncestr=$this->getNonceStr();
		$time=time();
		$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$str="jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$time}&url={$url}";
		$signature=sha1($str);

		$arr=array(
			'appId'=>$this->appid, // 必填，公众号的唯一标识
			'timestamp'=>$time, // 必填，生成签名的时间戳
			'nonceStr'=>$noncestr, // 必填，生成签名的随机串
			'signature'=>$signature,
			);
		return $arr;
	}

}



 ?>