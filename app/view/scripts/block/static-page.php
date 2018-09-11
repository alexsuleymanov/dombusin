<?	echo $this->page->cont;
	if ($this->page->autosub) {?>
<ul class="subpages">
<?	
		foreach($this->subpages as $k => $subpage){
			$href = "/".$subpage->intname;?>
	<li><a href="<?=$href?>"><?=$subpage->name?></a></li>
<?		}?>
</ul>
<?	}
