<?$prod = $this->prodone?>

<?if($prod->num > 0 || $prod->num2 > 0 || $prod->num3 > 0){?>
<form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
    <?
    if($prod->num3 > 0) {$prodvar = 3;}
    if($prod->num2 > 0) {$prodvar = 2;}
    if($prod->num > 0) {$prodvar = 1;}
    ?>
    <input type="hidden" name="id" value="<?= $prod->id ?>" />
    <input type="hidden" name="var" value="<?=$prodvar?>" id="prodvar<?=$prod->id?>" />
    <input type="hidden" name="ajax" value="1" class="ajax" />
    <input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />

    <div class="productListing-data by_now">
        <div class="col-md-3 col-xs-3 col-nopadding">
            <input type="text" size="5" maxlength="5" name="num" id="quantity<?= $prod->id ?>" onchange="check_num(<?=$prod->id?>, $('#prodvar<?=$prod->id?>').val(), $(this).val());" value="1" class="form-control text-center pull-left">
        </div>
        <div class="col-md-9 col-xs-9 col-nopadding">
            <?if(!is_array($this->cartids) || !in_array($prod->id, $this->cartids)) {?>
                <button class="btn btn-theme m-b-1 form-control active focus" type="button" data-prod-id="<?= $prod->id ?>" onmousedown="try { rrApi.addToBasket(<?=$prod->id?>) } catch(e) {}" onclick="
                    ga('send', 'event', 'Buy', 'Click_buy');
                    buy(<?= $prod->id ?>);
                    $(this).addClass('added');
                    $(this).html('<i class=&quot;fa fa-shopping-cart&quot;></i> Добавлен');
                    $(this).attr('onclick', 'location.href=\'<?=$this->url->mk('/cart')?>\'');
                    return false;">
                    <i class="fa fa-shopping-cart"></i> В корзину
                </button>
            <?} else {?>
                <button class="btn btn-theme m-b-1 form-control active focus added" type="button" data-prod-id="<?= $prod->id ?>" onclick="location.href='<?=$this->url->mk('/cart')?>'">
                    <i class="fa fa-shopping-cart"></i> Добавлен
                </button>
            <?}?>
        </div>
    </div>
    <div class="productListing-data quantity">

    </div>
</form>
<?}?>