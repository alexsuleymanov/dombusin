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

	//---- SHOW ----
	$show_cond = array();

	function showhead() {
	}

	function onshow($row) {
		global $title, $cat, $url, $opt, $valuta;

		$Order = new Model_Order($row->id);
		$Order->recount();

		
		$row->prods = "<a href=\"adm_ordercart.php?order_id=".$row->id."\"> [Содержимое] </a>";
		$row->export = "<a href=\"".$url->gvar("export=1&id=".$row->id)."\" target=\"_blank\"> [Экспорт CSV] </a>";
		$row->export2 = "<a href=\"".$url->gvar("export2=1&id=".$row->id)."\" target=\"_blank\"> [Экспорт CSV2] </a>";
		$row->sum = Func::fmtmoney($Order->to_pay)."грн.";
		if($row->manager){
			$Manager = new Model_User('manager', $row->manager);
			$manager = $Manager->get();

			$row->manager = ($manager->id) ? "<font color=\"#".$manager->color."\">".$manager->name." ".$manager->surname."</font>" : $row->manager;
		}
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
		'user' => array(
			'label' => "Заказчик",
			'type' => 'custom',
			'content' => "<a href=\"adm_user.php?usertype=client&action=edit&id=".$order->user."\" target=\"_blank\">Просмотреть</a><input type=\"hidden\" name=\"user\" value=\"".$order->user."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
/*		'esystem' => array(
			'label' => "Способ оплаты",
			'type' => 'select',
			'items' => array(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
*/
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
		'status' => array(
			'label' => "Статус",
			'type' => 'select',
			'items' => array(
				1 => 'отправлен',
				2 => 'собран',
				3 => 'доставлен',
				4 => 'обрабатывается',
				5 => 'собирается',
				6 => 'отменен',
				7 => 'оплачен',
			),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
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
		'shop' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"shop\" value=\"".Zend_Registry::get('shop_id')."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 1,
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
	);

	$Esystem = new Model_Esystem();
	$esystems = $Esystem->getall(array("where" => "visible = 1", "order" => "name"));
	foreach($esystems as $r) $fields['esystem']['items'][$r->id] = $r->name;

	$Delivery = new Model_Delivery();
	$deliveris = $Delivery->getall(array("where" => "visible = 1", "order" => "name"));
	foreach($deliveris as $r) $fields['delivery']['items'][$r->id] = $r->name;

	$Manager = new Model_User('manager');
	$managers = $Manager->getall(array("where" => "1", "order" => "surname"));
	foreach($managers as $r) $fields['manager']['items'][$r->id] = $r->name." ".$r->surname;

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
		global $templates;

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