<?	// Controller - Лента новостей

	$results = 15;
	$start = 0 + $_GET['start'];

	$_pagename = $args[0];
	$_intname = $args[1];

	$view->bc["/".$args[0]] = $labels["news"];

	if(empty($_intname) || $args[1] == 'archive'){
		$News = new Model_Page('news');
		$cond = array(
			"where" => "visible = 1",
			"order" => "tstamp desc",
		);

		if($args[2] || $args[3]){
			$y1 = $args[2];
			$y2 = ($args[3]) ? $args[2] : $args[2] + 1;
			$m = ($args[3]) ? $args[3] : 1;
			$t1 = mktime(0, 0, 0, $m, 1, $y1);
			$t2 = mktime(0, 0, 0, $m+1, 1, $y2);
			$cond["where"] .= " and tstamp > $t1 and tstamp < $t2";
		}

		$view->cnt = $News->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";
		$news = $News->getall($cond);

		if($start){
			$view->page->title = $view->page->title.". ".$labels['page']." ".(round($start/$results)+1);
			$view->page->descr = $view->page->descr.". ".$labels['page']." ".(round($start/$results)+1);
		}

		$view->news = $news;

		echo $view->render('head.php');
		echo $view->render('news/list.php');
		echo $view->render('rule.php');
		echo $view->render('foot.php');
	}else{
		$News = new Model_Page('news', $_intname);
		$news = $News->getbyname($_intname);

		$view->page->name = ($news->name) ? $news->name : $view->page->name;
		$view->page->title = ($news->title) ? $news->title : $view->page->title;
		$view->page->kw = ($news->kw) ? $news->kw : $view->page->kw;
		$view->page->descr = ($news->descr) ? $news->descr : $view->page->descr;
		$view->page->h1 = ($news->h1) ? $news->h1 : $news->name;

		$view->bc["/".$args[0]."/".$_intname] = $view->page->name;
		$view->news = $news;

		echo $view->render('head.php');
		echo $view->render('news/cont.php');
		echo $view->render('foot.php');
	}
