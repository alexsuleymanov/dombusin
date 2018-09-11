<?
	$adms = array(
		"Магазин" => array(
			"url" => "",
			"comment" => "Настройки магазина. Включение/отключение опций",
		),
		"Страницы" => array(
			"url" => "adm_page.php",
			"comment" => "Страницы главного меню, подменю и скрытые страницы",
		),
		"Новости" => array(
			"url" => "",
			"comment" => "Новостная лента сайта",
		),
		"Акции" => array(
			"url" => "",
			"comment" => "Управление акциями",
		),
		"Статьи" => array(
			"url" => "",
			"comment" => "Полезные статьи. Для людей и для раскрутки сайта",
		),
		"Отзывы" => array(
			"url" => "adm_comments.php?type=site",
			"comment" => "Редактирование и модерирование отзывов",
		),
		"Вакансии" => array(
			"url" => "",
			"comment" => "Вакансии. Список вакансий компании",
		),
		"Бренды" => array(
			"url" => "",
			"comment" => "Редактирование списка брендов для каталога товаров",
		),
		"Каталог" => array(
			"url" => "",
			"comment" => "Редактирование товаров и всех их свойств",
		),
		"Все товары" => array(
			"url" => "adm_prod.php",
			"comment" => "Редактирование товаров и всех их свойств",
		),
		"Импорт из 1С" => array(
			"url" => "adm_import_1c.php",
			"comment" => "Редактирование товаров и всех их свойств",
		),
		"Экспорт" => array(
			"url" => "adm_export.php",
			"comment" => "Экспорт товаров в разных форматах",
		),
		"Нераспределенные товары" => array(
			"url" => "adm_prod.php?cat=-1",
			"comment" => "Редактирование товаров и всех их свойств",
		),
		"Товары без категорий" => array(
			"url" => "adm_prod_error.php",
			"comment" => "Редактирование товаров с ошибкой. Нет категории",
		),
		"Характеристики" => array(
			"url" => "",
			"comment" => "Общие характеристики для всех категорий товаров",
		),			
		"Клиенты" => array(
			"url" => "",
			"comment" => "Зарегистрированные клиенты сайта",
		),
		"Заказы" => array(
			"url" => "",
			"comment" => "Список заказов всех клиентов",
		),
		"Менеджеры" => array(
			"url" => "adm_user.php?usertype=manager",
			"comment" => "Список менеджеров",
		),
		"Скидки" => array(
			"url" => "",
			"comment" => "Управление системой скидок. Размер скидки, размер накоплений для получения скидки",
		),
		"Голосование" => array(
			"url" => "",
			"comment" => "Редактирование списка вопросов и ответов. Результаты голосования",
		),
		"Рассылка" => array(
			"url" => "adm_distrib.php",
			"comment" => "Система рассылки",
		),
		"Фотогалерея" => array(
			"url" => "",
			"comment" => "Редактирование категорий и фотографий",
		),
		"Теги" => array(
			"url" => "",
			"comment" => "Управление облаком тегов. Список тегов",
		),
		"Блог: Категории" => array(
			"url" => "",
			"comment" => "Управление блогом. Категории",
		),
		"Блог: Статьи" => array(
			"url" => "",
			"comment" => "Управление блогом. Статьи",
		),
		"Способы оплаты" => array(
			"url" => "",
			"comment" => "Редактирование автоматических и неавтоматических способов оплаты",
		),
		"Способы доставки" => array(
			"url" => "",
			"comment" => "Редактирование способов доставки. Описания, цена доставки",
		),
		"Баннеры" => array(
			"url" => "",
			"comment" => "Система баннеров. Добавляйте все баннеры через эту систему.",
		),
		"Языки" => array(
			"url" => "",
			"comment" => "Языки сайта. Добавление, удаление, редактирование языков",
		),
		"Валюта" => array(
			"url" => "",
			"comment" => "Список всех валют на сайте с курсами",
		),
		"Администраторы" => array(
			"url" => "adm_admins.php",
			"comment" => "Изменение логина и пароля администратора, создание новых пользователей",
		),
		"Блоки" => array(
			"url" => "adm_block.php",
			"comment" => "Редактирование блоков на сайте",
		),
		"Надписи" => array(
			"url" => "adm_labels.php",
			"comment" => "Редактирование надписей на сайте",
		),
		"Шаблоны страниц" => array(
			"url" => "adm_template.php?type=page",
			"comment" => "Редактирование шаблонов страниц",
		),
		"Шаблоны писем" => array(
			"url" => "adm_template.php?type=mail",
			"comment" => "Редактирование шаблонов писем",
		),
		"Загрузка sitemap.xml" => array(
			"url" => "adm_sitemap.php",
			"comment" => "для вебмастерской",
		),
		"Настройки" => array(
			"url" => "adm_sett.php",
			"comment" => "Основные настройки сайта",
		),
		"Редиректы" => array(
			"url" => "adm_redirect.php",
			"comment" => "Редиректы для правильной смены адресов страниц",
		),
	);

 	if(Zend_Registry::get("admin_level") < 2){
 		unset($adms["Страницы"]);
 		unset($adms["Бренды"]);
 		unset($adms["Все товары"]);
 		unset($adms["Импорт из 1С"]);
 		unset($adms["Нераспределенные товары"]);
 		unset($adms["Рассылка"]);
 		unset($adms["Администраторы"]);
 		unset($adms["Блоки"]);
 		unset($adms["Надписи"]);
 		unset($adms["Шаблоны страниц"]);
 		unset($adms["Шаблоны писем"]);
 		unset($adms["Загрузка sitemap.xml"]); 
		unset($adms["Редиректы"]);
 		unset($adms["Настройки"]);

	}

	if(Zend_Registry::get('shop_id')) $adms["Магазин"]["url"] = "adm_shop.php";
	$opt = Zend_Registry::get('opt');
	if($opt['prod_chars'] && Zend_Registry::get("admin_level") > 1) $adms["Характеристики"]["url"] = "adm_char.php";
	if($opt['char_cats'] && Zend_Registry::get("admin_level") > 1) $adms["Характеристики"]["url"] = "adm_charcat.php";

	if($opt['prods'] && Zend_Registry::get("admin_level") > 1) $adms["Каталог"]["url"] = "adm_prod.php";
	if($opt['prod_brands'] && Zend_Registry::get("admin_level") > 1) $adms["Бренды"]["url"] = "adm_brand.php";

	if($opt['billing']){
		$adms["Клиенты"]["url"] = "adm_user.php?usertype=client";
		$adms["Заказы"]["url"] = "adm_order.php";
		if(Zend_Registry::get("admin_level") > 1){
			$adms["Способы оплаты"]["url"] = "adm_esystem.php";
			$adms["Способы доставки"]["url"] = "adm_delivery.php";
		}
	}

	if($opt['discounts'] && Zend_Registry::get("admin_level") > 1) $adms["Скидки"]["url"] = "adm_discount.php";

	if($opt['user_register']) $adms["Клиенты"]["url"] = "adm_user.php?usertype=client";

	if($opt['prod_brands'] && Zend_Registry::get("admin_level") > 1) $adms["Каталог"]["url"] = "adm_brand.php";
	if($opt['prod_cats'] && Zend_Registry::get("admin_level") > 1) $adms["Каталог"]["url"] = "adm_cat.php";

	if($opt['news'] && Zend_Registry::get("admin_level") > 1) $adms["Новости"]["url"] = "adm_news.php";
	if($opt['actions'] && Zend_Registry::get("admin_level") > 1) $adms["Акции"]["url"] = "adm_actions.php";
	if($opt['articles'] && Zend_Registry::get("admin_level") > 1) $adms["Статьи"]["url"] = "adm_article.php";
	if($opt['vacancy'] && Zend_Registry::get("admin_level") > 1) $adms["Вакансии"]["url"] = "adm_vacancy.php";

	if(MULTY_LANG == 1 && Zend_Registry::get("admin_level") > 1) $adms["Языки"]["url"] = "adm_lang.php";

	if($opt['vote'] && Zend_Registry::get("admin_level") > 1) $adms["Голосование"]["url"] = "adm_vote.php";
	if($opt['banners'] && Zend_Registry::get("admin_level") > 1) $adms["Баннеры"]["url"] = "adm_banner.php";
	if($opt['valuta'] && Zend_Registry::get("admin_level") > 1) $adms["Валюта"]["url"] = "adm_valuta.php";

	if($opt['blog'] && Zend_Registry::get("admin_level") > 1){
		$adms["Блог: Категории"]["url"] = "adm_blogcat.php";
		$adms["Блог: Статьи"]["url"] = "adm_blogarticles.php";
		$adms["Теги"]["url"] = "adm_tags.php";
	}

//	if($opt['adv']) $adms["Доска объявлений"]["url"] = "adm_advcat.php";
	if($opt['prod_tags'] && Zend_Registry::get("admin_level") > 1) $adms["Теги"]["url"] = "adm_tags.php";

	if($opt['photo_gallery'] && Zend_Registry::get("admin_level") > 1) $adms["Фотогалерея"]["url"] = "adm_photocat.php";

	if(Zend_Registry::get('shop_id') == 0 && Zend_Registry::get("admin_level") > 1) $adms["Администраторы"]["url"] = "adm_admins.php";
?>
				<table width="250">
<?	foreach($adms as $k => $v) {
		if ($v["url"] == '') {?>
<?/*					<tr><td><img src="/img/tr.gif" width="8" height="8"></td></tr>*/
		} else {?>
					<tr><td><a class="menu" href="<?=$v["url"]?>"><?=$k?></a><br/><?=$v['comment']?><br/><br/></td></tr>
<?		}?>
<?	}?>
				</table>
