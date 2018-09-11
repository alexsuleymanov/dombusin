<?
if(in_array($this->args[1], Model_Prod::$spec)) {
	$supurl = $this->args[1]."/";
}
$Cat = new Model_Cat();
$cat = $Cat->get($this->cat);?>
<h1><?= $this->page->h1 ?></h1>

<div class="pagecont">
<?	echo $this->page->cont2;?>
</div>


<?	$i=0;
foreach ($this->cats as $k => $r) {
	$subcats = $Cat->getall(array("where" => "cat = $r->id and visible = 1", "order" => "prior desc"));
	?>
	<div class="sl-block">
		<a href="/catalog/<?=$supurl?>cat-<?= $r->id ?>-<?= $r->intname ?>" data-id="<?= $r->id ?>" class="sl-item"><img src="/pic/cat/<?=$r->id?>.jpg" width="120" alt="<?= $r->name ?>">
		<span><?= $r->name ?></span>
		</a>
	</div>
<? } ?>
<div class="sl-space"></div>


