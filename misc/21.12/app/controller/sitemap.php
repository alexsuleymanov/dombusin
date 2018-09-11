<?
	$map = array();
	$Page = new Model_Page('page');
	$Article = new Model_Page('article');
	$News = new Model_Page('news');
	$Cat = new Model_Cat();
	$Prod = new Model_Prod();

	
	$cat = $Cat->getall(array("where" => "visible = 1", "order" => "name"));
	foreach($cat as $v){
		$map[] = array("href" => "http://".$_SERVER['HTTP_HOST']."/catalog/cat-".$v->id."-".$v->intname, "prior" => 1, "freq" => "weekly");
	}

	$prods = $Prod->getall(array("where" => "visible = 1"));
//	$prods = $Prod->getall(array("where" => "visible = 1 and `parent` = 0"));
	foreach($prods as $v){
		$map[] = array("href" => "http://".$_SERVER['HTTP_HOST']."/catalog/prod-".$v->id, "prior" => 1, "freq" => "weekly");
	}

	$pages = $Page->getall(array("where" => "visible = 1"));
	foreach($pages as $v){
		$map[] = array("href" => "http://".$_SERVER['HTTP_HOST']."/".$v->intname, "prior" => 0.5, "freq" => "monthly");
	}

	$articles = $Article->getall(array("where" => "visible = 1", "order" => "tstamp desc"));
	foreach($articles as $v){
		$map[] = array("href" => "http://".$_SERVER['HTTP_HOST']."/articles/".$v->intname, "prior" => 1, "tstamp" => $v->tstamp, "freq" => "monthly");
	}


	$news = $News->getall(array("where" => "visible = 1", "order" => "tstamp desc"));
	foreach($news as $v){
		$map[] = array("href" => "http://".$_SERVER['HTTP_HOST']."/news/".$v->intname, "prior" => 1, "tstamp" => $v->tstamp, "freq" => "monthly");
	}

	header('Content-type: text/xml; charset=utf-8', true);
	echo '<?xml version="1.0" encoding="UTF-8"'.'?'.'>';
	echo "<urlset\n
		xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
		xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
		xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
		http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
	echo "	<!-- Created by Alex Suleymanov www.asweb.com.ua -->\n";

	foreach($map as $v){
		echo "	<url>\n";
		echo "		<loc>".$v['href']."</loc>\n";
		if($v['tstamp']) echo "		<lastmod>".date("Y-m-d", $v['tstamp'])."</lastmod>\n";
		if($v['freq']) echo "		<changefreq>".$v['freq']."</changefreq>\n";
		if($v['prior']) echo "		<priority>".$v['prior']."</priority>\n";
		echo "	</url>\n";
	}

	echo "</urlset>";