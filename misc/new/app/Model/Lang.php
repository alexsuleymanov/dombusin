<?
	class Model_Lang extends Model_Model{
		protected $name = 'lang';
		protected $depends = array("translate");
		protected $relations = array();
		protected $visibility = 1;
		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}
	}
