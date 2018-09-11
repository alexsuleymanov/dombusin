<?	foreach($this->advs as $k => $item){?>
<table style="border: 1px solid #aaaaaa; width: 100%; margin: 0 5 20 0;">
	<tr>
		<td>
			<table width="100%" cellspacing="0" cellpadding="5">
				<tr bgcolor="#f0f0f0">
					<td><a href="<?=$this->url->mkd(array(2, "adv-".$item->id))?>" class="madvh"><b><?=$item->subj?></b></a></td>
					<td width="100"><?=($item->type == 0) ? "<font color=green>Продам</font>" : "<font color=red>Куплю</font>";?></td>
					<td width="100"><?=$item->city?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td valign="top"><a href="<?=$this->url->mkd(array(2, "adv-".$item->id))?>"><img src="/pic/adv1/<?=$item->id?>.jpg" width="150" alt="<?=$item->subj?>" /></a></td>
					<td valign="top"><span>Цена: <?=Func::fmtmoney($item->price).$this->sett["valuta"]?></span><br /><br />
						<?=substr(strip_tags($item->cont), 0, 300)."..."?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Добавлено: <?=date("d.m.Y", $item->tstamp)?></td>
	</tr>
</table>
<?	}?>