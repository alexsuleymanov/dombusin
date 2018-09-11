<?
	set_time_limit(0);

	$action = ($_GET['action']) ? $_GET['action'] : 'show';
	$id = 0 + $_GET['id'];
	$start = 0 + $_GET['start'];
	if(empty($results))	$results = 100;

try{

	if($action == 'mass_del'){
		foreach($_POST['del'] as $k => $id){			
			$Model = new $model();
			ondel($id);
			$Model->destroy($id);
		}

		header("Location: ".$url->gvar("action=&id="));
		die();
	}elseif($action == 'del'){
		$Model = new $model();
		ondel($id);
		$Model->destroy($id);

		header("Location: ".$url->gvar("action=&id="));
		die();
	}elseif($action == 'setajax'){
			$Model = new $model();
			$data = array();
			$data[$_GET['field']] = $_GET['fieldvalue'];

			$Model->update($data, array("where" => "id = '".data_base::nq($_GET['id'])."'"));
			die();
	}elseif($action == 'set' || $action == 'setlang'){
		$Lang = new Model_Lang();
		$lang_id = ($_GET['lang']) ? $_GET['lang'] : $lang_id;
		$lang = $Lang->get($lang_id)->intname;

		$Model = new $model();
		$data = array();
		$translate_data = array();

		$a = $_POST;

		foreach($fields as $k => $v) {
			if($v['set'] != 1) continue;
			if ($v['type'] == 'checkbox') $a[$k] = 0 + $a[$k];
			if ($v['type'] == 'date') $a[$k] = mktime($a["dateh_$k"], $a["datei_$k"], 0, $a["datem_$k"], $a["dated_$k"], $a["datey_$k"]);
			if ($v['type'] == 'file' && $_POST[$k."_filename"] != '') $a[$k] = $_POST[$k."_filename"];
		}

		foreach($fields as $k => $v) {
			if($k == "intname" && $a[$k] == '' && $a['mainpage'] == 0){
				$data[$k] = Func::mkintname($a["name"]);
			}elseif($k == "intname" && ($a[$k] == '/' || $a[$k] == 'index')){
				$data[$k] = '';
			}elseif($v['set'] == 1 && ($v['multylang'] == 0 || $default_lang_id == $lang_id)){
				$data[$k] = $a[$k];
			}elseif($v['set'] == 1 && $v['multylang'] == 1 && MULTY_LANG == 1 && $default_lang_id != $lang_id){
				$translate_data[$k] = $a[$k];
			}
		}
		
		if($id && function_exists("beforeset")) beforeset($id);

		if($id)
			$Model->update($data, array("where" => "id = $id"));
		else
			$Model->insert($data);

		if($id == 0){
			$id = $Model->last_id();
			if(function_exists('onadd')) onadd($id);
		}

		if(count($translate_data)){
			foreach($translate_data as $k => $v){
				$data = array(
					"obj_id" => $id,
					"lang" => $lang,
					"table" => $Model->table,
					"field" => $k,
					"cont" => $v,
				);
				$cond = array(
					"where" => "lang = '".$lang."' and `table` = '".$Model->table."' and field = '".$k."' and obj_id = '".$id."'",
				);

				$Translate = new Model_Translate();
				if($r = $Translate->getone($cond))
					$Translate->update($data, array("where" => "id = '".$r->id."'"));
				else
					$Translate->insert($data);
			}
		}

		foreach($fields as $k => $v) {
			$ftype = ($v['ftype']) ? $v['ftype']: "jpg";
			$dst = $v['location']."/".$id.".".$ftype;

			if($_POST[$k."_image_del"]){
//				$outputcache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(str_replace(array("/", "."), "_", str_replace("../", "", $v['location'])."/".$id.".".$ftype)));
				if (file_exists($dst)) unlink($dst);
			}
				
			if($v['type'] == 'image') {
				if($_POST[$k."_imagename"]){
					if (file_exists($dst)) unlink($dst);
					if (!file_exists($v['location'])) mkdir($v["location"]);
					rename($_POST[$k."_imagename"], $dst);
//					$outputcache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(str_replace(array("/", "."), "_", str_replace("../", "", $v['location'])."/".$id.".".$ftype)));
				}
			}
			
			if($v['type'] == 'file') {
				$dst = $v['location']."/".$_POST[$k."_filename"];
				if($_POST[$k."_filename"]){
					if (file_exists($dst)) unlink($dst);
					if (!file_exists($v['location'])) mkdir($v["location"]);
					rename($path."/admin/tmp/".$_POST[$k."_filename"], $dst);
				}
			}

			$dst = $v['location']."/".$a[$k];
			
			if($_POST[$k."_file_del"]) {
				if (file_exists($dst)) unlink($dst);
				$a[$k] = "";
			}
				
			if($v['type'] == 'multiselect' || $v['type'] == 'multiselecttree'){
			    $Relation = new Model_Relation();
				if($v['obj-rel'] == 'relation'){
					$Relation->delete(array("where" => "relation = '$id' and `type` = '".$v['relation']."'"));
				}else{
					$Relation->delete(array("where" => "obj = '$id' and `type` = '".$v['relation']."'"));
				}

				if(!empty($a[$k]))
					foreach($a[$k] as $kk => $vv){
						if($v['obj-rel'] == 'relation')
							$data = array(
								"type" => $v['relation'],
								"relation" => $id,
								"obj" => $vv,
							);
						else
							$data = array(
								"type" => $v['relation'],
								"obj" => $id,
								"relation" => $vv,
							);
						$Relation->insert($data);
					}

				if(count($a[$k]) > 1)
					if($v['obj-rel'] == 'relation'){
						$Relation->delete(array("where" => "relation = '$id' and obj = '-1' and `type` = '".$v['relation']."'"));
					}else{
						$Relation->delete(array("where" => "obj = '$id' and relation = '-1' and `type` = '".$v['relation']."'"));
					}
			}
		}

		onset($id);

		if($action == 'setlang')
			header("Location: ".$url->page.$url->gvar("action=edit&id=$id&lang=".$a['setlang']));
		else
			header("Location: ".$url->page.$url->gvar("action=&id=&lang="));
		die();
	}elseif($action == 'edit'){
//	Delete tmp files
		$dd = opendir("tmp");
		while($ff = readdir($dd))
			if($ff != '.' && $ff != '..' && $ff != 'translate')
				unlink("tmp/".$ff);

//	/Delete tmp files

		$Lang = new Model_Lang();
		$lang_id = ($_GET['lang']) ? $_GET['lang'] : $lang_id;
		$lang = $Lang->get($lang_id)->intname;
		Zend_Registry::set('lang', $lang);

		$id = 0 + $_GET[id];
		$a = new DBObject;

		if ($id == 0){
			foreach($fields as $k => $v){
				$a->$k = $v['value'];
			}
		}else {
			$Model = new $model();
			$a = $Model->get($id);
		}

		$view->a = $a;
		$view->fields = $fields;
		$view->langs = $Lang->getall(array("order" => "`main` desc"));
		$view->title = $title." - ".$a->name;
		$view->lang = $lang;
		$view->lang_id = $lang_id;
		$view->id = $id;
		$view->user_code = $user_code;

		echo $view->render('head.php');
		echo $view->render('edit.php');
		echo $view->render('foot.php');
	}elseif($action == 'show'){
		$Model = new $model();
		$Model->type = $model_type;

		$view->fields = $fields;

		if($_POST['filter']){
			if(empty($show_cond["where"])) $show_cond["where"] = "1 = 1";
			foreach($_POST as $k => $v){
				if($_POST[$k] && preg_match("/filter_(\w+)/", $k, $m))
					$show_cond["where"] .= " and `".$m[1]."` like '%".data_base::nq($_POST[$k])."%'";
			}
		}

		$view->cnt = $Model->getnum($show_cond);
		$view->results = $results;
		$view->start = $start;
	
		$order = ($_GET['order']) ? $_GET['order'] : $default_order;

		if($_GET['desc_asc']){ $desc_asc = $_GET['desc_asc'];}
		elseif($default_descasc){ $desc_asc = $default_descasc;}
		else {$desc_asc = "desc";}
		
//		$desc_asc = ($_GET['desc_asc']) ? $_GET['desc_asc'] : "asc";

		$show_cond['order'] = $order." ".$desc_asc;
		$show_cond["limit"] = "$start, $results";

		$rows2 = $rows = $Model->getall($show_cond);
			
		$view->rows = array();
		$view->originalrows = array();

		foreach($rows as $k => $v){
//			$view->rows[$k] = $Plugins->onshow($v);
			$view->rows[$k] = onshow($v);
		}

		foreach($rows2 as $k => $v){
			$view->originalrows[$k] = $v;
		}

		$view->can_edit = $can_edit;
		$view->can_del = $can_del;
		$view->can_add = $can_add;
		$view->title = $title;
		$view->showhead = showhead();
		$view->order = $order;
		$view->desc_asc = $desc_asc;
		
		echo $view->render('head.php');
		echo $view->render('show.php');
		echo $view->render('rule.php');
		echo $view->render('foot.php');
	}

}catch(DBException $e){
		echo "<font color=red>DBException!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "Trace: <br />";
		$trace = $e->getTrace(); 
		foreach($trace as $k => $v){
			echo "<font color=\"green\">".$k." -> </font>";
			foreach($v as $kk => $vv){
				echo $kk." -> ";
				if(is_array($vv)) print_r($vv); else echo $vv;
				echo "<br />";
			}
			echo "<br />";
		}
		echo "<br />";
}catch(Exception $e){
		echo "<font color=red>Exception!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "<br />";
}
