<?
	class Model_Relation extends Model_Model{
		protected $no_cache = true;

		protected $name = 'relation';
		protected $depends = array();
		protected $relations = array();
		protected $visibility = 0;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}
	}
