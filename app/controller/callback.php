<?php
$phone = $_POST['phone'] ? $_POST['phone'] : $_GET['phone'];
$name = $_POST['name'] ? $_POST['name'] : $_GET['name'];

if (!empty($phone)) {
//	mail("alex.suleymanov@gmail.com", "CallBack", "Перезвоните: ".$phone."(".$name.")", "Content-type:text/html; charset=utf-8");
	mail($sett['stuffemail'], "CallBack", "Перезвоните: ".$phone."(".$name.")", "Content-type:text/html; charset=utf-8");
}

echo "Ваш запрос отправлен!\nНаш специалист перезвонит в ближайшее время";

