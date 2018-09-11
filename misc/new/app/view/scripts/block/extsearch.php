<script>
	var extnum = null;
	function extsearchcount(data){
		console.log(data);
		$('#extnum span b').text(data.num);
	}
	$(document).ready(function(){
		$('#extsearch input').on('change', function() {
			extnum = $(this);
			
//			console.log($("#extsearch").attr('action')+$("#extsearch").serialize()+'&getnum=1');
			$.get($("#extsearch").attr('action'), $("#extsearch").serialize()+'&getnum=1', extsearchcount, "json").done(function() {
				$('#extnum').css('display', 'block');
				$('#extnum').insertBefore(extnum);
			});
		});
	});
	function extsearchShow(extnum) {
		$.get($("#extsearch").attr('action'), $("#extsearch").serialize()+'&getnum=1', extsearchcount, "json").done(function() {
			$('#extnum').css('display', 'block');
			$('#extnum').insertBefore(extnum);
		});
	}
</script>
<?
$opt = Zend_Registry::get('opt');
//	par == 1  Основные параметры
//	par == 2  Расширенные параметры
//  par == 3  Все параметры

$par = 0 + $this->params;
$cat = 0 + $this->cat;

$Prod = new Model_Prod();
$condp = array(
	"select" => "id, pop, mix, skidka, uploaded",
	"where" => "visible = 1 and (num > 0 or num2 > 0 or num3 > 0)",
	/*"relation" => array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".data_base::nq($cat)."'")*/);

$cat = data_base::nq($this->cat);
$cats_list = "(" . $cat;
$Cat = new Model_Cat();
$subcats = $Cat->getall(array("where" => "cat = " . $cat . " and visible = 1"));
if (count($subcats)) {
	foreach ($subcats as $subcat) {
		$cats_list .= ', ' . $subcat->id;
		$subsubcats = $Cat->getall(array("where" => "cat = " . $subcat->id . " and visible = 1"));
		if (count($subsubcats)) {
			foreach ($subsubcats as $subsubcat) {
				$cats_list .= ', ' . $subsubcat->id;
			}
		}
	}
}
$cats_list .= ")";
$condp["relation"] = array(
	"select" => "relation",
	"where" => "`type` = 'cat-prod' and obj in " . $cats_list
);

switch($this->args[1]) {
	case 'new':
		$condp["where"] .= " and `new` = 1";			
		break;
	case 'pop':
		$condp["where"] .= " and pop = 1";
		break;
	case 'mix':
		$condp["where"] .= " and mix = 1";
		break;	
	case 'action':
		if($_SESSION['useropt']) $condp["where"] .= " and skidkaopt > 0";
		else $condp["where"] .= " and skidka > 0";
		break;
}


$prods = $Prod->getall($condp);

if(count($prods)){
	$condpc = array("where" => "(");
	foreach($prods as $kc => $p){
		if($kc) $condpc["where"] .= " or ";
		$condpc["where"] .= "`prod` = ".$p->id;
	}

	$condpc["where"] .= ")";
}else{
	$condpc["where"] .= "id < 0";
}

$Prodchar = new Model_Prodchar();
$prodchars = $Prodchar->getall($condpc);
//	print_r($condpc);
//	print_r($prodchars);
foreach($prodchars as $prodchar){
	$pc[] = $prodchar->charval;
}

$supurl = '';
if(($this->args[1]==='new')||($this->args[1]==='action')||($this->args[1]==='pop')||($this->args[1]==='mix')) {
	$supurl = $this->args[1]."/".$this->args[2]."/";
} else {
	$supurl = $this->args[1]."/";
}
//	print_r($pc);
//	echo $supurl;
?>
<div id="extnum">
	<span id="total-filter-count">Выбрано: <b>0</b></span>
	<input type="submit" value="Показать">
</div>
<div class="left-tab" id="left-tab-2" <?if(count($this->prods)){?> style="display: block;"<?}else{?> style="display: none;"<?}?>>
	<div style="padding: 10px;">
		<form action="/<?= $this->args[0] ?>/<?=$supurl?>" method="get" id="extsearch">
			<input type="hidden" name="filter" value="1">
			<table cellspacing="0" cellpadding="0" border="0" id="filterform">
				<? if ($opt["prod_brands"] == 2) { ?>
					<tr>
						<td valign="top">
							<table cellspacing="0" cellpadding="0" border="0" width="90%">
								<tr>
									<td><strong><?= $this->labels["manufacturer"] ?></strong></td>
								</tr>
								<?
								$Brand = new Model_Brand();
								$brands = $Brand->getall(array("order" => "name"));
								foreach ($brands as $brand) {
									if ($nnn++ % 2 == 0)
										echo "<tr>";
									?>
									<tr>
										<td class="char"><input type="checkbox" name="brand<?= $brand->id ?>" value="<?= $brand->id ?>" <? if ($_GET["brand" . $brand->id])
												echo "checked"; ?>> <?= $brand->name ?></td>
									</tr>
								<? } ?>
							</table>
						</td>
					</tr>
				<? } ?>
				<? if ($opt["prod_chars"]) { ?>
					<tr>
						<td>
							<script>
								$(document).ready(function(){
									$("input:checkbox").each(function(){
										if (!$(this).is(":checked")) {
											$(this).prop('checked', false);
										}
									});
								});
							</script>

							<?
							$Char = new Model_Char();
							$chars = $Char->getforfilter($cat);
							?>
							<table cellspacing="4" cellpadding="0" border="0" width="100%">
								<? foreach ($chars as $r) {
									if ($r->type == 1) { //есть/нет ?>
										<tr>
											<td><input type="checkbox" name="char<?= $r->id ?>" value="1" <? if (!empty($this->chars[$r->id])) echo "checked=1"; ?>> <strong><?= $r->name ?></strong></td>
										</tr>
									<? } else if ($r->type == 4 || $r->type == 5) { //набор значений
										$Charval = new Model_Charval();
										if(count($pc)) {
											?>
											<tr>
												<td><strong><?= $r->name ?></strong></td>
											</tr>
											<tr>
												<td class="char">
													<div class="cchar">
														<?
														$charvals = $Charval->getall(array(
															"where" => "`char` = '" . $r->id . "' and id in (" . implode(",",
																	$pc) . ")",
															"order" => "prior desc, value"
														)); ?>
														<?if($r->id == 309) {?>
															<? foreach ($charvals as $charval) { ?>
																<div class="pal-item">
																	<input type="checkbox" name="char<?= $r->id ?>[]"
																	       value="<?= $charval->id ?>" <? if (is_array($this->chars[$r->id]) && in_array($charval->id,
																			$this->chars[$r->id])
																	) {
																		echo "checked=1";
																	} ?>>
																	<img src="/pic/charval/<?=$charval->id?>.jpg" alt="<?= $charval->value ?>" title="<?= $charval->value ?>"
																	     onclick = "
																		var ch = $(this).parent().find('input').first();
																		if(ch.is(':checked')) {
																			ch.removeAttr('checked');
																			$(this).removeClass('pal-active');
																			extsearchShow($(this));
																		} else {
																			ch.attr('checked', true);
																			$(this).addClass('pal-active');
																			extsearchShow($(this));
																		}
																		" class="pal<? if (is_array($this->chars[$r->id]) && in_array($charval->id,
																			$this->chars[$r->id])
																	) {
																		echo " pal-active";
																	} ?>">
																</div>
															<? }?>
														<?} else {?>
															<? foreach ($charvals as $charval) { ?>
																<input type="checkbox" name="char<?= $r->id ?>[]"
																       value="<?= $charval->id ?>" <? if (is_array($this->chars[$r->id]) && in_array($charval->id,
																		$this->chars[$r->id])
																) {
																	echo "checked=1";
																} ?>> <?= $charval->value ?><br>
															<? }?>
														<? }?>
													</div>
												</td>
											</tr>
										<?}?>
									<? } ?>
								<? } ?>
							</table>
						</td>
					</tr>
				<? } ?>
<? if ($this->args[1] != 'new' && $this->args[1] != 'pop' && $this->args[1] != 'mix' && $this->args[1] != 'action') { ?>
					<tr>
						<td valign="top">
							<table cellspacing="0" cellpadding="0" border="0" width="90%">
								<tr>
									<td><strong>Продажа</strong></td>
								</tr>
								<tr>
									<td class="char">
										<input type="checkbox" name="sale" value="action" <? if ($this->sale == 'action') echo "checked"; ?>> Распродажа
									</td>
								</tr>
								<tr>
									<td class="char">
										<input type="checkbox" name="sale" value="new" <? if ($this->sale == 'new') echo "checked"; ?>> Новинка
									</td>
								</tr>
								<tr>
									<td class="char">
										<input type="checkbox" name="sale" value="pop" <? if ($this->sale == 'pop') echo "checked"; ?>> Лучшие продажи
									</td>
								</tr>
								<tr>
									<td class="char">
										<input type="checkbox" name="sale" value="mix" <? if ($this->sale == 'mix') echo "checked"; ?>> Миксы
									</td>
								</tr>								
							</table>
						</td>
					</tr>
				<? } ?>					
					<tr>
						<td align="center"><div class="extsearch-space"></div><input type="submit" name="submit" value="Подобрать" id="extsearch-do"></td>
					</tr>
			</table>
		</form>
	</div>
</div>
