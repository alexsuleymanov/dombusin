<?	
//	die();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	set_time_limit(0);
	
	function clear($str){
		return iconv("UTF-8", "WINDOWS-1251", htmlspecialchars($str));
	}

	function fmtmoney($money) {
		return sprintf("%0.2f", $money);
	}
	
	function charval($charval){	
		$cv = array();
		if(preg_match("/(\d+[\.]?\d*?[*|\-|x|\.|~]?\d*?[\.]?\d*?)\s*?([a-z|A-Z|А-Я|а-я]+)/", clear($charval), $m)){
			$cv['val'] = $m[1];
			$cv['ed_izm'] = $m[2];
			return $cv;
		}else{
			return false;
		}
	}


	$Cat = new Model_Cat();
	$cats = $Cat->getall(array("where" => "visible != 0", "order" => "prior desc"));

	$Prod = new Model_Prod();
	$prods = $Prod->getallforexport();
	
	if($args[1] == 'xml'){
		if($args[2] != 'admin'){
			header('Content-type: text/xml; charset=windows-1251', true);
			readfile($path."/partners.xml");
			die();
		}
		echo "Всего товаров: ".count($prods)."<br>";
		$ff = fopen("partners.xml", "w+");

//		header('Content-type: text/xml; charset=windows-1251', true);
//		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';
//		echo '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';

		fwrite($ff, "<?xml version=\"1.0\" encoding=\"windows-1251\""."?".">\n");
		fwrite($ff, "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n");

		$line_head = "<yml_catalog date=\"".date("Y-m-d H:i", time())."\">\n 
			<shop>\n
				<name>".clear($sett['sitename'])."</name>\n
				<company>".clear($sett['sitename'])."</company>\n
				<url>https://".$_SERVER['HTTP_HOST']."</url>\n
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
		fwrite($ff, $line_offers);
		unset($cats);
		unset($cat);

//		$prodchars_all = $Prod->getprodchars_all();
		
		foreach($prods as $k => $prod){			
			$line_offers = '';
			$cats = $Cat->getall(array("where" => "notinxml = 0", "relation" => array("select" => "obj", "where" => "`type` = 'cat-prod' and relation = '".data_base::nq($prod->id)."'")));
			//$prodchars = isset($prodchars_all[$prod->id]) ? $prodchars_all[$prod->id] : array();
			$prodchars = $Prod->getprodchars($prod->id);
			
			echo $k.") Prod: ".$prod->id;
			echo "<br>";
//			if($k > 1000){ echo "Ok!"; die();}
//			$cats = array();
//			$prodchars = array();

			if(empty($cats)) continue;
			
			$line_offers .= "<offer id=\"".$prod->id."\" available=\"true\">
	<url>https://".$_SERVER['HTTP_HOST']."/catalog/prod-".$prod->id."</url>
	<code>".clear($prod->art)."</code>
	<price>".fmtmoney($prod->price)."</price>
	<barcode>".clear("В упаковке ".$prod->inpack)."</barcode>
	<currencyId>UAH</currencyId>
	<picture>https://".$_SERVER['HTTP_HOST']."/pic/prodbig/".$prod->id.".jpg</picture>
	<name>".clear($prod->name)."</name>
	<description>".clear($prod->name)."</description>\n";

//			$line_offers .= "	<categories>\n";
			foreach($cats as $k => $cat){
				if($k == 0)	$line_offers .= "	<categoryId>".$cat->id."</categoryId>\n";
			}
//			$line_offers .= " 	</categories>\n";

//			$line_offers .= "	<chars>\n";
			if($cv = charval($prod->inpack))
				$line_offers .= "	<param name=\"".clear("В упаковке")."\" unit=\"".$cv['ed_izm']."\">".clear($cv['val'])."</param>\n";
			else
				$line_offers .= "	<param name=\"".clear("В упаковке")."\">".clear($prod->inpack)."</param>\n";

			foreach($prodchars as $char){
				if(empty($char->value)) continue;
				if($cv = charval($char->value))
					$line_offers .= "	<param name=\"".clear($char->cname)."\" unit=\"".$cv['ed_izm']."\">".clear($cv['val'])."</param>\n";
				else
					$line_offers .= "	<param name=\"".clear($char->cname)."\">".clear($char->value)."</param>\n";
			}
//			$line_offers .= " 	</chars>\n";

			$line_offers .= "</offer>\n";

//			die();
			unset($prods[$k]);
			unset($prodchars);
			unset($cats);
			
			fwrite($ff, $line_offers);
		}

		$line_offers = "				</offers>\n";
		fwrite($ff, $line_offers);
		$line_foot = "	</shop>\n";
		$line_foot .= "</yml_catalog>";

		fwrite($ff, $line_foot);
		fclose($ff);
		
		echo "https://www.dombusin.com/partners.xml обновлен!<br />";
	}

?>