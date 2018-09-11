<?// Controller - Регистрация

	$form = new Form_Register();

	if($_POST['submit']){
		if ($form->isValid($_POST)){
			$values = $form->getValues();
			$User = new Model_User();

//			$password = substr(md5(time()), 0, 8);

			$data = array(
				"type" => 'client',
				"pass" => Func::encrypt_pass($values['pass']),
				"email" => $values['email'],
				"name" => $values['name'],
				"surname" => $values['surname'],
				"gender" => $values['gender'],
				"phone" => $values['phone'],
				"city" => $values['city'],
				"address" => $values['address'],
				"ip" => $_SERVER['REMOTE_ADDR '],
				"created" => time(),
			);

			$User->insert($data);
			$userid = $User->last_id();
	
			$data = array(
				'email' => $values['email'],
				'bd' => 1,
			);

			$Subscribe = new Model_Subscribe();
			$Subscribe->insert($data);

			setcookie("userid", $userid, time()+60*60*24*3000);
			setcookie("username", $values['name'], time()+60*60*24*3000);
			setcookie("usertype", 'client', time()+60*60*24*3000);

			$params = array(
				"type" => $_POST['type'],
				"login" => $_POST['login'],
				"gender" => $_POST['gender'],
				"pass" => $_POST['pass'],
				"email" => $_POST['email'],
				"name" => $_POST['name'],
				"patr" => $_POST['patr'],
				"surname" => $_POST['surname'],
				"phone" => $_POST['phone'],
				"city" => $_POST['city'],
				"address" => $_POST['address'],
			);

			@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));
			@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['admin_email'], $labels["register_message_theme"], Func::mess_from_tmp($templates["register_message_template"], $params));

			$url->redir("/user");

			echo $view->render('head.php');
			echo "<p align=center><font color=\"green\">".$labels["user_register_congratulation"]."</font></p>";
			echo $view->render('foot.php');

			if($_POST["redirect"])
				$url->redir("/user");
			die();
		}else{
			echo $view->render('head.php');
			$view->form = $form->render($view);
			echo $view->render('user/register.php');
			echo $view->render('foot.php');
		}
	}else{
		$view->bc["/".$args[0]] = $labels["register"];
		echo $view->render('head.php');
		$view->form = $form->render($view);
		echo $view->render('user/register.php');
		echo $view->render('foot.php');
	}