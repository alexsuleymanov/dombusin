<?
	class Model_Shop extends Model_Model{
		protected $name = 'shop';
		protected $depends = array("admin", "banner", "adv", "advcat", "brand", "cart", "cat", "char", "charcat", "charval", "comment", "discount", "esystem", "labels", "lang", "order", "page", "photo", "photocat", "prod", "prodvar", "relation", "sett", "shopopt", "simplechar", "tag", "user", "vote");
		protected $relations = array();
		protected $visibility = 0;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public function delete($id){
		
			parent::delete($id);
		}

		public function save($id = 0){

			parent::save($id);
		}
	}
