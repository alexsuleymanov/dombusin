<script type="text/javascript">
	$(document).ready(
		function(){
			$.ImageBox.init({
				loaderSRC: '<?=$this->path?>/img/imagebox/loading.gif',
				closeHTML: '<img src="<?=$this->path?>/img/imagebox/close.jpg" />'
			});
		}
	);
</script>
<table>
<?	$i = 0;
	foreach($this->photos as $k => $v){
		if($i++ % 4 == 0) echo "<tr>";?>
		<td><a href="/pic/photo/<?=$v->id?>.jpg" target="_blank" rel="imagebox-org"><img src="/thumb?src=pic/photo/<?=$v->id?>.jpg&width=100&height=100" alt="<?=$v->name?>" /></td>
<?	}?>
</table>
