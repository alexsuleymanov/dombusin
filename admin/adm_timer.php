<?	require("adm_incl.php");
	//---- GENERAL ----
//sfgasdgsag
	$title = "Акции. Таймер";
	$model = "Model_Timer";
//	$model_type = "actions";
	$default_order = "end";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$par = 0 + $_GET[par];

	//---- SHOW ----
	$show_cond = array();

	function showhead() {
	}

	function onshow($row) {
		extract($GLOBALS);
		return $row;
	}

	$fields = array(
		'end' => array(
			'label' => "Дата окончания",
			'type' => 'date',
			'value' => time(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
		'pic' => array(
			'label' => "Картинка",
			'type' => 'image',
			'location' => "../pic/timer",
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'pic2' => array(
			'label' => "Фон",
			'type' => 'image',
			'location' => "../pic/timerbg",
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),		
		'name' => array(
			'label' => "Название",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'href' => array(
			'label' => "Ссылка на страницу",
			'type' => 'text',
			'show' => 0,
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
