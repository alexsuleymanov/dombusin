<?
	class Model_Comment extends Model_Model{
		protected $name = 'comment';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;

		public $par = 1;

		public function __construct($id = 0){
			parent::__construct($id);
		}

	}
