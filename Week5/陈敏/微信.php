<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if($_GET['echostr'])
{
    $wechatObj->valid();
}else
{
    $wechatObj->responseMsg();
}



class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $Event = $postObj->Event;
                $EventKey = $postObj->EventKey;
                $MsgType = $postObj->MsgType;
                $time = time();
                $textTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[%s]]></MsgType>
			<Content><![CDATA[%s]]></Content>
			<FuncFlag>0</FuncFlag>
			</xml>";
            if($MsgType == "image")
            {
                $MsgType = "text";
                $Content = "您发送了一个图片信息";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $MsgType, $Content);
                echo $resultStr;
            }

            if($Event == "CLICK" and $EventKey == "V1001_TODAY_PICTURE")
            {
               $textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>1</ArticleCount>
                <Articles>
                <item>
                <Title><![CDATA[唯美]]></Title> 
                <Description><![CDATA[淡淡的~]]></Description>
                <PicUrl><![CDATA[https://ss0.bdstatic.com/94oJfD_bAAcT8t7mm9GUKT-xh_/timg?image&quality=100&size=b4000_4000&sec=1480685277&di=731a50326e040db47378f22a1a9b6493&src=http://img1.3lian.com/2015/w3/64/d/41.jpg]]></PicUrl>
                <Url><![CDATA[http://www.woyaogexing.com/tupian/weimei/]]></Url>
                </item>
                </Articles>
                </xml>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time);
                echo $resultStr;
      
            }



            if($Event == "subscribe")
             {
               $textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>1</ArticleCount>
                <Articles>
                <item>
                <Title><![CDATA[谢谢你这么可爱还关注我！(づ￣ 3￣)づ]]></Title> 
                <Description><![CDATA[我工~]]></Description>
                <PicUrl><![CDATA[http://www.pp3.cn/uploads/1304/89.jpg]]></PicUrl>
                <Url><![CDATA[http://www.scut.edu.cn/]]></Url>
                </item>
                </Articles>
                </xml>";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time);
                echo $resultStr;
      
            }


            
	if(!empty( $keyword ))
                {
                   
                        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <ArticleCount>1</ArticleCount>
                        <Articles>
                        <item>
                        <Title><![CDATA[你好啊，亲爱的朋友]]></Title> 
                        <Description><![CDATA[告诉你一个小秘密咯，这是我最爱的游戏。]]></Description>
                        <PicUrl><![CDATA[http://img4.duitang.com/uploads/item/201311/04/20131104232309_HzW5V.thumb.600_0.jpeg]]></PicUrl>
                        <Url><![CDATA[http://www.sanguosha.com/]]></Url>
                        </item>
                        </Articles>
                        </xml>";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time);
                        echo $resultStr;
                }else{
                	echo "Input something...";$MsgType = "text";
                $Content = "你好啊";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $MsgType, $Content);
                echo $resultStr;
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>