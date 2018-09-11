<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Валюта";
	$model = "Model_Valuta";
	$default_order = "id";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----
	$show_cond = array();

	function showhead() {
	}

	function onshow($row) {
		return $row;
	}

	$fields = array(
		'name' => array(
			'label' => "Обозначение",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'short' => array(
			'label' => "Название",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'course' => array(
			'label' => "Курс к основной валюте",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'visible' => array(
			'label' => "Отображать на сайте",
			'type' => 'checkbox',
			'value' => 1,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'main' => array(
			'label' => "Основная валюта",
			'type' => 'checkbox',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
	);

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");