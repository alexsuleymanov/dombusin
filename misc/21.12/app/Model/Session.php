<?
	class Model_Session extends Model_Model{
		protected $name = 'session';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 0;
		protected $visibility = 0;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}
	}
