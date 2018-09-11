<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Шаблоны";
	$model = "Model_Template";
	$default_order = "id";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----
	if($_GET["type"])
		$show_cond = array("where" => "`type` = '".data_base::nq($_GET["type"])."'");
	else
		$show_cond = array("where" => "`type` = ''");

	function showhead() {
	}

	function onshow($row) {
		return $row;
	}

	$fields = array(
		'intname' => array(
			'label' => "Внутренее имя",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
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
		'pic' => array(
			'label' => "Иконка",
			'comment' => "100x70",
			'width' => 100,
			'htight' => 70,
			'type' => 'image',
			'location' => "../pic/template",
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
        'short' => array(
			'label' => "Кратко",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
			'admin_level' => 2,
		),
        'cont' => array(
			'label' => "Шаблон",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
			'admin_level' => 2,
		),
		'type' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"type\" value=\"".$_GET['type']."\">",
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

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");