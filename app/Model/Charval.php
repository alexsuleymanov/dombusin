<?
	class Model_Charval extends Model_Model{
		protected $name = 'charval';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}
	}
