<?
	class Model_Cart extends Model_Model{
		protected $name = 'cart';
		protected $depends = array();
		protected $relations = array();
		protected $prod_vars;
		protected $visibility = 0;
		protected $Session;

		public $par = 0;
		public $cart = array();
		public $sum = 0;
		public $skidka = 0;
		public $to_pay = 0;
		public $prods_limited = array();
		
		public function __construct($id = 0){
			Zend_Session::start();
			$this->Session = new Model_Session();

			parent::__construct($id);
			$this->cart = &$_SESSION['cart'];

			if(empty($_SESSION['cart'])){
				$_SESSION['cart'] = array();
				if($_COOKIE['userid']){
					$prods = $this->Session->getall(array("where" => "`user` = '".$_COOKIE['userid']."'"));
					foreach($prods as $prod)
						$this->cart[$prod->prod] = array('id' => $prod->prod, 'var' => $prod->var, 'num' => $prod->num, 'price' => $prod->price, 'skidka' => $prod->skidka);
				}
			}
		}

		public function cart_id($id = 0, $var = 0, $chars = array()){
			ksort($chars);
			return md5($id."_".$var);//."_".Zend_Json::encode($chars));
		}

		public function buy($id = 0, $var = 0, $num = 1, $price = 0, $skidka = 0, $weight = 0){
			$cart_id = $this->cart_id($id, $var);
			
			if(isset($this->cart[$cart_id])){
				$this->cart[$cart_id]['num'] += $num;
///				if($_COOKIE['userid'])
	//				$this->Session->update(array("num" => $this->cart[$id]['num']), array("where" => "`user` = '".$_COOKIE['userid']."' and prod = '".$id."'"));
			}else{
				$this->cart[$cart_id] = array('id' => $id, 'var' => $var, 'num' => $num, 'price' => $price, 'skidka' => $skidka, 'weight' => $weight);
//				if($_COOKIE['userid'])
/*					$this->Session->insert(array(
						"user" => $_COOKIE['userid'],
						"prod" => $id,
						"num" => $num,
						"price" => $price,
						"skidka" => $skidka,
					));				*/
			}
			$this->recount();
		}

		public function amount(){
			$amount = 0;
			foreach($this->cart as $k => $v)
				if($v['skidka'])
					$amount += ($v['price'] - $v['price'] * $v['skidka'] / 100) * $v['num'];
				else
					$amount += $v['price'] * $v['num'];

			return $amount;
		}

		public function recount(){
			global $sett;
			$sum_total = 0;
			$sum_so_skidkoi = 0;
			$sum_bez_skidki = 0;
			
			foreach($this->cart as $k => $v){
				$skidka = ($v['skidka']) ? $v['skidka'] : $_COOKIE['userdiscount'];
				$sum_bez_skidki += $v['price'] * $v['num'];
				$sum_so_skidkoi += ($v['price'] - $v['price'] * $skidka / 100) * $v['num'];
			}

			$sum_so_skidkoi2 = AS_Skidka::skidka($sum_so_skidkoi);
//			echo $sum_so_skidkoi2;
			
			$this->sum = $sum_bez_skidki;
			$this->to_pay = $sum_so_skidkoi;
			$this->skidka = $this->sum - $this->to_pay;
			
/*			foreach($this->cart as $k => $v){
				$sum_bez_skidki += $v['price'] * $v['num'];
				$sum_so_skidkoi += ($v['price'] - $v['price'] * $v['skidka'] / 100) * $v['num'];
			}

			$this->sum = $sum_so_skidkoi;
//			echo $this->sum;
			$this->skidka = AS_Skidka::skidka($sum_so_skidkoi);
//			echo $this->skidka;
			$this->to_pay = $this->sum - $this->skidka;
//			$sum_so_skidkoi = AS_Skidka::skidka($sum_so_skidkoi);
			
//			$this->sum = $sum_total;
//			$this->to_pay = $sum_so_skidkoi + $sum_bez_skidki;
//			$this->skidka = $this->sum - $this->to_pay;
 * 
 */
		}

		public function get_sum(){
			return $this->sum;
		}

		public function get_skidka(){
			return $this->skidka;
		}

		public function get_to_pay(){
			return $this->to_pay;
		}

		public function prod_num(){
			return count($this->cart);
/*			$num = 0;

			foreach($this->cart as $k => $v)
				$num += $v['num'];

			return $num;*/
		}

		public function pack_num(){
			$num = 0;

			foreach($this->cart as $k => $v)
				$num += $v['num'];

			return $num;
		}

		public function weight(){
			$weight = 0;

			foreach($this->cart as $k => $v)
				$weight += $v['num'] * $v['weight'];

			return $weight;
		}

		public function update_cart($cart_id = 0, $num = 0){
			//$cart_id = $this->cart_id($id, $var);
			if($num == 0){
				unset($this->cart[$cart_id]);
//				if($_COOKIE['userid'])
//					$this->Session->delete(array("where" => "`user` = '".$_COOKIE['userid']."' and prod = '".$id."'"));
			}else{
	//			if($_COOKIE['userid'] && $this->cart[$id]['num'] != $num)
	//				$this->Session->update(array("num" => $this->cart[$id]['num']), array("where" => "`user` = '".$_COOKIE['userid']."' and prod = '".$id."'"));
				$this->cart[$cart_id]['num'] = $num;
			}
			$this->recount();
		}

		public function delete_cartitem($k){
			unset($this->cart[$k]);
			if($_COOKIE['userid'])
				$this->Session->delete(array("where" => "`user` = '".$_COOKIE['userid']."' and prod = '".$k."'"));
		}		

		public function delete_all(){
			$this->cart = array();
			if($_COOKIE['userid'])
				$this->Session->delete(array("where" => "`user` = '".$_COOKIE['userid']."'"));
		}

		public function load($order){		
			$this->cart = array();
			$cart = $this->getall(array("where" => "`order` = $order"));
			foreach($cart as $k => $v){
				$cart_id = $this->cart_id($v->prod, $v->prodvar);
				$this->cart[$cart_id] = array('id' => $v->prod, 'var' => $v->prodvar, 'num' => $v->num, 'price' => $v->price);
			}
		}

		public function save_cart($order_id){
			$Cart = new Model_Cart();
			$Prod = new Model_Prod();
			$q2 = "";

			$Order = new Model_Order($order_id);
			$order = $Order->get();
			$User = new Model_User($order->user);
			$Discount = new Model_Discount();
			$discount = 0 + $Discount->getnakop($Order->total($order->user)) + $User->get()->discount;
			
			if(count($this->cart))
				$q = "insert into `".$this->table."` (`order`, `prod`, `prodvar`, `price`, `num`, `skidka`) values";

			foreach($this->cart as $k => $v){
				if($i++ != 0) $q .= ", ";

				$prod = $Prod->get($v['id']);
				$price = $v['price'];

				if(!$v['skidka']){
					$price -= $price * $discount / 100;
				}

				$item = array(
					'order' => $order_id,
					'prod' => 0+$v['id'],
					'prodvar' => 0+$v['var'],
					'price' => 0+$price,
					'num' => 0+$v['num'],
					'skidka' => 0+$v['skidka'],
//					'name' => $prod->name,
				);
				$q .= "(".$item['order'].", ".$item['prod'].", ".$item['prodvar'].", ".$item['price'].", ".$item['num'].", ".$item['skidka'].")";
				$q2 .= "update ".$this->db_prefix."prod set `num` = '".($prod->num - $v['num'])."' where id = ".$prod->id.";";
			}
			$q .= ";";
			$this->q($q);
			$this->mq($q2);
		}

		public function prods_limited(){
			$Prod = new Model_Prod();			

			foreach($this->cart as $k => $v){
				$prod = $Prod->get($v['id']);
				$prod_num = $prod->num;
				if($v['var'] == 2) $prod_num = $prod->num2;
				if($v['var'] == 3) $prod_num = $prod->num3;
		
				if($prod->id == $v['id'] && $prod_num < $v['num']){
					$this->prods_limited[] = $v['id'];
					$this->cart[$k][num] = $prod_num;
				}
				if($prod->id == $v['id'] && $prod_num == 0){
					unset($this->cart[$k]);
				}
			}

			if(!empty($this->prods_limited)) return true;
			else return false;
		}
	}
