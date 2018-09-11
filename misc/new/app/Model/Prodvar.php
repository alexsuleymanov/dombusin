<?
	class Model_Prodvar extends Model_Model{
		protected $name = 'prodvar';
		protected $depends = array("cart");
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public static function getname($id){
			$Prodvar = new Model_Prodvar($id);
			return $Prodvar->get()->name;
		}

	}
