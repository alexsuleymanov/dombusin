<?	
	class AS_Skidka{
		public function __construct(){

		}

		public static function skidka($sum){
			if($_SESSION['useropt'])
				return $sum;
//			$sum = self::user_skidka($sum);
			else
				$sum = self::sum_skidka($sum);

			return $sum;
		}		

		protected static function user_skidka($sum){
			$Order = new Model_Order();
			$Discount = new Model_Discount();

			if($_SESSION['userid'] && !isset($_SESSION['admin_id'])){
				$order_total = $Order->total($_SESSION['userid']);
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
			$discount = 0;
			
			foreach($sum_skidka as $k => $v)
				$sum_skidka[$k] = explode(":", $v);

			foreach($sum_skidka as $k => $v){
				if($sum > $v[0]){
//					$sum2 = $sum * $v[1] / 100;
					if($discount < $v[1]) $discount = $v[1];
				}else break;
			}
			
			return $discount;
		}
		
		static function num_skidka($num, $skidka){
			$discount = 0;
			$skidka = self::skidka_decode($skidka);
			if(!is_array($skidka)) return 0;
			foreach($skidka as $k => $v){
				if($num >= $v['min'] && $num <= $v['max']){
					$discount = $v['skidka'];
					break;
				}
			}
			
			return $discount;
		}
		
		static function skidka_admin($skidka){
			$skidka1 = '';
			foreach(json_decode($skidka) as $k => $v){
				if($k) $skidka .= ";";
				$skidka1 .= $k.":".$v;
			}
			return $skidka1;
		}

		static function skidka_decode($skidka){
			$skidka1 = json_decode($skidka);
			$skidka2 = array();
			if(count($skidka1)) {
				foreach ($skidka1 as $k => $v) {
					if (strstr($k, '+')) {
						$min = intval(trim($k, '+'));
						$max = MAX_VALUE;
					} else {
						list($min, $max) = explode("-", $k);
					}

					$skidka2[] = array('min' => $min, 'max' => $max, 'skidka' => $v);
				}
			}
			return $skidka2;
		}
	}