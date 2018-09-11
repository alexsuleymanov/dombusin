<?	// Controller - лента RSS

	$News = new Model_Page('news');
	$articles = $News->getall(array("order" => "tstamp desc", "limit" => 10));

	$title = $sett['rss_title'];
	$siteurl = "https://".$_SERVER["HTTP_HOST"];
	$charset = 'UTF-8';
	$description = $sett['rss_description'];

	$feedArray = array(
		'title'			=> iconv("windows-1251", "utf-8", $title),
		'link'			=> $siteurl,
		'description'	=> iconv("windows-1251", "utf-8", $description),
		'charset'		=> $charset,
		'generator'		=> "ASweb RSS",
		'entries'		=> array()
	);

	foreach ($articles as $k => $item) {
		$tstamp = $item->tstamp;//date('D, d M Y H:i:s +0000', $item->tstamp);

		$feedArray['entries'][] = array(
			'title'			=> iconv("windows-1251", "utf-8", $item->name),
			'link'			=> $siteurl.'/news/'.$item->intname,
			'description'	=> iconv("windows-1251", "utf-8", $item->short),
			'content'		=> iconv("windows-1251", "utf-8", $item->cont),
			'lastUpdate'	=> $tstamp,
		);
            
	}

	$feed = Zend_Feed::importArray($feedArray, 'rss');
        
	$feed->send();