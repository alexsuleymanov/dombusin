<?
	$Order = new Model_Order();
	$orders = $Order->getall(array("where" => "user = '".data_base::nq($_COOKIE['userid'])."'", "order" => "tstamp desc"));
	$ocount = array(0,0,0,0,0,0,0,0,0,0,0,0);
	foreach($orders as $order) {
		$ocount[$order->status]++;
	}
?>
<div class="column-box-contents">
	<strong>Заказы:</strong><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""><a href="/user/order-history/status/4">Обрабатывается (<?=$ocount[4]?>)</a><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""><a href="/user/order-history/status/5">Собирается (<?=$ocount[5]?>)</a><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""><a href="/user/order-history/status/2">Собран (<?=$ocount[2]?>)</a><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""><a href="/user/order-history/status/1">Отправлен (<?=$ocount[1]?>)</a><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""><a href="/user/order-history/status/7">Оплачен (<?=$ocount[7]?>)</a><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""><a href="/user/order-history/status/6">Отменен (<?=$ocount[6]?>)</a><br>&nbsp;
	<strong>Персонализация:</strong><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""> <a href="/user/wishlist">Отложенные товары</a><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""> <a href="/user/order-history">История</a><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""> <a href="/user/profile">Инфо аккаунта</a><br>&nbsp;
	<img src="<?=$this->path?>/img/arrow_gr.png" alt=""> <a href="/user/change-pass">Смена пароля</a><br>
</div>


