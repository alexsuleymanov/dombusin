<?
	$model_page = new Model_Page('page');
	$Menus = $model_page->getall(array("where" => "page = 0 and visible = 1", "order" => "prior desc"));
?>
<table height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
<?	$i = 1;
	foreach($Menus as $k => $menu_r){?>
		<td class="menu<?=($menu_r->intname == $this->args[0]) ? "2" : ""?>"><a href="<?=$this->url->mk("/".$menu_r->intname)?>"><?=$menu_r->name?></a></td>
		<td width="1"><img src="/img/tr.gif" width="1"></td>
<?	}?>
	</tr>
</table>
