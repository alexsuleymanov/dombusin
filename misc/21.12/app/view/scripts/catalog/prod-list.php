<? if ((count($this->prods))||($_GET['filter']==1)) { ?>
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
<?	if(count($this->cats) == 0){?>
	<h1><?= $this->page->h1 ?></h1>
<?	}?>

<?	if($_SERVER['REQUEST_URI'] == $this->canonical && count($this->cats) == 0){?>

	<div class="pagecont">
	<?	echo $this->page->cont2;?>
	</div>
<?	}?>

<?	if($this->args[0] == 'catalog' && $this->args[1] != 'new' && $this->new_count && $this->args[1] != 'top'){?>
	<div class="goods-header" style="padding: 6px 3px 6px 10px;background:#F3F3F3;border: 1px solid #D8D8D8;">
		<input type="button" value="Показать новинки" onclick="location.href = '?novinki=1';"/>
	</div>
<?	}?>

	<div class="goods-header" style="height:18px;margin-bottom:15px;padding: 0px 3px 6px 10px;background:#F3F3F3;border: 1px solid #D8D8D8;">
	    <div style="width:30px;float:left;padding: 5px 0;">Вид:</div>
		<a href="<?= $this->url->gvar("view=list") ?>" class="list<? if ((!isset($this->view_mode)) || ($this->view_mode == 'list')) { ?>a<? } ?>">Список</a>
		<a href="<?= $this->url->gvar("view=grid") ?>" class="grid<? if ($this->view_mode == 'grid') { ?>a<? } ?>">Сетка</a>
	    <div style="padding-top:3px;float:right">
			Показано:
			<select onchange="countchange(value);">
				<option value="30"<? if ($this->results == 30) { ?> selected="selected"<? } ?>>30</option>
				<option value="60"<? if ($this->results == 60) { ?> selected="selected"<? } ?>>60</option>
				<option value="90"<? if ($this->results == 90) { ?> selected="selected"<? } ?>>90</option>
			</select>
		</div>
		<div style="float:right;padding-top:3px;padding-right:5px;">
			<?= $this->render('catalog/sort.php') ?>
		</div>
<?/*	if($this->args[0] == 'catalog' && $this->args[1] == 'new'){?>
		<div style="float:right;padding-top:3px;padding-right:5px;">
			Срок:
			<select onchange="location.href = '?period='+value;">
				<option value="60"<? if (empty($_GET['period']) || $_GET['period'] == 60) { ?> selected="selected"<? } ?>>60 дней</option>
				<option value="30"<? if ($_GET['period'] == 30) { ?> selected="selected"<? } ?>>30 дней</option>
				<option value="14"<? if ($_GET['period'] == 14) { ?> selected="selected"<? } ?>>14 дней</option>
			</select>
		</div>

<?	}*/?>
	</div>
	<div style="clear: both;"></div>
	<?if(count($this->prods)){?>
	<div class="listingPageLinks">
		<?= $this->render('rule.php') ?>
	</div>
	<?}?>
	
	<? if ((!isset($this->view_mode)) || ($this->view_mode == 'list')) { ?>
		
		<?if(!count($this->prods)){?>
			
			<div class="pl-empty">По данному запросу нет совпадений</div>
		<?} else {?>
		<div>
			<ul style="list-style: none;margin:0;">
				<? foreach ($this->prods as $prod) { ?>
					<li style="width:100%;display:block;border-bottom: 1px dotted #9D9D9D;display: list-item;list-style: none;margin: 0px;overflow: hidden;padding: 8px 1px 8px 4px;">
						<div style="height:100px; float:left; width:110px;" id="tovar-img<?= $prod->id ?>" class="tovar-img tovar-list-image">
							<a class="group" style="display: block; height:100px; width:110px;" href="/pic/prod/<?= $prod->id ?>.jpg" <?/*width="400"*/?>>
								<? if ($prod->pop) { ?>
									<div class="hot"></div>
								<? } ?>
								<?	if($prod->changed > (time() - 45*86400)){?>
									<div class="new"></div>
								<?	}?>

								<img src="/pic/prod/<?= $prod->id ?>.jpg" width="100" alt="<?= $prod->name ?>" style="max-width:100%;max-height:100px;" id="prodpreview<?= $prod->id ?>">
							</a>
						</div>
						<div class="list-name" style="width: 450px; float: left;">
							<a href="/catalog/prod-<?= $prod->id ?>" style="width:389px;display:block;padding-left:0px;"><?= $prod->name ?></a><br /><br />
							<span class="weight" style="display:block;float:left;width:175px;">В упаковке: &nbsp;
						<?	if($prod->num2 || $prod->num3){?>
								<select name="var" onchange="changepack(<?=$prod->id?>, this.value);">
						<?	if($prod->num){?>
									<option value="1"><?=$prod->inpack?></option>
						<?	}?>
						<?	if($prod->num2){?>
									<option value="2"><?=$prod->inpack2?></option>
						<?	}?>
						<?	if($prod->num3){?>
									<option value="3"><?=$prod->inpack3?></option>
						<?}?>
								</select>
						<?	}else{
								echo $prod->inpack;
							}?>
									&nbsp;
							</span>
							<span class="weight" style="display:block;float:left;width:175px;">
								Вес упаковки: &nbsp;
								<?$k = 0;?>
								<?if($prod->num){?>
								<span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar1"><?= $prod->weight ?> г</span>
								<?}?>
								<?if($prod->num2){?>
								<span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar2"><?= $prod->weight2 ?> г</span>
								<?}?>
								<?if($prod->num3){?>
								<span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar3"><?= $prod->weight3 ?> г</span>
								<?}?>
								&nbsp;
							</span>
						<? if ($prod->skidka) { ?>
							<span style="display:block; background:url(<?= $this->path ?>/img/discount.png) no-repeat; position:absolute;margin-left:400px;margin-top: -60px;width:50px;text-align:center;padding:17px 0 19px 0;color:#ffffff;font-size:14px; font-weight: bold;"><?="-".$prod->skidka."%" ?></span>
						<? } ?>
						</div>

						<div class="list-price" style="float: left;">
						<? $k = 0;?>
						<? if ($prod->skidka) { ?>							
							<?if($prod->num){?>
							<span class="prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar1">
								<span class="price" style="display:block;padding-left:10px;width:175px; font-size: 14px;">
									<font style="text-decoration: line-through; font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></font>
								</span>
								<span style="display:block;padding-left:10px;width:175px; font-size: 14px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span> / <?= $prod->inpack ?>&nbsp;</span>
							</span>
							<?}?>
							<?if($prod->num2){?>
							<span class="prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar2">
								<span class="price" style="display:block;padding-left:10px;width:175px; font-size: 14px;">
									<font style="text-decoration: line-through; font-size: 14px;"><?= Func::fmtmoney($prod->price2) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></font>
								</span>
								<span style="display:block;padding-left:10px;width:175px; font-size: 14px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price2 * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span> / <?= $prod->inpack2 ?>&nbsp;</span>
							</span>
							<?}?>
							<?if($prod->num3){?>
							<span class="prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar3">
								<span class="price" style="display:block;padding-left:10px;width:175px; font-size: 14px;">
									<font style="text-decoration: line-through; font-size: 14px;"><?= Func::fmtmoney($prod->price3) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></font>
								</span>
								<span style="display:block;padding-left:10px;width:175px; font-size: 14px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price3 * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span> / <?= $prod->inpack3 ?>&nbsp;</span>
							</span>
							<?}?>
						<? } elseif ($_COOKIE['userdiscount']) { ?>
							<?if($prod->num){?>
							<span class="prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar1">
								<span class="price" style="display:block;padding-left:10px;width:175px; font-size: 14px;"><s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?>&nbsp;</s></span>
								<span style="display: block;padding-left:10px;width:175px; font-size: 14px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span> / <?= $prod->inpack ?>&nbsp;</span><br />
							</span>
							<?}?>
							<?if($prod->num2){?>
							<span class="prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar2">
								<span class="price" style="display:block;padding-left:10px;width:175px; font-size: 14px;"><s><?= Func::fmtmoney($prod->price2) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?>&nbsp;</s></span>
								<span style="display: block;padding-left:10px;width:175px; font-size: 14px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price2 * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span> / <?= $prod->inpack2 ?>&nbsp;</span><br />
							</span>
							<?}?>
							<?if($prod->num3){?>
							<span class="prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar3">
								<span class="price" style="display:block;padding-left:10px;width:175px; font-size: 14px;"><s><?= Func::fmtmoney($prod->price3) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?>&nbsp;</s></span>
								<span style="display: block;padding-left:10px;width:175px; font-size: 14px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price3 * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span> / <?= $prod->inpack3 ?>&nbsp;</span><br />
							</span>
							<?}?>
						<? } else { ?>
							<?if($prod->num){?>
							<span class="prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar1">
								<span class="price" style="display:block;padding-left:10px;width:175px; font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?>&nbsp;</span>
							</span>
							<?}?>
							<?if($prod->num2){?>
							<span class="prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar2">
								<span class="price" style="display:block;padding-left:10px;width:175px; font-size: 14px;"><?= Func::fmtmoney($prod->price2) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?>&nbsp;</span>
							</span>
							<?}?>
							<?if($prod->num3){?>
							<span class="prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar3">
								<span class="price" style="display:block;padding-left:10px;width:175px; font-size: 14px;"><?= Func::fmtmoney($prod->price3) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?>&nbsp;</span>
							</span>
							<?}?>
						<? } ?>
						    <br />
							<span style="display:block; padding-left:10px;width:155px;">
								<?
									if($prod->num3) $prodvar = 3;
									if($prod->num2) $prodvar = 2;
									if($prod->num) $prodvar = 1;
								?>
								<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
									<input type="hidden" name="id" value="<?= $prod->id ?>" />
									<input type="hidden" name="var" value="<?=$prodvar?>" id="prodvar<?=$prod->id?>" />
									<input type="hidden" name="ajax" value="1" class="ajax" />
									<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
									<? if ($prod->num > 0 || $prod->num2 > 0 || $prod->num3 > 0) { ?>
										<input type="text" maxlength="5" name="num" id="quantity<?= $prod->id ?>" value="1" size="3" onchange="check_num(<?=$prod->id?>, $('#prodvar<?=$prod->id?>').val(), $(this).val());" >
										<input type="image" src="<?=$this->path?>/img/bbuy.png" onclick="_gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']); buy(<?= $prod->id ?>); return false;" style="margin: 0 0 0 10px; vertical-align: middle">
									<? } else { ?>
										Нет в наличии
									<? } ?>
								</form>
								<?if (isset($_COOKIE['userid'])) {?>
								<br><br>
								<form action="/user/wishlist/add/<?= $prod->id ?>" method="post" id="wishform_<?= $prod->id ?>">
									<input type="hidden" name="id" value="<?= $prod->id ?>" />
									<input type="hidden" name="var" value="<?=$prodvar?>" id="prodvar" />
									<input type="hidden" name="ajax" value="1" class="ajax" />
									<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
									&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $prod->id ?>); return false;" class="awl"><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний</a><br><br>
								</form>
								<?}?>
							</span>
						</div>

					</li>
				<? } ?>
			</ul>
		</div>
		<?}?>
	<? } else { ?>
		<?if(!count($this->prods)){?><div class="pl-empty">По данному запросу нет совпадений</div><?} else {?>
		<div class="moduleBox new_post products_grid">
			<div class="content">
				<? $i = 0;
				foreach ($this->prods as $prod) { ?>
					<? if ($i++ % 3 == 0) { ?>
						<div class="line">
						<? } ?>
						<div class="tovar-l" style="width: 247px; padding-bottom: 20px;" id="tovar-img<?= $prod->id ?>">
							<div class="productListing-data tovar-img" style="height: 240px; width: 247px;">
								<a href="/catalog/prod-<?= $prod->id ?>" style="display:block;width:247%;height:240%;position:relative;">
									<img src="/pic/prod/<?= $prod->id ?>.jpg" width="245" alt="<?= $prod->name ?>" style="position:relative;max-height:100%;max-width:100%" id="prodpreview<?= $prod->id ?>">
								</a>
								<? if ($prod->pop) { ?>
									<div class="hot"></div>
								<? } ?>
								<? if ($prod->skidka) { ?>
									<div class="discount"><span>-<?= $prod->skidka ?>%</span></div>
									<div class="hot"></div>
								<? } ?>
								<?	if($prod->changed > (time() - 45*86400)){?>
									<div class="new"></div>
								<?	}?>
							</div>
							<div class="productListing-data name" style="height: 40px;">
								<a href="/catalog/prod-<?= $prod->id ?>" title="<?= $prod->name ?>"><?=Func::fmtname($prod->name, 80) ?></a>
							</div>
							<div class="productListing-data price" style="height: 35px;">
								<?	if ($prod->skidka) { ?>
								<?	if($prod->num2 || $prod->num3){?>
									<select name="var" class="priceselect red" onchange="changepack(<?=$prod->id?>, this.value);">
								<?		if($prod->num){?>
										<option value="1"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?> &nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		}?>
								<?		if($prod->num2){?>		
										<option value="2"><?= Func::fmtmoney($prod->price2 * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3){?>
										<option value="3"><?= Func::fmtmoney($prod->price3 * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
									</select>
								<?		}else{?>
									<font style="text-decoration: line-through; font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></font><br>
									<span style="display:block;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span><span class="count products in pack"> / <?= $prod->inpack ?></span></span>
								<?		}?>
								<? } elseif ($_COOKIE['userdiscount']) { ?>
									<?	if($prod->num2 || $prod->num3){?>
									<select name="var" class="priceselect red" onchange="changepack(<?=$prod->id?>, this.value);">
								<?		if($prod->num){?>
										<option value="1"><?= Func::fmtmoney($prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?> &nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		}?>
								<?		if($prod->num2){?>
										<option value="2"><?= Func::fmtmoney($prod->price2 * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3){?>
										<option value="3"><?= Func::fmtmoney($prod->price3 * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
									</select>
								<?		}else{?>
									<span class="price" style="display:block;float:left;padding-left:10px;width:175px; font-size: 14px;"><s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?>&nbsp;/ <?= $prod->inpack ?></s></span><br />
									<span class="price" style="display:block;float:left;padding-left:10px;width:175px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span>&nbsp;/ <?= $prod->inpack ?></span><br />
								<?		}?>	
								<? } else { ?>
								<?	if($prod->num2 || $prod->num3){?>
									<select name="var" class="priceselect" onchange="changepack(<?=$prod->id?>, this.value);">
								<?		if($prod->num){?>		
										<option value="1"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></option>
								<?		}?>
								<?		if($prod->num2){?>
										<option value="2"><?= Func::fmtmoney($prod->price2) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack2 ?></option>
								<?		}?>
								<?		if($prod->num3){?>
										<option value="3"><?= Func::fmtmoney($prod->price3) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack3 ?></option>
								<?		}?>
									</select>
								<?		}else{?>
									<span style="display:block;"><span style="font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></span></span>
								<?		}?>	
									
								<? } ?>
							</div>

							<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
								<?
									if($prod->num3) $prodvar = 3;
									if($prod->num2) $prodvar = 2;
									if($prod->num) $prodvar = 1;
								?>
								<input type="hidden" name="id" value="<?= $prod->id ?>" />
								<input type="hidden" name="var" value="<?=$prodvar?>" id="prodvar<?=$prod->id?>" />
								<input type="hidden" name="ajax" value="1" class="ajax" />
								<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />

								<div class="productListing-data by_now">
									<input type="text" size="5" style="height:20px; width: 40px;" maxlength="5" name="num" id="quantity<?= $prod->id ?>" onchange="check_num(<?=$prod->id?>, $('#prodvar<?=$prod->id?>').val(), $(this).val());" value="1" />
									<input type="image" src="<?=$this->path?>/img/bbuy.png" onclick="_gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']); buy(<?= $prod->id ?>); return false;" style="margin: 0 0 0 20px; vertical-align: middle">
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
						<? if ($i % 3 == 0) { ?>
						</div>
					<? } ?>

				<? } ?>
				<? if ($i % 3 != 0) { ?>
				</div>
			<? } ?>
		</div>
		<?}?>
		<div class="clear"></div>
		</div>
	<? } ?>

	<?if(count($this->prods)){?>
	<div class="listingPageLinks">
		<?= $this->render('rule.php') ?>
	</div>
	<?}?>
	<div class="clear"></div>

<?
}else{
	if($_GET['novinki']){
		echo "За последние 30 дней не было добавлено ни одного нового товара в данную категорию<br /><br />";
		echo "<a href=\"/".$this->url->page.$this->url->gvar("novinki=")."\">Показать все товары в категории</a>";
	}
}?>
