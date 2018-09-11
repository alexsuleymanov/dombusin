<?
	class Model_Delivery extends Model_Model{
		protected $name = 'delivery';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}

		public function getall($opt = array()){
			if(isset($opt['where']))
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."'";

			return parent::getall($opt);
		}

		public function getnum($opt = array()){
			if(isset($opt['where']))
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."'";

			return parent::getnum($opt);
		}
	}
