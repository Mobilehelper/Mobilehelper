<?php

define("TOKEN", "wenbo");
$wechatObj = new wechatCallbackapiTest();

if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
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
            $state = 0;
            
            include 'connect_mysql.php';
            $state = FindUser($fromUsername);
            
            switch($state)
            {
                case "0":
	            	switch($keyword)
    	       	 	{
        	        	case "4" :
            	    		$msgType = "text";
	            	        $contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ \n 4.�˵� \n";
    	            		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        	       		 	echo $resultStr;
            	    		break;
                
	                	case "1" :
                        	    $con=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
    mysql_select_db(SAE_MYSQL_DB,$con);
    mysql_query("UPDATE mobilehelper_user SET state = '1' WHERE ID = '$fromUsername'");
    mysql_close($con);
    	            		$msgType = "text";
	    	             	$contentStr = "��������Ҫ��ѯ�ĳ��У�\n";
	                 		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $result);
		                 	echo $resultStr;
    		            	break;
                        case "2" :
                        
                        	$msgType = "text";
	    	             	$contentStr = "�����������ֻ����룺\n";
    	    	        	$con=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        	    			mysql_select_db(SAE_MYSQL_DB,$con);
            	    		mysql_query("UPDATE mobilehelper_user SET state = '2' WHERE ID = '$fromUsername'");
                			mysql_close($con);
	                 		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		                 	echo $resultStr;
    		            	break;

                         case "3":
                        	$msgType = "text";
	    	             	$contentStr = "��������ϣ����ͨ������\n";
    	    	        	$con=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        	    			mysql_select_db(SAE_MYSQL_DB,$con);
            	    		mysql_query("UPDATE mobilehelper_user SET state = '3' WHERE ID = '$fromUsername'");
                			mysql_close($con);
	                 		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		                 	echo $resultStr;
    		            	break;
                        
						case "0" :
    		            	$msgType = "text";
        		        	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $retstr);
            		     	echo $resultStr;
                			break;
                
                		default :
	                		$msgType = "text";
    	            		$contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ \n 4.�˵� \n";
        	        		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            	   	 		echo $resultStr;
            		}
                 case "1":
                	if($keyword==4){
                    	$con=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
            			mysql_select_db(SAE_MYSQL_DB,$con);
                		mysql_query("UPDATE mobilehelper_user SET state = '0' WHERE ID = '$fromUsername'");
                		mysql_close($con);
                    	$msgType = "text";
                    	$contentStr = date("Y-m-d H:i:s",time())."\n��ӭ����Mobilehelper,����Ϊ����ṩ�����µķ���\n 1.������ѯ  \n 2.���Ѳ�ѯ  \n 3.�ײ����Ų�ѯ \n 4.�˵� \n";
                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
               	 		echo $resultStr;
                	}
                	else{
                        $con=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
            			mysql_select_db(SAE_MYSQL_DB,$con);
                		mysql_query("UPDATE mobilehelper_user SET state = '0' WHERE ID = '$fromUsername'");
                		mysql_close($con);
                        $this->responseCityWeather($postStr);
                    }
                	break;

            }
        }else{
            echo "";
            exit;
        }
    }
    
    
    public function responseCityWeather()
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
        return 0;
    }
    
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
        			<ToUserName><![CDATA[%s]]></ToUserName>
        			<FromUserName><![CDATA[%s]]></FromUserName>
        			<CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content></xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "<item>
        			<Title><![CDATA[%s]]></Title>
        			<Description><![CDATA[%s]]></Description>
        			<PicUrl><![CDATA[%s]]></PicUrl>
        			<Url><![CDATA[%s]]></Url></item>";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $newsTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[news]]></MsgType>
					<Content><![CDATA[]]></Content>
					<ArticleCount>%s</ArticleCount>
					<Articles>$item_str</Articles></xml>";
        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }
    private function logger($log_content)
    {

    }    
}
?>