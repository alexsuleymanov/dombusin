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

$(function() {
    $("#asform_orderform #asform_phone").mask("99 (999) 999-9999");
    $("#asform_registerform #asform_phone").mask("99 (999) 999-9999");
});


$( document ).ready(function() {

    $('.jsddm > li').bind('mouseover', jsddm_open);
    $('.jsddm > li').bind('mouseout',  jsddm_timer);
    $(".prodvar1").show();

    var bLazy = new Blazy();

    if(window.innerWidth >= 992) {
        $("a.group").fancybox({
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 0,
            'speedOut': 0,
            'autoDimensions': false,
            'height': 'auto',
            'overlayShow': false
        }).hover(function () {
            $(this).click();
        }, function () {
            $.fancybox.close();
        });
        $("a.group").mouseout(function () {
            jQuery.fancybox.close();
        });
        $("a.group2").fancybox({
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 0,
            'speedOut': 0,
            'autoDimensions': false,
            'height': 'auto',
            'overlayShow': false
        }).hover(function () {
            $(this).click();
        }, function () {
            $.fancybox.close();
        });
        $("a.group2").mouseout(function () {
            jQuery.fancybox.close();
        });
    }
    $('.slinky').slinky({
        title: true,
        label: ''
    });
    $(".cart-block").mouseenter(function() {
        $("#dropdown-cart-cont").addClass('cart-active');
    });
    $(".cart-block").mouseleave(function() {
        $("#dropdown-cart-cont").removeClass('cart-active');
    });

    owlCart();
});

function changepack(prod, prodvar){
    $("."+prod+"prodvar").hide();
    $("."+prod+"prodvar"+prodvar).show();
    $("#prodvar"+prod).val(prodvar);
    $(".prodvar"+prod).val(prodvar);
    $(".pc-skidka-id-"+prod).addClass('hidden');
    $(".pc-skidka-id-"+prod+".pc-skidka-"+prodvar).removeClass('hidden');
}

function openNav() {
    document.getElementById("mfilter").style.width = "100%";
}

function closeNav() {
    document.getElementById("mfilter").style.width = "0";
}

