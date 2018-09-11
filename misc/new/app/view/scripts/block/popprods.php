<ul>
	<?
	$Prod = new Model_Prod();
	$prods = $Prod->getall(array("where" => "visible = 1 and pop = 1 and `main` = 1 and (num != 0 or num2 != 0 or num3 != 0)", "limit" => "8", "order" => "prior desc"));
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
<?		if($prod->skidka){?>
						<div class="discount"><span>-<?= $prod->skidka ?>%</span></div>
<?		}?>
<?		if($prod->pop){?>
						<div class="hot"></div>
<?		}?>
					</div>
					<p><a href="/catalog/prod-<?= $prod->id ?>" title="<?=$prod->name?>"><?=Func::fmtname($prod->name)?></a></p>
					<? if ($prod->skidka || $prod->skidka2 || $prod->skidka3) { ?>
								<?	if($prod->num2 > 0 || $prod->num3 > 0){?>
									<select name="var" class="priceselect red" onchange="changepack(<?=$prod->id?>, this.value);">
								<?		if($prod->num > 0){?>		
										<option value="1"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?> &nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		}?>
								<?		if($prod->num2 > 0){?>
										<option value="2"><?= Func::fmtmoney($prod->price2 * (100 - $prod->skidka2) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3 > 0){?>
										<option value="3"><?= Func::fmtmoney($prod->price3 * (100 - $prod->skidka3) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
									</select>
								<?		}else{?>
									<font style="text-decoration: line-through; font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></font><br>
									<span style="display:block;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span><span class="count products in pack"> / <?= $prod->inpack ?></span></span>
								<?		}?>
					<? } elseif (AS_Discount::getUserDiscount() > 0) { ?>
									<?	if($prod->num2 > 0 || $prod->num3 > 0){?>
									<select name="var" class="priceselect red" onchange="changepack(<?=$prod->id?>, this.value);">
								<?		if($prod->num > 0){?>		
										<option value="1"><?= Func::fmtmoney($prod->price * (100 - AS_Discount::getUserDiscount()) / 100) ?> &nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		}?>
								<?		if($prod->num2 > 0){?>
										<option value="2"><?= Func::fmtmoney($prod->price2 * (100 - AS_Discount::getUserDiscount()) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3 > 0){?>
										<option value="3"><?= Func::fmtmoney($prod->price3 * (100 - AS_Discount::getUserDiscount()) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
									</select>
								<?		}else{?>
									<span class="price" style="display:block;float:left;padding-left:10px;width:175px; font-size: 14px;"><s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;/ <?= $prod->inpack ?></s></span><br />
									<span class="price" style="display:block;float:left;padding-left:10px;width:175px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price * (100 - AS_Discount::getUserDiscount()) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span>&nbsp;/ <?= $prod->inpack ?></span><br />
								<?		}?>	
					<? } else { ?>
								<?	if($prod->num2 > 0 || $prod->num3 > 0){?>
									<select name="var" class="priceselect" onchange="changepack(<?=$prod->id?>, this.value);">
								<?		if($prod->num > 0){?>		
										<option value="1"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		}?>
								<?		if($prod->num2 > 0){?>
										<option value="2"><?= Func::fmtmoney($prod->price2) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3 > 0){?>
										<option value="3"><?= Func::fmtmoney($prod->price3) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
									</select>
								<?		}else{?>
									<span style="display:block;"><span style="font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></span></span>
								<?		}?>	
									
					<? } ?>
					<span>
						<form action="<?=$this->url->gvar("buy=1")?>" method="post" id="prodform_<?=$prod->id?>">
							<?
                                if($prod->num3 > 0) {$prodvar = 3;}
                                if($prod->num2 > 0) {$prodvar = 2;}
                                if($prod->num > 0) {$prodvar = 1;}
                            ?>
							<input type="hidden" name="id" value="<?=$prod->id?>" />
							<input type="hidden" name="var" value="<?=$prodvar?>" id="prodvar<?=$prod->id?>" />
							<input type="hidden" name="ajax" value="1" class="ajax" />
							<input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
							<input type="image" src="<?=$this->path?>/img/bbuy.png" onclick="ga('send', 'event', 'Buy', 'Click_buy'); buy(<?=$prod->id?>); return false;" style="margin: 0 0 0 20px;">
							<input type="text" maxlength="5" name="num" id="quantity<?=$prod->id?>" value="1" onchange="check_num(<?=$prod->id?>, $('#prodvar<?=$prod->id?>').val(), $(this).val());" >
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
