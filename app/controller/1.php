<?
$form = new Form_Order();
$form->setAction("/1");

if ($_POST['subm']) {
	if ($form->isValid($_POST)) {
		print_r($_POST);
		die();
	} else {
		echo $view->render('head.php');
		$view->form = $form;
		echo $view->render('test/form.php');
		echo $view->render('foot.php');
		die();
	}
} else {
	echo $view->render('head.php');
	$view->form = $form;
	echo $view->render('test/form.php');
	echo $view->render('foot.php');
	die();
}


