<?
	$i = 0;
	$cou=count($this->bc);
	if($cou){
		foreach($this->bc as $l => $t){
    		if($i < $cou-1){
				echo "<a href=\"$l\">" . $t;
				if(++$i < $cou) echo " > ";
				echo "</a>";
			}
			else
			{echo '<span>'.$t.'</span>';}
			$lastcat=$t;
		}
	}
?>