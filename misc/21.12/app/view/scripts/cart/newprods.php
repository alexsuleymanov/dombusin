<ul>
	<?
	$Prod = new Model_Prod();
	$prods = $Prod->getall(array("where" => "visible = 1 and new = 1 and (num != 0 or num2 != 0 or num3 != 0)", "limit" => "4", "order" => "rand()"));
	$i = 0;
	foreach ($prods as $prod) {?>
		<?if($i++%4==0){?>
			<div class="line clearfix">
		<?}?>
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
					<p><a href="/catalog/prod-<?= $prod->id ?>" title="<?=$prod->name?>"><?=substr($prod->name, 0, strpos($prod->name, ",", 50))."..."?></a></p>
					<?/*if($_COOKIE['userdiscount']) { ?>
						<span ><s>Цена: <?= Func::fmtmoney($prod->price) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?>&nbsp;</s></span>
						<span style="color: red;">Ваша цена: <?= Func::fmtmoney($prod->price*(100-$_COOKIE['userdiscount'])/100) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?>&nbsp;</span>
					<?	}else{?>
					<span>Цена: <?= Func::fmtmoney($prod->price * (100-$prod->skidka)/100) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?></span>
					<?	}*/?>
					<? if ($prod->skidka) { ?>
								<?	if($prod->num2 || $prod->num3){?>
									<select name="var" class="priceselect red" onchange="changepack(<?=$prod->id?>, this.value);">
								<?		if($prod->num){?>		
										<option value="1"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?> &nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		}?>		
								<?		if($prod->num2){?>
										<option value="2"><?= Func::fmtmoney($prod->price2 * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3){?>
										<option value="3"><?= Func::fmtmoney($prod->price3 * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
									</select>
								<?		}else{?>
									<font style="text-decoration: line-through; font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></font><br>
									<span style="display:block;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span><span class="count products in pack"> / <?= $prod->inpack ?></span></span>
								<?		}?>
								<? } elseif ($_COOKIE['userdiscount']) { ?>
									<?	if($prod->num2 || $prod->num3){?>
									<select name="var" class="priceselect red" onchange="changepack(<?=$prod->id?>, this.value);">
								<?		if($prod->num){?>		
										<option value="1"><?= Func::fmtmoney($prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?> &nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		}?>		
								<?		if($prod->num2){?>
										<option value="2"><?= Func::fmtmoney($prod->price2 * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3){?>
										<option value="3"><?= Func::fmtmoney($prod->price3 * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
									</select>
								<?		}else{?>
									<span class="price" style="display:block;float:left;padding-left:10px;width:175px; font-size: 14px;"><s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;/ <?= $prod->inpack ?></s></span><br />
									<span class="price" style="display:block;float:left;padding-left:10px;width:175px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span>&nbsp;/ <?= $prod->inpack ?></span><br />
								<?		}?>	
								<? } else { ?>
								<?	if($prod->num2 || $prod->num3){?>
									<select name="var" class="priceselect" onchange="changepack(<?=$prod->id?>, this.value);">
								<?		if($prod->num){?>		
										<option value="1"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		}?>		
								<?		if($prod->num2){?>
										<option value="2"><?= Func::fmtmoney($prod->price2) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3){?>
										<option value="3"><?= Func::fmtmoney($prod->price3) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
									</select>
								<?		}else{?>
									<span style="display:block;"><span style="font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></span></span>
								<?		}?>	
									
								<? } ?>
					<span>
						<form action="/cart/buy" method="post" id="prodform_<?=$prod->id?>">
							<input type="hidden" name="id" value="<?=$prod->id?>" />
							<input type="hidden" name="var" value="<?=$prod->var?>" id="prodvar<?=$prod->id?>" />
							<input type="hidden" name="ajax" value="1" class="ajax" />
							<input type="hidden" name="reload" value="1" />
							<input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
							<input type="image" src="<?=$this->path?>/img/bbuy.png" onclick="_gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']); buy(<?=$prod->id?>); return false;" style="margin: 0 0 0 20px;">
							<input type="text" maxlength="5" name="num" id="quantity<?=$prod->id?>" value="1" onchange="check_num(<?=$prod->id?>, $('#prodvar<?=$prod->id?>').val(), $(this).val());">
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
