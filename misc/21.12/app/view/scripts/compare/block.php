<?	$opt = Zend_Registry::get('opt');

	if($opt["prod_compare"] && $this->cat){?>
<div id="compare">
	<h2><?=$this->labels["to_compare"]?></h2>
	<span id="prods"><?=count($_SESSION["compare"][$this->cat])?></span> <?=$this->labels["tovarov"]?><br />
	<a id="opencompare" href="/compare/cmp/<?=$this->cat?>/<?=implode("-", $_SESSION["compare"][$this->cat])?>?iframe=1"><?=$this->labels["compare"]?></a>
</div>
<?	}?>