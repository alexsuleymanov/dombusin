<h2>Категории</h2>
<?
	$Cat = new Model_Cat('blogcat');
	$cats = $Cat->getall(array());
	foreach($cats as $k => $v){?>
		<div><a href="/blog/cat/<?=$v->intname?>"><?=$v->name?></a></div>
<?	}
