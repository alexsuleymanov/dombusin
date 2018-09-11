<?	
	define("ASWEB_ADMIN", 1);

	require_once "../incl.php";
	$url = new URLParser();

	require_once "../app/init/view.php";

	require_once("auth.php");
	require_once("edit.php");

	error_reporting(E_ERROR);
	ini_set("display_errors", 0);
