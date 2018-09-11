<div id="actionsheader"><?=$this->labels['actions']?></div>
<?
	$Actions = new Model_Page('actions');
	$cond = array(
		"order" => "tstamp desc",
		"limit" => 10,
	);

	$actions = $Actions->getall($cond);

	foreach($actions as $k => $v) {?>
<div class="actionswrap">
<?		if(file_exists("pic/actions/".$v->id.".jpg")){?>
	<a href="/actions/<?=$v->intname?>"><img src="/pic/actiontitle/<?=$v->id?>.jpg" alt="<?=$v->name?>" /></a>
<?		}else{?>
	<div class="actionshead"><a href="/actions/<?=$v->intname?>"><?=$v->name?></a></div>
<?		if(file_exists("pic/actions/".$v->id.".jpg")){?>
	<div class="actionsimg"><img src="/pic/actions/<?=$v->id?>.jpg" alt="<?=$v->name?>"></div>
<?		}?>
	<div class="actionscont"><a href="/actions/<?=$v->intname?>"><?=substr(strip_tags($v->cont), 0, 200)."...";?></a></div>
	<div class="strhead"><a href="/actions/<?=$v->intname?>"><?=$this->labels['continue']?></a></div>
</div>
<?		}?>
<?	}?>

