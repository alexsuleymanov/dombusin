<?
	include("adm_incl.php");
	error_reporting(E_ALL & ~E_NOTICE);
	//error_reporting(E_ERROR);
	ini_set("display_errors", 0);
	echo $view->render('head.php');

	if($_GET['submit']){
		$Sitemap = new AS_Sitemap();
		$Sitemap->save($path."/sitemap.xml");

		echo "<h3>sitemap.xml успешно обновлен</h3><p>Ссылка на sitemap - <a href=\"http://".$_SERVER['HTTP_HOST']."/sitemap.xml\" target=\"_blank\">http://".$_SERVER['HTTP_HOST']."/sitemap.xml</a></p>";
	}else{?>
<div style="margin: 20px;">
<h2>Генерация sitemap.xml</h2>
<br />
<form action="" method="get">
	<input type="submit" name="submit" value="Сгенерировать" />
</form>
</div>
<?	}

	echo $view->render('foot.php');