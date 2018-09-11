<?	// Controller - Поиск

	$results = 30;
	$start = 0 + $_GET['start'];
	$q = $_GET['q'];

	if($q){
		$text = $q;
		$words = preg_split("/[\s\.,\-\=\+!\'\"%\&\(\)]/", $text, -1, PREG_SPLIT_NO_EMPTY);
		$i = 0; $n = 0;

		if($text) $_SESSION[sres] = array();
		$sres = &$_SESSION[sres];

		if($opt["prods"]){
			$cond = array();
			$Prod = new Model_Prod();
			$cond["where"] = "visible = 1 and (num > 0 or num2 > 0 or num3 > 0)";
			foreach($words as $k => $v){
				$cond["where"] .= " and (art like '%$v%' or name like '%$v%' or title like '%$v%' or cont like '%$v%')";
			}
			$n += $Prod->getnum($cond);
			$cond["limit"] = "$start, $results";
			$prods = $Prod->getall($cond);

			/*foreach($pages as $res){
				$sres[$i]['link'] = "http://".$_SERVER["HTTP_HOST"]."/catalog/prod-".$res->id;
				$sres[$i]['name'] = $res->name;
				$sres[$i]['short'] = substr(strip_tags($res->cont), max(strpos($res->cont, $text) - 200, 0), 200);
				$i++;
			}*/

		}
		$_SESSION[cnt] = $n;

		$view->prods = $prods;
		$view->cnt = $_SESSION[cnt];
		$view->results = $results;
		$view->start = $start;

		$view->page->h1 = "Поиск";
		if($_GET["hint"]){
			print_r($sres);
			die();
		}

		$view->bc["/".$args[0]] = $labels["search"];
		echo $view->render("head.php");
		if(count($view->prods))
			echo $view->render("catalog/prod-list.php");
		else
			echo "<center>По данному запросу не найдено ни одного товара</center>";
		echo $view->render("foot.php");
	}else{
		$view->bc["/".$args[0]] = $labels["search"];
		echo $view->render("head.php");
		echo $view->render("search/index.php");
		echo $view->render("foot.php");
	}
