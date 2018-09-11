
		</div>
	</div>
</div>
<!-- End Main Content -->

<!-- Footer -->
<div class="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-6">
				<div class="title-footer"><span>О нас</span></div>
				<ul>
					<li><i class="fa fa-angle-double-right"></i> <a href="<?=$this->url->mk('/about')?>">О магазине</a></li>
					<li><i class="fa fa-angle-double-right"></i> <a href="<?=$this->url->mk('/user')?>">Оптовым покупателям</a></li>
					<li><i class="fa fa-angle-double-right"></i> <a href="<?=$this->url->mk('/delivery')?>">Доставка и оплата</a></li>
				</ul>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="title-footer"><span>Выгодные предложения</span></div>
				<ul>
					<li><i class="fa fa-angle-double-right"></i> <a href="<?=$this->url->mk('/skidki')?>">Дисконтная программа</a></li>
					<li><i class="fa fa-angle-double-right"></i> <a href="<?=$this->url->mk('/catalog/action')?>">Акции</a></li>
				</ul>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="title-footer"><span>С нами можно связаться</span></div>
				<ul>
					<li><i class="fa fa-angle-double-right"></i> <a href="<?=$this->url->mk('/contact')?>">Контакты</a></li>
				</ul>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="title-footer"><span>Оцените нас</span></div>
				<ul>
					<li><i class="fa fa-angle-double-right"></i> <a href="<?=$this->url->mk('/comments')?>">Отзывы</a></li>
				</ul>
			</div>

		</div>
	</div>
	<div class="text-center copyright">
		Copyright &copy; 2013-2017 Дом бусин
		<div class="footer-space"></div>

		<script type='text/javascript'> /* build:::7 */
			var liveTex = true,
				liveTexID = 39710,
				liveTex_object = true;
			(function() {
				var lt = document.createElement('script');
				lt.type ='text/javascript';
				lt.async = true;
		        lt.src = 'https://cs15.livetex.ru/js/client.js';
				var sc = document.getElementsByTagName('script')[0];
				if ( sc ) sc.parentNode.insertBefore(lt, sc);
				else  document.documentElement.firstChild.appendChild(lt);
			})();
		</script>
		
	<script type="text/javascript">
       var rrPartnerId = "574c38b15a658870b8cf2e37";       
       var rrApi = {}; 
       var rrApiOnReady = rrApiOnReady || [];
       rrApi.addToBasket = rrApi.order = rrApi.categoryView = rrApi.view = 
           rrApi.recomMouseDown = rrApi.recomAddToCart = function() {};
       (function(d) {
           var ref = d.getElementsByTagName('script')[0];
           var apiJs, apiJsId = 'rrApi-jssdk';
           if (d.getElementById(apiJsId)) return;
           apiJs = d.createElement('script');
           apiJs.id = apiJsId;
           apiJs.async = true;
           apiJs.src = "//cdn.retailrocket.ru/content/javascript/tracking.js";
           ref.parentNode.insertBefore(apiJs, ref);
       }(document));
    </script>
	


	
<?/*
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
        s.src = "https://d31j93rd8oukbv.cloudfront.net/metrika/watch_ua.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>

<!-- /Yandex.Metrika counter -->
*/?>
		<?	if($this->args[0] == 'order' && $this->args[1] == 'finish'){?>
			<!-- Google Code for https://www.dombusin.com/ Conversion Page -->
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
	</div>
</div>
<!-- End Footer -->
<a href="#top" class="back-top text-center" onclick="$('body,html').animate({scrollTop:0},500); return false">
	<i class="fa fa-angle-up"></i>
</a>
<?=$this->render('block/modal_callback.php')?>
<?=$this->render('block/modal_sent.php')?>
<?=$this->render('block/razmetka.php')?>

	<script type="text/javascript">
		!function(t,e,c,n){var s=e.createElement(c);s.async=1,s.src="https://script.softcube.com/"+n+"/sc.js";var r=e.scripts[0];r.parentNode.insertBefore(s,r)}(window,document,'script',"CF0B9A5F1A134785B046327D17152863");
	</script>
</body>
</html>
