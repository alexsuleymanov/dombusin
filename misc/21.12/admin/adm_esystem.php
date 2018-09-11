<?	require("adm_incl.php");

	//---- GENERAL ----

	$title = "Способы оплаты";
	$model = "Model_Esystem";
	$default_order = "prior";
		
	$can_add = 1;
	$can_del = 1;
	$can_edit = 1;

	//---- SHOW ----

	$show_cond = array();

	function showhead() {
		extract($GLOBALS);
		return $ret;
	}

	function onshow($row) {
		global $url;
		
		return $row;
	}

	$fields = array(
		'name' => array(
			'label' => "Название",
			'type' => 'text',
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 1,
		),
		'pic1' => array(
			'label' => "Иконка",
			'comment' => "",
			'type' => 'image',
			'location' => "../pic/esystem",
			'width' => 100,
			'show' => 1,
			'edit' => 1,
			'set' => 0,
			'multylang' => 0,
		),
		'script' => array(
			'label' => "Скрипт",
			'type' => 'text',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
		'form' => array(
			'label' => "Автоматическая форма *",
			'type' => 'textarea',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
		'comm1' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "* <font color=\"red\">Специальные значения</font> (они будут заменены на конкретные значения при отсылке формы):<br>
			<b>SITE_NAME</b> - адрес вашего сайта<br>
			<b>SITE_PAYAMOUNT</b> - сумма платежа<br>
			<b>SITE_PRODDESCR</b> - описание услуги<br>
			<b>SITE_ORDERNUMBER</b> - номер счета<br>
			<b>SITE_ESYSTEM</b> - ID платежной системы (для автоматической проверки оплаты)<br>",
			'show' => 0,
			'edit' => 1,
			'set' => 0,
			'sort' => 0,
			'multylang' => 0,
		),

		'autof' => array(
			'label' => "Автовызов",
			'type' => 'checkbox',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 0,
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
		'cont' => array(
			'label' => "Текст вывода",
			'type' => 'html',
			'show' => 0,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 1,
		),
		'course' => array(
			'label' => "Курс",
			'type' => 'text',
			'value' => 1,
			'show' => 1,
			'edit' => 1,
			'set' => 1,
			'sort' => 1,
			'multylang' => 0,
		),
		'minsum' => array(
			'label' => "Минимальная сумма",
			'type' => 'text',
			'value' => 1,
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
		'shop' => array(
			'label' => "",
			'type' => 'custom',
			'content' => "<input type=\"hidden\" name=\"shop\" value=\"".Zend_Registry::get('shop_id')."\">",
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
