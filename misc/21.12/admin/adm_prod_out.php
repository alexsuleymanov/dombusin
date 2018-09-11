<?	$opt = Zend_Registry::get('opt');
?>
<?	if($opt["prod_vars"]){?>
<div id="hiddenvar" style="visibility: hidden;">
	<table class="show" id="var0" width="100%">
		<tr>
			<td class="show" width="39%"><input type='text' id="title" name='var_0_title' style="width: 100%" value="" disabled="true"></td>
			<td class="show" width="39%"><input type='text' id="price" name='var_0_price' style="width: 100%" value="" disabled="true"></td>
			<td class="show" width="2%" id="dela"><a href="" id="a" onclick="remove_var(0); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	function add_row(data){
		table = $("#hiddenvar table:first");
		title = table.find("#title");
		newvar = table.clone();
		newvar.attr({"id": "var"+data});
		newvar.find("#title").attr({"name": "var_"+data+"_title", "disabled": ""});
		newvar.find("#price").attr({"name": "var_"+data+"_price", "disabled": ""});
		newvar.find("#dela").html('<a href="" id="a" onclick="remove_var('+data+'); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');
		$("#vars").append(newvar);
	}

	function remove_row(data){
		$("#var"+data).empty();
	}

	function add_var(){
		$.getJSON('adm_prod.php<?=$this->url->gvar("add=1")?>', {"add" : 1}, add_row);
	}

	function remove_var(id){
		if(confirm('Удалить вариант приобретения?'))
			$.getJSON('adm_prod.php<?=$this->url->gvar("time=")?>', {"del" : id}, remove_row);
	}
</script>
	<tr>
		<td class="edith" valign=top>Варианты приобретения</td>
		<td class="edit">
			<a href="" onclick="add_var(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</a><br><br>
			<table class="show" width="100%">
				<tr>
					<th class="show" width="39%">Вариант</th>
					<th class="show" width="39%">Цена</th>
					<th class="show" width="2%"></th>
				</tr>
			</table>
			<div id="vars">		
<?	$Prodvar = new Model_Prodvar();
	$prodvars = $Prodvar->getall(array("where" => "prod = '".data_base::nq($_GET[id])."'"));
	foreach($prodvars as $k => $r){?>
			<table class="show" id="var<?=$r->id?>" width="100%">
				<tr>
					<td class="show" width="39%"><input type='text' id="title" name='var_<?=$r->id?>_title' style="width: 100%" value="<?=$r->name?>"></td>
					<td class="show" width="39%"><input type='text' id="price" name='var_<?=$r->id?>_price' style="width: 100%" value="<?=$r->price?>"></td>
					<td class="show" width="2%" id="dela"><a href="" onclick="remove_var(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
				</tr>
			</table>
	<?}?>
			</div>
<?	}?>

<?	if($opt["prod_childs"]){?>
<div id="hiddenchild" style="visibility: hidden;">
	<div id="child0">
	<table width="300" border="0" class="show" id="child0">
		<tr>
			<td style="padding: 10;">
				<div id="child_select0">		
					Введите название товара<br>
					<input type="text" id="gsearch0" size="100" name="q" value=""/><br/><br/>
				</div>
				<img id="child_img0" src="" width="1" style="float: left; margin: 0px 10px 10px 0px;">
				<div id="child_title0"></div>
			</td>
			<td class="show" width="16" id="dela"><a href="" onclick="remove_child(0); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
		</tr>
	</table>
	</div>
</div>

<script type="text/javascript">
	function add_childrow(data){
		table = $("#hiddenchild table:first");
		newchild = table.clone();
		newchild.attr({"id": "child"+data});
		newchild.find("#gsearch0").attr({"id": "gsearch"+data});
		newchild.find("#child_select0").attr({"id": "child_select"+data});
		newchild.find("#child_img0").attr({"id": "child_img"+data});
		newchild.find("#child_title0").attr({"id": "child_title"+data});
		newchild.find("#child_price0").attr({"id": "child_price"+data});
		newchild.find("#dela").html('<a href="" id="a" onclick="remove_child('+data+'); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');
		newchildscript = "";

		newchildscript += "$().ready(function() {\n";
		newchildscript += "		$('#gsearch"+data+"').autocomplete('/hint/prod', {\n";
		newchildscript += "			width: 260,\n";
		newchildscript += "			selectFirst: false\n";
		newchildscript += "		});\n";
	
		newchildscript += "		$('#gsearch"+data+"').result(function(event, data, formatted) {\n";
		newchildscript += "			$('#child_img"+data+"').attr({'src': '/pic/prod'+data[1]+'.jpg', 'width': '100'});\n";
		newchildscript += "			$('#child_title"+data+"').html('<b>'+data[0]+'</b>');\n";
		newchildscript += "			$.get('adm_prod.php"+"<?=$this->url->gvar("time=")?>"+"', {'edit_child': 1, 'relid': "+data+", 'child': data[1]}, function(data){\n";
		newchildscript += "				$('#gsearch"+data+"').attr('disabled', 'true');\n";
		newchildscript += "				$('#child_select"+data+"').hide();\n";
		newchildscript += "			});\n";
		newchildscript += "		});\n";
		newchildscript += "});\n";

		newchildscript1 = '\n<script type="text\/javascript">\n';
		newchildscript1 += newchildscript;
		newchildscript1 += '<\/script>\n';

		$("#childs").append(newchildscript1);
		$("#childs").prepend(newchild);
		eval(newchildscript);
	}

	function remove_childrow(data){
		$("#child"+data).empty();
	}

	function add_child(){
		$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"add_child" : 1}, add_childrow);
	}

	function remove_child(id){
		if(confirm('Удалить сопутствующий товар?'))
			$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"del_child" : id}, remove_childrow);
	}
</script>
	<tr>
		<td class="edith" valign=top>Сопутствующие товары</td>
		<td class="edit">
			<a href="" onclick="add_child(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</a><br><br>
			<div id="childs">		
<?	$Relation = new Model_Relation();
	$childs = $Relation->getall(array("where" => "type = 'prod-prod' and obj = '".data_base::nq($_GET[id])."'"));
	foreach($childs as $k => $r){
		$Prod = new Model_Prod();
		$child = $Prod->get($r->relation);
?>
				<div id="child">
				<script type="text/javascript">
					$().ready(function() {
						$("#gsearch<?=$r->id?>").autocomplete("/hint/prod", {
							width: 260,
							selectFirst: false
						});
	
						$("#gsearch<?=$r->id?>").result(function(event, data, formatted) {
							$("#child_img<?=$r->id?>").attr({"src": "/pic/prod"+data[1]+".jpg", "width": "100"});
							$("#child_title<?=$r->id?>").html(data[0]);
							$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"edit_child": 1, "relid": <?=$r->id?>, "child": data[1]}, function(data){
								$("#gsearch<?=$r->id?>").attr("disabled", "true");
								$("#child_select<?=$r->id?>").hide();
							});
						});
					});
				</script>

				<table cellspacing="0" cellpadding="0" width="300" border="0" class="show" id="child<?=$r->id?>">
					<tr>
						<td style="padding: 10;">
							<img id="child_img<?=$r->id?>" src="/pic/prod/<?=$child->id?>.jpg" width="100" style="float: left; margin: 0px 10px 10px 0px;">
							<div id="child_title<?=$r->id?>"><b><?=$child->name?></b></div>
							<div id="child_price<?=$r->id?>"><?=Func::fmtmoney($child->price).$this->sett['valuta']?></div>
						</td>
						<td class="show" width="16" id="dela"><a href="" onclick="remove_child(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
					</tr>
				</table>
				</div>
	<?}?>
			</div>
<?	}?>


<?	if($opt["prod_analogs"]){?>
<div id="hiddenanalog" style="visibility: hidden;">
	<div id="analog0">
	<table width="300" border="0" class="show" id="analog0">
		<tr>
			<td style="padding: 10;">
				<div id="analog_select0">		
					Введите название товара<br>
					<input type="text" id="gsearch0" size="100" name="q" value=""/><br/><br/>
				</div>
				<img id="analog_img0" src="" width="1" style="float: left; margin: 0px 10px 10px 0px;">
				<div id="analog_title0"></div>
			</td>
			<td class="show" width="16" id="dela"><a href="" onclick="remove_analog(0); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
		</tr>
	</table>
	</div>
</div>

<script type="text/javascript">
	function add_analogrow(data){
		table = $("#hiddenanalog table:first");
		newanalog = table.clone();
		newanalog.attr({"id": "analog"+data});
		newanalog.find("#gsearch0").attr({"id": "gsearch"+data});
		newanalog.find("#analog_select0").attr({"id": "analog_select"+data});
		newanalog.find("#analog_img0").attr({"id": "analog_img"+data});
		newanalog.find("#analog_title0").attr({"id": "analog_title"+data});
		newanalog.find("#analog_price0").attr({"id": "analog_price"+data});
		newanalog.find("#dela").html('<a href="" id="a" onclick="remove_analog('+data+'); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');
		newanalogscript = "";

		newanalogscript += "$().ready(function() {\n";
		newanalogscript += "		$('#gsearch"+data+"').autocomplete('/hint/prod', {\n";
		newanalogscript += "			width: 260,\n";
		newanalogscript += "			selectFirst: false\n";
		newanalogscript += "		});\n";
	
		newanalogscript += "		$('#gsearch"+data+"').result(function(event, data, formatted) {\n";
		newanalogscript += "			$('#analog_img"+data+"').attr({'src': '/pic/prod'+data[1]+'.jpg', 'width': '100'});\n";
		newanalogscript += "			$('#analog_title"+data+"').html('<b>'+data[0]+'</b>');\n";
		newanalogscript += "			$.get('adm_prod.php"+"<?=$this->url->gvar("time=")?>"+"', {'edit_analog': 1, 'relid': "+data+", 'analog': data[1]}, function(data){\n";
		newanalogscript += "				$('#gsearch"+data+"').attr('disabled', 'true');\n";
		newanalogscript += "				$('#analog_select"+data+"').hide();\n";
		newanalogscript += "			});\n";
		newanalogscript += "		});\n";
		newanalogscript += "});\n";

		newanalogscript1 = '\n<script type="text\/javascript">\n';
		newanalogscript1 += newanalogscript;
		newanalogscript1 += '<\/script>\n';

		$("#analogs").append(newanalogscript1);
		$("#analogs").prepend(newanalog);
		eval(newanalogscript);
	}

	function remove_analogrow(data){
		$("#analog"+data).empty();
	}

	function add_analog(){
		$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"add_analog" : 1}, add_analogrow);
	}

	function remove_analog(id){
		if(confirm('Удалить пожожий товар?'))
			$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"del_analog" : id}, remove_analogrow);
	}
</script>
	<tr>
		<td class="edith" valign=top>Похожие товары</td>
		<td class="edit">
			<a href="" onclick="add_analog(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</a><br><br>
			<div id="analogs">		
<?	$Relation = new Model_Relation();
	$analogs = $Relation->getall(array("where" => "type = 'prod-prod-analog' and obj = '".data_base::nq($_GET[id])."'"));
	foreach($analogs as $k => $r){
		$Prod = new Model_Prod();
		$analog = $Prod->get($r->relation);
?>
				<div id="analog">
				<script type="text/javascript">
					$().ready(function() {
						$("#gsearch<?=$r->id?>").autocomplete("/hint/prod", {
							width: 260,
							selectFirst: false
						});
	
						$("#gsearch<?=$r->id?>").result(function(event, data, formatted) {
							$("#analog_img<?=$r->id?>").attr({"src": "/pic/prod"+data[1]+".jpg", "width": "100"});
							$("#analog_title<?=$r->id?>").html(data[0]);
							$.get('adm_prod.php<?=$this->url->gvar("time=")?>', {"edit_analog": 1, "relid": <?=$r->id?>, "analog": data[1]}, function(data){
								$("#gsearch<?=$r->id?>").attr("disabled", "true");
								$("#analog_select<?=$r->id?>").hide();
							});
						});
					});
				</script>

				<table cellspacing="0" cellpadding="0" width="300" border="0" class="show" id="analog<?=$r->id?>">
					<tr>
						<td style="padding: 10;">
							<img id="analog_img<?=$r->id?>" src="/pic/prod/<?=$analog->id?>.jpg" width="100" style="float: left; margin: 0px 10px 10px 0px;">
							<div id="analog_title<?=$r->id?>"><b><?=$analog->name?></b></div>
							<div id="analog_price<?=$r->id?>"><?=Func::fmtmoney($analog->price).$this->sett['valuta']?></div>
						</td>
						<td class="show" width="16" id="dela"><a href="" onclick="remove_analog(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
					</tr>
				</table>
				</div>
	<?}?>
			</div>
<?	}?>

<?	if($opt["prod_chars"]){?>
	<tr>
		<td class="edith" valign="top">Спецификация</td>
		<td class="edit">
			<table class="show">
			<tr>
				<th class="show" width="1%">Характеристика</th>
				<th class="show" width="*">Значение</th>
			</tr>
<?
		$pc = array();

		if($this->id){
			$Prodchar = new Model_Prodchar();
			$qr = $Prodchar->getall(array("where" => "prod = '".$this->id."'"));
			foreach($qr as $k => $r){
				$pc[$r->char][charval] = $r->charval;
				$pc[$r->char][value] = $r->value;
			}
		}

		if($opt['char_cats']){
			$Charcat = new Model_Charcat();
			$charcats = $Charcat->getall(array("where" => Model_Cat::cat_tree($_GET['cat'])));
			foreach($charcats as $k => $rcc){?>
			<tr>
				<td colspan="2" class="show"><b><?=$rcc->name?></b></td>
			</tr>
<?				$Char = new Model_Char();
				$chars = $Char->getall(array("where" => "charcat = '".$rcc->id."'"));

	    		foreach($chars as $k => $r) {?>
			<tr>
				<td class="show"><nobr><?=$r->name?></nobr></td>
				<td class="show">
<?					if($r->type == 4){?>
					<select name="charval_<?=$r->id?>">
<?						$Charval = new Model_Charval();
						$qrv = $Charval->getall(array("where" => "`char` = '".$r->id."'"));
						foreach($qrv as $k => $rv) {?>
						<option value="<?=$rv->id?>"<?if ($pc[$r->id][charval] == $rv->id) echo ' selected = "1"'?>><?=$rv->value?></option>
<?						}?>
					</select> <?=$r->izm?>
<?					}elseif($r->type == 2 || $r->type == 3){?>
					<input type="text" name="charval2_<?=$r->id?>" size="<?=($r->type == 2) ? "20": "90"?>" value="<?=$pc[$r->id][value]?>"> <?=$r->izm?>
<?					}elseif($r->type == 1){?>
					<select name="charval2_<?=$r->id?>">
						<option value="0" <?if ($pc[$r->id][value] == 0) echo 'selected = "1"'?>>Нет</option>
						<option value="1" <?if ($pc[$r->id][value] == 1) echo 'selected = "1"'?>>Да</option>
					<select>
<?					}?>
				</td>
			</tr>
<?				}
			}
	?>
<?		}else{
			$Char = new Model_Char();
			$chars = $Char->getall(array("where" => Model_Cat::cat_tree($_GET['cat'])));
			foreach($chars as $k => $r) {?>
			<tr>
				<td class="show"><nobr><?=$r->name?></nobr></td>
				<td class="show">
<?				if($r->type == 4){?>
					<select name="charval_<?=$r->id?>">
<?					$Charval = new Model_Charval();
					$qrv = $Charval->getall(array("where" => "`char` = '".$r->id."'"));
					foreach($qrv as $k => $rv) {?>
						<option value="<?=$rv->id?>"<?if ($pc[$r->id][charval] == $rv->id) echo ' selected = "1"'?>><?=$rv->value?></option>
<?					}?>
					</select> <?=$r->izm?>
<?				}elseif($r->type == 2 || $r->type == 3){?>
					<input type="text" name="charval2_<?=$r->id?>" size="<?=($r->type == 2) ? "20": "90"?>" value="<?=$pc[$r->id][value]?>"> <?=$r->izm?>
<?				}elseif($r->type == 1){?>
					<select name="charval2_<?=$r->id?>">
						<option value="0" <?if ($pc[$r->id][value] == 0) echo 'selected = "1"'?>>Нет</option>
						<option value="1" <?if ($pc[$r->id][value] == 1) echo 'selected = "1"'?>>Да</option>
					<select>
<?				}?>
				</td>
			</tr>
<?			}?>
<?		}?>
			</table>
		</td>
	</tr>
<?	}?>