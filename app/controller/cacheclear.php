<?php
	if($_GET['key'] != 'deus') die();
	
	if (file_exists($path.'/tmp'))
		foreach (glob($path.'/tmp/*') as $file){
			echo $file."<br>";
			unlink($file);
		}