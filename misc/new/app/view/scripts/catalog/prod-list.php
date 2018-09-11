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
    $Prod = new Model_Prod();
    $cprods = $Prod->getall(array('order' => 'rand()', 'limit' => 60));
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
                        <div class="col-md-2 col-xs-4 label-box">
                            <div class="img-wrapper pl-image-detail">
                                <a class="group" href="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&amp;width=665">
                                    <?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
                                        <img src="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&amp;width=665" alt="<?=$prod->name?>">
                                    <?} else {?>
                                        <img src="<?=$this->path?>/img/tr.gif">
                                    <?}?>
                                </a>
                                <a class="group2" href="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&amp;width=535">
                                    <?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
                                        <img src="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&amp;width=535" alt="<?=$prod->name?>">
                                    <?} else {?>
                                        <img src="<?=$this->path?>/img/tr.gif">
                                    <?}?>
                                </a>
                            </div>
                            <? if ($prod->pop) { ?>
                                <div class="pc-hot"></div>
                            <? } ?>
                            <? if ($prod->skidka || $prod->skidka2 || $prod->skidka3) { ?>
                                <div class="pc-skidka"><?="-".max($prod->skidka, $prod->skidka2, $prod->skidka3)."%" ?></div>
                            <? } ?>
                            <?	if($prod->new){?>
                                <div class="pc-new"></div>
                            <?	}?>
                        </div>
                        <div class="col-md-7 col-xs-8">
                            <div class="h6"><a href="/catalog/prod-<?= $prod->id ?>"><?=$prod->name?></a></div>
                            <div class="pl-colors">
                                <?
                                $c=0;
                                $ccount = 10;
                                foreach($cprods as $cprod) {
                                    if (file_exists('pic/prod/'.$cprod->id.'.jpg')) {
                                        ?>
                                        <img src="/thumb?src=pic/prod/<?=$cprod->id?>.jpg&amp;width=28&amp;height=28" alt="<?=$cprod->name?>" data-id="<?= $cprod->id ?>"<?if($c>$ccount){?> class='color-hidden'<?}?>>
                                        <?
                                    }
                                    if($c++==$ccount) {?>
                                        <a href="#" class="color-show" onclick="var $this = $(this); $(this).parent().find('img').each(function(){
                                            $(this).removeClass('color-hidden');
                                            $this.addClass('color-hidden');
                                        }); return false;">Показать все</a>
                                    <?}
                                }
                                ?>
                            </div>
                            <?$this->prodone = $prod;?>
                            <div class="weight-block">
                                <?=$this->render('catalog/prod-weight.php');?>
                            </div>
                            <div class="xprice">
                                <?=$this->render('catalog/prod-price.php');?>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-12">
                            <div class="xprice">
                                <?=$this->render('catalog/prod-price.php');?>
                            </div>
                            <div class="xform">
                                <?=$this->render('catalog/prod-form.php');?>
                            </div>
                            <div class="xwish">
                                <?=$this->render('catalog/prod-wish.php');?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            <? } ?>

        <? } else { ?>
            <? $i = 0;
            foreach ($this->prods as $prod) { ?>
                <div class="col-sm-4 col-md-4 box-product-outer bpo-grid">
                    <div class="box-product label-box">
                        <div class="img-wrapper">
                            <a href="/catalog/prod-<?= $prod->id ?>">
                                <?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
                                    <img src="/thumb?src=pic/prod/<?= $prod->id ?>.jpg&amp;width=665" alt="<?=$prod->name?>">
                                <?} else {?>
                                    <img src="<?=$this->path?>/img/tr.gif">
                                <?}?>
                            </a>
                        </div>
                        <? if ($prod->pop) { ?>
                            <div class="pc-hot"></div>
                        <? } ?>
                        <? if ($prod->skidka || $prod->skidka2 || $prod->skidka3) { ?>
                            <div class="pc-skidka"><?="-".max($prod->skidka, $prod->skidka2, $prod->skidka3)."%" ?></div>
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
                                    <div class="xwish">
                                        <?=$this->render('catalog/prod-wish.php');?>
                                    </div>
                                </div>
                            </div>
                        <?}?>
                        <div class="pl-colors color-slider">
                            <?
                            foreach($cprods as $cprod) {
                                if (file_exists('pic/prod/'.$cprod->id.'.jpg')) {
                                    ?>
                                    <img src="/thumb?src=pic/prod/<?=$cprod->id?>.jpg&amp;width=28&amp;height=28" alt="<?=$cprod->name?>" data-id="<?= $cprod->id ?>">
                                    <?
                                }
                            }
                            ?>
                        </div>
                        <div class="h6"><a href="/catalog/prod-<?= $prod->id ?>"><?=$prod->name?></a></div>
                        <?$this->prodone = $prod;?>
                        <div class="weight-block">
                            <?=$this->render('catalog/prod-weight.php');?>
                        </div>
                        <div class="xprice">
                            <?=$this->render('catalog/prod-price.php');?>
                        </div>
                        <div class="xform">
                            <?=$this->render('catalog/prod-form.php');?>
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
