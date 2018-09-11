<?	
	define("ASWEB_ADMIN", 1);

	require_once "../incl.php";
	require_once "../incl2.php";
	$url = new URLParser();

	require_once "../app/init/view.php";

	require_once("auth.php");
	require_once("edit.php");

//	error_reporting(E_ERROR);
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set("display_errors", 1);

//		error_reporting(E_ALL & ~E_NOTICE);
//	ini_set("display_errors", 1);