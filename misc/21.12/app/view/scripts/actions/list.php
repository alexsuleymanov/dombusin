<? foreach($this->actions as $k => $v){?>
	<div style="float: left; width: 125px; height: 130px; padding: 15px;">
		<a href="<?=$this->url->mk('/catalog/action/action-'.$v->id.'-'.$v->intname)?>" data-id="<?= $v->id ?>" class="sl-item"><img src="/thumb?src=pic/actions/<?=$v->id?>.jpg&amp;width=120" alt="<?= $v->name ?>"><br><?= $v->name ?></a>
	</div>
<? }?>
<div class="clear"></div>
