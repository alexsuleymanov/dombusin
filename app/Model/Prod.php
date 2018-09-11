<?
//	version 2.1

class Model_Prod extends Model_Model{
	protected $_cat;
	protected $_brand;

	protected $name = 'prod';
	protected $depends = array("photo", "comment", "prodvar", "prodchar", "cart");
	protected $relations = array();
	protected $multylang = 1;
	protected $visibility = 1;
	protected $opt = 0;

	public $par = 0;

	public static $spec = array("new", "sale", "mix", "pop", "action", "onsale");
	
	public function __construct($id = 0, $cat = 0){
		parent::__construct($id);
		$this->opt = (isset($_SESSION['useropt']) && $_SESSION['useropt'] == 1) ? "opt" : "";
	}

	public static function getname($id){
		$Prod = new Model_Prod($id);
		return $Prod->get()->name;
	}

	public function getall($options = array()) {
		$prods = array();
		$prods = parent::getall($options);
		foreach($prods as $k => $prod){
			if($_SESSION['useropt'] && !defined("ASWEB_ADMIN")){
				$prods[$k]->price = $prod->priceopt;
				$prods[$k]->price2 = $prod->priceopt2;
				$prods[$k]->price3 = $prod->priceopt3;
				$prods[$k]->price4 = $prod->priceopt4;
				$prods[$k]->skidka = $prod->skidkaopt;
				$prods[$k]->skidka2 = $prod->skidkaopt2;
				$prods[$k]->skidka3 = $prod->skidkaopt3;
				$prods[$k]->skidka4 = $prod->skidkaopt4;
				$prods[$k]->numdiscount = $prod->numdiscountopt;
				$prods[$k]->numdiscount2 = $prod->numdiscountopt2;
				$prods[$k]->numdiscount3 = $prod->numdiscountopt3;
				$prods[$k]->numdiscount4 = $prod->numdiscountopt4;
			}
		}
		return $prods;
	}

	public function get($id = 0) {
		$prod = parent::get($id);
		
		if($_SESSION['useropt'] && !defined("ASWEB_ADMIN")){
			$prod->price = $prod->priceopt;
			$prod->price2 = $prod->priceopt2;
			$prod->price3 = $prod->priceopt3;
			$prod->price4 = $prod->priceopt4;
			$prod->skidka = $prod->skidkaopt;
			$prod->skidka2 = $prod->skidkaopt2;
			$prod->skidka3 = $prod->skidkaopt3;
			$prod->skidka4 = $prod->skidkaopt4;
			$prod->numdiscount = $prod->numdiscountopt;
			$prod->numdiscount2 = $prod->numdiscountopt2;
			$prod->numdiscount3 = $prod->numdiscountopt3;
			$prod->numdiscount4 = $prod->numdiscountopt4;			
		}

		return $prod;
	}
	
	public static function chars_filled($prod, $chars){
		foreach($chars as $k => $char){

		}
		return true;
	}

	public static function quickcount($cat = 0, $type = false){
		$Prod = new Model_Prod();
		$ids = array();
	
		$cond = array("select" => "id", "where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0)");
		$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'");
		
		if($type == 'new'){
			$cond["where"] .= " and `new` = 1";//" and uploaded > ".(time() - 90*86400);
		}
		
		if($type == 'pop'){
			$cond["where"] .= " and pop = 1";
		}
		
		if($type == 'mix'){
			$cond["where"] .= " and `mix` = 1";
		}

		if ($_GET['sale']) {
			if ($_GET['sale'] == 'action') {
				$cond["where"] .= " and (skidka > 0 or skidka2 > 0 or skidka3 > 0)";
			} else {
				$cond["where"] .= " and `".$_GET['sale']."` = 1";
			}
		}
		
		if (($type == 'action' || $_GET['sale'] == 'action') && !isset($_SESSION['useropt'])) {
			$cond["where"] .= " and (skidka > 0 or skidka2 > 0 or skidka3 > 0)";
		} elseif ($type == 'action' || $_GET['sale'] == 'action') {
			$cond["where"] .= " and (skidkaopt > 0 or skidkaopt2 > 0 or skidkaopt3 > 0)";	
		}
		
		$prods = $Prod->getall($cond);

//		print_r($cond); 
	//	echo count ($prods); die();
		
		$Prodchar = new Model_Prodchar();

		foreach($prods as $prod){
			$ch[] = $prod;
			$ids = array_unique(array_merge($ids, array($prod->id)));
		}
		unset($prods);

		if (count($ids)) {
			$condpc = array("where" => "(");
			foreach($ids as $kc => $p){
				if($kc) $condpc["where"] .= " or ";
				$condpc["where"] .= "`prod` = ".$p;
			}
			unset($ids);
			$condpc["where"] .= ")";
		} else {
			$condpc["where"] .= "prod = -1";
		}
		
		$chr = array();
		foreach($_GET as $k => $v){
			if(preg_match("/char(\d+)/", $k, $m)){
				$chr[$m[1]] = $v;
			}
		}
//                    print_r($chr);
		$prodchars_all = $Prodchar->getall($condpc);

		if(!empty($chr)){
			$condpc["where"] .= " and (";
			foreach($chr as $k => $v){
				foreach($v as $vv){
					if($j++ > 0) $condpc["where"] .= " or ";
					$condpc["where"] .= "(`char` = ".$k." and charval = ".$vv.")";
				}
			}
			$condpc["where"] .= ")";
		}

//			echo "<p>";
//			print_r($condpc["where"]);

		$prodchars = $Prodchar->getall($condpc);

//			echo count($prodchars);
		$pp = array();
		foreach($prodchars as $k => $v){
			$pp[] = $v->prod;
		}

		$pcount = array_count_values($pp);

		foreach($pcount as $k => $v){
			if($v < count($chr)) unset($pcount[$k]);
		}

//			echo count($pcount);
//			print_r($pcount);
//			die();
		$prods = array();


		/*На выходе нужен массив в виде $prods[char][charval];
         * Для каждой характристики будет написано выбрано n, это будет кол-во по выбранным значениям,
         * а для других значений будет +m. Где m - равно значению $prods[char][charval], если в фильте отсутствует эта характеристика
         * Делаем мульти запрос. Запросов будет столько, сколько характеристик.
         * Для каждой характеристики выбираем количество товаров. если не задана эта характеристика.
         * Проверить скорость работы такой системы при наличии полнотекстового индекса.
         *
         */
		return count($pcount);
	}

	public static function filter2($cat = 0, $brands_array = array(), $chars_array = array(), $sale = ''){
		$Prod = new Model_Prod();
		$ids = array();

		$cond = array("select" => "id", "where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0)");
		$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'");

		if ($_GET['novinki']) {
			$cond["where"] .= " and `new` = 1";//" and uploaded > ".(time() - 45*86400);
		}

//		if($sale && in_array($sale, array('pop', 'mix', 'new', 'action'))) {
//			if ($sale = 'action') {
//				$cond["where"] .= " and (skidka > 0 or skidka2 > 0 or skidka3 > 0)";
//			} else {
//				$cond["where"] .= " and `".$sale."` = 1";				
//			}
//		}
		
		$prods = $Prod->getall($cond);

		$Prodchar = new Model_Prodchar();
//		print_r($prods);
		foreach($prods as $prod){
			$ch[] = $prod;
			$ids = array_unique(array_merge($ids, array($prod->id)));
		}
		unset($prods);

		if(count($ids)){
			$condpc = array("where" => "(");
			foreach($ids as $kc => $p){
				if($kc) $condpc["where"] .= " or ";
				$condpc["where"] .= "`prod` = ".$p;
			}
			unset($ids);
			$condpc["where"] .= ")";
		}else{
			$condpc["where"] .= "id = -1";		
		}

		$chr = array();
/*		foreach($_GET as $k => $v){
			if(preg_match("/char(\d+)/", $k, $m)){
				$chr[$m[1]] = $v;
			}
		}*/
		
		foreach($chars_array as $k => $v){
			$chr[$k] = $v;
		}

//                    print_r($chr);
		$prodchars_all = $Prodchar->getall($condpc);

		if(!empty($chr)){
			$condpc["where"] .= " and (";
			foreach($chr as $k => $v){
				foreach($v as $vv){
					if($j++ > 0) $condpc["where"] .= " or ";
					$condpc["where"] .= "(`char` = ".$k." and charval = ".$vv.")";
				}
			}
			$condpc["where"] .= ")";
		}

//			echo "<p>";
//			print_r($condpc["where"]);

		$prodchars = $Prodchar->getall($condpc);

//			echo count($prodchars);
		$pp = array();
		foreach($prodchars as $k => $v){
			$pp[] = $v->prod;
		}

		$pcount = array_count_values($pp);

		foreach($pcount as $k => $v){
			if($v < count($chr)) unset($pcount[$k]);
		}

//			echo count($pcount);
//			print_r($pcount);
//			die();
		$prods = array();


		foreach($pcount as $kk => $pc){
			$prods[] = $kk;
		}

		$filter_q = "(";

		if(empty($pcount)){
			$filter_q .= " id = '0'";
		}else{
			foreach($pcount as $v => $vv){
				if($i2++) $filter_q .= " or id = $v";
				else $filter_q .= " id = $v";
			}
		}

		$filter_q .= ")";
		return $filter_q;
	}
	

	public function getcat(){
	//	$cats = array();
		$qr = $this->q("
					select c.id as id, c.name as name, c.intname as intname 
					from ".$this->db_prefix."relation as r
					left join ".$this->db_prefix."cat as c on r.obj = c.id
					where r.relation = ".$this->id." limit 1");

		return $qr->f();
	}

	public function getallforexport(){
		global $sett;
		$prods = array();

		$qr = $this->q("
					select p.id as id, p.name as name, p.price as price, p.price2 price2, p.inpack as inpack, p.skidka".$this->opt." as skidka, p.art as art, p.brand as brand, p.short as short, p.cont as cont 
					from ".$this->db_prefix."prod as p
					where p.visible = 1 and p.price != 0 and p.num > 0 and p.name != '' order by p.id");

		while($r = $qr->f()){
			$prods[] = $r;
		}

		return $prods;
	}
	
	public function getprodchars($prod_id){
		$prod_chars = array();
		$prod = $prod_id ? $prod_id : $this->id;
		$qr = $this->q("
					select c.id as cid, c.name as cname, c.izm, cv.value as value, pc.charval as val, pc.value as text 
					from ".$this->db_prefix."prodchar as pc 
					left join ".$this->db_prefix."char as c on c.id = pc.`char` 
					left join ".$this->db_prefix."charval as cv on cv.id = pc.charval 
					where pc.prod = '".$prod."' and cv.value != ''");

		while($r = $qr->f()){
			$prod_chars[$r->cid] = $r;
		}
//		print_r($prod_chars); die();
		return $prod_chars;
	}

	public function getprodchars_all(){
		$prod_chars = array();

		$qr = $this->q("
					select pc.prod as pid, c.id as cid, c.name as cname, c.izm, cv.value as value, pc.charval as val, pc.value as text 
					from ".$this->db_prefix."prodchar as pc 
					left join ".$this->db_prefix."char as c on c.id = pc.`char` 
					left join ".$this->db_prefix."charval as cv on cv.id = pc.charval 
					where cv.value != ''");

		while($r = $qr->f()){
			$prod_chars[$r->pid][$r->cid] = $r;
		}
//		print_r($prod_chars); die();
		return $prod_chars;
	}
	
	public function getprodvars(){
		$Prodvar = new Model_Prodvar();
		$cond = array(
			"where" => "prod = $this->id",
			"order" => "prior desc",
		);
		return $Prodvar->getall($cond);
	}

	public function getcomments(){
		$Comment = new Model_Comment();
		$cond = array(
			"where" => "`type` = 'prod' and par = $this->id and visible = 1",
			"order" => "tstamp desc",
		);
		return $Comment->getall($cond);
	}

	public function getphotos(){
		$Photo = new Model_Photo();
		$cond = array(
			"where" => "`type` = 'prod' and par = $this->id",
			"order" => "prior desc",
		);
		return $Photo->getall($cond);
	}

	public function getprodchilds(){
		$prods = array();
		$Cart = new Model_Cart();
		$cart = $Cart->getone(array("where" => "prod = ".$this->id));

		if($cart->order){
			$q = "select p.id, p.name, p.price, p.skidka".$this->opt." as skidka, p.skidka".$this->opt."2 as skidka2, p.skidka".$this->opt."3 as skidka3, p.inpack from ".$this->db_prefix."cart as c
					left join ".$this->db_prefix."prod as p on p.id = c.prod 
					where c.order = ".$cart->order." and p.visible = 1 and p.id != ".$this->id." limit 4";

			$qr = $this->q($q);

			while($r = $qr->f()){
				$prods[$r->id] = $r;
			}
		}

		return $prods;
	}

	public function getprodanalogs(){
		$pc = array();
		$prods = array();
		$pc1 = $this->getprodchars($this->id);

		foreach($pc1 as $k => $v) $pc[] = $v;

		$qr = $this->q("
					select p.id as pid, p.intname as intname, p.name as name, p.price, p.skidka".$this->opt." as skidka, p.skidka".$this->opt."2 as skidka2, p.skidka".$this->opt."3 as skidka3, p.inpack 
					from ".$this->db_prefix."prodchar as pc 
					left join ".$this->db_prefix."prod as p on p.id = pc.`prod` 
					where (pc.`char` = '".$pc[0]->cid."' and pc.charval = '".$pc[0]->val."') and (pc.`char` = '".$pc[1]->cid."' and pc.charval = '".$pc[1]->val."') order by p.prior desc limit 4");

		while($r = $qr->f()){
			$prods[] = $r;
		}

		return $prods;
	}

	public function getbyname($intname = ''){
		$cond = array(
			"where" => "visible = 1 and intname = '".data_base::nq($intname)."'",
			"limit" => 1,
		);
		$r = $this->getall($cond);
		return (count($r)) ? $r[0] : false;
	}

	public function clearprodvars(){
		$Prodvar = new Model_Prodvar();
		$Prodvar->delete(array("where" => "prod = $this->id"));
	}

	public function clearprodchars(){
		$Prodchar = new Model_Prodchar();
		$Prodchar->delete(array("where" => "prod = $this->id"));
	}

	public function setpop(){
		global $sett;

		$access_date = $sett['update_pop_prods'];

		$date_elements  = explode(".", $access_date);

		$last_tstamp = mktime(0,0,0,$date_elements[1],$date_elements[0],$date_elements[2]);

		if($last_tstamp < time() - 60*60*24*30){
			$qr = $this->q("select p.id as pid
					from ".$this->db_prefix."cart as c
					left join ".$this->db_prefix."prod as p on p.id = c.prod
					where p.visible = 1 group by p.id order by rand() limit 10");

			while($r = $qr->f()){
				$this->update(array("pop" => 1), array("where" => "id = ".$r->pid));
			}
			$Sett = new Model_Sett();
			$Sett->update(array("value" => date("d.m.Y", time())), array("where" => "intname = 'update_pop_prods'"));
		}
	}
	
	public function getneraspids()
	{
		$ids = array();
		
		$qr = $this->q("SELECT p.id as id FROM `dombusin_relation` as r right join dombusin_prod as p on p.id = r.relation WHERE r.relation is NULL");
		while ($r = $qr->f()) {
			$ids[] = $r->id;
		}
		
		return $ids;
	}

	/*
	public static function filter($cat = 0){
		$Prod = new Model_Prod();
		$ids = array();

		$cond = array("select" => "id", "where" => "visible = 1");
		$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'");
//		if($_GET['novinki']){
	//		$cond["where"] .= " and `new` = 1";//and uploaded > ".(time() - 45*86400);
//		}
		
		$prods = $Prod->getall($cond);
		$Prodchar = new Model_Prodchar();

		foreach($prods as $prod){
			$ch[] = $prod;
			$ids = array_unique(array_merge($ids, array($prod->id)));
		}
		unset($prods);

		$condpc = array("where" => "(");
		foreach($ids as $kc => $p){
			if($kc) $condpc["where"] .= " or ";
			$condpc["where"] .= "`prod` = ".$p;
		}
		unset($ids);
		$condpc["where"] .= ")";

		$chr = array();
		foreach($_GET as $k => $v){
			if(preg_match("/char(\d+)/", $k, $m)){
				$chr[$m[1]] = $v;
			}
		}
		foreach($_GET as $k => $v){
			if(preg_match("/char(\d+)/", $k, $m)){
				$chr[$m[1]] = $v;
			}
		}
					
		$prodchars_all = $Prodchar->getall($condpc);

		if(!empty($chr)){
			$condpc["where"] .= " and (";
			foreach($chr as $k => $v){
				foreach($v as $vv){
					if($j++ > 0) $condpc["where"] .= " or ";
					$condpc["where"] .= "(`char` = ".$k." and charval = ".$vv.")";
				}
			}
			$condpc["where"] .= ")";
		}

//			echo "<p>";
//			print_r($condpc["where"]);

		$prodchars = $Prodchar->getall($condpc);

//			echo count($prodchars);
		$pp = array();
		foreach($prodchars as $k => $v){
			$pp[] = $v->prod;
		}

		$pcount = array_count_values($pp);

		foreach($pcount as $k => $v){
			if($v < count($chr)) unset($pcount[$k]);
		}

//			echo count($pcount);
//			print_r($pcount);
//			die();
		$prods = array();



		foreach($pcount as $kk => $pc){
			$prods[] = $kk;
		}

		$filter_q = "(";

		if(empty($pcount)){
			$filter_q .= " id = '0'";
		}else{
			foreach($pcount as $v => $vv){
				if($i2++) $filter_q .= " or id = $v";
				else $filter_q .= " id = $v";
			}
		}

		$filter_q .= ")";
		return $filter_q;
	}
*/
}
