<? if ((is_array($this->wishlist)) && (count($this->wishlist))) { ?>

	<div>
		<table class="table table-bordered table-cart">
			<thead>
			<tr>
				<th class="ce-img"><?= $this->labels["photo"] ?></th>
				<th><?= $this->labels['title'] ?></th>
				<th class="ce-wide"><?= $this->labels['price'] ?></th>
				<th class="ce-wide">Кол-во</th>
				<th>Действие</th>
			</tr>
			</thead>
			<tbody>

			<?
			foreach ($this->wl as $v) {
				$Prod = new Model_Prod($v->prod);
				$prod = $Prod->get($v->prod);
				
				$title = "<a href=\"/catalog/prod-" . $prod->id . "\" target=\"_blank\">" . $prod->name . "</a>";
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
				
				?>
				<tr class="ce<?= $w++ % 2 ?>">
					<td align="center" class="ce-img"><img src="/pic/prod/<?= $prod->id ?>.jpg" alt="" /></td>
					<td align="left" valign="top" class="cezt">
						<span style="display:block;"><?= $title ?></span>
						<span class="weight" style="display:block;padding-top:10px;float:left;">Вес: &nbsp;<?= $weight ?>&nbsp; г</span>
					</td>
					<td align="center" class="ce-wide">
						<nobr><?= Func::fmtmoney($price) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></nobr>
					</td>
					<form action="/user/wishlist/delete/<?=$v->id?>" method="post" id="wishform_<?= $v->id ?>">

					<td align="center" class="productListing-data ce-wide">
						<input type="text" maxlength="5" name="num" id="quantity<?= $v->id ?>" value="1" size="3" onchange="check_num_<?= $v->id ?>()" class="form-control" style="text-align: center;">
					</td>
					<td style="text-align:right;">						
							<button class="btn btn-theme m-b-1 cart_button" title="Добавить в корзину" type="button" onclick="ga('send', 'event', 'Buy', 'Click_buy'); wish_to_cart(<?= $v->id ?>); return false;"><i class="fa fa-shopping-cart"></i></button>
							<input type="hidden" name="id" value="<?= $v->prod ?>" />
							<input type="hidden" name="var" value="<?= $v->var ?>" />
							<input type="hidden" name="ajax" value="1" class="ajax" />
							<input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
							<button id="button_remove<?= $v->id ?>" class="btn btn-theme m-b-1 cart_button" type="submit" title="Удалить"><i class="fa fa-trash"></i></button>					
					</td>
					</form>
				</tr>
			<? } ?>

			</tbody>
		</table>
		<div class="listingPageLinks">
			<span style="float: right;"><?= $this->render('rule.php') ?></span>
		</div>
		<!-- ajax end -->
	</div>
	<div class="clear"></div>
	<nav aria-label="Shopping Cart Next Navigation">
		<ul class="pager">
			<li class="previous"><a href="/"><span aria-hidden="true">&larr;</span> На главную</a></li>
		</ul>
	</nav>

<? } ?>









