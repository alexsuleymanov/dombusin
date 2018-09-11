<?
	$templates = array();

	if(!$templates = $cache->load("template".$lang)){
		$obj = new Model_Template();
		$templates_array = $obj->getall();

		foreach($templates_array as $k => $v)
			$templates[$v->intname] = $v->cont;

		$cache->save($templates, "template".$lang, array("model_template"));
	}
