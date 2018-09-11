<script>
	function is_empty(id){
		return true;
	}
</script>
<?=$this->showhead?>
<?		if ($this->can_add) { ?>
<a href="<?=$this->url->gvar("action=edit")?>"><img src="<?=$this->path?>/img/add.jpg" align="absmiddle"> Добавить</a>
<br><br>
<?		}?>
<table class="show">
	<tr>
<form action="" method="post">
		<input type="hidden" name="filter" value="1">
		<td class="show">Фильтр</td>
<?	foreach($this->fields as $k => $v) {
		if($v['show'] != 1) continue;?>
		<td class="show">
<?		if($v['filter']){?>
			<input type="text" name="filter_<?=$k?>" value="<?=$_POST['filter_'.$k]?>" style="width:100%;" class="inp">
<?		}else{?>
			&nbsp;
<?		}?>
		</td>
<?	}?>
<?		if ($this->can_edit + $this->can_del > 0) {?>
		<td class="show" colspan="<?=$this->can_edit + $this->can_del?>"><input type="image" src="<?=$this->path?>/img/search.jpg"></td>
<?		}?>
</form>
	</tr>
	<tr>
		<td class="show"></td>
<?		foreach($this->fields as $k => $v) {
			if($v['show'] != 1) continue;
			$desc_asc = ($this->desc_asc == 'asc') ? 'desc': 'asc';
?>
		<th class="show" <?if($v['sort'] == 1){ echo "title=\"Отсортировать\" style=\"cursor: hand;\" onclick=\"location.href='".$this->url->gvar("order=".$k."&desc_asc=".$desc_asc)."'\"";}?>>
			<?=$v['label']?>
<?			if($v['sort'] == 1){
				if($this->order == $k){?>
			<img src="<?=$this->path?>/img/arrow_<?=($this->desc_asc == 'desc') ? "down" : "up";?>.gif" align="absmiddle">
<?				}?>
<?			}?>
		</th>
<?		}?>
<?		if ($this->can_edit + $this->can_del > 0) {?>
		<th class="show" colspan="<?=$this->can_edit + $this->can_del?>">&nbsp;</th>
<?		}?>
	</tr>
<?		foreach($this->rows as $kk => $row) {?>
	<tr onmouseover="this.bgColor='#f2ffe3'" onmouseout="this.bgColor='#ffffff'">
		<td class="show"><?=$kk?></td>
<?			foreach($this->fields as $k => $v) {
				if($v['show'] != 1) continue;
?>
		<td class="show">
<?
				if($v['type'] == 'checkbox'){
					echo ($row->$k) ? "<center><img src=\"".$this->path."/img/ok.png\"></center>" : ""; 
				}elseif($v['type'] == 'image'){
					echo "<img src=\"/thumb?width=120&src=admin/".$v["location"]."/".$row->id.".jpg\">";
				}elseif($v['type'] == 'date'){
					echo date("d.m.Y", $row->$k);
				}else{
					echo $row->$k;
				}?>
		</td>
<?			}
			if ($this->can_edit) {?>
		<td class="show"><a href="<?=$this->url->gvar("action=edit&id=".$row->id)?>" title="Редактировать"><img src="<?=$this->path?>/img/b_edit.png"></a></td>
<?			}
			if ($this->can_del) { ?>
		<td class="show"><a href="<?=$this->url->gvar("action=del&id=".$row->id)?>" onclick="return confirm('Удалить?')" title="Удалить"><img src="<?=$this->path?>/img/b_del.png"></a></td>
<?			}?>
	</tr>
<?		}?>
</table>
