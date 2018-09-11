<?
	$model_page = new Model_Page('page');
	$Menus = $model_page->getall(array("where" => "page = 0 and visible = 1", "order" => "prior desc"));
?>
<table cellpadding="0" cellspacing="0" style="margin:0 auto;">
	<tr valign="middle">
		<td><img src="<?=$this->path?>/img/topmenu1.jpg" alt="" /></td>

<?	$i = 1;
	foreach($Menus as $k => $menu_r){
		if($i++!=1){echo "<td class='topmenutd'><span class='l17'>|</span></td>";}?>
		<td class="topmenutd"><a href="<?=$this->url->mk("/".$menu_r->intname)?>"><?=$menu_r->name?></a></td>
<?	}?>
		<td><img src="<?=$this->path?>/img/topmenu3.jpg" alt="" /></td>
	</tr>
</table>