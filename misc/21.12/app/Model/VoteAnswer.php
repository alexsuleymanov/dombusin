<?
	class Model_Voteanswer extends Model_Model{
		protected $name = 'voteanswer';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public function totalvotes($vote){
			return $this->q("select sum(`count`) as sum from ".$this->db_prefix."voteanswer where vote = $vote")->f()->sum;
		}
	}
