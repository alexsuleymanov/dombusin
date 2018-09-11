<?	
	set_time_limit(0);

	$currency_code = $sett['currency_code'];
	$currency_rate = 1;

	function clear($str){
		return trim($str);
	}

	function clear_1251($str){
//		return $str;
		//$str = str_replace(";", ",", $str);
		//return htmlspecialchars(iconv("UTF-8", "WINDOWS-1251", $str));
		return iconv("UTF-8", "WINDOWS-1251", trim($str));
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
	$cats = $Cat->getall(array("where" => "visible != 0"));

	$Prod = new Model_Prod();
	$prods = $Prod->getallforexport();

	if($args[1] == 'atom') {	
		header("Content-Type: application/xml; charset=utf-8");
		
		echo '<?xml version="1.0" encoding="utf-8"?>'."\n";
		echo '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">'."\n";
		echo '<title>Dombusin.com</title>'."\n";
		echo '<link rel="self" href="http://mirbusin.ru"/>'."\n";
		
		foreach ($prods as $prod) {
			echo "<entry>		
	<g:id>".$prod->id."</g:id>
	<g:mpn>".$prod->art."</g:mpn>
	<g:title>".$prod->name."</g:title>
	<g:description>".$prod->name."</g:description>
	<g:link>https://".$_SERVER['HTTP_HOST']."/catalog/prod-".$prod->id."</g:link>
	<g:image_link>https://".$_SERVER['HTTP_HOST']."/pic/prod/".$prod->id.".jpg</g:image_link>
	<g:condition>new</g:condition>
	<g:availability>in stock</g:availability>
	<g:price>".$prod->price." UAH</g:price>\n";
			if ($skidka->value) {		
	echo "<g:sale_price>".($prod->price * (100 - $skidka->value) / 100)." UAH</g:sale_price>
	<g:price_effective_date>".date("Y-m-d", max(array($skidka->end, time()+30*86400)))."</g:price_effective_date>\n";
			}
	echo "</entry>\n";			
		}
		echo "</feed>";
		die();
	}
	


	if($args[1] == 'rozetka'){
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
		ini_set("display_errors", 1);

		$str = "";
		$str .= '<?xml version="1.0" encoding="utf-8"'.'?'.'>'."\n";
		$str .= "<yml_catalog date=\"".date("Y-m-d H:i", time())."\">\n"
			."<shop>\n"
			."	<name>".$sett['sitename']."</name>\n"
			."	<company>".$sett['sitename']."</company>\n"
			."	<url>http://".$_SERVER['HTTP_HOST']."</url>\n"
			."	<platform>AS-Commerce</platform>\n"
			."	<version>2.0</version>\n"
			."	<currencies>\n"
			."		<currency id=\"UAH\" rate=\"1\"/>\n"
			."	</currencies>\n"
			."	<categories>\n";

		foreach($cats as $k => $cat){
			$str .= "		<category id=\"".$cat->id."\"";
			if ($cat->cat) $str .= " parentId=\"".$cat->cat."\"";
			$str .= ">".clear($cat->name)."</category>\n";
		}
		$str .= "	</categories>\n
	<offers>\n";

		foreach($prods as $k => $prod){
//			if ($prod->num == 0) continue;
			$Prod = new Model_Prod($prod->id);
			$prodchars = $Prod->getprodchars($prod->id);
			$cat = $Prod->getcat();

			$str .= "		<offer id=\"".$prod->id."\" available=\"true\">\n"
				. "			<url>http://".$_SERVER['HTTP_HOST']."/catalog/prod-".$prod->id."</url>\n"
				. "			<price>".$prod->price."</price>\n"
				. "			<stock_quantity>".$prod->num."</stock_quantity>\n"
				. "			<currencyId>UAH</currencyId>\n"
				. "			<categoryId>".$cat->name."</categoryId>\n"
				. "			<picture>http://".$_SERVER['HTTP_HOST']."/pic/prod/".$prod->id.".jpg</picture>\n"
				. "			<name>".clear($prod->name)."</name>\n"
				. "			<vendor>".clear("Dombusin")."</vendor>\n"
				. "			<description>".clear($prod->cont)."</description>\n";
			
			foreach($prodchars as $char){
				if($args[1] != 'rozetka' && empty($char->value)) continue;
				if($char->id == 15 || $char->name == 'Размер') continue;
				$value = ($char->value) ? $char->value : $char->text; 
				if($args[1] == 'rozetka'){
					$str .= "				<param name=\"".clear($char->cname)."\">".clear($value)."</param>\n";
					continue;
				}
				
				
				if($cv = $char->value)
					$str .= "				<param name=\"".clear($char->cname)."\" unit=\"".$cv['ed_izm']."\">".clear($cv['val'])."</param>\n";
				else
					$str .= "				<param name=\"".clear($char->cname)."\">".clear($char->text)."</param>\n";
			}

			$str .= "		</offer>\n";
			
		}
		
		$str .= "	</offers>\n"
			."</shop>\n"
			."</yml_catalog>\n";

		echo "Export Done";
		
		file_put_contents($path."/rozetka.xml", $str);
	}