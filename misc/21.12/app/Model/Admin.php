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
