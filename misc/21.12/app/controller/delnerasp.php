<?
//	set_time_limit(0);

		$Prod = new Model_Prod();
		$cond = array(
			"where" => "1",
		);

		$order = ($_GET['order']) ? $_GET['order'] : "prior";
		$desc_asc = ($_GET['desc_asc']) ? $_GET['desc_asc'] : "desc";

		$cond['order'] = $order." ".$desc_asc;

		$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '-1'");

//		if($_GET["filter"]){
//			$cond["where"] .= " and ".Model_Prod::filter2($cat);
//		}

//		$view->cnt = $Prod->getnum($cond);

//		$cond["limit"] = "$start, $results";
		$prods = $Prod->getall($cond);
		echo count($prods)."<p>";
		foreach($prods as $k => $v){
			echo $k.") ".$v->id."---".$v->art;
			echo "<br />";
			$Prod->delete(array("where" => "id = '".$v->id."'"));
		}
		$Relation = new Model_Relation();
		$Relation->delete(array("where" => "`type` = 'cat-prod' and obj = '-1'"));
?>