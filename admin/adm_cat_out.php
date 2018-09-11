	<tr>
		<td class="edith" valign="top">Спецификация</td>
		<td class="edit">
			<table class="show">
				<tr>
					<th class="show" width="100">Характеристика</th>
					<th class="show" width="50">Значение</th>
					<th class="show" width="*">Приоритет</th>
				</tr>
<?
		$pc = array();

		if($this->id){
			$Catchar = new Model_Catchar();
			$qr = $Catchar->getall(array("where" => "cat = '".$this->id."'", "order" => "prior desc"));
			foreach($qr as $k => $r){
				$pc[$r->char]['cat'] = $r->cat;
				$pc[$r->char]['char'] = $r->char;
				$pc[$r->char]['prior'] = $r->prior;
			}
		}

		$Char = new Model_Char();
		$chars = $Char->getall(array("where" => "cat = 0"));
		foreach($chars as $k => $r) {?>
				<tr>
					<td class="show"><nobr><?=$r->name?></nobr></td>
					<td class="show"><input type="checkbox" name="char_<?=$r->id?>" value="<?=$r->id?>" <?if($pc[$r->id]['char']) echo "checked=\"1\"";?>/></td>
					<td class="show"><input type="text" name="prior_<?=$r->id?>" value="<?=0+$pc[$r->id]['prior']?>" /></td>
				</tr>
<?		}?>
			</table>
		</td>
	</tr>