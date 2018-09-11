<?
	class Model_Page extends Model_Model{
		public $type;

		protected $name = 'page';
		protected $depends = array("page", "photo", "comment");
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;
		protected static $tree = array();

		public $par = 0;

		public function __construct($type = '', $id = 0){
			$this->type = $type;

			parent::__construct($id);
		}

		public function getall($opt = array()){
			if(isset($opt['where']))
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."'";

			if($this->type) $opt["where"] .= " and `type` = '$this->type'";

			return parent::getall($opt);
		}

		public function getnum($opt = array()){
			if(isset($opt['where']))
				$opt['where'] .= " and shop = '".Zend_Registry::get('shop_id')."'";
			else
				$opt['where'] .= " shop = '".Zend_Registry::get('shop_id')."'";
			if($this->type) $opt["where"] .= " and `type` = '$this->type'";
			return parent::getnum($opt);
		}

		public function getbyname($intname = ''){
			$cond = array(
				"where" => "`type` = '".data_base::nq($this->type)."' and intname = '".data_base::nq($intname)."'",
				"limit" => 1,
			);

			$r = $this->getall($cond);
			return (count($r)) ? $r[0] : false;
		}

		public function getsubpages($par = 0){
			$cond = array(
				"where" => "visible = 1 and page = $par",
				"order" => "prior desc",
			);

			return $this->getall($cond);
		}

		public function getphotos($page = 0){
			$Photo = new Model_Photo();
			$cond = array(
				"where" => "`type` = 'page' and par = $page",
				"order" => "prior desc",
			);
			return $Photo->getall($cond);
		}

		public static function get_page_tree_up($start){
			global $db, $db_prefix;

			$qr = $db->q("select * from ".$db_prefix."page where id = '$start' order by prior desc");
			while($r = $qr->f()){
				self::$tree[$r->id] = $r;
				self::get_page_tree_up($r->page);
			}

			return (empty(self::$tree)) ? array() : self::$tree;
		}

		public static function archive($type){
			$archive = array();

			$Page = new Model_Page($type);
			$oldest = getdate($Page->getone(array("where" => "visible = 1", "order" => "tstamp", "limit" => 1))->tstamp);
			$now = getdate(time());

			for($i = $now["year"]; $i >= $oldest["year"]; $i--){
				$t1 = mktime(0, 0, 0, 1, 1, $i);
				$t2 = mktime(0, 0, 0, 1, 1, $i+1);
				if($Page->getnum(array("where" => "tstamp > $t1 and tstamp < $t2"))){
					$archive[$i] = array();
					for($j = 1; $j <= 12; $j++){
						$t1 = mktime(0, 0, 0, $j, 1, $i);
						$t2 = mktime(0, 0, 0, $j+1, 1, $i);
						if($Page->getnum(array("where" => "tstamp > $t1 and tstamp < $t2"))){
							$archive[$i][] = $j;
						}
					}
				}
			}
			return $archive;
		}

	}
