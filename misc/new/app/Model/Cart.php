<?php
class Model_Cart extends Model_Model{
	protected $name = 'cart';
	protected $depends = array();
	protected $relations = array();
	protected $prod_vars;
	protected $visibility = 0;
	protected $path;
	
	public $par = 0;
	public $cart = array();
	public $sum = 0;
	public $skidka = 0;
	public $to_pay = 0;
	public $prods_limited = array();
	
	const WITHOUT_DISCOUNT = 1;
		
	public function __construct($id = 0, $order_id = 0)
	{
		$this->cart = array();
			
		if ($order_id) {
			parent::__construct(0);
			$prods = $this->getall(array("where" => "`order` = ".$order_id));
				
			foreach($prods as $prod) {
				$this->cart[$this->cart_id($prod->prod, $prod->prodvar)] = array('id' => $prod->prod, 'var' => $prod->prodvar, 'num' => $prod->num, 'baseprice' => $prod->price, 'price' => 0, 'skidka' => $prod->skidka, 'numdiscount' => $prod->numdiscount, 'userdiscount' => $prod->userdiscount);					
			}
				
			$this->recount();
		} else {
			parent::__construct($id);
			$this->cart = &$_SESSION['cart'];
			if (empty($this->cart)) {
				$this->cart = array();
			}
				
			if (Model_User::userid() && empty($this->cart)) {
				$this->load_session(Model_User::userid());				
			}
			$this->recount();
		}			
	}

	public function cart_id($prod = 0, $var = 0, $chars = array(), $user_id = 0){
		$id = $prod."_".$var;
			
		if (!empty($chars)) {
			ksort($chars);
			$id .= "_".json_encode($chars);				
		}
			
		if ($user_id) {
			$id .= "_".$user_id;
		}
			
		return md5($id);
	}
		
	public function buy($id = 0, $var = 0, $num = 1, $price = 0, $skidka = 0, $numdiscount = '', $weight = 0){
		$cart_id = $this->cart_id($id, $var);
			
		if(isset($this->cart[$cart_id])){
			$this->cart[$cart_id]['num'] += $num;
			if($this->cart[$cart_id]['skidka'] == 0){
				$this->cart[$cart_id]['numdiscount'] = AS_Skidka::num_skidka($num, $numdiscount);
				$this->cart[$cart_id]['userdiscount'] = AS_Discount::getUserDiscount();
			}else{
				$this->cart[$cart_id]['numdiscount'] = 0;
				$this->cart[$cart_id]['userdiscount'] = 0;
			}
		}else{
			$this->cart[$cart_id] = array('id' => intval($id), 'var' => intval($var), 'num' => intval($num), 'baseprice' => floatval($price), 'price' => floatval($price), 'skidka' => floatval($skidka), 'weight' => floatval($weight));
	
			if($this->cart[$cart_id]['skidka'] == 0){
				$this->cart[$cart_id]['numdiscount'] = AS_Skidka::num_skidka($num, $numdiscount);
				$this->cart[$cart_id]['userdiscount'] = AS_Discount::getUserDiscount();
			}else{
				$this->cart[$cart_id]['numdiscount'] = 0;
				$this->cart[$cart_id]['userdiscount'] = 0;
			}
		}
		$this->recount();
		$this->save_session();
	}

	public function update_cart($cart_id = 0, $num = 0, $numdiscount = ''){
		if($num == 0){
			$prod = $this->cart[$cart_id]['id'];
			$prodvar = $this->cart[$cart_id]['var'];
			unset($this->cart[$cart_id]);
		}else{								
			$this->cart[$cart_id]['num'] = intval($num);
			if($this->cart[$cart_id]['skidka'] == 0){
				$this->cart[$cart_id]['numdiscount'] = AS_Skidka::num_skidka($num, $numdiscount);
				$this->cart[$cart_id]['userdiscount'] = AS_Discount::getUserDiscount();
			}else{
				$this->cart[$cart_id]['numdiscount'] = 0;
				$this->cart[$cart_id]['userdiscount'] = 0;					
			}
				
			$this->recount();
			$prod = intval($this->cart[$cart_id]['id']);
			$prodvar = intval($this->cart[$cart_id]['var']);
		}
		$this->save_session();
	}

	public function amount(){
		$amount = 0;
		foreach($this->cart as $k => $v)
			$amount += $v['price'] * $v['num'];				
			
		return $amount;
	}

	public function amount_without_discount(){
		$amount = 0;
			
		foreach($this->cart as $k => $v){
			$amount += $v['baseprice'] * $v['num'];
		}
			
		return $amount;
	}
				
	public function user_login($user_id, $discount = -1){
		if($user_id){
			$this->load_session($user_id);
		}			
			
		if($discount >= 0){
			foreach($this->cart as $k => $v){
				if($this->cart[$k]['skidka'] == 0) $this->cart[$k]['userdiscount'] = $discount;
			}
		}
		$this->recount();
		$this->save_session();
	}
		
	public function setUserDiscount($discount){
		if($discount){
			foreach($this->cart as $k => $v){
				if($this->cart[$k]['skidka'] == 0) $this->cart[$k]['userdiscount'] = $discount;
			}
		}
		$this->recount();
		$this->save_session();
	}
		
	protected function recount(){
		$Prod = new Model_Prod();
		
		foreach($this->cart as $k => $v){
			$prod = $Prod->get($v['id']);
			$skidka = $prod->skidka;
			
			if ($v['var'] == 2) {
				$skidka = $prod->skidka2;
			}

			if ($v['var'] == 3) {
				$skidka = $prod->skidka3;
			}
			
			$this->cart[$k]['skidka'] = $skidka;
			
			$this->cart[$k]['baseprice'] = round($v['baseprice'], 2);
			if($v['skidka']){
				$this->cart[$k]['price'] = round($v['baseprice'] * (100 - $v['skidka']) / 100, 2);
			}else{
				$this->cart[$k]['price'] = round($v['baseprice'] * (100 - $v['userdiscount']) * (100 - $v['numdiscount']) / 100 / 100, 2);
			}				
		}		
	}
		
	public function prod_num(){
		return (empty($this->cart)) ? 0 : count($this->cart);
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

	public function delete_cartitem($k){
		$prod = $this->cart[$k]['id'];
		$prodvar = $this->cart[$k]['var'];
		unset($this->cart[$k]);
		$this->recount();
		$this->save_session();
	}		

	public function delete_all()
	{
		$this->cart = array();
		$this->save_session();
	}

	public function setPath($path)
	{
		$this->path = $path;
	}

	public function load_session($user_id){
		if (file_exists($this->path."/cart/".$user_id)) {
			$cart = unserialize(file_get_contents($this->path."/cart/".$user_id));
		} else {
			$cart = array();
		}
		
		foreach ($cart as $k => $v) {
			$this->cart[$k] = $v;
		}
	}

	public function save_session()
	{
		if (Model_User::isauth()) {
			$ff = fopen($this->path."/cart/". Model_User::userid(), "w");
			fwrite($ff, serialize($this->cart));
			fclose($ff);
		}
	}
		
	public function save_cart($order_id){
		$Cart = new Model_Cart();
		$Prod = new Model_Prod();
		$q2 = "";
		$discount = 0;
			
//			$User = new Model_User($order->user);
			
		if (count($this->cart)) {
			$q = "insert into `".$this->table."` (`order`, `prod`, `prodvar`, `price`, `num`, `skidka`, `userdiscount`, `numdiscount`) values";
		}

		foreach ($this->cart as $k => $v) {
			if($i++ != 0) $q .= ", ";

			$prod = $Prod->get($v['id']);
			$price = $v['price'];

			if(!$v['skidka']){
				$price -= $price * $discount / 100;
			}

			if($v['skidka']){
				$v['userdiscount'] = 0;
				$v['numdiscount'] = 0;
			}
				
			$item = array(
				'order' => $order_id,
				'prod' => 0+$v['id'],
				'prodvar' => 0+$v['var'],
				'price' => 0+$v['baseprice'],
				'num' => 0+$v['num'],
				'skidka' => 0+$v['skidka'],
				'numdiscount' => 0+$v['numdiscount'],
				'userdiscount' => 0+$v['userdiscount'],
			);
				
			$q .= "(".$item['order'].", ".$item['prod'].", ".$item['prodvar'].", ".$item['price'].", ".$item['num'].", ".$item['skidka'].", ".$item['userdiscount'].", ".$item['numdiscount'].")";
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
		
			if($prod->id == $v['id'] && $prod_num > 0 && $prod_num < $v['num']){
				$this->prods_limited[] = $v['id'];
				$this->cart[$k]['num'] = $prod_num;
			}
			if($prod->id == $v['id'] && $prod_num <= 0){
				unset($this->cart[$k]);
			}
		}
		$this->save_session();
		if(!empty($this->prods_limited)) return true;
		else return false;
	}
}
