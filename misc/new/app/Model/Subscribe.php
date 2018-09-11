<?
	class Model_Subscribe extends Model_Model{
		public $type;

		protected $name = 'subscribe';
		protected $depends = array();
		protected $relations = array();
		protected $visibility = 1;
		public $par = 0;

		private $email;

		public function __construct($type = '', $id = 0){
			$this->type = $type;

			parent::__construct($id);
		}

		function in_base($email, $bd = '', $distrib = ''){
			$cond = array("where" => "email = '".data_base::nq($email)."'");

			if($bd)
				$cond["where"] .= " and bd = '".data_base::nq($bd)."'";
			if($distrib)
				$cond["where"] .= " and distrib = '".data_base::nq($distrib)."'";

			return ($this->getnum($cond) != 0) ? true : false;
		}

		function subscribe($email, $bd = '', $distrib = ''){
			global $db;
/*
определяем, нет ли подписчика в базе. Если нет, то добавляем. 
$bd для мультиязычных сайтов. 
$distrib для сайтов, где можно подписаться на несколько рассылок(прайс, новости и т.д.)
*/
			if(!preg_match("/[0-9A-Za-z]+@[0-9A-Za-z]+\.[0-9A-Za-z]+/", $email)) throw new SubscribeException("E-mail wrong|неверный e-mail");

			if(!$this->in_base($email, $bd, $distrib)){
				$data = array(
					"email" => $email,
					"bd" => $bd,
					"distrib" => $distrib,
				);
				$this->insert($data);
			}else throw new Model_Subscribe_Exception("E-mail already exists in the base| E-mail уже существует в базе");

			return true;
		}

		function unsubscribe($email, $bd = '', $distrib = ''){
			$cond = array("where" => "email = '".data_base::nq($email)."'");

			if($bd)
				$cond["where"] .= " and bd = '".data_base::nq($bd)."'";
			if($distrib)
				$cond["where"] .= " and distrib = '".data_base::nq($distrib)."'";

			$this->delete($cond);
			return true;
		}

		function export($bd = ''){
			global $db;
			$arr = array();

			$cond = array("where" => "1 = 1");
			if($bd)
				$cond["where"] .= " and bd = '".data_base::nq($bd)."'";
			if($distrib)
				$cond["where"] .= " and distrib = '".data_base::nq($distrib)."'";

			$emails = $this->getall($cond);

			foreach($emails as $r){
				$arr[] = $r->email;
			}

			return $arr;
		}

		function import($fn, $bd = ''){
			$i = 0;
			$em = file($fn);

			foreach($em as $k => $v){
				$data = array(
					"email" => trim($v),
				);
				if($bd)
					$data["bd"] = $bd;
				if($distrib)
					$data["distrib"] = $distrib;

				if(!$this->in_base($data['email'], $bd)){
					$this->insert($data);
					echo ++$i.") ".$data['email']."<br />";
				}
			}

			return $i;
		}
	}
