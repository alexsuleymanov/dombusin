<!-- Featured -->
<div class="title main-np"><span>Популярные товары</span></div>
<div class="row">
	<?
	$Prod = new Model_Prod();
	$prods = $Prod->getall(array("where" => "visible = 1 and pop = 1 and (num > 0 or num2 > 0 or num3 > 0)", "limit" => "4", "order" => "rand()"));
	$i = 0;
	foreach ($prods as $prod) {?>
		<div class="col-sm-3 col-md-3 box-product-outer bpo-grid">
			<div class="box-product">
				<div class="img-wrapper">
					<a href="/catalog/prod-<?= $prod->id ?>">
						<?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
							<img src="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&amp;width=665&amp;height=665" alt="<?=$prod->name?>">
						<?} else {?>
							<img src="<?=$this->path?>/img/tr.gif">
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
				<?if (Model_User::userid()) {?>
					<?
					if($prod->num3 > 0) {$prodvar = 3;}
					if($prod->num2 > 0) {$prodvar = 2;}
					if($prod->num > 0) {$prodvar = 1;}
					?>
					<div class="pa">
						<div class="pc-wish">
							<form action="/user/wishlist/add/<?= $prod->id ?>" method="post" id="wishform_<?= $prod->id ?>">
								<input type="hidden" name="id" value="<?= $prod->id ?>" />
								<input type="hidden" name="var" value="<?=$prodvar?>" class="prodvar<?=$prod->id?>"/>
								<input type="hidden" name="ajax" value="1" class="ajax" />
								<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
								&nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $prod->id ?>); return false;" class="awl"><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний&nbsp;&nbsp;</a>
							</form>
						</div>
					</div>
				<?}?>
				<div class="h6"><a href="/catalog/prod-<?= $prod->id ?>"><?=$prod->name?></a></div>
				<div class="weight">Упак.: &nbsp;
					<?	if($prod->num2 > 0 || $prod->num3 > 0){?>
						<select name="var" onchange="changepack(<?=$prod->id?>, this.value);">
							<?	if($prod->num > 0){?>
								<option value="1"><?=$prod->inpack?></option>
							<?	}?>
							<?	if($prod->num2 > 0){?>
								<option value="2"><?=$prod->inpack2?></option>
							<?	}?>
							<?	if($prod->num3 > 0){?>
								<option value="3"><?=$prod->inpack3?></option>
							<?}?>
						</select>
					<?	}else{
						echo $prod->inpack;
					}?>

				</div>
				<div class="weight">
					Вес упак.: &nbsp;
					<?$k = 0;?>
					<?if($prod->num > 0){?>
						<span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar1"><?= $prod->weight ?> г</span>
					<?}?>
					<?if($prod->num2 > 0){?>
						<span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar2"><?= $prod->weight2 ?> г</span>
					<?}?>
					<?if($prod->num3 > 0){?>
						<span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar3"><?= $prod->weight3 ?> г</span>
					<?}?>

				</div>
				<div class="xprice">
					<?$this->prodone = $prod;?>
					<?=$this->render('catalog/prod-price.php');?>
				</div>
				<div class="xform">
					<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
						<?
						if($prod->num3 > 0) {$prodvar = 3;}
						if($prod->num2 > 0) {$prodvar = 2;}
						if($prod->num > 0) {$prodvar = 1;}
						?>
						<input type="hidden" name="id" value="<?= $prod->id ?>" />
						<input type="hidden" name="var" value="<?=$prodvar?>" id="prodvar<?=$prod->id?>" />
						<input type="hidden" name="ajax" value="1" class="ajax" />
						<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />

						<div class="productListing-data by_now">
							<div class="col-md-3 col-xs-3 col-nopadding">
								<input type="text" size="5" maxlength="5" name="num" id="quantity<?= $prod->id ?>" onchange="check_num(<?=$prod->id?>, $('#prodvar<?=$prod->id?>').val(), $(this).val());" value="1" class="form-control text-center pull-left">
							</div>
							<div class="col-md-9 col-xs-9 col-nopadding">
								<?if(!is_array($this->cartids) || !in_array($prod->id, $this->cartids)) {?>
									<button class="btn btn-theme m-b-1 form-control active focus" type="button" data-prod-id="<?= $prod->id ?>" onmousedown="try { rrApi.addToBasket(<?=$prod->id?>) } catch(e) {}" onclick="
										buy(<?= $prod->id ?>);
										$(this).addClass('added');
										$(this).html('<i class=&quot;fa fa-shopping-cart&quot;></i> Добавлен');
										$(this).attr('onclick', 'location.href=\'<?=$this->url->mk('/cart')?>\'');
										return false;">
										<i class="fa fa-shopping-cart"></i> В корзину
									</button>
								<?} else {?>
									<button class="btn btn-theme m-b-1 form-control active focus added" type="button" data-prod-id="<?= $prod->id ?>" onclick="location.href='<?=$this->url->mk('/cart')?>'">
										<i class="fa fa-shopping-cart"></i> Добавлен
									</button>
								<?}?>
							</div>
						</div>
						<div class="productListing-data quantity">

						</div>
					</form>
				</div>
			</div>
		</div>

	<? } ?>
	<div class="clearfix">&nbsp;</div>
</div>
<!-- End Featured -->
<div class="clearfix">&nbsp;</div>