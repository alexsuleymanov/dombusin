<?
	include '../app/lib/PHPExcel/IOFactory.php';
	set_time_limit(0);
	ob_implicit_flush(1);

//	header("Content-Type: text/html; charset=windows-1251");
	header("Content-Type: text/html; charset=utf-8");
	include("adm_incl.php");
	echo $view->render('head.php');

	if($_POST['submit'] || $_POST['submit2'] || $_POST['submit3']){
		$Prod = new Model_Prod();
		$Relation = new Model_Relation();

		$objPHPExcel = PHPExcel_IOFactory::load($_FILES['ff']['tmp_name']);
		
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		echo "<table border=\"1\">";
		foreach($sheetData as $k => $r){
//			if($k == 1) continue;
			echo "<tr>";
			echo "<td>".$r['A']."</td>";
			echo "<td>".$r['B']."</td>";
			echo "<td>".$r['C']."</td>";
			echo "<td>".$r['D']."</td>";
			echo "<td>".$r['E']."</td>";
			echo "<td>".$r['F']."</td>";
			echo "<td style=\"padding-left: 20px\">".$r['G']."</td>";
			echo "<td style=\"padding-left: 20px\">".$r['H']."</td>";
			echo "<td style=\"padding-left: 20px\">".$r['K']."</td>";
			echo "<td style=\"padding-left: 20px\">".$r['L']."</td>";


			$cat = intval($r['A']);
			$brand = intval($r['B']);
			$art = trim($r['C']);
			$name = $r['D'];
			$price = 0 + floatval(str_replace(",", ".", $r['E']));
			$price_usd = 0 + floatval(str_replace(",", ".", $r['F']));
			$price_eur = 0 + floatval(str_replace(",", ".", $r['G']));
			$num = 0 + intval(str_replace(",", ".", $r['H']));
			$short = $r['I'];
			$cont = $r['J'];
			$photo = $r['K'];
			$photos = str_replace(";", ",", $r['L']);

			echo "</tr>";
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

			if($Prod->getnum(array("where" => "art = '".$art."'"))){
				$Prod->update($data, array("where" => "art = '".$art."'"));
//				echo (++$i).") Товар обновлен --- ".$art." - ".$name.". Цена - ".$price."<br />";
				$prod_id = $Prod->getone(array("where" => "art = '".$art."'"))->id;
			}else{
				if(is_int($brand) && is_int($cat)){
					$Prod->insert($data, array("where" => "art = '".$art."'"));
//					echo (++$i).") Товар добавлен --- ".$art." - ".$name.". Цена - ".$price."<br />";
					$prod_id = $Prod->last_id();
				}
			}			

//			echo $prod_id."---".$photo."---".$photos."<br />";


//			if($_POST['submit2'] || $_POST['submit3']){
//				if($_POST['submit3']){

//			echo $prod_id."---".$photo."--- ---".$photos."<br />";

				$Prod = new Model_Prod();
				$Photo = new Model_Photo();
				if(!empty($photos)){
					$old_photos = $Photo->getall(array("where" => "`type` = 'prod' and par = '".$prod_id."'"));
					foreach($old_photos as $k => $v){
						if(file_exists($path."/pic/photo/".$v->id.".jpg")) unlink($path."/pic/photo/".$v->id.".jpg");
						$Photo->delete(array("where" => "id = '".$v->id."'"));						
					}
				}

				if(!empty($photo))
					if(file_exists($path."/pic/prod/".$prod_id.".jpg")) unlink($path."/pic/prod/".$prod_id.".jpg");
//				}
		


				if(!empty($photo) && file_exists($path."/pic/!photo/".$photo)){
					$ir = new imageresizer;
					$ir->src = $path."/pic/!photo/".$photo;
					$ir->dst = $path."/pic/prod/".$prod_id.".jpg";

					$ftypes = array(1 => "gif", 2 => "jpg", 3 => "png", 4 => "swf", 5 => "psd", 6 => "bmp");
					$ims = getimagesize($path."/pic/!photo/".$photo);
					$ftype = $ftypes[$ims[2]];

					$ir->type = $ftype;
					$ir->outtype = 'jpg';
				
					$sz = getimagesize($ir->src);
			
					$ir->dstw = $sz[0];
					$ir->dsth = $sz[1];
		
					$ir->resize();
				}

				if(!empty($photos)){
					$phts = explode(",", $photos);				

					foreach($phts as $photo){
						if(file_exists($path."/pic/!photo/".$photo)){
							$Photo = new Model_Photo();
							$Photo->insert(array("type" => "prod", "par" => $prod_id));
							$photo_id = $Photo->last_id();

//							echo "<br />".$photo_id."---".$photo."<br />";

							$ir = new imageresizer;
							$ir->src = $path."/pic/!photo/".$photo;
							$ir->dst = $path."/pic/photo/".$photo_id.".jpg";

							$ftypes = array(1 => "gif", 2 => "jpg", 3 => "png", 4 => "swf", 5 => "psd", 6 => "bmp");
							$ims = getimagesize($path."/pic/!photo/".$photo);
							$ftype = $ftypes[$ims[2]];

							$ir->type = $ftype;
							$ir->outtype = 'jpg';
		
							$sz = getimagesize($ir->src);

							$ir->dstw = $sz[0];
							$ir->dsth = $sz[1];

							$ir->resize();
						}
					}
				}

//			}

			if($i % 100 == 0){
				echo str_repeat(' ',1024*64);
				flush();
				ob_flush();
			}
		}
		echo "<br /><br /><a href=\"adm_import.php\">Назад</a>";
	}else{?>
<div style="margin: 20px;">
<h2>Импорт данных из CSV</h2>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="ff" />
	<input type="submit" name="submit" value="Импортировать" />
</form>
</div>
<?/*
<div style="margin: 20px;">
<h2>Добавить новые фотографии</h2>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="ff" />
	<input type="submit" name="submit2" value="Импортировать" />
</form>
</div>

<div style="margin: 20px;">
<h2>Обновить фотографии</h2>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="ff" />
	<input type="submit" name="submit3" value="Импортировать" />
</form>
</div>
*/?>
<?	}

	echo $view->render('foot.php');