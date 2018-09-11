<?
	class Model_Admin extends Model_Model{
		protected $name = 'admins';
		protected $depends = array();
		protected $relations = array();
		protected $visibility = 0;
		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}
	}
