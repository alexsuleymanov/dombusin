<?	require("adm_incl.php");

	//---- GENERAL ----

	$title = "Способы доставки";
	$model = "Model_Delivery";
	$default_order = "id";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----

	$show_cond = array();

	function showhead() {
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
		'pic1' => array(
			'label' => "Иконка",
			'comment' => "",
			'type' => 'image',
			'location' => "../pic/delivery",
			'width' => 100,
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'price' => array(
			'label' => "Цена доставки",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
		'cont' => array(
			'label' => "Описание",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
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
			'multylang' => 0,
		),
		'prior' => array(
			'label' => "Приоритет",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
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

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	require("lib/admin.php");
