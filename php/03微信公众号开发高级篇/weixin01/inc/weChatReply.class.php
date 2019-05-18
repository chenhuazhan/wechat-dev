<?php
/**
 * Created by PhpStorm.
 * User: chenhuazhan
 * Date: 2019/5/18
 * Time: 13:53
 * Desc: 微信回复类
 */

class weChatReply
{
    private $postObj;
    public function __construct($postObj)
    {
        $this->postObj = $postObj;
    }
    // 回复文本消息
    public function text($contentStr)
    {
        $postObj = $this->postObj;
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>0</FuncFlag>
        </xml>";
        $time = time();
        $repRsgType = 'text';

        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $repRsgType, $contentStr);
        echo $resultStr;
        exit();
    }

    // 回复音乐消息
    public function music($postObj, $data)
    {
        $xml = "<xml>
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
        echo sprintf($xml, $postObj->FromUserName, $postObj->ToUserName, time(), $data['Title'], $data['Description'], $data['MusicUrl'], $data['HQMusicUrl']);
        exit();
    }

    //回复图文消息
    public function news($data)
    {
        $postObj = $this->postObj;

        $xml = "	<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%d</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>1</ArticleCount>
				<Articles>
					<item>
                        <Title><![CDATA[{$data['Title']}]]></Title> 
                        <Description><![CDATA[{$data['Description']}]]></Description>
                        <PicUrl><![CDATA[{$data['PicUrl']}]]></PicUrl>
                        <Url><![CDATA[{$data['Url']}]]></Url>
                    </item>
				</Articles>
			</xml> ";
        echo sprintf($xml, $postObj->FromUserName, $postObj->ToUserName, time());
        exit();
    }

    //回复图片
    public function replyImage($MediaId)
    {
        $postObj = $this->postObj;
        $xml = '	<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%d</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    <Image>
                    <MediaId><![CDATA[%s]]></MediaId>
                    </Image>
                    </xml>';
        echo sprintf($xml, $postObj->FromUserName, $postObj->ToUserName, time(), $MediaId);
    }

}