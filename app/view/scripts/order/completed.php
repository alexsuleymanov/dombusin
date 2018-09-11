<center>
<h1>Спасибо за Ваш заказ!</h1>
<?/*<img src="<?=$this->path?>/img/order_maked.png" alt="" />*/?>

<p style="font-size: 16px;"><b>Заказ №<?=$this->order_id?> отправлен в обработку.</b></p>
<p style="font-size: 16px;">Наш менеджер свяжется с вами в ближайшее время.</p>
<p style="font-size: 16px;">Копия заказа отправлена на Ваш e-mail. Также Вы можете посмотреть заказ и его текущий статус в <a href="/user">личном кабинете</a>.</p>

<br /><br />
</center>

<?/*
<script type="text/javascript">
	ga('require', 'ecommerce');
	ga('ecommerce:addTransaction', {
		'id': '<?=$this->order_id?>',
		'affiliation': '<?=$this->sett['sitename']?>',
		'revenue': '<?=Func::fmtmoney($this->order_sum)?>',
		'shipping': '0',
		'tax': '0',
		'currency': 'UAH'
	});
<?	foreach($this->cartitems as $item){
		$Prod = new Model_Prod($item['id']);
		$prod = $Prod->get();		
		$cat = $Prod->getcat();
?>
	ga('ecommerce:addItem', {
		'id': '<?=$this->order_id?>',
		'name': '<?=$prod->name?>',
		'sku': '<?=$prod->art?>',
		'category': '<?=$cat->name?>',
		'price': '<?=Func::fmtmoney($item['price'])?>',
		'quantity': '<?=$item['num']?>'
	});
<?	}?>
	ga('ecommerce:send');
</script>
*/?>
<script type="text/javascript">
(window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() {
    try { 
      rrApi.order({
         transaction: <?=$this->order_id?>,
         items: [
<?	foreach($this->cartitems as $k => $item){
		$Prod = new Model_Prod($item['id']);
		$prod = $Prod->get();		
		$cat = $Prod->getcat();
?>			 
            { id: <?=$item['id']?>, qnt: <?=$item['num']?>, price: <?=$item['price']?> }<?if($k < (count($this->cartitems)-1)) echo ",";?>
<?	}?>	
         ]
      });
    } catch(e) {} 
})
</script>