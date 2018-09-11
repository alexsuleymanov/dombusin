<?php	
//	set_include_path(implode(PATH_SEPARATOR, array(realpath(dirname(__FILE__))."/../../")));

//	echo realpath(dirname(__FILE__));
//	die();

	error_reporting(E_ERROR & E_WARNING);
	ini_set("display_errors", 1);

//	require_once "incl.php";

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

	/*	public function getprodchars(){
		$prod_chars = array();

		$qr = $this->q("
					select c.id as cid, c.name as name, c.izm, cv.value as value, pc.charval as val, pc.value as text 
					from ".$this->db_prefix."prodchar as pc 
					left join ".$this->db_prefix."char as c on c.id = pc.`char` 
					left join ".$this->db_prefix."charval as cv on cv.id = pc.charval 
					where pc.prod = '".$this->id."' order by c.prior desc");

		while($r = $qr->f()){
			$prod_chars[$r->cid] = $r;
		}
		return $prod_chars;
	}
	*/
	
	/*
	 * 	public function getallforexport(){
		global $sett;
		$prods = array();

		$qr = $this->q("
					select p.id as id, c.id as cat, c.name as name, b.name as brandname, p.name as name, p.price as price, p.price2 price2, p.inpack as inpack, p.skidka as skidka, p.art as art, p.brand as brand, p.short as short, p.cont as cont 
					from ".$this->db_prefix."prod as p 
					left join ".$this->db_prefix."cat as c on c.id = p.cat 
					left join ".$this->db_prefix."brand as b on b.id = p.brand 
					where p.visible = 1 and p.price != 0 and p.num > 0 and p.name != '' order by p.name");

		while($r = $qr->f()){
//				if(!isset($_COOKIE['admin_id']) && $r->price == 0 && $r->price_usd != 0) $r->price = $r->price_usd * $sett['course_usd'];
//				if(!isset($_COOKIE['admin_id']) && $r->price == 0 && $r->price_eur != 0) $r->price = $r->price_eur * $sett['course_eur'];

			$prods[] = $r;
		}

		return $prods;
	}
	 */
	
	$db_server	= "localhost";
	$db_login	= "deus";
	$db_pass	= "d2e06u84s";
	$db_base	= "dombusin2";

	$path = realpath(dirname(__FILE__));
	
	$dbh = mysql_connect($db_server, $db_login, $db_pass);
	mysql_select_db($db_base);
	mysql_query("set character set utf8");
	mysql_query("set names utf8");

	$cats = array();
	$prods = array();

	$qr = mysql_query("select id, cat, name from dombusin_cat where visible > 0 order by prior desc");
	while($r = mysql_fetch_object($qr)){
		$cats[] = $r;
	}
	$qr = mysql_query("select p.id as id, c.id as cat, c.name as name, b.name as brandname, p.name as name, p.price as price, p.price2 price2, p.inpack as inpack, p.skidka as skidka, p.art as art, p.brand as brand, p.short as short, p.cont as cont 
					from dombusin_prod as p 
					left join dombusin_cat as c on c.id = p.cat 
					left join dombusin_brand as b on b.id = p.brand 
					where p.visible = 1 and p.price != 0 and p.num > 0 and p.name != '' order by p.name");

	while($r = mysql_fetch_object($qr)){
		$prods[] = $r;
	}

	$ff = fopen(realpath(dirname(__FILE__))."/export.xml", "w+");
	fwrite($ff, "<?xml version=\"1.0\" encoding=\"windows-1251\""."?".">\n");
	fwrite($ff, "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n");

	$sitename = "Дом бусин \"Изюминка\"";
	
	$line_head = "<yml_catalog date=\"".date("Y-m-d H:i", time())."\">\n 
			<shop>\n
				<name>".clear($sitename)."</name>\n
				<company>".clear($sitename)."</company>\n
				<url>http://www.dombusin.com</url>\n
				<platform>AS-Commerce</platform>\n
				<version>2.0</version> \n
				<currencies>\n
					<currency id=\"UAH\" rate=\"1\"/>\n 
				</currencies>";

	fwrite($ff, $line_head);

	$line_cats = "\n				<categories>\n";

	foreach($cats as $k => $cat){
		$line_cats .= "<category id=\"".$cat->id."\""; 
		if($cat->cat) $line_cats .= " parentId=\"".$cat->cat."\"";
		$line_cats .= ">".clear($cat->name)."</category>\n";
	}

	$line_cats .= "				</categories>\n";

	fwrite($ff, $line_cats);

	$line_offers = "				<offers>\n";

	unset($cats);
	unset($cat);

	foreach($prods as $k => $prod){
		$cats = array();
		$prodchars = array();

		$qr = mysql_query("select c.id, c.cat, c.name from dombusin_relation as r 
			left join dombusin_cat as c on c.id = r.obj 
			where r.type = 'cat-prod' and r.relation = '".$prod->id."' and c.notinxml = 0 and visible = 1 order by c.prior desc");
		while($r = mysql_fetch_object($qr)){
			$cats[] = $r;
		}
		if(empty($cats)) continue;
		
		$prodchars = array();

		$qr = mysql_query("
				select c.id as cid, c.name as name, c.izm, cv.value as value, pc.charval as val, pc.value as text 
				from dombusin_prodchar as pc 
				left join dombusin_char as c on c.id = pc.`char` 
				left join dombusin_charval as cv on cv.id = pc.charval 
				where pc.prod = '".$prod->id."' order by c.prior desc");

		while($r = mysql_fetch_object($qr)){
			$prodchars[$r->cid] = $r;
		}			
			
		$line_offers .= "
			<offer id=\"".$prod->id."\" available=\"true\"> 
				<url>http://www.dombusin.com/catalog/prod-".$prod->id."</url> 
				<code>".clear($prod->art)."</code> 
				<price>".fmtmoney($prod->price)."</price> 
				<barcode>".clear("В упаковке ".$prod->inpack)."</barcode>
				<currencyId>UAH</currencyId> 
				<picture>http://www.dombusin.com/pic/prodbig/".$prod->id.".jpg</picture> 
				<name>".clear($prod->name)."</name> 
				<description>".clear($prod->name)."</description>\n";

		foreach($cats as $k => $cat){
			if($k == 0)	$line_offers .= "	<categoryId>".$cat->id."</categoryId>\n";					
		}

		if($cv = charval($prod->inpack))
			$line_offers .= "	<param name=\"".clear("В упаковке")."\" unit=\"".$cv['ed_izm']."\">".clear($cv['val'])."</param>\n";
		else
			$line_offers .= "	<param name=\"".clear("В упаковке")."\">".clear($prod->inpack)."</param>\n";

		foreach($prodchars as $char){
			if(empty($char->value)) continue;
			if($cv = charval($char->value))
				$line_offers .= "	<param name=\"".clear($char->name)."\" unit=\"".$cv['ed_izm']."\">".clear($cv['val'])."</param>\n";
			else
				$line_offers .= "	<param name=\"".clear($char->name)."\">".clear($char->value)."</param>\n";
		}

		$line_offers .= "</offer>\n";
	}

	$line_offers .= "				</offers>\n";
	fwrite($ff, $line_offers);
	$line_foot = "	</shop>\n";
	$line_foot .= "</yml_catalog>";

	fwrite($ff, $line_foot);
	fclose($ff);
		
