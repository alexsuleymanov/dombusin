<?	// Controller - Блог

	$results = 5;
	$start = 0 + $_GET['start'];

	$_pagename = $args[1];

	$view->bc["/".$args[0]] = $labels["blog"];

	if($_pagename == 'article'){
		$_intname = $args[2];

   		$Article = new Model_Page('post', $_intname);
		$article = $Article->getbyname($_intname);

		$view->page->name = ($article->name) ? $article->name : $view->page->name;
		$view->page->title = ($article->title) ? $article->title : $view->page->title;
		$view->page->kw = ($article->kw) ? $article->kw : $view->page->kw;
		$view->page->descr = ($article->descr) ? $article->descr : $view->page->descr;
		$view->page->h1 = ($article->h1) ? $article->h1 : $view->page->h1;

		$view->article = $article;

		$view->bc["/".$args[0]."/article".$_intname] = $view->page->name;

		echo $view->render('head.php');
		echo $view->render('blog/cont.php');
		echo $view->render('foot.php');
	}else{
		$Article = new Model_Page('post');
		$cond = array(
			"where" => "visible = 1",
			"order" => "tstamp desc",
		);

		if($_pagename == 'archive'){
			$year = $args[2];
			$month = $args[3];
			$t1 = mktime(0, 0, 0, $month, 1, $year);
			$t2 = mktime(0, 0, 0, $month+1, 1, $year);
			$cond["where"] .= " and tstamp > '".$t1."' and tstamp < '".$t2."'";
		}

		if($_pagename == 'cat'){
			$Cat = new Model_Cat('blogcat');
			$cat = $Cat->getone(array("where" => "intname = '".data_base::nq($args[2])."'"));

			$view->page->name = ($cat->name) ? $view->page->name.". ".$cat->name : $view->page->name;
			$view->page->title = ($cat->title) ? $view->page->title.". ".$cat->title : $view->page->title;
			$view->page->kw = ($cat->kw) ? $view->page->name.". ".$cat->kw : $view->page->kw;
			$view->page->descr = ($cat->descr) ? $view->page->name.". ".$cat->descr : $view->page->descr;

			$cond["relation"] = array("select" => "obj", "where" => "`type` = 'post-cat' and relation = '".data_base::nq($cat->id)."'");
		}

		if($_pagename == 'tag'){
			$Tag = new Model_Tag();
			$tag = $Tag->getone(array("where" => "intname = '".data_base::nq($args[2])."'"));

			$view->page->name .= ". ".$tag->name;
			$view->page->title .= ". ".$tag->name;
			$view->page->kw .= ", ".$tag->name;
			$view->page->descr .= ". ".$tag->name;

			$cond["relation"] = array("select" => "obj", "where" => "`type` = 'post-tag' and relation = '".data_base::nq($tag->id)."'");
		}

		$view->cnt = $Article->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";
		$articles = $Article->getall($cond);

		$view->articles = $articles;

		if($start){
			$view->page->title = $view->page->title.". ".$labels['page']." ".(round($start/$results)+1);
			$view->page->descr = $view->page->descr.". ".$labels['page']." ".(round($start/$results)+1);
		}

		echo $view->render('head.php');
		echo $view->render('blog/list.php');
		echo $view->render('rule.php');
		echo $view->render('foot.php');
	}
