<?	// Controller - Вакансии

	$results = 15;
	$start = 0 + $_GET['start'];

	$_pagename = $args[0];
	$_intname = $args[1];

	$view->bc["/".$args[0]] = $labels["vacancy"];

	if(empty($_intname)){
		$Vacancy = new Model_Page('vacancy');
		$cond = array(
			"order" => "tstamp desc",
		);

		$view->cnt = $Vacancy->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";
		$vacancies = $Vacancy->getall($cond);

		if($start){
			$view->page->title = $view->page->title.". ".$labels['page']." ".(round($start/$results)+1);
			$view->page->descr = $view->page->descr.". ".$labels['page']." ".(round($start/$results)+1);
		}

		$view->vacancies = $vacancies;

		echo $view->render('head.php');
		echo $view->render('vacancy/list.php');
		echo $view->render('rule.php');
		echo $view->render('foot.php');
	}else{
		$Vacancy = new Model_Page('vacancy', $_intname);
		$vacancy = $Vacancy->getbyname($_intname);

		$view->page->name = ($vacancy->name) ? $vacancy->name : $view->page->name;
		$view->page->title = ($vacancy->title) ? $vacancy->title : $view->page->title;
		$view->page->kw = ($vacancy->kw) ? $vacancy->kw : $view->page->kw;
		$view->page->descr = ($vacancy->descr) ? $vacancy->descr : $view->page->descr;
		$view->bc["/".$args[0]."/".$_intname] = $view->page->name;

		$view->vacancy = $vacancy;

		echo $view->render('head.php');
		echo $view->render('vacancy/cont.php');
		echo $view->render('foot.php');
	}
