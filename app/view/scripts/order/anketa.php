<?
	$_GET["redirect"] = "/order/confirm";
	echo $this->page->cont;
?>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>

<div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1"><?=$this->labels["if_you_not_registered"]?></a></li>
			<li><a href="#tabs-2"><?=$this->labels["if_you_registered"]?></a></li>
		</ul>
    
		<div id="tabs-1">
			<?echo $this->registerform->render($this);?>
		</div>
		<div id="tabs-2">
			<?echo $this->loginform->render($this);?>
		</div>
	</div>
</div>

<div style="clear: both;">&nbsp;</div>

<div>
<?	echo $this->render("cart/show.php");?>
</div>


<div style="clear: both;"></div>
