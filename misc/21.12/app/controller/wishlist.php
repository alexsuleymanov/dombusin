<?// Controller - Wishlist

	if(!isset($_COOKIE['userid'])){
		$_SESSION["error"] = $labels["you_must_register"];
		$url->redir("/login");
		die();
	}

	$action = ($args[1]) ? $args[1] : 'show';

	$view->bc["/".$args[0]] = $labels["cart"];

	if($action == 'add'){
		$id = 0 + $args[2];

		$Wishlist = new Model_Wishlist();
		if($Wishlist->getnum(array("where" => "user = '".$_COOKIE['userid']."' and prod = '".data_base::nq($id)."'") == 0))
			$Wishlist->insert(array("prod" => $id));

		if($_POST['ajax']){
//			$result = array("prods" => $cart->prod_num(), "amount" => $cart->amount());
//			echo Zend_Json::encode($result);
			die();
		}else{
			header("Location: /wishlist/show".$url->gvar("asdflkha="));
			die();
		}
	}elseif($action == 'show'){
		$Page = new Model_Page('page');
		$view->page = $Page->getbyname("wishlist");

		echo $view->render('head.php');
		echo $view->render('user/wishlist.php');
		echo $view->render('foot.php');
	}elseif($action == 'delete'){
		$Wishlist = new Model_Wishlist();
		$Wishlist->delete($args[2]);

		if($_POST['ajax']){
			die();
		}else{
			header("Location: /wishlist/show".$url->gvar("asdflkha="));
			die();
		}
	}