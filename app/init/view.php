<?
	$view = new Zend_View();

	$view->baseUrl = "/";

	$view->page = $page;
	$view->sett = $sett;
	$view->labels = $labels;
	$view->blocks = $blocks;
	$view->templates = $templates;
	$view->valutas = $valutas;
	$view->valuta = $_SESSION['valuta'];
	$view->args = $args;
	$view->url = $url;
	$view->cart = $cart;
	$view->visited_prods = $visited_prods;
	$view->bc = array(/*"/" => "Начало"*/);
	$view->cache = $cache;
	$view->outputcache = $outputcache;
//	$view->memcache = $memcache;
	
	$view->path = "/app/view";

	if(ASWEB_ADMIN == 1){
		$view->setBasePath("../admin/view/");
		$view->path = "/admin/view";
	}else{
		$view->setBasePath("app/view/");
		$view->path = "/app/view";
	}
