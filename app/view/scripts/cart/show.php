<div>
	<table class="table table-bordered table-cart" style="width: 100%; border-collapse: collapse;" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;"><?= $this->labels["photo"] ?></th>
			<th style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;"><?= $this->labels['title'] ?></th>
			<th style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;"><?= $this->labels['price'] ?></th>
			<th style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;"><?= $this->labels['quantity'] ?></th>
			<th style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;">Сумма</th>
		</tr>
		</thead>
		<tbody>
		<?
		$n = $sum = 0;
		$total_weight = 0;

		foreach ($this->cart->cart as $k => $v) {
			$Prod = new Model_Prod($v['id']);
			$prod = $Prod->get($v['id']);
			$host = ($_SERVER['HTTPS']) ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST'];
			$title = "<a href=\"".$host."/catalog/prod-" . $prod->id . "\" target=\"_blank\">" . $prod->name . "</a>";
			$price = $prod->price;
			$skidka = $prod->skidka;
			$weight = $prod->weight;
			$inpack = $prod->inpack;

			if($v['var'] == 2){
				$price = $prod->price2;
				$skidka = $prod->skidka2;
				$weight = $prod->weight2;
				$inpack = $prod->inpack2;
			}

			if($v['var'] == 3){
				$price = $prod->price3;
				$skidka = $prod->skidka3;
				$weight = $prod->weight3;
				$inpack = $prod->inpack3;
			}
			?>
			<tr class="ce<?= $w++ % 2 ?>"<?if($w%2==1){?> style="background: #f2f2f2"<?}?> valign="top">
				<td align="center" style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;"><img src="<?=$host?>/pic/prod/<?= $v['id'] ?>.jpg" width="100" alt=""></td>
				<td class="cet" style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;">
					<input type="hidden" name="id_<?= $k ?>" value="<?= $v['id'] ?>">
					<?= $title ?>
					<br><br>
					<div class="clear"></div>
					<div class="cet2" style="float: left; width: 150px;">Упак.: <?= $inpack ?></div>
					<div class="cet2" style="float: left; width: 150px;">Вес упак.: <?= $weight ?> г</div>
					<?$total_weight += $weight * $v['num']?>
					<div class="clear"></div>
				</td>
				<td class="cep" style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;"><?=Func::fmtmoney($v['price'])." ".$this->valuta['name']?></td>
				<td align="center" style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;"><?= $v['num'] ?></td>
				<td class="cep" style="border: 1px solid #ddd; text-align: left; color: #666; padding: 8px;"><?=Func::fmtmoney($v['price'] * $v['num'])." ".$this->valuta['name']?></td>
			</tr>
		<? } ?>
		</tbody>
	</table>
</div>

<div style="margin-top: 1em;">
	<table cellpadding="0" cellspacing="0" style="float: right; width: 300px;">
		<tr valign="top" id="cart_sum_row" <?if($this->cart->amount() == $this->cart->amount_without_discount()) echo "style=\"display: none;\""?>>
			<td width="150" align="right"><b style="color: #666">Сумма</b></td><td width="6" align="center"> : </td><td width="100" aligh="right" style="color: red; text-align: right;"><span class="cart_amount"><?= Func::fmtmoney($this->cart->amount_without_discount())?></span> <?= $this->valuta['name'] ?></td>
		</tr>
		<tr valign="top" id="cart_skidka_row" <?if($this->cart->amount_without_discount() - $this->cart->amount() == 0) echo "style=\"display: none;\""?>>
			<td width="150" align="right"><b style="color: #666">Скидка</b></td><td width="6" align="center"> : </td><td width="100" aligh="right" style="color: red; text-align: right;"><span class="cart_skidka"><?= Func::fmtmoney($this->cart->amount_without_discount() - $this->cart->amount()) ?></span> <?= $this->valuta['name'] ?></td>
		</tr>
		<tr valign="top" class="ce8">
			<td width="150" align="right"><b style="color: #666">К оплате</b></td><td width="6" align="center"> : </td><td width="100" aligh="right" style="color: red; text-align: right;"><span class="cart_to_pay"><?= Func::fmtmoney($this->cart->amount()) ?></span> <?= $this->valuta['name'] ?></td>
		</tr>
	</table>

	<table cellpadding="0" cellspacing="0" style="float: right; width: 300px;">
		<tr valign="top">
			<td width="150" align="right"><b style="color: #666">Количество товаров</b></td><td width="6" align="center"> : </td><td width="100" aligh="right" style="text-align: right; color: #666"><span class="cart_num"><?= $this->cart->prod_num() ?></span></td>
		</tr>
		<tr valign="top">
			<td width="150" align="right"><b style="color: #666">Упаковок</b></td><td width="6" align="center"> : </td><td width="100" aligh="right" style="text-align: right; color: #666"><span class="cart_packs"><?= $this->cart->pack_num() ?></span></td>
		</tr>
		<tr valign="top">
			<td width="150" align="right"><b style="color: #666">Общий вес</b></td><td width="6" align="center"> : </td><td width="100" aligh="right" style="text-align: right; color: #666"><span class="cart_weight"><?= $this->cart->weight() ?></span> г</td>
		</tr>
	</table>
</div>