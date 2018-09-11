<?// Controller - Форма обратной связи

	$form = new Form_Contact();
	$form->addDecorator(new Form_Decorator_Ajax());

	$types = array(
		"Zend_Form_Element_Submit",
		"Zend_Form_Element_File",
		"Zend_Form_Element_Captcha",
		"Zend_Form_Element_Exception",
		"Zend_Form_Element_Hash",
		"Zend_Form_Element_Hidden",
		"Zend_Form_Element_Image",
		"Zend_Form_Element_Reset",
		"Zend_Form_Element_Button",
	);

	if(Func::is_ajax()){
		if($form->isValid($_POST)){
			foreach($form->getElements() as $k => $v){
				if(in_array($v->getType(), $types)) continue;
				$text .= "<b>".$v->getLabel()."</b>: ".$_POST[$v->getName()]."<br>";
			}

			$params = array(
				"message" => $text,
			);

			@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['admin_email'], $labels["message_from_site"], Func::mess_from_tmp($templates["contact_message_template"], $params));
			@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["message_sent"], Func::mess_from_tmp($templates["auto_message_template"], $params));
			$form->success($labels["message_sent"]);
			$form->clear();
		}else{
			$form->printErrorMessages();
		}
		die();
	}

	if ($_POST["submit"]) {
		if($form->isValid($_POST)){
			$text = "";
			foreach($form->getElements() as $k => $v){
				if(in_array($v->getType(), $types)) continue;
				$text .= "<b>".$v->getLabel()."</b>: ".$_POST[$v->getName()]."<br>";
			}

			$params = array(
				"message" => $text,
			);

			@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $sett['admin_email'], $labels["message_from_site"], Func::mess_from_tmp($templates["contact_message_template"], $params));
			@Func::mailhtml($_SERVER[HTTP_HOST], "noreply@".$_SERVER[HTTP_HOST], $_POST['email'], $labels["message_sent"], Func::mess_from_tmp($templates["auto_message_template"], $params));
			echo $view->render("head.php");
			echo $view->page->cont;
			echo "<center><h2>".$labels["message_sent"]."</h2></center>";
			echo $view->render("foot.php");
		}else{
			echo $view->render("head.php");
			echo $view->page->cont;
			echo $form->render($view);
			echo $view->render("foot.php");
		}
	}else{
		$view->bc["/".$args[0]] = $labels["contacts"];

		echo $view->render("head.php");
		echo $view->page->cont;
		echo $form->render($view);
		echo "<br><br><br>";
		echo $view->render("foot.php");
	}