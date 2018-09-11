<?// Controller - Оформление заказа
	function pay(){
		extract($GLOBALS);

		$Esystem = new Model_Esystem();
		$esystem = $Esystem->get($esystem_id);

		$params = array(
			'SITE_NAME' => $_SERVER['HTTP_HOST'],
			'SITE_ESYSTEM' => $esystem_id,
			'SITE_ORDERNUMBER' => $order_id,
			'SITE_PRODDESCR' => $labels["pay_for_bill"].$order_id,
			'SITE_PAYAMOUNT' => Func::fmtmoney($order_sum * $esystem->course),
		);

		if($esystem->form){
			$esystem->form = str_replace(array_keys($params), array_values($params), $esystem->form);
//			echo iconv("UTF-8", "WINDOWS-1251", $esystem->form);
			echo $esystem->form;
			echo "<script type=\"text/javascript\">window.payform.submit();</script>";
			die();
		}elseif($esystem->script){
			$Pay = new $esystem->script();
			$Pay->pay($params);
			die();
		}else{
			echo $view->render("head.php");
			echo $esystem->cont;
			echo $view->render("foot.php");
			die();
		}
	}

	if($args[1] == 'finish'){
		echo $view->render('head.php');
		echo $view->render('order/completed.php');
		echo $view->render('foot.php');
		die();
	}

	if($args[1] == ''){
	//	error_reporting(E_ALL & ~E_NOTICE);
	//	ini_set("display_errors", 1);

		$form = new Form_Order();
		$form->setAction("/order");

		if($_POST['subm']){
			if ($form->isValid($_POST)){
				$userid = 0 + $_COOKIE['userid'];
				$User = new Model_User('client');
				$user = $User->getone(array("where" => "`email` = '".data_base::nq($_POST["email"])."'"));

				if(!$_COOKIE['userid'] && empty($user->id)){
					$password = substr(md5(time()), 0, 8);

					$data = array(
						"type" => 'client',
						"pass" => ($_POST['password']) ? $_POST['password']: $password,
						"email" => $_POST['email'],
						"name" => $_POST['name'],
						"surname" => $_POST['surname'],
						"gender" => $_POST['gender'],
						"phone" => $_POST['phone'],
						"city" => $_POST['city'],
						"address" => $_POST['address'],
						"ip" => $_SERVER['REMOTE_ADDR '],
						"created" => time(),
						"discount" => 0 + $discount,
					);
					$User = new Model_User('client');
					$User->insert($data);
					$userid = $User->last_id();

					$data = array(
						'email' => $values['email'],
						'bd' => 1,
					);

					$Subscribe = new Model_Subscribe();
					$Subscribe->insert($data);

					setcookie("userid", $userid, time()+60*60*24*3000, "/");
    				setcookie("username", $values['name'], time()+60*60*24*3000, "/");
					setcookie("usertype", 'client', time()+60*60*24*3000, "/");

					$user = $User->get($userid);

					$params = array(
						"pass" => ($_POST['password']) ? $_POST['password'] : $password,
						"email" => $_POST['email'],
						"name" => $_POST['name'],
						"surname" => $_POST['surname'],
						"phone" => $_POST['phone'],
						"city" => $_POST['city'],
						"address" => $_POST['address'],
					);

					@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));
					@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['admin_email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));
				}elseif(!$_SESSION['userid'] && $user->id){
					setcookie("userid", $user->id, time()+60*60*24*3000, "/");
    				setcookie("username", $user->name, time()+60*60*24*3000, "/");
					setcookie("usertype", 'client', time()+60*60*24*3000, "/");
					$userid = $user->id;
				}

				$data = array(
					"shop" => Zend_Registry::get('shop_id'),
					"user" => $userid,
					"name" => $_POST['surname']." ".$_POST['name'],
					"addr" => $_POST['address'],
					"city" => $_POST['city'],
					"phone" => $_POST['phone'],
					"email" => $_POST['email'],
					"tstamp" => time(),
//					"esystem" => 0 + $_POST["esystem"],
					"delivery" => 0 + $_POST["delivery"],
					"esystem" => $_POST["esystem"],
					"sklad" => $_POST["sklad"],
					"comment" => $_POST["comment"],
					"status" => 4,
				);

				$Order = new Model_Order();
				$Order->insert($data);

                if($opt['discounts']){
					$Discount = new Model_Discount();

					$order_total = $Order->total($userid);
					$discount = $Discount->getnakop($order_total);
				}

				$data = array(
					"country" => $_POST["country"],
					"city" => $_POST["city"],
					"address" => $_POST["address"],
					"name" => $_POST["name"],
					"surname" => $_POST["surname"],
					"www" => $_POST["www"],
					"phone" => $_POST["phone"],
					"discount" => 0 + $discount,
				);

				$User = new Model_User('client', $_COOKIE['userid']);
//				$User->save($data);
				$user = $User->get($_COOKIE['userid']);
				$client_data = "<table><tr><td>".$labels['name']."</td><td>".$_POST['name']." ".$_POST['surname']."</td></tr><tr><td>Email</td><td>".$_POST['email']."</td></tr><tr><td>".$labels['phone']."</td><td>".$_POST['phone']."</td></tr><tr><td>".$labels['address']."</td><td>".$_POST['city'].", ".$_POST['address']."</td></tr></table>";

				$order_id = $Order->last_id();
				$cart->save_cart($order_id);

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
					"phone" => $_POST["phone"],
					"city" => $_POST["city"],
					"address" => $_POST["address"],
				);

				echo $view->render('head.php');

				$mess = Func::mess_from_tmp($templates["order_message_template"], $params);

				@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['order_email'], $labels["order_maked"], $mess);
//				@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], "alex.suleymanov@gmail.com", $labels["order_maked"], $mess);
				@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["order_maked"], $mess);

				$order_amount = $cart->amount();
				$cart->delete_all();

//				pay();
				
				$url->redirjs('/order/finish');
                session_start();
                $_SESSION['remarking_cart'] = "1";

				echo $view->render('foot.php');
			}else{
				echo $view->render('head.php');
				//if($_COOKIE['userid']){
					$view->form = $form;
					echo $view->render('order/confirm.php');
				//}else{
				//	$loginform = new Form_Login();
				//	$loginform->setAction("/order/login".$url->gvar("asfdlkh="));
//
//					$view->loginform = $loginform;
//					$view->registerform = $form;
//					echo $view->render('order/anketa.php');
//				}
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

	if($args[1] == 'register'){
		$loginform = new Form_Login();
		$loginform->setAction("/order/login".$url->gvar("asfdlkh="));

		$registerform = new Form_Register2();
		$registerform->setAction("/order/register".$url->gvar("asfdlkh="));

		if($_POST['submit']){
			if ($registerform->isValid($_POST)){
				$values = $registerform->getValues();
				$User = new Model_User();

				$data = array(
					"type" => 'client',
					"login" => $values['login'],
					"pass" => $values['pass'],
					"email" => $values['email'],
					"name" => $values['name'],
					"surname" => $values['surname'],
					"phone" => $values['phone'],
					"city" => $values['city'],
					"address" => $values['address'],
				);

				$User->insert($data);
				$userid = $User->last_id();


				setcookie("userid", $userid, time()+60*60*24*30);
				setcookie("username", $values['name'], time()+60*60*24*30);
				setcookie("usertype", 'client', time()+60*60*24*30);

				echo $view->render('head.php');
				echo "<p align=center><font color=\"green\">".$labels["user_register_congratulation"]."</font></p>";

				$params = array(
					"type" => $_POST['type'],
					"login" => $_POST['login'],
					"pass" => $_POST['pass'],
					"email" => $_POST['email'],
					"name" => $_POST['name'],
					"surname" => $_POST['surname'],
					"phone" => $_POST['phone'],
					"city" => $_POST['city'],
					"address" => $_POST['address'],
				);

				@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));
				@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['admin_email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));

				echo $view->render('foot.php');

				$url->redirjs("/order/confirm".$url->gvar("asfdlkh="));
				die();
			}else{
				echo $view->render('head.php');
				$view->registerform = $registerform;
				$view->loginform = $loginform;
				echo $view->render('order/anketa.php');
				echo $view->render('foot.php');
			}
		}else{
			echo $view->render('head.php');
			$view->registerform = $registerform;
			$view->loginform = $loginform;
			echo $view->render('order/anketa.php');
			echo $view->render('foot.php');
		}
		die();
	}

	if($args[1] == 'login'){
		$loginform = new Form_Login();
		$loginform->setAction("/order/login".$url->gvar("asfdlkh="));

		$registerform = new Form_Order();
//		$registerform->setAction("/order/register".$url->gvar("asfdlkh="));

		if($_POST["submit"]){
			$values = $loginform->getValues();
			$User = new Model_User('client');
			$user = $User->getone(array("where" => "email = '".data_base::nq($values["login"])."'"));
			
			$pass = explode(":", $user->pass);

			if($user->id && $user->pass == md5($pass[1].$values["pass"]).':'.$pass[1]){
				setcookie("userid", $user->id, time()+60*60*24*30);
				setcookie("username", $user->name, time()+60*60*24*30);
				setcookie("usertype", $user->type, time()+60*60*24*30);

			    $url->redir("/order/confirm".$url->gvar("asfdlkh="));
				die();
			}else{
				$_SESSION["error"] = $labels["wrong_password"];
				$url->redir("/order/login".$url->gvar("asfdlkh="));
				die();
			}
		}else{
			echo $view->render('head.php');
			echo $view->page->cont;
			$view->loginform = $loginform;
			$view->registerform = $registerform;
			echo $view->render('order/anketa.php');
			echo $view->render('foot.php');
			die();
		}
	}

/*	if($args[1] == ''){
		print_r($_COOKIE); die();
// && $_COOKIE['userid']){
		$url->redir("/order/confirm".$url->gvar("asfdlkh="));
	}/*elseif($args[1] == ''){
		$loginform = new Form_Login();
		$loginform->setAction("/order/login".$url->gvar("asfdlkh="));
		$registerform = new Form_Order();
//		$registerform->setAction("/order/register".$url->gvar("asfdlkh="));

		$view->loginform = $loginform;
		$view->registerform = $registerform;

		echo $view->render('head.php');
		echo $view->render('order/anketa.php');
		echo $view->render('foot.php');
	}*/

	if($args[1] == 'pay' && $_COOKIE['userid']){
		$esystem_id = ($_POST["esystem"]) ? $_POST["esystem"] : $_GET["esystem"];
		$order_id = ($_POST["order"]) ? $_POST["order"] : $_GET["order"];

		$Cart = new Model_Cart();
		$cartitem = $Cart->getone(array("where" => "`order` = '".data_base::nq($order_id)."'"));
		$order_sum += $cartitem->price * $cartitem->num;

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
