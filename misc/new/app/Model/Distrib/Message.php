<?
	class Model_Distrib_Message{
		public $subj;
		public $text;
		public $from;
		public $fromaddr;

		function __construct($from, $fromaddr, $subj, $text){
			$this->from = $from;
			$this->fromaddr = $fromaddr;
			$this->subj = $subj;
			$this->text = $text;
		}
	}

