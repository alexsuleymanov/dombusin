<?	// Controller - Список брендов

	$results = 15;
	$start = 0 + $_GET['start'];

	$_pagename = $args[0];
	$_intname = $args[1];

	$view->bc["/".$args[0]] = $labels["brands"];

	if(empty($_intname)){
		$Brand = new Model_Brand();
		$view->brands = $Brand->getall(array("where" => "visible = 1", "order" => "name"));
		echo $view->render('head.php');
		echo $view->render('brands/list.php');
		echo $view->render('foot.php');
		die();
	}else{
		$Brand = new Model_Brand();
		$brand = $Brand->getbyname($_intname);

		$view->page->name = ($brand->name) ? $brand->name : $view->page->name;
		$view->page->title = ($brand->title) ? $brand->title : $view->page->title;
		$view->page->kw = ($brand->kw) ? $brand->kw : $view->page->kw;
		$view->page->descr = ($brand->descr) ? $brand->descr : $view->page->descr;

		$view->brand = $brand;
		$view->bc["/".$args[0]."/".$_intname] = $view->page->name;

		echo $view->render('head.php');
		echo $view->render('brands/cont.php');

		$Cat = new Model_Cat();
		$cats = $Cat->getbybrand($brand->id);
		$view->cats = $cats;
		echo $view->render('brands/cats.php');
		echo $view->render('foot.php');
	}
