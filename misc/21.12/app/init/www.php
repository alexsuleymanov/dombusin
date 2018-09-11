<?
	$host = "www.dombusin.com";
	
	if(strcmp($_SERVER["HTTP_HOST"], $host) != 0){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: http://".$host.$_SERVER["REQUEST_URI"]);
		exit();
	}