<?
	if (!isset($_COOKIE['session_id'])){
		$session_id = md5(microtime());
		Zend_Registry::set('session_id', $session_id);
		setcookie("session_id", $session_id, time()+60*60*24*30);
	}else{
		Zend_Registry::set('session_id', $_COOKIE['session_id']);
	}
