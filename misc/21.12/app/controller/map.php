<?// Controller - Карта сайта

	$map = array();
	$Page = new Model_Page('page');
	$Article = new Model_Page('article');
	$News = new Model_Page('news');
	$Cat = new Model_Cat();
	$Prod = new Model_Prod();

	
	$view->cats = $Cat->getall(array("where" => "visible = 1 and cat = 0", "order" => "name"));
	$view->subcats = $Cat->getall(array("where" => "visible = 1 and cat != 0", "order" => "name"));

	$view->pages = $Page->getall(array("where" => "visible = 1 and `page` = 0"));
	$view->subpages = $Page->getall(array("where" => "visible = 1 and `page` != 0"));

	$view->articles = $Article->getall(array("where" => "visible = 1", "order" => "tstamp desc"));


	$view->news = $News->getall(array("where" => "visible = 1", "order" => "tstamp desc"));

	echo $view->render("head.php");
	echo $view->render("sitemap/show.php");
	echo $view->render("foot.php");