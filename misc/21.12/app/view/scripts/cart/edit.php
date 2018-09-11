<h1>Корзина</h1>
<?//print_r($this->cart->cart);?>
<? if (isset($_COOKIE['userid'])) { ?>
	<div id="cart_tabs">
		<div class="ct ct-2" onclick="$('.ect').css('display', 'none'); $('#ect-1').css('display', 'block'); $('.ct').removeClass('ct-2'); $(this).addClass('ct-2');">Корзина</div>
		<div class="ct" onclick="$('.ect').css('display', 'none'); $('#ect-2').css('display', 'block'); $('.ct').removeClass('ct-2'); $(this).addClass('ct-2');">Список желаний</div>
	</div>
<? } ?>

<?	if(!empty($this->prods_limited)){
		$Prod = new Model_Prod();
		$msg = 'Количество некоторых товаров ограничено:\n';
		foreach($this->prods_limited as $k => $v){
			$prod = $Prod->get($v);
			$msg .= $prod->art.': '.$prod->num.' на складе\n';
		}
?>

	<script type="text/javascript">
		$(document).ready(function() {
			alert('<?=$msg?>');
		});
	</script>
<?	}?>
<div id="ect-1" class="ect" style="padding: 20px;">
	
		<div class="ycart">
			<?
			$opt = Zend_Registry::get('opt');
			$Cart = new Model_Cart();

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

			<? echo $this->page->cont; ?>
			<div style="text-align: right; margin-bottom: 20px;">
				<b>Товаров:</b> <span class="cart_num"><?=$Cart->prod_num()?></span>&nbsp;&nbsp;&nbsp;&nbsp;
				<b>На сумму:</b> <span class="cart_amount"><?=Func::fmtmoney($Cart->amount())?></span> <?=$this->valuta['name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="/cart/clear">Очистить корзину</a>
			</div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="xcart" style="border: 1px solid #cccccc; margin: 10px 0px 10px 0px;">
				<tr style="background-color: #f2f2f2;">
					<td width="10" align="center" style="border:1px solid #fff;"></td>
					<td width="110" align="center" style="border:1px solid #fff;"><b><?= $this->labels["photo"] ?></b></td>
					<td align="center" style="border:1px solid #fff;"><b><?= $this->labels['title'] ?></b></td>
					<td width="30" align="center" style="border:1px solid #fff;width: 30px;"><nobr><b>Кол-во</b></nobr></td>
					<td width="50" align="center" style="border:1px solid #fff;width: 120px;"><b><?= $this->labels['price'] ?></b></td>
					<td width="50" align="center" style="border:1px solid #fff;"><b>Сумма</b></td>
					<td width="76" align="center" style="border:1px solid #fff;width: 100px;"><b>Действие</b></td>
				</tr>
				<?
				$n = $sum0 = $sum = 0;
				$total_weight = 0;

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
					
					$sum += ($price - $price * $prod->skidka) / 100 * $v['num'];
					
					if ($discount)
						$sum2 = $sum - ($sum * $discount) / 100;
					else
						$sum2 = $sum;
					?>
					<script type="text/javascript">
						<?	$num = $prod->num;
							if($v['var'] == 2) $num = $prod->num2;
							if($v['var'] == 3) $num = $prod->num3;
						//	print_r($prod);
						//	print_r($v);
						?>
							
						function check_cart_num_<?= $k ?>(buy_num){
							var num_na_sklade = <?= 0 + $num ?>;
							var num_in_cart = <?= 0 + $v['num'] ?>;
							var num = buy_num;

							if(num_na_sklade < num){
								alert("На складе есть не более "+num_na_sklade+" упаковок(ка)");
								$("#cart_num_<?= $this->cart->cart_id($v['id'], $v['var']) ?>").val(num_na_sklade);
								return num_na_sklade;
							}
							return buy_num;
						}
					</script>
                    <form action="/cart/update" method="post" id="cartform">
					<tr class="ce<?= $w++ % 2 ?>">
						<td align="center"><?= $w ?></td>
						<td align="center"><img src="/pic/prod/<?= $v['id'] ?>.jpg" width="100" alt="" /></td>
						<td class="cezt">
							<input type="hidden" name="id_<?= $k ?>" value="<?= $v['id'] ?>">
							<?= $title ?>
							<div class="clear"></div>
							<div class="cet2" style="float: left; width: 150px;">Вес упаковки: <?= $weight ?> г</div>
							<div class="cet2" style="float: left; width: 120px;">В упаковке: <?= $inpack ?></div>
							<? $total_weight += $weight * $v['num'] ?>
							<div class="clear"></div>
						</td>
						<td align="center" width="90">
							<input type="button" class="cart_num_minus" id="cart_num_minus_<?=$k?>" value="-" style="width: 20px;" onclick="plus_minus_cart_num('minus', '<?=$k?>')"/>
							<input type="text" name="num_<?=$k?>" value="<?=$v['num']?>" size=2 class="cart_num" id="cart_num_<?=$k?>" style="text-align: center;" onchange="change_cart_num('<?=$k?>')"/>
							<input type="button" id="cart_num_plus_<?=$k?>" class="cart_num_plus" value="+" style="width: 20px;"  onclick="plus_minus_cart_num('plus', '<?=$k?>')"/><br />
						</td>
						<td align="center"><? //=($prod->skidka) ? Func::fmtmoney(($prod->price - $prod->price*$prod->skidka/100)*$v['num']).$this->valuta['name'] : Func::fmtmoney($prod->price * $v['num']).$this->valuta['name']   ?>
						<? if ($prod->skidka) { ?>
						<s><?= Func::fmtmoney($price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></s><br />
						<nobr><?= Func::fmtmoney($price * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></nobr><br />
						<span style="color:red;">Скидка -<?= $prod->skidka ?>%</span>
					<? } elseif ($_COOKIE['userdiscount']) { ?>
						<s><?= Func::fmtmoney($price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></s><br />
						<nobr><?= Func::fmtmoney($price * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></nobr><br />
					<? } else { ?>
						<nobr><?= Func::fmtmoney($price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></nobr>
					<? } ?>

					</td>
					<td align="center">
						<? if ($prod->skidka) { ?>
							<span id="cart_sum_<?=$k?>"><?= Func::fmtmoney($price * (100 - $prod->skidka) / 100 * $v['num']) ?></span>&nbsp;<?= $this->valuta['name'] ?>
						<? } elseif ($_COOKIE['userdiscount']) { ?>
							<span id="cart_sum_<?=$k?>"><?= Func::fmtmoney($price * (100 - $_COOKIE['userdiscount']) / 100 * $v['num']) ?></span>&nbsp;<?= $this->valuta['name'] ?>
						<? } else { ?>
							<span id="cart_sum_<?=$k?>"><?= Func::fmtmoney($price * $v['num']) ?></span>&nbsp;<?= $this->valuta['name'] ?>
						<? } ?>
					</td>
					<td align="center" style="width: 10px;">
						<? if (isset($_COOKIE['userid'])) { ?>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="cart_to_wish('<?= $k ?>'); return false;" class="awl"><nobr><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" /> В список желаний</nobr></a><br><br>
						<? } ?>
						<a href="/cart/delete/<?= $k ?>">Удалить</a>
                                        </td>
                                    </tr>
                                        </form>
				<? } ?>
				<tr>
			</table>
		</div>

		<? $Cart->recount(); ?>
		<input type="hidden" name="total_sum" id="total_sum" value="<?= $Cart->sum ?>" />

		<script>
			function make_order(){
				var total_sum = $("#total_sum").val();
				if(total_sum > 0) location.href = '/order';
//				else alert("Минимальная сумма заказа 2000 грн.");
			}
		</script>

		<div style="text-align: right;">
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


		<div class="clear"></div>
		<div style="float: right;"><input type="image" src="<?= $this->path ?>/img/o.png" class="but" value="<?= $this->labels["make_order"] ?>" onclick="_gaq.push(['_trackEvent', 'Zakaz', 'Click_zakaz', 'Zakaz']);make_order(); return false;"></div>
		<div style="float: right; margin-right: 20px;"><button id="button1" type="button" onclick="document.location.href='/';">На главную</button><script type="text/javascript">$("#button1").button({icons:{primary:"ui-icon-triangle-1-w"}});</script></div>
		<div class="clear"></div>
	</form>



</div>
<div id="ect-2" style="display: none;" class="ect"><?= $this->render('user/wishlist.php') ?></div>

<!-- module new_products end //-->
<br />
<!-- module new_products start //-->

	<div class="new_post">
		<div class="head_mod"><p>Новые товары</p></div>
		<div class="content_border">
			<?= $this->render('cart/newprods.php') ?>
			<div class="clear"></div>
		</div>
	</div>

<div class="popular">
	<div class="head_mod"><p>Популярные товары</p></div>
	<div class="content_border">
		<?= $this->render('cart/popprods.php') ?>
		<div class="clear"></div>
	</div>
</div>

