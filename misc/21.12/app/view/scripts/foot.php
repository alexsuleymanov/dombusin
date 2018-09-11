<p>&nbsp;</p>
<p>&nbsp;</p>
<?//echo microtime(true) - Zend_Registry::get('start_time');?>
				<div class="clear"></div>
									</div>

				<div class="menu_bottom">
				</div>
			</div>
			<p class="copyright">
			 <?//=$this->render("block/google-bc.php");?>
			 Copyright &copy; 2013 Дом бусин<br>
<?/*Metrika*/?>


		<noindex>
	<div id="login_form_wrapper" class="clearfix" style="left: 0px;">
		<div id="login_form" class="clearfix">
			<?=$this->render('block/login.php')?>
		</div>
	</div>
	</noindex>
	<script type="text/javascript">
	//<!--
		window.popoverHide = false;
		$(document).ready(function(){

			if($('#login_link').length && $('#login_form_wrapper').length){
				var iHtml = $('#login_form_wrapper')[0].innerHTML;
				$('#login_link').popover({
						html: true,
						placement: 'bottom',
						content: iHtml
				});
				$('#login_link').popover('hide');
				$('#login_link').bind('click',function(event){
					if($('#registration_link').length){
						$('#registration_link').popover('hide');
					};
					$('#holder').unbind('click');
					$('#holder').bind('click',function(event){
						if(window.popoverHide == false){
						//	$('#login_link').popover('hide');
							$('#holder').unbind('click');
						};
					});
					return false;
					$('#login_link').popover('show');
					setTimeout(function(){
							$('.popover').bind('mouseover',function(){
								window.popoverHide = true;
							});
							$('.popover').bind('mouseout',function(){
								window.popoverHide = false;
							});
					},70);
					event.preventDefault();
					return false;
				});
			};
		});
	//-->
	</script>

			<noindex>


				<div id="registration_form_wrapper" class="clearfix">
						<div id="registration_form" class="clearfix">
							<h3 style="padding: 0; margin: 0;">Регистрация</h3>
							<?$form = new Form_Register();
							echo $form->render($this);
							?>
						</div>
					</div>

	</noindex>
	<script type="text/javascript">
	//<!--
		window.popoverHide = false;
		$(document).ready(function(){
			if($('#registration_link').length && $('#registration_form_wrapper').length){
				var iHtml = $('#registration_form_wrapper')[0].innerHTML;
				$('#registration_link').popover({
						html: true,
						placement: 'bottom',
						content: iHtml
				});
				$('#registration_link').popover('hide');
				$('#registration_link').bind('click',function(event){
					if($('#login_link').length){
						$('#login_link').popover('hide');
					};
					$('#holder').unbind('click');
					$('#holder').bind('click',function(event){
						if(window.popoverHide == false){
							//$('#registration_link').popover('hide');
							$('#holder').unbind('click');
						};
					});
					return false;
					$('#registration_link').popover('show');
					setTimeout(function(){
							$('.popover').bind('mouseover',function(){
								window.popoverHide = true;
							});
							$('.popover').bind('mouseout',function(){
								window.popoverHide = false;
							});
					},70);
					event.preventDefault();
					return false;
				});
			};
		});

	//-->
	</script>

<script type='text/javascript'> /* build:::7 */
	var liveTex = true,
		liveTexID = 39710,
		liveTex_object = true;
	(function() {
		var lt = document.createElement('script');
		lt.type ='text/javascript';
		lt.async = true;
        lt.src = 'http://cs15.livetex.ru/js/client.js';
		var sc = document.getElementsByTagName('script')[0];
		if ( sc ) sc.parentNode.insertBefore(lt, sc);
		else  document.documentElement.firstChild.appendChild(lt);
	})();
</script>

<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=20598382&amp;from=informer"
target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/20598382/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="20598382" data-lang="ru" /></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter20598382 = new Ya.Metrika({
                    id:20598382,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/20598382" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<?	if($this->args[0] == 'order' && $this->args[1] == 'finish'){?>
<!-- Google Code for http://www.dombusin.com/ Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 973438294;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "k8dOCK3ioWcQ1vqV0AM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/973438294/?label=k8dOCK3ioWcQ1vqV0AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?	}?>


<!-- Код тега ремаркетинга Google -->
<?	if($this->args[0] == 'order' && $this->args[1] == 'finish'){?>

<?	}?>
	<?=$this->render('block/callback.php')?>
		<p id="back-top">
			<a href="#top"><span></span>Наверх</a>
		</p>
<?//echo microtime(true) - Zend_Registry::get('start_time');?>
 </body>
</html>
