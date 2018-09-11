<?
	class Model_Prodchar extends Model_Model{
		protected $name = 'prodchar';
		protected $depends = array();
		protected $relations = array();
		protected $visibility = 0;
		protected $multylang = 1;
		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public function getforfilter($cat){
			$pc = array();

			$Prod = new Model_Prod();
			$prods = $Prod->getall(array("select" => "id", "where" => "visible = 1", "relation" => array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'")));

			$condpc = array("where" => "(");
			foreach($prods as $kc => $p){
				if($kc) $condpc["where"] .= " or ";
				$condpc["where"] .= "pc.prod = ".$p->id;
			}   	

			$condpc["where"] .= ")";

			$q = "select pc.id, pc.prod, pc.char, pc.charval, cv.value from ".$this->db_prefix."prodchar as pc 
				right join ".$this->db_prefix."charval as cv on cv.id = pc.charval 
				where cv.value != '' and ".$condpc["where"];

			$qr = $this->q($q);

			while($r = $qr->f()){
				$pc[] = $r;

			}
//			print_r($pc);
//			die();
			return $pc;
		}
	}
