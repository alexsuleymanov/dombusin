<script>
	function is_empty(id){
		return true;
	}

	$(document).ready(function(){
		$("#checkall").click(function(){
			$(".inpcheck").attr("checked", $("#checkall").attr("checked"));
		});
	});

	function setajax(id, field, value){
		$.get("<?=$_SERVER['SCRIPT_NAME']?>?action=setajax", {'id' : id, 'field': field, 'fieldvalue': value}, function(){
			location.reload();	
		});
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
		<td class="show">&nbsp;</td>
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
		<td class="show" colspan="<?=$this->can_edit + $this->can_del + 0?>"><input type="image" src="<?=$this->path?>/img/search.jpg"></td>
<?		}?>
		<td>&nbsp;<input type="checkbox" id="checkall"/> Все</td>
</form>
	</tr>
	<tr>
<form action="?action=mass_del" method="post" id="massform">
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
		<th class="show"><input type="submit" id="massformsubmit" name="submit" value="Удалить" /></th>
<?		}?>
	</tr>
<?		foreach($this->rows as $kk => $row) {?>
	<tr onmouseover="this.bgColor='#f2ffe3'" onmouseout="this.bgColor='#ffffff'">
		<td class="show"><?=$kk+1?></td>
<?			foreach($this->fields as $k => $v) {
				if($v['show'] != 1) continue;
?>
		<td class="show" align="center">
<?
				$ftype = ($v['ftype']) ? $v['ftype'] : 'jpg';
				if($v['type'] == 'checkbox'){?>
			<div style="cursor: pointer;" onclick="setajax(<?=$row->id?>, '<?=$k?>', <?=($row->$k) ? 0 : 1;?>)">
<?					echo ($row->$k) ? "<center><img src=\"".$this->path."/img/ok.png\"></center>" : "<center><img src=\"".$this->path."/img/b_del.png\"></center>";?>
			</div>
				<?/*	echo ($row->$k) ? "<center><img src=\"".$this->path."/img/ok.png\"></center>" : "<center><img src=\"".$this->path."/img/b_del.png\"></center>"; */?>
<?				}elseif($v['type'] == 'image'){
					echo "<img src=\"/thumb?width=120&src=".str_replace("../", "", $v["location"])."/".$row->id.".".$ftype."\">";
				}elseif($v['type'] == 'date'){
					echo date("d.m.Y h:i A", $row->$k);
				}elseif($v['type'] == 'select'){
					echo (preg_match("/^\d+$/", $row->$k)) ? $v['items'][$row->$k] : $row->$k;
				}else{?>
<?					if($row->$k == $this->originalrows[$kk]->$k){?>

			<div style="cursor: pointer;" id="text<?=$k?>_<?=$kk?>">
<?					echo $row->$k;?>
			</div>
			<?	if($v['edit']){?>
			<script>
				function onchangetext<?=$k?>_<?=$kk?>(a){
	                setajax(<?=$row->id?>, '<?=$k?>', $(a).val());
				}

				$("#text<?=$k?>_<?=$kk?>").bind('click', function(){
					$(this).html("<input type='text' id='<?=$k?><?=$kk?>' name='<?=$k?>' value='<?=data_base::nq($this->originalrows[$kk]->$k)?>' onchange='onchangetext<?=$k?>_<?=$kk?>(this)'>");
					$(this).unbind('click');
					document.getElementById("<?=$k?><?=$kk?>").focus();
				});
			</script>
			<?	}?>
<?					}else{
	                    echo $row->$k;
					}?>
<?//			echo $row->$k;?>
<?				}?>
		</td>
<?			}
			if ($this->can_edit) {?>
		<td class="show"><a href="<?=$this->url->gvar("action=edit&id=".$row->id)?>" title="Редактировать"><img src="<?=$this->path?>/img/b_edit.png"></a></td>
<?			}
			if ($this->can_del) { ?>
		<td class="show"><a href="<?=$this->url->gvar("action=del&id=".$row->id)?>" onclick="return confirm('Удалить?')" title="Удалить"><img src="<?=$this->path?>/img/b_del.png"></a></td>
		<td class="show"><input type="checkbox" class="inpcheck" id="del_<?=$row->id?>" name="del[]" value="<?=$row->id?>" title="Отметить" /></td>
<?			}?>
	</tr>
<?		}?>
</form>
</table>