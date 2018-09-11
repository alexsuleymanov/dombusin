<? if (count($this->prods)) { ?>
	<script type="text/javascript">
		function countchange(value) {
			$.ajax({
				url: '/catalog/set?results='+value,
				success: function (data) {
					href = '<?= $this->url->gvar("start=0") ?>';
					location.href = href;
				}
			});
		}
	</script>

	<? $opt = Zend_Registry::get('opt'); ?>
	<?
	$Cat = new Model_Cat();
	$cat = $Cat->get($this->cat);
	?>
	<h1><?= $cat->name ?></h1>

	<div class="goods-header" style="padding: 6px 3px 6px 10px;background:#F3F3F3;border: 1px solid #D8D8D8;">
		<b><?= count($this->prods) ?></b> товаров
	</div>

	<div class="goods-header" style="height:18px;margin-bottom:15px;padding: 0px 3px 6px 10px;background:#F3F3F3;border: 1px solid #D8D8D8;">
	    <div style="width:30px;float:left;padding: 5px 0;">Вид:</div>
		<a href="<?= $this->url->gvar("view=list") ?>" class="list<? if ((!isset($this->view_mode)) || ($this->view_mode == 'list')) { ?>a<? } ?>">Список</a>
		<a href="<?= $this->url->gvar("view=grid") ?>" class="grid<? if ($this->view_mode == 'grid') { ?>a<? } ?>">Сетка</a>
	    <div style="padding-top:3px;float:right">
			Сортировать по:
			<select onchange="countchange(value);">
				<option value="32"<? if ($this->results == 32) { ?> selected="selected"<? } ?>>32</option>
				<option value="64"<? if ($this->results == 64) { ?> selected="selected"<? } ?>>64</option>
				<option value="96"<? if ($this->results == 96) { ?> selected="selected"<? } ?>>96</option>
			</select>
		</div>
		<div style="float:right;padding-top:3px;padding-right:5px;">
			<?= $this->render('catalog/sort.php') ?>
		</div>
	</div>
	<div style="clear: both;"></div>
	<div class="listingPageLinks">
		<?= $this->render('rule.php') ?>
	</div>
	<? if ((!isset($this->view_mode)) || ($this->view_mode == 'list')) { ?>
		<div>
			<ul style="list-style: none;margin:0;">
				<? foreach ($this->prods as $prod) { ?>
					<li style="width:100%;display:block;border-bottom: 1px dotted #9D9D9D;display: list-item;list-style: none;margin: 0px;overflow: hidden;padding: 8px 1px 8px 4px;">
						<script>
							function check_num_<?= $prod->id ?>(){
								var num_na_sklade = <?= 0 + $prod->num ?>;
								var num_in_cart = <?= 0 + $_SESSION['cart'][$prod->id . "_0"]['num'] ?>;
								var num = num_in_cart + parseInt($("#quantity<?= $prod->id ?>").val());

								if(num_na_sklade < num){
									$("#quantity<?= $prod->id ?>").val(num_na_sklade-num_in_cart);
									alert("На складе есть не более "+num_na_sklade+" упаковок(ка)");
									return false;
								}
							}
						</script>

						<div style="height:100px;float:left;width:110px;" id="tovar-img<?= $prod->id ?>" class="tovar-img">
							<a class="group" href="/catalog/prod-<?= $prod->id ?>/ajax">
								<? if ($prod->pop) { ?>
									<div class="hot"></div>
								<? } ?>
								<? /*
								  <?if($prod->pop){?>
								  <span style="position:absolute;margin-left:65px;z-index:10;display:block;">
								  <img src="<?=$this->path?>/img/hot.gif" width="33px" height="12px">
								  </span>
								  <?}?>
								 */ ?>
								<img src="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&amp;width=100" alt="<?= $prod->name ?>" style="max-width:100%;max-height:100px;float:left;" id="prodpreview<?= $prod->id ?>">
							</a>
						</div>
						<a href="/catalog/prod-<?= $prod->id ?>" style="width:389px;display:block;padding-left:110px;"><?= $prod->name ?></a>
						<span class="pack_counter" style="display:block;padding-top:10px;padding-left:10px;float:left;width:175px;">Кол-во: &nbsp;<?= $prod->inpack ?>&nbsp;</span>
						<span class="weight" style="display:block;padding-top:10px;float:left;width:175px;">Вес: &nbsp;<?= $prod->weight ?> г&nbsp;</span>


						<? if ($prod->skidka) { ?>
							<span class="price" style="display:block;float:left;padding-left:10px;width:175px;">
								<font style="text-decoration: line-through;">Цена: <?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?></font>
							</span>
							<span style="display:block;float:left;">Промо цена: <span style="color:red;"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span>&nbsp;</span>
						<? } elseif ($_COOKIE['userdiscount']) { ?>
							<span class="price" style="display:block;float:left;padding-left:10px;width:175px;"><s>Цена: <?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;</s></span><br />
							<span style="color: red;white-space:nowrap;display: block;">Ваша цена: <?= Func::fmtmoney($prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;</span><br />
						<? } else { ?>
							<span class="price" style="display:block;float:left;padding-left:10px;width:175px;">Цена: <?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;</span>
						<? } ?>

						<span style="display:block;float:right;padding-left:10px;width:120px;">
							<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
								<input type="hidden" name="id" value="<?= $prod->id ?>" />
								<input type="hidden" name="ajax" value="1" class="ajax" />
								<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
								<? if ($prod->num > 0) { ?>
									<input type="text" maxlength="5" name="num" id="quantity<?= $prod->id ?>" value="1" size="3" onchange="check_num_<?= $prod->id ?>()">
									<button id="button_buy<?= $prod->id ?>" class="button_buy" type="submit" onclick="_gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']); buy(<?= $prod->id ?>); return false;">Купить</button>
								<? } else { ?>
									Нет в наличии
								<? } ?>
							</form>
							<?if (isset($_COOKIE['userid'])) {?>
							<br><br>
							<form action="/user/wishlist/add/<?= $prod->id ?>" method="post" id="wishform_<?= $prod->id ?>">
								<input type="hidden" name="id" value="<?= $prod->id ?>" />
								<input type="hidden" name="ajax" value="1" class="ajax" />
								<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
								&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $prod->id ?>); return false;" class="awl"><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний</a><br><br>
							</form>
							<?}?>
						</span>
						<? if ($prod->skidka) { ?>
							<span style="display:block;background:url(<?= $this->path ?>/img/off.png) no-repeat;position:absolute;margin-left:430px;width:50px;text-align:center;padding:10px 0 19px 0;color:#623C02;font-size:18px;"><?= $prod->skidka ?></span>
						<? } ?>
					</li>
				<? } ?>
			</ul>
		</div>
	<? } else { ?>


		<div class="moduleBox new_post products_grid">
			<div class="content">
				<? $i = 0;
				foreach ($this->prods as $prod) { ?>
					<script>
						function check_num_<?= $prod->id ?>(){
							var num_na_sklade = <?= 0 + $prod->num ?>;
							var num_in_cart = <?= 0 + $_SESSION['cart'][$prod->id . "_0"]['num'] ?>;
							var num = num_in_cart + parseInt($("#quantity<?= $prod->id ?>").val());

							if(num_na_sklade < num){
								$("#quantity<?= $prod->id ?>").val(num_na_sklade-num_in_cart);
								alert("На складе есть не более "+num_na_sklade+" упаковок(ка)");
								return false;
							}
						}
					</script>

					<? if ($i++ % 4 == 0) { ?>
						<div class="line">
						<? } ?>
						<div class="tovar-l" style="width: 160px; padding-bottom: 20px;" id="tovar-img<?= $prod->id ?>">
							<div class="productListing-data tovar-img" style="height: 160px; width: 160px;">
								<a href="/catalog/prod-<?= $prod->id ?>" style="display:block;width:100%;height:100%;position:relative;">
									<img src="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&amp;width=155" alt="<?= $prod->name ?>" style="position:relative;max-height:100%;max-width:100%" id="prodpreview<?= $prod->id ?>">
								</a>
								<? if ($prod->pop) { ?>
									<div class="hot"></div>
								<? } ?>
								<? if ($prod->skidka) { ?>
									<div class="discount"><span>-<?= $prod->skidka ?>%</span></div>
									<div class="hot"></div>
								<? } ?>
							</div>
							<div class="productListing-data name" style="height: 50px;">
								<a href="/catalog/prod-<?= $prod->id ?>" title="<?= $prod->name ?>"><?= substr($prod->name, 0, strpos($prod->name, ",", 50)) . "..." ?></a>
							</div>
							<div class="productListing-data price" style="height: 35px;">
								<? if ($prod->skidka) { ?>
									<font style="text-decoration: line-through;">Цена: <?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></font><br>
									<span style="display:block;">Промо цена: <span style="color:red;"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></span></span>
								<? } elseif ($_COOKIE['userdiscount']) { ?>
									<span class="price" style="display:block;float:left;padding-left:10px;width:175px;"><s>Цена: <?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;/ <?= $prod->inpack ?></s></span><br />
									<span class="price" style="display:block;float:left;padding-left:10px;width:175px; color: red;">Цена: <?= Func::fmtmoney($prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;/ <?= $prod->inpack ?></span><br />
								<? } else { ?>
									<span style="display:block;">Цена: <span style="color:red;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></span></span>
								<? } ?>
							</div>

							<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
								<input type="hidden" name="id" value="<?= $prod->id ?>" />
								<input type="hidden" name="ajax" value="1" class="ajax" />
								<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />

								<div class="productListing-data by_now">
									<input type="text" size="2" style="height:20px; width: 20px;" maxlength="5" name="num" id="quantity<?= $prod->id ?>" onchange="check_num_<?= $prod->id ?>()" value="1" />
									<button id="button_buy<?= $prod->id ?>" class="button_buy" type="submit" onclick="_gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']); buy(<?= $prod->id ?>); return false;" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
										<span class="ui-button-text">Купить</span>
									</button>
								</div>
								<div class="productListing-data quantity">

								</div>
							</form>
							<?if (isset($_COOKIE['userid'])) {?>
							<br>
							<form action="/user/wishlist/add/<?= $prod->id ?>" method="post" id="wishform_<?= $prod->id ?>">
								<input type="hidden" name="id" value="<?= $prod->id ?>" />
								<input type="hidden" name="ajax" value="1" class="ajax" />
								<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
								&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $prod->id ?>); return false;" class="awl"><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний</a><br><br>
							</form>
							<?}?>
						</div>
						<? if ($i % 4 == 0) { ?>
						</div>
					<? } ?>

				<? } ?>
				<? if ($i % 4 != 0) { ?>
				</div>
			<? } ?>
		</div>
		<div class="clear"></div>
		</div>
	<? } ?>

	<div class="listingPageLinks">
		<?= $this->render('rule.php') ?>
	</div>
	<div class="clear"></div>

<?
}?>
