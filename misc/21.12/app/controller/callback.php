<?
		Func::mailhtml("Pro-shop", "callback@dombusin.com", $sett['admin_email'], "CallBack", "Перезвоните: ".$_POST['phone']."(".$_POST['name'].") - ".$_POST['cont']);
//		Func::mailhtml("Pro-shop", "callback@pro-shop.com.ua", $sett['admin_email'], "CallBack", "Перезвоните: ".iconv("UTF-8", "WINDOWS-1251", $_POST['phone'])."(".iconv("UTF-8", "WINDOWS-1251", $_POST['name']).") - ".iconv("UTF-8", "WINDOWS-1251", $_POST['cont']));
//		Func::mailhtml("Pro-shop", "callback@pro-shop.com.ua", "alex.suleymanov@gmail.com", "CallBack", "Перезвоните: ".iconv("UTF-8", "WINDOWS-1251", $_POST['phone'])."(".iconv("UTF-8", "WINDOWS-1251", $_POST['name']).") - ".iconv("UTF-8", "WINDOWS-1251", $_POST['cont']));

//		echo "Ваш запрос отправлен!\nНаш специалист перезвонит в ближайшее время";
		die();

?>