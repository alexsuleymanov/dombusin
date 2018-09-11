<?
	error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
	ini_set("display_errors", 1);

	set_time_limit(0);

	header("Content-Type: text/html; charset=utf-8");
	include("adm_incl.php");

	function clear($str){
		return str_replace("\"\"", "\"", trim(iconv("windows-1251", "utf-8", $str), " \t\n\r\0\""));
	}

	function fmtmoney($str){
		return 0 + floatval(str_replace(",", ".", str_replace("\xA0", "", $str)));
	}

	echo $view->render('head.php');

	if($_POST['submit']){
//		$csv = fopen($_FILES['ff']['tmp_name'], "r");
		$strings = ($_POST['full']) ? file($_FILES['ff3']['tmp_name']) : file($_FILES['ff']['tmp_name']);
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

//		$objPHPExcel = PHPExcel_IOFactory::load($_FILES['ff']['tmp_name']);
		
//		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		$chrs = $Char->getall(array("where" => "cat = 0"));
		foreach($chrs as $k => $v){
			$chars[$v->id] = array();
			$cv = $Charval->getall(array("where" => "`char` = ".$v->id));
			foreach($cv as $kk => $vv){
				$chars[$v->id][$vv->value] = $vv->id;
			}
		}

//		print_r($chars); die();
//		unset($chrs);

//		echo "<table border=\"1\">";
		foreach($strings as $k => $v){
//		foreach($sheetData as $k => $r){
			if($k < 1) continue;
//			if($k > 40) die();

			$r = explode(";", $v);

			$tstamp = clear($r['0']);
			$art = clear($r['1']);
			$name = clear($r['2']);
			$pic = clear($r['3']);
			$weight = clear($r['4']);
			$inpack = clear($r['5']);
//////
			$okraska = clear($r['6']);	//297
			$material = clear($r['7']);	//270
			$color = clear($r['8']);	//288
			$surface = clear($r['9']);  //272
			$form = clear($r['10']);	//287
			$dyrka = clear($r['11']);	//274
			$diameter = clear($r['12']);//275
			$lenght = clear($r['13']);	//276
			$width = clear($r['14']);	//277
			$tolsh = clear($r['15']);	//278
			$ogranka = clear($r['16']);	//279			
			$vid = clear($r['17']);		//284
			$brand = clear($r['18']);	//282
			$tema = clear($r['19']);	//281
			$type = clear($r['20']);	//283
			
			$fasovka = clear($r['21']);	//302
			$brand2 = clear($r['22']);	//318
			$vstavka = clear($r['23']);	//310
			$stone_material = clear($r['24']);	//311
			$primenenie = clear($r['25']);	//312
			$svoistvo_kamnia = clear($r['26']);	//313
			$seria = clear($r['27']);	//314
			$style = clear($r['28']);	//315
			$otv_form = clear($r['29']);	//316
			$palitra = clear($r['30']);	//309
			$size = clear($r['31']);	//298
			$color_num = clear($r['32']);	//317
            
			if(!($okraska_val = $chars[297][$okraska]) && !empty($okraska)){
				$Charval->insert(array("char" => 297, "value" => $okraska, "visible" => 1));
				$okraska_val = $Charval->last_id();
				$chars[297][$okraska] = $okraska_val;
			}
			if(!($material_val = $chars[270][$material]) && !empty($material)){
				$Charval->insert(array("char" => 270, "value" => $material, "visible" => 1));
				$material_val = $Charval->last_id();
				$chars[270][$material] = $material_val;
			}
/*			echo $k.") ";
			echo $material." - ".$chars[270][$material]." -- ";
			print_r($chars[270]);
			echo "<br />";
			echo "val: ".$material_val; echo "<br />";*/

			if(!($color_val = $chars[288][$color]) && !empty($color)){
				$Charval->insert(array("char" => 288, "value" => $color, "visible" => 1));
				$color_val = $Charval->last_id();
				$chars[288][$color] = $color_val;
			}
			if(!($surface_val = $chars[272][$surface]) && !empty($surface)){
				$Charval->insert(array("char" => 272, "value" => $surface, "visible" => 1));
				$surface_val = $Charval->last_id();
				$chars[272][$surface] = $surface_val;
			}
			if(!($form_val = $chars[287][$form]) && !empty($form)){
				$Charval->insert(array("char" => 287, "value" => $form, "visible" => 1));
				$form_val = $Charval->last_id();
				$chars[287][$form] = $form_val;
			}
			if(!($dyrka_val = $chars[274][$dyrka]) && !empty($dyrka)){
				$Charval->insert(array("char" => 274, "value" => $dyrka, "visible" => 1));
				$dyrka_val = $Charval->last_id();
				$chars[274][$dyrka] = $dyrka_val;
			}
			if(!($diameter_val = $chars[275][$diameter]) && !empty($diameter)){
				$Charval->insert(array("char" => 275, "value" => $diameter, "visible" => 1));
				$diameter_val = $Charval->last_id();
				$chars[275][$diameter] = $diameter_val;
			}
			if(!($lenght_val = $chars[276][$lenght]) && !empty($lenght)){
				$Charval->insert(array("char" => 276, "value" => $lenght, "visible" => 1));
				$lenght_val = $Charval->last_id();
				$chars[276][$lenght] = $lenght_val;
			}
			if(!($width_val = $chars[277][$width]) && !empty($width)){
				$Charval->insert(array("char" => 277, "value" => $width, "visible" => 1));
				$width_val = $Charval->last_id();
				$chars[277][$width] = $width_val;
			}
			if(!($tolsh_val = $chars[278][$tolsh]) && !empty($tolsh)){
				$Charval->insert(array("char" => 278, "value" => $tolsh, "visible" => 1));
				$tolsh_val = $Charval->last_id();
				$chars[278][$tolsh] = $tolsh_val;
			}
			if(!($ogranka_val = $chars[279][$ogranka]) && !empty($ogranka)){
				$Charval->insert(array("char" => 279, "value" => $ogranka, "visible" => 1));
				$ogranka_val = $Charval->last_id();
				$chars[279][$ogranka] = $ogranka_val;
			}
			if(!($vid_val = $chars[284][$vid]) && !empty($vid)){
				$Charval->insert(array("char" => 284, "value" => $vid, "visible" => 1));
				$vid_val = $Charval->last_id();
				$chars[284][$vid] = $vid_val;
			}
			if(!($brand_val = $chars[282][$brand]) && !empty($brand)){
				$Charval->insert(array("char" => 282, "value" => $brand, "visible" => 1));
				$brand_val = $Charval->last_id();
				$chars[282][$brand] = $brand_val;
			}
			if(!($tema_val = $chars[281][$tema]) && !empty($tema)){
				$Charval->insert(array("char" => 281, "value" => $tema, "visible" => 1));
				$tema_val = $Charval->last_id();
				$chars[281][$tema] = $tema_val;
			}
			if(!($type_val = $chars[283][$type]) && !empty($type)){
				$Charval->insert(array("char" => 283, "value" => $type, "visible" => 1));
				$type_val = $Charval->last_id();
				$chars[283][$type] = $type_val;
			}
			if(!($fasovka_val = $chars[302][$fasovka]) && !empty($fasovka)){
				$Charval->insert(array("char" => 302, "value" => $fasovka, "visible" => 1));
				$fasovka_val = $Charval->last_id();
				$chars[302][$fasovka] = $fasovka_val;
			}
			if(!($brand2_val = $chars[318][$brand2]) && !empty($brand2)){
				$Charval->insert(array("char" => 318, "value" => $brand2, "visible" => 1));
				$brand2_val = $Charval->last_id();
				$chars[318][$brand2] = $brand2_val;
			}
			if(!($vstavka_val = $chars[310][$vstavka]) && !empty($vstavka)){
				$Charval->insert(array("char" => 310, "value" => $vstavka, "visible" => 1));
				$vstavka_val = $Charval->last_id();
				$chars[310][$vstavka] = $vstavka_val;
			}
			if(!($stone_material_val = $chars[311][$stone_material]) && !empty($stone_material)){
				$Charval->insert(array("char" => 311, "value" => $stone_material, "visible" => 1));
				$stone_material_val = $Charval->last_id();
				$chars[311][$stone_material] = $stone_material_val;
			}
			if(!($primenenie_val = $chars[312][$primenenie]) && !empty($primenenie)){
				$Charval->insert(array("char" => 312, "value" => $primenenie, "visible" => 1));
				$primenenie_val = $Charval->last_id();
				$chars[312][$primenenie] = $primenenie_val;
			}
			if(!($svoistvo_kamnia_val = $chars[313][$svoistvo_kamnia]) && !empty($svoistvo_kamnia)){
				$Charval->insert(array("char" => 313, "value" => $svoistvo_kamnia, "visible" => 1));
				$svoistvo_kamnia_val = $Charval->last_id();
				$chars[313][$svoistvo_kamnia] = $svoistvo_kamnia_val;
			}
			if(!($seria_val = $chars[314][$seria]) && !empty($seria)){
				$Charval->insert(array("char" => 314, "value" => $seria, "visible" => 1));
				$seria_val = $Charval->last_id();
				$chars[314][$seria] = $seria_val;
			}
			if(!($style_val = $chars[315][$style]) && !empty($style)){
				$Charval->insert(array("char" => 315, "value" => $style, "visible" => 1));
				$style_val = $Charval->last_id();
				$chars[315][$style] = $style_val;
			}
			if(!($otv_form_val = $chars[316][$otv_form]) && !empty($otv_form)){
				$Charval->insert(array("char" => 316, "value" => $otv_form, "visible" => 1));
				$otv_form_val = $Charval->last_id();
				$chars[316][$otv_form] = $otv_form_val;
			}
			if(!($palitra_val = $chars[309][$palitra]) && !empty($palitra)){
				$Charval->insert(array("char" => 309, "value" => $palitra, "visible" => 1));
				$palitra_val = $Charval->last_id();
				$chars[309][$palitra] = $palitra_val;
			}
			if(!($size_val = $chars[298][$size]) && !empty($size)){
				$Charval->insert(array("char" => 298, "value" => $size, "visible" => 1));
				$size_val = $Charval->last_id();
				$chars[298][$size] = $size_val;
			}
			if(!($color_num_val = $chars[317][$color_num]) && !empty($color_num)){
				$Charval->insert(array("char" => 317, "value" => $color_num, "visible" => 1));
				$color_num_val = $Charval->last_id();
				$chars[317][$color_num] = $color_num_val;
			}
//			echo "asdf".$form_val."11";die();
/*			$num = 0 + intval(clear($r['36']));
			$price = fmtmoney($r['37']);
			$priceopt = fmtmoney($r['38']);
			$cont = clear($r['39']);*/

			$inpack = clear($r['38']);
			$inpack2 = clear($r['42']);
			$inpack3 = clear($r['46']);
			$inpack4 = 0;// + intval(clear($r['50']));
			
			$num = 0 + intval(clear($r['48']));
			$num2 = 0 + intval(clear($r['49']));
			$num3 = 0 + intval(clear($r['50']));
			$num4 = 0;// + intval(clear($r['5']));
			
			$price = fmtmoney($r['51']);
			$price2 = fmtmoney($r['52']);
			$price3 = fmtmoney($r['53']);
			$price4 = 0;//fmtmoney($r['55']);
			
			$priceopt = fmtmoney($r['54']);
			$priceopt2 = fmtmoney($r['55']);
			$priceopt3 = fmtmoney($r['56']);
			$priceopt4 = 0;//fmtmoney($r['59']);
			
			$weight = fmtmoney($r['39']);
			$weight2 = fmtmoney($r['43']);
			$weight3 = fmtmoney($r['47']);
			$weight4 = 0;//fmtmoney($r['51']);
			
			$cont = clear($r['57']);

//			print_r($chars); die();	
/*			echo "<tr>";
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

			echo $qc;
			die();*/
			
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
				"pic" => $pic,
			);

/////////////////////////////////////////
			$prod = $Prod->getone(array("where" => "`art` = '".data_base::nq($art)."'"));
		
			if($prod){
			/*	$data = array(
					"name" => $name,
					"num" => $num,
					"inpack" => $inpack,
					"price" => $priceopt,
					"pic" => $pic,
				);*/
				$changed = ($prod->num == 0 && $num != 0) ? time() : $prod->changed;

				if($cont)
					$q .= "update dombusin_prod set `name` = '".data_base::nq($name)."', `num` = '".data_base::nq($num)."', `num2` = '".data_base::nq($num2)."', `num3` = '".data_base::nq($num3)."', `num4` = '".data_base::nq($num4)."', `inpack` = '".data_base::nq($inpack)."', `inpack2` = '".data_base::nq($inpack2)."', `inpack3` = '".data_base::nq($inpack3)."', `inpack4` = '".data_base::nq($inpack4)."', `price` = '".data_base::nq($price)."', `price2` = '".data_base::nq($price2)."', `price3` = '".data_base::nq($price3)."', `price4` = '".data_base::nq($price4)."', `weight` = '".data_base::nq($weight)."', `weight2` = '".data_base::nq($weight2)."', `weight3` = '".data_base::nq($weight3)."', `weight4` = '".data_base::nq($weight4)."', `pic` = '".data_base::nq($pic)."', `cont` = '".data_base::nq($cont)."', `changed` = '".$changed."' where `art` = '".$art."'; ";
				else
					$q .= "update dombusin_prod set `name` = '".data_base::nq($name)."', `num` = '".data_base::nq($num)."', `num2` = '".data_base::nq($num2)."', `num3` = '".data_base::nq($num3)."', `num4` = '".data_base::nq($num4)."', `inpack` = '".data_base::nq($inpack)."', `inpack2` = '".data_base::nq($inpack2)."', `inpack3` = '".data_base::nq($inpack3)."', `inpack4` = '".data_base::nq($inpack4)."', `price` = '".data_base::nq($price)."', `price2` = '".data_base::nq($price2)."', `price3` = '".data_base::nq($price3)."', `price4` = '".data_base::nq($price4)."', `weight` = '".data_base::nq($weight)."', `weight2` = '".data_base::nq($weight2)."', `weight3` = '".data_base::nq($weight3)."', `weight4` = '".data_base::nq($weight4)."', `pic` = '".data_base::nq($pic)."', `changed` = '".$changed."' where `art` = '".$art."'; ";
	
				if($_POST['full']){
					$Prodchar->delete(array("where" => "prod = ".$prod->id));

					
//					print_r($chars);
//					echo "<br />";
					$qc = "insert into dombusin_prodchar (`char`, `prod`, `charval`, `value`) values 
						('297', '".$prod->id."', '".$chars[297][$okraska]."', ''),
						('270', '".$prod->id."', '".$chars[270][$material]."', ''),
						('288', '".$prod->id."', '".$chars[288][$color]."', ''),
						('272', '".$prod->id."', '".$chars[272][$surface]."', ''),
						('287', '".$prod->id."', '".$chars[287][$form]."', ''),
						('274', '".$prod->id."', '".$chars[274][$dyrka]."', ''),
						('275', '".$prod->id."', '".$chars[275][$diameter]."', ''),
						('276', '".$prod->id."', '".$chars[276][$lenght]."', ''),
						('277', '".$prod->id."', '".$chars[277][$width]."', ''),
						('278', '".$prod->id."', '".$chars[278][$tolsh]."', ''),
						('279', '".$prod->id."', '".$chars[279][$ogranka]."', ''),
						('284', '".$prod->id."', '".$chars[284][$vid]."', ''),
						('282', '".$prod->id."', '".$chars[282][$brand]."', ''),
						('281', '".$prod->id."', '".$chars[281][$tema]."', ''),
						('283', '".$prod->id."', '".$chars[283][$type]."', ''),
						('302', '".$prod->id."', '".$chars[302][$fasovka]."', ''),
						('318', '".$prod->id."', '".$chars[318][$brand2]."', ''),
						('310', '".$prod->id."', '".$chars[310][$vstavka]."', ''),
						('311', '".$prod->id."', '".$chars[311][$stone_material]."', ''),
						('312', '".$prod->id."', '".$chars[312][$primenenie]."', ''),
						('313', '".$prod->id."', '".$chars[313][$svoistvo_kamnia]."', ''),
						('314', '".$prod->id."', '".$chars[314][$seria]."', ''),
						('315', '".$prod->id."', '".$chars[315][$style]."', ''),
						('316', '".$prod->id."', '".$chars[316][$otv_form]."', ''),
						('309', '".$prod->id."', '".$chars[309][$palitra]."', ''),
						('298', '".$prod->id."', '".$chars[298][$size]."', ''),
						('317', '".$prod->id."', '".$chars[317][$color_num]."', '');
					";

					$Prodchar->mq($qc);
				}

				if(++$i % 10 == 0){
					echo str_repeat(' ', 1024*64);
					flush();
					ob_flush();

					$Prod->mq($q);
					$q = "";
				}

//				$Prod->mq($q);

//				echo $q."<br /><br />";
//                unset($cont);
				echo ($i).") Товар обновлен - ".$art."(".$prod->id."). Цена - ".$price.". В упаковке - ".$inpack.". Остатки - ".$num.". Картинка - ".$pic."<br />";

//				die();
			}else{
				$data = array(
					"intname" => Func::mkintname(iconv("windows-1251", "utf-8", $r[2])),
					"art" => $art,
					"name" => $name,
					"inpack" => $inpack,
					"inpack2" => $inpack2,
					"inpack3" => $inpack3,
					"inpack4" => $inpack4,
					"num" => $num,
					"num2" => $num2,
					"num3" => $num3,
					"num4" => $num4,
					"price" => $price,
					"price2" => $price2,
					"price3" => $price3,
					"price4" => $price4,
					"weight" => $weight,
					"weight2" => $weight2,
					"weight3" => $weight3,
					"weight4" => $weight4,
					"izm" => '',
					"pic" => $pic,
					"cont" => $cont,
					"uploaded" => time(),
					"changed" => time(),
				);

				$Prod->insert($data);
				$lastid = $Prod->last_id();

				if($_POST['full']){
					$Prodchar->delete(array("where" => "prod = ".$lastid));

					$qc = "insert into dombusin_prodchar (`char`, `prod`, `charval`, `value`) values 
						('297', '".$prod->id."', '".$chars[297][$okraska]."', ''),
						('270', '".$prod->id."', '".$chars[270][$material]."', ''),
						('288', '".$prod->id."', '".$chars[288][$color]."', ''),
						('272', '".$prod->id."', '".$chars[272][$surface]."', ''),
						('287', '".$prod->id."', '".$chars[287][$form]."', ''),
						('274', '".$prod->id."', '".$chars[274][$dyrka]."', ''),
						('275', '".$prod->id."', '".$chars[275][$diameter]."', ''),
						('276', '".$prod->id."', '".$chars[276][$lenght]."', ''),
						('277', '".$prod->id."', '".$chars[277][$width]."', ''),
						('278', '".$prod->id."', '".$chars[278][$tolsh]."', ''),
						('279', '".$prod->id."', '".$chars[279][$ogranka]."', ''),
						('284', '".$prod->id."', '".$chars[284][$vid]."', ''),
						('282', '".$prod->id."', '".$chars[282][$brand]."', ''),
						('281', '".$prod->id."', '".$chars[281][$tema]."', ''),
						('283', '".$prod->id."', '".$chars[283][$type]."', ''),
						('302', '".$prod->id."', '".$chars[302][$fasovka]."', ''),
						('318', '".$prod->id."', '".$chars[318][$brand2]."', ''),
						('310', '".$prod->id."', '".$chars[310][$vstavka]."', ''),
						('311', '".$prod->id."', '".$chars[311][$stone_material]."', ''),
						('312', '".$prod->id."', '".$chars[312][$primenenie]."', ''),
						('313', '".$prod->id."', '".$chars[313][$svoistvo_kamnia]."', ''),
						('314', '".$prod->id."', '".$chars[314][$seria]."', ''),
						('315', '".$prod->id."', '".$chars[315][$style]."', ''),
						('316', '".$prod->id."', '".$chars[316][$otv_form]."', ''),
						('309', '".$prod->id."', '".$chars[309][$palitra]."', ''),
						('298', '".$prod->id."', '".$chars[298][$size]."', ''),
						('317', '".$prod->id."', '".$chars[317][$color_num]."', '');
					";
					$Prodchar->mq($qc);
				}

				if($j) $q2 .= ",\n";
				$q2 .= "('".data_base::nq(Func::mkintname(iconv("windows-1251", "utf-8", $r[2])))."', '".$art."', '".data_base::nq($name)."', '".$inpack."', '".$num."', '".$price."', '".$priceopt."', '', '".$pic."', '".data_base::nq($cont)."', '".time()."', '".time()."')";
				$Relation->insert(array("type" => "cat-prod", "obj" => "-1", "relation" => $lastid));
				echo (++$i).") Товар добавлен - ".$art.". Цена - ".$price.". В упаковке - ".$inpack.". Остатки - ".$num."<br />";

				if($j++ % 50 == 0){
					echo str_repeat(' ',1024*64);
					flush();
					ob_flush();

					$q2 = "";
				}
			}
			unset($strings[$k]);
		}
		if($q) $Prod->mq($q);
//		if($q2) $Prod->mq($q2);
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
//				$outputcache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array("pic_prod_".$prod->id."_jpg"));
			}
		}

		echo "<br /><br /><a href=\"adm_import_1c.php\">Назад</a>";
		die();
	}elseif($_POST['submit4']){
		$Prod = new Model_Prod();
		$strings = file($_FILES['ff4']['tmp_name']);
		$j = 0;
		
		foreach($strings as $k => $v){
			if($k < 1) continue;

			$r = explode(";", $v);
			$art = clear($r[0]);
			$skidka = clear($r[1]);

			$q .= "update dombusin_prod set `skidka` = '".data_base::nq($skidka)."' where `art` = '".data_base::nq($art)."'; ";
			if($j++ % 50 == 0){
				echo str_repeat(' ',1024*64);
				flush();
				ob_flush();
				$Prod->mq($q);
				echo $q;
				$q = "";				
			}
			echo $art."| - ".$skidka."<br />";
//			$Prod->update(array('skidka' => $skidka), array("where" => "art = '".data_base::nq($r[0])."'"));
		}
		if($q){
			echo str_repeat(' ',1024*64);
			flush();
			ob_flush();
			$Prod->mq($q);
			echo $q;
			$q = "";							
		}
		echo "Импорт завершен. ".$j." позиций";
		echo "<br /><br /><a href=\"adm_import_1c.php\">Назад</a>";
		die();
	}elseif($_POST['submit5']){
		$Prod = new Model_Prod();
		$prods = $Prod->getall(array("where" => "art like '% %'"));
		foreach($prods as $prod){
			$q .= "update dombusin_prod set `art` = '".trim($prod->art)."' where id = ".$prod->id."; ";
			if($j++ % 50 == 0){
				echo str_repeat(' ',1024*64);
				flush();
				ob_flush();
				$Prod->mq($q);
				$q = "";
			}
			echo $prod->id." - ".$prod->art."<br />";
			
		}
	}else{?>
<div style="margin: 20px;">
<h2>Обновление цен и остатков из 1С</h2>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="ff" />
	<input type="submit" name="submit" value="Импортировать" />
</form>
</div>

<div style="margin: 20px;">
<h2>Полный импорт данных из 1С</h2>
<form action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="full" value="1" />
	<input type="file" name="ff3" />
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

<div style="margin: 20px;">
<h2>Загрузка акций</h2>
<form action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="new" value="1" />
	<input type="file" name="ff4" />
	<input type="submit" name="submit4" value="Импортировать" />
</form>
</div>

<?/*
<div style="margin: 20px;">
<h2>Обновление http://www.dombusin.com/export.xml</h2>
<a target="_blank" href="/price/xml">Обновить price.xml</a>
</div>
*/?>
<?	}

	echo $view->render('foot.php');