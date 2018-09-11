<?
	$Cat = new Model_Cat();
	$cats = $Cat->getall(array("where" => "cat = 0", "order" => "prior desc"));
	$j = 0;
?>
<table cellspacing="20" cellpadding="0" border="0" width="100%">
<?	foreach($cats as $k => $cat_r){
		if($j++ % 3 == 0) echo "<tr>";?>
	<td class="prodcat">
		<a href="/catalog/cat-<?=$cat_r->id?>-<?=$cat_r->intname?>"><h4><?=$cat_r->name?></h4></a>
		<?
			$Subcat = new Model_Cat();
			$subcats = $Cat->getall(array("where" => "cat = $cat_r->id", "order" => "prior desc"));
		?>
		<?	$i=0;
			foreach($subcats as $sk => $scat_r){
				if($i++!=0){echo ", ";}
		?>
		<a href="/catalog/cat-<?=$scat_r->id?>-<?=$scat_r->intname?>"><?=$scat_r->name?></a>
		<?	}?>
	</td>
<?	}?>
</table>
