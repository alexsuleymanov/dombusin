<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/style.css">
</head>
<body height="100%">
	<table width="100%" height="100%" cellspacing=0 cellpadding=8 border="0">
		<tr>
			<td align="center" height="200"><img src="<?=$this->path?>/img/asweb_logo.jpg"><br><br><br><br></td>
		</tr>
		<tr>
			<td align="center" valign="top">
			<table style="background-color: #f0f0f0;" cellspacing="5">
<?	if ($this->err != "") {?>
				<tr>
					<td colspan=2 align=center><font color=red><b><?=$this->err?></b></font></td>
<?	}?>
				</tr>
				<tr>
					<form action="" method="post">
					<input type="hidden" name="auth" value="1" />
					<td>Имя пользователя</td>
					<td><input type=text name="login"></td>
				</tr>
				<tr>
					<td>Пароль</td>
					<td><input type=password name="pass"></td>
				</tr>
				<tr>
					<td colspan=2 align=center><input type=submit name="" value="Вход"></td>
				</tr>
				</form>
			</table>
			<br><br><br>
		</tr>
		<tr>
			<td height=1% style="background-color: #000000; border-top: 1px solid #999999; color: #666666; font-size: 11px; font-weight: bold; text-align: right" colspan=2>
				<a href="http://asweb.com.ua" style="color: #666666; font-size: 14px; font-weight: bold;"><img src="<?=$this->path?>/img/suleymanov.jpg" alt="александр сулейманов" align="absmiddle"></a>
			</td>
		</tr>
	</table>
</body>
</html>
