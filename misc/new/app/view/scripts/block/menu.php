<?
$model_page = new Model_Page('page');
$Menus = $model_page->getall(array("where" => "page = 0 and visible = 1", "order" => "prior desc"));
?>
<ul class="nav navbar-nav">
	<?	$i = 1;
	foreach($Menus as $k => $menu_r){?>
		<li <?if(($_SERVER['REQUEST_URI'] == "/" && $menu_r->intname == "") || ($menu_r->intname != "" && strstr($_SERVER['REQUEST_URI'], $menu_r->intname))) echo "class=\"active\"";?>><a href="<?=$this->url->mk("/".$menu_r->intname)?>"><?=$menu_r->name?></a></li>
		<?if($menu_r->intname=='') {?>
			<li class="ce-mobile"><a href="/#m-cats">Категории товаров</a></li>
		<?}?>
	<?	}?>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			Информация <span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li><a href="/info">Помощь</a></li>
			<li><a href="/skidki">Скидки</a></li>
			<li><a href="/delivery">Доставка и оплата</a></li>
			<li><a href="/comments">Отзывы</a></li>
			<li><a href="/articles">Блог</a></li>
			<li><a href="/contact">Контакты</a></li>
		</ul>
	</li>
</ul>