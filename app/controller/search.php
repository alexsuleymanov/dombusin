<?	// Controller - Поиск

	$results = 30;
	$start = 0 + $_GET['start'];
	$q = $_GET['q'];

	$view->view_mode = ($_GET['view']) ? $_GET['view'] : "list";
	
	if($q){
		$text = $q;
		$words = preg_split("/[\s\.,\-\=\+!\'\"%\&\(\)]/", $text, -1, PREG_SPLIT_NO_EMPTY);
		$i = 0; $n = 0;

		$cond = array();
		$Prod = new Model_Prod();
		$cond["where"] = "visible = 1 and (num > 0 or num2 > 0 or num3 > 0)";
		foreach($words as $k => $v){
			$cond["where"] .= " and (art like '%$v%' or name like '%$v%')";
		}
		$view->cnt = $Prod->getnum($cond);

		$cond["limit"] = "$start, $results";
		$prods = $Prod->getall($cond);
		$_SESSION[cnt] = $n;

		$view->prods = $prods;
		$view->results = $results;
		$view->start = $start;

		$view->bc["/".$args[0]] = $labels["search"];
		echo $view->render("head.php");
		$view->cat = 0;
		if(count($view->prods)) {
			echo $view->render("catalog/prod-list.php");
		} else {
			echo $view->render('search/empty.php');
		}
		echo $view->render("foot.php");
	}else{
		$view->bc["/".$args[0]] = $labels["search"];
		echo $view->render("head.php");
		echo $view->render("search/index.php");
		echo $view->render("foot.php");
	}
