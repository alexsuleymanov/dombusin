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
<h1>Поиск</h1>

<div class="goods-header" style="padding: 6px 3px 6px 10px;background:#F3F3F3;border: 1px solid #D8D8D8;">
	<b><?= count($this->prods) ?></b> товаров
</div>

<div class="goods-header" style="height:18px;margin-bottom:15px;padding: 0px 3px 6px 10px;background:#F3F3F3;border: 1px solid #D8D8D8;">
    <div style="width:30px;float:left;padding: 5px 0;">Вид:</div>
	<a href="<?= $this->url->gvar("view=list") ?>" class="list<? if ((!isset($_GET['view'])) || ($_GET['view'] == 'list')) { ?>a<? } ?>">Список</a>
	<a href="<?= $this->url->gvar("view=grid") ?>" class="grid<? if ($_GET['view'] == 'grid') { ?>a<? } ?>">Сетка</a>
    <div style="padding-top:3px;float:right">
		Сортировать по:
		<select onchange="countchange(value);">
			<option value="30"<? if ($this->results == 3) { ?> selected="selected"<? } ?>>30</option>
			<option value="60"<? if ($this->results == 60) { ?> selected="selected"<? } ?>>60</option>
			<option value="90"<? if ($this->results == 90) { ?> selected="selected"<? } ?>>90</option>
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
<? if ((!isset($_GET['view'])) || ($_GET['view'] == 'list')) { ?>
	<div>
		<ul style="list-style: none;margin:0;">
			<? foreach ($this->prods as $prod) { ?>
				<li style="width:100%;display:block;border-bottom: 1px dotted #9D9D9D;display: list-item;list-style: none;margin: 0px;overflow: hidden;padding: 8px 1px 8px 4px;">
					<div style="height:100px;float:left;width:110px;">
						<a class="group" href="/catalog/prod-<?= $prod->id ?>/ajax">
							<img src="/thumb?src=pic/<?= $shop ?>/prod/<?= $prod->id ?>.jpg&amp;width=100&amp;height=100" alt="<?= $prod->name ?>" style="max-width:100%;max-height:100px;float:left;">
						</a>
					</div>
					<a href="/catalog/prod-<?= $prod->id ?>" style="width:389px;display:block;padding-left:110px;"><?= $prod->name ?></a>
					<span class="pack_counter" style="display:block;padding-top:10px;padding-left:10px;float:left;width:175px;">Кол-во: &nbsp;<?= $prod->quantity ?> шт.&nbsp;</span>
					<span class="weight" style="display:block;padding-top:10px;float:left;width:175px;">Вес: &nbsp;<?= $prod->weight ?> г&nbsp;</span>


					<? if ($prod->price2 > $prod->price) { ?>
						<span class="price" style="display:block;float:left;padding-left:10px;width:175px;">
							<font style="text-decoration: line-through;">Цена: <?= $prod->price2 ?>&nbsp;грн.</font>
						</span>
						<span style="display:block;float:left;">Промо цена: <span style="color:red;"><?= $prod->price ?>&nbsp;грн.</span>&nbsp;</span>
					<? } else { ?>
						<span class="price" style="display:block;float:left;padding-left:10px;width:175px;">Цена: <?= $prod->price ?>&nbsp;грн.&nbsp;</span>
					<? } ?>


					<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
						<input type="hidden" name="id" value="<?= $prod->id ?>" />
						<input type="hidden" name="ajax" value="1" class="ajax" />
						<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
						<button id="button_buy<?= $prod->id ?>" type="submit" onclick="buy(<?= $prod->id ?>); return false;">Купить</button>
						<input type="text" maxlength="5" name="num" id="quantity<?= $prod->id ?>" value="1">
					</form>
					<script type="text/javascript">$("#button_buy<?= $prod->id ?>").button({icons:{primary:"ui-icon-cart"}});</script>
					<? if ($prod->price2 > $prod->price) { ?>
					<span style="display:block;background:url(<?=$this->path?>/img/off.png) no-repeat;position:absolute;margin-left:430px;width:50px;text-align:center;padding:10px 0 19px 0;color:#623C02;font-size:18px;"><?= round(($prod->price2 - $prod->price) / $prod->price2 * 100) ?></span>
					<?}?>
				</li>
			<? } ?>
		</ul>
	</div>
<? } else { ?>


	<div class="moduleBox new_post products_grid">
		<div class="content">
			<? $i = 0;
			foreach ($this->prods as $prod) { ?>
				<? if ($i++ % 5 == 0) { ?>
					<div class="line">
					<? } ?>
					<div class="tovar-l">
						<div class="productListing-data tovar-img" style="height: 173px;">
							<a href="/catalog/prod-<?= $prod->id ?>" style="display:block;width:100%;height:100%;position:relative;">
								<img src="/thumb?src=pic/<?= $shop ?>/prod/<?= $prod->id ?>.jpg&amp;width=168&amp;height=168" alt="<?= $prod->name ?>" style="position:relative;max-height:100%;max-width:100%">
							</a>
							<? if ($prod->price2 > $prod->price) { ?>
								<div class="discount"><span>-<?= round(($prod->price2 - $prod->price) / $prod->price2 * 100) ?>%</span></div>
								<div class="hot"></div>
							<? } ?>
						</div>
						<div class="productListing-data name" style="height: 50px;">
							<a href="/catalog/prod-<?= $prod->id ?>"><?= $prod->name ?></a>
						</div>
						<div class="productListing-data price" style="height: 35px;">
							<? if ($prod->price2 > $prod->price) { ?>
								<font style="text-decoration: line-through;">Цена: <?= $prod->price2 ?>&nbsp;грн.<span class="count products in pack"> / 1 шт.</span></font><br>
								<span style="display:block;">Промо цена: <span style="color:red;"><?= $prod->price ?>&nbsp;грн.<span class="count products in pack"> / 1 шт.</span></span></span>
							<? } else { ?>
								<span style="display:block;">Цена: <span style="color:red;"><?= $prod->price ?>&nbsp;грн.<span class="count products in pack"> / 1 шт.</span></span></span>
							<? } ?>
						</div>

						<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
							<input type="hidden" name="id" value="<?= $prod->id ?>" />
							<input type="hidden" name="ajax" value="1" class="ajax" />
							<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />

							<div class="productListing-data by_now">
								<button id="button_buy<?= $prod->id ?>" type="submit" onclick="buy(<?= $prod->id ?>); return false;" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
									<span class="ui-button-icon-primary ui-icon ui-icon-cart"></span>
									<span class="ui-button-text">Купить</span>
								</button>
								<script type="text/javascript">$("#button_buy<?= $prod->id ?>").button({icons:{primary:"ui-icon-cart"}});</script>
							</div>
							<div class="productListing-data quantity">
								<input type="text" size="5" style="height:20px;" maxlength="5" name="num" id="quantity<?= $prod->id ?>" value="1">
							</div>
						</form>




					</div>
					<? if ($i % 5 == 0) { ?>
					</div>
				<? } ?>

			<? } ?>
			<? if ($i % 5 != 0) { ?>
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

