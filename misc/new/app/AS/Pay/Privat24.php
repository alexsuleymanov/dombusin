<?
	class AS_Pay_Privat24 extends AS_Pay_Esystem{
		private $secretkey = '';

		public function pay($params){

		}

		private function parse_query($query){
			$items=explode("&", $query);

			$ar=array();

			foreach($items as $it){
				$key=""; $value="";
				list($key, $value)=explode("=", $it, 2);
				$ar[$key]=$value;
			}

			return $ar;
		}

		public function is_success(){
			global $path;
			$created = time();

/*			$ff = fopen($path."/tmp/log.txt", "w");
			foreach($_POST as $k => $v){
				fwrite($ff, "_POST[".$k."] = ".$v."\n\n");
			}
			fwrite($ff, $xml);
			fclose($ff);
*/

			$hash = sha1(md5($_POST['payment'].$this->secretkey, ''));

			$pb_payment= $this->parse_query($_POST['payment']);

			if($hash == $_POST['signature'] && $pb_payment['state'] == "ok") return true;
			else return false;
		}
	}