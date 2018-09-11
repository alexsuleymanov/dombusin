<?
	class Model_Wishlist extends Model_Model{
		protected $name = 'wishlist';
		protected $depends = array();
		protected $relations = array();
		protected $multylang = 1;
		protected $visibility = 0;

		public $par = 0;

		public function __construct($id = 0){
			parent::__construct($id);
		}
		
/*		public function clear(){
			$qr = $this->q("select w.id as wid, w.prod, p.id from dombusin_wishlist as w "
				. "left join dombusin_prod as p on p.id = w.prod where p.id is NULL");
			while($r = $qr->f()){
				print_r($r);
				echo "<br>";
				$this->q("delete from dombusin_wishlist where id = ".$r->wid);
			}
		}*/
	}
