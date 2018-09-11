<?
	$del = 0 + $_GET['del'];
	$add = 0 + $_GET['add'];

	$add_prod = 0 + $_GET['add_prod'];
	$del_prod = 0 + $_GET['del_prod'];
	$edit_prod = 0 + $_GET['edit_prod'];

	$vid = 0 + $_GET['id'];

	if ($del){
		$Prodvar = new Model_Prodvar();
		$Prodvar->delete(array("where" => "id = '$del'"));
		echo $del;
		die();
	}

	if ($add){
		$Prodvar = new Model_Prodvar();
		$Prodvar->insert(array("prod" => $vid));
		echo $Prodvar->last_id();
		die();
	}

	if ($del_prod){
		$Relation = new Model_Relation();
		$Relation->delete(array("where" => "id = '$del_prod'"));
		echo $del_prod;
		die();
	}

	if ($add_prod){
		$Relation = new Model_Relation();
		$Relation->insert(array("type" => "action-prod", "obj" => $vid, "relation" => 0));
		echo $Relation->last_id();
		die();
	}

	if ($edit_prod){
		$Relation = new Model_Relation($_GET['relid']);
		$Relation->save(array("relation" => $_GET['prod']));
		echo $_GET['prod'];
		die();
	}
