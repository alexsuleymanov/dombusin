<?
	$action = $args[1];
	$cat = $args[2];
	$id = $args[3];

	$view->bc["/".$args[0]] = $labels["compare"];

	if($action == "add"){
		$_SESSION["compare"][$cat][$id] = $id;
		$result = array("prods" => count($_SESSION["compare"][$cat]));
		echo Zend_Json::encode($result);
	}elseif($action == "del"){
		unset($_SESSION["compare"][$cat][$id]);
		$url->redir("/compare/cmp/".$cat."/".implode("-", $_SESSION["compare"][$cat]));
	}elseif($action == "cmp" && $cat){
		if(empty($args[3])) echo $this->render("compare/empty.php");
		$view->prods = array();
		$view->prod_chars = array();

		$ids = $_SESSION["compare"][$cat];//explode("-", $args[3]);

		foreach($ids as $k => $v){
			$Prod = new Model_Prod($v);
			$view->prods[$v] = $Prod->get();
			$view->prod_chars[$v] = $Prod->getprodchars();
		}

		if($opt["char_cats"]){
			$Charcat = new Model_Charcat();
			$view->charcats = $Charcat->getall(array("where" => Model_Cat::cat_tree($cat)));
		}
		$Char = new Model_Char();
		$view->chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat)));

		echo $view->render("compare/show.php");
	}