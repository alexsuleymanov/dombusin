<?
	if($_GET['action'] == 'delete'){
		echo realpath(dirname(__FILE__)) ."/../". $_GET['filename'];
		unlink(realpath(dirname(__FILE__)) ."/../". $_GET['filename']);
		die();
	}

	include("../../incl.php");
	include("../auth.php");

	$i = 0;
	$filename1 = $filename = $_FILES["userfile"]["name"];
	
	while(file_exists("../".$_GET['location']."/".$filename1)){
		$i++;
		$filename1 = $i."_".$filename;
	}

	$tmp_file = $path."/admin/tmp/".$filename1;
	
	move_uploaded_file($_FILES["userfile"]["tmp_name"], $tmp_file);
	$dst = $tmp_file;

	echo $filename1;
