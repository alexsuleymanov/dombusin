<?
	class Model_Discount extends Model_Model{
		protected $name = 'discount';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 0;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public function getnakop($nakop){
			$dis = $this->getone(array("where" => "nakop <= '".data_base::nq($nakop)."'", "order" => "nakop desc"));
			return $dis->value;
		}

		public function getnakopid($nakop){
			$dis = $this->getone(array("where" => "nakop <= '".data_base::nq($nakop)."'", "order" => "nakop desc"));
			return $dis->id;
		}

		public function tonextdiscount($nakop){
			$dis = $this->getone(array("where" => "nakop > '".data_base::nq($nakop)."'", "order" => "nakop"));
			return ($dis->nakop - $nakop);
		}

		public function nextdiscount($nakop){
			$dis = $this->getone(array("where" => "nakop > '".data_base::nq($nakop)."'", "order" => "nakop"));
			return $dis;
		}
	}
