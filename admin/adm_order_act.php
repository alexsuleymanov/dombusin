<?
	$del = 0 + $_GET['del'];
	$add = 0 + $_GET['add'];
	$vid = 0 + $_GET['id'];
	$export = 0 + $_GET['export'];
	$export2 = 0 + $_GET['export2'];
	$edit_cart = 0 + $_GET['edit_cart'];

	if ($del){
		$Cart = new Model_Cart();
		$Cart->delete(array("where" => "id = '$del'"));
		echo $del;
		die();
	}

	if ($add){
		$Cart = new Model_Cart();
		$Cart->insert(array("order" => $vid));
		echo $Cart->last_id();
		die();
	}

	if ($export){
		$Order = new Model_Order();
		$Order->export_csv($vid);
		die();
	}

	if ($_GET['action'] == 'mass_export'){
		$Order = new Model_Order();
		$Order->mass_export_csv($_POST['del']);
		die();
	}
	
	if ($export2){
		$Order = new Model_Order();
		$Order->export_csv2($vid);
		die();
	}

	if ($edit_cart){
		$Cart = new Model_Cart($_GET['cart_id']);
		$Prod = new Model_Prod($_GET['prod']);
		$prod = $Prod->get();
		
		$data = array(
			'id' => $_GET['cart_id'],
			'order' => $_GET['order'],
			'prod' => $prod->id,
			'price' => $prod->price,
			'num' => 1,
			'skidka' => $prod->skidka,
		);

		$Cart->save($data);

		Zend_Json::encode($data);
		die();
	}

	if($_GET['update_cart']){
		$Cart = new Model_Cart($_GET['cart_id']);
		$Cart->save(array("num" => $_GET['num']));

		die();
	}

	if($_GET['change_user']){
		if($_GET['user_email']){
			$Order = new Model_Order($_GET['order_id']);
	
			$User = new Model_User("client");
			$user = $User->getone(array("where" => "email = '".data_base::nq($_GET['user_email'])."'"));
//			print_r($user);
//			print_r($Order->get());
//			echo $url->gvar("order_id=&change_user=&user_id=&user_email=");
			$Order->save(array("user" => $user->id));
			$url->redir($url->gvar("order_id=&change_user=&user_id="));
			die();
		}else{
			echo $view->render('head.php');
			echo "<form action='".$url->gvar("time=")."' method='get'><input type='hidden' name='order_id' value='".$_GET['order_id']."'><input type='hidden' name='change_user' value='1'>E-mail пользователя: <input type=\"text\" name=\"user_email\"> <input type='submit' value='Сменить'></form>";
			echo $view->render('foot.php');
		}
		die();
	}