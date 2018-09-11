<?	// Controller - Доска объявлений

	$start = 0 + $_GET['start'];

	if($args[0] == 'sale')
		$type = 0;
	elseif($args[0] == 'buy')
		$type = 1;
		
	foreach($args as $k=>$v){
		if(preg_match("/cat-(\d+)_(.*?)/", $v, $m))
			$cat = 0 + $m[1];
		if(preg_match("/adv-(\d+)/", $v, $m))
			$adv = 0 + $m[1];
		if(preg_match("/type-(\d+)/", $v, $m))
			$type = 0 + $m[1];
	}

	$view->bc["/".$args[0]] = $labels["adv"];

	if($args[1] == 'add'){
		$form = new Form_Adv();

		if($_POST['submit']){
			if ($form->isValid($_POST)){
				$values = $form->getValues();
				$Adv = new Model_Adv();

				$data = array(
					'shop' => Zend_Registry::get('shop_id'),
					'cat' => $values['cat'],
					'type' => $values['type'],
					'region' => 0,
					'user' => 0,
					'contacts' => $values['contacts'],
					'subj' => $values['subj'],
					'cont' => $values['cont'],
					'tstamp' => time(),
					'active_till' => time()+60*60*24*365,
					'title' => $values['title'],
					'kw' => $values['kw'],
					'descr' => $values['descr'],
				);
				$Adv->insert($data);
				echo $view->render('head.php');
				echo $view->render('adv/head.php');
				echo $view->render('adv/success.php');
				echo $view->render('foot.php');
			}else{
				echo $view->render('head.php');
				echo $view->render('adv/head.php');
				echo $form->render($view);
				echo $view->render('foot.php');
			}
		}else{
			echo $view->render('head.php');
			echo $view->render('adv/head.php');
			echo $form->render($view);
			echo $view->render('foot.php');
		}
		die();
	}

	if(empty($cat)){
		$AdvCat = new Model_AdvCat();
		$view->cats = $AdvCat->getall(array("where" => "advcat = '".data_base::nq($cat)."'", "order" => "prior desc"));

		echo $view->render('head.php');
		echo $view->render('adv/head.php');
		echo $view->render('adv/cats.php');
		echo $view->render('foot.php');
	}elseif(empty($adv)){
		$results = 20;
		$order = "tstamp desc";

		$AdvCat = new Model_AdvCat($cat);
		$page = $AdvCat->get();

		$view->page->title = $page->title;
		$view->page->kw = $page->kw;
		$view->page->descr = $page->descr;

		$Adv = new Model_Adv();
		$cond = array(
			"where" => "cat = '".data_base::nq($cat)."'",
			"order" => $order,
		);
		if($type)
			$cond["where"] .= " and `type` = '".data_base::nq($type)."'";

		$view->cnt = $Adv->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";
		$view->advs = $Adv->getall($cond);

		echo $view->render('head.php');
		echo $view->render('adv/head.php');

		if($opt["adv_cat_tree"]){
			$AdvCat = new Model_AdvCat();
			$view->cats = $AdvCat->getall(array("where" => "advcat = '".data_base::nq($cat)."'", "order" => "prior desc"));
			if(count($view->cats)) echo $view->render('adv/subcats.php');
		}

		echo $view->render('adv/list.php');
		echo $view->render('rule.php');
		echo $view->render('foot.php');
	}elseif($adv){
		$adv_model = new Model_Adv($adv);
		$view->adv = $adv_model->get();

		if($view->adv == false){
			include("404.php");
			die();
		}

		$view->page->title = $view->adv->title;
		$view->page->kw = $view->adv->kw;
		$view->page->descr = $view->adv->descr;

		echo $view->render('head.php');
		echo $view->render('adv/head.php');
		echo $view->render('adv/show.php');
		echo $view->render('foot.php');
	}
