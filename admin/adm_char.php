<?	require("adm_incl.php");
	//---- GENERAL ----

	$char_types = array(
		1 => "есть/нет",
		2 => "число",
		4 => "набор значений",
		5 => "набор значений от/до",
	);

	$title = "Характеристики";
	$model = "Model_Char";
	$default_order = "prior";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$cat = 0 + $_GET[cat];
	$char_cat = 0 + $_GET[charcat];
	$prod = 0 + $_GET[prod];
	$id = 0 + $_GET[id];

	//---- SHOW ----
	if($opt['char_cats'])
		$show_cond = array("where" => "charcat = '".data_base::nq($char_cat)."'");
	elseif($opt['prod_cats'])
		$show_cond = array("where" => Model_Cat::cat_tree($cat));
	else
		$show_cond = array();

	function showhead() {
		global $url, $cat, $char_cat, $opt;

		if($opt['char_cats']){
			$CharCat = new Model_CharCat();
			$char_cat = $CharCat->get($char_cat);
    		$str = "<h3>".$char_cat->name."</h3><a href=\"adm_charcat.php".$url->gvar("char_cat=&p=")."\"> <- Назад</a><p>";
		}elseif($opt['prod_cats']){
			$Cat = new Model_Cat();
			$cat = $Cat->get($cat);
	    	$str = "<h3>".$cat->name."</h3><a href=\"adm_cat.php".$url->gvar("cat=".$rc->par."&p=")."\"> <- Назад</a><p>";
		}

		$Char = new Model_Char();
		$Char->delete_empty_vals();

		return $str;
	}

	function onshow($row) {
		global $title, $char_types, $url, $opt;

		if($row->type == 4 || $row->type == 5)
			$row->values = "<div align=center><a href=\"adm_charval.php".$url->gvar("p=&char=".$row->id)."\">&gt;&gt;&gt;</a></div>";
		$row->type = $char_types[$row->type];

		return $row;
	}

	$fields = array(
		'charcat' => array(
			'label' => "Категория характеристик",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'cat' => array(
			'label' => "Категория",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'name' => array(
			'label' => "Заголовок",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
        'izm' => array(
			'label' => "Ед. изм.",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
        'type' => array(
			'label' => "Тип",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
        'incat' => array(
			'label' => "Отображать в каталоге",
			'type' => 'checkbox',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
        'search' => array(
			'label' => "Поиск",
			'type' => 'checkbox',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
        'prior' => array(
			'label' => "Приоритет",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
        'values' => array(
			'label' => "Значения",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
	);

	if($opt["char_cats"]){
		if($char_cat){
			$Char_Cat = new Model_CharCat();
			$rc = $Char_Cat->get($char_cat);
			$fields["charcat"]["items"][$rc->id] = $rc->name;
		}else{
			$fields["charcat"]["items"][0] = "Нет";
		}
	}else{
		unset($fields["charcat"]);
	}

	if($opt["prod_cats"]){
		if($cat){
			$Cat = new Model_Cat();
			$rc = $Cat->get($cat);
			$fields[cat][items][$rc->id] = $rc->name;
		}else{
			$fields[cat][items][0] = "Общая";
		}
	}else{
		unset($fields["cat"]);
	}

	foreach($char_types as $k => $v){
		$fields["type"]["items"][$k] = $v;
	}

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
		return $formfields;
	}

	
	require("lib/admin.php");