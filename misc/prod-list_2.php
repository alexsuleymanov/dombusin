<? if ((count($this->prods))||($_GET['filter']==1)) { ?>
    <script type="text/javascript">
        function countchange(value) {
            $.ajax({
                url: '/catalog/set?results='+value,
                success: function (data) {
                    href = '<?= $this->url->gvar("start=0") ?>';
                    location.href = href;
                }
            });
        }
    </script>

    <? $opt = Zend_Registry::get('opt'); ?>
    <?
    $Cat = new Model_Cat();
    $cat = $Cat->get($this->cat);
    ?>
    <?	if(count($this->cats) == 0){?>
        <h1><?= $this->page->h1 ?></h1>
    <?	}?>

    <?	if($_SERVER['REQUEST_URI'] == $this->canonical && count($this->cats) == 0){?>

        <?	echo $this->page->cont2;?>

    <?	}?>


    <div class="pc-buy">
        <?//	if($this->args[0] == 'catalog' && $this->args[1] != 'new' && $this->new_count && $this->args[1] != 'top'){?>
        <button class="btn btn-theme m-b-2" type="button" onclick="location.href = '?novinki=1';">Показать новинки</button>
        <?//	}?>
    </div>
    <!-- Product Sorting Bar -->
    <div class="product-sorting-bar">
        <div class="psb-view pull-left">
            Вид:
            <a href="<?= $this->url->gvar("view=list") ?>" class="list<? if ($this->view_mode == 'list') { ?>a<? } ?>"><i class="fa fa-list-ul"></i> Список</a>
            <a href="<?= $this->url->gvar("view=grid") ?>" class="grid<? if ((!isset($this->view_mode)) || ($this->view_mode == 'grid')) { ?>a<? } ?>"><i class="fa fa-th-large"></i> Сетка</a>
        </div>
        <div class="pull-right">Показано:
            <select name="show" class="selectpicker" data-width="60px" onchange="countchange(value);">
                <option value="30"<? if ($this->results == 30) { ?> selected="selected"<? } ?>>30</option>
                <option value="60"<? if ($this->results == 60) { ?> selected="selected"<? } ?>>60</option>
                <option value="90"<? if ($this->results == 90) { ?> selected="selected"<? } ?>>90</option>
            </select>
        </div>
        <div class="pull-right">
            <?= $this->render('catalog/sort.php') ?>
        </div>
    </div>
    <!-- End Product Sorting Bar -->


    <?if(!count($this->prods)){?><div class="pl-empty">По данному запросу нет совпадений</div><?} else {?>

        <? if ($this->view_mode == 'list') { ?>
            <? $i = 0;
            foreach ($this->prods as $prod) { ?>
                <div class="col-md-12 box-product-outer bpo-list">
                    <div class="box-product">
                        <div class="col-md-2">
                            <div class="img-wrapper pl-image-detail">
                                <a href="/catalog/prod-<?= $prod->id ?>">
                                    <?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
                                        <img alt="Product" src="/pic/prod/<?= $prod->id ?>.jpg" data-zoom-image="/pic/prod/<?= $prod->id ?>.jpg">
                                    <?} else {?>
                                        <img alt="Product" src="<?=$this->path?>/img/tr.gif">
                                    <?}?>
                                </a>
                            </div>
                            <? if ($prod->pop) { ?>
                                <div class="pc-hot"></div>
                            <? } ?>
                            <? if ($prod->skidka) { ?>
                                <div class="pc-skidka"><?="-".$prod->skidka."%" ?></div>
                            <? } ?>
                            <?	if($prod->uploaded > (time() - 45*86400)){?>
                                <div class="pc-new"></div>
                            <?	}?>
                        </div>
                        <div class="col-md-7">
                            <h6><a href="/catalog/prod-<?= $prod->id ?>"><?=$prod->name?></a></h6>
                            <span class="weight" style="display:block;float:left;width:175px;">В упаковке: &nbsp;
                                <?	if($prod->num2 || $prod->num3){?>
                                    <select name="var" onchange="changepack(<?=$prod->id?>, this.value);">
                                        <?	if($prod->num){?>
                                            <option value="1"><?=$prod->inpack?></option>
                                        <?	}?>
                                        <?	if($prod->num2){?>
                                            <option value="2"><?=$prod->inpack2?></option>
                                        <?	}?>
                                        <?	if($prod->num3){?>
                                            <option value="3"><?=$prod->inpack3?></option>
                                        <?}?>
                                    </select>
                                <?	}else{
                                    echo $prod->inpack;
                                }?>
                                &nbsp;
							</span>
							<span class="weight" style="display:block;float:left;width:175px;">
								Вес упаковки: &nbsp;
                                <?$k = 0;?>
                                <?if($prod->num){?>
                                    <span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar1"><?= $prod->weight ?> г</span>
                                <?}?>
                                <?if($prod->num2){?>
                                    <span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar2"><?= $prod->weight2 ?> г</span>
                                <?}?>
                                <?if($prod->num3){?>
                                    <span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar3"><?= $prod->weight3 ?> г</span>
                                <?}?>
                                &nbsp;
							</span>
                        </div>
                        <div class="col-md-3">
                            <div class="xprice">
                                <?$this->prodone = $prod;?>
                                <?=$this->render('catalog/prod-price.php');?>
                            </div>
                            <div class="xform">
                                <form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
                                    <?
                                    if($prod->num3) {$prodvar = 3;}
                                    if($prod->num2) {$prodvar = 2;}
                                    if($prod->num) {$prodvar = 1;}
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
                                            <?if(!in_array($prod->id, $this->cartids)) {?>
                                                <button class="btn btn-theme m-b-1 form-control active focus" type="button" data-prod-id="<?= $prod->id ?>" onclick="
                                                    _gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']);
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
                            </div>
                            <?if (isset($_COOKIE['userid'])) {?>
                            <form action="/user/wishlist/add/<?= $prod->id ?>" method="post" id="wishform_<?= $prod->id ?>">
                                <input type="hidden" name="id" value="<?= $prod->id ?>" />
                                <input type="hidden" name="ajax" value="1" class="ajax" />
                                <input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
                                &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $prod->id ?>); return false;" class="awl"><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний</a>
                            </form>
                            <?}?>
                        </div>
                    </div>
                </div>
            <? } ?>

        <? } else { ?>
            <? $i = 0;
            foreach ($this->prods as $prod) { ?>
                <div class="col-sm-4 col-md-4 box-product-outer bpo-grid">
                    <div class="box-product">
                        <div class="img-wrapper">
                            <a href="/catalog/prod-<?= $prod->id ?>">
                                <?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
                                    <img alt="Product" src="/pic/prod/<?= $prod->id ?>.jpg">
                                <?} else {?>
                                    <img alt="Product" src="<?=$this->path?>/img/tr.gif">
                                <?}?>
                            </a>
                        </div>
                        <? if ($prod->pop) { ?>
                            <div class="pc-hot"></div>
                        <? } ?>
                        <? if ($prod->skidka) { ?>
                            <div class="pc-skidka"><?="-".$prod->skidka."%" ?></div>
                        <? } ?>
                        <?	if($prod->uploaded > (time() - 45*86400)){?>
                            <div class="pc-new"></div>
                        <?	}?>
                        <?if (isset($_COOKIE['userid'])) {?>
                        <div class="pa">
                            <div class="pc-wish">
                                <form action="/user/wishlist/add/<?= $prod->id ?>" method="post" id="wishform_<?= $prod->id ?>">
                                    <input type="hidden" name="id" value="<?= $prod->id ?>" />
                                    <input type="hidden" name="ajax" value="1" class="ajax" />
                                    <input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
                                    &nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $prod->id ?>); return false;" class="awl"><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний&nbsp;&nbsp;</a>
                                </form>
                            </div>
                        </div>
                        <?}?>
                        <h6><a href="/catalog/prod-<?= $prod->id ?>"><?=$prod->name?></a></h6>
                        <div class="xprice">
                            <?$this->prodone = $prod;?>
                            <?=$this->render('catalog/prod-price.php');?>
                        </div>
                        <div class="xform">
                            <form action="<?= $this->url->gvar("buy=1") ?>" method="post" id="prodform_<?= $prod->id ?>">
                                <?
                                if($prod->num3) {$prodvar = 3;}
                                if($prod->num2) {$prodvar = 2;}
                                if($prod->num) {$prodvar = 1;}
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
                                        <?if(!in_array($prod->id, $this->cartids)) {?>
                                            <button class="btn btn-theme m-b-1 form-control active focus" type="button" data-prod-id="<?= $prod->id ?>" onclick="
                                                _gaq.push(['_trackEvent', 'Buy', 'Click_buy', 'Buy']);
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
                        </div>
                    </div>
                </div>
            <? } ?>
        <? } ?>

    <?}?>
    <div class="clearfix"></div>

    <?if(count($this->prods)){?>
        <div class="listingPageLinks">
            <?= $this->render('rule.php') ?>
        </div>
    <?}?>
    <div class="clear"></div>

    <?
}else{
    if($_GET['novinki']){
        echo "За последние 30 дней не было добавлено ни одного нового товара в данную категорию<br /><br />";
        echo "<a href=\"/".$this->url->page.$this->url->gvar("novinki=")."\">Показать все товары в категории</a>";
    }
} ?>
