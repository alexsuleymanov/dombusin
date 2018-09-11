var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

function jsddm_canceltimer(){
	if(closetimer){
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

function jsddm_close(){
	if(ddmenuitem) ddmenuitem.css('display', 'none');
}

function jsddm_timer(){
	closetimer = window.setTimeout(jsddm_close, timeout);
}

function jsddm_open(){
	jsddm_canceltimer();
	jsddm_close();
	ddmenuitem = $(this).find('ul').eq(0).css('display', 'block');
}

$( document ).ready(function() {

	$(document).ready(function(){
		$('.jsddm > li').bind('mouseover', jsddm_open);
		$('.jsddm > li').bind('mouseout',  jsddm_timer);
	});

    $("a.group").fancybox({
	'transitionIn'	:	'elastic',
	'transitionOut'	:	'elastic',
	'speedIn'		:	0,
	'speedOut'		:	0,
	'autoDimensions'	:	false,
	'width'			:	560,
	'height'		:	'auto',
	'left'			:	150,
	'top'			:	0,
	'overlayShow'	:	false
    }).hover(function() {
		$(this).click();
    }, function() {
		$.fancybox.cancel();
	});

    $("a.group").mouseout(function(){
	jQuery.fancybox.close();
    });
//	document.onclick = jsddm_close;

//	$(".cart_num").on("change", change_cart_num);
//	$(".cart_num_minus").on("click", $.proxy(plus_minus_cart_num, null, 'minus'));
//	$(".cart_num_plus").on("click", $.proxy(plus_minus_cart_num, null, 'plus'));

	$("#back-top").hide();

	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

	$('body').nivoZoom();
	
	$(".prodvar1").show();
});

function changepack(prod, prodvar){
    $("."+prod+"prodvar").hide();
    $("."+prod+"prodvar"+prodvar).show();
    $("#prodvar"+prod).val(prodvar);
}