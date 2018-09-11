<?//print_r($this->prod);?>
<div class="row">
	<!-- Image List -->
	<div class="col-sm-4 prod-cont">
		<div class="image-detail">
			<img src="/pic/prod/<?= $this->prod->id ?>.jpg" data-zoom-image="/pic/prod/<?= $this->prod->id ?>.jpg" alt="<?= $this->prod->name ?>">
		</div>
		<? if ($this->prod->pop) { ?>
			<div class="pc-hot"></div>
		<? } ?>
		<? if ($this->prod->skidka) { ?>
			<div class="pc-skidka"><?="-".$this->prod->skidka."%" ?></div>
		<? } ?>
		<?	if($this->prod->new){?>
			<div class="pc-new"></div>
		<?	}?>
	</div>
	<!-- End Image List -->

	<div class="col-sm-8">
		<h1 class="title-detail"><?= $this->prod->name ?></h1>
		<table class="table table-detail">
			<tbody>
			<tr>
				<td class="productInfoKey">Модель:</td>
				<td class="productInfoValue"><span id="productInfoModel"><?= $this->prod->art ?></span></td>
			</tr>
			<tr>
				<td class="productInfoKey">Упаковка:</td>
				<td class="productInfoValue" id="inpack">
					<?	if($this->prod->num2 > 0 || $this->prod->num3 > 0){?>
						<select name="var" onchange="changepack(<?=$this->prod->id?>, this.value);">
							<?if($this->prod->num > 0){?>
								<option value="1"><?=$this->prod->inpack?></option>
							<?}?>
							<?if($this->prod->num2 > 0){?>
								<option value="2"><?=$this->prod->inpack2?></option>
							<?}?>
							<?if($this->prod->num3 > 0){?>
								<option value="3"><?=$this->prod->inpack3?></option>
							<?}?>
						</select>
					<?	}else{
						echo $this->prod->inpack;
					}?>
<?//print_r($this->cart->cart);?>
				</td>
			</tr>
			<tr>
				<td class="pc-num">
					
					<?
					if($this->prod->num3 > 0) $prodvar = 3;
					if($this->prod->num2 > 0) $prodvar = 2;
					if($this->prod->num > 0) $prodvar = 1;
					?>
					<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $this->prod->id ?>">
						<input type="hidden" name="id" value="<?= $this->prod->id ?>" />
						<input type="hidden" name="var" value="<?=$prodvar?>" id="prodvar<?=$this->prod->id?>" class="prodvar<?=$this->prod->id?>"/>
						<input type="hidden" name="ajax" value="1" class="ajax" />
						<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
						<?			if($this->prod->num > 0 || $this->prod->num2 > 0 || $this->prod->num3 > 0){?>
							<input type="text" maxlength="5" size="2" name="num" id="quantity<?= $this->prod->id ?>" value="1" onchange="check_num(<?=$this->prod->id?>, $('#prodvar<?=$this->prod->id?>').val(), $(this).val());" class="form-control text-center">
						<?			}else{?>
							Нет в наличии
						<?			}?>
					</form>
				</td>
				<td class="pc-buy">
					<?			if($this->prod->num > 0 || $this->prod->num2 > 0 || $this->prod->num3 > 0){?>
						<?if(!in_array($this->prod->id, $this->cartids)) {?>
							<button class="btn btn-theme m-b-1 active focus" type="button" data-prod-id="<?= $this->prod->id ?>" onmousedown="try { rrApi.addToBasket(<?=$this->prod->id?>) } catch(e) {}" onclick="
								buy(<?= $this->prod->id ?>);
								$(this).addClass('added');
								$(this).html('<i class=&quot;fa fa-shopping-cart&quot;></i> Добавлен');
								$(this).attr('onclick', 'location.href=\'<?=$this->url->mk('/cart')?>\'');
								return false;">
								<i class="fa fa-shopping-cart"></i> В корзину
							</button>
						<?} else {?>
							<button class="btn btn-theme m-b-1 active focus added" type="button" data-prod-id="<?= $this->prod->id ?>" onclick="location.href='<?=$this->url->mk('/cart')?>'">
								<i class="fa fa-shopping-cart"></i> Добавлен
							</button>
						<?}?>
					<?			}else{?>

					<?			}?>

				</td>
			</tr>
			<tr>
				<td class="productInfoKey">Вес:</td>
				<td>
					<table>
						<tr>
							<?$k = 0;
							if($this->prod->num > 0){?>
								<td class="productInfoValue prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar1" id="weight"><?= $this->prod->weight ?> г</td>
							<?}?>
							<?if($this->prod->num2 > 0){?>
								<td class="productInfoValue prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar2" id="weight"><?= $this->prod->weight2 ?> г</td>
							<?}?>
							<?if($this->prod->num3 > 0){?>
								<td class="productInfoValue prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar3" id="weight"><?= $this->prod->weight3 ?> г</td>
							<?}?>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="productInfoKey">Цена:</td>
				<td class="productInfoValue">
					<?$this->prodone = $this->prod;
					echo $this->render('catalog/prod-price.php');?>
				</td>
			</tr>
			<? if (!$this->prod->skidka && !$_SESSION['useropt']) { ?>
				<?
				$Discount = new Model_Discount();
				$discounts = $Discount->getall(array("order" => "value asc"));

				foreach ($discounts as $discount) {
					$k = 0;?>
			
					<?	if($this->prod->num > 0) {?>
					<tr style="color:grey;" class="prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar1">
						<td class="productInfoKey" style="text-align:right"><?= $discount->name ?>:</td>
						<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price * (100 - $discount->value) / 100) ?> <?= $this->valuta['name'] ?> <span style="padding-left:10px;"><?=$discount->value?>%</span></span></td>
					</tr>
					<?	}?>
					
					<?	if($this->prod->num2 > 0) {?>
					<tr style="color:grey;" class="prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar2">
						<td class="productInfoKey" style="text-align:right"><?= $discount->name ?>:</td>
						<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price2 * (100 - $discount->value) / 100) ?> <?= $this->valuta['name'] ?> <span style="padding-left:10px;"><?=$discount->value?>%</span></span></td>
					</tr>
					<?	}?>
					
					<?	if($this->prod->num3 > 0) {?>
					<tr style="color:grey;" class="prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar3">
						<td class="productInfoKey" style="text-align:right"><?= $discount->name ?>:</td>
						<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price3 * (100 - $discount->value) / 100) ?> <?= $this->valuta['name'] ?> <span style="padding-left:10px;"><?=$discount->value?>%</span></span></td>
					</tr>
					<?	}?>

				<? } ?>

			<? } ?>
			<?if(!$_SESSION['useropt']){?>
				<tr>
					<td colspan="2"><a href="/skidki">Дисконтная программа</a></td>
				</tr>
			<?}?>
			<?if (Model_User::userid()) {?>
				<tr>
					<td colspan="2">
						<form action="/user/wishlist/add/<?= $this->prod->id ?>" method="post" id="wishform_<?= $this->prod->id ?>">
							<input type="hidden" name="id" value="<?= $this->prod->id ?>" />
							<input type="hidden" name="var" value="<?=$prodvar?>" class="prodvar<?=$this->prod->id?>"/>
							<input type="hidden" name="ajax" value="1" class="ajax" />
							<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
							<button class="btn btn-theme m-b-1" type="button" onclick="wishlist(<?= $this->prod->id ?>); return false;"><i class="fa fa-heart"></i> В список желаний</button>
						</form>
					</td>
				</tr>
			<?}?>
			</tbody>
		</table>
	</div>

	<div class="col-md-12">

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#desc" aria-controls="desc" role="tab" data-toggle="tab">Описание</a></li>
			<li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">Характеристики</a></li>
			<!--<li role="presentation"><a href="#review" aria-controls="review" role="tab" data-toggle="tab">Reviews ()</a></li>-->
		</ul>
		<!-- End Nav tabs -->

		<!-- Tab panes -->
		<div class="tab-content tab-content-detail">

			<!-- Description Tab Content -->
			<div role="tabpanel" class="tab-pane active" id="desc">
				<div class="well">
					<?= $this->prod->cont ?>
				</div>
			</div>
			<!-- End Description Tab Content -->

			<!-- Detail Tab Content -->
			<div role="tabpanel" class="tab-pane" id="detail">
				<div class="well">
					<?=$this->render("catalog/prod-chars.php");?>
				</div>
			</div>
			<!-- End Detail Tab Content -->

			<!-- Review Tab Content -->
			<!--<div role="tabpanel" class="tab-pane" id="review">
				<div class="well">

				</div>
			</div>-->
			<!-- End Review Tab Content -->

		</div>
		<!-- End Tab panes -->

	</div>
</div>

<?=$this->render('catalog/prod-analog.php') ?>
<?=$this->render('catalog/prod-childs.php') ?>

<script type="text/javascript">
    (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() {
		try{ rrApi.view(<?=$this->prod->id?>); } catch(e) {}
	})
</script>
