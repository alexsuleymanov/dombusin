<?
	echo realpath(dirname(__FILE__));
	$ff = fopen(realpath(dirname(__FILE__))."/11", "w+");
	fwrite($ff, "111");
	fclose($ff);