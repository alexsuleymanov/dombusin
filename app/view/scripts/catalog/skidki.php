<br />
<div class="content" id="discountPolicy2">
	<table width="100%">
		<tr>
			<td><b><span style="text-decoration: underline;">Условия для получения скидок в магазине:</span></b><br /><br /></td>
		</tr>
		<?
		$Discount = new Model_Discount();
		$discounts = $Discount->getall(array("order" => "value asc"));
		foreach ($discounts as $discount) {
		?>
		<tr><td>Покупка товаров на сумму ≥ <?= Func::fmtmoney($discount->nakop) ?> <?=$this->valuta->name?>. (любых товаров), гарантирует Вам <?=$discount->value?>% скидку.</td></tr>
		<?}?>
	</table>
	<br />
</div>