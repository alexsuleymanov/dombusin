<?
	class Model_Photo extends Model_Model{
		protected $name = 'photo';
		protected $depends = array("comment");
		protected $relations = array();
		protected $visibility = 1;
		public $par = 1;
		public $ftype = 'jpg';

		public function __construct($id = 0){
			parent::__construct($id);
		}

	}
