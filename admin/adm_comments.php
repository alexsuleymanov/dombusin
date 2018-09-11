<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Отзывы";
	$model = "Model_Comment";
	$default_order = "id";
		
	$can_add = 0;
	$can_del = 1;
	$can_edit = 1;

	$id = 0 + $_GET["id"];
	$par = 0 + $_GET["par"];
	$type = $_GET["type"];

	//---- SHOW ----

	$show_cond = array("where" => "par = '$par' and `type` = '$type'");

	function showhead() {
		extract($GLOBALS);
		$ret = "<a href=\"adm_".$type.".php".$url->gvar("p=&par=&type=")."\"><- Назад</a><br><br>";
		return $ret;
	}

	function onshow($row) {
		global $url;
		$User = new Model_User('client', $row->user);
		$user = $User->get();
		$row->author = $user->name;
		$row->user = $user->name." ".$user->surname;
		return $row;
	}

	if($id){
		$Comment = new Model_Comment($id);
		$comment = $Comment->get();
		$User = new Model_User('client', $comment->user);
		$user = $User->get();
	}
	
	$fields = array(
		'tstamp' => array(
			'label' => "Время добавления",
			'type' => 'date',
			'value' => time(),
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
		'user' => array(
			'label' => "Пользователь",
			'type' => 'custom',
			'content' => '<a href="adm_user.php?action=edit&id='.$user->id.'">'.$user->name.' '.$user->surname.'</a>',
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'author' => array(
			'label' => "Автор",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'theme' => array(
			'label' => "Тема",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
			'multylang' => 0,
		),
		'cont' => array(
			'label' => "Коментарий",
			'type' => 'textarea',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
		'answer' => array(
			'label' => "Ответ",
			'type' => 'textarea',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
			'multylang' => 0,
		),
		'visible' => array(
			'label' => "Отображать на сайте",
			'type' => 'checkbox',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 1,
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
		'type' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"type\" value=\"".$type."\">",
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
