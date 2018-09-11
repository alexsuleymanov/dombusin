<script type="text/javascript">
	var clicked = 0;
	
	function as_zoom(id){
		
		$("#prodpreview"+id).animate({"width": 400, "height": 400}, 400);
		
		if(clicked == 0){
			$("#prodpreview"+id).animate({"width": 400, "height": 400}, 400);
			$("#lupa").hide();
			clicked = 1;
		}else{
			clicked = 0;
			$("#prodpreview"+id).animate({"width": 192, "height": 192}, 400);
			$("#lupa").show();
		}
	}
</script>
<h1><?= $this->prod->name ?></h1>
<div>

	<div style="position: relative; float: left; text-align: center; padding: 0 10px 10px 0; width: 192px;" id="tovar-img<?=$this->prod->id?>">
		<? if ($this->prod->hit) { ?>
			<span style="position:absolute;margin-left:190px;z-index:10;display:block;"><img src="<?= $this->path ?>/img/hot.gif"></span>
		<? } ?>
<?/*		<a href="/pic/prod/<?= $this->prod->id ?>.jpg" rel="example1" title="<?= $this->prod->name ?>" class="nivoZoom2">*/?>
			<img src="/pic/prod/<?= $this->prod->id ?>.jpg" width="192" alt="<?= $this->prod->name ?>" id="prodpreview<?=$this->prod->id?>" style="position: absolute; margin-left: -90px; cursor: pointer;" onclick="as_zoom(<?=$this->prod->id?>);"/>
<?/*		</a>*/?>
		<? if ($this->prod->skidka) { ?>
			<div style="display:block; background:url(<?= $this->path ?>/img/discount.png) no-repeat; position:absolute; top: -10px; left: 160px; width:50px; text-align:center;padding:17px 0 19px 0;color:#ffffff;font-size:14px; font-weight: bold;"><?="-".$this->prod->skidka."%" ?></div>
		<? } ?>
		<?	if($this->prod->changed > (time() - 45*86400)){?>
			<div class="new"></div>
		<?	}?>

			<div href="" class="lupa-plus"><img src="<?=$this->path?>/img/lupa-plus.png" id="lupa" style="cursor: pointer;" onclick="as_zoom(<?=$this->prod->id?>);" /></div>
	</div>

	<div style="margin-left: 252px; min-height: 144px;">
		<table border="0" cellspacing="0" cellpadding="5px">
			<tr>
				<td class="productInfoKey"  style="text-align:right">Упаковка:</td>
				<td class="productInfoValue" id="inpack">
					<?	if($this->prod->num2 || $this->prod->num3){?>
					<select name="var" onchange="changepack(<?=$this->prod->id?>, this.value);">
						<?if($this->prod->num){?>
						<option value="1"><?=$this->prod->inpack?></option>
						<?}?>
						<?if($this->prod->num2){?>
						<option value="2"><?=$this->prod->inpack2?></option>
						<?}?>
						<?if($this->prod->num3){?>
						<option value="3"><?=$this->prod->inpack3?></option>
						<?}?>
					</select>
					<?	}else{
							echo $this->prod->inpack;
						}?>
					
				</td>
			</tr>
			<tr>
				<td class="productInfoKey"  style="text-align:right">Вес:</td>
				<?$k = 0;
					if($this->prod->num){?>
				<td class="productInfoValue prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar1" id="weight"><?= $this->prod->weight ?> г</td>
				<?}?>
				<?if($this->prod->num2){?>
				<td class="productInfoValue prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar2" id="weight"><?= $this->prod->weight2 ?> г</td>
				<?}?>
				<?if($this->prod->num3){?>
				<td class="productInfoValue prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar3" id="weight"><?= $this->prod->weight3 ?> г</td>
				<?}?>
			</tr>
<?			if($_COOKIE['userdiscount'] && $this->prod->skidka == 0){
				$k = 0;?>
			<?if($this->prod->num){?>
			<tr class="<?=$this->prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar1">
				<td class="productInfoKey"  style="text-align:right"><s>Цена:</s></td>
				<td class="productInfoValue"><span id="productInfoPrice"><s><?= Func::fmtmoney($this->prod->price)?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack ?></s></span> <?= Func::fmtmoney($this->prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack ?></span></td>
			</tr>
			<tr class="<?=$this->prod->id?>prodvar prodvar prodvar<?=$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar1">
				<td class="productInfoKey"  style="text-align:right; color: red;">Ваша цена:</td>
				<td class="productInfoValue"><span id="productInfoPrice" style="color: red;"><?= Func::fmtmoney($this->prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack ?></span></td>
			</tr>
			<?}?>
			<?if($this->prod->num2){?>
			<tr class="<?=$this->prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar2">
				<td class="productInfoKey"  style="text-align:right"><s>Цена:</s></td>
				<td class="productInfoValue"><span id="productInfoPrice"><s><?= Func::fmtmoney($this->prod->price2)?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack ?></s></span> <?= Func::fmtmoney($this->prod->price2 * (100 - $_COOKIE['userdiscount']) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack2 ?></span></td>
			</tr>
			<tr class="<?=$this->prod->id?>rodvar prodvar prodvar<?=$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar2">
				<td class="productInfoKey"  style="text-align:right; color: red;">Ваша цена:</td>
				<td class="productInfoValue"><span id="productInfoPrice" style="color: red;"><?= Func::fmtmoney($this->prod->price2 * (100 - $_COOKIE['userdiscount']) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack2 ?></span></td>
			</tr>
			<?}?>
			<?if($this->prod->num3){?>
			<tr class="<?=$this->prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar3">
				<td class="productInfoKey"  style="text-align:right"><s>Цена:</s></td>
				<td class="productInfoValue"><span id="productInfoPrice"><s><?= Func::fmtmoney($this->prod->price3)?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack3 ?></s></span> <?= Func::fmtmoney($this->prod->price3 * (100 - $_COOKIE['userdiscount']) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack3 ?></span></td>
			</tr>
			<tr class="<?=$this->prod->id?>prodvar prodvar prodvar<?=$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar3">
				<td class="productInfoKey"  style="text-align:right; color: red;">Ваша цена:</td>
				<td class="productInfoValue"><span id="productInfoPrice" style="color: red;"><?= Func::fmtmoney($this->prod->price3 * (100 - $_COOKIE['userdiscount']) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack3 ?></span></td>
			</tr>
			<?}?>

<?			}elseif($this->prod->skidka != 0){?>
			<tr>
				<td class="productInfoKey"  style="text-align:right">Цена:</td>
				<td class="productInfoValue"><span id="productInfoPrice"><s><?= Func::fmtmoney($this->prod->price)?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack ?></s></span> <span id="productInfoPrice" style="color: red;"><?= Func::fmtmoney($this->prod->price * (100 - $this->prod->skidka) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack ?></span></td>
			</tr>
<?			}else{
				$k = 0;
?>
			<?if($this->prod->num){?>
			<tr class="prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar1">
				<td class="productInfoKey"  style="text-align:right">Цена:</td>
				<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price * (100 - $this->prod->skidka) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack ?></span></td>
			</tr>
			<?}?>
			<?if($this->prod->num2){?>
			<tr class="prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar2">
				<td class="productInfoKey"  style="text-align:right">Цена:</td>
				<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price2 * (100 - $this->prod->skidka) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack2 ?></span></td>
			</tr>
			<?}?>
			<?if($this->prod->num3){?>
			<tr class="prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar3">
				<td class="productInfoKey"  style="text-align:right">Цена:</td>
				<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price3 * (100 - $this->prod->skidka) / 100) ?> <?= $this->valuta['name'] ?> / <?= $this->prod->inpack3 ?></span></td>
			</tr>
			<?}?>
<?			}?>
			
			<? if (!$this->prod->skidka) { ?>
				<?
				$Discount = new Model_Discount();
				$discounts = $Discount->getall(array("order" => "value asc"));
				
				foreach ($discounts as $discount) {
					$k = 0;
					?>
					<tr style="color:grey;" class="prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar1">
						<td class="productInfoKey" style="text-align:right"><?= $discount->name ?>:</td>
						<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price * (100 - $discount->value) / 100) ?> <?= $this->valuta['name'] ?> <span style="padding-left:10px;"><?=$discount->value?>%</span></span></td>
					</tr>
					<tr style="color:grey;" class="prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar2">
						<td class="productInfoKey" style="text-align:right"><?= $discount->name ?>:</td>
						<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price2 * (100 - $discount->value) / 100) ?> <?= $this->valuta['name'] ?> <span style="padding-left:10px;"><?=$discount->value?>%</span></span></td>
					</tr>
					<tr style="color:grey;" class="prodvar prodvar<?=++$k?> <?=$this->prod->id?>prodvar <?=$this->prod->id?>prodvar3">
						<td class="productInfoKey" style="text-align:right"><?= $discount->name ?>:</td>
						<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price3 * (100 - $discount->value) / 100) ?> <?= $this->valuta['name'] ?> <span style="padding-left:10px;"><?=$discount->value?>%</span></span></td>
					</tr>

				<? } ?>

			<? } ?>
			<tr>
				<td colspan="2"><a href="/skidki">Дисконтная программа</a></td>
			</tr>
		</table>

		<div style="margin-top: 10px; float: left;">
			<?
				if($this->prod->num3) $prodvar = 3;
				if($this->prod->num2) $prodvar = 2;
				if($this->prod->num) $prodvar = 1;
			?>
			<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $this->prod->id ?>">
				<input type="hidden" name="id" value="<?= $this->prod->id ?>" />
				<input type="hidden" name="var" value="<?=$prodvar?>" id="prodvar<?=$this->prod->id?>"/>
				<input type="hidden" name="ajax" value="1" class="ajax" />
				<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />

<?			if($this->prod->num > 0 || $this->prod->num2 > 0 || $this->prod->num3 > 0){?>
				<input type="text" maxlength="5" size="2" name="num" id="quantity<?= $this->prod->id ?>" value="1" onchange="check_num(<?=$this->prod->id?>, $('#prodvar<?=$this->prod->id?>').val(), $(this).val());">
				<input type="image" src="<?=$this->path?>/img/bbuy.png" src="<?=$this->path?>/img/bbuy.png" onclick="_gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']); buy(<?= $this->prod->id ?>); return false;" style="margin: 0 0 0 20px; vertical-align: middle">
<?			}else{?>
				Нет в наличии
<?			}?>
			</form>

			<?if (isset($_COOKIE['userid'])) {?>
			<form action="/user/wishlist/add/<?= $this->prod->id ?>" method="post" id="wishform_<?= $this->prod->id ?>">
				<input type="hidden" name="id" value="<?= $this->prod->id ?>" />
				<input type="hidden" name="var" value="<?= $prodvar ?>" />
				<input type="hidden" name="ajax" value="1" class="ajax" />
				<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $this->prod->id ?>); return false;" class="awl"><img src="<?=$this->path?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний</a>
			</form>
			<?}?>
			
			<br /><br />
			<?=$this->render("catalog/prod-chars.php");?>

			<br /><br /><br />
<?/*			<div style="margin: 25px 0 5px 0;" id="vk_like"></div>
			<script type="text/javascript">
				VK.Widgets.Like("vk_like", {type: "button", height: 24});
			</script>

			<div style="margin-bottom:5px;" class="fb-like" data-href="http://dombusin.com" data-send="true" data-layout="button_count" data-width="200" data-show-faces="false"></div>

			<a target="_blank" class="mrc__plugin_uber_like_button" href="http://connect.mail.ru/share" data-mrc-config="{'cm' : '1', 'ck' : '3', 'sz' : '20', 'st' : '2', 'tp' : 'combo'}">Нравится</a>
			<script src="<?= $this->path ?>/js/loader00.js" type="text/javascript" charset="UTF-8"></script>
*/?>
		</div>
		<!-- nikita_end -->
	</div>
</div>


<div style="clear: both;"></div>

<table border="0" cellspacing="0" cellpadding="0">


	<tr>
		<td class="productInfoKey">Модель:</td>
		<td class="productInfoValue"><span id="productInfoModel"><?= $this->prod->art ?></span></td>
	</tr>


</table>


<div>
	<?= $this->prod->cont ?>
</div>

<br>
<?//=$this->render('catalog/skidki.php')?>

<div class="submitFormButtons" style="text-align: right;">


</div>

<div class="clear"></div>

<div class="new_post">
	<div class="head_mod"><p>Похожие товары</p></div>
	<div class="content_border">
		<?=$this->render('catalog/prod-analog.php') ?>
		<div class="clear"></div>
	</div>
</div>

<div class="clear"></div>

<div class="new_post">
	<div class="head_mod"><p>Клиенты, купившие этот товар, также покупают</p></div>
	<div class="content_border">
		<?=$this->render('catalog/prod-childs.php') ?>
		<div class="clear"></div>
	</div>
</div>

