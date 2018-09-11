<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr>
		<td style="padding: 0 0 0 10;" height=20 valign=top>
			<h2 class="voteh">Голосование</h2>
		</td>
	</tr>
	<tr>
		<td style="padding: 0 0 2 10;" valign=top align=left><b><?=$this->vote->name?></b></td>
	</tr>
	<tr>
		<td style="padding: 0 0 0 10;" valign=top>
			<table width="100%">
<?	foreach($this->answers as $k => $v) { 
		$perc = ($this->s == 0) ? 100 : (100*$v->count/$this->s);?>
				<tr><td><?=$v->name?><td nowrap><table align="left" height="15" width='<?=round($perc)?>' bgcolor="#FF0000"><tr><td></tr></table>&nbsp;<?=sprintf("%0.1f", $perc)?>%</tr>
<?  }?>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">Всего голосов: <?=$this->s?></td>
	</tr>
</table>
