<?
	class Func{
		static $mysqlq = 0;
		static $seeded;

    	static function fmtmoney($money) {
			return sprintf("%0.2f", $money);// / $_SESSION['valuta']['course']);
		}

		static function fmtname($name, $length = 50){			
			return (mb_strlen($name, "utf-8") <= $length) ? $name : mb_substr($name, 0, 70) . "...";
//			return (mb_strlen($name, "utf-8") <= $length) ? $name : mb_substr($name, 0, mb_strpos($name, ",", $length)) . "...";
		}

		static function fmtname2($name, $length = 50){			
			return (mb_strlen($name, "utf-8") <= $length) ? $name : mb_substr($name, 0, 50) . "...";
//			return (mb_strlen($name, "utf-8") <= $length) ? $name : mb_substr($name, 0, mb_strpos($name, ",", $length)) . "...";
		}

		static function getExtension($filename) {
			return array_pop(explode(".", $filename));
		}

		static function mailhtml($from, $fromadr, $to, $subj, $text, $files = array(), $smtp = array()) {
/*
			$smtp = array(
				'host' => "mail.asweb.com.ua",
				'auth' => 'login',
				'username' => 'mail@asweb.com.ua',
				'password' => 'mail261984',
				'port' => 25,
			);
*/
			if(count($smtp)){
				$transport = new Zend_Mail_Transport_Smtp($smtp["host"], $smtp);
				Zend_Mail::setDefaultTransport($transport);
			}

			$mail = new Zend_Mail('utf-8');

			$mail->setBodyText(strip_tags($text));
			$mail->setBodyHtml($text);
			$mail->setFrom($fromadr, $from);
			$mail->addTo($to);
			$mail->setSubject($subj);

			foreach($files as $k => $v){
	            $attach = new Zend_Mime_Part(file_get_contents($v["tmp_name"]));
				$attach->type = mime_content_type($v["tmp_name"]);
				$attach->disposition = Zend_Mime::DISPOSITION_INLINE;
				$attach->encoding = Zend_Mime::ENCODING_BASE64;
				$attach->filename = $v["name"];
				$mail->addAttachment($attach);
			}

			try{
				if($transport)
					return $mail->send($transport);
				else
					return $mail->send();
			}catch(Exception $exception){
				return false;
			}
		}

		static function mess_from_tmp($tmp, $params){
			extract($GLOBALS);

			$rep = array();
			preg_match_all("/{([\$\[\]\'\w\_\-\d]+)}/", $tmp, $m);

			foreach($m[1] as $k => $v){
				if($v[0] == '$'){
					if(strstr($v, "[")){
						$vv = substr($v, 1, strpos($v, "[")-1);
						preg_match("/\[[\'\"]([^\'\"]+)[\'\"]\]/", $v, $m);
						$rep["{".$v."}"] = ${$vv}[$m[1]];
					}else{
						$rep["{".$v."}"] = ${'v'};
					}
				}
				else
					$rep["{".$v."}"] = $params[$v];
			}

			return str_replace(array_keys($rep), array_values($rep), $tmp);
		}

		static function translit($str){
    		$letters = array(
				"а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e",
				"ё" => "e", "ж" => "zh", "з" => "z", "и" => "i", "й" => "j", "к" => "k",
    	        "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
        	    "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "c",
            	"ч" => "ch", "ш" => "sh", "щ" => "sh", "ы" => "i", "ь" => "", "ъ" => "",
	            "э" => "e", "ю" => "yu", "я" => "ya",
				"А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D", "Е" => "E",
				"Ё" => "E", "Ж" => "ZH", "З" => "Z", "И" => "I", "Й" => "J", "К" => "K",
            	"Л" => "L", "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
	            "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "C",
    	        "Ч" => "CH", "Ш" => "SH", "Щ" => "SH", "Ы" => "I", "Ь" => "", "Ъ" => "",
        	    "Э" => "E", "Ю" => "YU", "Я" => "YA",
			);
		
			foreach($letters as $letterVal => $letterKey) {
				$str = str_replace($letterVal, $letterKey, $str);
			}
		
			return $str;
		}

		static function mkintname($str){
			return trim(preg_replace("/[\W]+/", "-", strtolower(trim(Func::translit($str)))), '-');
		}

		static function is_ajax(){
	        if ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
    	        return true;
        	}

        	if (function_exists('apache_request_headers')) {
            	$headers = apache_request_headers();
	            if ($headers["X-Requested-With"] == "XMLHttpRequest" || $headers["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
    	            return true;
        	    }
	        }
			return false;
		}

		static function ajaxdecode($str){
			return iconv("UTF-8", "WINDOWS-1251", $str);
		}

		static function controller_list(){
			global $path;
			$controllers = array();
			$controllers[''] = "Статическая страница";

			$dd = opendir($path."/app/controller");
			while($ff = readdir($dd)){
				if($ff == "." || $ff == "..") continue;
				$ff_arr = file($path."/app/controller/".$ff);
				if(preg_match("/.*?Controller - (.*)/u", $ff_arr[0], $m)){
					$controllers[$ff] = $ff." - ".$m[1];
				}
			}

			return $controllers;
		}

		static function osc_rand($min = null, $max = null) {
			if (!isset($seeded)) {
				if (version_compare(PHP_VERSION, '4.2', '<')) {
					mt_srand((double)microtime()*1000000);
				}

				$seeded = true;
			}

			if (is_numeric($min) && is_numeric($max)) {
				if ($min >= $max) {
					return $min;
				} else {
					return mt_rand($min, $max);
				}
			} else {
				return mt_rand();
			}
		}

		static function encrypt_pass($plain) {
			$password = '';

			for ($i = 0; $i < 10; $i++) {
				$password .= Func::osc_rand();
			}

			$salt = substr(md5($password), 0, 2);

			$password = md5($salt . $plain) . ':' . $salt;

			return $password;
		}

		static function global_images($text){
			if(preg_match("/\/pic\/image\//", $text))
				return preg_replace("/\/pic\/image\//", "https://".$_SERVER['HTTP_HOST']."/pic/image/", $text);
			else
				return preg_replace("/\/pic\//", "https://".$_SERVER['HTTP_HOST']."/pic/", $text);
		}
		
		static function mkphone($phone)
		{
			$phone = str_replace(array('(', ')', '-', ' '), array('', '', '',''), $phone);
			
			if (!preg_match("/^38/", $phone)) {
				$phone = '38'.$phone;
			}
			
			return $phone;
		}
	}
