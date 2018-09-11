<script type="text/javascript">
	function all_chars(){
		$("#all_chars").hide();
		$(".char_row").show();
	}
</script>
<table width="250">
	<tr>
		<td colspan="2"><!--<h2><?=$this->labels["technical_chars"]?></h2>-->
			<table cellspacing="0" cellpadding="2" width="100%" border="0">
<?		foreach($this->chars as $k => $cv){
			if($this->prod_chars[$cv->id]->val == 0 || $this->prod_chars[$cv->id]->value == '') continue;
?>
				<tr class="char_row" <?if($j++ > 4) echo "style=\"display: none;\""?>>
					<td valign="bottom"><?=$cv->name?><hr class="gray"></td>
					<td valign="bottom">
<?					if($cv->type == 4){
						echo $this->prod_chars[$cv->id]->value." ".$this->prod_chars[$cv->id]->izm;
					}elseif($cv->type == 2){
						echo $this->prod_chars[$cv->id]->text." ".$this->prod_chars[$cv->id]->izm;
					}elseif($cv->type == 1){
						echo ($this->prod_chars[$cv->id]->text) ? $this->labels["yes"]: $this->labels["no"];
					}?>
						<hr class="gray">
					</td>
				</tr>
<?		}?>
			<?if($j > 4){?>
				<tr>
					<td colspan="2" align="center"><input type="button" value="Показать все" onclick="all_chars();" id="all_chars"/></td>
				</tr>
			<?}?>
			</table>
		</td>
	</tr>
</table>
