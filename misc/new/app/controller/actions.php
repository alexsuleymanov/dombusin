<?	// Controller - Акции

	$results = 15;
	$start = 0 + $_GET['start'];

	$_pagename = $args[0];
	$_intname = $args[1];

	$view->bc["/".$args[0]] = $labels["actions"];

	if(empty($_intname) || $args[1] == 'archive'){
		$Actions = new Model_Page('actions');
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

		$view->cnt = $Actions->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";
		$actions = $Actions->getall($cond);

		if($start){
			$view->page->title = $view->page->title.". ".$labels['page']." ".(round($start/$results)+1);
			$view->page->descr = $view->page->descr.". ".$labels['page']." ".(round($start/$results)+1);
		}

		$view->actions = $actions;

		echo $view->render('head.php');
		echo $view->render('actions/list.php');
		echo $view->render('rule.php');
		echo $view->render('foot.php');
	}else{
		$Actions = new Model_Page('actions', $_intname);
		$actions = $Actions->getbyname($_intname);

		$view->page->name = ($actions->name) ? $actions->name : $view->page->name;
		$view->page->title = ($actions->title) ? $actions->title : $view->page->title;
		$view->page->kw = ($actions->kw) ? $actions->kw : $view->page->kw;
		$view->page->descr = ($actions->descr) ? $actions->descr : $view->page->descr;
		$view->page->h1 = ($actions->h1) ? $actions->h1 : $actions->name;

		$view->bc["/".$args[0]."/".$_intname] = $view->page->name;
		$view->actions = $actions;
		
		$view->prods = $prods;
		
		echo $view->render('head.php');
		echo $view->render('actions/cont.php');
		echo $view->render('foot.php');
	}
