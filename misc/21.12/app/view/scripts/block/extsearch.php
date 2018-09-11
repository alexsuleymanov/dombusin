<style>
	#extnum {
		position: absolute;
		left: 210px;
		border: 3px solid #ffda44;
		border-radius: 5px 0 5px 5px;
		-moz-border-radius: 5px 0 5px 5px;
		-webkit-border-radius: 5px 0 5px 5px;
		-khtml-border-radius: 5px 0 5px 5px;
		width: 126px;
		height: 67px;
		line-height: 20px;
		font-size: 12px;
		text-align: center;
		box-shadow: 1px 2px 3px 2px rgba(0, 0, 0, 0.37);
		-moz-box-shadow: 1px 2px 3px 2px rgba(0, 0, 0, 0.37);
		-webkit-box-shadow: 1px 2px 3px 2px rgba(0, 0, 0, 0.37);
		-khtml-box-shadow: 1px 2px 3px 2px rgba(0, 0, 0, 0.37);
		background: #fff;
		color: #41679e;
		display: none;
		z-index: 33;
	}
	#extnum:after {
		content: " ";
		position: absolute;
		display: block;
		width: 16px;
		height: 21px;
		position: absolute;
		left: -16px;
		top: -3px;
		background: url(<?=$this->path?>/img/s_253tm2.png) -1px -1px no-repeat;
	}
	#extnum span {
		display: block;
		margin: 10px 0 5px;
	}
</style>
<script>
	var extnum = null;
	function extsearchcount(data){
		$('#extnum span b').text(data.num);
	}
	$(document).ready(function(){
		$('#extsearch input').on('change', function() {
			extnum = $(this);
			
			$.get($("#extsearch").attr('action'), $("#extsearch").serialize()+'&getnum=1', extsearchcount, "json").done(function() {
				
				$('#extnum').css('display', 'block');
				$('#extnum').insertBefore(extnum);
			});
		});
	});
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
	"select" => "id, pop, skidka, changed",
	"where" => "visible = 1 and num > 0",
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
		$condp["where"] .= " and changed > ".(time() - 45*86400);
		break;
	case 'pop':
		$condp["where"] .= " and pop = 1";
		break;
	case 'action':
		$condp["where"] .= " and skidka > 0";
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
if(($this->args[1]==='new')||($this->args[1]==='action')||($this->args[1]==='pop')) {
	$supurl = $this->args[1]."/".$this->args[2]."/";
} else {
	$supurl = $this->args[1]."/";
}
//	print_r($pc);
?>
<div id="extnum">
	<span id="total-filter-count">Выбрано: <b>0</b></span>
	<input type="submit" value="Показать">
</div>
<div class="left-tab" id="left-tab-2" <?if(count($this->prods)){?> style="display: block;"<?}else{?> style="display: none;"<?}?>>
	<div style="padding: 10px;">
		<form action="/<?= $this->args[0] ?>/<?=$supurl?>" method="get" id="extsearch">
			<input type="hidden" name="filter" value="1">
			<table cellspacing="0" cellpadding="0" border="0" width="180" id="filterform">
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
								<?/*								<tr>
									<td><strong>Цена: </strong></td>
								</tr>
								<tr>
									<td class="char">от <input type="text" name="minprice" size="5" value="<?= $_GET["minprice"] ?>"> до <input type="text" name="maxprice" size="5" value="<?= $_GET["maxprice"] ?>"> грн.</td>
								</tr>*/?>
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
														<? foreach ($charvals as $charval) { ?>
															<input type="checkbox" name="char<?= $r->id ?>[]"
															       value="<?= $charval->id ?>" <? if (is_array($this->chars[$r->id]) && in_array($charval->id,
																	$this->chars[$r->id])
															) {
																echo "checked=1";
															} ?>> <?= $charval->value ?><br>
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
				<tr>
					<td align="center"><input type="submit" name="submit" value="Подобрать" id="extsearch-do"></td>
				</tr>
			</table>
		</form>
	</div>
</div>
