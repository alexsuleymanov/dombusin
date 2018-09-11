<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Содержимое заказа";
	$model = "Model_Cart";
	$default_order = "id";
	$results = 500;
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$id = 0 + $_GET['id'];
	$order_id = 0 + $_GET['order_id'];

	$Model = new $model($id);
	$item = $Model->get();

	//---- SHOW ----
	$show_cond = array("where" => "`order` = '$order_id'");

	function showhead(){
		global $url;

		$str = "<a href=\"adm_order.php".$url->gvar("p=&order_id=")."\"><- Назад</a><br><br>";
		return $str;
	}

	function onshow($row) {
		$Prod = new Model_Prod($row->prod);
		$prod = $Prod->get();

		if($opt["prod_vars"]){
			$Prodvar = new Model_Prodvar($row->prodvar);
			$prodvar = $Prodvar->get();
			$row->prod = $prod->name."<br />(".$prodvar->name.")";
		}else{
			$row->prod = $prod->name;
		}

		$row->img = "<img src=\"/thumb?width=120&src=pic/prod/".$prod->id.".jpg\">";
		return $row;
	}

	$Prod = new Model_Prod($item->prod);
	$prod = $Prod->get();

	if($opt["prod_vars"]){
		$Prodvar = new Model_Prodvar($item->prodvar);
		$prodvar = $Prodvar->get();
	}

	$fields = array(
		'img' => array(
			'label' => "Фото",
			'type' => 'text',
			'content' => "<img src=\"/thumb?width=120&src=pic/prod/".$item->prod.".jpg\">",
			'show' => 1,
			'edit' => 0,
			'set' => 0,
			'multylang' => 0,
		),
		'prod' => array(
			'label' => "Товар",
			'type' => 'custom',
			'content' => $prod->name." <a href=\"adm_prod.php?action=edit&id=".$item->prod."\" target=\"_blank\">Просмотреть</a><input type=\"hidden\" name=\"prod\" value=\"".$item->prod."\">",
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
		'prodvar' => array(
			'label' => "Вариант приобретения",
			'type' => 'custom',
			'content' => $prodvar->name."<input type=\"hidden\" name=\"prodvar\" value=\"".$item->prodvar."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
		'price' => array(
			'label' => "Цена",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'num' => array(
			'label' => "Количество",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'order' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"order\" value=\"".$order_id."\">",
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'multylang' => 0,
		),
	);

	if($opt["prod_vars"] != 1) unset($fields["prodvar"]);
		
	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");