<?php

define("TOKEN", "wenbo");
<<<<<<< HEAD
include 'connect_mysql.php';
include 'connect_yidong.php';
include 'select_taocan.php';

$wechatObj = new wechatCallbackapiTest();


=======
$wechatObj = new wechatCallbackapiTest();
>>>>>>> a09201484ead0110a53ffe5a2b7f1459db74f6d7
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}
<<<<<<< HEAD



class wechatCallbackapiTest 
{   
=======
class wechatCallbackapiTest
{
    $flag = 0;
>>>>>>> a09201484ead0110a53ffe5a2b7f1459db74f6d7
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    private function checkSignature()
    {                                                                     
        $signature = $_GET["signature"];                 
        $timestamp = $_GET["timestamp"];                 
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    //���յ�������
     public function responseMsg()
    {
         $time = time();
         $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
         if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
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
<<<<<<< HEAD
            $state = FindUser($fromUsername);
            $OrignState = $state;
            $state = $state % 10;
            $msgType = "text";
            $datedata  = date("Y-m-d-H:i:s",time());
            switch($state)
            {
                case "0":
	            	switch($keyword)
    	       	 	{
        	        	case "0" :
	            	        $contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ \n 0.�˵� \n";
    	            		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            	    		break;
	                	case "1" :
                        	ChangeState($fromUsername,'1');
	    	             	$contentStr = "��������Ҫ��ѯ�ĳ��У�\n";
	                 		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    		            	break;
                        case "2" :
                        	ChangeState($fromUsername,'2');
	    	             	$contentStr = "�����������ֻ����룺\n";
	                 		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    		            	break;
                        case "3":
                        	ChangeState($fromUsername,'3');
	    	             	$contentStr = "��������ϣ����ͨ����(����)��\n";
	                 		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    		            	break;
                		default :
                        	$RX_TYPE = trim($postObj->MsgType);
            				switch ($RX_TYPE)
            				{
                				case "event":
                					$result = $this->receiveEvent($postObj);
                    				break;
                				case "text":
                    				$msgType = "text";
    	            				$contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ \n 0.�˵� \n";
        	        				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    				break;
            				}
            		}
                	break;
                case "1":
                	if($keyword==4){
                    	ChangeState($fromUsername,'0');
                    	$contentStr = $keyword."1";
                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	}
                	else{
                        ChangeState($fromUsername,'0');
                        $this->responseCityWeather($postStr);
                    }
                	break;
                case "2":
                	$OrignState = ($OrignState-$state)/10;
                	$state = $OrignState % 10;
                	if($keyword==0){
                    	ChangeState($fromUsername,'0');
                    	$msgType = "text";
                    	$contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ \n 0.�˵� \n";
                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	}
                	else{
                        switch($state)
                        {
                            case 0:
                        		ChangeState($fromUsername,'12');
                        		ChangeKey($fromUsername,"mobile",$keyword);
                        		CheckIn_Yidong($keyword,$fromUsername,$datedata);
                				$picTpl = "<xml>
									<ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[%s]]></MsgType>
									<ArticleCount>1</ArticleCount>
									<Articles>
									<item>
									<Title><![CDATA[%s]]></Title>
									<Description><![CDATA[%s]]></Description>
									<PicUrl><![CDATA[%s]]></PicUrl>
                            		<Url><![CDATA[%s]]></Url>
									</item>
									</Articles>
									<FuncFlag>1</FuncFlag>
									</xml> ";
                        		$msgType = "news";
								$title = "��֤��";
								$data  = date('Y-m-d');
								$desription = "�����ͼƬ��Ȼ��ظ���֤��";
								$image = "http://mobilehelp-test.stor.sinaapp.com/".$fromUsername.$datedata.".jpg";
                        		$turl = "http://mobilehelp-test.stor.sinaapp.com/".$fromUsername.$datedata.".jpg";
                				$resultStr = sprintf($picTpl, $fromUsername, $toUsername, $time, $msgType, $title,$desription,$image,$turl);
                            	break;
                          case 1:
                            	ChangeState($fromUsername,'22');
                            	ChangeKey($fromUsername,"yanzheng",$keyword);
                    			$contentStr ="����������\n";
                				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            	break;
                          case 2:
                            	ChangeState($fromUsername,'0');
                    			$contentStr =$keyword;
                				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            	break;
                        }
                    }
                	break;
                case "3":
                	$OrignState = ($OrignState-$state)/10;
                	$state = $OrignState % 10;
                	if($keyword==0){
                    	ChangeState($fromUsername,'0');
                    	$contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ \n 0.�˵� \n";
                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	}
                	else{
                        switch($state)
                        {
                            case 0:
                            	ChangeState($fromUsername,'13');
                        		ChangeKey($fromUsername,"tonghua",$keyword);
	    	            		$contentStr = "��������ϣ����������M����\n";
                            	break;
                            case 1:
                            	ChangeState($fromUsername,'23');
                        		ChangeKey($fromUsername,"liuliang",$keyword);
	    	            		$contentStr = "��������ϣ���Ķ�������������\n";
                            	break;
                            case 2:
                            	ChangeState($fromUsername,'33');
                        		ChangeKey($fromUsername,"duanxin",$keyword);
                            	$contentStr = "ѡ��˾��\nYD:�ƶ�\nLT:��ͨ";
                            	break;
                            case 3:
                            	if($keyword=='YD'||$keyword=='yD'||$keyword=='Yd'||$keyword=='yd')
                                {
        							$contentStr = YD_SelectBestTaocan($fromUsername);
                                }
                            	else if($keyword=='LT'||$keyword=='Lt'||$keyword=='lT'||$keyword=='lt')
                                {
                                    $contentStr = LT_SelectBestTaocan($fromUsername);
                                }
                            	else
                                {
                                    $contentStr = "����������ײ�";
                                }
                            	ChangeState($fromUsername,'0');
                            	break;
                            default:
                            	$contentStr = "Error\n";
                        }
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    }
                break;
             }
            echo $resultStr;
=======
            
            
            switch($keyword)
            {
                case "4" :
                	$msgType = "text";
                    $contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ \n 4.menu";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
               	 	echo $resultStr;
                	break;
                
                case "1" :
                	global $flag = 1;
                	$msgType = "text";
                 	$contentStr = "��������Ҫ��ѯ�ĳ��У�\n";
                 	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                 	echo $resultStr;
                	echo sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, global $flag);
                	break;
                
                case "2" :
                case "3" :
                	$msgType = "text";
                	$contentStr = date("Y-m-d H:i:s",time())."\nSorry :ERROR.";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
               	 	echo $resultStr;
                	break;
                
                default :
                    $msgType = "text";
                	$contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
               	 	echo $resultStr;
            }

>>>>>>> a09201484ead0110a53ffe5a2b7f1459db74f6d7
        }else{
            echo "";
            exit;
        }
    }
    
    
<<<<<<< HEAD
    private function responseCityWeather($postStr)
=======
    public function responseCityWeather()
>>>>>>> a09201484ead0110a53ffe5a2b7f1459db74f6d7
    {
         $time = time();
         $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
         if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
<<<<<<< HEAD
            $RX_TYPE = trim($postObj->MsgType);
            $result = $this->receiveText($postObj);
            echo $result;
        }else{
            $msgType = "text";
            $contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ \n 4.�˵� \n";
         	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
            exit;
        }
        return 0;
    }
             
=======
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
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
            $RX_TYPE = trim($postObj->MsgType);
            switch ($RX_TYPE)
            {
                case "event":
                	$result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
            }
            $this->logger("T ".$result);
            echo $result;
        }else{
            echo "";
            exit;
        }
    }
    
>>>>>>> a09201484ead0110a53ffe5a2b7f1459db74f6d7
     private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
                $content = "��ӭ����iFu������ ";
                break;
        }
        $result = $this->transmitText($object, $content);
        return $result;
    }
    
    
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        if(key)
        $url = "http://apix.sinaapp.com/weather/?appkey=".$object->ToUserName."&city=".urlencode($keyword); 
        $output = file_get_contents($url);
        $content = json_decode($output, true);
        $result = $this->transmitNews($object, $content);
        return $result;
    }
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
<<<<<<< HEAD
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[text]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		</xml>";
=======
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
>>>>>>> a09201484ead0110a53ffe5a2b7f1459db74f6d7
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
<<<<<<< HEAD
    	</item>
		";
=======
    </item>
";
>>>>>>> a09201484ead0110a53ffe5a2b7f1459db74f6d7
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $newsTpl = "<xml>
<<<<<<< HEAD
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[news]]></MsgType>
		<Content><![CDATA[]]></Content>
		<ArticleCount>%s</ArticleCount>
		<Articles>
		$item_str</Articles>
		</xml>";
        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

=======
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";
        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }
    private function logger($log_content)
    {

    }
>>>>>>> a09201484ead0110a53ffe5a2b7f1459db74f6d7
        
}
?>