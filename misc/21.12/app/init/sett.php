<?
	$sett = array();

	if(!$sett = $cache->load("sett".$lang)){
		$obj = new Model_Sett();
		$sett_array = $obj->getall();

		foreach($sett_array as $k => $v)
			$sett[$v->intname] = $v->value;

		$cache->save($sett, "sett".$lang, array("model_sett"));
	}
