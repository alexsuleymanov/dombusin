<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Фотографии";
	$model = "Model_Photo";
	$default_order = "prior";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$type = $_GET['type'];
	$par = 0 + $_GET['par'];

	//---- SHOW ----
	$show_cond = array("where" => "type = '".data_base::nq($type)."' and par = '".data_base::nq($par)."'");

	function showhead() {
		global $url, $photocat, $type, $par;

		$model = "Model_".ucfirst($type);
		$Model = new $model;
		$r = $Model->get($par);
		$str .= "<h3>".$r->name."</h3>";
		$str .= "<a href=\"adm_".$type.".php".$url->gvar("type=&par=&p=")."\"><- Назад</a><br><br>";

		return $str;
	}

	function onshow($row) {
		$row->photo = "<img src=\"/pic/".Zend_Registry::get('shop_url')."/miniphoto/".$row->id.".jpg\">";

		return $row;
	}

	$fields = array(
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
		'pic2' => array(
			'label' => "Большое фото",
			'comment' => "",
			'type' => 'image',
			'location' => "../pic/photo",
			'width' => 500,
			'show' => 1,
			'edit' => 1,
			'set' => 0,
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
		'shop' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"shop\" value=\"".Zend_Registry::get('shop_id')."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
		'type' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"type\" value=\"".$type."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
		'par' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"par\" value=\"".$par."\">",
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