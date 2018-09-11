<?
	$model_cat = new Model_Cat();
	$Menus = $model_cat->getall(array("where" => "cat = 0 and visible = 1 and prior > 500", "order" => "prior desc"));
?>
<table cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td class="footspace"></td>
	</tr>
	<tr valign="top">
		<td style="width:15px;"></td>
<?	$i = 1;
	foreach($Menus as $k => $menu_r){?>
		<td class="menu3">
			<a href="/catalog/cat-<?=$menu_r->id?>-<?=$menu_r->intname?>"><?=$menu_r->name?></a>
			<table cellpadding="0" cellspacing="0" class="menu311">
		<?
		$Menus = $model_cat->getall(array("where" => "cat = ".$menu_r->id." and visible = 1", "order" => "prior desc"));
		foreach($Menus as $k => $menu_r){?>
			<tr valign="middle">
				<td class="menu31"><a href="/catalog/cat-<?=$menu_r->id?>-<?=$menu_r->intname?>"><?=$menu_r->name?></a></td>
			</tr>
		<?	}?>
			</table>
		</td>
<?	}?>
	</tr>
	<tr valign="top">
		<td class="footspace3"></td>
	</tr>
</table>
