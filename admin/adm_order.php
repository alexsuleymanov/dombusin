<?	require("adm_incl.php");
	require("adm_order_act.php");
	$user_code = "adm_order_out.php";

	//---- GENERAL ----

	$title = "Заказы";
	$model = "Model_Order";
	$default_order = "id";
		
	$can_add = 0;
	$can_del = 1;
	$can_edit = 1;

	$id = 0 + $_GET['id'];
	$Model = new $model($id);
	$order = $Model->get();
	$opt = 0 + $_GET['opt'];

	//---- SHOW ----
	if($opt)
		$show_cond = array("where" => "opt = 1");
	else
		$show_cond = array();

	function showhead() {
		$str = "<p align=\"right\"><input type=\"button\" value=\"Экспорт\" onclick=\"$('#massform').attr('target', '_blank'); $('#massform').attr('action', '?action=mass_export'); $('#massformsubmit').click();\"></p><br><br>";
		return $str;
	}

	function onshow($row) {
		global $title, $cat, $url, $opt, $valuta;

		$Order = new Model_Order($row->id);
		
		$row->prods = "<a href=\"adm_ordercart.php?order_id=".$row->id."\"> [Содержимое] </a>";
		$row->export = "<a href=\"".$url->gvar("export=1&id=".$row->id)."\" target=\"_blank\"> [Экспорт CSV] </a>";
		$row->export2 = "<a href=\"".$url->gvar("export2=1&id=".$row->id)."\" target=\"_blank\"> [Экспорт CSV2] </a>";
		$row->change_user = "<a href=\"".$url->gvar("change_user=1&order_id=".$row->id)."\"> [Сменить заказчика] </a>";
		$row->sum = Func::fmtmoney($Order->cart->amount())."грн.";
		if($row->manager){
			$Manager = new Model_User('manager', $row->manager);
			$manager = $Manager->get();

			$row->manager = ($manager->id) ? "<font color=\"#".$manager->color."\">".$manager->name." ".$manager->surname."</font>" : $row->manager;
		}

		$User = new Model_User('client', $row->user);
		$user = $User->get();
		if($user->opt) $row->name .= "<br /><font color=\"green\">Оптовик</font>";
		
//		$row->tstamp = $r;
		return $row;
	}

	$fields = array(
		'id' => array(
			'label' => "Номер заказа",
			'type' => 'custom',
			'content' => "#".$id."<input type=\"hidden\" name=\"id\" value=\"".$id."\">",
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
/*		'user' => array(
			'label' => "Заказчик",
			'type' => 'select',
			'items' => array(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),*/
		'username' => array(
			'label' => "Анкета заказчика",
			'type' => 'custom',
			'content' => "<a href=\"adm_user.php?usertype=client&action=edit&id=".$order->user."\" target=\"_blank\">Просмотреть</a><input type=\"hidden\" name=\"user\" value=\"".$order->user."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'name' => array(
			'label' => "Имя",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'sum' => array(
			'label' => "Сумма заказа",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'tstamp' => array(
			'label' => "Дата",
			'type' => 'date',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
		'addr' => array(
			'label' => "Адрес",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'city' => array(
			'label' => "Город",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'state' => array(
			'label' => "Область",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'phone' => array(
			'label' => "Телефон",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'email' => array(
			'label' => "E-mail",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'comment' => array(
			'label' => "Комментарий",
			'type' => 'textarea',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
/*		'payment_method' => array(
			'label' => "Способ оплаты",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
*/
		'esystem' => array(
			'label' => "Способ оплаты",
			'type' => 'select',
			'items' => array(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'delivery' => array(
			'label' => "Способ доставки",
			'type' => 'select',
			'items' => array(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'manager' => array(
			'label' => "Менеджер",
			'type' => 'select',
			'items' => array(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'sklad' => array(
			'label' => "Номер склада",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'needcall' => array(
			'label' => "Нужен звонок",
			'type' => 'checkbox',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'status' => array(
			'label' => "Статус",
			'type' => 'select',
			'items' => array(
				1 => 'отправлен (1)',
				2 => 'собран (2)',
				3 => 'доставлен (3)',
				4 => 'обрабатывается (4)',
				5 => 'собирается (5)',
				6 => 'отменен (6)',
				7 => 'оплачен (7)',
				8 => 'недооформлен (8)',
			),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'informclient' => array(
			'label' => "Уведомить клиента",
			'type' => 'checkbox',
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
/*		'prods' => array(
			'label' => "Содержимое заказа",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
*/
/*		'export' => array(
			'label' => "Экспорт в CSV",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),*/
		'export2' => array(
			'label' => "Экспорт в CSV2",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
		'change_user' => array(
			'label' => "Сменить заказчика",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
	);

	$Esystem = new Model_Esystem();
	$esystems = $Esystem->getall(array("where" => "visible = 1", "order" => "name"));
	foreach($esystems as $r) $fields['esystem']['items'][$r->id] = $r->name;

	$Delivery = new Model_Delivery();
	$deliveris = $Delivery->getall(array("where" => "visible = 1", "order" => "name"));
	foreach($deliveris as $r) $fields['delivery']['items'][$r->id] = $r->name;

	$Manager = new Model_User('manager');
	$managers = $Manager->getall(array("where" => "`type` = 'manager' and visible = 1", "order" => "surname"));
	$fields['manager']['items'][0] = "Нет";
	foreach($managers as $r) $fields['manager']['items'][$r->id] = $r->name." ".$r->surname;
	
/*	$User = new Model_User('client');
	$users = $User->getall(array("order" => "surname"));
//	$fields['manager']['items'][0] = "Нет";
	foreach($users as $r) $fields['user']['items'][$r->id] = $r->name." ".$r->surname;*/

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
		global $templates;

		$User = new Model_User('client');
		$User->update(array("manager" => $_POST['manager']), array("where" => "id = ".$_POST['user']));		

		if($_POST['status'] == 6){
			$Cart = new Model_Cart();
			$cart = $Cart->getall(array("where" => "`order` = ".$id));
			foreach($cart as $v){
				$Prod = new Model_Prod($v->prod);
				$prod = $Prod->get();
				$Prod->save(array(
					"num" => ($prod->num + $v->num)
				));
			}
		}
		
		if($_POST['informclient']){
			$status = array(
				1 => 'отправлен',
				2 => 'собран',
				3 => 'доставлен',
				4 => 'обрабатывается',
				5 => 'собирается',
				6 => 'отменен',
				7 => 'оплачен',
			);

			$Order = new Model_Order($id);
			$order = $Order->get();

			$params = array(
				"order_id" => $order->id,
				"order_time" => date("d.m.Y (G:i)", $order->tstamp),
				"order_status" => $status[$order->status],
			);

			$mess = Func::mess_from_tmp($templates["order_status_message_template"], $params);
			@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $order->email, "Статус заказ изменен", $mess);			
		}
	}
	
	require("lib/admin.php");