<?
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set("display_errors", 1);

	print_r($_SERVER);

		function gvar($dpar = "") {
			global $_SERVER;

			$s = urldecode($_SERVER[QUERY_STRING]."&".$dpar);
			$a = explode("&", $s);
			$new_a = array();
			$q = "";

			foreach($a as $k => $v){
				if (preg_match("/^([^=]+)=(.*)$/", $v, $m)){
					if(strstr($m[1], "["))
						$new_a[$m[1]."_".$k] = urlencode($m[1])."=".urldecode($m[2]);
					else
						$new_a[$m[1]] = urlencode($m[1])."=".urldecode($m[2]);
					if(empty($m[2])) $new_a[$m[1]] = "";

				}
			}
	
			foreach($new_a as $v) $q .= ($v) ? $v."&" : "";

			return (empty($q)) ? "" : "?".rtrim($q, "&");
		}

	echo "gvar.php".gvar("start=0");