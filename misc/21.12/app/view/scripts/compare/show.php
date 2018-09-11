<?	if(isset($this->charcats)){?>
<table cellspacing="0" cellpadding="2" width="100%" border="0">
	<tr>
		<td width="100">&nbsp;</td>
<?		foreach($this->prods as $k => $prod){?>
		<td>
			<img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&width=120" alt=""><br />
			<a href="/compare/del/<?=$prod->cat?>/<?=$prod->id?>"><?=$this->labels["remove_from_compare"]?></a>

		</td>
<?		}?>
	</tr>
<?		foreach($this->charcats as $ccid => $ccv){?>
	<tr valign="top">
		<td colspan="<?=count($this->prods)+1?>" class="charcat"><strong class="char_cat"><?=$ccv->name?></strong></td>
	</tr>
<?			foreach($this->chars as $k => $cv){
				if($cv->charcat != $ccv->id) continue;?>
	<tr>
		<td valign="bottom" class="charname"><?=$cv->name?></td>
<?		foreach($this->prods as $k => $prod){?>
		<td valign="bottom" class="charvalue">
<?					if($cv->type == 4){
						echo $this->prod_chars[$prod->id][$cv->id]->value." ".$this->prod_chars[$prod->id][$cv->id]->izm;
					}elseif($cv->type == 2){    
						echo $this->prod_chars[$prod->id][$cv->id]->text." ".$this->prod_chars[$prod->id][$cv->id]->izm;
					}elseif($cv->type == 1){
						echo ($this->prod_chars[$prod->id][$cv->id]->text) ? $this->labels["yes"]: $this->labels["no"];
					}?>
		</td>
<?		}?>
	</tr>
<?			}?>
<?		}?>
</table>
<?	}elseif(isset($this->chars)){?>
<table cellspacing="0" cellpadding="2" width="100%" border="0">
	<tr>
		<td width="100">&nbsp;</td>
<?		foreach($this->prods as $k => $prod){?>
		<td><img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&width=120" alt=""></td>
<?		}?>
	</tr>
<?		foreach($this->chars as $k => $cv){?>
	<tr>
		<td valign="bottom" class="charname"><?=$cv->name?></td>
<?			foreach($this->prods as $k => $prod){?>
		<td valign="bottom" class="charvalue">
<?					if($cv->type == 4){
						echo $this->prod_chars[$prod->id][$cv->id]->value." ".$this->prod_chars[$prod->id][$cv->id]->izm;
					}elseif($cv->type == 2){    
						echo $this->prod_chars[$prod->id][$cv->id]->text." ".$this->prod_chars[$prod->id][$cv->id]->izm;
					}elseif($cv->type == 1){
						echo ($this->prod_chars[$prod->id][$cv->id]->text) ? $this->labels["yes"]: $this->labels["no"];
					}?>
		</td>
<?			}?>
	</tr>
<?		}?>
</table>
<?	}?>