<?	// Controller - Коментарии
	$results = 20;
	$start = 0 + $_GET['start'];

	$form = new Form_Comment();
	if(Func::is_ajax()){
//		header('Content-Type: text/html; charset=windows-1251');
//		if($form->isValid($_POST)){
			$Comment = new Model_Comment();

			$data = array(
				'type' => $_POST["type"],
				'par' => 0 + $_POST["par"],
				'user' => 0 + $_COOKIE['userid'],
				'author' => $_POST['author'],
//				'email' => $_POST['email'],
				'theme' => $_POST['theme'],
				'tstamp' => time(),
				'cont' => $_POST['cont'],
				'visible' => 0,
			);

			$Comment->insert($data);


			$msg = "Оставлен отзыв, зайдите в админ-панель и подтвердите";
			$subj = "Отзыв оставлен";
			
			Func::mailhtml("Dombusin", "noreply@dombusin.com", $sett['admin_email'], $subj, $msg);

			$form->success("Ваш отзыв отправлен модератору");
			$form->redir("/");
//			$form->clear();
//		}else{
//			$form->printErrorMessages();
//		}
	}else{
		$Comment = new Model_Comment();		

		$cond = array("where" => "visible = 1");

		$view->cnt = $Comment->getnum($cond);
		$view->results = $results;
		$view->start = $start;
		
		$cond["limit"] = "$start, $results";
		$view->comments = $Comment->getall($cond);

		echo $view->render("head.php");
		echo $view->render("comments/list.php");
		echo $view->render("foot.php");
	}
