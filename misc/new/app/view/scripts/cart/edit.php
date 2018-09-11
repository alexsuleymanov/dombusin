<h1>Корзина</h1>
<?//print_r($this->cart->cart);?>
<? if (Model_User::userid()) { ?>
	<div class="filter-sidebar">
		<div class="title">
			<span class="left-switcher left-switcher-active" onclick="
			$('.left-switcher').removeClass('left-switcher-active');
			$(this).addClass('left-switcher-active');
			$('.ect').css('display', 'none');
			$('#ect-1').css('display', 'block');
			">Корзина</span>
			<span class="left-switcher" onclick="
			$('.left-switcher').removeClass('left-switcher-active');
			$(this).addClass('left-switcher-active');
			$('.ect').css('display', 'none');
			$('#ect-2').css('display', 'block');
			">Список желаний</span>
		</div>
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
<div id="ect-1" class="ect">
	<?if(!Model_User::isOpt()) echo $this->page->cont; ?>
	<div style="text-align: right; margin-bottom: 20px;">
		<b>Товаров:</b> <span class="cart_num"><?=$this->cart->prod_num()?></span>&nbsp;&nbsp;&nbsp;&nbsp;
		<b>На сумму:</b> <span class="cart_amount"><?=Func::fmtmoney($this->cart->amount())?></span> <?=$this->valuta['name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="/cart/clear" onclick="return confirm('Вы действительно хотите удалить все товары?');">Очистить корзину</a>
	</div>
	<nav aria-label="Shopping Cart Next Navigation">
		<ul class="pager">
			<li class="previous"><a href="/"><span aria-hidden="true">&larr;</span> На главную</a></li>
			<li class="next"><a href="#" onclick="ga('send', 'event', 'Zakaz', 'Click_zakaz');make_order(); return false;" class="btn btn-theme m-b-1 active focus"><?= $this->labels["make_order"] ?> <span aria-hidden="true">&rarr;</span></a></li>
		</ul>
	</nav>
	<!--<div class="table-responsive">-->
	<div>
		<table class="table table-bordered table-cart">
			<thead>
			<tr>
				<th class="ce-img"><?= $this->labels["photo"] ?></th>
				<th><?= $this->labels['title'] ?></th>
				<th class="ce-wide">Кол-во</th>
				<th class="ce-wide"><?= $this->labels['price'] ?></th>
				<th class="ce-wide">Сумма</th>
				<th class="ce-wide-name">Действие</th>
			</tr>
			</thead>
			<tbody>

			<?
			$n = $sum0 = $sum = 0;
			$total_weight = 0;
//print_r($this->cart->cart);
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
						<td align="center" class="ce-img"><img src="/pic/prod/<?= $v['id'] ?>.jpg" alt="" /></td>
						<td class="cezt">
							<input type="hidden" name="id_<?= $k ?>" value="<?= $v['id'] ?>">
							<?= $title ?><br><br class="ce-wide">
							<div class="clear"></div>
							<div class="cet2 ce-wide">Вес упаковки: <?= $weight ?> г</div>
							<div class="cet2 ce-wide">В упаковке: <?= $inpack ?></div>
							<? $total_weight += $weight * $v['num'] ?>
							<div class="clear"></div>
							<div class="ce-mobile">
								<br>
								<? if ($v['price'] != $v['baseprice']) {?>
									<s><?= Func::fmtmoney($v['baseprice']) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></s><br />
									<nobr><?= Func::fmtmoney($v['price']) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></nobr><br />
									<?if($v['skidka']){?><span style="color:red;">Скидка -<?=$v['skidka']?>%</span><?}?>
								<? } else { ?>
									<nobr><?= Func::fmtmoney($v['price']) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></nobr>
								<? } ?>
							</div>
						</td>
						<td align="center" class="ce-pm">
							<nobr>
								<input type="button" class="cart_num_minus btn btn-theme" id="cart_num_minus_<?=$k?>" value="-" onclick="plus_minus_cart_num('minus', '<?=$k?>')"/>
								<input type="text" name="num_<?=$k?>" value="<?=$v['num']?>" size=2 class="cart_num" id="cart_num_<?=$k?>" style="text-align: center;" onchange="change_cart_num('<?=$k?>')"/>
								<input type="button" id="cart_num_plus_<?=$k?>" class="cart_num_plus btn btn-theme" value="+" onclick="plus_minus_cart_num('plus', '<?=$k?>')"/>
							</nobr>
							<div class="ce-mobile m-but-block">
								<? if (Model_User::userid()) { ?>
									<a href="#" onclick="cart_to_wish('<?= $k ?>'); return false;" title="Добавить в список желаний"><i class="fa fa-heart"></i></a>&nbsp;
								<? } ?>
								<a href="/cart/delete/<?= $k ?>" onclick="return confirm('Вы действительно хотите удалить этот товар');" title="Удалить"><i class="fa fa-trash"></i></a>
							</div>
						</td>
						<td align="center" class="ce-wide">
							<? if (round($v['price'], 2) != round($v['baseprice'], 2)) {?>
								<s><?= Func::fmtmoney($v['baseprice']) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></s><br />
								<nobr><?= Func::fmtmoney($v['price']) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></nobr><br />
								<?if($v['skidka']){?><span style="color:red;">Скидка -<?=$v['skidka']?>%</span><?}?>
							<? } else { ?>
								<nobr><?= Func::fmtmoney($v['price']) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></nobr>
							<? } ?>
						</td>
						<td align="center" class="ce-wide">
							<? if ($v['price'] != $v['baseprice']) { ?>
								<!--<s><?= Func::fmtmoney($v['baseprice'] * $v['num']) ?>&nbsp;<?= $this->valuta['name'] ?></s><br />-->
								<nobr><span id="cart_sum_<?=$k?>"><?= Func::fmtmoney($v['price'] * $v['num']) ?></span>&nbsp;<?= $this->valuta['name'] ?></nobr><br />
								<?/*if($v['skidka'])<span style="color:red;">Скидка -<?=($v['baseprice'] - $v['price']) * $v['num']?>%</span>*/?>
							<? } else { ?>
								<nobr><span id="cart_sum_<?=$k?>"><?= Func::fmtmoney($v['price'] * $v['num']) ?></span>&nbsp;<?= $this->valuta['name'] ?></nobr>
							<? } ?>
						</td>
						<td align="center" style="text-align:right;" class="ce-wide">
							<? if (Model_User::userid()){ ?>
								<a href="#" onclick="cart_to_wish('<?= $k ?>'); return false;" class="awl btn btn-theme m-b-1 cart_button" title="Добавить в список желаний"><i class="fa fa-heart"></i> </a><br>
							<? } ?>
							<a href="/cart/delete/<?= $k ?>" class="btn btn-theme m-b-1 cart_button" onclick="return confirm('Вы действительно хотите удалить этот товар');" title="Удалить"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
				</form>
			<? } ?>
			</tbody>
		</table>
	</div>

	<input type="hidden" name="total_sum" id="total_sum" value="<?= $this->cart->amount()?>" />

	<script>
		function make_order(){
			var total_sum = $("#total_sum").val();
			<?	if($_SESSION['useropt'] && $_SESSION['userminiopt'] == 0){?>
			if(total_sum > 2000) location.href = '/order';
			else alert("Минимальная сумма заказа 2000 грн.");
			<?	}elseif($_SESSION['useropt'] && $_SESSION['userminiopt'] == 1){?>
			if(total_sum > 500) location.href = '/order';
			else alert("Минимальная сумма заказа 500 грн.");
			<?	}else{?>
			if(total_sum > 0) location.href = '/order';
			<?	}?>
		}
	</script>

	<div style="text-align: right;">
		<table cellpadding="0" cellspacing="0" style="float: right; width: 300px;">
			<?	if(!$_SESSION['useropt']){?>
				<tr valign="top" id="cart_sum_row" <?//if($Cart->sum - $Cart->to_pay == 0) echo "style=\"display: none;\""?>>
					<td width="150" align="right"><b>Сумма</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_sum"><?= Func::fmtmoney($this->cart->amount_without_discount())?></span> <?= $this->valuta['name'] ?></td>
				</tr>
				<tr valign="top" id="cart_discount_row" <?//if($Cart->sum - $Cart->to_pay == 0) echo "style=\"display: none;\""?>>
					<td width="150" align="right"><b>Скидка</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_discount"><?= Func::fmtmoney($this->cart->amount_without_discount() - $this->cart->amount()) ?></span> <?= $this->valuta['name'] ?></td>
				</tr>
				<tr valign="top" class="ce8">
					<td width="150" align="right"><b>К оплате</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_to_pay"><?= Func::fmtmoney($this->cart->amount()) ?></span> <?= $this->valuta['name'] ?></td>
				</tr>
			<?	}else{?>
				<tr valign="top" id="cart_sum_row">
					<td width="150" align="right"><b>Сумма</b></td><td width="6" align="center"> : </td><td width="100" aligh="left" style="color: red"><span class="cart_to_pay"><?= Func::fmtmoney($this->cart->amount())?></span> <?= $this->valuta['name'] ?></td>
				</tr>
			<?	}?>
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

	<div class="clear"></div>
	<nav aria-label="Shopping Cart Next Navigation">
		<ul class="pager">
			<li class="previous"><a href="/"><span aria-hidden="true">&larr;</span> На главную</a></li>
			<li class="next"><a href="#" onclick="ga('send', 'event', 'Zakaz', 'Click_zakaz');make_order(); return false;" class="btn btn-theme m-b-1 active focus"><?= $this->labels["make_order"] ?> <span aria-hidden="true">&rarr;</span></a></li>
		</ul>
	</nav>




</div>
<div id="ect-2" style="display: none;" class="ect"><?= $this->render('user/wishlist.php') ?></div>

<?= $this->render('cart/newprods.php') ?>
<?= $this->render('cart/popprods.php') ?>
