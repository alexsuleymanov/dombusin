<?	// Controller - Фотографии товаров

	foreach($args as $k=>$v){
		if(preg_match("/cat-(\d+)-(.*?)/", $v, $m))
			$cat = 0 + $m[1];
		if(preg_match("/brand-(\d+)-(.*?)/", $v, $m))
			$brand = 0 + $m[1];
		if(preg_match("/prod-(\d+)/", $v, $m))
			$prod = 0 + $m[1];
	}

	$view->cat = $cat;

	if(empty($cat)){
		$Cat = new Model_Cat();
		$view->cats = $Cat->getall(array("where" => "cat = '".data_base::nq($cat)."'", "order" => "prior desc"));

		echo $view->render('head.php');
		if(count($view->cats)) echo $view->render('photos/cat-list.php');
		echo $view->render('foot.php');
		die();
	}else{
		$Prod = new Model_Prod();
		$prods = $Prod->getall(array("select" => "id", "where" => "cat = '$cat'"));
		$view->photos = array();

		foreach($prods as $prods){
			$Prod = new Model_Prod($prod->id);
			$view->photos = array_merge($view->photos, $Prod->getphotos());
		}

		echo $view->render('head.php');
		echo $view->render('photos/list.php');
		echo $view->render('foot.php');
		die();
	}
