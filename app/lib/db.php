<?
	abstract class data_base{
		abstract function q($query);
		abstract function lastid();
		
		static function dnq($str){
			return stripslashes($str);
		}

		static function nq($data){
			$data = str_replace("\\", "\\\\", $data);
			$data = str_replace("'", "\'", $data);
			$data = str_replace('"', '\"', $data);
			$data = str_replace("\x00", "\\x00", $data);
			$data = str_replace("\x1a", "\\x1a", $data);
			$data = str_replace("\r", "\\r", $data);
			$data = str_replace("\n", "\\n", $data);
			return($data); 
		}
	}

	class MySQL extends data_base{
		protected $mysqli;
		
		function __construct($server, $login, $pass, $base){
			$this->mysqli = new mysqli($server, $login, $pass, $base);
			if ($mysqli->connect_error) throw new DBException($mysqli->connect_error);
		}
		
		function __destruct(){
			$this->mysqli->close();
		}

		function q($query){
			$res = $this->mysqli->query($query);
			if($res == false) throw new DBException($this->mysqli->error);
			return new MySQLResult($res);
		}
		
		function mq($query){
			$res = $this->mysqli->multi_query($query);
			if($res == false) print_r($this->mysqli->error);
			while ($this->mysqli->more_results()) {
				$this->mysqli->next_result();
				$this->mysqli->store_result();
			}
		}

		function lastid(){
			$ret = $this->mysqli->insert_id;
			if($ret == false) throw new DBException("No MySQL connection was established<br/>");
			return $ret;
		}

	}

	class MySQLResult{
		protected $result;

		function __construct($res){
			$this->result = $res;
		}

		function __destruct(){
//			$this->result->free();
//			mysql_free_result($this->resource);
		}

		function f(){
			$row = $this->fa();
			if($row == false) return false;
			$obj = new DBObject;
			foreach($row as $k => $v) $obj->$k = $v;
			return $obj;
		}

		function fa(){
			$row = $this->result->fetch_assoc();
			if($row == false) return false;
			foreach($row as $k => $v) $row[$k] = data_base::dnq($row[$k]);
			return $row;
		}

		function num_rows(){
			$n = $this->result->num_rows;
			return $n;
		}
	}

	class DBException extends Exception{
    }

	class DBObject{
    }