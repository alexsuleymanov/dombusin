<?// Controller - Оформление заказа
	if($args[1] == ''){
 		$form = new Form_Order();
		$form->setAction("/order");

		if($_POST['subm']){
			if(isset($_SESSION['lastordertime']) && $_SESSION['lastordertime'] > (time() - 60)) $url->redir("/cart");
			$Order = new Model_Order();
			
			if ($form->isValid($_POST)){
				$userid = Model_User::userid();
				$Discount = new Model_Discount();
				$User = new Model_User('client');
				$user = $User->getone(array("where" => "`email` = '".data_base::nq($_POST["email"])."'"));
				if(empty($cart->cart) || $user->lastordertime > (time() - 60)) $url->redir("/cart");
				
				if(Model_User::userid() == 0 && empty($user->id)){ // Новый клиент
					$password = substr(md5(time()), 0, 8);
					$data = array(
						"type" => 'client',
						"pass" => ($_POST['password']) ? $_POST['password']: $password,
						"email" => $_POST['email'],
						"name" => $_POST['name'],
						"surname" => $_POST['surname'],
						"gender" => $_POST['gender'],
						"phone" => Func::mkphone($_POST['phone']),
						"city" => $_POST['city'],
						"address" => $_POST['address'],
						"ip" => $_SERVER['REMOTE_ADDR'],
						"created" => time(),
						"discount" => 0,
						"lastordertime" => time(),					
					);
					$User = new Model_User('client');
					$User->insert($data);
					$userid = $User->last_id();

					$data = array(
						'email' => $values['email'],
						'bd' => 1,
					);
															
					$user = $User->get($userid);
					Model_User::login($user);
					$cart->user_login(AS_Discount::getUserDiscount());

					$params = array(
						"pass" => ($_POST['password']) ? $_POST['password'] : $password,
						"email" => $_POST['email'],
						"name" => $_POST['name'],
						"surname" => $_POST['surname'],
						"phone" => Func::mkphone($_POST['phone']),
						"city" => $_POST['city'],
						"address" => $_POST['address'],
					);
				}elseif(Model_User::userid() == 0 && $user->id){ // Клиент есть в базе но не авторизирован		
					if ($user->opt && $cart->amount() < 2000) {
						$_SESSION['message'] = $labels['error_opt_user_auth'];
						$url->redir("/user");
						die();
					}

					Model_User::login($user);
					$cart->user_login($user->id, Model_User::user_discount($user->id));
					$userid = $user->id;
				}  elseif(Model_User::userid()){ // Клиент авторизирован
					
				}

				$data = array(
					"user" => $userid,
					"manager" => 0 + $user->manager,
					"name" => $_POST['surname']." ".$_POST['name'],
					"addr" => $_POST['address'],
					"city" => $_POST['city'],
					"phone" => Func::mkphone($_POST['phone']),
					"email" => $_POST['email'],
					"tstamp" => time(),
//					"esystem" => 0 + $_POST["esystem"],
					"delivery" => 0 + $_POST["delivery"],
					"esystem" => $_POST["esystem"],
					"sklad" => $_POST["sklad"],
					"comment" => $_POST["comment"],
					"status" => 8,
					"opt" => 0 + $user->opt,
					"needcall" => 0 + $_POST['needcall'],
				);
				
				$Order->insert($data);
				$_SESSION['lastordertime'] = time();
				
				$data = array(
					"email" => $_POST['email'],
					"name" => $_POST['name'],
					"surname" => $_POST['surname'],
					"gender" => $_POST['gender'],
					"phone" => Func::mkphone($_POST['phone']),
					"city" => $_POST['city'],
					"address" => $_POST['address'],
					"lastordertime" => time(),
				);
				$User = new Model_User('client', $userid);
				$User->save($data);
					
				$data = array(
					"country" => $_POST["country"],
					"city" => $_POST["city"],
					"address" => $_POST["address"],
					"name" => $_POST["name"],
					"surname" => $_POST["surname"],
					"www" => $_POST["www"],
					"phone" => Func::mkphone($_POST["phone"]),
					"discount" => 0 + $discount,
				);

				$User = new Model_User('client', Model_User::userid());
				$user = $User->get(Model_User::userid());
				$client_data = "<table><tr><td>".$labels['name']."</td><td>".$_POST['name']." ".$_POST['surname']."</td></tr><tr><td>Email</td><td>".$_POST['email']."</td></tr><tr><td>".$labels['phone']."</td><td>".Func::mkphone($_POST['phone'])."</td></tr><tr><td>".$labels['address']."</td><td>".$_POST['city'].", ".$_POST['address']."</td></tr></table>";

				$order_id = $Order->last_id();
				$cart->save_cart($order_id);

				echo $view->render('head.php');

				$Esystem = new Model_Esystem();
				$Delivery = new Model_Delivery();

				$params = array(
					"order_id" => $order_id,
					"client" => $_POST["surname"]." ".$_POST["name"],
					"order_time" => date("d.m.Y (G:i)", time()),
					"order" => $view->render('cart/show.php'),
					"client" => $client_data,
					"payment" => $Esystem->get($_POST["esystem"])->cont,
					"delivery" => $Delivery->get($_POST["delivery"])->cont,
					"login" => $user->login,
					"pass" => $user->pass,
					"name" => $_POST["name"],
					"surname" => $_POST["surname"],
					"email" => $user->email,
					"phone" => Func::mkphone($_POST["phone"]),
					"city" => $_POST["city"],
					"address" => $_POST["address"],
					"needcall" => 0 + $_POST['needcall'],
				);

				$order_amount = $cart->amount();
				$cart->delete_all();

				$mess = Func::mess_from_tmp($templates["order_message_template"], $params);

				@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['order_email'], $labels["order_maked"], $mess);
				@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["order_maked"], $mess);
				
				$url->redirjs('/order/finish/'.$order_id);
                session_start();
                $_SESSION['remarking_cart'] = "1";

				echo $view->render('foot.php');
			}else{
				echo $view->render('head.php');
				$view->form = $form;
				echo $view->render('order/confirm.php');
				echo $view->render('foot.php');
			}
		}else{
			echo $view->render('head.php');
			$view->form = $form;
			echo $view->render('order/confirm.php');
			echo $view->render('foot.php');
		}
	}elseif($args[1] == '/confirm'){
		$url->redir("/order".$url->gvar("asfdlkh="));
		die();
	}

	if($args[1] == 'finish'){
		$order_id = $args[2];
		$Order = new Model_Order($order_id);
		$order = $Order->get();
		$order_sum = $Order->cart->amount();
		
		if ($order->status != 8) {
			header("Location: /");
			die();
		} else {
			$Order->update(array("status" => 4), array("where" => "id = '".data_base::nq($order_id)."'"));
		}		
		
		$view->cartitems = $Order->cart->cart;		
		$view->order_sum = $order_sum;
		$view->order_id = $order_id;

		unset($_SESSION['userid']);

		echo $view->render('head.php');
		echo $view->render('order/completed.php');
		echo $view->render('foot.php');
		die();
	}

	if($args[1] == 'pay' && Model_User::userid()){
		$esystem_id = ($_POST["esystem"]) ? $_POST["esystem"] : $_GET["esystem"];
		$order_id = ($_POST["order"]) ? $_POST["order"] : $_GET["order"];

		$Cart = new Model_Cart(0, $order_id);
		$order_amount = $Cart->amount();
		pay();
		die();
	}

	if($args[1] == 'pay-result'){
		foreach($args as $k=>$v){
			if(preg_match("/esystem-(\d+)/", $v, $m))
				$esystem_id = 0 + $m[1];
			if(preg_match("/order-(\d+)/", $v, $m))
				$order_id = 0 + $m[1];
		}

		$Esystem = new Model_Esystem();
		$esystem = $Esystem->get($esystem_id);

		$Pay = new $esystem->script();
		if($Pay->is_success()){
			$Order = new Model_Order($order_id);
			$Order->save(array("status" => 1));
		}
		exit();
	}
