<?	$k = 1;?>
<?//	print_r($this->prodone);
//	if($this->prodone->id == 33905) print_r($this->prodone);
for($i = 1; $i <= 3; $i++){?>
<?	if (($i == 1 && $this->prodone->skidka) || ($i != 1 && $this->prodone->{'skidka'.$i})) { // На товар есть акция. Никаких других скидок на него быть не может
        $num_var = ($i == 1) ? 'num' : 'num'.$i;
        $price_var = ($i == 1) ? 'price' : 'price'.$i;
		$skidka_var = ($i == 1) ? 'skidka' : 'skidka'.$i;
        $inpack_var = ($i == 1) ? 'inpack' : 'inpack'.$i;

        if($this->prodone->$num_var > 0){?>
            <span class="prodvar prodvar<?=$k++?> <?=$this->prodone->id?>prodvar <?=$this->prodone->id?>prodvar<?=$i?>">
				<span style="display:block;width:175px; font-size: 14px;">
					<font style="text-decoration: line-through; font-size: 14px;"><?= Func::fmtmoney($this->prodone->$price_var) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $this->prodone->$inpack_var ?></font>
				</span>
				<span style="display:block;width:175px; font-size: 14px;">
					<span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($this->prodone->$price_var * (100 - $this->prodone->$skidka_var) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span> / <?= $this->prodone->$inpack_var ?>&nbsp;
				</span>
			</span>
<?		}?>
<?	}elseif(($i == 1 && $this->prodone->{'numdiscount'}) || ($i != 1 && $this->prodone->{'numdiscount'.$i})){ // Есть скидка от количества упаковок. Будет несколько цен. Каждая уже со скидкой постоянного клиента, если она у него есть. Учитываем только $userdiscount
		$num_var = ($i == 1) ? 'num' : 'num'.$i;
        $price_var = ($i == 1) ? 'price' : 'price'.$i;
		$skidka_var = ($i == 1) ? 'skidka' : 'skidka'.$i;
        $inpack_var = ($i == 1) ? 'inpack' : 'inpack'.$i;
        $numdiscount_var = ($i == 1) ? 'numdiscount' : 'numdiscount'.$i;
        if($this->prodone->$num_var > 0){?>
            <span class="prodvar prodvar<?=$k++?> <?=$this->prodone->id?>prodvar <?=$this->prodone->id?>prodvar<?=$i?>">
                <?
                $nd = 0;
                foreach(AS_Skidka::skidka_decode($this->prodone->$numdiscount_var) as $k => $n){?>
                    <?if($nd++==0) {$maxprice = Func::fmtmoney($this->prodone->$price_var * (100 - (AS_Discount::getUserDiscount() + $n['skidka'])) / 100);}?>
                    <span style="display:block;width:175px; font-size: 14px;" class="numdiscount">
					<span class="ndiscount"><?=$n['min']?><?=($n['max'] == MAX_VALUE) ? '+' : '-'.$n['max']?>:</span>
					<span style="color:red; font-weight: bold; font-size: 14px;">
					<?= Func::fmtmoney($this->prodone->$price_var * (100 - (AS_Discount::getUserDiscount() + $n['skidka'])) / 100) ?>&nbsp;<?= $this->valuta['name'] ?>
					</span>
                        <?/* / <?= $this->prodone->$inpack_var ?>&nbsp;*/?>
				</span>
                <?				}?>
                <?$minprice = Func::fmtmoney($this->prodone->$price_var * (100 - (AS_Discount::getUserDiscount() + $n['skidka'])) / 100);?>
                <span style="color:red; font-weight: bold; font-size: 14px;" class="pricediscount"><?=$minprice?> - <?=$maxprice?> <?= $this->valuta['name'] ?></span>
			</span>

<?		}?>
<?	}elseif (AS_Discount::getUserDiscount() > 0) { // У клиента есть накопительная скидка и он не оптовик. Проверка на всякий случай, он автоматически не оптовик

		$num_var = ($i == 1) ? 'num' : 'num'.$i;
        $price_var = ($i == 1) ? 'price' : 'price'.$i;
        $inpack_var = ($i == 1) ? 'inpack' : 'inpack'.$i;

        if($this->prodone->$num_var > 0){?>
            <span class="prodvar prodvar<?=$k++?> <?=$this->prodone->id?>prodvar <?=$this->prodone->id?>prodvar<?=$i?>">
				<span style="display:block;padding-left:10px;width:175px; font-size: 14px;"><s><?= Func::fmtmoney($this->prodone->$price_var) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $this->prodone->$inpack_var ?>&nbsp;</s></span>
				<span style="display: block;padding-left:10px;width:175px; font-size: 14px;"><span style="color:red; font-weight: bold; font-size: 14px;"><?= Func::fmtmoney($this->prodone->$price_var * (100 - AS_Discount::getUserDiscount()) / 100) ?>&nbsp;<?= $this->valuta['name'] ?></span> / <?= $this->prodone->$inpack_var ?>&nbsp;</span><br />
			</span>
        <?			}?>
<?	} else { // Нет никаких скидок
        $num_var = ($i == 1) ? 'num' : 'num'.$i;
        $price_var = ($i == 1) ? 'price' : 'price'.$i;
        $inpack_var = ($i == 1) ? 'inpack' : 'inpack'.$i;

        if($this->prodone->$num_var > 0){?>
            <span class="prodvar prodvar<?=$k++?> <?=$this->prodone->id?>prodvar <?=$this->prodone->id?>prodvar<?=$i?>">
				<span style="display:block;width:175px; font-size: 14px;"><?= Func::fmtmoney($this->prodone->$price_var) ?>&nbsp;<?= $this->valuta['name'] ?> / <?= $this->prodone->$inpack_var ?>&nbsp;</span>
			</span>
<?		}?>
<?	}?>
<?	
}?>