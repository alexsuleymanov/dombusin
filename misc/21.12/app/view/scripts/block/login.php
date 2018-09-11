<? if ($_COOKIE['userid']) { ?>
	<form action="/login/logoff" method="post" name="loginform">
		<table cellspacing="5" cellpadding="0" border="0" style="width:185px">
			<tr valign="middle">
				<td colspan="2" style="height:22px;"><strong class="loginh"><?= $this->labels["welcome"] ?>, <?= $_COOKIE["username"] ?></strong></td>
			</tr>
			<tr align="center">
				<td>
					<p style="margin: 10px 0 0 0;">
					<input type="button" id="lf_b1" value="Личный кабинет" onclick="location.href = '/user';">
					<script type="text/javascript">$("#lf_b1").button({icons:{primary:"ui-icon-key"}});</script>
					</p>
					<p style="margin: 10px 0 0 0;">
						<input type="submit" id="lf_b2" value="Выйти">
						<script type="text/javascript">$("#lf_b2").button({icons:{primary:"ui-icon-key"}});</script>
					</p>
				</td>
			</tr>
		</table>
	</form>
<? } else { ?>
	<h3>
		Авторизация
	</h3>
	<form action="/login" method="post" name="loginform">
		<input type="hidden" name="submit" value="1">
		<ol>
			<li class="enter_address">
				<label for="email_address_1" style="width: 100px;">E-mail:</label>
				<input type="text" name="login" id="email_address_1" onsubmit="loginform.submit();" style="width: 200px;">
			</li>
			<li class="enter_password">
				<label for="password_2" style="width: 100px;"><?= $this->labels["password"] ?>:</label>
				<input type="password" name="pass" id="password_2" onsubmit="loginform.submit();" style="width: 200px;">
			</li>
			<li class="site_login">
				<button id="button1" type="submit">Войти</button>
				<script type="text/javascript">$("#button1").button({icons:{primary:"ui-icon-key"}});</script>
			</li>
			<li>&nbsp;</li>
			<li class="forgot_password">
				Забыли пароль? <a href="/login/remind">Нажмите сюда</a>.
			</li>
		</ol>
	</form>
<? } ?>
