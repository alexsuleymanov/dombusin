<?
	$host = "www.dombusin.com";
	
	if($_SERVER["HTTP_HOST"] != $host || empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: https://".$host.$_SERVER["REQUEST_URI"]);
		exit();
	}