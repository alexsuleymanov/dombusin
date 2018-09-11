<h1>Корзина</h1>
<div>
	<div>
		<table class="table table-bordered table-cart">
			<thead>
			<tr>
				<th><?= $this->labels["photo"] ?></th>
				<th><?= $this->labels['title'] ?></th>
				<th><?= $this->labels['quantity'] ?></th>
				<th><?= $this->labels['price'] ?></th>
			</tr>
			</thead>
			<tbody>
			<?
			$n = $sum = 0;
			$total_weight = 0;

			foreach ($this->cart->cart as $k => $v) {
				$Prod = new Model_Prod($v['id']);
				$prod = $Prod->get();
				$title = "<a href=\"/catalog/prod-" . $prod->id . "\" target=\"_blank\">" . $prod->name . "</a>";
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
				<tr class="ce<?= $w++ % 2 ?>">
					<td align="center"><img src="https://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?= $v['id'] ?>.jpg" width="100" alt=""></td>
					<td class="cet">
						<input type="hidden" name="id_<?= $k ?>" value="<?= $v['id'] ?>">
						<?= $title ?>
						<br><br>
						<div class="clear"></div>
						<div class="cet2" style="float: left; width: 150px;">В упаковке: <?= $inpack ?></div>
						<div class="cet2" style="float: left; width: 150px;">Вес: <?= $weight ?> г</div>
						<?$total_weight += $weight * $v['num']?>
						<div class="clear"></div>
					</td>
					<td align="center"><?= $v['num'] ?></td>
					<td class="cep"><?=Func::fmtmoney($v['price'] * $v['num'])." ".$this->valuta['name']?></td>
				</tr>
			<? } ?>
			</tbody>
		</table>
	</div>
	
	<div style="text-align: right; padding-right: 20px;">
		<table cellpadding="0" cellspacing="0" style="float: right; width: 300px;">
			<tr valign="top" id="cart_sum_row" <?if($this->cart->amount() == $this->cart->amount_without_discount()) echo "style=\"display: none;\""?>>
				<td width="150" align="right"><b>Сумма</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_amount"><?= Func::fmtmoney($this->cart->amount_without_discount())?></span> <?= $this->valuta['name'] ?></td>
			</tr>
			<tr valign="top" id="cart_skidka_row" <?if($Cart->sum - $Cart->to_pay == 0) echo "style=\"display: none;\""?>>
				<td width="150" align="right"><b>Скидка</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_skidka"><?= Func::fmtmoney($this->cart->amount_without_discount() - $this->cart->amount()) ?></span> <?= $this->valuta['name'] ?></td>
			</tr>
			<tr valign="top" class="ce8">
				<td width="150" align="right"><b>К оплате</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_to_pay"><?= Func::fmtmoney($this->cart->amount()) ?></span> <?= $this->valuta['name'] ?></td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" style="float: right; width: 300px;">
			<tr valign="top">
				<td width="150" align="right"><b>Количество товаров</b></td><td width="6" align="center"> : </td><td width="100" aligh="left"><span class="cart_num"><?= $this->cart->prod_num() ?></span></td>
			</tr>
			<tr valign="top">
				<td width="150" align="right"><b>Упаковок</b></td><td width="6" align="center"> : </td><td width="100" aligh="left"><span class="cart_packs"><?= $this->cart->pack_num() ?></span></td>
			</tr>
			<tr valign="top">
				<td width="150" align="right"><b>Общий вес</b></td><td width="6" align="center"> : </td><td width="100" aligh="left"><span class="cart_weight"><?= $this->cart->weight() ?></span> г</td>
			</tr>
		</table>
	</div>