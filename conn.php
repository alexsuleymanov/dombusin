<?	
//	$db_login	= "igorz";
//	$db_pass	= "95Kp6HNR";
	$db_server	= "localhost";
	$db_login	= "deus";
	$db_pass	= "d2e06u84s";
	$db_base	= "dombusin2";
	$db_prefix	= "dombusin_";

	try{
		$db = new MySQL($db_server, $db_login, $db_pass, $db_base);
		$db->q("set character set utf8");
		$db->q("set names utf8");
	}catch(DBException $e){
		echo "<font color=red>DBException!</font><br />";
		echo $e->getMessage()."<br />";
		echo "in file: ".$e->getFile()."<br />";
		echo "at line: ".$e->getLine()."<br />";
		echo "Trace: <br />";
		$trace = $e->getTrace(); 
		foreach($trace as $k => $v){
			echo "<font color=\"green\">".$k." -> </font>";
			foreach($v as $kk => $vv){
				echo $kk." -> ";
				if(is_array($vv)) print_r($vv); else echo $vv;
				echo "<br />";
			}
			echo "<br />";
		}
		echo "<br />";
	}