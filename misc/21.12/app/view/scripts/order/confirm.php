
<div style="padding: 20px;">
	<h1>Оформление заказа</h1>
    <?	echo $this->page->cont;?>

    <div>
    	<?echo $this->form->render($this);?>
    </div>
<?/*
    <div style="clear: both;"></div>
    <div class="ce6"><input type="image" src="<?= $this->path ?>/img/o.png" class="but" value="<?= $this->labels["make_order"] ?>" onclick="$('#asform_orderform').submit(); return false;"></div>
    <div style="clear: both;"></div>
*/?>

    <div style="padding-top: 40px;">
    	<?=$this->render("cart/show.php");?>
    </div>
	<?/*
    <div style="clear: both;"></div>
    <div class="ce6" style="float: right; padding-right: 50px;"><input type="image" src="<?= $this->path ?>/img/o.png" class="but" value="<?= $this->labels["make_order"] ?>" onclick="$('#asform_orderform').submit(); return false;"></div>
    <div style="clear: both;"></div>*/?>
</div>