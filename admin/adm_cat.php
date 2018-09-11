<?	require("adm_incl.php");
	require("adm_cat_act.php");
	$user_code = "adm_cat_out.php";

	//---- GENERAL ----

	$title = "Категории";
	$model = "Model_Cat";
	$default_order = "prior";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$cat = 0 + $_GET[cat];

	//---- SHOW ----
	$show_cond = array("where" => "cat = '".data_base::nq($cat)."'");

	function showhead() {
		global $url, $cat;

		$Cat = new Model_Cat();
		$cat = $Cat->get($cat);
		$str .= "<h3>".$cat->name."</h3>";

		$back = $cat->cat;
		if(isset($back))
			$str .= "<a href=\"adm_cat.php".$url->gvar("cat=".$back."&p=")."\"><- Назад</a><br><br>";

		return $str;
	}

	function onshow($row) {
		global $title, $cat, $url, $opt;

		if($opt["cat_tree"]){
			$row->subcat = "<div align=center><a href=\"adm_cat.php".$url->gvar("start=&cat=".$row->id)."\"> [Подкатегории] </a></div>";
		}

/*		if($opt["char_cats"] && $opt["prod_chars"]){
			$row->char = "<div align=center><a href=\"adm_charcat.php".$url->gvar("start=&cat=".$row->id)."\"> [Характеристики] </a></div>";
		}elseif($opt["prod_chars"]){
			$row->char = "<div align=center><a href=\"adm_char.php".$url->gvar("start=&cat=".$row->id)."\"> [Характеристики] </a></div>";			
		}
*/
		$row->prod = "<div align=center><a href=\"adm_prod.php".$url->gvar("start=&cat=".$row->id)."\"> [Товары] </a></div>";
		$row->pages = "<div align=center><a href=\"adm_catpage.php".$url->gvar("start=&cat=".$row->id)."\"> [Метки] </a></div>";

		return $row;
	}

	$fields = array(
		'cat' => array(
			'label' => "Родительская",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
		'intname' => array(
			'label' => "Имя для URL",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'name' => array(
			'label' => "Заголовок для меню",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 1,
		),
		'pic' => array(
			'label' => "Иконка",
			'type' => 'image',
			'location' => "../pic/cat",
			'width' => 300,
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
        'short' => array(
			'label' => "Кратко",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
        'cont2' => array(
			'label' => "Текст до товаров",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
        'cont' => array(
			'label' => "Текст после товаров",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
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
        'delim' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<h2 align=center>Параметры для оптимизации</h2><hr>",
			'show' => 0,
			'edit' => 1,
			'set' => 0,
		),
		'title' => array(
			'label' => "Заголовок &lt;title&gt;",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
		'h1' => array(
			'label' => "Заголовок &lt;H1&gt;",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
		'kw' => array(
			'label' => "Keywords",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
		'descr' => array(
			'label' => "Description",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
		'pages' => array(
			'label' => "Метки",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
		),
	);

	if($opt['cat_tree']){
		$fields['subcat'] = array(
			'label' => "Подкатегории",
			'type' => 'text',
			'value' => "",
			'show' => 1,
			'edit' => 0,
			'set' => 0,
		);
	}else{
		unset($fields["subcat"]);
	}

	if(!$opt['prod_chars']){
		$fields['char'] = array(
			'label' => "Характеристики",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
		);
	}else{
		unset($fields["char"]);
	}

	if($opt['prods']){
		$fields['prod'] = array(
			'label' => "Товары",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
		);
	}else{
		unset($fields["prod"]);
	}

	if($opt["cat_tree"]){
		if($cat){
			$Cat = new Model_Cat();
			$cats = $Cat->getall(array("where" => "id = $cat"));
			foreach($cats as $k => $r) $fields['cat']['items'][$r->id] = $r->name;
		}else{
			$fields["cat"]["items"][0] = "Нет";
		}
	}else{
		unset($fields["cat"]);
	}

	//---- DEL ----
	function ondel($id) {
		global $outputcache;
		$outputcache->remove('catmenu');
		$outputcache->remove('catmenua');
	}

	//---- SET ----
	function onset($id) {
		extract($GLOBALS);
		
		$outputcache->remove('catmenu');
		$outputcache->remove('catmenua');
		
		$Cat = new Model_Cat($id);
		$cat = $Cat->get($id);
//		$Cat->visibility($id, $cat->visible);
		$Catchar = new Model_Catchar();

		$cc = array();

		foreach($_POST as $k => $v) {
			if (preg_match("/^char_(\d+)$/", $k, $m)) $cc[$m[1]]['char'] = $v;
			if (preg_match("/^prior_(\d+)$/", $k, $m)) $cc[$m[1]]['prior'] = $v;
		}

		$Cat->clearcatchars();

		foreach($cc as $k => $v){
			if(empty($v['char'])) continue;
			$Catchar->insert(array(
				"cat" => $id,
				"char" => $v['char'],
				"prior" => $v['prior'],
			));
		}
	}

	
	require("lib/admin.php");