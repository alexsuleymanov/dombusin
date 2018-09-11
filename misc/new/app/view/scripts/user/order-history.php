<h1>Мои заказы</h1>
<table class="table table-bordered table-cart table-order">
	<thead>
	<tr>
		<th align="center">Заказ №</th>
		<th align="center">Дата заказа</th>
		<th align="center">Статус</th>
		<th align="center" class="ce-wide">Сумма заказа</th>
		<th align="center" class="ce-wide">Действия</th>
	</tr>
	</thead>
	<tbody>
	<?
	foreach ($this->orders as $order) {
		$Order = new Model_Order($order->id);
		$sum2 = $Order->cart->amount();
		?>
		<tr class="ce<?= $w % 2 ?>">
			<td align="center"><a href="/<?= $this->args[0] ?>/<?= $this->args[1] ?>/<?= $order->id ?>"><?= $order->id ?></a></td>
			<td align="center"><?= date("d.m.Y", $order->tstamp) ?></td>
			<td align="center">
				<?
				switch ($order->status) {
					case 1: echo 'Отправлен';
						break;
					case 2: echo 'Собран';
						break;
					case 3: echo 'Доставлен';
						break;
					case 4: echo 'Обрабатывается';
						break;
					case 5: echo 'Собирается';
						break;
					case 6: echo 'Отменен';
						break;
					case 7: echo 'Оплачен';
						break;
					default: echo 'Неизвестен';
						break;
				}
				?>
			</td>
			<td class="ce-wide" align="center"><span style="color:#990100;"><?= Func::fmtmoney($sum2) . $this->sett["valuta"] ?></span></td>
			<td class="ce-wide" align="center">
				<a href="/<?= $this->args[0] ?>/<?= $this->args[1] ?>/<?= $order->id ?>"  class="btn btn-theme m-b-1">Смотреть</a>
			</td>
		</tr>
		<tr class="ce-tight ce<?= $w++ % 2 ?>">
			<td colspan="2" align="center"><span style="color:#990100;"><?= Func::fmtmoney($sum2) . $this->sett["valuta"] ?></span></td>
			<td align="center"><a href="/<?= $this->args[0] ?>/<?= $this->args[1] ?>/<?= $order->id ?>"  class="btn btn-theme">Смотреть</a></td>
		</tr>

	<? } ?>
	</tbody>
</table>
<?/*
if ($this->ocnt % $this->oresults == 0)
	$count = floor($this->ocnt / $this->oresults);
else
	$count = floor($this->ocnt / $this->oresults + 1);
?>
<?/*
<div class="listingPageLinks">
	<span style="float: right;">&nbsp;Страница <?=$this->ostart/$this->oresults+1?> из <?= $count ?>&nbsp;</span>

	Показано <b><?= count($this->orders) ?></b> из <b><?= $this->ocnt ?></b> (из <b></b> заказов)</div>
*/?>


<?= $this->render('rule.php') ?>
<div class="submitFormButtons">
	<button id="button1" type="button" onclick="document.location.href='/<?= $this->args[0] ?>';" class="btn btn-theme">Назад</button></div>

<div class="clear"></div>
<br><br>