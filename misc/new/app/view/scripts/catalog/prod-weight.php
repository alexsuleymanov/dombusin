<?$prod = $this->prodone?>
<div class="weight weight1">В упаковке: &nbsp;
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
<div class="weight weight2">
    Вес упаковки: &nbsp;
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