<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Пользователи";
	$model = "Model_User";
	$model_type = $_GET['usertype'];
	$default_order = "name";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----
	$show_cond = array("where" => "`type` = '".data_base::nq($model_type)."'");

	function showhead() {
		return $ret;
	}

	function onshow($row) {
		extract($GLOBALS);

		return $row;
	}

	$fields = array(
/*		'login' => array(
			'label' => "Логин",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
*/
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
		'shop' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"shop\" value=\"".Zend_Registry::get('shop_id')."\">",
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
	
	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}
	
	require("lib/admin.php");