<?
	class AS_History{
		protected $history;
		public $history_length;
		
		public function __construct($type = 'page', $length = 10){
			Zend_Session::start();

			if(!isset($_SESSION['history'])) $_SESSION['history'] = array();
			if(!isset($_SESSION['history'][$type])) $_SESSION['history'][$type] = array();
			
			$this->history = &$_SESSION['history'][$type];
			$this->history_length = $length;
		}

		protected function url_exists($url, $name){
			foreach($this->history as $k => $v){
				if($v->url == $url || $v->name == $name) return true;
			}
			return false;
		}

		public function add($url, $name){
			if($this->url_exists($url, $name)) return;
			if(count($this->history) >= $this->history_length) array_shift($this->history);
			array_push($this->history, new AS_Link($url, $name));
		}

		public function last(){
			$last = array_pop($this->history);
			array_push($this->history, $last);

			return $last; 
		}

		public function getall(){
			return $this->history;
		}
	}