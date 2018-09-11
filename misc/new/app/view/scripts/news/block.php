<div id="newsheader"><?=$this->labels['news']?></div>
<?
	$News = new Model_Page('news');
	$cond = array(
		"order" => "tstamp desc",
		"limit" => 10,
	);

	$news = $News->getall($cond);?>
<?	foreach($news as $k => $v) {?>
<div style="height:16px;">
	<div class="plusnews"><img src="<?=$this->path?>/img/plus.png" alt="" /></div>
	<div class="newshead">
		<a href="/news/<?=$v->intname?>"><?=$v->name?></a>
	</div>
</div>
<div class="newscont">
	<a href="/news/<?=$v->intname?>"><?=substr(strip_tags($v->cont), 0, 200)."...";?></a>
</div>
<div>
	<div class="strnews"><img src="<?=$this->path?>/img/str1.png" alt="" /></div>
	<div class="strhead">
		<a href="/news/<?=$v->intname?>"><?=$this->labels['continue']?></a>
	</div>
</div>
<?	}?>

