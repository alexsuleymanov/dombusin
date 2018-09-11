<?
	$valutas = array();

	if(!$_SESSION['valuta'] || $_GET['valuta'] || (!$valutas = $cache->load("valutas".$lang))){
		$obj = new Model_Valuta();
		$valutas_array = $obj->getall(array("where" => "visible = 1", "order" => "`main` desc"));

		foreach($valutas_array as $k => $v){
			if($v->main && !$_SESSION["valuta"]) $_SESSION["valuta"] = array("id" => $v->id, "name" => $v->name, "short" => $v->short, "course" => $v->course);
			$valutas[$v->id] = array("id" => $v->id, "name" => $v->name, "short" => $v->short, "course" => $v->course, "main" => $v->main);
		}

		$cache->save($valutas, "valutas".$lang, array("model_valuta"));

		if($_GET['valuta']){
			$url = new URLParser($_SERVER[REQUEST_URI], $_SERVER[QUERY_STRING]);
			$_SESSION['valuta'] = $valutas[$_GET['valuta']];
			$url->redir($url->gvar("valuta="));
		}
	}
