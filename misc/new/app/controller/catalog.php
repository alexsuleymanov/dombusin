<?	// Controller - Каталог товаров

	if($_GET['results'] && $_GET['results'] != $_SESSION['results']){
		$_SESSION['results'] = $_GET['results'];
		$results = $_SESSION['results'];
	}else{
		$results = ($_SESSION['results']) ? $_SESSION['results'] : 30;
	}

	
	if($_GET['view'] || $args[1] == 'pop' || $args[1] == 'new' || $args[1] == 'mix'){
		setcookie("view_mode", $_GET['view'], time()+86400*365);
		if($args[1] == 'pop' || $args[1] == 'new' || $args[1] == 'mix'){
			setcookie("view_mode", 'list', time()+86400*365);
		}
	}

	$start = 0 + $_GET['start'];
	$period = ($_GET['period']) ? $_GET['period'] : 30;

	$cat = 0;
	$brand = 0;
	$prod = 0;

	$view->brands = array();
	$view->chars = array();
	
	foreach($args as $k=>$v){
		if(preg_match("/cat-(\d+)-(.*?)/", $v, $m))
			$cat = 0 + $m[1];
		if(preg_match("/brand-(\d+)-(.*?)/", $v, $m))
			$brand = 0 + $m[1];
		if(preg_match("/tag-(\d+)-(.*?)/", $v, $m))
			$tag = 0 + $m[1];
		if(preg_match("/action-(\d+)-(.*?)/", $v, $m))
			$action = 0 + $m[1];
		if(preg_match("/char-(\d+)-(\d+)/", $v, $m)){
			$char = 0 + $m[1];
			$charval = 0 + $m[2];
		}
		
		if(preg_match("/prod-(\d+)/", $v, $m))
			$prod = 0 + $m[1];

		if(preg_match("/filter-(.*)/", $v, $m)){
			$filter = $m[1];
			$view->filter = $filter;
			$is_filter = 1;
			preg_match_all("/brand(\d+)/", $filter, $m);
			$view->brands = $m[1];
			preg_match_all("/char(\d+)\-([\d_]+)/", $filter, $m);
			$view->chars = array();
//			print_r($m);
			preg_match("/sale-(\w+)/", $filter, $m2);
			$view->sale = $m2[1];
			
			foreach($m[1] as $k => $v){
				if(preg_match("/_/", $m[2][$k])){
					preg_match_all("/(\d+)/", $m[2][$k], $mm);
//					print_r($mm);
//					foreach($mm[0] as $k => $v)
					$view->chars[$v] = $mm[0];
				}else{
					$view->chars[$v][] = $m[2][$k];
				}

			}
//			print_r($view->chars);
		}
	//		print_r($view->brands);
	}

	$view->cat = $cat;
	$view->brand = $brand;
	$view->prod = $prod;
	$view->bc["/"] = "Главная";
	$view->view_mode = ($_GET['view']) ? $_GET['view'] : $_COOKIE['view_mode'];

	if($_GET['getnum']){
		$Prod = new Model_Prod();
		$type = false;
		
		if(($args[1]==='new')||($args[1]==='action')||($args[1]==='pop')) {
			$type = $args[1];
		}
				
		$result = array("num" => $Prod->quickcount($cat, $type));
		echo Zend_Json::encode($result);
		die();
	}
	
	if($_GET['filter']){
		if($args[1] === 'new' || $args[1] === 'action')
			$url_redir = "/catalog/".$args[1]."/".$args[2]."/filter";
		else
			$url_redir = "/catalog/".$args[1]."/"."filter";
//		echo $url_redir; die();
		$k = 0;
		if ($_GET['sale']) {
			$url_redir .= "-sale-".$_GET['sale'];
		}
		
		foreach($_GET as $k => $b){
			if(preg_match("/brand(\d+)/", $k, $m)){
				//if($k++) $url_redir .= "-";
				$url_redir .= "-brand".$m[1];
			}
		}
//		print_r($_GET);
		foreach($_GET as $k => $b){
			if(preg_match("/char(\d+)/", $k, $m)){
				//if($k++) $url_redir .= "-";
				$url_redir .= "-char".$m[1]."-".implode("_", $b);
			}
		}
		if(isset($_GET['minprice']) && isset($_GET['maxprice'])){
			$url_redir .= "?minprice=".$_GET['minprice']."&maxprice=".$_GET['maxprice'];
		}
//		echo $url_redir;
		$url->redir($url_redir);
		die();
	}

	if($args[1] == 'set'){
		if(isset($_GET['results'])&&(is_numeric($_GET['results']))){
			$_SESSION['results'] = $_GET['results'];
		}
	}

	if($opt["prod_cats"] && empty($cat) && empty($prod) && empty($tag) && $args[1]!=='action' && $args[1]!=='new' && $args[1]!=='pop' && $args[1] !== 'mix') {
		$Cat = new Model_Cat();
		$view->cats = $Cat->getall(array("where" => "visible = 1 and cat = 0", "order" => "prior desc"));

		echo $view->render('head.php');

		if (($args[1]=='action')&&($args[2]=='')) {
			$Actions = new Model_Page('actions');
			$cond = array(
				"where" => "visible = 1",
				"order" => "tstamp desc",
			);
			$actions = $Actions->getall($cond);
			$view->actions = $actions;
			echo $view->render('actions/list.php');
		}

		echo $view->render('catalog/page-cont.php');
		echo $view->render('foot.php');
		//die();
	}elseif((empty($prod))||($action)){
		if($cat){
			$Cat = new Model_Cat($cat);
			$row = $Cat->get($cat);

			$view->page->cont = $row->cont;
			$view->page->cont2 = $row->cont2;
			$view->page->title = ($row->title) ? $row->title : $row->name.". ".$view->page->title;
			$view->page->name = $row->name;
			$view->page->h1 = ($row->h1) ? $row->h1 : $row->name;
			$view->page->kw = $row->kw;
			$view->page->descr = $row->descr;

			if($charval){
				$Charval = new Model_Charval($charval);
				$charval_row = $Charval->get($charval);
				$view->page->title = $charval_row->value.". ".$view->page->title;
				$view->page->h1 = $charval_row->value.". ".$view->page->h1;
				$view->page->kw = $charval_row->value.", ".$view->page->kw;
//				$view->page->cont = $row->cont;
//				$view->page->cont2 = $row->cont2;

				$_GET['filter'] = 1;
				$_GET['char'.$char] = array("0" => $charval);
			}

			$tree = array_reverse(Model_Cat::get_cat_tree_up($cat));

			foreach($tree as $k => $v){
				$Cat = new Model_Cat();
				$cat_row = $Cat->get($v->id);
				$view->bc["/catalog/cat-".$cat_row->id."-".$cat_row->intname] = $cat_row->name;
			}
			$view->page->bc = $view->bc;
			$view->canonical = "/".$args[0]."/cat-".$row->id."-".$row->intname;
			if($_GET['start'] != 0) $view->canonical = "/".$args[0]."/cat-".$row->id."-".$row->intname."?start=".$_GET['start'];
		}

		if($brand){
			$Brand = new Model_Brand($brand);
			$row = $Brand->get($brand);

			$view->page->title = ($row->title) ? $view->page->title.". ".$row->title : $view->page->title.". ".$row->name;
			$view->page->h1 .= ($row->h1) ? $view->page->h1.". ".$row->h1 : $view->page->h1.". ".$row->name;
			$view->page->kw .= ($row->kw) ? $row->kw.", ".$view->page->kw : $row->name.", ".$view->page->kw;
			$view->page->descr = ($row->descr) ? $row->descr : $row->name.". ".$view->page->descr;
		}

		if($_pagename == 'tag'){
			$Tag = new Model_Tag($tag);
			$tag = $Tag->get($tag);

			$view->page->title .= ". ".$tag->name;
			$view->page->h1 .= ". ".$tag->name;
			$view->page->kw .= ", ".$tag->name;
			$view->page->descr .= ". ".$tag->name;
		}

		if($is_filter){
			$Catpage = new Model_Catpage();
			$catpage = $Catpage->getone(array("where" => "intname = '".data_base::nq($_SERVER['REQUEST_URI'])."'"));
//			print_r($catpage);
			if($catpage){
				$view->page->title = $catpage->title;
				$view->page->h1 = $catpage->h1;
				$view->page->kw = $catpage->kw;
				$view->page->descr = $catpage->descr;
				$view->page->cont = $catpage->cont;
				$view->page->cont2 = $catpage->cont2;
				$view->canonical = $catpage->intname;
				$view->noindex = 0;
				$view->bc[$catpage->intname] = $catpage->name;
			}else{
				$view->noindex = 1;
				if($view->brands[0]){
					foreach($view->brands as $kkk => $bbb){
						$Brand = new Model_Brand($bbb);
						$brand_row = $Brand->get();
						$view->page->h1 .= ($kkk > 0) ? ", ".$brand_row->name : " ".$brand_row->name;
					}
				}
			}
			
			if(!empty($_GET)) $view->noindex = 1;
//			print_r($catpage);
		}
		
		$Prod = new Model_Prod();

		$cond = array(
			"where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0)",
		);

		$order = ($_GET['order']) ? $_GET['order'] : "changed";
		$desc_asc = ($_GET['desc_asc']) ? $_GET['desc_asc'] : "desc";
		$cond['order'] = $order." ".$desc_asc;

		if(($cat) && ($args[1]!=='new') && ($args[1]!=='pop') && ($args[1]!=='mix')) {
			$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'");
		} elseif($cat) {
			$cat = data_base::nq($cat);
			$cats_list = "(" . $cat;
			$Cat = new Model_Cat();
			$subcats = $Cat->getall(array("where" => "cat = " . $cat . " and visible = 1"));
			if (count($subcats)) {
				foreach ($subcats as $subcat) {
					$cats_list .= ', ' . $subcat->id;
					$subsubcats = $Cat->getall(array("where" => "cat = " . $subcat->id . " and visible = 1"));
					if (count($subsubcats)) {
						foreach ($subsubcats as $subsubcat) {
							$cats_list .= ', ' . $subsubcat->id;
						}
					}
				}
			}
			$cats_list .= ")";
			$cond["relation"] = array(
				"select" => "relation",
				"where" => "`type` = 'cat-prod' and obj in " . $cats_list
			);
		}

		if($brand) $cond['where'] .= " and brand = '".data_base::nq($brand)."'";
		if($tag) $cond["relation"] = array("select" => "obj", "where" => "`type` = 'prod-tag' and relation = '".data_base::nq($tag)."'");
		if($action) $cond['where'] .= " and `action` = '".data_base::nq($action)."'";

		if($is_filter){
			$cond["where"] .= " and ".Model_Prod::filter2($cat, $view->brands, $view->chars, $view->sale);
		}
		
		if($args[1]==='pop'){
			$cond["where"] .= " and pop = 1";
		}
		
		if($args[1] == 'mix'){
			$cond["where"] .= " and `mix` = 1";
		}
		
		if ($view->sale) {
			if ($view->sale == 'action') {
				$cond["where"] .= " and (skidka > 0 or skidka2 > 0 or skidka3 > 0)";
			} else {
				$cond["where"] .= " and `".$view->sale."` = 1";
			}
		}
		
		if($args[1] === 'action'){
			if($_SESSION['useropt']) $cond["where"] .= " and (skidkaopt > 0 or skidkaopt2 > 0 or skidkaopt3 > 0)";
			else $cond["where"] .= " and (skidka > 0 or skidka2 > 0 or skidka3 > 0)";
		}

		if($args[1]==='new' || $_GET['novinki']){
			$cond["where"] .= " and `new` = 1";// and uploaded > ".(time() - 90*86400);
		}else{
			$cond2 = $cond;
			$cond2["where"] .= " and `new` = 1";//" and uploaded > ".(time() - 90*86400);
			$view->new_count = $Prod->getnum($cond2);
		}
		
		$view->cnt = $Prod->getnum($cond);

//		$prods = $Prod->getall($cond);
//		print_r($cond); 
	//	echo count($prods); die();
		
		$cond["limit"] = "$start, $results";
		
		$prods = $Prod->getall($cond);
		
		$view->results = $results;
		$view->start = $start;

//		$prods = array_slice($prods, $start, $results);

		if($start){
			$view->page->title = Func::mess_from_tmp($templates['cat_page_title'], array("page" => round($start/$results)+1, "name" => $view->page->name));
			$view->page->descr = Func::mess_from_tmp($templates['cat_page_descr'], array("page" => round($start/$results)+1, "name" => $view->page->name));
			$view->page->cont = $view->page->cont2 = '';
		}

		$view->prods = $prods;

		echo $view->render('head.php');

		if(($opt["cat_tree"])&&($args[1]!=='action')&&($args[1]!=='new')&&($args[1]!=='pop')&&($args[1]!=='mix')){
			$Cat = new Model_Cat();
			$view->cats = $Cat->getall(array("where" => "visible = 1 and cat = '".data_base::nq($cat)."'", "order" => "prior desc"));
			if(count($view->cats)) echo $view->render('catalog/subcat-list.php');
		}

		$cartids = array();
		foreach ($view->cart->cart as $k => $v) {
			$cartids[] = $v['id'];
		}
		$view->cartids = $cartids;

		echo $view->render('catalog/prod-list.php');
		//echo $view->render('rule.php');
		echo $view->render('catalog/page-cont.php');
		echo $view->render('foot.php');
	}elseif($view->args[2]=='ajax'){
		$Prod = new Model_Prod($prod);
		$view->prod = $Prod->get($prod);
		$view->noindex = 1;
		echo "<html><head><meta name='robots' content='noindex,nofollow' /></head><body>";
		echo $view->render('catalog/prod-ajax.php');
		echo "</body></html>";
	} elseif($view->args[2]=='ajax2') {
		$Prod = new Model_Prod($prod);
		$view->prodone = $Prod->get($prod);
		$prod = $Prod->get($prod);

		$cartids = array();
		foreach ($view->cart->cart as $k => $v) {
			$cartids[] = $v['id'];
		}
		$view->cartids = $cartids;

		echo json_encode(array(
			'prod' => $prod,
			'price' => $view->render('catalog/prod-price.php'),
			'weight' => $view->render('catalog/prod-weight.php'),
			'form' => $view->render('catalog/prod-form.php'),
			'wish' => $view->render('catalog/prod-wish.php'),
		));
	} else {
		$Prod = new Model_Prod($prod);
		$view->prod = $Prod->get($prod);
		$visited_prods->add($_SERVER['REQUEST_URI'], $view->prod->name);
		//print_r($view->prod);
		$Relation = new Model_Relation();
		$relation = $Relation->getone(array("where" => "`type` = 'cat-prod' and `relation` = '".$view->prod->id."'"));
		$cat = $relation->obj;

		if($cat){
			$tree = array_reverse(Model_Cat::get_cat_tree_up($cat));
			foreach($tree as $k => $v){
				$Cat = new Model_Cat();
				$cat_row = $Cat->get($v->id);
				$view->bc["/catalog/cat-".$cat_row->id."-".$cat_row->intname] = $cat_row->name;
			}
		}
		$view->page->bc = $view->bc;
		$view->bc[$_SERVER["REQUEST_URI"]] = $view->prod->name;

		if($opt["prod_cats"] && $cat == 0){
			$Cat = new Model_Cat();
			$cat = $Cat->get($view->prod->cat)->id + 0;
		}

		if($view->prod == false){
			include("404.php");
			die();
		}

		$view->page->title = ($view->prod->title) ? $view->prod->title : "Купить ".$view->prod->name." в интернет-магазине Дом Бусин";
		$view->page->h1 = $view->prod->h1 ? $view->prod->h1 : $view->prod->name;
		$view->page->kw = $view->prod->kw;
		$view->page->descr = ($view->prod->descr) ? $view->prod->descr : htmlspecialchars($view->prod->name)." &rarr; Дом бусин &quot;Изюминка&quot;, звоните: +38 (050) 760-40-98.";
		$view->page->bc = ($view->prod->bc) ? $view->prod->bc : $view->page->bc;

//		print_r($view->page->bc);

		if($opt["prod_chars"]){
			$view->prod_chars = $Prod->getprodchars();
			if($opt["char_cats"]){
				$Charcat = new Model_Charcat();
				$view->charcats = $Charcat->getall(array("where" => Model_Cat::cat_tree($cat)));
			}
			$Char = new Model_Char();
			$view->chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat)));
		}

		if($opt["prod_photos"])
			$view->photos = $Prod->getphotos();

		if($opt["prod_vars"])
			$view->prodvars = $Prod->getprodvars();

		if($opt["prod_comments"]){
			$form = new Form_Comment();
			$form->addDecorator(new Form_Decorator_Ajax());
			$view->form = $form->render($view);
			$view->comments = $Prod->getcomments();
		}

		$view->childs = $Prod->getprodchilds();
		$view->analogs = $Prod->getprodanalogs();

		$view->canonical = "/".$args[0]."/prod-".$view->prod->id;

		$cartids = array();
		foreach ($view->cart->cart as $k => $v) {
			$cartids[] = $v['id'];
		}
		$view->cartids = $cartids;

		echo $view->render('head.php');
		echo $view->render('catalog/prod-cont.php');
		echo $view->render('foot.php');
	}
