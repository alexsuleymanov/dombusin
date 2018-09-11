<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Значения характеристик";
	$model = "Model_Charval";
	$default_order = "id";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$cat = 0 + $_GET[cat];
	$char_cat = 0 + $_GET[char_cat];
	$char = 0 + $_GET[char];
	$prod = 0 + $_GET[prod];
	$id = 0 + $_GET[id];

	//---- SHOW ----
	$show_cond = array("where" => "`char` = '".data_base::nq($char)."'");

	function showhead() {
		global $url, $cat, $char, $opt;

		$Char = new Model_Char();
		$char = $Char->get($char);
		$str = "<h3>".$char->name."</h3><a href=\"adm_char.php".$url->gvar("char=&p=")."\"><-Назад</a><p>";

		return $str;
	}

	function onshow($row) {
		return $row;
	}

	$fields = array(
		'char' => array(
			'label' => "Характеристика",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'value' => array(
			'label' => "Значение",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'pic' => array(
			'label' => "Картинка",
			'type' => 'image',
			'location' => "../pic/charval",
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),		
		'prior' => array(
			'label' => "Приоритет",
			'type' => 'text',
			'value' => '0',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
	);

	$Char = new Model_Char();
	$rc = $Char->get($char);
	$fields["char"]["items"][$rc->id] = $rc->name;

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
		return $formfields;
	}

	
	require("lib/admin.php");