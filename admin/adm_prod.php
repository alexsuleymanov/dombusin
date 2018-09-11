<?	require("adm_incl.php");
	require("adm_prod_act.php");
	$user_code = "adm_prod_out.php";
	//---- GENERAL ----

	set_time_limit(0);
	
	$title = "Товары";
	$model = "Model_Prod";
	$default_order = "num";
	$default_descasc = "desc";
	
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;
	$resulte = 100;

	$cat = 0 + $_GET[cat];
	$brand = 0 + $_GET[brand];
	$id = 0 + $_GET[id];

	//---- SHOW ----
	$show_cond = array("where" => "1");
//	if($cat) $show_cond["where"] .= " and cat = '$cat'";
/*	if ($_GET['cat'] == -1) {
		$Prod = new Model_Prod();
		$ids = $Prod->getneraspids();
		print_r($ids);
		$show_cond["where"] .= " and id in (".implode(",", $ids).")";
	}*/
	
	if (isset($_GET['cat'])) $show_cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'");
	if ($brand) $show_cond["where"] .= " and brand = '$brand'";

	$Prod = new Model_Prod();
	$Prod->setpop();

	function showhead() {
		global $url, $cat, $char_cat, $opt, $view;

		if($cat){
			$Cat = new Model_Cat($cat);
			$cat = $Cat->get($cat);
			$str = "<h3>".$cat->name."</h3><a href=\"adm_cat.php".$url->gvar("order=&desc_asc=&brand=&cat=".$cat->par."&start=")."\"> <- Назад</a><p>";			
		}
		$str .= $view->render('prod/massedit.php');
//		$str .= $view->render('menu.php');
//		if($opt['prod_chars']){
//			$Char = new Model_Char();
//			$Char->delete_empty_vals();
//		}

		return $str;
	}

	function onshow($row) {
		global $url, $opt;

		$row->photos = "<a href=\"adm_photo.php".$url->gvar("start=&type=prod&par=".$row->id)."\"> [Фотографии] </a>";
		$row->comments = "<a href=\"adm_comments.php".$url->gvar("start=&type=prod&par=".$row->id)."\"> [Отзывы] </a>";

		return $row;
	}
	
	function onedit($row) {
		global $url, $opt;
		
//		error_reporting(E_ERROR);
//		ini_set("display_errors", 1);
		
/*		$row->numdiscount = $row->numdiscount ? $row->numdiscount) : "";
		$row->numdiscount2 = $row->numdiscount2 ? $row->numdiscount2) : "";
		$row->numdiscount3 = $row->numdiscount3 ? $row->numdiscount3) : "";
		$row->numdiscount4 = $row->numdiscount4 ? $row->numdiscount4 : "";
		
		$row->numdiscountopt = $row->numdiscountopt ? Func::skidka_admin($row->numdiscountopt) : "";
		$row->numdiscountopt2 = $row->numdiscountopt2 ? Func::skidka_admin($row->numdiscountopt2) : "";
		$row->numdiscountopt3 = $row->numdiscountopt3 ? Func::skidka_admin($row->numdiscountopt3) : "";
		$row->numdiscountopt4 = $row->numdiscountopt4 ? Func::skidka_admin($row->numdiscountopt4) : "";
*/		
		return $row;
	}

	$fields = array(
/*		'cat' => array(
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
		'brand' => array(
			'label' => "Бренд",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
*/
		'pic2' => array(
			'label' => "Большое фото",
			'comment' => "",
			'width' => 500,
			'type' => 'image',
			'ftype' => 'jpg',
			'location' => "../pic/prod",
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'art' => array(
			'label' => "Артикул",
			'type' => 'text',
			'value' => '',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'pic' => array(
			'label' => "Фото",
			'type' => 'text',
			'value' => '',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
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
		'delim2' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<h2 align=center>Упаковка 1</h2><hr>",
			'show' => 0,
			'edit' => 1,
			'set' => 0,
		),
		'price' => array(
			'label' => "Цена",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'priceopt' => array(
			'label' => "Цена Опт",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'skidka' => array(
			'label' => "Скидка",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'numdiscount' => array(
			'label' => "Скидка от кол-ва",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'skidkaopt' => array(
			'label' => "Скидка оптовая",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'numdiscountopt' => array(
			'label' => "Скидка от кол-ва опт",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'weight' => array(
			'label' => "Вес",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'inpack' => array(
			'label' => "В упаковке",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'num' => array(
			'label' => "Остаток",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'delim6' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<h2 align=center>Упаковка 2</h2><hr>",
			'show' => 0,
			'edit' => 1,
			'set' => 0,
		),
		'price2' => array(
			'label' => "Цена",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'priceopt2' => array(
			'label' => "Цена Опт",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'skidka2' => array(
			'label' => "Скидка",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'numdiscount2' => array(
			'label' => "Скидка от кол-ва",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'skidkaopt2' => array(
			'label' => "Скидка оптовая",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'numdiscountopt2' => array(
			'label' => "Скидка от кол-ва опт",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'weight2' => array(
			'label' => "Вес",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'inpack2' => array(
			'label' => "В упаковке",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'num2' => array(
			'label' => "Остаток",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'delim3' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<h2 align=center>Упаковка 3</h2><hr>",
			'show' => 0,
			'edit' => 1,
			'set' => 0,
		),
		'price3' => array(
			'label' => "Цена",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'priceopt3' => array(
			'label' => "Цена Опт",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'skidka3' => array(
			'label' => "Скидка",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'numdiscount3' => array(
			'label' => "Скидка от кол-ва",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'skidkaopt3' => array(
			'label' => "Скидка оптовая",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'numdiscountopt3' => array(
			'label' => "Скидка от кол-ва опт",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'weight3' => array(
			'label' => "Вес",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'inpack3' => array(
			'label' => "В упаковке",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'num3' => array(
			'label' => "Остаток",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'delim4' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<h2 align=center>Упаковка 4</h2><hr>",
			'show' => 0,
			'edit' => 1,
			'set' => 0,
		),
		'price4' => array(
			'label' => "Цена",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'priceopt4' => array(
			'label' => "Цена Опт",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'skidka4' => array(
			'label' => "Скидка",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'numdiscount4' => array(
			'label' => "Скидка от кол-ва",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'skidkaopt4' => array(
			'label' => "Скидка оптовая",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'numdiscountopt4' => array(
			'label' => "Скидка от кол-ва опт",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'weight4' => array(
			'label' => "Вес",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'inpack4' => array(
			'label' => "В упаковке",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'num4' => array(
			'label' => "Остаток",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'delim5' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<h2 align=center>Описание</h2><hr>",
			'show' => 0,
			'edit' => 1,
			'set' => 0,
		),
		'short' => array(
			'label' => "Краткое описание",
			'comment' => "",
			'type' => 'textarea',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 1,
		),
		'cont' => array(
			'label' => "Полное описание",
			'comment' => "",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 1,
		),
        'cats' => array(
			'label' => 'Категории',
			'type' => 'multiselecttree',
			'relation' => 'cat-prod',
			'obj-rel' => 'relation',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'action' => array(
			'label' => "Акция",
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
			'filter' => 0,
			'multylang' => 0,
		),
        'prior' => array(
			'label' => "Приоритет",
			'type' => 'text',
			'value' => 0,
			'show' => 0,
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
			'set' => 0,
			'sort' => 1,
			'multylang' => 0,
		),
		'main' => array(
			'label' => "На главной",
			'type' => 'checkbox',
			'value' => 1,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
        'new' => array(
			'label' => "Новый товар",
			'type' => 'checkbox',
			'value' => 1,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
        'pop' => array(
			'label' => "Популярный товар",
			'type' => 'checkbox',
			'value' => 1,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
        'mix' => array(
			'label' => "Микс",
			'type' => 'checkbox',
			'value' => 0,
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
/*		'photos' => array(
			'label' => "Фотографии",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
		'comments' => array(
			'label' => "Отзывы",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
*/
	);

	if(!$opt["prod_photos"]){
		unset($fields["photos"]);
	}

	if(!$opt["prod_comments"]){
		unset($fields["comments"]);
	}

	if(!$opt["prod_brands"]){
		unset($fields["brand"]);
	}

	$Action = new Model_Page('actions');
	$rows = $Action->getall(array("order" => "name desc"));
	$fields["action"]["items"][0] = "Нет";
	foreach($rows as $k => $r) $fields["action"]["items"][$r->id] = $r->name;
	
	if($opt["prod_cats"]){
		$Cat = new Model_Cat();
		$rows = $Cat->getall(array("where" => "id = $cat"));
//		$rows = $Cat->getall(array("order" => "name desc"));
		foreach($rows as $k => $r) $fields["cat"]["items"][$r->id] = $r->name;
	}else{
		unset($fields["cat"]);
	}

	if($opt["prod_brands"]){
		$Brand = new Model_Brand();
		$rows = $Brand->getall(array("order" => "name desc"));
		foreach($rows as $k => $r) $fields["brand"]["items"][$r->id] = $r->name;
	}else{
		unset($fields["brand"]);
	}

	$Cat = new Model_Cat();
	$rc = $Cat->getall(array("order" => "name"));
	foreach($rc as $k => $v){
		$fields['cats']['items'][] = array("id" => $v->id, "par" => $v->cat, "name" => $v->name);
	}

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function beforeset($id) {
		$Prod = new Model_Prod($id);
		$prod = $Prod->get($id);

		if(($prod->visible == 0 && $_POST['visible'] == 1) || ($prod->num == 0 && $_POST['num'] > 0)){
			$data = array("changed" => time(), "visible" => 1, "num" => $_POST['num']);
			$Prod->save($data);
		}elseif($_POST['visible'] == 0){
			$data = array("visible" => 0);
			$Prod->save($data);
		}
	}

	function onset($id) {
		extract($GLOBALS);
		if($_GET['cat']) $outputcache->remove('extsearch'.$_GET['cat']);
		
		$pc = array();
		$pv = array();

		foreach($_POST as $k => $v) {
			if (preg_match("/^charval_(\d+)$/", $k, $m)) $pc[$m[1]][val] = $v;
			if (preg_match("/^charval2_(\d+)$/", $k, $m)) $pc[$m[1]][value] = ($v) ? $v : '';
			if (preg_match("/^var_(\d+)_title$/", $k, $m)) $pv[$m[1]][title] = ($v) ? $v : '';
			if (preg_match("/^var_(\d+)_price$/", $k, $m)) $pv[$m[1]][price] = ($v) ? $v : 0;
		}

/*		if($opt["prod_chars"]){
			$Prod->clearprodchars();

			$Prodchar = new Model_Prodchar();

			foreach($pc as $k => $v)
				$Prodchar->insert(array(
					"prod" => $id,
					"char" => $k,
					"charval" => 0 + $v[val],
					"value" => $v[value],
				));
		}*/
/*
		if($opt["prod_vars"]){
			$Prod->clearprodvars();

			$Prodvar = new Model_Prodvar();
			foreach($pv as $k => $v)
				$Prodvar->insert(array(
					"prod" => $id,
					"name" => data_base::nq($v['title']),
					"price" => $v['price'],
				));
		}*/
	}

	require("lib/admin.php");