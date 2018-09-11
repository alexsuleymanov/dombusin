<div class="profile-social">
	<div class="reg-auth--soc">
		<h5>Привязать профиль<br> к социальным сетям</h5>
		<div class="soc-list__btns">
			<?=$this->render('block/facebook/login2.php')?>
			<?=$this->render('block/google/login2.php')?>
		</div>
	</div>
</div>

<h1>Мой аккаунт</h1>

<div class="moduleBox">
	<h6>Мой аккаунт</h6>

	<div class="content">
		<img src="<?=$this->path?>/img/account_.gif" alt="Мой аккаунт">

		<ul style="padding-left: 100px; list-style-image: url(templates/richer_designs/images/arrow_green.gif);">
			<li><a href="/user/profile">Посмотреть или изменить информацию о моем аккаунте</a></li>
			<li><a href="/user/change-pass">Изменить пароль моего аккаунта</a></li>
		</ul>

		<div style="clear: both;"></div>
	</div>
</div>

<div class="moduleBox">
	<h6>Мои заказы</h6>

	<div class="content">
		<img src="<?=$this->path?>/img/account0.gif" alt="Мои заказы">
		<?	if ($this->user->opt == 0) {?>
			<div style="padding-left:100px;padding-bottom:15px;">
				Вы оплатили в нашем магазине заказов на <font style="color:red"><?= Func::fmtmoney($this->order_total) . $this->sett["valuta"] ?></font>
				<br>Ваша дисконтная скидка в нашем магазине составляет <font style="color:red"><?=(0+$this->discount)?>%</font>
				<br>До следующей скидки (<?=$this->nextdiscount->name?> – <?=$this->nextdiscount->value?>%) осталось <font style="color:red"><?=$this->tonextdiscount?></font> <?=$this->sett["valuta"]?></font>
			</div>
		<?	}?>
		<ul style="padding-left: 100px; list-style-image: url(templates/richer_designs/images/arrow_green.gif);">
			<li><a href="/user/order-history">Посмотреть заказы, сделанные мной</a></li>
			<li><a href="/user/order-history/last">Посмотреть последние продукты</a></li>
			<li><a href="/user/wishlist">Посмотреть Отложенные товары</a></li>
		</ul>

		<div style="clear: both;"></div>
	</div>
</div>
<?/*
<div class="moduleBox">
	<h6>Мои уведомления</h6>

	<div class="content">
		<img src="<?=$this->path?>/img/account1.gif" alt="Мои уведомления">
		<ul style="padding-left: 100px; list-style-image: url(templates/richer_designs/images/arrow_green.gif);">
			<li><a href="/user/newsletters">Подписаться или отписаться от рассылки новостей</a></li>
			<li><a href="/user/notifications">Посмотреть или изменить мои уведомления о товарах</a></li>
		</ul>

		<div style="clear: both;"></div>
	</div>
</div>
*/?>
<div class="clear"></div>




<?= $this->page->cont ?>


