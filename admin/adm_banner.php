<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Баннеры";
	$model = "Model_Banner";
	$default_order = "page";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----
	$show_cond = array();

	function showhead() {
	}

	function onshow($row) {
		if($row->page == 'all_pages') $row->page = "общий";
		if($row->page == '') $row->page = "главная";

		return $row;
	}

	$fields = array(
		'page' => array(
			'label' => "Страница",
			'type' => 'text',
			'value' => "all_pages",
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'position' => array(
			'label' => "Позиция",
			'type' => 'select',
			'items' => array(
				"1" => "верхний",
				"2" => "левый",
				"3" => "правый",
			),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'cont' => array(
			'label' => "Содержимое",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
	);

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");