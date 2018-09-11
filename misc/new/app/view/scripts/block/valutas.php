	<select name="valuta" id="currency" class="val" onchange="location.href='?valuta='+$(this).val()">
<?	foreach($this->valutas as $k => $v){?>
		<option value="<?=$v['id']?>" <?if($v['id'] == $_SESSION['valuta']['id']) echo "selected=\"1\";"?>><?=$v['short']?></option>
<?	}?>
	</select>