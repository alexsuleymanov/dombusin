<?	$opt = Zend_Registry::get('opt');?>

<div id="hiddencart" style="visibility: hidden;">
	<table class="show" id="cart0" width="100%">
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td class="show" width="2%">0</td>
			<td class="show" id="cart_title0">
   				<div id="cart_select0">		
					Введите название товара<br>
					<input type="text" id="gsearch0" size="100" name="q" value=""/><br/><br/>
				</div>
			</td>
			<td class="show" width="120"><img id="cart_img0" src="/pic/prod/0.jpg" alt="" width="118" height="119"></td>
			<td class="show" width="22%" id="cart_price0">&nbsp;</td>
			<td class="show" width="22%"><input type='text' id="num" name='cart_num0' id="cart_num0" size="3" value="1" disabled="true"></td>
			<td class="show" width="2%" id="dela"><a href="" id="a" onclick="remove_cart(0); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	function add_row(data){
		table = $("#hiddencart table:first");
		title = table.find("#prod");
		newcart = table.clone();
		newcart.attr({"id": "cart"+data});
		newcart.find("#gsearch0").attr({"id": "gsearch"+data});
		newcart.find("#cart_img0").attr({"id": "cart_img"+data});
		newcart.find("#cart_title0").attr({"id": "cart_title"+data});
		newcart.find("#cart_price0").attr({"id": "cart_price"+data});
		newcart.find("#cart_num0").attr({"name": "cart_num"+data, "id": "cart_num"+data, "disabled": "0"});
		newcart.find("#dela").html('<a href="" id="a" onclick="remove_cart('+data+'); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');
//		$("#carts").append(newcart);

		newchildscript = "";

		newchildscript += "$().ready(function() {\n";
		newchildscript += "		$('#gsearch"+data+"').autocomplete('/hint/prod', {\n";
		newchildscript += "			width: 260,\n";
		newchildscript += "			selectFirst: false\n";
		newchildscript += "		});\n";
	
		newchildscript += "		$('#gsearch"+data+"').result(function(event, data, formatted) {\n";
//		newchildscript += "			alert(data[1]);\n";
		newchildscript += "			$('#cart_img"+data+"').attr({'src': '/pic/prod/'+data[1]+'.jpg', 'width': '118'});\n";
		newchildscript += "			$('#cart_title"+data+"').html('<b>'+data[0]+'</b>');\n";
		newchildscript += "			$.get('adm_order.php"+"<?=$this->url->gvar("time=")?>"+"', {'edit_cart': 1, 'order': <?=$_GET[id]?>, 'cart_id': "+data+", 'prod': data[1]}, function(data1){\n";
		newchildscript += "				$('#cart_price"+data+"').html(data1.price+'грн.');\n";
		newchildscript += "				alert(data1);\n";
		newchildscript += "			});\n";
		newchildscript += "		});\n";
		newchildscript += "});\n";

		newchildscript1 = '\n<script type="text\/javascript">\n';
		newchildscript1 += newchildscript;
		newchildscript1 += '<\/script>\n';

		$("#carts").append(newchildscript1);
		$("#carts").prepend(newcart);
		eval(newchildscript);
	}

	function remove_row(data){
		$("#cart"+data).empty();
	}

	function add_cart(){
		$.getJSON('adm_order.php<?=$this->url->gvar("add=1")?>', {"add" : 1}, add_row);
	}

	function remove_cart(id){
		if(confirm('Удалить товар из заказа?'))
			$.getJSON('adm_order.php<?=$this->url->gvar("time=")?>', {"del" : id}, remove_row);
	}

	function update_cart(id, obj){
		$.get('adm_order.php<?=$this->url->gvar("update_cart=1")?>', {"cart_id" : id, "num": $(obj).val()});
	}
</script>

	<tr>
		<td class="edith" valign=top>Содержание заказа</td>
		<td class="edit">
			<a href="" onclick="add_cart(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</a><br><br>

			<table class="show" width="100%">
				<tr>
					<th class="show" width="2%">#</th>
					<th class="show">Товар</th>
					<th class="show" width="120">Фото</th>
					<th class="show" width="22%">Цена</th>
					<th class="show" width="22%">Количество</th>
					<th class="show" width="2%">&nbsp;</th>
				</tr>
			</table>
			<div id="carts">		
<?
	$Order = new Model_Order(0+$_GET[id]);
	$order = $Order->get(0+$_GET[id]);	
	$prods = $Order->getcart();
	$User = new Model_User('client');
	$user = $User->get($order->user);
	$order_total = $Order->total($order->user);
	
	$total_weight = 0;
	$userdiscount = 0;
	
	foreach($prods as $k => $r){
		$Prod = new Model_Prod($r['id']);
		$prod = $Prod->get();
		
		$inpack = $prod->inpack;
		$weight = $prod->weight;
		
		if($r['userdiscount']) $userdiscount = $r['userdiscount'];
			
		if($r['var'] == 2){
			$inpack = $prod->inpack2;
			$weight = $prod->weight2;
		}
		
		if($r['var'] == 3){
			$inpack = $prod->inpack3;
			$inpack = $prod->weight3;
		}
		
		$total_weight += $weight * $r['num'];
		$skidka = ($r['baseprice']) ? round((1-$r['price'] / $r['baseprice']), 2) * 100 : 0;
?>
			<table class="show" id="cart<?=$r->id?>" width="100%">
				<tr>
					<td class="show" width="2%"><?=++$j?></td>
					<td class="show" id="cart_title<?=$r['id']?>"><a href="adm_prod.php?action=edit&id=<?=$prod->id?>" target="_blank"><?=$prod->name?></a></td>
					<td class="show" width="120" align="center"><img id="cart_img<?=$r['id']?>" src="/pic/prod/<?=$prod->id?>.jpg" alt="" width="118" height="119"></td>
					<td class="show" width="22%"><?=($skidka > 0) ? "<s>".Func::fmtmoney($r['baseprice'])."</s> ".Func::fmtmoney($r['price']) : Func::fmtmoney($r['price'])?> грн.<?=($skidka) ? "<br /><span style=\"color: red;\">Скидка: ".$skidka."%</span>" : ""?><br /><br />В упаковке: <?=$inpack?></td>
					<td class="show" width="22%"><input type='text' id="num" name='cart_num<?=$k?>' id="cart_num<?=$k?>" size="3" value="<?=$r['num']?>" onchange="update_cart(<?=$k?>, this)" /></td>
					<td class="show" width="2%" id="dela"><a href="" id="a" onclick="remove_cart(<?=$k?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
				</tr>
			</table>
	<?}?>
				
	<div style="font-weight: bold">
		Стоимость: <font color="red"><?=Func::fmtmoney($Order->cart->amount())?></font> <?=$this->valuta['name']?><br/><br/>
		Общая сумма заказов: <?=Func::fmtmoney($order_total)?> <?=$this->valuta['name']?><br/>
		Скидка клиента: <?=$userdiscount?> %<br/>
		Общий вес: <?=$total_weight?> г<br/>
	</div>
	

</div>
