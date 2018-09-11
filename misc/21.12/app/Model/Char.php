<?
	class Model_Char extends Model_Model{
		protected $name = 'char';
		protected $depends = array("charval", "prodchar");
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

		public function delete_empty_vals(){
			$rc = $this->q("select cv.id from ".$this->db_prefix."charval as cv left join `".$this->db_prefix."char` as c on cv.`char` = c.id where c.id = 'null'");
			while($rr = $rc->f()){
				$this->q("delete from ".$this->db_prefix."charval where id = '".$rr->id."'");
			}
		}

		public function getforfilter($cat){
			$chars = array();
			$qr = $this->q("
					select c.id as id, c.name as name, c.type, cc.prior
					from ".$this->db_prefix."catchar as cc 
					right join ".$this->db_prefix."char as c on c.id = cc.char 
					where cc.cat = '".$cat."' and c.search > 0 order by cc.prior desc");

			while($r = $qr->f()){
				$chars[] = $r;
			}
			return $chars;
		}
	}
