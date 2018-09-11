<?
	include("adm_incl.php");
	echo $view->render('head.php');

	if($_POST['submit']){
		if(file_exists($path."/sitemap.xml")) unlink($path."/sitemap.xml");
		move_uploaded_file($_FILES['sitemap']['tmp_name'], $path."/sitemap.xml");
		echo "<h3>sitemap.xml успешно обновлен</h3><p>Ссылка на sitemap - <a href=\"http://".$_SERVER['HTTP_HOST']."/sitemap.xml\">http://".$_SERVER['HTTP_HOST']."/sitemap.xml</a></p>";
	}else{?>
<div style="margin: 20px;">
<h2>Загрузка sitemap.xml</h2>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="sitemap" />
	<input type="submit" name="submit" value="Загрузить" />
</form>
</div>
<?	}

	echo $view->render('foot.php');