<?
	set_time_limit(0);
	ob_implicit_flush(1);

//	header("Content-Type: text/html; charset=windows-1251");
//	header("Content-Type: text/html; charset=utf-8");
	include("adm_incl.php");

	if($_GET['unisender']){
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=unisender.csv");

		$User = new Model_User('client');
		$Order = new Model_Order();

		$users = $User->getall(array());
//		$line0 = iconv("UTF-8", "WINDOWS-1251", "\"E-mail\";\"Ф.И.О.\";\"Дата последнего заказа\"\n");
//		echo $line0;

		foreach($users as $user){
			$order = $Order->getone(array("where" => "`user` = ".$user->id."", "order" => "tstamp desc"));
			$line = "\"".iconv("UTF-8", "WINDOWS-1251", $user->email)."\";\"".iconv("UTF-8", "WINDOWS-1251", $user->surname." ".$user->name)."\";\"".date("d.m.Y", $order->tstamp)."\"\n";
			echo $line;
		}
		die();
	}

	if($_GET['xml']){
		$url->redir("/price/xml/admin");
	}
	
	echo $view->render('head.php');

?>
<div style="margin: 20px;">
<h2>Экспорт Юнисендер</h2>
<form action="" method="get">
	<input type="submit" name="unisender" value="Экспортировать" />
</form>
</div>

<div style="margin: 20px;">
<h2>Экспорт XML</h2>
<form action="" method="get">
	<input type="submit" name="xml" value="Экспортировать" />
</form>
</div>

	<?
	echo $view->render('foot.php');