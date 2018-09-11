<h2>Облако тегов</h2>
<?	$Tag = new Model_Tag();
	$tags = $Tag->getall(array());
	foreach($tags as $k => $v){?>
		<a href="/tag/<?=$v->intname?>"><span style="font-size: <?=rand(6, 16)?>px;"><?=$v->name?></span></a>
<?	}
