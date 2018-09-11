<?
	foreach($this->results as $k => $v){?>
	<div rel="<?=$v->id?>" onmouseover="$(this).css('background-color', '#f0f0f0')" onmouseout="$(this).css('background-color', '#f0f0f0')" onclick="$('#cat_id').val($(this).attr('id'));"><?=$v->name?></div>
<?	}?>