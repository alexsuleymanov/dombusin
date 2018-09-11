<?
	class Model_Block extends Model_Model{
		protected $name = 'block';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 0;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}
	}
