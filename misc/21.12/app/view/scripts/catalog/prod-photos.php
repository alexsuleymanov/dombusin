<script type="text/javascript">
	$(document).ready(
		function(){
			$("a[rel=prod_photos]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Фото ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
		}
	);
</script>
<div class="prodimages">
<table cellpadding="0" cellspacing="8">
<?	$i = 0;
	foreach($this->photos as $k => $v){
		if($i++ % 4 == 0) echo "<tr>";?>
		<td><a href="/pic/photo/<?=$v->id?>.jpg" target="_blank" rel="prod_photos"><img src="/thumb?src=pic/photo/<?=$v->id?>.jpg&width=65" alt="<?=$v->name?>" class="prodimage" /></td>
<?	}?>
</table>
</div>
