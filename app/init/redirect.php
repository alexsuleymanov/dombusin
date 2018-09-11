<?
	$Redirect = new Model_Redirect();
	$redirect = $Redirect->getone(array("where" => "oldurl = '".data_base::nq($_SERVER["REQUEST_URI"])."'"));

	if($redirect->newurl){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".$redirect->newurl);
		exit();
	}

/*	if(empty($_GET['gclid']) && $_SERVER["REQUEST_URI"] != "/" && (preg_match("/.*?\/$/", $_SERVER["REQUEST_URI"], $m) || preg_match("/(\/\?)/", $_SERVER["REQUEST_URI"], $m))){
		
		$newurl = preg_replace(array("/(.)\/$/", "/\/\?/"), array("$1", "?"), $_SERVER["REQUEST_URI"]);
		echo $newurl; die();
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".$newurl);
		exit();
	}
*/