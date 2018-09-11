<?
	class Model_Translate extends Model_Model{
		protected $no_cache = true;

		protected $name = 'translate';
		protected $depends = array();
		protected $relations = array();
		protected $visibility = 0;
		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public function translate($obj_id = 0, $table = '', $lang = ''){
			return $this->getall(array("where" => "obj_id = '$obj_id' and `table` = '$table' and lang = '$lang'"));
		}
	}
