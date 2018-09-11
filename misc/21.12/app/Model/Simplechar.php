<?
	class Model_Simplechar extends Model_Model{
		public $type;
		protected $name = 'simplechar';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;

		public $par = 0;

		public function __construct($type = '', $id = 0){
			$this->type = $type;

			parent::__construct($id);
		}

		public function getall($opt = array()){
			if(isset($opt['where']) && $this->type)
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."'";
			if($this->type) $opt["where"] .= " and `type` = '$this->type'";

			return parent::getall($opt);
		}

		public function getnum($opt = array()){
			if(isset($opt['where']) && $this->type)
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."'";
			if($this->type) $opt["where"] .= " and `type` = '$this->type'";

			return parent::getnum($opt);
		}

	}
