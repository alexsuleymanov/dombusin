<?// Controller - Оформление заказа

if ($args[1] == '') {
	$form_newuser = new Form_Order();
	$form_newuser->setAction($url->mk("/order"));

	$form_login = new Form_Order();
	$form_newuser->setAction($url->mk("/order"));
	
	if ($_POST['login']) {
		$User = new Model_User('client');
		$user = $User->getone(array("where" => "email = '".data_base::nq($_POST["email"])."' and pass = '".data_base::nq($_POST["pass"])."'"));
		
		if ($user->id) {
			$_SESSION['order_name'] = $user->name;
			$_SESSION['order_surname'] = $user->surname;
			$_SESSION['order_email'] = $user->email;
			$_SESSION['order_phone'] = $user->phone;
			
		    $url->redir($url->mk("/order/delivery"));
			die();
		} else {
			$_SESSION["order_error"] = $labels["wrong_password"];
			$url->redir($url->mk("/order#login"));
			die();
		}
	} elseif($_POST['register']) {
		if ($form_newuser->isValid($_POST)){
			$_SESSION['order_name'] = $user->name;
			$_SESSION['order_surname'] = $user->surname;
			$_SESSION['order_email'] = $user->email;
			$_SESSION['order_phone'] = $user->phone;
		
			$url->redir("/order/delivery");
		} else {
			$view->form_login = $form_login;
			$view->form_newuser = $form_newuser;
			
			echo $view->render('head.php');
			echo $view->render('order/anketa.php');
			echo $view->render('foot.php');
		}
	} else {
		$view->form_login = $form_login;
		$view->form_newuser = $form_newuser;

		echo $view->render('head.php');
		echo $view->render('order/anketa.php');
		echo $view->render('foot.php');
	}
	die();
}

if ($args[1] == 'delivery') {
	if ($_POST['submit']) {
		$Delivery = new Model_Delivery();
		$delivery = $Delivery->get($_POST['delivery']);
		
		$_SESSION['order_delivery'] = $delivery->id;
		$_SESSION['order_city'] = $_POST['city'];
		$_SESSION['order_addr'] = $_POST['addr'];
		$_SESSION['order_deliverycost'] = $delivery->price;
		
		if ($_POST['street'] && $_POST['house']) {
			$_SESSION['order_addr']	= $_POST['street'].", ".$_POST['house'].", ".$_POST['flat'];
		}
		
		$url->redir("/order/payment");
	} else {
		echo $view->render('head.php');
		echo $view->render('order/delivery.php');
		echo $view->render('foot.php');
	}
	die();
}

if ($args[1] == 'payment') {
	if ($_POST['submit']) {
		$_SESSION['order_esystem'] = $_POST['esystem'];
		
		$url->redir("/order/confirm");
	} else {
		echo $view->render('head.php');
		echo $view->render('order/payment.php');
		echo $view->render('foot.php');
	}
	die();
}

if($args[1] == 'confirm'){
	$Order = new Model_Order();
			
	$userid = Model_User::userid();
	$Discount = new Model_Discount();
	$User = new Model_User('client');
	$user = $User->getone(array("where" => "`email` = '".data_base::nq($_SESSION['order_email'])."'"));
	
	if(Model_User::userid() == 0 && empty($user->id)){ // Новый клиент
		$password = substr(md5(time()), 0, 8);
		$data = array(
			"type" => 'client',
			"pass" => ($_POST['password']) ? $_POST['password']: $password,
			"email" => $_SESSION['order_email'],
			"name" => $_SESSION['order_name'],
			"surname" => $_SESSION['order_surname'],
			"phone" => Func::mkphone($_SESSION['order_phone']),
			"city" => $_POST['city'],
			"address" => $_SESSION['order_addr'],
			"ip" => $_SERVER['REMOTE_ADDR'],
			"created" => time(),
			"discount" => 0,
			"lastordertime" => time(),					
		);
		
		$User = new Model_User('client');
		$User->insert($data);
		$userid = $User->last_id();
															
		$user = $User->get($userid);
		Model_User::login($user);
		$cart->user_login(AS_Discount::getUserDiscount());

		$params = array(
			"pass" => ($_POST['password']) ? $_POST['password'] : $password,
			"email" => $_SESSION['order_email'],
			"name" => $_SESSION['order_name'],
			"surname" => $_SESSION['order_surname'],
			"phone" => Func::mkphone($_SESSION['order_phone']),
			"city" => $_SESSION['order_city'],
			"address" => $_SESSION['order_addr'],
		);
	}elseif(Model_User::userid() == 0 && $user->id){ // Клиент есть в базе но не авторизирован					
		Model_User::login($user);
		$cart->user_login(AS_Discount::getUserDiscount());
					
		$userid = $user->id;
	}  elseif(Model_User::userid()){ // Клиент авторизирован
					
	}

	$data = array(
		"user" => $userid,
		"manager" => 0 + $user->manager,
		"name" => $_SESSION['order_surname']." ".$_SESSION['order_name'],
		"addr" => $_SESSION['order_addr'],
		"city" => $_SESSION['order_city'],
		"phone" => Func::mkphone($_SESSION['order_phone']),
		"email" => $_SESSION['order_email'],
		"tstamp" => time(),
		"esystem" => 0 + $_SESSION['order_esystem'],
		"delivery" => 0 + $_SESSION['order_delivery'],
		"sklad" => $_SESSION['order_sklad'],
		"comment" => $_SESSION['order_cmment'],
		"status" => 4,
		"opt" => 0 + $user->opt,
//		"needcall" => 0 + $_POST['needcall'],
	);
				
	$Order->insert($data);
	$_SESSION['lastordertime'] = time();
				
	$user = $User->get(Model_User::userid());
	$client_data = "<table><tr><td>".$labels['name']."</td><td>".$_POST['name']." ".$_POST['surname']."</td></tr><tr><td>Email</td><td>".$_POST['email']."</td></tr><tr><td>".$labels['phone']."</td><td>".Func::mkphone($_POST['phone'])."</td></tr><tr><td>".$labels['address']."</td><td>".$_POST['city'].", ".$_POST['address']."</td></tr></table>";

	$order_id = $Order->last_id();
	$cart->save_cart($order_id);

	$Esystem = new Model_Esystem();
	$Delivery = new Model_Delivery();

	$esystem = $Esystem->get($_SESSION['order_esystem']);
	$delivery = $Delivery->get($_SESSION['order_delivery']);
				
	if ($esystem->auto) {
		$url->redir($url->mk("/order/pay?esystem=".$esystem->id."&order=".$order_id));
		die();
	}
				
	echo $view->render('head.php');

	$params = array(
		"order_id" => $order_id,
		"client" => $_SESSION['order_surname']." ".$_SESSION['order_name'],
		"order_time" => date("d.m.Y (G:i)", time()),
		"order" => $view->render('cart/show.php'),
		"client" => $client_data,
		"payment" => $Esystem->get($_SESSION['order_esystem'])->cont,
		"delivery" => $Delivery->get($_SESSION['order_delivery'])->cont,
		"pass" => $user->pass,
		"name" => $_SESSION['order_name'],
		"surname" => $_SESSION['order_surname'],
		"email" => $user->email,
		"phone" => Func::mkphone($_SESSION['order_phone']),
		"city" => $_SESSION['order_city'],
		"address" => $_SESSION['order_addr'],
//		"needcall" => 0 + $_POST['needcall'],
	);

	$order_amount = $cart->amount();
	$cart->delete_all();

	$mess = Func::mess_from_tmp($templates["order_message_template"], $params);

	@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['order_email'], $labels["order_maked"], $mess);
	@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["order_maked"], $mess);
				
	$url->redirjs('/order/finish/'.$order_id);

	$_SESSION['remarking_cart'] = "1";

	echo $view->render('foot.php');
	die();
}

if($args[1] == 'finish'){
	$order_id = $args[2];
	$Order = new Model_Order($order_id);
	$order = $Order->get();
	$order_sum = $Order->cart->amount();
		
	$view->cartitems = $Order->cart->cart;		
	$view->order_sum = $order_sum;
	$view->order_id = $order_id;

	unset($_SESSION['userid']);

	echo $view->render('head.php');
	echo $view->render('order/completed.php');
	echo $view->render('foot.php');
	die();
}

if ($args[1] == 'pay' && Model_User::userid()) {
	$Order = new Model_Order();
	$order = $Order->get($_GET['order']);
		
	$cartitems = $Cart->getall(array("where" => "`order` = '".$order->id."'"));
	$n = 0;
	foreach($cartitems as $cartitem){
		$order_sum += $cartitem->price * $cartitem->num;
		$n += $cartitem->num;
	}
		
	$order_sum = $order_sum + $_SESSION['order_deliverycost'];
	$order_id = $_GET['order'];
	AS_Pay::pay($order_sum);
	die();
}
	
if ($args[1] == 'pay-result') {
	foreach ($args as $k=>$v) {
		if (preg_match("/esystem-(\d+)/", $v, $m)) {
			$esystem_id = 0 + $m[1];
		}
		if (preg_match("/order-(\d+)/", $v, $m)) {
			$order_id = 0 + $m[1];
		}	
	}

	$Esystem = new Model_Esystem();
	$esystem = $Esystem->get($esystem_id);

	$Pay = new $esystem->script();
	if ($Pay->is_success()) {
		$Order = new Model_Order($order_id);
		$Order->save(array("status" => 1));
	}
	exit();
}