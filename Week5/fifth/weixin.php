<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
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
                $event = $postObj->Event;
                $eventKey = $postObj->EventKey;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
                if ($event == 'subscribe')
                {
                    $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>1</ArticleCount>
                    <Articles>
                    <item>
                    <Title><![CDATA[欢迎来到梦想国度]]></Title> 
                    <Description><![CDATA[一个神奇的地方]]></Description>
                    <PicUrl><![CDATA[http://img15.3lian.com/2015/f2/132/d/23.jpg]]></PicUrl>
                    <Url><![CDATA[http://www.scut.edu.cn/oj/]]></Url>
                    </item>
                    </Articles>
                    </xml>";

                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time);
                    echo $resultStr;
                }
				if(!empty( $keyword ))
                {
              		$msgType = "text";

                    $conn = $this->dbconnect();
                    $result=mysqli_query($conn,"SELECT * FROM aTest WHERE id='$fromUsername'");
                    $mysql_arr=mysqli_fetch_assoc($result);
                    mysqli_set_charset($conn , "utf-8");

                    if ($mysql_arr['model']=='0') {
                        if ($keyword == '你好')
                        {
                            $contentStr = "恩~我很好";

                        } elseif ($keyword =='你才是单身狗')
                        {
                            $contentStr = "哦~是吗？";
                        }elseif ($keyword =='我不是单身狗') {
                            $contentStr = "那你很棒哦";
                        } else
                        {
                            $contentStr = "你好啊 单身狗";
                        }
                    }else{
                        if ($keyword == '退出'){
                            $contentStr = "成功退出反馈模式";
                            mysqli_query($conn,"UPDATE aTest SET model='0' WHERE id='$fromUsername'");
                        }else{
                            $suggestion = $mysql_arr['suggestion']."--".$keyword;
                            mysqli_query($conn,"UPDATE aTest SET suggestion='$suggestion'  WHERE id='$fromUsername'");
                            $contentStr = "多谢您的建议,回复‘退出’即可‘退出此模式";
                        }
                    }
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

                if($event=="CLICK" && $eventKey=="V1001_JOKE")
                {
                    $msgType = "text";
                    $url = "http://v.juhe.cn/joke/randJoke.php?type=&key=76849f11cb4d9aca65b72248b4b07b02";
                    $output = file_get_contents($url);
                    $arr = json_decode($output, true);
                    $contentStr = $arr['result'][0]['content'];
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }

                if($event=="CLICK" && $eventKey=="V1001_SUGGESTION")
                {
                    $msgType = "text";

                    $conn = $this->dbconnect();
                    if ($conn=='false'){
                        $contentStr = '数据异常';
                    }else{
                        $result=mysqli_query($conn,"SELECT * FROM aTest WHERE id='$fromUsername'");
                        $mysql_arr=mysqli_fetch_assoc($result);
                        if ($mysql_arr['id'] != $fromUsername){
                            mysqli_query($conn,"INSERT INTO aTest(id,model)  VALUE ('$fromUsername','1')");
                            $contentStr = "成功进入反馈模式，请输入您要反馈的信息，回复‘退出’退出此模式";
                        }else{
                            if ($mysql_arr['model']=='0'){
                                 mysqli_query($conn,"UPDATE aTest SET model='1' WHERE id='$fromUsername'");

                                $contentStr = "进入反馈模式，请输入您要反馈的信息，回复‘退出’退出此模式";
                            }else{
                                $contentStr = "您已经在反馈模式中，请勿重复操作";
                            }
                        }


                    }

                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }

        }else {
        	echo "....";
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
    function dbconnect ()
    {
        define('MYSQL_HOST' , "sqld.duapp.com:4050");
        define('MYSQL_NAME' , "fmffkSeexOhJAFAgVxPC");
        define('MYSQL_USER' , "3c38759fbacd4c4fb6378e243ac1457e");
        define('MYSQL_PASS' , "d83ff3c81861455692a7191eeabc302a");
        $conn=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS);
        if($conn) {
            mysqli_select_db($conn, MYSQL_NAME);
            mysqli_set_charset($conn , "utf-8");
            return $conn;
        }else{
            return 'false';
        }
    }
}

?>