<?
	class Model_Catchar extends Model_Model{
		protected $name = 'catchar';
		protected $depends = array();
		protected $relations = array();
		protected $visibility = 0;
		protected $multylang = 0;
		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public function getforfilter($cat){
			$pc = array();

			$q = "select cc.id, cc.char, cc.prior, c.name from ".$this->db_prefix."catchar as cc 
				left join ".$this->db_prefix."char as c on c.id = cc.char 
				order by cc.prior desc";

			$qr = $this->q($q);

			while($r = $qr->f()){
				$pc[] = $r;

			}
			return $pc;
		}
	}
