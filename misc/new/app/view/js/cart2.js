function asreload(){
    location.reload();
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
    update_cart_block(data);
//    window.setTimeout(save_session, 1000);
}

function owlCallBack(){
	if($('#cart-list .owl-carousel .owl-item').last().hasClass('active')){
		$('.owl-next').hide();
		$('.owl-prev').show();
	}else if($('#cart-list .owl-carousel .owl-item').first().hasClass('active')){
		$('.owl-prev').hide();
		$('.owl-next').show();
	}
}

function owlCart() {
	// owlCarousel for Cart Slider
	/*cart_slider.owlCarousel('destroy');*/
	if ($('.cart-slider').exist()) {
		$("#dropdown-cart-cont").addClass('cart-hidden');
		$("#dropdown-cart-cont").addClass('cart-active');
		var cart_slider = $('.cart-slider');
		cart_slider.owlCarousel({
			dots: false,
			nav: true,
			loop: false,
			navText:['<i class="fa fa-angle-left"> пред.</i>','след. <i class="fa fa-angle-right"></i>'],
			navContainer: '.cart-nav',
			items: 1,
			autoWidth: true,
			onTranslated:owlCallBack
		});

		$("#dropdown-cart-cont").removeClass('cart-active');
		$("#dropdown-cart-cont").removeClass('cart-hidden');
		$('#cart-list .owl-prev').hide();
		if($("#dropdown-cart-cont div.media").length < 6) {
			$('#cart-list .owl-next').hide();
		}
	}
}

function check_num(id, prodvar, num){
    var html = $.ajax({
	type: "POST",
	url: "/cart/check",
	dataType: 'json',
	data: {"id": id, "prodvar": prodvar, "num": num},
	async: false
    }).responseText;

    var json = $.parseJSON(html);
    if(json.status == 'false'){
	$("#quantity"+id).val(json.num);
    }
    
    return json;
}

function buy(id){
    var prodvar = $("#prodvar"+id).val();
    var num = $("#quantity"+id).val();
    var check = window["check_num"](id, prodvar, num);
//    console.log(check);
    
    if(check.status == 'true'){
	//$("#prod_added").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');
	$.post("/cart/buy", $("#prodform_"+id).serialize(), function(data){update_cart_block(data)}, "json");//
    }else{
	alert("Доступно "+check.num+" упаковок");
    }
 //   window.setTimeout(save_session, 3000);
}

/*function buy(id){
	if(window["check_num_"+id]()){
		$("#prod_added").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');
//		alert($("#prodform_"+id).serialize());
		$.post("/cart/buy", $("#prodform_"+id).serialize(), update_cart_block, "json");
	}
}
*/
function wishlist(id){
//    var prodvar = $("#prodvar"+id).val();
    $("#prod_added2").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');
    $.post("/user/wishlist/add/"+id, $("#wishform_"+id).serialize(), "json");
}

function order_click(){
    $("#order_maked").show().animate({opacity: 0.9}, 500);
    
}

function wish_to_cart(id){
    $("#prod_added").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');
//    window.setTimeout(save_session, 1000);
    $.post("/cart/buy/fromwish", $("#wishform_"+id).serialize(), function (data){
        window.location.reload();
    }, "json");
}

function cart_to_wish(id){
	$("#prod_added2").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');

	$.get("/user/wishlist/fromcart/"+id, {'id': id}, function (data){
	    window.location.reload();
	});
}

function wishlist_delete(id){
	$.post("/user/wishlist/delete/"+id, $("#wishform_"+id).serialize(), "json");
}


function fmtmoney(num){
	return num.toFixed(2);
}

function fmtnum(num){
	return num.toFixed(0);
}

function update_cart_block(data){
	console.log(data);
//	window.setTimeout(save_session, 100);
	
	if(data.prods == 1)
		$(".cart_num").html(data.prods+" товар");
	if(data.prods > 1 && data.prods < 5)
		$(".cart_num").html(data.prods+" товара");
	if(data.prods == 0 || data.prods > 4)
		$(".cart_num").html(data.prods+" товаров");

//    $(".cart-amount").html(fmtmoney(data.amount));
	$("#amount #val2").html(fmtmoney(data.amount));
	$.get( "/cart/list", function( data ) {
		$('#cart-list').html(data);
		owlCart();
	});

	if(data.reload == 1) location.reload();
/*	if(typeof data.message != 'undefined'){
		swal({
			title: data.message,
			text: '',
			timer: 800,
			showConfirmButton: false });
	}*/
    $("#prod_added").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');
}
/*
function buy(id){
//	console.log($("#prodform_"+id).attr('action'));
    $.post($("#prodform_"+id).attr('action'), $("#prodform_"+id).serialize(), update_cart_block, "json");
}
*/
function update_cart(data){
	console.log(data);

	$("#loading").hide('fast');
	$("#total_sum").val(data.amount);
//	console.log(fmtmoney(data.amount));
//	$("#cart_price_"+data.id).html(fmtmoney(data.price));
	$("#cart_sum_"+data.cart_id).html(fmtmoney(data.num*data.price));
	$("#cart_num_"+data.cart_id).val(data.num);
	$(".cart_amount").html(fmtmoney(data.amount));
	$(".cart_weight").html(fmtnum(data.weight));
	$(".cart_num").html(fmtnum(data.prods));
	$(".cart_packs").html(fmtnum(data.packs));
	$(".cart_sum").html(fmtmoney(data.sum));
	$(".cart_to_pay").html(fmtmoney(data.to_pay));

	if(data.discount > 0){
		$("#cart_sum_row").show();
		$("#cart_discount_row").show();
		$(".cart_discount").html(fmtmoney(data.discount));
	}else{
//		$("#cart_sum_row").hide();
		$("#cart_discount_row").hide();
	}
	
//	update_cart_block(data);
}

function change_cart_num(id){
	var cart_id = id;

	var num = $("#cart_num_"+id).val();
	num = window["check_cart_num_"+id](num);
//	alert("check_cart_num_"+id);
//	num = window["check_cart_num_"+cart_id](num);
//	alert("id="+cart_id+"&num="+num);
	$("#loading").show().animate({opacity: 0.9}, 500);
	$.post($("#cartform").attr('action'), "id="+cart_id+"&num="+num, update_cart, "json");
}

function cart_delete(cart_id){
	$.post("/cart/delete", "cart_id="+cart_id, update_cart, "json");
}

function plus_minus_cart_num(plus_minus, id){
	if(typeof id === 'string' || id instanceof String){	  
	    var num = parseInt($("#cart_num_"+id).val());
	    
	    if(plus_minus == 'plus'){	    	
		num += 1;
	    }   
	    if(plus_minus == 'minus'){
		num -= 1;
	    }
	
	    num = window["check_cart_num_"+id](num);
	    $("#loading").show().animate({opacity: 0.9}, 500);
	    $.post($("#cartform").attr('action'), "id="+id+"&num="+num, update_cart, "json");
	}
}

function save_session(){    
    $.get("/cart/save-session", {}, function(){
	console.log('Session saved');
    });    
}

$( document ).ready(function() {
    $(".cart_num").on("change", change_cart_num);
    $(".cart_num_minus").on("click", $.proxy(plus_minus_cart_num, null, 'minus'));
    $(".cart_num_plus").on("click", $.proxy(plus_minus_cart_num, null, 'plus'));
});