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
	$("#prod_added").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');
	$.post("/cart/buy", $("#prodform_"+id).serialize(), update_cart_block, "json");
    }else{
	alert("Доступно "+check.num+" упаковок");
    }
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
	$("#prod_added2").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');
	$.post("/user/wishlist/add/"+id, $("#wishform_"+id).serialize(), "json");
}

function wish_to_cart(id){
	$("#prod_added").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');
	$.get("/cart/buy/fromwish", $("#prodform_"+id).serialize(), function (data){
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

	if(data.prods == 1)
		$(".cart_num").html(data.prods+" товар");
	if(data.prods > 1 && data.prods < 5)
		$(".cart_num").html(data.prods+" товара");
	if(data.prods == 0 || data.prods > 4)
		$(".cart_num").html(data.prods+" товаров");

//    $(".cart-amount").html(fmtmoney(data.amount));
	$("#amount #val2").html(fmtmoney(data.amount));
	if(data.reload == 1) location.reload();
/*	if(typeof data.message != 'undefined'){
		swal({
			title: data.message,
			text: '',
			timer: 800,
			showConfirmButton: false });
	}*/
}
/*
function buy(id){
//	console.log($("#prodform_"+id).attr('action'));
    $.post($("#prodform_"+id).attr('action'), $("#prodform_"+id).serialize(), update_cart_block, "json");
}
*/
function update_cart(data){
	console.log(data);

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

	if(data.skidka > 0){
		$("#cart_sum_row").show();
		$("#cart_skidka_row").show();
		$(".cart_skidka").html(fmtmoney(data.skidka));
	}else{
		$("#cart_sum_row").hide();
		$("#cart_skidka_row").hide();
	}
	
//	update_cart_block(data);
}

function change_cart_num(id){
	var cart_id = id;
	var num = $("#cart_num_"+cart_id).val();
//	alert("check_cart_num_"+id);
	num = window["check_cart_num_"+cart_id](num);
//	alert("id="+cart_id+"&num="+num);
	$.post($("#cartform").attr('action'), "id="+cart_id+"&num="+num, update_cart, "json");
}

function cart_delete(cart_id){
	$.post("/cart/delete", "cart_id="+cart_id, update_cart, "json");
}

function plus_minus_cart_num(plus_minus, id){
//	var str = $(this).attr("id");
//	console.log(plus_minus);
	console.log(id);

	if(plus_minus == 'plus'){
		var cart_id = id;//str.substring(14);
		var num = parseInt($("#cart_num_"+cart_id).val());
		num += 1;
	}
	if(plus_minus == 'minus'){
		var cart_id = id;//str.substring(15);
		var num = parseInt($("#cart_num_"+cart_id).val());
		num -= 1;
	}

	console.log(num);

	num = window["check_cart_num_"+id](num);
	$.post($("#cartform").attr('action'), "id="+cart_id+"&num="+num, update_cart, "json");
}

$( document ).ready(function() {
	$(".cart_num").on("change", change_cart_num);
	$(".cart_num_minus").on("click", $.proxy(plus_minus_cart_num, null, 'minus'));
	$(".cart_num_plus").on("click", $.proxy(plus_minus_cart_num, null, 'plus'));

});