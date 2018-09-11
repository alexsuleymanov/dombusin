<?	
	header("Last-Modified: ".date("D, d M Y H:i:s GMT"));
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/style.css">
	<script type="text/javascript" src="<?=$this->path?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/ajaxupload.js"></script>

	<script type="text/javascript" src="<?=$this->path?>/js/autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/autocomplete/jquery.autocomplete.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=$this->path?>/js/autocomplete/jquery.autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="<?=$this->path?>/js/autocomplete/lib/thickbox.css" />

</head>
<body height="100%">
	<table width="100%" height="100%" cellspacing="0" cellpadding="8">
		<tr>
			<td colspan="2" bgcolor="#f0f0f0" height="20" align="right">
				Администрирование&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="/admin/auth.php?action=logout">Выход</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		<tr>
			<td height=1% style="font-size: 26px; font-weight: bold; padding: 4px; padding-left: 0px; padding-top: 10px;" colspan="2">
				<table width="100%" border="0">
					<tr>
						<td width="250"><img src="<?=$this->path?>/img/asweb_logo.jpg" width="200"></td>
						<td style="padding-left: 20px;"><h1><?=$this->title?></h1></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="250" valign="top" style="padding: 20px 0px 10px 10px;"><?echo $this->render('menu.php');?></td>
			<td valign="top" style="border-top: 1px solid #999999; border-left: 1px solid #999999; padding: 20px;">
