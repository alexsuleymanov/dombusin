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
