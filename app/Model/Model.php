<?
//	version	2.4

	class Model_Model{
	    protected $db = NULL;
		public $db_prefix;

    	public $table = "";
		protected $_lastid = NULL;

	    public $id   = NULL;
    	public $row  = array();

		protected $name = '';
		protected $depends = array();
		protected $relations = array();
		public $par = 0;
    
    	function __construct($id = 0){
			global $db, $db_prefix;
			$this->db = $db;
			
			$this->db_prefix = $db_prefix;
			$this->table = $this->db_prefix.$this->name;
			$this->id = $id;
		}

		function get($id = 0){
			if($id)	$this->id = $id;
			$r = $this->q("select * from `$this->table` where id = '".data_base::nq($this->id)."'")->f();
			if(defined('MULTY_LANG') && $r){
				$translate = $this->translate($r->id, $this->table, Zend_Registry::get('lang'));
				foreach($translate as $k => $v){
					$field = $v->field;
					$r->$field = $v->cont;
				}
			}

			return $r;
		}

		function last_id(){
			return $this->_lastid;
		}

		function getone($options = array()){
			$rows = $this->getall($options);
			return $rows[0];
		}
		//Пример array("where" => "cat = '$cat' and brand = '$brand", "order" => "tstamp desc, cat asc", "limit" => "0, 5")

		function getall($options = array()){
			$rows = array();
			$ids = array();

			$select = isset($options['select']) ? $options['select'] : "*";
			$where = isset($options['where']) ? $options['where'] : "1";
			$order = "order by " . (isset($options['order']) ? $options['order'] : "id desc");
			$limit = isset($options['limit']) ? "limit $options[limit]" : "";
			$obj_rel = 'obj';
			
			if(isset($options["relation"])){
				$Relation = new Model_Relation();
				$relations = $Relation->getall(array("select" => $options["relation"]["select"]." as relid", "$obj_rel as id", "where" => $options["relation"]["where"]));
				if(count($relations)){
					foreach($relations as $k => $v) $ids[] = $v->relid;
					$where .= " and (id = ".implode(" or id = ", $ids).")";
				}else return $rows;
			}
			
			$q = "select $select " .
				"from `$this->table` " .
				"where $where " .
				"$order $limit";

			$qr = $this->q($q);
			while($r = $qr->f()){
				if(defined('MULTY_LANG')){
					$translate = $this->translate($r->id, $this->table, Zend_Registry::get('lang'));

					if(Zend_Registry::get('default_lang') != Zend_Registry::get('lang') && $this->multylang && !empty($translate))
						foreach($translate as $k => $v){
							$field = $v->field;
							$r->$field = $v->cont;
						}
				}
				$rows[] = $r;
    		}

			return (empty($rows)) ? array() : $rows;
		}

		function getnum($options = array()){
			$options["select"] = "count(id) as num";
			$arr = $this->getone($options);
			return $arr->num;
		}

		function q($q){
			return $this->db->q($q);
		}

		function mq($q){
			return $this->db->mq($q);
		}

		public function save($data, $options = array()){
			if($this->id > 0)
				return $this->update($data, $options);
			else
				return $this->insert($data);
		}
	
		public function update($data, $options = array()){
			$where = isset($options['where']) ? $options['where'] : "id = '".$this->id."'";

			$q = "update `$this->table` set ";

			$i = 0;
			while(list($k, $v) = each($data)){
				if($i++) $q .= ", ";
            	$q .= "`".$k."` = '".data_base::nq($v)."'";
			}

			$q .= " where $where";
			$this->q($q);
		}

		public function insert($data){
			$q = "insert into `$this->table` set ";

			$i = 0;
			while(list($k, $v) = each($data)){
				if($i++) $q .= ", ";
            	$q .= "`".$k."` = '".data_base::nq($v)."'";
			}

			$this->q($q);
			$this->_lastid = $this->db->lastid();
		}
	
		public function translate($id, $table, $lang){
			$Translate = new Model_Translate();
			return $Translate->translate($id, $table, $lang);
		}

		function delete($options = array()){
			$where = isset($options['where']) ? $options['where'] : "id = '".$this->id."'";
			if(defined('MULTY_LANG')){
				$rows = $this->getall($options);
				foreach($rows as $k => $r){
					$this->q("delete from `".$this->db_prefix."translate` where obj_id = '".$r->id."' and `table` = '".$this->table."'");
				}
			}

			$this->q("delete from `$this->table` where $where");
		}

		function delete_all(){
			if(defined('MULTY_LANG')){
				$rows = $this->getall($options);
				foreach($rows as $k => $r){
					$this->q("delete from `".$this->db_prefix."translate` where obj_id = '".$r->id."' and `table` = '".$this->table."'");
				}
			}

			$this->q("truncate table `$this->table`");
		}

		function destroy($id = 0){
			global $path;

//			echo "<p>Destroy: ".$this->name."-".$id;
//			print_r($this->depends);
			foreach($this->depends as $depend){
//				echo "<br>".$depend.": "; 
				$model = "Model_".ucfirst($depend);
				$Model = new $model();

				if($Model->par == 1){
					$objs = $Model->getall(array("select" => "id", "where" => "`type` = '".$this->name."' and `par` = '".$id."'"));
				}else{
					$objs = $Model->getall(array("select" => "id", "where" => "`".$this->name."` = '".$id."'"));
				}
//				print_r($objs);
				foreach($objs as $obj){
					$Model->destroy($obj->id);
				}
			}

			if($this->ftype)
				$dst = $path."/pic/".$this->name."/".$id.".".$this->ftype;
			else
				$dst = $path."/pic/".$this->name."/".$id.".jpg";

			if (file_exists($dst)) unlink($dst);

			$Translate = new Model_Translate();
			$Translate->delete(array("where" => "`obj_id` = '".$id."' and `table` = '".$model."'"));

			$Relation = new Model_Relation();
			foreach($this->relations as $k => $v){
				$Relation->delete(array("where" => "`".$k."` = '".$id."' and `type` = '".$relation."'"));
			}

			$this->delete(array("where" => "`id` = ".$id));
//			die();
		}

		function visibility($id, $visible = 0){
			global $path;

			foreach($this->depends as $depend){
				$model = "Model_".ucfirst($depend);
				$Model = new $model();
				if($Model->visibility == 0) continue;

				if($Model->par == 1){
					$objs = $Model->getall(array("select" => "id", "where" => "`type` = '".$this->name."' and `par` = '".$id."'"));
				}else{
					$objs = $Model->getall(array("select" => "id", "where" => "`".$this->name."` = '".$id."'"));
				}

				foreach($objs as $obj){
					$Model->visibility($obj->id, $visible);
				}
			}

			$this->update(array("visible" => data_base::nq($visible)), array("where" => "id = '".$id."'"));
		}

	}