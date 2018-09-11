<script type="text/javascript">
    (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() {
		try { rrApi.categoryView(<?=$this->cat?>); } catch(e) {}
	})
</script>

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
        <h1 class="pl-h1"><?= $this->page->h1 ?></h1>
    <?	}?>

    <?	if($_SERVER['REQUEST_URI'] == $this->canonical && count($this->cats) == 0){?>

        <?	echo $this->page->cont2;?>

    <?	}?>

    <?if(count($this->prods)){?>
        <div class="listingPageLinks">
            <?= $this->render('rule.php') ?>
        </div>
    <?}?>
    <div class="clear"></div>

    <div class="pc-buy">
        <?/*	if($this->args[0] == 'catalog' && $this->args[1] != 'new' && $this->new_count && $this->args[1] != 'top'){?>
        <button class="btn btn-theme m-b-2" type="button" onclick="location.href = '?novinki=1';">Показать новинки</button>
        <?	}*/?>

    </div>
    <!-- Product Sorting Bar -->
    <div class="product-sorting-bar">
        <div class="psb-view pull-left">
            Вид:
            <a href="<?= $this->url->gvar("view=list") ?>" class="list<? if (!isset($this->view_mode) || $this->view_mode == 'list') { ?>a<? } ?>"><i class="fa fa-list-ul"></i> Список</a>
            <a href="<?= $this->url->gvar("view=grid") ?>" class="grid<? if ($this->view_mode == 'grid') { ?>a<? } ?>"><i class="fa fa-th-large"></i> Сетка</a>
        </div>
        <div class="pull-right pl-count">Показано:
            <select name="show" class="selectpicker" data-width="60px" onchange="countchange(value);">
                <option value="30"<? if ($this->results == 30) { ?> selected="selected"<? } ?>>30</option>
                <option value="60"<? if ($this->results == 60) { ?> selected="selected"<? } ?>>60</option>
                <option value="90"<? if ($this->results == 90) { ?> selected="selected"<? } ?>>90</option>
            </select>
        </div>
        <?
        $par = 0 + $this->params;
        $cat = 0 + $this->cat;

        $chars = array();
        if ($opt["prod_chars"]) {
            $Char = new Model_Char();
            if ($par == 1 || $par == 0)
                $chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat) . " and search = '1'", "order" => "prior desc"));
            else if ($par == 2)
                $chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat) . " and (search = '1' or search = '2')", "order" => "prior desc"));
            else
                $chars = $Char->getall(array("where" => Model_Cat::cat_tree($cat) . " and (search = '1' or search = '2' or search = '3')", "order" => "prior desc"));
        }
        if (((count($this->prods))||($_GET['filter']==1))&&($this->cat)) {
        ?>
        <div class="psb-view pull-right pl-filter">
            <a href="#" class="list" onclick="openNav(); return false;"><i class="fa fa-filter"></i></a>
        </div>
        <?}?>
        <div class="pull-right pl-sort">
            <?= $this->render('catalog/sort.php') ?>
        </div>

    </div>
    <!-- End Product Sorting Bar -->

    <div id="mfilter" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
       <div class="h4 es2h4">Фильтр</div>
        <?if($this->cat) echo $this->render('block/extsearch2.php')?>
    </div>


    <?if(!count($this->prods)){?><div class="pl-empty">По данному запросу нет совпадений</div><?} else {?>

        <? if ($this->view_mode == 'list' || !isset($this->view_mode)) { ?>
            <? $i = 0;
            foreach ($this->prods as $prod) { ?>
                <div class="col-md-12 box-product-outer bpo-list">
                    <div class="box-product">
                        <div class="col-md-2 col-xs-4">
                            <div class="img-wrapper pl-image-detail">
                                <a class="group" href="/pic/prod/<?= $prod->id ?>.jpg">
                                    <img class="b-lazy" src="/app/view/img/loading-img.gif" data-src="/pic/prod/<?= $prod->id ?>.jpg" alt="<?=$prod->name?>">
                                </a>
                                <a class="group2" href="/pic/prod/<?= $prod->id ?>.jpg">
                                    <img class="b-lazy" src="/app/view/img/loading-img.gif" data-src="/pic/prod/<?= $prod->id ?>.jpg" alt="<?=$prod->name?>">
                                </a>
                            </div>
                            <? if ($prod->pop) { ?>
                                <div class="pc-hot"></div>
                            <? } ?>
                            <?/* if ($prod->skidka || $prod->skidka2 || $prod->skidka3) { ?>
                                <div class="pc-skidka"><?="-".max($prod->skidka, $prod->skidka2, $prod->skidka3)."%" ?></div>
                            <? } */?>
                            <? if ($prod->skidka) { ?>
                                <div class="pc-skidka pc-skidka-1 pc-skidka-id-<?=$prod->id?>"><?="-".$prod->skidka."%" ?></div>
                            <? } ?>
                            <? if ($prod->skidka2) { ?>
                                <div class="pc-skidka pc-skidka-2 pc-skidka-id-<?=$prod->id?> hidden"><?="-".$prod->skidka2."%" ?></div>
                            <? } ?>
                            <? if ($prod->skidka3) { ?>
                                <div class="pc-skidka pc-skidka-3 pc-skidka-id-<?=$prod->id?> hidden"><?="-".$prod->skidka3."%" ?></div>
                            <? } ?>
                            <?	if($prod->new){?>
                                <div class="pc-new"></div>
                            <?	}?>
                        </div>
                        <div class="col-md-7 col-xs-8">
                            <div class="h6"><a href="/catalog/prod-<?= $prod->id ?>"><?=$prod->name?></a></div>
                            <span class="weight" style="display:block;float:left;width:175px;">Упак.: &nbsp;
                                <?	if($prod->num2 > 0 || $prod->num3 > 0){?>
                                    <select name="var" onchange="changepack(<?=$prod->id?>, this.value);">
                                        <?	if($prod->num > 0){?>
                                            <option value="1"><?=$prod->inpack?></option>
                                        <?	}?>
                                        <?	if($prod->num2 > 0){?>
                                            <option value="2"><?=$prod->inpack2?></option>
                                        <?	}?>
                                        <?	if($prod->num3 > 0){?>
                                            <option value="3"><?=$prod->inpack3?></option>
                                        <?}?>
                                    </select>
                                <?	}else{
                                    echo $prod->inpack;
                                }?>
                                &nbsp;
							</span>
							<span class="weight" style="display:block;float:left;width:175px;">
								Вес упак.: &nbsp;
                                <?$k = 0;?>
                                <?if($prod->num > 0){?>
                                    <span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar1"><?= $prod->weight ?> г</span>
                                <?}?>
                                <?if($prod->num2 > 0){?>
                                    <span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar2"><?= $prod->weight2 ?> г</span>
                                <?}?>
                                <?if($prod->num3 > 0){?>
                                    <span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar3"><?= $prod->weight3 ?> г</span>
                                <?}?>
                                &nbsp;
							</span>
                            <div class="xprice">
                                <?$this->prodone = $prod;?>
                                <?=$this->render('catalog/prod-price.php');?>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <div class="xprice">
                                <?$this->prodone = $prod;?>
                                <?=$this->render('catalog/prod-price.php');?>
                            </div>
                            <div class="xform">
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
                            <?if (Model_User::userid()) {?>
                                <form action="/user/wishlist/add/<?= $prod->id ?>" method="post" id="wishform_<?= $prod->id ?>">
                                    <input type="hidden" name="id" value="<?= $prod->id ?>" />
									<input type="hidden" name="var" value="<?=$prodvar?>" class="prodvar<?=$prod->id?>"/>
                                    <input type="hidden" name="ajax" value="1" class="ajax" />
                                    <input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $prod->id ?>); return false;" class="awl"><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний</a>
                                </form>
                            <?}?>
                        </div>
                        <div class="clear"></div>
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
                                <img class="b-lazy" src="/app/view/img/loading-img.gif" data-src="/pic/prod/<?= $prod->id ?>.jpg" alt="<?=$prod->name?>">
                            </a>
                        </div>
                        <? if ($prod->pop) { ?>
                            <div class="pc-hot"></div>
                        <? } ?>
                        <?/* if ($prod->skidka || $prod->skidka2 || $prod->skidka3) { ?>
                            <div class="pc-skidka"><?="-".max($prod->skidka, $prod->skidka2, $prod->skidka3)."%" ?></div>
                        <? } */?>
                        <? if ($prod->skidka) { ?>
                            <div class="pc-skidka pc-skidka-1 pc-skidka-id-<?=$prod->id?>"><?="-".$prod->skidka."%" ?></div>
                        <? } ?>
                        <? if ($prod->skidka2) { ?>
                            <div class="pc-skidka pc-skidka-2 pc-skidka-id-<?=$prod->id?> hidden"><?="-".$prod->skidka2."%" ?></div>
                        <? } ?>
                        <? if ($prod->skidka3) { ?>
                            <div class="pc-skidka pc-skidka-3 pc-skidka-id-<?=$prod->id?> hidden"><?="-".$prod->skidka3."%" ?></div>
                        <? } ?>
                        <?	if($prod->new){?>
                            <div class="pc-new"></div>
                        <?	}?>
                        <?if (Model_User::userid()) {?>
						<?
                                if($prod->num3 > 0) {$prodvar = 3;}
                                if($prod->num2 > 0) {$prodvar = 2;}
                                if($prod->num > 0) {$prodvar = 1;}
                                ?>
                            <div class="pa">
                                <div class="pc-wish">
                                    <form action="/user/wishlist/add/<?= $prod->id ?>" method="post" id="wishform_<?= $prod->id ?>">
                                        <input type="hidden" name="id" value="<?= $prod->id ?>" />
										<input type="hidden" name="var" value="<?=$prodvar?>" class="prodvar<?=$prod->id?>"/>
                                        <input type="hidden" name="ajax" value="1" class="ajax" />
                                        <input type="hidden" name="fromurl" value="<?= $_SERVER['REQUEST_URI'] . $this->url->gvar(time() . "=") ?>" class="prod_id" />
                                        &nbsp;&nbsp;<a href="#" onclick="wishlist(<?= $prod->id ?>); return false;" class="awl"><img src="<?= $this->path ?>/img/add-wish-list.png" alt="" />&nbsp;В список желаний&nbsp;&nbsp;</a>
                                    </form>
                                </div>
                            </div>
                        <?}?>
                        <div class="h6"><a href="/catalog/prod-<?= $prod->id ?>"><?=$prod->name?></a></div>
                        <div class="weight">Упак.: &nbsp;
                            <?	if($prod->num2 > 0 || $prod->num3 > 0){?>
                                <select name="var" onchange="changepack(<?=$prod->id?>, this.value);">
                                    <?	if($prod->num > 0){?>
                                        <option value="1"><?=$prod->inpack?></option>
                                    <?	}?>
                                    <?	if($prod->num2 > 0){?>
                                        <option value="2"><?=$prod->inpack2?></option>
                                    <?	}?>
                                    <?	if($prod->num3 > 0){?>
                                        <option value="3"><?=$prod->inpack3?></option>
                                    <?}?>
                                </select>
                            <?	}else{
                                echo $prod->inpack;
                            }?>

                        </div>
                        <div class="weight">
                            Вес упак.: &nbsp;
                            <?$k = 0;?>
                            <?if($prod->num > 0){?>
                                <span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar1"><?= $prod->weight ?> г</span>
                            <?}?>
                            <?if($prod->num2 > 0){?>
                                <span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar2"><?= $prod->weight2 ?> г</span>
                            <?}?>
                            <?if($prod->num3 > 0){?>
                                <span class="<?=$prod->id?>prodvar prodvar prodvar<?=++$k?> <?=$prod->id?>prodvar <?=$prod->id?>prodvar3"><?= $prod->weight3 ?> г</span>
                            <?}?>

                        </div>
                        <div class="xprice">
                            <?$this->prodone = $prod;?>
                            <?=$this->render('catalog/prod-price.php');?>
                        </div>
                        <div class="xform">
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
