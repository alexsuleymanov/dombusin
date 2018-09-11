<?
$i = 0;
$cou=count($this->bc);
if($cou){
	foreach($this->bc as $l => $t){
		if($i < $cou-1) {
			echo "<a href=\"$l\">" . $t;
			if((++$i < $cou)&&(!$this->prod)) {echo " > ";} elseif(($i < $cou-1)&&($this->prod)) {echo " > ";}
			echo "</a>";
		}
		else {
			if(!$this->prod) {
				echo $t;
			}

		}
		$lastcat=$t;
	}
}
?>