<div class="cart_block" onclick="location.href='/cart';" style="cursor: pointer;">
	<div id="prods">
		В корзине: 
		<span id="val" class="cart_num"><?= 0 + $this->cart->prod_num(); ?> <?if($this->cart->prod_num() == 1) echo "товар"; if($this->cart->prod_num() > 1 && $this->cart->prod_num() < 5) echo "товара"; if($this->cart->prod_num() > 4) echo "товаров";?></span>
	</div>
	<div id="amount">На сумму: <span id="val2" class="cart_amount"><?= Func::fmtmoney(0 + $this->cart->amount()); ?></span> <?= $this->valuta['name'] ?></div>
</div>
<?/*<div class="cart_minorder">Минимальный заказ 2000 грн</div>*/?>
