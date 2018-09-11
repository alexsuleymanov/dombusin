<div style="float:right">
<table cellpadding="0" cellspacing="0">
	<tr valign="top">

<?
	$model_page = new Model_Page('page');
	$Menus = $model_page->getall(array("where" => "page = 0 and visible = 1", "order" => "prior desc"));
?>
<?	$i = 1;
	foreach($Menus as $k => $menu_r){
		if($i++!=1){echo "<td>&nbsp;|&nbsp;</td>";}?>
		<td><a href="<?=$this->url->mk("/".$menu_r->intname)?>"><?=$menu_r->name?></a></td>
<?	}?>

	</tr>
</table>
</div>