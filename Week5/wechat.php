<?php

//define your token
define("TOKEN", "gehongwu0");
$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}


class wechatCallbackapiTest
{
    //验证签名	
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            echo $echoStr;
            exit;
        }
    }

    //接收事件推送并回复
    public function responseMsg()
    {
        //获取WeChat的post数据
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		
        if (!empty($postStr)){
            $this->logger("R \r\n".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            
            //消息类型分离
            switch ($RX_TYPE)
            {
                 case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            $this->logger("T \r\n".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }
 
    //接收事件
     private function receiveEvent($object)
        {
            $content = "";
            
            //事件判断
            switch ($object->Event)
            {
                case "subscribe":
                    $content = array();
                    $content[] = array("Title" =>"欢迎关注我的微信接口测试号","Description" =>"", "PicUrl" =>"", "Url" =>"");
                    $content[] = array("Title" =>"该测试号有以下功能","Description" =>"", "PicUrl" =>"", "Url" =>"");
                    $content[] = array("Title" =>"【1】广州天气预报查询","Description" =>"", "PicUrl" =>"", "Url" =>"");
                    $content[] = array("Title" =>"【2】地铁线路图查询","Description" =>"", "PicUrl" =>"", "Url" =>"");
                    $content[] = array("Title" =>"【3】发送位置查询经纬度","Description" =>"", "PicUrl" =>"", "Url" =>"");
                    $content[] = array("Title" =>"【4】音乐推荐","Description" =>"", "PicUrl" =>"", "Url" =>"");
                    $content[] = array("Title" =>"【5】搜索","Description" =>"", "PicUrl" =>"", "Url" =>"");
                    break;
                case "unsubscribe":
                    $content = "取消关注";
                    break;
                case "CLICK":
                    switch ($object->EventKey)
                    {
                        case "天气":
                            $content = "该功能暂未开发，敬请期待！";
                            break;
                        case "音乐":
                            $content = "请回复‘音乐’";
                            break;
                        case "反馈":
                            $content = "该功能暂未开发，敬请期待！";
                            break;
                         case "联系方式":
                            $content = "wechat:744657785";
                            break;
                        default:
                            $content = "点击菜单：".$object->EventKey;
                            break;
                    }
                    break;
            }

            if(is_array($content)){
                //发送图文
                $result = $this->transmitNews($object, $content);
            }else{
                //发送文本
                $result = $this->transmitText($object, $content);
            }
            return $result;
        }		

         //接收文本消息
         private function receiveText($object)
            {
                $keyword = trim($object->Content);

                //判断消息
                if (strstr($keyword, "文本")){
                    $content = "这是个文本消息";
                }
                else if (strstr($keyword, "单图文")){
                    $content = array();
                    $content[] = array(
                        "Title"=>"百度", 
                        "Description"=>"百度一下你就知道", 
                        "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"http://www.baidu.com");
                }
                else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
                    $content = array();
                    $content[] = array(
                        "Title"=>"百度", 
                        "Description"=>"", 
                        "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"http://www.baidu.com");
                    $content[] = array(
                        "Title"=>"github", 
                        "Description"=>"", 
                        "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", 
                        "Url" =>"www.github.com");
                    $content[] = array(
                        "Title"=>"wechat", 
                        "Description"=>"", 
                        "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", 
                        "Url" =>"http://mp.weixin.qq.com");
                }
                else if (strstr($keyword, "音乐")){
                    $content = array();
                    $content = array(
                        "Title"=>"最炫民族风", 
                        "Description"=>"歌手：凤凰传奇", 
                        "MusicUrl"=>"http://mascot-music.stor.sinaapp.com/zxmzf.mp3", 
                        "HQMusicUrl"=>"http://mascot-music.stor.sinaapp.com/zxmzf.mp3"); 
                }
                else if (strstr($keyword, "时间")){
                        $content = date("Y-m-d H:i:s",time())."\n\n";
                }
                else{
                        $content = "服务器正在撩妹请稍后再试！";
                }

                //传递
                if(is_array($content)){
                    if (isset($content[0])){
                        $result = $this->transmitNews($object, $content);
                    }else if (isset($content['MusicUrl'])){
                        $result = $this->transmitMusic($object, $content);
                    }
                }else{
                    $result = $this->transmitText($object, $content);
                }
                return $result;
            }

       
        //接收位置信息
        private function receiveLocation($object)
        {
            $content = "你发送的是位置，经度为：".$object->Location_Y."；纬度为：".$object->Location_X."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
            $result = $this->transmitText($object, $content);
            return $result;
        }

        
        //发送文本信息
        private function transmitText($object, $content)
            {
                if (!isset($content) || empty($content)){
                    return "";
                }

                $xmlTpl = "<xml>
                                    <ToUserName><![CDATA[%s]]></ToUserName>
                                    <FromUserName><![CDATA[%s]]></FromUserName>
                                    <CreateTime>%s</CreateTime>
                                    <MsgType><![CDATA[text]]></MsgType>
                                    <Content><![CDATA[%s]]></Content>
                                    </xml>";
                $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
                return $result;
            }

            //发送图文信息
            private function transmitNews($object, $newsArray)
                {
                    if(!is_array($newsArray)){
                        return "";
                    }
                    
                    //图文模板
                    $itemTpl = " <item>
                                          <Title><![CDATA[%s]]></Title>
                                          <Description><![CDATA[%s]]></Description>
                                          <PicUrl><![CDATA[%s]]></PicUrl>
                                          <Url><![CDATA[%s]]></Url>
                                          </item>";
                    $item_str = "";
                    
                    //拼接
                    foreach ($newsArray as $item){
                        $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
                    }
                    $xmlTpl = "<xml>
                                        <ToUserName><![CDATA[%s]]></ToUserName>
                                        <FromUserName><![CDATA[%s]]></FromUserName>
                                        <CreateTime>%s</CreateTime>
                                        <MsgType><![CDATA[news]]></MsgType>
                                        <ArticleCount>%s</ArticleCount>
                                        <Articles>
                                        $item_str    </Articles>
                                        </xml>";

                    $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
                    return $result;
                }

            //回复音乐
            private function transmitMusic($object, $musicArray)
            {
                if(!is_array($musicArray)){
                    return "";
                }
                
                //模板
                $itemTpl = "<Music>
                                     <Title><![CDATA[%s]]></Title>
                                     <Description><![CDATA[%s]]></Description>
                                     <MusicUrl><![CDATA[%s]]></MusicUrl>
                                     <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                                    </Music>";

                //输入信息
                $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);
                //回复模板
                $xmlTpl = "<xml>
                                    <ToUserName><![CDATA[%s]]></ToUserName>
                                    <FromUserName><![CDATA[%s]]></FromUserName>
                                    <CreateTime>%s</CreateTime>
                                    <MsgType><![CDATA[music]]></MsgType>
                                    $item_str
                                    </xml>";

                $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
                return $result;
            }


    //签名验证
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

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 1000000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('Y-m-d H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
}

?>