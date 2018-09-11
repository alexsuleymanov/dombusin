<?
	class Model_Order extends Model_Model{
		protected $name = 'order';
		protected $depends = array("cart");
		protected $relations = array();
		protected $visibility = 0;

		public $par = 0;
		public $sum = 0;
		public $skidka = 0;
		public $to_pay = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public function total($userid){
			$orders = $this->getall(array("select" => "id", "where" => "(status = 1 or status = 3 or status = 7) and user = ".data_base::nq($userid)));
			$total = 0;
			foreach($orders as $order){
				$total += $this->ordersum($order->id);
			}
			return $total;
		}

		public function ordersum($id){
			$Cart = new Model_Cart();
			$items = $Cart->getall(array("where" => "`order` = ".$id.""));

			$sum = 0;
			foreach($items as $item){
				$sum += $item->price * $item->num;
			}
			return $sum;
		}

		public function recount(){
			global $sett;
			$sum_total = 0;  
			$sum_so_skidkoi = 0;
			$sum_bez_skidki = 0;

			$Prod = new Model_Prod();
			$Discount = new Model_Discount();
			$Cart = new Model_Cart();
			$Order = new Model_Order();
			$prods = $Cart->getall(array("where" => "`order` = '".data_base::nq($this->id)."'"));
			$order = $Order->get($this->id);

			foreach($prods as $k => $v){
				$sum_bez_skidki += $v->price * $v->num;
				$sum_so_skidkoi += ($v->price - $v->price * $v->skidka / 100) * $v->num;
			}

//			$sum_so_skidkoi = AS_Skidka::skidka($sum_so_skidkoi);
			
			$this->sum = $sum_total;
			$this->to_pay = $sum_so_skidkoi;
			$this->skidka = $this->sum - $this->to_pay;
//			$this->sum = $sum_so_skidkoi;
//			$this->skidka = AS_Skidka::skidka($sum_so_skidkoi);
//			$this->to_pay = $this->sum - $this->skidka;
		}

		public function getall($opt = array()){
			if(isset($opt['where']))
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."'";

			return parent::getall($opt);
		}

		public function getnum($opt = array()){
			if(isset($opt['where']))
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."'";

			return parent::getnum($opt);
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

			$export = array();
			
			foreach($cart as $k => $v){
				$prod = $Prod->get($v->prod);
				$inpack = $v->inpack;
				
				$date = date("d.m.Y", $order->tstamp);
				$name = iconv("UTF-8", "WINDOWS-1251", $order->name);
				$art = iconv("UTF-8", "WINDOWS-1251", $prod->art);
				$prod_name = iconv("UTF-8", "WINDOWS-1251", $prod->name);
				
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
				$export[$v->id]["date"] = $date;
				$export[$v->id]["order"] = $order->id;
				$export[$v->id]["name"] = $name;
				$export[$v->id]["art"] = $art;
				$export[$v->id]["prod_name"] = $prod_name;
				
				if($v->prodvar == 1 || $v->prodvar == 0){	
					$export[$v->id]["inpack1"] = iconv("UTF-8", "WINDOWS-1251", $prod->inpack);
					$export[$v->id]["num1"] = strval($v->num);
					$export[$v->id]["price1"] = str_replace(".", ",", strval($v->price*(100-$v->skidka)/100));
					$export[$v->id]["sum1"] = str_replace(".", ",", strval($v->price*(100-$v->skidka)/100*$v->num));
				}

				if($v->prodvar == 2){	
					$export[$v->id]["inpack2"] = iconv("UTF-8", "WINDOWS-1251", $prod->inpack2);
					$export[$v->id]["num2"] = strval($v->num);
					$export[$v->id]["price2"] = str_replace(".", ",", strval($v->price*(100-$v->skidka)/100));
					$export[$v->id]["sum2"] = str_replace(".", ",", strval($v->price*(100-$v->skidka)/100*$v->num));
				}

				if($v->prodvar == 3){	
					$export[$v->id]["inpack3"] = iconv("UTF-8", "WINDOWS-1251", $prod->inpack3);
					$export[$v->id]["num3"] = strval($v->num);
					$export[$v->id]["price3"] = str_replace(".", ",", strval($v->price*(100-$v->skidka)/100));
					$export[$v->id]["sum3"] = str_replace(".", ",", strval($v->price*(100-$v->skidka)/100*$v->num));
				}

//				echo "".$date.";".$order->id.";".$name.";".$art.";".$prod_name.";".$inpack1.";".$num1.";".$price1.";".$sum1.";".$inpack2.";".$num2.";".$price2.";".$sum2.";".$inpack3.";".$num3.";".$price3.";".$sum3."\n";
			}
			
			foreach($export as $v){				
				echo $v['date'].";".$v['order'].";".$v['name'].";".$v['art'].";".$v['prod_name'].";".$v['inpack1'].";".$v['num1'].";".$v['price1'].";".$v['sum1'].";".$v['inpack2'].";".$v['num2'].";".$v['price2'].";".$v['sum2'].";".$v['inpack3'].";".$v['num3'].";".$v['price3'].";".$v['sum3']."\n";
			}
			
			die();
	//		$this->recount();

//			echo ";;;;;;;".iconv("UTF-8", "WINDOWS-1251", "Итого без скидки").";".$this->sum."\n";
//			echo ";;;;;;;".iconv("UTF-8", "WINDOWS-1251", "Скидка").";".($this->sum-$this->to_pay)."\n";
//			echo ";;;;;;;".iconv("UTF-8", "WINDOWS-1251", "К оплате").";".$this->to_pay."\n";
		}
	}
