<?
	$cart = new Model_Cart();
	$cart->setPath($path);
	
	if(Model_User::isauth()){
		$cart->user_login(Model_User::userid(), AS_Discount::getUserDiscount(), 1);
	}
	
	foreach ($cart->cart as $k => $v)
    if ($v[num] < 1)
        unset($cart->cart[$k]);
	