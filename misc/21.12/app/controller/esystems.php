<?	// Controller - Способы оплаты

	$Esystem = new Model_Esystem();
	$cond = array(
		"where" => "visible = 1",
		"order" => "prior desc",
	);

	$esystems = $Esystem->getall($cond);
	$view->esystems = $esystems;

	$view->bc["/".$args[0]] = $labels["esystems"];

	echo $view->render('head.php');
	echo $view->render('esystem/list.php');
	echo $view->render('foot.php');
