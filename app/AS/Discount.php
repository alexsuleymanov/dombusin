<?php
	class AS_Discount
	{
		public function __construct()
		{
			
		
		public static function getUserDiscount()
		{
			if(Model_User::isOpt()) return 0;
			return isset($_SESSION['userdiscount']) ? $_SESSION['userdiscount'] : 0;	
		}
		
		public static function calculateUserDiscount(Model_Model $Discount, Model_Model $Order, Model_Model $User, $user_id)
		{			
			if ($user_id <= 0) return 0;
			
			$user = $User->get($user_id);
			$order_total = $Order->total($user->id);			
			$discount = $Discount->getone(array("where" => "nakop <= '".data_base::nq($order_total)."'", "order" => "nakop desc"));
			
			if ($user->opt == 0) {
				return $discount->value;
			} else {
				return 0;
			}
		}
	}