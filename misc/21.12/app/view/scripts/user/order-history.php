<h1>Мои заказы</h1>
<table class="bt11" width="100%" style="border: 1px solid #D2D2D2;">
	<tr style="background-color:#F2F2F2;">
		<td style="border:1px solid #fff;padding:10px 0;" align="center">Заказ №</td>
		<td style="border:1px solid #fff;padding:10px 0;" align="center">Дата заказа</td>
		<td style="border:1px solid #fff;padding:10px 0;" align="center">Статус</td>
		<td style="border:1px solid #fff;padding:10px 0;" align="center">Сумма заказа</td>
		<td style="border:1px solid #fff;padding:10px 0;" align="center">Действия</td>
	</tr>
	<?
	foreach ($this->orders as $order) {
		$Order = new Model_Order($order->id);
/*		$Discount = new Model_Discount();
		$discount = $Discount->getnakop($Order->total($_COOKIE['userid']));
		$sum = $Order->ordersum($order->id);
		$sum2 = $sum - ($sum * $discount / 100);
*/
		$Order->recount();
		$sum2 = $Order->to_pay;
		?>
		<tr>
			<td style="border:1px solid #F2F2F2;" height="59" align="center"><a href="/<?= $this->args[0] ?>/<?= $this->args[1] ?>/<?= $order->id ?>"><?= $order->id ?></a></td>
			<td style="border:1px solid #F2F2F2;" align="center"><?= date("d.m.Y", $order->tstamp) ?></td>
			<td style="border:1px solid #F2F2F2;" align="center">
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
			<td style="border:1px solid #F2F2F2;" align="center"><span style="color:#990100;"><?= Func::fmtmoney($sum2) . $this->sett["valuta"] ?></span></td>
			<td style="border:1px solid #F2F2F2;" align="center">
				<a href="/<?= $this->args[0] ?>/<?= $this->args[1] ?>/<?= $order->id ?>">Смотреть</a>
			</td>
		</tr>

	<? } ?>

<?
if ($this->ocnt % $this->oresults == 0)
	$count = floor($this->ocnt / $this->oresults);
else
	$count = floor($this->ocnt / $this->oresults + 1);
?>

	<div class="listingPageLinks">
		<span style="float: right;">&nbsp;Страница <?=$this->ostart/$this->oresults+1?> из <?= $count ?>&nbsp;</span>

		Показано <b><?= $this->oresults ?></b> из <b><?= $this->ocnt ?></b> (из <b></b> заказов)</div>


</table>
<?= $this->render('rule2.php') ?>
<div class="submitFormButtons">
	<button id="button1" type="button" onclick="document.location.href='/<?= $this->args[0] ?>';">Назад</button><script type="text/javascript">$("#button1").button({icons:{primary:"ui-icon-triangle-1-w"}});</script></div>

<div class="clear"></div>
