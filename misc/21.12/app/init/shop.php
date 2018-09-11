<?
    $shop_url = $_SERVER["HTTP_HOST"];
	$shop_id = 0;

/*	$shop_model = new Model_Shop();
	$shop = $shop_model->getall(array("where" => "url = '".data_base::nq($shop_url)."'"));

	$shop_id = $shop[0]->id;
	$shop_url = $shop[0]->url;
*/
	Zend_Registry::set('shop_id', $shop_id);
	Zend_Registry::set('shop_url', $shop_url);
