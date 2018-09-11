<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Посадочные страницы";
	$model = "Model_Catpage";
	$default_order = "id";
	$default_desc_asc = "asc";
		
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
		$str .= "<h3>".$cat->name." для ...</h3>";

		$back = $cat->cat;
		if(isset($back))
			$str .= "<a href=\"adm_cat.php".$url->gvar("cat=".$back."&p=")."\"><- Назад</a><br><br>";

		return $str;
	}

	function onshow($row) {
/*		$Cat = new Model_Cat();
		$cat = $Cat->get($_GET['cat']);

		$Brand = new Model_Brand();
		$brand = $Brand->get($row->brand);

	//	$intname = "http://angelex.com.ua/catalog/cat-".$_GET['cat']."-".$cat->intname;
	//	if($row->brand) $intname .= "/brand-".$row->brand."-".$brand->intname;

	//	$row->intname = "<a href=\"".$intname."\" target=\"_blank\">".$intname."</a>";*/
		$row->intname = "http://www.dombusin.com".$row->intname;
		return $row;
	}

	$fields = array(
		'cat' => array(
			'label' => "Категория",
			'type' => 'select',
			'items' => array(),
			'show' => 1,
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
        'cont' => array(
			'label' => "Содержимое до",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
		'cont2' => array(
			'label' => "Содержимое после",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
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
		'bc' => array(
			'label' => "Хлебные крошки",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 1,
		),
	);

	$Cat = new Model_Cat();
	$cats = $Cat->getall(array("where" => "id = $cat"));
	foreach($cats as $k => $r) $fields['cat']['items'][$r->id] = $r->name;

/*	$Brand = new Model_Brand();
	$brands = $Brand->getall(array("order" => "name"));
	$fields['brand']['items'][0] = "Нет";
	foreach($brands as $k => $r) $fields['brand']['items'][$r->id] = $r->name;
*/
	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
		/*
		$Cat = new Model_Cat($id);
		$cat = $Cat->get($id);
		$Cat->visibility($id, $cat->visible);
		*/
	}

	
	require("lib/admin.php");