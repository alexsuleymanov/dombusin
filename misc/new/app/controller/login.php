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
		Model_User::logoff();		
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
				Model_User::login($user);
								
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
