<?
$_GET["redirect"] = "/order/confirm";
echo $this->page->cont;
?>

<h4>Личные данные</h4>
<div class="row order-row">
	<div class="col-sm-8">
		<div class="order-step active"><span><span>1</span></span>&nbsp;&nbsp;<strong>Личная информация</strong></div>
		<div class="order-step-cont active">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<? if (!Model_User::userid()) { ?>
					<li role="presentation" class="active"><a href="#newp" aria-controls="desc" role="tab" data-toggle="tab">Я новый покупатель</a></li>
				<?}?>
				<li role="presentation"<? if (Model_User::userid()) { ?> class="active"<?}?>><a href="#regp" aria-controls="detail" role="tab" data-toggle="tab">Я зарегистрированный покупатель</a></li>
			</ul>
			<!-- End Nav tabs -->

			<!-- Tab panes -->
			<div class="tab-content tab-content-detail">

				<!-- Description Tab Content -->
				<div role="tabpanel" class="tab-pane<? if (!Model_User::userid()) { ?> active<?}?>" id="newp">
					<div class="well">
						<?//echo $this->registerform->render($this);?>
						<form>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group row">
										<div class="col-md-3">
											<label for="name">Ваше имя</label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" name="name">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-3">
											<label for="surname">Фамилия</label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" name="surname">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-3">
											<label for="city">Город</label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" name="city">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-3">
											<label for="email">Электронная почта</label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" name="email">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-3">
											<label for="phone">Номер телефона</label>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" name="phone" id="anketa_phone">
										</div>
									</div>

									<button type="button" class="btn btn-theme m-b-1 active focus pull-right">Далее</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- End Description Tab Content -->

				<!-- Detail Tab Content -->
				<div role="tabpanel" class="tab-pane<? if (Model_User::userid()) { ?> active<?}?>" id="regp">
					<div class="well">
						<? if (Model_User::userid()) { ?>
							<form>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<div class="col-md-3">
												<label for="name">Ваше имя</label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" name="name">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-3">
												<label for="surname">Фамилия</label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" name="surname">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-3">
												<label for="city">Город</label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" name="city">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-3">
												<label for="email">Электронная почта</label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" name="email">
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-3">
												<label for="phone">Номер телефона</label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" name="phone" id="anketa_phone">
											</div>
										</div>

										<button type="button" class="btn btn-theme m-b-1 active focus pull-right">Далее</button>
									</div>
								</div>
							</form>
						<?} else {?>
							<?//echo $this->loginform->render($this);?>
							<?=$this->render('block/login.php')?>
						<?}?>
					</div>
				</div>
				<!-- End Detail Tab Content -->

			</div>
			<!-- End Tab panes -->

		</div>
		<div class="order-step"><span><span>2</span></span>&nbsp;&nbsp;<strong>Информация о доставке</strong></div>
		<div class="order-step-cont"></div>
		<div class="order-step"><span><span>3</span></span>&nbsp;&nbsp;<strong>Информация об оплате</strong></div>
		<div class="order-step-cont"></div>
		<div class="order-step"><span><span>4</span></span>&nbsp;&nbsp;<strong>Спасибо за заказ</strong></div>
	</div>
	<div class="col-sm-4">
		<?=$this->render('order/block.php')?>
	</div>
</div>