<?
$_GET["redirect"] = "/order/confirm";
echo $this->page->cont;
$city = 'Харків';
?>

<h4>Личные данные</h4>
<div class="row order-row">
    <div class="col-sm-8">
        <div class="order-step"><span><span>1</span></span>&nbsp;&nbsp;<strong>Личная информация</strong> - <a href="<?=$this->url->mk('/order')?>" class="active">Редактировать</a></div>
        <div class="order-step-cont"></div>
        <div class="order-step"><span><span>2</span></span>&nbsp;&nbsp;<strong>Информация о доставке</strong> - <a href="<?=$this->url->mk('/order/delivery')?>" class="active">Редактировать</a></div>
        <div class="order-step-cont"></div>
        <div class="order-step active"><span><span>3</span></span>&nbsp;&nbsp;<strong>Информация об оплате</strong></div>
        <div class="order-step-cont active">
            <form method="POST" action="<?=$this->url->mk('/order/payment')?>">
                <div class="order-step-block">
                    <label for="payment">Способ оплаты</label>
                    <div class="radio">
                        <label><input type="radio" name="payment" value="1">Наложенный платеж</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="payment" value="2" checked>На карту</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="payment" value="3">Наличными</label>
                    </div>
                </div>
                <div class="order-step-block">
                    <label for="payment-comment">Комментарий к заказу</label>
                    <textarea name="comment" class="form-control"></textarea>
                </div>
                <div class="clear"></div>
                <button type="button" class="btn btn-theme m-b-1 active focus pull-right">Далее</button>
                <div class="clear"></div>
            </form>
        </div>
        <div class="order-step"><span><span>4</span></span>&nbsp;&nbsp;<strong>Спасибо за заказ</strong></div>
    </div>
    <div class="col-sm-4">
        <?=$this->render('order/block.php')?>
    </div>
</div>