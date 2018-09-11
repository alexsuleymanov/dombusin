<?// Controller - Вход пользователей

	if($args[1] == "remind"){
		$form = new Form_Remind();

		if($_POST["submit"]){
			$values = $form->getValues();

			$User = new Model_User('client');
			$user = $User->getone(array("where" => "email = '".data_base::nq($values["email"])."'"));

			if(count($user)){
				$password = substr(md5(time()), 0, 8);
				$data = array(
					"pass" => Func::encrypt_pass($password),
				);

				$params = array(
					"email" => $user->email,
					"login" => $user->login,
					"pass" => $password,
				);

				$User->update($data, array("where" => "id = ".$user->id));

				Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $values["email"], $labels["remind_message_theme"], Func::mess_from_tmp($templates["remind_message_template"], $params));
				echo $view->render("head.php");
				echo "<p align=center><font color=\"green\">".$labels["password_sent"]."</font></p>";
				echo $view->render("foot.php");
				die();
			}else{
				echo $view->render("head.php");
				echo "<p align=center><font color=\"red\">".$labels["email_wrong"]."</font></p>";
				echo $view->render("foot.php");
				die();
			}
		}

		$Page = new Model_Page('page');
		$view->page = $Page->getbyname("login/remind");

		$view->bc["/".$args[0]] = $view->page->name;

		echo $view->render("head.php");
		echo $view->page->cont;
		echo $form->render($view);
		echo $view->render("foot.php");
		die();
	}

	if($args[1] == "logoff"){
		unset($_COOKIE['userid']);
		setcookie("userid", null, -1, "/");
		setcookie("username", null, -1, "/");
		setcookie("usertype", null, -1, "/");
		setcookie("userdiscount", null, -1, "/");
		setcookie("userdiscountlevel", null, -1, "/");
		
		$url->redir("/");
		die();
	}

	if($args[1] == ""){
		$form = new Form_Login();
		if($_POST["submit"]){
			$values = $form->getValues();
			$User = new Model_User('client');
			$user = $User->getone(array("where" => "email = '".data_base::nq($values["login"])."'"));
			
			$pass = explode(":", $user->pass);

			if($user->id && ($user->pass == md5($pass[1].$values["pass"]).':'.$pass[1] || $user->pass == $values["pass"])){
				setcookie("userid", $user->id, time()+60*60*24*3000);
				setcookie("username", $user->name, time()+60*60*24*3000);
				setcookie("usertype", $user->type, time()+60*60*24*3000);

				$Session = new Model_Session();
				$Discount = new Model_Discount();
				$Order = new Model_Order();
				$order_total = $Order->total($user->id);

				setcookie("userdiscount", $Discount->getnakop($order_total), time()+60*60*24*3000);
				setcookie("userdiscountlevel", $Discount->getnakopid($order_total), time()+60*60*24*3000);

				$prods = $Session->getall(array("where" => "`user` = '".$user->id."'"));
				foreach($prods as $prod)
					$cart->cart[$prod->prod] = array('id' => $prod->prod, 'num' => $prod->num, 'price' => $prod->price, 'skidka' => $prod->skidka);

				if($_POST["redirect"])
					$url->redir($_POST["redirect"]);
				else
				    $url->redir("/user");
				die();
			}else{
				$_SESSION["error"] = $labels["wrong_password"];
				if($_GET["from"])
					$url->redir($_GET["from"]);
				else
					$url->redir("/login");
				die();
			}
		}else{
			$view->bc["/".$args[0]] = $view->page->name;

			echo $view->render("head.php");
			echo $view->page->cont;
			echo $form->render($view);
			echo $view->render("user/login.php");
			echo $view->render("foot.php");
			die();
		}
	}
