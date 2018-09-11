<?php

//быдло код ремаркетинг, так как делать надо было очень быстро
//    session_start();
if($_SERVER['REQUEST_URI'] == "/order/finish"/* && $_SESSION['remarking_cart'] == 1*/){
    $db = mysql_connect("localhost","deus","d2e06u84s");
    mysql_select_db("dombusin2", $db);
    mysql_query("SET NAMES 'utf8'");
    //выбираем последний заказ данного юхера
    $q = mysql_query("SELECT *, (SELECT city FROM `dombusin_user` WHERE `id` = '".$_COOKIE['userid']."') as city FROM `dombusin_order` where user = '".$_COOKIE['userid']."' ORDER BY id DESC LIMIT 1");
    $r = mysql_fetch_assoc($q);
    //выбираем товара с данной покупки
    $items = mysql_query("SELECT *, (SELECT name FROM dombusin_prod where id = c.prod) as name, (SELECT cat FROM dombusin_prod where id = c.prod) as cat, (SELECT price FROM dombusin_prod where id = c.prod) as price, (SELECT skidka FROM dombusin_prod where id = c.prod) as skidka FROM `dombusin_cart` as c WHERE `order` = '".$r['id']."'");
    while($item = mysql_fetch_assoc($items)){
     //определеяем категорию товара
     $id_cat = mysql_fetch_array(mysql_query("select obj from dombusin_relation where relation = '".$item['prod']."'"));
     $cat = mysql_fetch_assoc(mysql_query("select cat, name from dombusin_cat where id = '".$id_cat['obj']."'"));
     if($cat['cat'] != 0){
        $cat_par = mysql_fetch_assoc(mysql_query("select name from dombusin_cat where id = '".$cat['cat']."'"));
     }
     $cat_name = $cat_par['name']." ".$cat['name'];
     if($item['skidka'] == 0){
        $sum = $sum + ($item['price'] * $item['num']);
    }
    $total_sum = $total_sum + ($item['price'] * $item['num']);
        $arr_res[] =  array("id" => $r['id'], "item_id" => $item['id'], "item_name" => $item['name'], "item_cat" => $cat_name, "item_price" => $item['price'], "num" => $item['num'], "skidka" => $item['skidka']);

    }
    if($sum > 1000){
        $skidka = 10;
        if($sum > 2000)$skidka = 15;
        if($sum > 5000)$skidka = 20;
    }else{
         $q = mysql_query("SELECT id FROM `dombusin_order` where user = '".$_COOKIE['userid']."' AND status = 1");
         while($r_sum = mysql_fetch_assoc($q)){
            $q_item = mysql_query("SELECT num, (select price from `dombusin_prod` where id = c.prod) as price FROM `dombusin_cart` as c WHERE `order` = '".$r_sum['id']."'");
            while($r_item = mysql_fetch_assoc($q_item)){
                $sum_all_order = $sum_all_order + ($r_item['price'] * $r_item['num']);
            }
         }
        $skidka = 0;
        $sum_all_order = intval($sum_all_order);
        if($sum_all_order >= 0){$skidka = 3;}
        if($sum_all_order >= 2000){$skidka = 6;}
        if($sum_all_order >= 5000){$skidka = 9;}
        if($sum_all_order >= 10000){$skidka = 12;}
        if($sum_all_order >= 15000){$skidka = 15;}
    }
    $sum = 0;
    foreach($arr_res as $val){
        if($val['skidka'] == 0){
            $val['item_price'] = ($val['item_price'] * (100 - $skidka)) / 100;
        }else{
            $val['item_price'] = ($val['item_price'] * (100 - $val['skidka'])) / 100;
        }
        $sum = $sum + ($val['item_price'] * $val['num']);
        $res_item .= "
           _gaq.push(['_addItem',
            '".$val['id']."',
            '".$val['item_id']."',
            '".$val['item_name']."',
            '".$val['item_cat']."',
            '".round($val['item_price'], 2)."',
            '".$val['num']."'
          ]);";
    }
    $sum = round($sum, 2);

?>
<!-- Remarketing -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-44721091-1']);
  _gaq.push(['_trackPageview']);

//Указываем информацию о транзакции
  _gaq.push(['_addTrans',
    '<? echo $r["id"];?>',           		// ID заказа - обязательное поле
    'dombusin.com',  	// Название магазина или точки продажи
    '<?php echo $sum;?>',         		// Общая сумма заказа - обязательное поле
    '0',           		// Налог
    '0',         		// Стоимость доставки
    '<?=$r["city"]?>',     		// Город
    '',     			// Область
    '' 			// Страна
  ]);

<?=$res_item?>

//Отправляем данные на сервер Google Analytics
  _gaq.push(['_trackTrans']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<? } ?>
