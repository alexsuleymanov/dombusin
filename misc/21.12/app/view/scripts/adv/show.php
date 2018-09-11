<h2><?=$this->adv->subj?></h2>
<table cellspacing="0">
	<tr>
		<td width="170" valign="top">
	        <a href="/pic/adv1/<?=$this->adv->id?>.jpg" target="_blank"><img src="/pic/adv1/<?=$this->adv->id?>.jpg&w=150" width="150" class="advimg" alt="<?=$this->adv->subj?>" /></a><br />
<?		if(file_exists("pic/adv2/".$this->adv->id.".jpg")){?>
	        <a href="/pic/adv2/<?=$this->adv->id?>.jpg" target="_blank"><img src="/pic/adv2/<?=$this->adv->id?>.jpg&w=150" width="150" class="advimg" alt="<?=$this->adv->subj?>" /></a><br />
<?		}?>
<?		if(file_exists("pic/adv3/".$this->adv->id.".jpg")){?>
	        <a href="/pic/adv3/<?=$this->adv->id?>.jpg" target="_blank"><img src="/pic/adv3/<?=$this->adv->id?>.jpg&w=150" width="150" class="advimg" alt="<?=$this->adv->subj?>" /></a><br />
<?		}?>
<?		if(file_exists("pic/adv4/".$this->adv->id.".jpg")){?>
	        <a href="/pic/adv4/<?=$this->adv->id?>.jpg" target="_blank"><img src="/pic/adv4/<?=$this->adv->id?>.jpg&w=150" width="150" class="advimg" alt="<?=$this->adv->subj?>" /></a><br />
<?		}?>
		</td>
		<td valign="top">
			<table cellspacing="5">
				<tr>
					<td>Дата публикации:</td>
					<td><?=date("d-m-Y", $this->adv->tstamp)?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding: 20 0 0 0;"><strong>Текст объявления</strong><br /><br /><?=$this->adv->cont?></td>
	</tr>
	<tr>
		<td colspan="2" style="padding: 20 0 0 0;"><strong>Контактная информация</strong><br /><br /><?=$this->adv->contacts?></td>
	</tr>
</table>
