<?
	class Model_Distrib extends Model_Model{
		public $type;

		protected $name = 'distrib';
		protected $depends = array();
		protected $relations = array();
		protected $visibility = 1;
		public $par = 0;

		private $email;

		public function __construct($type = '', $id = 0){
			$this->type = $type;

			parent::__construct($id);
		}

		function send($email, $mess){
			global $templates;
/*
	Принимает объект $mess, в котором предварително задаются поля:
	from		- имя отправителя
	fromaddr	- e-mail отправителя
	subj		- тема
	text		- текст
*/
			$params = array(
				"subj" => $mess->subj,
				"content" => $mess->text,
			);
			if($_POST["styles"])
				$text = Func::mess_from_tmp($templates["distrib_confirm_message_template"], $params);
			else
				$text = $mess->text;

			Func::mailhtml($mess->from, $mess->fromaddr, $email, $mess->subj, $text);

			return true;
		}

		function mass_send($mess, $start = 0, $files = array(), $bd = '', $distrib = ''){
			global $db, $templates;
			$cond = array("where" => "black = 0");
/*
	Принимает объект $mess, в котором предварително задаются поля:
	from		- имя отправителя
	fromaddr	- e-mail отправителя
	subj		- тема
	text		- текст
*/
			$j = 0;
			
			if($bd)
				$cond["where"] .= " and bd = '".data_base::nq($bd)."'";
			if($distrib)
				$cond["where"] .= " and distrib = '".data_base::nq($distrib)."'";

			$Subscribe = new Model_Subscribe();
			$emails = $Subscribe->getall($cond);

			$params = array(
				"subj" => $mess->subj,
				"content" => $mess->text,
				"prods" => $mess->prods,
			);

			if($_POST["styles"])
				$text = Func::mess_from_tmp($templates["distrib_message_template"], $params);
			else
				$text = $mess->text;

//			Func::mailhtml($mess->from, $mess->fromaddr, "alex.suleymanov@gmail.com", $mess->subj, $text, $files);
//			echo $text;
//			echo $this->id; die();

			foreach($emails as $r){
				if($j < $start){
					$j++;
					continue;
				}

				if(++$k >= 800) break;

				if(Func::mailhtml($mess->from, $mess->fromaddr, $r->email, $mess->subj, $text, $files)){
					echo ++$j.") ".$r->email."<br />";
					if($j % 20 == 0) flush();
				}
			}

			$this->savedistrib($mess->subj, $text, $bd, $j);

			return true;
		}

		function savedistrib($subj, $text, $bd, $sentto){
			$params = array(
				"tstamp" => time(),
				"subj" => $subj,
				"cont" => $text,
				"bd" => $bd,
				"sentto" => $sentto,
			);

			$this->save($params);
		}
	}
