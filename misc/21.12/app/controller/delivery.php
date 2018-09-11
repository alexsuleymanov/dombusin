<?	// Controller - Способы доставки

	$Delivery = new Model_Delivery();
	$cond = array(
		"where" => "visible = 1",
		"order" => "prior desc",
	);

	$delivery = $Delivery->getall($cond);
	$view->delivery = $delivery;

	$view->bc["/".$args[0]] = $labels["delivery"];

	echo $view->render('head.php');
	echo $view->render('delivery/list.php');
	echo $view->render('foot.php');
