<h4>Вход в интернет-магазин</h4>
<div class="row">
	<div class="col-sm-6">
		<form action="/login" method="post" name="loginform">
			<input type="hidden" name="submit" value="1">
			<div class="form-group">
				<label for="username">E-mail</label>
				<input type="text" class="form-control" id="username" name="login" onsubmit="loginform.submit();">
			</div>
			<div class="form-group">
				<label for="password"><?= $this->labels["password"] ?></label>
				<input type="password" class="form-control" id="password" name="pass" onsubmit="loginform.submit();">
				<a href="/login/remind" style="display: block; margin-top: 0.5em;">Напомнить пароль</a>
			</div>

			<button type="submit" class="btn-login">Войти</button>
			<a href="#" onclick="$(body).click(); return false;">&nbsp;Отмена</a>

		</form>

	</div>
	<div class="col-sm-1 blo-1">
		<div style="position: absolute; left: 9px; top: 70px; background: #fff;">или</div>
		<div style="height: 200px; border-right: 1px solid #ddd; width: 1px; margin: 0 auto;"></div>
	</div>
	<div class="col-sm-5 blo-2">
		<label>Войти как пользователь</label>
		<div class="reg-auth--soc">
			<div class="soc-list__btns">
				<?=$this->render('block/facebook/login.php')?>
				<?=$this->render('block/google/login.php')?>
			</div>
		</div>
		<a href="/register" class="bloa-1">Зарегистрироваться</a>
	</div>

</div>