<table cellpadding="20">
	<tr>
		<td valign="top" style="padding: 20px;">
<?	foreach($this->cats as $k => $v){
		echo "<h3><a href=\"/catalog-".$v->id."-".$v->intname."\">".$v->name."</a></h3>";
		foreach($this->subcats as $kk => $vv){
			if($vv->cat == $v->id) echo "<span style=\"margin-left: 20px;\"><a href=\"/catalog-".$vv->id."-".$vv->intname."\" style=\"color: #000000;\">".$vv->name."</a></span><br />";
		}
		echo "<br />";
	}
?>
		</td>
		<td valign="top" style="padding: 20px;">
<?
	foreach($this->pages as $k => $v){
		echo "<h3><a href=\"/".$v->intname."\">".$v->name."</a></h3>";
		foreach($this->subpages as $kk => $vv){
			if($vv->page == $v->id) echo "<span style=\"margin-left: 20px;\"><a href=\"".$vv->intname."\" style=\"color: #000000;\">".$vv->name."</a></span><br />";
		}
		echo "<br />";
	}
?>						

<?		echo "<h3><a href=\"/articles\">Статьи</a></h3>";?>
<?	foreach($this->articles as $k => $v){
		echo "<span style=\"margin-left: 20px;\"><a href=\"/articles/".$v->intname."\" style=\"color: #000000;\">".$v->name."</a></span><br />";		
		echo "<br />";
	}?>

<?		echo "<h3><a href=\"/news\">Новости</a></h3>";?>
<?	foreach($this->news as $k => $v){
		echo "<span style=\"margin-left: 20px;\"><a href=\"/news/".$v->intname."\" style=\"color: #000000;\">".$v->name."</a></span><br />";		
		echo "<br />";
	}?>

		</td>
	</tr>
</table>