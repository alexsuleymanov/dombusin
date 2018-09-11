<!-- Featured -->
<div class="title main-np"><span>Популярные товары</span></div>
<?
$Prod = new Model_Prod();
$prods = $Prod->getall(array("where" => "visible = 1 and pop = 1 and (num != 0 or num2 != 0 or num3 != 0)", "limit" => "4", "order" => "rand()"));
$i = 0;
foreach ($prods as $prod) {?>
	<div class="col-sm-4 col-lg-3 box-product-outer">
		<div class="box-product">
			<div class="img-wrapper">
				<a href="/catalog/prod-<?= $prod->id ?>">
					<?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
						<img alt="<?= $prod->name ?>" src="/pic/prod/<?= $prod->id ?>.jpg">
					<?} else {?>
						<img alt="<?= $prod->name ?>" src="<?=$this->path?>/img/tr.gif">
					<?}?>
				</a>
			</div>
			<? if ($prod->pop) { ?>
				<div class="pc-hot"></div>
			<? } ?>
			<? if ($prod->skidka) { ?>
				<div class="pc-skidka"><?="-".$prod->skidka."%" ?></div>
			<? } ?>
			<?	if($prod->new){?>
				<div class="pc-new"></div>
			<?	}?>
			<div class="h6"><a href="/catalog/prod-<?= $prod->id ?>"><?= $prod->name ?></a></div>
			<div class="price">
				<div>
					<?if(AS_Discount::getUserDiscount() > 0) { ?>
						<?	if($prod->num2 || $prod->num3){?>
							<select name="var" class="priceselect red" onchange="changepack(<?=$prod->id?>, this.value);">
								<option value="1"><?= Func::fmtmoney($prod->price * (100 - AS_Discount::getUserDiscount()) / 100) ?> &nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		if($prod->num2){?>
									<option value="2"><?= Func::fmtmoney($prod->price2 * (100 - AS_Discount::getUserDiscount()) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3){?>
									<option value="3"><?= Func::fmtmoney($prod->price3 * (100 - AS_Discount::getUserDiscount()) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
							</select>
						<?		}else{?>
							<span ><s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?>&nbsp;</s></span>
							<span style="color: red;">Ваша цена: <?= Func::fmtmoney($prod->price*(100-AS_Discount::getUserDiscount())/100) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?>&nbsp;</span>
						<?	}?>
					<?	}else{?>
						<?	if($prod->num2 || $prod->num3){?>
							<select name="var" class="priceselect red" onchange="changepack(<?=$prod->id?>, this.value);">
								<option value="1"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?> &nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		if($prod->num2){?>
									<option value="2"><?= Func::fmtmoney($prod->price2 * (100 - $prod->skidka2) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3){?>
									<option value="3"><?= Func::fmtmoney($prod->price3 * (100 - $prod->skidka3) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
							</select>
						<?		}else{?>
							<span><?= Func::fmtmoney($prod->price * (100-$prod->skidka)/100) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?></span>
						<?	}?>
					<?	}?>
				</div>
			</div>
			<form action="<?=$this->url->gvar("buy=1")?>" method="post" id="prodform_<?=$prod->id?>">
				<input type="hidden" name="id" value="<?=$prod->id?>" />
				<input type="hidden" name="ajax" value="1" class="ajax" />
				<input type="hidden" name="reload" value="1" />
				<input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
				<div class="col-md-3 col-xs-3 col-nopadding">
					<input type="text" maxlength="5" name="num" id="quantity<?=$prod->id?>" value="1" onchange="check_num(<?=$prod->id?>, $('#prodvar<?=$prod->id?>').val(), $(this).val());" class="form-control text-center">
				</div>
				<div class="col-md-9 col-xs-9 col-nopadding">
					<button class="btn btn-theme m-b-1 form-control" type="button" onclick="buy(<?=$prod->id?>); return false;"><i class="fa fa-shopping-cart"></i> В корзину</button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>
	</div>

<? } ?>
<!-- End Featured -->
<div class="clearfix"></div>