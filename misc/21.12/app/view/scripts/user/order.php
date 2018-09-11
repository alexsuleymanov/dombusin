<div style="padding: 30px;">
<?
$order = $this->order;
$Order = new Model_Order($order->id);
$Discount = new Model_Discount();
$discount = $Discount->getnakop($Order->total($_COOKIE['userid']));
$sum = $Order->ordersum($order->id);
$sum2 = $sum - ($sum * $discount / 100);
?>
<h1 style="height:30px;">Заказ №<?= $this->order->id ?></h1>

<div class="moduleBox">
	<span style="float: right;"><h6>Итого заказ: <?= Func::fmtmoney($sum2) . $this->sett["valuta"] ?></h6></span>

	<h6>Дата заказа: <?= date("d.m.Y", $order->tstamp) ?> <small><br>
			Статус: <?switch($order->status) {
				case 1: echo 'Отправлен'; break;
				case 2: echo 'Собран'; break;
				case 3: echo 'Доставлен'; break;
				case 4: echo 'Обрабатывается'; break;
				case 5: echo 'Собирается'; break;
				case 6: echo 'Отменен'; break;
				case 7: echo 'Оплачен'; break;
				default: echo 'Неизвестен'; break;
			}?><br><br></small></h6>

	<div class="content">
		<table border="0" width="100%" cellspacing="0" cellpadding="2">
			<tr>
				<td width="50%" valign="top">


					<h6><b>Адрес доставки</b></h6>

					<p>
						<?=$this->user->surname?$this->user->surname.'<br>':''?>
						<?=$this->user->name?$this->user->name.'<br>':''?>
						<?=$this->user->country?$this->user->country.'<br>':''?>
						<?=$this->user->city?$this->user->city.'<br>':''?>
						<?=$this->user->address?$this->user->address.'<br>':''?>
					</p>
				</td>
				<td width="50%" valign="top">

					<h6><b>Метод оплаты</b></h6>

					<?
						$PM = new Model_Esystem();
						$method = $PM->get($order->payment_method);
					?>
					<p><?=$method->name?></p>
				</td>
				<!--end --></tr>
		</table>
	</div>
</div>




<div class="moduleBox">
	<h6>Товары</h6>
	<div class="content">
		<table border="0" width="100%" cellspacing="0" cellpadding="2">
			<td>
				<table border="0" width="100%" cellspacing="0" cellpadding="5">

					<tr style="background-color:#F2F2F2;">
						<td style="text-align:center;border:1px solid #fff;padding:5px 10px;" width="30"><h6>Изображение</h6></td>
						<td style="text-align:center;border:1px solid #fff;padding:5px 10px;" width="500"><h6>Наименование</h6></td>
						<td style="text-align:center;border:1px solid #fff;padding:5px 10px;" width="125"><h6>Цена</h6></td>
						<td style="text-align:center;border:1px solid #fff;padding:5px 10px;" width="50"><h6>Кол-во</h6></td>
						<td style="text-align:center;border:1px solid #fff;padding:5px 10px;" width="133"><h6>Стоимость</h6></td>
					</tr>

					<?
					$w = 0;
					$Cart = new Model_Cart();
					$items = $Cart->getall(array("where" => "`order` = '" . $order->id . "'"));
					$Prod = new Model_Prod();
					$total_weight = 0;
					$sum = 0;

					foreach ($items as $v) {
						$prod = $Prod->get($v->prod);
						
						$price = $prod->price;
						$weight = $prod->weight;
						$inpack = $prod->inpack;
					
						if($v->var == 2){
							$price = $prod->price2;
							$weight = $prod->weight2;
							$inpack = $prod->inpack2;
						}
					
						if($v->var == 3){
							$price = $prod->price3;
							$weight = $prod->weight3;
							$inpack = $prod->inpack3;
						}
						
						$total_weight += $weight * $v->num;
						$sum1 += $price*$v->num;
						$sum += $v->skidka ? ($v->price * (100 - $v->skidka) / 100) * $v->num : $v->price * $v->num;
						?>

						<tr>
							<td style="border:1px solid #F2F2F2;" align="right" valign="top" width="30">
								<a href="/catalog/prod-<?= $v->prod ?>"><img src="/thumb?src=pic/prod/<?= $v->prod ?>.jpg&width=104" alt="<?=$v->name?>" style="float:left;"></a>
<?/*						if($order->status == 7 || $order->status == 1 || $order->status == 3){?>
								<br><a href="/pic/prod/<?= $v->prod ?>.jpg" target="_blank">Скачать</a>
<?						}*/?>
							</td>
							<td style="border:1px solid #F2F2F2; padding: 5px;" valign="top">
								<a href="/catalog/prod-<?= $v->prod ?>" style="display:block;"><?=$prod->name?></a>
								<span class="weight" style="display:block;padding-top:10px;float:left;width:250px;">Вес: &nbsp;<?=$weight?> г&nbsp;</span>
								<?/*if($v->skidka){?>
								<span style="display:block;background:url(<?=$this->path?>/img/off.png) no-repeat;position:absolute;margin-left:-50px;width:50px;text-align:center;padding:10px 0 19px 0;color:#623C02;font-size:18px;">
								<?=$v->skidka?>
								</span>
								<?}*/?>
							</td>
							<td style="border:1px solid #F2F2F2; padding: 5px;" align="center" valign="middle">
								<s>Цена: <?=Func::fmtmoney($price)?>&nbsp;<?= $this->valuta['name'] ?></s><br> Ваша цена: <?=Func::fmtmoney($v->price*(100-$v->skidka)/100)?>&nbsp;<?= $this->valuta['name'] ?></td>
							<td style="border:1px solid #F2F2F2; padding: 5px;" align="center" valign="middle" width="60"><?=$v->num?></td>

							</td>
							<td style="border:1px solid #F2F2F2; padding: 5px;" align="center" valign="middle" width="100"><span style="color:red;"><?=Func::fmtmoney(($v->price*(100-$v->skidka)/100)*$v->num)?>&nbsp;<?= $this->valuta['name'] ?></span></td>
						</tr>
<? } ?>

				</table>

				<p>&nbsp;</p>

				<table border="0" width="100%" cellspacing="0" cellpadding="2">
					<tr>
						<td width="80%" align="right">Общий вес:</td>
						<td align="right"><?=$total_weight?> г</td>
					</tr>
					<tr>
						<td align="right">Стоимость:</td>
						<td align="right"><?=Func::fmtmoney($sum1)?>&nbsp;<?= $this->valuta['name'] ?></td>
					</tr>
					<tr>
						<td align="right">Скидка:</td>
						<td align="right"><?=Func::fmtmoney($sum1 - $sum)?>&nbsp;<?= $this->valuta['name'] ?></td>
					</tr>
					<tr>
						<td align="right">Итого:</td>
						<td align="right"><b><?=Func::fmtmoney($sum)?>&nbsp;<?= $this->valuta['name'] ?></b></td>
					</tr>
				</table>
			</td>
		</table>
	</div>
</div>


<div class="submitFormButtons">
	<button id="button1" type="button" onclick="document.location.href='/<?=$this->args[0]?>/<?=$this->args[1]?>';">Назад</button><script type="text/javascript">$("#button1").button({icons:{primary:"ui-icon-triangle-1-w"}});</script></div>

<div class="clear"></div>
</div>