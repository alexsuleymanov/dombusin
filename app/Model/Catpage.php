<?
	class Model_Catpage extends Model_Model{
		protected $name = 'catpage';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

	}
