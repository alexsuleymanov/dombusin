<?	$del = 0 + $_GET['del'];
	$add = 0 + $_GET['add'];

	$add_child = 0 + $_GET['add_child'];
	$del_child = 0 + $_GET['del_child'];
	$edit_child = 0 + $_GET['edit_child'];

	$add_analog = 0 + $_GET['add_analog'];
	$del_analog = 0 + $_GET['del_analog'];
	$edit_analog = 0 + $_GET['edit_analog'];

	$mass_edit = 0 + $_GET['mass_edit'];

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

	if ($del_child){
		$Relation = new Model_Relation();
		$Relation->delete(array("where" => "id = '$del_child'"));
		echo $del_child;
		die();
	}

	if ($add_child){
		$Relation = new Model_Relation();
		$Relation->insert(array("type" => "prod-prod", "obj" => $vid, "relation" => 0));
		echo $Relation->last_id();
		die();
	}

	if ($edit_child){
		$Relation = new Model_Relation($_GET['relid']);
		$Relation->save(array("relation" => $_GET['child']));
		echo $_GET['child'];
		die();
	}


	if ($del_analog){
		$Relation = new Model_Relation();
		$Relation->delete(array("where" => "id = '$del_analog'"));
		echo $del_analog;
		die();
	}

	if ($add_analog){
		$Relation = new Model_Relation();
		$Relation->insert(array("type" => "prod-prod-analog", "obj" => $vid, "relation" => 0));
		echo $Relation->last_id();
		die();
	}

	if ($edit_analog){
		$Relation = new Model_Relation($_GET['relid']);
		$Relation->save(array("relation" => $_GET['analog']));
		echo $_GET['analog'];
		die();
	}

	if($mass_edit){
		$Prod = new Model_Prod();

		$prods = array();
		foreach($_POST['prod'] as $k => $v){
			$prods[] = $pid = str_replace("del_", "", $v);			
			if($k) $ids .= " or ";
			$ids .= "id = ".$pid;
		}

		if($_POST['skidka'] != -1){
			$data['skidka'] = $_POST['skidka'];
		}

		if($_POST['onsite']){
			$data['visible'] = 1;
			$data['changed'] = time();
		}

		if($_POST['offsite']){
			$data['visible'] = 0;
		}

		if($_POST['onnew']){
			$data['new'] = 1;
		}

		if($_POST['offnew']){
			$data['new'] = 0;
		}

		if($_POST['ontop']){
			$data['pop'] = 1;
			$data['main'] = 1;
		}

		if($_POST['offtop']){
			$data['pop'] = 0;
			$data['main'] = 0;
		}

		if(!empty($data)) $Prod->update($data, array("where" => $ids));

		if(!empty($_POST['cats'])){
			$Relation = new Model_Relation();
			foreach($_POST['cats'] as $kk => $vv){
				foreach($prods as $kkk => $vvv){
//					$Relation->delete(array("where" => "`type` = 'cat-prod' and relation = '".$vvv."'"));
					$q .= "insert into dombusin_relation set `type` = 'cat-prod', obj = '".$vv."', relation = '".$vvv."';\n";
					$q1 .= "delete from dombusin_relation where `type` = 'cat-prod' and relation = '".$vvv."';\n";
				}
//				$data1 = array("type" => "cat-prod", "obj" => $vv, "relation" => $prod_id);
//				$Relation->insert($data1);
//				$Relation->mq($q);
//				$Relation->mq($q1);
			}
//			echo $q; die();
			$Relation->mq($q1);
			$Relation->mq($q);
		}

		if($_GET['cat']) $outputcache->remove('extsearch'.$_GET['cat']);
//		echo $q;
		echo "Товары изменены";
		die();
	}