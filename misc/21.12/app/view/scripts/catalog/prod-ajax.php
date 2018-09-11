<div style="width: 250px; height: 250px;"><img src="/pic/prod/<?= $this->prod->id ?>.jpg" width="245" alt="<?= $this->prod->name ?>"></a></div>

<?/*<h1><?= $this->prod->name ?></h1>
<div style="float: left; width: 250px;"><img src="/thumb?src=pic/prod/<?= $this->prod->id ?>.jpg&amp;width=192&amp;height=192" alt="<?= $this->prod->name ?>"></a></div>

<div style="float: left; width: 250px;">
		<table border="0" cellspacing="0" cellpadding="5px">
			<tr>
				<td class="productInfoKey" style="text-align: right;"><?if($_COOKIE['userdiscountlevel'] && !$this->prod->skidka){?><s>Цена:</s><?}else{?>Цена:<?}?></td>
				<td class="productInfoValue">
	<? if ($this->prod->skidka) { ?>
					<font style="text-decoration: line-through;"><?= Func::fmtmoney($this->prod->price) ?>&nbsp;<?= $this->valuta['name'] ?></font>
					<span style="display:block;"><span style="color:red;"><?= Func::fmtmoney($this->prod->price - $this->prod->price * $this->prod->skidka / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span></span>
	<? } else { ?>
					<span style="display:block;float:left;"><?if($_COOKIE['userdiscountlevel']){?><s><?= Func::fmtmoney($this->prod->price) ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;</s><?}else{?><?= $this->prod->price ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;<?}?></span>
	<? } ?>
				</td>
			</tr>
			<tr>
				<td class="productInfoKey" style="text-align:right;">Кол-во:</td>
				<td class="productInfoValue"><?= $this->prod->inpack ?></td>
			</tr>
			<tr>
				<td class="productInfoKey" style="text-align:right;">Вес:</td>
				<td class="productInfoValue"><?= $this->prod->weight ?> г</td>
			</tr>
			<? if (!$this->prod->skidka) { ?>
				<?
				$Discount = new Model_Discount();
				$discounts = $Discount->getall(array("order" => "value asc"));
				foreach ($discounts as $discount) {
					?>
					<tr style="color:<?=($discount->id == $_COOKIE['userdiscountlevel']) ? "red": "grey";?>">
						<td class="productInfoKey" style="text-align:right"><?= $discount->name ?>:</td>
						<td class="productInfoValue"><span id="productInfoPrice"><?= Func::fmtmoney($this->prod->price * (100 - $discount->value) / 100) ?> <?= $this->valuta['name'] ?> <span style="padding-left:10px;"><?=$discount->value?>%</span></span></td>
					</tr>
				<? } ?>

			<? }else{?>
			   <tr><td><br /><br /><br /><br /><br /><br /></td><td><br /><br /><br /><br /><br /><br /></td></tr>
			<? } ?>


		</table>

</div>
<div style="clear: both;"></div>
*/?>