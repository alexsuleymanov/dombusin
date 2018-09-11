<?// Controller - Корзина

$action = ($args[1]) ? $args[1] : 'edit';

if($_GET['from']){
	$_SESSION['from'] = $_GET['from'];
}

$view->bc["/" . $args[0]] = $labels["cart"];

if ($action == 'check'){
	$Prod = new Model_Prod($_POST['id']);
	$prod = $Prod->get();
	
	$num_na_sklade = $prod->num;
	if($_POST['prodvar'] == 2) $num_na_sklade = $prod->num2;
	if($_POST['prodvar'] == 3) $num_na_sklade = $prod->num3;
	
	$cart_id = $cart->cart_id($_POST['id'], $_POST['prodvar']);
	$num_in_cart = 0 + $cart->cart[$cart_id]['num'];
	$num = $num_in_cart + $_POST['num'];

    if($num_na_sklade < $num){
		$res = array('status' => 'false', 'num' => $num_na_sklade - $num_in_cart);
	}else{
		$res = array('status' => 'true', 'num' => $num_na_sklade - $num_in_cart);
	}
	echo Zend_Json::encode($res);
//	echo ": ".$num." - ".$num_in_cart." - ".$num_na_sklade;
	die();
}

if ($action == 'buy') {
	$id = ($_POST['id']) ? intval($_POST['id']) : intval($_GET['id']);
	$var = ($_POST['var']) ? intval($_POST['var']) : 0;
	$num = ($_POST['num']) ? $_POST['num'] : 1;

	$Prod = new Model_Prod($id);
	$prod = $Prod->get($id);

	$price = $prod->price;
	$skidka = $prod->skidka;
	$weight = $prod->weight;
	
	if($var == 2){
		$price = $prod->price2;
		$weight = $prod->weight2;
	}
	if($var == 3){
		$price = $prod->price3;
		$weight = $prod->weight3;
	}
	
//	echo $id."---".$num."---".$price."---".$skidka."<br />";
	$cart->buy($id, $var, $num, $price, $skidka, $weight);

	if($args[2] == 'fromwish'){
		$Wishlist = new Model_Wishlist();
//		$Wishlist->delete(array("where" => "user = '".$_COOKIE['userid']."' and prod = '".data_base::nq($id)."'"));
//		echo "user = '".$_COOKIE['userid']."' and prod = '".data_base::nq($id)."'<br />";
	}

	$result = array("id" => $id, "prods" => $cart->prod_num(), "packs" => $cart->prod_num(), "amount" => $cart->amount(), "cart" => $cart->cart, "reload" => $_POST['reload']);

	echo Zend_Json::encode($result);
	die();
} elseif ($action == 'update') {
	$id = $_POST["id"];
	$var = 0 + $_POST["var"];
	$num = ($_POST["num"]) ? $_POST["num"] : 1;

	$cart->update_cart($id, $num);

	$Prod = new Model_Prod($cart->cart[$id]['id']);
	$prod = $Prod->get($cart->cart[$id]['id']);
	
	$price = $prod->price;
	if($cart->cart[$id]['var'] == 2) $price = $prod->price2;
	if($cart->cart[$id]['var'] == 3) $price = $prod->price3;
	
	$result = array("cart_id" => $id, "id" => $prod->id, "price" => $price * (100 - $prod->skidka) / 100, "num" => intval($num), "prods" => intval($cart->prod_num()), "packs" => intval($cart->pack_num()), "weight" => intval($cart->weight()), "amount" => $cart->amount(), "skidka" => $cart->get_skidka(), "sum" => $cart->get_sum(), "to_pay" => $cart->get_to_pay());
	echo Zend_Json::encode($result);
	die();
} elseif ($action == 'edit') {
	$Page = new Model_Page('page');
	$view->page = $Page->getbyname("cart");

	if($cart->prods_limited()) $view->prods_limited = $cart->prods_limited;
        
        foreach($cart->cart as $k => $v){
            if($v["num"] == 0) unset($cart->cart[$k]);
        }
        
	$view->wishlist = false;
	if (isset($_COOKIE['userid'])) {

		if ($_GET['oresults'] && $_GET['oresults'] != $_SESSION['oresults']) {
			$_SESSION['oresults'] = $_GET['oresults'];
			$oresults = $_SESSION['oresults'];
		} else {
			$oresults = ($_SESSION['oresults']) ? $_SESSION['oresults'] : 10;
		}
		$ostart = 0 + $_GET['ostart'];

		
		$view->wishlist = true;
		$Wishlist = new Model_Wishlist();
		$wishlist = $Wishlist->getall(array("where" => "user=" . $_COOKIE['userid']));

		if (count($wishlist)) {
			$wishes = "(";
			$i = 0;
			foreach ($wishlist as $wish) {
				if ($i++ != 0) {
					$wishes .= ',';
				}
				$wishes .= $wish->prod;
			}
			$wishes .= ")";

			$Prod = new Model_Prod();
			$view->ocnt = $Prod->getnum(array("where" => "id in " . $wishes, "order" => "prior asc", "limit" => "65"));
			$view->oresults = $oresults;
			$view->ostart = $ostart;
			$view->wishlist = $Prod->getall(array("where" => "id in " . $wishes, "order" => "prior asc", "limit" => "$ostart, $oresults"));
		}
	}

	echo $view->render('head.php');
	echo $view->render('cart/edit.php');
	echo $view->render('foot.php');
} elseif ($action == 'delete') {
	$cart->delete_cartitem($args[2]);
	if ($_POST['ajax']) {
		$result = array("prods" => $cart->prod_num(), "amount" => $cart->amount());
		echo Zend_Json::encode($result);
		die();
	} else {
		header("Location: /cart" . $url->gvar("asdflkha="));
		die();
	}
} elseif ($action == 'clear') {
	$cart->delete_all();
	if ($_POST['ajax']) {
		$result = array("prods" => $cart->prod_num(), "amount" => $cart->amount());
		echo Zend_Json::encode($result);
		die();
	} else {
		header("Location: /cart" . $url->gvar("asdflkha="));
		die();
	}
}
