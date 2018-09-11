<form action="/login" method="post" name="loginform">
	<input type="hidden" name="submit" value="1">
	<div class="form-group">
		<label for="username">E-mail</label>
		<input type="text" class="form-control" id="username" name="login" onsubmit="loginform.submit();">
	</div>
	<div class="form-group">
		<label for="password"><?= $this->labels["password"] ?></label>
		<input type="password" class="form-control" id="password" name="pass" onsubmit="loginform.submit();">
	</div>
	<button type="submit" class="btn btn-default btn-sm"><i class="fa fa-long-arrow-right"></i> Войти</button>
	<a class="btn btn-default btn-sm pull-right" href="/login/remind" role="button">Забыли пароль?</a>
</form>