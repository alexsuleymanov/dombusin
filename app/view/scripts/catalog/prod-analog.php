<? if (count($this->analogs)) { ?>
	<!-- Related Products -->
	<div class="row m-t-3">
		<div class="col-xs-12">
			<div class="title"><span>Похожие товары</span></div>
			<div class="related-product-slider owl-controls-top-offset">
				<? foreach ($this->analogs as $prod) {?>
					<div class="box-product-outer">
						<div class="box-product">
							<script>
								function check_num_<?=$prod->id?>(){
									var num_na_sklade = <?=0+$prod->num?>;
									var num_in_cart = <?=0+$_SESSION['cart'][$prod->id."_0"]['num']?>;
									var num = num_in_cart + parseInt($("#quantity<?=$prod->id?>").val());

									if(num_na_sklade < num){
										$("#quantity<?=$prod->id?>").val(num_na_sklade-num_in_cart);
										alert("На складе есть не более "+num_na_sklade+" упаковок(ка)");
										return false;
									}
								}
							</script>
							<div class="img-wrapper">
								<a href="/catalog/prod-<?= $prod->id ?>">
									<?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
										<img alt="<?=$prod->name?>" src="/pic/prod/<?= $prod->id ?>.jpg">
									<?} else {?>
										<img alt="Product" src="<?=$this->path?>/img/tr.gif">
									<?}?>
								</a>
							</div>
							<? if ($prod->pop) { ?>
								<div class="pc-hot"></div>
							<? } ?>
							<? if ($prod->skidka) { ?>
								<div class="pc-skidka"><?="-".$prod->skidka."%" ?></div>
							<? } ?>
							<?	if($prod->new){?>
								<div class="pc-new"></div>
							<?	}?>
							<h6><a href="/catalog/prod-<?= $prod->id ?>"><?=$prod->name?></a></h6>
							<div class="price">
								<div>
									<?if(AS_Discount::getUserDiscount() > 0) { ?>
										<span style="font-size: 14px;"><s><?= Func::fmtmoney($prod->price) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?>&nbsp;</s></span>
										<span><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($prod->price*(100-AS_Discount::getUserDiscount())/100) ?>&nbsp;<?=$this->valuta['name']?></span> / <?= $prod->inpack ?>&nbsp;</span>
									<?	}else{?>
										<span style="font-size: 14px;"><?= Func::fmtmoney($prod->price * (100-$prod->skidka)/100) ?>&nbsp;<?=$this->valuta['name']?> / <?= $prod->inpack ?></span>
									<?	}?>
								</div>
							</div>
							<form action="<?=$this->url->gvar("buy=1")?>" method="post" id="prodform_<?=$prod->id?>">
								<input type="hidden" name="id" value="<?=$prod->id?>" />
								<input type="hidden" name="ajax" value="1" class="ajax" />
								<input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
								<div class="col-md-3 col-xs-3 col-nopadding">
									<input type="text" maxlength="5" name="num" id="quantity<?=$prod->id?>" value="1" onchange="check_num_<?=$prod->id?>()" class="form-control text-center">
								</div>
								<div class="col-md-9 col-xs-9 col-nopadding">
									<button class="btn btn-theme m-b-1 form-control" type="button" onmousedown="try { rrApi.addToBasket(<?=$prod->id?>) } catch(e) {}" onclick="buy(<?=$prod->id?>); return false;"><i class="fa fa-shopping-cart"></i> В корзину</button>
								</div>
								<div class="clearfix"></div>
							</form>
						</div>
					</div>
				<? } ?>
			</div>
		</div>
	</div>
	<!-- End Related Products -->
<?}?>
