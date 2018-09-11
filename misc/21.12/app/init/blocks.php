<?
	$blocks = array();

	if(!$blocks = $cache->load("block".$lang)){
		$obj = new Model_Block();
		$blocks_array = $obj->getall();

		foreach($blocks_array as $k => $v)
			$blocks[$v->intname] = $v->value;

		$cache->save($blocks, "block".$lang, array("model_block"));
	}
