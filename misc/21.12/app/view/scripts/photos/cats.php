<table>
<?	$i = 0;
	foreach($this->subpages as $k => $v){
		if($i++ % 4 == 0) echo "<tr>";?>
		<td class="photocat" align="center"><a href="<?="/".$v->intname?>" target="_blank"><img src="/thumb?src=pic/page/<?=$v->id?>.jpg&width=100&height=100" alt="<?=$v->name?>" /><br><?=$v->name?></td>
<?	}?>
</table>
