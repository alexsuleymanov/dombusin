<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Текстовые разделы";
	$model = "Model_Page";
	$model_type = "page";
	$default_order = "prior";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$page = 0 + $_GET["page"];

	//---- SHOW ----
	$show_cond = array("where" => "page = '".$page."'");

	function showhead() {
		global $page, $model_type;
		$Page = new Model_Page($model_type);
		$back = $Page->getone(array("where" => "id = '".data_base::nq($page)."'"));

		$ret = "<a href=\"adm_page.php\">Главная</a>";
		if(isset($back))
			$ret .= " - <a href=\"adm_page.php?page=".$back->page."\">Назад</a>";
		$ret .= "<br><br>";

		return $ret;	
	}

	function onshow($row) {
		extract($GLOBALS);

		$row->type = ($row->href) ? "<font color=\"blue\">Внешний модуль</font>" : "<font color=\"orange\">Страница</font>";
		$row->intname = "<span class=\"lnk\">http://".$_SERVER[HTTP_HOST]."/".trim($row->intname, "/")."</span>";
		$row->submenu = "<a href=\"adm_page.php?page=".$row->id."\"> [Подменю] </a>";
		$row->photos = "<a href=\"adm_photo.php".$url->gvar("p=&type=page&par=".$row->id)."\"> [Фотографии] </a>";

		return $row;
	}

	$fields = array(
		'page' => array(
			'label' => 'Категория',
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
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
        'mainpage' => array(
			'label' => "Главная страница",
			'type' => 'checkbox',
			'value' => 0,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
		'href' => array(
			'label' => "Название скрипта",
			'type' => 'select',
			'items' => Func::controller_list(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
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
			'location' => "../pic/page",
			'width' => 300,
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
        'cont' => array(
			'label' => "Содержимое",
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
			'multylang' => 0,
		),
        'autosub' => array(
			'label' => "Список подразделов",
			'type' => 'checkbox',
			'value' => 1,
			'show' => 0,
			'edit' => 1,
			'set' => 1,
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
		'type' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"type\" value=\"".$model_type."\">",
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
		'submenu' => array(
			'label' => "Подменю",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
		'photos' => array(
			'label' => "Фотографии",
			'type' => 'text',
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
	);

	if($page){
		$Page = new Model_Page($model_type);
		$rc = $Page->getone(array("where" => "id = $page"));
//		$rc = $Page->getall(array("order" => "name desc"));
//		foreach($rc as $k => $r) $fields[page][items][$r->id] = $r->name;
		$fields[page][items][$rc->id] = $rc->name;
	}else{
		$fields[page][items][0] = "Корневая";
	}
	
	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
		extract($GLOBALS);

		if($page && strstr($_POST[intname], "/") == false){
			$Page = new Model_Page($model_type);
			$par_name = $Page->getone(array("where" => "id = $page"))->intname;
			$intname = ($par_name) ? $par_name."/".$data[intname] : $data[intname];
			$Page = new Model_Page($model_type, $id);
			$Page->update(array("intname" => $intname));
		}
	}

	require("lib/admin.php");