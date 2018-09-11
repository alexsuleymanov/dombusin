<script>
    function make_order(){
        var total_sum = $("#total_sum").val();
        <?	if($_SESSION['useropt'] && $_SESSION['userminiopt'] == 0){?>
        if(total_sum > 2000) location.href = '/order';
        else alert("Минимальная сумма заказа 2000 грн.");
		<?	}elseif($_SESSION['useropt'] && $_SESSION['userminiopt'] == 1){?>
        if(total_sum > 500) location.href = '/order';
        else alert("Минимальная сумма заказа 500 грн.");			
        <?	}else{?>
        if(total_sum > 0) location.href = '/order';
        <?	}?>
    }
</script>
<div class="cart-block">
    <button type="button" class="btn btn-default cart-button" onclick="location.href='/cart'">
        <i class="fa fa-shopping-cart"></i>&nbsp;
        <div class="cart_block">
            <div id="prods">
                Корзина:
                <span id="val" class="cart_num"><?//print_r($this->cart->cart)?><?echo intval($this->cart->prod_num());?> <?if(intval($this->cart->prod_num()) == 1) echo "товар"; if(intval($this->cart->prod_num()) > 1 && intval($this->cart->prod_num()) < 5) echo "товара"; if(intval($this->cart->prod_num()) > 4) echo "товаров";?></span>
            </div>
            <div id="amount">(<span id="val2" class="cart_amount"><?= Func::fmtmoney(0 + $this->cart->amount()); ?></span> <?= $this->valuta['name'] ?>)</div>
        </div>
        &nbsp;<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right" id="dropdown-cart-cont">
        <?	if($_SESSION['useropt'] && $_SESSION['userminiopt'] == 0){?>
        <div class="media">
            <div class="cart_minorder">Минимальный заказ 2000 грн</div>
        </div>
        <?}?>
        <div id="cart-list">
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
						$skidka = $prod->skidka;
                        $weight = $prod->weight;
                        $inpack = $prod->inpack;

                        if($v['var'] == 2){
                            $price = $prod->price2;
							$skidka = $prod->skidka2;
                            $weight = $prod->weight2;
                            $inpack = $prod->inpack2;
                        }

                        if($v['var'] == 3){
                            $price = $prod->price3;
							$skidka = $prod->skidka3;
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
            <input type="hidden" name="total_sum" id="total_sum" value="<?= $this->cart->amount()?>" />
            </form>
        <div class="cart-nav"></div>
        <div class="subtotal-cart">Сумма: <span><?= Func::fmtmoney($this->cart->amount())?> <?= $this->valuta['name'] ?></span></div>
    </div>
    <div class="text-center">
        <div class="btn-group" role="group" aria-label="View Cart and Checkout Button">
            <button class="btn btn-default btn-sm" type="button" onclick="location.href='/cart'"><i class="fa fa-shopping-cart"></i> В корзину</button>
            <?if(!$_SESSION['useropt'] || $this->cart->amount() > 2000){?><button class="btn btn-default btn-sm" type="button" onclick="location.href='/order'"><i class="fa fa-check"></i> Оформить</button><?}?>
        </div>
    </div>
</div>
</div>