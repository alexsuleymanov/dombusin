<?
$order = $this->order->get();
$Order = new Model_Order($order->id);
?>
<h1>Заказ №<?= $this->order->id ?></h1>


<span style="float: right;">Итого заказ: <?= Func::fmtmoney($sum2) . $this->sett["valuta"] ?></span>

<p>Дата заказа: <?= date("d.m.Y", $order->tstamp) ?> <br>
	Статус: <?switch($order->status) {
		case 1: echo 'Отправлен'; break;
		case 2: echo 'Собран'; break;
		case 3: echo 'Доставлен'; break;
		case 4: echo 'Обрабатывается'; break;
		case 5: echo 'Собирается'; break;
		case 6: echo 'Отменен'; break;
		case 7: echo 'Оплачен'; break;
		default: echo 'Неизвестен'; break;
	}?></p>

<p><b>Адрес доставки</b></p>

<p>
	<?=$this->user->surname?$this->user->surname.'<br>':''?>
	<?=$this->user->name?$this->user->name.'<br>':''?>
	<?=$this->user->country?$this->user->country.'<br>':''?>
	<?=$this->user->city?$this->user->city.'<br>':''?>
	<?=$this->user->address?$this->user->address.'<br>':''?>
</p>

<p><b>Метод оплаты</b></p>

<?
$PM = new Model_Esystem();
$method = $PM->get($order->payment_method);
?>
<p><?=$method->name?></p>

<div>
	<table class="table table-bordered table-cart table-order">
		<thead>
		<tr>
			<th align="center" class="ce-wide">Изображение</th>
			<th align="center" class="ce-wide">Наименование</th>
			<th align="center">Цена</th>
			<th align="center">Кол-во</th>
			<th align="center">Стоимость</th>
		</tr>
		</thead>
		<tbody>

		<?
		$w = 0;
		$Prod = new Model_Prod();
		$total_weight = 0;
		$sum = 0;
		foreach ($this->prods as $v) {
			$prod = $Prod->get($v['id']);

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

			$total_weight += $weight * $v['num'];
			?>
			<tr class="ce-tight ce<?= $w % 2 ?>">
				<td align="center">
					<a href="/catalog/prod-<?= $prod->id ?>"><img src="/thumb?src=pic/prod/<?= $v['id'] ?>.jpg&width=100" alt="<?=$prod->name?>"></a>
				</td>
				<td colspan="2">
					<a href="/catalog/prod-<?= $prod->id ?>" style="display:block;"><?=$prod->name?></a>
					<span class="weight">Вес: &nbsp;<?=$weight?> г&nbsp;</span>
				</td>
			</tr>
			<tr class="ce<?= $w++ % 2 ?>">
				<td align="center" class="ce-wide">
					<a href="/catalog/prod-<?= $prod->id ?>"><img src="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&width=100" alt="<?=$prod->name?>"></a>
				</td>
				<td class="ce-wide">
					<a href="/catalog/prod-<?= $prod->id ?>" style="display:block;"><?=$prod->name?></a>
					<span class="weight">Вес: &nbsp;<?=$weight?> г&nbsp;</span>
				</td>
				<td align="center">
					<?if($v['price'] != $v['baseprice']){?>
					<s>Цена: <?=Func::fmtmoney($v['baseprice'])?>&nbsp;<?= $this->valuta['name'] ?></s><br> Ваша цена: <?=Func::fmtmoney($v['price'])?>&nbsp;<?= $this->valuta['name'] ?>
					<?}else{?>
					Цена: <?=Func::fmtmoney($v['price'])?>&nbsp;<?= $this->valuta['name'] ?>
					<?}?>
				</td>	
				<td align="center"><?=$v['num']?></td>

				</td>
				<td align="center" ><span style="color:red;"><?=Func::fmtmoney($v['price']*$v['num'])?>&nbsp;<?= $this->valuta['name'] ?></span></td>
			</tr>
		<? } ?>
		</tbody>
	</table>

	<p>&nbsp;</p>

	<table border="0" width="100%" cellspacing="0" cellpadding="2">
		<tr>
			<td width="80%" align="right">Общий вес:</td>
			<td align="right"><?=$total_weight?> г</td>
		</tr>
		<tr>
			<td align="right">Стоимость:</td>
			<td align="right"><?=Func::fmtmoney($this->order->cart->amount_without_discount())?>&nbsp;<?= $this->valuta['name'] ?></td>
		</tr>
		<tr>
			<td align="right">Скидка:</td>
			<td align="right"><?=Func::fmtmoney($this->order->cart->amount_without_discount() - $this->order->cart->amount())?>&nbsp;<?= $this->valuta['name'] ?></td>
		</tr>
		<tr>
			<td align="right">Итого:</td>
			<td align="right"><b><?=Func::fmtmoney($this->order->cart->amount())?>&nbsp;<?= $this->valuta['name'] ?></b></td>
		</tr>
	</table>

</div>



<div class="submitFormButtons">
	<button id="button1" type="button" onclick="document.location.href='/<?=$this->args[0]?>/<?=$this->args[1]?>';" class="btn btn-theme">Назад</button></div>

<div class="clear"></div>
