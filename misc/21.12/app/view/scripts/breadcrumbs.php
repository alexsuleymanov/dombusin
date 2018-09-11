<?
	$i = 0;
	if($cc = count($this->bc))
		foreach($this->bc as $l => $t){
			if($i++) echo " / ";
			if($i < $cc)
				echo "<a href=\"$l\">".$t."</a>";
			else
				echo "<strong>".$t."</strong>";
		}
?>
