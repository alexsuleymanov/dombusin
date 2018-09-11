<?
	class Model_User extends Model_Model{
		public $type;

		protected $name = 'user';
		protected $depends = array("order");
		protected $relations = array();
		protected $visibility = 1;
		public $par = 0;

		public function __construct($type = '', $id = 0){
			$this->type = $type;

			parent::__construct($id);
		}

		public function getall($opt = array()){
			if(isset($opt['where']))
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."' and `type` = '$this->type'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."' and `type` = '$this->type'";

			return parent::getall($opt);
		}

		public function getnum($opt = array()){
			if(isset($opt['where']))
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."' and `type` = '$this->type'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."' and `type` = '$this->type'";
			return parent::getnum($opt);
		}
	}
