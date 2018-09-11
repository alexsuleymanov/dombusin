<?
	$Prod = new Model_Prod();
	$prod = $Prod->get($_GET['id']);
	$Globalcat = new Model_Globalcat();
	$globalcat = $Globalcat->get($cat->globalcat);
?>
	<script type="text/javascript">
		$().ready(function() {
			$("#gsearch").autocomplete("/hint/globalcat", {
				width: 260,
				selectFirst: false
			});

			$("#gsearch").result(function(event, data, formatted) {
				$("#globalcat").val(data[1]);
			});
		});
	</script>

	<table cellspacing="0" cellpadding="0" width="100%" border="0">
		<tr>
			<td>
				<input type="hidden" id="globalcat" name="globalcat" value="<?=($globalcat->id) ? $globalcat->id : 0?>">
				<input type="text" id="gsearch" size="100" name="q" value="<?=($globalcat->name) ? $globalcat->name : ''?>"/>
			</td>
			<td>
				<img src="" width="100">
				<div id="child_<??>_title"></div>
				<div id="child_<??>_price"></div>
			</td>
	</table>