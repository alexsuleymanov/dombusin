<?
	class Model_Timer extends Model_Model{
		protected $name = 'timer';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 0;
		protected $visibility = 1;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

	}
