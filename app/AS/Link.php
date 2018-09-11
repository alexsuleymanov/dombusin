<?
	class AS_Link{
		public $url;
		public $name;
		
		public function __construct($url = '', $name = ''){
			$this->url = $url;
			$this->name = $name;
		}

		public function tostring(){
			return "<a href=\"".$this->url."\">".$this->name."</a>";
		}
	}