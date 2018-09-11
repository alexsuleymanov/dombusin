<script type="text/javascript">
function rulechange(value) {
	href = '<?="/".$this->url->page.$this->url->gvar("start=1")?>';
	start = <?=$this->results?> * (value - 1);
	href = href.replace("start=1","start="+start);
	location.href = href;
}
</script>

<span style="float: right;">&nbsp;
	<form action="/">
		<?if($this->start>0){?>
		<?$newp = $this->start - $this->results;?>
		<a href="<?="/".$this->url->page.$this->url->gvar("start=".$newp)?>">&nbsp;&lt;&lt;</a>
		<?}?>
		Страница
		<select name="page" class="page" onchange="rulechange(value);">
			<?
			if($this->cnt%$this->results==0)
				$count = floor($this->cnt/$this->results);
			else
				$count = floor($this->cnt/$this->results+1);
			for($i=1;$i<$count+1;$i++){?>
			<option value="<?=$i?>"<?if($this->start/$this->results==$i-1){?> selected="selected"<?}?>><?=$i?></option>
			<?}?>
		</select> из <?=$count?>
	</form>&nbsp;
	<?if ($this->start < $this->cnt - $this->results) {?>
	<?$newp = $this->start + $this->results;?>
	<a href="<?="/".$this->url->page.$this->url->gvar("start=".$newp)?>">&nbsp;&gt;&gt;</a>
	<?}?>
</span>
Отображено с <b><?=$this->start+1?></b> по <b><?=($this->start+$this->results>$this->cnt)?$this->cnt:$this->start+$this->results?></b> (из <b><?=$this->cnt?></b> товаров)
