<!DOCTYPE >
<html lang="ru_RU">

	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<head>

		<meta name="google-site-verification" content="J4r-7mlAalS1trZud9ee_aZ_7xO5Ao4jeaogoWjjOcc">
		<meta http-equiv="x-ua-compatible" content="ie=9">
		<title><?= ($this->page->title) ? $this->page->title : $this->sett['sitename'] . ". " . $this->page->name ?></title>
		<meta name="description" content="<?= $this->page->descr ?>" />
		<meta name="keywords" content="<?= $this->page->kw ?>" />
		<? if (file_exists(dirname(__FILE__) . "../favicon.ico")) { ?>
			<link rel="Shortcut Icon" type="image/x-icon" href="/favicon.ico" />
		<? } ?>

		<script type="text/javascript" src="<?= $this->path ?>/js/jquery00.js"></script>
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/jquery-u.css">
		<script type="text/javascript" src="<?= $this->path ?>/js/jquery-u.js"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/msgwindo.js"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/bootstra.js"></script>

		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/loadingb.css">
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/styleshe.css">
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/bootstra.css">


		<link href="<?= $this->path ?>/css/styles00.css" media="screen" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="<?= $this->path ?>/js/noobslid.js"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/jcarouse.js"></script>
		<!-- jQuery Cart -->
		<script type="text/javascript">
			var session;
			var wait;
			var loading;
			var url;
			var data;
			var error;
			var retry;
			var b;
			var c;
			session="&osCsid=";
			wait='Ждите...';
			loading='templates/richer_designs/images/loadingfinal.gif';
			error='Ошибка';
			retry='Попробуйте еще раз.';
			b='#basket';
			c='#cart';

			function update(input)
			{
				$.showprogress(wait,'Корзина обновляется...',loading);
				data=$("#shopping_cart").serialize();
				url="checkout.php?action=cart_update"+session;
				var jqxhr = $.post(url, data)
				.success(function(msg) {
					if(msg.match(/^<!-- no product! -->/)){
						$.showprogress(error, "Нет в наличии", loading);
						input.value = input.defaultValue;
						setTimeout(function () { $.hideprogress(); }, 2500);
					}
					if ( $(b).length ){
						link=msg.match(/id=\"basket\"\>(.+?)\<\/\a\>/);
						$(b).html(link[1]);
					}
					if ( $(c).length ){
						link=msg.match(/id=\"cart\"\>(.+?)<\/div\>/);
						$(c).html(link[1]);
					}
					txt=msg.split('<!--ajax begin -->');
					txt=txt[txt.length-1];
					txt=txt.split('<!-- ajax end -->');
					txt=txt[0];
					$('#info').html(txt);
					setTimeout(function () { $.hideprogress(); },1500);
				})
				<!-- Error message -->
				.error(function() {
					$.showprogress(error, retry, loading);
					setTimeout(function () { $.hideprogress(); }, 3500);
				});
			};

			function del(key)
			{
				$.showprogress(wait,'Товар удаляется...',loading);
				url="checkout.php";
				data="action=cart_remove&item="+key+session;
				var jqxhr = $.get(url, data)
				.success(function(msg) {
					if ( $(b).length ){
						link=msg.match(/id=\"basket\"\>(.+?)\<\/\a\>/);
						$(b).html(link[1]);
					}
					if ( $(c).length ){
						link=msg.match(/id=\"cart\"\>(.+?)<\/div\>/);
						$(c).html(link[1]);
					}
					txt=msg.split('<!--ajax begin -->');
					txt=txt[txt.length-1];
					txt=txt.split('<!-- ajax end -->');
					txt=txt[0];
					$('#info').html(txt);
					setTimeout(function () { $.hideprogress(); },1500);
				})
				<!-- Error message -->
				.error(function() {
					$.showprogress(error, retry, loading);
					setTimeout(function () { $.hideprogress(); }, 3500);
				});
			};

/*			function buy(key,item)
			{
				var pNode   = typeof item.parentNode != "undefined"
					&& item.parentNode != null
					&& item.parentNode
				typeof item.parentNode.parentNode != "undefined"
					&& item.parentNode.parentNode != null
					&& item.parentNode.parentNode
					? item.parentNode.parentNode : false;

				$.showprogress(wait,'Товар добавляется в корзину...',loading);

				var quantity = "#quantity-"+key;
				var quantity = pNode  ? $(quantity,pNode) : $(quantity);

				if(pNode && !quantity.length){
					var quantity = "#quantity-"+key;
					var quantity = $(quantity);
				};

				quantity     = quantity.length ? quantity[0].value : 1;

				var wishlist = "#wishlist-"+key;
				var wishlist = pNode  ? $(wishlist,pNode) : $(wishlist);

				if(pNode && !wishlist.length){
					var wishlist = "#wishlist-"+key;
					var wishlist = $(wishlist);
				};

				wishlist     = wishlist.length ? wishlist[0].value : 0;


				url="products.php?"+key+"&quantity="+quantity;
				if (wishlist > 0){
					url += "&wishlist="+wishlist;
				}
				data="action=cart_add"+session;
				var jqxhr = $.get(url, data)
				.success(function(msg) {
					if(msg.match(/^<!-- no product! -->/)){
						$.showprogress(error, "Нет в наличии", loading);
						setTimeout(function () { $.hideprogress(); }, 3500);
					}
					if ( $(b).length ){
						link=msg.match(/id=\"basket\"\>(.+?)\<\/\a\>/);
						$(b).html(link[1]);
					}
					if ( $(c).length ){
						link=msg.match(/id=\"cart\"\>(.+?)<\/div\>/);
						$(c).html(link[1]);
					}
					if (wishlist > 0){
						url="wishlist.php";
						data="";
						var jqxhr = $.get(url, data)
						.success(function(msg) {
							txt=msg.split('<!--ajax begin -->');
							txt=txt[txt.length-1];
							txt=txt.split('<!-- ajax end -->');
							txt=txt[0];
							$('#nikitainfo').html(txt);
						});
					}
					setTimeout(function () { $.hideprogress(); },1500);
				})
				<!-- Request 2 -->
				.error(function() {
					$.showprogress(wait,'Товар добавляется...',loading);
					url="products.php?"+key;
					var jqxhr = $.get(url, data)
					.success(function(msg) {
						if ( $(b).length ){
							link=msg.match(/id=\"basket\"\>(.+?)\<\/\a\>/);
							$(b).html(link[1]);
						}
						if ( $(c).length ){
							link=msg.match(/id=\"cart\"\>(.+?)<\/div\>/);
							$(c).html(link[1]);
						}
						setTimeout(function () { $.hideprogress(); }, 1500);
					})
					<!-- Error message -->
					.error(function() {
						$.showprogress(error, retry, loading);
						setTimeout(function () { $.hideprogress(); }, 3500);
					});});
			};
*/
			// NIKITA_SP_FUNCTIONS
			function towishlist(key){
				$.showprogress(wait,'Товар добавляется в Отложенные товары',loading);
				var id = "quantity-"+key;
				var quantity = document.getElementById(id).value;
				url="products.php?"+key+"&quantity="+quantity;
				data="action=wishlist_add"+session;
				var jqxhr = $.get(url, data)
				.success(function(msg) {
					setTimeout(function () { $.hideprogress(); },1500);
				});
			};

			function removewishlist(id){
				$.showprogress(wait,'Удаление товара из списка желаний...',loading);
				url="wishlist.php?wishlist_id="+id;
				data="action=wishlist_remove"+session;
				var jqxhr = $.get(url, data)
				.success(function(msg) {
					txt=msg.split('<!--ajax begin -->');
					txt=txt[txt.length-1];
					txt=txt.split('<!-- ajax end -->');
					txt=txt[0];
					$('#nikitainfo').html(txt);
					setTimeout(function () { $.hideprogress(); },1500);
				});
			};

			function cartwish(key, id)
			{
				var eid = "products["+id+"]";
				var quantity = document.getElementById(eid).value;
				url="products.php?"+key+"&quantity="+quantity;
				data="action=wishlist_add"+session;
				var jqxhr = $.get(url, data);
				del(id);
			};
			var timer = new Array();
			function popup(key){
				clearTimeout(timer[key]);
				$('.ProDetailed'+key).show('fast');
				var current = $('.ProDetailed'+key).html();
				var notloaded = '<img src="images/ajax.gif">';
				if (current == notloaded){
					url="products.php?"+key;
					data = "";
					var jqxhr = $.get(url, data)
					.success(function(msg) {
						txt=msg.split('<!-- nikita_sp -->');
						txt=txt[2];
						txt=txt.split('<!-- nikita_sp_end -->');
						txt=txt[0];
						txt2 = txt.split('<!-- nikita -->');
						txt2 = txt2[0];
						txt3 = txt.split('<!-- nikita_end -->');
						txt3 = txt3[1];
						txt=txt2 + txt3;
						$('.ProDetailed'+key).animate({width: '550px'}, 300).html(txt);
					});
				}
			};

			function popupclose(key){
				timer[key] = setTimeout(function() {
					$('.ProDetailed'+key).fadeOut(10);
				}, 5);
			};

		</script>
		<!-- Preload image button -->
		<script type="text/javascript">
			<!--//--><![CDATA[//><!--
			var img = new Object();
			img[1] = new Image;
			img[2] = new Image;
			img[1].src = "/templates/richer_designs/buttons/images/ui-icons_f5e175_256x240.png";
			img[2].src = "/templates/richer_designs/buttons/images/ui-bg_glass_75_79c9ec_1x400.png";
			//--><!]]>
		</script>
		<script type="text/javascript">
			$(document).ready(function(){

				// hide #back-top first
				$("#back-top").hide();

				// fade in #back-top
				$(function () {
					$(window).scroll(function () {
						if ($(this).scrollTop() > 100) {
							$('#back-top').fadeIn();
						} else {
							$('#back-top').fadeOut();
						}
					});

					// scroll body to 0px on click
					$('#back-top a').click(function () {
						$('body,html').animate({
							scrollTop: 0
						}, 800);
						return false;
					});
				});

			});
		</script>

		<script type="text/javascript" src="<?= $this->path ?>/js/general0.js"></script>



		<!-- Put this script tag to the <head> of your page -->
		<script type="text/javascript" src="<?= $this->path ?>/js/openapi0.js"></script>

		<script type="text/javascript">
			VK.init({apiId: 3180233, onlyWidgets: true});
		</script>


		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<?= $this->sett['meta'] ?>


		<script type="text/javascript" src="<?=$this->path?>/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="<?=$this->path?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="<?=$this->path?>/js/jquery-ui.js"></script>

		<link href="<?= $this->path ?>/css/asform.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/niceacc/style.css" media="screen" />

		<script type="text/javascript">
		$(document).ready(function() {
			/*$("a#basket").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});*/

			$("a.group").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	0,
				'speedOut'		:	0,
				'autoDimensions'	:	false,
				'width'			:	560,
				'height'		:	'auto',
				'left'			:	50,
				'overlayShow'	:	false
			}).hover(function() {
				$(this).click();
			});

			$("a.group").mouseout(function(){
				jQuery.fancybox.close();
			});
		});



		</script>

		<script type="text/javascript">
		    $(document).ready(function(){
		        $("#link2card").click(function(){  // ID ссылки, по которой мы кликаем, в часности этот ID имеет кнопка В корзину
		        });
		    });
		</script>

		<script type="text/javascript">

		function pic2cart(id){
			$("#prodpreview"+id)
              .clone()
              .css({'position' : 'absolute', 'z-index' : '1000'})
              .prependTo("#tovar-img"+id)
			  .animate({'opacity': 0.5, 'margin-left': '800px', 'width': '50px', 'height': '50px'}, 700, function(){$(this).remove();});
		}

		function updatecart(data){
			$("#prods #val").html(data.prods);

			if(data.prods == 1)
				$("#prods #val").html(data.prods+" товар");
			if(data.prods > 1 && data.prods < 5)
				$("#prods #val").html(data.prods+" товара");
			if(data.prods == 0 || data.prods > 4)
				$("#prods #val").html(data.prods+" товаров");

			$("#amount #val2").html(data.amount);

//			alert('<?= $this->labels["prod_added_to_cart"] ?>');
		}

		function buy(id){
			pic2cart(id);
			$.post("/cart/buy", $("#prodform_"+id).serialize(), updatecart, "json");
		}
		</script>

		<link href="<?= $this->path ?>/css/style.css" rel="stylesheet" type="text/css" />

		<script type="text/javascript" src="<?= $this->path ?>/js/leanModal.js"></script>
		<script type="text/javascript">
			var modal;
			$(document).ready(function() {
				modal = $('#callback_but').leanModal({ top : 200, closeButton: ".modal_close" });

				$("a[rel=example_group]").fancybox({
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'titlePosition' 	: 'over'
				});
			});
		</script>

	</head>
	<body>
		<?
		if ($_GET['iframe'] == 1) {
			echo $this->render("iframe/head.php");
		} else {
			?>

			<div id="fb-root"></div>
			<div id="holder" class="holder clearfix">
				<div id="wrapper" class="wrapper">
					<div class="header">
						<div class="header_inner">
							<div class="phones at top clearfix">
								<p class="phone">(050) 760-40-98, (063) 473-10-64, (068) 080-68-70</p>
								<p class="callback"><a class="callbacklink" onclick="$('#callbackModal').modal();return false;" href="<?= $this->url->mk("/callback") ?>">Заказать обратный звонок</a></p>					</div>
						</div>
					</div>
					<div class="login clearfix" name="top">
						<a href="<?= $this->url->mk("/user") ?>" id="login_link">
							<? if (Model_User::userid()) { ?>
								<?= $this->labels["welcome"] ?>, <?= $_SESSION['username'] ?>
							<? } else { ?>
								Вход в интернет магазин
							<? } ?>
						</a>
						<? if (!Model_User::userid()) { ?>
							,
							<a href="<?= $this->url->mk("/register") ?>" id="registration_link">Регистрация</a>
						<? } ?>
					</div>
					<div class="header-right">

						<!-- box currencies start //-->

						<div class="select_val">
							<div class="head_mod"><p>Выбрать валюту</p></div>
							<?= $this->render('block/valutas.php') ?>
						</div>

						<!-- box currencies end //-->
					</div>
					<div class="header_menu clear clearfix">
						<ul>
							<li class="first"><a href="<?= $this->url->mk("/user") ?>">Мой аккаунт</a></li>
							<li><a href="<?= $this->url->mk("/wishlist") ?>">Отложенные товары</a></li>
							<li><a href="<?= $this->url->mk("/info") ?>">Помощь</a></li>
							<li class="last"><a href="<?= $this->url->mk("/contact") ?>">Связаться с нами</a></li>
						</ul>
					</div>

					<div class="header_bottom clear">
						<a href="<?= $this->url->mk("/") ?>" class="logo"><img src="<?= $this->path ?>/img/logo0000.png" alt="Дом бусин &quot;Изюминка&quot;"></a>
						<div class="search">
							<form name="search" action="<?= $this->url->mk("/search") ?>" method="get">
								<input type="text" name="q" id="keywords" class="search">				 <input type="submit" class="button" value="Поиск">
							</form>
						</div>
						<div class="sub_menu">
							<ul>
								<li class="delivery">
									<a href="<?= $this->url->mk("/delivery") ?>">Доставка</a></li>
								<li class="payment">
									<nobr><a href="<?= $this->url->mk("/back") ?>">Возврат товара</a></nobr></li>
								<li class="discounts">
									<a href="<?= $this->url->mk("/skidki") ?>">Скидки</a></li>
								<li class="franchising">
									<a href="<?= $this->url->mk("/franchajzing") ?>">Франчайзинг</a></li>
							</ul>
						</div>
						<div class="cart">
							<img src="<?= $this->path ?>/img/cart_log.png" alt="">
							<p><?= $this->render('cart/block.php') ?></p>
						</div>
					</div>
					<div class="main">
						<div class="menu">
							<?= $this->render('block/menu.php') ?>
						</div>
						<?if(($this->args[0]!='cart')&&($this->args[0]!='order')&&(!( ($this->args[0]=='user')&&($this->args[1]=='order-history')&&(is_numeric($this->args[2])) ))&&(!( ($this->args[0]=='user')&&($this->args[1]=='order-history')&&($this->args[2]=='last') ))&&(!( ($this->args[0]=='user')&&($this->args[1]=='wishlist') )) ){?>
						<div class="left">
							<!-- box categories start //-->
							<div class="side_menu">
								<?if($this->args[0]=='user') {?>
								<div class="head_mod"><p>Мой аккаунт</p></div>
								<?=$this->render('user/head.php')?>
								<?} else {?>
								<div class="head_mod"><p>Категории</p></div>
								<?= $this->render('block/catmenu.php') ?>
								<?}?>
							</div>
							<script>
							$('div.side_menu ul li ul li').has('ul').addClass("haschildren");
							</script>
							<!-- box categories end //-->


							<?if(count($this->prods)) {?>
							<?//=$this->render('block/extsearch.php')?>
							<?}?>
<?/*
							<div class="new_tovar">
								<div class="head_mod"><p><a href="<?= $this->url->mk('/catalog') ?>">Новые товары</a></p></div>

								<div style="align:center;background-color:#DFDFDF;">
									<div class="jCarouselLite_b">
										<?= $this->render('block/newproducts.php') ?>
									</div>
									<script ty