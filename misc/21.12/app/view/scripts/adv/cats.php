<table cellspacing="5" cellpadding="0" border="0" width="100%">
<?	$i = 0;
	foreach($this->cats as $k => $r){
		if($i++ % 2 == 0) echo "<tr>";?>
		<td width="50%" style="white-space: nowrap; padding: 0 25 0 0;"><a href="/adv/cat-<?=$r->id?>_<?=$r->intname?>" class="cat"><?=$r->name?></a></td>
<?	}?>
</table>