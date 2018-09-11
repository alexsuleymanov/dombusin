<?	// Controller - Фотогалерея

	$cat = $args[1];
	$results = 24;
	$start = 0 + $_GET['start'];

	$view->bc["/".$args[0]] = $labels["photos"];

	if(empty($args[1])){
		$Cat = new Model_Photocat();
		$cats = $Cat->get($args[1]);

		$view->cats = $cats;

		echo $view->render('head.php');
		echo $view->render('photos/cats.php');
		echo $view->render('foot.php');
	}else{
		$Photo = new Model_Photo();
		$cond = array(
			"where" => "`type` = 'photocat' and par = '".data_base::nq($cat)."'",
			"order" => "prior desc",
		);

		$view->cnt = $Photo->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";
		$photos = $Photo->getall($cond);

		if($start){
			$view->page->title = $view->page->title.". ".$labels['page']." ".(round($start/$results)+1);
			$view->page->descr = $view->page->descr.". ".$labels['page']." ".(round($start/$results)+1);
		}

		$view->bc["/".$args[0]."/".$args[1]] = $view->page->name;
		$view->photos = $photos;

		echo $view->render('head.php');
		if($view->photos) echo $view->render('photos/list.php');
		echo $view->render('foot.php');
	}
