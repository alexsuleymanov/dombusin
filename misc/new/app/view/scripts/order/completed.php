<!--<center>
<h1><?=$this->labels["order_maked"]?></h1>
<img src="<?=$this->path?>/img/order_maked.png" alt="" />
<br /><br />
<a href="/">Продолжить покупки</a>
<?=$this->labels["you_will_be_redirected_to_order_history"]?>
</center>

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
</script>-->

<?
$_GET["redirect"] = "/order/confirm";
echo $this->page->cont;
?>

<h4>Личные данные</h4>
<div class="row order-row">
	<div class="col-sm-8">
		<div class="order-step"><span><span>1</span></span>&nbsp;&nbsp;<strong>Личная информация</strong></div>
		<div class="order-step-cont"></div>
		<div class="order-step"><span><span>2</span></span>&nbsp;&nbsp;<strong>Информация о доставке</strong></div>
		<div class="order-step-cont"></div>
		<div class="order-step"><span><span>3</span></span>&nbsp;&nbsp;<strong>Информация об оплате</strong></div>
		<div class="order-step-cont"></div>
		<div class="order-step active"><span><span>4</span></span>&nbsp;&nbsp;<strong>Спасибо за заказ</strong></div>
		<div class="order-step-cont active">
			<div class="order-step-block">
				<p>Заказ №0 отправлен в обработку</p>
				<p>Наш менеджер свяжется с вами в ближайшее время</p>
				<p><a href="<?=$this->url->mk('/user')?>">Личный кабинет</a></p>
				<p><a href="<?=$this->url->mk('/')?>" type="button" class="btn btn-theme m-b-1 active focus pull-right">Завершить</a></p>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<?=$this->render('order/block.php')?>
	</div>
</div>