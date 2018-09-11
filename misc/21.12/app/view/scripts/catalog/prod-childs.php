<?/*
<? if (count($this->childs)) { ?>
	<div class="content">
		<?
		$i = 0;
		foreach ($this->childs as $prod) {
			if ($i++ % 3 == 0)
				echo '<div style="clear:both"></div>';
			?>
			<div style="float:left; width: 33%; text-align: center;">
				<a href="<?= $this->url->mkd(array(2, 'prod-' . $prod->id)) ?>">
					<img src="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&width=104&height=104" alt="<?= $prod->name ?>">
				</a>
				<span style="display:block; height: auto; text-align: center">
					<a href="<?= $this->url->mkd(array(2, 'prod-' . $prod->id)) ?>"><?= $prod->name ?></a>
				</span>
			</div>
		<? } ?>
		<div style="clear:both"></div>
	</div>
<? }else { ?>

<? } ?>
*/?>




<? if (count($this->childs)) { ?>
<ul>
<?	$i = 0;
	foreach ($this->childs as $prod) {?>
		<?if($i++%4==0){?>
			<div class="line clearfix">
		<?}?>
					<script>
						function check_num_<?=$prod->id?>(){
							var num_na_sklade = <?=0+$prod->num?>;
							var num_in_cart = <?=0+$_SESSION['cart'][$prod->id."_0"]['num']?>;
							var num = num_in_cart + parseInt($("#quantity<?=$prod->id?>").val());

							if(num_na_sklade < num){
								$("#quantity<?=$prod->id?>").val(num_na_sklade-num_in_cart);
								alert("На складе есть не более "+num_na_sklade+" упаковок(ка)");
								return false;
							}
						}
					</script>

				<div class="tovar-l clearfix" id="tovar-img<?=$prod->id?>">
					<div class="tovar-img">
						<a href="/catalog/prod-<?= $prod->id ?>">
							<img src="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&amp;width=180&amp;height=180" alt="<?= $prod->name ?>" id="prodpreview<?=$prod->id?>">
						</a>
<?		if ($prod->skidka) { ?>
						<div class="discount"><span>-<?= $prod->skidka ?>%</span></div>
<?		} ?>
<?		if($prod->pop){?>
						<div class="hot"></div>
<?		}?>

					</div>
					<p><a href="/catalog/prod-<?= $prod->id ?>" title="<?=$prod->name?>"><?=Func::fmtname($prod->name)?></a></p>
					<?if($_COOKIE['userdiscount']) { ?>
						<span style="font-size: 14px;"><s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?>&nbsp;</s></span>
						<span><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price*(100-$_COOKIE['userdiscount'])/100) ?>&nbsp;<?=$this->valuta['name']?></span> / <?= $prod->inpack ?>&nbsp;</span>
					<?	}else{?>
					<span style="font-size: 14px;"><?= Func::fmtmoney($prod->price * (100-$prod->skidka)/100) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?></span>
					<?	}?>
					<span>
						<form action="<?=$this->url->gvar("buy=1")?>" method="post" id="prodform_<?=$prod->id?>">
							<input type="hidden" name="id" value="<?=$prod->id?>" />
							<input type="hidden" name="ajax" value="1" class="ajax" />
							<input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
							<input type="image" src="<?=$this->path?>/img/bbuy.png" onclick="_gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']); buy(<?=$prod->id?>); return false;" style="margin: 0 0 0 20px;">
							<input type="text" maxlength="5" name="num" id="quantity<?=$prod->id?>" value="1" onchange="check_num_<?=$prod->id?>()">
						</form>
					</span>
				</div>
		<?if($i%4==0){?>
			</div>
		<?}?>
	<? } ?>
	<?if($i%4!=0){?>
		</div>
	<?}?>
</ul>
<?}?>