<?	// Controller - Статьи

	$results = 15;
	$start = 0 + $_GET['start'];

	$_pagename = $args[0];
	$_intname = $args[1];

	$view->bc["/".$args[0]] = $labels["articles"];

	if(empty($_intname)){
		$Article = new Model_Page('article');
		$cond = array(
			"where" => "visible = 1",
			"order" => "tstamp desc",
		);

		$view->cnt = $Article->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";
		$articles = $Article->getall($cond);

		if($start){
			$view->page->title = $view->page->title.". ".$labels['page']." ".(round($start/$results)+1);
			$view->page->descr = $view->page->descr.". ".$labels['page']." ".(round($start/$results)+1);
		}

		$view->articles = $articles;

		echo $view->render('head.php');
		echo $view->render('articles/list.php');
		echo $view->render('rule.php');
		echo $view->render('foot.php');
	}else{
		$Article = new Model_Page('article', $_intname);
		$article = $Article->getbyname($_intname);

		$view->page->name = ($article->name) ? $article->name : $view->page->name;
		$view->page->title = ($article->title) ? $article->title : $view->page->title;
		$view->page->kw = ($article->kw) ? $article->kw : $view->page->kw;
		$view->page->descr = ($article->descr) ? $article->descr : $view->page->descr;
		$view->page->h1 = ($article->h1) ? $article->h1 : $article->name;

		$view->article = $article;

		$view->bc["/".$args[0]."/".$_intname] = $view->page->name;

		echo $view->render('head.php');
		echo $view->render('articles/cont.php');
		echo $view->render('foot.php');
	}
