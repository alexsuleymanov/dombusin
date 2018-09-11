<?	
	class AS_Skidka{
		public function __construct(){

		}

		public static function skidka($sum){
//			$sum = self::user_skidka($sum);
			$sum = self::sum_skidka($sum);

			return $sum;
		}		

		protected static function user_skidka($sum){
			$Order = new Model_Order();
			$Discount = new Model_Discount();

			if($_COOKIE['userid'] && !isset($_COOKIE['admin_id'])){
				$order_total = $Order->total($_COOKIE['userid']);
				$dictounts = $Discount->getall();
				$discount = 0 + $Discount->getnakop($order_total);
				
				$sum = $sum - $sum * $discount / 100;
			}
			return $discount;
		} 

		protected static function sum_skidka($sum){
			global $sett;
			$sum2 = $sum;
			$sum_skidka = explode(";",$sett['sum_skidka']);

			foreach($sum_skidka as $k => $v)
				$sum_skidka[$k] = explode(":", $v);

			foreach($sum_skidka as $k => $v){
				if($sum > $v[0]){
					$sum2 = $sum * $v[1] / 100;
					if($discount < $v[1]) $discount = $v[1];
				}else break;
			}
			
			return $sum2;
		}
	}