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
    $("#anketa_phone").mask("99 (999) 999-9999");
});


$( document ).ready(function() {

    $('.jsddm > li').bind('mouseover', jsddm_open);
    $('.jsddm > li').bind('mouseout',  jsddm_timer);
    $(".prodvar1").show();

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

    $('.pl-colors img').click(function() {
        var $this = $(this);
        $.ajax({
            url: "/catalog/prod/ajax2/prod-"+$(this).attr('data-id'),
            dataType: 'json'
        }).done(function(data) {
            var $parent = $this.closest('.box-product');
            $parent.find('div.h6').first().html('<a href="/catalog/prod-'+data.prod.id+'">'+data.prod.name+'</a>');
            $parent.find('a.group').attr('href', '/thumb?src=pic/prod/'+data.prod.id+'.jpg&amp;width=665');
            $parent.find('a.group img').attr('src', '/thumb?src=pic/prod/'+data.prod.id+'.jpg&amp;width=665');
            $parent.find('a.group img').attr('alt', data.prod.name);
            $parent.find('a.group2').attr('href', '/thumb?src=pic/prod/'+data.prod.id+'.jpg&amp;width=535');
            $parent.find('a.group2 img').attr('src', '/thumb?src=pic/prod/'+data.prod.id+'.jpg&amp;width=535');
            $parent.find('a.group2 img').attr('alt', data.prod.name);
            $parent.find('.img-wrapper a').attr('href', '/catalog/prod-'+data.prod.id);
            $parent.find('.img-wrapper a img').attr('src', '/thumb?src=pic/prod/'+data.prod.id+'.jpg&amp;width=665');
            $parent.find('.img-wrapper a img').attr('alt', data.prod.name);
            $parent.find('.label-box .pc-hot').remove();
            $parent.find('.label-box .pc-skidka').remove();
            $parent.find('.label-box .pc-new').remove();
            if(data.prod.pop==1) {
                $parent.find('.label-box').append('<div class="pc-hot"></div>');
            }
            if((data.prod.skidka>0)||(data.prod.skidka2>0)||(data.prod.skidka3>0)) {
                $parent.find('.label-box').append('<div class="pc-skidka">-'+Math.max(data.prod.skidka, data.prod.skidka2, data.prod.skidka3)+'%</div>');
            }
            if(data.prod.new==1) {
                $parent.find('.label-box').append('<div class="pc-new"></div>');
            }
            $parent.find('.xprice').each(function(){
                $(this).html(data.price);
                $(".prodvar1").show();
            });
            $parent.find('.weight-block').each(function(){
                $(this).html(data.weight);
            });
            $parent.find('.xform').each(function(){
                $(this).html(data.form);
            });
            $parent.find('.xwish').each(function(){
                $(this).html(data.wish);
            });
        });
    });

    var color_slider = $('.color-slider');
    color_slider.owlCarousel({
        dots: false,
        nav: true,
        loop: false,
        navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        items: 4,
        slideBy: 4,
        autoWidth: true
    });

});

function changepack(prod, prodvar){
    $("."+prod+"prodvar").hide();
    $("."+prod+"prodvar"+prodvar).show();
    $("#prodvar"+prod).val(prodvar);
    $(".prodvar"+prod).val(prodvar);
}

function openNav() {
    document.getElementById("mfilter").style.width = "100%";
}

function closeNav() {
    document.getElementById("mfilter").style.width = "0";
}

