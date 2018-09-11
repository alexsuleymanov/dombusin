			<div>
				<? $i = 0;
				foreach ($this->prods as $prod) { ?>
					<? if ($i++ % 3 == 0) { ?>
						<div style="width: 100%; font-size:12px; float: none; clear: both; padding: 5px 0;">
						<? } ?>
						<div style="float: left; width: 247px; margin-right: 10px; padding-bottom: 20px;" id="tovar-img<?= $prod->id ?>">
							<div style="height: 240px; width: 247px; overflow: hidden;">
								<a href="http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?= $prod->id ?>" style="display:block;width:247%;height:240%;position:relative;">
									<img src="http://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?= $prod->id ?>.jpg" width="245" alt="<?= $prod->name ?>" style="position:relative;max-height:100%;max-width:100%">
								</a>
							</div>
							<div style="height: 40px;">
								<a href="http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?= $prod->id ?>" title="<?= $prod->name ?>"><?= substr($prod->name, 0, strpos($prod->name, ",", 50)) . "..." ?></a>
							</div>
							<div style="padding: 5px 0 5px 0;">
								<? if ($prod->skidka) { ?>
									<font style="text-decoration: line-through; font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></font><br>
									<span style="display:block;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span><span class="count products in pack"> / <?= $prod->inpack ?></span></span>
								<? } else { ?>
									<span style="display:block;"><span style="color:red; font-size: 14px;"><?= Func::fmtmoney($prod->price) ?>&nbsp;<?= $this->valuta['name'] ?><span class="count products in pack"> / <?= $prod->inpack ?></span></span></span>
								<? } ?>
							</div>

							<div>
								<a href="http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?= $prod->id ?>"><img src="http://<?=$_SERVER['HTTP_HOST']?>/app/view/img/bbuy.png" style="margin: 0 0 0 20px; vertical-align: middle">
							</div>
						</div>
						<? if ($i % 3 == 0) { ?>
						</div>
					<? } ?>

				<? } ?>
				<? if ($i % 3 != 0) { ?>
				</div>
				<? } ?>
			</div>
			<div style="clear: both;"></div>

