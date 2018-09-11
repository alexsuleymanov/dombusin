<table cellspacing="20" cellpadding="0" border="0" width="100%">
<?	$i = 0;
	foreach($this->brands as $k => $r){
		if($i++ % 5 == 0) echo "<tr>";?>
		<td width="100" align="center" style="white-space: nowrap; padding: 0 25 0 0;"><a href="/brands/<?=$r->intname?>" class="cat"><img src="/thumb?src=pic/brand/<?=$r->id?>.jpg&width=100&height=100" width="100" height="100" alt="<?=$r->name?>" /><br><?=$r->name?></a></td>
<?	}?>
</table>