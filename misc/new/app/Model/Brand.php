<?
	class Model_Brand extends Model_Model{
		protected $name = 'brand';
		protected $depends = array('prod');
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;
		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public function getbyname($intname = ''){
			$cond = array(
				"where" => "intname = '".data_base::nq($intname)."'",
				"limit" => 1,
			);
			$r = $this->getall($cond);
			return (count($r)) ? $r[0] : false;
		}

		public function getbycat($cat){
			$rows = array();

			$q = "select b.* 
				from ".$this->db_prefix."brand as b 
				left join ".$this->db_prefix."prod as p on p.brand = b.id 
				where b.visible = 1 and p.visible = 1 and p.cat = '".data_base::nq($cat)."' group by b.id order by b.name";

			$qr = $this->db->q($q);
			while($r = $qr->f())
				$rows[] = $r;

			return $rows;
		}
	}
