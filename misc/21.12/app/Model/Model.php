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
			global $cache;

//			if(!defined("CACHE_ON") || !$r = $cache->load("model_".$this->name."_".md5($id))){
			if($id)	$this->id = $id;
			$r = $this->q("select * from `$this->table` where id = '".data_base::nq($this->id)."'")->f();
			if(MULTY_LANG == 1 && $r){
				$translate = $this->translate($r->id, $this->table, Zend_Registry::get('lang'));
				foreach($translate as $k => $v){
					$field = $v->field;
					$r->$field = $v->cont;
				}
			}
//				if(defined("CACHE_ON") && !$this->no_cache) $cache->save($r, "model_".$this->name."_".md5($id), array("model_".$this->name));
//			}
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
			global $cache;

			$rows = array();
			$ids = array();

//			if(!defined("CACHE_SQL") || !$rows = $cache->load("model_".$this->table."_".md5(serialize($options)))){
			$select = isset($options['select']) ? $options['select'] : "*";
			$where = isset($options['where']) ? $options['where'] : "1";
			$order = "order by " . (isset($options['order']) ? $options['order'] : "id desc");
			$limit = isset($options['limit']) ? "limit $options[limit]" : "";

			if($options["relation"]){
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
				if(MULTY_LANG == 1){
					$translate = $this->translate($r->id, $this->table, Zend_Registry::get('lang'));

					if(Zend_Registry::get('default_lang') != Zend_Registry::get('lang') && $this->multylang && !empty($translate))
						foreach($translate as $k => $v){
							$field = $v->field;
							$r->$field = $v->cont;
						}
				}
				$rows[] = $r;
    		}


//				if(defined("CACHE_SQL") && !$this->no_cache) $cache->save($rows, "model_".$this->name."_".md5(serialize($options)), array("model_".$this->name));
//			}
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
			global $cache;
			$where = isset($options['where']) ? $options['where'] : "id = '".$this->id."'";

			$q = "update `$this->table` set ";

			$i = 0;
			while(list($k, $v) = each($data)){
				if($i++) $q .= ", ";
            	$q .= "`".$k."` = '".data_base::nq($v)."'";
			}

			$q .= " where $where";
			$this->q($q);

			$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array("model_".$this->name));
		}

		public function insert($data){
			global $cache;

			$q = "insert into `$this->table` set ";

			$i = 0;
			while(list($k, $v) = each($data)){
				if($i++) $q .= ", ";
            	$q .= "`".$k."` = '".data_base::nq($v)."'";
			}

			$this->q($q);
			$this->_lastid = $this->db->lastid();
			$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array("model_".$this->name));
		}
	
		public function translate($id, $table, $lang){
			$Translate = new Model_Translate();
			return $Translate->translate($id, $table, $lang);
		}

		function delete($options = array()){
			global $cache;
			$where = isset($options['where']) ? $options['where'] : "id = '".$this->id."'";
			if(defined('MULTY_LANG')){
				$rows = $this->getall($options);
				foreach($rows as $k => $r){
					$this->q("delete from `".$this->db_prefix."translate` where obj_id = '".$r->id."' and `table` = '".$this->table."'");
				}
			}

			$this->q("delete from `$this->table` where $where");
			$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array("model_".$this->name));
		}

		function delete_all(){
			global $cache;

			if(defined('MULTY_LANG')){
				$rows = $this->getall($options);
				foreach($rows as $k => $r){
					$this->q("delete from `".$this->db_prefix."translate` where obj_id = '".$r->id."' and `table` = '".$this->table."'");
				}
			}

			$this->q("truncate table `$this->table`");
			$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array("model_".$this->name));
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