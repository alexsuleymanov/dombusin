<form action="/cart/update" method="post" id="cartform">
    <div class="cart-slider">
        <?
        $n = $sum0 = $sum = 0;
        $total_weight = 0;
        $i=0;
        foreach ($this->cart->cart as $k => $v) {
            $Prod = new Model_Prod($v['id']);
            $prod = $Prod->get();
            $price = $prod->price;
            $weight = $prod->weight;
            $inpack = $prod->inpack;

            if($v['var'] == 2){
                $price = $prod->price2;
                $weight = $prod->weight2;
                $inpack = $prod->inpack2;
            }

            if($v['var'] == 3){
                $price = $prod->price3;
                $weight = $prod->weight3;
                $inpack = $prod->inpack3;
            }
            ?>
            <?if($i%5==0) {?>
                <div class="cart-slider-page">
            <?}?>

            <div class="media">
                <div class="media-left">
                    <a href="/catalog/prod-<?= $v['id'] ?>">
                        <?if(file_exists('pic/prod/'.$v['id'].'.jpg')) {?>
                            <img class="media-object img-thumbnail" src="/pic/prod/<?= $v['id'] ?>.jpg" width="50" alt="product">
                        <?} else {?>
                            <img class="media-object img-thumbnail" src="<?=$this->path?>/img/tr.gif" width="50" alt="product">
                        <?}?>
                    </a>
                </div>
                <div class="media-body">
                    <a href="/catalog/prod-<?= $v['id'] ?>" class="media-heading"><?=$prod->name?></a>
                </div>
                <div class="media-right">
                    <div>
                        <?=$v['num']?> x
                        <nobr><?= Func::fmtmoney($v['price']) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $inpack ?></nobr>
                    </div>
                    <?if($v['skidka']) {?> <strong>(-<?=$v['skidka']?>%)</strong><?}?>
                    <a class="mr-trash" href="#" data-toggle="tooltip" title="Remove" onclick="
                        $.get('/cart/delete/<?= $k ?>', function() {
                        $.post('/cart/get', null, update_cart_block, 'json');
                        });
                        "><i class="fa fa-trash"></i></a></div>
            </div>

            <?if($i++%5==4) {?>
                </div>
            <?}?>
        <? } ?>
        <?if($i%5!=0) {?>
    </div>
    <?}?>
    </div>
    <input type="hidden" name="total_sum" id="total_sum" value="<?= $Cart->sum ?>" />
</form>
<div class="cart-nav"></div>
<div class="subtotal-cart">Сумма: <span><?= Func::fmtmoney($this->cart->amount())?> <?= $this->valuta['name'] ?></span></div>

