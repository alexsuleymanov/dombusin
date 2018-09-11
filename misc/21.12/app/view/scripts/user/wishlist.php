<? if ((is_array($this->wishlist)) && (count($this->wishlist))) { ?>

	<div class="ycart">
		<!--ajax begin -->
		<br>
		<table width="100%" class="xcart">
			<tr align="center" style="background-color:#F2F2F2;">
				<td width="10" align="center" style="border:1px solid #fff;"></td>
				<td width="110" align="center" style="border:1px solid #fff;"><b><?= $this->labels["photo"] ?></b></td>
				<td width="562" align="center" style="border:1px solid #fff;"><b><?= $this->labels['title'] ?></b></td>
				<td width="90" align="center" style="border:1px solid #fff;width: 50px;"><b><?= $this->labels['quantity'] ?></b></td>
				<td width="50" align="center" style="border:1px solid #fff;width: 200px;"><b><?= $this->labels['price'] ?></b></td>
				<td width="76" align="center" style="border:1px solid #fff;width: 120px;"><b>Действие</b></td>
			</tr>

			<?
			foreach ($this->wishlist as $v) {
				$prod = $v;
				?>
				<tr class="ce<?= $w++ % 2 ?>">
					<td><?=++$i;?></td>
					<td align="center" class="productListing-data">
						<a href="/catalog/prod-<?= $v->id ?>">
							<img src="/pic/prod/<?= $v->id ?>.jpg" width="104" alt="">
						</a>
					</td>
					<td width="550px" align="left" valign="top" class="productListing-data">
						<span style="display:block;"><? $title = "<a href=\"/catalog/prod-" . $v->id . "\" target=\"_blank\">" . $v->name . "</a>"; ?><?= $title ?></span>
						<span class="weight" style="display:block;padding-top:10px;float:left;width:275px;">Вес: &nbsp;<?= $v->weight ?>&nbsp; г</span>


					</td>
				<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $v->id ?>">

					<td align="center" class="productListing-data">
						<input type="hidden" name="id" value="<?=$v->id?>" />
						<input type="hidden" name="ajax" value="1" class="ajax" />
<?/*						<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />*/?>
						<input type="text" maxlength="5" name="num" id="quantity<?= $v->id ?>" value="1" size="3" onchange="check_num_<?= $v->id ?>()">
					</td>
					<td align="center">
					<? if ($prod->skidka) { ?>
						<s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></s><br />
						<?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?><br />
						<span style="color:red;">Скидка -<?= $prod->skidka ?>%</span>
					<? } elseif ($_COOKIE['userdiscount']) { ?>
						<s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?></s><br />
						<?= Func::fmtmoney($prod->price * (100 - $_COOKIE['userdiscount']) / 100) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?><br />
					<? } else { ?>
						<?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $prod->inpack ?>
		<? } ?>

					</td>
					<td style="text-align:right;">
						<input type="image" src="<?=$this->path?>/img/bbuy.png" onclick="_gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']); wish_to_cart(<?= $v->id ?>); return false;" style="width: auto; height: auto; border: none;">
				</form>
				<br>
				<br>

				<form action="/user/wishlist/delete/<?= $v->id ?>" method="post" id="wishform_<?= $v->id ?>">
					<input type="hidden" name="id" value="<?= $this->prod->id ?>" />
					<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
					<button id="button_remove<?= $v->id ?>" class="button_remove" type="submit" value="Удалить">Удалить</button>
				</form>


				<br>
				</td>

				</tr>


	<? } ?>


		</table>
		<div class="listingPageLinks">
			<span style="float: right;"><?= $this->render('rule2.php') ?></span>
		</div>
		<!-- ajax end -->
	</div>
	<div class="submitFormButtons">
		<button id="button2" type="button" onclick="document.location.href='/';">На главную</button><script type="text/javascript">$("#button2").button({icons:{primary:"ui-icon-triangle-1-w"}});</script></div>

	<div class="clear"></div>

<? } ?>















