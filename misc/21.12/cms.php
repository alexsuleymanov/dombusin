<?	
	error_reporting(E_ERROR);
	ini_set("display_errors", 0);

	$start_time = microtime(true);

	
	$args = array();
	try{
		require_once("incl.php");

		if(!defined("MULTY_LANG")){
			$url = new URLParser($_SERVER[REQUEST_URI], $_SERVER[QUERY_STRING]);
			$args = $url->parce();
		}

		$Page = new Model_Page('page');

		if(($k = count($args)) > 1){
			while($page->id == null && $k > 0){
				$_pagename = '';
				for($i = 0; $i < $k; $i++){
					if($i) $_pagename .= "/";
					$_pagename .= $args[$i];
				}
				$page = $Page->getbyname($_pagename);
				$k--;
			}
		}else{
			$_pagename = ($args[0]) ? $args[0] : '';
			$page = $Page->getbyname($_pagename);
		}

			Zend_Registry::set("start_time", $start_time);
		require_once "app/init/view.php";

		if($page->id == null){
			if(file_exists("app/controller/".$args[0].".php") && in_array($args[0].".php", $system_scripts)){
				include("app/controller/".$args[0].".php");
			}else{
				header("HTTP/1.1 301 Moved Permanently");
//				header("HTTP/1.0 404 Not Found");
				header("Location: /404");
			}
			die();
		}

		if($page->href){
			include("app/controller/".$page->href);
//			die();
		}else{
			include("app/controller/static-page.php");
//			die();
		}
	}catch(Zend_Exception $e){
		echo "<font color=red>Zend Exception!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "<br />";
	}catch(DBException $e){
		echo "<font color=red>DBException!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "Trace: <br />";
		$trace = $e->getTrace(); 
		foreach($trace as $k => $v){
			echo "<font color=\"green\">".$k." -> </font>";
			foreach($v as $kk => $vv){
				echo $kk." -> ";
				if(is_array($vv)) print_r($vv); else echo $vv;
				echo "<br />";
			}
			echo "<br />";
		}
		echo "<br />";
	}catch(Exception $e){
		echo "<font color=red>Exception!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "<br />";
	}

	$time = microtime(true) - $start_time;
//	printf('Скрипт выполнялся %.4F сек.', $time);