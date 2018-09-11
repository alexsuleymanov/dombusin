<?
	header("Content-Type: text/html; charset=utf-8");
	include("adm_incl.php");

	function clear($str){
		return trim(iconv("windows-1251", "utf-8", $str));
	}

	echo $view->render('head.php');

	if($_POST['submit']){
//		$csv = fopen($_FILES['ff']['tmp_name'], "r");
		$strings = file($_FILES['ff']['tmp_name']);

//		$q = "";
		$q2 = "insert into dombusin_prod (`intname`, `art`, `name`, `inpack`, `num`, `price`, 'priceopt`, `izm`, `pic`, `cont`, `uploaded`, `changed`) values \n";

//		foreach($strings as $k => $v){*/
/////////////////////////////////////////

		$Prod = new Model_Prod();
		$Relation = new Model_Relation();
		$Char = new Model_Char();
		$Charval = new Model_Charval();
		$Prodchar = new Model_Prodchar();
		$Prodvar = new Model_Prodvar();

		$objPHPExcel = PHPExcel_IOFactory::load($_FILES['ff']['tmp_name']);
		
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		$chrs = $Char->getall(array("where" => "cat = 0"));
		foreach($chrs as $k => $v){
			$chars[$v->id] = array();
			$cv = $Charval->getall(array("where" => "`char` = ".$v->id));
			foreach($cv as $kk => $vv){
				$chars[$v->id] = array($vv->value => $vv->id);
			}
		}

		unset($chrs);

		echo "<table border=\"1\">";
		foreach($strings as $k => $v){
//		foreach($sheetData as $k => $r){
//			if($k < 3) continue;

			$r = explode(";", $v);

			$tstamp = clear($r['0']);
			$art = clear($r['1']);
			$name = clear($r['2']);
			$pic = clear($r['3']);
			$weight = clear($r['4']);
			$inpack = clear($r['5']);
//////
			$material = clear($r['6']);	//270
			$color = clear($r['7']);	//271
			$surface = clear($r['8']);	//272
			$form = clear($r['9']);		//273
			$dyrka = clear($r['10']);	//274
			$diameter = clear($r['11']);//275
			$lenght = clear($r['12']);	//276
			$width = clear($r['13']);	//277
			$tolsh = clear($r['14']);	//278
			$ogranka = clear($r['15']);	//279
			$okraska = clear($r['16']);	//280
//////
			$num = 0 + intval(clear($r['17']));
			$price = 0 + floatval(str_replace(",", ".", $r['18']));
			$priceopt = 0 + floatval(str_replace(",", ".", $r['19']));

			echo "<tr>";
			echo "<td>".$tstamp."</td>";
			echo "<td>".$art."</td>";
			echo "<td>".$name."</td>";
			echo "<td>".$pic."</td>";
			echo "<td>".$weight."</td>";
			echo "<td>".$inpack."</td>";
			echo "<td>".$material."</td>";
			echo "<td style=\"padding-left: 20px\">".$color."</td>";
			echo "<td style=\"padding-left: 20px\">".$surface."</td>";
			echo "<td style=\"padding-left: 20px\">".$form."</td>";
			echo "<td style=\"padding-left: 20px\">".$dyrka."</td>";
			echo "<td style=\"padding-left: 20px\">".$diameter."</td>";
			echo "<td style=\"padding-left: 20px\">".$length."</td>";
			echo "<td style=\"padding-left: 20px\">".$width."</td>";
			echo "<td style=\"padding-left: 20px\">".$tolsh."</td>";
 			echo "<td style=\"padding-left: 20px\">".$ogranka."</td>";
			echo "<td style=\"padding-left: 20px\">".$okraska."</td>";
			echo "<td style=\"padding-left: 20px\">".$num."</td>";
			echo "<td style=\"padding-left: 20px\">".$price."</td>";
			echo "<td style=\"padding-left: 20px\">".$priceopt."</td>";


			die();
			$data = array(
				"cat" => $cat,
				"brand" => $brand,
				"art" => $art,
				"name" => $name,
				"price" => $price,
				"price_usd" => $price_usd,
				"price_eur" => $price_eur,
				"num" => $num,
				"short" => $short,
				"cont" => $cont,
			);

/////////////////////////////////////////
			$prod = $Prod->getone(array("where" => "`art` = '".data_base::nq($art)."'"));
		
			if($prod){
				$data = array(
					"name" => $name,
					"num" => $num,
					"inpack" => $inpack,
					"price" => $price,
					"pic" => $pic,
				);
				$changed = ($prod->num == 0 && $num != 0) ? time() : $prod->changed;

				if($cont)
					$q .= "update dombusin_prod set `name` = '".data_base::nq($name)."', `num` = '".data_base::nq($num)."', `inpack` = '".data_base::nq($inpack)."', `price` = '".data_base::nq($price)."', `priceopt` = '".data_base::nq($priceopt)."', `pic` = '".data_base::nq($pic)."', `cont` = '".data_base::nq($cont)."', `changed` = '".$changed."' where `art` = '".$art."'; ";
				else
					$q .= "update dombusin_prod set `name` = '".data_base::nq($name)."', `num` = '".data_base::nq($num)."', `inpack` = '".data_base::nq($inpack)."', `price` = '".data_base::nq($price)."', `priceopt` = '".data_base::nq($priceopt)."', `pic` = '".data_base::nq($pic)."', `changed` = '".$changed."' where `art` = '".$art."'; ";
	
				$Prodchar->delete(array("where" => "prod = ".$prod->id));

				$qc = "insert into dombusin_prodchar (`char`, `prod`, `charval`, `value`) values 
					('270', '".$prod->id."', '".$chars[270][$material]."', ''),
					('271', '".$prod->id."', '".$chars[271][$color]."', ''),
					('272', '".$prod->id."', '".$chars[272][$surface]."', ''),
					('273', '".$prod->id."', '".$chars[273][$form]."', ''),
					('274', '".$prod->id."', '".$chars[274][$dyrka]."', ''),
					('275', '".$prod->id."', '".$chars[275][$diameter]."', ''),
					('276', '".$prod->id."', '".$chars[276][$lenght]."', ''),
					('277', '".$prod->id."', '".$chars[277][$width]."', ''),
					('278', '".$prod->id."', '".$chars[278][$tolsh]."', ''),
					('279', '".$prod->id."', '".$chars[279][$organka]."', ''),
					('280', '".$prod->id."', '".$chars[280][$okraska]."', '');
				";

				$Prodchar->mq($qc);

                unset($cont);
				echo (++$i).") Товар обновлен - ".$art.". Цена - ".$price.". В упаковке - ".$inpack.". Остатки - ".$num."<br />";
				if($i % 200 == 0){
					echo str_repeat(' ', 1024*64);
					flush();
					ob_flush();

					$Prod->mq($q);
					$q = "";
				}
			}else{
				$data = array(
					"intname" => Func::mkintname(iconv("windows-1251", "utf-8", $r[2])),
					"art" => $art,
					"name" => $name,
					"inpack" => $inpack,
					"num" => $num,
					"price" => $price,
					"izm" => '',
					"pic" => $pic,
					"cont" => $cont,
					"uploaded" => time(),
					"changed" => time(),
				);

				$Prod->insert($data);
				$lastid = $Prod->last_id();

				$Prodchar->delete(array("where" => "prod = ".$lastid));

				$qc = "insert into dombusin_prodchar (`char`, `prod`, `charval`, `value`) values 
					('270', '".$lastid."', '".$chars[270][$material]."', ''),
					('271', '".$lastid."', '".$chars[271][$color]."', ''),
					('272', '".$lastid."', '".$chars[272][$surface]."', ''),
					('273', '".$lastid."', '".$chars[273][$form]."', ''),
					('274', '".$lastid."', '".$chars[274][$dyrka]."', ''),
					('275', '".$lastid."', '".$chars[275][$diameter]."', ''),
					('276', '".$lastid."', '".$chars[276][$lenght]."', ''),
					('277', '".$lastid."', '".$chars[277][$width]."', ''),
					('278', '".$lastid."', '".$chars[278][$tolsh]."', ''),
					('279', '".$lastid."', '".$chars[279][$organka]."', ''),
					('280', '".$lastid."', '".$chars[280][$okraska]."', '');
				";
				$Prodchar->mq($qc);

				if($j) $q2 .= ",\n";
				$q2 .= "('".data_base::nq(Func::mkintname(iconv("windows-1251", "utf-8", $r[2])))."', '".$art."', '".data_base::nq($name)."', '".$inpack."', '".$num."', '".$price."', '".$priceopt."', '', '".$pic."', '".data_base::nq($cont)."', '".time()."', '".time()."')";
				$Relation->insert(array("type" => "cat-prod", "obj" => "-1", "relation" => $lastid));
				echo (++$i).") Товар добавлен - ".$art.". Цена - ".$price.". В упаковке - ".$inpack.". Остатки - ".$num."<br />";

				if($j++ % 200 == 0){
					echo str_repeat(' ',1024*64);
					flush();
					ob_flush();
					$q2 = "";
				}
			}
		}
		if($q) $Prod->mq($q);
		echo "<br /><br /><a href=\"adm_import_1c.php\">Назад</a>";
	}elseif($_POST['submit2']){
		$Prod = new Model_Prod();


		foreach($_FILES['ff2']['name'] as $k => $v){
			$prod = $Prod->getone(array("where" => "pic = '".$v."'"));
			if($prod->id){
				move_uploaded_file($_FILES['ff2']['tmp_name'][$k], "../pic/prod/".$prod->id.".jpg");
				copy("../pic/prod/".$prod->id.".jpg", "../pic/prodbig/".$prod->id.".jpg");
				$Watermark = new AS_Watermark("../pic/prod/".$prod->id.".jpg");
			    $Watermark->dst = "../pic/prod/".$prod->id.".jpg";
				$Watermark->add(2);
				
				echo $v." --- <a href=\"/pic/prod/".$prod->id.".jpg\" target=\"_blank\">/pic/prod/".$prod->id.".jpg</a><br>";
//				if($i % 20 == 0){
//				    echo str_repeat(' ',1024*64);
//				sleep(1);
//					flush();
//					ob_flush();
//				}
				$outputcache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array("pic_prod_".$prod->id."_jpg"));
			}
		}

		echo "<br /><br /><a href=\"adm_import_1c.php\">Назад</a>";
		die();
	}else{?>
<div style="margin: 20px;">
<h2>Импорт данных из 1С</h2>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="ff" />
	<input type="submit" name="submit" value="Импортировать" />
</form>
</div>

<div style="margin: 20px;">
<h2>Загрузка фото</h2>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" min="1" max="9999" name="ff2[]" multiple="true" />
	<input type="submit" name="submit2" value="Импортировать" />
</form>
</div>
<?	}

	echo $view->render('foot.php');