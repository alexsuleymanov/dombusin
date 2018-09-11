<?// Controller - Кабинет пользователя


if ($_GET['oresults'] && $_GET['oresults'] != $_SESSION['oresults']) {
	$_SESSION['oresults'] = $_GET['oresults'];
	$oresults = $_SESSION['oresults'];
} else {
	$oresults = ($_SESSION['oresults']) ? $_SESSION['oresults'] : 10;
}
$ostart = 0 + $_GET['ostart'];

if (!isset($_COOKIE["userid"])) {
	$_SESSION["error"] = $labels["you_must_register"];
	$url->redir("/login");
	die();
}

$view->bc["/" . $args[0]] = $labels["user_cabinet"];

if ($opt['discounts']) {
	$Discount = new Model_Discount();
	$Order = new Model_Order();

	$view->order_total = $Order->total($_COOKIE['userid']);
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

	$view->ocnt = $Order->getnum(array("where" => "user = '" . data_base::nq($_COOKIE['userid']) . "'"));
	$view->oresults = $oresults;
	$view->ostart = $ostart;

	$view->orders = $Order->getall(array("where" => "user = '" . data_base::nq($_COOKIE['userid']) . "'", "order" => "tstamp desc", "limit" => "$ostart, $oresults"));
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
	$Order = new Model_Order();
	$view->order = $Order->getone(array("where" => "user = '" . data_base::nq($_COOKIE['userid']) . "' and id=" . $args[2], "order" => "tstamp desc"));
	$view->bc["/" . $args[0] . "/" . $args[1]] = "Заказы";
	$view->bc["/" . $args[0] . "/" . $args[1] . "/" . $args[2]] = "Заказ №" . $view->order->id;

	echo $view->render("head.php");
	//echo $view->render("user/head.php");
	echo $view->render("user/order.php");
	echo $view->render("foot.php");
}

if (($args[1] == "order-history") && ($args[2] == 'last')) {
	$Order = new Model_Order();
	$view->order = $Order->getone(array("where" => "user = '" . data_base::nq($_COOKIE['userid']) . "'", "order" => "tstamp desc", "limit" => "1"));
	$view->bc["/" . $args[0] . "/" . $args[1]] = "Заказы";
	$view->bc["/" . $args[0] . "/" . $args[1] . "/" . $args[2]] = "Заказ №" . $view->order->id;

	echo $view->render("head.php");
	//echo $view->render("user/head.php");
	echo $view->render("user/order.php");
	echo $view->render("foot.php");
}

if ($args[1] == "wishlist") {

	if (!isset($_COOKIE['userid'])) {
		$_SESSION["error"] = $labels["you_must_register"];
		$url->redir("/login");
		die();
	}

	$action = ($args[2]) ? $args[2] : 'show';

	if ($action == 'add' || $action == 'fromcart') {
		if($action == 'fromcart')
			$prod = 0 + $cart->cart[$args[3]]['id'];
		elseif($action == 'add')
			$prod = 0 + $args[3];

		$Wishlist = new Model_Wishlist();
		if ($Wishlist->getnum(array("where" => "user = '" . $_COOKIE['userid'] . "' and prod = '" . data_base::nq($prod) . "'")) == 0)
			$Wishlist->insert(array("prod" => $prod, "user" => $_COOKIE['userid']));
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
		$wishlist = $Wishlist->getall(array("where" => "user=".$_COOKIE['userid']));

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
			$view->ocnt = $Prod->getnum(array("where" => "id in " . $wishes, "order" => "prior asc", "limit" => "65"));
			$view->oresults = $oresults;
			$view->ostart = $ostart;
			$view->wishlist = $Prod->getall(array("where" => "id in " . $wishes, "order" => "prior asc", "limit" => "$ostart, $oresults"));
		}

		echo $view->render('head.php');
		echo $view->render('user/wishlist.php');
		echo $view->render('foot.php');
	} elseif ($action == 'delete') {
		$Wishlist = new Model_Wishlist();
		$Wishlist->delete(array("where" => "prod=".$args[3]));

		if ($_POST['ajax']) {
			die();
		} else {
			header("Location: /user/wishlist/");
			die();
		}
	}
}

if (($args[1] == "order-history") && ($args[2] == 'status') && (in_array($args[3], array(1, 2, 3, 4, 5, 6, 7)))) {
	$Order = new Model_Order();

	$view->ocnt = $Order->getnum(array("where" => "user = '" . data_base::nq($_COOKIE['userid']) . "' and status = " . $args[3]));
	$view->oresults = $oresults;
	$view->ostart = $ostart;

	$view->orders = $Order->getall(array("where" => "user = '" . data_base::nq($_COOKIE['userid']) . "' and status = " . $args[3], "order" => "tstamp desc", "limit" => "$ostart, $oresults"));

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
			$User = new Model_User('client', $_COOKIE['userid']);
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
			$User = new Model_User('client', data_base::nq($_COOKIE['userid']));
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
		$User = new Model_User('client', data_base::nq($_COOKIE['userid']));
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