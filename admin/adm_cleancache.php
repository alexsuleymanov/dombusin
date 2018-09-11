<?
include("adm_incl.php");

$dir = opendir($path."/tmp");
while ($ff = readdir($dir)) {
	if($ff == '.' || $ff == '..') continue;
	if (file_exists($path."/tmp/".$ff)) unlink($path."/tmp/".$ff);
}
closedir($dir);
	
$dir = opendir($path."/tmp/img");
while ($ff = readdir($dir)) {
	if ($ff == '.' || $ff == '..') continue;
	if (file_exists($path."/tmp/img/".$ff)) unlink($path."/tmp/img/".$ff);
}
closedir($dir);

echo $view->render('head.php');
echo "<h3>Кеш очищен</h3>";
echo $view->render('foot.php');