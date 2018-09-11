<?	
//	error_reporting(E_ALL);
//	ini_set("display_errors", 1);

	function clear($str){
		return htmlspecialchars(iconv("UTF-8", "WINDOWS-1251", $str));
	}

	function fmtmoney($money) {
		return sprintf("%0.2f", $money);
	}
		
	function charval($charval){	
		$cv = array();
		if(preg_match("/(\d+[\.]?\d*?[*|\-|x|\.|~]?\d*?[\.]?\d*?)\s*?([a-z|A-Z|�-�|�-�]+)/", clear($charval), $m)){
			$cv['val'] = $m[1];
			$cv['ed_izm'] = $m[2];
			return $cv;
		}else{
			return false;
		}
	}

	$Cat = new Model_Cat();
	$cats = $Cat->getall(array("where" => "notinxml = 0 and visible != 0", "order" => "prior desc"));

	$Prod = new Model_Prod();
	$prods = $Prod->getallforexport();

	if($args[1] == 'test'){
		header('Content-type: text/html; charset=windows-1251', true);

		$Charval = new Model_Charval();
		$charval = $Charval->getall();
		foreach($charval as $k => $v){
			$cv = charval($v->value);
			echo clear($v->value).": ".$cv['val']."(".$cv['ed_izm'].")<br />";
			unset($m);
			unset($val);
			unset($ed_izm);
		}
	}

	if($args[1] == 'prom'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';
		echo '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
?>
		<yml_catalog date="<?=date("Y-m-d H:i", time());?>">
			<shop>
				<name><?=clear($sett['sitename'])?></name>
				<company><?=clear($sett['sitename'])?></company>
				<url>http://<?=$_SERVER['HTTP_HOST']?></url>
				<platform>AS-Commerce</platform>
				<version>2.0</version>
				<currencies>
					<currency id="UAH" rate="1"/>
				</currencies>

				<categories>
<?
		foreach($cats as $k => $cat){?>
					<category id="<?=$cat->id?>" <?if($cat->id){?>parentId="<?=$cat->cat?>"<?}?>><?=iconv("UTF-8", "WINDOWS-1251", $cat->name)?></category>
<?		}?>
				</categories>
				<offers>
<?		foreach($prods as $k => $prod){
			echo "<offer id=\"".$prod->id."\" available=\"true\"> <url>http://".$_SERVER['HTTP_HOST']."/catalog/prod-".$prod->id."</url> <price>".Func::fmtmoney($prod->price)."</price> <currencyId>UAH</currencyId> <categoryId>".$prod->cat."</categoryId> <picture>http://".$_SERVER['HTTP_HOST']."/pic/prod/".$prod->id.".jpg</picture> <name>".clear($prod->name)."</name> <vendor>".clear($prod->brandname)."</vendor> <description>".clear($prod->cont)."</description> </offer> ";
		}?>
				</offers>
			</shop>
		</yml_catalog>
<?		die();
	}

	if($args[1] == 'priceua'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';?>
<price date="<?=date("Y-m-d H:i", time());?>">
<name><?=$sett['sitename']?></name>

<currency code="UAH" rate="1"></currency>

<catalog>
<?		foreach($cats as $k => $cat){
			if($cat->cat){?>
	<category id="<?=$cat->id?>"><?=iconv("UTF-8", "WINDOWS-1251", $cat->name)?></category>
<?			}else{?>
	<category id="<?=$cat->id?>" parentID="<?=$cat->cat?>"><?=iconv("UTF-8", "WINDOWS-1251", $cat->name)?></category>
<?			}
		}?>
</catalog>

<items>
<?		foreach($prods as $prod){
			$Brand = new Model_Brand($prod->brand);
			$brand = $Brand->get($prod->brand);
?>
	<item id="<?=$prod->id?>">
	<name><?=iconv("UTF-8", "WINDOWS-1251", $prod->name)?></name>
	<categoryId><?=$prod->cat?></categoryId>
	<price><?=$prod->price?></price>
	<bnprice><?=$prod->price?></bnprice>
	<url>http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?=$prod->id?></url>
	<image>http://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?=$prod->id?>.jpg</image>
	<vendor><?=iconv("UTF-8", "WINDOWS-1251", $brand->name)?></vendor>
	<description><?=iconv("UTF-8", "WINDOWS-1251", $prod->short)?></description>
	</item>
<?		}?>
</items>
</price>
<?	}elseif($args[1] == 'hotline'){
		header('Content-type: text/xml; charset=utf-8', true);
		echo '<?xml version="1.0" encoding="utf-8"'.'?'.'>';?>
<price>
    <date><?=date("Y-m-d H:i", time());?></date>
    <firmName><?=$sett['sitename']?></firmName>
    <firmId>1234</firmId>

<categories>
<?		foreach($cats as $k => $cat){?>
	<category>
		<id><?=$cat->id?></id>
		<name><?=htmlspecialchars($cat->name)?></name>
<?			if($cat->cat == 0){?>
<?			}else{?>
		<parentId><?=$cat->cat?></parentId>
<?			}?>
	</category>
<?		}?>
</categories>

<items>
<?		foreach($prods as $prod){
			$Brand = new Model_Brand($prod->brand);
			$brand = $Brand->get($prod->brand);
?>
	<item>
		<id><?=$prod->id?></id>
		<categoryId><?=$prod->cat?></categoryId>
<?/*		<code><?=$prod->intname?></code>*/?>
		<vendor><?=htmlspecialchars($brand->name)?></vendor>
		<name><?=htmlspecialchars($prod->name)?></name>
		<description><?=strip_tags(htmlspecialchars($prod->short))?></description>
		<url>http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?=$prod->id?></url>
		<image>http://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?=$prod->id?>.jpg</image>
		<priceRUAH><?=fmtmoney($prod->price)?></priceRUAH>
	</item>
<?		}?>
</items>
</price>
<?	}elseif($args[1] == 'pn'){
		header('Content-type: text/xml; charset=utf-8', true);
		echo '<?xml version="1.0" encoding="utf-8"'.'?'.'>';?>
<price date="<?=date("Y-m-d H:i", time());?>">
<name><?=$sett['sitename']?></name>

<currency code="UAH" rate="1"></currency>

<catalog>
<?		foreach($cats as $k => $cat){
			if($cat->cat == 0){?>
	<category id="<?=$cat->id?>"><?=htmlspecialchars($cat->name)?></category>
<?			}else{?>
	<category id="<?=$cat->id?>" parentID="<?=$cat->cat?>"><?=htmlspecialchars($cat->name)?></category>
<?			}
		}?>
</catalog>

<items>
<?		foreach($prods as $prod){
			$Brand = new Model_Brand($prod->brand);
			$brand = $Brand->get($prod->brand);
?>
	<item id="<?=$prod->id?>">
	<name><?=htmlspecialchars($prod->name)?></name>
	<categoryId><?=$prod->cat?></categoryId>
	<price><?=$prod->price?></price>
	<bnprice><?=$prod->price?></bnprice>
	<url>http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?=$prod->id?></url>
	<image>http://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?=$prod->id?>.jpg</image>
	<vendor><?=htmlspecialchars($brand->name)?></vendor>
	<description><?=htmlspecialchars($prod->short)?></description>
	</item>
<?		}?>
</items>
</price>
<?	}elseif($args[1] == 'vcene'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';
		echo '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
?>
		<yml_catalog date="<?=date("Y-m-d H:i", time());?>">
			<shop>
				<name><?=$sett['sitename']?></name>
				<company><?=$sett['sitename']?></company>
				<url>http://<?=$_SERVER['HTTP_HOST']?></url>
				<platform>AS-Commerce</platform>
				<version>2.0</version>
				<currencies>
					<currency id="UAH" rate="1"/>
					<currency id="USD" rate="<?=$sett['course_usd']?>"/>
					<currency id="EUR" rate="<?=$sett['course_eur']?>"/>
					<currency id="RUR" rate="<?=$sett['course_rub']?>"/>
				</currencies>

				<categories>
<?
		foreach($cats as $k => $cat){?>
					<category id="<?=$cat->id?>" parentId="<?=$cat->cat?>"><?=iconv("UTF-8", "WINDOWS-1251", $cat->name)?></category>
<?		}?>
				</categories>
				<offers>
<?		foreach($prods as $k => $prod){
			$Brand = new Model_Brand($prod->brand);
			$brand = $Brand->get($prod->brand);
?>
					<offer available="true" id="<?=$prod->id?>">
						<url>http://tesey.in.ua/catalog/prod-<?=$prod->id?></url>
						<price><?=$prod->price?></price>
						<currencyId>UAH</currencyId>
						<categoryId><?=$prod->cat?></categoryId>
						<picture>http://tesey.in.ua/pic/prod/<?=$prod->id?>.jpg</picture>
						<name><?=iconv("UTF-8", "WINDOWS-1251", $prod->name)?></name>
						<vendor><?=iconv("UTF-8", "WINDOWS-1251", $brand->name)?></vendor>
						<description><?=iconv("UTF-8", "WINDOWS-1251", $prod->short)?></description>
					</offer>
<?		}?>
				</offers>
			</shop>
		</yml_catalog>
<?	}elseif($args[1] == 'yandex'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';
		echo '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
?>
		<yml_catalog date="<?=date("Y-m-d H:i", time());?>">
			<shop>
				<name><?=clear($sett['sitename'])?></name>
				<company><?=clear($sett['sitename'])?></company>
				<url>http://<?=$_SERVER['HTTP_HOST']?></url>
				<platform>AS-Commerce</platform>
				<version>2.0</version>
				<currencies>
					<currency id="UAH" rate="1"/>
					<currency id="USD" rate="<?=$sett['course_usd']?>"/>
					<currency id="EUR" rate="<?=$sett['course_eur']?>"/>
					<currency id="RUR" rate="<?=$sett['course_rub']?>"/>
				</currencies>

				<categories>
<?
		foreach($cats as $k => $cat){?>
					<category id="<?=$cat->id?>" <?if($cat->id){?>parentId="<?=$cat->cat?>"<?}?>><?=iconv("UTF-8", "WINDOWS-1251", $cat->name)?></category>
<?		}?>
				</categories>
				<offers>
<?		foreach($prods as $k => $prod){
			$Brand = new Model_Brand($prod->brand);
			$brand = $Brand->get($prod->brand);
			echo "<offer id=\"".$prod->id."\" available=\"true\"> <url>http://".$_SERVER['HTTP_HOST']."/catalog/prod-".$prod->id."</url> <price>".$prod->price."</price> <currencyId>UAH</currencyId> <categoryId>".$prod->cat."</categoryId> <picture>http://".$_SERVER['HTTP_HOST']."/pic/prod/".$prod->id.".jpg</picture> <model>".clear($prod->name)."</model> <vendor>".clear($brand->name)."</vendor> <description>".clear($prod->short)."</description> </offer> ";
		}?>
				</offers>
			</shop>
		</yml_catalog>
<?	}elseif($args[1] == 'xml'){
		$ff = fopen("export.xml", "w+");

//		header('Content-type: text/xml; charset=windows-1251', true);
//		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';
//		echo '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';

		fwrite($ff, "<?xml version=\"1.0\" encoding=\"windows-1251\""."?".">\n");
		fwrite($ff, "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n");

		$line_head = "<yml_catalog date=\"".date("Y-m-d H:i", time())."\">\n 
			<shop>\n
				<name>".clear($sett['sitename'])."</name>\n
				<company>".clear($sett['sitename'])."</company>\n
				<url>http://".$_SERVER['HTTP_HOST']."</url>\n
				<platform>AS-Commerce</platform>\n
				<version>2.0</version> \n
				<currencies>\n
					<currency id=\"UAH\" rate=\"1\"/>\n 
				</currencies>";
//		echo $line_head;
		fwrite($ff, $line_head);

		$line_cats = "\n				<categories>\n";

		foreach($cats as $k => $cat){
			$line_cats .= "<category id=\"".$cat->id."\""; 
			if($cat->cat) $line_cats .= " parentId=\"".$cat->cat."\"";
			$line_cats .= ">".clear($cat->name)."</category>\n";
		}

		$line_cats .= "				</categories>\n";

		fwrite($ff, $line_cats);

		$line_offers = "				<offers>";

		unset($cats);
		unset($cat);

		foreach($prods as $k => $prod){			
			$cats = $Cat->getall(array("where" => "notinxml = 0", "relation" => array("select" => "obj", "where" => "`type` = 'cat-prod' and relation = '".data_base::nq($prod->id)."'")));
			$prodchars = $Prod->getprodchars($prod->id);
//			$cats = array();
//			$prodchars = array();
			if(empty($cats)) continue;
			$line_offers .= "<offer id=\"".$prod->id."\" available=\"true\"> 
	<url>http://".$_SERVER['HTTP_HOST']."/catalog/prod-".$prod->id."</url> 
	<barcode>".clear("В упаковке ".$prod->inpack)."</barcode> 
	<price>".fmtmoney($prod->price)."</price> 
	<currencyId>UAH</currencyId> 
	<picture>http://".$_SERVER['HTTP_HOST']."/pic/prodbig/".$prod->id.".jpg</picture> 
	<name>".clear($prod->name)."</name> 
	<description>".clear($prod->name)."</description>\n";

//			$line_offers .= "	<categories>\n";
			foreach($cats as $k => $cat){
				if($k == 0)	$line_offers .= "	<categoryId>".$cat->id."</categoryId>\n";					
			}
//			$line_offers .= " 	</categories>\n";

//			$line_offers .= "	<chars>\n";
			if($cv = charval($prod->inpack))
				$line_offers .= "	<param name=\"� ��������\" unit=\"".$cv['ed_izm']."\">".clear($cv['val'])."</param>\n";
			else
				$line_offers .= "	<param name=\"� ��������\">".clear($prod->inpack)."</param>\n";

			foreach($prodchars as $char){
				if(empty($char->value)) continue;
				if($cv = charval($char->value))
					$line_offers .= "	<param name=\"".clear($char->name)."\" unit=\"".$cv['ed_izm']."\">".clear($cv['val'])."</param>\n";
				else
					$line_offers .= "	<param name=\"".clear($char->name)."\">".clear($char->value)."</param>\n";
/*				$line_offers .= "		<char>\n";
				$line_offers .= "			<name>".clear($char->name)."</name>\n";
				$line_offers .= "			<value>".clear($char->value)."</value>\n";
				$line_offers .= "		</char>\n";*/
			}
//			$line_offers .= " 	</chars>\n";

			$line_offers .= "</offer>\n";

//			die();
		}

		$line_offers .= "				</offers>\n";
		fwrite($ff, $line_offers);
		$line_foot = "	</shop>\n";
		$line_foot .= "</yml_catalog>";

		fwrite($ff, $line_foot);
		fclose($ff);
		if($args[2] != 'admin'){
			header('Content-type: text/xml; charset=windows-1251', true);
			readfile($path."/export.xml");
		}else{
			echo "http://www.dombusin.com/export.xml обновлен<br />";
		}
	}

?>