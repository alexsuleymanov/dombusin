<?
	$model_page = new Model_Page('page');
	$Menus = $model_page->getall(array("where" => "page = 0 and visible = 1", "order" => "prior desc"));
?>
<ul>
<?	$i = 1;
	foreach($Menus as $k => $menu_r){?>
	<li <?if(($_SERVER['REQUEST_URI'] == "/" && $menu_r->intname == "") || ($menu_r->intname != "" && strstr($_SERVER['REQUEST_URI'], $menu_r->intname))) echo "class=\"active\"";?>><a href="<?=$this->url->mk("/".$menu_r->intname)?>"><?=$menu_r->name?></a></li>
<?	}?>
</ul>
