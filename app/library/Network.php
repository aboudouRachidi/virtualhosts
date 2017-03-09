<?php
class Network{
	const ICONS=["success"=>"checkmark box","info"=>"info circle","warning"=>"warning circle","error"=>"announcement"];
	public static $semantic;
	public static function send($address,$port,$action,$content,$params=""){
		set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
			if (0 === error_reporting()) {
				return false;
			}
			throw new ErrorException($errstr, $errno, $errno, $errfile, $errline);
		});
			$serverResponses=[];
			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			$msg=self::createTCPMessage($action,$content,$params);
			try{
				$result = socket_connect($sock, $address, $port);
				if ($result !== false) {
					self::sendMessage($sock, $msg);
					$buf = '';
					if(false!==($buf= socket_read($sock, 2048))){
						if(mb_detect_encoding($buf, 'UTF-8', true)===false)
							$buf=utf8_encode($buf);
							$serverResponses=explode("|", $buf);
					}
					socket_close($sock);
					$serverResponses[]='{"type":"info","content":"Lecture de '.strlen($buf).' bytes provenant du serveur.\nFermeture de la connexion..."}';
				}
			}catch(ErrorException $e){
				$serverResponses[]='{"type":"error","content":"Communication impossible avec le serveur.\nAssurez vous que <b>vhServer</b> est lancé sur '.$address.' et écoute sur le port '.$port.'"}';
			}
			return $serverResponses;
	}
	
	public static function displayMessages($messages){
		foreach ($messages as $message){
			$obj=json_decode($message);
			if($obj!==null){
				self::showMessage($obj->content, $obj->type);
			}
		}
	}
	
	private static function hasError($messages){
		$result=false;
		foreach ($messages as $message){
			$obj=json_decode($message);
			if($obj!==null){
				if($obj->type==="error")
					$result=true;
			}
		}
		return $result;
	}
	
	private static function showMessage($content,$style){
		$msg=self::$semantic->htmlMessage("",nl2br($content));
		$msg->setStyle($style);
		$msg->setIcon(self::ICONS[$style]);
		echo $msg;
	}
	
	private static function createTCPMessage($action,$message="",$params=""){
		$params=explode(",", $params);
		if($action==="sendfile"){
			$filename='http://'.$_SERVER['SERVER_NAME'].$this->url->get($message);
	
			$fileContent=file_get_contents($filename);
			$msg ='{"action":"'.$action.'", "content":'.json_encode($fileContent).',"params":'.json_encode($params).'}';
		}else{
			$msg ='{"action":"'.$action.'", "content":'.json_encode($message).',"params":'.json_encode($params).'}';
		}
		return $msg."\n";
	}
	
	private static function sendMessage($socket,$msg){
		$length = strlen($msg);
		while (true) {
			$sent = socket_write($socket, $msg, $length);
			if ($sent === false) {
				break;
			}
			if ($sent < $length) {
				$msg = substr($msg, $sent);
				$length -= $sent;
			} else {
				break;
			}
		}
	}
}