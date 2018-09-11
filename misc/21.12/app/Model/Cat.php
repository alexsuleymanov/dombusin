<?
	class Model_Cat extends Model_Model{
		protected $name = 'cat';
		protected $depends = array('cat');
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 1;
		
		public $par = 0;
		protected static $tree = array();

		public function __construct($id = 0){
			parent::__construct("cat", $id);
		}

		public static function clear_tree(){
			self::$tree = array();
		}

		public static function cat_tree($id){
			global $db, $db_prefix;

			$qr_ct = $db->q("select id, cat from ".$db_prefix."cat where id = '$id'");
			$i = 0;

			$ct_str .= " (";
			while($r_ct = $qr_ct->f()){
    	    	$ct_str .= " cat = '".$r_ct->id."'";
				$ct_str .= " or";
				$qr_ct = $db->q("select id, cat from ".$db_prefix."cat where id = '".$r_ct->cat."'");
			}
			$ct_str .= " cat = '0')";

			return $ct_str;
		}

		public static function cat_tree_down($id){
			global $db, $db_prefix;
			$tree = Model_Cat::get_cat_tree($id);
			$i = 0;

			$ct_str .= " (";
			foreach($tree as $k => $v){
				if($i++) $ct_str .= " or ";
				if(is_array($v))
					$ct_str .= "cat = '".$k."' or ".Model_Cat::cat_tree_down($k);
				else
		    	    $ct_str .= "cat = '".$k."'";
			}
			$ct_str .= ")";

			return $ct_str;
		}

		public static function get_cat_tree($start){
			global $db, $db_prefix;
			$tree = array();

			$qr = $db->q("select id from ".$db_prefix."cat where cat = '$start' order by prior desc");
			while($r = $qr->f()){
				$tree[$r->id] = Model_Cat::get_cat_tree($r->id);
			}

			return (empty($tree)) ? $start : $tree;
		}

		public static function get_cat_tree_up($start){
			global $db, $db_prefix;

			$qr = $db->q("select * from ".$db_prefix."cat where id = '$start' order by prior desc");
			while($r = $qr->f()){
				self::$tree[$r->id] = $r;
				self::get_cat_tree_up($r->cat);

			}
			return (empty(self::$tree)) ? array() : self::$tree;
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

		public function getbyname($intname = ''){
			$cond = array(
				"where" => "intname = '".data_base::nq($intname)."'",
				"limit" => 1,
			);
			$r = $this->getall($cond);
			return (count($r)) ? $r[0] : false;
		}

		public function getbybrand($brand){
			$qr = $this->db->q("select cat from ".$this->db_prefix."prod where brand = ".$brand." group by cat");

			while($r = $qr->f()){
				$cats[] = $r->cat;
			}

			return $cats;
		}

		public function clearcatchars(){
			$Catchar = new Model_Catchar();
			$Catchar->delete(array("where" => "cat = $this->id"));
		}

	}
