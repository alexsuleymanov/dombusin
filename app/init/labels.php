<?
	$labels = array();

	if(!$labels = $cache->load("labels".$lang)){
		$obj = new Model_Labels();
		$labels_array = $obj->getall();

		foreach($labels_array as $k => $v)
			$labels[$v->intname] = $v->value;

		$cache->save($labels, "labels".$lang, array("model_labels"));
	}
