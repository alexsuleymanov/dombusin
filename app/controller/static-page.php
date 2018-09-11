<?
	$Page = new Model_Page('page');
	$subpages = $Page->getsubpages($page->id);

	$view->subpages = $subpages;

	$view->photos = $Page->getphotos($page->id);

	$tree = array_reverse(Model_Page::get_page_tree_up($page->id));

	foreach($tree as $k => $v){
		$Page = new Model_Page('page');
		$page_row = $Page->get($v->id);
		$view->bc["/".$page_row->intname] = $page_row->name;
	}

	echo $view->render('head.php');
	echo $view->render('page/cont.php');
	if($view->photos) echo $view->render('photos/list.php');
	echo $view->render('foot.php');

