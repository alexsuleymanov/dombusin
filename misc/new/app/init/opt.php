<?
	$opt = array();

	$opt["news"] = 1; 				//Новости
	$opt["news_comments"] = 0; 		//Коментарии новостей

	$opt["articles"] = 1;       	//Статьи
	$opt["articles_comments"] = 0;	//Коментарии статей

	$opt["actions"] = 1;       		//Акции
	$opt["actions_comments"] = 0;	//Коментарии акций
	$opt["action_prods"] = 1;      	//Привязка товаров к акциям

	$opt["vacancy"] = 1;			//Вакансии

	$opt["prods"] = 1;				//Каталог
	$opt["prod_cats"] = 1;			//Категории товаров
	$opt["cat_tree"] = 1;			//Дерево категорий
	$opt["prod_brands"] = 1;		//Бренды
	$opt["prod_vars"] = 1;			//Варианты приобретения
	$opt["prod_chars"] = 1;			//Характеристики товаров
	$opt["char_cats"] = 0;			//Категории характеристик
	$opt["prod_photos"] = 1;		//Доп. фото товаров
	$opt["prod_comments"] = 1;		//Комментарии к товарам
	$opt["prod_childs"] = 1;		//Сопутствующие товары
	$opt["prod_analogs"] = 1;		//Похожие товары товары

	$opt["prod_tags"] = 1;			//Теги товаров
	$opt["prod_compare"] = 1;		//Сравнение товаров

	$opt["ext_search"] = 1;			//Расширенный поиск
	$opt["novinki"] = 0;			//Новинки
	$opt["sale"] = 0;				//Распродажа

	$opt["vote"] = 0;				//Голосование

	$opt["adv"] = 1;				//Доска объявлений

	$opt["photo_gallery"] = 0;		//Фотогалерея
	$opt["photo_comments"] = 0;		//Коментарии фотографий

	$opt["blog"] = 1;				//Блог

	$opt["billing"] = 1;			//Система онлайн-заказов
	$opt["discounts"] = 1;			//Система скидок

	$opt["banners"] = 1;			//Система управления баннерами

	$opt["distrib"] = 1;			//Система рассылки
	$opt["valuta"] = 1;				//Мультивалютность
	$opt["watermarks"] = 1;			//Водяные знаки

	Zend_Registry::set('opt', $opt);	