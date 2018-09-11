<?
	$News = new Model_Page('article');
	$cond = array(
		"where" => "visible = 1",
		"order" => "tstamp desc",
		"limit" => 3,
	);

	$news = $News->getall($cond);?>
<?	foreach($news as $k => $v) {?>
<div class="art-item">
	<div class="ai1">
		<a href="/articles/<?=$v->intname?>"><?=date("d.m.Y",$v->tstamp)?></a>
	</div>
	<div class="ai2">
		<div class="ai21">
			<a href="/articles/<?=$v->intname?>"><?=$v->name?></a>
		</div>
		<div class="ai23">
			<a href="/articles/<?=$v->intname?>"><?=mb_substr(strip_tags($v->cont), 0, 200, 'UTF-8')."...";?></a>
		</div>
	</div>
	<div class="clear"></div>
</div>


<?	}?>
<div class="trr5"></div>
<div class="allart"><a href="/articles"><img src="<?=$this->path?>/img/plus.png" alt="" /><?=$this->labels['allarts']?></a></div>
<div class="clear"></div>