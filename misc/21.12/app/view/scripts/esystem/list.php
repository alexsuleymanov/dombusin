	<table cellspacing="15" border="0" width="100%">
		<tr>
<?		foreach($this->esystems as $k => $v){?>
			<td>
				<h3><?=$v->name?></h3>
				<br /><?=$v->cont?>
			</td>
		</tr>
<?
		}?>
	</table>