<ul style="margin-left: 40px;">
	<?
	$Prod = new Model_Prod();
	$prods = $Prod->getall(array("where" => "visible = 1 and `changed` > ".(time() - 45*86400)."", "limit" => "8", "order" => "changed desc"));
	$i = 0;
	foreach ($prods as $prod) {?>
		<?if($i++%4==0){?>
			<div class="line clearfix">
		<?}?>
				<div class="tovar-l clearfix" id="tovar-img<?=$prod->id?>">
					<div class="tovar-img">
						<a href="/catalog/prod-<?= $prod->id ?>">
							<img src="/pic/prod/<?= $prod->id ?>.jpg" width="152" alt="<?= $prod->name ?>" id="prodpreview<?=$prod->id?>">
						</a>
<?		if ($prod->skidka) { ?>
						<div class="discount"><span>-<?= $prod->skidka ?>%</span></div>
<?		} ?>
<?		if($prod->pop){?>
						<div class="hot"></div>
<?		}?>
						<div class="new"></div>

					</div>
					<p><a href="/catalog/prod-<?= $prod->id ?>" title="<?=$prod->name?>"><?=Func::fmtname($prod->name)?></a></p>
					<?if($_COOKIE['userdiscount']) { ?>
						<span style="font-size: 14px;"><s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?>&nbsp;</s></span>
						<span><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price*(100-$_COOKIE['userdiscount'])/100) ?>&nbsp;<?=$this->valuta['name']?></span> / <?= $prod->inpack ?>&nbsp;</span>
					<?	}else{?>
					<span style="font-size: 14px;"><?= Func::fmtmoney($prod->price * (100-$prod->skidka)/100) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?></span>
					<?	}?>
				</div>
		<?if($i%4==0){?>
			</div>
		<?}?>
	<? } ?>
	<?if($i%4!=0){?>
		</div>
	<?}?>
</ul>
