<?// Controller - Кабинет пользователя
//print_r($_SESSION);
//echo "<p>";
//print_r($cart->cart);
if ($_GET['oresults'] && $_GET['oresults'] != $_SESSION['oresults']) {
	$_SESSION['oresults'] = $_GET['oresults'];
	$oresults = $results = $_SESSION['oresults'];
} else {
	$oresults = ($_SESSION['oresults']) ? $_SESSION['oresults'] : 10;
	$results = $oresults;	
}

$start = 0 + $_GET['start'];

if (!Model_User::isauth()) {
	$_SESSION["error"] = $labels["you_must_register"];
	$url->redir("/login");
	die();
} else {
	$User = new Model_User('client');
	$view->user = $User->get(Model_User::userid());
}

$view->bc["/" . $args[0]] = $labels["user_cabinet"];

if ($opt['discounts']) {
	$Discount = new Model_Discount();
	$Order = new Model_Order();

	$view->order_total = $Order->total(Model_User::userid());
	$view->dictounts = $Discount->getall();
	$view->discount = $Discount->getnakop($view->order_total);
	$view->nextdiscount = $Discount->nextdiscount($view->order_total);
	$view->tonextdiscount = $Discount->tonextdiscount($view->order_total);
}

if ($args[1] == "newsletters") {
	$view->bc["/" . $args[0] . "/" . $args[1]] = "Новостная рассылка";
	echo $view->render("head.php");
	echo $view->render("user/newsletters.php");
	echo $view->render("foot.php");
}

if ($args[1] == "notifications") {
	$view->bc["/" . $args[0] . "/" . $args[1]] = "Уведомления";
	echo $view->render("head.php");
	echo $view->render("user/notifications.php");
	echo $view->render("foot.php");
}

if ($args[1] == "discounts") {
	$Page = new Model_Page('page');
	$view->page = $Page->getbyname("user/discounts");

	$view->bc["/" . $args[0] . "/" . $args[1]] = $labels["discounts"];

	echo $view->render("head.php");
	echo $view->render("user/discounts.php");
	echo $view->render("foot.php");
}

if (($args[1] == "order-history") && ($args[2] == '')) {
	$Order = new Model_Order();

	$view->cnt = $Order->getnum(array("where" => "user = '" . data_base::nq(Model_User::userid()) . "'"));
	$view->results = $view->oresults = $oresults;
	$view->start = $start;
	
	$view->orders = $Order->getall(array("where" => "user = '" . data_base::nq(Model_User::userid()) . "'", "order" => "tstamp desc", "limit" => "$start, $oresults"));
	$Page = new Model_Page('page');
	$view->page = $Page->getbyname("user/order-history");
	$view->bc["/" . $args[0] . "/" . $args[1]] = "Заказы";

	echo $view->render("head.php");
	//echo $view->render("user/head.php");
	echo $view->render("user/order-history.php");
	echo $view->render("foot.php");
	die();
}

if (($args[1] == "order-history") && (is_numeric($args[2]))) {
	$Order = new Model_Order($args[2]);
	$User = new Model_User('client');
	$view->order = $Order->get($args[2]);
	
	$view->user = $User->get($view->order->user);
	$view->prods = $Order->cart->cart;
//	$view->order = $Order->getone(array("where" => "user = '" . data_base::nq(Model_User::userid()) . "' and id=" . $args[2], "order" => "tstamp desc"));
	$view->bc["/" . $args[0] . "/" . $args[1]] = "Заказы";
	$view->bc["/" . $args[0] . "/" . $args[1] . "/" . $args[2]] = "Заказ №" . $view->order->id;
	
	echo $view->render("head.php");
	//echo $view->render("user/head.php");
	echo $view->render("user/order.php");
	echo $view->render("foot.php");
}

if (($args[1] == "order-history") && ($args[2] == 'last')) {
	$Order = new Model_Order();
	$order = $Order->getone(array("where" => "user = '" . data_base::nq(Model_User::userid()) . "'", "order" => "tstamp desc", "limit" => "1"));
	$order2 = new Model_Order($order->id);
	$view->order = $order2;
	$view->prods = $order2->cart->cart;
	$view->bc["/" . $args[0] . "/" . $args[1]] = "Заказы";
	$view->bc["/" . $args[0] . "/" . $args[1] . "/" . $args[2]] = "Заказ №" . $view->order->id;

	echo $view->render("head.php");
	//echo $view->render("user/head.php");
	echo $view->render("user/order.php");
	echo $view->render("user/history.php");
	echo $view->render("foot.php");
}

if ($args[1] == "wishlist") {
	if (!Model_User::isauth()) {
		$_SESSION["error"] = $labels["you_must_register"];
		$url->redir("/login");
		die();
	}

	$action = ($args[2]) ? $args[2] : 'show';
	
	if($action == 'clean'){
		$Wishlist = new Model_Wishlist();
		$Wishlist->clear();
		
		die();
	}
	
	if ($action == 'add' || $action == 'fromcart') {
		if($action == 'fromcart'){
			$prod = 0 + $cart->cart[$args[3]]['id'];
			$var = 0 + $cart->cart[$args[3]]['var'];
		}elseif($action == 'add'){
			$prod = 0 + $_POST['id'];
			$var = ($_POST['var']) ? $_POST['var'] : 1;
		}

		$Wishlist = new Model_Wishlist();
		if ($Wishlist->getnum(array("where" => "user = '" . Model_User::userid() . "' and prod = '" . data_base::nq($prod) . "' and var = '" . data_base::nq($var) . "'")) == 0)
			$Wishlist->insert(array("prod" => $prod, "var" => $var, "user" => Model_User::userid()));
 //               unset($cart->cart[$args[3]]);

		if($action == 'fromcart'){
			$cart->delete_cartitem($args[3]);
			echo $prod; echo $action; die();
		}
		
		if ($_POST['ajax']) {
			$result = array("prods" => $cart->prod_num(), "amount" => $cart->amount());
			echo Zend_Json::encode($result);
			die();
		} else {
			header("Location: /user/wishlist/show" . $url->gvar("asdflkha="));
			die();
		}
	} elseif ($action == 'show') {

		$view->bc["/" . $args[0] . "/" . $args[1]] = "Заказы";
		$view->bc["/" . $args[0] . "/" . $args[1] . "/" . $args[2]] = "Отложенные товары";

		$Wishlist = new Model_Wishlist();
		$wishlist = $Wishlist->getall(array("where" => "user=".Model_User::userid()));

		if(count($wishlist)) {
			$wishes = "(";
			$i=0;
			foreach($wishlist as $wish) {
				if($i++!=0){
					$wishes .= ',';
				}
				$wishes .= $wish->prod;
			}
			$wishes .= ")";

			$Prod = new Model_Prod();
			$view->ocnt = $view->cnt = $Prod->getnum(array("where" => "id in " . $wishes, "order" => "prior asc"));
			$view->results = $view->oresults = $oresults;
			$view->start = $view->start = $start;
			$cond = array("where" => "id in " . $wishes, "order" => "prior asc", "limit" => "$start, $oresults");
//			print_r($cond);
			$wishlist = $Wishlist->getall(array("where" => "user=".Model_User::userid(), "limit" => "$start, $oresults"));
			$view->wishlist = $Prod->getall($cond);
			$view->wl = $wishlist;
		}

		echo $view->render('head.php');
		echo $view->render('user/wishlist.php');
		echo $view->render('foot.php');
	} elseif ($action == 'delete') {
		$Wishlist = new Model_Wishlist();
		$Wishlist->delete(array("where" => "id=".$args[3]));

//		if ($_POST['ajax']) {
//			die();
//		} else {
			header("Location: /user/wishlist/");
			die();
//		}
	}
}

if (($args[1] == "order-history") && ($args[2] == 'status') && (in_array($args[3], array(1, 2, 3, 4, 5, 6, 7)))) {
	$Order = new Model_Order();

	$view->cnt = $Order->getnum(array("where" => "user = '" . data_base::nq(Model_User::userid()) . "' and status = " . $args[3]));
	$view->results = $results;
	$view->start = $start;

	$view->orders = $Order->getall(array("where" => "user = '" . data_base::nq(Model_User::userid()) . "' and status = " . $args[3], "order" => "tstamp desc", "limit" => "$start, $results"));

	$Page = new Model_Page('page');
	$view->page = $Page->getbyname("user/order-history");
	$view->bc["/" . $args[0] . "/" . $args[1]] = "Заказы";

	echo $view->render("head.php");
	//echo $view->render("user/head.php");
	echo $view->render("user/order-history.php");
	echo $view->render("foot.php");
	die();
}

if ($args[1] == "profile") {
	$form = new Form_Profile();
	if ($_POST["submit"]) {
		if ($form->isValid($_POST)) {
			$User = new Model_User('client', Model_User::userid());
			$data = array(
				"country" => $_POST["country"],
				"city" => $_POST["city"],
				"address" => $_POST["address"],
				"name" => $_POST["name"],
				"surname" => $_POST["surname"],
				"www" => $_POST["www"],
				"phone" => $_POST["phone"],
			);
			$User->save($data);
			$url->redir("/user/profile");
		} else {
			$Page = new Model_Page('page');
			$view->page = $Page->getbyname("user/profile");
			$view->bc["/" . $args[0] . "/" . $args[1]] = $view->page->name;

			echo $view->render("head.php");
			//echo $view->render("user/head.php");
			$view->form = $form->render($view);
			echo $view->render("user/profile.php");
			echo $view->render("foot.php");
		}
	} else {
		$Page = new Model_Page('page');
		$view->page = $Page->getbyname("user/profile");
		$view->bc["/" . $args[0] . "/" . $args[1]] = "Редактировать аккаунт";

		echo $view->render("head.php");
		//echo $view->render("user/head.php");
		$view->form = $form->render($view);
		echo $view->render("user/profile.php");
		echo $view->render("foot.php");
	}
	die();
}

if ($args[1] == "change-pass") {
	$form = new Form_ChangePass();
	if ($_POST["submit"]) {
		if ($form->isValid($_POST)) {
			$User = new Model_User('client', data_base::nq(Model_User::userid()));
			$data = array(
				"pass" => Func::encrypt_pass($_POST["pass"]),
			);
			$User->save($data);

			echo $view->render('head.php');
			echo "<p align=center><font color=\"green\">Ваш пароль был изменен</font></p>";

			echo $view->render('foot.php');

			if ($_POST["redirect"])
				$url->redirjs("/user");
			die();
		}else {
			echo $view->render("head.php");
			//echo $view->render("user/head.php");
			$view->form = $form->render($view);
			echo $view->render("user/change-pass.php");
			echo $view->render("foot.php");
		}
	} else {
		$User = new Model_User('client', data_base::nq(Model_User::userid()));
		$view->user = $User->get();

		$Page = new Model_Page('page');
		$view->bc["/" . $args[0] . "/" . $args[1]] = "Изменить пароль";

		echo $view->render("head.php");
		//echo $view->render("user/head.php");
		$view->form = $form->render($view);
		echo $view->render("user/change-pass.php");
		echo $view->render("foot.php");
	}
	die();
}

if ($args[1] == "") {
	echo $view->render("head.php");
	//echo $view->render("user/head.php");
	echo $view->render("user/account.php");
	echo $view->render("foot.php");
	die();
}