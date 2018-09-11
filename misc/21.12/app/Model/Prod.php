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

	public $par = 0;

	public function __construct($id = 0, $cat = 0){
		parent::__construct($id);
	}

	public static function getname($id){
		$Prod = new Model_Prod($id);
		return $Prod->get()->name;
	}

	public static function chars_filled($prod, $chars, $prod){
		foreach($chars as $k => $char){

		}
		return true;
	}

	/*
            public static function filter($cat = 0){
                $Char = new Model_Char();
                $chars = $Char->getall(array("where" => "`search` = 1 and ".Model_Cat::cat_tree($cat)));
    //			$chars = $Char->getall(array("where" => "`search` = 1 and cat = ".$cat));

                $ids = array();
                $ids2 = array();
                $ch = array();
                $chars_filled = 0;

                $Prod = new Model_Prod();

                $cond = array("select" => "id", "where" => Model_Cat::cat_tree($cat));
    //			$cond = array("select" => "id", "where" => "visible = 1");
                $cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'");

                $prods = $Prod->getall($cond);

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
                $condpc["where"] .= ")";


    //			print_r($condpc); die();
                $Prodchar = new Model_Prodchar();
                $prodchars = $Prodchar->getall($condpc);

                $chars_filled = 0;
                foreach($chars as $k => $char){
                    foreach($prodchars as $kk => $pc){
                        if($char->type == 4 && is_array($_GET["char".$char->id]) && $char->id == $pc->char && !in_array($pc->charval, $_GET["char".$char->id])){		//Значения характеристик
                            $ids = array_diff($ids, array($pc->prod));
                        }

                        if($char->type == 4 && $char->id == $pc->char){
                            $ids2[$pc->prod] += 1;
                        }

                    }
                    if($char->type == 4) $chars_filled++;
                }

                $filter_q = "(";

                if(empty($ids)){
                    $filter_q .= " id = '0'";
                }else{
                    foreach($ids as $v){
                        if($i2++) $filter_q .= " or id = $v";
                        else $filter_q .= " id = $v";
                    }
                }

                $filter_q .= ")";
    //			echo $filter_q; die();
                return $filter_q;
            }
    */
	public static function filter($cat = 0){
		$Prod = new Model_Prod();
		$ids = array();

		$cond = array("select" => "id", "where" => "visible = 1");
		$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'");
		if($_GET['novinki']){
			$cond["where"] .= " and changed > ".(time() - 45*86400);
		}

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

	public static function quickcount($cat = 0, $type = false){
		$Prod = new Model_Prod();
		$ids = array();

		$cond = array("select" => "id", "where" => "visible = 1 and (num > 0 || num2 > 0 || num3 > 0)");
		$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'");
		switch($type){
			case 'new':
				$cond["where"] .= " and uploaded > ".(time() - 45*86400);
				break;
			case 'pop':
				$cond["where"] .= " and pop = 1";
				break;
			case 'action':
				$cond["where"] .= " and action > 0";
				break;
		}

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

	/*		public static function filter($cat = 0){
                $brands = array();

                $minprice = (floatval($_GET[minprice])) ? floatval($_GET[minprice]) : 0;
                $maxprice = (floatval($_GET[maxprice])) ? floatval($_GET[maxprice]) : 1000000000;

                foreach($_GET as $k => $v){	// Производители
                    if(preg_match("/^brand(\d+)/", $k, $m))
                        $brands[] = $m[1];
                }

                $Char = new Model_Char();
                $chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat)));

                $ids = array();
                $ids2 = array();
                $ch = array();
                $chars_filled = 0;

                $Prod = new Model_Prod();

                $cond = array("select" => "id", "where" => Model_Cat::cat_tree($cat));
                if($minprice < $maxprice){
                    $cond["where"] .= " and price >= $minprice and price <= $maxprice";
                }

                if(count($brands)){
                    $cond["where"] .= " and (brand = ".implode(" or brand = ", $brands).")";
                }
                $prods = $Prod->getall($cond);

                foreach($prods as $prod){
                    $ch[] = $prod;
                    $ids = array_unique(array_merge($ids, array($prod->id)));
                }

                $Prodchar = new Model_Prodchar();
                $prodchars = $Prodchar->getall();

                $chars_filled = 0;
                foreach($chars as $k => $char){
                    foreach($prodchars as $kk => $pc){
                        if($char->type == 1 && $_GET["char".$char->id] && $char->id == $pc->char && $pc->value != $_GET["char".$char->id]){									//Характеристики есть/нет
                            $ids = array_diff($ids, array($pc->prod));
                        }elseif($char->type == 2 && ($_GET["char".$char->id."from"] || $_GET["char".$char->id."to"]) && $char->id == $pc->char){							//Характеристика от/до
                            if($_GET["char".$char->id."from"] && $pc->value < $_GET["char".$char->id."from"]){
                                $ids = array_diff($ids, array($pc->prod));
                            }
                            if($_GET["char".$char->id."to"] && $pc->value > $_GET["char".$char->id."to"]){
                                $ids = array_diff($ids, array($pc->prod));
                            }
                        }elseif($char->type == 4 && is_array($_GET["char".$char->id]) && $char->id == $pc->char && !in_array($pc->charval, $_GET["char".$char->id])){		//Значения характеристик
                            $ids = array_diff($ids, array($pc->prod));
                        }

                        if($char->type == 4 && $char->id == $pc->char){
                            $ids2[$pc->prod] += 1;
                        }
                    }
                    if($char->type == 4) $chars_filled++;
                }

                foreach($ids2 as $k => $v){
                    if($v < $chars_filled) $ids = array_diff($ids, array($k));
                }

                $filter_q = "(";

                if(empty($ids)){
                    $filter_q .= " id = '0'";
                }else{
                    foreach($ids as $v){
                        if($i2++) $filter_q .= " or id = $v";
                        else $filter_q .= " id = $v";
                    }
                }


                $filter_q .= ")";
                return $filter_q;
            }
    */
	public static function filter2($cat = 0, $brands_array, $chars_array){
		$Prod = new Model_Prod();
		$ids = array();

		$cond = array("select" => "id", "where" => "visible = 1");
		$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'");
		if($_GET['novinki']){
			$cond["where"] .= " and changed > ".(time() - 45*86400);
		}

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
		$Cat = new Model_Cat($this->cat);
		return $Cat->get();
	}

	public function getprodchars(){
		$prod_chars = array();

		$qr = $this->q("
					select c.id as cid, c.name as name, c.izm, cv.value as value, pc.charval as val, pc.value as text 
					from ".$this->db_prefix."prodchar as pc 
					left join ".$this->db_prefix."char as c on c.id = pc.`char` 
					left join ".$this->db_prefix."charval as cv on cv.id = pc.charval 
					where pc.prod = '".$this->id."' order by c.prior desc");

		while($r = $qr->f()){
			$prod_chars[$r->cid] = $r;
		}
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
			$q = "select p.id, p.name, p.price, p.skidka, p.inpack from ".$this->db_prefix."cart as c
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
		$pc1 = $this->getprodchars();

		foreach($pc1 as $k => $v) $pc[] = $v;

		$qr = $this->q("
					select p.id as pid, p.intname as intname, p.name as name, p.price, p.skidka, p.inpack 
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

	public function getallforexport(){
		global $sett;
		$prods = array();

		$qr = $this->q("
					select p.id as id, c.id as cat, c.name as name, b.name as brandname, p.name as name, p.price as price, p.price2 price2, p.inpack as inpack, p.skidka as skidka, p.art as art, p.brand as brand, p.short as short, p.cont as cont 
					from ".$this->db_prefix."prod as p 
					left join ".$this->db_prefix."cat as c on c.id = p.cat 
					left join ".$this->db_prefix."brand as b on b.id = p.brand 
					where p.visible = 1 and p.price != 0 and p.num > 0 and p.name != '' order by p.name");

		while($r = $qr->f()){
//				if(!isset($_COOKIE['admin_id']) && $r->price == 0 && $r->price_usd != 0) $r->price = $r->price_usd * $sett['course_usd'];
//				if(!isset($_COOKIE['admin_id']) && $r->price == 0 && $r->price_eur != 0) $r->price = $r->price_eur * $sett['course_eur'];

			$prods[] = $r;
		}

		return $prods;
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

}
