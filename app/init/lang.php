<?	
	$url = new URLParser($_SERVER[REQUEST_URI], $_SERVER[QUERY_STRING]);
	$args = $url->parce();

	$Lang = new Model_Lang();
	$langs = $Lang->getall();

	foreach($langs as $k => $v){
		if($v->main){
			$default_lang = $v->intname;
			$default_lang_id = $v->id;
		}
	}

	$lang = $default_lang;
	$lang_id = $default_lang_id;

	foreach($langs as $k => $v){
		if($args[0] == $v->intname){
			$lang = $v->intname;
			$lang_id = $v->id;
			array_shift($args);
		}
	}

	$url->args = $args;

	Zend_Registry::set('lang', $lang);
	Zend_Registry::set('default_lang', $default_lang);

	define("MULTY_LANG", 1); // Обязательно
