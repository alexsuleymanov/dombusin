<?
	header("HTTP/1.0 404 Not Found");

	$view->cont = "<font color=\"red\">".$labels["404"]."</font>";

	echo $view->render("head.php");
	echo $view->render("404.php");
	echo $view->render("foot.php");
