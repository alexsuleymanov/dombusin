<?	require("adm_incl.php");
	//---- GENERAL ----

	$title = "Варианты ответа";
	$model = "Model_VoteAnswer";
	$default_order = "prior";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	$vote = 0 + $_GET['vote'];

	//---- SHOW ----
	$show_cond = array("where" => "vote = $vote");

	function showhead() {
		extract($GLOBALS);

		return "<h2></h2> <a href=\"adm_vote.php".$url->gvar("vote=&start=")."\"> <img src=\"".$view->path."/img/back.jpg\" align=absmiddle> назад</a><p>";
	}

	function onshow($row) {
		return $row;
	}

	$fields = array(
		'vote' => array(
			'label' => 'Голосование',
			'type' => 'select',
			'items' => array(),
			'show' => 0,
			'edit' => 1,
			'set' => 1,
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
		'count' => array(
			'label' => "Кол-во голосов",
			'type' => 'text',
			'value' => 0,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'filter' => 0,
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
			'filter' => 0,
			'multylang' => 0,
		),
	);

	$Vote = new Model_Vote();
	$rc = $Vote->getone(array("where" => "id = $vote"));
	$fields['vote']['items'][$rc->id] = $rc->name;

	//---- DEL ----
	function ondel($id) {
	}

	//---- SET ----
	function onset($id) {
	}

	
	require("lib/admin.php");