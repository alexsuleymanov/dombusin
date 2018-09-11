<h1>Корзина</h1>
	<div class="ycart">
		<?
		$opt = Zend_Registry::get('opt');
		$Cart = new Model_Cart();

		$Cart->recount();

		if ($_COOKIE['userid']) {
			$Discount = new Model_Discount();
			$Order = new Model_Order();

			$order_total = $Order->total($_COOKIE['userid']);
			$dictounts = $Discount->getall();
			$discount = $Discount->getnakop($view->order_total);
			$nextdiscount = $Discount->nextdiscount($view->order_total);
			$tonextdiscount = $Discount->tonextdiscount($view->order_total);
		}

		foreach ($this->cart->cart as $k => $v)
			if ($v[num] < 1)
				$this->cart->cart[$k][num] = 1;
		?>

		<table width="906" border="0" cellspacing="0" cellpadding="0" class="xcart">

			<tr style="background-color: #f2f2f2;">
				<td width="110" align="center" style="border:1px solid #fff;"><b><?= $this->labels["photo"] ?></b></td>
				<td width="562" align="center" style="border:1px solid #fff;"><b><?= $this->labels['title'] ?></b></td>
				<td width="90" align="center" style="border:1px solid #fff;"><b><?= $this->labels['quantity'] ?></b></td>
				<td width="50" align="center" style="border:1px solid #fff;"><b><?= $this->labels['price'] ?></b></td>
			</tr>
			<?
			$n = $sum = 0;
			$total_weight=0;

			foreach ($this->cart->cart as $k => $v) {
				$Prod = new Model_Prod($v['id']);
				$prod = $Prod->get();
				$title = "<a href=\"/catalog/prod-" . $prod->id . "\" target=\"_blank\">" . $prod->name . "</a>";

				$price = $prod->price;
				$weight = $prod->weight;
				$inpack = $prod->inpack;
					
				if($v['var'] == 2){
					$price = $prod->price2;
					$weight = $prod->weight2;
					$inpack = $prod->inpack2;
				}
					
				if($v['var'] == 3){
					$price = $prod->price3;
					$weight = $prod->weight3;
					$inpack = $prod->inpack3;
				}	
					
				$sum += ($v['var']) ? $v['price'] * $v['num'] : $v['price'] * $v['num'];
				if ($discount)
					$sum2 = $sum - ($sum * $discount) / 100;
				else
					$sum2 = $sum;
				?>
				<tr class="ce<?= $w++ % 2 ?>">
					<td align="center"><img src="http://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?= $v['id'] ?>.jpg" width="100" alt="" /></td>
					<td class="cet">
						<input type="hidden" name="id_<?= $k ?>" value="<?= $v['id'] ?>">
						<?= $title ?>
						<div class="cet1">В упаковке: <?= $inpack ?></div>
						<div class="cet2">Вес: <?= $weight ?> г</div>
						<?$total_weight += $weight * $v['num']?>
						<div class="clear"></div>
					</td>
					<td align="center"><?= $v['num'] ?></td>
					<td class="cep"><?=($v['skidka']) ? Func::fmtmoney(($v['price'] - $v['price']*$v['skidka']/100)*$v['num'])." ".$this->valuta['name'] : Func::fmtmoney($v['price'] * (100 - $_COOKIE['userdiscount'])/100 * $v['num'])." ".$this->valuta['name'] ?></td>
				</tr>
			<? } ?>
			<tr>
		</table>
	</div>

<?	$Cart->recount();?>

<div style="text-align: right; padding-right: 20px;">
			<table cellpadding="0" cellspacing="0" style="float: right; width: 250px;">
				<tr valign="top" id="cart_sum_row" <?if($Cart->sum - $Cart->to_pay == 0) echo "style=\"display: none;\""?>>
					<td width="150" align="right"><b>Сумма</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_amount"><?= Func::fmtmoney($Cart->sum)?></span> <?= $this->valuta['name'] ?></td>
				</tr>
				<tr valign="top" id="cart_skidka_row" <?if($Cart->sum - $Cart->to_pay == 0) echo "style=\"display: none;\""?>>
					<td width="150" align="right"><b>Скидка</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_skidka"><?= Func::fmtmoney($Cart->sum - $Cart->to_pay) ?></span> <?= $this->valuta['name'] ?></td>
				</tr>
				<tr valign="top" class="ce8">
					<td width="150" align="right"><b>К оплате</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_to_pay"><?= Func::fmtmoney($Cart->to_pay) ?></span> <?= $this->valuta['name'] ?></td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" style="float: right; width: 250px;">
				<tr valign="top">
					<td width="150" align="right"><b>Количество товаров</b></td><td width="6" align="center"> : </td><td width="100" aligh="left"><span class="cart_num"><?= $Cart->prod_num() ?></span></td>
				</tr>
				<tr valign="top">
					<td width="150" align="right"><b>Упаковок</b></td><td width="6" align="center"> : </td><td width="100" aligh="left"><span class="cart_packs"><?= $Cart->pack_num() ?></span></td>
				</tr>
				<tr valign="top">
					<td width="150" align="right"><b>Общий вес</b></td><td width="6" align="center"> : </td><td width="100" aligh="left"><span class="cart_weight"><?= $Cart->weight() ?></span> г</td>
				</tr>
			</table>
		</div>