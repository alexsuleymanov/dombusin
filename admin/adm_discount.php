<?	require("adm_incl.php");

	//---- GENERAL ----

	$title = "Скидки";
	$model = "Model_Discount";
	$default_order = "nakop";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----

	$show_cond = array();

	function showhead() {
		return $ret;
	}

	function onshow($row) {
		global $url;
		
		return $row;
	}

	$fields = array(
		'name' => array(
			'label' => "Название",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 1,
		),
		'value' => array(
			'label' => "Размер скидки, %",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
		'nakop' => array(
			'label' => "Накопления",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
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
