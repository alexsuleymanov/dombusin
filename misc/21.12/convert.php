<?
	phpinfo();
	die();

	set_time_limit(0);
	header('Content-Type: text/html; charset=utf-8');
//	include('imageresizer.php');

	function translit($str){
   		$letters = array(
			"а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e",
			"ё" => "e", "ж" => "zh", "з" => "z", "и" => "i", "й" => "j", "к" => "k",
   	        "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
       	    "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "c",
           	"ч" => "ch", "ш" => "sh", "щ" => "sh", "ы" => "i", "ь" => "", "ъ" => "",
            "э" => "e", "ю" => "yu", "я" => "ya",
			"А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D", "Е" => "E",
			"Ё" => "E", "Ж" => "ZH", "З" => "Z", "И" => "I", "Й" => "J", "К" => "K",
           	"Л" => "L", "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
            "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "C",
   	        "Ч" => "CH", "Ш" => "SH", "Щ" => "SH", "Ы" => "I", "Ь" => "", "Ъ" => "",
       	    "Э" => "E", "Ю" => "YU", "Я" => "YA",
		);
	
		foreach($letters as $letterVal => $letterKey) {
			$str = str_replace($letterVal, $letterKey, $str);
		}
	
		return $str;
	}

	function mkintname($str){
		return trim(preg_replace("/[\W]+/", "-", strtolower(trim(translit($str)))), '-');
	}

	$db_server	= "localhost";
	$db_login	= "igorz";
	$db_pass	= "95Kp6HNR";
	$db_base	= "dombusin";

	$dbh = mysql_connect($db_server, $db_login, $db_pass);
	if(empty($dbh)) throw new DBException(mysql_error());
	if(mysql_select_db($db_base) == false) throw new DBException(mysql_error());
//	mysql_query("set character set cp1251");
	mysql_query("set character set utf8");
	mysql_query("set names utf8");

/*	$qr = mysql_query("select d.tid, d.vid, name, h.parent, t.page_title as title from term_data as d right join term_hierarchy as h on h.tid = d.tid right join page_title as t on t.id = d.tid");
	while($r = mysql_fetch_object($qr)){
		echo "insert into zoo_cat set id = ".$r->tid.", cat = ".$r->parent.", name = '".$r->name."', intname = '".mkintname($r->name)."', title = '".$r->title."', visible = 1<p>";
		mysql_query("insert into zoo_cat set id = ".$r->tid.", cat = ".$r->parent.", name = '".$r->name."', intname = '".mkintname($r->name)."', title = '".$r->title."', visible = 1");
//		print_r($r); echo "<p>";
	}
*/
/*
	$qr = mysql_query("select c.categories_id as id, c.parent_id as cat, c.categories_image as pic, cd.categories_name as name, cd.categories_description as cont, cd.categories_meta_description as descr, cd.categories_meta_title as title, cd.categories_meta_keywords as kw
			from osc_categories as c
			right join osc_categories_description as cd on c.categories_id = cd.categories_id
	");

	echo mysql_error();
//	$i = 0;
//	$ir = new imageresizer;
	while($r = mysql_fetch_object($qr)){
//		if($r->nid <= 721) continue;
//		if($r->nid <= 5821) continue;
//		print_r($r); echo "<p>";
//		echo "insert into zoo_prod set id = ".$r->nid.", cat = ".$r->cat.", name = '".$r->name."', intname = '".mkintname($r->name)."', price = '".$r->price."', cont = '', visible = 1<p>";
//		$i++;
		mysql_query("insert into dombusin_cat set id = ".$r->id.", cat = ".$r->cat.", name = '".$r->name."', intname = '".mkintname($r->name)."', cont = '".$r->cont."', kw = '".$r->kw."', descr = '".$r->descr."', title = '".$r->title."', pic = '".$r->pic."', visible = 1");
		$lastid = mysql_insert_id();
		if($r->cat)
			$q = "insert into dombusin_redirect set oldurl = '/index.php?cPath=".$r->cat."_".$r->id."', newurl = '/catalog/cat-".$lastid."-".mkintname($r->name)."'";
		else
			$q = "insert into dombusin_redirect set oldurl = '/index.php?cPath=".$r->id."', newurl = '/catalog/cat-".$lastid."-".mkintname($r->name)."'";

		mysql_query($q);
		print_r($q);
	}
*/
//	echo $i;
/*
	$qr = mysql_query("select configuration_title as comm, configuration_key as intname, configuration_value as value
			from osc_configuration
	");

	echo mysql_error();
//	$i = 0;
//	$ir = new imageresizer;
	while($r = mysql_fetch_object($qr)){
//		if($r->nid <= 721) continue;
//		if($r->nid <= 5821) continue;
//		print_r($r); echo "<p>";
//		echo "insert into zoo_prod set id = ".$r->nid.", cat = ".$r->cat.", name = '".$r->name."', intname = '".mkintname($r->name)."', price = '".$r->price."', cont = '', visible = 1<p>";
//		$i++;
		$q = "insert into dombusin_sett set intname = '".$r->intname."', comm = '".$r->comm."', `value` = '".$r->value."'";
		mysql_query($q);
		print_r($q); echo "<p>";
	}
*/	
/*
	$qr = mysql_query("select customers_id as id, customers_gender as gender, customers_firstname as name, customers_lastname as surname, 
						customers_email_address as email, customers_telephone as phone, customers_password as pass, customers_status as status, 
						customers_dob as birth, customers_ip_address as ip, date_last_logon as lastlogon, number_of_logons as logons, date_account_created as created 
			from osc_customers
	");

	echo mysql_error();

	while($r = mysql_fetch_object($qr)){
//		echo $r->created."<br>";
//		$tm = strtotime($r->created);
//		echo $tm."<br>";
//		echo date("Y-m-d H:i:s", $tm);
//		print_r($r);
//		die();
		

		$q = "insert into dombusin_user set `type` = 'client', id = ".$r->id.", gender = '".$r->gender."', name = '".$r->name."', surname = '".$r->surname."', 
					email = '".$r->email."', phone = '".$r->phone."', pass = '".$r->pass."', status = '".$r->status."', birth = '".strtotime($r->birth)."', ip = '".$r->ip."',
					lastlogon = '".strtotime($r->lastlogon)."', logons = '".$r->logons."', created = '".strtotime($r->created)."'";

		$r2 = mysql_fetch_object(mysql_query("select id from dombusin_user where id = '".$r->id."'"));

		if(!is_array($r2)){
			mysql_query($q);
			print_r($q); echo "<p>";
		}
//		echo mysql_error();
//		die();
	}
*/
/*
	$qr = mysql_query("select orders_id as id, customers_id as user, customers_name as name, customers_street_address as addr, 
						customers_city as city, customers_postcode as postcode, customers_state as `state`, customers_state_code as state_code, customers_country as country, 
						customers_telephone as phone, customers_email_address as email, customers_ip_address as ip, delivery_name as delivery_name, delivery_company as delivery_company,
						delivery_street_address as delivery_address, delivery_city as delivery_city, delivery_postcode, delivery_state, payment_method, date_purchased as `created`, 
						orders_status as status	from osc_orders");

	echo mysql_error();
//	$i = 0;
//	$ir = new imageresizer;
	while($r = mysql_fetch_object($qr)){
//		print_r($r); die();

		$q = "insert into dombusin_order set id = ".$r->id.", user = '".$r->user."', name = '".$r->delivery_name."', addr = '".$r->delivery_address."', 
					city = '".$r->delivery_city."', postcode = '".$r->delivery_postcode."', `state` = '".$r->delivery_state."', country = '".$r->country."', phone = '".$r->phone."',
					email = '".$r->email."', payment_method = '".$r->payment_method."', created = '".strtotime($r->created)."', tstamp = '".strtotime($r->created)."', ip = '".$r->ip."', `status` = '".$r->status."'";

//		echo $r->id." -- ";
		$r2 = mysql_fetch_row(mysql_query("select id from dombusin_order where id = '".$r->id."'"));

//		print_r($r2);
//		echo " --- ".(0 + is_array($r2));
//		echo "<br />";

		if(!is_array($r2)){
			mysql_query($q);
			print_r($q); echo "<p>";
		}
//		print_r($q); echo "<p>";

//		die();
//		echo mysql_error();
//		die();
	}
*/

	$qr = mysql_query("select orders_products_id as id, orders_id as `order`, products_id as prod, products_name as name, 
						products_price as price, products_quantity as num, products_discount as skidka
			from osc_orders_products 
	");

	echo mysql_error();
//	$i = 0;
//	$ir = new imageresizer;
	while($r = mysql_fetch_object($qr)){
//		print_r($r); die();
		$q = "insert into dombusin_cart set id = ".$r->id.", `order` = '".$r->order."', prod = '".$r->prod."', name = '".$r->name."', 
					price = '".$r->price."', num = '".$r->num."', skidka = '".$r->skidka."'";

		mysql_query($q);
		print_r($q); echo "<p>";
//		die();
		echo mysql_error();
//		die();
	}


/*	$qr = mysql_query("select p.products_id as id, p.products_model as art, p.products_weight as weight, 
						p.products_price as price, p.products_quantity as num, p.products_ordered as ordered, p.products_pack_counter as izm, 
						p.products_hot as pop, p.products_off as sale, p.products_on_main as `main`, pc.categories_id as cat, pd.products_name as name,
						pd.products_description as cont, pd.products_keyword as kw, pd.products_tags as tags, pd.products_viewed as views, pi.image as pic 
			from osc_products as p
			left join osc_products_description as pd on p.products_id = pd.products_id 
			left join osc_products_images as pi on p.products_id = pi.products_id 
			left join osc_products_to_categories as pc on p.products_id = pc.products_id
	");
*/
//	echo mysql_error();
//	$i = 0;
//	$ir = new imageresizer;
/*
	$qr = mysql_query("select id, cat, kw from dombusin_prod");
	while($r = mysql_fetch_object($qr)){
//		print_r($r); die();
/*		echo $r->created."<br>";
		$tm = strtotime($r->created);
		echo $tm."<br>";
		echo date("Y-m-d H:i:s", $tm);
		die();

		$q = "insert into dombusin_prod set id = ".$r->id.", art = '".$r->art."', weight = '".$r->weight."', price = '".$r->price."', 
					num = '".$r->num."', ordered = '".$r->ordered."', izm = '".$r->izm."', pop = '".$r->pop."', sale = '".$r->sale."', 
					`main` = '".$r->main."', cat = '".$r->cat."', name = '".$r->name."', cont = '".$r->cont."', kw = '".$r->kw."', 
					views = '".$r->views."', pic = '".$r->pic."'";

		mysql_query($q);
		print_r($q); echo "<p>";
//		die();
		echo mysql_error();
/////
		$r2 = mysql_fetch_object(mysql_query("select id, cat, intname from dombusin_cat where id = ".$r->cat.""));

		if($r2->cat){
			$q = "insert into dombusin_redirect set oldurl = '/index.php?cPath=".$r2->cat."_".$r2->id."', newurl = '/catalog/cat-".$r2->id."-".$r2->intname."'";
			$q2 = "insert into dombusin_redirect set oldurl = '/products.php?".$r->kw."', newurl = '/catalog/prod-".$r->id."-".$r->kw."'";
			$q3 = "insert into dombusin_redirect set oldurl = '/products.php?".$r->kw."&cPath=".$r2->cat."_".$r2->id."', newurl = '/catalog/prod-".$r->id."-".$r->kw."'";

			mysql_query($q);
			mysql_query($q2);
			mysql_query($q3);
			echo $q."<br>";
			echo $q2."<br>";
			echo $q3."<p>";
   		}elseif($r2->id){
			$q = "insert into dombusin_redirect set oldurl = '/index.php?cPath=".$r2->id."', newurl = '/catalog/cat-".$r2->id."-".$r2->intname."'";
			$q2 = "insert into dombusin_redirect set oldurl = '/products.php?".$r->kw."', newurl = '/catalog/prod-".$r->id."-".$r->kw."'";
			$q3 = "insert into dombusin_redirect set oldurl = '/products.php?".$r->kw."&cPath=".$r2->id."', newurl = '/catalog/prod-".$r->id."-".$r->kw."'";

			mysql_query($q);
			mysql_query($q2);
			mysql_query($q3);
			echo $q."<br>";
			echo $q2."<br>";
			echo $q3."<p>";
		}else{
			$q2 = "insert into dombusin_redirect set oldurl = '/products.php?".$r->kw."', newurl = '/catalog/prod-".$r->id."-".$r->kw."'";
//			$q3 = "insert into dombusin_redirect set oldurl = '/products.php?".$r->kw."&cPath=".$r2->id."', newurl = '/catalog/prod-".$r->id."-".$r->kw."'";
			mysql_query($q2);
//			mysql_query($q3);
			echo $q2."<p>";
//			echo $q3."<p>";
		}

//		mysql_query("update dombusin_prod set intname = '".$r->kw."' where kw = '".$r->kw."'");

		unset($r2);
//		die();
	}

	$qr = mysql_query("select id, pic from dombusin_prod");

	echo mysql_error();
	while($r = mysql_fetch_object($qr)){
		copy("http://www.dombusin.com/images/products/large/".$r->pic, "pic/prod/".$r->id.".jpg");
		print_r($r); echo "<br>";
//		die();
	}

*/	
/*
	$qr = mysql_query("select id, pic from dombusin_cat");

	echo mysql_error();
	while($r = mysql_fetch_object($qr)){
		copy("http://www.dombusin.com/images/categories/".$r->pic, "pic/cat/".$r->id.".jpg");
		print_r($r); echo "<br>";
//		die();
	}
*/
/*
	$qr = mysql_query("select products_id as prod, categories_id as cat from osc_products_to_categories");

	echo mysql_error();
	while($r = mysql_fetch_object($qr)){
		mysql_query("insert into dombusin_relation set `type` = 'cat-prod', `obj` = '".$r->cat."', `relation` = '".$r->prod."'");
		print_r($r); echo "<br>";
	}
			*/
	function osc_rand($min = null, $max = null) {
		if (!isset($seeded)) {
			if (version_compare(PHP_VERSION, '4.2', '<')) {
				mt_srand((double)microtime()*1000000);
			}

			$seeded = true;
		}

		if (is_numeric($min) && is_numeric($max)) {
			if ($min >= $max) {
				return $min;
			} else {
				return mt_rand($min, $max);
			}
		} else {
			return mt_rand();
		}
	}

	function encrypt_pass($plain) {
		$password = '';
    	for ($i = 0; $i < 10; $i++) {
			$password .= osc_rand();
		}

		$salt = substr(md5($password), 0, 2);

		$password = md5($salt . $plain) . ':' . $salt;

		return $password;
	}


/*	$pass = "11111";
	$r = mysql_fetch_object(mysql_query("select * from dombusin_user where email like 'Bondarev1010@mail.ru'"));
	
	print_r($r);
	$salt = "1c";
	echo "<br>".encrypt_pass($pass);
	echo "<br>".md5($salt . $pass) . ':' . $salt;
//	if(md5($pass) == $r->pass) echo "Yahoo!!!";

*/
	