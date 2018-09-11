<?
	class Model_Order extends Model_Model{
		protected $name = 'order';
		protected $depends = array("cart");
		protected $relations = array();
		protected $visibility = 0;

		public $cart;		
		public $par = 0;
		public $sum = 0;
		public $skidka = 0;
		public $to_pay = 0;

		public function __construct($id = 0){
			$this->cart = new Model_Cart(0, $id);
			//print_r($this->cart->cart);
			parent::__construct($id);
		}

		public function total($userid){
			$orders = $this->getall(array("select" => "id", "where" => "(status = 1 or status = 3 or status = 7) and user = ".data_base::nq($userid)));
			$total = 0;
			foreach($orders as $order){
				$Order = new Model_Order($order->id);
				$total += $Order->ordersum($order->id);
			}
			return $total;
		}

		public function num($userid){
			$orders = $this->getall(array("select" => "id", "where" => "user = ".data_base::nq($userid)));
			return count($orders);
		}

		public function getcart(){
			return $this->cart->cart;
		}
		
		public function ordersum($id){
			return $this->cart->amount();
/*			
			$Cart = new Model_Cart();
			$items = $Cart->getall(array("where" => "`order` = ".$id.""));

			$sum = 0;
			foreach($items as $item){
				$sum += $item->price * $item->num;
			}
			return $sum;*/
		}

		public function export_csv($order_id){
			global $path;

			error_reporting(0);
        	ini_set("display_errors", 0);
			header('Content-Type: text/csv');
			header("Content-disposition: attachment; filename=order".$order_id.".csv");

			$Cart = new Model_Cart();
			$Prod = new Model_Prod();
			$Order = new Model_Order();

			$this->id = $order_id;
			$sum = 0;

//			echo iconv("UTF-8", "WINDOWS-1251", "\"Дата\";\"Номер заказа\";\"Покупатель\";\"Код номенклатуры\";\"Номенклатура\";\"Кол-во\";\"Цена\";\"Сумма без скидки\";\"Скидка\"\n");
	
			$cart = $Cart->getall(array("where" => "`order` = ".$this->id, "order" => "id desc"));
			$order = $Order->get($this->id);

			foreach($cart as $k => $v){
				$prod = $Prod->get($v->prod);
				echo "".date("d.m.Y", $order->tstamp).";".$order->id.";".iconv("UTF-8", "WINDOWS-1251", $order->name).";".iconv("UTF-8", "WINDOWS-1251", $prod->art).";".iconv("UTF-8", "WINDOWS-1251", $prod->name).";".$v->num.";".str_replace(".", ",", strval(($v->price*(100-$v->skidka)/100))).";".str_replace(".", ",", strval(($v->price*(100-$v->skidka)/100*$v->num))).";".$v->skidka."\n";
			}
//			die();
	//		$this->recount();

//			echo ";;;;;;;".iconv("UTF-8", "WINDOWS-1251", "Итого без скидки").";".$this->sum."\n";
//			echo ";;;;;;;".iconv("UTF-8", "WINDOWS-1251", "Скидка").";".($this->sum-$this->to_pay)."\n";
//			echo ";;;;;;;".iconv("UTF-8", "WINDOWS-1251", "К оплате").";".$this->to_pay."\n";
		}

		public function export_csv2($order_id){
			global $path;
        	error_reporting(0);
        	ini_set("display_errors", 0);
			
			header('Content-Type: text/csv; charset=utf-8');
//			header('Content-Type: text/csv; charset=windows-1251');
			header("Content-disposition: attachment; filename=order".$order_id.".csv");
			
			$Prod = new Model_Prod();
			$Order = new Model_Order();

			$this->id = $order_id;
			$sum = 0;

//			echo iconv("UTF-8", "WINDOWS-1251", "\"Дата\";\"Номер заказа\";\"Покупатель\";\"Код номенклатуры\";\"Номенклатура\";\"Кол-во\";\"Цена\";\"Сумма без скидки\";\"Скидка\"\n");
			$Cart = new Model_Cart(0, $order_id);
			$cart = $Cart->cart;
//			$cart = $Cart->getall(array("where" => "`order` = ".$this->id, "order" => "id desc"));
			$order = $Order->get($this->id);

			$export = array();
			
			foreach($cart as $k => $v){
				$prod = $Prod->get($v['id']);
				$inpack = $prod->inpack;
				
				$date = date("d.m.Y", $order->tstamp);
				$name = $order->name;
				$email = $order->email;
				$art = $prod->art;
				$prod_name = $prod->name;
				$phone = $order->phone;
				$addr = $order->city.", ".$order->addr;
/*				$inpack1 = ($v->prodvar == 1 || $v->prodvar == 0) ? iconv("UTF-8", "WINDOWS-1251", $prod->inpack) : "";
				$inpack2 = ($v->prodvar == 2) ? iconv("UTF-8", "WINDOWS-1251", $prod->inpack2) : "";
				$inpack3 = ($v->prodvar == 3) ? iconv("UTF-8", "WINDOWS-1251", $prod->inpack3) : "";

				$num1 = ($v->prodvar == 1 || $v->prodvar == 0) ? strval($v->num) : "";
				$num2 = ($v->prodvar == 2) ? strval($v->num): "";
				$num3 = ($v->prodvar == 3) ? strval($v->num) : "";

				$price1 = ($v->prodvar == 1 || $v->prodvar == 0) ? str_replace(".", ",", strval($v->price*(100-$v->skidka)/100)): "";
				$price2 = ($v->prodvar == 2) ? str_replace(".", ",", strval($v->price*(100-$v->skidka)/100)): "";
				$price3 = ($v->prodvar == 3) ? str_replace(".", ",", strval($v->price*(100-$v->skidka)/100)): "";
				
				$sum1 = ($v->prodvar == 1 || $v->prodvar == 0) ? str_replace(".", ",", strval($v->price*(100-$v->skidka)/100*$v->num)) : "";
				$sum2 = ($v->prodvar == 2) ? str_replace(".", ",", strval($v->price*(100-$v->skidka)/100*$v->num)): "";
				$sum3 = ($v->prodvar == 3) ? str_replace(".", ",", strval($v->price*(100-$v->skidka)/100*$v->num)) : "";
*/				
				$export[$v['id']]["date"] = $date;
				$export[$v['id']]["order"] = $order->id;
				$export[$v['id']]["name"] = $name;
				$export[$v['id']]["art"] = $art;
				$export[$v['id']]["prod_name"] = $prod_name;
				$export[$v['id']]["email"] = $email;
				$export[$v['id']]["phone"] = $phone;
				
				if($v['var'] == 1 || $v['var'] == 0){	
					$export[$v['id']]["inpack1"] = $prod->inpack;
					$export[$v['id']]["num1"] = strval($v['num']);
					$export[$v['id']]["price1"] = str_replace(".", ",", strval($v['price']));
					$export[$v['id']]["sum1"] = str_replace(".", ",", strval($v['price']*$v['num']));
				}

				if($v['var'] == 2){	
					$export[$v['id']]["inpack2"] = $prod->inpack2;
					$export[$v['id']]["num2"] = strval($v['num']);
					$export[$v['id']]["price2"] = str_replace(".", ",", strval($v['price']));
					$export[$v['id']]["sum2"] = str_replace(".", ",", strval($v['price']*$v['num']));
				}

				if($v['var'] == 3){	
					$export[$v['id']]["inpack3"] = $prod->inpack3;
					$export[$v['id']]["num3"] = strval($v['num']);
					$export[$v['id']]["price3"] = str_replace(".", ",", strval($v['price']));
					$export[$v['id']]["sum3"] = str_replace(".", ",", strval($v['price']*$v['num']));
				}

//				echo "".$date.";".$order->id.";".$name.";".$art.";".$prod_name.";".$inpack1.";".$num1.";".$price1.";".$sum1.";".$inpack2.";".$num2.";".$price2.";".$sum2.";".$inpack3.";".$num3.";".$price3.";".$sum3."\n";
			}

			foreach($export as $v){				
				echo $v['date'].";".$v['order'].";".$v['name'].";".$v['email'].";".$v['art'].";".$v['prod_name'].";".$v['inpack1'].";".$v['num1'].";".$v['price1'].";".$v['sum1'].";".$v['inpack2'].";".$v['num2'].";".$v['price2'].";".$v['sum2'].";".$v['inpack3'].";".$v['num3'].";".$v['price3'].";".$v['sum3'].";".$phone.";".$addr."\n";
			}
			
			die();
	//		$this->recount();

//			echo ";;;;;;;".iconv("UTF-8", "WINDOWS-1251", "Итого без скидки").";".$this->sum."\n";
//			echo ";;;;;;;".iconv("UTF-8", "WINDOWS-1251", "Скидка").";".($this->sum-$this->to_pay)."\n";
//			echo ";;;;;;;".iconv("UTF-8", "WINDOWS-1251", "К оплате").";".$this->to_pay."\n";
		}
		
		public function mass_export_csv($orders){
			global $path;
        	error_reporting(0);
        	ini_set("display_errors", 0);
			
			header('Content-Type: text/csv');
			header("Content-disposition: attachment; filename=order".$order_id.".csv");
			
			foreach ($orders as $order_id) {
				$Prod = new Model_Prod();
				$Order = new Model_Order();

				$this->id = $order_id;
				$sum = 0;

				$Cart = new Model_Cart(0, $order_id);
				$cart = $Cart->cart;
				$order = $Order->get($this->id);

				$export = array();
			
				foreach($cart as $k => $v){
					$prod = $Prod->get($v['id']);
					$inpack = $prod->inpack;
				
					$date = date("d.m.Y", $order->tstamp);
					$name = $order->name;
					$email = $order->email;
					$art = $prod->art;
					$prod_name = $prod->name;
					$phone = $order->phone;
					$addr = $order->city.", ".$order->addr;
						
					$export[$v['id']]["date"] = $date;
					$export[$v['id']]["order"] = $order->id;
					$export[$v['id']]["name"] = $name;
					$export[$v['id']]["art"] = $art;
					$export[$v['id']]["prod_name"] = $prod_name;
					$export[$v['id']]["email"] = $email;
					$export[$v['id']]["phone"] = $phone;
					
					if($v['var'] == 1 || $v['var'] == 0){	
						$export[$v['id']]["inpack1"] = $prod->inpack;
						$export[$v['id']]["num1"] = strval($v['num']);
						$export[$v['id']]["price1"] = str_replace(".", ",", strval($v['price']));
						$export[$v['id']]["sum1"] = str_replace(".", ",", strval($v['price']*$v['num']));
					}

					if($v['var'] == 2){	
						$export[$v['id']]["inpack2"] = $prod->inpack2;
						$export[$v['id']]["num2"] = strval($v['num']);
						$export[$v['id']]["price2"] = str_replace(".", ",", strval($v['price']));
						$export[$v['id']]["sum2"] = str_replace(".", ",", strval($v['price']*$v['num']));
					}

					if($v['var'] == 3){	
						$export[$v['id']]["inpack3"] = $prod->inpack3;
						$export[$v['id']]["num3"] = strval($v['num']);
						$export[$v['id']]["price3"] = str_replace(".", ",", strval($v['price']));
						$export[$v['id']]["sum3"] = str_replace(".", ",", strval($v['price']*$v['num']));
					}
				}
			
				foreach($export as $v){				
					echo $v['date'].";".$v['order'].";".$v['name'].";".$v['email'].";".$v['art'].";".$v['prod_name'].";".$v['inpack1'].";".$v['num1'].";".$v['price1'].";".$v['sum1'].";".$v['inpack2'].";".$v['num2'].";".$v['price2'].";".$v['sum2'].";".$v['inpack3'].";".$v['num3'].";".$v['price3'].";".$v['sum3'].";".$phone.";".$addr."\n";
				}

//				echo ";;;;;;;;;\n";
//				echo ";;;;;;;;;\n";
			}
		}
	}
