<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Пользователи";
	$model = "Model_User";
	$model_type = $_GET['usertype'];
	$default_order = "created";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;
	$opt = $_GET['opt'];

	//---- SHOW ----
	if($model_type == 'manager')
		$show_cond = array("where" => "`type` = '".data_base::nq($model_type)."'");
	else
		$show_cond = array("where" => "`type` = '".data_base::nq($model_type)."' and opt = '$opt'");

	function showhead() {
		return $ret;
	}

	function onshow($row) {
		extract($GLOBALS);
		if($_GET['type'] == 'manager')
			$row->orders = "<div align=center><a href=\"adm_order.php?manager=".$row->id."\"> [Заказы] </a></div>";
		elseif($_GET['type'] == 'client')
			$row->orders = "<div align=center><a href=\"adm_order.php?user=".$row->id."\"> [Заказы] </a></div>";

		$Order = new Model_Order($row->id);
		$Order->cart->amount();
		$Discount = new Model_Discount();
		$ordersum = $Order->total($row->id);
		$skidka = 0 + $Discount->getnakop($ordersum);
		$row->order_num = "<nobr>".$Order->num($row->id)." заказов<br />".$ordersum." грн.<br />Скидка: ".$skidka."%</nobr>";

		return $row;
	}

	$fields = array(
		'created' => array(
			'label' => "Зарегистрирован",
			'type' => 'date',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
		'pass' => array(
			'label' => "Пароль",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'email' => array(
			'label' => "E-mail",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
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
			'multylang' => 1,
		),
		'surname' => array(
			'label' => "Фамилия",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'city' => array(
			'label' => "Город",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'address' => array(
			'label' => "Адрес",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 1,
		),
		'phone' => array(
			'label' => "Телефон",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
/*		'www' => array(
			'label' => "Адрес сайта",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'icq' => array(
			'label' => "ICQ",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'skype' => array(
			'label' => "Skype",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
*/
		'opt' => array(
			'label' => "Оптовый",
			'type' => 'checkbox',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'miniopt' => array(
			'label' => "Возможна розница",
			'type' => 'checkbox',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),		
		'order_num' => array(
			'label' => "Заказов",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'sort' => 0,
			'filter' => 0,
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
		'visible' => array(
			'label' => "Активен",
			'type' => 'checkbox',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
		'color' => array(
			'label' => "Цвет",
			'type' => 'color',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'type' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"type\" value=\"".$model_type."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
	);
	
	if($model_type == 'manager'){
		unset($fields['pass']);
		unset($fields['city']);
		unset($fields['address']);
	}else{
		unset($fields['color']);
	}
	
	$Manager = new Model_User('manager');
	$managers = $Manager->getall(array("where" => "1", "order" => "surname"));
	$fields['manager']['items'][0] = 'Нет';
	foreach($managers as $r) $fields['manager']['items'][$r->id] = $r->name." ".$r->surname;
	
	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}
	
	require("lib/admin.php");