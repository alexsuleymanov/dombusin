<?	include("../../incl.php");

	header("Content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";

	echo "<Templates imagesBasePath=\"/pic/template/\">\n";

	$Template = new Model_Template();
	$templates = $Template->getall(array("where" => "`type` = 'page'"));

	foreach($templates as $template){
		echo "<Template title=\"".$template->name."\" image=\"".$template->id.".jpg\">\n";
		echo "<Description>".$template->short."</Description>\n";
		echo "<Html>\n";
		echo "<![CDATA[\n";
		echo $template->cont."\n";
		echo "]]>\n";
		echo "</Html>\n";
		echo "</Template>\n";
	}
	echo "</Templates>";
