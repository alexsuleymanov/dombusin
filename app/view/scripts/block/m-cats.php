<?
$Cat = new Model_Cat();
$supcats = $Cat->getall(array("where" => "cat = 0 and visible = 1", "order" => "prior desc, name asc"));
if(count($supcats)) {
    ?>
    <section class="m-cats" id="m-cats">
        <div class="title"><span>Категории товаров</span></div>
        <div class="slinky">
            <ul>
                <? foreach ($supcats as $k => $supcat_r) { ?>
                    <li>
                        <?$cats = $Cat->getall(array("where" => "cat = $supcat_r->id and visible = 1", "order" => "prior desc, name asc"));?>
                        <a href="/catalog/cat-<?= $supcat_r->id ?>-<?= $supcat_r->intname ?>"><?= $supcat_r->name ?></a>
                        <?if (count($cats)) {?>
                            <ul>
                                <?foreach ($cats as $sk => $cat_r) {?>
                                    <li>
                                        <?$subcats = $Cat->getall(array("where" => "cat = $cat_r->id and visible=1", "order" => "prior desc"));?>
                                        <a href="/catalog/cat-<?= $cat_r->id ?>-<?= $cat_r->intname ?>"><?= $cat_r->name ?></a>
                                        <?if (count($subcats)) {?>
                                            <ul>
                                                <?foreach($subcats as $sk1 => $scat_r) {?>
                                                    <li>
                                                        <a href="/catalog/<?=$supurl?>cat-<?=$scat_r->id?>-<?=$scat_r->intname?>"><?=$scat_r->name?></a>
                                                    </li>
                                                <?}?>
                                            </ul>
                                        <?}?>
                                    </li>
                                <?}?>
                            </ul>
                        <?}?>
                    </li>
                <?}?>
            </ul>
        </div>
    </section>
<?}?>