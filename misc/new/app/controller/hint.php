<?
	$results = 20;
	$type = $_GET['type'];
	$q = $_GET['q'];

	if($q){
		$q = $q;
		$words = preg_split("/[\s\.,\-\=\+!\'\"%\&\(\)]/", $q, -1, PREG_SPLIT_NO_EMPTY);
		$i = 0; $n = 0;

		$cond = array();
		if($args[1] == 'globalcat'){
			$Globalcat = new Model_Globalcat();
			$cond["where"] = "visible = 1";
			foreach($words as $k => $v){
				$cond["where"] .= " and (name like '%$v%')";
			}
			$cond["limit"] = "$results";
			$cats = $Globalcat->getall($cond);

			foreach($cats as $cat){
				echo $cat->name."|".$cat->id."\n";
			}
		}

		if($args[1] == "prod"){
   			$Prod = new Model_Prod();
			$cond["where"] = "visible = 1";
			foreach($words as $k => $v){
				$cond["where"] .= " and (id like '%$v%' or name like '%$v%')";
			}
			$cond["limit"] = "$results";
			$prods = $Prod->getall($cond);

			foreach($prods as $prod){
				echo $prod->name."|".$prod->id."\n";
			}

		}
	}
