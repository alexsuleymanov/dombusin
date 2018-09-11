<?
	set_time_limit(0);
	ob_implicit_flush(1);

	include("adm_incl.php");

    if($_GET['action'] == "getprods"){?>
	<table>
<?		$Prod = new Model_Prod();
		$prods = $Prod->getall(array("where" => "visible = 1", "relation" => array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($_GET['cat'])."'"), "order" => "prior desc"));

		$i = 0;
		foreach($prods as $prod){
			if($i++ % 4 == 0) echo "<tr>";
?>
		<td style="border: 1px solid #d0d0d0; padding: 2px;">
			<input type="checkbox" name="prod_<?=$prod->id?>" value="1" style="float: left; margin: 40px 5px 0px 0px;"/>
			<img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&width=100" width="100" alt="" style="float: left; margin-right: 5px;"/><br/>
			<?=$prod->name?><br/>
			<div style="clear: both; margin: 3px;"></div>
			<div style="margin: 5px 2px 5px 20px;"><b style="color: red;">Цена: <?=$prod->price?> грн.</b></div>
		</td>
<?		}?>
	</table>
<?		
    	die();
	}

	echo $view->render("head.php");

	try{

	$action = $_GET[action];

?>
<table bgcolor="#f0f0f0" cellspacing="0" cellpadding="10" width="100%" class="dist">
	<tr>
		<td bgcolor="#00a000"><a href="?action=distrib"><h3 style="color: ffffff;">Сделать рассылку</h3></a></td>
		<td><a href="?action=delete">Удалить подписчика</a></td>
		<td><a href="?action=export">Экспорт базы адресов</a></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><a href="?action=add">Добавить подписчика</a></td>
		<td><a href="?action=import">Импорт базы адресов</a></td>
	</tr>
	<tr>
		<td><a href="/admin/adm_distrib.php">< Назад</a></td>
		<td><a href="?action=check">Проверить адрес</a></td>
		<td>&nbsp;</td>
	</tr>
</table>	
<br /><br />

<?	if($action == ""){
		$start = 0 + $_GET['start'];
		$results = 200;
		$default_order = 'tstamp';

		$Distrib = new Model_Distrib();
		$distribs = $Distrib->getall();

		if($_POST['filter']){
			if(empty($show_cond["where"])) $show_cond["where"] = "1 = 1";
			foreach($_POST as $k => $v){
				if($_POST[$k] && preg_match("/filter_(\w+)/", $k, $m))
					$show_cond["where"] .= " and `".$m[1]."` like '%".data_base::nq($_POST[$k])."%'";
			}
		}

		$view->cnt = $Distrib->getnum($show_cond);
		$view->results = $results;
		$view->start = $start;
	
		$order = ($_GET['order']) ? $_GET['order'] : $default_order;

		if($_GET['desc_asc']) $desc_asc = $_GET['desc_asc'];
		else $desc_asc = "desc";

		$show_cond['order'] = $order." ".$desc_asc;
		$show_cond["limit"] = "$start, $results";

		$rows = $Distrib->getall($show_cond);
?>
<h2>Архив рассылок</h2>

<table class="show" width="100%">
	<tr>
		<form action="" method="post">
		<input type="hidden" name="filter" value="1">
		<td class="show">&nbsp;</td>
		<td class="show">&nbsp;</td>
		<td class="show"><input type="text" name="filter_<?=$k?>" value="<?=$_POST['filter_'.$k]?>" style="width:100%;" class="inp"></td>
		<td class="show">&nbsp;</td>
		<td class="show">&nbsp;</td>
		<td class="show">&nbsp;</td>
		<td class="show">&nbsp;</td>
		<td class="show">&nbsp;</td>
		<td class="show"><input type="image" src="<?=$view->path?>/img/search.jpg"></td>
		</form>
	</tr>

	<tr>
<form action="?action=mass_del" method="post">
		<td class="show" width="15"></td>
<?		$desc_asc1 = ($desc_asc == 'asc') ? 'desc': 'asc';?>
		<th class="show" width="60" <?echo "title=\"Отсортировать\" style=\"cursor: hand;\" onclick=\"location.href='".$view->url->gvar("order=tstamp&desc_asc=".$desc_asc1)."'\"";?>>
			Дата
<?			if($order == 'tstamp'){?>
			<img src="<?=$view->path?>/img/arrow_<?=($desc_asc == 'desc') ? "down" : "up";?>.gif" align="absmiddle">
<?			}?>
		</th>
<?		$desc_asc1 = ($desc_asc == 'asc') ? 'desc': 'asc';?>
		<th class="show" <?echo "title=\"Отсортировать\" style=\"cursor: hand;\" onclick=\"location.href='".$view->url->gvar("order=name&desc_asc=".$desc_asc1)."'\"";?>>
			Тема
<?			if($order == 'name'){?>
			<img src="<?=$view->path?>/img/arrow_<?=($desc_asc == 'desc') ? "down" : "up";?>.gif" align="absmiddle">
<?			}?>
		</th>
		<th class="show" width="100">База</th>
		<th class="show" width="100">Разослано на</th>
		<th class="show" width="100">Доразослать</th>
		<th class="show" width="100">Редактировать</th>
		<th class="show" width="100">Повторить</th>
		<th class="show" width="60">Удалить</th>
	</tr>
<?		foreach($rows as $kk => $row) {?>
	<tr onmouseover="this.bgColor='#f2ffe3'" onmouseout="this.bgColor='#ffffff'">
		<td class="show"><?=$kk+1?></td>
		<td class="show" align="center" width="140"><?=date("d.m.Y H:i", $row->tstamp);?></td>
		<td class="show" align="center"><?=$row->subj?></td>
		<td class="show" align="center"><?=$row->bd?></td>
		<td class="show" align="center"><?=$row->sentto?></td>
		<td class="show" align="center"><a href="?action=send&id=<?=$row->id?>">Доразослать</a></td>
		<td class="show" align="center"><a href="?action=distrib&id=<?=$row->id?>">Редактировать</a></td>
		<td class="show" align="center"><a href="?action=resend&id=<?=$row->id?>">Повторить</a></td>
		<td class="show" align="center"><a href="<?=$view->url->gvar("action=del&id=".$row->id)?>" onclick="return confirm('Удалить?')" title="Удалить"><img src="<?=$view->path?>/img/b_del.png"></a></td>
	</tr>
<?		}?>
</form>
</table>
<?
		echo $view->render('rule.php');
	}elseif($action == "delete"){
		$Subs = new Model_Subscribe();
		if($_POST[submit]){
		    if($Subs->unsubscribe($_POST[email], $_POST['bd']))
				echo "<h3>Адрес удален из базы</h3>";
		}else{?>
<h2>Удалить подписчика</h2>
<form action="" method="post">
	<b>База</b><br />
	<select name="bd">
		<option value="1">Группа 1</option>
		<option value="2">Группа 2</option>
		<option value="3">Группа 3</option>
	</select><br><br>
	<input type="text" name="email" size="25" /> <input type="submit" name="submit" value="Удалить" />
</form>
<?		}
	}elseif($action == "add"){
		$Subs = new Model_Subscribe();
		if($_POST[submit]){
			try{
				if($Subs->subscribe($_POST[email], $_POST['bd']))
					echo "<h3>Адрес добавлен в базу</h3>";
			}catch(Model_Subscribe_Exception $e){
				echo "<font color=\"red\">".$e->getMessage()."</font>";
			}
		}else{?>
<h2>Добавить подписчика</h2>
<form action="" method="post">
	<b>База</b><br />
	<select name="bd">
		<option value="1">Группа 1</option>
		<option value="2">Группа 2</option>
		<option value="3">Группа 3</option>
	</select><br><br>
	<input type="text" name="email" size="25" /> <input type="submit" name="submit" value="Добавить" />
</form>
<?		}
	}elseif($action == "check"){
		$Subs = new Model_Subscribe();

		if($_POST[submit]){
			if($Subs->in_base($_POST[email]))
			    echo "<font color=\"green\">Такой адрес есть в базе</font>";
			else
				echo "<font color=\"red\">Такого адреса нет в базе</font>";
		}else{?>
<h2>Проверить адрес</h2>
<form action="" method="post">
	<select name="bd">
		<option value="1">Группа 1</option>
		<option value="2">Группа 2</option>
		<option value="3">Группа 3</option>
	</select><br><br>
	<input type="text" name="email" size="25" /> <input type="submit" name="submit" value="Проверить адрес" />
</form>
<?		}
	}elseif($action == "import"){
		$Subs = new Model_Subscribe();
		if($_POST[submit]){
			try{
				$i = $Subs->import($_FILES['emails']['tmp_name'], $_POST['bd']);
				echo "<h3>Импорт успешно выполнен</h3>Добавлено $i адресов";
			}catch(Model_Subscribe_Exception $e){
				echo "<font color=\"red\">".$e->getMessage()."</font>";
			}
		}else{?>
<h2>Выберите файл с адресами(текстовый файл, каждый e-mail с новой строки)</h2>
<form action="" method="post" enctype="multipart/form-data">
	<b>База</b><br />
	<select name="bd">
		<option value="1">Группа 1</option>
		<option value="2">Группа 2</option>
		<option value="3">Группа 3</option>
	</select><br><br>

	<input type="file" name="emails" size="25" /> <input type="submit" name="submit" value="Добавить" />
</form>
<?		}
	}elseif($action == "export"){
		$Subs = new Model_Subscribe();
		if($_POST[submit]){
			try{
				$arr = $Subs->export($_POST['bd']);
				foreach($arr as $a){
					echo ++$i.") ".$a."<br />";
				}
			}catch(Model_Subscribe_Exception $e){
				echo "<font color=\"red\">".$e->getMessage()."</font>";
			}
		}else{?>
<h2>Выберите Базу</h2>
<form action="" method="post" enctype="multipart/form-data">
	<b>База</b><br />
	<select name="bd">
		<option value="1">Группа 1</option>
		<option value="2">Группа 2</option>
		<option value="3">Группа 3</option>
	</select><br><br>

	<input type="submit" name="submit" value="Экспорт" />
</form>
<?		}
	}elseif($action == "add_black"){
		$Subs = new Model_Subscribe();
		if($_POST[submit]){
			$Subs->disallowemail($_POST[email]);
		}else{?>
<h2>Занести адрес в черный список</h2>
<form action="" method="post">
	<input type="text" name="email" size="25" /> <input type="submit" name="submit" value="Подтвердить" />
</form>
<?		}
	}elseif($action == "delete_black"){
		if($_POST[submit]){
			$Subs->allowemail($_POST[email]);
		}else{?>
<h2>Удалить из черного списка</h2>
<form action="" method="post">
	<input type="text" name="email" size="25" /> <input type="submit" name="submit" value="Подтвердить" />
</form>
<?		}
	}elseif($action == "send" || $action == "resend"){
		$id = 0 + $_GET['id'];
		$Distrib = new Model_Distrib();
		$distrib = $Distrib->get($id);

		ob_implicit_flush(1);
		echo "Подождите...<br />";
	
		echo "Рассылка началась...<br /><br />";

		if($action == "send")
			$start = $distrib->sentto;
		elseif($action == "resend")		
			$start = 0;

		$Distrib->mass_send(new Model_Distrib_Message($sett["sitename"], "subscribe@".$_SERVER['HTTP_HOST'], $distrib->subj, $distrib->cont), $start, $_FILES, $distrib->bd);
	}elseif($action == "distrib"){
		$Distrib = new Model_Distrib();

		if($_POST[submit]){
			$text = $_POST['text'];
			$Prod = new Model_Prod();
			$Cat = new Model_Cat();
			$prods = array();
			
			foreach($_POST as $k => $v) {
				if (preg_match("/^prod_(\d+)$/", $k, $m)) $prods[$m[1]][id] = $m[1];
				if (preg_match("/^price_(\d+)$/", $k, $m)) $prods[$m[1]][price] = $v;
				if (preg_match("/^cont_(\d+)$/", $k, $m)) $prods[$m[1]][cont] = $v;
			}

			$view->prods = array();
//			$prods_tmp = "<table cellpadding=\"0\" cellspacing=\"10\" width=\"100%\">\n";
					
			foreach($prods as $k => $v){
/*				if($k % 3 == 0) $prods .= "							<tr>";
				if(empty($v[id])) continue;
*/
				$view->prods[] = $Prod->get($v[id]);
//				$cat = $Cat->getone(array("where" => "id = ".$prod->cat));

//				$view->prod = $prod;
//				$view->cat = $cat;

//				$prods_tmp .= $view->render('distrib/prod-mini.php');
			}

//			$prods_tmp .= "</table>";

//			$view->prods = $prods;
			$prods_tmp = $view->render("distrib/prods.php");

			$params = array(
				"title" => $_POST['subj'],
				"message" => Func::global_images(data_base::dnq($text)),
				"prods" => $prods_tmp,
			);

			$text = Func::mess_from_tmp($templates["distrib_message_template"], $params);

//			print($text);die();
			ob_implicit_flush(1);
			echo "Подождите...<br />";
	
			echo "Рассылка началась...<br /><br />";

			$Distrib->mass_send(new Model_Distrib_Message($sett["sitename"], "subscribe@".$_SERVER['HTTP_HOST'], $_POST['subj'], $text), $_POST['start'], $_FILES, $_POST['bd']);
		}else{
			if($_GET['id']) $distrib = $Distrib->get($_GET['id']);
?>
<h2>Рассылка</h2>
<form action="" method="post">
<?	if($_GET['id']){?><input type="hidden" name="styles" value="1"/><?}?>
	<b>Тема</b><br /><input type="text" name="subj" size="25" <?if($distrib->subj) echo "value=\"".$distrib->subj."\"";?>/> <br /><br />
	<b>База</b><br />
	<select name="bd">
	<option value="1" <?if($distrib->bd == 1) echo "selected=\"1\"";?>>Группа 1</option>
	<option value="2" <?if($distrib->bd == 2) echo "selected=\"1\"";?>>Группа 2</option>
	<option value="3" <?if($distrib->bd == 3) echo "selected=\"1\"";?>>Группа 3</option>
	</select><br><br>
	<b>Текст сообщения</b><br /><?if(empty($distrib->cont)) edit('text', ''); else edit('text', $distrib->cont);?><br /><br />
	<b>Начать с</b><br /><input type="text" name="start" size="25" value="0"/> <br /><br />
	<input type="submit" name="submit" value="Подтвердить" />
<?	if(!$_GET['id']){?>
	<br /><br />
	<h2>Прикрепить товары</h2>
	<br />
	<div>
		<script>
			var click = new Array;

			function catclick(cat){
				if(!click[cat]){
					$.get("?action=getprods", {'cat' : cat}, function(data){
						$('#prods_'+cat).show().html(data);
					});
					click[cat] = 1;
				}else{
					$('#prods_'+cat).hide();
					click[cat] = 0;
				}
			}
		</script>
<?
	$Cat = new Model_Cat();
	$rc = $Cat->getall(array("order" => "name"));
	$tree = array();
	foreach($rc as $k => $v){
		$tree[] = array("id" => $v->id, "par" => $v->cat, "name" => $v->name);
	}

	function draw_tree($k, $tree, $rel, $par){
		echo "<ul style=\"padding-left: 20px;\">";
		foreach($tree as $kk => $item){
			if($item['par'] == $par){
				unset($tree[$kk]);
				echo "<li>";
				echo "<div style=\"font-size: 11px; margin-top: 2px; padding: 2px 30px 2px 5px; font-weight: bold; background-color: #f0f0f0; border: 1px solid #c0c0c0; cursor: pointer;\" onclick=\"catclick(".$item['id'].")\">".$item['name']."</div>";
				echo "<div id=\"prods_".$item['id']."\" style=\"margin-bottom: 10px; display: none; border: 1px solid #c0c0c0; padding: 2px 30px 2px 5px;\"></div>";
				draw_tree($k, $tree, $rel, $item['id']);
				echo "</li>";
			}
		}
		echo "</ul>";
	}

	draw_tree('cat', $tree, 1, 0);
?>
	</div>
<?	}?>
</form>
<?		}
	}

	}catch(Zend_Exception $e){
		echo "<font color=red>Zend Exception!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "<br />";
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

	echo $view->render("foot.php");
