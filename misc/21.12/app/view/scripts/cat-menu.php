<?
	$Cat = new Model_Cat();
	$cats = $Cat->getall(array("where" => "par=0", "order" => "prior desc"));
?>
<ul>
<?	foreach($cats as $k => $cat_r){?>
	<li>
		<a href="/catalog/cat-<?=$cat_r->id?>-<?=$cat_r->intname?>"><?=$cat_r->name?></a>
	</li>
<?	}?>
</ul>