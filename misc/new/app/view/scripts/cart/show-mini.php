<?
	$opt = Zend_Registry::get('opt');
	if(Model_User::userid()){
		$Discount = new Model_Discount();
		$Order = new Model_Order();

		$order_total = $Order->total(Model_User::userid());
		$dictounts = $Discount->getall();
		$discount = $Discount->getnakop($view->order_total);
		$nextdiscount = $Discount->nextdiscount($view->order_total);
		$tonextdiscount = $Discount->tonextdiscount($view->order_total);
	}

	foreach($this->cart->cart as $k => $v)
		if ($v[num] < 1) $this->cart->cart[$k][num] = 1;?>
<table>
	<tr>
		<td style="text-align: right;"><h2><?=$this->labels["your_order"]?></h2></td>
	</tr>
	<tr>
		<td>

	<table width="100%" border="0" cellspacing="20" class="cart-mini">
<?	$n = $sum = 0;
	foreach($this->cart->cart as $k => $v) {
		$Prod = new Model_Prod($v['id']);
		$prod = $Prod->get();
		$title = "<a href=\"/catalog/prod-".$prod->id."\" target=\"_blank\">".$prod->name."</a>";
				
		$sum += $v['price'] * $v['num'];
		if($discount) $sum2 = $sum - ($sum * $discount) / 100;
		else $sum2 = $sum;
?>
		<tr style="background-color: <?=($w++ % 2) ? "#f0f0f0": "#ffffff";?> padding: 20px;">
			<td align="center"><img src="https://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?=$v['id']?>.jpg" width="100" alt="" /></td>
			<td>
				<span class="prod-name"><?=$title?></span><br />
				<div style="text-align: right; white-space: nowrap;">
					<span class="prod-price"><?=($v['var']) ? Func::fmtmoney($prodvar->price).$this->sett["valuta"] : Func::fmtmoney($prod->price).$this->sett["valuta"];?></span> x 
					<span class="prod-num"><?=$v['num']?> = 
					<span class="prod-price"><?=Func::fmtmoney(($v['var']) ? $prodvar->price * $v['num'] : $prod->price * $v['num']).$this->sett["valuta"]?></span>
				</div>
			</td>
		</tr>
<?	}?>

	</table>

    <p align="right" style="font-weight:bold;">
      <?if($discount) echo $this->labels["discount"].": ".$discount."%<br />";?>
      <div class="order-total"><?=$this->labels["to_pay"]?>: <?=Func::fmtmoney($sum2).$this->sett['valuta']?> </div>
    </p>
		</td>
	</tr>
</table>

