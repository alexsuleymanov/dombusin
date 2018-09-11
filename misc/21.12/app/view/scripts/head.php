<html lang="ru_RU">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?= ($this->page->title) ? $this->page->title : $this->sett['sitename'] . ". " . $this->page->name ?></title>
		<meta name="description" content="<?= $this->page->descr ?>" />
		<meta name="keywords" content="<?= $this->page->kw ?>" />
		<link rel="Shortcut Icon" href="/favicon.ico" />


		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/jquery-u.css">
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/loadingb.css">

		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/styles.css">
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/cat-menu.css">
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/bootstra.css">
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/js/nivo-zoom/nivo-zoom.css" />
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/css/bxslider.css" />
		<link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/flickity.css" media="screen">

		<script type="text/javascript" src="<?= $this->path ?>/js/jquery00.js"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/jquery-u.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/msgwindo.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/bootstra.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/nivo-zoom/nivo-zoom.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/noobslid.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/noty/packaged/jquery.noty.packaged.min.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/noty/layouts/topCenter.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/cart.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/init.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/bxslider.min.js" async="1"></script>
		<script type="text/javascript" src="<?=$this->path?>/js/flickity.pkgd.min.js" async="1"></script>

		<script type="text/javascript">
			function addCSSRule(sheet, selector, rules, index) {
				if("insertRule" in sheet) {
					sheet.insertRule(selector + "{" + rules + "}", index);
				}
				else if("addRule" in sheet) {
					sheet.addRule(selector, rules, index);
				}
			}
			function getFancyPosition() {
				if($(window).width()>1002) {
					return ( Math.round(($(window).width() - 1002) / 2) + 320 );
				} else {
					return(320);
				}
			}

<?		if($this->args[0] != 'order'){?>
			$(window).bind('resize', function(e)
			{
				if (window.RT) clearTimeout(window.RT);
				window.RT = setTimeout(function()
				{
					this.location.reload(false);
				}, 100);
			});
<?		}?>
			$(document).ready(function(){

				<?if($this->prods){?>
				addCSSRule(document.styleSheets[0], "#fancybox-wrap", "left: "+getFancyPosition()+"px !important");
				<?}?>

				<?				if(strip_tags($this->blocks['user_message'])){?>
					var n = noty({
						text: '<?=$this->blocks['user_message']?>',
						type: 'warning',
						layout: 'topCenter',
						theme: 'relax',
						animation: {
					        open: {height: 'toggle'},
					        close: {height: 'toggle'},
					        easing: 'swing',
					        speed: 500
					    }
					});
<?				}?>
		});
	</script>

		<!-- Put this script tag to the <head> of your page -->
		<script type="text/javascript" src="<?= $this->path ?>/js/openapi0.js" async="1"></script>

		<script type="text/javascript">
//			VK.init({apiId: 3180233, onlyWidgets: true});
		</script>


		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<?= $this->sett['meta'] ?>

		<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=sMkDusYhyvQDoMR7Mix1rNh97aIuTPv2kEJFIhapaBDyihej6Gzxh/LwFgFicDLKOTbK5oUVAjpPI/5qHdLAHkEUz8ej2RZ20rup8YJmc268t1mAm4XbVZc2cFb394CR0vOXVBKREj6wmhk8quFNM0PEGougIEjlLfhtpz1cAxo-&pixel_id=1000029027';</script>
		
		<script type="text/javascript" src="<?= $this->path ?>/js/fancybox/jquery.mousewheel-3.0.4.pack.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/fancybox/jquery.fancybox-1.3.4.pack.js" async="1"></script>
		<script type="text/javascript" src="<?= $this->path ?>/js/jquery-ui.js" async="1"></script>

		<link href="<?= $this->path ?>/css/asform.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?= $this->path ?>/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

		<script type="text/javascript" src="<?= $this->path ?>/js/leanModal.js" async="1"></script>
		<script type="text/javascript">
		var modal;
		$(document).ready(function() {
			modal = $('#callback_but').leanModal({ top : 200, closeButton: ".modal_close" });

			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over'
			});

			$('.bxslider').bxSlider({
				mode: 'fade',
				pager: false
			});
		});
		</script>




<?	if($this->canonical){?>
		<link rel="canonical" href="http://www.dombusin.com<?=$this->canonical?>"/>
<?	}?>

<?	if($this->noindex){?>
		<meta name='robots' content='noindex, nofollow' />
<?	}?>

	</head>
	<body>
		<?=$this->render("block/remarketing.php")?>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-44721091-1']);
			_gaq.push(['_setDomainName', 'dombusin.com']);
			_gaq.push(['_setAllowLinker', true]);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>

		<img src="<?= $this->path ?>/img/prod_added.jpg" id="prod_added" alt="" style="top: 48%; left: 48%; position: fixed; z-index: 1000;  display: none; opacity: 0;" />
		<img src="<?= $this->path ?>/img/prod_added2.jpg" id="prod_added2" alt="" style="top: 48%; left: 48%; position: fixed; z-index: 1000;  display: none; opacity: 0;" />
<?/*			<div id="fb-root"></div>*/?>

		<div class="top-top">
			<div class="wrap-top-menu">
				<div class="enter-shop login clearfix" name="top">
				<? if ($_COOKIE['userid']) { ?>
					<a href="<?= $this->url->mk("/user") ?>" id="login_link" onclick="_gaq.push(['_trackEvent', 'Login', 'Avtorizaciya', 'Login']);"><?= $this->labels["welcome"] ?>, <?= $_COOKIE["username"] ?></a> | <a href="/user/wishlist">Список желаний</a> | <a href="/login/logoff">Выход</a>
				<? } else { ?>
					<a href="<?= $this->url->mk("/user") ?>" id="login_link" onclick="_gaq.push(['_trackEvent', 'Login', 'Avtorizaciya', 'Login']);">Вход в интернет магазин</a>
				<? } ?>
				<? if (!$_COOKIE['userid']) { ?>
					,
					<a href="<?= $this->url->mk("/register") ?>" id="registration_link" onclick="_gaq.push(['_trackEvent', 'Register', 'Reg_account', 'Register']);">Регистрация</a>
				<? } ?>
				</div>
<?//echo microtime(true) - Zend_Registry::get('start_time');?>
				<div class="top-menu">
					<ul>
						<li>
							<a href="/info"><b>Помощь</b></a>
						</li>
						<li>
							<a href="/skidki">Дисконтная программа</a>
						</li>
						<li>
							<a href="/delivery">Доставка и оплата</a>
						</li>
						<li>
							<a href="/comments">Отзывы</a>
						</li>
						<li>
							<a href="/contact">Контакты</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

			<div id="holder" class="holder clearfix">
				<div id="wrapper" class="wrapper">
					<div class="header_bottom clear">
						<a href="<?= $this->url->mk("/") ?>" class="logo"><img src="<?= $this->path ?>/img/logo2.jpg" alt="Дом бусин &quot;Изюминка&quot;" width="300"></a>

						<div class="topphones">
							<p class="phone"><span>(050)</span> 760-40-98, <span>(063)</span> 473-10-64, <span>(068)</span> 080-68-70</p>
						</div>

						<div class="search">
							<form name="search" action="<?= $this->url->mk("/search") ?>" method="get">
								<input type="text" name="q" id="keywords" class="search">
								<input type="submit" class="button" value="Поиск">
							</form>
						</div>
						<div class="cart">
<?/*							<div class="select_valuta">
								<?= $this->render('block/valutas.php') ?>
							</div>*/?>

							<img src="<?= $this->path ?>/img/cart_log.png" alt="">
							<?=$this->render('cart/block.php')?>
						</div>
					</div>
					<div class="main">
						<div class="menu">
							<?= $this->render('block/menu.php') ?>
						</div>
						<? if (($this->args[0] != 'cart') && ($this->args[0] != 'order') && (!( ($this->args[0] == 'user') && ($this->args[1] == 'order-history') && (is_numeric($this->args[2])) )) && (!( ($this->args[0] == 'user') && ($this->args[1] == 'order-history') && ($this->args[2] == 'last') )) && (!( ($this->args[0] == 'user') && ($this->args[1] == 'wishlist') ))) { ?>
							<div class="left">
								<!-- box categories start //-->
								<div class="side_menu">
									<? if ($this->args[0] == 'user') { ?>
										<div class="head_mod"><p>Мой аккаунт</p></div>
										<?= $this->render('user/head.php') ?>
									<? } elseif (((count($this->prods))||($_GET['filter']==1))&&($this->cat)) { ?>

										<?
										$opt = Zend_Registry::get('opt');
										//	par == 1  Основные параметры
										//	par == 2  Расширенные параметры
										//  par == 3  Все параметры

										$par = 0 + $this->params;
										$cat = 0 + $this->cat;

										$chars = array();
										if ($opt["prod_chars"]) {
											$Char = new Model_Char();
											if ($par == 1 || $par == 0)
												$chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat) . " and search = '1'", "order" => "prior desc"));
											else if ($par == 2)
												$chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat) . " and (search = '1' or search = '2')", "order" => "prior desc"));
											else
												$chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat) . " and (search = '1' or search = '2' or search = '3')", "order" => "prior desc"));
										}

										if (count($chars)) {
										    	$this->chars_count = count($chars);
											?>


											<div class="head_mod2">
												<p class="left-atab <?if(!count($this->prods)) echo "left-ataba";?>" onmouseover="$('p.left-atab-2').removeClass('left-atab-2a'); $(this).addClass('left-ataba'); $('.left-tab').css('display', 'none'); $('#left-tab-1').css('display', 'block')">Категории</p>
												<p class="left-atab-2 <?if(count($this->prods)) echo "left-atab-2a";?>" onmouseover="$('p.left-atab').removeClass('left-ataba'); $(this).addClass('left-atab-2a'); $('.left-tab').css('display', 'none'); $('#left-tab-2').css('display', 'block')">Фильтр</p>
											</div>
											<div class="clear"></div>
											<?echo $this->render('block/catmenu.php');//if(!$this->outputcache->start('catmenu')) {echo $this->render('block/catmenu.php'); $this->outputcache->end();}?>
											<?echo $this->render('block/extsearch.php');//if(!$this->outputcache->start('extsearch'.$this->cat)) {echo $this->render('block/extsearch.php'); $this->outputcache->end();}?>
										<? } else {
										    	$this->chars_count = count($chars);?>
											<div id="left-tab-0">
												<div class="head_mod">
													<p>
														<?if($this->args[1]==='new') {?>
															Категории новинок
														<?}elseif($this->args[1]==='pop') {?>
															Категории популярных
														<?}elseif($this->args[1]==='action') {?>
															Категории акций
														<?} else {?>
															Категории товаров
														<?}?>
													</p>
												</div>
												<?echo $this->render('block/catmenu.php');//if(!$this->outputcache->start('catmenua')) {echo $this->render('block/catmenu.php'); $this->outputcache->end();}?>
											</div>
										<? } ?>


									<? } else { ?>
										<div id="left-tab-0">
											<div class="head_mod">
												<p>
													<?if($this->args[1]==='new') {?>
														Категории новинок
													<?}elseif($this->args[1]==='pop') {?>
														Категории популярных
													<?}elseif($this->args[1]==='action') {?>
														Категории акций
													<?} else {?>
														Категории товаров
													<?}?>
												</p>
											</div>
											<?echo $this->render('block/catmenu.php');//if(!$this->outputcache->start('catmenua')) {echo $this->render('block/catmenu.php'); $this->outputcache->end();}?>
										</div>
									<? } ?>
								</div>
								<script>
								$('div.side_menu ul li ul li').has('ul').addClass("haschildren");
								</script>
								<!-- box categories end //-->
							</div>

							<div class="center">
							<? } else { ?>
								<div class="center2">
								<? } ?>
								<?	if($this->args[0] != ''){?>
								<div class="breadcrumbs" style="padding:10px 5px;">
									<?= ($this->args[0] != '') ? $this->render('block/breadcrumbs.php') : '' ?>
									<?/* if (($this->cat) && (file_exists('pic/cat/' . $this->cat . '.jpg'))) { ?>
										<img src="/thumb?src=pic/cat/<?= $this->cat ?>.jpg&amp;width=35" alt="Бусины" id="pageIcon" />
									<? }*/ ?>
								</div>
								<?	}?>

								<? if ($this->args[0] == '') { ?>
									<!-- module slide_show start //-->
									<div align="center" style="overflow: hidden; margin: 8px 0px 10px 0px;">
										<div style="overflow: hidden; height: auto; margin: 0px 0px 0px 0px; width:775px; height:247px;">
											<div class="gallery js-flickity" data-flickity-options='{ "autoPlay": 4000 }'>
												<?
												$Banner = new Model_Banner();
												$banners = $Banner->getall(array("where" => "position=1"));
												foreach ($banners as $banner) {
													?>
													<div class="gallery-cell"><?= $banner->cont ?></div>
												<? } ?>
											</div>
										</div>
									</div>

									<div class="new_post">
										<div class="head_mod"><p>Рекомендуемые категории</p></div>
										<div class="content_border">
											<?= $this->render('block/recomended-cats.php') ?>
											<div class="clear"></div>
										</div>
									</div>

									<div class="new_post">
										<div class="head_mod"><p>Новые поступления</p></div>
										<div class="content_border">
											<?= $this->render('block/newproducts.php') ?>
											<div class="clear"></div>
										</div>
									</div>

								<? } ?>

<?//echo microtime(true) - Zend_Registry::get('start_time');?>
